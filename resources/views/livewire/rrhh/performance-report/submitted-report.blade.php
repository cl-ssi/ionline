<div>
    @include('rrhh.performance_report.partials.nav')

    <h3 class="mb-3">Informe de desempeño Realizados</h3>
    <div class="mb-3">
        <label class="form-label" for="newField">Periodo</label>
        <select class="form-select" id="year" wire:model="year" required autocomplete="off">
            @for ($i = now()->year; $i >= 2024; $i--)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </select>
    </div>

    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Unidad</th>
                <th class="table-primary text-center">Oct-Dic</th>
                <th class="table-primary text-center">Ene-Mar</th>
                <th class="text-center">Abr-Jun</th>
                <th class="text-center">Jul-Sep</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->short_name }}</td>
                <td>{{ $organizationalUnit }}</td>
                <td class="text-center"><a class="btn btn-success btn-sm" href=""><i class="bi bi-file-check"></i></a></td>
                <td class="text-center"><button class="btn btn-success btn-sm"><i class="bi bi-file-check"></i></button></td>
                <td class="text-center"><button class="btn btn-secondary btn-sm disabled"><i class="bi bi-file-check"></i></button></td>
                <td class="text-center"><button class="btn btn-secondary btn-sm disabled"><i class="bi bi-file-check"></i></button></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
