<?php

namespace App\Http\Livewire\Requirements;

use Livewire\Component;

use App\Requirements\Category;
use App\Requirements\Requirement;
use App\Requirements\RequirementCategory;

class SetCategory extends Component
{
    public $req;

    public $reqCategories;
    public $reqCategoriesArray;

    public function setCategory($category_id)
    {
        if(in_array($category_id, $this->reqCategoriesArray))
        {
            /** este modelo no tiene ID hay que hacer la query para borrar */
            RequirementCategory::where('requirement_id',$this->req->id)
                ->where('category_id',$category_id)->delete();
        }
        else
        {
            RequirementCategory::Create([
                'requirement_id' => $this->req->id,
                'category_id' => $category_id
            ]);
        }
        
        $this->req->refresh();
    }

    public function render()
    {
        $this->reqCategories = $this->req->categories->where('user_id',auth()->id());
        $this->reqCategoriesArray = $this->reqCategories->pluck('id')->toArray();

        return view('livewire.requirements.set-category');
    }
}
