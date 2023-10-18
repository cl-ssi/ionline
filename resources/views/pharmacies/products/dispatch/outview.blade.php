@extends('layouts.bt4.integrity')

@section('content')

@isset($dispatch)
@if($dispatch)
<h3>Agregar observación</h3>

<form method="POST" action="{{env('APP_URL').'/external_pharmacy/store'}}">
	@csrf

    <input type="hidden" name="dispatch_id" value="{{$dispatch->id}}">
    <div class="form-row">
        <fieldset class="form-group col">
            <label for="for_note">Observación</label>
            <input type="text" class="form-control" id="for_observation" placeholder="" name="observation" required="">
        </fieldset>
    </div>

	<button type="submit" class="btn btn-primary">Guardar</button>
</form>
@endif
@endisset

<br><br>


@endsection