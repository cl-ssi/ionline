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

            // Obtener el ícono de FontAwesome (si existe)
            $faIcon = $data['icon'] ?? null;

            // Determinar el ícono a usar (por módulo o por mapeo de íconos existente)
            $module = $data['module'] ?? null;
            $moduleIcon = $this->getLegacyIcon($module); // Ícono para el sistema antiguo
            $bootstrapIcon = $this->getFilamentIcon($module); // Ícono BI para Filament

            // Mapeo de FontAwesome a Heroicons (para íconos generales)
            $iconMapping = [
                '<i class="fas fa-wallet"></i>' => 'bi-wallet',
                '<i class="fas fa-question-circle"></i>' => 'bi-question-circle',
                '<i class="fas fa-bell"></i>' => 'bi-bell',
                '<i class="fas fa-fw fa-file-invoice-dollar"></i>' => 'bi-cash-coin',
                '<i class="fas fa-id-badge fa-fw"></i>' => 'bi-person-badge',
                '<i class="far fa-id-card"></i>' => 'bi-card-text',
                '<i class="fas fa-fw fa-clock"></i>' => 'bi-clock',
                '<i class="fas fa-fw fa-box-open"></i>' => 'bi-box',
                '<i class="fas fa-fw fa-boxes"></i>' => 'bi-archive',
            ];

            // Determinar el ícono general si no es un ícono de módulo
            $generalIcon = $iconMapping[$faIcon] ?? 'bi-question-circle';

            // Convertir los datos de la notificación a un formato compatible con ambos sistemas
            $filamentData = [
                'icon' => $bootstrapIcon ?: $generalIcon, // Ícono BI (prioridad módulo, luego general)
                'fa_icon' => $faIcon,                     // Ícono FontAwesome original
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

    /**
     * Get the legacy FontAwesome icon for a module.
     */
    protected function getLegacyIcon($module)
    {
        $legacyIcons = [
            'Modificaciones Ficha APS' => 'fas fa-notes-medical',
            'Asistencia' => 'fas fa-clock',
            'Modulo Bodega' => 'fas fa-rocket',
            'Honorarios' => 'fas fa-rocket',
            'Plan de Compras' => 'fas fa-shopping-cart',
            'Perfil de Cargos' => 'fas fa-id-badge fa-fw',
            'Recepcion' => 'fas fa-list',
            'Viáticos' => 'bi bi-wallet',
            'Solicitudes de Contración' => 'bi bi-id-card',
            'Calificaciones' => 'bi bi-graph-up-arrow',
            'Drogas' => 'fas fa-cannabis',
            'Signature Request' => 'bi bi-pencil',
            'CDP' => 'fas fa-file-invoice-dollar',
            'Finance' => 'fas fa-file-pdf',
            'Solicitud Permiso Capacitación' => 'fas fa-chalkboard-teacher',
            'Ausentismo' => 'fas fa-plane',
            'Devolución Horas Extras' => 'bi bi-clock',
            'Convenios' => 'fas fa-handshake',
        ];

        return $legacyIcons[$module] ?? 'fas fa-question-circle'; // Default FontAwesome icon
    }

    /**
     * Get the Filament-compatible BI icon for a module.
     */
    protected function getFilamentIcon($module)
    {
        $filamentIcons = [
            'Modificaciones Ficha APS' => 'bi bi-file-medical',
            'Asistencia' => 'bi bi-clock',
            'Modulo Bodega' => 'bi bi-rocket',
            'Honorarios' => 'bi bi-rocket',
            'Plan de Compras' => 'bi bi-cart-check',
            'Perfil de Cargos' => 'bi-person-badge',
            'Recepcion' => 'bi bi-list-task',
            'Viáticos' => 'bi bi-wallet',
            'Solicitudes de Contración' => 'bi bi-person-lines-fill',
            'Calificaciones' => 'bi bi-graph-up-arrow',
            'Drogas' => 'bi bi-capsule',
            'Signature Request' => 'bi bi-pencil',
            'CDP' => 'bi-cash-coin',
            'Finance' => 'bi bi-file-earmark-pdf',
            'Solicitud Permiso Capacitación' => 'bi bi-person-workspace',
            'Ausentismo' => 'bi bi-airplane',
            'Devolución Horas Extras' => 'bi bi-clock-history',
            'Convenios' => 'bi bi-handshake',
        ];

        return $filamentIcons[$module] ?? 'bi bi-question-circle'; // Default BI icon
    }
}
