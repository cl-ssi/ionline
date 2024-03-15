<?php

namespace App\Models\Welfare\Benefits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Welfare\Benefits\Subsidy;

class Benefit extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'well_bnf_benefits';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'observation'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */    

    // protected $casts = [
    //     'fecha_inicio' => 'date:Y-m-d',
    //     'fecha_termino' => 'date:Y-m-d',
    //     'fecha_termino_2' => 'date:Y-m-d',
    // ];

    public function subsidies(): HasMany
    {
        return $this->hasMany(Subsidy::class);
    }
}
