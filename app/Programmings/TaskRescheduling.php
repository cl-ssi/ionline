<?php

namespace App\Programmings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class TaskRescheduling extends Model
{
    use SoftDeletes;
    protected $table = 'pro_task_rescheduling';

    protected $fillable = [
        'reason', 'date', 'task_id', 'created_by', 'updated_by'
    ];

    public $dates = [
        'date'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
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

    public function task() {
        return $this->belongsTo(Task::class);
    }

    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by')->select(array('id', 'dv', 'name', 'fathers_family', 'mothers_family'))->withTrashed();
    }

    public function updatedBy() {
        return $this->belongsTo(User::class, 'updated_by')->select(array('id', 'dv', 'name', 'fathers_family', 'mothers_family'))->withTrashed();
    }
}
