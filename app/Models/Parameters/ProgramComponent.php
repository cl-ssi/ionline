<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramComponent extends Model
{
    protected $table = 'agr_program_components';

    protected $fillable = [
        'name',
        'program_id',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }
}
