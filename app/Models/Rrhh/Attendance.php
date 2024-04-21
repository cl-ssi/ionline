<?php

namespace App\Models\Rrhh;

use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'rrhh_attendances';

    protected $fillable = [
        'user_id',
        'date',
        'records',
        'report_date',
    ];

    protected $casts = [
        'date' => 'date',
        'report_date' => 'date',
    ];

    // Relacion con user

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get formated records of attendance.
     */
    protected function records(): Attribute
    {
        return Attribute::make(
            get: function (string $value) {
                $record = str_replace(
                    '"Días"	"Horario "	"Horario "	"Horas "	"Horas "	"Horas Extras "	"Total Horas "	"Atrasos y "', 
               "\n".'"Días"														"Horario "						"Horario "				"Horas "		"Horas " "H.Extra"  "Total"		"Atrasos"', 
                    $value);
                $record = str_replace('"', '', $record);
                return $record;
            },
        );
    }
}
