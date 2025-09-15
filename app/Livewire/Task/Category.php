<?php

namespace App\Livewire\Task;

use App\Enums\TaskStatus;
use App\Models\Task;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;

class Category extends Component
{
    public ?\App\Models\Category $category = null;
    public ?string $status = null;
    public string $viewMode;
    public Collection $tasks;

    protected $listeners = ['taskMoved' => 'moveTask'];

    public function mount()
    {
        $this->loadTasks();
    }

    private function loadTasks()
    {
        if ($this->status) {
            $statusEnum = TaskStatus::from($this->status);
            $this->tasks = Task::where('status', $statusEnum->value)
                ->orderBy('order')
                ->get();
        } elseif ($this->category) {
            $this->tasks = $this->category->tasks()->orderBy('order')->get();
        } else {
            $this->tasks = collect();
        }
    }

    public function reorderCategory($draggedId, $targetId)
    {
        $dragged = \App\Models\Category::find($draggedId);
        $target  = \App\Models\Category::find($targetId);

        if ($dragged && $target) {
            $tempOrder = $dragged->order;
            $dragged->order = $target->order;
            $target->order = $tempOrder;

            $dragged->save();
            $target->save();
        }
    }

    public function moveTask($draggedId, $targetId = null, $newCategoryId = null)
    {
        $draggedTask = Task::find($draggedId);
        if (!$draggedTask) return;

        $targetTask = $targetId ? Task::find($targetId) : null;

        // Update status if kanban view
        if ($this->viewMode === 'kanban' && $this->status) {
            $draggedTask->status = $this->status->value ?? $this->status;
        }

        // Update category if overview
        if ($newCategoryId) {
            $draggedTask->categories()->sync([$newCategoryId]);
        }

        // Order logic
        if ($targetTask) {
            $draggedTask->order = $targetTask->order - 0.5; // tijdelijk ertussen
            $draggedTask->save();
            $this->reorderTasks($newCategoryId ?? $this->category?->id);
        } else {
            $draggedTask->save();
        }

        $this->loadTasks();
    }

    private function reorderTasks($categoryId = null)
    {
        $query = Task::query();

        if ($this->viewMode === 'kanban' && $this->status) {
            $query->where('status', $this->status->value ?? $this->status);
        } elseif ($categoryId) {
            $query->whereHas('categories', fn($q) => $q->where('categories.id', $categoryId));
        }

        $tasks = $query->orderBy('order')->get();
        foreach ($tasks as $i => $task) {
            $task->order = $i + 1;
            $task->save();
        }
    }

    public function render()
    {
        return view('livewire.task.category', [
            'category' => $this->category,
            'status' => $this->status ? TaskStatus::from($this->status) : null,
            'viewMode' => $this->viewMode,
            'tasks' => $this->tasks,
        ]);
    }
}
