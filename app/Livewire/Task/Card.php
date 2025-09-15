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

    public function render()
    {
        return view('livewire.task.card', [
            'card' => $this->card,
            'viewMode' => $this->viewMode,
        ]);
    }
}
