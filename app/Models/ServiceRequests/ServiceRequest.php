<?php

namespace App\Models\ServiceRequests;

use App\Models\Documents\SignaturesFile;
use App\Models\Establishment;
use App\Models\Parameters\Bank;
use App\Models\Parameters\Profession;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ServiceRequest extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'doc_service_requests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'responsable_id',
        'user_id',
        'subdirection_ou_id',
        'responsability_center_ou_id',
        'type',
        'request_date',
        'start_date',
        'end_date',
        'contract_type',
        'contractual_condition',
        'service_description',
        'programm_name',
        'grade',
        'other',
        'normal_hour_payment',
        'amount',
        'program_contract_type',
        'weekly_hours',
        'daily_hours',
        'nightly_hours',
        'estate',
        'estate_other',
        'working_day_type',
        'schedule_detail',
        'working_day_type_other',
        'subdirection_id',
        'responsability_center_id',
        'budget_cdp_number',
        'budget_item',
        'budget_amount',
        'budget_date',
        'contract_number',
        'month_of_payment',
        'establishment_id',
        'profession_id',
        'objectives',
        'resolve',
        'subt31',
        'additional_benefits',
        'bonus_indications',
        'digera_strategy',
        'rrhh_team',
        'gross_amount',
        'net_amount',
        'sirh_contract_registration',
        'resolution_number',
        'resolution_date',
        'bill_number',
        'total_hours_paid',
        'total_paid',
        'has_resolution_file',
        'has_resolution_file_at',
        'payment_date',
        'verification_code',
        'observation',
        'creator_id',
        'address',
        'phone_number',
        'email',
        'signature_page_break',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'request_date' => 'date:Y-m-d',
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
        'budget_date' => 'date:Y-m-d',
        'payment_date' => 'date:Y-m-d',
        'resolution_date' => 'date:Y-m-d',
        'has_resolution_file_at' => 'datetime',
    ];

    /**
     * Get the profession associated with the service request.
     */
    public function profession(): BelongsTo
    {
        return $this->belongsTo(Profession::class, 'profession_id');
    }

    /**
     * Get the responsible user associated with the service request.
     */
    public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_id')->withTrashed();
    }

    /**
     * Get the employee associated with the service request.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    /**
     * Get the creator associated with the service request.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id')->withTrashed();
    }

    /**
     * Get the signature flows associated with the service request.
     */
    public function SignatureFlows(): HasMany
    {
        return $this->hasMany(SignatureFlow::class);
    }

    /**
     * Get the establishment associated with the service request.
     */
    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    /**
     * Get the subdirection associated with the service request.
     */
    public function subdirection(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class, 'subdirection_ou_id');
    }

    /**
     * Get the responsibility center associated with the service request.
     */
    public function responsabilityCenter(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class, 'responsability_center_ou_id')->withTrashed();
    }

    /**
     * Get the shift controls associated with the service request.
     */
    public function shiftControls(): HasMany
    {
        return $this->hasMany(ShiftControl::class);
    }

    /**
     * Get the fulfillments associated with the service request.
     */
    public function fulfillments(): HasMany
    {
        return $this->hasMany(Fulfillment::class);
    }

    /**
     * Get the bank associated with the service request.
     */
    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    /**
     * Get the signed budget availability certificate associated with the service request.
     */
    public function signedBudgetAvailabilityCert(): BelongsTo
    {
        return $this->belongsTo(SignaturesFile::class, 'signed_budget_availability_cert_id');
    }

    // Custom Methods

    public function MonthOfPayment()
    {
        if ($this->payment_date) {
            return match ($this->payment_date->format('m')) {
                1 => 'Enero',
                2 => 'Febrero',
                3 => 'Marzo',
                4 => 'Abril',
                5 => 'Mayo',
                6 => 'Junio',
                7 => 'Julio',
                8 => 'Agosto',
                9 => 'Septiembre',
                10 => 'Octubre',
                11 => 'Noviembre',
                12 => 'Diciembre',
                default => null,
            };
        }
    }

    public function programm_name_id()
    {
        if (str_contains($this->programm_name, 'No médico')) {
            dd('no médico');
        }
    }

    public function working_day_type_description()
    {
        return match ($this->working_day_type) {
            'DIURNO' => 'un largo de 08:00 a 20:00 hrs., una noche de 20:00 a 08:00 hrs. y dos días libres',
            'TERCER TURNO' => 'dos largos de 08:00 a 20:00 hrs., dos noches de 20:00 a 08:00 hrs. y dos días libres',
            'CUARTO TURNO' => 'horario diurno',
            default => null,
        };
    }

    public static function getPendingRequests()
    {
        $count = 0;
        $user_id = auth()->id();
        $serviceRequests = ServiceRequest::whereHas('SignatureFlows', function ($subQuery) use ($user_id) {
            $subQuery->whereNull('status')
                ->where(function ($query) use ($user_id) {
                    $query->where('responsable_id', $user_id);
                });
        })
            ->wheredoesnthave('SignatureFlows', function ($subQuery) {
                $subQuery->where('status', 0);
            })
            ->with('SignatureFlows')
            ->get();

        foreach ($serviceRequests as $serviceRequest) {
            if ($serviceRequest->SignatureFlows->where('status', '===', 0)->count() == 0) {
                foreach ($serviceRequest->SignatureFlows->sortBy('sign_position') as $signatureFlow) {
                    if ($user_id == $signatureFlow->responsable_id && $signatureFlow->status === null) {
                        $last_signature_flow = $serviceRequest->SignatureFlows->where('status', '!=', 2)->where('sign_position', $signatureFlow->sign_position - 1)->first();
                        if ($last_signature_flow && $last_signature_flow->status !== null) {
                            $count += 1;
                        }
                    }
                }
            }
        }

        return $count;
    }

    public function status()
    {
        if ($this->SignatureFlows->where('status', '===', 0)->count() > 0) {
            return 'Rechazada';
        } elseif ($this->SignatureFlows->whereNull('status')->count() > 0) {
            return 'Pendiente';
        } else {
            return 'Finalizada';
        }
    }
}
