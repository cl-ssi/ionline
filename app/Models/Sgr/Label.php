<?php

namespace App\Models\Sgr;

use App\Models\User;
use App\Models\Rrhh\OrganizationalUnit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Label extends Model
{
    use HasFactory;
    protected $table = 'sgr_labels';
    
    protected $fillable = [
        'name',
        'color',
        'user_id',
        'organizational_unit_id',
    ];

    // relaciones

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function organizationalUnit(): BelongsTo {
        return $this->belongsTo(OrganizationalUnit::class);
    }
}
