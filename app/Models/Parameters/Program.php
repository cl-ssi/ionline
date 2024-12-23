<?php

namespace App\Models\Parameters;

use App\Models\Agreements\BudgetAvailability;
use App\Models\Documents\Agreements\Cdp;
use App\Models\Documents\Agreements\Process;
use App\Models\Establishment;
use App\Models\File;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Program extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cfg_programs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'alias',
        'alias_finance',
        'financial_type',
        'folio',
        'subtitle_id',
        'budget',
        'period',
        'start_date',
        'end_date',
        'description',
        'is_program',
        'ministerial_resolution_number',
        'ministerial_resolution_date',
        'ministerial_resolution_file',
        'resource_distribution_number',
        'resource_distribution_date',
        'resource_distribution_file',
        'establishment_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'ministerial_resolution_date' => 'date',
        'resource_distribution_date' => 'date',
        'is_program' => 'boolean',
    ];

    /**
     * The referers that belong to the program.
     */
    public function referers(): BelongsToMany|Builder
    {
        return $this->belongsToMany(User::class, 'cfg_program_user')->withTrashed();
    }

    public function cdps(): HasMany
    {
        return $this->hasMany(Cdp::class);
    }

    /**
     * Get the components for the program.
     */
    public function components(): HasMany
    {
        return $this->hasMany(ProgramComponent::class);
    }

    public function processes(): HasMany
    {
        return $this->hasMany(Process::class);
    }

    /**
     * Get all of the budgetAvailabilities for the Program.
     */
    public function budgetAvailabilities(): HasMany
    {
        return $this->hasMany(BudgetAvailability::class);
    }

    /**
     * Get the establishment that owns the program.
     */
    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    /**
     * // FIXME: pasar a minusculas
     * Get the subtitle that owns the program.
     */
    public function Subtitle(): BelongsTo
    {
        return $this->belongsTo(Subtitle::class);
    }

    // FIXME: pasar a minusculas
    /**
     * Get the budgets for the program.
     */
    public function Budgets(): HasMany
    {
        return $this->hasMany(ProgramBudget::class);
    }


    /**
     * Get the formatted start date attribute.
     */
    public function getStartDateFormatAttribute(): string
    {
        return $this->start_date ? $this->start_date->format('Y-m-d') : '-';
    }

    /**
     * Get the formatted end date attribute.
     */
    public function getEndDateFormatAttribute(): string
    {
        return $this->end_date ? $this->end_date->format('Y-m-d') : '-';
    }

    /**
     * Get the financing attribute.
     */
    public function getFinancingAttribute(): string
    {
        return strtolower($this->financial_type) != 'extrapresupuestario' ? 'Presupuestario' : 'Extrapresupuestario';
    }

    /**
     * Scope a query to only include valid programs.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOnlyValid($query)
    {
        return $query->whereIn('period', [now()->year, now()->year - 1]);
    }

    /**
     * Get programs by search text.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function getProgramsBySearch(string $searchText)
    {
        $programs = Program::query();
        $array_search = explode(' ', $searchText);
        foreach ($array_search as $word) {
            $programs->where(function ($q) use ($word) {
                $q->where('name', 'LIKE', '%'.$word.'%');
            });
        }

        return $programs;
    }
}
