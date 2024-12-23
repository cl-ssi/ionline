<?php

namespace App\Exports;

use App\Models\Requirements\Requirement;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RequirementsExport implements FromCollection, WithHeadings
{
    protected $requirementIds;

    public function __construct(Collection $requirementIds)
    {
        $this->requirementIds = $requirementIds;
    }

    public function collection()
    {
        return Requirement::with([
                'events',
                'archived',
                'parte',
                'labels',
                'category',
            ])
            ->whereIn('id', $this->requirementIds)
            ->get()
            ->map(function ($requirement) {
                $labels = $requirement->labels->pluck('name')->implode(', ');
                $category = optional($requirement->category)->name;
    
                $createdEvent = $requirement->events->first();
                $createdBy = $createdEvent ? $createdEvent->from_user->tinyName : '';
                $createdAt = $createdEvent ? $createdEvent->created_at->format('Y-m-d H:i') : '';
                $createdDiff = $createdEvent ? $createdEvent->created_at->diffForHumans() : '';
                $createdInfo = "Creado por $createdBy\n$createdAt\n$createdDiff";
    
                $lastEvent = $requirement->events->last();
                $lastEventStatus = $lastEvent ? ucfirst($lastEvent->status) : '';
    
                if ($lastEventStatus === 'Creado') {
                    $lastEventInfo = ''; // Dejar vacío si el último evento es "Creado"
                } elseif ($lastEventStatus === 'Derivado') {
                    $lastEventFromUser = $lastEvent->from_user->tinyName;
                    $lastEventToUser = optional($lastEvent->to_user)->tinyName;
                    $lastEventInfo = "$lastEventStatus para $lastEventToUser\n{$lastEvent->created_at->format('Y-m-d H:i')}\nde $lastEventFromUser";
                } elseif ($lastEventStatus === 'Cerrado') {
                    $lastEventFromUser = $lastEvent->from_user->tinyName;
                    $lastEventInfo = "$lastEventStatus por $lastEventFromUser\n{$lastEvent->created_at->format('Y-m-d H:i')}";
                } else {
                    $lastEventFromUser = $lastEvent->from_user->tinyName;
                    $lastEventToUser = optional($lastEvent->to_user)->tinyName;
                    $lastEventInfo = "$lastEventStatus por $lastEventFromUser\n{$lastEvent->created_at->format('Y-m-d H:i')}\npara $lastEventToUser";
                }
    
                return [
                    'N°' => $requirement->id,
                    'Asunto' => $requirement->subject,
                    'Creado' => $createdInfo,
                    'Ultimo evento' => $lastEventInfo,
                    'Fecha límite' => $requirement->limit_at,
                    'Etiquetas' => $labels,
                    'Categoría' => $category,
                ];
            });
    }
    
    
    

    public function headings(): array
    {
        return [
            'N°',
            'Asunto',
            'Creado',
            'Ultimo evento',
            'Fecha límite',
            'Etiquetas',
            'Categoría',
        ];
    }
}
