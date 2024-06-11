<?php

namespace App\Http\Livewire\Finance;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Sigfe\PdfBackup;
use App\Models\Documents\Approval;
use Illuminate\Support\Facades\Storage;

class UploadPdf extends Component
{
    use WithFileUploads;

    public $dteId;
    public $pdf;
    public $type;
    public $pdfBackup;
    public $pdfPath;

    protected $rules = [
        'pdf' => 'required|mimes:pdf|max:10240'
    ];

    public function mount($dteId, $type)
    {
        $this->dteId = $dteId;
        $this->type = $type;
        $this->loadPdfBackup();
    }

    public function loadPdfBackup()
    {
        $this->pdfBackup = PdfBackup::where('dte_id', $this->dteId)->where('type', $this->type)->first();
        $this->pdfPath = $this->pdfBackup ? Storage::disk('gcs')->url($this->pdfBackup->approval->document_pdf_path) : null;
    }

    public function updatedPdf()
    {
        $this->validate();
    }

    public function save()
    {
        $this->validate();

        $pdfBackup = PdfBackup::create([
            'dte_id' => $this->dteId,
            'type' => $this->type
        ]);

        $this->pdf->store('ionline/sigfe/pago/sin_firmar', ['disk' => 'gcs']);

        $pdfBackup->approval()->create([
            'module' => 'Finance',
            'module_icon' => 'fas fa-file-pdf',
            'subject' => 'Nuevo Comprobante de Pago',            
            'document_pdf_path' => 'ionline/sigfe/pago/sin_firmar/' . $this->pdf->hashName(),
            "sent_to_ou_id" => auth()->user()->organizational_unit_id,
            'digital_signature' => 1,
            'filename' => 'ionline/sigfe/pago/firmado/' . $this->pdf->hashName(),
            // probando si es valida la documentacion de opcional
            // "start_y" => 80,
            // "position" => "right",
        ]);

        session()->flash('message', 'PDF subido exitosamente.');

        $this->loadPdfBackup();

        $this->emit('pdfUploaded');
    }

    public function delete()
    {
        if ($this->pdfBackup) {
            $approval = Approval::where('approvable_id', $this->pdfBackup->id)
                ->where('approvable_type', PdfBackup::class)
                ->first();

            if ($approval) {
                Storage::disk('gcs')->delete($approval->document_pdf_path);
                $approval->delete();
            }

            $this->pdfBackup->delete();

            session()->flash('message', 'PDF eliminado exitosamente.');

            $this->pdfBackup = null;
            $this->pdfPath = null;

            $this->emit('pdfDeleted');
        }
    }

    public function render()
    {
        return view('livewire.finance.upload-pdf', [
            'pdfPath' => $this->pdfPath,
        ]);
    }
}
