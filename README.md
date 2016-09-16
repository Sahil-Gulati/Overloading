# Overloading
This is an introductory framework to support PHP Overloading through closures. Multiple functions can be defined with the same name with the help of closures. Every function and its implementation undergoes different validation methods. A complete basis usage examples is shared in this documentation.

##Installation
`composer require sahil-gulati/overloading`<br/>
#####OR<br/>
Create composer.json in your project directory
```javascript
{
    "require":{
        "sahil-gulati/overloading":"1.0.0"
    }
}
```
`composer install`
##Usage
```php
<?php
include 'vendor/autoload.php';
class OverloadingTest extends Overloading\Overloading
{
    public $x="";
    public $y="";
    public function __construct()
    {
        parent::__construct(
            func_get_args(),
            function($x) {
                $this->x=$x;
                echo "Setting the value of x";
            },
            function($x,$y) {
                $this->x=$x;
                $this->y=$y;
                echo "Setting the value of x and y";
            }
        );
    }
    public function declareFunction()
    {
        parent::__declare_testing_function(function($x){
            $this->x=$x;
            echo "X will be replaced by new value.";
        });
        parent::__declare_testing_function(function($x,$y){
            $this->x=$x;
            $this->y=$y;
            echo "X and Y will be replaced by new values";
        });		
    }
}

try
{
    $obj =new OverloadingTest("s");
    $obj->declareFunction();
    $obj->testing_function("s","g");
} catch (\Overloading\Exception\Exception $ex) {
    echo $ex->getErrorMessageForCode();
}
```

##Output
<pre>
Setting the value of x
x and y will be replaced by new values
</pre>

##Validations
1. Constructor definition:
```php
parent::__construct(
    func_get_args(),            //array of arguments passed in constructor**
    function($x) {              //constructor definition 1.**
        $this->x=$x;
        echo "Setting the value of x";
    },
    function($x,$y) {           //constructor definition 2.**
        $this->x=$x;
        $this->y=$y;
        echo "Setting the value of x and y";
    }
    //..,
    //..,
    //..
);
```
2. Function definition:
```php
parent::__declare_FUNCTION_NAME(function($x) { //FUNCTION_NAME is name of function to define**
    echo "In function FUNCTION_NAME";
});
```

##Features
**1.** Constructor Overloading<br/>
**2.** Function Overloading


`Note`: In this framework, Function definition and its invoke rely not on the type of arguments but on the no. of arguments. For instance if you define 2 functions, One with 3 arguments and Other also with 3 arguments, Then 2nd function's definition over-writes the definition of first, So if you call that function then second function/closure will be executed. This thing can be viewed as a feature/drawback. Later implementations of the this framework will effectively handle type handing with the same no. of arguments.

`Disclaimer`: This framework is not claiming to support and parse overloading likewise in other languages. This is just an implementation that enables you to use PHP closures in place of overloading.
