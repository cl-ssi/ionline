<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClCommune extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id','name','code_deis','region_id'
    ];

    public function region() {
        return $this->belongsTo('\App\Models\Parameters\ClRegion');
    }

    protected $dates = ['deleted_at'];

    protected $table = 'cl_communes';
}
