<div>
<div class="row">
  <fieldset class="form-group col-2">
      <label for="for_text">Id solicitud</label>
      <input type="text" class="form-control" wire:model="service_request_id">
  </fieldset>
  <fieldset class="form-group col-2">
      <label for="for_button"><br/></label>
      <button type="button" class="btn btn-primary form-control" wire:click="search()">Buscar</button>
  </fieldset>
</div>
<div class="row">

  <div id="for-picker" wire:ignore>
      <select wire:model.lazy="user_to_id" class="form-control selectpicker" data-live-search="true" data-size="5" required data-container="#for-picker">
          <option value=""></option>
          @foreach($users as $key => $user)
          <option value="{{$user->id}}">{{$user->getFullNameAttribute()}}</option>
          @endforeach
      </select>
  </div>

  <div id="for-picker" wire:ignore>
      <select wire:model.lazy="user_to_id" class="form-control selectpicker" data-live-search="true" data-size="5" required data-container="#for-picker">
          <option value=""></option>
          @foreach($users as $key => $user)
          <option value="{{$user->id}}">{{$user->getFullNameAttribute()}}</option>
          @endforeach
      </select>
  </div>

    <fieldset class="form-group col-12">
      @if($serviceRequests)
        <table class="table table-sm table-bordered">
          @foreach($serviceRequests->signatureFlows as $key => $signatureFlow)
            <tr>
                <td>{{$signatureFlow->responsable_id}}</td>
                <td>{{$signatureFlow->sign_position}}</td>
                <td>{{$signatureFlow->user->getFullNameAttribute()}}</td>
                <td>-</td>
                <td>
                  <select class="form-control selectpicker" data-live-search="true" data-size="5" required>
                      <option value=""></option>
                      @foreach($users as $key => $user)
                      <option value="{{$user->id}}">{{$user->getFullNameAttribute()}}</option>
                      @endforeach
                  </select>
                </td>
                <td><button>Derivar</button>
                </td>
            </tr>
          @endforeach
        </table>
      @endif
    </fieldset>
</div>
<div wire:loading wire:target="search">
    <span class="text-muted small">Procesando...</span>
</div>
</div>
