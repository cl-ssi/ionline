<?php

namespace App\Models\Allowances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Carbon\Carbon;
use App\Models\Documents\Signature;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\Documents\Approval;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use App\Models\Archive\Archive;
use App\Models\Documents\Correlative;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\ClCommune;
use App\Models\Parameters\AllowanceValue;
use App\Models\Establishment;
use App\Models\Parameters\ContractualCondition;
use App\Models\Allowances\Destination;
use App\Models\Allowances\AllowanceFile;
use App\Models\Allowances\AllowanceSign;
use App\Models\Allowances\AllowanceCorrection;

class Allowance extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'alw_allowances';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'correlative',
        'folio_sirh',
        'status',
        'user_allowance_id',
        'allowance_value_id',
        'grade',
        'law',
        'contractual_condition_id',
        'position',
        'establishment_id',
        'organizational_unit_allowance_id',
        'place',
        'reason',
        'overnight',
        'accommodation',
        'food',
        'passage',
        'means_of_transport',
        'origin_commune_id',
        'destination_commune_id',
        'round_trip',
        'from',
        'to',
        'total_days',
        'total_half_days',
        'fifty_percent_total_days',
        'sixty_percent_total_days',
        'half_days_only',
        'day_value',
        'half_day_value',
        'fifty_percent_day_value',
        'sixty_percent_day_value',
        'total_value',
        'creator_user_id',
        'creator_ou_id',
        'document_date',
        'signatures_file_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'from'  => 'date',
        'to'    => 'date',
        'document_date' => 'date'
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
     * Get the user that owns the allowance.
     */
    public function userAllowance(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_allowance_id')->withTrashed();
    }

    /**
     * Get the organizational unit that owns the allowance.
     */
    public function organizationalUnitAllowance(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class, 'organizational_unit_allowance_id');
    }

    /**
     * Get the user that created the allowance.
     */
    public function userCreator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_user_id')->withTrashed();
    }

    /**
     * Get the organizational unit that created the allowance.
     */
    public function organizationalUnitCreator(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class, 'creator_ou_id');
    }

    /**
     * Get the origin commune.
     */
    public function originCommune(): BelongsTo
    {
        return $this->belongsTo(ClCommune::class, 'origin_commune_id');
    }

    /**
     * Get the destination communes.
     */
    public function destinationCommune(): HasMany
    {
        return $this->hasMany(Destination::class, 'allowance_id');
    }

    /**
     * Get the files associated with the allowance.
     */
    public function files(): HasMany
    {
        return $this->hasMany(AllowanceFile::class, 'allowance_id');
    }

    /**
     * Get the allowance value.
     */
    public function allowanceValue(): BelongsTo
    {
        return $this->belongsTo(AllowanceValue::class, 'allowance_value_id');
    }

    /**
     * Get the establishment associated with the allowance.
     */
    public function allowanceEstablishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class, 'establishment_id');
    }

    /**
     * Get the allowance signs.
     */
    public function allowanceSigns(): HasMany
    {
        return $this->hasMany(AllowanceSign::class, 'allowance_id');
    }

    /**
     * Get the allowance signature.
     */
    public function allowanceSignature(): BelongsTo
    {
        return $this->belongsTo(Signature::class, 'signature_id');
    }

    /**
     * Get the contractual condition.
     */
    public function contractualCondition(): BelongsTo
    {
        return $this->belongsTo(ContractualCondition::class, 'contractual_condition_id');
    }

    /**
     * Get the destinations.
     */
    public function destinations(): HasMany
    {
        return $this->hasMany(Destination::class, 'allowance_id');
    }

    /**
     * Get the corrections.
     */
    public function corrections(): HasMany
    {
        return $this->hasMany(AllowanceCorrection::class, 'allowance_id');
    }

    /**
     * Get all of the ModificationRequest's approvations.
     */
    public function approvals(): MorphMany
    {
        return $this->morphMany(Approval::class, 'approvable');
    }

    /**
     * Get one archive.
     */
    public function archive(): MorphOne
    {
        return $this->morphOne(Archive::class, 'archive');
    }

    public function getStatusValueAttribute()
    {
        switch ($this->status) {
            case 'pending':
                return 'Pendiente';
            case 'rejected':
                return 'Rechazado';
            case 'complete':
                return 'Finalizado';
            case 'manual':
                return 'Manual';
            case '':
                return '';
        }
    }

    public function getStatusColorAttribute()
    {
        switch ($this->status) {
            case 'pending':
                return 'warning';
            case 'rejected':
                return 'danger';
            case 'complete':
                return 'success';
            case 'manual':
                return 'primary';
            case '':
                return '';
        }
    }

    public function getLawValueAttribute()
    {
        switch ($this->law) {
            case '18834':
                return 'N° 18.834';
            case '19664':
                return 'N° 19.664';
            case '':
                return '';
        }
    }

    public function getMeansOfTransportValueAttribute()
    {
        switch ($this->means_of_transport) {
            case 'ambulance':
                return 'Ambulancia';
            case 'plane':
                return 'Avión';
            case 'bus':
                return 'Bus';
            case 'institutional vehicle':
                return 'Vehículo Institucional';
            case 'other':
                return 'Otro';
        }
    }

    public function getRoundTripValueAttribute()
    {
        switch ($this->round_trip) {
            case 'round trip':
                return 'Ida, vuelta';
            case 'one-way only':
                return 'Ida';
            case '':
                return '';
        }
    }

    public function getOvernightValueAttribute()
    {
        switch ($this->overnight) {
            case 1:
                return 'Sí';
            case 0:
                return 'No';
        }
    }

    public function getPassageValueAttribute()
    {
        switch ($this->passage) {
            case 1:
                return 'Sí';
            case 0:
                return 'No';
        }
    }

    public function getHalfDaysOnlyValueAttribute()
    {
        switch ($this->half_days_only) {
            case '1':
                return 'Sí';
            case '0':
                return 'No';
            case '':
                return 'No';
        }
    }

    public function getAccommodationValueAttribute()
    {
        switch ($this->accommodation) {
            case 1:
                return 'Sí';
            case 0:
                return 'No';
        }
    }

    public function getFoodValueAttribute()
    {
        switch ($this->food) {
            case 1:
                return 'Sí';
            case 0:
                return 'No';
        }
    }

    public function scopeSearch($query, $status_search, $search_id, $user_allowance_search, $status_sirh_search, $establishment_search)
    {
        if ($status_search || $search_id || $user_allowance_search || $status_sirh_search || $establishment_search) {
            if ($status_search != '' && ($status_search == 'pending' || $status_search == 'rejected')) {
                $query->whereHas('allowanceSignature', function ($query) use ($status_search) {
                    $query->where('status', $status_search);
                })
                ->orWhere('status', $status_search);
            }

            if ($status_search != '' && $status_search == 'completed') {
                $query->whereHas('allowanceSignature', function ($query) use ($status_search) {
                    $query->where('status', $status_search);
                });
            }

            if ($search_id != '') {
                $query->where(function ($q) use ($search_id) {
                    $q->where('correlative', $search_id);
                });
            }

            $array_user_allowance_search = explode(' ', $user_allowance_search);
            foreach ($array_user_allowance_search as $word) {
                $query->whereHas('userAllowance', function ($query) use ($word) {
                    $query->where('name', 'LIKE', '%' . $word . '%')
                        ->orWhere('fathers_family', 'LIKE', '%' . $word . '%')
                        ->orWhere('mothers_family', 'LIKE', '%' . $word . '%');
                });
            }

            if ($status_sirh_search != '') {
                $query->whereHas('allowanceSigns', function ($query) use ($status_sirh_search) {
                    $query->where('status', $status_sirh_search);
                });
            }

            if ($establishment_search != '') {
                $query->whereHas('allowanceEstablishment', function ($query) use ($establishment_search) {
                    $query->where('establishment_id', $establishment_search);
                });
            }
        }
    }

    public function getFromFormatAttribute()
    {
        return Carbon::parse($this->from)->format('d-m-Y');
    }

    public function getToFormatAttribute()
    {
        return Carbon::parse($this->to)->format('d-m-Y');
    }

    /**
     * Simular un approval model.
     */
    public function getApprovalLegacyAttribute()
    {
        $approval = new Approval();

        $approval->status = true;
        $approval->approver_id = $this->allowanceSigns->first()->user_id;
        $approval->approver_at = $this->allowanceSigns->first()->date_sign;
        $approval->sent_to_ou_id = $this->allowanceSigns->first()->organizational_unit_id;

        return $approval;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($allowance) {
            //TODO: PARAMETRIZAR TYPE_ID VIATICOS
            $allowance->correlative = Correlative::getCorrelativeFromType(20, $allowance->organizationalUnitAllowance->establishment_id);
        });
    }
}