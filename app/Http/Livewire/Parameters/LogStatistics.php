<?php

namespace App\Http\Livewire\Parameters;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Parameters\Log;

class LogStatistics extends Component
{
    public function render()
    {
        // Realiza la eliminación de registros superiores a un mes
        Log::where('created_at', '<', now()->subMonth())->delete();

        $logs = Log::whereNull('module')->get();

        foreach ($logs as $log) {
            if (preg_match('/service-request/', $log->uri)) {
                $log->module = 'Honorarios';
                $log->save();
            } elseif (preg_match('/service_request/', $log->uri)) {
                $log->module = 'Honorarios';
                $log->save();
            } elseif (preg_match('/replacement_staff/', $log->uri)) {
                $log->module = 'Staff de reemplazo';
                $log->save();
            } elseif (preg_match('/replacement-staff/', $log->uri)) {
                $log->module = 'Staff de reemplazo';
                $log->save();
            } elseif (preg_match('/job_position_profile/', $log->uri)) {
                $log->module = 'Perfil de cargos';
                $log->save();
            } elseif (preg_match('/job-position-profile/', $log->uri)) {
                $log->module = 'Perfil de cargos';
                $log->save();
            } elseif (preg_match('/drugs/', $log->uri)) {
                $log->module = 'Drogas';
                $log->save();
            } elseif (preg_match('/requirements/', $log->uri)) {
                $log->module = 'SGR';
                $log->save();
            } elseif (preg_match('/agreements/', $log->uri)) {
                $log->module = 'Convenios';
                $log->save();
            } elseif (preg_match('/request-form/', $log->uri)) {
                $log->module = 'Abastecimiento';
                $log->save();
            } elseif (preg_match('/request_forms/', $log->uri)) {
                $log->module = 'Abastecimiento';
                $log->save();
            } elseif (preg_match('/pharmacies/', $log->uri)) {
                $log->module = 'Farmacia';
                $log->save();
            } elseif (preg_match('/signatures/', $log->uri)) {
                $log->module = 'Firmas';
                $log->save();
            } elseif (preg_match('/partes/', $log->uri)) {
                $log->module = 'Partes';
                $log->save();
            } elseif (preg_match('/warehouse/', $log->uri)) {
                $log->module = 'Bodega 2.0';
                $log->save();
            } elseif (preg_match('/fonasa/', $log->uri)) {
                $log->module = 'Fonasa';
                $log->save();
            } elseif (preg_match('/allowances/', $log->uri)) {
                $log->module = 'Viáticos';
                $log->save();
            } elseif (preg_match('~^/\d+/firma$~', $log->uri)) {
                $log->module = 'Firmas';
                $log->save();
            } elseif (preg_match('/\/documents\/showPdf/', $log->uri)) {
                $log->module = 'Firmas';
                $log->save();
            } elseif (preg_match('/\/documents\/signed-document-pdf/', $log->uri)) {
                $log->module = 'Firmas';
                $log->save();
            } elseif (preg_match('/\/documents\/\d*$/', $log->uri)) {
                $log->module = 'Documentos';
                $log->save();
            } elseif (preg_match('~^/documents~', $log->uri)) {
                $log->module = 'Documentos';
                $log->save();
            } elseif (preg_match('~^/firma~', $log->uri)) {
                $log->module = 'Firmas';
                $log->save();
            } elseif (preg_match('~^/indicators~', $log->uri)) {
                $log->module = 'Indicadores';
                $log->save();
            } elseif (preg_match('/new-upload-rem/', $log->uri)) {
                $log->module = 'Carga de Rem';
                $log->save();
            } elseif (preg_match('/programming/', $log->uri)) {
                $log->module = 'Programación';
                $log->save();
            } elseif (preg_match('/professionalhours/', $log->uri)) {
                $log->module = 'Programación';
                $log->save();
            } elseif (preg_match('/subrogations/', $log->uri)) {
                $log->module = 'Subrogantes';
                $log->save();
            } elseif (preg_match('/authorities/', $log->uri)) {
                $log->module = 'Autoridades';
                $log->save();
            } elseif (preg_match('~^/rem~', $log->uri)) {
                $log->module = 'Carga de Rem';
                $log->save();
            } elseif (preg_match('/Clave Única/', $log->message)) {
                $log->module = 'Clave Única';
                $log->save();
            } elseif (preg_match('~^/invoice~', $log->uri)) {
                $log->module = 'Honorarios';
                $log->save();
            } elseif (preg_match('/unspsc/', $log->uri)) {
                $log->module = 'UNSPSC';
                $log->save();
            } elseif (preg_match('/prof_agenda/', $log->uri)) {
                $log->module = 'Agenda UST';
                $log->save();
            } elseif (preg_match('/prof-agenda/', $log->uri)) {
                $log->module = 'Agenda UST';
                $log->save();
            } elseif (preg_match('/handle-task/', $log->uri)) {
                $log->module = 'Colas';
                $log->save();
            } elseif (preg_match('/finance\/payments/', $log->uri)) {
                $log->module = 'Estados de Pago';
                $log->save();
            } elseif (preg_match('/finance./', $log->uri)) {
                $log->module = 'Estados de Pago';
                $log->save();
            } elseif (preg_match('/no-attendance-record/', $log->uri)) {
                $log->module = 'Asistencia';
                $log->save();
            } elseif (preg_match('/summary/', $log->uri)) {
                $log->module = 'Sumarios';
                $log->save();
            } elseif (preg_match('/amipass/', $log->uri)) {
                $log->module = 'Amipass';
                $log->save();
            } elseif (preg_match('/inventory/', $log->uri)) {
                $log->module = 'Inventario';
                $log->save();
            } elseif (preg_match('/inventories/', $log->uri)) {
                $log->module = 'Inventario';
                $log->save();
            } elseif (preg_match('/hotel/', $log->uri)) {
                $log->module = 'Cabañas';
                $log->save();
            } elseif (preg_match('/login-external/', $log->uri)) {
                $log->module = 'Login externo';
                $log->save();
            } 
        }

        $group = DB::table('logs')
            ->select('module', DB::raw('count(*) as total'))
            ->groupBy('module')
            ->orderByDesc('total')
            ->get();

        $logsByDay = Log::selectRaw('DATE(created_at) as log_date, COUNT(*) as log_count')
            ->groupBy('log_date')
            ->get();
        
        $logsChart = null;
        foreach($logsByDay as $day) {
            $logsChart .= "['".$day->log_date."',".$day->log_count."],";
        }
    
        return view('livewire.parameters.log-statistics', [
            'group' => $group,
            'logsChart' => $logsChart,
        ]);
    }
}
