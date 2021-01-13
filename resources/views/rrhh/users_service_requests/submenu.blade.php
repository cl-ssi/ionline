<ul class="nav nav-tabs">
	<li class="nav-item">
		<a class="nav-link" href="{{ route('rrhh.users.service_requests.index') }}"><span class="fas fa-search"></span> </a>
	</li>

	<li class="nav-item">
		<a class="nav-link @if(Route::currentRouteName()=='rrhh.users.service_requests.edit')active @endif" href="{{ route('rrhh.users.service_requests.edit',$user->id) }}">
			<span class="fas fa-user"></span> <span class="d-none d-sm-inline"> Perfil</span></a>
	</li>

	<!-- @can('Users: assign permission')
	<li class="nav-item">
		<a class="nav-link @if(Route::currentRouteName()=='rrhh.roles.index')active @endif" href="{{ route('rrhh.roles.index', $user->id) }}">
			<span class="fas fa-wrench"></span> <span class="d-none d-sm-inline"> Permisos</span></a>
	</li>
	@endcan -->

</ul>

<br>
