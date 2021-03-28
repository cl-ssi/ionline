<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\ServiceRequests\ServiceRequest;

class ServicerequestFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'servicerequest:files';

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
        $srs = ServiceRequest::all();
        foreach($srs as $sr) {
            if($sr->has_resolution_file) {
                $name = 'service_request/resolutions/'.$sr->id.'.pdf';
                $file = Storage::disk('local')->get($name);
                Storage::disk('gcs')->put('ionline/'.$name, $file);
                echo $name."\n";
            }
            foreach($sr->fulfillments as $f){
                if($f->has_invoice_file){
                    $name = 'service_request/invoices/'.$f->id.'.pdf';
                    $file = Storage::disk('local')->get($name);
                    Storage::disk('gcs')->put('ionline/'.$name, $file);
                    echo $name."\n";
                }
            }
        }
        return 0;
    }
}
