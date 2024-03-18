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
                @foreach($periods as $period)
                <th class="text-center {{ now()->greaterThan($period->end_at) ? 'table-primary' : '' }}">{{ $period->name }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->short_name }}</td>
                <td>{{ $organizationalUnit }}</td>
                <td class="text-center"><a class="btn btn-success btn-sm" wire:click="showForm('{{ $user->id }}', '{{ $period->id }}')"><i class="bi bi-file-check"></i></a></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <br><br><br>

    @if($selectedUser)
        <h4 class="mb-3">Informe de desempeño</h4>
        <form>
        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Periodo</label>
            <div class="col-sm-9">
            <input type="text" class="form-control" value="{{ $selectedPeriod->name }}"  readonly>
            </div>
        </div>
            <div class="row mb-3">
            <label  class="col-sm-3 col-form-label">Nombre Funcionario</label>
            <div class="col-sm-9">
            <input type="text" class="form-control"  value="{{ $selectedUser->short_name }}"  readonly>
            </div>
        </div>
            <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Unidad organizacional</label>
            <div class="col-sm-9">
            <input type="text" class="form-control"  value="{{ $organizationalUnit }}" readonly>
            </div>
        </div>
        </form>
    @endif


</div>
