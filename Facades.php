<?php
class PaymentProcessorService
{
    public function payNow()
    {
        echo "Paid";
        echo "\n";
    }

    public function login()
    {
        echo "login";
        echo "\n";
    }
}


class AnimalService
{
    public function bark()
    {
        echo "bark";
        echo "\n";
    }

    public function walk()
    {
        echo "walk";
        echo "\n";
    }
}



abstract class Facade 
{
    public static $resolveClassName = '';
   
    public static function __callStatic($name, $arguments)
    {
        $class = static::resolveClass();
        $obj = new $class();
        $obj->$name(...$arguments);
        
    }

    public static function resolveClass(){
        // exception can be thrown but for now using die
        die('Need to resolve class in the child facade') ;
    }
}

class Animal extends Facade {
    public static function resolveClass(){
        return 'AnimalService';
    }
    
}

class PaymentProcessor extends Facade {
    public static function resolveClass(){
        return 'PaymentProcessorService';
    }
    
}








//$pay = new PaymentProcessor();
echo PaymentProcessor::payNow();
echo Animal::walk();