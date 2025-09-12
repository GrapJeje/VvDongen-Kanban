<div class="category">
    <div class="category__container">
        @if($viewMode === 'overview')
            <h2 class="category__title">{{ $category->name }}</h2>
        @else
            <h2 class="category__title">{{ ucfirst($status->value ?? $status) }}</h2>
        @endif

        <div class="category__tasks">
            @if($viewMode === 'overview')
                @foreach($category->tasks as $task)
                    @livewire('task.card', ['task' => $task, 'viewMode' => $viewMode], key($task->id))
                @endforeach
            @else
                @foreach($tasks as $task)
                    @livewire('task.card', ['task' => $task, 'viewMode' => $viewMode], key($task['id']))
                @endforeach
            @endif
        </div>
    </div>
</div>
