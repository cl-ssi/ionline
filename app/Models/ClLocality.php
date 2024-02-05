<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClLocality extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'commune_id'
    ];

    public function commune() {
        return $this->belongsTo('App\Models\ClCommune', 'commune_id');
    }

    protected $dates = ['deleted_at'];

    protected $table = 'cl_localities';
}
