<?php

namespace App\Http\Controllers\ServiceRequests;

use Illuminate\Http\Request;
use App\Models\Rrhh\OrganizationalUnit;
use App\Http\Controllers\Controller;
use App\Models\ServiceRequests\OrganizationalUnitLimit;

class OrganizationalUnitLimitController extends Controller
{
    public function index(Request $request)
    {
        $organizationalUnitLimits = OrganizationalUnitLimit::whereHas("organizationalUnit", function ($q) {
                                                                $q->whereHas("establishment", function ($q) {
                                                                    $q->where('id', auth()->user()->establishment_id);
                                                                });
                                                            })->get();
        return view('service_requests.organizational_unit_limits.index', compact('organizationalUnitLimits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $organizationalUnits = OrganizationalUnit::whereHas("establishment", function ($q) {
                                                        $q->where('id', auth()->user()->establishment_id);
                                                    })->get();
        return view('service_requests.organizational_unit_limits.create',compact('organizationalUnits'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $organizationalUnitLimit = new OrganizationalUnitLimit($request->All());
      $organizationalUnitLimit->save();

      session()->flash('info', 'El tope ha sido registrado.');
      return redirect()->route('rrhh.service-request.organizational_unit_limits.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pharmacies\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(OrganizationalUnitLimit $organizationalUnitLimit)
    {
        $organizationalUnits = OrganizationalUnit::whereHas("establishment", function ($q) {
                                                        $q->where('id', auth()->user()->establishment_id);
                                                    })->get();
        return view('service_requests.organizational_unit_limits.edit', compact('organizationalUnitLimit','organizationalUnits'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pharmacies\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrganizationalUnitLimit $organizationalUnitLimit)
    {
        $organizationalUnitLimit->fill($request->all());
        $organizationalUnitLimit->save();

        session()->flash('info', 'El tope ha sido actualizado.');
        return redirect()->route('rrhh.service-request.organizational_unit_limits.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pharmacies\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrganizationalUnitLimit $organizationalUnitLimit)
    {
      $organizationalUnitLimit->delete();
      session()->flash('success', 'El tope ha sido eliminado.');
      return redirect()->route('rrhh.service-request.organizational_unit_limits.index');
    }
}
