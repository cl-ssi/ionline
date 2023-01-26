<ul class="nav nav-tabs mb-4 d-print-none">

    <li class="nav-item">
        <a class="nav-link {{active('requirements.create_requirement_sin_parte')}}"
            href="{{ route('requirements.create_requirement_sin_parte') }}">
            <i class="fas fa-plus"></i>
            Nuevo requerimiento
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ active('requirements.inbox')}}"
            href="{{ route('requirements.inbox') }}">
            <i class="fas fa-inbox"></i>
            Bandeja
        </a>
    </li>


    <li class="nav-item">
        <a class="nav-link {{active('requirements.labels.index')}}"
            href="{{ route('requirements.labels.index') }}">
            <i class="fas fa-tags"></i>
            Etiquetas
        </a>
    </li>
    
    <li class="nav-item">
        <a class="nav-link {{active('requirements.categories')}}"
            href="{{ route('requirements.categories') }}">
            <i class="fas fa-copyright"></i>
            Categorías
        </a>
    </li>


</ul>
