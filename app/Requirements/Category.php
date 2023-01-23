<?php

namespace App\Requirements;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Rrhh\OrganizationalUnit;
use App\Requirements\Requirement;

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
        return $this->hasMany(Requirement::class);
    }

    public function scopeSearch($query, $request) {

        if($request != "") {
            $query->where('name','LIKE','%'.$request.'%');
        }

        return $query;
    }
}
