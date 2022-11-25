<div>
    <ul class="nav justify-content-end">
        <li class="nav-item">
            <a
                class="nav-link {{ ($user->id == auth()->id()) ? 'disabled' : '' }}"
                href="{{ route('requirements.inbox', auth()->user()) }}"
            >
                {{ auth()->user()->tinnyName }}
            </a>
        </li>
        @foreach($allowed_users as $allowed)
        <li class="nav-item">
            <a
                class="nav-link {{ ($user->id == $allowed->id) ? 'disabled' : '' }}"
                href="{{ route('requirements.inbox', $allowed) }}"
            >
                {{ $allowed->tinnyName }}
            </a>
        </li>
        @endforeach
    </ul>

    <fieldset class="form-row">
        <div class="col mb-2">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        Fecha Inicio
                    </span>
                </div>
                <input
                    type="date"
                    wire:model.debounce.600ms="start"
                    class="form-control"
                >
            </div>
        </div>
        <div class="col">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        Fecha Fin
                    </span>
                </div>
                <input
                    type="date"
                    wire:model.debounce.600ms="end"
                    class="form-control"
                >
            </div>
        </div>
    </fieldset>

    <div class="input-group">
        <input
            type="number"
            wire:model.debounce.600ms="req_id"
            class="form-control"
            placeholder="N°"
        >
        <input
            type="text"
            wire:model.debounce.600ms="subject"
            class="form-control"
            placeholder="Asunto"
        >
        <select wire:model.debounce.600ms="category" class="form-control">
            <option>Todos</option>
            @foreach(auth()->user()->reqCategories->pluck('name') as $category)
                <option>{{ $category }}</option>
            @endforeach
        </select>
        <select wire:model.debounce.600ms="status" class="form-control">
            @foreach($statuses as $statusItem)
                <option value="{{ $statusItem }}">{{ $statusItem }}</option>
            @endforeach
        </select>
        <input
            type="text"
            wire:model.debounce.600ms="user_involved"
            class="form-control"
            placeholder="Usuario involucrado"
        >
        <input
            type="text"
            wire:model.debounce.600ms="parte"
            class="form-control"
            placeholder="Origen, N°Origen"
        >
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" wire:click="getRequirements">
                <i class="fas fa-search" aria-hidden="true"></i>
            </button>
        </div>
    </div>

    <h4 class="my-2">Resultado de la búsqueda</h4>

    <table class="table table-sm table-bordered small">
        <thead>
            <tr>
                <th>N°</th>
                <th>Asunto</th>
                <th width="160">Creado</th>
                <th width="160">Ultimo evento</th>
                <th width="100">Fecha límite</th>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <tr
                class="d-none"
                wire:loading.class.remove="d-none"
                wire:target="getRequirements, start, end, req_id, subject, category, status, user_involved, parte"
            >
                <td class="text-center" colspan="6">
                    @include('layouts.partials.spinner')
                </td>
            </tr>
            @forelse($requirements as $req)

                <tr
                    @switch($req->status)
                        @case('creado')
                            class="alert-light" @break
                        @case('respondido')
                            class="alert-warning" @break
                        @case('cerrado')
                            class="alert-success" @break
                        @case('derivado')
                            class="alert-primary" @break
                        @case('reabierto')
                            class="alert-light" @break
                    @endswitch
                    wire:loading.remove
                    wire:target="getRequirements, start, end, req_id, subject, category, status, user_involved, parte"
                >
                @php
                $copia = $req->isCopy($user) ? 'alert-secondary' : '';
                @endphp

                    <td class="{{ $copia }} text-center">
                        {{ $req->id }}
                        {{ $req->status }}
                        {{-- @json($req->isCopy($user)) --}}
                        <br>
                        <a
                            href="{{ route('requirements.show', $req->id) }}"
                            class="btn btn-sm {{ $req->unreadedEvents ? 'btn-success' : 'btn-outline-primary' }}"
                        >
                            @if($req->unreadedEvents)
                                <i class="fas fa-eye"></i>
                                <span class='badge badge-secondary'>
                                    {{ $req->unreadedEvents  }}
                                </span>
                            @else
                                <i class="fas fa-edit"></i>
                            @endif
                        </a>
                    </td>

                    <td class="{{ $copia }}">
                        {{ $req->subject }}
                        <br>
                        @foreach($req->categories->where('user_id', auth()->id()) as $category)
                            <span
                                class='badge badge-primary'
                                style='background-color: #{{ $category->color }};'
                            >
                                {{$category->name}}
                            </span>
                        @endforeach

                        @if($req->parte)
                            <div>
                                <small>
                                    Parte: <b>{{ $req->parte->origin}} - {{$req->parte->number}}</b>
                                </small>
                            </div>
                        @endif
                    </td>

                    <td class="{{ $copia }}">
                        <b>Creado por</b>
                        <br>
                        {{ $req->events->first()->from_user->tinnyName }}<br>
                        {{ $req->created_at->format('Y-m-d H:i') }}<br>
                        {{ $req->created_at->diffForHumans() }}<br>
                    </td>

                    <td>
                        @switch($req->status)
                            @case('creado')
                            @break

                            @case('cerrado')
                            <b>Cerrado por</b><br>
                            {{ $req->events->last()->from_user->tinnyName }}<br>
                            {{ $req->events->last()->created_at->format('Y-m-d H:i') }}<br>
                            @break

                            @case('respondido')
                            @case('reabierto')
                            <b>{{ ucfirst($req->status) }} por</b><br>
                            {{ $req->events->last()->from_user->tinnyName }}<br>
                            {{ $req->events->last()->created_at->format('Y-m-d H:i') }}<br>
                            <b>para </b>{{ $req->events->last()->to_user->tinnyName }}
                            @break


                            @case('derivado')
                            <b>{{ ucfirst($req->status) }} para</b><br>
                            {{ $req->events->last()->to_user->tinnyName }}<br>
                            {{ $req->events->last()->created_at->format('Y-m-d H:i') }}<br>
                            <b>de </b>{{ $req->events->last()->from_user->tinnyName }}
                            @break
                        @endswitch
                    </td>

                    <td class="{{ $copia }}">
                        @if($req->limit_at)

                            <div class="text-danger">
                                <i class="fas fa-fw fa-chess-king"></i>
                                {{ $req->limit_at->format('Y-m-d') }}
                            </div>

                            @if($req->events->whereNotNull('limit_at')->where('status', '!=', 'en copia')->count() >= 1)
                                @foreach($req->events->whereNotNull('limit_at')->where('status', '!=', 'en copia') as $event)
                                    <div class="{{ now() >= $event->limit_at ? 'text-danger' : '' }}">
                                        <i class="fas fa-fw fa-chess-pawn"></i>
                                        {{ $event->limit_at->format('Y-m-d') }}
                                    </div>
                                @endforeach
                            @endif

                        @endif

                    </td>

                    <td class="{{ $copia }}">
                        @if($req->archived->where('user_id',auth()->id())->isEmpty())
                        <a
                            href="{{ route('requirements.archive_requirement',$req) }}"
                            title="Archivar" class="btn btn-sm btn-outline-primary"
                        >
                            <i class="fas fa-box"></i>
                        </a>
                        @else
                        <a
                            href="{{ route('requirements.archive_requirement_delete', $req) }}"
                            title="Desarchivar"
                            class="btn btn-sm btn-outline-secondary"
                        >
                            <i class="fas fa-box-open"></i>
                        </a>
                        @endif
                    </td>
                </tr>
            @empty
            <tr
                wire:loading.remove
                wire:target="getRequirements, start, end, req_id, subject, category, status, user_involved, parte"
            >
                <td class="text-center" colspan="6">
                    <em class="text-danger text-center">
                        <h6>
                            Que penita, no se han encontrado resultados.
                        </h6>
                    </em>
                </td>
            </tr>
            @endforelse
        </tbody>
        <caption>
            Total de resultados: {{ $requirements->total() }}
        </caption>
    </table>

    {{ $requirements->links() }}

</div>
