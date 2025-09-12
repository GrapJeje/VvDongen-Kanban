<?php

namespace App\Livewire\Task;

use App\Models\Task;
use Livewire\Component;

class Card extends Component
{
    public Task $card;
    public string $viewMode;

    public function mount(Task $task, string $viewMode)
    {
        $this->card = $task;
        $this->viewMode = $viewMode;
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
        return view('livewire.task.card', [
            'card' => $this->card,
            'viewMode' => $this->viewMode,
        ]);
    }
}
