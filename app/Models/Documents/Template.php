<?php

namespace App\Models\Documents;

use Carbon\Carbon;
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
        /** Ejemplo de datos */
        // $data['fecha'] = now()->format('d/m/Y');
        // $data['usuario']['nombre_completo'] = auth()->user()->full_name;
        // $data['usuario']['premium'] = false;
        // $data['unidad']['nombre'] = auth()->user()->organizationalUnit->name;
        // $data['unidad']['autoridad'] = auth()->user()->boss->full_name;
        // $data['cuotas'] = [
        //     ['name' => 'Cuota 1','valor' => 100],
        //     ['name' => 'Cuota 2','valor' => 200],
        //     ['name' => 'Cuota 3','valor' => 300]
        // ];

        /** Ejemplo de template */
        // <p>Hola <strong>{{usuario.nombre_completo}}</strong></p>
        // <p>Esta es una nota r&aacute;pida de c&oacute;mo hacer una plantilla que tiene una iteraci&oacute;n.</p>

        // @if(usuario.premium)
        //     <p>¡Gracias por ser un miembro premium!</p>
        // @else
        //     <p>Considera unirte a nuestro programa premium para obtener más beneficios.</p>
        // @endif

        // <p>Usando tablas</p>
        // <table style="border-collapse: collapse; width: 100%;" border="1">
        //     <colgroup><col style="width: 50%;"><col style="width: 50%;"></colgroup>
        //     <tbody>
        //         <tr>
        //             <td><strong>Nombre de la cuota</strong></td>
        //             <td style="text-align: center;"><strong>Valor</strong></td>
        //         </tr>
        //         @foreach(cuotas)
        //         <tr>
        //             <td>{{cuotas.name}}</td>
        //             <td style="text-align: center;">{{cuotas.valor}}</td>
        //         </tr>
        //         @endforeach
        //     </tbody>
        // </table>

        // <p>Usando Listas</p>
        // <ul>
        //     @foreach(cuotas)
        //     <li><b>{{cuotas.name}}</b>: {{cuotas.valor}}</li>
        //     @endforeach
        // </ul>
        // <p>Atentamente,</p>
        // <p><strong>{{unidad.autoridad}}</strong><br><strong>{{unidad.nombre}}</strong></p>

        // Buscar todas las variables entre {{ }}
        preg_match_all('/\{\{([a-zA-Z0-9_.]+)\}\}/', $this->content, $matches);

        // Eliminar duplicados y ordenar las variables
        $variables = array_unique($matches[1]);

        // Crear el array $data con los valores desde $record
        $data = [];
        foreach ($variables as $variable) {
            $path = explode('.', $variable); // Dividir por puntos para manejar estructuras anidadas
            $value = '$record';
            foreach ($path as $segment) {
                $value .= "->$segment";
            }
            eval("\$tempValue = isset($value) ? $value : null;"); // Obtener el valor dinámico
        
            // Verificar si el valor es una instancia de Carbon
            if ($tempValue instanceof Carbon) {
                $tempValue = $tempValue->toDateString();
            }
        
            $data[$variable] = $tempValue;
        }

        // // Imprimir el array $data
        // dd($data);



        // return $data;

        // Reemplazo de variables simples
        foreach ($data as $key => $values) {
            if (is_array($values) && isset($values[0]) && is_array($values[0])) {
                // Manejar iteraciones
                $pattern = '/@foreach\(' . $key . '\)(.*?)@endforeach/s';
                while (preg_match($pattern, $this->content, $matches)) {
                    $repeatedBlock = '';
                    foreach ($values as $item) {
                        $tempBlock = $matches[1];
                        foreach ($item as $subKey => $subValue) {
                            $tempBlock = str_replace('{{' . $key . '.' . $subKey . '}}', $subValue, $tempBlock);
                        }
                        $repeatedBlock .= $tempBlock;
                    }
                    $this->content = str_replace($matches[0], $repeatedBlock, $this->content);
                }
            } elseif (is_array($values)) {
                // Variables simples con subclaves
                foreach ($values as $subKey => $value) {
                    $this->content = str_replace('{{' . $key . '.' . $subKey . '}}', $value, $this->content);
                }
            } else {
                // Variables de una dimensión
                $this->content = str_replace('{{' . $key . '}}', $values, $this->content);
            }
        }
        
        return $this->content;

        // // Manejar condicionales
        // $patternIf = '/@if\((.*?)\)(.*?)@else(.*?)@endif/s';
        // while (preg_match($patternIf, $this->content, $matches)) {
        //     $condition = $matches[1];
        //     $ifBlock = $matches[2];
        //     $elseBlock = $matches[3];

        //     // Evaluar condición (solo booleanas)
        //     $condition = str_replace(['usuario.premium'], [$data['usuario']['premium']], $condition);

        //     if (eval("return $condition;")) {
        //         $this->content = str_replace($matches[0], $ifBlock, $this->content);
        //     } else {
        //         $this->content = str_replace($matches[0], $elseBlock, $this->content);
        //     }
        // }

        // // Manejar condicionales sin else
        // $patternIfNoElse = '/@if\((.*?)\)(.*?)@endif/s';
        // while (preg_match($patternIfNoElse, $this->content, $matches)) {
        //     $condition = $matches[1];
        //     $ifBlock = $matches[2];

        //     // Evaluar condición (solo booleanas)
        //     $condition = str_replace(['usuario.premium'], [$data['usuario']['premium']], $condition);

        //     if (eval("return $condition;")) {
        //         $this->content = str_replace($matches[0], $ifBlock, $this->content);
        //     } else {
        //         $this->content = str_replace($matches[0], '', $this->content);
        //     }
        // }
        // return $this->content;
    }
}