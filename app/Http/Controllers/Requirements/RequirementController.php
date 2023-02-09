<?php

namespace App\Http\Controllers\Requirements;

use Redirect;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Rrhh\OrganizationalUnit;
use App\Rrhh\Authority;
use App\Models\Requirements\RequirementStatus;
use App\Models\Requirements\RequirementCategory;
use App\Models\Requirements\Requirement;
use App\Models\Requirements\LabelRequirement;
use App\Models\Requirements\Label;
use App\Models\Requirements\File;
use App\Models\Requirements\EventStatus;
use App\Models\Requirements\EventDocument;
use App\Models\Requirements\Event;
use App\Models\Requirements\Category;
use App\Models\Documents\Parte;
use App\Models\Documents\Document;
use App\Mail\RequirementNotification;
use App\Http\Controllers\Controller;

class RequirementController extends Controller
{

    public function __constructor()
    {
        Carbon::setLocale('es');
    }

    public function inbox(Request $request, User $user = null)
    {
        /** Hay dos usuarios, el logeado "$auth_user" y al que voy a mostrar los sgr "$user" */
        $auth_user = auth()->user();
        $allowed_users = collect();

        /** Modelo authority del cual soy secretary */
        $authority_secretary = Authority::getAmIAuthorityFromOu(now(), 'secretary', $auth_user->id);

        /** Si soy secretary entonces obtengo la(s) autoridad(es) en $allowed_users */
        if(!empty($authority_secretary))
        {
            foreach($authority_secretary as $authority)
            {
                $authority_chief = Authority::getAuthorityFromDate($authority->organizational_unit_id, now(), 'manager');
                $allowed_users->push($authority_chief->user);
                /** Esto permite ver también la bandeja del "representa" 
                 * que se puede agregar al crear una autoridad
                 */
                if($authority_chief->represents)
                {
                    $allowed_users->push($authority_chief->represents);
                }
                // 0 => 14104369 Carlos Calvo
                // 1 => 10278387 José Donoso
            }
        }

        /** Si no pasó ningún usuario por parametro o
         * si el usuario es distinto al user logeado ($auth_user) y 
         * si el $user no existe en los permitidos entonces mostramos su bandeja personal */
        if(is_null($user) OR ($user != $auth_user AND !$allowed_users->contains($user) ) )
        {
            return redirect()->route('requirements.inbox',$auth_user);
        }

        /** Construyo la query de requerimientos */
        $requirements_query = Requirement::query();
        $requirements_query
            ->with('archived','labels','category','events','ccEvents','parte','eventsViewed','events.from_user','events.to_user','events.from_ou', 'events.to_ou')
            ->whereHas('events', function ($query) use ($user) {
                $query->where('from_user_id', $user->id)->orWhere('to_user_id', $user->id);
            });
        if($request->has('archived'))
        {
            $requirements_query->whereHas('archived', function ($query) use ($user,$auth_user) {
                $query->whereIn('user_id', [$user->id,$auth_user->id]);
            });
        }
        else
        {
            $requirements_query->whereDoesntHave('archived', function ($query) use ($user,$auth_user) {
                $query->whereIn('user_id', [$user->id,$auth_user->id]);
            });
        }        

        $requirements = $requirements_query->latest()->paginate(100)->withQueryString();
        /** Fin de la query de requerimientos */

        //18/01/2023: directora solicita filtro para solo ver los requerimientos no aperturados
        if($request->has('unreadedEvents'))
        {
            if($request['unreadedEvents']=="true"){
                foreach($requirements as $key => $requirement){
                    if(!$requirement->unreadedEvents){
                        $requirements->forget($key);
                    }
                }
            }
        }
        

        /* Query para los contadores */
        $counters_query = Requirement::query();
        
        $counters_query->whereHas('events', function ($query) use ($user) {
                $query->where('from_user_id', $user->id)->orWhere('to_user_id', $user->id);
            });
        
        $counters['archived'] = $counters_query->clone()
                ->whereHas('archived', function ($query) use ($user,$auth_user) {
                    $query->whereIn('user_id', [$user->id,$auth_user->id]);
                })->count();

        $counters_query->whereDoesntHave('archived', function ($query) use ($user,$auth_user) {
                    $query->whereIn('user_id', [$user->id,$auth_user->id]);
                });

        $counters['created'] = $counters_query->clone()->where('status','creado')->count();
        $counters['replyed'] = $counters_query->clone()->where('status','respondido')->count();
        $counters['derived'] = $counters_query->clone()->where('status','derivado')->count();
        $counters['closed'] = $counters_query->clone()->where('status','cerrado')->count();

        /** Retorno a la vista */
        return view('requirements.inbox', compact('requirements','user','allowed_users','counters'));
    }
    

    public function outbox(Request $request)
    {
        //         set_time_limit(3600);
        $users[0] = Auth::user()->id;
        $ous_secretary = [];

        // 14/06/2022: Esteban Rojas - Quitar requerimientos como secretaria (Se creó una nueva bandeja para ello)
        // $ous_secretary = Authority::getAmIAuthorityFromOu(date('Y-m-d'), 'secretary', Auth::user()->id);
        // foreach ($ous_secretary as $secretary) {
        //     $users[] = Authority::getAuthorityFromDate($secretary->OrganizationalUnit->id, date('Y-m-d'), 'manager')->user_id;
        // }

        //Si usuario actual es secretary, se muestran los requerimientos que tengan to_authority en true
        $userIsSecretary = (count($ous_secretary) > 0); //Será false

        //Se obtienen unidades organizacionales donde usuario es secretary
        $secretaryOuIds = [];
        // foreach ($ous_secretary as $ou_secretary) {
        //     $secretaryOuIds[] = $ou_secretary['organizational_unit_id'];
        // }

        $request_usu = $request['request_usu'];
        $archived_requirements = Requirement::with('events')
            ->where(function ($query) use ($secretaryOuIds, $userIsSecretary, $users) {
                $query->whereHas('events', function ($query) use ($users) {
                    $query->whereIn('from_user_id', $users)
                        ->orWhereIn('to_user_id', $users);
                })->whereHas('RequirementStatus', function ($query) use ($users) {
                    $query->where('status', 'viewed')
                        ->whereIn('user_id', $users);
                })->when($userIsSecretary, function ($query) use ($users, $secretaryOuIds) {
                    $query->getSentToAuthority($secretaryOuIds, $users, true);
                });
            })
            ->when($request['request_req'], function ($query, $request) {
                return $query->Search($request);
            })
            ->when($request['request_cat'], function ($query, $request) {
                return $query->whereHas('labels', function ($query) use ($request) {
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

        $archived_requirements_count = $archived_requirements;
        $archived_requirements_paginate = $archived_requirements;

        //se obtienen los id de requerimientos archivados
        $archivados = $archived_requirements_count->pluck('id');

        //si objeto es nulo, esporque no existen id's archivados, y no se debe agregar la clausula whereNotIn
        if (empty($archivados)) {

            $created_requirements = Requirement::with('events')
                ->where(function ($query) use ($secretaryOuIds, $userIsSecretary, $users) {
                    $query->whereHas('events', function ($query) use ($users) {
                        $query->whereIn('from_user_id', $users)
                            ->orWhereIn('to_user_id', $users);
                    })->when($userIsSecretary, function ($query) use ($users, $secretaryOuIds) {
                        $query->getSentToAuthority($secretaryOuIds, $users, false);
                    });
                })
                ->when($request['request_req'], function ($query, $request) {
                    return $query->Search($request);
                })
                ->when($request['request_cat'], function ($query, $request) {
                    return $query->whereHas('labels', function ($query) use ($request) {
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
            $created_requirements = Requirement::with('events')
                ->where(function ($query) use ($secretaryOuIds, $userIsSecretary, $request_usu, $request, $users) {
                    $query->whereHas('events', function ($query) use ($users) {
                        $query->whereIn('from_user_id', $users)
                            ->orWhereIn('to_user_id', $users);
                    })
                        ->when($userIsSecretary, function ($query) use ($users, $secretaryOuIds) {
                            $query->getSentToAuthority($secretaryOuIds, $users, false);
                        });
                })
                ->when($request['request_req'], function ($query, $request) {
                    return $query->Search($request);
                })
                ->when($request['request_cat'], function ($query, $request) {
                    return $query->whereHas('labels', function ($query) use ($request) {
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
                ->whereIntegerNotInRaw('id', $archivados) //<--- esta clausula permite traer todos los requerimientos que no esten archivados
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

        // dd($created_requirements->first()->events);
        foreach ($created_requirements as $key => $req) {
            // $flag = 0;
            // foreach ($req->events as $key => $event) {
            //     foreach ($events_status_id_event_array as $key => $event_id) {
            //         if ($event->id == $event_id) {
            //             $flag += 1;
            //         }
            //     }
            // }

            // cuando la cantidad de eventos es igual a la cantidad de statusEventos (viewed)
            if ($req->events->count() == EventStatus::where('user_id', Auth::user()->id)->whereIn('event_id',$req->events->pluck('id')->toArray())->count()) {
                $req->status_view = "visto";
            } else {
                $req->status_view = "sin revisar";
            }
            if ($req->status == 'creado' && $req->user_id == auth()->user()->id) {
                $req->status_view = "visto";
            }
        }


        //fixme SE DEMORA MUCHO
        foreach ($archived_requirements as $key => $req) {
            // $flag = 0;
            // foreach ($req->events as $key => $event) {
            //     foreach ($events_status_id_event_array as $key => $event_id) {
            //         if ($event->id == $event_id) {
            //             $flag += 1;
            //         }
            //     }
            // }

            if ($req->events->count() == EventStatus::where('user_id', Auth::user()->id)->whereIn('event_id',$req->events->pluck('id')->toArray())->count()) {
                $req->status_view = "visto";
            } else {
                $req->status_view = "sin revisar";
            }
            if ($req->status == 'creado' && $req->user_id == auth()->user()->id) {
                $req->status_view = "visto";
            }
        }

        //dd($created_requirements);
        return view('requirements.outbox', compact('created_requirements', 'archived_requirements', 'legend'));
    }




    public function secretary_outbox(Request $request)
    {
        $ous_secretary = [];
        $ous_secretary = Authority::getAmIAuthorityFromOu(date('Y-m-d'), 'secretary', Auth::user()->id);
        foreach ($ous_secretary as $secretary) {
            $users[] = Authority::getAuthorityFromDate($secretary->OrganizationalUnit->id, date('Y-m-d'), 'manager')->user_id;
        }

        //Si usuario actual es secretary, se muestran los requerimientos que tengan to_authority en true
        $userIsSecretary = (count($ous_secretary) > 0); 

        //Se obtienen unidades organizacionales donde usuario es secretary
        $secretaryOuIds = [];
        foreach ($ous_secretary as $ou_secretary) {
            $secretaryOuIds[] = $ou_secretary['organizational_unit_id'];
        }

        $request_usu = $request['request_usu'];
        $archived_requirements = Requirement::with('events')
            ->where(function ($query) use ($secretaryOuIds, $userIsSecretary, $users) {
                $query->whereHas('events', function ($query) use ($users) {
                    $query->whereIn('from_user_id', $users)
                        ->orWhereIn('to_user_id', $users);
                })->whereHas('RequirementStatus', function ($query) use ($users) {
                    $query->where('status', 'viewed')
                        ->whereIn('user_id', $users);
                })->when($userIsSecretary, function ($query) use ($users, $secretaryOuIds) {
                    $query->getSentToAuthority($secretaryOuIds, $users, true);
                });
            })
            ->when($request['request_req'], function ($query, $request) {
                return $query->Search($request);
            })
            ->when($request['request_cat'], function ($query, $request) {
                return $query->whereHas('labels', function ($query) use ($request) {
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

        $archived_requirements_count = $archived_requirements;
        $archived_requirements_paginate = $archived_requirements;

        //se obtienen los id de requerimientos archivados
        $archivados = $archived_requirements_count->pluck('id');

        //si objeto es nulo, esporque no existen id's archivados, y no se debe agregar la clausula whereNotIn
        if (empty($archivados)) {

            $created_requirements = Requirement::with('events')
                ->where(function ($query) use ($secretaryOuIds, $userIsSecretary, $users) {
                    $query->whereHas('events', function ($query) use ($users) {
                        $query->whereIn('from_user_id', $users)
                            ->orWhereIn('to_user_id', $users);
                    })->when($userIsSecretary, function ($query) use ($users, $secretaryOuIds) {
                        $query->getSentToAuthority($secretaryOuIds, $users, false);
                    });
                })
                ->when($request['request_req'], function ($query, $request) {
                    return $query->Search($request);
                })
                ->when($request['request_cat'], function ($query, $request) {
                    return $query->whereHas('labels', function ($query) use ($request) {
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
            $created_requirements = Requirement::with('events')
                ->where(function ($query) use ($secretaryOuIds, $userIsSecretary, $request_usu, $request, $users) {
                    $query->whereHas('events', function ($query) use ($users) {
                        $query->whereIn('from_user_id', $users)
                            ->orWhereIn('to_user_id', $users);
                    })
                        ->when($userIsSecretary, function ($query) use ($users, $secretaryOuIds) {
                            $query->getSentToAuthority($secretaryOuIds, $users, false);
                        });
                })
                ->when($request['request_req'], function ($query, $request) {
                    return $query->Search($request);
                })
                ->when($request['request_cat'], function ($query, $request) {
                    return $query->whereHas('labels', function ($query) use ($request) {
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
                ->whereIntegerNotInRaw('id', $archivados) //<--- esta clausula permite traer todos los requerimientos que no esten archivados
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
                if ($event->status == "en copia" && $event->to_user_id == $users[0]) {
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
                        if ($req->user->id == $users[0]) {
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


        //fixme SE DEMORA MUCHO
        //ciclo para definir si requerimiento tiene todos los eventos vistos (ticket verde) o no (ticket plomo)
        $events_status_id_event_array = EventStatus::where('user_id', $users[0])->pluck('event_id')->toArray();

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
            if ($req->status == 'creado' && $req->user_id == auth()->user()->id) {
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
            if ($req->status == 'creado' && $req->user_id == auth()->user()->id) {
                $req->status_view = "visto";
            }
        }

        return view('requirements.outbox', compact('created_requirements', 'archived_requirements', 'legend'));
    }




    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_requirement(Parte $parte)
    {
        // $documents = Document::all()->sortBy('id');
        // $ous = OrganizationalUnit::all()->sortBy('name');
        //        $organizationalUnit = OrganizationalUnit::Find(1);
        // $categories = Category::where('user_id', Auth::user()->id)->get();
        // $ouRoots = OrganizationalUnit::where('level', 1)->get();
        // $labels = Label::all();
        // $requirementCategories = RequirementCategory::where('requirement_id',$requirement->id)->get();
        // $categories = Category::where('user_id', Auth::user()->id)->get();
        return view('requirements.create', compact('parte'));
    }

    public function createFromParte(Parte $parte = null)
    {
        if(!$parte){
            $parte = Parte::whereDoesntHave('requirements')->whereDate('created_at', '>=', date('Y') .'-02-09')->first();
        }

        // get previous user id
        $previous = Parte::whereDoesntHave('requirements')->whereDate('created_at', '>=', date('Y') .'-02-09')
            ->where('id', '<', $parte->id)
            ->max('id');

        $previous = Parte::find($previous);
        
        // get next user id
        $next = Parte::whereDoesntHave('requirements')
            ->whereDate('created_at', '>=', date('Y') - 1 .'-01-01')
            ->where('id', '>', $parte->id)
            ->min('id');
        
        $next = Parte::find($next);
            
        $totalPending = Parte::whereDoesntHave('requirements')->whereDate('created_at', '>=', date('Y') .'-02-09')->count();

        return view('requirements.create-from-parte', compact('parte','previous','next','totalPending'));
    }

    public function create_requirement_sin_parte()
    {
        // set_time_limit(7200);
        // ini_set('memory_limit', '2048M');
        
        // $documents = Document::all()->sortBy('id');
        $parte = new Parte;
        // $ous = OrganizationalUnit::all()->sortBy('name');
        
        // $ouRoots = OrganizationalUnit::where('level', 1)->get();
        // $categories = Category::where('user_id', Auth::user()->id)->get();
        // $labels = Label::all();
        
        // return view('requirements.create', compact('ous', 'ouRoots', 'parte', 'documents', 'categories', 'labels'));
        return view('requirements.create', compact('parte'));
    }

    public function archive_requirement(Requirement $requirement)
    {
        $requirementStatus = new RequirementStatus();
        $requirementStatus->requirement_id = $requirement->id;
        $requirementStatus->user_id = Auth::user()->id;
        $requirementStatus->status = "viewed";
        $requirementStatus->save();

        //return redirect()->route('requirements.outbox');
        return redirect()->back()->with('success', 'El requerimiento ha sido archivado');
    }

    public function archive_requirement_delete(Requirement $requirement)
    {
        $requirementStatus = RequirementStatus::where('requirement_id', $requirement->id)
            ->where('user_id', Auth::user()->id)
            ->where('status', 'viewed');
        $requirementStatus->delete();

        // return redirect()->route('requirements.outbox');
        return redirect()->back()->with('success', 'El requerimiento ha sido desarchivado');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $requirement = Requirement::find(15920);
        // $requirement->categories()->attach($request->input('category_id'));
        // dd("");

        //se setea variables documents, que ahora viene separada por coma, y no en un array.
        $request->documents = explode(",",$request->documents);

        // validación existencia autoridad en ou
        if (Authority::getAuthorityFromDate($request->to_ou_id, now(), 'manager') == null) {
          return redirect()->back()->with('warning', 'La unidad organizacional seleccionada no tiene asignada una autoridad. Favor contactar a secretaria de dicha unidad para regularizar.');
        }

        if(!$request->users){
            return redirect()->back()->with('warning', 'Debe ingresar por lo menos un usuario a quien crear el requerimiento.');
        }
 
        // 30/01/2023: Atorres indica que desde ahora se deban agregar obligatoriamente los destinatarios y cc
        // //si solo se manda desde la vista un solo usuario, sin usar la tabla dinámica
        // if ($request->users == null) {
        //     $req = $request->All();
        //     if ($request->limit_at <> null) {
        //         $req['limit_at'] = Carbon::createFromFormat('Y-m-d\TH:i', $request->limit_at)->format('Y-m-d H:i:00');
        //     }


        //     $requirement = new Requirement($req);
        //     $requirement->user()->associate(Auth::user());

        //     //Si el usuario destino es autoridad, se marca el requerimiento
        //     $managerUserId = Authority::getAuthorityFromDate($request->to_ou_id, now(), 'manager')->user_id;
        //     $isManager = ($request->to_user_id == $managerUserId);
        //     $requirement->to_authority = $isManager;

        //     $requirement->save();

        //     /** Asigna las labels al requerimiento */
        //     $requirement->setLabels($request->input('label_id'));

        //     //se guarda evento
        //     $firstEvent = new Event($request->All());
        //     $firstEvent->from_user()->associate(Auth::user());
        //     $firstEvent->from_ou_id = Auth::user()->organizationalUnit->id;
        //     $firstEvent->requirement()->associate($requirement);
        //     $firstEvent->to_authority = $isManager;
        //     $firstEvent->save();

        //     //asocia evento con documentos
        //     if ($request->documents <> null) {
        //         foreach ($request->documents as $key => $document_aux) {
        //             $document = Document::find($document_aux);
        //             $firstEvent->documents()->attach($document);
        //         }
        //     }

        //     //guarda archivos
        //     if ($request->hasFile('forfile')) {
        //         foreach ($request->file('forfile') as $file) {
        //             $filename = $file->getClientOriginalName();
        //             $fileModel = new File;
        //             // $fileModel->file = $file->store('requirements');
        //             $fileModel->file = $file->store('ionline/requirements',['disk' => 'gcs']);
        //             $fileModel->name = $filename;
        //             $fileModel->event_id = $firstEvent->id;
        //             $fileModel->save();
        //         }
        //     }

        //     $requirement->events()->save($firstEvent);

        //     preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $firstEvent->to_user->email, $emails);
        //     if (env('APP_ENV') == 'production') {
        //         Mail::to($emails[0])
        //             ->send(new RequirementNotification($requirement));
        //     }

        //      /** Marca los eventos como vistos */
        //     $requirement->setEventsAsViewed;

        //     session()->flash('info', 'El requerimiento ' . $requirement->id . ' ha sido creado.');
        // } else {

            //encuentra cuales son usuarios para requerimientos, y cuales son en copia
            $users_req = null;
            $users_enCopia = null;
            $categories_array_ = null;
            foreach ($request->enCopia as $key => $enCopia) {
                if ($enCopia == 0) {
                    $users_req[] = $request->users[$key];
                    // obtiene categorías seleccionadas
                    if($request->categories!=null){
                        $categories_array_[] = $request->categories[$key];
                    }
                }
                if ($enCopia == 1) {
                    $users_enCopia[] = $request->users[$key];
                }
            }

            //se crearán requerimientos según usuarios agregados en tabla dinámica.
            $users = array_unique($users_req); //distinct
            $categories_array = null;
            if($categories_array_){
                $categories_array = array_unique($categories_array_); //distinct
            }
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
            $isAnyManager = false;
            foreach ($users as $key => $user) {

                $req = $request->All();
                if ($request->limit_at <> null) {
                    $req['limit_at'] = Carbon::createFromFormat('Y-m-d\TH:i', $request->limit_at)->format('Y-m-d H:i:00');
                }

                //Si algún usuario destino es autoridad, se marca el requerimiento
                $userModel = User::find($user);
                $managerUserId = Authority::getAuthorityFromDate($userModel->organizationalUnit->id, now(), 'manager')->user_id;
                $isManager = ($user == $managerUserId);
                if ($isManager) $isAnyManager = true;

//              dump($user, $isManager);

                //se crea requerimiento
                $requirement = new Requirement($req);
                $requirement->user()->associate(Auth::user());
                $requirement->group_number = $group_number;
                $requirement->to_authority = $isAnyManager;
                if($categories_array){
                    $requirement->category_id = $categories_array[$key];
                }
                $requirement->save();

                /** Asigna las labels al requerimiento */
                $requirement->setLabels($request->input('label_id'));

				// /** Marca los eventos como vistos */
				// $requirement->setEventsAsViewed;

                //se ingresa una sola vez: se guardan posibles usuarios en copia. Se agregan primero que otros eventos del requerimiento, para que no queden como "last()"
                if ($users_enCopia <> null) {
                    if ($flag == 0) {
                        $isAnyManager = false;
                        foreach ($users_enCopia as $key => $user_) {
                            //Si algún usuario en copia es autoridad, se marca el requerimiento y evento
                            $userModel = User::find($user_);
                            $managerUserId = Authority::getAuthorityFromDate($userModel->organizationalUnit->id, now(), 'manager')->user_id;
                            $isManager = ($user_ == $managerUserId);
                            if ($isManager) $isAnyManager = true;
//                          dump($user_, $isManager);

                            $user_aux = User::where('id', $user_)->get();
                            $firstEvent = new Event($request->All());
                            $firstEvent->to_user_id = $user_;
                            $firstEvent->to_ou_id = $user_aux->first()->organizational_unit_id;
                            $firstEvent->status = "en copia";
                            $firstEvent->from_user()->associate(Auth::user());
                            $firstEvent->from_ou_id = Auth::user()->organizationalUnit->id;
                            $firstEvent->requirement()->associate($requirement);
                            $firstEvent->to_authority = $isManager;
                            $firstEvent->save();

                            $requirement->events()->save($firstEvent);
                        }
                        $flag = 1;
                        $requirement->update(['to_authority' => $isAnyManager]);
                    }
                }

                //se ingresan los otros tipos de eventos (que no sean "en copia")
                $firstEvent = new Event($request->All());
                //$firstEvent->organizational_unit_id = $user_aux->first()->organizational_unit_id;
                $user_aux = User::find($user);
                if ($user_aux) {
                    $firstEvent->to_user_id = $user_aux->id;
                    $firstEvent->to_ou_id = $user_aux->organizational_unit_id;

                    //Si usuario es autoridad, se marca el requerimiento y evento
                    $managerUserId = Authority::getAuthorityFromDate($user_aux->organizational_unit_id, now(), 'manager')->user_id;
                    $isManager = ($user_aux->id == $managerUserId);
                    $firstEvent->to_authority = $isManager;
                    if (!$isAnyManager) $requirement->update(['to_authority' => $isManager]);
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
                        // $fileModel->file = $file->store('requirements');
                        $fileModel->file = $file->store('ionline/requirements',['disk' => 'gcs']);
                        $fileModel->name = $filename;
                        $fileModel->event_id = $firstEvent->id;
                        $fileModel->save();
                    }
                }

                $requirement->events()->save($firstEvent);

                /** Marca los eventos como vistos */
				$requirement->setEventsAsViewed;
                
                //$requirement->categories()->attach($request->input('category_id'));
                //$requerimientos = $requerimientos + $firstEvent->id + ",";
            }

            if (env('APP_ENV') == 'production') {
                preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $usersEmail, $emails);
                Mail::to($emails[0])
                    ->send(new RequirementNotification($requirement));
            }

            session()->flash('info', 'Los requerimientos han sido creados.');
        // }

        /* Si es un requerimiento creado desde un parte envía a inbox de parte */
        if ($requirement->parte_id) $return = 'documents.partes.index';
        else $return = 'requirements.inbox';

        return redirect()->route($return);
    }


    public function director_store(Request $request){

        //se setea variables documents, que ahora viene separada por coma, y no en un array.
        $request->documents = explode(",",$request->documents);

        // validación existencia autoridad en ou
        if (Authority::getAuthorityFromDate($request->to_ou_id, now(), 'manager') == null) {
          return redirect()->back()->with('warning', 'La unidad organizacional seleccionada no tiene asignada una autoridad. Favor contactar a secretaria de dicha unidad para regularizar.');
        }

        if(!$request->users){
            return redirect()->back()->with('warning', 'Debe ingresar por lo menos un usuario a quien crear el requerimiento.');
        }

        //encuentra cuales son usuarios para requerimientos, y cuales son en copia
        $users_req = null;
        $users_enCopia = null;
        // dd($request->enCopia);

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

        $usersEmail = '';
        $isAnyManager = false;
        foreach ($users as $key => $user) {

            $req = $request->All();
            if ($request->limit_at <> null) {
                $req['limit_at'] = Carbon::createFromFormat('Y-m-d\TH:i', $request->limit_at)->format('Y-m-d H:i:00');
            }

            //Si algún usuario destino es autoridad, se marca el requerimiento
            $userModel = User::find($user);
            $managerUserId = Authority::getAuthorityFromDate($userModel->organizationalUnit->id, now(), 'manager')->user_id;
            $isManager = ($user == $managerUserId);
            if ($isManager) $isAnyManager = true;

            //se crea requerimiento
            $requirement = new Requirement($req);
            $requirement->user()->associate(Auth::user());
            $requirement->group_number = $group_number;
            $requirement->to_authority = $isAnyManager;
            $requirement->save();

            /** Asigna las labels al requerimiento */
            $requirement->setLabels($request->input('label_id'));

            //se ingresa una sola vez: se guardan posibles usuarios en copia. Se agregan primero que otros eventos del requerimiento, para que no queden como "last()"
            if ($users_enCopia <> null) {
                if ($flag == 0) {
                    $isAnyManager = false;
                    foreach ($users_enCopia as $key => $user_) {
                        //Si algún usuario en copia es autoridad, se marca el requerimiento y evento
                        $userModel = User::find($user_);
                        $managerUserId = Authority::getAuthorityFromDate($userModel->organizationalUnit->id, now(), 'manager')->user_id;
                        $isManager = ($user_ == $managerUserId);
                        if ($isManager) $isAnyManager = true;
//                          dump($user_, $isManager);

                        $user_aux = User::where('id', $user_)->get();
                        $firstEvent = new Event($request->All());
                        $firstEvent->to_user_id = $user_;
                        $firstEvent->to_ou_id = $user_aux->first()->organizational_unit_id;
                        $firstEvent->status = "en copia";
                        $firstEvent->from_user()->associate(Auth::user());
                        $firstEvent->from_ou_id = Auth::user()->organizationalUnit->id;
                        $firstEvent->requirement()->associate($requirement);
                        $firstEvent->to_authority = $isManager;
                        $firstEvent->save();

                        $requirement->events()->save($firstEvent);
                    }
                    $flag = 1;
                    $requirement->update(['to_authority' => $isAnyManager]);
                }
            }

            //se ingresan los otros tipos de eventos (que no sean "en copia")
            $firstEvent = new Event($request->All());
            //$firstEvent->organizational_unit_id = $user_aux->first()->organizational_unit_id;
            $user_aux = User::find($user);
            if ($user_aux) {
                $firstEvent->to_user_id = $user_aux->id;
                $firstEvent->to_ou_id = $user_aux->organizational_unit_id;

                //Si usuario es autoridad, se marca el requerimiento y evento
                $managerUserId = Authority::getAuthorityFromDate($user_aux->organizational_unit_id, now(), 'manager')->user_id;
                $isManager = ($user_aux->id == $managerUserId);
                $firstEvent->to_authority = $isManager;
                if (!$isAnyManager) $requirement->update(['to_authority' => $isManager]);
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
                    // $fileModel->file = $file->store('requirements');
                    $fileModel->file = $file->store('ionline/requirements',['disk' => 'gcs']);
                    $fileModel->name = $filename;
                    $fileModel->event_id = $firstEvent->id;
                    $fileModel->save();
                }
            }

            $requirement->events()->save($firstEvent);

            /** Marca los eventos como vistos */
            $requirement->setEventsAsViewed;
        }

        if (env('APP_ENV') == 'production') {
            preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $usersEmail, $emails);
            Mail::to($emails[0])
                ->send(new RequirementNotification($requirement));
        }

        session()->flash('info', 'Los requerimientos han sido creados.');

        // get actual parte
        $parte = Parte::whereDoesntHave('requirements')->whereDate('created_at', '>=', date('Y') - 1 .'-01-01')
            ->where('id', '>', $request->parte_id)->min('id');
            $parte = Parte::find($parte);

        // get previous user id
        $previous = Parte::whereDoesntHave('requirements')->whereDate('created_at', '>=', date('Y') - 1 .'-01-01')
            ->where('id', '<', $parte->id)->max('id');
            $previous = Parte::find($previous);

        // get next user id
        $next = Parte::whereDoesntHave('requirements')->whereDate('created_at', '>=', date('Y') - 1 .'-01-01')
            ->where('id', '>', $parte->id)->min('id');
            $next = Parte::find($next);

    return view('requirements.create-from-parte', compact('parte','previous','next'));
}

    // public function asocia_categorias(Request $request)
    // {
    //     $req = RequirementCategory::where('requirement_id', $request->requirement_id);
    //     $req->delete();

    //     if ($request->category_id <> null) {
    //         foreach ($request->category_id as $key => $category_id) {

    //             $RequirementCategory = new RequirementCategory();
    //             $RequirementCategory->requirement_id = $request->requirement_id;
    //             $RequirementCategory->category_id = $category_id;
    //             $RequirementCategory->save();
    //         }
    //     }

    //     return Redirect::back();
    // }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Requirements\Requirement $requirement
     * @return \Illuminate\Http\Response
     */
    public function show(Requirement $requirement)
    {

        $ous = OrganizationalUnit::all()->sortBy('name');
        $ouRoots = OrganizationalUnit::with([
            'childs',
            'childs.childs',
            'childs.childs.childs',
            'childs.childs.childs.childs',
            'childs.childs.childs.childs.childs',
            'childs.establishment',
            'childs.childs.establishment',
            'childs.childs.childs.establishment',
            'childs.childs.childs.childs.establishment',
            'childs.childs.childs.childs.childs.establishment',
            ])->where('level', 1)->get();

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

       //Se busca requerimientos agrupados, estos corresponden a los req. de los otros destinatarios de la misma solicitud de req.
        $groupedRequirements = null;
        if ($requirement->group_number != null) {
            $groupedRequirements = Requirement::query()
                ->where('group_number', $requirement->group_number)
                ->where('id', '<>', $requirement->id)
                ->get();
        }

        /** Marca como visto todos los eventos */
        $requirement->setEventsAsViewed;

        return view('requirements.show', compact('ous', 'ouRoots', 'requirement', 'lastEvent', 'firstEvent', 'groupedRequirements'));
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
     * @param \App\Models\Requirements\Requirement $requirement
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
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Requirements\Requirement $requirement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Requirement $requirement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Requirements\Requirement $requirement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Requirement $requirement)
    {
        $id = $requirement->id;
        $requirement->events()->delete();
        $requirement->requirementStatus()->delete();
        $requirement->delete();

        session()->flash('success', 'El requerimiento ' . $id . ' ha sido eliminado');

        return redirect()->route('requirements.inbox');        
    }
}
