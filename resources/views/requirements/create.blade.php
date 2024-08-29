@extends('layouts.bt4.app')

@section('title', 'Crear requerimiento')

@section('content')

@include('requirements.partials.nav')

<h3 class="mb-3">Nuevo requerimiento
    @if($parte->id <> 0)
        en base al parte <strong>{{ $parte->correlative }}</strong>
        @if($parte->files != null)
            @foreach($parte->files as $file)
                <a href="{{ route('documents.partes.download', $file->id) }}"
                    target="_blank" data-toggle="tooltip" data-placement="top"
                    data-original-title="{{ $file->name }}">
                    <i class="fas fa-paperclip"></i>
                </a>
            @endforeach
        @endif

    @endif
</h3>

<div class="alert alert-info small" role="alert">
    <ul>
        <li>
            Los SGR <strong>tienen un comportamiento diferente al correo electrónico.</strong>
        </li>
        <li>
            Si se envía a más de un destinatario <i class="fas fa-user-plus"></i>, se creará uno para cada persona.<br>
            Por ejemplo: Al enviar un SGR para Jurídico y SDGA, <strong>se crearán 2 SGRs</strong>, que cada uno tendrá que responder por separado.
        </li>
        <li>
            Si desea informar a otra persona, puede utilizar la opción de copia <i class="far fa-copy"></i>, 
            esto no creará otro SGR (esta opción si funciona como el correo electrónico).
        </li>
        <li>
            Los SGRs van dirigidos a las jefaturas de las unidades, no es necesario copiar a las secretarías, ya que éstas siempre pueden ver y gestionar los SGRs de sus jefaturas.
        </li>
    </ul>
</div>

<div class="form-row">
    @if($parte->id <> 0)
        <div class="col-8">
            @if($parte->files->first() != null)
                @foreach($parte->files as $file)
                    <object type="application/pdf"
                            data="{{route('documents.partes.download', $file->id)}}"
                            width="100%"
                            height="700">
                    </object>
                @endforeach
            @endif
        </div>
    @endif
    <div class= @if($parte->id <> 0 ) "col-4" @else "col-12" @endif >
        <form method="POST" class="form-horizontal" action="{{ route('requirements.store') }}" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <input type="hidden" class="form-control" id="for_parte_id" name="parte_id" value="{{$parte->id}}" >

            <div class="form-row">

                <fieldset class="form-group col-12">

                    <!-- <label for="asignarCategoria" class="sr-only">Asignar categoría</label>
                    <input type="text" readonly class="form-control-plaintext" id="asignarCategoria" value="Asignar categoría:"> -->

                    <label for="label_id">Asignar etiqueta</label>
                    <select name="label_id[]" id="label_id" class="form-control selectpicker"
                        multiple title="Elige tus etiquetas" >
                        @foreach(auth()->user()->reqLabels as $key => $label)
                            <option value="{{$label->id}}"
                            data-content="<span class='badge badge-primary' style='background-color: #{{$label->color}};'>{{$label->name}}</span>">
                            </option>
                        @endforeach
                    </select>

                </fieldset>

            </div>

            @livewire('requirements.requirement-receivers',['parte_id' => $parte->id])

            <div class="form-row">
                <fieldset class="form-group @if($parte->id <> 0) col-12 @else col @endif">
                    <label for="for_date">Asunto</label>
                    <textarea name="subject" id="for_subject" class="form-control" rows="2" required>{{ $parte->subject }}</textarea>
                </fieldset>
            </div>
            
            <div class="row">
                <fieldset class="form-group @if($parte->id <> 0) col-12 @else col @endif">
                    <label for="for_date">Requerimiento</label>
                    <textarea class="form-control" id="for_body" name="body" rows="4" required></textarea>
                </fieldset>
            </div>

            <div class="form-row">
                <fieldset class="form-group @if($parte->id <> 0) col-12 @else col-2 @endif">
                    <label for="for_origin">Tipo</label>
                    <select class="form-control" name="priority" id="priority" >
                        <option>Normal</option>
                        <option>Urgente</option>
                    </select>
                </fieldset>

                <fieldset class="form-group @if($parte->id <> 0) col-12 @else col-3 @endif">
                    <label for="for_origin">Fecha límite</label>
                    <input type="datetime-local" class="form-control" id="for_limit_at"
                           name="limit_at">
                </fieldset>
            </div>

            <div class="row">
                <fieldset class="form-group @if($parte->id <> 0) col-12 @else col-5 @endif">
                    <label for="forFile">Adjuntar archivos</label>
                    <input type="file" class="form-control-file" id="forfile" name="forfile[]" multiple>
                </fieldset>

                <!-- <fieldset class="form-group @if($parte->id <> 0) col-12 @else col-3 @endif">
                    <label for="for_document">Asociar documentos</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="for_document" name="document">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary add-row">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="form-group @if($parte->id <> 0) col-12 @else col-2 @endif">
                    <label for="for_tabla_documents"></br></label></br>
                    <table id="tabla_documents" style="display: none">
                        <tr></tr>
                    </table>
                </fieldset> -->
                <fieldset class="col">
                    @livewire('requirements.events.associate-document',['parte_id' => $parte->id])
                </fieldset>
            </div>
            <button type="submit" class="btn btn-primary" id="submit">Crear</button>

        </form>
    </div>
</div>



@endsection

@section('custom_js')
  <script>

    $(document).ready(function(){
        $("#submit").click(function(){
            // alert(document.getElementById("users").value);
            // if (document.getElementById("users").value == null){
            //     alert("Debe ingresar por lo menos un usuario a quien para crear el requerimiento.");
            // }
            //Attempt to get the element using document.getElementById
            // var element = document.getElementById("users");

            // //If it isn't "undefined" and it isn't "null", then it exists.
            // if(typeof(element) != 'undefined' && element != null){
            //     // alert('Element exists!');
            // } else{
            //     alert("Debe ingresar por lo menos un usuario a quien crear el requerimiento.");
            //     return false;
            // }

            if($('.users').val() == undefined){
                alert("Debe ingresar por lo menos un usuario a quien crear el requerimiento.");
                return false;
            }

        });
    });

{{--
  	 $(document).ready(function(){
       var array = new Array;
  		 $("#ou").val(1);
  		 $("#ou").trigger("change");


      //$(document).ready(function(){
        $(".add-destinatario").click(function(){
          //valida que no exista el mismo usuario 2 veces en array
          if(array){
            for (var i = 0; i < array.length; i+=1) {
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
            var markup = "<tr><input type='hidden' id='users' name='users[]' value=" + user_id + ">" +
                             "<input type='hidden' name='enCopia[]' value='0'>" +
                              "<td>" + ou + "</td>" +
                              "<td>" + user + "</td>" +
                              "<td><input type='checkbox' disabled></td>" +
                              //"<td><button type='button' id='delete-row' class='btn btn-outline-secondary btn-sm' value=" + id + "><span class='fas fa-trash-alt' aria-hidden='true'></span></button></td>" +
                         "</tr>";
            $("#tabla_funcionarios").append(markup);
        });

        $(".add-destinatario-cc").click(function(){
          if (document.getElementById("users").value == null){
            alert("Debe ingresar por lo menos un usuario a quien derivar el requerimiento.");
          }

          //valida que no exista el mismo usuario 2 veces en array
          if(array){
            for (var i = 0; i < array.length; i+=1) {
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
            array.push($("#user option:selected").val());
            var markup = "<tr><input type='hidden' id='users' name='users[]' value=" + user_id + ">" +
                             "<input type='hidden' name='enCopia[]' value='1'>" +
                              "<td>" + ou + "</td>" +
                              "<td>" + user + "</td>" +
                              "<td><input type='checkbox' checked disabled></td>" +
                              //"<td><button type='button' id='delete-row' class='btn btn-outline-secondary btn-sm' value=" + id + "><span class='fas fa-trash-alt' aria-hidden='true'></span></button></td>" +
                         "</tr>";
            $("#tabla_funcionarios").append(markup);
        });
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
         var ou_id = e.target.value;
         $.get('{{ route('rrhh.users.get.autority.from.ou')}}/'+ou_id, function(data) {
             console.log(data);
             //alert(data.user_id);
             document.getElementById("user").value = data.user_id;
         });
       });
     });

    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
--}}
  </script>
@endsection
