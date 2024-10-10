<?php

namespace App\Models\Indicators;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Aps extends Model
{
    use HasFactory;

    protected $table = 'ind_aps';

    protected $fillable = [
        'year',
        'number',
        'name',
        'slug',
    ];

    public function indicators(): MorphMany
    {
        return $this->morphMany(Indicator::class, 'indicatorable');
    }

    /**
     * Obtiene un listado de años distintos registrados en la tabla.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getDistinctYears()
    {
        return self::select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
    }
}
