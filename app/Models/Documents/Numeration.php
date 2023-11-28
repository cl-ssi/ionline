<?php

namespace App\Models\Documents;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\User;
use App\Rrhh\OrganizationalUnit;
use App\Notifications\Signatures\NumerateAndDistribute;
use App\Models\Establishment;
use App\Models\Documents\Type;
use App\Models\Documents\DigitalSignature;
use App\Models\Documents\Correlative;

class Numeration extends Model
{
    use HasFactory;

    /**
     * Get the numeration model.
     */
    // public function file(): MorphOne
    // {
    //     return $this->morphOne(Numeration::class, 'numerable');
    // }

    /**
     * Get all of the numerations of a model.
     */
    // public function numerations(): MorphMany
    // {
    //     return $this->morphMany(Numeration::class, 'numerable');
    // }


    // $modelo->numeration()->create([
    //     'automatic' => true,
    //     'correlative' => null, // sólo enviar si automatic es falso, para numeros custom
    //     'doc_type_id' => $file_type_id,
    //     'file_path' => $file_path,
    //     'subject' => $subject,
    //     'user_id' => auth()->user()->id, // Responsable del documento numerado
    //     'organizational_unit_id' => auth()->user()->organizationalUnit->id, // Ou del responsable
    //     'establishment_id' => auth()->user()->establishment->id,
    // ]);



    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'automatic',
        'number',
        'internal_number',
        'date',
        'doc_type_id',
        'verification_code',
        'file_path',
        'subject',
        'user_id',
        'organizational_unit_id',
        'establishment_id',
        'numerable_type',
        'numerable_id'
    ];

    /**
    * The attributes that should be cast.
    *
    * @var array
    */
    protected $casts = [
        'automatic' => 'boolean',
        'date' => 'datetime',
    ];

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'doc_numerations';

    /**
     * Get the parent numerable model
     * - Finance/Reception
     * - 
     */
    public function numerable(): MorphTo
    {
        return $this->morphTo();
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function organizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class)->withTrashed();
    }

    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    /**
    * Numerate
    */
    public function numerate()
    {
        // $modelo->numeration()->create([
        //     'automatic' => true,
        //     'correlative' => null, // sólo enviar si automatic es falso, para numeros custom
        //     'doc_type_id' => $file_type_id,
        //     'file_path' => $file_path,
        //     'subject' => $subject,
        //     'user_id' => auth()->user()->id, // Responsable del documento numerado
        //     'organizational_unit_id' => auth()->user()->organizationalUnit->id, // Ou del responsable
        //     'establishment_id' => auth()->user()->establishment->id,
        // ]);

        $numerateUser = User::find(15287582); // Firma Desatendida iOnline

        /* Generar el codigo de verificacion ej: ej: '000123-sbK5np' */ 
        $verificationCode = str_pad($this->id, 6, "0", STR_PAD_LEFT) . '-' . str()->random(6);
        /* Si es automático, entonces obtiene el siguiente número del correlativo del tipo de documento */
        if ($this->automatic == true) {
            $number = Correlative::getCorrelativeFromType($this->doc_type_id);
        } else {
            $number = $this->correlative;
        }
        $file = Storage::get($this->file_path);
        $digitalSignature = new DigitalSignature();
        $success = $digitalSignature->numerate($numerateUser, $file, $verificationCode, $number);
        if($success) {
            return $digitalSignature->storeFirstSignedFile($this->file_path);
        }
        else {
            echo $digitalSignature->error;
        }

    }

    /**
    * Distribuir el documento numerado
    */
    public function distribute($users)
    {
        Notification::route('mail', $users)->notify(new NumerateAndDistribute($this));
    }
}
