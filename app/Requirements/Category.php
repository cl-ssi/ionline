<?php

namespace App\Requirements;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Rrhh\OrganizationalUnit;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'organizational_unit_id'
    ];

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'req_categories';

    public function organizationalUnit()
    {
        return $this->belongsTo(OrganizationalUnit::class);
    }
    
    public function requirements() {
        return $this->belongsToMany('App\Requirements\Category','req_requirements_categories');//->withPivot('requirement_id','category_id');
    }

    public function scopeSearch($query, $request) {

        if($request != "") {
            $query->where('name','LIKE','%'.$request.'%');
        }

        return $query;
    }
}
