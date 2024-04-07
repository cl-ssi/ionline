<?php

namespace App\Jobs;

// use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Bus\Queueable;
use App\Models\User;
// use App\Mail\TestMail;

class TestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        logger()->info('La cola se ejecutó correctamente la cola por '.$this->user->shortName);
        // try {
            // Mail::to($this->user->email)
            //     ->send(new TestMail($this->user));
        // } catch (\Exception $exception) {
        //     logger()->info($exception->getMessage());
        // }
    }
}
