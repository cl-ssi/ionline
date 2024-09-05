<?php

namespace App\Models\Documents;

use App\Models\Establishment;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\User;
use App\Notifications\Signatures\NumerateAndDistribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class Numeration extends Model
{
    use HasFactory, SoftDeletes;

    protected $status;

    /**
     * Get the numeration of the model.
     */
    // public function numeration(): MorphOne
    // {
    //     return $this->morphOne(Numeration::class, 'numerable');
    // }

    // $modelo->numeration()->create([
    //     'automatic' => true,
    //     'correlative' => null, // sólo enviar si automatic es falso, para numeros custom
    //     'doc_type_id' => $file_type_id,
    //     'file_path' => $file_path,
    //     'subject' => $subject,
    //     'user_id' => auth()->id(), // Responsable del documento numerado
    //     'organizational_unit_id' => auth()->user()->organizational_unit_id, // Ou del responsable
    //     'establishment_id' => auth()->user()->establishment_id,
    // ]);

    // /* Numerar */
    // $user = User::find(Parameter::get('partes','numerador', auth()->user()->establishment_id));
    // $status = $numeration->numerate($user);

    // if ($status === true) {
    //     /** Fue numerado con éxito */
    // }
    // else {
    //     /** En caso de error al numerar */
    // }

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
        'numerator_id',
        'doc_type_id',
        'verification_code',
        'file_path',
        'subject',
        'user_id',
        'organizational_unit_id',
        'establishment_id',
        'numerable_type',
        'numerable_id',
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
        return $this->belongsTo(Type::class, 'doc_type_id');
    }

    public function numerator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'numerator_id')->withTrashed();
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
     * File path and name
     */
    public function getStorageFilePathAttribute()
    {
        return 'ionline/documents/numeration/'.$this->id.'.pdf';
    }

    /**
     * Numerate
     */
    public function numerate(User $user)
    {
        // $modelo->numeration()->create([
        //     'automatic' => true,
        //     'internal_number' => null, // sólo enviar si automatic es falso, para numeros custom
        //     'doc_type_id' => $file_type_id,
        //     'file_path' => $file_path,
        //     'subject' => $subject,
        //     'user_id' => auth()->id(), // Responsable del documento numerado
        //     'organizational_unit_id' => auth()->user()->organizational_unit_id, // Ou del responsable
        //     'establishment_id' => auth()->user()->establishment_id,
        // ]);

        $this->status = null;
        DB::transaction(function () use ($user) {
            /* Chequear que el correlativo exista, si no, crearlo */
            $correlative = Correlative::firstOrCreate([
                'type_id' => $this->doc_type_id,
                'establishment_id' => $this->establishment_id,
            ], [
                'correlative' => 1,
            ]);

            $file = Storage::get($this->file_path);
            /* Generar el codigo de verificacion ej: ej: '000123-sbK5np' */
            $verificationCode = str_pad($this->id, 6, '0', STR_PAD_LEFT).'-'.str()->random(6);
            $number = $correlative->correlative;

            $digitalSignature = new DigitalSignature;
            $success = $digitalSignature->numerate($user, $file, $verificationCode, $number);

            if ($success) {
                /* Aumentar el correlativo y guardarlo */
                $correlative->correlative += 1;
                $correlative->save();
                /* Guardar el documento numerado */
                $digitalSignature->storeFirstSignedFile($this->storageFilePath);
                $this->number = $number;
                $this->verification_code = $verificationCode;
                $this->numerator_id = auth()->id();
                $this->date = now();
                $this->save();
                $this->status = true;
            } else {
                $this->status = $digitalSignature->error;
            }
        });

        return $this->status;
    }

    /**
     * Distribuir el documento numerado
     */
    public function distribute($users)
    {
        Notification::route('mail', $users)->notify(new NumerateAndDistribute($this));
    }
}
