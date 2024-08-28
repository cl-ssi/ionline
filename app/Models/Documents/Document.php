<?php

namespace App\Models\Documents;

use App\Models\Documents\Sign\Signature;
use App\Models\Requirements\Event;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\Establishment;
use App\Models\Documents\Type;

class Document extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'documents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number',
        'internal_number',
        'date',
        'type_id',
        'reserved',
        'antecedent',
        'responsible',
        'subject',
        'from',
        'for',
        'greater_hierarchy',
        'distribution',
        'content',
        'user_id',
        'organizational_unit_id',
        'establishment_id',
        'file_to_sign_id',
        'signature_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * Get the type that owns the document.
     *
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * Get the user that owns the document.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the organizational unit that owns the document.
     *
     * @return BelongsTo
     */
    public function organizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class);
    }

    public function reqEvents(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'req_documents_events');
    }
    
    public function fileToSign(): BelongsTo
    {
        return $this->belongsTo(SignaturesFile::class, 'file_to_sign_id');
    }

    /**
     * Get the establishment that owns the document.
     *
     * @return BelongsTo
     */
    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    /**
     * Get the signature that owns the document.
     *
     * @return BelongsTo
     */
    public function signature(): BelongsTo
    {
        return $this->belongsTo(Signature::class);
    }

    /**
    * Get View Name from document type
    */
    public function getViewNameAttribute()
    {
        /* Borra acéntos y convierte a snake_case para obtener
        * el nombre de la vista del documento EJ: Acta de Recepción => acta_de_recepcion */
        $accents ='àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ';
        $noAccents = 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY';
        if($this->type) {
            return str_replace(' ', '_', strtolower(
                strtr(utf8_decode($this->type->name), utf8_decode($accents), $noAccents)
            ));
        }
        else {
            return 'show';
        }
    }

    public function getFromHtmlAttribute()
    {
        return $this->from ? str_replace("/", "<br>", $this->from) : '';
    }

    public function getFromHtmlSignAttribute()
    {
        /*
         * Esta funcion elimina del firmante la frase "SERVICIO DE SALUD TARAPACÁ"
         * para evitar que salga duplicado en la firmante
         */
        $chars    = array("/", "SERVICIO DE SALUD TARAPACÁ", "Servicio de Salud Tarapacá");
        $htmlchar = array("<br>", "", "");

        return str_replace($chars, $htmlchar, $this->from);
    }

    public function getForHtmlAttribute()
    {
        return $this->for ? str_replace("/", "<br>", $this->for) : '';
    }

    public function getAntecedentHtmlAttribute()
    {
        return str_replace("/", "<br>", $this->antecedent);
    }

    public function getResponsiblesArrayAttribute()
    {
        return explode("\n",$this->responsible);
    }

    public function getResponsibleHtmlAttribute()
    {
        return $this->responsible ? str_replace("\n", "<br>", $this->responsible) : '';
    }

    public function getContentHtmlAttribute()
    {
        return str_replace("<!-- pagebreak -->", '<div style="page-break-after: always;"></div>', $this->content);
    }

    public function getDistributionHtmlAttribute()
    {
        $chars    = array("<", ">", "\n");
        $htmlchar = array("&lt;", "&gt;", "<br>");

        return str_replace($chars, $htmlchar, $this->distribution);
    }


    public function scopeSearch($query, Request $request)
    {
        if($request->input('id') != "") {
            $query->where('id', $request->input('id') );
        }

        if($request->input('type_id') != "") {
            $query->where('type_id', '=', $request->input('type_id') );
        }

        if($request->input('number') != "") {
            $query->where('number', 'LIKE', '%'.$request->input('number').'%' );
        }

        if($request->input('subject') != "") {
            $query->where('subject', 'LIKE', '%'.$request->input('subject').'%' );
        }

        if($request->input('user_id') != "") {
            $query->where('user_id', $request->input('user_id') );
        }

        if($request->input('file') != "") {
            $query->where('file', null );
        }

        return $query;
    }

    public static function parseTemplate($templateContent, $data)
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


        // Reemplazo de variables simples
        foreach ($data as $key => $values) {
            if (is_array($values) && isset($values[0]) && is_array($values[0])) {
                // Manejar iteraciones
                $pattern = '/@foreach\(' . $key . '\)(.*?)@endforeach/s';
                while (preg_match($pattern, $templateContent, $matches)) {
                    $repeatedBlock = '';
                    foreach ($values as $item) {
                        $tempBlock = $matches[1];
                        foreach ($item as $subKey => $subValue) {
                            $tempBlock = str_replace('{{' . $key . '.' . $subKey . '}}', $subValue, $tempBlock);
                        }
                        $repeatedBlock .= $tempBlock;
                    }
                    $templateContent = str_replace($matches[0], $repeatedBlock, $templateContent);
                }
            } elseif (is_array($values)) {
                // Variables simples con subclaves
                foreach ($values as $subKey => $value) {
                    $templateContent = str_replace('{{' . $key . '.' . $subKey . '}}', $value, $templateContent);
                }
            } else {
                // Variables de una dimensión
                $templateContent = str_replace('{{' . $key . '}}', $values, $templateContent);
            }
        }
        
        // Manejar condicionales
        $patternIf = '/@if\((.*?)\)(.*?)@else(.*?)@endif/s';
        while (preg_match($patternIf, $templateContent, $matches)) {
            $condition = $matches[1];
            $ifBlock = $matches[2];
            $elseBlock = $matches[3];

            // Evaluar condición (solo booleanas)
            $condition = str_replace(['usuario.premium'], [$data['usuario']['premium']], $condition);

            if (eval("return $condition;")) {
                $templateContent = str_replace($matches[0], $ifBlock, $templateContent);
            } else {
                $templateContent = str_replace($matches[0], $elseBlock, $templateContent);
            }
        }

        // Manejar condicionales sin else
        $patternIfNoElse = '/@if\((.*?)\)(.*?)@endif/s';
        while (preg_match($patternIfNoElse, $templateContent, $matches)) {
            $condition = $matches[1];
            $ifBlock = $matches[2];

            // Evaluar condición (solo booleanas)
            $condition = str_replace(['usuario.premium'], [$data['usuario']['premium']], $condition);

            if (eval("return $condition;")) {
                $templateContent = str_replace($matches[0], $ifBlock, $templateContent);
            } else {
                $templateContent = str_replace($matches[0], '', $templateContent);
            }
        }
        return $templateContent;
    }
}
