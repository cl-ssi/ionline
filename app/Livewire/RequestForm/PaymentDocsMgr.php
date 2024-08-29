<?php

namespace App\Livewire\RequestForm;

use Livewire\Component;
use App\Models\RequestForms\RequestForm;
use App\Models\RequestForms\PaymentDoc;

class PaymentDocsMgr extends Component
{
    public RequestForm $requestForm;
    public $name;
    public $description;
    public $form = false;
    protected $listeners = ['refreshComponent' => '$refresh'];

    

    /**
    * Save
    */
    public function save()
    {
        $this->validate([
            'name' => ['required', 'string'],
        ]);

        $paymentDoc = new PaymentDoc(); // Crear una nueva instancia de PaymentDoc
        $paymentDoc->name = $this->name; // Asignar el valor del campo "name"
        $paymentDoc->description = $this->description; // Asignar el valor del campo "description"
        $paymentDoc->requestForm()->associate($this->requestForm); // Asociar el PaymentDoc con el RequestForm actual
        $paymentDoc->save(); // Guardar el PaymentDoc en la base de datos
        $this->form = false;
        $this->dispatch('refreshComponent');

        $this->name = '';
        $this->description = '';

        
    }

    public function delete($paymentDocId)
    {
        $paymentDoc = PaymentDoc::findOrFail($paymentDocId); // Buscar el PaymentDoc por su ID
        $paymentDoc->delete(); // Eliminar el PaymentDoc

        $this->dispatch('refreshComponent');
    }



    /**
    * Muestra el formulario al apretar en el botón "+"
    */
    public function showForm()
    {
        $this->form = true;
    }

    public function render()
    {
        return view('livewire.request-form.payment-docs-mgr');
    }
}
