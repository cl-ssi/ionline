<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Pharmacies\Dispatch;
use Illuminate\Support\Facades\Storage;

class PharmaciesFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pharmacies:files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update files from local frm_files to GCS';

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
        $dispatchs = Dispatch::whereHas('files')->get();        
        foreach ($dispatchs as $dispatch) {
            foreach ($dispatch->files as $file) {
                list($folder,$name) = explode('/',$file->file);
                echo $name."\n";
                $file->update(['file' => 'ionline/pharmacies/'.$name]);
                $file = Storage::disk('local')->get($file->file);
                Storage::disk('gcs')->put('ionline/pharmacies'.$name, $file);                
            }
        }

        return 0;
    }
}
