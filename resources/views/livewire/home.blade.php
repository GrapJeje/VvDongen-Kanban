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
                @foreach(\App\Models\Category::all() as $category)
                    @livewire('task.category', ['category' => $category], key($category->id))
                @endforeach
            </div>
        @else

        @endif
    </main>

</div>
