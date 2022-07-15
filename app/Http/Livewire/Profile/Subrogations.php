<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use App\Models\Profile\Subrogation;

class Subrogations extends Component
{
    public $subrogations;
    public $view;

    public $subrogation;
    public $user_id, $subrogant_id, $level;

    protected $listeners = ['searchedUser'];

    public function searchedUser($searchedUser)
    {
        $this->subrogant_id = $searchedUser['id'];
    }

    protected function rules()
    {
        return [
            'user_id' => 'required',
            'subrogant_id' => 'required',
            'level' => 'required',
        ];
    }

    protected $messages = [
        'user_id.required' => 'El usuario es requerido.',
        'subrogant_id.required' => 'El subrogante es requerido.',
        'level.required' => 'El nivel es requerido.',
    ];

    public function mount()
    {
        $this->user_id = auth()->id();
        $this->subrogations = Subrogation::where('user_id',$this->user_id)->orderBy('level')->get();
        $this->view = 'index';
    }

    public function index()
    {
        $this->view = 'index';
    }

    public function create()
    {
        $this->view = 'create';
        $this->subrogation = null;
        
        $this->subrogant_id = null;
        $this->level = null;
    }

    public function store()
    {
        Subrogation::create($this->validate());
        $this->mount();
        $this->view = 'index';
    }

    public function edit(Subrogation $subrogation)
    {
        $this->view = 'edit';
        $this->subrogation = $subrogation;
        
        $this->subrogant_id = $subrogation->subrogant->id;
        $this->level = $subrogation->level;
    }

    public function update(Subrogation $subrogation)
    {
        $subrogation->update($this->validate());

        $this->mount();
        $this->view = 'index';
    }

    public function delete(Subrogation $subrogation)
    {
        $subrogation->delete();
        $this->mount();
    }

    public function render()
    {
        return view('livewire.profile.subrogations')->extends('layouts.app');;
    }
}
