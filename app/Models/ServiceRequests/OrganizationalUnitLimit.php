<?php

namespace App\Models\ServiceRequests;

use App\Models\Establishment;
use App\Models\Rrhh\OrganizationalUnit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrganizationalUnitLimit extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'doc_organizational_unit_limits';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 
        // 'establishment_id', 
        'organizational_unit_id', 'max_value'
    ];

    // public function establishment(): BelongsTo 
    // {
    //     return $this->belongsTo(Establishment::class);
    // }

    public function organizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class);
    }
}
