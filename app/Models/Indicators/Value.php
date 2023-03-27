<?php

namespace App\Models\Indicators;

use App\Programmings\Task;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Value extends Model
{
    use SoftDeletes;
    protected $table = 'ind_values';
    protected $fillable = ['activity_name', 'commune', 'establishment', 'month', 'factor', 'value', 'valueable_id', 'valueable_type', 'created_by', 'updated_by'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->updated_by = Auth::id();
            $model->created_by = Auth::id();
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });

        static::deleting(function ($model) {
            $model->updated_by = Auth::id();
            $model->save();
        });
    }

    public function valueable(){
        return $this->morphTo();
    }

    public function creator(){
        return $this->belongsTo(User::class,'created_by')->withTrashed();
    }

    public function editor(){
        return $this->belongsTo(User::class,'edited_by')->withTrashed();
    }

    public function attachedFiles()
    {
        return $this->morphMany(AttachedFile::class, 'attachable');
    }

    public function tasks(){
        return $this->hasMany(Task::class, 'activity_id');
    }
}