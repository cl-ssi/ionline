<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AssigmentImport;
use App\Models\Assigment;

class AssigmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      // $bulkLoadRecords = BulkLoadRecord::orderBy('id', 'Desc')->get();
      // return view('lab.bulk_load.import', compact('bulkLoadRecords'));
      $assigments = Assigment::all();

      $service_assigments = array();

      if ($request->type == 1) {
        foreach ($assigments as $key => $assigment) {
          $service_assigments[$assigment->unity][$assigment->porc_est_jorn_prior]['cantidad'] = 0;
        }
        foreach ($assigments as $key => $assigment) {
          $service_assigments[$assigment->unity][$assigment->porc_est_jorn_prior]['cantidad'] += 1;
        }
      }

      if ($request->type == 2) {
        foreach ($assigments as $key => $assigment) {
          $service_assigments[$assigment->unity][$assigment->porc_est_compet_prof]['cantidad'] = 0;
        }
        foreach ($assigments as $key => $assigment) {
          $service_assigments[$assigment->unity][$assigment->porc_est_compet_prof]['cantidad'] += 1;
        }
      }

      if ($request->type == 3) {
        foreach ($assigments as $key => $assigment) {
          $service_assigments[$assigment->unity][$assigment->porc_est_cond_especial]['cantidad'] = 0;
        }
        foreach ($assigments as $key => $assigment) {
          $service_assigments[$assigment->unity][$assigment->porc_est_cond_especial]['cantidad'] += 1;
        }
      }

      if ($request->type == 4) {
        foreach ($assigments as $key => $assigment) {
          $service_assigments[$assigment->unity][$assigment->porc_est_riesgo]['cantidad'] = 0;
        }
        foreach ($assigments as $key => $assigment) {
          $service_assigments[$assigment->unity][$assigment->porc_est_riesgo]['cantidad'] += 1;
        }
      }

      if ($request->type == 5) {
        foreach ($assigments as $key => $assigment) {
          $service_assigments[$assigment->unity][$assigment->porc_est_lugar_aislado]['cantidad'] = 0;
        }
        foreach ($assigments as $key => $assigment) {
          $service_assigments[$assigment->unity][$assigment->porc_est_lugar_aislado]['cantidad'] += 1;
        }
      }

      if ($request->type == 6) {
        foreach ($assigments as $key => $assigment) {
          $service_assigments[$assigment->unity][$assigment->porc_est_turno_llamada]['cantidad'] = 0;
        }
        foreach ($assigments as $key => $assigment) {
          $service_assigments[$assigment->unity][$assigment->porc_est_turno_llamada]['cantidad'] += 1;
        }
      }

      if ($request->type == 7) {
        foreach ($assigments as $key => $assigment) {
          $service_assigments[$assigment->unity][$assigment->porc_est_resid_hosp]['cantidad'] = 0;
        }
        foreach ($assigments as $key => $assigment) {
          $service_assigments[$assigment->unity][$assigment->porc_est_resid_hosp]['cantidad'] += 1;
        }
      }

      if ($request->type == 8) {
        foreach ($assigments as $key => $assigment) {
          $service_assigments[$assigment->unity][$assigment->porc_prof_espe_art_16]['cantidad'] = 0;
        }
        foreach ($assigments as $key => $assigment) {
          $service_assigments[$assigment->unity][$assigment->porc_prof_espe_art_16]['cantidad'] += 1;
        }
      }

      arsort($service_assigments);
      // dd($service_assigments);
      // dd($service_assigments);

      return view('assigments.import',compact('request','assigments','service_assigments'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function import(Request $request){


        Assigment::truncate();
        $file = $request->file('file');

        // $assigmentImportCollection = Excel::toCollection(new AssigmentImport, $file);
        Excel::import(new AssigmentImport, $file);

        session()->flash('success', 'El archivo fue cargado exitosamente.');
        return redirect()->route('assigment.index');
    }
}
