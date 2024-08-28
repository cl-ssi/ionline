<?php

namespace App\Models\ReplacementStaff;

use App\Models\ClCommune;
use App\Models\ClRegion;
use App\Models\ReplacementStaff\Applicant;
use App\Models\ReplacementStaff\Experience;
use App\Models\ReplacementStaff\Language;
use App\Models\ReplacementStaff\Profile;
use App\Models\ReplacementStaff\StaffManage;
use App\Models\ReplacementStaff\Training;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ReplacementStaff extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rst_replacement_staff';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'run',
        'dv',
        'birthday',
        'name',
        'fathers_family',
        'mothers_family',
        'gender',
        'email',
        'telephone',
        'telephone2',
        'region_id',
        'commune_id',
        'address',
        'observations',
        'status',
        'cv_file'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'birthday' => 'date'
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
     * Get the region that owns the replacement staff.
     *
     * @return BelongsTo
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(ClRegion::class);
    }

    /**
     * Get the commune that owns the replacement staff.
     *
     * @return BelongsTo
     */
    public function clCommune(): BelongsTo
    {
        return $this->belongsTo(ClCommune::class, 'commune_id');
    }

    /**
     * Get the profiles for the replacement staff.
     *
     * @return HasMany
     */
    public function profiles(): HasMany
    {
        return $this->hasMany(Profile::class);
    }

    /**
     * Get the experiences for the replacement staff.
     *
     * @return HasMany
     */
    public function experiences(): HasMany
    {
        return $this->hasMany(Experience::class);
    }

    /**
     * Get the trainings for the replacement staff.
     *
     * @return HasMany
     */
    public function trainings(): HasMany
    {
        return $this->hasMany(Training::class);
    }

    /**
     * Get the languages for the replacement staff.
     *
     * @return HasMany
     */
    public function languages(): HasMany
    {
        return $this->hasMany(Language::class);
    }

    /**
     * Get the applicants for the replacement staff.
     *
     * @return HasMany
     */
    public function applicants(): HasMany
    {
        return $this->hasMany(Applicant::class);
    }

    /**
     * Get the staff manages for the replacement staff.
     *
     * @return HasMany
     */
    public function staffManages(): HasMany
    {
        return $this->hasMany(StaffManage::class);
    }

    /**
     * Get the full name attribute.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->name . ' ' . $this->fathers_family . ' ' . $this->mothers_family;
    }

    /**
     * Get the identifier attribute.
     *
     * @return string
     */
    public function getIdentifierAttribute(): string
    {
        return strtoupper("{$this->run}-{$this->dv}");
    }

    /**
     * Get the status value attribute.
     *
     * @return string
     */
    public function getStatusValueAttribute(): string
    {
        switch ($this->status) {
            case 'immediate_availability':
                return 'Disponibilidad Inmediata';
            case 'working_external':
                return 'Trabajando';
            case 'selected':
                return 'Seleccionado';
            default:
                return '';
        }
    }

    /**
     * Get the gender value attribute.
     *
     * @return string
     */
    public function getGenderValueAttribute(): string
    {
        switch ($this->gender) {
            case 'male':
                return 'Masculino';
            case 'female':
                return 'Femenino';
            case 'other':
                return 'Otro';
            case 'unknown':
                return 'Desconocido';
            default:
                return '';
        }
    }

    /**
     * Scope a query to search replacement staff.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $search
     * @param int $profile_search
     * @param int $profession_search
     * @param int $staff_search
     * @param string $status_search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $search, $profile_search, $profession_search, $staff_search, $status_search)
    {
        if ($search || $profile_search || $profession_search || $staff_search || $status_search) {
            $array_name_search = explode(' ', $search);
            foreach ($array_name_search as $word) {
                $query->where(function ($query) use ($word) {
                    $query->where('name', 'LIKE', '%' . $word . '%')
                        ->orWhere('fathers_family', 'LIKE', '%' . $word . '%')
                        ->orWhere('mothers_family', 'LIKE', '%' . $word . '%')
                        ->orWhere('run', 'LIKE', '%' . $word . '%');
                });
            }

            if ($profile_search != 0) {
                $query->whereHas('profiles', function ($q) use ($profile_search) {
                    $q->where('profile_manage_id', $profile_search);
                });
            }

            if ($profession_search != 0) {
                $query->whereHas('profiles', function ($q) use ($profession_search) {
                    $q->where('profession_manage_id', $profession_search);
                });
            }

            if ($staff_search != 0) {
                $query->whereHas('staffManages', function ($q) use ($staff_search) {
                    $q->where('organizational_unit_id', $staff_search);
                });
            }

            if ($status_search != "0") {
                $query->where(function ($q) use ($status_search) {
                    $q->where('status', $status_search);
                });
            }
        }
    }
}