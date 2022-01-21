<?php

namespace App\Http\Controllers\Requirements;

use App\Documents\Parte;
use App\Documents\Document;
use App\Mail\RequirementNotification;
use App\Requirements\Requirement;
use App\Requirements\Event;
use App\Requirements\EventStatus;
use App\Requirements\RequirementCategory;
use App\Requirements\RequirementStatus;
use App\Requirements\EventDocument;
use App\Requirements\Category;
use App\Requirements\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rrhh\OrganizationalUnit;
use App\Rrhh\Authority;
use App\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Redirect;

class RequirementController extends Controller
{

  public function __constructor()
  {
    Carbon::setLocale('es');
  }

  public function inbox()
  {
  }

  public function outbox(Request $request)
  {
    //         set_time_limit(3600);

    //$parametro_busqueda = $request['text'];
    //      dd($request);

    $users[0] = Auth::user()->id;
    //$users[0] = array();
    $ous_secretary = Authority::getAmIAuthorityFromOu(date('Y-m-d'), 'secretary', Auth::user()->id);
    //$ous_secretary = Authority::getAmIAuthorityFromOu(Carbon::today(), 'secretary', Auth::user()->id);
    //ssdd($ous_secretary);
    foreach ($ous_secretary as $secretary) {
      $users[] = Authority::getAuthorityFromDate($secretary->OrganizationalUnit->id, date('Y-m-d'), 'manager')->user_id;
      //$users[] = Authority::getAuthorityFromDate($secretary->OrganizationalUnit->id, Carbon::today(), 'manager')->user_id;
    }

    // when($parametro_busqueda, function ($query, $parametro_busqueda) {
    //     return $query->where('type', 'LIKE', '%'.$parametro_busqueda.'%' );
    // })

    $request_usu = $request['request_usu'];
    $archived_requirements = Requirement::whereHas('events', function ($query) use ($users) {
      $query->whereIn('from_user_id', $users)
        ->orWhereIn('to_user_id', $users);
    })->whereHas('RequirementStatus', function ($query) use ($users) {
      $query->where('status', 'viewed')
        ->whereIn('user_id', $users);
    })
      ->when($request['request_req'], function ($query, $request) {
        return $query->Search($request);
      })
      ->when($request['request_cat'], function ($query, $request) {
        return $query->whereHas('categories', function ($query) use ($request) {
          $query->Search($request);
        });
      })
      ->when($request_usu, function ($query, $request_usu) {
        return $query->whereHas('events', function ($query) use ($request_usu) {
          $query->whereHas('from_user', function ($query) use ($request_usu) {
            $query->Search($request_usu);
          })
            ->OrWhereHas('to_user', function ($query) use ($request_usu) {
              $query->Search($request_usu);
            });
        });
      })
      ->when($request['request_parte'], function ($query, $request) {
        return $query->whereHas('parte', function ($query) use ($request) {
          $query->Search2($request);
        });
      })
      ->orderBy('created_at', 'DESC');
    //->count();dd($archived_requirements);

    //dd($archived_requirements);
    $archived_requirements_count = $archived_requirements;
    $archived_requirements_paginate = $archived_requirements;

    //se obtienen los id de requerimientos archivados
    $archivados = $archived_requirements_count->pluck('id');
    // foreach ($archived_requirements_count->get() as $key => $req) {
    //   $archivados[$key] =$req->id;
    // }

    //dd($archivados);

    //si objeto es nulo, esporque no existen id's archivados, y no se debe agregar la clausula whereNotIn
    if (empty($archivados)) {

      $created_requirements = Requirement::whereHas('events', function ($query) use ($users) {
        $query->whereIn('from_user_id', $users)
          ->orWhereIn('to_user_id', $users);
      })
        ->when($request['request_req'], function ($query, $request) {
          return $query->Search($request);
        })
        ->when($request['request_cat'], function ($query, $request) {
          return $query->whereHas('categories', function ($query) use ($request) {
            $query->Search($request);
          });
        })
        ->when($request_usu, function ($query, $request_usu) {
          return $query->whereHas('events', function ($query) use ($request_usu) {
            $query->whereHas('from_user', function ($query) use ($request_usu) {
              $query->Search($request_usu);
            })
              ->OrWhereHas('to_user', function ($query) use ($request_usu) {
                $query->Search($request_usu);
              });
          });
        })
        ->when($request['request_parte'], function ($query, $request) {
          return $query->whereHas('parte', function ($query) use ($request) {
            $query->Search2($request);
          });
        })
        ->orderBy('created_at', 'DESC');
    } else {
      $created_requirements = Requirement::with('events')->whereHas('events', function ($query) use ($users) {
        $query->whereIn('from_user_id', $users)
          ->orWhereIn('to_user_id', $users);
      })
        ->when($request['request_req'], function ($query, $request) {
          return $query->Search($request);
        })
        ->when($request['request_cat'], function ($query, $request) {
          return $query->whereHas('categories', function ($query) use ($request) {
            $query->Search($request);
          });
        })
        ->when($request_usu, function ($query, $request_usu) {
          return $query->whereHas('events', function ($query) use ($request_usu) {
            $query->whereHas('from_user', function ($query) use ($request_usu) {
              $query->Search($request_usu);
            })
              ->OrWhereHas('to_user', function ($query) use ($request_usu) {
                $query->Search($request_usu);
              });
          });
        })
        ->when($request['request_parte'], function ($query, $request) {
          return $query->whereHas('parte', function ($query) use ($request) {
            $query->Search2($request);
          });
        })
        ->WhereNotIn('id', $archivados) //<--- esta clausula permite traer todos los requerimientos que no esten archivados
        ->orderBy('created_at', 'DESC');
    }

    $created_requirements_paginate = $created_requirements;
    $created_requirements = $created_requirements_paginate->paginate(50);

    $archived_requirements = $archived_requirements_paginate->paginate(50);

    $legend['creados'] = 0;
    $legend['recibidos'] = 0;
    $legend['respondidos'] = 0;
    $legend['derivados'] = 0;
    $legend['cerrados'] = 0;
    $legend['reabiertos'] = 0;
    $legend['en copia'] = 0;

    foreach ($created_requirements as $req) {

      $flag = 0;
      foreach ($req->events as $key => $event) {
        if ($event->status == "en copia" && $event->to_user_id == Auth::user()->id) {
          $flag = 1;
          break;
        }
      }
      //si es que estuvo al menos "en copia" en req
      if ($flag == 1) {
        $legend['en copia']++;
      } else {
        switch ($req->status) {
          case 'creado':
            if ($req->user->id == Auth::user()->id) {
              $legend['creados']++;
            } else {
              $legend['recibidos']++;
            }
            break;
          case 'respondido':
            $legend['respondidos']++;
            break;
          case 'derivado':
            $legend['derivados']++;
            break;
          case 'cerrado':
            $legend['cerrados']++;
            break;
          case 'reabierto':
            $legend['reabiertos']++;
            break;
        }
      }
    }

    /* Eliminé esto pora dejar sólo lo pendiente por atender */
    // foreach($archived_requirements as $req){
    //     //echo $req->status;
    //     switch($req->status){
    //         case 'creado ':
    //             if($req->user == Auth::user()) {
    //                 $legend['creados']++;
    //             }
    //             else {
    //                 $legend['recibidos']++;
    //             }
    //             break;
    //         case 'respondido':  $legend['respondidos']++;    break;
    //         case 'derivado':    $legend['derivados']++;      break;
    //         case 'cerrado':     $legend['cerrados']++;       break;
    //         case 'reabierto':   $legend['reabiertos']++;     break;
    //     }
    // }
    //dd($legend);


    //fixme SE DEMORA MUCHO
    //ciclo para definir si requerimiento tiene todos los eventos vistos (ticket verde) o no (ticket plomo)
    //        $events_status = EventStatus::where('user_id',Auth::user()->id)->get();
    $events_status_id_event_array = EventStatus::where('user_id', Auth::user()->id)->pluck('event_id')->toArray();

    foreach ($created_requirements as $key => $req) {
      $flag = 0;
      foreach ($req->events as $key => $event) {
        foreach ($events_status_id_event_array as $key => $event_id) {
          if ($event->id == $event_id) {
            $flag += 1;
          }
        }
      }
      if (count($req->events) == $flag) {
        $req->status_view = "visto";
      } else {
        $req->status_view = "sin revisar";
      }
      if($req->status == 'creado' && $req->user_id == auth()->user()->id){
        $req->status_view = "visto";
      }
    }


    //fixme SE DEMORA MUCHO
    foreach ($archived_requirements as $key => $req) {
      $flag = 0;
      foreach ($req->events as $key => $event) {
        foreach ($events_status_id_event_array as $key => $event_id) {
          if ($event->id == $event_id) {
            $flag += 1;
          }
        }
      }
      if (count($req->events) == $flag) {
        $req->status_view = "visto";
      } else {
        $req->status_view = "sin revisar";
      }
      if($req->status == 'creado' && $req->user_id == auth()->user()->id){
        $req->status_view = "visto";
      }
    }

    //dd($created_requirements);
    return view('requirements.outbox', compact('created_requirements', 'archived_requirements', 'legend'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create_requirement(Parte $parte)
  {
    $documents = Document::all()->sortBy('id');
    $ous = OrganizationalUnit::all()->sortBy('name');
    //        $organizationalUnit = OrganizationalUnit::Find(1);
    $categories = Category::where('user_id', Auth::user()->id)->get();
    $ouRoots = OrganizationalUnit::where('level', 1)->get();
    // $requirementCategories = RequirementCategory::where('requirement_id',$requirement->id)->get();
    // $categories = Category::where('user_id',Auth::user()->id)->get();
    return view('requirements.create', compact('ous', 'ouRoots', 'parte', 'documents','categories'));
  }

  public function create_requirement_sin_parte()
  {
    $documents = Document::all()->sortBy('id');
    $parte = new Parte;
    $ous = OrganizationalUnit::all()->sortBy('name');
    //      $organizationalUnit = OrganizationalUnit::Find(1);
    $ouRoots = OrganizationalUnit::where('level', 1)->get();
    $categories = Category::where('user_id', Auth::user()->id)->get();
    //equirementCategory::where('requirement_id',$requirement->id)->get();

    return view('requirements.create', compact('ous', 'ouRoots', 'parte', 'documents', 'categories'));
  }

  public function archive_requirement(Requirement $requirement)
  {
    $requirementStatus = new RequirementStatus();
    $requirementStatus->requirement_id = $requirement->id;
    $requirementStatus->user_id = Auth::user()->id;
    $requirementStatus->status = "viewed";
    $requirementStatus->save();

    //return redirect()->route('requirements.outbox');
    return redirect()->back()->with('success', 'Se han Archivado correctamente');;
  }

  public function archive_requirement_delete(Requirement $requirement)
  {
    $requirementStatus = RequirementStatus::where('requirement_id', $requirement->id)
      ->where('user_id', Auth::user()->id)
      ->where('status', 'viewed');
    $requirementStatus->delete();

    return redirect()->route('requirements.outbox');
  }


  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //si solo se manda desde la vista un solo usuario, sin usar la tabla dinámica
    if ($request->users == null) {
      $req = $request->All();
      if ($request->limit_at <> null) {
        $req['limit_at'] = Carbon::createFromFormat('Y-m-d\TH:i', $request->limit_at)->format('Y-m-d H:i:00');
      }

      $requirement = new Requirement($req);
      $requirement->user()->associate(Auth::user());

      $requirement->save();
      $requirement->categories()->attach($request->input('category_id'));



      //se guarda evento
      $firstEvent = new Event($request->All());
      $firstEvent->from_user()->associate(Auth::user());
      $firstEvent->from_ou_id = Auth::user()->organizationalUnit->id;
      $firstEvent->requirement()->associate($requirement);
      $firstEvent->save();

      //asocia evento con documentos
      if ($request->documents <> null) {
        foreach ($request->documents as $key => $document_aux) {
          $document = Document::find($document_aux);
          $firstEvent->documents()->attach($document);
        }
      }

      //guarda archivos
      if ($request->hasFile('forfile')) {
        foreach ($request->file('forfile') as $file) {
          $filename = $file->getClientOriginalName();
          $fileModel = new File;
          $fileModel->file = $file->store('requirements');
          $fileModel->name = $filename;
          $fileModel->event_id = $firstEvent->id;
          $fileModel->save();
        }
      }

      $requirement->events()->save($firstEvent);

      preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $firstEvent->to_user->email, $emails);
      if (env('APP_ENV') == 'production') {
        Mail::to($emails[0])
          ->send(new RequirementNotification($requirement));
      }



      session()->flash('info', 'El requerimiento ' . $requirement->id . ' ha sido creado.');
    } else {

      //encuentra cuales son usuarios para requerimientos, y cuales son en copia
      $users_req = null;
      $users_enCopia = null;
      foreach ($request->enCopia as $key => $enCopia) {
        if ($enCopia == 0) {
          $users_req[] = $request->users[$key];
        }
        if ($enCopia == 1) {
          $users_enCopia[] = $request->users[$key];
        }
      }

      //se crearán requerimientos según usuarios agregados en tabla dinámica.
      $users = array_unique($users_req); //distinct
      $flag = 0;

      //obtiene nro para agrupar requerimientos
      if (Requirement::whereNotNull('group_number')->count() === 0) {
        $group_number = 1;
      } else {
        $group_number = Requirement::whereNotNull('group_number')
          ->latest()
          ->first()
          ->group_number + 1;
      }

      //$requerimientos = '';
      $usersEmail = '';
      foreach ($users as $key => $user) {

        $req = $request->All();
        if ($request->limit_at <> null) {
          $req['limit_at'] = Carbon::createFromFormat('Y-m-d\TH:i', $request->limit_at)->format('Y-m-d H:i:00');
        }

        //se crea requerimiento
        $requirement = new Requirement($req);
        $requirement->user()->associate(Auth::user());
        $requirement->group_number = $group_number;
        $requirement->save();

        //se ingresa una sola vez: se guardan posibles usuarios en copia. Se agregan primero que otros eventos del requerimiento, para que no queden como "last()"
        if ($users_enCopia <> null) {
          if ($flag == 0) {
            foreach ($users_enCopia as $key => $user_) {
              $user_aux = User::where('id', $user_)->get();
              $firstEvent = new Event($request->All());
              $firstEvent->to_user_id = $user_;
              $firstEvent->to_ou_id = $user_aux->first()->organizational_unit_id;
              $firstEvent->status = "en copia";
              $firstEvent->from_user()->associate(Auth::user());
              $firstEvent->from_ou_id = Auth::user()->organizationalUnit->id;
              $firstEvent->requirement()->associate($requirement);
              $firstEvent->save();

              $requirement->events()->save($firstEvent);
            }
            $flag = 1;
          }
        }

        //se ingresan los otros tipos de eventos (que no sean "en copia")
        $firstEvent = new Event($request->All());
        //$firstEvent->organizational_unit_id = $user_aux->first()->organizational_unit_id;
        $user_aux = User::find($user);
        if($user_aux){
          $firstEvent->to_user_id = $user_aux->id;
          $firstEvent->to_ou_id = $user_aux->organizational_unit_id;
        }
        $firstEvent->from_user()->associate(Auth::user());
        $firstEvent->from_ou_id = Auth::user()->organizationalUnit->id;
        $firstEvent->requirement()->associate($requirement);
        $firstEvent->save();

        //Obtiene emails
        $usersEmail .= $user_aux->first()->email . ',';

        //asocia evento con documentos
        if ($request->documents <> null) {
          foreach ($request->documents as $key => $document_aux) {
            $document = Document::find($document_aux);
            $firstEvent->documents()->attach($document);
          }
        }

        //guarda archivos
        if ($request->hasFile('forfile')) {
          foreach ($request->file('forfile') as $file) {
            $filename = $file->getClientOriginalName();
            $fileModel = new File;
            $fileModel->file = $file->store('requirements');
            $fileModel->name = $filename;
            $fileModel->event_id = $firstEvent->id;
            $fileModel->save();
          }
        }

        $requirement->events()->save($firstEvent);
        //$requerimientos = $requerimientos + $firstEvent->id + ",";
      }

      preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $usersEmail, $emails);
      Mail::to($emails[0])
        ->send(new RequirementNotification($requirement));

      session()->flash('info', 'Los requerimientos han sido creados.');
    }

    /* Si es un requerimiento creado desde un parte envía a inbox de parte */
    if ($requirement->parte_id) $return = 'documents.partes.index';
    else $return = 'requirements.outbox';



    return redirect()->route($return);
  }

  public function asocia_categorias(Request $request)
  {
    $req = RequirementCategory::where('requirement_id', $request->requirement_id);
    $req->delete();

    if ($request->category_id <> null) {
      foreach ($request->category_id as $key => $category_id) {

        $RequirementCategory = new RequirementCategory();
        $RequirementCategory->requirement_id = $request->requirement_id;
        $RequirementCategory->category_id = $category_id;
        $RequirementCategory->save();
      }
    }

    return Redirect::back();
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Requirements\Requirement  $requirement
   * @return \Illuminate\Http\Response
   */
  public function show(Requirement $requirement)
  {

    $documents = Document::all()->sortBy('id');
    $ous = OrganizationalUnit::all()->sortBy('name');
    //$ous = OrganizationalUnit::all()->sortBy('name');
    //$organizationalUnit = OrganizationalUnit::where('level', 1)->get();
//    $organizationalUnit = OrganizationalUnit::Find(1);
    $ouRoots = OrganizationalUnit::where('level', 1)->get();



    $requirement = Requirement::find($requirement->id);
    //$requirement=$requirement->events()->orderBy('id','DESC')->get();
    //dd($requirement);
    $requirementCategories = RequirementCategory::where('requirement_id', $requirement->id)->get();
    $categories = Category::where('user_id', Auth::user()->id)->get();
    $lastEvent = Event::where('requirement_id', $requirement->id)
      ->where('from_user_id', '<>', Auth::user()->id)->get()->last();
    //dd($lastEvent);

    //si no existen respuestas de otras personas, se devuelve la ultima cualquiera.
    if ($lastEvent == null) {
      $lastEvent = Event::where('requirement_id', $requirement->id)->get()->last();
    }
    $firstEvent = Event::where('requirement_id', $requirement->id)
      //->where('from_user_id','<>',Auth::user()->id)->get()
      ->First();

    //dd($lastEvent);

    //se verifica si evento ya se "vió", de lo contrario, se deja como visto.
    $events_status = EventStatus::where('user_id', Auth::user()->id)->get();
    foreach ($requirement->events as $key => $event) {
      $flag = 0;
      foreach ($events_status as $key => $event_status) {
        if ($event_status->event_id == $event->id) {
          $flag = 1;
        }
      }
      if ($flag == 0) {
        $eventStatus = new EventStatus();
        $eventStatus->event_id = $event->id;
        $eventStatus->user_id = Auth::user()->id;
        $eventStatus->status = "viewed";
        $eventStatus->save();
      }
    }

    //Se busca requerimientos agrupados, estos corresponden a los req. de los otros destinatarios de la misma solicitud de req.
    $groupedRequirements = null;
    if ($requirement->group_number != null) {
      $groupedRequirements = Requirement::query()
        ->where('group_number', $requirement->group_number)
        ->where('id', '<>', $requirement->id)
        ->get();
    }

    
    return view('requirements.show', compact('ous', 'ouRoots' , 'requirement', 'categories', 'requirementCategories', 'lastEvent', 'firstEvent', 'documents', 'groupedRequirements'));
  }

  public function report1(Request $request)
  {
    //dd($request->organizational_unit_id);
    $organizational_unit_id = $request->organizational_unit_id;
    $dateFrom = $request->dateFrom;
    $dateTo = $request->dateTo;
    $organizationalUnits = OrganizationalUnit::when($organizational_unit_id, function ($q, $organizational_unit_id) {
      return $q->where('id', $organizational_unit_id);
    })
      /*->whereHas('users', function ($query) use ($dateFrom, $dateTo) {
                                                   $query->whereHas('requirements', function ($query) use ($dateFrom, $dateTo) {
                                                         $query->whereBetween('created_at',[$dateFrom,$dateTo]);
                                                   });
                                             })*/
      ->get();

    $cont = 0;
    foreach ($organizationalUnits as $key => $organizationalUnit) {
      $matrix[$key]['unidad'] = $organizationalUnit->name;
      $matrix[$key]['creado'] = 0;
      $matrix[$key]['respondido'] = 0;
      $matrix[$key]['cerrado'] = 0;
      $matrix[$key]['derivado'] = 0;
      $matrix[$key]['reabierto'] = 0;
      foreach ($organizationalUnit->users as $key2 => $user) {
        $matrix2[$cont]['unidad'] = $organizationalUnit->name;
        $matrix2[$cont]['usuario'] = $user->getFullNameAttribute();
        $matrix2[$cont]['creado'] = 0;
        $matrix2[$cont]['respondido'] = 0;
        $matrix2[$cont]['cerrado'] = 0;
        $matrix2[$cont]['derivado'] = 0;
        $matrix2[$cont]['reabierto'] = 0;

        foreach ($user->requirements as $key3 => $requirement) {
          if (($requirement->created_at >= $dateFrom) && ($requirement->created_at <= $dateTo)) {
            if ($requirement->status == "creado") {
              $matrix[$key]['creado'] = $matrix[$key]['creado'] + 1;
              $matrix2[$cont]['creado'] = $matrix2[$cont]['creado'] + 1;
            }
            if ($requirement->status == "respondido") {
              $matrix[$key]['respondido'] = $matrix[$key]['respondido'] + 1;
              $matrix2[$cont]['respondido'] = $matrix2[$cont]['respondido'] + 1;
            }
            if ($requirement->status == "cerrado") {
              $matrix[$key]['cerrado'] = $matrix[$key]['cerrado'] + 1;
              $matrix2[$cont]['cerrado'] = $matrix2[$cont]['cerrado'] + 1;
            }
            if ($requirement->status == "derivado") {
              $matrix[$key]['derivado'] = $matrix[$key]['derivado'] + 1;
              $matrix2[$cont]['derivado'] = $matrix2[$cont]['derivado'] + 1;
            }
            if ($requirement->status == "reabierto") {
              $matrix[$key]['reabierto'] = $matrix[$key]['reabierto'] + 1;
              $matrix2[$cont]['reabierto'] = $matrix2[$cont]['reabierto'] + 1;
            }
          }
        }
        $cont = $cont + 1;
      }
    }

    //elimina valores que no tienen cantidades
    foreach ($matrix as $key => $d) {
      if ($d['creado'] == 0 && $d['respondido'] == 0 && $d['cerrado'] == 0 && $d['derivado'] == 0 && $d['reabierto'] == 0) {
        unset($matrix[$key]);
      }
    }
    foreach ($matrix2 as $key => $d) {
      if ($d['creado'] == 0 && $d['respondido'] == 0 && $d['cerrado'] == 0 && $d['derivado'] == 0 && $d['reabierto'] == 0) {
        unset($matrix2[$key]);
      }
    }

    $organizationalUnit = OrganizationalUnit::all();
    return view('requirements.reports.report1', compact('request', 'organizationalUnit', 'matrix', 'matrix2'));
  }

  // public function report_reqs_by_org(Request $request)
  // {
  //
  // }




  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Requirements\Requirement  $requirement
   * @return \Illuminate\Http\Response
   */
  public function edit(Requirement $requirement)
  {
    //$organizationalUnit = OrganizationalUnit::First();
    //return view('requirements.edit', compact('organizationalUnit'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Requirements\Requirement  $requirement
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Requirement $requirement)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Requirements\Requirement  $requirement
   * @return \Illuminate\Http\Response
   */
  public function destroy(Requirement $requirement)
  {
    $id = $requirement->id;
    $requirement->events()->delete();
    $requirement->requirementStatus()->delete();
    $requirement->delete();

    session()->flash('success', 'El requerimiento ' . $id . ' ha sido eliminado');

    return redirect()->route('requirements.outbox');
  }
}
