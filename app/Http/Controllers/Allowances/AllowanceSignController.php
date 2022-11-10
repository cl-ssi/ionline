<?php

namespace App\Http\Controllers\Allowances;

use App\Http\Controllers\Controller;
use App\Models\Allowances\AllowanceSign;
use App\Models\Allowances\Allowance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Rrhh\Authority;
use App\Notifications\Allowances\NewAllowance;
use App\Notifications\Allowances\EndAllowance;
use App\Notifications\Allowances\RejectedAllowance;

class AllowanceSignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Allowances\AllowanceSign  $allowanceSign
     * @return \Illuminate\Http\Response
     */
    public function show(AllowanceSign $allowanceSign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Allowances\AllowanceSign  $allowanceSign
     * @return \Illuminate\Http\Response
     */
    public function edit(AllowanceSign $allowanceSign)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Allowances\AllowanceSign  $allowanceSign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AllowanceSign $allowanceSign, $status, Allowance $allowance)
    {
        if($status == 'accepted'){
            $allowanceSign->user_id = Auth::user()->id;
            $allowanceSign->status = $status;
            $allowanceSign->date_sign = Carbon::now();
            $allowanceSign->save();

            $nextAllowanceSign = $allowanceSign->allowance->allowanceSigns->where('position', $allowanceSign->position + 1);

            if(!$nextAllowanceSign->isEmpty()){
                $nextRequestSign = $allowanceSign->allowance->allowanceSigns->where('position', $allowanceSign->position + 1)->first();
                $nextRequestSign->status = 'pending';
                $nextRequestSign->save();

                //SE NOTIFICA PARA INICIAR EL PROCESO DE APROBACION
                $notification = Authority::getAuthorityFromDate($nextRequestSign->organizational_unit_id, Carbon::now(), 'manager');
                $notification->user->notify(new NewAllowance($allowance));

                session()->flash('success', 'Estimado Usuario: Se aceptó viático con exito.');
                return redirect()->route('allowances.sign_index');
            }
            else{
                //SE NOTIFICA FIN DE PROCESO DE APROBACION
                $allowance->userAllowance->notify(new EndAllowance($allowance));
                $allowance->userCreator->notify(new EndAllowance($allowance));

                session()->flash('success', 'Estimado Usuario: Su solicitud de viático ha sido Aceptada en su totalidad.');
                return redirect()->route('allowances.sign_index');
            }

        }
        if($status == 'rejected'){
            $allowanceSign->user_id = Auth::user()->id;
            $allowanceSign->status = $status;
            $allowanceSign->observation = $request->observation;
            $allowanceSign->date_sign = Carbon::now();
            $allowanceSign->save();
    
            // $requestReplacementStaff->request_status = 'rejected';
            // $requestReplacementStaff->save();
    
            //SE NOTIFICA RECHAZO DE VIATICO
            $allowance->userCreator->notify(new RejectedAllowance($allowance));
            $allowance->userAllowance->notify(new RejectedAllowance($allowance));
    
            session()->flash('danger', 'Su solicitud de viático ha sido Rechazada con éxito.');
            return redirect()->route('allowances.sign_index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Allowances\AllowanceSign  $allowanceSign
     * @return \Illuminate\Http\Response
     */
    public function destroy(AllowanceSign $allowanceSign)
    {
        //
    }
}
