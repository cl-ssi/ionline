<?php

namespace App\Models\Rem;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Rem\RemPeriodSerie;

class RemPeriod extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'rem_periods';

    protected $fillable = [
        'period',
        'year',
        'month',
    ];

    protected $casts = [
        'period' => 'date',
    ];


    public function series()
    {
        return $this->hasMany(RemPeriodSerie::class, 'period_id', 'id');
        
    }
    

    
    
}
