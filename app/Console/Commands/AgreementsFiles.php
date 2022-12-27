<?php

namespace App\Console\Commands;

use App\Agreements\Addendum;
use App\Agreements\Agreement;
use App\Agreements\ProgramResolution;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class AgreementsFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'agreements:files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migra los archivos de convenios, addendums y sus resoluciones respectivamente a GCS';

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
        //file agreements
        $agreements = Agreement::whereNotNull('file')->get();
        foreach ($agreements as $agreement) {
            list($folder,$name) = explode('/',$agreement->file);
            echo $name."\n";
            $file = Storage::disk('local')->get($agreement->file);
            $agreement->update(['file' => 'ionline/agreements/agree/'.$name]);
            Storage::disk('gcs')->put('ionline/agreements/agree/'.$name, $file);
        }

        //file resolutions agreements
        $agreements = Agreement::whereNotNull('fileResEnd')->get();
        foreach ($agreements as $agreement) {
            list($folder,$name) = explode('/',$agreement->fileResEnd);
            echo $name."\n";
            $file = Storage::disk('local')->get($agreement->fileResEnd);
            $agreement->update(['fileResEnd' => 'ionline/agreements/agree_res/'.$name]);
            Storage::disk('gcs')->put('ionline/agreements/agree_res/'.$name, $file);
        }

        //file addendums
        $addendums = Addendum::whereNotNull('file')->get();
        foreach ($addendums as $addendum) {
            list($folder,$name) = explode('/',$addendum->file);
            echo $name."\n";
            $file = Storage::disk('local')->get($addendum->file);
            $addendum->update(['file' => 'ionline/agreements/addendum/'.$name]);
            Storage::disk('gcs')->put('ionline/agreements/addendum/'.$name, $file);
        }

        //file resolutions addendum
        $addendums = Addendum::whereNotNull('res_file')->get();
        foreach ($addendums as $addendum) {
            list($folder,$name) = explode('/',$addendum->res_file);
            echo $name."\n";
            $file = Storage::disk('local')->get($addendum->res_file);
            $addendum->update(['res_file' => 'ionline/agreements/addendum_res/'.$name]);
            Storage::disk('gcs')->put('ionline/agreements/addendum_res/'.$name, $file);
        }

        //file resolutions program
        $programs = ProgramResolution::whereNotNull('file')->get();
        foreach ($programs as $program) {
            list($folder,$name) = explode('/',$program->file);
            echo $name."\n";
            $file = Storage::disk('local')->get($program->file);
            $program->update(['file' => 'ionline/agreements/program_res/'.$name]);
            Storage::disk('gcs')->put('ionline/agreements/program_res/'.$name, $file);
        }
        
        return 0;
    }
}
