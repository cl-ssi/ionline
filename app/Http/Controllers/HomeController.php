<?php

namespace App\Http\Controllers;

use App\Models\Documents\Manual;
use App\Models\Parameters\News;
use App\Models\Parameters\PhraseOfTheDay;

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
        $allNews = News::where('until_at', '>', now())
            ->orWhere('until_at', null)
            ->orderBy('id', 'desc')
            ->get();

        $manuals = Manual::whereNotNull('file')
            ->orderBy('title', 'desc')
            ->get();

        return view('layouts.bt5.home', compact('phrase', 'allNews', 'manuals'));
    }
}
