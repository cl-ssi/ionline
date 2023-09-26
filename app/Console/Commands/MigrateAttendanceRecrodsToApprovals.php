<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Rrhh\NoAttendanceRecord;

class MigrateAttendanceRecrodsToApprovals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:approvals';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $records = NoAttendanceRecord::all();
        foreach($records as $record) {
            $record->approvals()->create([
                "module" => "Asistencia",
                "module_icon" => "fas fa-clock",
                "subject" => $record->date . ' : ' . $record->user->shortName . ':<br>'. $record->observation, 
                "document_route_name" => "finance.purchase-orders.showByCode",
                "document_route_params" => json_encode(["1272565-444-AG23"]),
                "approver_id" => $record->authority_id,
                "approver_at" => $record->authority_at,
                "status" => $record->status,
                "reject_observation" => $record->authority_observation . ($record->rrhh_observation ? ' RRHH:'. $record->rrhh_observation : null),
            ]);
        }
        return Command::SUCCESS;
    }
}
