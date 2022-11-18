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

    protected $table = 'cfg_suppliers';

    protected $fillable = [
        'run',
        'dv',
        'code',
        'name',
        'branch_code',
        'branch_name',
        'contact_name',
        'contact_phone',
        'contact_email',
        'contact_charge',
        'commercial_activity',
        'address',
        'region_id',
        'commune_id',
        'telephone'
    ];

    public function region()
    {
        return $this->belongsTo(ClRegion::class);
    }

    public function commune()
    {
        return $this->belongsTo(ClCommune::class);
    }

    public function scopeSearch($query, $name_search)
    {
        if ($name_search) {
            if($name_search != ''){
                $query->where(function($q) use($name_search){
                    $q->where('name', 'LIKE', '%'.$name_search.'%')
                    ->orwhere('run','LIKE', '%'.$name_search.'%');
                });
            }
        }
    }
}
