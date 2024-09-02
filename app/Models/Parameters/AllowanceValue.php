<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class AllowanceValue extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use softDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'cfg_allowance_values';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'level',
        'description',
        'value',
        'year',
    ];
}
