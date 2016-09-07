<?php

/**
 * @author Sahil Gulati <sahil@getamplify.com>
 * @desc
 */
namespace Overloading\Worker;
class Overload extends \Overloading\Worker\Base
{
    /**
     * 
     * @param Array $arguments
     * this will receive an array which will contain
     * arguments and closures,
     */
    public function __construct($arguments)
    {
        if(is_array($arguments) && count($arguments)>0)
        {
            $instance=$this->__initConstruct(__FUNCTION__,$arguments);
            $this->validate(__FUNCTION__, $instance->arguments, $instance->closures);
            $this->register(__FUNCTION__,$instance);
            $this->executeConstructor();
        }
    }
    
    /**
     * @func validate:
     * This can be used to validate a function where it
     * is fulfilling the required conditions or not
     * @param string $functionName
     * @param array $argumentsPassed (In case: __construct)
     * @param array of Closures $instance
     * @throws \Overloading\Worker\Exception
     */
    public function validate($functionName,array $arguments ,array $instance)
    {
        switch($functionName)
        {
            case '__construct':
                \Overloading\Worker\Validator::validateConstructor($functionName,$arguments,$instance);
                if(\Overloading\Worker\Validator::$isValid===false)
                {
                    throw new \Overloading\Exception\Exception(101,$functionName);
                }
                break;
            default:
                \Overloading\Worker\Validator::validate($functionName,$instance);
                if(\Overloading\Worker\Validator::$isValid===false)
                {
                    throw new \Overloading\Exception\Exception(101,$functionName);
                }
                break;
        }
    }
    /**
     *
     * @func register
     * this will register all the functions in an array
     * which we will be invoked from @func __call
     * except constructor
     * @param String $functionName
     * @param \stdClass $instance
     */
    public function register($functionName,$instance)
    {
        switch($functionName)
        {
            case '__construct':
                $this->registeredFunctions[$functionName]= \Overloading\Worker\Registrar::registerConstructor($instance);
                break;
            default:
                $instance= \Overloading\Worker\Registrar::register($instance);
                $this->registeredFunctions[$functionName]=\Overloading\Worker\Registrar::merge($this->registeredFunctions,$instance);
                break;
        }
    }
    
    /**
     * 
     * @func __call
     * it will be called if there is no matching 
     * function, which is invoked over this class object,
     * if its function name contains string `__declare_(FUNCTION_NAME)` then
     * @1 Register the function with FUNCTION_NAME
     * @2 Else Execute the function
     * @param String $name
     * @param Array $arguments
     */
    public function __call($name, $arguments)
    {
        if(stristr($name, '__declare_'))
        {
            $name=\Overloading\Worker\Base::getFunctionName($name);
            $instance=$this->__initFunction($name, $arguments);
            $this->validate($name, array(), $instance->closures);
            $this->register($name, $instance);
        }
        else
        {
            $this->execute($name,$arguments);
        }
    }
}