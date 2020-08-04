<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <table>
        <thread>
            <tr>
                <th>Nombre</th>
                <th>Editar</th>
            </tr>
        </thread>
        <tbody>
            @foreach($organizationalunits as $organizationalunit)
            <tr>
                <td>{{$organizationalunit->name}}</td>
                <td><a href="{{ route('rrhh.organizationalunits.edit', $organizationalunit) }}" class="btn btn-outline-secondary btn-sm">
					<span class="fas fa-edit" aria-hidden="true"></span> editar</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>