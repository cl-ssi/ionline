<div>
    @section('title', 'Administrar Inventarios')

    <h3 class="mb-3">
        Administrar Inventarios
    </h3>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>
                        Establecimiento
                    </th>
                    <th class="text-center">
                        Usuarios que pueden ver Inventario
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($establishments as $establishment)
                <tr>
                    <td>
                        {{ $establishment->name }}
                    </td>
                    <td class="text-center">
                        <a href="{{ route('inventories.users.manager', $establishment) }}">
                            {{ $establishment->usersInventories->count() }}
                            {{ ($establishment->usersInventories->count() > 1 ) ? 'usuarios' : 'usuario' }}
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $establishments->links() }}

    </div>
</div>
