<?php

namespace App\Http\Controllers\Suitability;

use App\Models\Suitability\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('suitability.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('suitability.categories.create');
    }

    public function store(Request $request)
    {
        $category = Category::create($request->all());
        return redirect()->route('suitability.categories.index');
        
    }



}
