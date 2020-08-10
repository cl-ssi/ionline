<?php

namespace App\Http\Controllers\Indicators\_2020\aps;

class Helper
{
    public function initializeData($data, $establecimientos, $ind, $ultimo_rem, $fuentes)
    {
        /* Inicializa en cero todos los campos necesarios para construir el array de datos para indicador $ind */
        // Partimos con los cumplimientos, esto podria variar según las metas especificadas
        foreach ($establecimientos as $establecimiento) {
            $data[$establecimiento->comuna][$ind]['cumplimiento'] = 0;
            $data[$establecimiento->comuna][$ind][$establecimiento->alias_estab]['cumplimiento'] = 0;
        }
        // Seguimos con los numeradores y denominadores segun fuentes consultadas
        foreach ($fuentes as $factor => $fuente) { // Parte por el numerador y termina con el denominador
            if ($fuente == 'REM') { //Fuente que contiene datos mensuales Ej. Rem A
                $_factor = ($factor == 'numerador') ? 'numeradores' : 'denominadores';
                foreach ($establecimientos as $establecimiento) {
                    $data[$establecimiento->comuna][$ind][$_factor]['total'] = 0;
                    $data[$establecimiento->comuna][$ind][$establecimiento->alias_estab][$factor] = 0; // Para el calculo del cumplimiento por establecimiento
                    $data[$establecimiento->comuna][$ind][$factor] = 0; // Para el calculo del cumplimiento por comuna
                    for ($mes = 1; $mes <= $ultimo_rem; $mes++) {
                        $data[$establecimiento->comuna][$ind][$_factor][$mes] = 0;
                        $data[$establecimiento->comuna][$ind][$establecimiento->alias_estab][$_factor]['total'] = 0;
                        $data[$establecimiento->comuna][$ind][$establecimiento->alias_estab][$_factor][$mes] = 0;
                    }
                }
            } elseif ($fuente == 'REM P') { // Fuente que contiene datos semestrales Ej Rem P
                foreach ($establecimientos as $establecimiento) {
                    $data[$establecimiento->comuna][$ind][$factor] = 0;
                    $data[$establecimiento->comuna][$ind][$factor . '_6'] = 0;
                    $data[$establecimiento->comuna][$ind][$factor . '_12'] = 0;

                    $data[$establecimiento->comuna][$ind][$establecimiento->alias_estab][$factor] = 0;
                    $data[$establecimiento->comuna][$ind][$establecimiento->alias_estab][$factor . '_6'] = 0;
                    $data[$establecimiento->comuna][$ind][$establecimiento->alias_estab][$factor . '_12'] = 0;
                }
            } else { // Fuente que contiene datos anuales Ej Fonasa
                foreach ($establecimientos as $establecimiento) {
                    $data[$establecimiento->comuna][$ind][$factor] = 0;
                    $data[$establecimiento->comuna][$ind][$establecimiento->alias_estab][$factor] = 0;
                }
            }
        }
        return $data;
    }

    public function setMetas($data, $establecimientos, $ind, $valor)
    {
        /* Se guarda los valores de las metas comunales */
        foreach ($establecimientos as $establecimiento) {
            if(is_array($valor)) // se especifica una meta por cada comuna por separado
                $data[$establecimiento->comuna][$ind]['meta'] = $valor[$establecimiento->comuna] ?? null;
            else // se especifica una misma meta para todas las comunas
                $data[$establecimiento->comuna][$ind]['meta'] = $valor;
        }
        return $data;
    }

    public function setValores($data, $valores, $ind, $ultimo_rem, $fuentes, $establecimientos)
    {
        $flag1 = $flag2 = NULL;
        foreach ($fuentes as $factor => $fuente) { // Parte por el numerador y termina con el denominador
            if($fuente == 'REM'){
                $_factor = ($factor == 'numerador') ? 'numeradores' : 'denominadores';
                foreach ($valores[$factor] as $registro) {
                    if (($flag1 != $registro->Comuna) or ($flag2 != $registro->alias_estab)) {
                        for ($mes = 1; $mes <= $ultimo_rem; $mes++) {
                            $data[$registro->Comuna][$ind][$registro->alias_estab][$_factor][$mes] = 0;
                        }
                        $flag1 = $registro->Comuna;
                        $flag2 = $registro->alias_estab;
                    }
                    $valor = ($factor == 'numerador') ? $registro->numerador : $registro->denominador;
                    $data[$registro->Comuna][$ind][$registro->alias_estab][$_factor][$registro->Mes] = $valor;
                    $data[$registro->Comuna][$ind][$registro->alias_estab][$_factor]['total'] += $valor;
                    $data[$registro->Comuna][$ind][$_factor][$registro->Mes] += $valor;
                    $data[$registro->Comuna][$ind][$_factor]['total'] += $valor;
                    $data[$registro->Comuna][$ind][$registro->alias_estab][$factor] += $valor;
                    $data[$registro->Comuna][$ind][$factor] += $valor;
                }
            }elseif($fuente == "REM P"){
                if($ultimo_rem <= 5){
                    foreach ($valores[$factor] as $registro){
                        $valor = ($factor == 'numerador') ? $registro->numerador : $registro->denominador;
                        $data[$registro->Comuna][$ind][$registro->alias_estab][$factor] = $valor;
                        $data[$registro->Comuna][$ind][$factor] += $valor;
                    }
                }else{
                    foreach ($valores[$factor] as $registro) {
                        $valor = ($factor == 'numerador') ? $registro->numerador : $registro->denominador;
                        $data[$registro->Comuna][$ind][$registro->alias_estab][$factor . '_' . $registro->Mes] = $valor; //$registro->Mes tiene el valor de 6 o 12 segun sea el caso
                        $data[$registro->Comuna][$ind][$factor . '_' . $registro->Mes] += $valor;
                        $data[$registro->Comuna][$ind][$registro->alias_estab][$factor] = $valor;
                        $data[$registro->Comuna][$ind][$factor] += $valor;
                    }
                }
            }else{
                foreach ($valores[$factor] as $registro){
                    $valor = ($factor == 'numerador') ? $registro->numerador : $registro->denominador;
                    $data[$registro->Comuna][$ind][$registro->alias_estab][$factor] = $valor;
                    $data[$registro->Comuna][$ind][$factor] += $valor;
                }
            }
        }

        $data = $this->calcularCumplimientos($data, $ind, $establecimientos);

        return $data;
    }

    public function calcularCumplimientos($data, $ind, $establecimientos)
    {
        /* Se calcula cumplimiento por establecimiento y luego por comuna */
        foreach ($establecimientos as $registro) {
            $data[$registro->comuna][$ind][$registro->alias_estab]['cumplimiento'] = $data[$registro->comuna][$ind][$registro->alias_estab]['denominador'] != 0 ?
                        $data[$registro->comuna][$ind][$registro->alias_estab]['numerador'] / $data[$registro->comuna][$ind][$registro->alias_estab]['denominador'] * 100 : 0;
            $data[$registro->comuna][$ind]['cumplimiento'] = $data[$registro->comuna][$ind]['denominador'] != 0 ?
                        $data[$registro->comuna][$ind]['numerador'] / $data[$registro->comuna][$ind]['denominador'] * 100 : 0;
        }

        return $data;
    }

    public function recalcularNumerador($data, $ind, $establecimientos)
    {
        /* Se recalcula los numeradores por establecimiento y luego por comuna, en caso de necesitar
           calcular denominador - numerador para cada establecimiento */
        // Seteamos los numeradores solo por comuna
        foreach($establecimientos as $registro) {
            $data[$registro->comuna][$ind]['numerador_12'] = 0;
            $data[$registro->comuna][$ind]['numerador_6'] = 0;
            $data[$registro->comuna][$ind]['numerador'] = 0;
        }
        // Calculamos los nuevos numeradores por establecimiento y luego guardamos los resultados por comuna
        foreach ($establecimientos as $registro) {
            $data[$registro->comuna][$ind][$registro->alias_estab]['numerador_12'] = $data[$registro->comuna][$ind][$registro->alias_estab]['denominador_12'] - $data[$registro->comuna][$ind][$registro->alias_estab]['numerador_12'];
            $data[$registro->comuna][$ind][$registro->alias_estab]['numerador_6'] = $data[$registro->comuna][$ind][$registro->alias_estab]['denominador_6'] - $data[$registro->comuna][$ind][$registro->alias_estab]['numerador_6'];
            $data[$registro->comuna][$ind][$registro->alias_estab]['numerador'] = $data[$registro->comuna][$ind][$registro->alias_estab]['denominador'] - $data[$registro->comuna][$ind][$registro->alias_estab]['numerador'];
            $data[$registro->comuna][$ind]['numerador_12'] += $data[$registro->comuna][$ind][$registro->alias_estab]['numerador_12'];
            $data[$registro->comuna][$ind]['numerador_6'] += $data[$registro->comuna][$ind][$registro->alias_estab]['numerador_6'];
            $data[$registro->comuna][$ind]['numerador'] += $data[$registro->comuna][$ind][$registro->alias_estab]['numerador'];
        }

        // Se manda recalcular los cumplimientos por comuna y establecimiento
        $data = $this->calcularCumplimientos($data, $ind, $establecimientos);

        return $data;
    }
}
