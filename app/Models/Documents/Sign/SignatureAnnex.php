<?php

namespace App\Models\Documents\Sign;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class SignatureAnnex extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sign_annexes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'url',
        'file',
        'signature_id',
    ];

    public function signature()
    {
        return $this->belongsTo(Signature::class);
    }

    public function isFile()
    {
        return $this->type == 'file';
    }

    public function isLink()
    {
        return $this->type == 'link';
    }

    public function getLinkFileAttribute()
    {
        $link = null;
        if($this->isFile() && Storage::disk('gcs')->exists($this->file))
        {
            $link = Storage::disk('gcs')->url($this->file);
        }

        return $link;
    }
}
