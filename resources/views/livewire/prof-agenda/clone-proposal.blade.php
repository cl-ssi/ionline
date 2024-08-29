<div>
    @if(!$showSelect)
        <div class="row">
            <fieldset class="form-group col-8">
            </fieldset>
            <fieldset class="form-group col-4">
                <label for="for_users"><br></label>
                <button class="btn btn-warning form-control" wire:click="openModal">Clonar a otro funcionario</button>
            </fieldset>
        </div>
    @endif


    @if($showSelect)
        <hr>
        <h4>Clonar horario</h4>

        <div class="alert alert-warning" role="alert">
            La propuesta a la cual se clonará el horario debe estar vacía.
        </div>

        <div>
            @if (session()->has('danger_message'))
                <div class="alert alert-danger">
                    {{ session('danger_message') }}
                </div>
            @endif
        </div>

        <div>
            @if (session()->has('confirmation_message'))
                <div class="alert alert-success">
                    {{ session('confirmation_message') }}
                </div>
            @endif
        </div>

        

        <div class="row">
            <fieldset class="form-group col-4">
                <label for="for_users">Propuesta</label>
                <select class="form-control" wire:model="selectedProposal" required>
                    <option value=""></option>
                    @foreach($proposals as $proposal)
                        <option value="{{$proposal->id}}">{{$proposal->id}} - {{$proposal->employee->shortName}}</option>
                    @endforeach
                </select>
            </fieldset>

            <fieldset class="form-group col-2">
                <label for="for_profesion_id"><br></label>
                <button class="btn btn-primary form-control" wire:click="save">Clonar</button>
            </fieldset>

            <fieldset class="form-group col-2">
                <label for="for_profesion_id"><br></label>
                <button class="btn btn-secondary form-control" wire:click="hideSelect">Cancelar</button>
            </fieldset>
        </div>
        <hr>
    @endif

</div>
