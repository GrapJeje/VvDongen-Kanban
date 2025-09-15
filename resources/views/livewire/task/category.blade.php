<div
    class="category"
    x-data="{ id: {{ $category->id ?? 'null' }} }"
    draggable="{{ $viewMode === 'overview' ? 'true' : 'false' }}"
    @dragstart="if($el.draggable){ $event.dataTransfer.setData('categoryId', id); $el.classList.add('dragging') }"
    @dragend="$el.classList.remove('dragging')"
    @dragover.prevent="$el.classList.add('hover')"
    @dragleave="$el.classList.remove('hover')"
    @drop="
        $el.classList.remove('hover');
        Livewire.dispatch('taskMoved', [
            $event.dataTransfer.getData('taskId'),
            null,
            {{ $category->id ?? 'null' }}
        ]);
    "
    data-id="{{ $category->id ?? 'null' }}"
>
    <div class="category__container">
        <h2 class="category__title">
            {{ $viewMode === 'overview' ? $category->name : ucfirst($status->value ?? $status) }}
        </h2>

        <div class="category__tasks dropzone"
             @dragover.prevent="$el.classList.add('hover')"
             @dragleave="$el.classList.remove('hover')"
             @drop="
                 $el.classList.remove('hover');
                 $wire.call('moveTask', $event.dataTransfer.getData('taskId'), null, {{ $category->id ?? 'null' }});
             ">
            @foreach($tasks as $task)
                @livewire('task.card', ['task' => $task, 'viewMode' => $viewMode], key('task-'.$task->id))
            @endforeach
        </div>
    </div>
</div>
