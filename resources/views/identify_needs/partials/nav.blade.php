@can('Identify Need: create')
<ul class="nav nav-tabs">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><i class="fas fa-inbox"></i> DNC</a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('identify_need.create') }}"><i class="fas fa-plus"></i> Crear DNC</a></li>
            <li><hr class="dropdown-divider"></li>
            <!-- <li><a class="dropdown-item" href="{{ route('news.index') }}"><i class="fas fa-inbox"></i> Todas Las Noticias</a></li> -->
            <li><a class="dropdown-item" href="{{ route('identify_need.own_index') }}"><i class="fas fa-inbox"></i> Mis DNC</a></li>
        </ul>
    </li>
</ul>
@endcan