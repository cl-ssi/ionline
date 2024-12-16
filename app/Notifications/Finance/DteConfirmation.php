<?php

namespace App\Notifications\Finance;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use App\Models\Finance\Dte;

class DteConfirmation extends Notification
{
    use Queueable;

    public $dte;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Dte $dte)
    {
        $this->dte = $dte;
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
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        // if($this->dte->folio_oc)
        // {
        //     return [
        //         'module'  => 'Finanzas',
        //         'icon'    => '<i class="fas fa-fw fa-file-invoice-dollar"></i>',
        //         'subject' => 'Nueva DTE para recepcionar: '.$this->dte->id,
        //         'action' => route('finance.receptions.create',0, false).'?oc='.$this->dte->folio_oc.'&dte_id='.$this->dte->id,
        //     ];
        // }
        // else
        // {
        //     return [
        //         'module'  => 'Finanzas',
        //         'icon'    => '<i class="fas fa-fw fa-file-invoice-dollar"></i>',
        //         'subject' => 'Nueva DTE para recepcionar: '.$this->dte->id,
        //         'action' => route('finance.receptions.create_no_oc').'?dte_id='.$this->dte->id,
        //     ];

        // }

        if ($this->dte->folio_oc) {
            return [
                "actions" => [
                    [
                        "name" => "create_reception_with_oc",
                        "label" => "Crear Recepción con OC",
                        "url" => route('finance.receptions.create', ['oc' => $this->dte->folio_oc, 'dte_id' => $this->dte->id]),
                        "color" => "primary",
                        "icon" => "heroicon-o-plus",
                        "shouldOpenInNewTab" => true,
                    ],
                ],
                "body" => 'Haz clic para crear una recepción de la DTE con el folio OC: ' . $this->dte->folio_oc . '.', 
                "color" => "info",
                "duration" => "persistent",
                "icon" => 'heroicon-s-document-currency-dollar',
                "status" => "info",
                "title" => 'Nueva DTE para recepcionar',
                "view" => "filament-notifications::notification",
                "format" => "filament",
            ];
        } else {
            return [
                "actions" => [
                    [
                        "name" => "create_reception_without_oc",
                        "label" => "Crear Recepción sin OC",
                        "url" => route('finance.receptions.create_no_oc', ['dte_id' => $this->dte->id]), 
                        "color" => "primary",
                        "icon" => "heroicon-o-plus",
                        "shouldOpenInNewTab" => true,
                    ],
                ],
                "body" => 'Haz clic para crear una recepción de la DTE sin el folio OC.',
                "color" => "info",
                "duration" => "persistent",
                "icon" => 'heroicon-s-document-currency-dollar',
                "status" => "info",
                "title" => 'Nueva DTE para recepcionar',
                "view" => "filament-notifications::notification",
                "format" => "filament",
            ];
        }


    }
}
