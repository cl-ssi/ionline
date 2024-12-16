<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateNotificationsToFilamentFormat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:convert-to-filament';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert Laravel notifications to Filament notification format';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Fetch all notifications
        $notifications = DB::table('notifications')->get();

        $updatedCount = 0;

        foreach ($notifications as $notification) {
            $data = json_decode($notification->data, true);

            // Skip if the notification is already in Filament format
            if (isset($data['format']) && $data['format'] === 'filament') {
                continue;
            }

            // Convert the Laravel notification data to Filament format
            $filamentData = [
                'actions' => [],
                'body' => $data['subject'] ?? null,
                'color' => null,
                'duration' => 'persistent',
                'icon' => $data['icon'] ?? null,
                'iconColor' => null,
                'status' => null,
                'title' => $data['module'] ?? 'Notification',
                'view' => 'filament-notifications::notification',
                'viewData' => [],
                'format' => 'filament',
                'subject' => $data['subject'] ?? null,
            ];

            // Update the notification in the database
            DB::table('notifications')
                ->where('id', $notification->id)
                ->update(['data' => json_encode($filamentData)]);

            $updatedCount++;
        }

        $this->info("Updated $updatedCount notifications to Filament format.");

        return Command::SUCCESS;
    }
}
