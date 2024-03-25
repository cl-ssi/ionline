<?php

namespace App\Http\Livewire\Meetings;

use Livewire\Component;

use App\Models\Meetings\Commitment;

class SearchCommitment extends Component
{
    public $index;

    public function render()
    {
        // return view('livewire.meetings.search-commitment');

        if($this->index == 'own'){
            return view('livewire.meetings.search-commitment', [
                'commitments' => Commitment::
                    orderBy('created_at', 'DESC')
                    ->where('commitment_user_id', auth()->id())
                    ->orWhere('commitment_ou_id', auth()->user()->organizationalUnit->id)
                    ->get()
            ]);
        }
    }
}
