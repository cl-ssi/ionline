<!-- Modal -->
@if($bootstrap == 'v4')
    <div class="modal fade" id="strategicAxesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <style>
                        .preserve-line-breaks {
                            white-space: pre-wrap;
                        }
                    </style>
                    <table class="table table-bordered table-striped table-sm small">
                        <thead>
                            <tr class="text-center">
                                <th width="5%">#</th>
                                <th width="30%">Objetivos Estratégicos (OE)</th>
                                <th width="65%">Objetivo de Impacto (OI)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($strategicAxes as $strategicAxis)
                                <tr>
                                    <th>OE {{ $strategicAxis->number }}</th>
                                    <th class="text-center">{{ $strategicAxis->name }}</th>
                                    <td class="preserve-line-breaks">{{ $strategicAxis->description }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="modal fade" id="strategicAxesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ejes Estratégicos (EE)</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <style>
                        .preserve-line-breaks {
                            white-space: pre-wrap;
                        }
                    </style>
                    <table class="table table-bordered table-striped table-sm small">
                        <thead>
                            <tr class="text-center">
                                <th width="5%">#</th>
                                <th width="30%">Objetivos Estratégicos (OE)</th>
                                <th width="65%">Objetivo de Impacto (OI)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($strategicAxes as $strategicAxis)
                                <tr>
                                    <th class="text-center">OE {{ $strategicAxis->number }}</th>
                                    <th class="text-center">{{ $strategicAxis->name }}</th>
                                    <td class="preserve-line-breaks">{{ $strategicAxis->description }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endif