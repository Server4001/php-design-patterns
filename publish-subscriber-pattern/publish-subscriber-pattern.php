<?php

class Component
{
    protected $_name = '';

    public function __construct($name)
    {
        $this->_name = $name;
    }

    public function doSomething()
    {
        echo $this->_name . " did something!\n";

        $instance = Dispatcher::getInstance();
        $instance::publish($this);
    }
}

class Dispatcher
{
    protected $_listeners = array();
    protected static $_instance = null;

    protected function __construct() { }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public static function subscribe($object, $subscriber)
    {
        $instance = Dispatcher::getInstance();
        $id = spl_object_hash($object);

        $instance->_listeners[$id][] = $subscriber;
    }

    public static function publish($object)
    {
        $instance = Dispatcher::getInstance();
        $id = spl_object_hash($object);

        if (!isset($instance->_listeners[$id])) {
            return;
        }

        $subscribers = $instance->_listeners[$id];

        foreach($subscribers as $subscriber) {
            /** @var Component $subscriber */
            $subscriber->doSomething();
        }
    }
}

// Usage:
$componentA = new Component('Component A');
$dispatcher = Dispatcher::getInstance();

$componentB = new Component('Component B');
$dispatcher::subscribe($componentA, $componentB);

$componentC = new Component('Component C');
$dispatcher::subscribe($componentA, $componentC);

$componentD = new Component('Component D');
$dispatcher::subscribe($componentB, $componentD);

/**
 * Something important happens to Component A and B, C, and D are automatically notified.
 */

$componentA->doSomething();
