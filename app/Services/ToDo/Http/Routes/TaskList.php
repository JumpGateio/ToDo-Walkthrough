<?php

namespace App\Services\ToDo\Http\Routes;

use Illuminate\Routing\Router;
use JumpGate\Core\Contracts\Routes;
use JumpGate\Core\Http\Routes\BaseRoute;

class TaskList extends BaseRoute implements Routes
{
    public $namespace = 'App\Services\Http\Controllers';

    public $middleware = [
        'web',
        'auth',
    ];

    public function routes(Router $router)
    {
        $router->get('create')
            ->name('task-list.create')
            ->uses('TaskList@create')
            ->middleware('active:task-list.create');
        $router->post('create')
            ->name('task-list.create')
            ->uses('TaskList@store');

        $router->get('edit')
            ->name('task-list.edit')
            ->uses('TaskList@edit')
            ->middleware('active:task-list.edit');
        $router->post('edit')
            ->name('task-list.edit')
            ->uses('TaskList@update');

        $router->get('delete')
            ->name('task-list.delete')
            ->uses('TaskList@delete');

        $router->get('{id}')
            ->name('task-list.show')
            ->uses('TaskList@show')
            ->middleware('active:task-list');

        $router->get('/')
            ->name('task-list.index')
            ->uses('TaskList@index')
            ->middleware('active:task-list.index');
    }
}
