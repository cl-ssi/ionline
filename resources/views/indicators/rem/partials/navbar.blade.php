<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        @foreach(collect(request()->segments()) as $segment)
            <li class="breadcrumb-item" @if($loop->last) active @endif>
                @php $path[] = $segment; @endphp

                {{-- Si no es el último loop --}}
                @if(!$loop->last)
                    {{-- Si tiene más de tres niveles entonces utiliza variables en la ruta --}}
                    @if( $loop->iteration > 3 )
                        {{-- Genera la ruta tipo: indicators.rems.{year}.{serie}.index --}}
                        <a href="{{ route('indicators.rem.index', [
                            collect(request()->segments())[$loop->index-1],
                            $prestacion->serie]) }}">
                    @elseif($loop->iteration == 3 )
                    <a href="{{ route('indicators.rem.list', collect(request()->segments())[$loop->index]) }}">
                    @elseif($loop->iteration == 2 )
                        <a href="{{ route('indicators.rems.index') }}">
                    @else
                        {{-- Ruta estática sin variables --}}
                        <a href="{{ route('indicators.index') }}">
                    @endif
                @endif

                {{-- Traduce o hermosea algunos strings --}}
                @switch($segment)
                    @case('indicators') Indicadores     @break
                    @case('rem')       REM             @break
                    @default
                        {{ ucfirst(str_replace('_',' ',$segment)) }}
                        @break
                @endswitch


                @if(!$loop->last)
                    </a>
                @endif
            </li>

        @endforeach
    </ol>
</nav>
