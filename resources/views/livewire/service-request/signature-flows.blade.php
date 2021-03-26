<div class="row">
  @foreach($signatureFlows as $key => $signatureFlow)
    <fieldset class="form-group col-sm-4">
        <label for="for_users">{{$key}}</label>
        <select name="users[]" class="form-control" id="{{$key}}" data-live-search="true" required="" data-size="5" readonly>
          @foreach($users as $key => $user)
            <option value="{{$user->id}}" @if($user->id == $signatureFlow) selected @else disabled @endif >{{$user->getFullNameAttribute()}}</option>
          @endforeach
        </select>
    </fieldset>
  @endforeach
</div>
