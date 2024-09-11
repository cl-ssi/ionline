@foreach ($events as $event)
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">
                [{{ $event->type->actor->name }}]
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
                    <span class="fas fa-user"></span> {{ optional($event->user)->shortName }}
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
                            @if (!$event->end_date OR ($event->end_date AND $event->files()->exists()))
                            <div class="card-footer text-muted">
                                @foreach ($event->files as $file)
                                    <li>
                                        <a href="{{ route('summary.files.download', ['file' => $file->id]) }}"><i
                                            class="fas fa-paperclip"></i> {{ $file->name }}</a>
                                    </li>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    @endforeach
                @endif
            @else
                <!-- Cuando el evento está abierto -->

                @if ($event->childs()->exists())
                    @include('summary.partials.event', ['events' => $event->childs])
                @endif

                @if($event->type->linksSubEvents()->exists() AND !$event->type->sub_event)
                    @include('summary.partials.add_event', ['links' => $event->type->linksSubEvents, 'childs' => true])
                @endif

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

                    <div class="float-right mt-2">
                        @if ($event->type->duration)
                            <button type="submit" name="save" class="btn btn-outline-primary"
                                value="save">Guardar</button>
                        @endif
                        <button type="submit" name="save" class="btn btn-primary "
                            value="save&close">Guardar y Finalizar</button>
                    </div>
                </form>

                <div class="clearfix mb-2"></div>

                @if ($event->type->templates()->exists())
                    <h6>Plantillas</h6>
                    @foreach ($event->type->templates as $template)
                        <li>
                            <a target="_blank" href="{{ route('summary.templates.show', [$summary, $template]) }}">
                                {{ $template->name }}
                            </a>
                        </li>
                    @endforeach
                @endif
            @endif


            <blockquote class="blockquote mb-0 mt-3">
                <footer class="blockquote-footer">
                    {{ $event->creator->shortName ?? '' }} -
                    {{ $event->start_date }} -
                    @if ($event->end_date)
                        {{ $event->end_date }} - {{ (int) $event->end_date->diffInDays($event->start_date) }} dias
                    @else
                        Transcurridos {{ $event->type->daysPassed }} día(s) hábil(es)
                        @if(isset($event->type->totalDays))
                            de {{ $event->type->totalDays }} día(s) hábil(es)
                        @endif
                    @endif

                    <!-- <div class="progress mt-2">
                        <div
                            class="progress-bar @if($event->type->totalDays == $event->type->daysPassed) bg-danger @endif"
                            role="progressbar"
                            style="width: {{ $summary->lastEvent->type->progressPercentage }}%"
                            aria-valuenow="{{ $summary->lastEvent->type->progressPercentage }} %"
                            aria-valuemin="0"
                            aria-valuemax="100"
                        >
                        </div>
                    </div> -->
                </footer>
            </blockquote>

        </div>
        @if ($event->type->require_file)
            @if (!$event->end_date OR ($event->end_date AND $event->files()->exists()))
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
                                    <input type="hidden" class="form-control" name="event_id" value="{{$event->id}}">
                                    <div class="input-group">
                                        <input class="form-control" type="file" id="formFile" name="files[]">
                                        <button class="btn btn-outline-primary" type="submit" id="attache">
                                            <i class="fas fa-arrow-up"></i> Adjuntar
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
@endforeach
