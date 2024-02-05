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

    public function region()
    {
        return $this->belongsTo(ClRegion::class);
    }

    public function localities()
    {
        return $this->hasMany('App\Models\ClLocality', 'commune_id');
    }

    public static function getCommunesBySearch($searchText){
        $communes = ClCommune::query();
        $array_search = explode(' ', $searchText);
        foreach($array_search as $word){
            $communes->where(function($q) use($word){
                $q->where('name', 'LIKE', '%'.$word.'%');
            });
        }
        
        return $communes;
    }

    protected $dates = ['deleted_at'];
    
    protected $table = 'cl_communes';
}
