<?php

namespace App\Http\Livewire\Sign;

use App\Http\Requests\Sign\StoreSignatureRequest;
use App\Models\Documents\Document;
use App\Models\Documents\Sign\Signature;
use App\Models\Documents\Sign\SignatureAnnex;
use App\Models\Documents\Type;
use App\Services\SignService;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class RequestSignature extends Component
{
    use WithFileUploads;

    public $document;
    public $document_number;
    public $type_id;
    public $subject;
    public $description;
    public $distribution;
    public $recipients;
    public $reserved;
    public $page;

    public $type_annexed;
    public $annexes;
    public $annex_file;
    public $annex_link;

    public $document_to_sign;

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

    public $documentTypes;
    public $signers;

    public $columnAvailable;
    public $myColumns;
    public $lastColumn;

    public $iterationDocument;
    public $iterationAnnex;

    protected $listeners = [
        'setEmailRecipients',
        'setEmailDistributions',
        'addLeftSignature',
        'addCenterSignature',
        'addRightSignature',
    ];

    public function mount()
    {
        $this->iterationDocument = 1;
        $this->iterationAnnex = 1;

        if(isset($this->document))
        {
            $this->setInputs($this->document);
        }
        else
        {
            $this->resetInput();
        }

        $this->documentTypes = Type::whereNull('partes_exclusive')->pluck('name', 'id');
    }

    public function rules()
    {
        return (new StoreSignatureRequest())->rules($this->document);
    }

    public function render()
    {
        return view('livewire.sign.request-signature')->extends('layouts.bt4.app');
    }

    public function save()
    {
        $this->validate();

        $validator = Validator::make([
            'total_signatures' =>
                $this->left_signatures->count()
                + $this->center_signatures->count()
                + $this->right_signatures->count(),
        ], [
            'total_signatures' => 'required|numeric|min:1',
        ]);


        if($validator->fails())
        {
            session()->flash('danger', 'La solicitud debe tener al menos un firmante');
            return;
        }

        if($this->lastColumn == 'left')
        {
            if($this->column_left_endorse == 'Opcional')
            {
                session()->flash('danger', 'El tipo de Visacion para la columna izquierda debe ser distinto a opcional.');
                return;
            }
        }
        elseif($this->lastColumn == 'center')
        {
            if($this->column_center_endorse == 'Opcional')
            {
                session()->flash('danger', 'El tipo de Visacion para la columna central debe ser distinto a opcional.');
                return;
            }
        }
        elseif($this->lastColumn == 'right')
        {
            if($this->column_right_endorse == 'Opcional')
            {
                session()->flash('danger', 'El tipo de Visacion para la columna derecha debe ser distinto a opcional.');
                return;
            }
        }

        $myColumns = $this->myColumns->keys();

        if(! isset($this->myColumns) || $myColumns->count() == 0)
        {
            session()->flash('danger', 'El Tipo de Firma es un campo obligatorio.');
            return;
        }

        if($myColumns->contains('left') && $this->column_left_endorse == null)
        {
            session()->flash('danger', "El Tipo de Firma en la columna izquierda es obligatorio.");
            return;
        }
        elseif($myColumns->contains('center') && $this->column_center_endorse == null)
        {
            session()->flash('danger', "El Tipo de Firma en la columna central es obligatorio.");
            return;
        }
        elseif($myColumns->contains('right') && $this->column_right_endorse == null)
        {
            session()->flash('danger', "El Tipo de Firma en la columna derecha es obligatorio.");
            return;
        }

        /**
         * Map the recipients
         */
        $recipients = collect($this->recipients);
        $recipients = $recipients->map(function($item) {
            return $item['destination'];
        });
        $this->recipients = $recipients->toArray();

        /**
         * Map the distributions
         */
        $distribution = collect($this->distribution);
        $distribution = $distribution->map(function($item) {
            return $item['destination'];
        });
        $this->distribution = $distribution->toArray();

        /**
         * Save the document
         */
        $folder = Signature::getFolder();
        $filename = 'document-sign-' . now()->timestamp;
        $url = $filename.'.pdf';
        $file = $folder . "/" . $url;

        /**
         * Save the file to sign
         */
        if(isset($this->document))
        {
            $document = $this->document;
            $image = base64_encode(file_get_contents(public_path('/images/logo_rgb.png')));
            $documentFile = \PDF::loadView('documents.templates.'.$document->viewName, compact('document','image'));
            $base64 = base64_encode($documentFile->stream());
            Storage::disk('gcs')->put($file, base64_decode($base64));

        }
        else
        {
            $this->document_to_sign->storeAs($folder, $url, 'gcs');
        }

        /**
         * Create the signature request
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
        $signatureService->setFile($file);
        // $signatureService->setAnnexes(null);
        $signatureService->setSignersLeft($this->left_signatures);
        $signatureService->setSignersCenter($this->center_signatures);
        $signatureService->setSignersRight($this->right_signatures);
        $signatureService->setUserId(auth()->id());
        $signatureService->setOuId(auth()->user()->organizational_unit_id);
        $signature = $signatureService->save();

        /**
         * Save the annexes
         */
        if(isset($this->annex_file))
        {
            foreach($this->annex_file as $fileItem)
            {
                $folder = 'ionline/sign/annexes/';
                $filename = $signature->id . '-' . Str::uuid(12) . '.' . $fileItem->getClientOriginalExtension();
                $file = $folder . $filename;

                $fileItem->storeAs($folder, $filename, 'gcs');

                SignatureAnnex::create([
                    'type' => 'file',
                    'file' => $file,
                    'signature_id' => $signature->id,
                ]);
            }
        }

        /**
         * Save the files
         */
        foreach($this->annexes as $annex)
        {
            SignatureAnnex::create([
                'type' => 'link',
                'url' => $annex['source'],
                'signature_id' => $signature->id,
            ]);
        }

        if(isset($this->document))
        {
            $this->document->update([
                'signature_id' => $signature->id,
            ]);

            session()->flash('success', "La solicitud de firma fue creada exitosamente.");
            return redirect()->route('documents.index');
        }
        else
        {
            session()->flash('success', "La solicitud de firma fue creada exitosamente.");
            $this->resetInput();
        }

    }

    public function resetInput()
    {
        $this->page = 'last';
        $this->reserved = false;

        $this->column_left_visator = false;
        $this->column_center_visator = false;
        $this->column_right_visator = false;

        $this->type_annexed = 'link';
        $this->annexes = collect();

        $this->recipients = collect([]);
        $this->distribution = collect([]);

        $this->namesSignaturesLeft = collect([]);
        $this->namesSignaturesCenter = collect([]);
        $this->namesSignaturesRight = collect([]);

        $this->left_signatures = collect([]);
        $this->center_signatures = collect([]);
        $this->right_signatures = collect([]);

        $this->myColumns = collect();
        $this->columnAvailable = collect(['left' => 0, 'center' => 0, 'right' => 0]);

        $this->iterationDocument++;
        $this->iterationAnnex++;

        $this->reset([
            'document_number',
            'type_id',
            'subject',
            'description',
            'column_left_endorse',
            'column_center_endorse',
            'column_right_endorse',
            'lastColumn',
            'document_to_sign',
            'annex_file',
        ]);
    }

    public function setInputs(Document $document)
    {
        $this->document_to_sign = '';
        $this->type_id = $document->type_id;
        $this->document_number = $document->date->format('Y-m-d');
        $this->subject = $document->subject;

        $distributionString = trim($document->distribution);
        $distributionString = preg_split('/\s+/', $distributionString);
        $distributionString = implode(',', $distributionString);
        $distributionArray = explode(",", $distributionString);

        $this->page = 'last';
        $this->reserved = false;

        $this->column_left_visator = false;
        $this->column_center_visator = false;
        $this->column_right_visator = false;

        $this->recipients = collect([]);
        $distribution = collect($distributionArray);

        $this->distribution = $distribution->map(function($item) {
            $itemDistribution['type'] = 'email';
            $itemDistribution['destination'] = $item;

            return $itemDistribution;
        });

        $this->type_annexed = 'link';
        $this->annexes = collect();

        $this->namesSignaturesLeft = collect([]);
        $this->namesSignaturesCenter = collect([]);
        $this->namesSignaturesRight = collect([]);

        $this->left_signatures = collect([]);
        $this->center_signatures = collect([]);
        $this->right_signatures = collect([]);

        $this->myColumns = collect();
        $this->columnAvailable = collect(['left' => 0, 'center' => 0, 'right' => 0]);
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

            $this->columnAvailable->put('left', $this->columnAvailable->get('left') + 1);
            $this->getColumns();
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

            $this->columnAvailable->put('center', $this->columnAvailable->get('center') + 1);
            $this->getColumns();
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

            $this->columnAvailable->put('right', $this->columnAvailable->get('right') + 1);
            $this->getColumns();
        }
        else
        {
            $this->emit('clearSearchUser', false);
        }
    }

    public function deleteSigner($index, $column)
    {
        switch ($column) {
            case 'left':
                $this->left_signatures = $this->left_signatures->forget($index)->values();
                $this->namesSignaturesLeft = $this->namesSignaturesLeft->forget($index)->values();
                $this->columnAvailable->put('left', $this->columnAvailable->get('left') - 1);
                break;
            case 'center':
                $this->center_signatures = $this->center_signatures->forget($index)->values();
                $this->namesSignaturesCenter = $this->namesSignaturesCenter->forget($index)->values();
                $this->columnAvailable->put('center', $this->columnAvailable->get('center') - 1);
                break;
            case 'right':
                $this->right_signatures = $this->right_signatures->forget($index)->values();
                $this->namesSignaturesRight = $this->namesSignaturesRight->forget($index)->values();
                $this->columnAvailable->put('right', $this->columnAvailable->get('right') - 1);
                break;
        }
        $this->getColumns();
    }

    public function getColumns()
    {
        $this->myColumns = $this->columnAvailable->filter(function ($key, $column) {
            if($column > 0)
                return $key;
        });

        if($this->myColumns->count() == 1)
        {
            $this->lastColumn = $this->myColumns->take(1)->keys()->first();
        }
        elseif($this->myColumns->count() > 0)
        {
            $lastColumn = $this->myColumns->keys();
            $lastColumn = $lastColumn->last();
            $this->lastColumn = $lastColumn;
        }
        elseif($this->myColumns->count() == 0)
        {
            $this->lastColumn = null;
        }
    }

    public function uploadAnnexed()
    {
        $data['type'] = $this->type_annexed;

        if($this->type_annexed == 'link')
        {
            $data['source'] = $this->annex_link;
        }

        $this->annexes->push($data);

        $this->type_annexed = 'link';
        $this->annex_link = null;
    }

    public function deleteAnnexes($index)
    {
        $this->annexes = $this->annexes->forget($index)->values();
    }
}
