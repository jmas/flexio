<?php

/**
 * Flash service
 *
 * Purpose of this service is to make some data available across pages. Flash
 * data is available on the next page but deleted when execution reach its end.
 *
 * Usual use of Flash is to make it possible for the current page to pass some data
 * to the next one (for instance success or error message before HTTP redirect).
 *
 * Flash::set('errors', 'Blog not found!');
 * Flass::set('success', 'Blog has been saved with success!');
 * Flash::get('success');
 *
 * Flash service as a concept is taken from Rails. This thing is really useful!
 */
class Flash
{
    const SESSION_KEY = 'flash';
    
    private $previous = array(); // Data that prevous page left in the Flash

    /**
     * This function will read flash data from the $_SESSION variable
     * and load it into $this->previous array
     *
     * @param none
     * @return void
     */
    public function __construct($config=array())
    {
        foreach ($config as $key=>$value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }

        // Get flash data...
        if( !empty($_SESSION[self::SESSION_KEY]) && is_array($_SESSION[self::SESSION_KEY]) ) {
            $this->previous = $_SESSION[self::SESSION_KEY];
        }

        $_SESSION[self::SESSION_KEY] = array();
    }

    /**
     * Return specific variable from the flash. If value is not found NULL is
     * returned
     *
     * @param string $var Variable name
     * @return mixed
     */
    public function get($var, $defaultValue=null)
    {
        return isset($this->previous[$var]) ? $this->previous[$var]: $defaultValue;
    }

    /**
     * Add specific variable to the flash. This variable will be available on the
     * next page unless removed with the removeVariable() or clear() method
     *
     * @param string $var Variable name
     * @param mixed $value Variable value
     * @return void
     */
    public function set($var, $value)
    {
        $_SESSION[self::SESSION_KEY][$var] = $value;
    }

    /**
     * Call this function to clear flash. Note that data that previous page
     * stored will not be deleted - just the data that this page saved for
     * the next page
     *
     * @param none
     * @return void
     */
    public function clear()
    {
        $_SESSION[self::SESSION_KEY] = array();
    }

} // end Flash class
