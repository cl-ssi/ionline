<?php

namespace App\Console\Commands;

use App\Models\Rrhh\NoAttendanceRecord;
use Illuminate\Console\Command;

class FixAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:attendance';

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
        // Get all attendance records created_at since 30 days ago
        // $records = NoAttendanceRecord::with('approval','approval.sentToOu','approval.approver','authority','authority.organizationalUnit')
        //     ->where('created_at', '>=', now()->subDays(40))->get();

        // foreach ($records as $record) {
        //     // Print record id if record doesnt have approval relation
        //     // if($record->id == 13700) 
        //     // {
        //     //     dd($record->approval);
        //     // }
        //     if (!$record->authority->organizationalUnit->is($record->approval->sentToOu)) {
        //         // echo $record->id . PHP_EOL;
        //         // Si el status del approval es null
        //         if (is_null($record->approval->status)) {
        //             echo $record->id . ' ' . $record->authority->organizational_unit_id . ' ' .  $record->approval->sent_to_ou_id . PHP_EOL;
        //             // setear $record->approval->sent_to_ou_id = $record->authority->organizational_unit_id
        //             $record->approval->sent_to_ou_id = $record->authority->organizational_unit_id;
        //             $record->approval->save();
        //         }
        //         else {
        //             if($record->approval->approver->is($record->user)) {
        //                 echo $record->id . ' ' . $record->approval->approver_id . ' ' .  $record->user_id . PHP_EOL;
        //             }
        //         }
        //     }

        // }

        $records = NoAttendanceRecord::with('user','approval','approval.sentToOu','approval.approver','authority','authority.organizationalUnit')
            ->where('created_at', '>=', now()->subDays(40))->get();
        
        foreach ($records as $record) {
            if($record->user_id == $record->authority_id) {
                echo $record->id . ' ' . $record->user_id . ' ' .  $record->authority_id . PHP_EOL;
                
                $record->authority_id = $record->user->boss->id;
                $record->authority_at = null;
                $record->status = null;
                $record->save();

                $record->approval->resetStatus();
                $record->approval->sent_to_ou_id = $record->user->boss->organizational_unit_id;
                $record->approval->save();
            }
        }
        return Command::SUCCESS;
    }
}
