<div>
    <div class="table-responsive">
        <table class="table table-sm table-bordered my-0">
            <tbody>
                <tr>
                    <td class="alert-light text-center">
                        <span title="Recibidos">
                            Creados
                        </span>
                        ({{ $counters['created'] }})
                    </td>
                    <td class="alert-warning text-center">
                        Respondidos ({{ $counters['replyed'] }})
                    </td>
                    <td class="alert-success text-center">
                        Cerrados ({{ $counters['closed'] }})
                    </td>
                    <td class="alert-primary text-center">
                        Derivados ({{ $counters['derived'] }})
                    </td>
                    <td class="alert-secondary text-center">
                        Copia ({{ $counters['copy'] }})
                    </td>
                    <td class="alert-light text-center">
                        Reabierto ({{ $counters['reopen'] }})
                    </td>
                    <td class="alert-light text-center">
                        Pendiente ({{ $counters['pending'] }})
                    </td>
                    <td class="alert-light text-center">
                        Archivados ({{ $counters['archived'] }})
                    </td>
                    <td class="alert-secondary text-center">
                        Total ({{ $counters['total'] }})
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
