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
        'id',
        'name',
        'code_deis',
        'region_id'
    ];

    protected $dates = ['deleted_at'];

    protected $table = 'cl_communes';

    public function region()
    {
        return $this->belongsTo(ClRegion::class);
    }
}
