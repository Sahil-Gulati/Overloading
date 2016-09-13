# Overloading
This is an introductory framework to support PHP Overloading through closures. Multiple functions can be defined with the same name with the help of closures. Every function and its implementation undergoes different validation methods. A complete basis usage examples is shared in this documentation.

##Installation
`composer require sahil-gulati/overloading`<br/>
#####OR<br/>
Create composer.json in your project directory
<pre>
{
    "require":{
        "sahil-gulati/overloading":"1.0.0"
    }
}
</pre>
`composer install`
##Usage
<pre>
&lt;?php
include 'vendor/autoload.php';
class Test extends Overloading\Overloading
{
    public function __construct()
    {
        parent::__construct(
            func_get_args(),
            function($x) {
                echo "in __construct x is $x\n";
            },
            function($x,$y) {
                echo "in __construct x y are $x, $y \n";
            }
        );
    }
    public function testing()
    {
        parent::__declare_test1(function($x){
            echo "in test1 x is $x";
        });
        parent::__declare_test1(function($x,$y){
            echo "in test1 x, y are $x, $y";
        });		
    }
}

try
{
    $obj =new Test("s");
    $obj->testing();
    $obj->test1("s","g");
} catch (\Overloading\Exception\Exception $ex) {
    echo $ex->getErrorMessageForCode();
}
</pre>

##Output
<pre>
in test1 x, y are s, g
</pre>

##Validations
1. Constructor definition:
<pre>
parent::__construct(
        func_get_args(),            **//array of arguments passed in constructor**
        function($x) {              **//constructor definition 1.**
            echo "in __construct x is $x\n";
        },
        function($x,$y) {           **//constructor definition 2.**
            echo "in __construct x y are $x, $y \n";
        }
);
</pre>
2. Function definition:
<pre>
parent::__declare_FUNCTION_NAME(function($x) { **//FUNCTION_NAME is name of function to define**
        echo "in test1 x is $x";
});
</pre>

##Features
**1.** Constructor Overloading<br/>
**2.** Function Overloading


`Note`: In this framework, Function definition and its invoke rely not on the type of arguments but on the no. of arguments. For instance if you define 2 functions, One with 3 arguments and Other also with 3 arguments, Then 2nd function's definition over-writes the definition of first, So if you call that function then second function/closure will be executed. This thing can be viewed as a feature/drawback. Later implementations of the this framework will effectively handle type handing with the same no. of arguments.

`Disclaimer`: This framework is not claiming to support and parse overloading likewise in other languages. This is just an implementation that enables you to use PHP closures in place of overloading.
