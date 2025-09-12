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

    public function moveTask($draggedId, $targetId, $newCategoryId = null)
    {
        $draggedTask = Task::find($draggedId);
        $targetTask  = Task::find($targetId);

        if (!$draggedTask || !$targetTask) return;

        if ($newCategoryId && $draggedTask->categories()->first()->id !== $newCategoryId) {
            $draggedTask->categories()->detach($draggedTask->categories()->first());
            $draggedTask->categories()->attach($newCategoryId, ['order' => $targetTask->order]);
        } else {
            $tempOrder = $draggedTask->order;
            $draggedTask->order = $targetTask->order;
            $targetTask->order = $tempOrder;
            $draggedTask->save();
            $targetTask->save();
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
