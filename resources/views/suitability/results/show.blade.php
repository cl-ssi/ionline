@extends('layouts.app')

@section('content')

@include('suitability.nav')
<h3 class="mb-3">Resultado Solicitud de Test de Idoneidad N° {{ $result->psirequest->id }}</h3>
<h3 class="mb-3">Realizado por {{ $result->user->fullName }} </h3>
<h3 class="mb-3">Para el cargo de {{ $result->psirequest->job }} </h3>



<p class="mt-5">Total de Puntos: {{ $result->total_points }} Puntos</p>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Preguntas</th>
            <th>Alternativa</th>
            <th>Respuesta</th>
            <th>Puntos</th>
        </tr>
    </thead>
    <tbody>
        @foreach($result->questions as $question)
        <tr>
            <td>{{$question->id}}) {{ $question->question_text }}</td>
            <td>{{$question->questionOptions->find($question->pivot->option_id)->alternative?? '' }} </td>
            <td>{{ $question->questionOptions->find($question->pivot->option_id)->option_text }}</td>
            <td>{{ $question->pivot->points }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<br><br><br>
Resultados para Corrector del Excel
<a class="btn btn-outline-success btn-sm mb-3" id="downloadLink" onclick="exportF(this)">Descargar en excel</a>
<table class="table table-sm table-bordered table-responsive text-center align-middle" id="tabla_correctora">
    @foreach($questions as $question)
    <tr>
        <!-- <td>{{$question->id}}) {{ $question->question_text }}</td> -->
        <td>
            @for ($i = 0; $i < 144; $i++) @if(isset($result->questions[$i]) and $result->questions[$i]->id == $question->id)
                @if ($result->questions[$i]->questionOptions->find($result->questions[$i]->pivot->option_id)->alternative == "A")
               Q
                @endif
                @endif
                @endfor
        </td>
        <td>
            @for ($i = 0; $i < 144; $i++) @if(isset($result->questions[$i]) and $result->questions[$i]->id == $question->id)
                @if ($result->questions[$i]->questionOptions->find($result->questions[$i]->pivot->option_id)->alternative == "B")
              Q
                @endif
                @endif
                @endfor
        </td>
        <td>
            @for ($i = 0; $i < 144; $i++) @if(isset($result->questions[$i]) and $result->questions[$i]->id == $question->id)
                @if ($result->questions[$i]->questionOptions->find($result->questions[$i]->pivot->option_id)->alternative == "C")
             Q
                @endif
                @endif
                @endfor
        </td>


    </tr>
    @endforeach
</table>


<!-- <hr>


<br><br>
Resultados para el Excel
<table class="table table-bordered">
    <tbody>
        @for ($i = 0; $i < 144; $i++) <tr>
            @if(isset($result->questions[$i]) && $result->questions[$i]->count()!=0 )
            <td>
                @if($result->questions[$i]->questionOptions->find($result->questions[$i]->pivot->option_id)->alternative == 'A')
                Q
                @endif
            </td>
            <td>
                @if($result->questions[$i]->questionOptions->find($result->questions[$i]->pivot->option_id)->alternative == 'B')
                Q
                @endif
            </td>
            <td>
                @if($result->questions[$i]->questionOptions->find($result->questions[$i]->pivot->option_id)->alternative == 'C')
                Q
                @endif
            </td>
            @else
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            @endif


            </tr>
            @endfor
    </tbody>
</table> -->



@endsection

@section('custom_js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">
let date = new Date()
let day = date.getDate()
let month = date.getMonth() + 1
let year = date.getFullYear()
let hour = date.getHours()
let minute = date.getMinutes()
    function exportF(elem) {
        var table = document.getElementById("tabla_correctora");
        var html = table.outerHTML;
        var html_no_links = html.replace(/<a[^>]*>|<\/a>/g, ""); //remove if u want links in your table
        var url = 'data:application/vnd.ms-excel,' + escape(html_no_links); // Set your html table into url
        elem.setAttribute("href", url);
        elem.setAttribute("download", "tabla_correctora_{{ $result->psirequest->school->name}}_{{$result->user->fullName}}_{{ $result->psirequest->job}}.xls"); // Choose the file name
        return false;
    }
</script>


@endsection