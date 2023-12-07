<?php

namespace App\Http\Controllers\Finance\Receptions;

use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\User;
use App\Notifications\Documents\Partes\NewNumeration;
use App\Models\Finance\Receptions\Reception;
use App\Models\Documents\Approval;
use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Support\Facades\Storage;

class ReceptionController extends Controller
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
     * Display the specified resource.
     *
     * @param  \App\Models\Finance\Receptions\Reception  $reception
     * @return \Illuminate\Http\Response
     */
    public function show($reception_id)
    {
        $reception = Reception::find($reception_id);
        $establishment = $reception->creator->organizationalUnit->establishment;
        return Pdf::loadView('finance.receptions.show', [
            'reception' => $reception,
            'establishment' => $establishment
        ])->stream('download.pdf');

        // return view('finance.receptions.show', compact('reception'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Finance\Receptions\Reception  $reception
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reception $reception)
    {
        //
    }

    /**
    * Approval Callback
    */
    public function approvalCallback($approval_id) {
        $approval = Approval::find($approval_id);
        if($approval->status == true) {
            $approval->approvable->numeration()->create([
                'automatic' => true,
                'doc_type_id' => 11,
                'file_path' => $approval->filename,
                'subject' => $approval->subject,
                'user_id' => $approval->approver->id, // Responsable del documento numerado
                'organizational_unit_id' => $approval->sent_to_ou_id ?? $approval->approverOu->id, // Ou del responsable
                'establishment_id' => $approval->approverOu->establishment->id,
            ]);

            $approval->approvable->responsable_id = $approval->approver->id;
            $approval->approvable->save();

            $establishment_id = $approval->approverOu->establishment->id;

            /* Users wiwth permission Partes: numerator */
            $users = User::permission('Partes: numerator')
                ->whereHas('organizationalUnit', function ($query) use ($establishment_id) {
                    $query->where('establishment_id', $establishment_id);
                }
            )->get();

            Notification::send($users, new NewNumeration());
        }
    }
}
