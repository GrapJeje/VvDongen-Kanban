<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;
use phpDocumentor\Reflection\Types\Boolean;

#[Layout('layouts.default')]
class Home extends Component
{
    public string $viewMode = 'overview'; // 'overview' or 'kanban'

    public function switchViewMode()
    {
        $this->viewMode = $this->viewMode === 'overview' ? 'kanban' : 'overview';
    }

    public function render()
    {
        return view('livewire.home');
    }
}
