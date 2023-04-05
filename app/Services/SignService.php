<?php

namespace App\Services;

use App\Models\Documents\Sign\Signature;
use App\Models\Documents\Sign\SignatureFlow;
use Illuminate\Support\Carbon;

class SignService
{
    public $document_number;

    public $type_id;

    public $reserved;

    public $subject;

    public $description;

    public $distribution;

    public $recipients;

    public $page;

    public $column_left_visator;

    public $column_left_endorse;

    public $column_center_visator;

    public $column_center_endorse;

    public $column_right_visator;

    public $column_right_endorse;

    public $signers_left;

    public $signers_center;

    public $signers_right;

    public $file;

    public $annexes;

    public $user_id;

    public $ou_id;

    public function __construct()
    {
        $this->page = 'last';
        $this->reserved = false;
    }

    // tipo de visacion
    // opcional (uno o mas usuario)
    // obligatorio sin cadena (uno o mas)
    // obligatorio en cadena responsabilidad (dos o mas usuario)

    // si no hay usuario no aparezca el tipo de visacion
    public function setDocumentNumber(string $documentNumber)
    {
        $this->document_number = Carbon::parse($documentNumber);
    }

    public function setType($typeId)
    {
        $this->type_id = $typeId;
    }

    public function setReserved(bool $reserved = false)
    {
        $this->reserved = $reserved;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setDistribution($distribution)
    {
        $this->distribution = $distribution;
    }

    public function setRecipients($recipients)
    {
        $this->recipients = $recipients;
    }

    public function setPage(string $page = 'last')
    {
        $this->page = $page;
    }

    public function setColumnLeftVisator($columnLeftVisator)
    {
        $this->column_left_visator = $columnLeftVisator;
    }

    public function setColumnLeftEndorse($columnLeftEndorse)
    {
        $this->column_left_endorse = $columnLeftEndorse;
    }

    public function setColumnCenterVisator($columnCenterVisator)
    {
        $this->column_center_visator = $columnCenterVisator;
    }

    public function setColumnCenterEndorse($columnCenterEndorse)
    {
        $this->column_center_endorse = $columnCenterEndorse;
    }

    public function setColumnRightVisator($columnRightVisator)
    {
        $this->column_right_visator = $columnRightVisator;
    }

    public function setColumnRightEndorse($columnRightEndorse)
    {
        $this->column_right_endorse = $columnRightEndorse;
    }

    public function setUserId($userId)
    {
        $this->user_id = $userId;
    }

    public function setOuId($ouId)
    {
        $this->ou_id = $ouId;
    }

    public function setFile($file)
    {
        $this->file = $file;
    }

    public function setAnnexes($annexes)
    {
        $this->annexes = $annexes;
    }

    public function setSignersLeft($signersLeft)
    {
        $this->signers_left = $signersLeft;
    }

    public function setSignersCenter($signersCenter)
    {
        $this->signers_center = $signersCenter;
    }

    public function setSignersRight($signersRight)
    {
        $this->signers_right = $signersRight;
    }

    public function save()
    {
        /**
         * Crea la solicitud de Firma
         */
        $signature = Signature::create([
            'document_number' => $this->document_number,
            'type_id' => $this->type_id,
            'reserved' => $this->reserved,
            'subject' => $this->subject,
            'description' => $this->description,
            'distribution' => implode(',', $this->distribution),
            'recipients' => implode(',', $this->recipients),
            'status' => 'pending', // enum
            'status_at' => now(),
            'page' => $this->page,
            'column_left_visator' => $this->column_left_visator,
            'column_left_endorse' => $this->column_left_endorse,
            'column_center_visator' => $this->column_center_visator,
            'column_center_endorse' => $this->column_center_endorse,
            'column_right_visator' => $this->column_right_visator,
            'column_right_endorse' => $this->column_right_endorse,
            'user_id' => auth()->id(),
            'ou_id' => $this->ou_id,
        ]);

        /**
         * Agrega los firmantes de la columna izquierda
         */
        foreach($this->signers_left as $indexLeft => $itemSignerLeft)
        {
            $signerLeft = SignatureFlow::create([
                'type' => ($this->column_left_visator == true) ? 'Visador' : 'Firmante',
                'file' => $this->file,
                'column_position' => 'left',
                'row_position' => $indexLeft,
                'status' => 'pending', // enum
                'status_at' => now(),
                'signer_id' => $itemSignerLeft,
            ]);

            $signature->flows()->save($signerLeft);
        }

        /**
         * Agrega los firmantes de la columna derecha
         */
        foreach($this->signers_center as $indexCenter => $itemSignerCenter)
        {
            $signerCenter = SignatureFlow::create([
                'type' => ($this->column_center_visator == true) ? 'Visador' : 'Firmante',
                'user_id' => $itemSignerCenter,
                'file' => $this->file,
                'column_position' => 'center',
                'row_position' => $indexCenter,
                'status' => 'pending', // enum
                'status_at' => now(),
                'signer_id' => $itemSignerCenter,
            ]);

            $signature->flows()->save($signerCenter);
        }

        /**
         * Agrega los firmantes de la columna derecha
         */
        foreach($this->signers_right as $indexRight => $itemSignerRight)
        {
            $signerRight = SignatureFlow::create([
                'type' => ($this->column_right_visator) == true ? 'Visador' : 'Firmante',
                'user_id' => $itemSignerCenter,
                'file' => $this->file,
                'column_position' => 'right',
                'row_position' => $indexRight,
                'status' => 'pending', // enum
                'status_at' => now(),
                'signer_id' => $itemSignerRight,
            ]);

            $signature->flows()->save($signerRight);
        }
    }
}