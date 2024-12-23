<?php

namespace App\Models\Rrhh;

use App\Models\Documents\Approval;
use App\Models\Establishment;
use App\Models\Parameters\Parameter;
use App\Models\User;
use App\Observers\Rrhh\OvertimeRefundObserver;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([OvertimeRefundObserver::class])]
class OvertimeRefund extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'att_overtime_refunds';

    protected $fillable = [
        'date',
        'user_id',
        'organizational_unit_id',
        'boss_id',
        'boss_position',
        'grado',
        'planta',
        'type',
        'details',
        'total_minutes_day',
        'total_minutes_night',
        'status',
        'establishment_id',
        'rrhh_ok',
    ];

    protected $casts = [
        'date'    => 'date',
        'details' => 'array',
        'type'    => Type::class,
        'status'  => Status::class,
        'rrhh_ok' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function organizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class);
    }

    public function boss(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    /**
     * Get all of the approvations of a model.
     */
    public function approvals(): MorphMany
    {
        return $this->morphMany(Approval::class, 'approvable');
    }

    /**
     * Get the last of the approvations of a model.
     */
    public function lastApproval(): MorphOne
    {
        return $this->morphOne(Approval::class, 'approvable')->orderByDesc('id');
    }

    public function userApproval(): Approval
    {
        return Approval::make([
            'sent_to_user_id'      => $this->user->id,
            'approver_ou_id'       => $this->user->organizational_unit_id,
            'approver_id'          => $this->user->id,
            'approver_at'          => $this->created_at,
            'status'               => true,
        ]);
    }

    public function createApprovals(): void
    {
        $organizationalUnitsArray = $this->organizationalUnit->getHierarchicalUnits($this->user);
        $ouSubRRHH                = Parameter::get('ou', 'SubRRHH', $this->establishment_id);

        if (! $ouSubRRHH) {
            abort(403, 'Falta setear el Parámetro SubRRHH para el establecimiento.');
        }

        // Agregar el SubRRHH al final del array siempre y cuando no sea el último
        if ($organizationalUnitsArray[count($organizationalUnitsArray) - 1]['id'] != $ouSubRRHH) {
            $organizationalUnitsArray[] = [
                'id' => $ouSubRRHH,
            ];
        }

        $previousApprovalId = null;
        $positions          = ['left', 'center', 'right'];

        foreach ($organizationalUnitsArray as $index => $organizationalUnit) {
            $userApproval = $this->approvals()->create([
                'module'                => 'Devolución Horas Extras',
                'module_icon'           => 'bi bi-clock',
                'subject'               => 'Solicitud Devolución Horas Extras',
                'document_route_name'   => 'rrhh.overtime-refunds.show',
                'document_route_params' => json_encode([
                    'record' => $this->id,
                ]),
                'sent_to_ou_id'        => $organizationalUnit['id'],
                'approvable_callback'  => true,
                'active'               => $index === 0, // Solo el primero es activo
                'previous_approval_id' => $previousApprovalId,
                'position'             => $positions[$index % 3], // Ciclo de 'left', 'center', 'right'
                'start_y'              => $index < 3 ? 80 : null, // Solo los primeros 3 elementos tienen stary_y en 80
            ]);

            // Actualizar el ID del último approval creado
            $previousApprovalId = $userApproval->id;
        }
    }

    public function approvalCallback(): void
    {
        // Verificar los estados de los approvals
        if ($this->approvals->every(fn ($approval) => $approval->status === true)) {
            $this->update(['status' => 'approved']);
        } elseif ($this->approvals->contains(fn ($approval) => $approval->status === false)) {
            $this->update(['status' => 'rejected']);
        } 
        // elseif ($this->approvals->contains(fn ($approval) => $approval->status === null)) {
        //     $this->update(['status' => 'pending']);
        // }
    }

    public function getWeeks(): array
    {
        $weeks        = [];
        $startOfMonth = $this->date->startOfMonth();
        $endOfMonth   = $this->date->endOfMonth();

        $currentDate = $startOfMonth->copy();

        while ($currentDate->lte($endOfMonth)) {
            $weekNumber = $currentDate->weekOfYear;
            $dateString = $currentDate->toDateString();

            if (! isset($weeks[$weekNumber])) {
                $weeks[$weekNumber] = [
                    'days'   => [],
                    'totals' => [
                        'total_hours_day'             => 0,
                        'total_hours_night'           => 0,
                        'total_hours_day_converted'   => '00H,00m',
                        'total_hours_night_converted' => '00H,00m',
                    ],
                ];
            }

            $detailsForDate = collect($this->details)->firstWhere('date', $dateString);
            $details        = $detailsForDate ?? [
                'hours_day'     => 0,
                'hours_night'   => 0,
                'justification' => null,
            ];

            // Solo incluir registros donde active es true
            if ($details['hours_day'] > 0 || $details['hours_night'] > 0) {
                $weeks[$weekNumber]['days'][$dateString] = $details;

                // Sumar las horas del día y de la noche
                $weeks[$weekNumber]['totals']['total_hours_day'] += $details['hours_day'];
                $weeks[$weekNumber]['totals']['total_hours_night'] += $details['hours_night'];
            }

            $currentDate->addDay();
        }

        // Convertir los totales de minutos a horas y minutos
        foreach ($weeks as $weekNumber => $week) {
            $weeks[$weekNumber]['totals']['total_hours_day_converted']   = $this->convertMinutesToHoursAndMinutes($week['totals']['total_hours_day']);
            $weeks[$weekNumber]['totals']['total_hours_night_converted'] = $this->convertMinutesToHoursAndMinutes($week['totals']['total_hours_night']);
        }

        return $weeks;
    }

    protected function totalMinutesDayInHours(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->convertMinutesToHoursAndMinutes($this->total_minutes_day),
        );
    }

    protected function totalMinutesNightInHours(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->convertMinutesToHoursAndMinutes($this->total_minutes_night),
        );
    }

    private function convertMinutesToHoursAndMinutes($totalMinutes): string
    {
        $hours   = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;

        return sprintf('%02dH:%02dm', $hours, $minutes);
    }
}

enum Type: string implements HasLabel
{
    case Pay    = 'pay';
    case Return = 'return';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Pay    => 'Pago',
            self::Return => 'Devolución',
        };
    }
}

enum Status: string implements HasLabel, HasColor
{
    case Pending  = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Pending  => 'Pendiente',
            self::Approved => 'Aprobado',
            self::Rejected => 'Rechazado',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Pending => 'gray',
            self::Approved => 'success',
            self::Rejected => 'danger',
        };
    }
}
