<?php

namespace App\Http\Controllers\ReplacementStaff;

use App\Models\ReplacementStaff\RequestReplacementStaff;
use App\Models\ReplacementStaff\ReplacementStaff;
use App\Models\ReplacementStaff\RequestSign;
use App\Rrhh\OrganizationalUnit;
use App\Rrhh\Authority;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class RequestReplacementStaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requestReplacementStaff = RequestReplacementStaff::orderBy('id', 'DESC')
            ->paginate(10);

        return view('replacement_staff.request.index', compact('requestReplacementStaff'));
    }

    public function own_index()
    {
        $my_pending_requests = RequestReplacementStaff::latest()
            ->where('user_id', Auth::user()->id)
            ->where(function ($q){
              	$q->doesntHave('technicalEvaluation')
                ->orWhereHas('technicalEvaluation', function( $query ) {
                  $query->where('technical_evaluation_status','pending');
                });
            })
            ->WhereHas('requestSign', function($j) {
              $j->Where('request_status', 'pending');
            })
            ->get();

        $my_request = RequestReplacementStaff::latest()
            ->where('user_id', Auth::user()->id)
            ->where(function ($q){
              $q->whereHas('requestSign', function($j) {
                $j->Where('request_status', 'rejected');
              })
              ->orWhereHas('technicalEvaluation', function($y){
                  $y->Where('technical_evaluation_status', 'complete')
                  ->OrWhere('technical_evaluation_status', 'rejected');
              });
            })
            ->get();

        return view('replacement_staff.request.own_index', compact('my_request', 'my_pending_requests'));
    }

    public function ou_index()
    {
        $ou_request = RequestReplacementStaff::where('organizational_unit_id', Auth::user()->organizationalUnit->id)
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('replacement_staff.request.ou_index', compact('ou_request'));
    }

    public function to_sign(RequestReplacementStaff $requestReplacementStaff)
    {
        $date = Carbon::now();
        $type = 'manager';
        $user_id = Auth::user()->id;

        $authorities = Authority::getAmIAuthorityFromOu($date, $type, $user_id);

        if(!empty($authorities)){
            foreach ($authorities as $authority) {

                $request_to_sign = RequestReplacementStaff::latest()
                    ->whereHas('requestSign', function($q) use ($authority){
                        $q->Where('organizational_unit_id', $authority->organizational_unit_id)
                        ->Where('request_status', 'pending');
                    })
                    ->get();

                $request_to_sign_accepted = RequestReplacementStaff::latest()
                    ->whereHas('requestSign', function($q) use ($authority){
                        $q->Where('organizational_unit_id', $authority->organizational_unit_id)
                        ->Where('request_status', 'accepted')
                        ->OrWhere('request_status', 'rejected');
                    })
                    ->paginate(10);
            }
            return view('replacement_staff.request.to_sign', compact('request_to_sign', 'request_to_sign_accepted'));
        }

        session()->flash('danger', 'Estimado Usuario/a: Usted no dispone de solicitudes para aprobación.');
        return redirect()->route('replacement_staff.request.own_index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('replacement_staff.request.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request_replacement = new RequestReplacementStaff($request->All());
        $request_replacement->user()->associate(Auth::user());
        $request_replacement->organizational_unit_id = Auth::user()->organizationalUnit->id;
        $request_replacement->save();

        $uo_request = OrganizationalUnit::where('id', $request_replacement->organizational_unit_id)
            ->get()
            ->last();

        // UO Nivel 1  Director
        if($uo_request->level == 1){

            for ($i = 1; $i <= 2; $i++) {

                $request_sing = new RequestSign();

                $date = Carbon::now()->format('Y_m_d_H_i_s');
                $type = 'manager';
                $user_id = Auth::user()->id;

                $iam_authority = Authority::getAmIAuthorityFromOu($date, $type, $user_id);

                if(!empty($iam_authority)){
                    if ($i == 1) {
                        $request_sing->position = '1';
                        $request_sing->ou_alias = 'sub_rrhh';
                        $request_sing->organizational_unit_id = 44;
                        $request_sing->request_status = 'pending';
                    }

                    if ($i == 2) {
                        $request_sing->position = '2';
                        $request_sing->ou_alias = 'dir';
                        $request_sing->organizational_unit_id = $request_replacement->organizational_unit_id;
                        $request_sing->request_status = 'accepted';
                    }
                }
                else{
                  if ($i == 1) {
                      $request_sing->position = '1';
                      $request_sing->ou_alias = 'sub_rrhh';
                      $request_sing->organizational_unit_id = 44;
                      $request_sing->request_status = 'pending';
                  }

                  if ($i == 2) {
                      $request_sing->position = '2';
                      $request_sing->ou_alias = 'dir';
                      $request_sing->organizational_unit_id = $request_replacement->organizational_unit_id;
                      $request_sing->request_status = 'pending';
                  }
                }
                $request_sing->request_replacement_staff_id = $request_replacement->id;
                $request_sing->save();
            }
        }

        //UO Nivel 2 SUB Direcciones - Deptos.
        if($uo_request->level == 2){

            for ($i = 1; $i <= 3; $i++) {
                $request_sing = new RequestSign();

                $date = Carbon::now()->format('Y_m_d_H_i_s');
                $type = 'manager';
                $user_id = Auth::user()->id;

                $iam_authority = Authority::getAmIAuthorityFromOu($date, $type, $user_id);

                if(!empty($iam_authority)){
                    if($i == 1){
                        $request_sing->position = '1';
                        $request_sing->ou_alias = 'leadership';
                        $request_sing->organizational_unit_id = $request_replacement->organizational_unit_id;
                        $request_sing->request_status = 'accepted';
                    }
                    if ($i == 2) {
                        $request_sing->position = '2';
                        $request_sing->ou_alias = 'sub_rrhh';
                        $request_sing->organizational_unit_id = 44;
                        $request_sing->request_status = 'pending';
                    }

                    if ($i == 3) {
                        $request_sing->position = '2';
                        $request_sing->ou_alias = 'dir';
                        $request_sing->organizational_unit_id = $uo_request->father->id;
                    }
                }
                else{
                    if($i == 1){
                        $request_sing->position = '1';
                        $request_sing->ou_alias = 'leadership';
                        $request_sing->organizational_unit_id = $request_replacement->organizational_unit_id;
                        $request_sing->request_status = 'pending';
                    }
                    if ($i == 2) {
                        $request_sing->position = '2';
                        $request_sing->ou_alias = 'sub_rrhh';
                        $request_sing->organizational_unit_id = 44;
                    }

                    if ($i == 3) {
                        $request_sing->position = '3';
                        $request_sing->ou_alias = 'dir';
                        $request_sing->organizational_unit_id = $uo_request->father->id;
                    }
                }
                $request_sing->request_replacement_staff_id = $request_replacement->id;
                $request_sing->save();
            }
        }

        //UO Nivel 3 Deptos. bajo SUB Direcciones.
        if($uo_request->level == 3){

            for ($i = 1; $i <= 3; $i++) {
                $request_sing = new RequestSign();

                $date = Carbon::now()->format('Y_m_d_H_i_s');
                $type = 'manager';
                $user_id = Auth::user()->id;

                $iam_authority = Authority::getAmIAuthorityFromOu($date, $type, $user_id);

                if(!empty($iam_authority)){
                    if($i == 1){
                        $request_sing->position = '1';
                        $request_sing->ou_alias = 'leadership';
                        $request_sing->organizational_unit_id = $request_replacement->organizational_unit_id;
                        $request_sing->request_status = 'accepted';
                    }
                    if ($i == 2) {
                      $request_sing->position = '2';
                      $request_sing->ou_alias = 'sub';
                      $request_sing->organizational_unit_id = $uo_request->father->id;
                    }

                    if ($i == 3) {
                        $request_sing->position = '2';
                        $request_sing->ou_alias = 'sub_rrhh';
                        $request_sing->organizational_unit_id = 44;
                    }
                }
                else{

                    if($i == 1){
                        $request_sing->position = '1';
                        $request_sing->ou_alias = 'leadership';
                        $request_sing->organizational_unit_id = $request_replacement->organizational_unit_id;
                        $request_sing->request_status = 'pending';
                    }
                    if ($i == 2) {
                      $request_sing->position = '2';
                      $request_sing->ou_alias = 'sub';
                      $request_sing->organizational_unit_id = $uo_request->father->id;
                    }

                    if ($i == 3) {
                        $request_sing->position = '3';
                        $request_sing->ou_alias = 'sub_rrhh';
                        $request_sing->organizational_unit_id = 44;
                    }
                }
                $request_sing->request_replacement_staff_id = $request_replacement->id;
                $request_sing->save();
            }
        }

        session()->flash('success', 'Se ha creado la Solicitud Exitosamente');
        return redirect()->route('replacement_staff.request.own_index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RequestReplacementStaff  $requestReplacementStaff
     * @return \Illuminate\Http\Response
     */
    public function show(RequestReplacementStaff $requestReplacementStaff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RequestReplacementStaff  $requestReplacementStaff
     * @return \Illuminate\Http\Response
     */
    public function edit(RequestReplacementStaff $requestReplacementStaff)
    {
        return view('replacement_staff.request.edit', compact('requestReplacementStaff'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RequestReplacementStaff  $requestReplacementStaff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RequestReplacementStaff $requestReplacementStaff)
    {
        $requestReplacementStaff->fill($request->all());
        $requestReplacementStaff->save();
        session()->flash('success', 'Su solicitud ha sido sido correctamente actualizada.');
        return redirect()->route('replacement_staff.edit', $requestReplacementStaff);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RequestReplacementStaff  $requestReplacementStaff
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequestReplacementStaff $requestReplacementStaff)
    {
        //
    }
}
