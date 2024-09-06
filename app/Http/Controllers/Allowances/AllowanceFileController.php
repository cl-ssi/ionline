<?php

namespace App\Http\Controllers\Allowances;

use App\Models\Allowances\AllowanceFile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AllowanceFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AllowanceFile  $allowanceFile
     * @return \Illuminate\Http\Response
     */
    public function show(AllowanceFile $allowanceFile)
    {
        return Storage::response($allowanceFile->file);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AllowanceFile  $allowanceFile
     * @return \Illuminate\Http\Response
     */
    public function edit(AllowanceFile $allowanceFile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AllowanceFile  $allowanceFile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AllowanceFile $allowanceFile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AllowanceFile  $allowanceFile
     * @return \Illuminate\Http\Response
     */
    public function destroy(AllowanceFile $allowanceFile)
    {
        //Storage::delete($requestReplacementStaff->request_verification_file);
    }
}
