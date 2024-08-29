<?php

namespace App\Livewire\Requirements;

use Livewire\Component;

class SetCategory extends Component
{
    public $requirement;
    public $category_id;

    /**
    * mount
    */
    public function mount()
    {
        $this->category_id = $this->requirement->category_id;
    }

    /**
    * setCategory
    */
    public function setCategory()
    {
        if(empty($this->category_id)) {
            $this->category_id = null;
        }
        $this->requirement->category_id = $this->category_id;
        $this->requirement->save();
    }

    public function render()
    {
        return view('livewire.requirements.set-category');
    }
}
