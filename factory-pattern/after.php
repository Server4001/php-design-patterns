<?php

class Vehicle
{

    public static function create($type, $wheels)
    {
        switch ($type) {
            case "car":
                return new Car($wheels);
                break;
            case "truck":
                return new Truck($wheels);
                break;
            default:
                return new stdClass();
        }
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

$car = Vehicle::create('car', 4);
echo $car->getType() . "<br>";

$truck = Vehicle::create('truck', 18);
echo $truck->getType() . "<br>";
