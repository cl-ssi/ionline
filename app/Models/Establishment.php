<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Rrhh\OrganizationalUnit;
use App\Models\Commune;
use App\Models\Inv\EstablishmentUser;
use App\Models\Warehouse\Store;
use App\User;

class Establishment extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'deis',
        'sirh_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'commune_id'
    ];

    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }

    public function organizationalUnits()
    {
        return $this->hasMany(OrganizationalUnit::class);
    }

    public function stores()
    {
        return $this->hasMany(Store::class);
    }

    public function usersInventories()
    {
        return $this->belongsToMany(User::class, 'inv_establishment_user')
            ->using(EstablishmentUser::class)
            ->withTimestamps();
    }

    /**
    * Organizational Unit tree
    */
    public function getTreeAttribute()
    {
        return $this->organizationalUnits()
            ->where('level',1)
            ->with([
                'childs',
                'childs.childs',
                'childs.childs.childs',
                'childs.childs.childs.childs',
                'childs.childs.childs.childs.childs',
            ])->first();
    }
}
