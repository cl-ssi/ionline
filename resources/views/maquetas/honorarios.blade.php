@extends('layouts.app')

@section('title', 'Maqueta Honorario')

@section('content')

<h3 class="mb-3">Perfil Funcionario</h3>

<table class="table table-bordered">
    <caption style="caption-side: top;">Datos Personales</caption>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Rut</th>
                <th>Dirección</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Alvaro</td>
                <td>1243124</td>
                <td>Dirección</td>
            </tr>
        </tbody>
</table>

<fieldset class="form-group col-12 col-md-2">
    <label for="for_month">Año</label>
    <select name="year" class="form-control text-capitalize">
        <option value=""></option>
        @php
            $currentYear = Carbon\Carbon::now()->year;
            $startYear = $currentYear - 10;
            $endYear = $currentYear + 10;
        @endphp
        @for($i = $startYear; $i <= $endYear; $i++)
            <option value="{{ $i }}" {{ old('year')==$i ? 'selected':'' }}>
                {{ $i }}
            </option>
        @endfor
    </select>
</fieldset>


        </fieldset>

        <table id="month-table" class="table">
    <thead>
        <tr>
            <th>DIURNO</th>
            <th>HORA EXTRA</th>
            <th>TURNO</th>
            <th>HORA MEDICA</th>
        </tr>
    </thead>
    <tbody>
        <!-- rows go here -->
    </tbody>
</table>

<select id="month-select" name="month" class="form-control text-capitalize">
    <option value=""></option>
    @for($i = 1; $i <= 12; $i++)
        <option value="{{ $i }}" {{ old('month')==$i ? 'selected':'' }}>
            {{ Carbon\Carbon::parse("0000-$i-1")->monthName }}
        </option>
    @endfor
</select>

<script>
function getContractCounts() {
    var yearSelect = document.querySelector('select[name="year"]');
    var monthSelect = document.querySelector('select[name="month"]');
    var monthTable = document.getElementById('month-table');
    var contractCounts = [0, 0, 0, 0];

    if (yearSelect.value !== '' && monthSelect.value !== '') {
        // Make Ajax request to backend to get contract counts for selected month and year
        axios.get('/contracts', {
            params: {
                year: yearSelect.value,
                month: monthSelect.value
            }
        })
        .then(function (response) {
            // Update contract counts array with response data
            contractCounts = response.data;
            // Update table with new counts
            var tableBody = monthTable.querySelector('tbody');
            tableBody.innerHTML = '';
            for (var i = 0; i < contractCounts.length; i++) {
                var newRow = document.createElement('tr');
                var newCell = document.createElement('td');
                newCell.textContent = contractCounts[i];
                newRow.appendChild(newCell);
                tableBody.appendChild(newRow);
            }
            // Show table
            monthTable.style.display

<a href="{{ route('maquetas.menu') }}" class="btn btn-primary">Menu</a>

@endsection

