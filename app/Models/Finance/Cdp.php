<?php

namespace App\Models\Finance;

use App\Models\Documents\Approval;
use App\Models\Documents\Numeration;
use App\Models\Documents\Type;
use App\Models\Establishment;
use App\Models\Parameters\Parameter;
use App\Models\RequestForms\RequestForm;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Cdp extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fin_cdps';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'file_path',
        'request_form_id',
        'user_id',
        'organizational_unit_id',
        'establishment_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'datetime',
    ];

    /**
     * Get the request form that owns the CDP.
     *
     * @return BelongsTo
     */
    public function requestForm(): BelongsTo
    {
        return $this->belongsTo(RequestForm::class);
    }

    /**
     * Get the user that owns the CDP.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the organizational unit that owns the CDP.
     *
     * @return BelongsTo
     */
    public function organizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class);
    }

    /**
     * Get the establishment that owns the CDP.
     *
     * @return BelongsTo
     */
    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    /**
     * Get the approval model.
     *
     * @return MorphOne
     */
    public function approval(): MorphOne
    {
        return $this->morphOne(Approval::class, 'approvable');
    }

    /**
     * Get the numeration of the model.
     *
     * @return MorphOne
     */
    public function numeration(): MorphOne
    {
        return $this->morphOne(Numeration::class, 'numerable');
    }

    public function createNumeration(): void
    {
        /**
         * Este método no se está ocupando
         * En el CdpController debería cambiarse para ocupar este método
         * No he tenido tiempo de hacerlo
         */
        $documentType = Type::where('name','Certificado disponibilidad presupuestaria')->first();

        // Si no existe el tipo de documento, no se puede numerar
        if (!$documentType) {
            logger()->error('No se encontró el tipo de documento para numerar');
            return;
        }

        if ($this->approval->status != true) {
            logger()->error('El documento no ha sido aprobado');
            return;
        }

        // Si ya existe un numerado, no se puede volver a numerar
        if ($this->numeration) {
            logger()->error('El documento ya contiene un modelo numeration');
            return;
        }

        $this->numeration()->create([
            'automatic'              => true,
            'correlative'            => null, // sólo enviar si automatic es falso, para numeros custom
            'doc_type_id'            => $documentType->id,
            'file_path'              => $this->approval->filename,
            'subject'                => 'Certificado disponibilidad presupuestaria',
            'user_id'                => $this->approval->approver_id, // Responsable del documento numerado
            'organizational_unit_id' => $this->approval->approver_ou_id, // Ou del responsable
            'establishment_id'       => $this->establishment_id,
        ]);

        /**
         * El proceso de Numerar se hace en el módulo de partes en el menú numerar y distribuir
         */
        // $user = User::find(Parameter::get('partes','numerador', $this->establishment_id));
        // $status = $this->numeration->numerate($user);

        // if ($status === true) {
        //     /** Fue numerado con éxito */
        //     logger()->info('Numerado con éxito');
        // } 
        // else {
        //     /** En caso de error al numerar */
        //     logger()->error('Error al numerar');
        // }
    }
}