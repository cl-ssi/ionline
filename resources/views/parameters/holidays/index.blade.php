@extends('layouts.app')

@section('title', 'Lista de Feriados')

@section('content')

@include('parameters.nav')

<h3 class="mb-3">Lista de Feriados</h3>

<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Fecha</th>
            <th>Nombre</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($holidays as $holiday)
            <tr>
                <td>{{ $holiday->id }}</td>
                <td>{{ $holiday->date }}</td>
                <td>{{ $holiday->name }}</td>
                <td>
                    <button class="btn btn-outline-secondary" data-toggle="modal"
                        data-target="#editModal"
                        data-date="{{ $holiday->date }}"
                        data-name="{{ $holiday->name }}"
                        data-formaction="{{ route('parameters.holidays.update', $holiday->id)}}">
                    <i class="fas fa-edit"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@include('parameters/holidays/modal_edit')

@endsection

@section('custom_js')
<script type="text/javascript">
    $('#editModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var modal  = $(this)

        modal.find('input[name="date"]').val(button.data('date'))
        modal.find('input[name="name"]').val(button.data('name'))

        var formaction  = button.data('formaction')
        modal.find("#form-edit").attr('action', formaction)
    })
</script>
@endsection
