<?php

namespace App\Documents;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Parte extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date', 'type', 'number', 'origin', 'subject', 'important', 'entered_at', 'viewed_at'
    ];

    public function getCreationParteDateAttribute()
    {
      return Carbon::parse($this->date)->format('d-m-Y');
    }

    public function events() {
        return $this->hasMany('\App\Documents\ParteEvent');
    }

    public function requirements() {
        return $this->hasMany('\App\Requirements\Requirement');
    }

    public function files() {
        return $this->hasMany('App\Documents\ParteFile');
    }

    public function scopeSearch($query, Request $request) {
        if($request->input('id') != "") {
            $query->where('id', $request->input('id') );
        }

        if($request->input('type') != "") {
            $query->where('type', $request->input('type') );
        }

        if($request->input('number') != "") {
            $query->where('number', 'LIKE', '%'.$request->input('number').'%' );
        }

        if($request->input('origin') != "") {
            $query->where('origin', 'LIKE', '%'.$request->input('origin').'%' );
        }

        if($request->input('subject') != "") {
            $query->where('subject', 'LIKE', '%'.$request->input('subject').'%' );
        }

        return $query;
    }

    public function scopeSearch2($query, $request) {
        if($request != "") {
            $query->where('number','LIKE','%'.$request.'%')
                  ->orWhere('origin','LIKE','%'.$request.'%');
        }

        return $query;
    }

    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'viewed_at'];
}
