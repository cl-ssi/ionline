<!-- resources/views/partials/unidad.blade.php -->
<li>
    {{ $unidad['descripcion'] }} <span class="small text-muted">{{ $unidad['codigo'] }}</span>
    @if (count($unidad['children']) > 0)
        <ol>
            @foreach ($unidad['children'] as $child)
                @include('partials.unidad', ['unidad' => $child])
            @endforeach
        </ol>
    @endif
</li>
