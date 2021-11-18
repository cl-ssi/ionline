@extends('layouts.app')

@section('title', 'Autoridades')

@section('content')
@foreach($ouTopLevels as $ouTopLevel)
<h3 class="mb-3">Autoridades</h3>
<h4 class="mb-3">{{($ouTopLevel->establishment->name)}}</h4>
@can('Authorities: manager')
@if($ouTopLevel->establishment_id == Auth::user()->organizationalUnit->establishment->id)
<a href="{{ route('rrhh.authorities.create') }}?establishment_id={{$ouTopLevel->establishment_id}}" class="btn btn-primary">Crear Autoridad del {{($ouTopLevel->establishment->name)}}</a><br><br>
@endif
@endcan


<div class="row">

    <div class="col-md-5 small">
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


    <div class="col-7">

    @can('Authorities: manager')
    <form method="POST" class="form-inline" action="{{ route('rrhh.authorities.index') }}?ou=">
        @csrf
        @method('GET')
        @if($ou)
        <input type="hidden" name="ou" value="{{ $ou }}">
        @endif
        <div class="form-group mx-sm-3 mb-2">
            <label for="for_date" class="sr-only">Fecha</label>
            <input type="date" class="form-control" id="for_date" name="date"
                value="{{$today->format('Y-m-d')}}" required >
        </div>
        <button type="submit" class="btn btn-primary mb-2" disabled>Buscar</button>
    </form>
    @endcan


    @if($authorities AND $calendar AND ($ouTopLevel->establishment_id == $ou->establishment_id))
        @if($ou)
        <h3>{{ $ou->name }}</h3>
        @endif

        <style media="screen">
            .dia_calendario {
                display: inline-block;
                border: solid 1px rgb(0, 0, 0, 0.125);
                border-radius: 0.25rem;
                width: 13.6%;
                text-align: center;
                margin-bottom: 5px;
            }
        </style>
        @foreach($calendar as $item)
          @if($item['manager'])
            <div class="dia_calendario small p-2" {!! ($today->format('Y-m-d') == $item['date'])?'style="border: 2px solid black;"':'' !!}>
                <center>
                    {{ $item['date'] }}
                    @if($item['manager'])
                    <hr class="mt-1 mb-1" >
                    <a href="{{ route('rrhh.authorities.edit', $authorities[0]->id) }}">
                        {{ $item['manager']->user->fullName }} <br>
                    </a>
                    <!-- <hr class="mt-1 mb-1"> -->
                    <em class="text-muted">{{ $item['manager']->position }}</em><br>
                    @endif
                    @if($item['delegate'])
                    <hr class="mt-1 mb-1" >
                    <a href="{{ route('rrhh.authorities.edit', $authorities[0]->id) }}">
                        {{ $item['delegate']->user->fullName }} <br>
                    </a>
                    <!-- <hr class="mt-1 mb-1"> -->
                    <em class="text-muted">{{ $item['delegate']->position }}</em><br>
                    @endif
                    @if($item['secretary'])
                    <hr class="mt-1 mb-1" >
                    <a href="{{ route('rrhh.authorities.edit', $authorities[0]->id) }}">
                        {{ $item['secretary']->user->fullName }} <br>
                    </a>
                    <!-- <hr class="mt-1 mb-1"> -->
                    <em class="text-muted">{{ $item['secretary']->position }}</em> <br>
                    @endif
                </center>
            </div>
          @endif
        @endforeach


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
                    @if($authority)
                    @if($authority->user)
                    <tr class="small">
                        <td>{{ $authority->user->fullName }}</td>
                        <td nowrap>{{ $authority->from->format('d-m-Y') }}</td>
                        <td nowrap>{{ ($authority->to) ? $authority->to->format('d-m-Y') : '' }}</td>
                        <td>{{ $authority->position }}</td>
                        <td>
                            {{ $authority->created_at->format('Y-m-d H:i') }}<br>
                            <small>{{ $authority->creator->fullName }}</small>
                        </td>
                        <th>
                            @can('be god')
                            <a href="{{ route('rrhh.authorities.edit', $authority->id) }}" class="btn btn-outline-secondary btn-sm">
    					        <span class="fas fa-edit" aria-hidden="true"></span></a>
                            @endcan
                        </th>
                    </tr>
                    @endif
                    @endif
                @endforeach

            </tbody>
        </table>
    @endif


    </div>
</div>

@endforeach
@endsection

@section('custom_js')

@endsection
