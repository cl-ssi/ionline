<?php

namespace App\Models\Documents\Agreements;

use App\Models\ClCommune;
use App\Models\Parameters\Mayor;
use App\Models\Parameters\Municipality;
use App\Observers\Documents\Agreements\ProcessObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Parameters\Program;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([ProcessObserver::class])]
class Process extends Model
{
    use SoftDeletes;

    protected $table = 'agr_processes';

    protected $fillable = [
        'program_id',
        'period',
        'process_type_id',
        'commune_id',
        'total_amount',
        'number',
        'date',
        'establishments',
        'quotas',
        'signer_id',
        'signer_appellative',
        'signer_decree',
        'signer_name',
        'municipality_id',
        'municipality_name',
        'municipality_rut',
        'municipality_adress',
        'mayor_id',
        'mayor_name',
        'mayor_run',
        'mayor_appelative',
        'mayor_decree',
        'process_id',
    ];

    protected $casts = [
        'date' => 'date',
        'establishments' => 'array',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function processType(): BelongsTo
    {
        return $this->belongsTo(ProcessType::class, 'process_type_id');
    }

    public function commune(): BelongsTo
    {
        return $this->belongsTo(ClCommune::class, 'commune_id');
    }

    public function signer(): BelongsTo
    {
        return $this->belongsTo(Signer::class, 'signer_id');
    }

    public function municipality(): BelongsTo
    {
        return $this->belongsTo(Municipality::class, 'municipality_id');
    }

    public function mayor(): BelongsTo
    {
        return $this->belongsTo(Mayor::class, 'mayor_id');
    }

    public function process(): BelongsTo
    {
        return $this->belongsTo(Process::class, 'process_id');
    }

    public function processes(): HasMany
    {
        return $this->hasMany(Process::class, 'process_id');
    }

}