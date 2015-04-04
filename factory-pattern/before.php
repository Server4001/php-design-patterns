<?php

class Vehicle
{

    /**
     * @var int
     */
    private $wheels;

    public function __construct($wheels = 0)
    {
        $this->wheels = $wheels;
    }

    public function getType()
    {
        return get_class($this);
    }
}

class Car extends Vehicle
{

}

class Truck extends Vehicle
{

}

$car = new Car(4);
echo $car->getType() . "<br>";

$truck = new Truck();
echo $truck->getType() . "<br>";
