<?php

interface Subject
{
    public function attach(Observer2 $observer);
    public function attachMultiple(array $observers);
    public function detach(Observer2 $observer);
    public function notify();
}

interface Observer2
{
    public function handle();
}

class LoginEvent implements Subject
{
    /**
     * @var SplObjectStorage
     */
    private $observers;

    public function __construct()
    {
        $this->observers = new SplObjectStorage();
    }

    public function attach(Observer2 $observer)
    {
        $this->observers->attach($observer);

        return $this;
    }

    public function attachMultiple(array $observers)
    {
        foreach ($observers as $observer) {
            $this->attach($observer);
        }

        return $this;
    }

    public function detach(Observer2 $observer)
    {
        $this->observers->detach($observer);

        return $this;
    }

    public function notify()
    {
        /** @var Observer2 $observer */
        foreach ($this->observers as $observer) {
            $observer->handle();
        }
    }
}

class LogHandler implements Observer2
{
    public function handle()
    {
        var_dump("We are logging to a file.");
    }
}

class LoginCountHandler implements Observer2
{
    public function handle()
    {
        var_dump("We are incrementing the login count.");
    }
}

class SendLoginEmail implements Observer2
{
    public function handle()
    {
        var_dump("We are sending the login email");
    }
}

// The user logs in.
$login = new LoginEvent();

$login->attach(new LogHandler())
    ->attachMultiple(array(
        new LoginCountHandler(),
        new SendLoginEmail(),
    ));

$login->notify();
