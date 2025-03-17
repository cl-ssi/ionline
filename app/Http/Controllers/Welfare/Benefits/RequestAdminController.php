<?php

namespace App\Http\Controllers\Welfare\Benefits;

use App\Http\Controllers\Controller; // Importar correctamente la clase Controller
use App\Models\Welfare\Benefits\Request as BenefitRequest;
use Illuminate\Http\Request;

class RequestAdminController extends Controller
{
    public function index(Request $request)
    {
        $statusFilters = $request->get('statusFilters', ['En revisión']);
        
        // Consulta de solicitudes
        $establishments = [auth()->user()->establishment_id];
        if(auth()->user()->establishment_id == 41){
            $establishments = [41];
        } elseif(auth()->user()->establishment_id == 38){
            $establishments = [1, 38];
        }

        $query = BenefitRequest::query();

        if (!in_array('Todos', $statusFilters)) {
            $query->whereIn('status', $statusFilters)
                ->whereHas('applicant', function ($q) use ($establishments) {
                    $q->whereIn('establishment_id', $establishments);
                });
        }

        $requests = $query->orderByDesc('id')->paginate(10)->withQueryString(); // Esto preserva los filtros en los enlaces de paginación

        return view('welfare.benefits.request_admin', [
            'requests' => $requests,
            'statusFilters' => $statusFilters,
        ]);
    }

    public function acceptedRequestsIndex(Request $request)
    {
        // Consulta de solicitudes
        $establishments = [auth()->user()->establishment_id];
        if(auth()->user()->establishment_id == 41){
            $establishments = [41];
        } elseif(auth()->user()->establishment_id == 38){
            $establishments = [1, 38];
        }

        $query = BenefitRequest::query();

        $query->where('status', 'Aceptado')
            ->whereHas('applicant', function ($q) use ($establishments) {
                $q->whereIn('establishment_id', $establishments);
            });

        $requests = $query->orderByDesc('id')->paginate(10)->withQueryString(); // Esto preserva los filtros en los enlaces de paginación

        return view('welfare.benefits.accepted_request_admin', [
            'requests' => $requests
        ]);
    }
}
