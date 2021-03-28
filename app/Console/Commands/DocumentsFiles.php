<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Documents\Document;

class DocumentsFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'document:files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update files from local tu GCS';

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
        $documents = Document::whereNotNull('file')->get();
        foreach($documents as $document) {
            list($folder,$name) = explode('/',$document->file);
            echo $name."\n";
            // $file = Storage::disk('local')->get($document->file);
            // Storage::disk('gcs')->put('ionline/documents/documents/'.$name, $file);
            // $document->update(['file' => 'ionline/documents/documents/'.$name]);
        }
        return 0;
    }
}
