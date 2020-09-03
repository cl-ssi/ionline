@extends('layouts.app')

@section('title', 'Nuevo requerimiento')

@section('content')

@include('requirements.partials.nav')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/animate.css') }}" rel="stylesheet" type="text/css"/>

<style type="text/css" rel="stylesheet">
#page-loader {
position: fixed;
top: 0;
left: 0;
width: 100%;
height: 100%;
z-index: 1000;
background: #FFF none repeat scroll 0% 0%;
z-index: 99999;
}
#page-loader .preloader-interior {
display: block;
position: relative;
left: 50%;
top: 50%;
width: 189px;
height: 171px;
margin: -75px 0 0 -75px;
background-image: url("{{asset('images/logo_rgb.png')}}");
-webkit-animation: heartbeat 1s infinite;
}

#page-loader .preloader-interior:before {
content: "";
position: absolute;
top: 5px;
left: 5px;
right: 5px;
bottom: 5px;
-webkit-animation: heartbeat 1s infinite;
}

@keyframes heartbeat
{
  0%{transform: scale( .75 );}
  20%{transform: scale( 1 );}
  40%{transform: scale( .75 );}
  60%{transform: scale( 1 );}
  80%{transform: scale( .75 );}
  100%{transform: scale( .75 );}
}

</style>

<div class="row mb-3 d-print-none">
    <div class="col">
        <a class="btn btn-primary" data-toggle="collapse" data-target="#collapseExample"
            href="{{ route('requirements.create') }}">
            <i class="fas fa-plus"></i> Nuevo evento
        </a>
    </div>

    <div class="col">
        <form name="form" id="form" method="GET" class="form-inline"
            action="{{ route('requirements.asocia_categorias',$requirement) }}">
            @csrf
            @method('GET')
            <input type="hidden" value="{{ $requirement->id }}" name="requirement_id">
            <div class="form-group mb-2">
                <label for="asignarCategoria" class="sr-only">Asignar categoría:</label>
                <input type="text" readonly class="form-control-plaintext" id="asignarCategoria" value="Asignar categoría:">
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <label for="category_id" class="sr-only">Categorias</label>
                <select name="category_id[]" id="category_id" class="selectpicker input-sm"
                    multiple title="Elige tus categorías" >
                    @foreach($categories as $key => $category)
                        {{$flag = 0}}
                        @foreach($requirementCategories as $key => $requirementCategory)
                            @if($category->id == $requirementCategory->category_id)
                                {{$flag = 1}}
                            @endif
                        @endforeach

                        <option value="{{$category->id}}"
                            data-content="<span class='badge badge-primary' style='background-color: #{{$category->color}};'>{{$category->name}}</span>"
                            {{ ($flag == 1)?'selected':'' }}>
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
</div>

@include('requirements.events.create')

<hr />

<h5 class="mb-3"><span class="text-info">Req {{ $requirement->id}}:</span> {{ $requirement->subject }}</h5>

@if($requirement->parte <> null)
    @if($requirement->parte->files != null)
        <h6 class="mb-3">Requerimiento creado en base al parte número: {{ $requirement->parte->id }}
        @foreach($requirement->parte->files as $file)
            <a href="{{ route('documents.partes.download', $file->id) }}"
                target="_blank" data-toggle="tooltip" data-placement="top"
                data-original-title="{{ $file->name }}">
                <i class="fas fa-paperclip"></i>
            </a>
        @endforeach
        </h6>
    @endif
@endif

@foreach($requirement->events()->orderBy('id','DESC')->get() as $key => $event)
  @if($event->status <> 'en copia')
    <div class="card mb-3">
        <div class="card-header">
            @switch($event->status)
                @case('creado')
                    <i class="fas fa-check"></i> Creado
                    @break
                @case('respondido')
                    <i class="fas fa-comment"></i> Respondido
                    @break
                @case('cerrado')
                    <i class="fas fa-ban"></i> Cerrado
                    @break
                @case('derivado')
                    <i class="fas fa-reply"></i> Derivado
                    @break
                @case('reabierto')
                    <i class="fas fa-paper-plane"></i> Reabierto
                    @break
            @endswitch
            para <strong>{{$event->to_user->getFullNameAttribute()}}</strong>
            de <span class="text-info">{{$event->to_ou->name}}</span>
        </div>

        <div class="card-body">
            <p class="card-text text-primary"> {!! str_replace("\n", '<br>', $event->body) !!}</p>
            <footer class="blockquote-footer">
                <cite title="Fecha">{{ $event->created_at->format('Y-m-d H:i') }}</cite>
                por
                <strong>{{ $event->from_user->getFullNameAttribute() }}</strong> de
                <span class="text-info">{{ $event->from_user->organizationalUnit->name }}</span>
            </footer>

            @php $cc = ""; @endphp
            @foreach($requirement->events as $event_)
                @if($event_->status == "en copia")
                  @if($event_->body == $event->body && $event->created_at->format('H') == $event_->created_at->format('H'))
                    @php
                      $cc = $cc . $event_->to_user->getFullNameAttribute() . " / ";
                    @endphp
                  @endif
                @endif
            @endforeach

            @if($cc != null)
            <footer class="blockquote-footer">
                En copia a
                <strong>{{$cc}}</strong>
            </footer>
            @endif

        </div>

        <div class="card-footer text-muted">
            <span class="mr-3">
            Archivos adjuntos:
            @foreach($event->files as $file)
                <a href="{{ route('requirements.download', $file->id) }}" target="_blank">
                    <i class="fas fa-paperclip"></i> {{ $file->name }}
                </a>
            @endforeach
            </span>

            <span class="ml-3">
            Documentos asociados:
            @foreach($event->documents as $document)
                <a href="{{ route('documents.download', $document->id) }}" target="_blank">
                    <i class="far fa-file-alt"></i> {{ $document->subject }}
                </a>
            @endforeach
            </span>
        </div>

    </div>
    @endif

@endforeach
<div id="page-loader" style="display: none">
  <span class="preloader-interior"></span>
</div>
@endsection

@section('custom_js')

  <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>

  <script>

  	 $(document).ready(function(){
       var array = new Array;
       $("#ou").val({{$lastEvent->from_user->organizationalUnit->id}}); //select que se actualiza automáticamente
       $("#ou").trigger("change");
       $("#user").val({{$lastEvent->from_user->id}}); //select que se actualiza automáticamente
       $("#user").trigger("change");

       // document.getElementById("div_ou").style.display = "none";
       // document.getElementById("div_destinatario").style.display = "none";

       // document.getElementById("ou").disabled  = true;
       // document.getElementById("user").disabled  = true;
       // document.getElementById("add_destinatario").disabled  = true;
       // document.getElementById("add_destinatario_cc").disabled  = true;

       //preloader
       $('#category_id').on('change', function() {
          $('#page-loader').fadeIn(500);
          document.forms['form'].submit();
       });

       //función para agregar documentos
       $(".add-row").click(function(){
         $("#tabla_documents").fadeIn(2000);
           var doc_id = $("#for_document").val();
           var flag = 0;
           //validación si existe documento
           @foreach($documents as $document)
            if ({{$document->id}} == doc_id) {
              flag = 1;
            }
           @endforeach
           if (flag == 1) {
             var markup = "<input type='hidden' name='documents[]' value=" + doc_id + ">" +
                          "<td align='left'>" + doc_id + ", </td>";
             $("#tabla_documents").append(markup);
             $("#for_document").val("");
             $("#for_document").focus();
           }else{alert("No existe documento, favor intente otro.");}

       });

       $(".add_destinatario").click(function(){
         //se valida si existen datos en el array (solo permite ingresar un solo deruivado)
         if(!$("#users").val()){

           $("#tabla_funcionarios").fadeIn(2000);
             var ou = $("#ou option:selected").text();
             var user = $("#user option:selected").text();
             var user_id = $("#user option:selected").val();
             array.push(user_id);
             var markup = "<tr><input type='hidden' id='users' name='users[]' value=" + user_id + ">" +
                              "<input type='hidden' name='enCopia[]' value='0'>" +
                               "<td>" + ou + "</td>" +
                               "<td>" + user + "</td>" +
                               "<td><input type='checkbox' disabled></td>" +
                               //"<td><button type='button' id='delete-row' class='btn btn-outline-secondary btn-sm' value=" + id + "><span class='fas fa-trash-alt' aria-hidden='true'></span></button></td>" +
                          "</tr>";
             $("#tabla_funcionarios").append(markup);
           }else{alert("No se puede derivar para más de un usuario en una respuesta a un requerimiento.");}
       });

       $(".add_destinatario_cc").click(function(){

         var tipo;
         if($("#status").val() == "respondido"){tipo = "responder"}
         if($("#status").val() == "derivado"){tipo = "derivar"}

         if(document.getElementById("users") != null){
           if (document.getElementById("users").value == null){
             alert("Debe ingresar por lo menos un usuario a quien " + tipo + " el requerimiento.");return;
           }
         }else{alert("Debe ingresar por lo menos un usuario a quien " + tipo + " el requerimiento.");return;}

         //valida que no exista el mismo usuario 2 veces en array
         if(array){
           for (var i = 0; i < array.length; i+=1) {
              //console.log("En el índice '" + i + "' hay este valor: " + array[i]);
              if($("#user option:selected").val() == array[i]){
                alert("Ya se ingresó usuario");
                return;
              }
            }
         }


         $("#tabla_funcionarios").fadeIn(2000);
         var ou = $("#ou option:selected").text();
         var user = $("#user option:selected").text();
         var user_id = $("#user option:selected").val();
         array.push(user_id);
         var markup = "<tr><input type='hidden' id='users[]' name='users[]' value=" + user_id + ">" +
                          "<input type='hidden' id='enCopia' name='enCopia[]' value='1'>" +
                           "<td>" + ou + "</td>" +
                           "<td>" + user + "</td>" +
                           "<td><input type='checkbox' checked disabled></td>" +
                           //"<td><button type='button' id='delete-row' class='btn btn-outline-secondary btn-sm' value=" + id + "><span class='fas fa-trash-alt' aria-hidden='true'></span></button></td>" +
                      "</tr>";
         $("#tabla_funcionarios").append(markup);

         // if($("#status").val() == "respondido"){
         //   $("#ou").val({{$lastEvent->from_user->organizationalUnit->id}});
         //   $("#ou").trigger("change");
         //   $("#user").val({{$lastEvent->from_user->id}});
         // }

       });

  	 });

     //función que permite funcionalidad asincrona (permite que termine la ejecución procedural del código antes de partir con el resto)
      function funcionDeferred(){
          var deferred = $.Deferred();
          var ou_id = document.getElementById("ou").value;//e.target.value;
          $.get('{{ route('rrhh.users.get.from.ou')}}/'+ou_id, function(data) {
              console.log(data);
              $('#user').empty();
              $.each(data, function(index,subCatObj){
                  $('#user').append('<option value="'+subCatObj.id+'">'+subCatObj.name+' '+subCatObj.fathers_family+' '+subCatObj.mothers_family+'</option>');
              });
              deferred.resolve();
          });
          return deferred;//.promise();
      }

      //evento al cambiar select
      $('#ou').on('change', function(e){
        console.log(e);
        funcionDeferred().done(function() {
            if(document.getElementById("status").value == "respondido" || document.getElementById("status").value == "reabierto"){
              $("#user").val({{$lastEvent->from_user->id}});
              $('#to').val({{$lastEvent->from_user->id}});
            }else if(document.getElementById("status").value == "cerrado"){
              @if($firstEvent <> null)
                $("#user").val({{$firstEvent->from_user_id}});
                $('#to').val({{$firstEvent->from_user_id}});
              @endif
            }
            else {
                var ou_id = e.target.value;
                $.get('{{ route('rrhh.users.get.autority.from.ou')}}/'+ou_id, function(data) {
                    console.log(data);
                    //alert(data.user_id);
                    document.getElementById("user").value = data.user_id;
                });
            }
        });
      });

      //evento al cambiar select status
      $('#status').on('change', function(e){
        //se ocultan campos
        // document.getElementById("div_ou").style.display = "none";
        // document.getElementById("div_destinatario").style.display = "none";
        // $("#div_tipo").removeClass("form-group col-3").addClass("form-group col-12");

        if (document.getElementById("status").value == "derivado") {

          // document.getElementById("ou").disabled  = false;
          // document.getElementById("user").disabled  = false;
          // document.getElementById("add_destinatario").disabled  = false;
          // document.getElementById("add_destinatario_cc").disabled  = false;

          // document.getElementById("div_ou").style.display = "block";
          // document.getElementById("div_destinatario").style.display = "block";
          // $("#div_tipo").removeClass("form-group col-12").addClass("form-group col-3");

          $("#ou").val(1);
          $('#organizational_unit_id').val(1);
          $("#ou").trigger("change");
        }else if(document.getElementById("status").value == "respondido" || document.getElementById("status").value == "reabierto"){
          @if($lastEvent <> null)
            $("#ou").val({{$lastEvent->from_user->organizationalUnit->id}});
            $('#organizational_unit_id').val({{$lastEvent->from_user->organizationalUnit->id}});
            $("#ou").trigger("change");
          @endif
          // document.getElementById("ou").disabled  = true;
          // document.getElementById("user").disabled  = true;
          // document.getElementById("add_destinatario").disabled  = true;
          // document.getElementById("add_destinatario_cc").disabled  = true;

        }else if(document.getElementById("status").value == "cerrado"){
          @if($firstEvent <> null)
            $("#ou").val({{$firstEvent->from_user->organizationalUnit->id}});
            $('#organizational_unit_id').val({{$firstEvent->from_user->organizationalUnit->id}});
            $("#ou").trigger("change");
          @endif
          document.getElementById("ou").disabled  = true;
          document.getElementById("user").disabled  = true;
          document.getElementById("add_destinatario").disabled  = true;
          document.getElementById("add_destinatario_cc").disabled  = true;
        }
      });

  </script>

@endsection
