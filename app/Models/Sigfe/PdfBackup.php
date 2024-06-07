<?php

namespace App\Models\Sigfe;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\File;

class PdfBackup extends Model
{
    

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'fin_receptions';

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
