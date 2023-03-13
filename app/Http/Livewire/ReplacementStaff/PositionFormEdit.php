<?php

namespace App\Http\Livewire\ReplacementStaff;

use App\Models\ReplacementStaff\Position;
use App\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Contracts\Validation\Validator;

class PositionFormEdit extends Component
{
    public $requestReplacementStaff;
    public $position_id = null;
    public $editMode = null;
    public $positionEdit;
    public $createNewPosition = 'no';

    public function destroy($id)
    {
        if ($this->requestReplacementStaff->positions->count() == 1) {
            session()->flash('warning', 'No es posible borrar el único cargo disponible en la solicitud. Intente con editar el cargo.');
            return redirect()->route('replacement_staff.request.edit', $this->requestReplacementStaff);
        }

        Position::findorFail($id)->delete();
        $this->requestReplacementStaff->load('positions');
    }

    public function edit($id)
    {
        $this->editMode = true;
        $this->positionEdit = Position::findorFail($id);
        $this->position_id = $id;
        $this->emit('setPosition', $this->positionEdit);
    }

    public function updatedcreateNewPosition($value)
    {
        $this->emit('setIsDisabled', $value == 'no' ? 'disabled' : '');
    }

    public function mount()
    {
        $this->requestReplacementStaff->load('positions');
    }

    public function render()
    {
        return view('livewire.replacement-staff.position-form-edit');
    }
}
