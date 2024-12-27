<?php

namespace App\Notifications\Rrhh;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use App\Models\Rrhh\NoAttendanceRecord;

class NewNoAttendanceRecord extends Notification
{
    use Queueable;

    public $noAttendanceRecord;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(NoAttendanceRecord $noAttendanceRecord)
    {
        $this->noAttendanceRecord = $noAttendanceRecord;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        // return [
        //     'module'  => 'Asistencia', // Opcional
        //     'icon'    => '<i class="fas fa-fw fa-clock"></i>', // Opcional
        //     'subject' => 'Constancia marca de '.$this->noAttendanceRecord->user->tinnyName,
        //     'action' => route('rrhh.attendance.no-records.confirmation',[$this->noAttendanceRecord->id], false),
        // ];

        return [
            "icon" => "heroicon-o-clock",
            "status" => "info",
            "title" => 'Asistencia',
            "body" => 'Constancia de marca de ' . $this->noAttendanceRecord->user->tinnyName,
            "actions" => [
                [
                    "name" => "confirm_attendance",
                    "label" => "Confirmar Asistencia",
                    "url" => route('rrhh.attendance.no-records.confirmation', [$this->noAttendanceRecord->id]),
                    "color" => "primary",
                    "icon" => "heroicon-o-check",
                    "shouldOpenInNewTab" => false,
                    "shouldMarkAsRead"=> true, // Marcar como leída al hacer clic
                    "view"=> "filament-actions::button-action",
                ],
            ],
            "duration" => "persistent",
            "view" => "filament-notifications::notification",
            "format" => "filament",
        ];
    }
}
