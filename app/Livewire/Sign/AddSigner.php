<?php

namespace App\Livewire\Sign;

use App\Models\Establishment;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\User;
use Livewire\Component;

class AddSigner extends Component
{
    public $eventName;
    public $establishments;
    public $ous;
    public $users;

    public $search_organizational_unit;
    public $establishment_id;
    public $organizational_unit_id;
    public $user_id;

    public $organizationalUnit;
    public $options;

    public function mount()
    {
        $establishments_ids = explode(',',env('APP_SS_ESTABLISHMENTS'));

        $this->establishments = Establishment::query()
            ->whereIn('id', $establishments_ids)
            ->orderBy('official_name')
            ->get();

        $this->options = [];
        $this->ous = [];
        $this->users = collect();
    }
    
    public function render()
    {
        return view('livewire.sign.add-signer');
    }

    public function updatedEstablishmentId($establishment_id)
    {
        $this->ous = array();
        $this->options = array();

        $ous = OrganizationalUnit::select('id','level','name','organizational_unit_id as father_id')
            ->where('establishment_id', $establishment_id)
            ->orderBy('name')
            ->get()
            ->toArray();

        if(!empty($ous))
        {
            $this->buildTree($ous, 'father_id', 'id');
        }

        /** Necesito formar este array poque sino livewire me los ordena por key los options y me quedan desordenados */
        foreach($this->options as $id => $option)
        {
            $this->ous[] = array('id'=> $id, 'name' => $option);
        }

        $this->users = collect([]);
        $this->organizational_unit_id = null;
        $this->user_id = null;
    }

    function buildTree(array $flatList)
    {
        $grouped = [];
        foreach ($flatList as $node)
        {
            if(!$node['father_id'])
            {
                $node['father_id'] = 0;
            }
            $grouped[$node['father_id']][] = $node;
        }

        $fnBuilder = function($siblings) use (&$fnBuilder, $grouped) {
            foreach ($siblings as $k => $sibling)
            {
                $id = $sibling['id'];
                $this->options[$id] = str_repeat("- ", $sibling['level']).$sibling['name'];

                if(isset($grouped[$id]))
                {
                    $sibling['children'] = $fnBuilder($grouped[$id]);
                }
                $siblings[$k] = $sibling;
            }
            return $siblings;
        };

        return $fnBuilder($grouped[0]);
    }

    public function updatedOrganizationalUnitId($organizational_unit_id)
    {
        if($organizational_unit_id != '')
        {
            $this->organizationalUnit = OrganizationalUnit::find($organizational_unit_id);

            if(isset($this->organizationalUnit->currentManager) && isset($this->organizationalUnit->currentManager->user))
            {
                $this->user_id = $this->organizationalUnit->currentManager->user->id;
            }
            else
            {
                $this->user_id = null;
            }

            $this->users = User::query()
                ->whereOrganizationalUnitId($organizational_unit_id)
                ->get();
        }
        else
        {
            $this->users = collect([]);
            $this->user_id = null;
        }
    }

    public function add()
    {
        if($this->user_id != '')
        {
            $this->dispatch($this->eventName, $this->user_id);
            $this->users = collect([]);
            $this->ous = [];
            $this->options = [];
            $this->establishment_id = '';
            $this->organizational_unit_id = null;
            $this->user_id = null;
        }
    }
}
