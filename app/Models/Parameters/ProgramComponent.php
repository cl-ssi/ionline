<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramComponent extends Model
{
    protected $table = 'cfg_program_components';

    protected $fillable = [
        'name',
        'program_id',
        'subtitle_id',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function subtitle(): BelongsTo
    {
        return $this->belongsTo(Subtitle::class);
    }
}
