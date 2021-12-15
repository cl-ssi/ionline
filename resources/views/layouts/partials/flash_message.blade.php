@foreach (['danger', 'warning', 'success', 'info'] as $key)
    @if(session()->has($key))
	    <div class="alert alert-{{ $key }} alert-dismissable">
	    	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	    	{!! session()->get($key) !!}
	    </div>
    @endif
@endforeach

@if(session()->has('verified'))
        <div class="alert alert-success alert-dismissable">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			Su dirección de correo electrónico se ha verificado correctamente.
		</div>
@endif