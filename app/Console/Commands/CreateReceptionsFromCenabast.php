<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Finance\Receptions\Reception;
use App\Models\Finance\Dte;

class CreateReceptionsFromCenabast extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CreateReceptionsFromCenabast';

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
        
        $dtes = Dte::whereNotNull('cenabast_reception_file')
            ->whereNotNull('all_receptions_user_id')
            ->get();

        foreach($dtes as $dte) {
            $reception = Reception::updateOrCreate(
                ['dte_id' => $dte->id],
                [
                    'date'              => $dte->all_receptions_at,
                    'responsable_id'    => $dte->all_receptions_user_id,
                    'responsable_ou_id' => $dte->all_receptions_ou_id,
                    'creator_id'        => $dte->all_receptions_user_id,
                    'creator_ou_id'     => $dte->all_receptions_ou_id,
                    'reception_type_id' => 1,
                    'establishment_id'  =>  $dte->establishment_id,
                    'purchase_order'    =>  $dte->folio_oc,
                ]);
            
            $reception->files()->updateOrCreate(
                [ 'type' => 'signed_file' ],
                [
                    'storage_path'  => $dte->cenabast_reception_file,
                    'stored'        => true,
                    'type'          => 'signed_file',
                    'stored_by_id'  => $dte->all_receptions_user_id,
                ]);
        }
        return Command::SUCCESS;
    }
}
