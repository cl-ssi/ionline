<?php

namespace App\Models\Agreements;

use App\Models\ClCommune;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Parameters\Program;
use Illuminate\Database\Eloquent\SoftDeletes;

class Process extends Model
{
    use SoftDeletes;

    protected $table = 'agr_processes';

    protected $fillable = [
        'process_id',
        'period',
        'program_id',
        'commune_id',
        'establishment_id',
        'quotas',
        'total_amount',
        'signer_id',
        'representative',
        'representative_rut',
        'representative_appelative',
        'representative_decree',
        'municipality_adress',
        'municipality_rut',
        'number',
        'date',
        'establishment_list',
        'process_type_id',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function commune(): BelongsTo
    {
        return $this->belongsTo(ClCommune::class, 'commune_id');
    }

    public function signer(): BelongsTo
    {
        return $this->belongsTo(Signer::class, 'signer_id');
    }

    public function process(): BelongsTo
    {
        return $this->belongsTo(Process::class, 'process_id');
    }

    public function processes()
    {
        return $this->hasMany(Process::class, 'process_id');
    }

}
