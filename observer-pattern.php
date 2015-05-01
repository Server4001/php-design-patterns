<?php

interface Observer
{
    public function addCurrency(Currency $currency);
}

interface Currency
{
    public function __construct($price);
    public function update();
    public function getPrice();
}

class PriceSimulator implements Observer
{
    private $_currencies = null;

    public function __construct()
    {
        $this->_currencies = array();
    }

    public function addCurrency(Currency $currency)
    {
        array_push($this->_currencies, $currency);

        return $this;
    }

    public function updatePrices()
    {
        foreach ($this->_currencies as $currency) {
            /** @var Currency $currency */
            $currency->update();
        }

        return $this;
    }
}

class Pound implements Currency
{
    private $_price;

    public function __construct($price)
    {
        $this->_price = $price;
        echo self::class . " Original Price: {$price}" . PHP_EOL;
    }

    public function update()
    {
        $this->_price = $this->getPrice();
        echo self::class . " Updated Price: {$this->_price}" . PHP_EOL;

        return $this;
    }

    public function getPrice()
    {
        return f_rand(0.65, 0.71);
    }
}

class Yen implements Currency
{

    private $_price;

    public function __construct($price)
    {
        $this->_price = $price;
        echo self::class . " Original Price: {$price}" . PHP_EOL;
    }

    public function update()
    {
        $this->_price = $this->getPrice();
        echo self::class . " Updated Price: {$this->_price}" . PHP_EOL;

        return $this;
    }

    public function getPrice()
    {
        return f_rand(120.52, 122.50);
    }
}

function f_rand($min = 0, $max = 1, $mul = 1000000)
{
    if ($min > $max) {
        throw new Exception('You are dumb.');
    }

    return mt_rand(($min * $mul), ($max * $mul)) / $mul;
}

// ------------------
// EXAMPLE USAGE:
// ------------------
$priceSimulator = new PriceSimulator();
$yen = new Yen(12);
$pound = new Pound(200);

$priceSimulator->addCurrency($yen)
    ->addCurrency($pound);

echo PHP_EOL;

$priceSimulator->updatePrices();

echo PHP_EOL;

$priceSimulator->updatePrices();

echo PHP_EOL;

// ------------------
// ADDING A NEW CLASS TO OBSERVE:
// ------------------
class Dollar implements Currency
{
    private $_price;

    public function __construct($price)
    {
        $this->_price = $price;
        echo self::class . " Original Price: {$price}" . PHP_EOL;
    }

    public function update()
    {
        $this->_price = $this->getPrice();
        echo self::class . " Updated Price: {$this->_price}" . PHP_EOL;

        return $this;
    }

    public function getPrice()
    {
        return f_rand(2.12, 5.60);
    }
}

// ------------------
// USING THE NEW CLASS:
// ------------------
$dollar = new Dollar(62.15);
$priceSimulator->addCurrency($dollar);

echo PHP_EOL;

$priceSimulator->updatePrices();

