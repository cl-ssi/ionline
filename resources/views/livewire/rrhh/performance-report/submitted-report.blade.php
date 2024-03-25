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
                @if(!$periods->isEmpty())
                    @foreach($periods as $period)
                        <th class="text-center {{ now()->greaterThan($period->end_at) ? 'table-primary' : '' }}">{{ $period->name }}</th>
                    @endforeach
                @else
                    <th colspan="3" class="text-center">No hay períodos definidos <br><small>(crear periodo de informe)</small></th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->short_name }}</td>
                    <td>{{ $organizationalUnit }}</td>
                    @if(!$periods->isEmpty())
                        <td class="text-center">
                            @foreach($periods as $period)
                                <a class="btn btn-success btn-sm" wire:click="showForm('{{ $user->id }}', '{{ $period->id }}')"><i class="bi bi-file-check"></i></a>
                            @endforeach
                        </td>
                    @else
                        <td class="text-center">-</td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No hay usuarios para mostrar</td>
                </tr>
            @endforelse
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
