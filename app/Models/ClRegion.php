<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\HealthService;

class ClRegion extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id','name'
    ];
    
    protected $dates = ['deleted_at'];
    
    protected $table = 'cl_regions';

    public function healthServices()
    {
        return $this->hasMany(HealthService::class);
    }

    /* TODO: fixear, dejar sólo una tabla comunas */
    public function communes() {
        return $this->hasMany('\App\Models\Parameters\Commune');
    }
}
