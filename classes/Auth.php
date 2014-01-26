<?php

class Auth
{
    const SESSION_KEY               = 'auth';
    const COOKIE_KEY                = 'auth';
    const ALLOW_LOGIN_WITH_EMAIL    = false;
    const COOKIE_LIFE               = 1209600; // 2 weeks
    const DELAY_ON_INVALID_LOGIN    = false;
    
    protected $isLoggedIn    = false;
    protected $record        = false;
    protected $permissions   = array();

    /**
	 *
	 */
	public function __construct($config=array())
	{
		foreach ($config as $key => $value) {
			if (property_exists($this, $key)) {
				if (isset($this->{$key})) {
					$this->{$key} = $value;
				}
			}
		}
	}
    
    /**
     *
     */
    public function load()
    {
        if (isset($_SESSION[self::SESSION_KEY]) && isset($_SESSION[self::SESSION_KEY]['username'])) {
            $user = Flexio::app()->models->findByAttrs('User', array(
            	'username'=>$_SESSION[self::SESSION_KEY]['username'],
        	));
        } else if (isset($_COOKIE[self::COOKIE_KEY])) {
            $user = $this->challengeCookie($_COOKIE[self::COOKIE_KEY]);
        } else {
            return false;
        }

        if (! $user) {
            return $this->logout();
        }

        $this->setInfos($user);
    }
    
    /**
     *
     */
    public function setInfos(Model $user)
    {
        $_SESSION[self::SESSION_KEY] = array('username' => $user->username);
        
        $this->record = $user;
        $this->isLoggedIn = true;
        $this->permissions = $user->getPermissions();
    }
    
    /**
     *
     */
    public function isLoggedIn()
    {
        return $this->isLoggedIn;
    }
    
    /**
     *
     */
    public function getRecord()
    {
        return $this->record ? $this->record: null;
    }
    
    /**
     *
     */
    public function getId()
    {
        return $this->record ? $this->record->id: null;
    }
    
    /**
     *
     */
    public function getUserName()
    {
        return $this->record ? $this->record->username: null;  
    }
    
    /**
     *
     */
    public function getPermissions()
    {
        return $this->permissions;
    }
    
    /**
     * Checks if user has (one of) the required permissions.
     *
     * @param string $permission Can contain a single permission or comma seperated list of permissions.
     * @return boolean
     */
    public function hasPermission($permissions)
    {
        if (empty($permissions)) {
            return true;
        }
                
		if ( !is_array($permissions)) {
			$permissions = explode(',', (string)$permissions);
		}

        foreach ($permissions as $permission) {
            if (in_array(strtolower($permission), $this->permissions)) {
                return true;
        	}
        }
        
        return false;
    }
    
    /**
     *
     */
    public function login($username, $password, $setCookie=false)
    {
        $this->logout();
        
        $user = Flexio::app()->models->findByAttrs('User', array(
        	'username'=>$username,
    	));
        
        if (! $user instanceof User && self::ALLOW_LOGIN_WITH_EMAIL) {
            $user = Flexio::app()->models->findByAttrs('User', array(
            	'email'=>$username,
        	));
        }
        
        if ($user instanceof User && $user->password == sha1($password)) {
            $user->lastLogin = date('Y-m-d H:i:s');
            $user->save();
            
            if ($setCookie) {
                $time = $_SERVER['REQUEST_TIME'] + self::COOKIE_LIFE;
                setcookie(self::COOKIE_KEY, self::bakeUserCookie($time, $user), $time, '/', null, (isset($_ENV['SERVER_PROTOCOL']) && ((strpos($_ENV['SERVER_PROTOCOL'],'https') || strpos($_ENV['SERVER_PROTOCOL'],'HTTPS')))));
            }
            
            $this->setInfos($user);
            
            return true;
        } else {
            if( self::DELAY_ON_INVALID_LOGIN ) {
                if ( ! isset($_SESSION[self::SESSION_KEY.'_invalid_logins'])) {
                    $_SESSION[self::SESSION_KEY.'_invalid_logins'] = 1;
                } else {
                    ++$_SESSION[self::SESSION_KEY.'_invalid_logins'];
                }

                sleep(max(0, min($_SESSION[self::SESSION_KEY.'_invalid_logins'], (ini_get('max_execution_time') - 1))));
            }

            return false;   
        }
    }
    
    /**
     *
     */
    public function logout()
    {
        unset($_SESSION[self::SESSION_KEY]);
        
        $this->eatCookie();
        $this->record = null;
        $this->permissions = array();
    }
    
    /**
     *
     */
    protected function challengeCookie($cookie)
    {
        $params = $this->explodeCookie($cookie);

        if (isset($params['exp'], $params['id'], $params['digest'])) {
        	$user = Flexio::app()->models->findById('User', $params['id']);

            if (! $user) {
                return false;
            }
            
            if ($this->bakeUserCookie($params['exp'], $user) == $cookie && $params['exp'] > $_SERVER['REQUEST_TIME']) {
                return $user;
        	}
        }

        return false;
    }
    
    /**
     *
     */
    protected function explodeCookie($cookie)
    {
        $pieces = explode('&', $cookie);
        
        if (count($pieces) < 2) {
            return array();
        }
        
        foreach ($pieces as $piece) {
            list($key, $value) = explode('=', $piece);
            $params[$key] = $value;
        }

        return $params;
    }
    
    /**
     *
     */
    protected function eatCookie()
    {
        setcookie(self::COOKIE_KEY, false, $_SERVER['REQUEST_TIME']-self::COOKIE_LIFE, '/', null, (isset($_ENV['SERVER_PROTOCOL']) && (strpos($_ENV['SERVER_PROTOCOL'],'https') || strpos($_ENV['SERVER_PROTOCOL'],'HTTPS'))));
    }
    
	/**
	 *
	 */
    protected function bakeUserCookie($time, $user)
    {
        return 'exp='.$time.'&id='.$user->id.'&digest='.md5($user->username.$user->password);
    }
}