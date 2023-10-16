<?php

namespace App\Http\Livewire\His;

use Livewire\WithPagination;
use Livewire\Component;
use App\Rrhh\OrganizationalUnit;
use App\Models\Parameters\Parameter;
use App\Models\His\ModificationRequest;
use App\Models\Documents\Approval;

class ModificationMgr extends Component
{
    /** Necesario para paginar los resultados */
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    /** Mostrar o no el form, tanto para crear como para editar */
    public $form = false;

    public $modrequest;
    public $param_types;
    public $param_ous;
    public $ous;

    public $vb = [];

    protected $rules = [
        'modrequest.type' => 'required',
        'modrequest.subject' => 'required|min:4',
        'modrequest.body' => 'nullable',
        'modrequest.status' => 'nullable',
        'modrequest.observation' => 'nullable',
    ];

    protected $messages = [
        'modrequest.type.required' => 'El tipo es obligatorio.',
        'modrequest.subject.required' => 'El asunto es obligatorio.',
    ];

    /**
    * mount
    */
    public function mount()
    {
        $this->param_types = explode(',',Parameter::get('his_modifications','tipos_de_solicitudes'));
        $this->param_ous = explode(',',Parameter::get('his_modifications','ids_unidades_vb'));
        $this->ous = OrganizationalUnit::whereIn('id', $this->param_ous)->get();
    }

    public function index()
    {
        $this->resetErrorBag();
        $this->form = false;
    }

    /**
    * Set Approvals
    */
    public function setApprovals(ModificationRequest $modrequest)
    {
        foreach($this->vb as $ou_id => $status) {
            if($status) {
                $modrequest->approvals()->create([
                    "module" => "Modificaciones Ficha APS",
                    "module_icon" => "fas fa-notes-medical",
                    "subject" => $modrequest->subject,
                    "document_route_name" => "his.modification-request.show",
                    "document_route_params" => json_encode(["modification_request_id" => $modrequest->id]),
                    "approver_ou_id" => $ou_id,
                ]);

            }
        }
        $modrequest->save();

        $this->index();
    }

    public function form(ModificationRequest $modrequest)
    {
        $this->modrequest = ModificationRequest::firstOrNew([ 'id' => $modrequest->id]);
        $this->creator = $this->modrequest->creator->shortName;
        foreach($this->param_ous as $ous) {
            $this->vb[$ous] = true;
        }
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
        $modifications = ModificationRequest::with([
                'creator',
                'approvals',
                'approvals.organizationalUnit',
            ])
            ->latest()
            ->paginate(25);

        return view('livewire.his.modification-mgr', [
            'modifications' => $modifications,
        ])->extends('layouts.bt4.app');
    }
}
