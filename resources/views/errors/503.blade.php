<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1.0">
    <title>En mantención</title>
    <style>
        h1, h2 {
            font-family: Sans-serif;
            font-weight: 200;
            color: #006fb3;
        }
        .gb_azul {
            color: #006fb3;
        }
        .gb_rojo {
            color: #fe6565;
        }
    </style>
</head>
<body>

    <center>
    <br>
    <br>

    <h1>{{ env('APP_NAME') }} - {{ env('APP_SS') }}</h1>
    <div>
        <table>
            <tr>
                <td style="background-color: #006fb3;" width="250" height="6"></td>
                <td style="background-color: #fe6565;" width="250" height="6"></td>
            </tr>
        </table>
    </div>

    <br>
    <br>
    <img src="/images/mantenimiento.png" alt="En mantenimiento">
    <br>
    <br>

    <h2 class="gb_rojo">EN MANTENIMIENTO 🤖</h2>

    </center>
    
</body>
</html>