<div>
<div class="table-responsive">
<table class="table table-sm table-bordered small">
    <thead>
        <tr>
        <th>Id</th>
        <th>Tipo de Contrato</th>
        <th>Descripción de Servicio</th>
        </tr>
        </thead>
    <tbody>
    @foreach ($sr => $servicerequest)
    <tr>
    <td class="small">{{ $servicerequest->id ?? '' }}</td>
    <td class="small">{{ $servicerequest->id ?? '' }}</td>
    </tr>


    @endforeach
    </tbody>
</table>
</div>
</div>