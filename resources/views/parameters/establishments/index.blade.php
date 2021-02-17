@extends('layouts.app')

@section('title', 'Lista de Establecimientos')

@section('content')

@include('parameters/nav')

<h3 class="mb-3">Establecimientos</h3>

<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Tipo</th>
            <th>Nombre</th>
            <th>DEIS</th>
            <th>CÓD. SIRH</th>
            <th>Comuna</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($establishments as $establishment)
            <tr>
                <td>{{ $establishment->id }}</td>
                <td>{{ $establishment->type }}</td>
                <td>{{ $establishment->name }}</td>
                <td>{{ $establishment->deis }}</td>
                <td>{{ $establishment->sirh_code }}</td>
                <td>{{ $establishment->commune->name }}</td>
                <td>
                    <button class="btn btn-default" data-toggle="modal"
                        data-target="#editModal"
                        data-name="{{ $establishment->name }}"
                        data-sirh="{{ $establishment->sirh_code }}"
                        data-formaction="{{ route('parameters.establishments.update', $establishment->id)}}">
                    <i class="fas fa-edit"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@include('parameters/establishments/modal_edit')

@endsection

@section('custom_js')
<script type="text/javascript">
    $('#editModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var modal = $(this)

        var name = button.data('name')
        var sirh = button.data('sirh')
        modal.find('.modal-title').text('Editando ' + name)
        modal.find('input[name="name"]').val(name)
        modal.find('input[name="sirh"]').val(sirh)

        var formaction  = button.data('formaction')
        modal.find("#form-edit").attr('action', formaction)
    })
</script>
@endsection
