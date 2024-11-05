<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alcalde extends Model
{
    protected $table = 'cfg_alcaldes';

    protected $fillable = [
        'appellative',
        'name',
        'run',
        'decree',
        'municipality_id'
    ];

    public function municipality(): BelongsTo  
    {
        return $this->belongsTo(Municipality::class);
    }
}
