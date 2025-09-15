<?php

namespace App\Livewire\Task;

use App\Enums\TaskStatus;
use App\Models\Task;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;

class Category extends Component
{
    public ?\App\Models\Category $category = null;
    public string $viewMode;
    public ?string $status = null;
    public Collection $tasks;

    protected $listeners = ['taskMoved' => 'moveTask'];

    public function mount($category = null, $status = null, $viewMode = 'overview')
    {
        $this->category = $category;
        $this->viewMode = $viewMode;
        $this->status = $status;
        $this->loadTasks();
    }

    private function loadTasks()
    {
        if ($this->viewMode === 'kanban' && $this->status) {
            $this->tasks = Task::where('status', $this->status)
                ->orderBy('order')
                ->get();
        } elseif ($this->viewMode === 'overview' && $this->category) {
            $this->tasks = $this->category->tasks()
                ->orderBy('order')
                ->get();
        } else {
            $this->tasks = collect();
        }
    }

    public function reorderCategory($draggedId, $targetId)
    {
        $dragged = \App\Models\Category::find($draggedId);
        $target  = \App\Models\Category::find($targetId);

        if ($dragged && $target) {
            $temp = $dragged->order;
            $dragged->order = $target->order;
            $target->order = $temp;

            $dragged->save();
            $target->save();
        }
    }

    public function moveTask($draggedId, $targetId = null, $newCategoryId = null, $newStatus = null)
    {
        $draggedTask = Task::find($draggedId);
        if (!$draggedTask) return;

        $targetTask = $targetId ? Task::find($targetId) : null;

        if ($this->viewMode === 'kanban' && $newStatus) {
            $draggedTask->status = $newStatus;
        }

        if ($this->viewMode === 'overview' && $newCategoryId) {
            $draggedTask->categories()->sync([$newCategoryId]);
        }

        if ($targetTask) {
            $draggedTask->order = $targetTask->order - 0.5;
            $draggedTask->save();
            $this->reorderTasks($newCategoryId ?? $this->category?->id, $newStatus);
        } else $draggedTask->save();

        $this->loadTasks();
    }

    private function reorderTasks($categoryId = null, $status = null)
    {
        $query = Task::query();

        if ($this->viewMode === 'kanban' && $status) {
            $query->where('status', $status);
        } elseif ($this->viewMode === 'overview' && $categoryId) {
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
            'tasks' => $this->tasks,
            'viewMode' => $this->viewMode,
            'status' => $this->status,
        ]);
    }
}
