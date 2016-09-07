<?php

/**
 * @author Sahil Gulati <sahil@getamplify.com>
 * @desc
 */
namespace Overloading\Worker;
class Validator
{
    /**
     *
     * @var Boolean $isValid
     * which will determine weather a validation 
     * is successfull or not
     */
    public static $isValid=false;
    
    /**
     * 
     * @func validate
     * This will validate function name and the
     * closures array
     * @param String $functionName
     * @param array $instances
     */
    public static function validate($functionName,array $instances)
    {
        self::$isValid=  is_string($functionName) ? true: false;
        foreach ($instances as $key => $closureObj)
        {
            if(!is_object($closureObj))
            {
                self::$isValid=false;
                break;
            }
        }
    }
    /**
     * @func validateConstructor:
     * validates a constructor arguments weather a 
     * registeration request for a overloading 
     * constructor is valid or not!
     * @param string $functionName
     * @param array $arguments
     * @param \stdClass $instance
     */
    public static function validateConstructor($functionName,array $arguments,array $instance)
    {
        self::$isValid=  is_string($functionName) ? true : false;
        self::$isValid=  is_array($arguments) ? true : false;
        foreach ($instance as $key => $closureObj)
        {
            if(!is_object($closureObj))
            {
                self::$isValid=false;
                break;
            }
        }
    }
}