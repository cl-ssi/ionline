<?php

namespace App\Console\Commands;

use App\Models\Documents\SignaturesFile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class SignaturesFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'signatures:files {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update files from local to GCS';

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
        $original = SignaturesFile::find($this->argument('id'));
        $file = base64_decode($original->file);
        $filePath = 'ionline/signatures/original/' . $original->id . '.pdf';
        Storage::disk('gcs')->put($filePath, $file);
        $original->file = $filePath;
        $original->save();
        echo $original->file . "\n";

        /*

        $originalSignaturesFiles = SignaturesFile::whereNotNull('file')->get();
        $signedSignaturesFiles = SignaturesFile::whereNotNull('signed_file')->get();

        foreach ($originalSignaturesFiles as $originalSignaturesFile) {
            $file = base64_decode($originalSignaturesFile->file);
            $filePath = 'ionline/signatures/original/' . $originalSignaturesFile->id . '.pdf';
            Storage::disk('gcs')->put($filePath, $file);
            $originalSignaturesFile->file = $filePath;
            $originalSignaturesFile->save();
            echo $originalSignaturesFile->file . "\n";
        }

        foreach ($signedSignaturesFiles as $signedSignaturesFile) {
            $file = base64_decode($signedSignaturesFile->signed_file);
            $filePath = 'ionline/signatures/signed/' . $signedSignaturesFile->id . '.pdf';
            Storage::disk('gcs')->put($filePath, $file);
            $signedSignaturesFile->signed_file = $filePath;
            $signedSignaturesFile->save();
            echo $signedSignaturesFile->signed_file . "\n";
        }
        */
        return 0;
    }
}
