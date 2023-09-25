<?php

namespace App\Models\His;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\User;
use App\Models\Documents\Approval;
use App\Models\His\ModificationRequestFile;

class ModificationRequest extends Model
{
    use HasFactory;

    /**
    * The primary key associated with the table.
    *
    * @var string
    */
    protected $table = 'his_modification_requests';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'id',
        'type',
        'subject',
        'body',
    ];
    
    public function creator()
    {
        return $this->belongsTo(User::class,'creator_id')->withTrashed();
    }

    /**
     * Get all of the ModificationRequest's approvations.
     */
    public function approvals(): MorphMany
    {
        return $this->morphMany(Approval::class, 'approvable');
    }

    public function files()
    {
        return $this->hasMany(ModificationRequestFile::class,'request_id');
    }

    /**
    * Get Color With status
    */
    public function getColorAttribute()
    {
        switch($this->status) {
            case '0': return 'danger'; break;
            case '1': return 'success'; break;
            default: return ''; break;
        }
    }
}
