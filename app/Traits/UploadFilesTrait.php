<?php

namespace App\Traits;

trait UploadFilesTrait
{
    /**
     * Receive files and save them
     *
     * @param  mixed  $files
     * @return void
     */
    public function storeFiles($files)
    {
        $this->filesAll = $files;
    }

    /**
     * Update the files
     *
     * @param  mixed $files
     * @return void
     */
    public function updateFiles($files)
    {
        $this->filesAll = $files;
    }

    /**
     * Reset the files
     *
     * @return void
     */
    public function restoreComponent()
    {
        $this->dispatch('resetAllFiles');
    }
}
