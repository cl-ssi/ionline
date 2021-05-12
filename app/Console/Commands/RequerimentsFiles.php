<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Requirements\Event;
use Illuminate\Support\Facades\Storage;

class RequerimentsFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'requeriments:files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migra los archivos de requerimientos a GCS';

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
        //echo'funciono';
        $events = Event::whereHas('files')->get();
        foreach ($events as $event) {
            foreach ($event->files as $file) {
                list($folder,$name) = explode('/',$file->file);
                echo $name."\n";
                $file->update(['file' => 'ionline/requirements/'.$name]);
                $file = Storage::disk('local')->get($file->file);
                Storage::disk('gcs')->put('ionline/requirements/'.$name, $file);

            }

        }
        
        return 0;
    }
}
