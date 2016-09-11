<?php

// Example: You have a user model, and need new methods for fullName, a formatted created at, etc. But, that model is
// already suffering from model bloat. Instead, use a decorator:

abstract class Presenter
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function __call($method, $args)
    {
        return call_user_func_array([$this->model, $method], $args);
    }

    public function __get($name)
    {
        return $this->model->{$name};
    }
}

class UserPresenter extends Presenter
{
    public function fullName()
    {
        return trim($this->model->first_name . ' ' . $this->model->last_name);
    }

    public function createdAt()
    {
        return (new DateTime($this->model->created_at))->format('m/d/Y');
    }

    public function role()
    {
        return ($this->model->is_admin ? 'admin' : 'user');
    }
}

// Consuming code (maybe a controller action):
$user = new User::find(12);
$presenter = new UserPresenter($user);
return view([
    'name'       => $presenter->fullName(),
    'created_at' => $presenter->createdAt(),
    'role'       => $presenter->role(),
    'points'     => $presenter->points(), // Method on User model.
    'birthday'   => $presenter->birthday, // Property on User model.
]);
