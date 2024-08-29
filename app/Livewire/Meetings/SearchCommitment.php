<?php

namespace App\Livewire\Meetings;

use Livewire\Component;

use App\Models\Meetings\Commitment;
use App\Models\Rrhh\Authority;

class SearchCommitment extends Component
{
    public $index;

    public function render()
    {
        // return view('livewire.meetings.search-commitment');

        if($this->index == 'own'){
            $iAmAuthoritiesIn = array();
            foreach(Authority::getAmIAuthorityFromOu(now(), 'manager', auth()->user()->id) as $authority){
                array_push($iAmAuthoritiesIn, $authority->organizational_unit_id);
            }

            return view('livewire.meetings.search-commitment', [
                'commitments' => Commitment::
                    orderBy('created_at', 'DESC')
                    ->where('commitment_user_id', auth()->id())
                    ->orWhereIn('commitment_ou_id', $iAmAuthoritiesIn)
                    ->get()
            ]);
        }

        if($this->index == 'all'){
            return view('livewire.meetings.search-commitment', [
                'commitments' => Commitment::
                    orderBy('created_at', 'DESC')
                    // ->orWhere('commitment_ou_id', auth()->user()->organizationalUnit->id)
                    ->get()
            ]);
        }
    }
}
