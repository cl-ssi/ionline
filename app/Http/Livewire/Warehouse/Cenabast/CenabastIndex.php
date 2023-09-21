<?php

namespace App\Http\Livewire\Warehouse\Cenabast;

use App\Models\Documents\Sign\Signature;
use App\Models\Finance\Dte;
use App\Services\DocumentSignService;
use App\Services\ImageService;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;

class CenabastIndex extends Component
{
    public $filter_by = 'all';

    public $selectedDte;

    public $otp;

    public function mount()
    {
        $this->selectedDte = [];
    }

    public function getCenabast($tray)
    {
        $dtes = Dte::query()
            ->where('cenabast', 1)
            ->where('establishment_id',auth()->user()->organizationalUnit->establishment->id)
            ->when($this->filter_by == 'without-attached', function($query) {
                $query->whereNull('confirmation_signature_file');
            })
            ->when($this->filter_by == 'with-attached', function($query) {
                $query->whereNotNull('confirmation_signature_file');
            });

        $dtes = $dtes->paginate(100);

        return $dtes;
    }

    public function render()
    {
        return view('livewire.warehouse.cenabast.cenabast-index', [
            'dtes' => $this->getCenabast('sin_adjuntar'),
        ]);
    }

    public function signMultiple()
    {
        if(Str::length($this->otp) != 6)
        {
            session()->flash('danger', 'Disculpe, el OTP debe ser de 6 dígitos');
            return redirect()->route('warehouse.cenabast.index');
        }

        if(count($this->selectedDte) == 0)
        {
            session()->flash('danger', 'Disculpe, debe seleccionar uno o mas archivos para firmar');
            return redirect()->route('warehouse.cenabast.index');
        }

        foreach($this->selectedDte as $dteId => $value)
        {
            /**
             * Setea el user
             */
            $user = User::find(auth()->id());

            /**
             * Setea el base64Image
             */
            $base64Image = app(ImageService::class)->createSignature($user);

            /**
             * Obtiene el DTE dado el dteId
             */
            $dte = Dte::find($dteId);

            /**
             * Determina si es farmaceutico
             */
            $isPharmacist = $dte->pharmacist->id == auth()->id();

            /**
             * Determina si es el jefe
             */
            $isBoss = $dte->boss->id == auth()->id();

            /**
             * Bloque el DTE
             */
            $dte->update([
                'block_signature' => true,
            ]);

            dispatch(function () use ($dte, $user, $base64Image, $isPharmacist, $isBoss) {
                /**
                 *  Obtiene la url del archivo a firmar
                 */
                $fileToSign = ($isPharmacist) ? $dte->confirmation_signature_file_url : $dte->cenabast_reception_file_url;

                /**
                 * Parsing link confirmation_signature_file_url a base64
                 */
                $documentBase64Pdf = base64_encode(file_get_contents($fileToSign));

                /**
                 * Calculate el eje X
                 */
                $coordinateX = app(Signature::class)->calculateColumn($isPharmacist ? 'left' : 'right');

                /**
                 * Calculate el eje X
                 */
                $coordinateY = app(Signature::class)->calculateRow(1, 60);

                /**
                 * Firma el documento con el servicio DocumentSignService
                 */

                $documentSignService = new DocumentSignService;
                $documentSignService->setDocument($documentBase64Pdf);
                $documentSignService->setFolder('/ionline/cenabast/signature/');
                $documentSignService->setFilename('dte-' . $dte->id);
                $documentSignService->setUser($user);
                $documentSignService->setXCoordinate($coordinateX);
                $documentSignService->setYCoordinate($coordinateY);
                $documentSignService->setBase64Image($base64Image);
                $documentSignService->setPage('LAST');
                $documentSignService->setOtp($this->otp);
                $documentSignService->setEnvironment('TEST');
                $documentSignService->setModo('DESATENDIDO');
                $documentSignService->sign();

                /**
                 * Si es farmaceutico, setea que ya firmo
                 */
                if($isPharmacist == true)
                {
                    $dte->update([
                        'cenabast_signed_pharmacist' => true,
                    ]);
                }

                /**
                 * Si es el jefe, setea que ya firmo
                 */
                if($isBoss)
                {
                    $dte->update([
                        'cenabast_signed_boss' => true,
                    ]);
                }

                if(! isset($dte->cenabast_reception_file))
                {
                    /**
                     * Setea el campo con la ruta del archivo firmado
                     */
                    $dte->update([
                        'cenabast_reception_file' => '/ionline/cenabast/signature/dte-' . $dte->id.'.pdf' ,
                    ]);
                }

                /**
                 * Desbloque el DTE
                 */
                $dte->update([
                    'block_signature' => false,
                ]);

            })->catch(function(\Throwable $th) use($dte) {
                /**
                 * Elimina el job porque el OTP seguramente ya vencio
                 */
                $this->delete();

                /**
                 * Desbloque el DTE
                 */
                $dte->update([
                    'block_signature' => false,
                ]);
            })->onQueue('default');

        }

        session()->flash('info', 'Los archivos están en proceso de firma, esto tomará unos segundos.');
        return redirect()->route('warehouse.cenabast.index');
    }


    public function deleteFile(Dte $dte)
    {
        if (isset($dte->confirmation_signature_file))
        {
            Storage::disk('gcs')->delete($dte->confirmation_signature_file);

            $dte->update([
                'confirmation_signature_file' => null,
            ]);

            session()->flash('info', 'El archivo fue eliminado con éxito');
        }
        else
        {
            session()->flash('error', 'El archivo no existe');
        }

        return redirect()->route('warehouse.cenabast.index');
    }

}
