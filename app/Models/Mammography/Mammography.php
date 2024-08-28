<?php

namespace App\Models\Mammography;

use App\Models\Establishment;
use App\Models\Rrhh\OrganizationalUnit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Mammography extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mammographies';

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
        'exam_date',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'arrival_at' => 'datetime',
        'dome_at' => 'datetime',
        'exam_date' => 'datetime',
    ];

    /**
     * Get the establishment that owns the place.
     *
     * @return BelongsTo
     */
    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    /**
     * Get the organizational unit that owns the document.
     *
     * @return BelongsTo
     */
    public function organizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class);
    }

    /**
     * Get the full name of the person.
     *
     * @return string
     */
    public function fullName(): string
    {
        return $this->name . ' ' . $this->fathers_family . ' ' . $this->mothers_family;
    }

    /**
     * Scope a query to search by name, father's family, mother's family, or run.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $search
     * @return void
     */
    public function scopeSearch($query, $search): void
    {
        if ($search) {
            $array_search = explode(' ', $search);
            foreach ($array_search as $word) {
                $query->where(function ($query) use ($word) {
                    $query->where('name', 'LIKE', '%' . $word . '%')
                        ->orWhere('fathers_family', 'LIKE', '%' . $word . '%')
                        ->orWhere('mothers_family', 'LIKE', '%' . $word . '%')
                        ->orWhere('run', 'LIKE', '%' . $word . '%');
                });
            }
        }
    }

    /**
     * Get the alias of the establishment.
     *
     * @return string
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
     * Get the alias of the inform method.
     *
     * @return string
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
     *
     * @return string
     */
    public function getRunFormatAttribute(): string
    {
        return $this->run . '-' . $this->dv;
    }
}