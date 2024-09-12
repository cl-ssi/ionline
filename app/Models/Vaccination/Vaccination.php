<?php

namespace App\Models\Vaccination;

use App\Models\Establishment;
use App\Models\Rrhh\OrganizationalUnit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Vaccination extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'run',
        'dv',
        'name',
        'fathers_family',
        'mothers_family',
        'email',
        'personal_email',
        'establishment_id',
        'organizational_unit_id',
        'organizationalUnit',
        'inform_method',
        'arrival_at',
        'dome_at',
        'first_dose',
        'first_dose_at',
        'second_dose',
        'second_dose_at',
        'fd_observation',
        'sd_observation',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'arrival_at'     => 'datetime',
        'dome_at'        => 'datetime',
        'first_dose'     => 'datetime',
        'second_dose'    => 'datetime',
        'first_dose_at'  => 'datetime',
        'second_dose_at' => 'datetime',
    ];

    /**
     * Get the establishment that owns the vaccination.
     */
    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    /**
     * Get the organizational unit that owns the vaccination.
     */
    public function organizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class);
    }

    /**
     * Get the full name of the person.
     */
    public function fullName(): string
    {
        return $this->name.' '.$this->fathers_family.' '.$this->mothers_family;
    }

    /**
     * Scope a query to search for a specific term.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $search
     * @return void
     */
    public function scopeSearch($query, $search)
    {
        if ($search) {
            $array_search = explode(' ', $search);
            foreach ($array_search as $word) {
                $query->where(function ($query) use ($word) {
                    $query->where('name', 'LIKE', '%'.$word.'%')
                        ->orWhere('fathers_family', 'LIKE', '%'.$word.'%')
                        ->orWhere('mothers_family', 'LIKE', '%'.$word.'%')
                        ->orWhere('run', 'LIKE', '%'.$word.'%');
                });
            }
        }
    }

    /**
     * Get the alias for the establishment.
     */
    public function getAliasEstabAttribute(): string
    {
        switch ($this->establishment_id) {
            case 1:
                return 'HETG';
            case 38:
                return 'DSSI';
            default:
                return '';
        }
    }

    /**
     * Get the alias for the inform method.
     */
    public function getAliasInformMethodAttribute(): string
    {
        switch ($this->inform_method) {
            case 1:
                return 'Clave Única';
            case 2:
                return 'Teléfono';
            case 3:
                return 'Correo';
            default:
                return '';
        }
    }

    /**
     * Get the formatted run.
     */
    public function getRunFormatAttribute(): string
    {
        return $this->run.'-'.$this->dv;
    }
}
