@extends('layouts.external')

@section('content')

<!-- <div class="jumbotron">
  <h1 class="display-4">Bienvenido!</h1>
  <p class="lead">Te presentamos el nuevo portal externo del Servicio de Salud Iquique.</p>
</div> -->

<br>

<h1 class="display-4">Bienvenido!</h1>
<!-- <h5 class="display-5">Este es el nuevo portal externo del Servicio de Salud Iquique.</h5> -->

<hr>

<div class="row">
  <div class="col-sm-4">
    <div class="card">
      <img src="{{ asset('images/logo_rys_2021.jpg') }}" style="width: 80%; align: center;" class="card-img-top" alt="RyS Logo 2021">
      <div class="card-body">
        <h5 class="card-title">Reclutamiento y Selección</h5>
        <p class="card-text" align="justify">
            Ingresa tus antecedentes curriculares para postular al <b>Staff de Reemplazos</b>
            de la Unidad de Reclutamiento y Selección del Servicio de Salud Iquique.
            <br><br>
            Las postulaciones realizadas por este medio no son vinculantes a las convocatorias
            publicadas en portal de <b>Empleos Públicos</b> y/o en la página web del <b>Servicio de Salud Iquique</b>.
        </p>
        <a href="{{ route('replacement_staff.create') }}" class="btn btn-primary">Ir</a>
      </div>
    </div>
  </div>
  <!-- Se informa que es necesario llenar cada apartado requerido con la información y
  adjuntos correspondientes, en razón de hacer efectiva su postulación al estamento o
  perfil de cargo de su interés y competencias. -->
  <div class="col-sm-4">
    <!-- <div class="card">
      <img src="..." style="width: 80%; align: center;" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title"></h5>
        <p class="card-text" align="justify">

        </p>
        <a href="#" class="btn btn-primary">Ir</a>
      </div>
    </div> -->
  </div>
  <div class="col-sm-4">
    <!-- <div class="card">
      <img src="..." style="width: 80%; align: center;" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title"></h5>
        <p class="card-text" align="justify">

        </p>
        <a href="#" class="btn btn-primary">Ir</a>
      </div>
    </div>
  </div> -->
</div>



@endsection
