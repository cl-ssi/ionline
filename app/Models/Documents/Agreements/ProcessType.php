<?php

namespace App\Models\Documents\Agreements;

use App\Models\Documents\Template;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class ProcessType extends Model
{
    protected $table = 'agr_process_types';

    protected $fillable = [
        'name',
        'description',
        'is_dependent',
        'has_resolution',
        'active',
    ];

    protected $casts = [
        'is_dependent'   => 'boolean',
        'has_resolution' => 'boolean',
        'active'         => 'boolean',
    ];

    public function processes(): HasMany
    {
        return $this->hasMany(Process::class);
    }

    public function template(): MorphOne
    {
        return $this->morphOne(Template::class, 'templateable');
    }
}
