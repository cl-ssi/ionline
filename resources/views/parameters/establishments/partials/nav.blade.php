<ul class="nav nav-tabs mb-3 d-print-none">

    @foreach($establishments as $estab)
        
    <li class="nav-item">
        <a class="nav-link {{ active('rrhh.users.directory.eliminar') }}"
            href="{{ route('rrhh.users.directory',$estab) }}">
            <i class="fas fa-building"></i> {{ $estab->official_name }}
        </a>
    </li>

    @endforeach

</ul>
