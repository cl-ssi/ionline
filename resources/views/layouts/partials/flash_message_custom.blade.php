@if(session()->has($name))
    <div class="alert alert-{{ $type ?? 'primary' }} alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {!! session()->get($name) !!}
    </div>
@endif