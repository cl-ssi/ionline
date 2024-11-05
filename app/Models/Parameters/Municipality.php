<?php

namespace App\Models\Parameters;

use App\Models\ClCommune;
use App\Models\Commune;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Municipality extends Model
{
    /** Cambio a nueva tabla pendiente */
    // protected $table = 'cfg_municipalities';

    // protected $fillable = [
    //     'name',
    //     'rut',
    //     'address',
    //     'emails',
    //     'commune_id'
    // ];

    // protected $casts = [
    //     'emails' => 'array'
    // ];

    // public function commune(): BelongsTo
    // {
    //     return $this->belongsTo(ClCommune::class);
    // }

    protected $fillable = [
        'name',
        'name_municipality',
        'rut_municipality',
        'adress_municipality',
        'appellative_representative',
        'decree_representative',
        'name_representative',
        'rut_representative',
        'name_representative_surrogate',
        'rut_representative_surrogate', 
        'decree_representative_surrogate',
        'email_municipality',
        'email_municipality_2',
        'appellative_representative_surrogate'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function commune(): BelongsTo
    {
        return $this->belongsTo(Commune::class);
    }
}
