<?php

namespace App\Models\Requirements;

use App\Rrhh\OrganizationalUnit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Label extends Model
{
    use HasFactory;
    protected $table = 'req_labels';
    
    protected $fillable = [
        'name',
        'color',
        'user_id',
    ];
    
    public function organizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class, 'ou_id');
    }
}
