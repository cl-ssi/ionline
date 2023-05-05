<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RequestForms\FormItemsExport;
use Carbon\Carbon;

class ProcessReportFormItems implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $resultExport;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($resultExport)
    {
        $this->resultExport = $resultExport;
        //dd($this->resultExport);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return Excel::download(new FormItemsExport($this->resultExport), 'requestFormsExport_'.now().'.xlsx');
    }
}
