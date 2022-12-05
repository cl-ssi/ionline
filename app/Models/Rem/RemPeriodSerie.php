<?php

namespace App\Models\Rem;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RemPeriodSerie extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'period_id',
        'serie_id',
        'month',
    ];

    public function serie(){
        return $this->belongsTo('App\Models\Rem\RemSerie','serie_id');
      }

      public function period(){
        return $this->belongsTo('App\Models\Rem\RemPeriod','period_id');
      }
}
