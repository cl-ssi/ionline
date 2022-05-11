<?php

namespace App\Console\Commands;

use App\Models\RequestForms\RequestForm;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AddApprovedAtRequestForms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'request-forms:add-approved-at';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $requestForms = RequestForm::all();

        foreach ($requestForms as $requestForm) {
            $supplyEvent = $requestForm->eventRequestForms->last();

            if($supplyEvent && $supplyEvent->status === 'approved'){
                $requestForm->approved_at = $supplyEvent->signature_date;
                $requestForm->save();
            }
        }

        return 0;
    }
}
