<?php

namespace App\Models\ProfAgenda;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class ExternalUser extends Model implements AuditableContract
{
    use HasFactory, SoftDeletes, Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'prof_agenda_external_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'dv',
        'name',
        'fathers_family',
        'mothers_family',
        'gender',
        'email',
        'address',
        'phone_number',
        'birthday',
        'active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'birthday' => 'date',
    ];

    /**
     * Get the open hours associated with the external user.
     *
     * @return HasMany
     */
    public function openHours(): HasMany
    {
        return $this->hasMany(OpenHour::class);
    }

    /**
     * Get the short name attribute for the external user.
     *
     * @return string
     */
    public function getShortNameAttribute(): string
    {
        return implode(' ', [
            $this->name,
            mb_convert_case($this->fathers_family, MB_CASE_TITLE, 'UTF-8'),
            mb_convert_case($this->mothers_family, MB_CASE_TITLE, 'UTF-8')
        ]);
    }

    /**
     * Get the gender description for the external user.
     *
     * @return string
     */
    public function getGender(): string
    {
        if (is_null($this->gender)) {
            return "";
        } else {
            return match($this->gender) {
                "male" => "Masculino",
                "female" => "Femenino",
                default => "Otro",
            };
        }
    }
}
