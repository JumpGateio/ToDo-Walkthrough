<?php

namespace App\Services\ToDo\Http\Routes;

use Illuminate\Routing\Router;
use JumpGate\Core\Contracts\Routes;
use JumpGate\Core\Http\Routes\BaseRoute;

class Task extends BaseRoute implements Routes
{
    public $namespace = 'App\Services\Http\Controllers';

    public $middleware = [
        'web',
        'auth',
    ];

    public function routes(Router $router)
    {
        $router->get('create')
            ->name('task.create')
            ->uses('Task@create')
            ->middleware('active:task.create');
        $router->post('create')
            ->name('task.create')
            ->uses('Task@store');

        $router->get('edit/{id}')
            ->name('task.edit')
            ->uses('Task@edit')
            ->middleware('active:task.edit');
        $router->post('edit/{id}')
            ->name('task.edit')
            ->uses('Task@update');

        $router->get('delete/{id}')
            ->name('task.delete')
            ->uses('Task@delete');

        $router->get('{id}')
            ->name('task.show')
            ->uses('Task@show')
            ->middleware('active:task');

        $router->get('/')
            ->name('task.index')
            ->uses('Task@index')
            ->middleware('active:task.index');
    }
}
