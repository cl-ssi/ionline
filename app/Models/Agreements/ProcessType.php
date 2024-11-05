<?php

namespace App\Models\Agreements;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProcessType extends Model
{
    protected $table = 'agr_process_types';

    protected $fillable = [
        'name',
        'description',
        'template',
        'is_dependent',
        'has_resolution',
    ];

    protected $casts = [
        'is_dependent' => 'boolean',
        'has_resolution' => 'boolean',
    ];

    // public function processes(): HasMany
    // {
    //     return $this->hasMany(Process::class);
    // }
}
