<div>

    <h3 class="mb-3">Configuración correo de cumpleaños</h3>


    @if($configuration)
    <div class="card" style="{{ $edit ? 'display:none' : '' }}">
        <div class="card-header">
            {{$configuration->subject}}
            <span style="float:right">
                <a href="#" wire:click="edit()">Editar</a>
            </span>
        </div>
        <div class="card-body">
            <h5 class="card-title">{{$configuration->tittle}}</h5>
            <p class="card-text">Estimado(a) @nombre,</p>
            <p class="card-text">{!!$configuration->message!!}</p>
        </div>
    </div>
    @endif

    
    <div style="{{ $edit ? '' : 'display:none' }}">

        <div class="form-row">
            <fieldset class="form-group col-6">
                <label>Asunto</label>
                <input type="text" class="form-control" wire:model.live="subject">
            </fieldset>
        </div>

        <div class="form-row">
            <fieldset class="form-group col-6">
                <label>Título</label>
                <input type="text" class="form-control" wire:model.live="tittle">
            </fieldset>
        </div>

        <div class="form-row">
            <fieldset class="form-group col-12">
                <label>Mensaje</label>

                <div wire:ignore>
                    <div class="form-group pt-1" style="width: 940px;">
                        <label for="contenido">Contenido*</label>
                        <textarea class="form-control" id="message" cols="30" rows="18" wire:model.blur="message">
                        </textarea>
                    </div>
                </div>
            </fieldset>
        </div>
        
        <button type="button" class="btn btn-primary mt-1 mb-4" wire:click="save()">Guardar</button>
        <button type="button" class="btn btn-secondary mt-1 mb-4" wire:click="cancel()">Cancelar</button>

    </div>

    @if($system_message != "")
        <br>
        <div class="alert alert-success" role="alert">
            {{ $system_message }}
        </div>
    @endif

    <a href="#" wire:click="review_users()" style="{{ $review_users ? 'display:none' : '' }}" >Próximos cumpleaños</a>
    <a href="#" wire:click="review_users()" style="{{ $review_users ? '' : 'display:none' }}" >Ocultar próximos cumpleaños</a>

    <div style="{{ $review_users ? '' : 'display:none' }}">
        <br><hr>
        <h4>Ionline</h4>
        <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">Rut</th>
            <th scope="col">Nombre</th>
            <th scope="col">F.Nacimiento</th>
            <th scope="col">Años</th>
            <th scope="col">Email</th>
            </tr>
        </thead>
        <tbody>
            @if($users_array)
            @foreach($users_array as $user)
                @if($user->email_personal)<tr>
                @else <tr class="table-danger">
                @endif
                    <th scope="row">{{$user->runFormat}}</th>
                    <td>{{$user->fullName}}</td>
                    <td>{{$user->birthday->format('m-d')}}</td>
                    <td>{{$user->birthday->age}}</td>
                    <td>{{$user->email_personal}}</td>
                </tr>
            @endforeach
            @endif
        </tbody>
        </table>
        <hr>

        <h4>Sirh</h4>
        <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">Rut</th>
            <th scope="col">Nombre</th>
            <th scope="col">F.Nacimiento</th>
            <th scope="col">Años</th>
            <th scope="col">Email</th>
            </tr>
        </thead>
        <tbody>
            @if($sirh_users_array)
            @foreach($sirh_users_array as $user)
                @if($user->email)<tr>
                @else <tr class="table-danger">
                @endif
                    <th scope="row">{{$user->id}}</th>
                    <td>{{$user->name}}</td>
                    <td>{{$user->birthdate->format('m-d')}}</td>
                    <td>{{$user->birthdate->age}}</td>
                    <td>{{$user->email}}</td>
                </tr>
            @endforeach
            @endif
        </tbody>
        </table>
    </div>



    @section('custom_js')

    <script src="https://cdn.tiny.cloud/1/ktzops2hqsh9irqr0b17eqfnkuffe5d3u0k4bcpzkc1kfssx/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        tinymce.init({
            selector: '#message',
            forced_root_block: false,
            setup: function (editor) {
                editor.on('init change', function () {
                    editor.save();
                });
                editor.on('change', function (e) {
                    @this.set('message', editor.getContent());
                });
            }
        });
    </script>

    @endsection
</div>
