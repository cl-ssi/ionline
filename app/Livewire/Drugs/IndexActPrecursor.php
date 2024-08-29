<?php

namespace App\Livewire\Drugs;

use App\Models\Drugs\ActPrecursor;
use Livewire\Component;
use Livewire\WithPagination;

class IndexActPrecursor extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.drugs.index-act-precursor', [
            'acts' => ActPrecursor::orderByDesc('id')->paginate(10)
        ])->extends('layouts.bt4.app');
    }
}
