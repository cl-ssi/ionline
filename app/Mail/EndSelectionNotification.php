<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\ReplacementStaff\TechnicalEvaluation;

class EndSelectionNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $technicalEvaluation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(TechnicalEvaluation $technicalEvaluation)
    {
        $this->technicalEvaluation = $technicalEvaluation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('replacement_staff.request.mail.endselectionnotification')
          ->subject('Fin Proceso Selección - Solicitud Nº '.$this->technicalEvaluation->requestReplacementStaff->id);
    }
}
