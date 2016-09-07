<?php

/**
 * @author Sahil Gulati <sahil@getamplify.com>
 * @desc
 */
namespace Overloading\Worker;
class Base
{
    /**
     *
     * @var Array $registeredFunctions
     * will contain all the closures corresponding to 
     * function name and require parameters
     */
    protected $registeredFunctions=array();
    /**
     * 
     * @param String $functionName
     * @param Array $arguments
     * where its 0th field contain an array and
     * remaining fields contains closures
     * @return Object will return an instance 
     * which contain all the necessary information 
     */
    public function __initConstruct($functionName,$arguments)
    {
        $instance=self::getInstance();
        $instance->name=$functionName;
        $instance->arguments=$arguments[0];
        unset($arguments[0]);
        $instance->closures=$arguments;
        return $instance;
    }
    
    public function __initFunction($functionName,array $closures)
    {
        $instance=self::getInstance();
        $instance->name=$functionName;
        $instance->closures=$closures;
        return $instance;
    }
    /**
     * @func executeConstructor
     * This is the final function which will execute the 
     * functional finally on the basis of arguments required.
     * and send invoke the arguments sequentially
     */
    public function executeConstructor()
    {
        if(is_array($this->registeredFunctions) && isset($this->registeredFunctions['__construct']))
        {
            $arguments=$this->registeredFunctions['__construct']->arguments;
            $noOfArguments=count($this->registeredFunctions['__construct']->arguments);
            $functionName=$this->registeredFunctions['__construct']->name;
            if(isset($this->registeredFunctions['__construct']->{$functionName}["required"][$noOfArguments]))
            {
                $evalString=array();
                foreach($arguments as $key => $value)
                {
                    $evalString[]='$arguments['.$key.']';
                }
                $evalString=implode(',', $evalString);
                eval('$this->registeredFunctions["__construct"]->{$functionName}["required"][$noOfArguments]('.$evalString.');');
                unset($this->registeredFunctions['__construct']);
            }
            else
            {
                throw new \Overloading\Exception\Exception(100,$functionName,$noOfArguments);
            }
        }
    }
    /**
     * 
     * @func execute
     * executes a function which is already registered
     * with required no of arguments
     * @param String $name
     * @param Array $arguments
     */
    public function execute($name,$arguments)
    {
        $noOfArguments=count($arguments);
        if(isset($this->registeredFunctions[$name]) && isset($this->registeredFunctions[$name]->{$name}["required"][$noOfArguments]))
        {
            $evalString=array();
            foreach($arguments as $key => $value)
            {
                $evalString[]='$arguments['.$key.']';
            }
            $evalString=implode(',', $evalString);
            eval('$this->registeredFunctions[$name]->{$name}["required"][$noOfArguments]('.$evalString.');');
        }
        else
        {
            throw new \Overloading\Exception\Exception(100,$name,$noOfArguments);
        }
    }
    /**
     * 
     * @func getInstance
     * used at most of the places for retrieving a standard
     * and blank class Object
     * @return Object retuurn a stdClass Object
     */
    public static function getInstance()
    {
        return \Overloading\Worker\Registrar::getInstance();
    }
    
    /**
     * 
     * @param String $functionName
     * @return String FUNCTION_NAME
     * which is the required function with which function
     *  name get registered 
     */
    public static function getFunctionName($functionName)
    {
        if(is_string($functionName) && stristr($functionName, '__declare_'))
        {
            return ltrim($functionName,'__declare_');
        }
    }
}