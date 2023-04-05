<?php

namespace App\Http\Livewire\Sign;

use Illuminate\Support\Str;
use App\Http\Requests\Sign\StoreSignatureRequest;
use App\Services\SignService;
use App\User;
use Livewire\Component;
use Livewire\WithFileUploads;

class RequestSignature extends Component
{
    use WithFileUploads;

    public $document_number;
    public $type_id;
    public $subject;
    public $description;
    public $distribution;
    public $recipients;
    public $reserved;
    public $page;

    public $document_to_sign;
    public $annex; //array
    public $url; //array

    public $left_signatures;
    public $center_signatures;
    public $right_signatures;

    public $namesSignaturesLeft;
    public $namesSignaturesCenter;
    public $namesSignaturesRight;

    public $column_left_endorse;
    public $column_center_endorse;
    public $column_right_endorse;

    public $column_left_visator;
    public $column_center_visator;
    public $column_right_visator;

    protected $listeners = [
        'setEmailRecipients',
        'setEmailDistributions',
        'addLeftSignature',
        'addCenterSignature',
        'addRightSignature',
        'documentTypeChanged' => 'setDocumentType'
    ];

    public function mount()
    {
        $this->resetInput();
    }

    public function rules()
    {
        return (new StoreSignatureRequest())->rules();
    }

    public function render()
    {
        return view('livewire.sign.request-signature');
    }

    public function setDocumentType($documentType)
    {
        $this->type_id = $documentType;
    }

    public function save()
    {
        $this->validate();

        /**
         * Guarda el archivo a firmar
         */
        $folder = 'ionline/sign/original'; // enum o en el modelo Signature
        $filename = 'document-sign-' . now()->timestamp();
        $url = $filename.'.pdf';
        $this->document_to_sign->storeAs($folder, $url, 'gcs');

        /**
         * Crea la solicitud de firma
         */
        $signatureService = new SignService;
        $signatureService->setDocumentNumber($this->document_number);
        $signatureService->setType($this->type_id);
        $signatureService->setSubject($this->subject);
        $signatureService->setDescription($this->description);
        $signatureService->setDistribution($this->distribution);
        $signatureService->setRecipients($this->recipients);
        $signatureService->setPage($this->page);
        $signatureService->setColumnLeftVisator($this->column_left_visator);
        $signatureService->setColumnLeftEndorse($this->column_left_endorse);
        $signatureService->setColumnCenterVisator($this->column_center_visator);
        $signatureService->setColumnCenterEndorse($this->column_center_endorse);
        $signatureService->setColumnRightVisator($this->column_right_visator);
        $signatureService->setColumnRightEndorse($this->column_right_endorse);
        $signatureService->setFile($url);
        $signatureService->setAnnexes(null);
        $signatureService->setSignersLeft($this->left_signatures);
        $signatureService->setSignersCenter($this->center_signatures);
        $signatureService->setSignersRight($this->right_signatures);
        $signatureService->setUserId(auth()->id());
        $signatureService->setOuId(auth()->user()->organizational_unit_id);
        $signatureService->save();

        $this->resetInput();
    }

    public function resetInput()
    {
        $this->page = 'last';
        $this->reserved = false;

        $this->column_left_visator = false;
        $this->column_center_visator = false;
        $this->column_right_visator = false;

        $this->recipients = [];
        $this->distribution = [];

        $this->namesSignaturesLeft = collect([]);
        $this->namesSignaturesCenter = collect([]);
        $this->namesSignaturesRight = collect([]);

        $this->left_signatures = collect([]);
        $this->center_signatures = collect([]);
        $this->right_signatures = collect([]);

        $this->reset([
            'document_number',
            'type_id',
            'subject',
            'description',
            'column_left_endorse',
            'column_center_endorse',
            'column_right_endorse',
        ]);
    }

    public function setEmailRecipients($emails)
    {
        $this->recipients = $emails;
    }

    public function setEmailDistributions($emails)
    {
        $this->distribution = $emails;
    }

    public function addLeftSignature($userId)
    {
        if(isset($userId) && ! $this->left_signatures->contains($userId))
        {
            $this->left_signatures->push($userId);
            $user = User::find($userId);
            $this->namesSignaturesLeft->push($user->short_name);
            $this->emit('clearSearchUser');
        }
        else
        {
            $this->emit('clearSearchUser', false);
        }
    }

    public function addCenterSignature($userId)
    {
        if(isset($userId) && ! $this->center_signatures->contains($userId))
        {
            $this->center_signatures->push($userId);
            $user = User::find($userId);
            $this->namesSignaturesCenter->push($user->short_name);
            $this->emit('clearSearchUser');
        }
        else
        {
            $this->emit('clearSearchUser', false);
        }
    }

    public function addRightSignature($userId)
    {
        if(isset($userId) && ! $this->right_signatures->contains($userId))
        {
            $this->right_signatures->push($userId);
            $user = User::find($userId);
            $this->namesSignaturesRight->push($user->short_name);
            $this->emit('clearSearchUser');
        }
        else
        {
            $this->emit('clearSearchUser', false);
        }
    }
}
