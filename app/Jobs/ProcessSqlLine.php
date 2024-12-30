<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class ProcessSqlLine implements ShouldQueue
{
    use Queueable;

    protected $sql;

    /**
     * Create a new job instance.
     */
    public function __construct($sql)
    {
        $this->sql = $sql;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $connection = DB::connection('mysql_rem');
        $connection->unprepared($this->sql);
    }
}
