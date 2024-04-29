<!-- resources/views/partials/unidad.blade.php -->
<li>
    {{ $unidad['descripcion'] }}
    <span class="small text-muted @if ($unidad['descripcion'] == '(NO EXISTE UNIDAD SUPERIOR)') text-danger @endif">{{ $unidad['codigo'] }}</span>
    @if (count($unidad['children']) > 0)
        <ol>
            {{-- {{ dd($unidad['children']) }} --}}
            @foreach ($unidad['children'] as $child)
                @include('partials.unidad', ['unidad' => $child])
            @endforeach
        </ol>
    @endif
</li>
