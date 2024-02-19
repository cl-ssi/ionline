<?php

namespace App\Http\Controllers\ReplacementStaff;;

use App\Models\ReplacementStaff\ContactRecord;
use App\Models\ReplacementStaff\ReplacementStaff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ContactRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ReplacementStaff $staff)
    {
        $contactRecords = ContactRecord::latest()
          ->where('replacement_staff_id', $staff->id)
          ->get();
        return view('replacement_staff.contact_record.index', compact('staff', 'contactRecords'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ReplacementStaff $staff)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ReplacementStaff $staff)
    {
        $contactRecord = new ContactRecord($request->All());
        $contactRecord->replacementStaff()->associate($staff);
        $contactRecord->user()->associate(auth()->user());
        $contactRecord->save();

        session()->flash('success', 'El Registro de Contacto se ha guardado correctamente.');
        return redirect()->route('replacement_staff.contact_record.index', $staff);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContactRecord  $contactRecord
     * @return \Illuminate\Http\Response
     */
    public function show(ContactRecord $contactRecord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContactRecord  $contactRecord
     * @return \Illuminate\Http\Response
     */
    public function edit(ContactRecord $contactRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContactRecord  $contactRecord
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContactRecord $contactRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContactRecord  $contactRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContactRecord $contactRecord)
    {
        //
    }
}
