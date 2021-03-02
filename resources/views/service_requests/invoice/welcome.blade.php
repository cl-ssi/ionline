@extends('layouts.guest')

@section('title', 'Información sobre funcionarios a Honorarios')

@section('content')
<h3 class="mb-3">Información para funcionarios a honorarios</h3>


<ul>
    <li>Está dirigido a funcionarios que poseen contrato a Honorario para la DSSI</li>
    <li>Podrás ver el estado de tus solicitudes de pago</li>     
</ul>


<div class="alert alert-secondary mt-3 text-center" role="alert">
    <h4 class="alert-heading">Consultar sobre solicitudes de pago</h4>
    <!-- Código para visualizar botón oficial iniciar sesión con ClaveÚnica-->
    <div class="row justify-content-center">
        <a class="btn-cu btn-m btn-color-estandar" title="Este es el botón Iniciar sesión de ClaveÚnica"
            href="{{ route('claveunica.autenticar') }}?redirect=L2ludm9pY2UvbG9naW4=">
            <span class="cl-claveunica"></span>
            <span class="texto">Iniciar sesión</span>
        </a>
    <!--./ fin botón-->
    </div>
</div>


<div class="alert alert-info mt-3" role="alert">
    Si no tienes clave única, Acercate a tu sucursal de registro civil a pedir una    
</div>

@endsection

@section('custom_js')

@endsection
