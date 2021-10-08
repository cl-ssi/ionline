<!DOCTYPE html>
<html lang="es" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title></title>
        <style media="screen">
            .datos {
                background-color: #70D2D8;
                color: #0B4796;
            }
            #maincontainer {
              width:100%;
              height: 100%;
            }

            #leftcolumn {
              float:left;
              display:inline-block;
              width: 100px;
              height: 100%;
              background: blue;
            }

            #contentwrapper {
              float:left;
              display:inline-block;
              width: -moz-calc(100% - 100px);
              width: -webkit-calc(100% - 100px);
              width: calc(100% - 100px);
              height: 100%;
              background-color: red;
            }
        </style>
    </head>
    <body>
        <div id="maincontainer">
            <div id="leftcolumn" class="">
                <img src="{{ asset('images/logo_rgb.png')}}" alt="logo SSI">
            </div>

            <div id="contentwrapper " class="">
                <h2>CAMPAÑA VACUNACIÓN COVID-19</h2>
                <h1>YO ME VACUNO</h1>
            </div>
        </div>

        <div class="datos">
            Nombre: {{ $vaccination->fullName() }}
        </div>

        Fecha 1° vacunación: {{ $vaccination->first_dose_at->format('d-m-Y H:i') }}
        Fecha 2° vacunación: {{ optional($vaccination->second_dose_at)->format('d-m-Y H:i') }}
        Lugar de vacunación: Hospital Ernesto Torres Galdámes
        Tipo de Vacuna: CORONAVAC / LABORATORIO SINOVAC LIFE SCIENCE®
    </body>
</html>
