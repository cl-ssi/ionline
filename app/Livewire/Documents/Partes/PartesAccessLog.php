<?php

namespace App\Livewire\Documents\Partes;

use Livewire\Component;
use App\Models\User;
use App\Models\Parameters\AccessLog;

class PartesAccessLog extends Component
{
    public function render()
    {
        $daysAgo = 15;

        $lastLogs = AccessLog::with('user','switchUser')
                    ->where('type', 'partes')
                    ->where('created_at', '>', now()->subDays($daysAgo))
                    ->whereHas('user', function($query) {
                        $query->whereHas('organizationalUnit', function($query) {
                            $query->whereHas('establishment', function($subQuery) {
                                $subQuery->where('id', auth()->user()->organizationalUnit->establishment_id);
                            });
                        });
                    })
                    ->latest()
                    ->get();

        /* Usuarios con acceso a Partes de tu mismo establecimiento */
        $users = User::with('organizationalUnit')
            ->permission(['Partes: user','Partes: oficina'])
            ->whereHas('organizationalUnit', function($query) {
            $query->whereHas('establishment', function($subQuery) {
                $subQuery->where('id', auth()->user()->organizationalUnit->establishment_id);
            });
        })->get();
        

        return view('livewire.documents.partes.partes-access-log', compact('lastLogs','daysAgo','users'));
    }
}
