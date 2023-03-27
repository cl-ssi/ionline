<?php

namespace App\Programmings;

use App\Models\Indicators\Value;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    use SoftDeletes;
    protected $table = 'pro_tasks';

    protected $fillable = [
        'name', 'date', 'activity_id', 'created_by', 'updated_by'
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

    public function activity() {
        return $this->belongsTo(Value::class, 'activity_id');
    }

    public function reschedulings() {
        return $this->hasMany(TaskRescheduling::class);
    }

    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by')->select(array('id', 'dv', 'name', 'fathers_family', 'mothers_family'))->withTrashed();
    }

    public function updatedBy() {
        return $this->belongsTo(User::class, 'updated_by')->select(array('id', 'dv', 'name', 'fathers_family', 'mothers_family'))->withTrashed();
    }

    public function getRowspanCountAttribute(){
        return $this->reschedulings->count() > 0 ? $this->reschedulings->count() : 1;
    }
}
