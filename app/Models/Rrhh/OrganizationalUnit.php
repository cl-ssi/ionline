<?php

namespace App\Models\Rrhh;

use App\Models\Documents\Document;
use App\Models\Establishment;
use App\Models\Profile\Subrogation;
use App\Models\RequestForms\RequestForm;
use App\Models\Requirements\Category;
use App\Models\ServiceRequests\OrganizationalUnitLimit;
use App\Models\ServiceRequests\ServiceRequest;
use App\Models\User;
use App\Observers\Rrhh\OrganizationalUnitObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\JobPositionProfiles\JobPositionProfile;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

#[ObservedBy([OrganizationalUnitObserver::class])]
class OrganizationalUnit extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = 'organizational_units';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'level',
        'order',
        'organizational_unit_id',
        'establishment_id',
        'sirh_function',
        'sirh_ou_id',
        'sirh_cost_center',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class)->orderBy('name');
    }

    public function father(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class, 'organizational_unit_id');
    }

    public function childs(): HasMany
    {
        return $this->hasMany(OrganizationalUnit::class, 'organizational_unit_id');
    }

    public function authorities(): HasMany
    {
        return $this->hasMany(Authority::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    public function jobPositionProfiles(): HasMany
    {
        return $this->hasMany(JobPositionProfile::class, 'jpp_ou_id');
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function serviceRequestLimit(): HasOne
    {
        return $this->hasOne(OrganizationalUnitLimit::class);
    }

    public function requestForms(): HasMany
    {
        return $this->hasMany(RequestForm::class, 'applicant_ou_id');
    }

    public function manager(): HasOneThrough
    {
        return $this->hasOneThrough(User::class, Authority::class, 'organizational_unit_id', 'id', 'id', 'user_id')
            ->where('type', Authority::TYPE_MANAGER)
            ->where('date', now()->startOfDay()->toDateString());
    }

    public function secretary(): HasOneThrough
    {
        return $this->hasOneThrough(User::class, Authority::class, 'organizational_unit_id', 'id', 'id', 'user_id')
            ->where('type', Authority::TYPE_SECRETARY)
            ->where('date', now()->startOfDay()->toDateString());
    }

    public function delegate(): HasOneThrough
    {
        return $this->hasOneThrough(User::class, Authority::class, 'organizational_unit_id', 'id', 'id', 'user_id')
            ->where('type', Authority::TYPE_DELEGATE)
            ->where('date', now()->startOfDay()->toDateString());
    }

    public function currentManager(): HasOne
    {
        return $this->hasOne(Authority::class)
            ->with('user')
            ->where('date', today())
            ->where('type', 'manager');
    }

    public function currentDelegate(): HasOne
    {
        return $this->hasOne(Authority::class)
            ->with('user')
            ->where('date', today())
            ->where('type', 'delegate');
    }

    public function currentSecretary(): HasOne
    {
        return $this->hasOne(Authority::class)
            ->with('user')
            ->where('date', today())
            ->where('type', 'secretary');
    }

    public function subrogations(): HasMany
    {
        // return $this->hasManyThrough(User::class, Subrogation::class, 'organizational_unit_id', 'id', 'id', 'user_id')
        //     ->where('type', Subrogation::TYPE_MANAGER)
        //     ->orderBy('level', 'asc');
        return $this->hasMany(Subrogation::class)
            ->orderBy('type')
            ->orderBy('level', 'asc');
    }

    public function managers(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, Subrogation::class, 'organizational_unit_id', 'id', 'id', 'user_id')
            ->where('type', Subrogation::TYPE_MANAGER)
            ->orderBy('level', 'asc');
    }

    public function subrogationsManager()
    {
        return $this->hasMany(Subrogation::class)
            ->where('type', 'manager');
    }

    /**
     * Ordenar unidades organizacionales dentro del mismo establecimiento.
     *
     * @param int $establishmentId
     * @return void
     */
    public static function reorderUnits(int $establishmentId): void
    {
        $root = self::with('childs')
            ->whereNull('organizational_unit_id')
            ->where('establishment_id', $establishmentId)
            ->orderBy('name')
            ->first();

        $order = 1;

        $order = self::updateOrder($root, $order);
    }

    /**
     * Actualizar el orden de un nodo y sus hijos recursivamente.
     *
     * @param OrganizationalUnit $node
     * @param int $currentOrder
     * @return int
     */
    private static function updateOrder(OrganizationalUnit $node, int $currentOrder): int
    {
        // Verificar si el valor actual es diferente del esperado
        if ($node->order !== $currentOrder) {
            $node->order = $currentOrder;
            $node->saveQuietly();
        }

        $currentOrder++;

        $children = $node->childs()->orderBy('name')->get();

        foreach ($children as $child) {
            $currentOrder = self::updateOrder($child, $currentOrder);
        }

        return $currentOrder;
    }

    public function scopeSearch($query, $name)
    {
        if ($name != '') {
            return $query->where('name', 'LIKE', '%'.$name.'%');
        }
    }

    protected function initials(): Attribute
    {
        /**
         * NOTA: cree esta nueva funcion de iniciales,
         * No se que consecuencias pueda tener en el sistema, si es necesario
         * se puede comentar y descomentar la funcion getInitialsAttribute
         */
        return Attribute::make(
            get: function (): string {
                $excludedWords = ['de', 'y', 'la', 'e', 'las', 'del', 'al', 'en', 'el'];

                $specialWords = [
                    'S.A.M.U.' => 'SAMU', 
                    'P.E.S.P.I.' => 'PESPI', 
                    'P.R.A.I.S.' => 'PRAIS', 
                    'O.I.R.S.' => 'OIRS', 
                    'GES/PPV' => 'GESPPV',
                    'IAAS' => 'IAAS',
                ];

                // Dividir el nombre en palabras, manejando múltiples espacios
                $words = preg_split('/\s+/', $this->name, -1, PREG_SPLIT_NO_EMPTY);
                $initials = array_map(function ($word) use ($excludedWords, $specialWords) {
                    $wordLower = strtolower($word);
                    if (isset($specialWords[$word])) {
                        return $specialWords[$word];
                    }
                    return !in_array($wordLower, $excludedWords) ? strtoupper($word[0]) : '';
                }, $words);

                // Unir las iniciales y eliminar cualquier paréntesis al final
                return rtrim(implode('', array_filter($initials)), '()');
            }
        );
    }

    // public function getInitialsAttribute()
    // {
    //     $words    = explode(' ', preg_replace('/\s+/', ' ', $this->name));
    //     $initials = '';
    //     foreach ($words as $word) {
    //         if (
    //             $word != 'de' && $word != 'y' && $word != 'la' && $word != 'e' && $word != 'las' && $word != 'del'
    //             && $word != 'al' && $word != 'en' && $word != 'el'
    //         ) {
    //             if ($word === 'Subdirección') {
    //                 $initials .= 'SD';
    //             } elseif (
    //                 $word === 'S.A.M.U.' || $word === 'P.E.S.P.I.' || $word === 'P.R.A.I.S.' || $word === 'O.I.R.S.' ||
    //                 $word === 'GES/PPV'
    //             ) {
    //                 $initials .= $word;
    //             } else {
    //                 $initials .= $word[0];
    //             }
    //         }
    //     }

    //     return $initials;
    // }

    /**
     * Retorna un array de las OrganizationalUnits ascendentes, incluyendo la unidad inicial,
     * cada una con su relación manager cargada.
     *
     * @return array
     */

     public function getDescendantUnitsArray(): array
     {
         $units = [];
     
         foreach ($this->childs as $child) {
             $descendants = $child->getDescendantUnitsArray();
             $units = array_merge($units, $descendants);
         }
     
         $units[] = [
             'id' => $this->id,
             'name' => $this->name,
             'manager_id' => $this->organizational_unit_id,
             'level' => $this->level
         ];
     
         // Ordenar por nivel de menor a mayor
         usort($units, function ($a, $b) {
             return $a['level'] <=> $b['level'];
         });
     
         return $units;
     }


    public function getAncestorUnitsArray(): array
    {
        $units = [];
    
        // Incluir la unidad actual con su relación manager cargada
        $units[] = ['id' => $this->id, 'name' => $this->name, 'manager' => $this->manager->id ?? null, 'level' => $this->level];
    
        // Verificar si la unidad tiene un padre
        if ($this->father) {
            // Obtener las unidades ascendentes del padre
            $ancestorUnits = $this->father->getAncestorUnitsArray();
            // Fusionar las unidades del padre con las unidades actuales
            $units = array_merge($units, $ancestorUnits);
        }

        return $units;
    }

    /**
     * Obtiene todas las unidades organizacionales descendientes de la unidad actual en base a un array de IDs.
     */
    public function getHierarchicalUnits(User $user): array
    {
        $organizationalUnits = $this->getAncestorUnitsArray();
    
        // Filtrar unidades donde el manager es el mismo que el del siguiente
        $organizationalUnits = array_values(array_filter($organizationalUnits, function ($unit, $key) use ($organizationalUnits) {
            return !isset($organizationalUnits[$key + 1]) || $unit['manager'] != $organizationalUnits[$key + 1]['manager'];
        }, ARRAY_FILTER_USE_BOTH));
    
        // Filtrar unidades donde el manager es el usuario actual
        $organizationalUnits = array_values(array_filter($organizationalUnits, function ($unit) use ($user) {
            return $user->id != $unit['manager'];
        }));
    
        // Verificar la condición adicional sobre el nivel de la primera unidad
        if (!empty($organizationalUnits)) {
            $firstUnit = $organizationalUnits[0];
            $lastIndex = count($organizationalUnits) - 1;
    
            if ($firstUnit['level'] > 2 || ($firstUnit['level'] == 2 && $user->id != $firstUnit['manager'])) {
                unset($organizationalUnits[$lastIndex]);
            }
        }
    
        // Reindexar el array para devolverlo con índices consecutivos
        return array_values($organizationalUnits);
    }

    public function getTree($getBrothers = false, $getChilds = false)
    {
        // ARBOL PARA GOOGLE CHART
        $tree = collect([]);
        $root = $this;

        for ($i = 1; $i <= $this->level; $i++) {
            if ($this->id == $root->id) {
                $info['v'] = $root->name;
                $info['f'] = "{$root->name}<div style='color:red; font-style:italic'>Funcionario</div>";
            } else {
                $info = $root->name;
            }

            $sheet = [$info, $root->father->name ?? '', ''];
            $tree->push($sheet);

            $root = $root->father;
        }

        if ($this->father && $getBrothers) {
            foreach ($this->father->childs as $child) {
                $sheet = [$child->name, $child->father->name ?? '', ''];
                $tree->push($sheet);
            }
        }

        if ($getChilds) {
            foreach ($this->childs as $child) {
                $sheet = [$child->name, $child->father->name ?? '', ''];
                $tree->push($sheet);
            }
        }

        return $tree;
    }

    public function getTreeDocPdf()
    {
        $root         = $this;
        $tree_doc_pdf = [];

        for ($i = 1; $i <= $this->level; $i++) {
            $info_doc_pdf['level'] = $root->level;
            $info_doc_pdf['name']  = $root->name;
            $tree_doc_pdf[]        = $info_doc_pdf;
            $root                  = $root->father;
        }

        $print = array_multisort(array_column($tree_doc_pdf, 'level'), SORT_ASC, $tree_doc_pdf);

        $col = array_column($tree_doc_pdf, 'level');
        array_multisort($col, SORT_ASC, $tree_doc_pdf);

        return $tree_doc_pdf;
    }

    public function getTreeAttribute()
    {
        return $this->getTree();
    }

    public function getTreeWithBrothersAttribute()
    {
        return $this->getTree(true);
    }

    public function getTreeWithChildsAttribute()
    {
        return $this->getTree(false, true);
    }

    public function getAllChilds()
    {
        $root     = $this;
        $ouChilds = [];

        foreach ($root->childs as $child) {
            $ouChilds[] = $child->id;
            foreach ($child->childs as $child) {
                $ouChilds[] = $child->id;
            }
        }

        return $ouChilds;
    }

    public static function getOrganizationalUnitsBySearch($searchText)
    {
        $organizationalUnits = OrganizationalUnit::query();
        $array_search        = explode(' ', $searchText);
        foreach ($array_search as $word) {
            $organizationalUnits->where(function ($q) use ($word) {
                $q->where('name', 'LIKE', '%'.$word.'%')
                    ->where('establishment_id', auth()->user()->organizationalUnit->establishment_id);
            });
        }

        return $organizationalUnits;
    }

    public function getOrganizationalUnitByLevel($level)
    {
        if ($this->level == $level) {
            return $this;
        }

        return $this->father->getOrganizationalUnitByLevel($level);
    }

    public function activeContractCount($program, $program_contract_type)
    {
        // devuelve contratos mensuales y programa OTROS PROGRAMAS HETG
        // devuelve contratos cuyo proceso de visación este completado.
        // devuelve contratos que no tengan renuncia, ni abandono de funciones.
        // devuelve contratos que todavia no hayan terminado
        $serviceRequests = ServiceRequest::wheredoesnthave('SignatureFlows', function ($subQuery) {
            $subQuery->whereNull('status')
                ->orWhere('status', 0);
        })
            ->whereHas('fulfillments', function ($q) {
                $q->wheredoesnthave('FulfillmentItems', function ($q) {
                    $q->whereIn('type', ['Renuncia voluntaria', 'Abandono de funciones', 'Término de contrato anticipado']);
                });
            })
            ->where('end_date', '>', now())
            ->where('responsability_center_ou_id', $this->id)
            ->when($program, function ($q) use ($program) {
                $q->where('programm_name', $program);
            })
            ->when($program_contract_type, function ($q) use ($program_contract_type) {
                $q->where('program_contract_type', $program_contract_type);
            })
            ->with('SignatureFlows')
            ->count();

        return $serviceRequests;
    }

    /**
     * Get the OU short name.
     */
    protected function shortName(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                // Reemplaza las palabras antes de cortar el string
                $value = $attributes['name'];
                $value = str_replace('Departamento de', 'D.', $value);
                $value = str_replace('Unidad de', 'U.', $value);
                $value = str_replace('Subdirección de', 'SD.', $value);

                // Retorna los primeros 40 caracteres del string resultante
                return substr($value, 0, 30).'.';
            },
        );
    }
}
