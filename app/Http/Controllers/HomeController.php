<?php

namespace App\Http\Controllers;

use App\Models\Parameters\PhraseOfTheDay;
use App\Models\News\News;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $phrase = PhraseOfTheDay::inRandomOrder()->first();

        /* NEWS: Noticias */
        $allNews = News::all();

        return view('layouts.bt5.home', compact('phrase', 'allNews'));
    }
}
