<?php

namespace App\Http\Controllers\ReplacementStaff;

use App\Models\ReplacementStaff\RequestSign;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RequestSignController extends Controller
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
     * @param  \App\Models\RequestSign  $requestSing
     * @return \Illuminate\Http\Response
     */
    public function show(RequestSign $requestSign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RequestSign  $requestSing
     * @return \Illuminate\Http\Response
     */
    public function edit(RequestSign $requestSign)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RequestSign  $requestSing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RequestSign $requestSign, $status)
    {
        if($status == 'accepted'){
            $requestSign->user_id = Auth::user()->id;
            $requestSign->request_status = $status;
            $requestSign->date_sign = Carbon::now()->format('Y_m_d_H_i_s');
            $requestSign->save();

            $nextRequestSign = $requestSign->requestReplacementStaff->requestSign->where('position', $requestSign->position + 1);

            if(!$nextRequestSign->isEmpty()){
              $nextRequestSign = $requestSign->requestReplacementStaff->requestSign->where('position', $requestSign->position + 1)->first();
              $nextRequestSign->request_status = 'pending';
              $nextRequestSign->save();

              // AQUI ENVIAR NOTIFICACIÓN DE CORREO ELECTRONICO AL NUEVO VISADOR.

              session()->flash('success', 'Su la solicitud ha sido Aceptada con exito.');
              return redirect()->route('replacement_staff.request.to_sign');
            }
            else{
                session()->flash('success', 'Su la solicitud ha sido Aceptada en su totalidad.');
                return redirect()->route('replacement_staff.request.to_sign');
            }

        }
        else{
          $requestSign->user_id = Auth::user()->id;
          $requestSign->request_status = $status;
          $requestSign->date_sign = Carbon::now()->format('Y_m_d_H_i_s');
          $requestSign->save();

          session()->flash('danger', 'Su solicitud ha sido Rechazada con éxito.');
          return redirect()->route('replacement_staff.request.to_sign');
        }

        // session()->flash('success', 'Su solicitud ha sido.');
        // return redirect()->route('replacement_staff.edit', $replacementStaff);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RequestSign  $requestSing
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequestSign $requestSign)
    {
        //
    }
}
