<?php

namespace App\Notifications\Rrhh;

use App\Models\Rrhh\AttendanceRecord;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAttendanceRecord extends Notification implements ShouldQueue
{
    use Queueable;

    protected AttendanceRecord $attendanceRecord;

    /**
     * Create a new notification instance.
     */
    public function __construct(AttendanceRecord $attendanceRecord)
    {
        $this->attendanceRecord = $attendanceRecord;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $this->attendanceRecord = $this->attendanceRecord->refresh();

        $mailMessage = (new MailMessage)
            ->level('info')
            ->subject('Registro de asistencia de ' . $this->attendanceRecord->user->shortName)
            ->greeting('Hola ' . $this->attendanceRecord->user->boss->name)
            ->line('Registro de asistencia Nº: ' . $this->attendanceRecord->id)
            ->line('Funcionario: ' . $this->attendanceRecord->user->shortName)
            ->line('Tipo: ' . ($this->attendanceRecord->type == 1 ? 'Entrada' : 'Salida'))
            ->line('Fecha y hora: ' . $this->attendanceRecord->record_at)
            ->lineIf(!is_null($this->attendanceRecord->observation), 'Observación : ' . $this->attendanceRecord->observation)
            ->salutation('Saludos cordiales.');

        if (!empty($this->attendanceRecord->user->email)) {
            $mailMessage->cc($this->attendanceRecord->user->email);
        }

        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
