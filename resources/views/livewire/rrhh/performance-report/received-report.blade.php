<div>    
    @include('rrhh.performance_report.partials.nav')
    <h3 class="mb-3 mt-3">Mis Informes de Desempeño</h3>
    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>Id</th>
                <th>Periodo</th>
                <th>Jefatura</th>
                <th>Informe</th>
                <th>Toma de conocimiento</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>123</td>
                <td>Oct-Dic</td>
                <td>José Donoso Carrera</td>
                <td class="text-center"><a class="btn btn-success btn-sm" href=""><i class="bi bi-file-check"></i></a></td>
                <td class="text-success">
                    2023-12-12 13:23:69<br>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Observación" aria-label="Recipient's username" aria-describedby="button-addon2">
                        <button class="btn btn-primary" type="button" id="button-addon2">
                            <i class="bi bi-floppy"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <tr>
                <td>123</td>
                <td>Ene-Mar</td>
                <td>José Donoso Carrera</td>
                <td class="text-center"><a class="btn btn-success btn-sm" href=""><i class="bi bi-file-check"></i></a></td>
                <td class="text-secondary">
                    Pendiente
                </td>
            </tr>

        </tbody>
    </table>
</div>
