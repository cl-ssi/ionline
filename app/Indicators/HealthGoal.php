<?php

namespace App\Indicators;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthGoal extends Model
{
    use HasFactory;

    protected $table = 'ind_health_goals';
    protected $fillable = ['law', 'name', 'year'];

    public function indicators()
    {
        return $this->morphMany('App\Indicators\Indicator', 'indicatorable');
    }

    public function getCompliance()
    {
        $total = 0;
        foreach($this->indicators as $indicator) $total += $indicator->getContribution();
        return $total;
    }
}
