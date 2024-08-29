<?php

namespace App\Livewire;

use App\Models\File as ModelsFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class FileMgrList extends Component
{
    use WithFileUploads;

    /**
     * Variable to save the file
     *
     * @var mixed
     */
    public $file;

    /**
     * Model containing the files
     *
     * @var mixed
     */
    public $model;

    /**
     * Collection with files
     *
     * @var mixed
     */
    public $fileLists;

    public function mount()
    {
        $this->fileLists = $this->model->files;
    }

    public function render()
    {
        return view('livewire.file-mgr-list');
    }

    /**
     * Delete a file
     *
     * @param  ModelsFile  $file
     * @return void
     */
    public function deleteFile(ModelsFile $file)
    {
        /**
         * Delete the file from storage
         */
        Storage::disk('gcs')->delete("$file->storage_path/$file->name");

        /**
         * Update the model file
         */
        $file->update([
            'stored' => false,
            'name' => null,
        ]);

        /**
         * Get the files agin
         */
        $this->fileLists = $this->model->files;
    }

    /**
     * Update the file
     *
     * @param  ModelsFile  $file
     * @return void
     */
    public function updateFile(ModelsFile $file)
    {
        /**
         * Delete the previous file
         */
        Storage::disk('gcs')->delete("$file->storage_path/$file->name");

        /**
         * Get the new file
         */
        $temporaryFile = $this->file->getRealPath();

        $folder = $file->storage_path;

        $name = Str::slug($file->input_title).'-'. now()->format('y-m-d-h-i-s-').Str::random(5);

        $extension = File::extension($temporaryFile);

        /**
         * Save the new file
         */
        Storage::disk('gcs')->put("$folder/$name.$extension" , File::get($temporaryFile));

        /**
         * Update the file in the File model
         */
        $file->update([
            'name' => "$name.$extension",
            'stored' => true,
        ]);

        /**
         * Set the file variable to null
         */
        $this->file = null;

        /**
         * Get the files again
         */
        $this->fileLists = $this->model->files;
    }
}
