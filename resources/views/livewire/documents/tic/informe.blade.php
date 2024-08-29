<div>
    <h3>Informe de prestador</h3>

    <div class="mb-3">
        <label for="issues" class="form-label">Archivo TSV de Github</label>
        <textarea class="form-control" wire:model.live="github_input" id="issues" rows="8"></textarea>
    </div>

    <div class="row">
        <div class="col-md-4">
            <button
                type="button"
                class="btn btn-primary"
                wire:click="process"
            >
                Procesar
            </button>
            Registros procesados: {{ $records }}
        </div>
        <div class="offset-md-6 col-md-2">
            <div class="mb-3">
                <input
                    type="month"
                    class="form-control"
                    wire:model.live="period"
                />
            </div>
        </div>

    </div>

    <table class="table table-sm table-bordered small">
        <thead>
            <tr>
                <th>Repositorio</th>
                <th>N°</th>
                <th>Inicio</th>
                {{-- <th>Fin</th> --}}
                <th>Tarea</th>
                <!-- <th>Iteración</th> -->
                {{-- <th>Estado</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach($filtered_issues as $issue)
            <tr>
                <td>{{ $issue['Repository'] }}</td>
                <td>{{ $issue['URL'] }}</td>
                <td nowrap>{{ $issue['Start at']->format('Y-m-d') }}</td>
                {{-- <td nowrap>{{ $issue['End at']->format('Y-m-d') }}</td> --}}
                <td>{{ $issue['Title'] }}</td>
                <!-- <td>{{ $issue['Assignees'] }}</td> -->
                <!-- <td>{{ $issue['Iteration'] }}</td> -->
                {{-- <td>{{ $issue['Status'] == '✅ Done' ? 'Completado' : 'En desarrollo' }}</td> --}}
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
