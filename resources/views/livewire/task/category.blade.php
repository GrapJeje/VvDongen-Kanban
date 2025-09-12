@if($viewMode === 'overview')
    <div
        class="category"
        x-data="{ id: {{ $category->id }} }"
        draggable="true"
        @dragstart="dragSrcEl = $el; $el.classList.add('dragging')"
        @dragend="$el.classList.remove('dragging')"
        @dragover.prevent
        @drop="
                if(dragSrcEl !== $el){
                    $wire.call('reorderCategory', dragSrcEl.dataset.id, $el.dataset.id)
                }
            "
        data-id="{{ $category->id }}"
    >
        @else
            <div class="category">
                @endif
                <div class="category__container">
                    @if($viewMode === 'overview')
                        <h2 class="category__title">{{ $category->name }}</h2>
                    @else
                        <h2 class="category__title">{{ ucfirst($status->value ?? $status) }}</h2>
                    @endif

                        <div class="category__tasks"
                             @dragover.prevent
                             @drop="dragSrcEl && $wire.call('moveTask', dragSrcEl.dataset.id, $el.dataset.id, {{ $category->id ?? 'null' }})">
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
