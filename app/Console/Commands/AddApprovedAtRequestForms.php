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
        $requestForms = RequestForm::with('eventRequestForms')->where('status', 'approved')->whereNull('approved_at')->get();

        foreach ($requestForms as $requestForm) {
            $requestForm->approved_at = $requestForm->eventRequestForms->where('event_type', 'supply_event')->where('status', 'approved')->last()->signature_date;
            $requestForm->save();
        }

        return 0;
    }
}
