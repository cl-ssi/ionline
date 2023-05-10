<?php

namespace App\Http\Livewire\Rrhh;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Rrhh\NoAttendanceRecord;

class NoAttendanceRecordIndex extends Component
{
	use WithPagination;
	protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.rrhh.no-attendance-record-index',[
            'records' => NoAttendanceRecord::paginate(50),
        ]);
    }
}
