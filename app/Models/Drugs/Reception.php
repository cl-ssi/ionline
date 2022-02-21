<?php

namespace App\Models\Drugs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Reception extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parte', 'parte_label', 'parte_police_unit_id',
        'document_number', 'document_police_unit_id', 'document_date',
        'delivery', 'delivery_run', 'delivery_position',
        'court_id', 'imputed', 'imputed_run', 'observation',
        'reservado_isp_number', 'reservado_isp_date',
        //'user_id', 'manager_id', 'lawyer_id'
    ];

    public function items() {
        return $this->hasMany('App\Models\Drugs\ReceptionItem');
    }

    public function court() {
        return $this->belongsTo('App\Models\Drugs\Court');
    }

    public function partePoliceUnit() {
        return $this->belongsTo('App\Models\Drugs\PoliceUnit', 'parte_police_unit_id');
    }

    public function documentPoliceUnit() {
        return $this->belongsTo('App\Models\Drugs\PoliceUnit', 'document_police_unit_id');
    }

    public function user() {
        return $this->belongsTo('App\User')->withTrashed();
    }

    public function manager() {
        return $this->belongsTo('App\User', 'manager_id')->withTrashed();
    }

    public function lawyer() {
        return $this->belongsTo('App\User', 'lawyer_id')->withTrashed();
    }

    public function destruction() {
        return $this->hasOne('App\Models\Drugs\Destruction');
    }

    public function wasDestructed() {
        return isset($this->destruction);
    }

    public function haveItemsForDestruction() {
        return $this->items->where('destruct','>',0)->count() != 0;
    }

    public function haveItems() {
        return count($this->items) > 0;
    }

    public function scopeSearch($query, $id) {
        if($id != "") {
            return $query->where('id', $id)->orWhereHas('sampleToISP', function ($q) use ($id) {
                $q->where('number', $id);
            });
            //return $query->where('id', $id)->orWhere('reservado_isp_number',$id);
        }
        else {
            return $query->whereDate('created_at', '>', Carbon::today()->subDays(16))->latest();
        }
    }

    public function sampleToIsp() {
        return $this->hasOne('App\Models\Drugs\SampleToIsp');
    }

    public function recordToCourt() {
        return $this->hasOne('App\Models\Drugs\RecordToCourt');
    }

    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'document_date', 'reservado_isp_date'];

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'drg_receptions';
}
