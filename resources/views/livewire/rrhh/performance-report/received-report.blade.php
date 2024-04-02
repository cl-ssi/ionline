<div>    
    @include('rrhh.performance_report.partials.nav')
    <h3 class="mb-3 mt-3">Mis Informes de Desempeño</h3>
    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>Id</th>
                <th>Periodo</th>
                <th>Realizado Por</th>
                <th>Informe</th>
                <th>Toma de conocimiento</th>
            </tr>
        </thead>
        <tbody>
            @foreach($performanceReports as $report)
            <tr>
                <td>{{ $report->id }}</td>
                <td>{{ $report->period->name }}</td>
                <td>{{ $report->createdUser->short_name }}</td>
                <td class="text-center">
                    <a class="btn btn-success btn-sm" href="{{ route('rrhh.performance-report.show', ['userId' => auth()->user()->id, 'periodId' => $report->period->id]) }}"
                    title="Descargar PDF" target="_blank"
                    ><i class="bi bi-file-check"></i></a>
                </td>
                <td class="text-success">
                @if ($report->latest_approval_date)
                    {{ $report->latest_approval_date }}
                @else
                    Pendiente
                @endif                   
                    <br>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Observación" aria-label="Recipient's username" aria-describedby="button-addon2">
                        <button class="btn btn-primary" type="button" id="button-addon2">
                            <i class="bi bi-floppy"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
</div>
