<?php

namespace App\Http\Livewire\Sign;

use App\Models\Documents\Sign\SignatureFlow;
use Livewire\Component;
use Livewire\WithPagination;

class SignatureIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $filterBy = "all";
    public $search;

    public function render()
    {
        return view('livewire.sign.signature-index', [
            'signatureFlows' => $this->getSignatureFlows()
        ]);
    }

    public function getSignatureFlows()
    {
        $search = "%$this->search%";

        $signatureFlows = SignatureFlow::query()
            ->when($this->filterBy != "all", function($query){
                $query->whereStatus($this->filterBy);
            })
            ->when(isset($this->search), function ($query) use($search) {
                $query->whereHas('signature', function($query) use($search) {
                    $query->where('subject', 'like', $search)
                        ->OrWhere('description', 'like', $search);
                });
            })
            ->whereSignerId(auth()->id())
            ->paginate(10);

        return $signatureFlows;
    }
}
