<div>
    @include('rrhh.partials.nav')

    <h3 class="mb-3">Plantilla Firma de correo</h3>

    <style>
        .raya_rojo {
            color: #EE3A43;
            display: inline-block;
            font-family: "Arial Black",sans-serif;
            font-size: 24.0pt;
        }
        .raya_azul {
            color: #0168B3;
            display: inline-block;
            font-family: "Arial Black",sans-serif;
            font-size: 24.0pt;
        }
    </style>

    <div class="row g-2 mb-3">
        <div class="form-group col-6">
            <label for="pronom">Pronombres y artículo</label>
            <input type="text" class="form-control" id="pronom" wire:model.live.debounce.500ms="pronom" aria-describedby="pronom">
        </div>
        <div class="form-group col-6">
            <label for="personalPhone">Teléfono personal</label>
            <input type="text" class="form-control" id="personalPhone" wire:model.live.debounce.500ms="personalPhone" aria-describedby="personalPhone">
        </div>
    </div>

    @php($user = auth()->user())


    <strong>Formato de firma del Gobierno <a href="https://kitdigital.gob.cl/generador-de-firma">(Generador de firmas - Manual Normas Gráficas del Gobierno)</a></strong>
    
    <address class="border p-2 mb-3">
    Estimado {{ auth()->user()->shortName }}<br><br>
    El presente correo electrónico es para lorem ipsum, dolor sit amet consectetur adipisicing elit. Ut est sint iure minus accusantium quidem, eligendi in aut ab tempore nihil, modi iusto quasi. Tempora asperiores quas rem libero iusto?
    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Corporis deleniti, aspernatur, autem pariatur dolores magni, soluta fugiat nostrum omnis voluptatum voluptas ipsum ut dolore eum libero! Accusantium odio omnis ipsam.
    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Incidunt nostrum ratione repellendus dolor, eligendi necessitatibus saepe odit, illum, voluptatum eaque odio culpa minus nisi ullam voluptatem perferendis error labore expedita.
    <br><br>

        <span class="raya_azul">━━━</span><span class="raya_rojo">━━━━━</span><br>

        <span class="small">
            <strong>{{ $user->shortName }}
                @if($pronom)
                ({{ $pronom }})
                @endif
            </strong>
        </span>

        <br>

        @if($user->position)
            <span class="text-muted small">
                @if($user->position == 'Jefe' OR
                    $user->position == 'Director' OR
                    $user->position == 'Jefa' OR
                    $user->position == 'Directora')
                        {{ $user->position }}
                @elseif($user->position != NULL)
                    <em>{{ $user->position }}</em>
                @endif
            </span>
            <br>
        @endif

        @if($user->organizationalUnit)
        <span class="small">{{ $user->organizationalUnit->name }}</span>
        <br>
        @endif


        @foreach($user->telephones as $telephone)
            <span class="small">Teléfono: <a href="tel:+56{{ $telephone->number }}">+56 {{ $telephone->number }}</a> /  
            Anexo: {{ $telephone->minsal }}</span>
            <br>
        @endforeach

        @if($personalPhone)
            <span class="small">Teléfono: <a href="tel:+56{{ $personalPhone }}">+56 {{ $personalPhone }}</a></span>
            <br>
        @endif

        @if($user->email)
            <span class="small"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></span>
            <br>
        @endif

        <span class="small">
            <strong class="text-muted">
            <br>
            {{ optional($user->organizationalUnit)->establishment->official_name ?? '' }}<br>
            Gobierno de Chile
            </strong>
        </span>
        <br>


    </address>


    <br><br><br>

    {{--
    <strong>Ejemplo de firma 1</strong>

    <address class="border p-2 mb-3">
    Estimado {{ auth()->user()->shortName }}<br><br>
    El presente correo electrónico es para lorem ipsum, dolor sit amet consectetur adipisicing elit. Ut est sint iure minus accusantium quidem, eligendi in aut ab tempore nihil, modi iusto quasi. Tempora asperiores quas rem libero iusto?
    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Corporis deleniti, aspernatur, autem pariatur dolores magni, soluta fugiat nostrum omnis voluptatum voluptas ipsum ut dolore eum libero! Accusantium odio omnis ipsam.
    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Incidunt nostrum ratione repellendus dolor, eligendi necessitatibus saepe odit, illum, voluptatum eaque odio culpa minus nisi ullam voluptatem perferendis error labore expedita.
    <br><br>
    <div class="row">
        <div class="ml-3 mr-3" >
            <img src="/images/logo_sst_150px.png" 
                width="150" 
                alt="Logo Vacuna Dupla Influenza y Covid19">
            <img src="/images/firma_camp.png" 
                width="136" 
                alt="Logo Vacuna Dupla Influenza y Covid19">
        </div>
        <div class="">
            <span class="small">
                <strong>{{ $user->shortName }}
                    @if($pronom)
                    ({{ $pronom }})
                    @endif
                </strong>
            </span>

            <br>

            @if($user->position)
                <span class="text-muted small">
                    @if($user->position == 'Jefe' OR
                        $user->position == 'Director' OR
                        $user->position == 'Jefa' OR
                        $user->position == 'Directora')
                            {{ $user->position }}
                    @elseif($user->position != NULL)
                        <em>{{ $user->position }}</em>
                    @endif
                </span>
            @endif

            @if($user->organizationalUnit)
                <span class="small">{{ $user->organizationalUnit->name }}</span>
                <br>
            @endif


            @foreach($user->telephones as $telephone)
                <span class="small">Teléfono: <a href="tel:+56{{ $telephone->number }}">+56 {{ $telephone->number }}</a> / 
                Anexo: {{ $telephone->minsal }}</span>
                <br>
            @endforeach

            @if($personalPhone)
                <span class="small">Teléfono: <a href="tel:+56{{ $personalPhone }}">+56 {{ $personalPhone }}</a></span>
                <br>
            @endif

            @if($user->email)
                <span class="small"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></span>
                <br>
            @endif

            <br>
        </div>
    </div>


    </address>

    <br><br><br>


    --}}

    <strong>Formato SST</strong>
    <address class="border p-2 mb-3">
        Estimado {{ auth()->user()->shortName }}<br><br>
        El presente correo electrónico es para lorem ipsum, dolor sit amet consectetur adipisicing elit. Ut est sint iure minus accusantium quidem, eligendi in aut ab tempore nihil, modi iusto quasi. Tempora asperiores quas rem libero iusto?
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Corporis deleniti, aspernatur, autem pariatur dolores magni, soluta fugiat nostrum omnis voluptatum voluptas ipsum ut dolore eum libero! Accusantium odio omnis ipsam.
        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Incidunt nostrum ratione repellendus dolor, eligendi necessitatibus saepe odit, illum, voluptatum eaque odio culpa minus nisi ullam voluptatem perferendis error labore expedita.
        <br><br>


        <table>
            <tr>
                <td>
                <img src="/images/logo_100_años_salud_y_seguridad_social.png" 
                    width="190" 
                    alt="100 Años Salud y Seguridad Social">
                </td>
                <td>
                    <span class="raya_azul">━━━</span><span class="raya_rojo">━━━━━</span><br>
                    <span class="small">
                        <strong>{{ $user->shortName }}
                            @if($pronom)
                            ({{ $pronom }})
                            @endif
                        </strong>
                        <br>
                    </span>

                    @if($user->position)
                        <span class="text-muted small">
                            @if($user->position == 'Jefe' OR
                                $user->position == 'Director' OR
                                $user->position == 'Jefa' OR
                                $user->position == 'Directora')
                                    {{ $user->position }}
                            @elseif($user->position != NULL)
                                <em>{{ $user->position }}</em>
                            @endif
                        </span>
                        <br>
                    @endif

                    @if($user->organizationalUnit)
                        <span class="small">{{ $user->organizationalUnit->name }}</span>
                        <br>
                    @endif


                    @foreach($user->telephones as $telephone)
                        <span class="small">Teléfono: <a href="tel:+56{{ $telephone->number }}">+56 {{ $telephone->number }}</a> /  
                        Anexo: {{ $telephone->minsal }}</span>
                        <br>
                    @endforeach

                    @if($personalPhone)
                        <span class="small">Teléfono: <a href="tel:+56{{ $personalPhone }}">+56 {{ $personalPhone }}</a></span>
                        <br>
                    @endif

                    @if($user->email)
                        <span class="small"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></span>
                        <br>
                    @endif


                    <span class="small">
                        <strong class="text-muted">
                        <br>
                        {{ optional($user->organizationalUnit)->establishment->official_name ?? '' }}<br>
                        Gobierno de Chile
                        </strong>
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <a href="{{ route('redirect-url.signature') }}">
                        <img src="{{ asset('images/firma_banner_400px.gif') }}"
                            alt="Banner Firma"
                            >
                    </a>
                </td>
            </tr>
        </table>



    </address>



    <br><br><br>



</div>