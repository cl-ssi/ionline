<?php

namespace App\Console\Commands;

use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Console\Command;

class FixNotificationUrl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'FixNotificationUrl';

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
        $pattern = '#^https?://[^/]+#';
        $notifications = DatabaseNotification::all();
        foreach($notifications as $notification) {
            $data = $notification->data;
            $url = $data['action'];
            $new_url = preg_replace($pattern, '', $url);
            $data['action'] = $new_url;
            $notification->data = $data;
            $notification->save();
            echo $url . ' ' . $new_url."\n";
        }
        return 0;
    }
}
