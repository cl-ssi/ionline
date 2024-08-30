<?php

namespace App\Livewire;

use Livewire\Attributes\On;
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

    /**
     * Uploaded File Counter
     *
     * @var int
     */
    public $countFile;

    /**
     * Folder where the files will be saved
     *
     * @return void
     */
    public $storage_path;

    public function mount()
    {
        /**
         * Build to accept for accept tag
         */
        $separator = ', .';

        $collectionValidFileTypes = collect($this->valid_types);

        $this->accept = $collectionValidFileTypes->implode($separator);

        $this->accept = '.' . $this->accept;

        /**
         * Set the countFile to zero
         */
        $this->countFile = 0;

        /**
         * Reset the collection files
         */
        $this->files = collect();
    }

    public function render()
    {
        return view('livewire.file-mgr');
    }

    /**
     * Save the files
     *
     * @return void
     */
    public function saveFile()
    {
        /**
         * Validate the files
         */
        $this->validate([
            'file' => File::types($this->valid_types)
                ->min(5) // MIN: 5KB
                ->max($this->max_file_size * 1024),// MAX: MB to KB

        ]);

        /**
         * Get the file to save
         */
        $info['temporaryFile'] = $this->file->getRealPath();
        $info['temporaryFilename'] = $this->file->getClientOriginalName();

        /**
         * Push the uploaded file into the collection
         */
        $this->files->push($info);

        /**
         * Emit to save the files
         */
        $this->dispatch('storeFiles', files: $this->files);

        /**
         * Increase the count to reset the input
         */
        $this->countFile++;

        /**
         * Set the file to null
         */
        $this->file = null;
    }

    /**
     * Delete a file
     *
     * @param  mixed  $index
     * @return void
     */
    public function deleteFile($index)
    {
        /**
         * Delete the file from the collection
         */
        $this->files = $this->files->forget($index)->values();

        /**
         * Emit to updateFiles with the file array
         */
        $this->dispatch('updateFiles', $this->files->toArray());
    }

    /**
     * Reset all files
     *
     * @return void
     */
    #[On('resetAllFiles')]
    public function resetAllFiles()
    {
        $this->files = collect();
    }
}
