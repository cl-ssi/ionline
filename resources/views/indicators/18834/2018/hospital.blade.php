@extends('layouts.app')

@section('title', 'Ley N° 18.834')

@section('content')

@include('indicators.partials.nav')

@foreach($data3 as $nombre_comuna => $comuna)
  <h3 class="mb-3">{{ $nombre_comuna }}</h3>
@endforeach

<h6 class="mb-3">Metas Sanitarias Ley N° 18.834</h6>

<style>
    .glosa {
        width: 400px;
    }
</style>

<hr>
<!-- Tab panes -->
    @foreach($data3 as $nombre_comuna => $comuna)

            <h4></h4>
            <h5 class="mb-3">{{ $label3['meta'] }}</h5>

            <table class="table table-sm table-bordered small">

                <thead>
                    <tr class="text-center">
                        <th>Indicador</th>
                        <th nowrap>Meta</th>
                        <th nowrap>% Cump</th>
                        <th>Acum</th>
                        <th>Ene</th>
                        <th>Feb</th>
                        <th>Mar</th>
                        <th>Abr</th>
                        <th>May</th>
                        <th>Jun</th>
                        <th>Jul</th>
                        <th>Ago</th>
                        <th>Sep</th>
                        <th>Oct</th>
                        <th>Nov</th>
                        <th>Dic</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td class="text-left glosa">{{ $label3['numerador'] }}</td>
                        <td rowspan="2" class="align-middle text-center">{{ $comuna['meta'] }}</td>
                        <td rowspan="2" class="align-middle text-center">{{ number_format($comuna['cumplimiento'], 2, ',', '.') }}%</td>
                        @foreach($comuna['numeradores'] as $numerador)
                            <td class="text-right">{{ number_format($numerador, 0, ',', '.') }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="text-left">{{ $label3['denominador'] }}</td>
                        @foreach($comuna['denominadores'] as $denominador)
                            <td class="text-right">{{ number_format($denominador, 0, ',', '.') }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>


    @endforeach

    <hr>
    <!-- Tab panes -->
        @foreach($data5 as $nombre_comuna => $comuna)

                <h4></h4>
                <h5 class="mb-3">{{ $label5['meta'] }}</h5>



                <table class="table table-sm table-bordered small">

                    <thead>
                        <tr class="text-center">
                            <th>Indicador</th>
                            <th nowrap>Meta</th>
                            <th nowrap>% Cump</th>
                            <th>Acum</th>
                            <th>Ene</th>
                            <th>Feb</th>
                            <th>Mar</th>
                            <th>Abr</th>
                            <th>May</th>
                            <th>Jun</th>
                            <th>Jul</th>
                            <th>Ago</th>
                            <th>Sep</th>
                            <th>Oct</th>
                            <th>Nov</th>
                            <th>Dic</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td class="text-left glosa">{{ $label5['numerador'] }}</td>
                            <td rowspan="2" class="align-middle text-center">{{ $comuna['meta'] }}</td>
                            <td rowspan="2" class="align-middle text-center">{{ number_format($comuna['cumplimiento'], 2, ',', '.') }}%</td>
                            @foreach($comuna['numeradores'] as $numerador)
                                <td class="text-right">{{ number_format($numerador, 0, ',', '.') }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="text-left">{{ $label5['denominador'] }}</td>
                            @foreach($comuna['denominador'] as $denominador)
                                <td class="text-right">{{ number_format($denominador, 0, ',', '.') }}</td>
                            @endforeach
                            <td class="textrightleft" colspan="12"></td>
                        </tr>
                    </tbody>
                </table>


        @endforeach

        <hr>
        <!-- Tab panes -->
            @foreach($data6 as $nombre_comuna => $comuna)

                    <h4></h4>
                    <h5 class="mb-3">{{ $label6['meta'] }}</h5>



                    <table class="table table-sm table-bordered small">

                        <thead>
                            <tr class="text-center">
                                <th>Indicador</th>
                                <th nowrap>Meta</th>
                                <th nowrap>% Cump</th>
                                <th>Acum</th>
                                <th>Ene</th>
                                <th>Feb</th>
                                <th>Mar</th>
                                <th>Abr</th>
                                <th>May</th>
                                <th>Jun</th>
                                <th>Jul</th>
                                <th>Ago</th>
                                <th>Sep</th>
                                <th>Oct</th>
                                <th>Nov</th>
                                <th>Dic</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td class="text-left glosa">{{ $label6['numerador'] }}</td>
                                <td rowspan="2" class="align-middle text-center">{{ $comuna['meta'] }}</td>
                                <td rowspan="2" class="align-middle text-center">{{ number_format($comuna['cumplimiento'], 2, ',', '.') }}%</td>
                                @foreach($comuna['numeradores'] as $numerador)
                                    <td class="text-right">{{ number_format($numerador, 0, ',', '.') }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td class="text-left">{{ $label6['denominador'] }}</td>
                                @foreach($comuna['denominadores'] as $denominador)
                                    <td class="text-right">{{ number_format($denominador, 0, ',', '.') }}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>


            @endforeach

            <h5 class="mb-3">{{ $data7['label'] }}</h5>

            <table class="table table-sm table-bordered small">

                <thead>
                    <tr class="text-center">
                        <th>Indicador</th>
                        <th nowrap>Meta</th>
                        <th nowrap>% Cump</th>
                        <th>Acum</th>
                        <th>Ene</th>
                        <th>Feb</th>
                        <th>Mar</th>
                        <th>Abr</th>
                        <th>May</th>
                        <th>Jun</th>
                        <th>Jul</th>
                        <th>Ago</th>
                        <th>Sep</th>
                        <th>Oct</th>
                        <th>Nov</th>
                        <th>Dic</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td class="text-left glosa">{{ $data7['label_numerador'] }}</td>
                        <td rowspan="2" class="align-middle text-center">{{ $data7['meta'] }}</td>
                        <td rowspan="2" class="align-middle text-center">{{ $data7['cumplimiento']}} %</td>
                        <td class="text-right">{{ number_format($data7['numerador_acumulado'],0, ',', '.') }}</td>
                        @foreach($data7['numeradores'] as $numerador)
                            <td class="text-right">{{ number_format($numerador, 0, ',', '.') }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="text-left">{{ $data7['label_denominador'] }}</td>
                        <td class="text-right">{{ number_format($data7['denominador_acumulado'],0, ',', '.') }}</td>
                        @foreach($data7['denominadores'] as $denominador)
                            <td class="text-right">{{ number_format($denominador, 0, ',', '.') }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>





            <h5 class="mb-3">{{ $data8['label'] }}</h5>

            <table class="table table-sm table-bordered small">

                <thead>
                    <tr class="text-center">
                        <th>Indicador</th>
                        <th nowrap>Meta</th>
                        <th nowrap>% Cump</th>
                        <th>Acum</th>
                        <th>Ene</th>
                        <th>Feb</th>
                        <th>Mar</th>
                        <th>Abr</th>
                        <th>May</th>
                        <th>Jun</th>
                        <th>Jul</th>
                        <th>Ago</th>
                        <th>Sep</th>
                        <th>Oct</th>
                        <th>Nov</th>
                        <th>Dic</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td class="text-left glosa">{{ $data8['label_numerador'] }}</td>
                        <td rowspan="2" class="align-middle text-center">{{ $data8['meta'] }}</td>
                        <td rowspan="2" class="align-middle text-center">{{ $data8['cumplimiento']}} %</td>
                        <td class="text-right">{{ number_format($data8['numerador_acumulado'],0, ',', '.') }}</td>
                        @foreach($data8['numeradores'] as $numerador)
                            <td class="text-right">{{ number_format($numerador, 0, ',', '.') }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="text-left">{{ $data8['label_denominador'] }}</td>
                        <td class="text-right">{{ number_format($data8['denominador_acumulado'],0, ',', '.') }}</td>
                        @foreach($data8['denominadores'] as $denominador)
                            <td class="text-right">{{ number_format($denominador, 0, ',', '.') }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>



            <h5 class="mb-3">{{ $data9['label'] }}</h5>

            <table class="table table-sm table-bordered small">

                <thead>
                    <tr class="text-center">
                        <th>Indicador</th>
                        <th nowrap>Meta</th>
                        <th nowrap>% Cump</th>
                        <th>Acum</th>
                        <th>Ene</th>
                        <th>Feb</th>
                        <th>Mar</th>
                        <th>Abr</th>
                        <th>May</th>
                        <th>Jun</th>
                        <th>Jul</th>
                        <th>Ago</th>
                        <th>Sep</th>
                        <th>Oct</th>
                        <th>Nov</th>
                        <th>Dic</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td class="text-left glosa">{{ $data9['label_numerador'] }}</td>
                        <td rowspan="2" class="align-middle text-center">{{ $data9['meta'] }}</td>
                        <td rowspan="2" class="align-middle text-center">{{ $data9['cumplimiento']}} %</td>
                        <td class="text-right">{{ number_format($data9['numerador_acumulado'],0, ',', '.') }}</td>
                        <td colspan="12">{{ $data9['vigencia'] }}</td>
                    </tr>
                    <tr>
                        <td class="text-left">{{ $data9['label_denominador'] }}</td>
                        <td class="text-right">{{ number_format($data9['denominador_acumulado'],0, ',', '.') }}</td>
                        <td colspan="12"></td>
                    </tr>
                </tbody>
            </table>



            <h5 class="mb-3">{{ $data10['label'] }}</h5>

            <table class="table table-sm table-bordered small">

                <thead>
                    <tr class="text-center">
                        <th>Indicador</th>
                        <th nowrap>Meta</th>
                        <th nowrap>% Cump</th>
                        <th>Acum</th>
                        <th>Ene</th>
                        <th>Feb</th>
                        <th>Mar</th>
                        <th>Abr</th>
                        <th>May</th>
                        <th>Jun</th>
                        <th>Jul</th>
                        <th>Ago</th>
                        <th>Sep</th>
                        <th>Oct</th>
                        <th>Nov</th>
                        <th>Dic</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td class="text-left glosa">{{ $data10['label_numerador'] }}</td>
                        <td rowspan="2" class="align-middle text-center">{{ $data10['meta'] }}</td>
                        <td rowspan="2" class="align-middle text-center">{{ $data10['cumplimiento']}} %</td>
                        <td class="text-right">{{ number_format($data10['numerador_acumulado'],0, ',', '.') }}</td>
                        <td class="text-right" colspan="{{ $data10['vigencia'] }}">{{ number_format($data10['numerador_acumulado'],0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="text-left">{{ $data10['label_denominador'] }}</td>
                        <td class="text-right">{{ number_format($data10['denominador_acumulado'],0, ',', '.') }}</td>
                        <td class="text-right" colspan="{{ $data10['vigencia'] }}">{{ number_format($data10['denominador_acumulado'],0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>

@endsection

@section('custom_js')

@endsection
