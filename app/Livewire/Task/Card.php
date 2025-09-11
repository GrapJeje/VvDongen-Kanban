<?php

namespace App\Livewire\Task;

use Livewire\Component;

class Card extends Component
{
    public \App\Models\Task $card;

    public function mount(\App\Models\Task $task)
    {
        $this->card = $task;
    }

    public function render()
    {
        return view('livewire.task.card', [
            'card' => $this->card,
        ]);
    }
}
