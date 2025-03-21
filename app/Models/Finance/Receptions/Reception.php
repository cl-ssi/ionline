<?php

namespace App\Models\Finance\Receptions;

use App\Models\Documents\Approval;
use App\Models\Documents\Numeration;
use App\Models\Establishment;
use App\Models\File;
use App\Models\Finance\Dte;
use App\Models\Finance\PurchaseOrder;
use App\Models\Pharmacies\Purchase;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\User;
use App\Observers\Finance\Receptions\ReceptionObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use OwenIt\Auditing\Contracts\Auditable;

#[ObservedBy([ReceptionObserver::class])]
class Reception extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fin_receptions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number', // FIXME: no se está ocupando, quizá la idea era almacenar el numero de la relacion numerate
        'internal_number',
        'date',
        'reception_type_id',

        'purchase_order',

        'guia_id',
        'dte_id',
        'dte_type',
        'dte_number',
        'dte_date',

        'header_notes',
        'footer_notes',

        'rejected',
        'rejected_notes',

        'partial_reception',

        'neto',
        'descuentos',
        'cargos',
        'subtotal',
        'iva',
        'total',

        'status',

        'mercado_publico',

        // 'file',
        'responsable_id',
        'responsable_ou_id',
        'creator_id',
        'creator_ou_id',

        'establishment_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date'              => 'date:Y-m-d',
        'dte_date'          => 'date:Y-m-d',
        'partial_reception' => 'boolean',
        'status'            => 'boolean',
        'rejected'          => 'boolean',
    ];

    public function receptionType(): BelongsTo
    {
        return $this->belongsTo(ReceptionType::class);
    }

    public function purchaseOrder(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order', 'code');
    }

    public function guia(): BelongsTo
    {
        return $this->belongsTo(Dte::class, 'guia_id');
    }

    public function dte(): BelongsTo
    {
        return $this->belongsTo(Dte::class, 'dte_id');
    }

    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function responsableOu(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function creatorOu(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ReceptionItem::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    /**
     * Get all of the approvations of a model.
     */
    public function approvals(): MorphMany
    {
        return $this->morphMany(Approval::class, 'approvable');
    }

    /**
     * Get the numeration of the model.
     */
    public function numeration(): MorphOne
    {
        return $this->morphOne(Numeration::class, 'numerable');
    }

    /**
     * Get all of the files of a model.
     */
    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    /**
     * Get signed file, legacy de cenabast.
     */
    public function signedFileLegacy(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable')->where('type', 'signed_file');
    }

    public function noOcFile(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable')->where('type', 'no_oc');
    }

    /**
     * Get support file, archivo de respaldo.
     */
    public function supportFile(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable')->where('type', 'support_file');
    }

    /** Convierte los tipos de dte en human readable "boleta_honorarios" => "Boleta Honorarios" */
    public function getDteTypeNameAttribute()
    {
        return ucwords(str_replace('_', ' ', strtolower($this->dte_type)));
    }

    public function allApprovalsOk(): bool
    {
        $approvals = $this->approvals;

        return $approvals->every(function ($approval) {
            return $approval->status == 1;
        });
    }
}
