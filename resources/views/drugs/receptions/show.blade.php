@extends('layouts.app')

@section('title', 'Editar Recepción')

@section('content')

@include('drugs.nav')

<h3 class="mb-3">Recepción </h3>

<table class="table table-sm table-bordered">
    <tr>
        <th>N° Acta: </th>
        <td><a href="{{ route('drugs.receptions.show', $reception->id) }}">{{ $reception->id }}</a></td>

        <th>Fecha Acta</th>
        <td>{{ $reception->created_at->format('d-m-Y') }}</td>

        <td colspan="2">
            @can('Drugs: edit receptions')
                <a href="{{ route('drugs.receptions.edit', $reception->id) }}"> <i class="fas fa-edit"></i> Editar </a>
            @endcan
             |
            @if( $reception->haveItems() )
            <a href="{{ route('drugs.receptions.record', $reception->id) }}" target="_blank">  <i class="fas fa-file-pdf"></i> Acta</a>
            @endif
        </td>
    </tr>
    <tr>
        <th>N° Oficio</th>
        <td>{{ $reception->document_number }}</td>

        <th>Fecha Documento</th>
        <td>{{ $reception->document_date->format('d-m-Y') }}</td>

        <th>{{ $reception->parte_label }}</th>
        <td>{{ $reception->parte }}</td>
    </tr>

    <tr>
        <th>Funcionario que entrega</th>
        <td>{{ $reception->delivery }}</td>

        <th>Run</th>
        <td>{{ $reception->delivery_run }}</td>

        <th>Cargo</th>
        <td>{{ $reception->delivery_position }}</td>
    </tr>

    <tr>
        <th>Origen Parte</th>
        <td colspan="5">{{ $reception->partePoliceUnit->name }}</td>
    </tr>

    <tr>
        <th>Origen Oficio</th>
        <td colspan="5">{{ $reception->documentPoliceUnit->name }}</td>
    </tr>

    <tr>
        <th>Juzgado</th>
        <td colspan="5">{{ $reception->court->name }}</td>
    </tr>
    <tr>
        <th>Imputado</th>
        <td>{{ $reception->imputed }}</td>

        <th>Observación</th>
        <td colspan="4">{{ $reception->observation }}</td>
    </tr>
</table>


<table class="table table-sm table-bordered mt-3">
    <thead>
        <tr class="text-center">
            <th>Id</th>
            @if( ! $reception->wasDestructed() )
            <th></th>
            @endif
            <th class="text-left">Descripción</th>
            <th>Sustancia Presunta</th>
            <th>NUE</th>
            <th>N° Muestras</th>
            <th>Peso Oficio</th>
            <th>Peso Bruto</th>
            <th>Peso Neto</th>
            <th>Peso Muestra</th>
            <th>Peso C.Muestra</th>
            <th>Dest.</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($reception->items as $i)
        <tr class="text-center">
            <td>{{ $i->id }}</td>
            @if( ! $reception->wasDestructed() )
            <td>
                <form method="POST" class="form-horizontal" action="{{ route('drugs.receptions.destroy_item', $i->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </td>
            @endif
            <td class="text-left">{{ $i->description }}</td>
            <td>{{ $i->substance->name }}
                @if($i->result_number)
                    <small class="text-muted"><br>N° Doc: {{ $i->result_number }} ({{ $i->result_date->format('d-m-Y') }})</small>
                @endif
            </td>
            <td>{{ $i->nue }}</td>
            <td>{{ $i->sample_number }}</td>
            <td>{{ $i->document_weight }}</td>
            <td>{{ $i->gross_weight }}</td>
            <td>{{ $i->net_weight }}</td>
            <td>{{ $i->sample }}</td>
            <td>{{ $i->countersample }}</td>
            <td>{{ $i->destruct }}</td>
            <td>
                <a href="{{ route('drugs.receptions.edit_item', $i->id ) }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-edit"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


    @switch( request()->route()->getActionMethod() )
        @case('show')

            {{-- DESTRUCCIONES --}}
            @if( $reception->wasDestructed() )
                <div class="alert alert-warning" role="alert">
                    <a href="{{ route('drugs.destructions.show', $reception->destruction->id) }}"
                        class="btn btn-outline-secondary btn-sm" target="_blank">
                        <i class="fas fa-fw fa-file-pdf"></i>
                    </a>

                    Ya ha sido destruida con fecha
                    {{ $reception->destruction->destructed_at->format('d-m-Y') }}

                    @can('Drugs: delete destructions')
                        <form class="form-inline" style="display: inline-block;"
                            action="{{ route('drugs.destructions.destroy', $reception->destruction->id )}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                 <i class="fas fa-trash"></i> Eliminar destrucción
                             </button>
                        </form>
                    @endcan
                </div>
            @else
                @include('drugs.receptions.partials.add_item')

                @if( $reception->haveItemsForDestruction() )
                    @include('drugs.receptions.partials.create_destruction')
                @else
                    <div class="alert alert-warning mt-4" role="alert">
                        No hay items para destruir
                    </div>
                @endif
            @endif

            @include('drugs.receptions.partials.add_reservado_isp')

            @include('drugs.receptions.partials.add_record_to_court')

            @break

        @case('editItem')

            {{-- DESTRUCCIONES --}}
            @if( $reception->wasDestructed() )
                <div class="alert alert-warning" role="alert">
                    <a href="{{ route('drugs.destructions.show', $reception->destruction->id) }}"
                        class="btn btn-outline-secondary btn-sm" target="_blank">
                        <i class="fas fa-fw fa-file-pdf"></i>
                    </a>
                    Ya ha sido destruida con fecha
                    {{ $reception->destruction->destructed_at->format('d-m-Y') }}
                </div>
            @else
                @include('drugs.receptions.partials.edit_item')
            @endif



            {{-- AGREGAR RESULTADO DE ISP --}}
            @if($item->substance->laboratory == 'ISP')
                @can('Drugs: add results from ISP')
                    @include('drugs.receptions.partials.add_result')
                @endcan
            @endif



            {{-- AGREGAR RESULTADO DE ANALISIS LOCAL --}}
            @if($item->substance->laboratory == 'SEREMI')
                @can('Drugs: add protocols')
                    @include('drugs.receptions.partials.add_protocol')
                @endcan
            @endif



            @break
    @endswitch

@endsection

@section('custom_js')
<script type="text/javascript">
jQuery(function ($) {
    var $inputs = $('input[name=net_weight],input[name=estimated_net_weight]');
    $inputs.on('input', function () {
        // Set the required property of the other input to false if this input is not empty.
        $inputs.not(this).prop('required', !$(this).val().length);
    });
});
</script>
@endsection
