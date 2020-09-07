@extends('layouts.app')

@section('title', 'Listado de Convenios')

@section('content')

@include('agreements/nav')

<h3 class="mb-3">Seguimiento de Convenios</h3>
    
    <table class="table table-striped  btn-table table-sm table-bordered table-condensed fixed_headers table-hover table-responsive"><!-- table-responsive -->
    <thead>
            <tr class="small">
              <th class="text-center table-light"  colspan="2">
              </th>
              <th class="text-center align-middle table-dark" colspan="12">CONVENIO</th>
              <th class="text-center align-middle table-light" colspan="12">RESOLUCIÓN</th>
              <th class="text-center align-middle table-light" colspan="2"></th>
            </tr>
            <tr class="small" style="font-size:70%;">
              <th class="text-center"></th>
              <th></th>
              <th></th>
              <th class="text-center">RTP</th>
              <th class="text-center" colspan="2">DAJ</th>
              <th class="text-center" colspan="2">DAP</th>
              <th class="text-center" colspan="2">DGF</th>
              <th class="text-center" colspan="2">SDGA</th>
              <th class="text-center" colspan="2">COMUNA</th>

              <th class="text-center" colspan="2">RTP</th>
              <th class="text-center" colspan="2">DAJ</th>
              <th class="text-center" colspan="2">DAP</th>
              <th class="text-center" colspan="2">DGF</th>
              <th class="text-center" colspan="2">SDGA</th>
              <th class="text-center" colspan="2">OF. PARTE</th>
              <th class="text-center" colspan="1">RES</th>

            </tr>
            <tr style="font-size:80%;" >
              <th class="text-center">#</th>
              <th style="width:300px">Nombre</th>
              <th>Comuna</th>
              <th class="text-center">Salida</th>
              <th class="text-center">Ingreso</th>
              <th class="text-center">Salida</th>
              <th class="text-center">Ingreso</th>
              <th class="text-center">Salida</th>
              <th class="text-center">Ingreso</th>
              <th class="text-center">Salida</th>
              <th class="text-center">Ingreso</th>
              <th class="text-center">Salida</th>
              <th class="text-center">Ingreso</th>
              <th class="text-center">Salida</th>

              <th class="text-center">Ingreso</th>
              <th class="text-center">Salida</th>
              <th class="text-center">Ingreso</th>
              <th class="text-center">Salida</th>
              <th class="text-center">Ingreso</th>
              <th class="text-center">Salida</th>
              <th class="text-center">Ingreso</th>
              <th class="text-center">Salida</th>
              <th class="text-center">Ingreso</th>
              <th class="text-center">Salida</th>
              <th class="text-center">Ingreso</th>
              <th class="text-center">Salida</th>
              <th class="text-center"></th>
            </tr>
        </thead>
        <tbody style="font-size:65%;">
            @foreach($agreements as $agreement)
            <tr>
            <th scope="row" class="text-center">
                <a href="{{ route('agreements.show', $agreement->id) }}" class="">{{ $agreement->id }}</a>
                </th>
              <td>{{ $agreement->program->name }}</td>
              <td>{{ $agreement->commune->name }}</td>
              <td><!-- RTP -->
                @php $flag = 0; @endphp
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'RTP' AND $stage->group == 'CON')
                           <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-primary" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">{{$stage->date->format('d-M')}}</button>
                                @php $flag = 1; @endphp
                        @endif
                @endforeach
                 @if ($flag==0)
                    <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-secondary" data-toggle="modal"
                        data-target="#addModalDateStage"
                        data-stage_id=""
                        data-agreement_id="{{ $agreement->id }}"
                        data-stage="RTP"
                        data-group="CON"
                        data-formaction="{{ route('agreements.stage.store', $agreement->id )}}">Agregar</button>
                @endif
              </td>
              <td><!-- DAJ IN -->
                @php $flag = 0; @endphp
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'DAJ' AND $stage->group == 'CON')
                           <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-primary" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">{{$stage->date->format('d-M')}}</button>
                                @php $flag = 1; @endphp
                        @endif
                @endforeach
                 @if ($flag==0)
                    <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-secondary" data-toggle="modal"
                        data-target="#addModalDateStage"
                        data-stage_id=""
                        data-agreement_id="{{ $agreement->id }}"
                        data-stage="DAJ"
                        data-group="CON"
                        data-formaction="{{ route('agreements.stage.store', $agreement->id )}}">Agregar</button>
                @endif
              </td>
              <td><!-- DAJ END -->
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'DAJ' AND $stage->group == 'CON')
                           <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-primary" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">
                                {{ $stage->dateEnd ? $stage->dateEnd->format('d-M') : null }}</button>
                        @endif
                @endforeach
            </td>
              <td><!-- DAP IN -->
                @php $flag = 0; @endphp
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'DAP' AND $stage->group == 'CON')
                           <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-primary" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">{{$stage->date->format('d-M')}}</button>
                                @php $flag = 1; @endphp
                        @endif
                @endforeach
                 @if ($flag==0)
                    <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-secondary" data-toggle="modal"
                        data-target="#addModalDateStage"
                        data-stage_id=""
                        data-agreement_id="{{ $agreement->id }}"
                        data-stage="DAP"
                        data-group="CON"
                        data-formaction="{{ route('agreements.stage.store', $agreement->id )}}">Agregar</button>
                @endif
              </td>
              <td><!-- DAP END -->
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'DAP' AND $stage->group == 'CON')
                           <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-primary" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">
                                {{ $stage->dateEnd ? $stage->dateEnd->format('d-M') : null }}</button>
                        @endif
                @endforeach</td>
              <td><!-- DGF IN -->
                @php $flag = 0; @endphp
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'DGF' AND $stage->group == 'CON')
                           <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-primary" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">{{$stage->date->format('d-M')}}</button>
                                @php $flag = 1; @endphp
                        @endif
                @endforeach
                 @if ($flag==0)
                    <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-secondary" data-toggle="modal"
                        data-target="#addModalDateStage"
                        data-stage_id=""
                        data-agreement_id="{{ $agreement->id }}"
                        data-stage="DGF"
                        data-group="CON"
                        data-formaction="{{ route('agreements.stage.store', $agreement->id )}}">Agregar</button>
                @endif
              </td>
              <td><!-- DGF END -->
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'DGF' AND $stage->group == 'CON')
                           <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-primary" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">
                                {{ $stage->dateEnd ? $stage->dateEnd->format('d-M') : null }}</button>
                        @endif
                @endforeach</td>
              <td><!-- SDGA IN -->
                 @php $flag = 0; @endphp
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'SDGA' AND $stage->group == 'CON')
                           <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-primary" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">{{$stage->date->format('d-M')}}</button>
                                @php $flag = 1; @endphp
                        @endif
                @endforeach
                 @if ($flag==0)
                    <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-secondary" data-toggle="modal"
                        data-target="#addModalDateStage"
                        data-stage_id=""
                        data-agreement_id="{{ $agreement->id }}"
                        data-stage="SDGA"
                        data-group="CON"
                        data-formaction="{{ route('agreements.stage.store', $agreement->id )}}">Agregar</button>
                @endif
              </td>
              <td><!-- SDGA END -->
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'SDGA' AND $stage->group == 'CON')
                           <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-primary" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">
                                {{ $stage->dateEnd ? $stage->dateEnd->format('d-M') : null }}</button>
                        @endif
                @endforeach</td>
              <td><!-- COMUNNE IN -->
                @php $flag = 0; @endphp
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'Comuna' AND $stage->group == 'CON')
                           <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-primary" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">{{$stage->date->format('d-M')}}</button>
                                @php $flag = 1; @endphp
                        @endif
                @endforeach
                 @if ($flag==0)
                    <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-secondary" data-toggle="modal"
                        data-target="#addModalDateStage"
                        data-stage_id=""
                        data-agreement_id="{{ $agreement->id }}"
                        data-stage="Comuna"
                        data-group="CON"
                        data-formaction="{{ route('agreements.stage.store', $agreement->id )}}">Agregar</button>
                @endif
              </td>
              <td><!-- COMMUNE END -->
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'Comuna' AND $stage->group == 'CON')
                           <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-primary" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">
                                {{ $stage->dateEnd ? $stage->dateEnd->format('d-M') : null }}</button>
                        @endif
                @endforeach</td>

              <td><!-- RES RTP-->
                @php $flag = 0; @endphp
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'RTP' AND $stage->group == 'RES')
                           <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-primary" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">{{$stage->date->format('d-M')}}</button>
                                @php $flag = 1; @endphp
                        @endif
                @endforeach
                 @if ($flag==0)
                    <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-secondary" data-toggle="modal"
                        data-target="#addModalDateStage"
                        data-stage_id=""
                        data-agreement_id="{{ $agreement->id }}"
                        data-stage="RTP"
                        data-group="RES"
                        data-formaction="{{ route('agreements.stage.store', $agreement->id )}}">Agregar</button>
                @endif
              </td>
              <td><!-- RES RTP END-->
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'RTP' AND $stage->group == 'RES')
                           <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-primary" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">{{ $stage->dateEnd ? $stage->dateEnd->format('d-M') : null }}</button>
                        @endif
                @endforeach</td>
              <td><!-- RES DAJ-->
                @php $flag = 0; @endphp
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'DAJ' AND $stage->group == 'RES')
                           <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-primary" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">{{$stage->date->format('d-M')}}</button>
                                @php $flag = 1; @endphp
                        @endif
                @endforeach
                 @if ($flag==0)
                    <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-secondary" data-toggle="modal"
                        data-target="#addModalDateStage"
                        data-stage_id=""
                        data-agreement_id="{{ $agreement->id }}"
                        data-stage="DAJ"
                        data-group="RES"
                        data-formaction="{{ route('agreements.stage.store', $agreement->id )}}">Agregar</button>
                @endif
              </td>
              <td><!-- RES DAJ END-->
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'DAJ' AND $stage->group == 'RES')
                           <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-primary" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">{{ $stage->dateEnd ? $stage->dateEnd->format('d-M') : null }}</button>
                        @endif
                @endforeach</td>
              <td><!-- RES DAP-->
                @php $flag = 0; @endphp
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'DAP' AND $stage->group == 'RES')
                           <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-primary" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">{{$stage->date->format('d-M')}}</button>
                                @php $flag = 1; @endphp
                        @endif
                @endforeach
                 @if ($flag==0)
                    <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-secondary" data-toggle="modal"
                        data-target="#addModalDateStage"
                        data-stage_id=""
                        data-agreement_id="{{ $agreement->id }}"
                        data-stage="DAP"
                        data-group="RES"
                        data-formaction="{{ route('agreements.stage.store', $agreement->id )}}">Agregar</button>
                @endif
              </td>
              <td><!-- RES DAP END-->
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'DAP' AND $stage->group == 'RES')
                           <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-primary" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">{{ $stage->dateEnd ? $stage->dateEnd->format('d-M') : null }}</button>
                        @endif
                @endforeach</td>
              <td><!-- RES DGF-->
                @php $flag = 0; @endphp
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'DGF' AND $stage->group == 'RES')
                           <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-primary" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">{{$stage->date->format('d-M')}}</button>
                                @php $flag = 1; @endphp
                        @endif
                @endforeach
                 @if ($flag==0)
                    <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-secondary" data-toggle="modal"
                        data-target="#addModalDateStage"
                        data-stage_id=""
                        data-agreement_id="{{ $agreement->id }}"
                        data-stage="DGF"
                        data-group="RES"
                        data-formaction="{{ route('agreements.stage.store', $agreement->id )}}">Agregar</button>
                @endif
              </td>
              <td><!-- RES DGF END-->
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'DGF' AND $stage->group == 'RES')
                           <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-primary" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">{{ $stage->dateEnd ? $stage->dateEnd->format('d-M') : null }}</button>
                        @endif
                @endforeach</td>
              <td><!-- RES SDGA-->
                @php $flag = 0; @endphp
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'SDGA' AND $stage->group == 'RES')
                           <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-primary" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">{{$stage->date->format('d-M')}}</button>
                                @php $flag = 1; @endphp
                        @endif
                @endforeach
                 @if ($flag==0)
                    <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-secondary" data-toggle="modal"
                        data-target="#addModalDateStage"
                        data-stage_id=""
                        data-agreement_id="{{ $agreement->id }}"
                        data-stage="SDGA"
                        data-group="RES"
                        data-formaction="{{ route('agreements.stage.store', $agreement->id )}}">Agregar</button>
                @endif
              </td>
              <td><!-- RES SDGA END-->
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'SDGA' AND $stage->group == 'RES')
                           <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-primary" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">{{ $stage->dateEnd ? $stage->dateEnd->format('d-M') : null }}</button>
                        @endif
                @endforeach</td>
              <td><!-- RES OF. PARTS-->
                @php $flag = 0; @endphp
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'SDGA' AND $stage->group == 'RES')
                           <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-primary" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">{{$stage->date->format('d-M')}}</button>
                                @php $flag = 1; @endphp
                        @endif
                @endforeach
                 @if ($flag==0)
                    <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-secondary" data-toggle="modal"
                        data-target="#addModalDateStage"
                        data-stage_id=""
                        data-agreement_id="{{ $agreement->id }}"
                        data-stage="SDGA"
                        data-group="RES"
                        data-formaction="{{ route('agreements.stage.store', $agreement->id )}}">Agregar</button>
                @endif</td>
              <td><!-- RES DAP END-->
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'RTP' AND $stage->group == 'RES')
                           <button style ="outline: none !important;padding: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-primary" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">{{ $stage->dateEnd ? $stage->dateEnd->format('d-M') : null }}</button>
                        @endif
                @endforeach</td>
              <td>{{ $agreement->number }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

@include('agreements/agreements/modal_edit_date_stage')
@include('agreements/agreements/modal_add_date_stage')
@endsection

@section('custom_js')
<script type="text/javascript">
    $('#editModalDateStage').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var modal  = $(this)
        console.log(button.data('date_end'));
        modal.find('input[name="id"]').val(button.data('stage_id'))
        modal.find('input[name="agreement_id"]').val(button.data('agreement_id'))
        modal.find('input[name="type"]').val(button.data('stage'))
        modal.find('input[name="date"]').val(button.data('date'))
        modal.find('input[name="dateEnd"]').val(button.data('date_end'))
        modal.find("#form-edit").attr('action', button.data('formaction'))
    })

    $('#addModalDateStage').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var modal  = $(this)
        console.log(button.data('group'));
        modal.find('input[name="group"]').val(button.data('group'))
        modal.find('input[name="agreement_id"]').val(button.data('agreement_id'))
        modal.find('input[name="type"]').val(button.data('stage'))
        modal.find("#form-edit").attr('action', button.data('formaction'))
    })
</script>
@endsection
