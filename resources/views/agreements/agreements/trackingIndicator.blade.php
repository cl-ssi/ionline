@extends('layouts.bt4.app')

@section('title', 'Listado de Convenios')

@section('content')

@include('agreements/nav')



<h3 class="mb-3">Seguimiento de Convenios
<form class="form-inline float-right mb-3" method="GET" action="{{ route('agreements.tracking.index') }}">
  <div class="input-group">
    <select name="program" id="formprogram" class="form-control selectpicker" data-live-search="true" data-size="10">
                    <option style="font-size:70%;" value="" >Programa</option>
                @foreach($programs as $program)
                    <option style="font-size:70%;" value="{{ $program->id }}" {{ request()->program == $program->id ? 'selected' : '' }}>{{ Str::limit($program->name, 100) }}</option>
                @endforeach
    </select>
    <select name="commune" id="formcommune" class="form-control selectpicker">
                    <option value="">Comuna</option>
                @foreach($communes as $commune)
                    <option value="{{ $commune->id }}" {{ request()->commune == $commune->id ? 'selected' : '' }}>{{ $commune->name }}</option>
                @endforeach
    </select>
    <select name="period" class="form-control selectpicker">
                @foreach(range(date('Y'), 2020) as $period)
                    <option value="{{ $period }}" {{ request()->period == $period ? 'selected' : '' }}>{{ $period }}</option>
                @endforeach
    </select>
		<div class="input-group-append">
			<button class="btn btn-outline-secondary" type="submit">
				<i class="fas fa-search" aria-hidden="true"></i>
			</button>
		</div>
	</div>
</form>
</h3>
<form method="GET" action="{{ route('agreements.tracking.index') }}">
<input type="hidden" name="program" value="{{request()->program}}">
<input type="hidden" name="commune" value="{{request()->commune}}">
<input type="hidden" name="period" value="{{request()->period}}">
<button type="submit" name="export" class="btn btn-success mb-1 btn-sm">Exportar Excel</button>
</form>

<table class="table table-striped  btn-table table-sm table-bordered table-condensed fixed_headers table-hover "><!-- table-responsive -->
    <thead>
            <tr class="small">
              <th class="text-center table-light" colspan="2"></th>
              <th class="text-center align-middle table-dark" colspan="8">CONVENIO</th>
              <th class="text-center align-middle table-secondary" colspan="7">RESOLUCIÓN</th>
            </tr>
            <tr class="small" style="font-size:70%;">
              <th class="text-center">#</th>
              <th>NOMBRE</th>
              <th>COMUNA</th>
              @if($period_selected >= 2024)
              <th class="text-center" data-toggle="tooltip" title="Referente Técnico">RTP</th>
              <th class="text-center" data-toggle="tooltip" title="Dpto. Jurídico" colspan="1">DAJ</th>
              <th class="text-center" data-toggle="tooltip" title="Director Atención Primaría" colspan="1">DAP</th>
              <th class="text-center" data-toggle="tooltip" title="SDGA" colspan="1">SDGA</th>
              <th class="text-center" data-toggle="tooltip" title="Dpto. Finanzas" colspan="1">DGF</th>
              <th class="text-center" data-toggle="tooltip" title="Firma Alcalde" colspan="1" >COMUNA</th>
              <th class="text-center" data-toggle="tooltip" title="Firma Director(a)" colspan="1" >DIRECTOR/A</th>

              <th class="text-center" data-toggle="tooltip" title="Referente Técnico" colspan="1" style="border-left: 3px solid #c0c0c0">RTP</th>
              <th class="text-center" data-toggle="tooltip" title="Director Atención Primaría" colspan="1">DAP</th>
              <th class="text-center" data-toggle="tooltip" title="Dpto. Jurídico" colspan="1">DAJ</th>
              <th class="text-center" data-toggle="tooltip" title="SDGA" colspan="1">SDGA</th>
              <th class="text-center" data-toggle="tooltip" title="SDA" colspan="1">SDA</th>
              <th class="text-center" data-toggle="tooltip" title="Oficina de Parte" colspan="1">OF.PARTE</th>
              <th class="text-center" data-toggle="tooltip" title="Nro. Resolución" colspan="1">RES</th>
              @else
              <th class="text-center" data-toggle="tooltip" title="Referente Técnico">RTP</th>
              <th class="text-center" data-toggle="tooltip" title="Director Atención Primaría" colspan="1">DAP</th>
              <th class="text-center" data-toggle="tooltip" title="Dpto. Jurídico" colspan="1">DAJ</th>
              <th class="text-center" data-toggle="tooltip" title="Dpto. Finanzas" colspan="1">DGF</th>
              <th class="text-center" data-toggle="tooltip" title="SDGA" colspan="1">SDGA</th>
              <th class="text-center" data-toggle="tooltip" title="Firma Alcalde" colspan="1" >COMUNA</th>
              <th class="text-center" data-toggle="tooltip" title="Firma Director(a)" colspan="1" >DIRECTOR/A</th>

              <th class="text-center" data-toggle="tooltip" title="Referente Técnico" colspan="1" style="border-left: 3px solid #c0c0c0">RTP</th>
              <th class="text-center" data-toggle="tooltip" title="Director Atención Primaría" colspan="1">DAP</th>
              <th class="text-center" data-toggle="tooltip" title="Dpto. Jurídico" colspan="1">DAJ</th>
              <th class="text-center" data-toggle="tooltip" title="Dpto. Finanzas" colspan="1">DGF</th>
              <th class="text-center" data-toggle="tooltip" title="SDGA" colspan="1">SDGA</th>
              <th class="text-center" data-toggle="tooltip" title="Oficina de Parte" colspan="1">OF.PARTE</th>
              <th class="text-center" data-toggle="tooltip" title="Nro. Resolución" colspan="1">RES</th>
              @endif
            </tr>
        </thead>
        <tbody style="font-size:65%;">
            @foreach($agreements as $agreement)
            <tr>
              <th scope="row" class="text-center">
                <a href="{{ route('agreements.show', $agreement->id) }}" class="">{{ $agreement->id }}</a>
              </th>
              <td>
              <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;" data-toggle="collapse" data-target="#coll{{ $agreement->id }}">+ {{ $agreement->program->name ?? 'Retiro voluntario' }}</button>
                <div id="coll{{ $agreement->id }}" class="collapse show">
                  <ul class="small" >
                    @foreach($agreement->agreement_amounts as $amount)
                        @if($amount->amount != 0)
                        <li>{{ $amount->program_component->name }}</li>
                        @endif
                    @endforeach
                  </ul>
                </div>
                 @if (!$agreement->addendums->isEmpty())
                   <hr class="mt-0 mb-1"/>
                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;" class="text-secondary" > -> @if($agreement->addendums->count() > 1) Incluye Addendums, último addendum #{{$agreement->addendums->first()->id}} @else Incluye Addendum #{{$agreement->addendums->first()->id}} @endif</button>
                 @endif
                 @if (!$agreement->continuities->isEmpty())
                   <hr class="mt-0 mb-1"/>
                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;" class="text-secondary" > -> @if($agreement->continuities->count() > 1) Incluye Resol. continuidad, último Resol. #{{$agreement->continuities->first()->id}} @else Incluye Resol. continuidad #{{$agreement->continuities->first()->id}} @endif</button>
                 @endif
              </td>
              <td>{{ $agreement->commune->name }}</td>
              <td><!-- RTP -->
              @if($agreement->file_to_endorse_id || $agreement->document?->file_to_sign_id)
                @php $flag_pending_state = false @endphp
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{$agreement->getEndorseObservationBySignPos(1)}}">
                  <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px; text-align: center;" class="btn btn-link text-secondary text-center" style="pointer-events: none;" type="button" disabled><i class="fas {{$agreement->getEndorseStateBySignPos(1)}}"></i></button>
                </span>
                @if (!$agreement->addendums->isEmpty() && $agreement->addendums->first()->file_to_endorse_id)
                @php $flag_pending_state_addendum = false @endphp
                <hr class="mt-0 mb-1"/>
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{$agreement->addendums->first()->getEndorseObservationBySignPos(1)}}">
                  <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px; text-align: center;" class="btn btn-link text-secondary text-center" style="pointer-events: none;" type="button" disabled><i class="fas {{$agreement->addendums->first()->getEndorseStateBySignPos(1)}}"></i></button>
                </span>
                @endif
                @if (!$agreement->continuities->isEmpty() && $agreement->continuities->first()->file_to_endorse_id)
                @php $flag_pending_state_continuity = false @endphp
                <hr class="mt-0 mb-1"/>
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{$agreement->continuities->first()->getEndorseObservationBySignPos(1)}}">
                  <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px; text-align: center;" class="btn btn-link text-secondary text-center" style="pointer-events: none;" type="button" disabled><i class="fas {{$agreement->continuities->first()->getEndorseStateBySignPos(1)}}"></i></button>
                </span>
                @endif
              @else
                @php $flag = 0; @endphp
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'RTP' AND $stage->group == 'CON')
                           <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px; display: block;" class="btn btn-link" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-observation="{{ $stage->observation }}"
                                data-file="{{ $agreement->file ?  route('agreements.download', $agreement->id)   : null  }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">
                                @if($stage->dateEnd)
                                  <i class="fas fa-check text-success"></i>
                                @else
                                  <i class="fas fa-check text-warning"></i>
                                @endif
                                </button>
                                @php $flag = 1; @endphp
                                <!-- SI EXISTE UN ADENDUM EN EL CONVENIO -->
                                @if (!$agreement->addendums->isEmpty())
                                 <hr class="mt-0 mb-1"/>
                                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;display: block;" class="btn btn-link" data-toggle="modal"
                                    data-target="#editModalDateStageAddendum"
                                    data-stage_id="{{ $stage->id }}"
                                    data-agreement_id="{{ $stage->agreement_id }}"
                                    data-stage="{{ $stage->type }}"
                                    data-file="{{ $agreement->file ?  route('agreements.download', $agreement->id)   : null  }}"
                                    data-date="{{ $stage->date->format('Y-m-d') }}"
                                    data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                    data-date_addendum="{{ $stage->date_addendum ? $stage->date_addendum : null }}"
                                    data-date_end_addendum="{{ $stage->dateEnd_addendum ? $stage->dateEnd_addendum : null }}"
                                    data-formaction="{{ route('agreements.stage.update', $stage->id )}}">
                                    @if($stage->dateEnd_addendum)
                                      <i class="fas fa-check text-primary"></i>
                                    @else
                                      <i class="fas fa-check text-secondary"></i>
                                    @endif
                                    </button>
                                @endif
                        @endif
                @endforeach
                @if($flag==0)
                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px; text-align: center;" class="btn btn-link text-secondary text-center" data-toggle="modal"
                        data-target="#addModalDateStage"
                        data-stage_id=""
                        data-agreement_id="{{ $agreement->id }}"
                        data-stage="RTP"
                        data-group="CON"
                        data-formaction="{{ route('agreements.stage.store', $agreement->id )}}">
                        <i class="fas fa-ellipsis-h"></i></button>
                @endif
              @endif
              </td>
              <td><!-- DAP IN -->
              @if($agreement->file_to_endorse_id || $agreement->document?->file_to_sign_id)
                @if(!$flag_pending_state) @php $flag_pending_state = $agreement->isEndorsePendingBySignPos(1) @endphp @endif
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{$flag_pending_state ? 'En espera' : $agreement->getEndorseObservationBySignPos(2)}}">
                  <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px; text-align: center;" class="btn btn-link text-secondary text-center" style="pointer-events: none;" type="button" disabled><i class="fas {{$flag_pending_state ? 'fa-ellipsis-h' : $agreement->getEndorseStateBySignPos(2)}}"></i></button>
                </span>
                @if (!$agreement->addendums->isEmpty() && $agreement->addendums->first()->file_to_endorse_id)
                @if(!$flag_pending_state_addendum) @php $flag_pending_state_addendum = $agreement->addendums->first()->isEndorsePendingBySignPos(1) @endphp @endif
                <hr class="mt-0 mb-1"/>
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{$flag_pending_state_addendum ? 'En espera' : $agreement->addendums->first()->getEndorseObservationBySignPos(2)}}">
                  <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px; text-align: center;" class="btn btn-link text-secondary text-center" style="pointer-events: none;" type="button" disabled><i class="fas {{$flag_pending_state_addendum ? 'fa-ellipsis-h' : $agreement->addendums->first()->getEndorseStateBySignPos(2)}}"></i></button>
                </span>
                @endif
                @if (!$agreement->continuities->isEmpty() && $agreement->continuities->first()->file_to_endorse_id)
                @if(!$flag_pending_state_continuity) @php $flag_pending_state_continuity = $agreement->continuities->first()->isEndorsePendingBySignPos(1) @endphp @endif
                <hr class="mt-0 mb-1"/>
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{$flag_pending_state_continuity ? 'En espera' : $agreement->continuities->first()->getEndorseObservationBySignPos(2)}}">
                  <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px; text-align: center;" class="btn btn-link text-secondary text-center" style="pointer-events: none;" type="button" disabled><i class="fas {{$flag_pending_state_continuity ? 'fa-ellipsis-h' : $agreement->continuities->first()->getEndorseStateBySignPos(2)}}"></i></button>
                </span>
                @endif
              @else
                @php $flag = 0; @endphp
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'DAP' AND $stage->group == 'CON')
                           <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-observation="{{ $stage->observation }}"
                                data-file="{{ $stage->file ?  route('agreements.stage.download', $stage->id)   : null  }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">
                                @if($stage->dateEnd)
                                  <i class="fas fa-check text-success"></i>
                                @else
                                  <i class="fas fa-check text-warning"></i>
                                @endif
                                </button>
                                @php $flag = 1; @endphp
                                <!-- SI EXISTE UN ADENDUM EN EL CONVENIO -->
                                @if (!$agreement->addendums->isEmpty())
                                 <hr class="mt-0 mb-1"/>
                                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;display: block;" class="btn btn-link" data-toggle="modal"
                                    data-target="#editModalDateStageAddendum"
                                    data-stage_id="{{ $stage->id }}"
                                    data-agreement_id="{{ $stage->agreement_id }}"
                                    data-stage="{{ $stage->type }}"
                                    data-file="{{ $agreement->file ?  route('agreements.download', $agreement->id)   : null  }}"
                                    data-date="{{ $stage->date->format('Y-m-d') }}"
                                    data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                    data-date_addendum="{{ $stage->date_addendum ? $stage->date_addendum : null }}"
                                    data-date_end_addendum="{{ $stage->dateEnd_addendum ? $stage->dateEnd_addendum : null }}"
                                    data-formaction="{{ route('agreements.stage.update', $stage->id )}}">
                                    @if($stage->dateEnd_addendum)
                                      <i class="fas fa-check text-primary"></i>
                                    @else
                                      <i class="fas fa-check text-secondary"></i>
                                    @endif
                                    </button>
                                @endif
                        @endif
                @endforeach
                 @if ($flag==0)
                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-secondary" data-toggle="modal"
                        data-target="#addModalDateStage"
                        data-stage_id=""
                        data-agreement_id="{{ $agreement->id }}"
                        data-stage="DAP"
                        data-group="CON"
                        data-formaction="{{ route('agreements.stage.store', $agreement->id )}}"><i class="fas fa-ellipsis-h"></i></button>
                @endif
              @endif
              </td>
              <td><!-- DAJ IN -->
              @if($agreement->file_to_endorse_id || $agreement->document?->file_to_sign_id)
                @if(!$flag_pending_state) @php $flag_pending_state = $agreement->isEndorsePendingBySignPos(2) @endphp @endif
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{$flag_pending_state ? 'En espera' : $agreement->getEndorseObservationBySignPos(3)}}">
                  <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px; text-align: center;" class="btn btn-link text-secondary text-center" style="pointer-events: none;" type="button" disabled><i class="fas {{$flag_pending_state ? 'fa-ellipsis-h' : $agreement->getEndorseStateBySignPos(3)}}"></i></button>
                </span>
                @if (!$agreement->addendums->isEmpty() && $agreement->addendums->first()->file_to_endorse_id)
                  @if(!$flag_pending_state_addendum) @php $flag_pending_state_addendum = $agreement->addendums->first()->isEndorsePendingBySignPos(2) @endphp @endif
                  <hr class="mt-0 mb-1"/>
                  <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{$flag_pending_state_addendum ? 'En espera' : $agreement->addendums->first()->getEndorseObservationBySignPos(3)}}">
                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px; text-align: center;" class="btn btn-link text-secondary text-center" style="pointer-events: none;" type="button" disabled><i class="fas {{$flag_pending_state_addendum ? 'fa-ellipsis-h' : $agreement->addendums->first()->getEndorseStateBySignPos(3)}}"></i></button>
                  </span>
                @endif
                @if (!$agreement->continuities->isEmpty() && $agreement->continuities->first()->file_to_endorse_id)
                  @if(!$flag_pending_state_continuity) @php $flag_pending_state_continuity = $agreement->continuities->first()->isEndorsePendingBySignPos(2) @endphp @endif
                  <hr class="mt-0 mb-1"/>
                  <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{$flag_pending_state_continuity ? 'En espera' : $agreement->continuities->first()->getEndorseObservationBySignPos(3)}}">
                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px; text-align: center;" class="btn btn-link text-secondary text-center" style="pointer-events: none;" type="button" disabled><i class="fas {{$flag_pending_state_continuity ? 'fa-ellipsis-h' : $agreement->continuities->first()->getEndorseStateBySignPos(3)}}"></i></button>
                  </span>
                @endif
              @else
                @php $flag = 0; @endphp
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'DAJ' AND $stage->group == 'CON')
                           <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-observation="{{ $stage->observation }}"
                                data-file="{{ $stage->file ?  route('agreements.stage.download', $stage->id)   : null  }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">
                                @if($stage->dateEnd)
                                  <i class="fas fa-check text-success"></i>
                                @else
                                  <i class="fas fa-check text-warning"></i>
                                @endif
                                </button>
                                @php $flag = 1; @endphp
                                <!-- SI EXISTE UN ADENDUM EN EL CONVENIO -->
                                @if (!$agreement->addendums->isEmpty())
                                 <hr class="mt-0 mb-1"/>
                                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;display: block;" class="btn btn-link" data-toggle="modal"
                                    data-target="#editModalDateStageAddendum"
                                    data-stage_id="{{ $stage->id }}"
                                    data-agreement_id="{{ $stage->agreement_id }}"
                                    data-stage="{{ $stage->type }}"
                                    data-file="{{ $agreement->file ?  route('agreements.download', $agreement->id)   : null  }}"
                                    data-date="{{ $stage->date->format('Y-m-d') }}"
                                    data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                    data-date_addendum="{{ $stage->date_addendum ? $stage->date_addendum : null }}"
                                    data-date_end_addendum="{{ $stage->dateEnd_addendum ? $stage->dateEnd_addendum : null }}"
                                    data-formaction="{{ route('agreements.stage.update', $stage->id )}}">
                                    @if($stage->dateEnd_addendum)
                                      <i class="fas fa-check text-primary"></i>
                                    @else
                                      <i class="fas fa-check text-secondary"></i>
                                    @endif
                                    </button>
                                @endif
                        @endif
                @endforeach
                 @if ($flag==0)
                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-secondary" data-toggle="modal"
                        data-target="#addModalDateStage"
                        data-stage_id=""
                        data-agreement_id="{{ $agreement->id }}"
                        data-stage="DAJ"
                        data-group="CON"
                        data-formaction="{{ route('agreements.stage.store', $agreement->id )}}"><i class="fas fa-ellipsis-h"></i></button>
                @endif
              @endif
              </td>
              <td><!-- DGF IN -->
              @if($agreement->file_to_endorse_id || $agreement->document?->file_to_sign_id)
                @if(!$flag_pending_state) @php $flag_pending_state = $agreement->isEndorsePendingBySignPos(3) @endphp @endif
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{$flag_pending_state ? 'En espera' : $agreement->getEndorseObservationBySignPos(4)}}">
                  <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px; text-align: center;" class="btn btn-link text-secondary text-center" style="pointer-events: none;" type="button" disabled><i class="fas {{$flag_pending_state ? 'fa-ellipsis-h' : $agreement->getEndorseStateBySignPos(4)}}"></i></button>
                </span>
                @if (!$agreement->addendums->isEmpty() && $agreement->addendums->first()->file_to_endorse_id)
                  @if(!$flag_pending_state_addendum) @php $flag_pending_state_addendum = $agreement->addendums->first()->isEndorsePendingBySignPos(3) @endphp @endif
                  <hr class="mt-0 mb-1"/>
                  <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{$flag_pending_state_addendum ? 'En espera' : $agreement->addendums->first()->getEndorseObservationBySignPos(4)}}">
                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px; text-align: center;" class="btn btn-link text-secondary text-center" style="pointer-events: none;" type="button" disabled><i class="fas {{$flag_pending_state_addendum ? 'fa-ellipsis-h' : $agreement->addendums->first()->getEndorseStateBySignPos(4)}}"></i></button>
                  </span>
                @endif
                @if (!$agreement->continuities->isEmpty() && $agreement->continuities->first()->file_to_endorse_id)
                  @if(!$flag_pending_state_continuity) @php $flag_pending_state_continuity = $agreement->continuities->first()->isEndorsePendingBySignPos(3) @endphp @endif
                  <hr class="mt-0 mb-1"/>
                  <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{$flag_pending_state_continuity ? 'En espera' : $agreement->continuities->first()->getEndorseObservationBySignPos(4)}}">
                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px; text-align: center;" class="btn btn-link text-secondary text-center" style="pointer-events: none;" type="button" disabled><i class="fas {{$flag_pending_state_continuity ? 'fa-ellipsis-h' : $agreement->continuities->first()->getEndorseStateBySignPos(4)}}"></i></button>
                  </span>
                @endif
              @else
                @php $flag = 0; @endphp
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'DGF' AND $stage->group == 'CON')
                           <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-observation="{{ $stage->observation }}"
                                data-file="{{ $stage->file ?  route('agreements.stage.download', $stage->id)   : null  }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">
                                @if($stage->dateEnd)
                                  <i class="fas fa-check text-success"></i>
                                @else
                                  <i class="fas fa-check text-warning"></i>
                                @endif
                                </button>
                                @php $flag = 1; @endphp
                                <!-- SI EXISTE UN ADENDUM EN EL CONVENIO -->
                                @if (!$agreement->addendums->isEmpty())
                                 <hr class="mt-0 mb-1"/>
                                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;display: block;" class="btn btn-link" data-toggle="modal"
                                    data-target="#editModalDateStageAddendum"
                                    data-stage_id="{{ $stage->id }}"
                                    data-agreement_id="{{ $stage->agreement_id }}"
                                    data-stage="{{ $stage->type }}"
                                    data-file="{{ $agreement->file ?  route('agreements.download', $agreement->id)   : null  }}"
                                    data-date="{{ $stage->date->format('Y-m-d') }}"
                                    data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                    data-date_addendum="{{ $stage->date_addendum ? $stage->date_addendum : null }}"
                                    data-date_end_addendum="{{ $stage->dateEnd_addendum ? $stage->dateEnd_addendum : null }}"
                                    data-formaction="{{ route('agreements.stage.update', $stage->id )}}">
                                    @if($stage->dateEnd_addendum)
                                      <i class="fas fa-check text-primary"></i>
                                    @else
                                      <i class="fas fa-check text-secondary"></i>
                                    @endif
                                    </button>
                                @endif
                        @endif
                @endforeach
                 @if ($flag==0)
                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-secondary" data-toggle="modal"
                        data-target="#addModalDateStage"
                        data-stage_id=""
                        data-agreement_id="{{ $agreement->id }}"
                        data-stage="DGF"
                        data-group="CON"
                        data-formaction="{{ route('agreements.stage.store', $agreement->id )}}"><i class="fas fa-ellipsis-h"></i></button>
                @endif
              @endif
              </td>
              <td><!-- SDGA IN -->
              @if($agreement->file_to_endorse_id || $agreement->document?->file_to_sign_id)
                @if(!$flag_pending_state) @php $flag_pending_state = $agreement->isEndorsePendingBySignPos(4) @endphp @endif
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{$flag_pending_state ? 'En espera' : $agreement->getEndorseObservationBySignPos(5)}}">
                  <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px; text-align: center;" class="btn btn-link text-secondary text-center" style="pointer-events: none;" type="button" disabled><i class="fas {{$flag_pending_state ? 'fa-ellipsis-h' : $agreement->getEndorseStateBySignPos(5)}}"></i></button>
                </span>
                @if (!$agreement->addendums->isEmpty() && $agreement->addendums->first()->file_to_endorse_id)
                  @if(!$flag_pending_state_addendum) @php $flag_pending_state_addendum = $agreement->addendums->first()->isEndorsePendingBySignPos(4) @endphp @endif
                  <hr class="mt-0 mb-1"/>
                  <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{$flag_pending_state_addendum ? 'En espera' : $agreement->addendums->first()->getEndorseObservationBySignPos(5)}}">
                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px; text-align: center;" class="btn btn-link text-secondary text-center" style="pointer-events: none;" type="button" disabled><i class="fas {{$flag_pending_state_addendum ? 'fa-ellipsis-h' : $agreement->addendums->first()->getEndorseStateBySignPos(5)}}"></i></button>
                  </span>
                @endif
                @if (!$agreement->continuities->isEmpty() && $agreement->continuities->first()->file_to_endorse_id)
                  @if(!$flag_pending_state_continuity) @php $flag_pending_state_continuity = $agreement->continuities->first()->isEndorsePendingBySignPos(4) @endphp @endif
                  <hr class="mt-0 mb-1"/>
                  <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{$flag_pending_state_continuity ? 'En espera' : $agreement->continuities->first()->getEndorseObservationBySignPos(5)}}">
                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px; text-align: center;" class="btn btn-link text-secondary text-center" style="pointer-events: none;" type="button" disabled><i class="fas {{$flag_pending_state_continuity ? 'fa-ellipsis-h' : $agreement->continuities->first()->getEndorseStateBySignPos(5)}}"></i></button>
                  </span>
                @endif
              @else
                 @php $flag = 0; @endphp
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'SDGA' AND $stage->group == 'CON')
                           <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-observation="{{ $stage->observation }}"
                                data-file="{{ $stage->file ?  route('agreements.stage.download', $stage->id)   : null  }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">
                                @if($stage->dateEnd)
                                  <i class="fas fa-check text-success"></i>
                                @else
                                  <i class="fas fa-check text-warning"></i>
                                @endif
                                </button>
                                @php $flag = 1; @endphp
                                <!-- SI EXISTE UN ADENDUM EN EL CONVENIO -->
                                @if (!$agreement->addendums->isEmpty())
                                 <hr class="mt-0 mb-1"/>
                                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;display: block;" class="btn btn-link" data-toggle="modal"
                                    data-target="#editModalDateStageAddendum"
                                    data-stage_id="{{ $stage->id }}"
                                    data-agreement_id="{{ $stage->agreement_id }}"
                                    data-stage="{{ $stage->type }}"
                                    data-file="{{ $agreement->file ?  route('agreements.download', $agreement->id)   : null  }}"
                                    data-date="{{ $stage->date->format('Y-m-d') }}"
                                    data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                    data-date_addendum="{{ $stage->date_addendum ? $stage->date_addendum : null }}"
                                    data-date_end_addendum="{{ $stage->dateEnd_addendum ? $stage->dateEnd_addendum : null }}"
                                    data-formaction="{{ route('agreements.stage.update', $stage->id )}}">
                                    @if($stage->dateEnd_addendum)
                                      <i class="fas fa-check text-primary"></i>
                                    @else
                                      <i class="fas fa-check text-secondary"></i>
                                    @endif
                                    </button>
                                @endif
                        @endif
                @endforeach
                 @if ($flag==0)
                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-secondary" data-toggle="modal"
                        data-target="#addModalDateStage"
                        data-stage_id=""
                        data-agreement_id="{{ $agreement->id }}"
                        data-stage="SDGA"
                        data-group="CON"
                        data-formaction="{{ route('agreements.stage.store', $agreement->id )}}"><i class="fas fa-ellipsis-h"></i></button>
                @endif
              @endif
              </td>

              <td ><!-- COMUNNE IN -->
                @php $flag = 0; @endphp
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'Comuna' AND $stage->group == 'CON')
                           <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-observation="{{ $stage->observation }}"
                                data-file="{{ $stage->file ?  route('agreements.stage.download', $stage->id)   : null  }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">
                                @if($stage->dateEnd)
                                  <i class="fas fa-check text-success"></i>
                                @else
                                  <i class="fas fa-check text-warning"></i>
                                @endif
                                </button>
                                @php $flag = 1; @endphp
                                <!-- SI EXISTE UN ADENDUM EN EL CONVENIO -->
                                @if (!$agreement->addendums->isEmpty())
                                 <hr class="mt-0 mb-1"/>
                                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;display: block;" class="btn btn-link" data-toggle="modal"
                                    data-target="#editModalDateStageAddendum"
                                    data-stage_id="{{ $stage->id }}"
                                    data-agreement_id="{{ $stage->agreement_id }}"
                                    data-stage="{{ $stage->type }}"
                                    data-file="{{ $agreement->file ?  route('agreements.download', $agreement->id)   : null  }}"
                                    data-date="{{ $stage->date->format('Y-m-d') }}"
                                    data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                    data-date_addendum="{{ $stage->date_addendum ? $stage->date_addendum : null }}"
                                    data-date_end_addendum="{{ $stage->dateEnd_addendum ? $stage->dateEnd_addendum : null }}"
                                    data-formaction="{{ route('agreements.stage.update', $stage->id )}}">
                                    @if($stage->dateEnd_addendum)
                                      <i class="fas fa-check text-primary"></i>
                                    @else
                                      <i class="fas fa-check text-secondary"></i>
                                    @endif
                                    </button>
                                @endif
                        @endif
                @endforeach
                 @if ($flag==0)
                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-secondary" data-toggle="modal"
                        data-target="#addModalDateStage"
                        data-stage_id=""
                        data-agreement_id="{{ $agreement->id }}"
                        data-stage="Comuna"
                        data-group="CON"
                        data-formaction="{{ route('agreements.stage.store', $agreement->id )}}"><i class="fas fa-ellipsis-h"></i></button>
                @endif
              </td>
              <td><!-- Director(a) -->
              @if($agreement->file_to_sign_id)
                {{--@if(!$flag_pending_state) @php $flag_pending_state = $agreement->isEndorsePendingBySignPos(4) @endphp @endif--}}
                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{$agreement->getSignObservation()}}">
                  <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px; text-align: center;" class="btn btn-link text-secondary text-center" style="pointer-events: none;" type="button" disabled><i class="fas {{$agreement->getSignState()}}"></i></button>
                </span>
                @if (!$agreement->addendums->isEmpty() && $agreement->addendums->first()->file_to_sign_id)
                  {{--@if(!$flag_pending_state_addendum) @php $flag_pending_state_addendum = $agreement->addendums->first()->isEndorsePendingBySignPos(4) @endphp @endif--}}
                  <hr class="mt-0 mb-1"/>
                  <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{$agreement->addendums->first()->getSignObservation()}}">
                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px; text-align: center;" class="btn btn-link text-secondary text-center" style="pointer-events: none;" type="button" disabled><i class="fas {{$agreement->addendums->first()->getSignState()}}"></i></button>
                  </span>
                @endif
              @else
                 @php $flag = 0; @endphp
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'Director' AND $stage->group == 'CON')
                           <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-observation="{{ $stage->observation }}"
                                data-file="{{ $stage->file ?  route('agreements.stage.download', $stage->id)   : null  }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">
                                @if($stage->dateEnd)
                                  <i class="fas fa-check text-success"></i>
                                @else
                                  <i class="fas fa-check text-warning"></i>
                                @endif
                                </button>
                                @php $flag = 1; @endphp
                                <!-- SI EXISTE UN ADENDUM EN EL CONVENIO -->
                                @if (!$agreement->addendums->isEmpty())
                                 <hr class="mt-0 mb-1"/>
                                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;display: block;" class="btn btn-link" data-toggle="modal"
                                    data-target="#editModalDateStageAddendum"
                                    data-stage_id="{{ $stage->id }}"
                                    data-agreement_id="{{ $stage->agreement_id }}"
                                    data-stage="{{ $stage->type }}"
                                    data-file="{{ $agreement->file ?  route('agreements.download', $agreement->id)   : null  }}"
                                    data-date="{{ $stage->date->format('Y-m-d') }}"
                                    data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                    data-date_addendum="{{ $stage->date_addendum ? $stage->date_addendum : null }}"
                                    data-date_end_addendum="{{ $stage->dateEnd_addendum ? $stage->dateEnd_addendum : null }}"
                                    data-formaction="{{ route('agreements.stage.update', $stage->id )}}">
                                    @if($stage->dateEnd_addendum)
                                      <i class="fas fa-check text-primary"></i>
                                    @else
                                      <i class="fas fa-check text-secondary"></i>
                                    @endif
                                    </button>
                                @endif
                        @endif
                @endforeach
                 @if ($flag==0)
                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-secondary" data-toggle="modal"
                        data-target="#addModalDateStage"
                        data-stage_id=""
                        data-agreement_id="{{ $agreement->id }}"
                        data-stage="Director"
                        data-group="CON"
                        data-formaction="{{ route('agreements.stage.store', $agreement->id )}}"><i class="fas fa-ellipsis-h"></i></button>
                @endif
              @endif
              </td>

              <td style="border-left: 3px solid #c0c0c0"><!-- RES RTP-->
                @php $flag = 0; @endphp
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'RTP' AND $stage->group == 'RES')
                           <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-observation="{{ $stage->observation }}"
                                data-file="{{ $agreement->file ?  route('agreements.createWordRes', $agreement->id)   : null  }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">
                                @if($stage->dateEnd)
                                  <i class="fas fa-check text-success"></i>
                                @else
                                  <i class="fas fa-check text-warning"></i>
                                @endif
                                </button>
                                @php $flag = 1; @endphp
                                <!-- SI EXISTE UN ADENDUM EN EL CONVENIO -->
                                @if (!$agreement->addendums->isEmpty())
                                 <hr class="mt-0 mb-1"/>
                                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;display: block;" class="btn btn-link" data-toggle="modal"
                                    data-target="#editModalDateStageAddendum"
                                    data-stage_id="{{ $stage->id }}"
                                    data-agreement_id="{{ $stage->agreement_id }}"
                                    data-stage="{{ $stage->type }}"
                                    data-file="{{ $agreement->file ?  route('agreements.download', $agreement->id)   : null  }}"
                                    data-date="{{ $stage->date->format('Y-m-d') }}"
                                    data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                    data-date_addendum="{{ $stage->date_addendum ? $stage->date_addendum : null }}"
                                    data-date_end_addendum="{{ $stage->dateEnd_addendum ? $stage->dateEnd_addendum : null }}"
                                    data-formaction="{{ route('agreements.stage.update', $stage->id )}}">
                                    @if($stage->dateEnd_addendum)
                                      <i class="fas fa-check text-primary"></i>
                                    @else
                                      <i class="fas fa-check text-secondary"></i>
                                    @endif
                                    </button>
                                @endif
                        @endif
                @endforeach
                 @if ($flag==0)
                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-secondary" data-toggle="modal"
                        data-target="#addModalDateStage"
                        data-stage_id=""
                        data-agreement_id="{{ $agreement->id }}"
                        data-stage="RTP"
                        data-group="RES"
                        data-formaction="{{ route('agreements.stage.store', $agreement->id )}}"><i class="fas fa-ellipsis-h"></i></button>
                @endif
              </td>
              <td><!-- RES DAP-->
                @php $flag = 0; @endphp
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'DAP' AND $stage->group == 'RES')
                           <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-observation="{{ $stage->observation }}"
                                data-file="{{ $stage->file ?  route('agreements.stage.download', $stage->id)   : null  }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">
                                @if($stage->dateEnd)
                                  <i class="fas fa-check text-success"></i>
                                @else
                                  <i class="fas fa-check text-warning"></i>
                                @endif
                                </button>
                                @php $flag = 1; @endphp
                                <!-- SI EXISTE UN ADENDUM EN EL CONVENIO -->
                                @if (!$agreement->addendums->isEmpty())
                                 <hr class="mt-0 mb-1"/>
                                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;display: block;" class="btn btn-link" data-toggle="modal"
                                    data-target="#editModalDateStageAddendum"
                                    data-stage_id="{{ $stage->id }}"
                                    data-agreement_id="{{ $stage->agreement_id }}"
                                    data-stage="{{ $stage->type }}"
                                    data-file="{{ $agreement->file ?  route('agreements.download', $agreement->id)   : null  }}"
                                    data-date="{{ $stage->date->format('Y-m-d') }}"
                                    data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                    data-date_addendum="{{ $stage->date_addendum ? $stage->date_addendum : null }}"
                                    data-date_end_addendum="{{ $stage->dateEnd_addendum ? $stage->dateEnd_addendum : null }}"
                                    data-formaction="{{ route('agreements.stage.update', $stage->id )}}">
                                    @if($stage->dateEnd_addendum)
                                      <i class="fas fa-check text-primary"></i>
                                    @else
                                      <i class="fas fa-check text-secondary"></i>
                                    @endif
                                    </button>
                                @endif
                        @endif
                @endforeach
                 @if ($flag==0)
                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-secondary" data-toggle="modal"
                        data-target="#addModalDateStage"
                        data-stage_id=""
                        data-agreement_id="{{ $agreement->id }}"
                        data-stage="DAP"
                        data-group="RES"
                        data-formaction="{{ route('agreements.stage.store', $agreement->id )}}"><i class="fas fa-ellipsis-h"></i></button>
                @endif
              </td>
              <td><!-- RES DAJ-->
                @php $flag = 0; @endphp
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'DAJ' AND $stage->group == 'RES')
                           <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-observation="{{ $stage->observation }}"
                                data-file="{{ $stage->file ?  route('agreements.stage.download', $stage->id)   : null  }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">
                                @if($stage->dateEnd)
                                  <i class="fas fa-check text-success"></i>
                                @else
                                  <i class="fas fa-check text-warning"></i>
                                @endif
                                </button>
                                @php $flag = 1; @endphp
                                <!-- SI EXISTE UN ADENDUM EN EL CONVENIO -->
                                @if (!$agreement->addendums->isEmpty())
                                 <hr class="mt-0 mb-1"/>
                                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;display: block;" class="btn btn-link" data-toggle="modal"
                                    data-target="#editModalDateStageAddendum"
                                    data-stage_id="{{ $stage->id }}"
                                    data-agreement_id="{{ $stage->agreement_id }}"
                                    data-stage="{{ $stage->type }}"
                                    data-file="{{ $agreement->file ?  route('agreements.download', $agreement->id)   : null  }}"
                                    data-date="{{ $stage->date->format('Y-m-d') }}"
                                    data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                    data-date_addendum="{{ $stage->date_addendum ? $stage->date_addendum : null }}"
                                    data-date_end_addendum="{{ $stage->dateEnd_addendum ? $stage->dateEnd_addendum : null }}"
                                    data-formaction="{{ route('agreements.stage.update', $stage->id )}}">
                                    @if($stage->dateEnd_addendum)
                                      <i class="fas fa-check text-primary"></i>
                                    @else
                                      <i class="fas fa-check text-secondary"></i>
                                    @endif
                                    </button>
                                @endif
                        @endif
                @endforeach
                 @if ($flag==0)
                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-secondary" data-toggle="modal"
                        data-target="#addModalDateStage"
                        data-stage_id=""
                        data-agreement_id="{{ $agreement->id }}"
                        data-stage="DAJ"
                        data-group="RES"
                        data-formaction="{{ route('agreements.stage.store', $agreement->id )}}"><i class="fas fa-ellipsis-h"></i></button>
                @endif
              </td>
              <td><!-- RES DGF-->
                @php $flag = 0; @endphp
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'DGF' AND $stage->group == 'RES')
                           <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-observation="{{ $stage->observation }}"
                                data-file="{{ $stage->file ?  route('agreements.stage.download', $stage->id)   : null  }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">
                                @if($stage->dateEnd)
                                  <i class="fas fa-check text-success"></i>
                                @else
                                  <i class="fas fa-check text-warning"></i>
                                @endif
                                </button>
                                @php $flag = 1; @endphp
                                <!-- SI EXISTE UN ADENDUM EN EL CONVENIO -->
                                @if (!$agreement->addendums->isEmpty())
                                 <hr class="mt-0 mb-1"/>
                                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;display: block;" class="btn btn-link" data-toggle="modal"
                                    data-target="#editModalDateStageAddendum"
                                    data-stage_id="{{ $stage->id }}"
                                    data-agreement_id="{{ $stage->agreement_id }}"
                                    data-stage="{{ $stage->type }}"
                                    data-file="{{ $agreement->file ?  route('agreements.download', $agreement->id)   : null  }}"
                                    data-date="{{ $stage->date->format('Y-m-d') }}"
                                    data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                    data-date_addendum="{{ $stage->date_addendum ? $stage->date_addendum : null }}"
                                    data-date_end_addendum="{{ $stage->dateEnd_addendum ? $stage->dateEnd_addendum : null }}"
                                    data-formaction="{{ route('agreements.stage.update', $stage->id )}}">
                                    @if($stage->dateEnd_addendum)
                                      <i class="fas fa-check text-primary"></i>
                                    @else
                                      <i class="fas fa-check text-secondary"></i>
                                    @endif
                                    </button>
                                @endif
                        @endif
                @endforeach
                 @if ($flag==0)
                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-secondary" data-toggle="modal"
                        data-target="#addModalDateStage"
                        data-stage_id=""
                        data-agreement_id="{{ $agreement->id }}"
                        data-stage="DGF"
                        data-group="RES"
                        data-formaction="{{ route('agreements.stage.store', $agreement->id )}}"><i class="fas fa-ellipsis-h"></i></button>
                @endif
              </td>
              <td><!-- RES SDGA-->
                @php $flag = 0; @endphp
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'SDGA' AND $stage->group == 'RES')
                           <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-observation="{{ $stage->observation }}"
                                data-file="{{ $stage->file ?  route('agreements.stage.download', $stage->id)   : null  }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">
                                @if($stage->dateEnd)
                                  <i class="fas fa-check text-success"></i>
                                @else
                                  <i class="fas fa-check text-warning"></i>
                                @endif
                                </button>
                                @php $flag = 1; @endphp
                                <!-- SI EXISTE UN ADENDUM EN EL CONVENIO -->
                                @if (!$agreement->addendums->isEmpty())
                                 <hr class="mt-0 mb-1"/>
                                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;display: block;" class="btn btn-link" data-toggle="modal"
                                    data-target="#editModalDateStageAddendum"
                                    data-stage_id="{{ $stage->id }}"
                                    data-agreement_id="{{ $stage->agreement_id }}"
                                    data-stage="{{ $stage->type }}"
                                    data-file="{{ $agreement->file ?  route('agreements.download', $agreement->id)   : null  }}"
                                    data-date="{{ $stage->date->format('Y-m-d') }}"
                                    data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                    data-date_addendum="{{ $stage->date_addendum ? $stage->date_addendum : null }}"
                                    data-date_end_addendum="{{ $stage->dateEnd_addendum ? $stage->dateEnd_addendum : null }}"
                                    data-formaction="{{ route('agreements.stage.update', $stage->id )}}">
                                    @if($stage->dateEnd_addendum)
                                      <i class="fas fa-check text-primary"></i>
                                    @else
                                      <i class="fas fa-check text-secondary"></i>
                                    @endif
                                    </button>
                                @endif
                        @endif
                @endforeach
                 @if ($flag==0)
                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-secondary" data-toggle="modal"
                        data-target="#addModalDateStage"
                        data-stage_id=""
                        data-agreement_id="{{ $agreement->id }}"
                        data-stage="SDGA"
                        data-group="RES"
                        data-formaction="{{ route('agreements.stage.store', $agreement->id )}}"><i class="fas fa-ellipsis-h"></i></button>
                @endif
              </td>
              <td><!-- RES OF. PARTS-->
                @php $flag = 0; @endphp
                @foreach($agreement->stages as $stage)
                        @if($stage->type == 'OfParte' AND $stage->group == 'RES')
                           <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link" data-toggle="modal"
                                data-target="#editModalDateStage"
                                data-stage_id="{{ $stage->id }}"
                                data-agreement_id="{{ $stage->agreement_id }}"
                                data-stage="{{ $stage->type }}"
                                data-observation="{{ $stage->observation }}"
                                data-file="{{ $stage->file ?  route('agreements.stage.download', $stage->id)   : null  }}"
                                data-date="{{ $stage->date->format('Y-m-d') }}"
                                data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                data-formaction="{{ route('agreements.stage.update', $stage->id )}}">
                                @if($stage->dateEnd)
                                  <i class="fas fa-check text-success"></i>
                                @else
                                  <i class="fas fa-check text-warning"></i>
                                @endif
                                </button>
                                @php $flag = 1; @endphp
                                <!-- SI EXISTE UN ADENDUM EN EL CONVENIO -->
                                @if (!$agreement->addendums->isEmpty())
                                 <hr class="mt-0 mb-1"/>
                                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;display: block;" class="btn btn-link" data-toggle="modal"
                                    data-target="#editModalDateStageAddendum"
                                    data-stage_id="{{ $stage->id }}"
                                    data-agreement_id="{{ $stage->agreement_id }}"
                                    data-stage="{{ $stage->type }}"
                                    data-file="{{ $agreement->file ?  route('agreements.download', $agreement->id)   : null  }}"
                                    data-date="{{ $stage->date->format('Y-m-d') }}"
                                    data-date_end="{{ $stage->dateEnd ? $stage->dateEnd->format('Y-m-d') : null }}"
                                    data-date_addendum="{{ $stage->date_addendum ? $stage->date_addendum : null }}"
                                    data-date_end_addendum="{{ $stage->dateEnd_addendum ? $stage->dateEnd_addendum : null }}"
                                    data-formaction="{{ route('agreements.stage.update', $stage->id )}}">
                                    @if($stage->dateEnd_addendum)
                                      <i class="fas fa-check text-primary"></i>
                                    @else
                                      <i class="fas fa-check text-secondary"></i>
                                    @endif
                                    </button>
                                @endif
                        @endif
                @endforeach
                 @if ($flag==0)
                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;" class="btn btn-link text-secondary" data-toggle="modal"
                        data-target="#addModalDateStage"
                        data-stage_id=""
                        data-agreement_id="{{ $agreement->id }}"
                        data-stage="OfParte"
                        data-group="RES"
                        data-formaction="{{ route('agreements.stage.store', $agreement->id )}}"><i class="fas fa-ellipsis-h"></i></button>
                @endif</td>
              <td>
                @if($agreement->fileResEnd != null)  
                  <a class="btn btn-link text-info" style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;" href="{{ route('agreements.downloadRes', $agreement->id) }}" target="_blank">
                    {{ $agreement->res_exempt_number }}
                  </a>
                @else
                    {{ $agreement->res_exempt_number }}
                @endif

                @if (!$agreement->addendums->isEmpty())
                  <hr class="mt-0 mb-1"/>
                  @if($agreement->addendums->first()->res_file != null) 
                  <a class="btn btn-link text-info" style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;" href="{{ route('agreements.addendum.downloadRes', $agreement->addendums->first()) }}" target="_blank">{{ $agreement->addendums->first()->res_number }}</a>
                  @else
                  {{ $agreement->addendums->first()->res_number }}
                  @endif
                @endif

                @if (!$agreement->continuities->isEmpty())
                  <hr class="mt-0 mb-1"/>
                  @if($agreement->continuities->first()->res_file != null) 
                  <a class="btn btn-link text-info" style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;" href="{{ route('agreements.continuity.downloadRes', $agreement->continuities->first()) }}" target="_blank">{{ $agreement->continuities->first()->res_number }}</a>
                  @else
                  {{ $agreement->continuities->first()->res_number }}
                  @endif
                @endif
              </td>
            </tr>
            @endforeach
        </tbody>
    </table>
{{ $agreements->withQueryString()->links() }}
@include('agreements/agreements/modal_edit_date_stage')
@include('agreements/agreements/modal_add_date_stage')
@include('agreements/agreements/modal_edit_date_addendum_stage')

@endsection

@section('custom_js')
<script type="text/javascript">
    $('[data-toggle="tooltip"]').tooltip()
    $('#editModalDateStage').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var modal  = $(this)
        console.log(button.data('date_end'));
        modal.find('input[name="id"]').val(button.data('stage_id'))
        modal.find('input[name="agreement_id"]').val(button.data('agreement_id'))
        modal.find('input[name="type"]').val(button.data('stage'))
        modal.find('input[name="observation"]').val(button.data('observation'))
        
        //console.log(button.data('file'))
        if(button.data('file')){
          modal.find('#iconfile').attr("class"," fas fa-file-download text-info")
          modal.find('#urlfile').attr("href",button.data('file'))
        }
        else {
          modal.find('#iconfile').attr("class","fas fa-exclamation-circle text-light") //
          modal.find('#urlfile').attr("href","#")
        }
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

    //ADDENDUM STAGE EDIT
     $('#editModalDateStageAddendum').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var modal  = $(this)
        console.log(button.data('date_end'));
        modal.find('input[name="id"]').val(button.data('stage_id'))
        modal.find('input[name="agreement_id"]').val(button.data('agreement_id'))
        modal.find('input[name="type"]').val(button.data('stage'))
        //console.log(button.data('file'))
        if(button.data('file')){
          modal.find('#iconfile').attr("class"," fas fa-file-download text-info")
          modal.find('#urlfile').attr("href",button.data('file'))
        }
        else {
          modal.find('#iconfile').attr("class","fas fa-exclamation-circle text-light") //
          modal.find('#urlfile').attr("href","#")
        }
        modal.find('input[name="date"]').val(button.data('date'))
        modal.find('input[name="dateEnd"]').val(button.data('date_end'))
        modal.find('input[name="date_addendum"]').val(button.data('date_addendum'))
        modal.find('input[name="dateEnd_addendum"]').val(button.data('date_end_addendum'))
        modal.find("#form-edit").attr('action', button.data('formaction'))
    })
</script>
@endsection
