<?php

interface CarService
{
	public function getCost();

	public function getDescription();
}

class BasicInspection implements CarService
{
	public function getCost()
	{
		return 25;
	}

	public function getDescription()
	{
		return 'Basic Inspection';
	}
}

class OilChange implements CarService
{
	protected $_carService;

	function __construct(CarService $carService)
	{
	    $this->_carService = $carService;
	}

	public function getCost()
	{
		return 29 + $this->_carService->getCost();
	}

	public function getDescription()
	{
		return $this->_carService->getDescription() . ' and Oil Change';
	}
}

class TireRotation implements CarService
{
	protected $_carService;

	function __construct(CarService $carService)
	{
		$this->_carService = $carService;
	}

	public function getCost()
	{
		return 15 + $this->_carService->getCost();
	}

	public function getDescription()
	{
		return $this->_carService->getDescription() . ' and Tire Rotation';
	}
}

// Usage:
$service = new OilChange(new TireRotation(new BasicInspection));
echo $service->getDescription() . "\n";
echo $service->getCost() . "\n";
