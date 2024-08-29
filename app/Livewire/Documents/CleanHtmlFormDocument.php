<?php

namespace App\Livewire\Documents;

use App\Models\Documents\Document;
use Livewire\Component;

class CleanHtmlFormDocument extends Component
{
    public $record;

    public function clean() {
        $record = $this->record; // Obtén el registro actual
        $content = $record->content;

        // Eliminar estilos existentes y anchos de las celdas
        //$content = preg_replace('/style="[^"]*"/i', '', $content);
        // Ajustar los estilos, eliminando todo excepto 'text-align: center;'
        $content = preg_replace_callback(
            '/style="([^"]*)"/i',
            function ($matches) {
                // Analizar los estilos individuales
                $styles = explode(';', $matches[1]);
                $newStyles = array_filter($styles, function ($style) {
                    return trim($style) === 'text-align: center';
                });
                return 'style="' . implode(';', $newStyles) . '"';
            },
            $content
        );

        // Eliminar todas las etiquetas <span> y su contenido en todo el contenido
        $content = preg_replace('/<span\b[^>]*>(.*?)<\/span>/is', '$1', $content);
        
        // // Eliminar todas las etiquetas <span> dentro de <p>
        // $content = preg_replace_callback(
        //     '/<p\b[^>]*>(.*?)<\/p>/is',
        //     function ($matches) {
        //         // Eliminar todas las etiquetas <span> y su contenido dentro de <p>
        //         return preg_replace('/<span\b[^>]*>(.*?)<\/span>/is', '$1', $matches[0]);
        //     },
        //     $content
        // );
    
        // Elimina todos los width de las tablas
        $content = preg_replace('/width="[^"]*"/i', '', $content);

        // Eliminar espacios HTML no rompibles
        $content = str_replace('&nbsp;', '', $content);
        $content = str_replace('<p>&nbsp</p>;', '', $content);

        // Eliminar comentarios de salto de página
        $content = str_replace('<!-- pagebreak -->', '', $content);

        // Eliminar etiquetas <p> vacías
        $content = preg_replace('/<p[^>]*>\s*<\/p>/i', '', $content);

        // Eliminar <p> dentro de <td> y <th>
        $content = preg_replace_callback(
            '/<(td|th)(.*?)>(.*?)<\/(td|th)>/is',
            function ($matches) {
                // Elimina todas las etiquetas <p> dentro de <td> o <th>
                $cellContent = preg_replace('/<p[^>]*>([\s\S]*?)<\/p>/i', '$1', $matches[3]);
                return "<{$matches[1]}{$matches[2]}>{$cellContent}</{$matches[4]}>";
            },
            $content
        );

        // Eliminar etiquetas HTML vacías, excepto las etiquetas de tabla (table, tr, th, td)
        $content = preg_replace('/<((?!table|tr|th|td)\w+)(\s+[^>]*)?>\s*<\/\1>/is', '', $content);


        // Añadir estilos a las etiquetas <p>
        $content = preg_replace_callback(
            '/<p\b([^>]*)>/i',
            function ($matches) {
                $attributes = $matches[1];
                if (strpos($attributes, 'style=') !== false) {
                    // Si ya existe un atributo 'style', ajustarlo
                    $attributes = preg_replace_callback(
                        '/(style=")([^"]*)"/i',
                        function ($styleMatches) {
                            $existingStyles = $styleMatches[2];
                            // Asegurarse de que el estilo existente termine con ';'
                            $existingStyles = rtrim($existingStyles, '; ');
                            // Añadir 'text-align: justify;' solo si no está ya incluido
                            if (strpos($existingStyles, 'text-align: justify') === false) {
                                $existingStyles .= ($existingStyles ? '; ' : '') . 'text-align: justify';
                            }
                            return $styleMatches[1] . $existingStyles . '"';
                        },
                        $attributes
                    );
                } else {
                    // Si no hay un atributo 'style', añadirlo correctamente
                    $attributes .= ' style="text-align: justify"';
                }
                return '<p ' . $attributes . '>';
            },
            $content
        );

        // Eliminar todos los atributos de las etiquetas <table>
        $content = preg_replace('/<table[^>]*>/i', '<table>', $content);

        // Añadir estilos y bordes a las tablas
        $content = preg_replace_callback(
            '/<table(.*?)>/i',
            function ($matches) {
                return '<table' . $matches[1] . ' style="border-collapse: collapse; width: 100%;" border="1">';
            },
            $content
        );

        // Eliminar todos los atributos 'style' vacíos
        $content = preg_replace('/\sstyle=""/i', '', $content);

        // Eliminar etiquetas <p> vacías con 'text-align: justify;'
        $content = preg_replace('/<p\s+style="text-align:\s*justify;"\s*>\s*<\/p>/is', '', $content);

        // Eliminar espacios múltiples consecutivos
        $content = preg_replace('/\s{2,}/', ' ', $content);

        // Formatear HTML con saltos de línea adecuados para mejorar la legibilidad
        $content = preg_replace('/>\s*</', ">\n<", $content); // Añade saltos de línea entre etiquetas

        // Añadir un salto de línea después de cada etiqueta de cierre y antes de cada etiqueta de apertura
        $content = preg_replace('/<\/(\w+)>/', "</$1>\n", $content); // Añade un salto de línea después de las etiquetas de cierre
        $content = preg_replace('/<(\w+)([^>]*)>/', "\n<$1$2>", $content); // Añade un salto de línea antes de las etiquetas de apertura

        $record->content = $content;
        $record->save();

        // refresh page
        return redirect()->route('documents.edit', $record->id);
    }
    public function render()
    {
        return view('livewire.documents.clean-html-form-document');
    }
}
