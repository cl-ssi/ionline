<h4 class="mt-3">Historial de cambios</h4>
<div class="table-responsive-md">
<table class="table table-sm small text-muted mt-3">
    <thead>
        <tr>
            <th>Evento</th>
            <th>Acción</th>
            <th>Modificaciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($audits->sortByDesc('updated_at') as $audit)
        <tr>
            <td>
                <strong>Usuario:</strong> {{ optional($audit->user)->fullName }}<br>
                <strong>Fecha:</strong> {{ $audit->created_at }}<br>
                <strong>Modelo:</strong> {{ $audit->auditable_type }}<br>
                <strong>Id:</strong> {{ $audit->auditable_id }}<br>
                <strong>URL:</strong> {{ $audit->url }}<br>
                <strong>IP:</strong> {{ $audit->ip_address }}
            </td>
            <td>
                {{ $audit->event }}
            </td>
            <td>
            @if($audit->event != "deleted")
              @foreach($audit->getModified() as $attribute => $modified)
                  <strong>{{ $attribute }}</strong> :  {{ isset($modified['old']) ? $modified['old'] : '' }}  => {{ $modified['new'] }} <br>
              @endforeach
            @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
