<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClRegion extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id','name'
    ];

    public function communes() {
  		  return $this->hasMany('\App\Models\Parameters\Commune');
    }

    protected $dates = ['deleted_at'];

    protected $table = 'cl_regions';

}
