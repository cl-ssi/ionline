<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gs1 extends Model
{
    use HasFactory;

    public static function parse($barcode, $format)
    {
        $gs1Codes = [
            '00' => 'Serial Shipping Container Code (SSCC)',
            '01' => 'Global Trade Item Number (GTIN)',
            '02' => 'Número de identificación de producto global (GTIN-14)',
            '10' => 'Número de serie',
            '11' => 'Fecha de producción',
            '12' => 'Fecha de caducidad',
            '13' => 'Fecha de envasado',
            '15' => 'Fecha de mejor antes',
            '17' => 'Número de lote',
            '20' => 'Número de identificación de producto interno (NIP)',
            '21' => 'Número de identificación de la ubicación física del envío (GLN)',
            '22' => 'Número de identificación del destino de ruta (número de GLN)',
            '30' => 'Cantidad de productos',
            '37' => 'Número de contenedor',
            '390x' => 'Número de referencia de pedidos de clientes',
            '391x' => 'Número de referencia de facturas de clientes',
            '392x' => 'Número de referencia de recibos de clientes',
            '393x' => 'Número de referencia de confirmaciones de clientes',
            '400' => 'Número de pedido de clientes',
            '401' => 'Número de factura de clientes',
            '402' => 'Número de recibo de clientes',
            '403' => 'Número de confirmación de clientes',
            '8003' => 'Número de referencia de paletas',
            '8004' => 'Fecha de empaquetado',
            '8006' => 'Fecha de producción (yyww)',
            '8008' => 'Fecha de envasado',
            '8020' => 'Fecha de embalaje',
            '900' => 'Número de referencia de compra del distribuidor',
            '901' => 'Número de referencia de venta del distribuidor',
            '92' => 'Número de transacción',
        ];

        $format = [
            '01' => 14,
            '10' => 8,
            '17' => 6,
        ];

        // Eliminar caracteres no numéricos
        $barcode = preg_replace('/\D/', '', $barcode);

        // Verificar si la cadena comienza con "01"
        if (substr($barcode, 0, 2) === "01") {
            // Almacenar los siguientes 14 caracteres en $cod_producto
            $cod_producto = substr($barcode, 2, 14);

            // Eliminar los primeros 16 caracteres de la barcode
            $resto = substr($barcode, 16);

            // Mostrar los resultados
            echo "Código del producto: $cod_producto\n";
            echo "Resto de la barcode: $resto\n";
        } else {
            echo "La cadena no comienza con '01'. No se puede extraer el código del producto.\n";
        }

        // Verificar si el resto comienza con "12", "17" o "10"
        if (substr($resto, 0, 2) === "12" || substr($resto, 0, 2) === "17") {
            // Utilizar los siguientes 6 caracteres como fecha
            $fecha_str = substr($resto, 2, 6);
        } elseif (substr($resto, 0, 2) === "10") {
            // Evaluar en pares los siguientes números hasta encontrar un "12" o "17"
            for ($i = 2; $i < strlen($resto) - 1; $i += 2) {
                $segmento = substr($resto, $i, 2);
                if ($segmento === "12" || $segmento === "17") {
                    // Utilizar los siguientes 6 caracteres como fecha
                    $fecha_str = substr($resto, $i + 2, 6);
                    break;
                }
            }
        } else {
            return null; // No se encontró un segmento válido para fecha
        }

        // Intentar convertir la fecha a un objeto Carbon
        try {
            $fecha = Carbon::createFromFormat('ymd', $fecha_str);
            return $fecha;
        } catch (Exception $e) {
            return null; // Fecha no válida
        }

        // por cada elemento del array format buscar en el barcode con la logitud que se encuentra en el array format
        // si lo encuentra lo guarda en un array

        $gs1 = [];
        foreach ($format as $key => $length) {
            if (strpos($barcode, $key) !== false) {
                // parse date in format YYMMDD with carbon
                if ($key == '17') {
                    $gs1[$key] = \Carbon\Carbon::createFromFormat('ymd', substr($barcode, strpos($barcode, $key) + 2, $length));
                } else {
                    
                    $gs1[$key] = substr($barcode, strpos($barcode, $key) + 2, $length);
                }
            }
        }

        // Juntar array names como keys y el array gs1 como values
        $gs1 = array_combine(array_map(function ($key) use ($gs1Codes) {
            return $gs1Codes[$key];
        }, array_keys($gs1)), array_values($gs1));

        return $gs1;
    }

}
