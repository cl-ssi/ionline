<!DOCTYPE html>
<html lang="es" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Confirmación de ingreso</title>
        <style>
            body {
                font-size: 11.0pt;
                font-family: Arial, Helvetica, sans-serif;
            }
            .texto {
                font-size:9.0pt;
                font-family:Arial, Helvetica, sans-serif;
                color: #7F7F7F;
            }
            .justify {
                text-align: justify;
            }
            .linea_firma {
                font-size:24.0pt;
                font-family:Arial, Helvetica, sans-serif;
            }
            .letra_servicio {
                font-size:7.0pt;
                font-family:Arial, Helvetica, sans-serif;
                margin-left: 3px;
                font-weight: 800;
            }
            .letra_ministerio {
                font-size:4.5pt;
                font-family:Arial, Helvetica, sans-serif;
                margin-top: 2px;
                margin-left: 4px;
                font-weight: 600;
            }
            .letra_gobierno {
                font-size:5.5pt;
                font-family:Arial, Helvetica, sans-serif;
                font-weight: 800;
                margin-left: 3px;
                margin-top: 70px;
            }
            .escudo {
                text-align: center;
                font-size:60pt;
                color: #CCC;
                margin-top: 0px;
            }
        </style>
    </head>
    <body>
        <table border="1" style="border-collapse:collapse;">
            <tr style="vertical-align: top;">
                <td style="width: 54px;"><div class="escudo">*</div></td>
                <td style="width: 79px;">
                    <div class="letra_servicio">Servicio de</div>
                    <div class="letra_servicio">Salud Iquique</div>
                    <div class="letra_ministerio">Ministerio de Salud</div>
                    <div class="letra_gobierno">Gobierno de Chile</div>
                </td>
            </tr>
        </table>
        <!-- <img src="{{ asset('images/SSI_PLUMA.jpg') }}" width="140" alt=""> -->

        <br>
        <strong>MODULO FORMULARIO DE REQUERIMIENTO DE COMPRAS</strong><br>
        <strong>SOLICITUD DE COMPRA DE PASAJE</strong><br><br>
        <hr>
        <div class="justify">
            <div class="card">
                <div class="card-body">
                    <h3>Estimado/a </h3>
                    <p>Usted tiene una nueva solicitud de aprobación para compra de pasajes,
                      correspondiente al formulario de requerimientos N°.: <strong>{{ $notification->id }}</strong>.</p>
                    <p><strong>Fecha</strong>: {{ $notification->updated_at }}</p>
                    <p><strong>Justificación</strong>: {{ $notification->justification }}</p>
                    <p><strong>Solicita:</strong>: {{ $notification->whorequest->FullName }}</p>
                    <p><strong>Cargo</strong>:<br>{{ $notification->whorequest_position }}</p>
                    <p><strong>NOTA</strong>: Este es un mensaje automático, favor no responder este correo, el seguimiento de su Ticket debe realizarlo a través de la plataforma.</p>
                    <p>Saludos cordiales.</p>
                </div>
            </div>
            <br>

            <p class="texto">
                <span class="linea_firma" style="color: #EE3A43">——</span><span class="linea_firma" style="color: #0168B3">———</span><br>
                <span class="texto"><b>SSI Intranet</b></span><br>
                <span class="texto">Módulo de Formularios de Requerimientos de Compras</span>
                <br><br>
                Unidad de Tecnología, Informática y Comunicación<br>
                <b>Servicio de Salud Iquique | Gobierno de Chile</b><br>
                soporte.ssi@redsalud.gob.cl<br>
            </p>

        </div>

    </body>
</html>
