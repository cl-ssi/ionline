<?php

namespace App\Models\Resources;

use App\Models\Inv\InventoryLabel;
use App\Resources\Computer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ComputerLabel extends Pivot
{
    use HasFactory;

    protected $table = 'res_computer_label';

    protected $fillable = [
        'computer_id',
        'label_id'
    ];

    public function computer()
    {
        return $this->belongsTo(Computer::class);
    }

    public function label()
    {
        return $this->belongsTo(InventoryLabel::class);
    }
}
