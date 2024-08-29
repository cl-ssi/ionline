<?php

namespace App\Livewire\Resources;

use App\Models\Resources\Computer;
use Livewire\Component;
use Livewire\WithPagination;

class ComputerIndex extends Component
{
    use WithPagination;
	protected $paginationTheme = 'bootstrap';
    public $search;
    public $type_resource;

    public function render()
    {
        return view('livewire.resources.computer-index', [
            'computers' => $this->getComputers()
        ]);
    }

    public function getComputers()
    {
        $computers = Computer::search($this->search)
            ->with('users', 'place')
            ->when($this->type_resource != null, function($query) {
                $query->when($this->type_resource == "merged", function($query) {
                    $query->whereNotNull('fusion_at');
                }, function($query) {
                    $query->whereNull('fusion_at');
                });
            })
            ->paginate(50);

        return $computers;
    }
}
