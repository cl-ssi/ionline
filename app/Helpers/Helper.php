<?php

namespace App\Helpers;

class Helper {
	/**
	 *	Función de validación de un rut basado en el algoritmo chileno
	 *	el formato de entrada es ########-# en donde deben ser sólo
	 *	números en la parte izquierda al guión y número o k en el
	 *	dígito verificador
	 */
	public static function validaRut ( $rutCompleto ) {
    	if ( !preg_match("/^[0-9]+-[0-9kK]{1}/",$rutCompleto)) return false;
    		$rut = explode('-', $rutCompleto);
    		return strtolower($rut[1]) == Helper::dv($rut[0]);
    }
	public static function dv ( $T ) {
		$M=0;$S=1;
		for(;$T;$T=floor($T/10))
			$S=($S+$T%10*(9-$M++%6))%11;
		return $S?$S-1:'k';
	}
}


// Ejemplo de la validación del rut

//echo Helper::validaRut('1-9') ? 'Es válido' : 'No es válido :( ';
