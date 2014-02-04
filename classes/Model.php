<?php

/**
 * @class Model
 */
abstract class Model
{
	/**
	 *
	 */
	protected $attrs=array();
	
	/**
	 *
	 */
	protected $errors=array();

	/**
	 *
	 */
	protected $db;

	/**
	 *
	 */
	protected $manager;

	/**
	 *
	 */
	public static function join() { return null; }

	/**
	 *
	 */
	public function __construct($config=array())
	{
		if (isset($config['attrs']) && is_array($config['attrs'])) {
			$this->setAttrs($config['attrs']);
		}

		if (isset($config['db'])) {
			$this->db = $config['db'];
		}

		if (isset($config['manager'])) {
			$this->manager = $config['manager'];
		}
	}

	/**
	 *
	 */
	public function __get($key)
	{
		return $this->getAttr($key);
	}

	/**
	 *
	 */
	public function __set($key, $value)
	{
		$this->setAttr($key, $value);
	}

	/**
	 *
	 */
	public function __isset($key)
	{
		return isset($this->attrs[$key]) || isset($this->data[$key]);
	}

	/**
	 *
	 */
	public static function fields()
	{
		return array();
	}

	/**
	 *
	 */
	public function setAttr($key, $value=null)
	{
		$this->attrs[$key]=$value;
	}

	/**
	 *
	 */
	public function setAttrs(array $attrs)
	{
		$this->attrs = Arr::merge($this->attrs, $attrs);
	}

	/**
	 *
	 */
	public function getAttr($key=null, $defaultValue=null)
	{
		if ($key===null) {
			return $this->attrs;
		}

		if (! empty($this->attrs[$key])) {
			return $this->attrs[$key];
		}

		return $defaultValue;
	}

	/**
	 *
	 */
	public function getAttrs(array $keys=null)
	{
		$attrs = $this->attrs;

		if ($keys !== null) {
			$result = array();

			foreach ($keys as $key) {
				if (isset($attrs[$key])) {
					$result[$key] = $attrs[$key];
				} else {
					$result[$key] = null;
				}
			}

			return $result;
		}

		return $attrs;
	}

	/**
	 *
	 */
	public function isNew()
	{
		return $this->getAttr('id') === null ? true: false;
	}

	/**
	 *
	 */
	public function save($isNeedValidate=true)
	{
		if ($isNeedValidate) {
			$this->validate();

			if (! empty($this->errors)) {
				return false;
			}
		}

		if (! $this->beforeSave()) {
			return false;
		}

        $attrs = $this->getTableAttrs();

        if (empty($attrs)) {
        	return false;
        }

        if ($this->isNew()) {
            if (! $this->beforeInsert()) {
            	return false;
        	}

            $sql = 'INSERT INTO '.$this->getTableName().' ('
                 . implode(', ', array_keys($attrs))
                 . ') VALUES ('
                 . implode(', ', array_fill(0, count($attrs), '?'))
                 . ')';
			
            $stmt = $this->db->prepare($sql);
            $return = $stmt->execute(array_values($attrs)) !== false;

            $this->id = $this->db->lastInsertId();
             
            if (! $this->afterInsert()) {
        		return false;
        	}
		} else {
        	if (! $this->beforeUpdate()) {
        		return false;
        	}

        	unset($attrs['id']);

            $columns = array_keys($attrs);
            
            // Escape and format for SQL update query
            foreach ($columns as $i=>$column) {
                $columns[$i] = $column.'=?';
            }
            
            $sql = 'UPDATE '.$this->getTableName().' SET '
                 . implode(', ', $columns)
                 . ' WHERE id = '.$this->id;
            
            $stmt = $this->db->prepare($sql);
            $return = $stmt->execute(array_values($attrs)) !== false;

            if (! $this->afterUpdate()) {
            	return false;
            }
        }

        if (! $this->afterSave()) {
			return false;
		}

        return $return;
	}

	/**
	 *
	 */
	public function delete()
	{
		if (! $this->beforeDelete()) {
			return false;
		}

        $sql = 'DELETE FROM '.$this->getTableName().' WHERE id='.$this->db->quote($this->id);

        $return = $this->db->exec($sql) !== false;

        if (! $this->afterDelete()) {
            $this->save();
            return false;
        }
        
        return $return;
	}

	/**
	 *
	 */
	public function validate()
	{
		$validators = $this->validators();

		if ($validators === null || count($validators) === 0) {
			return true;
		}

		foreach ($validators as $keys => $validator) {
			$keys = explode(',', $keys);

			foreach ($keys as $key) {
				$key = trim($key);
				$isValid = call_user_func_array($validator, array($key, $this));

				// if (! $isValid) {
				// 	$this->addError($key);
				// }
			}
		}

		return empty($this->errors);
	}

	/**
	 *
	 */
	public function addError($field, $message)
	{
		if (! isset($this->errors[$field])) {
			$this->errors[$field] = array();
		}

		$this->errors[$field][] = $message;
	}

	/**
	 *
	 */
	public function haveErrors()
	{
		return ! empty($this->errors);
	}

	/**
	 *
	 */
	public function getErrors()
	{
		return $this->errors;
	}

	/**
	 *
	 */
	public function getErrorsFormatted($template='<div class="errors">{ERRORS}</div>', $itemTemplate='<div class="error"><span class="value">{ERROR}</span></div>')
	{
		if (empty($this->errors)) {
			return null;
		}

		$items = array();

		foreach ($this->errors as $key=>$errors) {
			foreach ($errors as $error) {
				$items[] = str_replace('{ERROR}', $error, str_replace('{KEY}', $key, $itemTemplate));
			}
		}

		return str_replace('{ERRORS}', implode('', $items), $template);
	}

	/**
	 *
	 */
	public function beforeSave() { return true; }
    
    /**
	 *
	 */
    public function beforeInsert() { return true; }
    
    /**
	 *
	 */
    public function beforeUpdate() { return true; }
    
    /**
	 *
	 */
    public function beforeDelete() { return true; }
    
    /**
	 *
	 */
    public function afterSave() { return true; }
    
    /**
	 *
	 */
    public function afterInsert() { return true; }
    
    /**
	 *
	 */
    public function afterUpdate() { return true; }
    
    /**
	 *
	 */
    public function afterDelete() { return true; }

    /**
	 *
	 */
    public function validators() { return null; }

    /**
	 *
	 */
	protected function getTableName()
	{
		return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', get_class($this)));
	}

	/**
	 *
	 */
	protected function getTableAttrs()
	{
		$attrs = $this->getAttrs();
		$fields = $this->fields();

		$tableAttrs = array();

		foreach ($fields as $fieldName) {
			if (isset($attrs[$fieldName]) && $attrs[$fieldName] !== null) {
				$tableAttrs[$fieldName]=$attrs[$fieldName];
			}
		}

		return $tableAttrs;
	}
}
