<?php

namespace App\Models\Indicators;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttachedFile extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'ind_attached_files';
    protected $fillable = [
        'file', 'document_name', 'commune', 'establishment', 'section', 'attachable_type', 'attachable_id'
    ];

    public function attachable(){
        return $this->morphTo();
    }

}
