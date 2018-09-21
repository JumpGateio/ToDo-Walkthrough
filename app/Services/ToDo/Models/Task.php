<?php

namespace App\Services\ToDo\Models;

use App\Models\BaseModel;

class Task extends BaseModel
{
    public $table = 'todo_tasks';

    protected $fillable = [
        'list_id',
        'name',
        'description',
        'complete_flag',
    ];

    public function taskList()
    {
        return $this->belongsTo(TaskList::class, 'list_id');
    }
}
