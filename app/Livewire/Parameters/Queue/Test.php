<?php

namespace App\Livewire\Parameters\Queue;

use App\Jobs\ProcessApproval;
use App\Jobs\TestJob;
use App\Models\Documents\Approval;
use Livewire\Component;

class Test extends Component
{
    public function testQueue() {
        $approval = Approval::find(1);
        ProcessApproval::dispatch($approval);
        TestJob::dispatch(auth()->user());
    }

    public function render()
    {
        return view('livewire.parameters.queue.test');
    }
}
