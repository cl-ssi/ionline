@if(session()->has($name))
    <div class="alert alert-{{ $type ?? 'primary' }} alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {!! session()->get($name) !!}
    </div>
@endif

<!--
    Ejemplo de uso:

    Incluir en el blade:
    @include('layouts.partials.flash_message_custom',[
        'name' => 'custom_name',  // debe ser único
        'type' => 'primary' // optional: 'primary' (default), 'danger', 'warning', 'success', 'info'
    ])


    En el controller:
    session()->flash('custom_name','Mensaje que se quiere mostrar');
-->