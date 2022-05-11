<small>
@switch($type)
    @case('segments.index')
        Segmentos
        @break
    @case('segments.edit')
        {{ $segment->name }}
        / Editar
        @break
    @case('families.index')
        <a href="{{ route('families.index', $segment) }}">{{ $segment->name }}</a>
        / Familias
        @break
    @case('families.edit')
        <a href="{{ route('families.index', $segment) }}">{{ $segment->name }}</a>
        / {{ $family->name }}
        / Editar
        @break
    @case('class.index')
        <a href="{{ route('families.index', $segment) }}">{{ $segment->name }}</a>
        / <a href="{{ route('class.index', ['segment' => $segment, 'family' => $family]) }}">{{ $family->name }}</a>
        / Clases
        @break
    @case('class.edit')
        <a href="{{ route('families.index', $segment) }}">{{ $segment->name }}</a>
        / <a href="{{ route('class.index', ['segment' => $segment, 'family' => $family]) }}">{{ $family->name }}</a>
        / {{ $class->name }}
        / Editar
        @break
    @case('products.index')
        <a href="{{ route('segments.index') }}">{{ $segment->name }}</a>
        / <a href="{{ route('families.index', ['segment' => $segment]) }}">{{ $family->name }}</a>
        / <a href="{{ route('class.index', ['segment' => $segment, 'family' => $family]) }}">{{ $class->name }}</a>
        / Productos
    @break
    @case('products.edit')
        <a href="{{ route('segments.index') }}">{{ $segment->name }}</a>
        / <a href="{{ route('families.index', ['segment' => $segment]) }}">{{ $family->name }}</a>
        / <a href="{{ route('class.index', ['segment' => $segment, 'family' => $family]) }}">{{ $class->name }}</a>
        / {{ $product->name }}
        / Editar
        @break
@endswitch
</small>
