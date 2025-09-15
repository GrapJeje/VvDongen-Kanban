<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'status', 'person', 'order'];

    public function labels()
    {
        return $this->belongsToMany(Label::class, 'label_task')
            ->withTimestamps();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_task')
            ->withTimestamps();
    }
}
