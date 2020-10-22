<nav class="navbar navbar-expand-lg navbar-dark bg-nav-gobierno">

    <!-- Branding Image -->
    <a class="navbar-brand" href="{{ route('ehr.patient.index') }}">
        {{ config('app.name') }}
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse"
        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Left Side Of Navbar -->

        <!-- Authentication Links -->

        <ul class="navbar-nav mr-auto">

            @role('dev')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('ehr.patient.index') }}">
                <i class="fas fa-heartbeat"></i> EHR</a>
            </li>
            @endrole

        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">

            <!-- Authentication Links -->
            @guest
            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a></li>
            @else

            <li class="nav-item dropdown">

                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @if(config('app.debug') == true)
                        <span class="badge badge-pill badge-danger">Debug</span>
                    @endif

                    @if(session()->has('god'))<i class="fas fa-eye text-danger"></i>@endif

                    {{ Auth::user()->name }}

                </a>


                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                    <a class="dropdown-item"
                        href="{{ route('password.edit') }}"><i class="fas fa-key fa-fw"></i> Cambiar Clave</a>

                    @if(session()->has('god'))
                        <a class="dropdown-item" href="{{ route('rrhh.users.switch', session('god')) }}">
                            <i class="fas fa-eye text-danger"></i> God Like
                        </a>
                    @endif

                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt fa-fw"></i>
                        Cerrar Sesión
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>

                </div>
            </li>
            @endguest

        </ul>

    </div>
</nav>
