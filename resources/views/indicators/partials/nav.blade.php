<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        {{-- Si tienen más de 5 niveles la ruta entonces es una edición de un parametro--}}
        {{-- No mostraré el breacrumb --}}
        {{-- FIXME: ver como mostrar el breadcrumb --}}
        @if(collect(request()->segments())->count() <= 5)


            @foreach(collect(request()->segments()) as $segment)

                <li class="breadcrumb-item" @if($loop->last) active @endif>
                    @php $path[] = $segment; @endphp

                    @if(!$loop->last)
                        <a href="{{ route(implode('.',$path).'.index') }}">
                    @endif


                    @switch($segment)
                        @case('indicators') Indicadores     @break
                        @case('19813')      Ley 19.813      @break
                        @case('19664')      Ley 19.664      @break
                        @case('18834')      Ley 18.834      @break
                        @case('iaaps')      IAAPS           @break
                        @case('program_aps') Programación APS @break
                        @case('aps') Indicadores APS @break
                        @case('depsev') Dependencia Severa @break
                        @case('saserep') Salud Sexual y Reproductiva @break
                        @case('ges_odont') GES Odontológico @break
                        @case('sembrando_sonrisas') Sembrando Sonrisas @break
                        @case('mejoramiento_atencion_odontologica') Mejoramiento Atención Odontológica @break
                        @case('pespi') PESPI @break
                        @default
                            {{ ucfirst(str_replace('_',' ',$segment)) }}
                            @break
                    @endswitch


                    @if(!$loop->last)
                        </a>
                    @endif
                </li>
            @endforeach

        @endif
    </ol>
</nav>
