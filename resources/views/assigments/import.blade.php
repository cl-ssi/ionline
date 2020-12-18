@extends('layouts.app')

@section('title', 'Listado de casos')

@section('content')

<div class="card">
  <div class="card-body">

    <DIV align="right">
     <h5 class="mb-3">Existen <b>{{$assigments->count()}}</b> filas cargadas.</h5>
    </DIV>

    <h5>Carga Masiva</h5>
    <br>
    <form action="{{ route('assigment.import') }}" method="post" enctype="multipart/form-data">
        @csrf

        @method('POST')
        <div class="custom-file mb-3">
            <input type="file" class="custom-file-input"  name="file" required>
            <label class="custom-file-label" for="customFile" data-browse="Elegir">Seleccione el archivo excel...</label>
        </div>

        <!-- <div class="form-group">
            <label for="fordescription">Descripción:</label>
            <input type="text" class="form-control" id="fordescription" name="description">
        </div> -->

        <div class="mb-3">
            <button class="btn btn-primary float-right mb-3"><i class="fas fa-upload"></i> Cargar</button>
        </div>

    </form>
  </div>
</div>

<br>

<h5 class="mb-3">Funcionarios cargados</h5>

<div class="container">
  <div class="row">
    <div class="col-sm-1">
      <label for="exampleFormControlInput1">Tipo</label>
    </div>
    <div class="col-sm-4">
      <form action="{{ route('assigment.index') }}" method="GET" enctype="multipart/form-data">

      <select class="form-control" onchange="this.form.submit()" name="type">
        <option value="1" {{$request->type == 1 ? 'selected' : ''}}>% EST. JORN. PRIOR.</option>
        <option value="2" {{$request->type == 2 ? 'selected' : ''}}>% EST. COMPET. PROF.</option>
        <option value="3" {{$request->type == 3 ? 'selected' : ''}}>% EST. CONDICION ESPECIAL</option>
        <option value="4" {{$request->type == 4 ? 'selected' : ''}}>% EST. RIESGO</option>
        <option value="5" {{$request->type == 5 ? 'selected' : ''}}>% EST. LUGAR AISLADO</option>
        <option value="6" {{$request->type == 6 ? 'selected' : ''}}>% TURNO LLAMADA</option>
        <option value="7" {{$request->type == 7 ? 'selected' : ''}}>% RESIDENCIA HOSPIT.</option>
        <option value="8" {{$request->type == 8 ? 'selected' : ''}}>% PROG. DE ESPE.ART6 L19664</option>
      </select>

      </form>
    </div>
  </div>
</div>

<br>

<table class="table table-sm table-bordered table-striped small">
	<thead>
		<tr class="text-center">
      <th>Servicio</th>
      <th>Total</th>
      <!-- <th>EST. JORN. PRIOR</th> -->
		</tr>
	</thead>
	<tbody>

    @foreach($service_assigments as $key => $service_assigment)
    <?php $total = 0 ?>
      <tr>
        <td>{{$key}}</td>
        <td>
          @foreach($service_assigment as $key2 => $type)
            <?php $total += $type['cantidad'] ?>
          @endforeach
          {{$total}}
        </td>
        @foreach($service_assigment as $key2 => $type)
            <td>{{$key2}} - <a href="#" class="btn_{{ str_replace(')', '', str_replace('(', '',str_replace(' ', '',str_replace('.', '', $key)))) }}-{{str_replace('.', '',$key2)}}"
                               ><label style="cursor:pointer">[<b>{{$type['cantidad']}}</b>]</label>
                             </a>
            </td>
        @endforeach
      </tr>
    @endforeach
	</tbody>
</table>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detalles</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <table id="table" class="table table-sm" style="table-layout: fixed;word-wrap: break-word;">
          <thead>
            <tr>
              <!-- <th scope="col">#</th> -->
              <th scope="col">Rut</th>
              <th scope="col">Nombre</th>
              <th scope="col">Proceso</th>
              <th scope="col">Planta</th>
              <!-- <th scope="col">Unidad</th> -->
              <th scope="col">%</th>
              <th scope="col">$</th>
            </tr>
          </thead>
          <tbody>
            @foreach($assigments as $key => $assigment)

              @if($request->type == 1)
              <tr style="display:none"  class="row_{{str_replace(')', '', str_replace('(', '', str_replace(' ', '', str_replace('.', '', $assigment->unity))))}}-{{str_replace('.', '',$assigment->porc_est_jorn_prior)}}">
                <td>{{$assigment->name}}</td>
                <td>{{$assigment->rut}}</td>
                <td>{{$assigment->process}}</td>
                <td>{{$assigment->service}}</td>
                <td>{{$assigment->porc_est_jorn_prior}}</td>
                <td>{{$assigment->est_jorn_prior}}</td>
              </tr>
              @endif
              @if($request->type == 2)
              <tr style="display:none"  class="row_{{str_replace(')', '', str_replace('(', '', str_replace(' ', '', str_replace('.', '', $assigment->unity))))}}-{{str_replace('.', '',$assigment->porc_est_compet_prof)}}">
                <td>{{$assigment->name}}</td>
                <td>{{$assigment->rut}}</td>
                <td>{{$assigment->process}}</td>
                <td>{{$assigment->service}}</td>
                <td>{{$assigment->porc_est_compet_prof}}</td>
                <td>{{$assigment->est_compet_prof}}</td>
              </tr>
              @endif
              @if($request->type == 3)
              <tr style="display:none"  class="row_{{str_replace(')', '', str_replace('(', '', str_replace(' ', '', str_replace('.', '', $assigment->unity))))}}-{{str_replace('.', '',$assigment->porc_est_cond_especial)}}">
                <td>{{$assigment->name}}</td>
                <td>{{$assigment->rut}}</td>
                <td>{{$assigment->process}}</td>
                <td>{{$assigment->service}}</td>
                <td>{{$assigment->porc_est_cond_especial}}</td>
                <td>{{$assigment->est_cond_especial}}</td>
              </tr>
              @endif
              @if($request->type == 4)
              <tr style="display:none"  class="row_{{str_replace(')', '', str_replace('(', '', str_replace(' ', '', str_replace('.', '', $assigment->unity))))}}-{{str_replace('.', '',$assigment->porc_est_riesgo)}}">
                <td>{{$assigment->name}}</td>
                <td>{{$assigment->rut}}</td>
                <td>{{$assigment->process}}</td>
                <td>{{$assigment->service}}</td>
                <td>{{$assigment->porc_est_riesgo}}</td>
                <td>{{$assigment->est_riesgo}}</td>
              </tr>
              @endif
              @if($request->type == 5)
              <tr style="display:none"  class="row_{{str_replace(')', '', str_replace('(', '', str_replace(' ', '', str_replace('.', '', $assigment->unity))))}}-{{str_replace('.', '',$assigment->porc_est_lugar_aislado)}}">
                <td>{{$assigment->name}}</td>
                <td>{{$assigment->rut}}</td>
                <td>{{$assigment->process}}</td>
                <td>{{$assigment->service}}</td>
                <td>{{$assigment->porc_est_lugar_aislado}}</td>
                <td>{{$assigment->est_lugar_aislado}}</td>
              </tr>
              @endif
              @if($request->type == 6)
              <tr style="display:none"  class="row_{{str_replace(')', '', str_replace('(', '', str_replace(' ', '', str_replace('.', '', $assigment->unity))))}}-{{str_replace('.', '',$assigment->porc_est_turno_llamada)}}">
                <td>{{$assigment->name}}</td>
                <td>{{$assigment->rut}}</td>
                <td>{{$assigment->process}}</td>
                <td>{{$assigment->service}}</td>
                <td>{{$assigment->porc_est_turno_llamada}}</td>
                <td>No está</td>
              </tr>
              @endif
              @if($request->type == 7)
              <tr style="display:none"  class="row_{{str_replace(')', '', str_replace('(', '', str_replace(' ', '', str_replace('.', '', $assigment->unity))))}}-{{str_replace('.', '',$assigment->porc_est_resid_hosp)}}">
                <td>{{$assigment->name}}</td>
                <td>{{$assigment->rut}}</td>
                <td>{{$assigment->process}}</td>
                <td>{{$assigment->service}}</td>
                <td>{{$assigment->porc_est_resid_hosp}}</td>
                <td>{{$assigment->est_resid_hosp}}</td>
              </tr>
              @endif
              @if($request->type == 8)
              <tr style="display:none"  class="row_{{str_replace(')', '', str_replace('(', '', str_replace(' ', '', str_replace('.', '', $assigment->unity))))}}-{{str_replace('.', '',$assigment->porc_prof_espe_art_16)}}">
                <td>{{$assigment->name}}</td>
                <td>{{$assigment->rut}}</td>
                <td>{{$assigment->process}}</td>
                <td>{{$assigment->service}}</td>
                <td>{{$assigment->porc_prof_espe_art_16}}</td>
                <td>No está</td>
              </tr>
              @endif
            @endforeach
          </tbody>
        </table>

        <!-- 'process', 'invoice', 'payment_year', 'payment_month', 'accrual_year', 'accrual_month', 'rut', 'correlative', 'payment_correlative',
        'name', 'establishment', 'legal_quality', 'hours', 'bienio', 'service', 'unity', 'porc_est_jorn_prior',  'porc_est_compet_prof', 'porc_est_cond_especial',
         'porc_est_riesgo', 'porc_est_lugar_aislado', 'porc_est_turno_llamada', 'porc_est_resid_hosp', 'porc_prof_espe_art_16', 'assets_total', 'base_salary', 'antiquity',
         'experience', 'responsibility', 'est_jorn_prior', 'est_compet_prof', 'est_condic_lugar', 'zone_asignation', 'est_cond_especial', 'est_resid_hosp', 'est_prog_especiali',
         'est_riesgo', 'est_lugar_aislado', 'asig_permanencia' -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>



@endsection

@section('custom_js')

<script>
  // Add the following code if you want the name of the file appear on select
  $(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
  });

    $(document).ready(function(){

		@foreach($service_assigments as $key => $service_assigment)

      @foreach($service_assigment as $key2 => $type)

        $('.btn_{{ str_replace(')', '', str_replace('(', '',str_replace(' ', '', str_replace('.', '', $key)))) }}-{{str_replace('.', '',$key2)}}').click(function(){

          // alert('{{$key2}}');
          // alert($('.btn_{{ str_replace(')', '', str_replace('(', '',str_replace(' ', '', str_replace('.', '', $key)))) }}').attr('class').split(' ')[1]);

          $('#table').find('tr').hide();
          // // alert($(".row_{{ str_replace(' ', '', str_replace('.', '', $assigment->unity)) }}"));
          $('.row_{{ str_replace(')', '', str_replace('(', '', str_replace(' ', '', str_replace('.', '', $key)))) }}-{{str_replace('.', '',$key2)}}').toggle();
          // // console.log($('.row_{{ str_replace(')', '', str_replace('(', '', str_replace(' ', '', str_replace('.', '', $key)))) }}'));
          $('#exampleModal').modal('show');
        });
      @endforeach

		@endforeach



    });
</script>

@endsection
