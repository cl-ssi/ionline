<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">
            {{ $event->type->name }}
        </h5>

        @if ($event->end_date)
            <!-- Cuando el evento está terminado -->
            <p class="card-text">
                {{ $event->body }}
            </p>

            @if ($event->type->require_user)
                <span class="fas fa-user"></span> {{ $event->user->shortName}}
            @endif
        @else
            <!-- Cuando el evento está abierto -->
            <form method="post" action="{{ route('summary.event.update', [$event->summary,$event]) }}">
                @csrf
                @method('PUT')

                <textarea class="form-control mb-3" name="body">{{ $event->body }}</textarea>
                
                @if ($event->type->require_user)
                    @if($event->user_id)
                        @livewire('search-select-user', ['selected_id' => 'user_id', 'user' => $event->user])
                    @else
                        @livewire('search-select-user', ['selected_id' => 'user_id'])
                    @endif
                @endif
                
                <hr>
                
                <div class="float-right">
                    <button type="submit" name="save" class="btn btn-outline-primary" value="save">Guardar</button>
                    <button type="submit" name="save" class="btn btn-primary " value="save&close">Guardar y Finalizar</button>
                </div>
            </form>
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
    @if ($event->type->require_file)
        <div class="card-footer text-muted">
            <div class="row">

                <div class="col">
                    <li>
                        <a href=""><i class="fas fa-paperclip"></i> nombre del archivo 1</a>
                </li>
                <li>
                    <a href=""><i class="fas fa-paperclip"></i> nombre del archivo 2</a>
                </li>
            </div>
            <div class="col">
                @if (is_null($event->end_date))
                <!-- Si el evento no está terminado mostramos el input de archivos -->
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04">
                            <label class="custom-file-label" for="customFileLangHTML" data-browse="Examinar">Seleccione un archivo</label>
                        </div>
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary" type="button" id="attache">
                                <i class="fas fa-arrow-up"></i> Adjuntar
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
