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

            // Mapeo de FontAwesome a Heroicons.
            $iconMapping = [
                '<i class="fas fa-wallet"></i>' => 'bi-wallet',
                '<i class="fas fa-question-circle"></i>' => 'bi-question-circle',
                '<i class="fas fa-bell"></i>' => 'bi-bell',
                '<i class="fas fa-fw fa-file-invoice-dollar"></i>' => 'bi-file-earmark-dollar',
                '<i class="fas fa-id-badge fa-fw"></i>' => 'bi-person-badge',
                '<i class="far fa-id-card"></i>' => 'bi-person-id',
                '<i class="fas fa-fw fa-clock"></i>' => 'bi-clock',
                '<i class="fas fa-fw fa-box-open"></i>' => 'bi-box',
                '<i class="fas fa-fw fa-boxes"></i>' => 'bi-archive',
            ];     
            
            // Convert the Laravel notification data to Filament format
            $filamentData = [
                'icon' => $iconMapping[$data['icon']] ?? null,
                'iconColor' => null,
                'title' => $data['module'] ?? 'Notification',
                'body' => $data['subject'] ?? null,
                'actions' => [
                    [
                        'name' => str_replace('\\', '_', $notification->type),
                        'label' => $data['action_label'] ?? 'Ver Notificación',
                        'url' => $data['action'] ?? null,
                        'color' => 'primary',
                        'icon' => 'heroicon-o-eye',
                        'shouldOpenInNewTab' => false,
                    ],
                ],
                'color' => null,
                'duration' => 'persistent',
                'status' => $data['status'] ?? 'info',
                'view' => 'filament-notifications::notification',
                'viewData' => ['additional_info' => $data['additional_info'] ?? null,],
                'format' => 'filament',
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
