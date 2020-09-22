<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Resources\Computer;
use App\Resources\Printer;
use App\Parameters\Location;
use App\Parameters\Place;

class ReportController extends Controller
{
  public function report(Request $request)
  {
    $location_id = null;
    if($request->location_id <> 0){$location_id = $request->location_id;}
    $place_id = null;
    if($request->place_id <> 0){$place_id = $request->place_id;}
    $active_type = null;
    if($request->active_type <> ""){$active_type = $request->active_type;}

    //dd($location_id, $place_id, $active_type);

    $matrix = null;
    $cont = 0;
    $computers = Computer::when($place_id, function ($q, $place_id) {
                             return $q->where('place_id', $place_id);
                           })
                           ->when($location_id, function ($q, $location_id) {
                              return $q->whereHas('place', function ($q) use ($location_id) {
                                     return $q->where('location_id',$location_id);
                                  });
                           })
                           ->when($active_type, function ($q, $active_type) {
                             return $q->where('active_type',$active_type);
                           })
                           ->orderBy('ip','ASC')->get();
    foreach ($computers as $key => $computer) {
      if($computer->ip <> null){
        $matrix[$cont]=$computer;
        $cont = $cont + 1;
      }
    }
    $printers = Printer::when($place_id, function ($q, $place_id) {
                           return $q->where('place_id', $place_id);
                         })
                         ->when($location_id, function ($q, $location_id) {
                            return $q->whereHas('place', function ($q) use ($location_id) {
                                   return $q->where('location_id',$location_id);
                                });
                         })
                         ->when($active_type, function ($q, $active_type) {
                           return $q->where('active_type',$active_type);
                         })
                        ->orderBy('ip','ASC')->get();
    foreach ($printers as $key => $printer) {
      if($printer->ip <> null){
        $matrix[$cont]=$printer;
        $cont = $cont + 1;
      }
    }

    $locations = Location::All();
    $places = Place::All();
    return view('resources.report', compact('computers','printers','locations','places','request'));
  }
}
