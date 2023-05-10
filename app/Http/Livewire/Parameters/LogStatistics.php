<?php

namespace App\Http\Livewire\Parameters;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Parameters\Log;

class LogStatistics extends Component
{
    public function render()
    {
        $logs = Log::whereNull('module')->get();
        
        foreach($logs as $log) {
            if (preg_match('/service-request/', $log->uri)) {
                $log->module = 'Honorarios';
                $log->save();
            }
            elseif (preg_match('/replacement_staff/', $log->uri)) {
                $log->module = 'Staff de reemplazo';
                $log->save();
            }
            elseif (preg_match('/replacement-staff/', $log->uri)) {
                $log->module = 'Staff de reemplazo';
                $log->save();
            }
            elseif (preg_match('/drugs/', $log->uri)) {
                $log->module = 'Drogas';
                $log->save();
            }
            elseif (preg_match('/requirements/', $log->uri)) {
                $log->module = 'SGR';
                $log->save();
            }
            elseif (preg_match('/agreements/', $log->uri)) {
                $log->module = 'Convenios';
                $log->save();
            }
            elseif (preg_match('/request-form/', $log->uri)) {
                $log->module = 'Abastecimiento';
                $log->save();
            }
            elseif (preg_match('/request_forms/', $log->uri)) {
                $log->module = 'Abastecimiento';
                $log->save();
            }
            elseif (preg_match('/pharmacies/', $log->uri)) {
                $log->module = 'Farmacia';
                $log->save();
            }
            elseif (preg_match('/signatures/', $log->uri)) {
                $log->module = 'Firmas';
                $log->save();
            }
            elseif (preg_match('/partes/', $log->uri)) {
                $log->module = 'Partes';
                $log->save();
            }
            elseif (preg_match('/warehouse/', $log->uri)) {
                $log->module = 'Bodega 2.0';
                $log->save();
            }
            elseif (preg_match('/fonasa/', $log->uri)) {
                $log->module = 'Fonasa';
                $log->save();
            }
            elseif (preg_match('/allowances/', $log->uri)) {
                $log->module = 'Viáticos';
                $log->save();
            }
            elseif (preg_match('/\/documents\/\d*$/', $log->uri)) {
                $log->module = 'Documentos';
                $log->save();
            }
            elseif (preg_match('~^/documents~', $log->uri)) {
                $log->module = 'Documentos';
                $log->save();
            }
            elseif (preg_match('~^/\d+/firma$~', $log->uri)) {
                $log->module = 'Firmas';
                $log->save();
            }
            elseif (preg_match('~^/firma~', $log->uri)) {
                $log->module = 'Firmas';
                $log->save();
            }
            elseif (preg_match('~^/indicators~', $log->uri)) {
                $log->module = 'Indicadores';
                $log->save();
            }
            elseif (preg_match('/new-upload-rem/', $log->uri)) {
                $log->module = 'Carga de Rem';
                $log->save();
            }
            elseif (preg_match('/programming/', $log->uri)) {
                $log->module = 'Programación';
                $log->save();
            }
            elseif (preg_match('/subrogations/', $log->uri)) {
                $log->module = 'Subrogantes';
                $log->save();
            }
            elseif (preg_match('/authorities/', $log->uri)) {
                $log->module = 'Autoridades';
                $log->save();
            }
            elseif (preg_match('~^/rem~', $log->uri)) {
                $log->module = 'Carga de Rem';
                $log->save();
            }
            elseif (preg_match('~^/invoice~', $log->uri)) {
                $log->module = 'Honorarios';
                $log->save();
            }
            elseif (preg_match('/unspsc/', $log->uri)) {
                $log->module = 'UNSPSC';
                $log->save();
            }
        }
        
        $group = DB::table('logs')
            ->select('module', DB::raw('count(*) as total'))
            ->groupBy('module')
            ->orderByDesc('total')
            ->get();

        return view('livewire.parameters.log-statistics', [
            'group' => $group
        ]);
    }
}
