<?php

class Database
{

    private $_connection;
    // Store the single instance
    private static $_instance;

    /**
     * Gets an instance of the database
     *
     * @return Database
     */
    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Class constructor, protected so that it can only be accessed outside the class via getInstance()
     */
    protected function __construct()
    {
        $this->_connection = new mysqli('localhost', 'root', 'password', 'php_oop');
        if (mysqli_connect_error()) {
            trigger_error('Failed to connect to MySQL: ' . mysqli_connect_error(), E_USER_ERROR);
        }
    }

    /**
     * Empty clone magic method to prevent duplication
     */
    private function __clone()
    {
    }

    /**
     * Get the mysqli connection
     * @return mixed
     */
    public function getConnection()
    {
        return $this->_connection;
    }
}

// Usage:
$db = Database::getInstance();
$mysqli = $db->getConnection();

$result = $mysqli->query("SELECT postal_code FROM location ");
