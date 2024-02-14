<?php

namespace App\Models\Welfare\Amipass;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class PendingAmount extends Model implements Auditable
{
    use HasFactory;
    // use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'well_pending_amounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'year', 'month','user_id','amount','consolidated_amount'
    ];

}
