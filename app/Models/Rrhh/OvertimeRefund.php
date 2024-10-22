<?php

namespace App\Models\Rrhh;

use App\Models\Establishment;
use App\Models\User;
use App\Observers\Rrhh\OvertimeRefundObserver;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([OvertimeRefundObserver::class])]
class OvertimeRefund extends Model
{
    use HasFactory;

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
        'establishment_id',
    ];

    protected $casts = [
        'date' => 'date',
        'details' => 'array',
        'type' => Type::class,
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

    public function getWeeks(): array
    {
        $weeks = [];
        $startOfMonth = $this->date->startOfMonth();
        $endOfMonth = $this->date->endOfMonth();

        $currentDate = $startOfMonth->copy();

        while ($currentDate->lte($endOfMonth)) {
            $weekNumber = $currentDate->weekOfYear;
            $dateString = $currentDate->toDateString();

            if (!isset($weeks[$weekNumber])) {
                $weeks[$weekNumber] = [
                    'days' => [],
                    'totals' => [
                        'total_hours_day' => 0,
                        'total_hours_night' => 0,
                        'total_hours_day_converted' => '00H,00m',
                        'total_hours_night_converted' => '00H,00m',
                    ],
                ];
            }

            $detailsForDate = collect($this->details)->firstWhere('date', $dateString);
            $details = $detailsForDate ?? [
                'hours_day' => 0,
                'hours_night' => 0,
                'active' => true,
                'justification' => null,
            ];

            // Solo incluir registros donde active es true
            if ($details['active']) {
                $weeks[$weekNumber]['days'][$dateString] = $details;

                // Sumar las horas del día y de la noche
                $weeks[$weekNumber]['totals']['total_hours_day'] += $details['hours_day'];
                $weeks[$weekNumber]['totals']['total_hours_night'] += $details['hours_night'];
            }

            $currentDate->addDay();
        }

        // Convertir los totales de minutos a horas y minutos
        foreach ($weeks as $weekNumber => $week) {
            $weeks[$weekNumber]['totals']['total_hours_day_converted'] = $this->convertMinutesToHoursAndMinutes($week['totals']['total_hours_day']);
            $weeks[$weekNumber]['totals']['total_hours_night_converted'] = $this->convertMinutesToHoursAndMinutes($week['totals']['total_hours_night']);
        }

        return $weeks;
    }

    private function convertMinutesToHoursAndMinutes($totalMinutes): string
    {
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;
        return sprintf('%02dH:%02dm', $hours, $minutes);
    }
}


enum Type: string implements HasLabel
{
    case Pay = 'pay';
    case Return = 'return';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Pay => 'Pago',
            self::Return => 'Devolución',
        };
    }
}