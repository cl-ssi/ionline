<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Documents\Parte;
use Illuminate\Support\Facades\Storage;

class ParteFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parte:files';

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
        $partes = Parte::whereHas('files')->get();
        foreach($partes as $parte) {
            foreach($parte->files as $file) {
                list($folder,$name) = explode('/',$file->file);
                echo $name."\n";
		        $file->update(['file' => 'ionline/documents/partes/'.$name]);
                $file = Storage::disk('local')->get($file->file);
                Storage::disk('gcs')->put('ionline/documents/partes/'.$name, $file);
            }
        }
        return 0;
    }
}
