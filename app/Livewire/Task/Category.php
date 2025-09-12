<?php

namespace App\Livewire\Task;

use App\Enums\TaskStatus;
use Livewire\Component;
use App\Models\Task;

class Category extends Component
{
    public ?\App\Models\Category $category = null;
    public ?string $status = null;
    public string $viewMode;
    public array $tasks = [];

    public function mount()
    {
        if ($this->status) {
            $statusEnum = TaskStatus::from($this->status);
            $this->tasks = Task::where('status', $statusEnum->value)->get()->toArray();
        } elseif ($this->category) {
            $this->tasks = $this->category->tasks->toArray();
        }
    }

    public function render()
    {
        return view('livewire.task.category', [
            'category' => $this->category,
            'status'   => $this->status ? TaskStatus::from($this->status) : null,
            'viewMode' => $this->viewMode,
            'tasks'    => $this->tasks,
        ]);
    }
}
