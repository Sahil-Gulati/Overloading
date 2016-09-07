<?php
ini_set('display_errors', 1);
include 'Overloading.php';
class Test extends Overloading\Overloading
{
    public function __construct()
    {
        parent::__construct(
            func_get_args(),
            function($x)
            {
                echo "in __construct x is $x\n";
            },
            function($x,$y)
            {
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
