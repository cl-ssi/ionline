<?php

namespace App\Parameters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = ['name', 'address'];

        public function places() {
            return $this->hasMany('App\Parameters\Place');
        }

        use SoftDeletes;
        /**
         * The attributes that should be mutated to dates.
         *
         * @var array
         */
        protected $dates = ['deleted_at'];

       /**
       * The table associated with the model.
       *
       * @var string
       */
       protected $table = 'cfg_locations';
}
