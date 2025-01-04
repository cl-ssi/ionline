<?php

namespace App\Models\Documents;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Template extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'doc_templates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'title',
        'content',
        'templateable_type',
        'templateable_id',
    ];

    public function templateable(): MorphTo
    {
        return $this->morphTo();
    }

    public function parseTemplate($record)
    {
        /** Template de ejemplo para tinker */
        // Template::find(1)->parseTemplate(Process::first())

        /** Objeto de ejemplo */
        // $record = (object) [
        //     'program' => (object) ['name' => 'Programa de Prueba'],
        //     'quotas'  => collect([
        //         (object) ['description' => 'Cuota 1', 'amount' => 100],
        //         (object) ['description' => 'Cuota 2', 'amount' => 200],
        //         (object) ['description' => 'Cuota 3', 'amount' => 300],
        //     ]),
        //     'positiva' => true,
        //     'negativa' => false,
        // ];

        /* Template
        ========================
        <p>Programa: <strong>{{program.name}}</strong></p>
        <p>Ejemplo de Foreach</p>
        <ul>
        @foreach(quotas)
            <li><b>{{description}}</b>: {{amount}} </li>
        @endforeach
        </ul>

        <p>Ejemplo de if</p>
        @if(positiva)
            <p>Variable positiva es true</p>
        @endif

        <p>Ejemplo e if y else</p>
        @if(negativa)
            <p>Variable negativa es true</p>
        @else
            <p>Variable negativa es false</p>
        @endif

        Resultado esperado
        ========================
        <p>Programa: <strong>Programa de Prueba</strong></p>

        <p>Ejemplo de Foreach</p>
        <ul>
            <li><b>Cuota 1</b>: 100 </li>
            <li><b>Cuota 2</b>: 200 </li>
            <li><b>Cuota 3</b>: 300 </li>
        </ul>

        <p>Ejemplo de if</p>
        <p>Variable positiva es true</p>

        <p>Ejemplo e if y else</p>
        <p>Variable negativa es false</p>
        */

        $content = $this->content;

        // Manejo de bloques @foreach
        $pattern = '/@foreach\((\w+(?:\.[a-zA-Z0-9_]+)*)\)(.*?)@endforeach/s';
        while (preg_match($pattern, $content, $matches)) {
            $collectionName = $matches[1];
            $block          = $matches[2];

            // Navegar por el objeto para obtener la colección
            $path       = explode('.', $collectionName);
            $collection = $record;
            foreach ($path as $segment) {
                $collection = $collection->$segment ?? [];
            }

            $repeatedBlock = '';

            if (is_iterable($collection)) {
                foreach ($collection as $item) {
                    $tempBlock = $block;

                    // Reemplazar variables dentro del bloque foreach
                    $tempBlock = $this->replaceSimpleVariables($tempBlock, $item);

                    // Reemplazar la referencia completa a la colección en variables del tipo {{quotas.percentage}}
                    $tempBlock = $this->replaceSimpleVariables($tempBlock, $item, $collectionName);

                    $repeatedBlock .= $tempBlock;
                }
            }

            // Reemplazar el bloque completo
            $content = str_replace($matches[0], $repeatedBlock, $content);
        }

        // Manejo de condicionales @if @else @endif
        $pattern = '/@if\((.*?)\)(.*?)(@else(.*?))?@endif/s';
        while (preg_match($pattern, $content, $matches)) {
            $condition = trim($matches[1]);
            $ifBlock   = $matches[2];
            $elseBlock = isset($matches[4]) ? $matches[4] : '';

            // Evaluar la condición
            $value = null;
            eval('$value = isset($record->'.str_replace('.', '->', $condition).') ? $record->'.str_replace('.', '->', $condition).' : false;');

            if ($value) {
                $content = str_replace($matches[0], $ifBlock, $content);
            } else {
                $content = str_replace($matches[0], $elseBlock, $content);
            }
        }

        // Reemplazo de variables simples en formato {{program.name}}
        $content = $this->replaceSimpleVariables($content, $record);

        return $content;
    }

    private function replaceSimpleVariables($content, $record, $prefix = '')
    {
        preg_match_all('/\{\{([a-zA-Z0-9_.]+)\}\}/', $content, $matches);
        foreach ($matches[1] as $variable) {
            $path = explode('.', $variable);

            // Si hay un prefijo, ajustarlo para subvariables
            if ($prefix && strpos($variable, $prefix.'.') === 0) {
                $path = explode('.', substr($variable, strlen($prefix) + 1));
            }

            $value = $record;

            // Navegar por el objeto $record usando el path
            foreach ($path as $segment) {
                $value = $value->$segment ?? null;
            }

            // Si el valor no es una cadena, convertirlo en una
            $content = str_replace("{{{$variable}}}", is_scalar($value) ? (string) $value : '', $content);
        }

        return $content;
    }
}
