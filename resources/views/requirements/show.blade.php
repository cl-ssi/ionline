@extends('layouts.bt4.app')

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

<div class="row d-print-none">
    <div class="col-6 col-md-2">
        
        <a class="btn btn-primary" data-toggle="collapse" data-target="#collapseExample"
            href="{{ route('requirements.create') }}">
            <i class="fas fa-plus"></i> Evento
        </a>
        @can('Requirements: delete')
            @if($requirement->status == 'creado')
            <form method="POST" action="{{ route('requirements.destroy', $requirement) }}" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger" 
                    onclick="return confirm('¿Desea eliminar este requerimiento?')">
                    <i class="fas fa-trash"></i><span>
                </button>
            </form>
            @endif
        @endcan
    
    </div>
    <div class="col-6 col-md-5">
        @livewire('requirements.set-label',['req' => $requirement])
    </div>

    <div class="col-12 col-md-4">
        @livewire('requirements.set-category',['requirement' => $requirement])
    </div>

    <div class="col-6 col-md-1">
        @if($requirement->archived->where('user_id',auth()->id())->isEmpty())
        <a class="btn btn-outline-primary" href="{{ route('requirements.archive_requirement',$requirement) }}" title="Archivar">
            <i class="fas fa-fw fa-box-open"></i>
        </a>
        @else
        <a class="btn btn-outline-secondary" href="{{ route('requirements.archive_requirement_delete',$requirement) }}" title="Desarchivar">
            <i class="fas fa-fw fa-box"></i>
        </a>
        @endif
    </div>

</div>


@include('requirements.events.create')

<hr />


<h5 class="mb-3"><span class="text-info">Req {{ $requirement->id}}:</span> {{ $requirement->subject }} </h5>

@if($requirement->parte)
    <h6 class="mb-3">Requerimiento creado en base al parte número: {{ $requirement->parte->correlative }}

    @if($requirement->parte->signaturesFile)
        <a href="{{ route('documents.signatures.showPdf',[$requirement->parte->signatures_file_id, time()])}}"
            target="_blank" title="Documento firmado">
            <i class="fas fa-signature"></i>
        </a>
    @endif

    @if($requirement->parte->files != null)
        @foreach($requirement->parte->files as $file)
            <a href="{{ route('documents.partes.download', $file->id) }}"
                target="_blank" data-toggle="tooltip" data-placement="top"
                data-original-title="{{ $file->name }}">
                <i class="fas fa-paperclip"></i>
            </a>
        @endforeach
    @endif
    
    </h6>
@endif




@if($requirement->limit_at)
<h6 class="mb-3 text-danger"> 
    <i class="fas fa-chess-king"></i>
    Fecha límite del requerimiento: 
    {{ optional($requirement->limit_at)->format('Y-m-d') }}
</h6>
@endif

@foreach($requirement->events()->orderBy('id','DESC')->get() as $key => $event)
  @if($event->status <> 'en copia')
    <div class="card mb-3">
        <div class="card-header">
            
            <cite title="Fecha">
            @switch($event->status)
                @case('creado')
                    <i class="fas fa-check"></i> Creado
                    @break
                @case('respondido')
                    <i class="fas fa-comment text-warning"></i> Respondido
                    @break
                @case('cerrado')
                    <i class="fas fa-ban fa-lg text-success"></i> Cerrado
                    @break
                @case('derivado')
                    <i class="fas fa-reply text-primary"></i> Derivado
                    @break
                @case('reabierto')
                    <i class="fas fa-paper-plane text-warning"></i> Reabierto
                    @break
            @endswitch
             el {{ $event->created_at->format('Y-m-d H:i') }}
            
            @if($event->limit_at)
                <span class="text-danger">
                con fecha límite: {{ $event->limit_at->format('Y-m-d H:i') }}
                </span>
            @endif
            </cite>

            <span class="float-right text-muted">{{ $event->id }}</span>

            @if($event->from_user->organizationalUnit)
            <div>
                Por	<strong>{{ $event->from_user->fullName }}</strong> de
                <span class="text-info">{{ $event->from_user->organizationalUnit->name }}</span>
            </div>
            @endif

            @if($event->status != 'cerrado' AND $event->status != 'respondido')
                <div>
                Para <strong>{{$event->to_user->fullName }}</strong>
                de <span class="text-info">{{$event->to_ou->name}}</span>
                </div>
            @endif

            @php $cc = ""; @endphp

            @foreach($requirement->events as $event_)
                @if($event_->status == "en copia")
                    @if($event_->body == $event->body && $event->created_at->format('H') == $event_->created_at->format('H'))
                        @php
                            $cc = $cc . $event_->to_user->tinyName . ", ";
                        @endphp
                    @endif
                @endif
            @endforeach

            @if($cc != null)
            <div class="blockquote-footer">
                En copia a: <strong>{{$cc}}</strong>
            </div>
            @endif




        </div>

        <div class="card-body">
            <p class="card-text text-primary">{!! str_replace("\n", '<br>', $event->body) !!}</p>
        </div>

        <div class="card-footer text-muted">

            <span class="mr-3">
            Archivos adjuntos:
            @foreach($event->files as $file)
                <a href="{{ route('requirements.download', $file->id) }}" target="_blank">
                    <i class="fas fa-paperclip"></i> {{ $file->name }}
                </a>

                @if($file->event->from_user_id == auth()->id())
                <a href="{{ route('requirements.deleteFile', $file->id) }}">
                    <i class="fas fa-trash" style="color:red"></i>
                </a>
                @endif
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

@if($groupedRequirements != null AND $groupedRequirements->count() != 0)
    <footer class="blockquote-footer">
        Requerimiento enviado también a
        <ul>
                @foreach($groupedRequirements as $groupedRequirement)
                    @foreach($groupedRequirement->events as $event)
                        @if($event->status == "creado")
                        <li> <strong> {{$event->to_user->fullName }} </strong> </li>
                        @endif
                    @endforeach
                @endforeach
        </ul>
    </footer>
@endif

<div id="page-loader" style="display: none">
    <span class="preloader-interior"></span>
</div>
@endsection

@section('custom_js')

  <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>

  <script>

       $(document).ready(function(){
       var array = new Array;
      //  $("#ou").val( $lastEvent->from_user->organizationalUnit->id ); //select que se actualiza automáticamente
      //  $("#ou").trigger("change", [true]);
      //  $("#user").val( $lastEvent->from_user->id ); //select que se actualiza automáticamente
      //  $("#user").trigger("change");
       $("#status").trigger("change", [true]);

       // document.getElementById("div_ou").style.display = "none";
       // document.getElementById("div_destinatario").style.display = "none";

       // document.getElementById("ou").disabled  = true;
       // document.getElementById("user").disabled  = true;
       // document.getElementById("add_destinatario").disabled  = true;
       // document.getElementById("add_destinatario_cc").disabled  = true;

       //preloader



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
                               "<td><button type='button' class='btn btn-outline-danger delete-row' data-toggle='tooltip' data-placement='top' title='Eliminar'><i class='fas fa-trash'></i></button></td>" +
                               //"<td><button type='button' id='delete-row' class='btn btn-outline-secondary btn-sm' value=" + id + "><span class='fas fa-trash-alt' aria-hidden='true'></span></button></td>" +
                          "</tr>";
             $("#tabla_funcionarios").append(markup);
           }else{alert("No se puede derivar para más de un usuario en una respuesta a un requerimiento.");}
       });

       $(document).on('click', '.delete-row', function () {
            $(this).closest('tr').remove();
            // También puedes eliminar el ID correspondiente del array
            // Ejemplo: array.splice(index, 1);
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
                             "<td><button type='button' class='btn btn-outline-danger delete-row' data-toggle='tooltip' data-placement='top' title='Eliminar'><i class='fas fa-trash'></i></button></td>" +
                      "</tr>";
         $("#tabla_funcionarios").append(markup);

         // if($("#status").val() == "respondido"){
         //   $("#ou").val( $lastEvent->from_user->organizationalUnit->id );
         //   $("#ou").trigger("change");
         //   $("#user").val( $lastEvent->from_user->id );
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
      $('#ou').on('change', function(e, is_implicit_call){
        console.log(e);
        funcionDeferred().done(function() {
          if(!is_implicit_call){
            var ou_id = e.target.value;
                $.get('{{ route('rrhh.users.get.autority.from.ou')}}/'+ou_id, function(data) {
                    console.log(data);
                    //alert(data.user_id);
                    document.getElementById("user").value = data.user_id;
                });
          }else{
            if(document.getElementById("status").value == "respondido" || document.getElementById("status").value == "reabierto"){
              $("#user").val({{ optional(optional($lastEvent)->from_user)->id}});
              $('#to').val({{ optional(optional($lastEvent)->from_user)->id}});
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

          $("#ou").val({{auth()->user()->organizational_unit_id}});
          $('#organizational_unit_id').val({{auth()->user()->organizational_unit_id}});
          //$('#organizational_unit_id').val(1);
          $("#ou").trigger("change", [true]);
        }else if(document.getElementById("status").value == "respondido" || document.getElementById("status").value == "reabierto"){
          @if($lastEvent <> null)
            @if($lastEvent->from_user->organizationalUnit)
                $("#ou").val({{$lastEvent->from_user->organizationalUnit->id}});
                $('#organizational_unit_id').val({{$lastEvent->from_user->organizationalUnit->id}});
                $("#ou").trigger("change", [true]);
            @endif
          @endif
          // document.getElementById("ou").disabled  = true;
          // document.getElementById("user").disabled  = true;
          // document.getElementById("add_destinatario").disabled  = true;
          // document.getElementById("add_destinatario_cc").disabled  = true;

        }else if(document.getElementById("status").value == "cerrado"){
          @if($firstEvent <> null)
            @if($lastEvent->from_user->organizationalUnit)
                $("#ou").val({{$firstEvent->from_user->organizationalUnit->id}});
                $('#organizational_unit_id').val({{$firstEvent->from_user->organizationalUnit->id}});
                $("#ou").trigger("change", [true]);
            @endif
          @endif
          document.getElementById("ou").disabled  = true;
          document.getElementById("user").disabled  = true;
          document.getElementById("add_destinatario").disabled  = true;
          document.getElementById("add_destinatario_cc").disabled  = true;
        }
      });

  </script>

@endsection
