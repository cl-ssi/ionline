@foreach ($events as $event)
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">
                {{ $event->type->name }}
                <small class="text-muted">
                    {{ $event->type->description }}
                </small>
            </h5>

            @if ($event->end_date)
                <!-- Cuando el evento está terminado -->
                <p class="card-text">
                    <label for="for-body">Observaciones de este paso:</label><br>
                    {{ $event->body }}
                </p>

                @if ($event->type->require_user)
                    <span class="fas fa-user"></span> {{ $event->user->shortName }}
                @endif

                @if ($event->has('childs'))
                    @foreach ($event->childs as $event)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">
                                    {{ $event->type->name }}
                                    <small class="text-muted">
                                        {{ $event->type->description }}
                                    </small>
                                </h5>
                                <p class="card-text">
                                    <label for="for-body">Observaciones de este paso:</label><br>
                                    {{ $event->body }}
                                </p>

                                @if ($event->type->require_user)
                                    <span class="fas fa-user"></span> {{ $event->user->shortName }}
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            @else
                <!-- Cuando el evento está abierto -->
                <form method="post" action="{{ route('summary.event.update', [$event->summary, $event]) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="for-body">Observaciones de este paso: </label>
                        <textarea class="form-control mb-3" name="body">{{ $event->body }}</textarea>
                    </div>

                    @if ($event->type->require_user)
                        @if ($event->user_id)
                            @livewire('search-select-user', ['selected_id' => 'user_id', 'user' => $event->user])
                        @else
                            @livewire('search-select-user', ['selected_id' => 'user_id'])
                        @endif
                    @endif

                    <div class="float-right">
                        @if ($event->type->duration)
                            <button type="submit" name="save" class="btn btn-outline-primary"
                                value="save">Guardar</button>
                        @endif
                        <button type="submit" name="save" class="btn btn-primary " value="save&close">Guardar y
                            Finalizar</button>
                    </div>
                </form>

                <div class="clearfix mb-3"></div>

                @if ($event->childs()->exists())
                    @include('summary.partials.event', ['events' => $event->childs])
                @endif

                @if ($event->type->linksSubEvents()->exists() and !$event->type->sub_event)
                    @include('summary.partials.add_event', ['links' => $event->type->linksSubEvents])
                @endif

                @if ($event->type->templates()->exists())
                    <h6>Templates</h6>
                    @foreach ($event->type->templates as $template)
                        <li>
                            <a href="{{ route('summary.templates.show', [$summary, $template]) }}">
                                {{ $template->name }}
                            </a>
                        </li>
                    @endforeach
                @endif
            @endif



            <footer class="blockquote-footer">
                {{ $event->creator->shortName ?? '' }} -
                {{ $event->start_date }} -
                @if ($event->end_date)
                    {{ $event->end_date }} - {{ $event->end_date->diffInDays($event->start_date) }} dias
                @else
                    12 días hasta ahora
                @endif
            </footer>

        </div>
        @if ($event->type->require_file)
            <div class="card-footer text-muted">
                <div class="row">

                    <div class="col">
                        @foreach ($event->files as $file)
                            <li>
                                <a href="{{ route('summary.files.download', ['file' => $file->id]) }}"><i
                                        class="fas fa-paperclip"></i> {{ $file->name }}</a>
                            </li>
                        @endforeach
                    </div>
                    <div class="col">
                        @if (is_null($event->end_date))
                            <!-- Si el evento no está terminado mostramos el input de archivos -->
                            <form method="post" action="{{ route('summary.files.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="inputGroupFile04"
                                            aria-describedby="inputGroupFileAddon04" name="files[]">
                                        <label class="custom-file-label" for="customFileLangHTML"
                                            data-browse="Examinar">Seleccione un archivo</label>
                                    </div>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-primary" type="submit" id="attache">
                                            <i class="fas fa-arrow-up"></i> Adjuntar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
@endforeach
