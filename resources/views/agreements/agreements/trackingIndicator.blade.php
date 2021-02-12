@extends('layouts.app')

@section('title', 'Listado de Convenios')

@section('content')

@include('agreements/nav')



<form class="form-inline float-right small" method="GET" action="{{ route('agreements.tracking.index') }}">
	<div class="input-group mb-6">  
  <select name="commune" id="formprogram" class="form-control">
                    <option value="">Todas</option>
                @foreach($communes as $commune)
                    <option value="{{ $commune->id }}" {{ request()->commune == $commune->id ? 'selected' : '' }}>{{ $commune->name }}</option>
                @endforeach
    </select>
    <select name="period" class="form-control">
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

<h3 class="mb-3">Seguimiento de Convenios</h3>
<br>


<table class="table table-striped  btn-table table-sm table-bordered table-condensed fixed_headers table-hover "><!-- table-responsive -->
    <thead>
            <tr class="small">
              <th class="text-center table-light" colspan="2"></th>
              <th class="text-center align-middle table-dark" colspan="7">CONVENIO</th>
              <th class="text-center align-middle table-secondary" colspan="7">RESOLUCIÓN</th>
            </tr>
            <tr class="small" style="font-size:70%;">
              <th class="text-center">#</th>
              <th>NOMBRE</th>
              <th>COMUNA</th>
              <th class="text-center" data-toggle="tooltip" title="Referente Técnico">RTP</th>
              <th class="text-center" data-toggle="tooltip" title="Dpto. Jurídico" colspan="1">DAJ</th>
              <th class="text-center" data-toggle="tooltip" title="Director Atención Primaría" colspan="1">DAP</th>
              <th class="text-center" data-toggle="tooltip" title="Dpto. Finanzas" colspan="1">DGF</th>
              <th class="text-center" data-toggle="tooltip" title="SDGA" colspan="1">SDGA</th>
              <th class="text-center" data-toggle="tooltip" title="Firma Alcalde" colspan="1" >COMUNA</th>

              <th class="text-center" data-toggle="tooltip" title="Referente Técnico" colspan="1" style="border-left: 3px solid #c0c0c0">RTP</th>
              <th class="text-center" data-toggle="tooltip" title="Dpto. Jurídico" colspan="1">DAJ</th>
              <th class="text-center" data-toggle="tooltip" title="Director Atención Primaría" colspan="1">DAP</th>
              <th class="text-center" data-toggle="tooltip" title="Dpto. Finanzas" colspan="1">DGF</th>
              <th class="text-center" data-toggle="tooltip" title="SDGA" colspan="1">SDGA</th>
              <th class="text-center" data-toggle="tooltip" title="Oficina de Parte" colspan="1">OF.PARTE</th>
              <th class="text-center" data-toggle="tooltip" title="Nro. Resolución" colspan="1">RES</th>

            </tr>
        </thead>
        <tbody style="font-size:65%;">
            @foreach($agreements as $agreement)
            <tr>
              <th scope="row" class="text-center">
                <a href="{{ route('agreements.show', $agreement->id) }}" class="">{{ $agreement->id }}</a>
              </th>
              <td>
              <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;" data-toggle="collapse" data-target="#coll{{ $agreement->id }}">+ {{ $agreement->program->name }}</button>
                <div id="coll{{ $agreement->id }}" class="collapse" >
                  <ul class="small" >
                    @foreach($agreement->agreement_amounts as $amount)
                        <li>{{ $amount->program_component->name }}</li>
                    @endforeach
                  </ul>
                </div>
                 @if (!$agreement->addendums->isEmpty())
                   <hr class="mt-0 mb-1"/>
                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px;" class="text-secondary" > -> Incluye Addendum</button>
                 @endif
              </td>
              <td>{{ $agreement->commune->name }}
              </td>
              <td><!-- RTP -->
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
                 @if ($flag==0)
                    <button style ="outline: none !important;padding-top: 0;border: 0;vertical-align: baseline; font-size:10px; text-align: center;" class="btn btn-link text-secondary text-center" data-toggle="modal"
                        data-target="#addModalDateStage"
                        data-stage_id=""
                        data-agreement_id="{{ $agreement->id }}"
                        data-stage="RTP"
                        data-group="CON"
                        data-formaction="{{ route('agreements.stage.store', $agreement->id )}}">
                        <i class="fas fa-ellipsis-h"></i></button>
                @endif

              </td>
              <td><!-- DAJ IN -->
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
              </td>
              <td><!-- DAP IN -->
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
              </td>
              <td><!-- DGF IN -->
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
              </td>
              <td><!-- SDGA IN -->
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
                {{ $agreement->res_exempt_number }}
                @if (!$agreement->addendums->isEmpty())
                  <hr class="mt-0 mb-1"/>
                  @foreach($agreement->addendums as $addendum)
                    <span class="text-secondary">{{$addendum->number}}</span>
                  @endforeach
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
