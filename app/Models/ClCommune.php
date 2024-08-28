<?php

namespace App\Models;

use App\Models\ClLocality;
use App\Models\ClRegion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClCommune extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cl_communes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'code_deis',
        'region_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // Add any date attributes here if needed
    ];

    /**
     * Get the region that owns the commune.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(ClRegion::class);
    }

    /**
     * Get the localities for the commune.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function localities(): HasMany
    {
        return $this->hasMany(ClLocality::class, 'commune_id');
    }

    /**
     * Get communes by search text.
     *
     * @param string $searchText
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function getCommunesBySearch(string $searchText)
    {
        $communes = ClCommune::query();
        $array_search = explode(' ', $searchText);
        foreach ($array_search as $word) {
            $communes->where(function ($q) use ($word) {
                $q->where('name', 'LIKE', '%' . $word . '%');
            });
        }

        return $communes;
    }
}