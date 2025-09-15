<div>
    @section('title', 'KanBan')

    <header>
        <div class="kanban__btn">
            <button
                type="button"
                wire:click="switchViewMode"
                @if($viewMode === 'overview') disabled @endif
            >
                Overview
            </button>
            <button
                type="button"
                wire:click="switchViewMode"
                @if($viewMode === 'kanban') disabled @endif
            >
                Kanban
            </button>
        </div>
    </header>

    <div class="fake-header">
        <div class="kanban__btn">
            <button>Fake btn</button>
        </div>
    </div>

    <main>
        @if($viewMode === 'overview')
            <div class="categories">
                @foreach(\App\Models\Category::orderBy('order')->get() as $category)
                    @livewire('task.category', ['category' => $category, 'viewMode' => $viewMode], key($category->id))
                @endforeach
            </div>
        @else
            <div class="categories">
                @foreach(\App\Enums\TaskStatus::cases() as $status)
                    @livewire('task.category', [
                        'status' => $status->value,
                        'viewMode' => $viewMode,
                        'category' => null,
                    ], key('status-'.$status->value))
                @endforeach
            </div>
        @endif
    </main>

</div>
