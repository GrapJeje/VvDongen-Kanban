<?php

namespace App\Livewire\Task;

use Livewire\Component;

class Category extends Component
{
    public \App\Models\Category $category;

    public function mount(\App\Models\Category $category)
    {
        $this->category = $category;
    }

    public function render()
    {
        return view('livewire.task.category', [
            'category' => $this->category,
        ]);
    }
}
