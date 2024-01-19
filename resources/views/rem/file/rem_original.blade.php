@extends('layouts.bt4.app')
@section('custom_css')
<style>
	.sticky-left {
    position: sticky;
    left: 0;
    z-index: 1;
    background-color: #fff; /* Cambia esto al color de fondo deseado */
}
</style>
@endsection
@section('content')
    @include('rem.nav')


    
<div class="filter-form">
    <h3>Carga de REMs</h3>
    <form method="get" action="{{ route('rem.files.rem_original') }}" class="form-inline">
        <div class="form-group mx-sm-3 mb-2">
            <label for="monthsToShow">Selecciona la cantidad de meses hacia atrás:</label>
            <input type="number" class="form-control" name="monthsToShow" id="monthsToShow" value="{{ $monthsToShow }}" min="1">
        </div>
        <button type="submit" class="btn btn-primary mb-2">Actualizar</button>
    </form>
</div>



    @if($monthsToShow > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-sm small">
                <thead>
                    <tr class="text-center">
                        <th class="sticky-left">Establecimiento/Período</th>
                        @foreach ($periods as $period)
                            <th>{{ $period->year ?? '' }}-{{ $period->month ?? '' }}</th>
                        @endforeach
                    </tr>
                    @foreach (auth()->user()->remEstablishments as $remEstablishment)
                        <tr>
                            <td class="text-center font-weight-bold sticky-left">
                                {{ $remEstablishment->establishment->official_name ?? '' }}
                                ({{ $remEstablishment->establishment->establishmentType->name ?? '' }})
                                ({{ $remEstablishment->establishment->new_deis_without_first_character ?? '' }})
                            </td>

                            @foreach ($periods as $period)
                                <td nowrap>
                                    @forelse($period->series as $serie)
                                        @if ($serie->type == $remEstablishment->establishment->type)
                                            <ul>
                                                Serie:{{ $serie->serie->name ?? '' }}
                                                <br>
                                                @livewire('rem.new-upload-rem', [
                                                    'period' => $period,
                                                    'serie' => $serie,
                                                    'remEstablishment' => $remEstablishment,
                                                    'rem_period_series' => $serie,
                                                    'type' => 'Original',
                                                    'monthsToShow' => $monthsToShow
                                                ])
                                            </ul>
                                        @endif
                                    @empty
                                        <h6>No Existen Series asociado a este periodo, Favor asociar Serie al periodo</h6>
                                    @endforelse
                                </td>
                            @endforeach
                        </tr>
                    @endforeach

                </thead>
            </table>
        </div>
    @endif

@endsection
