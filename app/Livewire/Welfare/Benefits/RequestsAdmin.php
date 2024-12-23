<?php

namespace App\Livewire\Welfare\Benefits;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use App\Models\Welfare\Benefits\Request;
use App\Notifications\Welfare\Benefits\RequestTransfer;
use App\Notifications\Welfare\Benefits\RequestAccept;
use App\Notifications\Welfare\Benefits\RequestReject;
use App\Models\File;
use Livewire\WithPagination;
use Illuminate\Pagination\Paginator;

class RequestsAdmin extends Component
{
    use WithPagination;
    
    // public $requests;
    public $appliedFilters = []; // Almacena filtros aplicados con el botón
    public $statusFilters = ['En revisión']; // Establecer el filtro predeterminado
    public $currentRequestId = null;
    public $showTextarea = false;
    public $observation = '';

    protected $rules = [
        'requests.*.status_update_observation' => 'required',
        'requests.*.accepted_amount' => 'required',
        'requests.*.folio_number' => 'required',
        'requests.*.installments_number' => 'required',
    ];

    public function boot()
    {
        // Habilitar estilos de paginación de Bootstrap
        Paginator::useBootstrap();
    }

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

    public function applyFilters()
    {
        $this->appliedFilters = $this->statusFilters;
        $this->resetPage(); // Reiniciar la paginación
    }

    public function accept($id)
    {
        $request = Request::find($id);
        $request->status = "Aceptado";
        $request->status_update_date = now();
        $request->status_update_responsable_id = auth()->user()->id;
        $request->save();

        // Enviar notificación
        if ($request->applicant && $request->applicant->email_personal != null) {
            $request->applicant->notify(new RequestAccept($request));
        }

        $this->render();
    }

    public function reject($id)
    {
        $this->currentRequestId = $id;
        $this->showTextarea = true;
    }

    public function cancel()
    {
        $this->showTextarea = false;
        $this->currentRequestId = null;
        $this->observation = '';
    }

    public function saveObservation($key)
    {
        $this->requests[$key]->save();
        session()->flash('message', 'Se registró la observación.');
    }

    public function saveCancelObservation()
    {
        $request = Request::find($this->currentRequestId);
        $request->status = "Rechazado";
        $request->status_update_observation = $this->observation;
        $request->status_update_date = now();
        $request->status_update_responsable_id = auth()->user()->id;
        $request->save();

        // Enviar notificación
        if ($request->applicant && $request->applicant->email_personal != null) {
            $request->applicant->notify(new RequestReject($request));
        }

        session()->flash('message', 'Se registró la observación.');
        $this->showTextarea = false;
        $this->observation = '';
        $this->currentRequestId = null;
    }

    public function saveFolio($key)
    {
        $this->requests[$key]->save();
        session()->flash('message', 'Se registró el folio.');
    }

    public function saveAcceptedAmount($key)
    {
        $request = Request::find($this->requests[$key]->id);
        $request->accepted_amount_date = now();
        $request->accepted_amount_responsable_id = auth()->user()->id;
        $request->accepted_amount = $this->requests[$key]->accepted_amount;
        $request->save();

        session()->flash('message', 'Se registró el monto aprobado.');
    }

    public function saveInstallmentsNumber($key)
    {
        $this->requests[$key]->save();
        session()->flash('message', 'Se registró el número de cuotas.');
    }

    public function saveTransfer($key)
    {
        $request = Request::find($this->requests[$key]->id);
        $request->status = "Pagado";
        $request->payed_date = now();
        $request->payed_responsable_id = auth()->user()->id;
        $request->payed_amount = $request->accepted_amount;
        $request->save();

        session()->flash('message', 'Se registró la transferencia.');

        // Enviar notificación
        if ($request->applicant && $request->applicant->email_personal != null) {
            $request->applicant->notify(new RequestTransfer($request, $request->accepted_amount));
        }
    }

    public function showFile($requestId)
    {
        $file = File::find($requestId);
        return Storage::response($file->storage_path, mb_convert_encoding($file->name, 'ASCII'));
    }

    public function render()
    {
        // Inicializar la consulta de solicitudes
        $query = Request::query();

        // si es de HAH, solo se devuelve data de ese establecimiento. Si es SST, se devuelve SST y HETG. Si no es ninguna de los 2, se devuelve esa info.
        $establishments = [auth()->user()->establishment_id];
        if(auth()->user()->establishment_id == 41){
            $establishments = [41];
        }elseif(auth()->user()->establishment_id == 38){
            $establishments = [1,38];
        }

        // Aplicar el filtro si se selecciona un estado y no se selecciona "Todos"
        if (!empty($this->statusFilters) && !in_array('Todos', $this->statusFilters)) {
            $query->whereIn('status', $this->statusFilters)
                    ->whereHas('applicant', function ($q) use ($establishments) {
                            $q->whereIn('establishment_id',$establishments);
                        });
        } elseif (empty($this->statusFilters)) {
            $query->where('status', null) // No mostrar nada si no hay filtros seleccionados
                    ->whereHas('applicant', function ($q) use ($establishments) {
                        $q->whereIn('establishment_id',$establishments);
                    });
        }

        // Obtener las solicitudes filtradas
        $this->requests = $query->orderByDesc('id')->paginate(10);

        return view('livewire.welfare.benefits.requests-admin', [
            'requests' => $this->requests,
        ]);
    }
}
