<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;


class StaffDecreeByEstament extends Model implements Auditable
{
    use HasFactory;
    use softDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'estament_id', 'start_degree', 'end_degree', 'description', 'staff_decree_id'
    ];

    public function staffDecree()
    {
        return $this->belongsTo(StaffDecree::class);
    }

    protected $table = 'cfg_staff_decree_by_estaments';
}
