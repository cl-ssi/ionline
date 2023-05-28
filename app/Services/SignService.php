<?php

namespace App\Services;

use App\Models\Documents\Sign\Signature;
use App\Models\Documents\Sign\SignatureFlow;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class SignService
{
    /**
     *
     * @var string
     */
    public $document_number;

    /**
     * @var string
     */
    public $type_id;

    /**
     * @var bool
     */
    public $reserved;

    /**
     * @var string
     */
    public $subject;

    /**
     * @var string
     */
    public $description;

    /**
     * @var array
     */
    public $distribution;

    /**
     * @var array
     */
    public $recipients;

    /**
     * @var string
     */
    public $page;

    /**
     * @var bool
     */
    public $column_left_visator;

    /**
     * @var string
     */
    public $column_left_endorse;

    /**
     * @var bool
     */
    public $column_center_visator;

    /**
     * @var string
     */
    public $column_center_endorse;

    /**
     * @var bool
     */
    public $column_right_visator;

    /**
     * @var string
     */
    public $column_right_endorse;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $signers_left;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $signers_center;

    /**
     * @var \Illuminate\Support\Collection
     */
    public $signers_right;

    /**
     * @var string
     */
    public $file;

    /**
     * @var mixed
     */
    public $annexes;

    /**
     * @var string
     */
    public $user_id;

    /**
     * @var string
     */
    public $ou_id;

    /**
     * Initialize the service
     */
    public function __construct()
    {
        $this->page = 'last';
        $this->reserved = false;
    }

    /**
     * @param  string $documentNumber
     * @return void
     */
    public function setDocumentNumber(string $documentNumber)
    {
        $this->document_number = Carbon::parse($documentNumber);
    }

    /**
     * @param  string $typeId
     * @return void
     */
    public function setType(string $typeId)
    {
        $this->type_id = $typeId;
    }

    /**
     * @param  boolean $reserved
     * @return void
     */
    public function setReserved(bool $reserved = false)
    {
        $this->reserved = $reserved;
    }

    /**
     * @param  string $subject
     * @return void
     */
    public function setSubject(string $subject)
    {
        $this->subject = $subject;
    }

    /**
     * @param  string $description|null
     * @return void
     */
    public function setDescription(string $description = null)
    {
        $this->description = $description;
    }

    /**
     * @param  array $distribution
     * @return void
     */
    public function setDistribution(array $distribution)
    {
        $this->distribution = $distribution;
    }

    /**
     * @param  array $recipients
     * @return void
     */
    public function setRecipients(array $recipients)
    {
        $this->recipients = $recipients;
    }

    /**
     * @param  string $page
     * @return void
     */
    public function setPage(string $page = 'last')
    {
        $this->page = $page;
    }

    /**
     * @param  bool $columnLeftVisator
     * @return void
     */
    public function setColumnLeftVisator(bool $columnLeftVisator)
    {
        $this->column_left_visator = $columnLeftVisator;
    }

    /**
     * @param  string $columnLeftEndorse
     * @return void
     */
    public function setColumnLeftEndorse(string $columnLeftEndorse = null)
    {
        $this->column_left_endorse = $columnLeftEndorse;
    }

    /**
     * @param  boolean $columnCenterVisator
     * @return void
     */
    public function setColumnCenterVisator(bool $columnCenterVisator)
    {
        $this->column_center_visator = $columnCenterVisator;
    }

    /**
     * @param  string $columnCenterEndorse
     * @return void
     */
    public function setColumnCenterEndorse(string $columnCenterEndorse = null)
    {
        $this->column_center_endorse = $columnCenterEndorse;
    }

    /**
     * @param  boolean $columnRightVisator
     * @return void
     */
    public function setColumnRightVisator(bool $columnRightVisator)
    {
        $this->column_right_visator = $columnRightVisator;
    }

    /**
     * @param  string $columnRightEndorse
     * @return void
     */
    public function setColumnRightEndorse(string $columnRightEndorse = null)
    {
        $this->column_right_endorse = $columnRightEndorse;
    }

    /**
     * @param  string $userId
     * @return void
     */
    public function setUserId(string $userId)
    {
        $this->user_id = $userId;
    }

    /**
     * @param  string $ouId
     * @return void
     */
    public function setOuId(string $ouId)
    {
        $this->ou_id = $ouId;
    }

    /**
     * @param  string $file
     * @return void
     */
    public function setFile(string $file)
    {
        $this->file = $file;
    }

    /**
     * @param  mixed $annexes
     * @return void
     */
    public function setAnnexes(mixed $annexes)
    {
        $this->annexes = $annexes;
    }

    /**
     * @param  Collection $signersLeft
     * @return void
     */
    public function setSignersLeft(Collection $signersLeft)
    {
        $this->signers_left = $signersLeft;
    }

    /**
     * @param  Collection $signersCenter
     * @return void
     */
    public function setSignersCenter(Collection $signersCenter)
    {
        $this->signers_center = $signersCenter;
    }

    /**
     * @param  Collection $signersRight
     * @return void
     */
    public function setSignersRight(Collection $signersRight)
    {
        $this->signers_right = $signersRight;
    }

    /**
     * Save the Signature and the file to sign
     *
     * @return Signature
     */
    public function save()
    {
        /**
         * Create the Signature request
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
            'file' => $this->file,
            'signed_file' => $this->file,
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
         * Add the signers from the left column
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
         * Add the signers from the center column
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
         * Add the signers from the right column
         */
        foreach($this->signers_right as $indexRight => $itemSignerRight)
        {
            $signerRight = SignatureFlow::create([
                'type' => ($this->column_right_visator) == true ? 'Visador' : 'Firmante',
                'user_id' => $itemSignerRight,
                'file' => $this->file,
                'column_position' => 'right',
                'row_position' => $indexRight,
                'status' => 'pending', // enum
                'status_at' => now(),
                'signer_id' => $itemSignerRight,
            ]);

            $signature->flows()->save($signerRight);
        }

        return $signature;
    }
}