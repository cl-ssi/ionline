<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Treasury extends Model
{
    protected $table = 'fin_treasuries';

    protected $fillable = [
        'name',
        'treasureable_type',
        'treasureable_id',
    ];

    public function treasureable(): MorphTo
    {
        return $this->morphTo();
    }
}
