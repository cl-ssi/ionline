<?php

namespace App\Http\Livewire\News;

use Livewire\Component;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Models\News\News;

class SearchNews extends Component
{
    public $renderPage;

    public function render()
    {
        if(Route::current()->uri == 'news/index'){
            $newsList = News::latest()->paginate(20);
            return view('livewire.news.search-news', compact('newsList'));
        }
        if(Route::current()->uri == 'news/own_index'){
            $newsList = News::where('user_id', Auth::user()->id)->paginate(20);
            return view('livewire.news.search-news', compact('newsList'));
        }
    }

    public function index(){
        $this->render();
    }

    public function own_index(){
        $this->render();
    }
}
