<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    public static function getAvatar($initials = 'A', $bgColor = '#000000', $size = 256)
    {
        // Validar que el color de fondo sea un valor hexadecimal válido
        if (!preg_match('/^#[a-fA-F0-9]{6}$/', $bgColor)) {
            $bgColor = '#000000'; // Por defecto, negro si el color es inválido
        }

        // Convertir el color hexadecimal en RGB
        $bgColorRgb = sscanf($bgColor, '#%02x%02x%02x');

        // Crear la imagen
        $image = imagecreatetruecolor($size, $size);

        // Establecer el color de fondo
        $backgroundColor = imagecolorallocate($image, $bgColorRgb[0], $bgColorRgb[1], $bgColorRgb[2]);
        imagefill($image, 0, 0, $backgroundColor);

        // Establecer el color del texto (blanco)
        $textColor = imagecolorallocate($image, 255, 255, 255);

        // Ruta a la fuente
        $fontFile = public_path('fonts/Verdana.ttf');
        if (!file_exists($fontFile)) {
            throw new \Exception('Error: El archivo de fuente no se encuentra.');
        }

        // Calcular el tamaño del texto y su posición centrada
        $fontSize = 0.3 * $size;
        $bbox = imagettfbbox($fontSize, 0, $fontFile, $initials);
        $textWidth = $bbox[2] - $bbox[0];
        $textHeight = $bbox[7] - $bbox[1];
        $x = ($size - $textWidth) / 2;
        $y = ($size - $textHeight) / 2 - $bbox[6];

        // Agregar el texto a la imagen
        imagettftext($image, $fontSize, 0, $x, $y, $textColor, $fontFile, $initials);

        // Devolver la imagen como un stream
        return response()->stream(function () use ($image) {
            imagepng($image);
            imagedestroy($image);
        }, 200, ['Content-Type' => 'image/png']);
    }
}
