<?php

namespace App\Models\JobPositionProfiles;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;


class Competency extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'description',
        'active_from',
        'active_to'
    ];

    public function scopeActive($query, $created_at)
    {
        if(Competency::latest()->first()->active_to == null){  
            return $query->whereDate('active_from', '<=', $created_at)
                ->where(function ($q) use ($created_at) {
                    $q->whereDate('active_to', '>=', $created_at)
                        ->orWhereNull('active_to'); // Permite registros sin fecha de término
                    });
                }
        else{
            return $query->whereDate('active_from', '<=', $created_at)
                ->whereDate('active_to', '>=', $created_at);
        }
    }

    protected $table = 'jpp_competencies';
}
