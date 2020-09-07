<?php

namespace App\Http\Controllers\Requirements;

//use App\Requirements\RequirementCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Requirements\Category;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $categories = Auth::User()->reqCategories;
      //$categories = Category::where('user_id',Auth::id())
      return view('requirements.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      //$establishments = Establishment::orderBy('name','ASC')->get();
      return view('requirements.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $category = new Category($request->all());
      //$dispatch->pharmacy_id = session('pharmacy_id');
      $category->user_id = Auth::id();
      $category->save();

      session()->flash('success', 'Se ha guardado la categoría.');
      return redirect()->route('requirements.categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Requirements\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Requirements\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
      //$categories = Category::All();
      //$programs = Program::All();
      return view('requirements.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Requirements\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
      $category->fill($request->all());
      $category->save();

      session()->flash('info', 'La categoría '.$category->name.' ha sido editada.');
      return redirect()->route('requirements.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Requirements\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
