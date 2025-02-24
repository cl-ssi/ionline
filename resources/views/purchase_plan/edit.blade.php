@extends('layouts.bt5.app')

@section('title', 'Plan de Compras')

@section('content')

@include('purchase_plan.partials.nav')

<div class="row">
    <div class="col-md">
        <h4 class="mb-3"><i class="fas fa-plus"></i> Plan de Compra: </h4>
        {{-- <p>Incluye Planes de Compras de mi Unidad Organizacional: <b>{{ auth()->user()->organizationalUnit->name }}</p> --}}
    </div>
</div>

<br>

@livewire('purchase-plan.create-purchase-plan', [
    'action'                => 'edit',
    'purchasePlanToEdit'    => $purchasePlan
])

@if(auth()->user()->hasPermissionTo('Request Forms: audit'))
    <hr/>
    <h6><i class="fas fa-info-circle"></i> Auditoría Interna</h6>

    <div class="accordion" id="accordionExample">
        <div class="card">
            <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                            data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Formulario
                    </button>
                </h2>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                    data-parent="#accordionExample">
                <div class="card-body">
                    <h6 class="mt-3 mt-4">Historial de cambios</h6>
                    <div class="table-responsive-md">
                        <table class="table table-sm small text-muted mt-3">
                            <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Usuario</th>
                                <th>Evento</th>
                                <th>Modificaciones</th>
                            </tr>
                            </thead>
                            <tbody>
                                    @foreach($purchasePlan->audits->sortByDesc('updated_at') as $audit)
                                        <tr>
                                            <td nowrap>{{ $audit->created_at }}</td>
                                            <td nowrap>{{ optional($audit->user)->fullName }}</td>
                                            <td nowrap>{{ $audit->event }}</td>
                                            <td>
                                                @foreach($audit->getModified() as $attribute => $modified)
                                                    @if(isset($modified['old']) OR isset($modified['new']))
                                                        <strong>{{ $attribute }}</strong>
                                                        :  {{ isset($modified['old']) ? $modified['old'] : '' }}
                                                        => {{ $modified['new'] ?? '' }};
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection

@section('custom_js')

@endsection
