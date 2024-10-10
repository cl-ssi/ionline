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
}
