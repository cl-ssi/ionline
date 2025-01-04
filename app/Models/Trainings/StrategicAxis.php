<?php

namespace App\Models\Trainings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Relations\hasMany;
use App\Models\Trainings\ImpactObjective;

class StrategicAxis extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'number', 
        'name', 
        'description'
    ];

    /**
     * Get the documents for the user.
     */
    public function impactObjectives(): HasMany
    {
        return $this->hasMany(ImpactObjective::class, 'strategic_axis_id');
    }

    protected $table = 'tng_strategic_axes';
}
