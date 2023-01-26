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

    public $options;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'deis',
        'sirh_code',
        'dependency',
        'official_name',
        'administrative_dependency',
        'level_of_care',
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

    /**
    * ouTree
    */
    public function getOuTreeAttribute()
    {
        $ous = $this->organizationalUnits()
            ->select('id','level','name','organizational_unit_id as father_id')
            ->get()
            ->toArray();
        
        if(!empty($ous)) {
            $this->buildTree($ous, 'father_id', 'id');
        }

        return $this->options;
    }


    /**
     * @param array $flatList - a flat list of tree nodes; a node is an array with keys: id, parentID, name.
     */
    function buildTree(array $flatList)
    {
        $grouped = [];
        foreach ($flatList as $node){
            if(!$node['father_id']) {
                $node['father_id'] = 0;
            }
            $grouped[$node['father_id']][] = $node;
        }

        $fnBuilder = function($siblings) use (&$fnBuilder, $grouped) {
            foreach ($siblings as $k => $sibling) {
                $id = $sibling['id'];
                $this->options[$id] = str_repeat("- ", $sibling['level']).$sibling['name'];
                if(isset($grouped[$id])) {
                    $sibling['children'] = $fnBuilder($grouped[$id]);
                }
                $siblings[$k] = $sibling;
            }
            return $siblings;
        };

        return $fnBuilder($grouped[0]);
    }
}
