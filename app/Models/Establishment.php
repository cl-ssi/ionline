<?php

namespace App\Models;

use App\Models\Inv\EstablishmentUser;
use App\Models\Parameters\EstablishmentType;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\Warehouse\Store;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class Establishment extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public $options;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'establishments';

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
        'health_service_id',
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
        'father_organizational_unit_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'commune_id',
    ];

    public function healthService(): BelongsTo
    {
        return $this->belongsTo(HealthService::class);
    }

    /**
     * Get the commune that owns the establishment.
     */
    public function commune(): BelongsTo
    {
        return $this->belongsTo(Commune::class);
    }

    /**
     * Get the establishment type that owns the establishment.
     */
    public function establishmentType(): BelongsTo
    {
        return $this->belongsTo(EstablishmentType::class);
    }

    /**
     * Get the organizational units for the establishment.
     */
    public function organizationalUnits(): HasMany
    {
        return $this->hasMany(OrganizationalUnit::class);
    }

    /**
     * Get the stores for the establishment.
     */
    public function stores(): HasMany
    {
        return $this->hasMany(Store::class);
    }

    /**
     * Get the mother establishment.
     */
    public function mother(): BelongsTo
    {
        return $this->belongsTo(Establishment::class, 'new_mother_code', 'new_deis');
    }

    /**
     * Get the father organizational unit for the establishment.
     */
    public function ouFather(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class, 'father_organizational_unit_id');
    }

    /**
     * Get the users inventories for the establishment.
     */
    public function usersInventories(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'inv_establishment_user')
            ->using(EstablishmentUser::class)
            ->withTimestamps();
    }

    /**
     * Organizational Unit tree for google charts
     */
    public function getTreeGoogleChartAttribute(): string
    {
        $ous = $this->organizationalUnits()
            ->with('father')
            ->get();

        foreach ($ous as $ou) {
            $array[] = [$ou->name, $ou->father->name ?? '', ''];
        }

        return json_encode($array);
    }

    /**
     * Organizational Unit tree array
     */
    public function getTreeArrayAttribute(): array
    {
        $ous = $this->organizationalUnits()
            ->select('id', 'level', 'name', 'organizational_unit_id as father_id')
            ->orderBy('name')
            ->get()
            ->toArray();

        $array[0]['id'] = null;
        $array[0]['name'] = null;
        if (! empty($ous)) {
            $array = $this->buildTree($ous);
        }

        return $array[0];
    }

    /**
     * ouTree
     */
    public function getOuTreeAttribute(): array
    {
        $ous = $this->organizationalUnits()
            ->select('id', 'level', 'name', 'organizational_unit_id as father_id')
            ->orderBy('name')
            ->get()
            ->toArray();

        if (! empty($ous)) {
            $this->buildTree($ous);
        }

        return $this->options;
    }

    /**
     * Get the organizational unit tree with alias.
     */
    public function getOuTreeWithAliasAttribute(): ?array
    {
        $ous = $this->organizationalUnits()
            ->select('id', 'level', 'name', 'organizational_unit_id as father_id')
            ->orderBy('name')
            ->get()
            ->toArray();

        if (! empty($ous)) {
            $this->buildTree($ous);
        }
        foreach ((array) $this->options as $key => $option) {
            $this->options[$key] = $this->alias.' '.$option;
        }

        return $this->options;
    }

    /**
     * Get the organizational unit tree with alias by level.
     */
    public function getOuTreeWithAliasByLevelAttribute(int $level): array
    {
        $ous_lv1 = $this->organizationalUnits()->where('id', 1)->get()->toArray();
        $ous_lv_param = $this->organizationalUnits()
            ->select('id', 'level', 'name', 'organizational_unit_id as father_id')
            ->orderBy('name')
            ->where('level', $level)
            ->get()
            ->toArray();

        $ous = array_merge($ous_lv1, $ous_lv_param);

        foreach ($ous as $key => $ou) {
            $this->options[$ou['id']] = $ou['name'];
        }

        return $this->options;
    }

    /**
     * Get the new DEIS without the first character.
     */
    public function getNewDeisWithoutFirstCharacterAttribute(): string
    {
        return substr($this->new_deis, 1);
    }

    /**
     * Get the full address.
     */
    public function getFullAddressAttribute(): string
    {
        return $this->street_type.' '.$this->address.' '.$this->street_number;
    }

    /**
     * Build a tree from a flat list.
     *
     * @param  array  $flatList  - a flat list of tree nodes; a node is an array with keys: id, parentID, name.
     */
    public function buildTree(array $flatList): array
    {
        $grouped = [];
        foreach ($flatList as $node) {
            if (! $node['father_id']) {
                $node['father_id'] = 0;
            }
            $grouped[$node['father_id']][] = $node;
        }

        $fnBuilder = function ($siblings) use (&$fnBuilder, $grouped) {
            foreach ($siblings as $k => $sibling) {
                $id = $sibling['id'];
                $this->options[$id] = str_repeat('- ', $sibling['level']).$sibling['name'];
                if (isset($grouped[$id])) {
                    $sibling['children'] = $fnBuilder($grouped[$id]);
                }
                $siblings[$k] = $sibling;
            }

            return $siblings;
        };

        return $fnBuilder($grouped[0]);
    }

    /**
     * Get Establishment Logo public path
     */
    public function getLogoPublicPathAttribute(): string
    {
        /** Confeccionar URL pública del logo */
        /** El código está acá para poder reutilizar este include en otro documento
         * EJ:
         * '/images/logo_rgb_SSI.png'
         * '/images/logo_pluma_SSI_HAH.png'
         */
        $logo = '/images/logo_';

        $logo .= 'rgb_';

        if ($this->mother) {
            $logo .= $this->mother->alias.'_';
        }

        $logo .= $this->alias.'.png';

        return public_path($logo);
    }
}
