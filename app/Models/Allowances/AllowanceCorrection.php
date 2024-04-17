<?php

namespace App\Models\Allowances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class AllowanceCorrection extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'description', 'allowance_id', 'user_id'
    ];

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id')->withTrashed();
    }

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table = 'alw_allowance_corrections';
}
