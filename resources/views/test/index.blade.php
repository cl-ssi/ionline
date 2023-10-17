@extends('layouts.bt4.app')

@section('title', 'Home')

@section('content')

<form method="post" action="{{ route('test.post') }}">
    @csrf
    <textarea name="texto" id="tt"  
        rows="18" 
        class="form-control"  
        style="white-space: pre-wrap;"></textarea>
    <button class="btn btn-primary">Guardar</button>
</form>

@endsection

@section('custom_js')
<script>
//Javascript
var stringAsHtml = $('tt').val().Replace("\r\n", "<br />\r\n");
console.log('stringAsHtml');

</script>

@endsection
