<?php

namespace App\Models\Parameters;

use App\Models\ClCommune;
use App\Models\ClRegion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'run', 'dv', 'name', 'address', 'region_id', 'commune_id', 'telephone'
    ];

    protected $table = 'cfg_suppliers';

    public function region()
    {
        return $this->belongsTo(ClRegion::class);
    }

    public function commune()
    {
        return $this->belongsTo(ClCommune::class);
    }
}
