<?php

namespace App\Http\Controllers\ReplacementStaff;

use App\Models\ReplacementStaff\RequestReplacementStaff;
use App\Models\ReplacementStaff\ReplacementStaff;
use App\Models\ReplacementStaff\RequestSing;
use App\Rrhh\OrganizationalUnit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class RequestReplacementStaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requests = RequestReplacementStaff::orderBy('id', 'DESC')
            ->paginate(10);

        return view('replacement_staff.request.index', compact('requests'));
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

    public function to_select(RequestReplacementStaff $requestReplacementStaff)
    {


        return view('replacement_staff.request.to_select', compact('requestReplacementStaff'));
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

        $request_sing = new RequestSing();
        $request_sing->leadership_organizational_unit_id = $request_replacement->organizational_unit_id;
        $request_sing->leadership_request_status = 'pending';

        //SUB
        $direct_sub = OrganizationalUnit::where('id', $request_sing->leadership_organizational_unit_id)
            ->get()
            ->last();

        switch ($direct_sub->level) {
            case 2:
                $request_sing->sub_organizational_unit_id = $request_replacement->organizational_unit_id;
                break;
            case 3:
                $request_sing->sub_organizational_unit_id = $direct_sub->father->id;
                break;
            case 4:
                $request_sing->sub_organizational_unit_id = $direct_sub->father->father->id;
                break;
            case 5:
                $request_sing->sub_organizational_unit_id = $direct_sub->father->father->father->id;
                break;
        }

        $request_sing->sub_request_status = 'pending';

        //SUB RRHH
        $request_sing->sub_rrhh_organizational_unit_id = 44;
        $request_sing->sub_rrhh_request_status = 'pending';

        $request_sing->request_replacement_staff_id = $request_replacement->id;

        $request_sing->save();

        //AuthorityFromDate($ou_id, $date, $type)

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
        //
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
