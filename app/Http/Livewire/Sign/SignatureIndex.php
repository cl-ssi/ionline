<?php

namespace App\Http\Livewire\Sign;

use App\Jobs\SignDocumentJob;
use App\Models\Documents\Sign\Signature;
use App\Models\Documents\Sign\SignatureFlow;
use App\Services\DocumentSignService;
use App\Services\ImageService;
use App\User;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Throwable;

class SignatureIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $selectedSignatures;
    public $filterBy = "all";
    public $search;
    public $otp;

    public $observation;

    public function render()
    {
        return view('livewire.sign.signature-index', [
            'signatures' => $this->getSignatures()
        ]);
    }

    public function mount()
    {
        $this->selectedSignatures = collect();
    }

    public function updateSelected($signatureId)
    {
        if($this->selectedSignatures->contains($signatureId))
        {
            $this->selectedSignatures = $this->selectedSignatures->filter(function ($itemSelected) use($signatureId){
                return $itemSelected != $signatureId;
            });
        }
        else
        {
            $this->selectedSignatures->push($signatureId);
        }
    }

    public function signToMultiple()
    {
        $signatures = Signature::query()
            ->whereIn('id', $this->selectedSignatures->toArray())
            ->get();

        foreach($signatures as $signature)
        {
            /**
             * Bloquea la firma
             */
            $signature->update([
                'is_blocked' => true,
            ]);

            /**
             * Setea el user
             */
            $user = User::find(auth()->id());

            /**
             * Setea el signatureFlow
             */
            $signatureFlow = SignatureFlow::query()
                ->whereSignerId(auth()->id())
                ->whereSignatureId($signature->id)
                ->first();

            /**
             * Setea el base64Image
             */
            $base64Image = app(ImageService::class)->createSignature($user);

            dispatch(function () use ($signature, $signatureFlow, $user, $base64Image) {

                /**
                 * Firma el documento con el servicio
                 */
                $documentSignService = new DocumentSignService;
                $documentSignService->setDocument($signature->link_signed_file);
                $documentSignService->setFolder(Signature::getFolderSigned());
                $documentSignService->setFilename($signature->id.'-'.$signatureFlow->id);
                $documentSignService->setUser($user);
                $documentSignService->setXCoordinate($signatureFlow->x);
                $documentSignService->setYCoordinate($signatureFlow->y);
                $documentSignService->setBase64Image($base64Image);
                $documentSignService->setPage($signature->page);
                $documentSignService->setOtp($this->otp);
                $documentSignService->setEnvironment('TEST');
                $documentSignService->setModo('ATENDIDO');
                $documentSignService->sign();

                /**
                 * Desbloquea la firma
                 */
                $signature->update([
                    'is_blocked' => false,
                ]);

                /**
                 * Actualiza el signature flow
                 */
                $signatureFlow->update([
                    'status' => 'signed',
                ]);

            })->catch(function() {
                $this->delete();
                /**
                 * Desbloquear signature
                 */
            })->onQueue('sign');
        }

        session()->flash('warning', 'El archivos estan en proceso de firma, esto tomara unos segundos.');
        return redirect()->route('v2.documents.signatures.index');
    }

    public function getSignatures()
    {
        $search = "%$this->search%";

        $signatures = Signature::query()
            ->when(isset($this->search), function ($query) use($search) {
                $query->whereHas('flows', function($query) {
                    $query->whereSignerId(auth()->id());
                })->where(function($query) use($search) {
                    $query->where('subject', 'like', $search)
                    ->orWhere('description', 'like', $search);
                });
            })
            ->when($this->filterBy != "all", function($query) {
                $query->whereHas('flows', function($query) {
                    $query->when($this->filterBy == 'pending', function ($query) {
                        $query->whereStatus('pending');
                    }, function ($query) {
                        $query->whereIn('status', ['signed', 'rejected']);
                    })
                    ->whereSignerId(auth()->id());
                });
            })
            ->orderByDesc('id')
            ->whereHas('flows', function($query) {
                $query->whereSignerId(auth()->id());
            })
            ->paginate(10);

        return $signatures;
    }

    public function rejectedSignature(Signature $signature)
    {
        $signatureFlow = SignatureFlow::query()
            ->whereSignerId(auth()->id())
            ->whereSignatureId($signature->id)
            ->first();

        $signatureFlow->update([
            'status' => 'rejected',
            'status_at' => now(),
            'rejected_observation' => $this->observation,
        ]);

        $signature->update([
            'status' => 'rejected',
            'status_at' => now(),
        ]);

        session()->flash('success', "La solicitud de firma #$signature->id fue rechazada.");
        return redirect()->route('v2.documents.signatures.index');    }
}
