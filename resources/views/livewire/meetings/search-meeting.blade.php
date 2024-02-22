<div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm small">
            <thead>
                <tr class="text-center">
                    <th>ID</th>
                    <th>Fecha Creación</th>
                    <th>Fecha Reunión</th>
                    <th>Tipo</th>
                    <th>Asunto</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($meetings as $meeting)
                <tr>
                    <th class="text-center">{{ $meeting->id }}</th>
                    <td>{{ $meeting->created_at->format('d-m-Y H:i:s') }}</td>
                    <td>{{ $meeting->date->format('d-m-Y') }}</td>
                    <td>{{ $meeting->type }}</td>
                    <td>{{ $meeting->subject }}</td>
                    <td class="text-center">
                        <a href="{{ route('meetings.edit', $meeting) }}"
                            class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-edit"></i> 
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
