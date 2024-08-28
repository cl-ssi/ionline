<?php

namespace App\Models\JobPositionProfiles;

use App\Models\Documents\Approval;
use App\Models\Parameters\Area;
use App\Models\Parameters\ContractualCondition;
use App\Models\Parameters\Estament;
use App\Models\Parameters\StaffDecreeByEstament;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class JobPositionProfile extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jpp_job_position_profiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'charges_number',
        'degree',
        'subordinates',
        'salary',
        'law',
        'dfl3',
        'dfl29',
        'other_legal_framework',
        'working_day',
        'specific_requirement',
        'training',
        'experience',
        'technical_competence',
        'objective',
        'working_team',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get the user that owns the job position profile.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_creator_id')->withTrashed();
    }

    /**
     * Get the organizational unit that created the job position profile.
     *
     * @return BelongsTo
     */
    public function creatorOrganizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class, 'ou_creator_id')->withTrashed();
    }

    /**
     * Get the organizational unit that owns the job position profile.
     *
     * @return BelongsTo
     */
    public function organizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class, 'jpp_ou_id')->withTrashed();
    }

    /**
     * Get the estament that owns the job position profile.
     *
     * @return BelongsTo
     */
    public function estament(): BelongsTo
    {
        return $this->belongsTo(Estament::class);
    }

    /**
     * Get the area that owns the job position profile.
     *
     * @return BelongsTo
     */
    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    /**
     * Get the contractual condition that owns the job position profile.
     *
     * @return BelongsTo
     */
    public function contractualCondition(): BelongsTo
    {
        return $this->belongsTo(ContractualCondition::class);
    }

    /**
     * Get the staff decree by estament that owns the job position profile.
     *
     * @return BelongsTo
     */
    public function staffDecreeByEstament(): BelongsTo
    {
        return $this->belongsTo(StaffDecreeByEstament::class, 'staff_decree_by_estament_id');
    }

    /**
     * Get the roles for the job position profile.
     *
     * @return HasMany
     */
    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }

    /**
     * Get the liabilities for the job position profile.
     *
     * @return HasMany
     */
    public function jppLiabilities(): HasMany
    {
        return $this->hasMany(JobPositionProfileLiability::class, 'job_position_profile_id');
    }

    /**
     * Get the expertises for the job position profile.
     *
     * @return HasMany
     */
    public function jppExpertises(): HasMany
    {
        return $this->hasMany(ExpertiseProfile::class, 'job_position_profile_id');
    }

    /**
     * Get the signs for the job position profile.
     *
     * @return HasMany
     */
    public function jobPositionProfileSigns(): HasMany
    {
        return $this->hasMany(JobPositionProfileSign::class);
    }

    /**
     * Get all of the job position profile's approvals.
     *
     * @return MorphMany
     */
    public function approvals(): MorphMany
    {
        return $this->morphMany(Approval::class, 'approvable');
    }

    /**
     * Get all of the trashed approvals for the job position profile.
     *
     * @return MorphMany
     */
    public function trashedApprovals(): MorphMany
    {
        return $this->morphMany(Approval::class, 'approvable')->withTrashed()->where('status', 0);
    }

    /**
     * Get the status value attribute.
     *
     * @return string
     */
    public function getStatusValueAttribute(): string
    {
        switch ($this->status) {
            case 'saved':
                return 'Guardado';
            case 'sent':
                return 'Enviado';
            case 'review':
                return 'En revisión';
            case 'pending':
                return 'Pendiente';
            case 'rejected':
                return 'Rechazado';
            case 'complete':
                return 'Finalizado';
            default:
                return '';
        }
    }

    /**
     * Get the subordinates value attribute.
     *
     * @return string
     */
    public function getSubordinatesValueAttribute(): string
    {
        switch ($this->subordinates) {
            case '0':
                return 'No';
            case '1':
                return 'Sí';
            default:
                return '';
        }
    }

    /**
     * Get the law value attribute.
     *
     * @return string
     */
    public function getLawValueAttribute(): string
    {
        switch ($this->law) {
            case '18834':
                return 'Ley N°18.834';
            case '19664':
                return 'Ley N°19.664';
            default:
                return '';
        }
    }

    /**
     * Get the DFL 3 value attribute.
     *
     * @return string
     */
    public function getDfl3ValueAttribute(): string
    {
        switch ($this->dfl3) {
            case '0':
                return '';
            case '1':
                return 'DFL N°03/17';
            default:
                return '';
        }
    }

    /**
     * Get the DFL 29 value attribute.
     *
     * @return string
     */
    public function getDfl29ValueAttribute(): string
    {
        switch ($this->dfl29) {
            case '0':
                return '';
            case '1':
                return 'DFL N°29 (Estatuto Administrativo)';
            default:
                return '';
        }
    }

    /**
     * Get the other legal framework value attribute.
     *
     * @return string
     */
    public function getOtherLegalFrameworkValueAttribute(): string
    {
        switch ($this->other_legal_framework) {
            case '0':
                return '';
            case '1':
                return 'Otros (Ley N° 15.076) Urgencia 28 hrs.';
            default:
                return '';
        }
    }

    /**
     * Scope a query to search by various criteria.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $status_search
     * @param string|null $estament_search
     * @param string|null $id_search
     * @param string|null $name_search
     * @param string|null $user_creator_search
     * @param array|null $sub_search
     * @return void
     */
    public function scopeSearch($query, $status_search, $estament_search, $id_search, $name_search, $user_creator_search, $sub_search): void
    {
        if ($status_search || $estament_search || $id_search || $name_search || $user_creator_search || $sub_search) {
            if ($status_search != '') {
                $query->where('status', $status_search);
            }
            if ($estament_search != '') {
                $query->where('estament_id', $estament_search);
            }
            if ($id_search != '') {
                $query->where('id', $id_search);
            }
            if ($name_search != '') {
                $query->where('name', 'LIKE', '%' . $name_search . '%');
            }
            $array_user_creator_search = explode(' ', $user_creator_search);
            foreach ($array_user_creator_search as $word) {
                $query->whereHas('user', function ($query) use ($word) {
                    $query->where('name', 'LIKE', '%' . $word . '%')
                        ->orWhere('fathers_family', 'LIKE', '%' . $word . '%')
                        ->orWhere('mothers_family', 'LIKE', '%' . $word . '%');
                });
            }
            if (!empty($sub_search)) {
                $query->whereIn('jpp_ou_id', $sub_search);
            }
        }
    }
}