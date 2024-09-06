<?php

namespace App\Livewire\PurchasePlan;

use Livewire\Component;

use Livewire\WithFileUploads;

use App\Models\PurchasePlan\PurchasePlan;
use App\Models\PurchasePlan\PurchasePlanPublication;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AddPurchasePlan extends Component
{
    use WithFileUploads;

    public $purchasePlan;

    public $mercadoPublicoId;
    public $date;
    public $fileAttached;
    
    public $iterationFileClean = 0;

    protected function messages(){
        return [
            'mercadoPublicoId.required' => 'Debe ingresar ID de Mercado Público.',
            'date.required'             => 'Debe ingresar Fecha de publicación.',
            'fileAttached.required'     => 'Debe ingresar Adjunto.'
        ];
    }

    public function render()
    {
        return view('livewire.purchase-plan.add-purchase-plan');
    }

    public function save(){
        $validatedData = $this->validate([
                'mercadoPublicoId'  => 'required',
                'date'              => 'required',
                'fileAttached'      => 'required'
            ]
        );

        $now = now()->format('Y_m_d_H_i_s');

        $purchasePlanPublication = DB::transaction(function () use($now) {
            $purchasePlanPublication = PurchasePlanPublication::updateOrCreate(
                [
                    'id'  =>  null,
                ],
                [
                    'mercado_publico_id'    => $this->mercadoPublicoId,
                    'date'                  => $this->date,
                    'file'                  => $this->fileAttached->storeAs('/ionline/purchase_plan/publication', $now.'_alw_file_'.$this->purchasePlan->id.'.'.$this->fileAttached->extension(), 'gcs'),
                    'purchase_plan_id'      => $this->purchasePlan->id,
                    'user_id'               => auth()->id()
                ]
            );

            return $purchasePlanPublication;
        });

        $this->purchasePlan->status = 'published';
        $this->purchasePlan->save();

        session()->flash('success', 'Estimados Usuario, se ha ingresado exitosamente ID de Mercado Público correspondiente al Plan de Compra N°'.$this->purchasePlan->id);
        return redirect()->route('purchase_plan.show', ['purchasePlan' => $this->purchasePlan]);
    }

    public function show_file(PurchasePlanPublication $purchasePlanPublication){
        return Storage::response($purchasePlanPublication->file);
    }
}
