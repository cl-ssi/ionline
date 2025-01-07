<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class ProcessSqlLine implements ShouldQueue, ShouldBeUnique 
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
     * The number of seconds after which the job's unique lock will be released.
     *
     * @var int
     */
    public $uniqueFor = 120;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::connection('mysql_rem')->insert($this->sql);
    }

    /**
     * Get the unique ID for the job.
     */
    public function uniqueId(): string
    {
        return $this->sql;
    }
}
