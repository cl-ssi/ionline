<?php

namespace App\Models\IdentifyNeeds;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\User;
use App\Models\Parameters\Estament;
use App\Models\Trainings\StrategicAxis;


class IdentifyNeed extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'status',

        // USUARIO
        'user_id',
        'organizational_unit_id',
        'organizational_unit_name',
        'establishment_id',
        'establishment_name',
        'email',
        'email_personal',
        'position',

        // JEFATURA
        'boss_id',
        'boss_email',

        'subject',
        'estament_id',
        'family_position',
        'nature_of_the_need',
        'question_1',
        'question_2',
        'question_3',
        'question_4',
        'law',
        'question_5',
        'question_6',
        'training_type',
        'other_training_type',
        'strategic_axis_id',
        'impact_objective_id',
        'mechanism',
        'places',

        // TIPO ONLINE
        'online_type_mechanism',

        // TIPO PRESENCIAL
        'coffee_break',
        'coffee_break_price',

        // TIPO ONLINE ASINCRONICO 
        'exists',
        'digital_capsule',

        'transport',
        'transport_price',
        'accommodation',
        'accommodation_price'
    ];

    /**
     * Get the user that owns the identify need.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
       return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Get the organizational unit that created the identify need.
     *
     * @return BelongsTo
     */
    public function organizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class, 'ou_creator_id')->withTrashed();
    }

    /**
     * Get the boss of the user who owns the identification need.
     *
     * @return BelongsTo
     */
    public function boss(): BelongsTo
    {
       return $this->belongsTo(User::class, 'boss_id')->withTrashed();
    }

    /**
     * Get the estament that owns the identify need.
     *
     * @return BelongsTo
     */
    public function estament(): BelongsTo
    {
        return $this->belongsTo(Estament::class);
    }

    /**
     * Get the estament that owns the identify need.
     *
     * @return BelongsTo
     */
    public function strategicAxis(): BelongsTo 
    {
        return $this->belongsTo(StrategicAxis::class);
    }

    /**
     * Define eventos del modelo.
     */
    protected static function booted()
    {
        static::saving(function ($model) {
            // Convierte el array a JSON si es un array
            if (is_array($model->nature_of_the_need)) {
                $model->nature_of_the_need = json_encode($model->nature_of_the_need);
            }
        });
    }

    public function getNatureOfTheNeedAttribute($value)
    {
        return json_decode($value, true); // Convierte el string JSON en un array
    }

    public function setNatureOfTheNeedAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['nature_of_the_need'] = json_encode($value); // Serializa el array a JSON
        } elseif (is_string($value)) {
            $this->attributes['nature_of_the_need'] = $value; // Si ya es un JSON, lo guarda tal cual
        }
    }

    protected $casts = [
        'created_at' => 'datetime'
    ];

    protected $table = 'dnc_identify_needs';
}
