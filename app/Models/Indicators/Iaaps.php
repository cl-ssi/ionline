<?php

namespace App\Models\Indicators;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iaaps extends Model
{
    use HasFactory;

    protected $table = 'ind_iaaps';
    protected $fillable = ['name', 'year', 'establishment_cods', 'communes'];

    public function indicators()
    {
        return $this->morphMany(Indicator::class, 'indicatorable');
    }
}
