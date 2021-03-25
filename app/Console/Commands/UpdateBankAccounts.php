<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \App\Models\ServiceRequests\ServiceRequest;

class UpdateBankAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:bankaccounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza todas las cuentas bancarias de service requests';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $srs = \App\Models\ServiceRequests\ServiceRequest::orderByDesc('id')->whereNotNull('account_number')->get();
        echo "Solicitudes:" . count($srs) . "\n";
        foreach($srs as $sr) {
            $sr_same_user = \App\Models\ServiceRequests\ServiceRequest::where('rut', $sr->rut)->get();
            foreach($sr_same_user as $sr_user) {
                $sr_user->update([
                    'bank_id' => $sr->bank_id, 
                    'account_number' => $sr->account_number, 
                    'pay_method'=>$sr->pay_method
                ]);
            }
        }
        return 0;
    }
}
