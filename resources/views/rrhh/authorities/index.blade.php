@extends('layouts.app')

@section('title', 'Autoridades')

@section('content')

<style media="screen">
    .dia_calendario {
        display: inline-block;
        border: solid 1px rgb(0, 0, 0, 0.125);
        border-radius: 0.25rem;
        width: 13.9%;
        /* width: 154px; */
        text-align: center;
        margin-bottom: 5px;
    }
</style>

<h3 class="mb-3">Autoridades</h3>

@foreach($ouTopLevels as $ouTopLevel)

    @if($authorities AND $calendar AND ($ouTopLevel->establishment_id == $ou->establishment_id))
        <div class="row">

            <div class="col-12">

                <h4>{{ $ou->name }} <span class="small"> ({{ $ouTopLevel->establishment->name }}) </span></h4>

                @foreach($calendar as $item)
                    <div class="dia_calendario small p-2 text-center" {!! ($today->format('Y-m-d') == $item['date'])?'style="border: 2px solid black;"':'' !!}>

                        {{ $item['date'] }}

                        @if($item['manager'])
                            <hr class="mt-1 mb-1" >
                            @can('Authorities: edit') <a href="{{ route('rrhh.authorities.edit', $item['manager']->id) }}"> @endcan
                            {{ optional($item['manager']->user)->fullName }} <br>
                            @can('Authorities: edit') </a> @endcan
                            <em class="text-muted">{{ $item['manager']->position }}</em><br>
                        @endif
                        @if($item['delegate'])
                            <hr class="mt-1 mb-1" >
                            @can('Authorities: edit') <a href="{{ route('rrhh.authorities.edit', $item['delegate']->id) }}"> @endcan
                            {{ $item['delegate']->user->fullName }} <br>
                            @can('Authorities: edit') </a> @endcan
                            <em class="text-muted">{{ $item['delegate']->position }}</em><br>
                        @endif
                        @if($item['secretary'])
                            <hr class="mt-1 mb-1" >
                            @can('Authorities: edit') <a href="{{ route('rrhh.authorities.edit', $item['secretary']->id) }}"> @endcan
                            {{ $item['secretary']->user->fullName }} <br>
                            @can('Authorities: edit') </a> @endcan
                            <em class="text-muted">{{ $item['secretary']->position }}</em> <br>
                        @endif

                    </div>
                @endforeach
            </div>

        </div>

        @can('Authorities: create')
        <div class="row mt-3 mb-3">
            <div class="col-7">
                <h4>{{ $ou->name }}</h4>
            </div>
            <div class="col-1">
                @if($ouTopLevel->establishment_id == Auth::user()->organizationalUnit->establishment->id)
                <a href="{{ route('rrhh.authorities.create') }}?establishment_id={{$ouTopLevel->establishment_id}}&ou_id={{$ou->id}}" class="btn btn-primary">
                    Crear
                </a>
                @endif
            </div>
            <div class="col-4">
                <form method="GET" class="form-inline" action="{{ route('rrhh.authorities.index') }}?">

                    <input type="hidden" name="ou" value="{{ $ou->id }}">

                    <div class="form-group mx-sm-3">
                        <label for="for_date" class="sr-only">Fecha</label>
                        <input type="date" class="form-control" id="for_date" name="date"
                            value="{{$today->format('Y-m-d')}}" required >
                    </div>
                    <button type="submit" class="btn btn-outline-primary">Buscar</button>
                </form>
            </div>
        </div>
        @endcan

        <div class="row">
            
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Funcionario</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th>Cargo</th>
                            <th>Creación</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($authorities as $authority)
                        <tr class="small">
                            <td>{{ optional($authority->user)->fullName }} {{ trashed($authority->user) }}</td>
                            <td nowrap>{{ $authority->from->format('d-m-Y') }}</td>
                            <td nowrap>{{ ($authority->to) ? $authority->to->format('d-m-Y') : '' }}</td>
                            <td>{{ $authority->position }}</td>
                            <td>
                                {{ $authority->created_at->format('Y-m-d H:i') }}<br>
                                <small>{{ $authority->creator->fullName }}</small>
                            </td>
                            <th>
                                @can('Authorities: edit')
                                <a href="{{ route('rrhh.authorities.edit', $authority->id) }}" class="btn btn-outline-secondary btn-sm">
                                    <span class="fas fa-edit" aria-hidden="true"></span></a>
                                @endcan
                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    @endif

    <h4 class="mb-3">{{ $ouTopLevel->establishment->name }}</h4>

    <div class="row">
        <div class="col-12">
            <b>+</b> <a href="{{ route('rrhh.authorities.index') }}?ou={{$ouTopLevel->id}}">{{ $ouTopLevel->name }}</a>
            <ul>
            @foreach($ouTopLevel->childs as $child_level_1)
                <li><a href="{{ route('rrhh.authorities.index') }}?ou={{$child_level_1->id}}"> {{$child_level_1->name}} </a></li>
                <ul>
                    @foreach($child_level_1->childs as $child_level_2)
                        <li><a href="{{ route('rrhh.authorities.index') }}?ou={{$child_level_2->id}}">{{ $child_level_2->name }}</a></li>
                            <ul>
                                @foreach($child_level_2->childs as $child_level_3)
                                    <li><a href="{{ route('rrhh.authorities.index') }}?ou={{$child_level_3->id}}">{{ $child_level_3->name }}</a></li>
                                    @foreach($child_level_3->childs as $child_level_4)
                                    <ul>
                                    <li><a href="{{ route('rrhh.authorities.index') }}?ou={{$child_level_4->id}}">{{ $child_level_4->name }}</a></li>
                                    </ul>
                                    @endforeach
                                @endforeach
                            </ul>
                    @endforeach
                </ul>
            @endforeach
            </ul>
        </div>

    </div>

@endforeach

@endsection

@section('custom_js')

@endsection
