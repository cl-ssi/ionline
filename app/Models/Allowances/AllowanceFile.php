<?php

namespace App\Models\Allowances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class AllowanceFile extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name', 'file'
    ];

    public function user() {
        return $this->belongsTo('App\User', 'user_id')->withTrashed();
    }

    public function allowance() {
        return $this->belongsTo('App\Models\Allowances\Allowance', 'allowance_id');
    }

    protected $table = 'alw_allowance_files';
}
