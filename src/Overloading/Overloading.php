<?php
/**
 * @author Sahil Gulati <sahil@getamplify.com>
 * @desc
 */

namespace Overloading;
ini_set('display_errors', 1);
spl_autoload_register(array('Overloading\Loader','loaderNamespace'));
class Loader
{
    public static function loaderNamespace($qualifiedClassname)
    {
        $classname=  str_replace('\\', '/', $qualifiedClassname);
        $classname=ltrim($classname,__NAMESPACE__."/");
        $classname=$classname.".php";
        if(file_exists($classname))
        {
            require_once $classname;
        }
        else
        {
            self::loadClass($qualifiedClassname);
        }
    }
    public static function loadClass($qualifiedClassname)
    {
        throw new \Overloading\Exception\Exception(102,$qualifiedClassname);
    }
}

class Overloading extends \Overloading\Worker\Overload
{
    public function __construct()
    {
        return parent::__construct(func_get_args());
    }
    public function __call($functionName,$arguments)
    {
        parent::__call($functionName, $arguments);
    }
}