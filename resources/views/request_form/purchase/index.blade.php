@extends('layouts.bt4.app')
@section('title', 'Formulario de requerimiento')
@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />
<h4 class="mb-3">Formularios de Requerimiento - Bandeja de Entrada Abastecimiento</h4>

@include('request_form.partials.nav')

</div>

<div class="col-sm">
    @livewire('request-form.search-requests', [
      'inbox' => 'purchase'])
</div>

{{-- 
@if(!$my_request_forms->isEmpty())
</div>
<div class="col">
    <div class="table-responsive">
        <h6><i class="fas fa-inbox"></i> Mis Formularios asignados</h6>
        <table class="table table-sm table-hover table-bordered small">
            <thead>
                <tr class="text-center">
                    <th>ID</th>
                    <th>Folio</th>
                    <th style="width: 7%">Fecha Creación</th>
                    <th>Tipo / Mecanismo de Compra</th>
                    <th>Descripción</th>
                    <th>Usuario Gestor</th>
                    <th>Items</th>
                    <th>Presupuesto</th>
                    <th>Vencimiento</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($my_request_forms as $requestForm)
                <tr>
                    <td>{{ $requestForm->id }} <br>
                        @if($requestForm->purchasingProcess)
                        <span class="badge badge-{{$requestForm->purchasingProcess->getColor()}}">{{$requestForm->purchasingProcess->status->getlabel()}}</span>
                        @else
                        <span class="badge badge-warning">En proceso</span>
                        @endif
                    </td>
                    <td>{{ $requestForm->folio }}</td>
                    <td>
                        {{ $requestForm->created_at->format('d-m-Y H:i') }}<br>
                        {{ $requestForm->created_at->diffForHumans() }}
                    </td>
                    <td>{{ ($requestForm->purchaseMechanism) ? $requestForm->purchaseMechanism->PurchaseMechanismValue : '' }}<br>
                        {{ $requestForm->SubtypeValue }}
                    </td>
                    <td>{{ $requestForm->name }}</td>
                    <td>{{ $requestForm->user ? $requestForm->user->fullName : 'Usuario eliminado' }}<br>
                        {{ $requestForm->user ? $requestForm->userOrganizationalUnit->name : 'Usuario eliminado' }}
                    </td>
                    <td>{{ $requestForm->quantityOfItems() }}</td>
                    <td class="text-right">{{$requestForm->symbol_currency}}{{ number_format($requestForm->estimated_expense,$requestForm->precision_currency,",",".") }}</td>
                    <td title="Aprobación: {{$requestForm->approved_at ? $requestForm->approved_at->format('d-m-Y H:i') : ''}}" >
                        {{ $requestForm->expireAt }}
                        <div style="font-weight: bold">{{' (' . $requestForm->daysToExpire . ' días)' }}</div>
                    </td>
                    <td>
                        @if($requestForm->signatures_file_id)
                        <a class="btn btn-info btn-sm" title="Ver Formulario de Requerimiento firmado" href="{{ $requestForm->signatures_file_id == 11 ? route('request_forms.show_file', $requestForm->requestFormFiles->last() ?? 0) : route('request_forms.signedRequestFormPDF', [$requestForm, 1]) }}" target="_blank" title="Certificado">
                            <i class="fas fa-file-contract"></i>
                        </a>
                        @endif

                        @if($requestForm->old_signatures_file_id)
                        <a class="btn btn-secondary btn-sm" title="Ver Formulario de Requerimiento Anterior firmado" href="{{ $requestForm->old_signatures_file_id == 11 ? route('request_forms.show_file', $requestForm->requestFormFiles->last() ?? 0) : route('request_forms.signedRequestFormPDF', [$requestForm, 0]) }}" target="_blank" title="Certificado">
                            <i class="fas fa-file-contract"></i>
                        </a>
                        @endif

                        @if($requestForm->signedOldRequestForms->isNotEmpty())
                        <a class="btn btn-secondary btn-sm" title="Ver Formulario de Requerimiento Anteriores firmados" href="{{ $requestForm->old_signatures_file_id == 11 ? route('request_forms.show_file', $requestForm->requestFormFiles->last() ?? 0) : route('request_forms.signedRequestFormPDF', [$requestForm, 0]) }}" target="_blank" data-toggle="modal" data-target="#history-fr-{{$requestForm->id}}">
                        <i class="fas fa-file-contract"></i>
                        </a>
                        @include('request_form.partials.modals.old_signed_request_forms')
                        @endif

                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="">
                            <a href="{{ route('request_forms.supply.purchase', $requestForm) }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-shopping-cart"></i></a>
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{$my_request_forms->appends(Request::input())->links()}}
</div>
@else
<h6><i class="fas fa-inbox"></i> Mis Formularios asignados</h6>
<div class="card">
    <div class="card-body">
        No hay formularios de requerimiento para mostrar.
    </div>
</div>
@endif

@if(!$request_forms->isEmpty())
</div>
<div class="col">
    <div class="table-responsive">
        <h6><i class="fas fa-inbox"></i>Todos los formularios</h6>
        <table class="table table-sm table-hover table-bordered small">
            <thead>
                <tr class="text-center">
                    <th>ID</th>
                    <th>Folio</th>
                    <th>Tipo / Mecanismo de Compra</th>
                    <th>Descripción</th>
                    <th>Usuario Gestor</th>
                    <th>Comprador a cargo</th>
                    <th>Items</th>
                    <th>Presupuesto</th>
                    <th>Espera</th>
                    <th>Vencimiento</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($request_forms as $requestForm)
                <tr>
                    <td>{{ $requestForm->id }} <br>
                        @if($requestForm->purchasingProcess)
                        <span class="badge badge-{{$requestForm->purchasingProcess->getColor()}}">{{$requestForm->purchasingProcess->status->getLabel()}}</span>
                        @else
                        <span class="badge badge-warning">En proceso</span>
                        @endif
                    </td>
                    <td>{{ $requestForm->folio }}</td>
                    <td>{{ ($requestForm->purchaseMechanism) ? $requestForm->purchaseMechanism->PurchaseMechanismValue : '' }}<br>
                        {{ $requestForm->SubtypeValue }}
                    </td>
                    <td>{{ $requestForm->name }}</td>
                    <td>{{ $requestForm->user ? $requestForm->user->fullName : 'Usuario eliminado' }}<br>
                        {{ $requestForm->user ? $requestForm->userOrganizationalUnit->name : 'Usuario eliminado' }}
                    </td>
                    <td>@foreach($requestForm->purchasers as $purchaser) {{ $purchaser->fullName }} <br> @endforeach</td>
                    <td>{{ $requestForm->quantityOfItems() }}</td>
                    <td class="text-right">{{$requestForm->symbol_currency}}{{ number_format($requestForm->estimated_expense,$requestForm->precision_currency,",",".") }}</td>
                    <td>{{ $requestForm->created_at->diffForHumans() }}</td>
                    <td title="Aprobación: {{$requestForm->approved_at ? $requestForm->approved_at->format('d-m-Y H:i') : ''}}"">
                        {{ $requestForm->expireAt }}
                        <div style="font-weight: bold">{{' (' . $requestForm->daysToExpire . ' días)' }}</div>
                    </td>

                    <td>
                        @if($requestForm->iAmPurchaser())
                        @if($requestForm->signatures_file_id)
                        <a class="btn btn-info btn-sm" title="Ver Formulario de Requerimiento firmado" href="{{ $requestForm->signatures_file_id == 11 ? route('request_forms.show_file', $requestForm->requestFormFiles->last() ?? 0) : route('request_forms.signedRequestFormPDF', [$requestForm, 1]) }}" target="_blank" title="Certificado">
                            <i class="fas fa-file-contract"></i>
                        </a>
                        @endif

                        @if($requestForm->old_signatures_file_id)
                        <a class="btn btn-secondary btn-sm" title="Ver Formulario de Requerimiento Anterior firmado" href="{{ $requestForm->old_signatures_file_id == 11 ? route('request_forms.show_file', $requestForm->requestFormFiles->last() ?? 0) : route('request_forms.signedRequestFormPDF', [$requestForm, 0]) }}" target="_blank" title="Certificado">
                            <i class="fas fa-file-contract"></i>
                        </a>
                        @endif
                        
                        @if($requestForm->signedOldRequestForms->isNotEmpty())
                        <a class="btn btn-secondary btn-sm" title="Ver Formulario de Requerimiento Anteriores firmados" href="{{ $requestForm->old_signatures_file_id == 11 ? route('request_forms.show_file', $requestForm->requestFormFiles->last() ?? 0) : route('request_forms.signedRequestFormPDF', [$requestForm, 0]) }}" target="_blank" data-toggle="modal" data-target="#history-fr-{{$requestForm->id}}">
                        <i class="fas fa-file-contract"></i>
                        </a>
                        @include('request_form.partials.modals.old_signed_request_forms')
                        @endif
                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="">
                            <a href="{{ route('request_forms.supply.purchase', $requestForm) }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-shopping-cart"></i></a>
                        </span>
                        @endif

                        @if(App\Models\Rrhh\Authority::getAmIAuthorityFromOu(Carbon\Carbon::now(), 'manager', auth()->user()->id) ||
                        auth()->user()->hasPermissionTo('Request Forms: boss'))

                        @if($requestForm->signatures_file_id)
                        <a class="btn btn-info btn-sm" title="Ver Formulario de Requerimiento firmado" href="{{ $requestForm->signatures_file_id == 11 ? route('request_forms.show_file', $requestForm->requestFormFiles->last() ?? 0) : route('request_forms.signedRequestFormPDF', [$requestForm, 1]) }}" target="_blank" title="Certificado">
                            <i class="fas fa-file-contract"></i>
                        </a>
                        @endif

                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="">
                            <a href="{{ route('request_forms.supply.purchase', $requestForm) }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-shopping-cart"></i></a>
                        </span>

                        @endif


                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{$request_forms->appends(Request::input())->links()}}
</div>
@else
<h6><i class="fas fa-inbox"></i> Formularios asignados</h6>
<div class="card">
    <div class="card-body">
        No hay formularios de requerimiento para mostrar.
    </div>
</div>
@endif
--}}

@endsection

@section('custom_js')

@endsection

@section('custom_js_head')

@endsection
