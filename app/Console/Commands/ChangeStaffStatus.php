<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ReplacementStaff\Applicant;
use Carbon\Carbon;

class ChangeStaffStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change:staffStatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change replacement staff status at midnight';

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
        $applicants = Applicant::where('selected', 1)
            ->latest()
            ->whereDate('end_date', '<', Carbon::now()->toDateString())
            ->get();

        foreach ($applicants as $key => $applicant) {
            $applicant->replacementStaff->update(['status' => 'immediate_availability']);
        }
    }
}
