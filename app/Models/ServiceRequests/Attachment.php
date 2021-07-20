<?php

namespace App\Models\ServiceRequests;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{
    use HasFactory;
    use softDeletes;

    protected $fillable = [
        'name', 'file', 'fulfillment_id'
    ];


    protected $table = 'doc_fulfillments_attachments';

}
