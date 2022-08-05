<ul class="nav nav-tabs mb-4">

    @can('Integrity: manage complaints')
    <li class="nav-item">
        <a class="nav-link {{ active('rrhh/integrity/complaints') }}"
            href="{{ route('rrhh.integrity.complaints.index') }}">Administrador</a>
    </li>
    @endcan

    @role('dev')
    <li class="nav-item">
        <a class="nav-link {{ active('rrhh/integrity/complaints/mail') }}" href="{{ route('rrhh.integrity.complaints.mail',1) }}">Formato e-mail</a>
    </li>
    @endrole

    <li class="nav-item">
        <a class="nav-link {{ active('rrhh/integrity/complaints/create') }}" target="_blank"
            href="{{ route('rrhh.integrity.complaints.create') }}">
            <i class="fas fa-external-link-alt"></i> Nueva</a>
    </li>
</ul>
