<div class="task-card"
     draggable="true"
     x-data="{ id: {{ $card->id }} }"
     @dragstart="$event.dataTransfer.setData('taskId', id); $el.classList.add('dragging')"
     @dragend="$el.classList.remove('dragging')"
     @dragover.prevent
     @drop="
        if($event.dataTransfer.getData('taskId') != id){
            Livewire.dispatch('taskMoved', [
                $event.dataTransfer.getData('taskId'),
                id,
                {{ $category->id ?? 'null' }}
            ]);
        }
     "
     data-id="{{ $card->id }}"
>
    <h3 class="task-card__title">{{ $card->title }}</h3>

    @if($card->person)
        <p class="task-card__person">{{ $card->person }}</p>
    @endif

    @if($viewMode === 'overview')
        <p class="task-card__status {{ $card->status }}">{{ ucfirst($card->status) }}</p>
    @endif

    <div class="task-card__timestamps">
        <small>Created: {{ $card->created_at->format('d/m/Y') }}</small>
        <small>Updated: {{ $card->updated_at->format('d/m/Y') }}</small>
    </div>
</div>
