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

class AnimalPurchaseService
{
    protected $AnimalService;
    protected $PaymentProcessorService;
    public function __construct(AnimalService $AnimalService,  PaymentProcessorService $PaymentProcessorService)
    {
        $this->AnimalService = $AnimalService;
        $this->PaymentProcessorService = $PaymentProcessorService;
    }

    public function buy( $type = NULL)
    {
        $this->AnimalService->bark();
        $this->AnimalService->walk();
        if( $type == 'needlogin'){
            $this->PaymentProcessorService->login();
        }
        $this->PaymentProcessorService->payNow();
        
    }
}





// custom facade class that can be extended 
abstract class Facade 
{
    public static function __callStatic($name, $arguments)
    {
        $class = static::resolveClass();

        if( is_string($class)){
            $obj = new $class();
        }else if( is_object($class)){
            $obj =  $class;
        }
        
        
        $obj->$name(...$arguments);
        
    }

    abstract static function resolveClass();
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


class AnimalPurchase extends Facade {
    public static function resolveClass(){
        $animal = new AnimalService();
        $payment = new PaymentProcessorService();
        $purchase = new AnimalPurchaseService( $animal ,  $payment);
        return $purchase ;
    }
    
}








/*
Facade pattern implementation in core php. 

In laravel facades prvides a static interface in which no need to create object of the dependencies while calling the facade function because all dependencies object are created in the service container using bind method.

As it's a core php , there is no such container which will create dependencies object . That's why we create a facade abstract class.  If any cass extend this class it will automaticaly provide the static interface in core php also. 
*/


// ---------------------------- sample facade call --------------------
//echo PaymentProcessor::payNow();
//echo Animal::walk();
//echo AnimalPurchase::buy('needlogin');

echo AnimalPurchase::buy();