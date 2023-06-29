@foreach (['danger', 'warning', 'success', 'info'] as $key)
    @if(session()->has($key))
        <div class="alert alert-{{ $key }} alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {!! session()->get($key) !!}
        </div>
    @endif
@endforeach