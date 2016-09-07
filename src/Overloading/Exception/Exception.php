<?php
/**
 * @author Sahil Gulati <sahil@getamplify.com>
 * @desc
 */
namespace Overloading\Exception;
class Exception extends \Exception
{
    /**
     *
     * @var $_code For recieving the current  
     * error code with which exception is thrown
     */
    private $_code=0;
    /**
     *
     * @var $errorMessage in which we will set
     * the error message which corresponds to 
     * error code
     */
    private $errorMessage=array();
    /**
     *
     * @var $errorCodes in which we define valid
     * erro codes which we valid error codes if a 
     * code is not defined, then we can't set message 
     * against that error code;
     */
    private $errorCodes=array(100,101,102,103);
    /**
     *
     * @var $messageVariables extra variables
     * which can be used while creating message 
     * for current exception thrown
     */
    private static $messageVariables=array();
    
    public function __construct($code)
    {
        $this->_code=$code;
        self::$messageVariables=  func_get_args();
        $this->registerException();
        parent::__construct($this->getErrorMessageForCode(), $code);
    }
    
    /**
     * 
     * @func getErrorMessageForCode:
     * will return the error code on the basis
     * of error code received in the exception
     */
    public function getErrorMessageForCode()
    {
        if(isset($this->errorMessage[$this->_code]))
        {
            return $this->errorMessage[$this->_code];
        }
    }
    
    /**
     * @func registerException:
     * will register the error message on the basis
     * of error code received in exception and
     * arguments received
     */
    private function registerException()
    {
        foreach($this->errorCodes as $errorCode)
        {
            switch($errorCode)
            {
                case 100:
                    $this->errorMessage[$errorCode]="Fatal error: No matching function:(".self::$messageVariables[1].") with no. of arguments:(".self::$messageVariables[2].") ";
                    break;
                case 101:
                    $this->errorMessage[$errorCode]="Fatal error: Failed validation of function:(".self::$messageVariables[1].")";
                    break;
                case 102:
                    $this->errorMessage[$errorCode]="Fatal error: Failed to load class:(".self::$messageVariables[1].")";
                    break;
            }
        }
    }
}