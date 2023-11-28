<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;

class TestFileManager extends Component
{
    public $fileReceived;

    protected $listeners = [
        'storeFiles',
    ];

    public function render()
    {
        return view('livewire.test-file-manager');
    }

    /**
     * Save
     */
    public function save()
    {
        // guardar el archivo
    }

    /**
     * storeFiles
     */
    public function storeFiles($temporaryFile)
    {
        $folder = 'test';

        $name = Str::random();

        $extension = File::extension($temporaryFile);

        Storage::disk('gcs')->put("$folder/$name.$extension" , File::get($temporaryFile));

        dd('listo');
    }
}
