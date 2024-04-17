<?php

namespace App\Http\Controllers\Rrhh;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rrhh\PerformanceReport;
use Barryvdh\DomPDF\Facade\Pdf;

class CalificationController extends Controller
{
    //

    public function show($userId, $periodId)
    {
        $report = PerformanceReport::where('received_user_id', $userId)
            ->where('period_id', $periodId)
            ->first();

        if ($report) {

            $latestApproval = $report->approvals()->where('sent_to_user_id', auth()->user()->id)
            ->whereNull('status')
            ->latest()
            ->first();

            if ($latestApproval) {
                $latestApproval->update([
                    'status' => 1,
                    'approver_id' => auth()->user()->id,
                    'approver_ou_id' => auth()->user()->organizational_unit_id,
                    'approver_at' => now(),
                ]);
            }


            $establishment = $report->createdUser->organizationalUnit->establishment;
            return Pdf::loadView('rrhh.performance_report.show', [
                'report' => $report,
                'establishment' => $establishment,
            ])->stream('download.pdf');
        }

        // Manejar el caso cuando el informe no existe
        return redirect()->back()->with('error', 'El informe no existe');
    }
    


}
