<?php

namespace App\Http\Livewire\Partes;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Documents\Parte;

class Inbox extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $parte_id;
    public $parte_type;
    public $parte_number;
    public $parte_origin;
    public $parte_subject;

    /**
    * Mount
    */
    public function mount()
    {
        $this->parte_id = session('parte_id');
        $this->parte_type = session('parte_type');
        $this->parte_number = session('parte_number');
        $this->parte_origin = session('parte_origin');
        $this->parte_subject = session('parte_subject');
    }

    public function search() {
        session(['partes_id' => $this->parte_id]);
        session(['partes_type' => $this->parte_type]);
        session(['partes_number' => $this->parte_number]);
        session(['partes_origin' => $this->parte_origin]);
        session(['partes_subject' => $this->parte_subject]);
    }

    public function render()
    {
        $partes = Parte::query()
            ->whereEstablishmentId(auth()->user()->organizationalUnit->establishment->id)
            // ->filter('id', $this->parte_id)
            ->filter('type', $this->parte_type)
            ->filter('number', $this->parte_number)
            ->filter('origin', $this->parte_origin)
            ->filter('subject', $this->parte_subject)
            ->with([
                'requirements',
                'files',
                'requirements.events',
                'requirements.events.to_user',
                'files.signatureFile.signaturesFlows',
                'files.signatureFile',
                ])
            ->latest()->paginate('100');

        return view('livewire.partes.inbox', ['partes' => $partes]);
    }
}
