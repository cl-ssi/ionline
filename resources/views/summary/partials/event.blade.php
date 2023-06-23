<div class="card">
    <div class="card-header">
        <h5 class="card-title">{{ $event->event->name }}</h5>
        <h6 class="card-subtitle mb-2 text-muted">
            {{ $event->start_date }} -
            @if ($event->end_date)
                {{ $event->end_date }} - {{ $event->end_date->diffInDays($event->start_date) }} dias
            @else
                12 días hasta ahora
            @endif
        </h6>
    </div>
    <div class="card-body">

        @if ($event->end_date)
            <p class="card-text">
                {{ $event->body }}
            </p>

            @if ($event->event->user)
                <span class="fas fa-user"></span> Alvaro Torres Fuchslohcer (reemplasar por ShortName)
            @endif
        @else
            <textarea class="form-control mb-3">{{ $event->body }}</textarea>

            @livewire('search-select-user', ['selected_id' => 'user_id'])

            <hr>

            <div class="float-right">
                <button class="btn btn-outline-primary" type="button">Guardar</button>
                <button class="btn btn-primary " type="button">Guardar y Finalizar</button>
            </div>
        @endif


        <blockquote class="blockquote mb-0 mt-3">
            <footer class="blockquote-footer">{{ $event->creator->ShortName ?? '' }}</cite></footer>
        </blockquote>
    </div>
    @if ($event->event->file)
        <div class="card-footer text-muted">
            <li>
                <a href=""><i class="fas fa-paperclip"></i> nombre del archivo 1</a>
            </li>
            <li>
                <a href=""><i class="fas fa-paperclip"></i> nombre del archivo 2</a>
            </li>
        </div>
    @endif
</div>
