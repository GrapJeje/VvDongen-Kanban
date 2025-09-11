<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'order',
    ];

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'category_task')
            ->withTimestamps();
    }
}
