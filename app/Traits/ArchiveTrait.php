<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use App\Models\Archive\Archive;

trait ArchiveTrait
{
    /*
    * Archive
    */
    
    public function archive($class_name, $id)
    {
        $modelToArchive = $class_name::find($id);
        
        $archive = $modelToArchive->archive()->create([
            'user_id' => auth()->id(),
        ]);
    }

    public function unarchive($class_name, $id)
    {
        $modelToUnarchive = Archive::where('archive_type', $class_name)
            ->where('archive_id', $id)
            ->first();
        
        $modelToUnarchive->delete();
    }
}