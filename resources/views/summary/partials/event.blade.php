<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">
            {{ $event->event->name }}
        </h5>

        @if ($event->end_date)
            <!-- Cuando el evento está terminado -->
            <p class="card-text">
                {{ $event->body }}
            </p>

            @if ($event->event->require_user)
                <span class="fas fa-user"></span> Alvaro Torres Fuchslohcer (reemplazar por shortName)
            @endif
        @else
            <!-- Cuando el evento está abierto -->
            <textarea class="form-control mb-3">{{ $event->body }}</textarea>

            @livewire('search-select-user', ['selected_id' => 'user_id'])

            <hr>

            <div class="float-right">
                <button class="btn btn-outline-primary" type="button">Guardar</button>
                <button class="btn btn-primary " type="button">Guardar y Finalizar</button>
            </div>
        @endif


        <blockquote class="blockquote mb-0 mt-3">
            <footer class="blockquote-footer">
                {{ $event->creator->shortName ?? '' }} -
                {{ $event->start_date }} -
                @if ($event->end_date)
                {{ $event->end_date }} - {{ $event->end_date->diffInDays($event->start_date) }} dias
                @else
                12 días hasta ahora
                @endif
            </footer>
        </blockquote>
    </div>
    @if ($event->event->require_file)
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
