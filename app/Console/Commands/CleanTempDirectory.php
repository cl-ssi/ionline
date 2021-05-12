<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class CleanTempDirectory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:tempDir';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup temporary folder tmp_files on storage/public';

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
        $file = new Filesystem;
        $result = $file->cleanDirectory('storage/app/public/tmp_files');
        return $result ? $this->info('Se ejecutó correctamente comando clean:tempDir') : $this->error('Oops! algo ocurrió al momento de ejecutar el comando clean:tempDir');
    }
}
