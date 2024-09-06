<?php

namespace App\Livewire\Inventory;

use Livewire\Component;
use App\Models\Inv\Classification;
use Illuminate\Support\Facades\Auth;

class ClassificationMgr extends Component
{
    /** Mostrar o no el form, tanto para crear como para editar */
    public $form = false;


    public $classification;


    protected function rules()
    {
        return [

            'classification.name' => 'required|min:4',
        ];
    }


    public function index()
    {
        $this->resetErrorBag();
        $this->form = false;
    }


    public function save()
    {
        $this->validate();
        $this->classification->establishment_id = auth()->user()->organizationalUnit->establishment_id;
        $this->classification->save();
        $this->index();
    }

    public function formMethod(Classification $classification)
    {
        $this->classification = Classification::firstOrNew([ 'id' => $classification->id]);
        $this->form = true;
    }

    public function delete(Classification $classification)
    {
        $classification->delete();
    }

    public function render()
    {
        $classifications = Classification::where('establishment_id', auth()->user()->organizationalUnit->establishment_id)->latest()->paginate(25);
        return view('livewire.inventory.classification-mgr', [
            'classifications' => $classifications,
        ])->extends('layouts.bt4.app');

    }
}
