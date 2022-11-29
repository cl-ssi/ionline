<?php

namespace App\Models\Rem;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemPeriodSerie extends Model
{
    use HasFactory;

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
