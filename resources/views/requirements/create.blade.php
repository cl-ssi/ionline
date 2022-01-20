@extends('layouts.app')

@section('title', 'Crear requerimiento')

@section('content')

@include('requirements.partials.nav')

<h3 class="mb-3">Nuevo requerimiento
    @if($parte->id <> 0)
        en base al parte <strong>{{ $parte->id }}</strong>
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















<!-- <div class="row">
<div class="col-12">

                <label for="asignarCategoria" class="sr-only">Asignar categoría</label>
                <input type="text" readonly class="form-control-plaintext" id="asignarCategoria" value="Asignar categoría:">
                <label for="category_id" class="sr-only">Categorias</label>
                <select name="category_id" id="category_id" class="selectpicker input-sm"
                    multiple title="Elige tus categorías" >
                    @foreach($categories as $key => $category)
                    <option value="{{$category->id}}"
                    data-content="<span class='badge badge-primary' style='background-color: #{{$category->color}};'>{{$category->name}}</span>">



                    </option>
                    @endforeach
                    </select>


</div>

</div>

<hr> -->

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



<div class="col-12">

                <label for="asignarCategoria" class="sr-only">Asignar categoría</label>
                <input type="text" readonly class="form-control-plaintext" id="asignarCategoria" value="Asignar categoría:">
                <label for="category_id" class="sr-only">Categorias</label>
                <select name="category_id[]" id="category_id" class="selectpicker input-sm"
                    multiple title="Elige tus categorías" >
                    @foreach($categories as $key => $category)
                    <option value="{{$category->id}}"
                    data-content="<span class='badge badge-primary' style='background-color: #{{$category->color}};'>{{$category->name}}</span>">


                    </option>
                    @endforeach
                    </select>


</div>

<br><br>

<br>

                <fieldset class="form-group @if($parte->id <> 0) col-12 @else col-6 @endif">
                    <label for="ou">Unidad Organizacional</label>
                    <!-- <select class="custom-select" id="forOrganizationalUnit" name="organizationalunit"> -->
                    <select class="form-control selectpicker" data-live-search="true" id="ou" name="to_ou_id" required
                            data-size="5">
                        @foreach($ouRoots as $ouRoot)
                            @if($ouRoot->name != 'Externos')
                                <option value="{{ $ouRoot->id }}">
                                {{($ouRoot->establishment->alias ?? '')}}-{{ $ouRoot->name }}
                                </option>
                                @foreach($ouRoot->childs as $child_level_1)

                                    <option value="{{ $child_level_1->id }}">
                                        &nbsp;&nbsp;&nbsp;
                                        {{($child_level_1->establishment->alias ?? '')}}-{{ $child_level_1->name }}
                                    </option>
                                    @foreach($child_level_1->childs as $child_level_2)
                                        <option value="{{ $child_level_2->id }}">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            {{($child_level_2->establishment->alias ?? '')}}-{{ $child_level_2->name }}
                                        </option>
                                        @foreach($child_level_2->childs as $child_level_3)
                                            <option value="{{ $child_level_3->id }}">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                {{($child_level_3->establishment->alias ?? '')}}-{{ $child_level_3->name }}
                                            </option>
                                            @foreach($child_level_3->childs as $child_level_4)
                                                <option value="{{ $child_level_4->id }}">
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    {{($child_level_4->establishment->alias ?? '')}}-{{ $child_level_4->name }}
                                                </option>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endif
                        @endforeach
                    </select>
                </fieldset>

                <fieldset class="form-group @if($parte->id <> 0) col-12 @else col-5 @endif">
                    <label for="for_origin">Destinatario</label>
                    <div class="input-group">
                        <select class="form-control" name="to_user_id" id="user" required="">

                        </select>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-primary add-destinatario"
                                    data-toggle="tooltip" data-placement="top"
                                    title="Utilizar para agregar más de un destinatario">
                                <i class="fas fa-user-plus"></i>
                            </button>
                            <button type="button" class="btn btn-outline-primary add-destinatario-cc"
                                    data-toggle="tooltip" data-placement="top"
                                    title="Utilizar para agregar en copia al requerimiento">
                                <i class="far fa-copy"></i>
                            </button>
                        </div>
                    </div>
                </fieldset>



            </div>

            <table id="tabla_funcionarios" class="table table-striped table-sm" style="display: none">
                <thead>
                <tr>
                    <th>Unidad Organizacional</th>
                    <th>Destinatario</th>
                    <th>En copia</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>


            <div class="form-row">
                <fieldset class="form-group @if($parte->id <> 0) col-12 @else col-6 @endif">
                    <label for="for_date">Asunto</label>
                    <input type="text" class="form-control" id="for_subject"
                           name="subject" required="required" value="{{$parte->subject}}">
                </fieldset>

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

                <fieldset class="form-group @if($parte->id <> 0) col-12 @else col-3 @endif">
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
                </fieldset>
            </div>

            <div class="row">
                <fieldset class="form-group @if($parte->id <> 0) col-12 @else col @endif">
                    <label for="for_date">Requerimiento</label>
                    <textarea class="form-control" id="for_body" name="body" rows="3" required></textarea>
                </fieldset>
            </div>

            <button type="submit" class="btn btn-primary">Crear</button>

        </form>
    </div>
</div>




@endsection

@section('custom_js')
  <script>

  	 $(document).ready(function(){
       var array = new Array;
  		 $("#ou").val(1);
  		 $("#ou").trigger("change");
  	 //});




  		// $('#ou').on('change', function(e){
  		//     console.log(e);
  		//     var ou_id = e.target.value;
  		//     $.get('{{ route('rrhh.users.get.from.ou')}}/'+ou_id, function(data) {
  		//         console.log(data);
  		//         $('#user').empty();
  		//         $.each(data, function(index,subCatObj){
  		//             $('#user').append(
  		// 							'<option value="'+subCatObj.id+'">'+subCatObj.name+' '+subCatObj.fathers_family+' '+subCatObj.mothers_family+'</option>'
  		// 							);
  		//         });
  		//     });
  		// });

  		// $('#ou').on('change', function(e){
  		//     console.log(e);
  		//     var ou_id = e.target.value;
  		//     $.get('{{ route('rrhh.users.get.autority.from.ou')}}/'+ou_id, function(data) {
  		//         console.log(data);
  		// 				//alert(data.user_id);
  		// 				document.getElementById("user").value = data.user_id;
  		//     });
  		// });

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

  </script>
@endsection