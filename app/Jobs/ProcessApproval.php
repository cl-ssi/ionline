<?php

namespace App\Jobs;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Bus\Queueable;
use App\Models\Documents\Approval;

class ProcessApproval implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    /**
     * The podcast instance.
     *
     * @var \App\Models\Documents\Approval
     */
    public $approval;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Approval $approvalSelected)
    {
        $this->approval = $approvalSelected;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        app()->call($this->approval->callback_controller_method, 
            json_decode($this->approval->callback_controller_params,true));
    }
}
