@foreach (['danger', 'warning', 'success', 'info'] as $key)
    @if(session()->has($key))
        <div class="alert alert-{{ $key}} alert-dismissible fade show" role="alert">
            {!! session()->get($key) !!}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
@endforeach