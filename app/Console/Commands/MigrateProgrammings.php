<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Commune;
use App\Models\Programmings\CommuneFile;
use Illuminate\Support\Facades\Storage;

class MigrateProgrammings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'programmings:files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'migrate Commune model_s files from local production storage to GCS';

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
      $communes = Commune::whereHas('communeFiles')->get();
      foreach ($communes as $commune) {
          echo "\n";
          echo "ID de Comuna: ".$commune->id."\n";
          foreach ($commune->communeFiles as $communefile) {
              if(!empty($communefile->file_a)){
              list($folder,$name) = explode('/',$communefile->file_a);
              echo $name." file a\n";
              //$communefile->update(['file_a' => 'ionline/programmings/'.$name]);
              $file = Storage::disk('local')->get($communefile->file_a);
              Storage::disk('gcs')->put('ionline/programmings/'.$name, $file);
            }
              if(!empty($communefile->file_b)){
              list($folder,$name) = explode('/',$communefile->file_b);
              echo $name." file b\n";
              //$communefile->update(['file_b' => 'ionline/programmings/'.$name]);
              $file = Storage::disk('local')->get($communefile->file_b);
              Storage::disk('gcs')->put('ionline/programmings/'.$name, $file);
            }
              if(!empty($communefile->file_c)){
              list($folder,$name) = explode('/',$communefile->file_c);
              echo $name." file c\n";
              //$communefile->update(['file_c' => 'ionline/programmings/'.$name]);
              $file = Storage::disk('local')->get($communefile->file_c);
              Storage::disk('gcs')->put('ionline/programmings/'.$name, $file);
            }
          }
              echo "\n";
      }
      return 0;
    }
}
