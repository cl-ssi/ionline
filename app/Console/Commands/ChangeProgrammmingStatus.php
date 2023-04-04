<?php

namespace App\Console\Commands;

use App\Models\Programmings\Programming;
use Illuminate\Console\Command;

class ChangeProgrammmingStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change:proStatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change programming status at midnight December 1';

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
        Programming::where('year', date("Y") + 1)->update(['status'=>'active']);
        $this->info('Programming status updated successfully.');
    }
}
