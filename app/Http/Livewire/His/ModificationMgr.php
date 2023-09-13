<?php

namespace App\Http\Livewire\His;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\His\ModificationRequest;

class ModificationMgr extends Component
{
    /** Necesario para paginar los resultados */
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    /** Mostrar o no el form, tanto para crear como para editar */
    public $form = false;

    public $modrequest;

    protected $rules = [
        'modrequest.type' => 'required',
        'modrequest.subject' => 'required|min:4',
        'modrequest.body' => 'nullable',
        'modrequest.status' => 'nullable',
    ];

    protected $messages = [
        'modrequest.type.required' => 'El tipo es obligatorio.',
        'modrequest.subject.required' => 'El asunto es obligatorio.',
    ];

    public function index()
    {
        $this->resetErrorBag();
        $this->form = false;
    }

    public function form(ModificationRequest $modrequest)
    {
        $this->modrequest = ModificationRequest::firstOrNew([ 'id' => $modrequest->id]);
        $this->creator = $this->modrequest->creator->shortName;
        $this->form = true;
        // app('debugbar')->log($this->modrequest);
    }

    public function save()
    {
        $this->validate();
        $this->modrequest->save();
        $this->index();
    }

    public function render()
    {
        $modifications = ModificationRequest::latest()->paginate(25);
        return view('livewire.his.modification-mgr', [
            'modifications' => $modifications,
        ]);
    }
}
