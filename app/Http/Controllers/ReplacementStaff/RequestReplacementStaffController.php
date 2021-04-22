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
        $my_request = RequestReplacementStaff::where('user_id', Auth::user()->id)
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('replacement_staff.request.own_index', compact('my_request'));
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
                        $q->Where('organizational_unit_id', $authority->organizational_unit_id);
                    })
                    ->paginate(10);
            }
            return view('replacement_staff.request.to_sign', compact('request_to_sign'));
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

        for ($i = 1; $i <= 3; $i++) {
            $request_sing = new RequestSign();
            if($i == 1){
                $request_sing->position = '1';
                $request_sing->ou_alias = 'leadership';
                $request_sing->organizational_unit_id = $request_replacement->organizational_unit_id;
                $request_sing->request_status = 'pending';
            }
            if ($i == 2) {
                $request_sing->position = '2';
                $request_sing->ou_alias = 'sub';

                //SUB
                $direct_sub = OrganizationalUnit::where('id', $request_replacement->organizational_unit_id)
                    ->get()
                    ->last();

                // dd($direct_sub);

                switch ($direct_sub->level) {
                    case 2:
                        $request_sing->organizational_unit_id = $direct_sub->id;
                        break;
                    case 3:
                        $request_sing->organizational_unit_id = $direct_sub->father->id;
                        break;
                    case 4:
                        $request_sing->organizational_unit_id = $direct_sub->father->father->id;
                        break;
                    case 5:
                        $request_sing->organizational_unit_id = $direct_sub->father->father->father->id;
                        break;
                }

            }
            if ($i == 3) {
                $request_sing->position = '3';
                $request_sing->ou_alias = 'sub_rrhh';
                $request_sing->organizational_unit_id = 44;
            }
            $request_sing->request_replacement_staff_id = $request_replacement->id;
            $request_sing->save();
        }

        session()->flash('success', 'Se ha creado la Solicitud Exitosamente');
        return redirect()->route('replacement_staff.request.index');
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
        //
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
