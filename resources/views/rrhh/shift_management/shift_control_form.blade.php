<?php setlocale(LC_ALL, 'es_CL.UTF-8');?>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Certificado de cumplimiento</title>
        <meta name="description" content="">
        <meta name="author" content="Servicio de Salud Iquique">
        <style media="screen">
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 0.8rem;
        }
        .content {
            margin: 0 auto;
            /*border: 1px solid #F2F2F2;*/
            width: 724px;
            /*height: 1100px;*/
        }
        .monospace {
            font-family: "Lucida Console", Monaco, monospace;
        }
        .pie_pagina {
            margin: 0 auto;
            /*border: 1px solid #F2F2F2;*/
            width: 724px;
            height: 26px;
            position: fixed;
            bottom: 0;
        }
        .seis {
            font-size: 0.6rem;
        }
        .siete {
            font-size: 0.7rem;
        }
        .ocho {
            font-size: 0.8rem;
        }
        .nueve {
            font-size: 0.9rem;
        }
        .plomo {
            background-color: F3F1F0;
        }
        .titulo {
            text-align: center;
            font-size: 1.2rem;
            font-weight: bold;
            padding: 4px 0 6px;
        }
        .center {
            text-align: center;
        }
        .left {
            text-align: left;
        }
        .right {
            text-align: right;
        }
        .justify {
            text-align: justify;
        }

        .indent {
            text-indent: 30px;
        }

        .uppercase {
            text-transform: uppercase;
        }

        #firmas {
            margin-top: 100px;
        }

        #firmas > div {
            display: inline-block;
        }

        .li_letras {
            list-style-type: lower-alpha;
        }

        table {
            border: 1px solid grey;
            border-collapse: collapse;
            padding: 0 4px 0 4px;
            width: 100%;
        }
        th, td {
            border: 1px solid grey;
            border-collapse: collapse;
            padding: 0 4px 0 4px;
        }

        .column {
          float: left;
          width: 50%;
        }

        /* Clear floats after the columns */
        .row:after {
          content: "";
          display: table;
          clear: both;
        }

        @media all {
            .page-break { display: none; }
        }

        @media print {
            .page-break { display: block; page-break-before: always; }
        }
        tr.hide_all{
            text-align:center;
            border-style:hidden;
        }
        th.rightfield{
            border-top-style:hidden;
            border-left-style:hidden;
            border-bottom-style:hidden;
            font-size: 12px;
            text-align:center;
        }
        th.middlefield{
            border-top-style:hidden;
            border-bottom-style:hidden;
           font-size: 12px;
            text-align:center;
        }
        tr.bottomFields{
            border-left-style:hidden;
            border-bottom-style:hidden;
            border-right-style:hidden;
            
        }
        </style>
    </head>
    <body>
        <div class="content">
            <div class="content">
                <img style="padding-bottom: 4px;" src="images/logo_pluma.jpg" width="120" alt="Logo Servicio de Salud"><br>
                <div class="siete" style="padding-top: 3px;">
                    HOSPITAL DR. ERNESTO TORRES GALDÁMEZ<br>
                </div>
                <br><br>
                <div class="titulo">
                    <div class="center" style="width: 100%;">
                        <span class="uppercase">PLANILLA DE CONTROL DE TURNOS</span><br>
                        <small class="uppercase" style="font-size: 12px;">(TURNO NORMAL)</small><br>
                    </div>
                </div>
                <br><br>
                <table class="table tblShiftControlForm table-striped"> 
                    <thead> 
                        <tr>
                                <th style="font-size: 12px;text-align:center;" class="rightfield">RUT: </th>
                                <td> 
                                    @if( isset( $usr ) )
                                        {{strtoupper($usr->runFormat())}}
                                    @else
                                        <i class="fas fa-spinner fa-pulse"></i>
                                    @endif
                                </td>
                                <th class="middlefield">CARGO</th>
                                <td>
                                    @if( isset( $usr ) )
                                        N/A
                                    @else
                                        <i class="fas fa-spinner fa-pulse"></i>
                                    @endif
                                </td>
                        </tr>
                        <tr>
                                <th  class="rightfield" >MES</th>
                                <td>
                                    @if ( isset( $usr ) )  
                                        {{ strtoupper($months[$actuallyMonth]) }}
                                    @else
                                    
                                        <i class="fas fa-spinner fa-pulse"></i>

                                    @endif
                                </td>
                                <th  class="middlefield">GRADO</th>
                                <td>
                                    @if ( isset( $usr ) ) 
                                        N/A   
                                    @else
                                    
                                        <i class="fas fa-spinner fa-pulse"></i>

                                    @endif
                                    
                                </td>
                        </tr>
                        <tr>
                                <th  class="rightfield">SERVICIO</th>
                                <td>
                                    @if ( isset( $usr ) )
                                        N/A   
                                     
                                    @else
                                    
                                        <i class="fas fa-spinner fa-pulse"></i>

                                    @endif
                                </td>
                                <th  class="middlefield">CALIDAD</th>
                                <td>
                                       @if ( isset( $usr ) ) 
                                        N/A   
                                       
                                    @else
                                    
                                        <i class="fas fa-spinner fa-pulse"></i>

                                    @endif
                                    
                                </td>
                        </tr>
                        <tr>
                                <th  class="rightfield">TURNO  </th>
                                <td> @if (isset( $usr ) ) 
                                        N/A   
                                     
                                     @else
                                    
                                        <i class="fas fa-spinner fa-pulse"></i>
                                    @endif
                                </td>
                                <th  class="middlefield">N°CREDENCIAL</th>
                                <td>
                                      @if ( isset( $usr ) ) 
                                        N/A   
                                       
                                    @else
                                    
                                        <i class="fas fa-spinner fa-pulse"></i>

                                    @endif 
                                       
                                    
                                </td>
                        </tr> 
                        <tr>
                        </tr>
                    </thead>
                </table>
                <br> <br>
                <table class="siete">
                    <thead>
                        <tr>
                            <th>    
                                @if ( isset( $usr ) ) 
                                {{strtoupper($usr->fathers_family)}} 
                                   {{strtoupper($usr->mothers_family) }}
                                @endif
                            </th>
                            <th> <p style="color:white">   || </p> </th>
                            <th>
                                @if ( isset( $usr ) ) 
                                    {{$usr->getFirstNameAttribute()}}
                          
                                @endif
                            </th>
                        </tr>
                        <tr class="bottomFields">
                            <th>APELLIDO PATERNO</th>
                            <th>APELLIDO MATERNO</th>
                            <th>NOMBRES</th>
                        </tr>
                    </thead>
                </table>
                <br>

                <table class="table tblShiftControlForm"> 
                    <thead> 
                        <tr>
                            <th>FECHA</th>
                            <th>DÍA</th>
                            <th  colspan="2">HORARIO</th>
                            <th>OBSERVACION DE DATOS OBLIGATORIOS <p style="font-size:10px">POR QUIEN: NOMBRE Y APELLIDOS / MOTIVO DE AUSENTISMO / A QUIEN REMPLAZA</p></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Entrada</th>
                            <th>Salida</th>
                            <th></th>
                        </tr>
                    </thead>
                    @php
                        $total = 0;
                    @endphp
                    <tbody>
                        @if(isset($days) && $days  > 0)  
                            @for($i = 1; $i < ($days+1); $i++ )
                                <tr>
                                    <td style="text-align:center;">{{$i}}  </td>
                                    <td>
                                        @php
                                            $date2 = \Carbon\Carbon::createFromFormat('Y-m-d',  $actuallyYears."-".$actuallyMonth."-".$i);  
                                            $date =explode(" ",$date2);
                                            if(isset($shifsUsr) && $shifsUsr->days){
                                                $d = $shifsUsr->days->where('day',$date[0]);
                                                $d = $d->first();
                                            }else{
                                                $d["working_day"] = "";
                                                $d["status"] = "";
                                            }
                                        @endphp
                                        {{ ($d["working_day"]!="F")?$d["working_day"]:"-"  }}                    
                                    </td>
                                    @if($date2->isPast())
                                        <td>{{ (isset($timePerDay[$d["working_day"]]))?$timePerDay[$d["working_day"]]["from"]:""  }}</td>
                                        <td>{{  (isset($timePerDay[$d["working_day"]]))?$timePerDay[$d["working_day"]]["to"]:"" }}</td>
                                        <td>{{  ( isset($timePerDay[$d["working_day"]]) )?  ( ($shiftStatus[$d["status"]] == 1)? "Completado":$shiftStatus[$d["status"]] ) :"" }}</td>
                                        @php
                                            $total+=   (isset($timePerDay[$d["working_day"]]))?$timePerDay[$d["working_day"]]["time"]:0  ;
                                        @endphp
                                    @else
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    @endif
                                </tr>
                            @endfor
                        @else

                            <tr>
                                <td>
                                    <i class="fas fa-spinner fa-pulse"></i>
                                </td>
                            </tr>
                        @endif
                                        
                        <tr>
                            <th>TOTAL</th>  
                            <td>{{$total}}</td> 
                            <td></td>   
                            <td></td>   
                            <td></td>   
                        </tr>
                    </tbody> 
                </table>
                <br><br>

        <table>
            <tbody> 
                <tr class="hide_all">
                    <td><b>JEFE DIRECTO</b></td>   
                    <td><b>FUNCIONARIO</b></td>   
                    <td><b>SUBDIRECCION CUIDADO DEL PACIENTE</b></td>   
                </tr>
                <tr class="hide_all">
                    <td><b style="font-size: 10px;">NOMBRE, FIRMA Y TIMBRE</b></td>   
                    <td><b style="font-size: 10px;">FIRMA</b></td>   
                    <td><b style="font-size: 10px;">FIRMA Y TIMBRE</b></td>   
                </tr>
            </tbody> 
                </table>
<br><br>
                <b style="text-align: center">Los cambios de turno son solo días por noche y noche por día en el mismo día.</b>
            </div>
        </div>

      


        <br style="padding-bottom: 10px;">

        <br><br><br><br>


    </body>
</html>
