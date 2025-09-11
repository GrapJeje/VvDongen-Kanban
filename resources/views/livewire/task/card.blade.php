<div class="task-card">
    <h3 class="task-card__title">{{ $card->title }}</h3>

    @if($card->person)
        <p class="task-card__person">Assigned to: {{ $card->person }}</p>
    @endif

    <p class="task-card__status {{ $card->status }}">{{ ucfirst($card->status) }}</p>

    <div class="task-card__timestamps">
        <small>Created: {{ $card->created_at->format('d/m/Y') }}</small>
        <small>Updated: {{ $card->updated_at->format('d/m/Y') }}</small>
    </div>
</div>
