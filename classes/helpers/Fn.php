<?php

/**
 * @class Fn
 */
class Fn
{
	/**
	 * Call a user function using named instead of positional parameters.
	 * If some of the named parameters are not present in the original function, they
	 * will be silently discarded.
	 * Does no special processing for call-by-ref functions...
	 * @param string $function name of function to be called
	 * @param array $params array containing parameters to be passed to the function using their name (ie array key)
	 */
	static public function callNamed($className, $methodName, $params)
	{
	    $reflect = new ReflectionMethod($className, $methodName);
	    $real_params = array();

	    foreach ($reflect->getParameters() as $i => $param) {
	        $pname = $param->getName();
	        
	        if ($param->isPassedByReference()) {
	            /// @todo shall we raise some warning?
	        }

	        if (array_key_exists($pname, $params)) {
	            $real_params[] = $params[$pname];
	        } else if ($param->isDefaultValueAvailable()) {
	            $real_params[] = $param->getDefaultValue();
	        } else {
	            // missing required parameter: mark an error and exit
	            //return new Exception('call to '.$fn.' missing parameter nr. '.$i+1);
	            throw new Exception(sprintf('call missing parameter nr. %d', $i+1));
	        }
	    }

	    return call_user_func_array(array($className, $methodName), $real_params);
	}
}