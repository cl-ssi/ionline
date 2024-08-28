<?php

namespace App\Models\ServiceRequests;

use DatePeriod;
use DateInterval;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use OwenIt\Auditing\Auditable;
use App\Models\Documents\Approval;
use Illuminate\Database\Eloquent\Model;
use App\Models\Documents\SignaturesFile;
use App\Models\ServiceRequests\Attachment;
use App\Models\ServiceRequests\ShiftControl;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ServiceRequests\ServiceRequest;
use App\Models\ServiceRequests\FulfillmentItem;
use App\Models\ServiceRequests\Denomination1121;
use App\Models\ServiceRequests\DenominationFormula;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Fulfillment extends Model implements AuditableContract
{
    use Auditable, HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'doc_fulfillments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'service_request_id',
        'year',
        'month',
        'type',
        'start_date',
        'end_date',
        'observation',
        'responsable_approbation',
        'responsable_approbation_date',
        'responsable_approver_id',
        'rrhh_approbation',
        'rrhh_approbation_date',
        'rrhh_approver_id',
        'payment_ready',
        'has_invoice_file',
        'has_invoice_file_at',
        'has_invoice_file_user_id',
        'finances_approbation',
        'finances_approbation_date',
        'finances_approver_id',
        'invoice_path',
        'user_id',
        'bill_number',
        'total_hours_to_pay',
        'total_to_pay',
        'total_to_pay_at',
        'total_hours_paid',
        'total_paid',
        'payment_date',
        'contable_month',
        'payment_rejection_detail',
        'illness_leave',
        'leave_of_absence',
        'assistance',
        'backup_assistance',
        'signatures_file_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
        'payment_date' => 'date:Y-m-d',
        'has_invoice_file_at' => 'datetime',
        'responsable_approbation_date' => 'datetime',
        'rrhh_approbation_date' => 'datetime',
        'finances_approbation_date' => 'datetime',
        'total_to_pay_at' => 'datetime'
    ];

    /**
     * Get the denominations associated with the fulfillment (1121).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function Denominations1121()
    {
        return $this->belongsToMany(Denomination1121::class, 'doc_1121_fulfillments', 'doc_1121_id', 'doc_fulfillments_id')->withTimestamps();
    }

    /**
     * Get the denominations associated with the fulfillment (Formula).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function DenominationsFormula()
    {
        return $this->belongsToMany(DenominationFormula::class, 'doc_formula_fulfillments', 'doc_formula_id', 'doc_fulfillments_id')->withTimestamps();
    }

    /**
     * Get the shift controls associated with the fulfillment.
     *
     * @return HasMany
     */
    public function shiftControls(): HasMany
    {
        return $this->hasMany(ShiftControl::class);
    }

    /**
     * Get the fulfillment items associated with the fulfillment.
     *
     * @return HasMany
     */
    public function FulfillmentItems(): HasMany
    {
        return $this->hasMany(FulfillmentItem::class);
    }

    /**
     * Get the service request associated with the fulfillment.
     *
     * @return BelongsTo
     */
    public function ServiceRequest(): BelongsTo
    {
        return $this->belongsTo(ServiceRequest::class);
    }

    /**
     * Get the responsible user associated with the fulfillment.
     *
     * @return BelongsTo
     */
    public function responsableUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_approver_id')->withTrashed();
    }

    /**
     * Get the RRHH user associated with the fulfillment.
     *
     * @return BelongsTo
     */
    public function rrhhUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rrhh_approver_id')->withTrashed();
    }

    /**
     * Get the finances user associated with the fulfillment.
     *
     * @return BelongsTo
     */
    public function financesUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'finances_approver_id')->withTrashed();
    }

    /**
     * Get the user who uploaded the invoice file.
     *
     * @return BelongsTo
     */
    public function voiceUploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'has_invoice_file_user_id')->withTrashed();
    }

    /**
     * Get the signed certificate associated with the fulfillment.
     *
     * @return BelongsTo
     */
    public function signedCertificate(): BelongsTo
    {
        return $this->belongsTo(SignaturesFile::class, 'signatures_file_id');
    }

    /**
     * Get the attachments associated with the fulfillment.
     *
     * @return HasMany
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class);
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

    // Custom Methods

    public function MonthOfPayment()
    {
        if ($this->contable_month) {
            return match ($this->contable_month) {
                1 => "Enero",
                2 => "Febrero",
                3 => "Marzo",
                4 => "Abril",
                5 => "Mayo",
                6 => "Junio",
                7 => "Julio",
                8 => "Agosto",
                9 => "Septiembre",
                10 => "Octubre",
                11 => "Noviembre",
                12 => "Diciembre",
                default => null,
            };
        }
    }

    public function quit_status()
    {
        foreach ($this->FulfillmentItems as $key => $fulfillmentItem) {
            if (in_array($fulfillmentItem->type, [
                "Renuncia voluntaria",
                "Abandono de funciones",
                "Término de contrato anticipado"
            ])) {
                return "Sí";
            }
        }
        return "No";
    }

    public function scopeSearch($query, Request $request)
    {
        if ($request->input('establishment') != "") {
            $query->whereHas('servicerequest', function ($q) use ($request) {
                $q->where('establishment_id', $request->input('establishment'));
            });
        }

        if ($request->input('sr_id') != "") {
            $query->whereHas('servicerequest', function ($q) use ($request) {
                $q->Where('id', $request->input('sr_id'));
            });
        }

        if ($request->input('rut') != "") {
            $query->whereHas('servicerequest', function ($q) use ($request) {
                $q->whereHas('employee', function ($q) use ($request) {
                    $users = User::getUsersBySearch($request->input('rut'));
                    $q->whereIn('id', $users->get('id'));
                });
            });
        }

        if ($request->input('year') != "") {
            $query->where('year', $request->input('year'));
        }

        if ($request->input('month') != "") {
            $query->where('month', $request->input('month'));
        }

        if ($request->input('program_contract_type') != "") {
            $query->whereHas('servicerequest', function ($q) use ($request) {
                $q->Where('program_contract_type', $request->input('program_contract_type'));
            });
        }

        if ($request->input('type') != "") {
            $query->whereHas('servicerequest', function ($q) use ($request) {
                $q->Where('type', $request->input('type'));
            });
        }

        if ($request->input('programm_name') != "") {
            $query->whereHas('servicerequest', function ($q) use ($request) {
                $q->Where('programm_name', $request->input('programm_name'));
            });
        }

        if ($request->input('resolution') != "") {
            if ($request->input('resolution') == 'Yes') {
                $query->whereHas('serviceRequest', function ($q) use ($request) {
                    $q->where('has_resolution_file', 1);
                });
            } else {
                $query->whereHas('serviceRequest', function ($q) use ($request) {
                    $q->whereNull('has_resolution_file');
                });
            }
        }

        if ($request->input('payment_date') != "") {
            if ($request->input('payment_date') == 'P') {
                $query->whereNotNull('payment_date');
            } else {
                $query->whereNull('payment_date');
            }
        }

        if ($request->input('certificate') != "") {
            if ($request->input('certificate') == 'Yes') {
                $query->whereNotNull('signatures_file_id');
            } else {
                $query->whereNull('signatures_file_id');
            }
        }

        if ($request->input('ok_responsable') != "") {
            if ($request->input('ok_responsable') == 'Yes') {
                $query->whereNotNull('responsable_approbation');
            } else {
                $query->whereNull('responsable_approbation');
            }
        }

        if ($request->input('ok_rrhh') != "") {
            if ($request->input('ok_rrhh') == 'Yes') {
                $query->whereNotNull('rrhh_approbation');
            } else {
                $query->whereNull('rrhh_approbation');
            }
        }

        if ($request->input('ok_finances') != "") {
            if ($request->input('ok_finances') == 'Yes') {
                $query->whereNotNull('finances_approbation');
            } else {
                $query->whereNull('finances_approbation');
            }
        }

        if ($request->input('invoice') != "") {
            if ($request->input('invoice') == 'Yes') {
                $query->whereNotNull('has_invoice_file');
            } else {
                $query->whereNull('has_invoice_file');
            }
        }

        if ($request->input('working_day_type') != "") {
            $query->whereHas('servicerequest', function ($q) use ($request) {
                $q->Where('working_day_type', $request->input('working_day_type'));
            });
        }

        return $query;
    }

    // Funciones para el cálculo del total a cobrar de cada período.
    public function monto_con_inasistencias($mes_completo, $mes, $monto)
    {
        $fulfillment = $this->serviceRequest->fulfillments->where('month', $mes)->first();

        if ($fulfillment) {
            $total_dias_trabajados = 0;
            $mes_completo = true;

            // Renuncia voluntaria
            if ($renuncia = $fulfillment->fulfillmentItems->where('type', 'Renuncia voluntaria')->first()) {
                $fulfillment->end_date = $renuncia->end_date;
            }

            if ($fulfillment->start_date && $fulfillment->end_date) {
                if (
                    $fulfillment->start_date->toDateString() == $fulfillment->start_date->startOfMonth()->toDateString()
                    && $fulfillment->end_date->toDateString() == $fulfillment->end_date->endOfMonth()->toDateString()
                ) {
                    $total_dias_trabajados = 30;
                    $mes_completo = true;
                } else {
                    $total_dias_trabajados = $fulfillment->start_date->diff($fulfillment->end_date)->days + 1;
                    $mes_completo = false;
                }
            }

            $dias_descuento = 0;
            $dias_trabajado_antes_retiro = 0;
            $hrs_descuento = 0;
            $mins_descuento = 0;

            foreach ($fulfillment->fulfillmentItems as $item) {
                switch ($item->type) {
                    case 'Inasistencia Injustificada':
                    case 'Licencia no covid':
                        $mes_completo = false;
                        $dias_descuento += $item->end_date->diff($item->start_date)->days + 1;
                        break;
                    case 'Licencia media jornada no covid':
                        $mes_completo = false;
                        $dias_descuento_t = $item->end_date->diff($item->start_date)->days + 1;
                        $dias_descuento += ($dias_descuento_t / 2);
                        break;
                    case 'Abandono de funciones':
                    case 'Renuncia voluntaria':
                    case 'Término de contrato anticipado':
                        $mes_completo = false;
                        $dias_descuento += $item->end_date->diff($item->start_date)->days + 1;
                        $dias_trabajado_antes_retiro = ((int)$item->end_date->format("d")) - (int)$fulfillment->start_date->format("d");
                        break;
                    case 'Atraso':
                        $mes_completo = false;
                        $mins_descuento += $item->end_date->diffInMinutes($item->start_date);
                        break;
                }
            }

            $total_dias_trabajados -= $dias_descuento;

            if ($mes_completo) {
                $total = $monto - ($dias_descuento * ($monto / 30));
            } else {
                if ($dias_trabajado_antes_retiro != 0) {
                    $total_dias_trabajados = $dias_trabajado_antes_retiro;
                }
                $total = $total_dias_trabajados * ($monto / 30);
            }

            if ($hrs_descuento != 0) {
                $valor_hora = ($monto / 30 / 8.8);
                $total_dcto_horas = $hrs_descuento * $valor_hora;
                $total -= $total_dcto_horas;
            }

            if ($mins_descuento >= 60) {
                $valor_hora = ($monto / 30 / 8.8);
                $hrs_descuento = floor($mins_descuento / 60);
                $total_dcto_horas = $hrs_descuento * $valor_hora;
                $total -= $total_dcto_horas;
            }

            return $total;
        }
    }

    public function items_verification($month)
    {
        foreach ($this->serviceRequest->fulfillments->where('month', $month) as $fulfillment) {
            foreach ($fulfillment->fulfillmentItems as $item) {
                if (in_array($item->type, [
                    'Inasistencia Injustificada',
                    'Licencia no covid',
                    'Licencia media jornada no covid',
                    'Abandono de funciones',
                    'Atraso',
                    'Renuncia voluntaria',
                    'Término de contrato anticipado'
                ])) {
                    if (is_null($item->end_date) || is_null($item->start_date)) {
                        return false;
                    }
                }
            }
        }
        return true;
    }

    public function getValueMonthlyQuoteValue()
    {
        $serviceRequest = $this->ServiceRequest;

        if ($this->month > $serviceRequest->end_date->month) {
            return null;
        }

        $first_month = $serviceRequest->start_date->month;
        $last_month  = $serviceRequest->end_date->month;
        $valores_mensualizados = [];

        if ($serviceRequest->start_date->format('Y-m-d') == $serviceRequest->start_date->firstOfMonth()->format('Y-m-d') && $serviceRequest->end_date->format('Y-m-d') == $serviceRequest->end_date->endOfMonth()->format('Y-m-d')) {
            $nroCuotas = $serviceRequest->start_date->diffInMonths($serviceRequest->end_date) + 1;
            $valor_mensual = $serviceRequest->net_amount;
            $interval = DateInterval::createFromDateString('1 month');
            $periods   = new DatePeriod($serviceRequest->start_date, $interval, $serviceRequest->end_date);
            $periods = iterator_to_array($periods);

            foreach ($periods as $key => $period) {
                if ($this->items_verification(intval($period->format("m")))) {
                    $valores_mensualizados[intval($period->format("m"))] = number_format($this->monto_con_inasistencias(true, intval($period->format("m")), $valor_mensual));
                } else {
                    $valores_mensualizados[intval($period->format("m"))] = "Revise los datos ingresados en el cuadro de responsable.";
                }
            }
        } else {
            $diff_in_months = $serviceRequest->end_date->diffInMonths($serviceRequest->start_date);

            if ($diff_in_months < 1) {
                if ($serviceRequest->start_date->month != $serviceRequest->end_date->month) {
                    goto here;
                }

                if ($this->items_verification($serviceRequest->start_date->month)) {
                    $valores_mensualizados[$serviceRequest->start_date->month] = number_format($this->monto_con_inasistencias(false, $serviceRequest->start_date->month, $serviceRequest->net_amount));
                } else {
                    $valores_mensualizados[$serviceRequest->start_date->month] = "Revise los datos ingresados en el cuadro de responsable.";
                }
            } else {
                here:

                if ($serviceRequest->start_date->format('Y-m-d') != $serviceRequest->start_date->firstOfMonth()->format('Y-m-d') && $serviceRequest->end_date->format('Y-m-d') != $serviceRequest->end_date->endOfMonth()->format('Y-m-d')) {
                    $nroCuotas = $serviceRequest->start_date->diffInMonths($serviceRequest->end_date) + 2;
                    $valor_mensual = $serviceRequest->net_amount;
                    $interval = DateInterval::createFromDateString('1 month');
                    $periods   = new DatePeriod($serviceRequest->start_date, $interval, $serviceRequest->end_date->addMonth());
                    $periods = iterator_to_array($periods);
                    $dias_trabajados1 = $serviceRequest->start_date->diff($serviceRequest->start_date->lastOfMonth())->days + 1;
                    $valor_diferente1 = round($dias_trabajados1 * ($valor_mensual / 30));
                    $dias_trabajados2 = $serviceRequest->end_date->firstOfMonth()->diff($serviceRequest->end_date)->days + 1;
                    $valor_diferente2 = round($dias_trabajados2 * ($valor_mensual / 30));

                    foreach ($periods as $key => $period) {
                        if ($key === array_key_first($periods)) {
                            if ($this->items_verification(intval($period->format("m")))) {
                                $valores_mensualizados[intval($period->format("m"))] = number_format($this->monto_con_inasistencias(false, intval($period->format("m")), $valor_diferente1));
                            } else {
                                $valores_mensualizados[intval($period->format("m"))] = "Revise los datos ingresados en el cuadro de responsable.";
                            }
                        } elseif ($key === array_key_last($periods)) {
                            if ($this->items_verification(intval($period->format("m")))) {
                                $valores_mensualizados[intval($period->format("m"))] = number_format($this->monto_con_inasistencias(false, intval($period->format("m")), $valor_diferente2));
                            } else {
                                $valores_mensualizados[intval($period->format("m"))] = "Revise los datos ingresados en el cuadro de responsable.";
                            }
                        } else {
                            if ($this->items_verification(intval($period->format("m")))) {
                                $valores_mensualizados[intval($period->format("m"))] = number_format($this->monto_con_inasistencias(true, intval($period->format("m")), $valor_mensual));
                            } else {
                                $valores_mensualizados[intval($period->format("m"))] = "Revise los datos ingresados en el cuadro de responsable.";
                            }
                        }
                    }
                } elseif ($serviceRequest->start_date->format('Y-m-d') != $serviceRequest->start_date->firstOfMonth()->format('Y-m-d')) {
                    $nroCuotas = $serviceRequest->start_date->diffInMonths($serviceRequest->end_date) + 1;
                    $valor_mensual = $serviceRequest->net_amount;
                    $interval = DateInterval::createFromDateString('1 month');
                    $periods   = new DatePeriod($serviceRequest->start_date->firstOfMonth(), $interval, $serviceRequest->end_date->endOfMonth());
                    $periods = iterator_to_array($periods);
                    $dias_trabajados = $serviceRequest->start_date->diff($serviceRequest->start_date->lastOfMonth())->days + 1;
                    $valor_diferente = round($dias_trabajados * ($valor_mensual / 30));

                    foreach ($periods as $key => $period) {
                        if ($this->items_verification(intval($period->format("m")))) {
                            $valores_mensualizados[intval($period->format("m"))] = number_format($this->monto_con_inasistencias(false, intval($period->format("m")), $valor_diferente));
                        } else {
                            $valores_mensualizados[intval($period->format("m"))] = "Revise los datos ingresados en el cuadro de responsable.";
                        }
                    }
                } elseif ($serviceRequest->end_date->format('Y-m-d') != $serviceRequest->end_date->endOfMonth()->format('Y-m-d')) {
                    $nroCuotas = $serviceRequest->start_date->diffInMonths($serviceRequest->end_date) + 1;
                    $valor_mensual = $serviceRequest->net_amount;
                    $interval = DateInterval::createFromDateString('1 month');
                    $periods   = new DatePeriod($serviceRequest->start_date, $interval, $serviceRequest->end_date);
                    $periods = iterator_to_array($periods);
                    $dias_trabajados = (int)$serviceRequest->end_date->format('d');
                    $valor_diferente = round($dias_trabajados * ($valor_mensual / 30));

                    foreach ($periods as $key => $period) {
                        if ($this->items_verification(intval($period->format("m")))) {
                            $valores_mensualizados[intval($period->format("m"))] = number_format($this->monto_con_inasistencias(true, intval($period->format("m")), $valor_mensual));
                        } else {
                            $valores_mensualizados[intval($period->format("m"))] = "Revise los datos ingresados en el cuadro de responsable.";
                        }
                    }
                }
            }
        }

        return $valores_mensualizados[$this->month];
    }
}
