<?php

namespace App\Http\Livewire\Parameters\Queue;

use App\Jobs\TestJob;
use Livewire\Component;

class Test extends Component
{
    public function testQueue() {
        // ProcessApproval::dispatch($approval);
        TestJob::dispatch(auth()->user());
    }

    public function render()
    {
        return view('livewire.parameters.queue.test');
    }
}
