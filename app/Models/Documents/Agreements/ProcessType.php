<?php

namespace App\Models\Documents\Agreements;

use App\Models\Documents\Template;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcessType extends Model
{
    use SoftDeletes;
    
    protected $table = 'agr_process_types';

    protected $fillable = [
        'name',
        'description',
        'revision_commune',
        'sign_commune',
        'is_dependent',
        'father_process_type_id',
        'is_resolution',
        'is_certificate',
        'active',
    ];

    protected $casts = [
        'revision_commune' => 'boolean',
        'sign_commune'   => 'boolean',
        'is_dependent'   => 'boolean',
        'is_resolution'  => 'boolean',
        'active'         => 'boolean',
        'is_certificate' => 'boolean',
    ];

    public function fatherProcessType(): BelongsTo
    {
        return $this->belongsTo(ProcessType::class);
    }

    public function childsProcessType(): HasMany
    {
        return $this->hasMany(ProcessType::class, 'father_process_type_id', 'id');
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
