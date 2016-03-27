<?php

interface Loggable
{
    public function log(array $data);
}

class LogToFile implements Loggable
{
    public function log(array $data)
    {
        var_dump("I am logging the data to a file.");
    }
}

class LogToDatabase implements Loggable
{
    public function log(array $data)
    {
        var_dump("I am logging the data to the database");
    }
}

class LogToWebService implements Loggable
{
    public function log(array $data)
    {
        var_dump("I am logging the data to a web service");
    }
}

class MyApp
{
    public function log(Loggable $logger, array $data)
    {
        $logger->log($data);

        return $this;
    }
}

$app = new MyApp();

$app->log(new LogToFile(), array("some data"));
$app->log(new LogToDatabase(), array("some other data"));
$app->log(new LogToWebService(), array("some more data"));
