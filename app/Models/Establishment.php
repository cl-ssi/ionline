<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Rrhh\OrganizationalUnit;
use App\Models\Parameters\EstablishmentType;
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
        'alias',
        'type',
        'mother_code',
        'new_mother_code',
        'establishment_type_id',
        'deis',
        'new_deis',
        'sirh_code',
        'commune_id',
        'dependency',
        'health_services_id',
        'official_name',
        'administrative_dependency',
        'level_of_care',
        'street_type',
        'street_number',
        'address',
        'url',
        'telephone',
        'emergency_service',
        'latitude',
        'longitude',
        'level_of_complexity',
        'provider_type_health_system',
        'mail_director',
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

    public function establishmentType()
    {
        return $this->belongsTo(establishmentType::class);
    }

    public function organizationalUnits()
    {
        return $this->hasMany(OrganizationalUnit::class);
    }

    public function stores()
    {
        return $this->hasMany(Store::class);
    }

    public function mother()
    {
        return $this->belongsTo(Establishment::class,'new_mother_code','new_deis');
    }

    /** Unidad Organizacional Padre, para el caso de los cosams, que dependen de una OU (salud mental) */
    public function ouFather()
    {
        return $this->belongsTo(OrganizationalUnit::class,'father_organizational_unit_id');
    }

    public function usersInventories()
    {
        return $this->belongsToMany(User::class, 'inv_establishment_user')
            ->using(EstablishmentUser::class)
            ->withTimestamps();
    }

    /**
    * Organizational Unit tree for google charts
    */
    public function getTreeGoogleChartAttribute()
    {
        $ous = $this->organizationalUnits()
            ->with('father')
            ->get();

        foreach($ous as $ou) {
            $array[] = array($ou->name, $ou->father->name ?? '', '');
        }
        return json_encode($array);
    }

    /**
    * Organizational Unit tree array
    */
    public function getTreeArrayAttribute()
    {
        $ous = $this->organizationalUnits()
            ->select('id','level','name','organizational_unit_id as father_id')
            ->orderBy('name')
            ->get()
            ->toArray();
        
        if(!empty($ous)) {
            $array = $this->buildTree($ous, 'father_id', 'id');
        }
        return $array[0];
    }

    /**
    * ouTree
    */
    public function getOuTreeAttribute()
    {
        $ous = $this->organizationalUnits()
            ->select('id','level','name','organizational_unit_id as father_id')
            ->orderBy('name')
            ->get()
            ->toArray();
        
        if(!empty($ous)) {
            $this->buildTree($ous, 'father_id', 'id');
        }

        return $this->options;
    }

    public function getOuTreeWithAliasAttribute()
    {
        $ous = $this->organizationalUnits()
            ->select('id','level','name','organizational_unit_id as father_id')
            ->orderBy('name')
            ->get()
            ->toArray();
        
        if(!empty($ous)) {
            $this->buildTree($ous, 'father_id', 'id');
        }
        foreach ($this->options as $key => $option) {
            $this->options[$key] = $this->alias . ' ' .$option;
        }
        return $this->options;
    }

    public function getNewDeisWithoutFirstCharacterAttribute()
    {
        return substr($this->new_deis, 1);
    }

    public function getFullAddressAttribute()
    {
        return $this->street_type . ' ' . $this->address . ' ' . $this->street_number;
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
