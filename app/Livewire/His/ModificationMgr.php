<?php

namespace App\Livewire\His;

use App\Models\His\ModificationRequest;
use App\Models\Parameters\Parameter;
use App\Models\Rrhh\OrganizationalUnit;
use Livewire\Component;
use Livewire\WithPagination;

class ModificationMgr extends Component
{
    use WithPagination;

    public $form = false;
    public $modrequest;
    public $param_types;
    public $param_ous;
    public $ous;
    public $vb = [];

    public $modificationRequestId;
    public $modificationRequestType;
    public $modificationRequestSubject;
    public $modificationRequestBody;
    public $modificationRequestStatus;
    public $modificationRequestObservation;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'modificationRequestType' => 'required',
        'modificationRequestSubject' => 'required|min:4',
        'modificationRequestBody' => 'nullable',
        'modificationRequestStatus' => 'nullable',
        'modificationRequestObservation' => 'nullable',
    ];

    protected $messages = [
        'modificationRequestType.required' => 'El tipo es obligatorio.',
        'modificationRequestSubject.required' => 'El asunto es obligatorio.',
    ];

    public function mount()
    {
        $this->param_types = explode(',', Parameter::get('his_modifications', 'tipos_de_solicitudes'));
        $this->param_ous = explode(',', Parameter::get('his_modifications', 'ids_unidades_vb'));
        $this->ous = OrganizationalUnit::whereIn('id', $this->param_ous)->get();
    }

    public function index()
    {
        $this->resetErrorBag();
        $this->form = false;
    }

    public function setApprovals(ModificationRequest $modrequest)
    {
        foreach ($this->vb as $ou_id => $status) {
            if ($status) {
                $modrequest->approvals()->create([
                    'module' => 'Modificaciones Ficha APS',
                    'module_icon' => 'fas fa-notes-medical',
                    'subject' => $modrequest->subject,
                    'document_route_name' => 'his.modification-request.show',
                    'document_route_params' => json_encode(['modification_request_id' => $modrequest->id]),
                    'sent_to_ou_id' => $ou_id,
                ]);
            }
        }
        $modrequest->save();

        $this->index();
    }

    public function edit(ModificationRequest $modrequest)
    {
        $this->modrequest = $modrequest;
        $this->modificationRequestId = $modrequest->id;
        $this->assignModificationRequestAttributes();
        $this->form = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'type' => $this->modificationRequestType,
            'subject' => $this->modificationRequestSubject,
            'body' => $this->modificationRequestBody,
            'status' => $this->modificationRequestStatus,
            'observation' => $this->modificationRequestObservation,
        ];

        ModificationRequest::updateOrCreate(
            ['id' => $this->modificationRequestId],
            $data
        );

        $this->index();
    }

    private function assignModificationRequestAttributes()
    {
        $this->modificationRequestType = $this->modrequest->type;
        $this->modificationRequestSubject = $this->modrequest->subject;
        $this->modificationRequestBody = $this->modrequest->body;
        $this->modificationRequestStatus = $this->modrequest->status;
        $this->modificationRequestObservation = $this->modrequest->observation;
        $this->creator = $this->modrequest->creator->shortName;

        foreach ($this->param_ous as $ous) {
            $this->vb[$ous] = true;
        }
    }

    public function render()
    {
        $modifications = ModificationRequest::with([
            'creator',
            'approvals',
            'approvals.sentToOu',
        ])
            ->latest()
            ->paginate(25);

        return view('livewire.his.modification-mgr', [
            'modifications' => $modifications,
        ]);
    }
}