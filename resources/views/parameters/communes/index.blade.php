@extends('layouts.app')

@section('title', 'Lista de Comunas')

@section('content')

@include('parameters/nav')

<h3 class="mb-3">Comunas</h3>

<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($communes as $commune)
            <tr>
                <td>{{ $commune->id }}</td>
                <td>{{ $commune->name }}</td>
                <td>
                    <button class="btn btn-default" data-toggle="modal"
                        data-target="#editModal"
                        data-name="{{ $commune->name }}"
                        data-formaction="{{ route('parameters.communes.update', $commune->id)}}">
                    <i class="fas fa-edit"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@include('parameters/communes/modal_edit')

@endsection

@section('custom_js')
<script type="text/javascript">
    $('#editModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var modal = $(this)

        var name = button.data('name')
        modal.find('.modal-title').text('Editando ' + name)
        modal.find('input[name="name"]').val(name)

        var formaction  = button.data('formaction')
        modal.find("#form-edit").attr('action', formaction)
    })
</script>
@endsection
