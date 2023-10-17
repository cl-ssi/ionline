<!-- <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-1 mb-1 text-muted">
    <span>Mi información</span>
    <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
    <span data-feather="plus-circle"></span>
    </a>
</h6>
<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link {{ active('profile.observation.index') }}" href="#">
        <span data-feather="user"></span>
        Mis exámenes<span class="sr-only"></span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ active(['profile.show', 'profile.edit']) }}" href="#">
        <span data-feather="user"></span>
        Mi perfíl<span class="sr-only"></span>
        </a>
    </li>
</ul> -->


<!-- <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-1 mb-1 text-muted">
    <span>Pacientes</span>
    <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
    <span data-feather="plus-circle"></span>
    </a>
</h6>
<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link {{ active('patient.index') }}" href="#">
        <span data-feather="users"></span>
        Ver todos<span class="sr-only">(current)</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ active('patient.create') }}" href="#">
        <span data-feather="plus-circle"></span>
        Ingresar nuevo
        </a>
    </li>
</ul> -->


<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-1 mb-1 text-muted">
    <span>Staff de Reemplazo</span>
    <a class="d-flex align-items-center text-muted" href="{{ route('replacement_staff.create') }}" aria-label="Ver Mis datos">
    <span data-feather="plus-circle"></span>
    </a>
</h6>
<ul class="nav flex-column">
    <!-- <li class="nav-item">
        <a class="nav-link {{ active('patient.index') }}" href="{{ route('replacement_staff.create') }}">
        <span data-feather="users"></span>
        Mis Datos<span class="sr-only">(current)</span>
        </a>
    </li> -->
<!-- <li class="nav-item">
        <a class="nav-link {{ active('patient.create') }}" href="#">
        <span data-feather="plus-circle"></span>
        Ingresar nuevo
        </a>
    </li> -->
</ul>



<!-- <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-1 mb-1 text-muted">
    <span>Administrador</span>
    <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
    <span data-feather="plus-circle"></span>
    </a>
</h6>
<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link {{ active('parameter.permission.index') }}" href="#">
        <span data-feather="lock"></span>
        Permisos<span class="sr-only">(current)</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ active('user.edit') }}" href="#">
        <span data-feather="unlock"></span>
        Mis permisos
        </a>
    </li>
</ul> -->

@can('Suitability: admin')
@php
$schools = App\Models\Suitability\SchoolUser::where('user_external_id',Auth::guard('external')->user()->id)->get();
@endphp
<a class="nav-link" href="{{ route('idoneidad.downloadManualAdministrator') }}" target="_blank">Descargar Manual Administrador</a>
@foreach($schools as $school)
<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-1 mb-1 text-muted">
    <span>{{ $school->school->name}}</span>
    <!-- <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
        <span data-feather="plus-circle"></span>
    </a> -->
    <span data-feather="book-open"></span>
</h6>
<ul class="nav flex-column">

    <li class="nav-item">
        <a class="nav-link {{ active('parameter.permission.index') }}" href="{{ route('idoneidad.createExternal', $school->school->id) }}">
            <span data-feather="file-plus"></span>
            Crear Solicitud<span class="sr-only">(current)</span>
        </a>
        <a class="nav-link {{ active('parameter.permission.index') }}" href="{{ route('idoneidad.listOwn', $school->school->id) }}">
            <span data-feather="list"></span>
            Mis Solicitudes<span class="sr-only">(current)</span>
        </a>
    </li>
    @endforeach
</ul>
@endcan


@php
$psirequests = App\Models\Suitability\PsiRequest::where('user_external_id',Auth::guard('external')->user()->id)->where('status','Esperando Test')->get();
@endphp

@if($psirequests->isNotEmpty())
<a class="nav-link" href="{{ route('idoneidad.downloadManualUser') }}" target="_blank">Descargar Manual Usuario</a>

<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-1 mb-1 text-muted">
    <span>Test de Idoneidad</span>
    <span data-feather="file-text"></span>
</h6>

<ul class="nav flex-column">
    @foreach($psirequests as $psirequest)
    <li class="nav-item">
    <form action="{{ route('idoneidad.updateStatus', $psirequest) }}" method="POST">
        @csrf
        @method('PATCH')
        <button type="submit" class="btn btn-danger float-left"><i  onclick="return confirm('Al momento de apretar en aceptar, usted tendrá 45 minutos para poder realizar el Test de Idoneidad, TODAS las preguntas deben ser respondidas, no tendrá más oportunidades, luego de realizado este test. Por favor asegurarse que posea buena conexión a internet. ¿Está seguro que desea rendir el test?')">Realizar test para cargo <br>{{$psirequest->job}} ({{$psirequest->school->name}})</i></button>
    </form>
    </li>


    @endforeach
</ul>
@endif









<ul class="nav flex-column">
    <li class="nav-item border-top">
        <a class="nav-link" href="{{ route('logout') }}">
            <span data-feather="log-out"></span>
            Cerrar sesión
        </a>
    </li>
</ul>
