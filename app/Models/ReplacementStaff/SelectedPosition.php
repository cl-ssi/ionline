<?php

namespace App\Models\ReplacementStaff;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class SelectedPosition extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'position_id', 'run', 'dv', 'name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $table = 'rst_selected_positions';
}
