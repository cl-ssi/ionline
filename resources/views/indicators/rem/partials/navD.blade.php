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
                        <a href="{{ route('indicators.rems.year.serie.index', [
                            collect(request()->segments())[$loop->index-1],
                            'serie_d']) }}">
                    @else
                        {{-- Ruta estática sin variables --}}
                        <a href="{{ route(implode('.', $path).'.index') }}">
                    @endif
                @endif

                {{-- Traduce o hermosea algunos strings --}}
                @switch($segment)
                    @case('indicators') Indicadores     @break
                    @case('rems')       REM             @break
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
