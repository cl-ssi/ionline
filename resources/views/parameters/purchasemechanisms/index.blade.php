@extends('layouts.app')

@section('title', 'Mecanismo de Compra')

@section('content')

@include('parameters.nav')

<h3 class="mb-3">Mantenedor Mecanismo de Compra</h3>

<a class="btn btn-primary mb-3" href="{{ route('parameters.purchasemechanisms.create') }}">
    Crear
</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Mecanismo de Compra</th>
            <th>Tipo de Compra</th>
            <th>Días Hábiles</th>
            <th>Días Corridos</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($purchaseMechanisms as $purchaseMechanism)
        <tr>
            <td
            rowspan="{{ count($purchaseMechanism->purchaseTypes)==0?1:count($purchaseMechanism->purchaseTypes) }}"
            colspan="{{ count($purchaseMechanism->purchaseTypes)==0?4:1 }}"
            >{{ $purchaseMechanism->id }}</td>
            <td
            rowspan="{{ count($purchaseMechanism->purchaseTypes)==0?1:count($purchaseMechanism->purchaseTypes) }}"
            colspan="{{ count($purchaseMechanism->purchaseTypes)==0?4:1 }}"
            >{{ $purchaseMechanism->name }}</td>
            @foreach($purchaseMechanism->purchaseTypes as $key => $purchaseType)

              @if($key > 0 )
                <tr>
              @endif

                <td>{{ $purchaseType->name }}</td>
                <td>{{ $purchaseType->finance_business_day }}</td>
                <td>{{ $purchaseType->supply_continuous_day }}</td>

                @if($key == 0 )
                  <td rowspan="{{ count($purchaseMechanism->purchaseTypes)==0?1:count($purchaseMechanism->purchaseTypes) }}">
                  <a href="{{ route('parameters.purchasemechanisms.edit', $purchaseMechanism) }}"><i class="fas fa-edit"></i></a></td>
                @endif

              @if($key > 0 )
                </tr>
              @endif

            @endforeach

            @if(count($purchaseMechanism->purchaseTypes) == 0)
              <td><a href="{{ route('parameters.purchasemechanisms.edit', $purchaseMechanism) }}"><i class="fas fa-edit"></i></a></td>
            @endif

        </tr>
        @endforeach
    </tbody>
</table>


@endsection

@section('custom_js')

@endsection
