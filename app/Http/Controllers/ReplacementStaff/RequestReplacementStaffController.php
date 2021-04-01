<?php

namespace App\Http\Controllers\ReplacementStaff;

use App\Models\ReplacementStaff\RequestReplacementStaff;
use App\Models\ReplacementStaff\ReplacementStaff;
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
        // $my_request = RequestReplacementStaff::where('user_id', Auth::user()->id)
        //     ->orderBy('id', 'DESC')
        //     ->paginate(10);
        //
        // $ou_request = RequestReplacementStaff::where('organizational_unit_id', Auth::user()->organizationalUnit->id)
        //     ->orderBy('id', 'DESC')
        //     ->paginate(10);
        //
        // return view('replacement_staff.request.index', compact('my_request', 'ou_request'));
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
