<?php

namespace App\Models\Documents;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Establishment;
use App\Models\Documents\Type;
use App\Models\Documents\Correlative;

use App\Models\User;
use App\Rrhh\OrganizationalUnit;
use App\Models\File;
use App\Models\Documents\SignaturesFile;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\hasMany;
use Illuminate\Database\Eloquent\Relations\belongsTo;

class Parte extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'correlative',
        'entered_at',
        'type_id',
        'reserved',
        'date',
        'number',
        'origin',
        'subject',
        'important',
        'physical_format',
        'received_by_id',
        'establishment_id',
        'organizational_unit_id',
        'user_id',
        'signatures_file_id',
        'reception_date',
        'viewed_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    // protected $dates = [
    //     'date',
    //     'deleted_at',
    //     'viewed_at',
    // ];

    protected $casts = [
        'date' => 'date:Y-m-d',
        'deleted_at' => 'datetime',
        'viewed_at' => 'datetime',
    ];

    public function events()
    {
        return $this->hasMany('\App\Models\Documents\ParteEvent');
    }

    public function requirements()
    {
        return $this->hasMany('\App\Models\Requirements\Requirement');
    }

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class)->withTrashed();
    }

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function organizationalUnit(): belongsTo
    {
        return $this->belongsTo(organizationalUnit::class)->withTrashed();
    }

    public function signaturesFile(): belongsTo
    {
        return $this->belongsTo(SignaturesFile::class)->withTrashed();
    }

    public function setCorrelative()
    {
        abort_if(!isset($this->establishment_id), 501, 'El parte no tiene establecimiento asociado');

        /* Obtener el objeto correlativo según el tipo */
        $correlative = Correlative::whereNull('type_id')
            ->where('establishment_id', $this->establishment_id)
            ->first();

        if (!$correlative) {
            $correlative = Correlative::create([
                'type_id' => null,
                'correlative' => 1,
                'establishment_id' => $this->establishment_id
            ]);
        }

        /* Almacenar el número del correlativo  */
        $number = $correlative->correlative;

        /* Aumentar el correlativo y guardarlo */
        $correlative->correlative += 1;
        $correlative->save();

        /* Almacenar el correlativo en el parte */
        $this->correlative = $number;
    }


    public static function createPartesForDirectors($destinatarios, SignaturesFlow $signaturesFlow)
    {
        // Limpiar los espacios en blanco alrededor de cada dirección de correo electrónico en el array de destinatarios
        $destinatarios = array_map('trim', explode(',', $destinatarios));

        // Preparar un array de correos electrónicos de la base de datos, separando los correos en el valor del campo mail_director por coma y limpiando los espacios en blanco
        $mail_director_arr = Establishment::select('id', 'mail_director')
            ->whereNotNull('mail_director')
            ->get()
            ->map(function ($est) {
                return [
                    'id' => $est['id'],
                    'mail_director' => array_map('trim', explode(',', $est['mail_director']))
                ];
            })
            ->toArray();

        // Encontrar las coincidencias entre los vectores
        $coincidencias = array_filter($destinatarios, function ($value) use ($mail_director_arr) {
            return collect($mail_director_arr)->pluck('mail_director')->flatten()->contains($value);
        });



        // Buscar los establecimientos que tienen los correos electrónicos en la variable $coincidencias
        $ids_establecimientos = [];
        if (!empty($coincidencias)) {
            foreach ($mail_director_arr as $mail_director) {
                if (count(array_intersect($coincidencias, $mail_director['mail_director'])) > 0) {
                    $ids_establecimientos[] = $mail_director['id'];
                }
            }
        }

        foreach ($ids_establecimientos as $id) {

            $document = SignaturesFile::where('signature_id', $signaturesFlow->signature->id)
                ->where('file_type', 'documento')
                ->first();

            $parte = Parte::create([
                'entered_at' => now(),
                'type_id' => $signaturesFlow->signature->type_id,
                'date' => $signaturesFlow->signature->request_date,
                'subject' => $signaturesFlow->signature->subject,
                'user_id' => $signaturesFlow->user_id,
                'organizational_unit_id' => $signaturesFlow->signature->organizationalUnit->id,
                'establishment_id' => $id,
                'origin' => $signaturesFlow->signature->organizationalUnit->name . ' (Parte generado desde Solicitud de Firma N°' . $signaturesFlow->signature->id . ' por ' . $signaturesFlow->signature->responsable->fullname . ')',
                'signatures_file_id' => $document->id
            ]);
            $parte->setCorrelative();
            $parte->save();

            $signaturesFiles = SignaturesFile::where('signature_id', $signaturesFlow->signature->id)
            ->where('file_type', 'anexo')
            ->get();

            foreach ($signaturesFiles as $key => $sf) {
                $parte->files()->create([
                    'storage_path' => $sf->file,
                    'stored' => true,
                    'name' => $sf->fileName,
                    'stored_by_id' => $parte->user_id,
                ]);
            }
        }
    }




    /* FIXME: Esto no es necesario */
    public function getCreationParteDateAttribute()
    {
        return Carbon::parse($this->date)->format('d-m-Y');
    }

    public function scopeFilter($query, $column, $value)
    {
        if (!empty($value)) {
            switch ($column) {
                case 'origin':
                case 'subject':
                    $query->where($column, 'LIKE', '%' . $value . '%');
                    break;                
                case 'correlative':
                case 'number':
                case 'type_id':
                    $query->where($column, $value);
                    break;
                case 'without_sgr':
                    $query->whereDoesntHave('requirements');
                    $query->whereDate('created_at', '>=', date('Y') - 1 . '-01-01');
                    break;
                case 'important':
                    $query->whereNotNull('important');
                    break;
            }
        }
    }

    public function scopeSearch($query, Request $request)
    {
        if ($request->input('id') != "") {
            $query->where('id', $request->input('id'));
        }

        if ($request->input('type') != "") {
            $query->where('type', $request->input('type'));
        }

        if ($request->input('number') != "") {
            $query->where('number', 'LIKE', '%' . $request->input('number') . '%');
        }

        if ($request->input('origin') != "") {
            $query->where('origin', 'LIKE', '%' . $request->input('origin') . '%');
        }

        if ($request->input('subject') != "") {
            $query->where('subject', 'LIKE', '%' . $request->input('subject') . '%');
        }

        if ($request->input('without_sgr') != "") {
            $query->whereDoesntHave('requirements');
            $query->whereDate('created_at', '>=', date('Y') - 1 . '-01-01');
        }

        return $query;
    }

    /* FIXME: cambiar nombre */
    public function scopeSearch2($query, $request)
    {
        if ($request != "") {
            $query->where('number', 'LIKE', '%' . $request . '%')
                ->orWhere('origin', 'LIKE', '%' . $request . '%');
        }

        return $query;
    }
}
