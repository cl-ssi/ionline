<?php

namespace App\Indicators;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Value extends Model
{
    protected $table = 'ind_values';
    protected $fillable = ['month', 'factor', 'value', 'created_by', 'updated_by'];

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            $model->created_by = Auth::id();
        });

        static::creating(function ($model) {
            $model->updated_by = Auth::id();
            $model->created_by = Auth::id();
        });
    }

    public function action(){
        return $this->belongsTo('App\Indicators\Action');
    }

    public function creator(){
        return $this->belongsTo('App\User','created_by');
    }

    public function editor(){
        return $this->belongsTo('App\IUser','edited_by');
    }
}