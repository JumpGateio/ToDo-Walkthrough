<?php

namespace App\Services\ToDo\Models;

use App\Models\BaseModel;
use App\Models\User;

class TaskList extends BaseModel
{
    public $table = 'todo_lists';

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'complete_flag',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'list_id');
    }
}
