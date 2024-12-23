<?php

namespace App\Models\Documents\Agreements;

use App\Models\Documents\Template;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class ProcessType extends Model
{
    protected $table = 'agr_process_types';

    protected $fillable = [
        'name',
        'description',
        'bilateral',
        'is_dependent',
        'father_process_type_id',
        'has_resolution',
        'active',
    ];

    protected $casts = [
        'bilateral'      => 'boolean',
        'is_dependent'   => 'boolean',
        'has_resolution' => 'boolean',
        'active'         => 'boolean',
    ];

    public function fatherProcessType(): BelongsTo
    {
        return $this->belongsTo(ProcessType::class);
    }

    public function childProcessType(): HasOne
    {
        return $this->hasOne(ProcessType::class,'father_process_type_id');
    }

    public function processes(): HasMany
    {
        return $this->hasMany(Process::class);
    }

    public function template(): MorphOne
    {
        return $this->morphOne(Template::class, 'templateable');
    }
}
