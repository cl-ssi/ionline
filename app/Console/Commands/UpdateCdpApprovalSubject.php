<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Finance\Cdp;

class UpdateCdpApprovalSubject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cdp:update-approval-subject';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza el atributo subject de la relación approval para todos los modelos Cdp';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Recorre todos los modelos Cdp
        Cdp::with('approval', 'requestForm')->chunk(100, function ($cdps) {
            foreach ($cdps as $cdp) {
                // Construye el nuevo valor del subject
                $newSubject = "Certificado de Disponibilidad Presupuestaria <br>Formulario " .
                    "<a target=\"_blank\" href=\"" . route('request_forms.show', $cdp->requestForm->id) . "\">#{$cdp->requestForm->folio}</a>";

                // Actualiza el atributo subject de la relación approval
                $cdp->approval->subject = $newSubject;
                $cdp->approval->save();

                $this->info("CDP #{$cdp->id}: Subject actualizado.");
            }
        });

        $this->info('Todos los CDP han sido actualizados.');
        return 0;
    }
}
