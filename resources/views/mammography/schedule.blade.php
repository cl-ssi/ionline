@extends('layouts.bt4.app')

@section('title', 'Agenda')

@section('content')

@include('mammography.partials.nav')

<h3 class="mb-3">Agenda de Examenes</h3>

<form method="GET" class="form-horizontal" action="{{ route('mammography.schedule') }}">
    <div class="input-group mb-sm-4">
        <input class="form-control col-md-4" type="date" name="search" autocomplete="off" id="for_search" value="{{$request->search}}" required>
        <div class="input-group-append">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
        </div>
    </div>
</form>

@if($day)
  @foreach($day->slots as $slot)
    <div class="card">
        <div class="card-header">
            <i class="fas fa-clock"></i> {{ $slot->start_at->format('H:i:s') }} - <span class="badge bg-warning text-dark">Nº Cupos {{ $slot->available }}</span>
        </div>
        <div class="card-body">
            @foreach($mammograms as $mammography)

                @if($slot->start_at == $mammography->exam_date)

                  <div class="list-group">
                    <a class="list-group-item list-group-item-action">
                      <i class="fas fa-user"></i> {{ $mammography->runFormat }} - {{ $mammography->fullName() }} @if($mammography->telephone) | <i class="fas fa-phone-alt"></i> {{ $mammography->telephone }} @endif
                    </a>
                  </div>
                @endif
            @endforeach

        </div>
    </div>
  @endforeach
@endif

@endsection

@section('custom_js')
<script type="text/javascript">
    function clicked(user, dose) {
        return confirm('Desea registrar que se ha vacunado '+user+' para la '+dose+' dosis?');
    }
</script>
@endsection
