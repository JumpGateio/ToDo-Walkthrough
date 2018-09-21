<?php

namespace App\Services\ToDo\Models;

use App\Models\BaseModel;
use App\Models\User;
use Cviebrock\EloquentSluggable\Sluggable;

class TaskList extends BaseModel
{
    use Sluggable;

    public $table = 'todo_lists';

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'complete_flag',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'list_id');
    }
}
