<?php

namespace App\Http\Livewire\Welfare\Benefits;

use Livewire\Component;

use Illuminate\Support\Facades\Storage;
use App\Models\Welfare\Benefits\Request;
// use App\Models\Welfare\Benefits\Transfer;
use App\Notifications\Welfare\Benefits\RequestTransfer;
use App\Models\File;

class RequestsAdmin extends Component
{
    public $requests;
    // public $statusFilter = 'En revisión';
    public $statusFilters = ['En revisión']; // Establecer el filtro predeterminado

    protected $rules = [
        'requests.*.status_update_observation' => 'required',
        'requests.*.accepted_amount' => 'required',
        'requests.*.folio_number' => 'required',
        'requests.*.installments_number' => 'required',
    ];

    public function updatedStatusFilters()
    {
        // Limpiar el filtro si "Todos" está seleccionado
        if (in_array('Todos', $this->statusFilters)) {
            $this->statusFilters = ['Todos'];
        }
        // Limpiar "Todos" si otros filtros están seleccionados
        elseif (!empty($this->statusFilters) && count($this->statusFilters) > 1 && in_array('Todos', $this->statusFilters)) {
            $this->statusFilters = array_diff($this->statusFilters, ['Todos']);
        }
    }

    public function accept($id){
        $request = Request::find($id);
        $request->status = "Aceptado";
        $request->status_update_date = now();
        $request->status_update_responsable_id = auth()->user()->id;
        $request->save();
        $this->render();
    }

    public function reject($id){
        $request = Request::find($id);
        $request->status = "Rechazado";
        $request->status_update_date = now();
        $request->status_update_responsable_id = auth()->user()->id;
        $request->save();
        $this->render();
    }

    public function saveObservation($key){
        $this->requests[$key]->save();
        session()->flash('message', 'Se registró la observación.');
    }

    public function saveFolio($key){
        $this->requests[$key]->save();
        session()->flash('message', 'Se registró el folio.');
    }


    public function saveAcceptedAmount($key){
        $request = Request::find($this->requests[$key]->id);
        
        // 13/06/2024: se comenta por solicitud de bienestar
        // verificación no se pase monto del tope anual (solo para subsidios con tope anual)
        // if($request->subsidy->annual_cap != null){
        //     $disponible_ammount = $request->subsidy->annual_cap - $request->getSubsidyUsedMoney();

        //     if($this->requests[$key]->accepted_amount > $disponible_ammount){
        //         session()->flash('info', 'No es posible guardar el valor puesto que excede el tope anual del beneficio.');
        //         return;
        //     }
        // }

        $request->accepted_amount_date = now();
        $request->accepted_amount_responsable_id = auth()->user()->id;
        $request->accepted_amount = $this->requests[$key]->accepted_amount;
        $request->save();

        session()->flash('message', 'Se registró el monto aprobado.');
    }

    public function saveInstallmentsNumber($key){
        $this->requests[$key]->save();
        // for ($i = 0; $i < $this->requests[$key]->installments_number; $i++) {
        //     $transfer = new Transfer();
        //     $transfer->request_id = $this->requests[$key]->id;
        //     $transfer->installment_number = ($i + 1);
        //     $transfer->save();
        // }
        session()->flash('message', 'Se registró el número de cuotas.');
    }

    public function saveTransfer($key){
        $request = Request::find($this->requests[$key]->id);
        $request->status = "Pagado";
        $request->payed_date = now();
        $request->payed_responsable_id = auth()->user()->id;
        $request->payed_amount = $request->accepted_amount;
        $request->save();

        session()->flash('message', 'Se registró la transferencia.');

        // envia notificación
        if($request->applicant){
            if($request->applicant->email_personal != null){
                // Utilizando Notify 
                $request->applicant->notify(new RequestTransfer($request, $request->accepted_amount));
            } 
        }
    }

    public function showFile($requestId)
    {
        $file = File::find($requestId);
        return Storage::disk('gcs')->response($file->storage_path, mb_convert_encoding($file->name,'ASCII'));
    }

    public function render()
    {
        $this->requests = Request::all();
        
        // Inicializar la consulta de solicitudes
        $query = Request::query();

        // Aplicar el filtro si se selecciona un estado y no se selecciona "Todos"
        if (!empty($this->statusFilters) && !in_array('Todos', $this->statusFilters)) {
            $query->whereIn('status', $this->statusFilters);
        } elseif (empty($this->statusFilters)) {
            $query->where('status', null); // No mostrar nada si no hay filtros seleccionados
        }

        // Obtener las solicitudes filtradas
        $this->requests = $query->orderByDesc('id')->get();

        return view('livewire.welfare.benefits.requests-admin');
        
    }
}
