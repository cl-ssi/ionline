<?php

namespace App\Models\Indicators;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HealthGoal extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'ind_health_goals';
    protected $fillable = ['law', 'name', 'year'];

    public function indicators()
    {
        return $this->morphMany(Indicator::class, 'indicatorable');
    }

    public function getCompliance()
    {
        $total = 0;
        foreach($this->indicators as $indicator) $total += $indicator->getContribution();
        return $total;
    }
}
