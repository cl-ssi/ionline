<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mayor extends Model
{
    protected $table = 'cfg_mayors';

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
