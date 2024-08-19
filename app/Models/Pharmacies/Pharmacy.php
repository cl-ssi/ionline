<?php

namespace App\Models\Pharmacies;

use App\Models\Establishment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pharmacy extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'address','establishment_id'
    ];

    use SoftDeletes;

    protected $table = 'frm_pharmacies';

    //relaciones
    public function disptachs()
    {
      return $this->hasMany('App\Models\Pharmacies\Dispatch');
    }

    public function purchases()
    {
      return $this->hasMany('App\Models\Pharmacies\Purchase');
    }

    public function receivings()
    {
      return $this->hasMany('App\Models\Pharmacies\Receiving');
    }

    public function establishments()
    {
      return $this->hasMany('App\Models\Pharmacies\Establishment');
    }

    public function suppliers()
    {
      return $this->hasMany('App\Models\Pharmacies\Supplier');
    }

    public function products()
    {
      return $this->hasMany('App\Models\Pharmacies\Product');
    }

    public function users()
    {
      return $this->belongsToMany('App\Models\User', 'frm_pharmacy_user')->withTimestamps();
    }

    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }
}
