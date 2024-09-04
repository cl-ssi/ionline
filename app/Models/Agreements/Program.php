<?php

namespace App\Models\Agreements;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'agr_programs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
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
     * Get all of the agreements for the Program.
     */
    public function agreements(): HasMany
    {
        return $this->hasMany(Agreement::class);
    }

    /**
     * Get all of the resolutions for the Program.
     */
    public function resolutions(): HasMany
    {
        return $this->hasMany(ProgramResolution::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get all of the quotas_minsal for the Program.
     */
    public function quotas_minsal(): HasMany
    {
        return $this->hasMany(ProgramQuotaMinsal::class);
    }

    /**
     * Get all of the budget_availabilities for the Program.
     */
    public function budget_availabilities(): HasMany
    {
        return $this->hasMany(BudgetAvailability::class);
    }

    /**
     * Get all of the components for the Program.
     */
    public function components(): HasMany
    {
        return $this->hasMany(ProgramComponent::class);
    }
}
