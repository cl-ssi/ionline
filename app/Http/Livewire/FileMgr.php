<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rules\File;

class FileMgr extends Component
{
    use WithFileUploads;

    /**
     * Flag to indicate if there are multiple files
     *
     * @var boolean
     */
    public $multiple;

    /**
     * Valid file types
     *
     * @var array
     */
    public $valid_types;

    /**
     * Maximum files in MB
     *
     * @var int
     */
    public $max_file_size;

    /**
     * File
     *
     * @var mixed
     */
    public $file;

    /**
     * Files
     *
     * @var mixed
     */
    public $files;

    /**
     * Tag accept
     *
     * @var string
     */
    public $accept;

    /**
     * Input title
     *
     * @var string
     */
    public $input_title;


    public function mount()
    {
        /**
         * Build to accept for accept tag
         */
        $separator = ', .';

        $collectionValidFileTypes = collect($this->valid_types);

        $this->accept = $collectionValidFileTypes->implode($separator);

        $this->accept = '.' . $this->accept;
    }

    public function render()
    {
        return view('livewire.file-mgr');
    }

    /**
     * emitFile
     */
    public function emitFile()
    {
        /**
         * Validate the files
         */
        $this->validate([
            'file' => File::types($this->valid_types)
                ->min(100) // MIN: 1MB or 1KB
                ->max($this->max_file_size * 1024),// MAX: MB to KB

        ]);

        /**
         * Emit to save the files
         */
        $this->emit('storeFiles', $this->file->getRealPath());
    }
}
