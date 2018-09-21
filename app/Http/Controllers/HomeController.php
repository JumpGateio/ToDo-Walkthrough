<?php

namespace App\Http\Controllers;

use App\Services\ToDo\Models\TaskList;

class HomeController extends BaseController
{
    public function index()
    {
        TaskList::create([
            'user_id' => auth()->id(),
            'name' => 'Testing task lists',
        ]);
        return $this->view();
    }
}
