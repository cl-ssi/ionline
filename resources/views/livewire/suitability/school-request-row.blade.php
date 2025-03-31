<div>
    <tr class="{{ $psirequest->status_inhability != 'enabled' ? 'table-danger' : '' }}">
        <td>{{ $psirequest->id }}</td>
        <td>{{ $psirequest->user_external_id }}</td>
        <td>{{ $psirequest->user->fullName }}</td>
        <td>{{ $psirequest->job }}</td>
        <td>{{ $psirequest->user->email }}</td>
        <td>
            {{ $psirequest->inhabilidad }}
            @if($psirequest->status_inhability != 'enabled')
                <button class="btn btn-sm btn-link text-primary" 
                    wire:click="asdasdasdasd">
                    <i class="fas fa-edit"></i>
                </button>
            @endif
        </td>
        <td>{{ $psirequest->status }}</td>
        <td>
            @if($psirequest->status == "Aprobado" && $psirequest->result)
                @if($psirequest->result->signedCertificate && $psirequest->result->signedCertificate->hasAllFlowsSigned)
                    <a href="{{ route('idoneidad.signedSuitabilityCertificate', $psirequest->result->id) }}" class="btn @if($psirequest->result->signedCertificate->hasAllFlowsSigned) btn-outline-success @else btn-outline-primary @endif" target="_blank">
                        <span class="fas fa-file-pdf" aria-hidden="true"></span></a>
                @endif
            @endif
        </td>
    </tr>
</div>
