

<li class="parent_li">
    <a href="{{ route($route, [$establishment,$array['id']]) }}">{{ $array['name'] }}</a>

    @if(array_key_exists('children',$array))

        @foreach($array['children'] as $key => $nodo)
            @if ($key === array_key_first($array['children']))
                <ul>
            @endif

            @include('parameters.establishments.partials.nodo',[
                'array' => $nodo,
                'route' => $route,
            ])

            @if ($key === array_key_last($array['children']))
                </ul>
            @endif
        @endforeach
    @else 
        </li>
    @endif