<ul class="nav nav-tabs mb-3 d-print-none">
    <li class="nav-item active">
        <a class="nav-link"
            href="{{ route('request_forms.create') }}">
            <i class="fas fa-pencil-alt"></i> Nuevo
        </a>
    </li>
    <li class="nav-item active">
        <a class="nav-link"
            href="{{ route('request_forms.index') }}">
            <i class="fas fa-inbox"></i> Mis Formularios
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('request_forms.my_request_inbox') }}">
            <i class="fas fa-inbox"></i> Mis Solicitudes
            <span class="badge badge-secondary">{{ App\Utilities::getPendingSignature() }}</span></a>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('request_forms.authorize_inbox') }}">
            <i class="fas fa-inbox"></i> Autorizar
            <span class="badge badge-secondary">{{ App\Utilities::getPendingSignatureAuthorize() }}</span></a>
        </a>
    </li>
    @if(App\Utilities::getAmIDirector() == 1)
    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('request_forms.director_inbox') }}">
            <i class="fas fa-inbox"></i> Director
            <span class="badge badge-secondary">{{ App\Utilities::getPendingDirectorAuthorize() }}</span></a>
        </a>
    </li>
    @endif
    @can('Request Forms: Finance add item code')
    <li class="nav-item">
        <a class="nav-link"
            href="{{ route('request_forms.finance_inbox') }}">
            <i class="fas fa-inbox"></i> Finanzas
            <span class="badge badge-secondary">{{ App\Utilities::getPendingDirectorAuthorize() }}</span></a>
        </a>
    </li>
    @endcan
    @can('Request Forms: supplying')
    <li class="nav-item">
        <a class="nav-link"
            href="">
            <i class="fas fa-inbox"></i> Abastecimiento
            <span class="badge badge-secondary"></span></a>
        </a>
    </li>
    @endcan
</ul>
