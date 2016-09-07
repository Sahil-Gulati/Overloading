<?php

/**
 * @author Sahil Gulati <sahil@getamplify.com>
 * @desc
 */
namespace Overloading\Worker;
class Registrar
{
    /**
     * 
     * @func will receive an instance which will
     * be registered in the registeredFunctions array
     * @param \stdClass $instance
     */
    public static function registerConstructor(\stdClass $instance)
    {
        $instance=self::getConstructorParameters($instance);
        return $instance;
    }
    /**
     * @func getParameters
     * will map a function on index corresponds to its
     * required parameters
     * @param stdClass $instance
     * @return stdClass $instance
     */
    public static function getConstructorParameters(\stdClass $instance)
    {
        if(is_object($instance))
        {
            $closures=$instance->closures;
            unset($instance->closures);
            foreach($closures as $key => $closureObj)
            {
                $parametersObj=self::getReflectionRequiredParameters($closureObj);
                $instance->{$instance->name}["required"][$parametersObj->noOfRequiredParameters]=$closureObj;
            }
        }
        return $instance;
    }
    
    /**
     * @func getReflectionRequiredParameters
     * will return all the parameters related details 
     * required for a closure to be called while execution
     * @param Object(Closure) $instance
     * @return \stdClass $newInstance
     */
    public static function getReflectionRequiredParameters(\Closure $instance)
    {
        $newInstance=self::getInstance();
        $reflectionObj= new \ReflectionFunction($instance);
        $newInstance->noOfParameters=$reflectionObj->getNumberOfParameters();
        $newInstance->noOfRequiredParameters=$reflectionObj->getNumberOfRequiredParameters();
        $newInstance->noOfOptionalParameters=$newInstance->noOfParameters-$newInstance->noOfRequiredParameters;
        foreach($reflectionObj->getParameters() as $key => $reflectionObj)
        {
            $newInstance->requireParameters[$key]=$reflectionObj->name;
        }
        return $newInstance;
    }
    /**
     * 
     * @param Object(stdClass) $instance
     * @return returns a stdClass object function
     * contain all the parameters which are required for a function
     */
    public static function register($instance)
    {
        return self::getParameters($instance);
    }
    /**
     * 
     * @param object(stdClass) $instance
     * @return object
     * returns a stdClass object which contain all the
     * required properties of a closure
     */
    public static function getParameters($instance)
    {
        $newInstance=self::getInstance();
        $newInstance->name=$instance->name;
        foreach ($instance->closures as $key => $closureObj)
        {
            $reflectionObj=self::getReflectionRequiredParameters($closureObj);
            $newInstance->{$instance->name}["required"][$reflectionObj->noOfRequiredParameters]=$closureObj;
        }
        return $newInstance;
    }
    /**
     * 
     * @param array $registerFunctions
     * @param \stdClass $instance
     * @return array
     * return an array index of the function which 
     * contains merged object on the basis of required 
     * properties
     */
    public static function merge(array $registerFunctions,  \stdClass $instance)
    {
        $functionName=$instance->name;
        foreach($instance->{$functionName}["required"] as $noOfParameters => $closureObj)
        {
            $registerFunctions[$functionName]->{$functionName}["required"][$noOfParameters]=$closureObj;
        }
        return $registerFunctions[$functionName];
    }
    /**
     * 
     * @return \stdClass 
     * returns a stdClass object which will be a blank object
     */
    public static function getInstance()
    {
        return new \stdClass();
    }
}