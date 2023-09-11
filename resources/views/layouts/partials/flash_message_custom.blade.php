@foreach (['danger-custom', 'warning-custom', 'success-custom', 'info-custom'] as $key)
    @if(session()->has($key))
        <div class="alert alert-{{ str_replace('-custom','',$key) }} alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {!! session()->get($key) !!}
        </div>
    @endif
@endforeach
