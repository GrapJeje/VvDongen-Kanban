<div class="category">
    <div class="category__container">
        <h2 class="category__title">{{ $category->name }}</h2>

        <div class="category__tasks">
            @foreach($category->tasks as $task)
                @livewire('task.card', ['task' => $task], key($task->id))
            @endforeach
        </div>
    </div>
</div>
