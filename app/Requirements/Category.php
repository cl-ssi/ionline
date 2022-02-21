<?php

namespace App\Requirements;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','color','user_id'
    ];

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'req_categories';

    public function scopeSearch($query, $request) {

        if($request != "") {
            $query->where('name','LIKE','%'.$request.'%');
        }

        return $query;
    }

    //relaciones
    public function user()
    {
      return $this->belongsTo('App\User')->withTrashed();
    }

    public function requirements() {
        return $this->belongsToMany('App\Requirements\Category','req_requirements_categories');//->withPivot('requirement_id','category_id');
    }

}
