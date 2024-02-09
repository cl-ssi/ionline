<div>
    <h3>Informe de prestador</h3>

    <!-- Input de tipo mes y año en bootstrap 5.3 -->
    <div class="mb-3">
        <label for="period" class="form-label">Periodo {{ $period }}</label>
        <input
            type="month"
            class="form-control"
            wire:model="period"
        />
    </div>

    
    <div class="mb-3">
        <label for="issues" class="form-label">Github</label>
        <textarea class="form-control" wire:model="github_input" id="issues" rows="10"></textarea>
    </div>
    
    <button
        type="button"
        class="btn btn-primary"
        wire:click="process"
    >
        Procesar
    </button>
    
    <table class="table table-sm table-bordered small">
        <thead>
            <tr>
                <th>Repositorio</th>
                <th>Issue</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Tarea</th>
                <th>Iteración</th>
                <!-- <th>Estado</th> -->
            </tr>
        </thead>
        <tbody>
            @foreach($issues as $issue)
            <tr>
                <td>{{ $issue['Repository'] }}</td>
                <td>{{ $issue['URL'] }}</td>
                <td nowrap>{{ $issue['Start at']->format('Y-m-d') }}</td>
                <td nowrap>{{ $issue['End at']->format('Y-m-d') }}</td>
                <td>{{ $issue['Title'] }}</td>
                <!-- <td>{{ $issue['Assignees'] }}</td> -->
                <td>{{ $issue['Iteration'] }}</td>
                <!-- <td>{{ $issue['Status'] }}</td> -->
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
