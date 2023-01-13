<?php

namespace App\Models\RNIdb;

use App\Models\Establishment;
use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [ 'filename', 'size', 'file', 'establishment_id', 'user_id'];
    protected $table = 'rni_files';

    public function establishment()
    {
        return $this->belongsTo(Establishment::class, 'establishment_id');
    }

    public function registerBy()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'rni_file_user');
    }
}
