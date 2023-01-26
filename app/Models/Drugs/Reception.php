<?php

namespace App\Models\Drugs;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Reception extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

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
        'reservado_isp_number', 'reservado_isp_date', 'date',
        //'user_id', 'manager_id', 'lawyer_id'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'date',
        'deleted_at',
        'document_date',
        'reservado_isp_date',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'drg_receptions';

    public function items()
    {
        return $this->hasMany(ReceptionItem::class);
    }

    public function court()
    {
        return $this->belongsTo(Court::class);
    }

    public function partePoliceUnit()
    {
        return $this->belongsTo(PoliceUnit::class, 'parte_police_unit_id');
    }

    public function documentPoliceUnit()
    {
        return $this->belongsTo(PoliceUnit::class, 'document_police_unit_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id')->withTrashed();
    }

    public function lawyer()
    {
        return $this->belongsTo(User::class, 'lawyer_id')->withTrashed();
    }

    public function destruction()
    {
        return $this->hasOne(Destruction::class);
    }

    public function sampleToIsp()
    {
        return $this->hasOne(SampleToIsp::class);
    }

    public function recordToCourt()
    {
        return $this->hasOne(RecordToCourt::class);
    }

    public function wasDestructed()
    {
        return isset($this->destruction);
    }

    public function haveItemsForDestruction()
    {
        return $this->hasMany(ReceptionItem::class)->where('destruct', '>', 0);
        // return $this->items()->where('destruct', '>', 0)->count() != 0;
    }

    public function haveItems()
    {
        return count($this->items) > 0;
    }

    public function scopeSearch($query, $id)
    {
        if ($id != "") {
            return $query->where('id', $id)->orWhereHas('sampleToISP', function ($q) use ($id) {
                $q->where('number', $id);
            });
            //return $query->where('id', $id)->orWhere('reservado_isp_number',$id);
        } else {
            return $query->whereDate('created_at', '>', Carbon::today()->subDays(16))->latest();
        }
    }
}
