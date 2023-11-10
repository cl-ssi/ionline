<?php

namespace App\Http\Livewire\Warehouse\Cenabast;

use App\Jobs\SignDteJob;
use App\Models\Finance\Dte;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;
use Livewire\Component;

class CenabastIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $filter_by = 'all';
    public $filter_by_signature = 'all';

    public $selectedDte;

    public $otp;

    public $filter = [
        'id' => '',
        'folio' => '',
    ];

    public function mount()
    {
        $this->selectedDte = [];
    }

    /**
     * Obtiene los DTEs
     *
     * @return void
     */
    public function getCenabast()
    {
        $dtes = Dte::query()
            ->with([
                'controls',
                'establishment',
                'confirmationUser',
                'confirmationUser.organizationalUnit',
            ])
            ->where('cenabast', 1)            
            ->where('establishment_id', auth()->user()->organizationalUnit->establishment->id)
            ->when($this->filter_by_signature == 'without-pharmacist', function($query) {
                $query->where('cenabast_signed_pharmacist', 0);
            })
            ->when($this->filter_by_signature == 'without-boss', function($query) {
                $query->where('cenabast_signed_boss', 0);
            })
            ->when($this->filter_by_signature == 'with-pharmacist-without-boss', function($query) {
                $query->where('cenabast_signed_pharmacist', 'LIKE', '1%')->where('cenabast_signed_boss', 0);
            })
            ->when($this->filter_by == 'without-attached', function($query) {
                $query->whereNull('confirmation_signature_file');
            })
            ->when($this->filter_by == 'with-attached', function($query) {
                $query->whereNotNull('confirmation_signature_file');
            });

        if (!empty($this->filter['id'])) {
                $dtes->where('id', $this->filter['id']);
        }

        if (!empty($this->filter['folio'])) {
                $dtes->where('folio', $this->filter['folio']);
            }

        if (!empty($this->filter['id'])) {
                $dtes->where('id', $this->filter['id']);
        }

        $dtes = $dtes->latest()->paginate(100);

        return $dtes;
    }

    public function render()
    {
        return view('livewire.warehouse.cenabast.cenabast-index', [
            'dtes' => $this->getCenabast('sin_adjuntar'),
        ])->extends('layouts.bt4.app');
    }

    /**
     * Firma multiples DTe
     *
     * @return void
     */
    public function signMultiple()
    {
        /**
         * Si el OTP no es de 6 digitos, muestra un error
         */
        if(Str::length($this->otp) != 6)
        {
            session()->flash('danger', 'Disculpe, el OTP debe ser de 6 dígitos');
            return redirect()->route('warehouse.cenabast.index');
        }

        /**
         * Si no se ha seleccionado DTE, muestra un error
         */
        if(count($this->selectedDte) == 0)
        {
            session()->flash('danger', 'Disculpe, debe seleccionar uno o mas archivos para firmar');
            return redirect()->route('warehouse.cenabast.index');
        }

        foreach($this->selectedDte as $dteId => $value)
        {
            /**
             * Dispatch el job SignDte
             */
            dispatch(new SignDteJob(auth()->id(), $dteId, $this->otp));
        }

        session()->flash('info', 'Los archivos están en proceso de firma, esto tomará unos segundos.');
        return redirect()->route('warehouse.cenabast.index');
    }

    /**
     * Elimina el acta cargada
     *
     * @param  Dte  $dte
     * @return void
     */
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

    /**
     * Elimina acta carga y firmadas
     *
     * @param  Dte  $dte
     * @return void
     */
    public function deleteFileSignature(Dte $dte)
    {
        /**
         * Elimina el acta cargada
         */
        if (isset($dte->cenabast_reception_file))
        {
            Storage::disk('gcs')->delete($dte->cenabast_reception_file);
        }

        /**
         * Elimina el acta firmada
         */
        if (isset($dte->confirmation_signature_file))
        {
            Storage::disk('gcs')->delete($dte->confirmation_signature_file);
        }

        /**
         * Setea los campos del DTE
         */
        $dte->update([
            'cenabast_reception_file' => null,
            'confirmation_signature_file' => null,
            'cenabast_signed_pharmacist' => false,
            'cenabast_signed_boss' => false,
            'confirmation_status' => null,
            'confirmation_user_id' => null,
            'confirmation_ou_id' => null,
            'confirmation_at' => null,
        ]);

        session()->flash('sucess', 'El acta cargada y firmada fue eliminada con éxito');
        return redirect()->route('warehouse.cenabast.index');
    }
}
