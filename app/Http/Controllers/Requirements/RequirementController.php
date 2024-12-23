<?php

namespace App\Http\Controllers\Requirements;

use App\Http\Controllers\Controller;
use App\Mail\RequirementNotification;
use App\Models\Documents\Document;
use App\Models\Documents\Parte;
use App\Models\Requirements\Category;
use App\Models\Requirements\Event;
use App\Models\Requirements\EventStatus;
use App\Models\Requirements\File;
use App\Models\Requirements\Label;
use App\Models\Requirements\Requirement;
use App\Models\Requirements\RequirementCategory;
use App\Models\Requirements\RequirementStatus;
use App\Models\Rrhh\Authority;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\User;
use App\Notifications\Requirements\NewSgr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Redirect;

class RequirementController extends Controller
{
    public function __constructor()
    {
        Carbon::setLocale('es');
    }

    public function inbox(Request $request, ?User $user = null)
    {
        /** Hay dos usuarios, el logeado "$auth_user" y al que voy a mostrar los sgr "$user" */
        $auth_user = auth()->user();
        $allowed_users = collect();

        /** Modelo authority del cual soy secretary */
        $authority_secretary = Authority::getAmIAuthorityFromOu(now(), 'secretary', $auth_user->id);

        /** Si soy secretary entonces obtengo la(s) autoridad(es) en $allowed_users */
        if ($authority_secretary->isNotEmpty()) {
            foreach ($authority_secretary as $authority) {
                $authority_chief = Authority::getAuthorityFromDate($authority->organizational_unit_id, now(), 'manager');
                if ($authority_chief) {
                    $allowed_users->push($authority_chief->user);

                    /** Esto permite ver también la bandeja del "representa"
                     * que se puede agregar al crear una autoridad
                     */
                    if ($authority_chief->representation) {
                        $allowed_users->push($authority_chief->representation);
                    }
                    // 0 => 14104369 Carlos Calvo
                    // 1 => 10278387 José Donoso
                }

            }
        }

        /**
         * Caso de estudio, sobre la comparación entre objetos
         * $user1 == $user2 es falso, si se llama a alguna relacion
         * de cualquiera de los dos objetos
         * en el caso de abajo, al llamar a $auth_user->delegate
         * ya pasan a ser diferentes los resultados.
         */
        // app('debugbar')->log($user !== $auth_user);

        /** Es delegado de una OU (quiere decir que puede ver los SGR del manager) */
        foreach ($auth_user->delegate as $delegate) {
            $allowed_users->push($delegate->organizationalUnit->currentManager->user);
        }

        // app('debugbar')->log($user !== $auth_user);
        // app('debugbar')->log(!$allowed_users->contains($user));
        // return true;

        /** Si no pasó ningún usuario por parametro o
         * si el usuario es distinto al user logeado ($auth_user) y
         * si el $user no existe en los permitidos entonces mostramos su bandeja personal */
        if (is_null($user) or ($user->id != $auth_user->id and ! $allowed_users->contains($user))) {
            return redirect()->route('requirements.inbox', $auth_user);
        }

        /** Construyo la query de requerimientos */
        $requirements_query = Requirement::query();
        $requirements_query
            ->with('archived', 'labels', 'category', 'events', 'ccEvents', 'parte', 'eventsViewed', 'events.from_user', 'events.to_user', 'events.from_ou', 'events.to_ou', 'eventsWithoutCC', 'eventsViewed')
            ->whereHas('events', function ($query) use ($user) {
                $query->where('from_user_id', $user->id)->orWhere('to_user_id', $user->id);
            });

        // obener total pendientes
        $total_pending_requirements = 0;
        $req_query = clone $requirements_query;
        $total_pending_requirements = $req_query->whereDoesntHave('archived', function ($query) use ($user, $auth_user) {
            $query->whereIn('user_id', [$user->id, $auth_user->id]);
        })->count();

        // devuelve requerimientos a bandeja
        // if($request->has('archived'))
        // {
        //     $requirements_query->whereHas('archived', function ($query) use ($user,$auth_user) {
        //         $query->whereIn('user_id', [$user->id,$auth_user->id]);
        //     });
        // }
        // else
        // {
        //     $requirements_query->whereDoesntHave('archived', function ($query) use ($user,$auth_user) {
        //         $query->whereIn('user_id', [$user->id,$auth_user->id]);
        //     });
        // }

        //$requirements = $requirements_query->latest()->paginate(100)->withQueryString();
        /** Fin de la query de requerimientos */

        //18/01/2023: directora solicita filtro para solo ver los requerimientos no aperturados
        // if($request->has('unreadedEvents'))
        // {
        //     if($request['unreadedEvents']=="true"){
        //         foreach($requirements as $key => $requirement){
        //             if(!$requirement->unreadedEvents){
        //                 $requirements->forget($key);
        //             }
        //         }
        //     }
        // }

        /* Query para los contadores */
        $counters_query = Requirement::query();

        $counters_query->whereHas('events', function ($query) use ($user) {
            $query->where('from_user_id', $user->id)->orWhere('to_user_id', $user->id);
        });

        $counters['archived'] = $counters_query->clone()
            ->whereHas('archived', function ($query) use ($user, $auth_user) {
                $query->whereIn('user_id', [$user->id, $auth_user->id]);
            })->count();

        $counters_query->whereDoesntHave('archived', function ($query) use ($user, $auth_user) {
            $query->whereIn('user_id', [$user->id, $auth_user->id]);
        });

        $counters['created'] = $counters_query->clone()->where('status', 'creado')->count();
        $counters['replyed'] = $counters_query->clone()->where('status', 'respondido')->count();
        $counters['derived'] = $counters_query->clone()->where('status', 'derivado')->count();
        $counters['closed'] = $counters_query->clone()->where('status', 'cerrado')->count();
        $counters['pending'] = $total_pending_requirements;

        // dd($requirements->total());

        /** Retorno a la vista */
        return view('requirements.inbox', compact('user', 'auth_user', 'allowed_users', 'counters'));
    }

    public function outbox(Request $request)
    {
        //         set_time_limit(3600);
        $users[0] = auth()->id();
        $ous_secretary = [];

        // 14/06/2022: Esteban Rojas - Quitar requerimientos como secretaria (Se creó una nueva bandeja para ello)
        // $ous_secretary = Authority::getAmIAuthorityFromOu(today(), 'secretary', auth()->id());
        // foreach ($ous_secretary as $secretary) {
        //     $users[] = Authority::getAuthorityFromDate($secretary->OrganizationalUnit->id, today(), 'manager')->user_id;
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
                ->where(function ($query) use ($secretaryOuIds, $userIsSecretary, $users) {
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
                if ($event->status == 'en copia' && $event->to_user_id == auth()->id()) {
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
                        if ($req->user->id == auth()->id()) {
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
        //             if($req->user == auth()->user()) {
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
        //        $events_status = EventStatus::where('user_id',auth()->id())->get();
        $events_status_id_event_array = EventStatus::where('user_id', auth()->id())->pluck('event_id')->toArray();

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
            if ($req->events->count() == EventStatus::where('user_id', auth()->id())->whereIn('event_id', $req->events->pluck('id')->toArray())->count()) {
                $req->status_view = 'visto';
            } else {
                $req->status_view = 'sin revisar';
            }
            if ($req->status == 'creado' && $req->user_id == auth()->user()->id) {
                $req->status_view = 'visto';
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

            if ($req->events->count() == EventStatus::where('user_id', auth()->id())->whereIn('event_id', $req->events->pluck('id')->toArray())->count()) {
                $req->status_view = 'visto';
            } else {
                $req->status_view = 'sin revisar';
            }
            if ($req->status == 'creado' && $req->user_id == auth()->user()->id) {
                $req->status_view = 'visto';
            }
        }

        //dd($created_requirements);
        return view('requirements.outbox', compact('created_requirements', 'archived_requirements', 'legend'));
    }

    public function secretary_outbox(Request $request)
    {
        $ous_secretary = [];
        $ous_secretary = Authority::getAmIAuthorityFromOu(today(), 'secretary', auth()->id());
        foreach ($ous_secretary as $secretary) {
            $users[] = Authority::getAuthorityFromDate($secretary->OrganizationalUnit->id, today(), 'manager')->user_id;
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
                ->where(function ($query) use ($secretaryOuIds, $userIsSecretary, $users) {
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
                if ($event->status == 'en copia' && $event->to_user_id == $users[0]) {
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
                $req->status_view = 'visto';
            } else {
                $req->status_view = 'sin revisar';
            }
            if ($req->status == 'creado' && $req->user_id == auth()->user()->id) {
                $req->status_view = 'visto';
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
                $req->status_view = 'visto';
            } else {
                $req->status_view = 'sin revisar';
            }
            if ($req->status == 'creado' && $req->user_id == auth()->user()->id) {
                $req->status_view = 'visto';
            }
        }

        return view('requirements.outbox', compact('created_requirements', 'archived_requirements', 'legend'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create_requirement(Parte $parte): View
    {
        // $documents = Document::all()->sortBy('id');
        // $ous = OrganizationalUnit::all()->sortBy('name');
        //        $organizationalUnit = OrganizationalUnit::Find(1);
        // $categories = Category::where('user_id', auth()->id())->get();
        // $ouRoots = OrganizationalUnit::where('level', 1)->get();
        // $labels = Label::all();
        // $requirementCategories = RequirementCategory::where('requirement_id',$requirement->id)->get();
        // $categories = Category::where('user_id', auth()->id())->get();
        return view('requirements.create', compact('parte'));
    }

    public function createFromParte(?Parte $parte = null)
    {
        if (! $parte) {
            $parte = Parte::whereDoesntHave('requirements')->whereDate('created_at', '>=', date('Y').'-01-01')->first();
        }

        $previous = null;
        $next = null;
        if ($parte) {

            // get previous user id
            $previous = Parte::whereDoesntHave('requirements')->whereDate('created_at', '>=', date('Y').'-01-01')
                ->where('id', '<', $parte->id)
                ->max('id');

            $previous = Parte::find($previous);

            // get next user id
            $next = Parte::whereDoesntHave('requirements')
                ->whereDate('created_at', '>=', date('Y') - 1 .'-01-01')
                ->where('id', '>', $parte->id)
                ->min('id');

            $next = Parte::find($next);
        }

        $totalPending = Parte::whereDoesntHave('requirements')->whereDate('created_at', '>=', date('Y').'-01-01')->count();

        return view('requirements.create-from-parte', compact('parte', 'previous', 'next', 'totalPending'));
    }

    public function create_requirement_sin_parte()
    {
        // set_time_limit(7200);
        // ini_set('memory_limit', '2048M');

        // $documents = Document::all()->sortBy('id');
        $parte = new Parte;
        // $ous = OrganizationalUnit::all()->sortBy('name');

        // $ouRoots = OrganizationalUnit::where('level', 1)->get();
        // $categories = Category::where('user_id', auth()->id())->get();
        // $labels = Label::all();

        // return view('requirements.create', compact('ous', 'ouRoots', 'parte', 'documents', 'categories', 'labels'));
        return view('requirements.create', compact('parte'));
    }

    public function archive_requirement(Requirement $requirement)
    {
        $requirementStatus = new RequirementStatus;
        $requirementStatus->requirement_id = $requirement->id;
        $requirementStatus->user_id = auth()->id();
        $requirementStatus->status = 'viewed';
        $requirementStatus->save();

        //return redirect()->route('requirements.outbox');
        return redirect()->back()->with('success', 'El requerimiento ha sido archivado');
    }

    public function archive_mass(Request $request)
    {
        $requirementIds = $request->input('archive');

        foreach ($requirementIds as $requirementId) {
            $requirement = Requirement::find($requirementId);
            if ($requirement) {
                $requirementStatus = new RequirementStatus;
                $requirementStatus->requirement_id = $requirement->id;
                $requirementStatus->user_id = auth()->id();
                $requirementStatus->status = 'viewed';
                $requirementStatus->save();
            }
        }

        return redirect()->back()->with('success', 'Los requerimientos han sido archivados');
    }

    public function archive_requirement_delete(Requirement $requirement)
    {
        $requirementStatus = RequirementStatus::where('requirement_id', $requirement->id)
            ->where('user_id', auth()->id())
            ->where('status', 'viewed');
        $requirementStatus->delete();

        // return redirect()->route('requirements.outbox');
        return redirect()->back()->with('success', 'El requerimiento ha sido desarchivado');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     // $requirement = Requirement::find(15920);
    //     // $requirement->categories()->attach($request->input('category_id'));
    //     //dd($request->all());

    //     /* TODO: si no tengo OU_ID no debería entrar al SGR; es posible que esté controlado ya en el create */
    //     //se setea variables documents, que ahora viene separada por coma, y no en un array.
    //     $request->documents = explode(",",$request->documents);

    //     // validación existencia autoridad en ou
    //     /* // FIXME: Esto no debería estar. */
    //     if (Authority::getAuthorityFromDate($request->to_ou_id, now(), 'manager') == null) {
    //       return redirect()->back()->with('warning', 'La unidad organizacional seleccionada no tiene asignada una autoridad. Favor contactar a secretaria de dicha unidad para regularizar.');
    //     }

    //     /** Contraldo por JS? */
    //     if(!$request->users){
    //         return redirect()->back()->with('warning', 'Debe ingresar por lo menos un usuario a quien crear el requerimiento.');
    //     }

    //     // 30/01/2023: Atorres indica que desde ahora se deban agregar obligatoriamente los destinatarios y cc
    //     // //si solo se manda desde la vista un solo usuario, sin usar la tabla dinámica
    //     // if ($request->users == null) {
    //     //     $req = $request->All();
    //     //     if ($request->limit_at <> null) {
    //     //         $req['limit_at'] = Carbon::createFromFormat('Y-m-d\TH:i', $request->limit_at)->format('Y-m-d H:i:00');
    //     //     }

    //     //     $requirement = new Requirement($req);
    //     //     $requirement->user()->associate(auth()->user());

    //     //     //Si el usuario destino es autoridad, se marca el requerimiento
    //     //     $managerUserId = Authority::getAuthorityFromDate($request->to_ou_id, now(), 'manager')->user_id;
    //     //     $isManager = ($request->to_user_id == $managerUserId);
    //     //     $requirement->to_authority = $isManager;

    //     //     $requirement->save();

    //     //     /** Asigna las labels al requerimiento */
    //     //     $requirement->setLabels($request->input('label_id'));

    //     //     //se guarda evento
    //     //     $firstEvent = new Event($request->All());
    //     //     $firstEvent->from_user()->associate(auth()->user());
    //     //     $firstEvent->from_ou_id = auth()->user()->organizationalUnit->id;
    //     //     $firstEvent->requirement()->associate($requirement);
    //     //     $firstEvent->to_authority = $isManager;
    //     //     $firstEvent->save();

    //     //     //asocia evento con documentos
    //     //     if ($request->documents <> null) {
    //     //         foreach ($request->documents as $key => $document_aux) {
    //     //             $document = Document::find($document_aux);
    //     //             $firstEvent->documents()->attach($document);
    //     //         }
    //     //     }

    //     //     //guarda archivos
    //     //     if ($request->hasFile('forfile')) {
    //     //         foreach ($request->file('forfile') as $file) {
    //     //             $filename = $file->getClientOriginalName();
    //     //             $fileModel = new File;
    //     //             // $fileModel->file = $file->store('requirements');
    //     //             $fileModel->file = $file->store('ionline/requirements',['disk' => 'gcs']);
    //     //             $fileModel->name = $filename;
    //     //             $fileModel->event_id = $firstEvent->id;
    //     //             $fileModel->save();
    //     //         }
    //     //     }

    //     //     $requirement->events()->save($firstEvent);

    //     //     preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $firstEvent->to_user->email, $emails);
    //     //     if (env('APP_ENV') == 'production') {
    //     //         Mail::to($emails[0])
    //     //             ->send(new RequirementNotification($requirement));
    //     //     }

    //     //      /** Marca los eventos como vistos */
    //     //     $requirement->setEventsAsViewed;

    //     //     session()->flash('info', 'El requerimiento ' . $requirement->id . ' ha sido creado.');
    //     // } else {

    //         // dd($request->categories, $request->enCopia, $request->users);
    //         //encuentra cuales son usuarios para requerimientos, y cuales son en copia
    //         // dd($request->categories, $request->users, $request->enCopia);
    //         $users_req = null;
    //         $users_enCopia = null;
    //         $categories_array = null;
    //         foreach ($request->enCopia as $key => $enCopia) {
    //             if ($enCopia == 0) {
    //                 $users_req[] = $request->users[$key];
    //                 // obtiene categorías seleccionadas
    //                 /* TODO: Revisa  que pasa si tiene nulos, el array queda más pequeño? */
    //                 if($request->categories!=null){
    //                     $categories_array[] = $request->categories[$key];
    //                 }
    //             }
    //             if ($enCopia == 1) {
    //                 $users_enCopia[] = $request->users[$key];
    //             }
    //         }
    //         // dd($categories_array);

    //         //se crearán requerimientos según usuarios agregados en tabla dinámica.
    //         /* TODO: esto elimina duplicados, si llega a entrar acá, no coinciden las keys con los otros arrays  */
    //         $users = array_unique($users_req); //distinct
    //         // $categories_array = null;
    //         // if($categories_array_){
    //         //     $categories_array = array_unique($categories_array_); //distinct
    //         // }
    //         $flag = 0;
    //         // dd($categories_array);

    //         /* obtiene nro para agrupar requerimientos */
    //         /* TODO: Dejar una query, se hace dos veces una para preguntar si es igual a cero y la otra para obetener el siguiente */
    //         if (Requirement::whereNotNull('group_number')->count() === 0) {
    //             $group_number = 1;
    //         } else {
    //             $group_number = Requirement::whereNotNull('group_number')
    //                     ->latest()
    //                     ->first()
    //                     ->group_number + 1;
    //         }

    //         //$requerimientos = '';
    //         $usersEmail = '';
    //         $isAnyManager = false;
    //         foreach ($users as $key => $user) {

    //             $req = $request->All();
    //             if ($request->limit_at <> null) {
    //                 $req['limit_at'] = Carbon::createFromFormat('Y-m-d\TH:i', $request->limit_at)->format('Y-m-d H:i:00');
    //             }

    //             //Si algún usuario destino es autoridad, se marca el requerimiento
    //             $userModel = User::find($user);

    //             /* // FIXME: si no tiene manager, no puede obtener ->user_id */
    //             /** Para saber si un usuario es autoridad de su propia unidad organizacional */
    //             $managerUserId = Authority::getAuthorityFromDate($userModel->organizationalUnit->id, now(), 'manager')->user_id;

    //             /* // FIXME: siempre el anyManager se basará en el último user */
    //             $isManager = ($user == $managerUserId);

    //             /* TODO: Que hace el isAnyManager o cual es la diferencia con el isManager */
    //             if ($isManager) $isAnyManager = true;

    //             //dump($user, $isManager);

    //             //se crea requerimiento
    //             $requirement = new Requirement($req);
    //             $requirement->user()->associate(auth()->user());
    //             $requirement->group_number = $group_number;
    //             $requirement->to_authority = $isAnyManager;

    //             /* TODO: los indices coinciden? */
    //             if($categories_array){
    //                 $requirement->category_id = $categories_array[$key];
    //             }
    //             $requirement->save();

    //             /** Asigna las labels al requerimiento */
    //             $requirement->setLabels($request->input('label_id'));

    // 			// /** Marca los eventos como vistos */
    // 			// $requirement->setEventsAsViewed;

    //             /* se ingresa una sola vez: se guardan posibles usuarios en copia. */
    //             /* Se agregan primero que otros eventos del requerimiento, para que no queden como "last()" */
    //             if ($users_enCopia <> null) {
    //                 if ($flag == 0) {
    //                     $isAnyManager = false;
    //                     /* // FIXME: ambos se llaman key, deberian ser diferentes, esto está dentro de otro foreach con otro key */
    //                     foreach ($users_enCopia as $key => $user_) {
    //                         //Si algún usuario en copia es autoridad, se marca el requerimiento y evento
    //                         $userModel = User::find($user_);

    //                         $managerUserId = Authority::getAuthorityFromDate($userModel->organizationalUnit->id, now(), 'manager')->user_id;
    //                         $isManager = ($user_ == $managerUserId);
    //                         if ($isManager) $isAnyManager = true;
    //                         //dump($user_, $isManager);

    //                         /* // FIXME: se carga una coleccion de user, pero, solo se usar para obtener la ou_id */
    //                         $user_aux = User::where('id', $user_)->get();
    //                         $firstEvent = new Event($request->All());
    //                         $firstEvent->to_user_id = $user_;
    //                         $firstEvent->to_ou_id = $user_aux->first()->organizational_unit_id;
    //                         $firstEvent->status = "en copia";
    //                         $firstEvent->from_user()->associate(auth()->user());
    //                         $firstEvent->from_ou_id = auth()->user()->organizationalUnit->id;
    //                         $firstEvent->requirement()->associate($requirement);
    //                         $firstEvent->to_authority = $isManager;
    //                         $firstEvent->save();

    //                         $requirement->events()->save($firstEvent);
    //                     }
    //                     $flag = 1;
    //                     /* // FIXME: siempre quedará con el el estado del útlimo en copia */
    //                     $requirement->update(['to_authority' => $isAnyManager]);
    //                 }
    //             }

    //             //se ingresan los otros tipos de eventos (que no sean "en copia")
    //             $firstEvent = new Event($request->All());
    //             //$firstEvent->organizational_unit_id = $user_aux->first()->organizational_unit_id;

    //             /* // FIXME: ya está antes */
    //             $user_aux = User::find($user);
    //             if ($user_aux) {
    //                 $firstEvent->to_user_id = $user_aux->id;
    //                 $firstEvent->to_ou_id = $user_aux->organizational_unit_id;

    //                 //Si usuario es autoridad, se marca el requerimiento y evento
    //                 $managerUserId = Authority::getAuthorityFromDate($user_aux->organizational_unit_id, now(), 'manager')->user_id;
    //                 $isManager = ($user_aux->id == $managerUserId);
    //                 $firstEvent->to_authority = $isManager;
    //                 if (!$isAnyManager) $requirement->update(['to_authority' => $isManager]);
    //             }
    //             $firstEvent->from_user()->associate(auth()->user());
    //             $firstEvent->from_ou_id = auth()->user()->organizationalUnit->id;
    //             $firstEvent->requirement()->associate($requirement);
    //             $firstEvent->save();

    //             /* // FIXME: esto obtiene el primer usuario de la BD
    //              * Obtiene emails
    //              * */
    //             $usersEmail .= $user_aux->first()->email . ',';

    //             //asocia evento con documentos
    //             /* // FIXME: al parecer no es necesario la KEY y si fuese, no debería llamarse igual a la del foreach */
    //             if ($request->documents <> null) {
    //                 foreach ($request->documents as $key => $document_aux) {
    //                     /* // FIXME: no se necesita cargar el modelo documento, se puede asociar directamente el $document_aux en el attach */
    //                     $document = Document::find($document_aux);
    //                     $firstEvent->documents()->attach($document);
    //                 }
    //             }

    //             //guarda archivos
    //             if ($request->hasFile('forfile')) {
    //                 foreach ($request->file('forfile') as $file) {
    //                     $filename = $file->getClientOriginalName();
    //                     $fileModel = new File;
    //                     // $fileModel->file = $file->store('requirements');
    //                     $fileModel->file = $file->store('ionline/requirements',['disk' => 'gcs']);
    //                     $fileModel->name = $filename;
    //                     $fileModel->event_id = $firstEvent->id;
    //                     $fileModel->save();
    //                 }
    //             }

    //             $requirement->events()->save($firstEvent);

    //             /** Marca los eventos como vistos */
    // 			$requirement->setEventsAsViewed;

    //             //$requirement->categories()->attach($request->input('category_id'));
    //             //$requerimientos = $requerimientos + $firstEvent->id + ",";
    //         }

    //         if (env('APP_ENV') == 'production') {
    //             preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $usersEmail, $emails);
    //             Mail::to($emails[0])
    //                 ->send(new RequirementNotification($requirement));
    //         }

    //         session()->flash('info', 'Los requerimientos han sido creados.');
    //     // }

    //     /* Si es un requerimiento creado desde un parte envía a inbox de parte */
    //     if ($requirement->parte_id) $return = 'documents.partes.index';
    //     else $return = 'requirements.inbox';

    //     return redirect()->route($return);
    // }

    public function store(Request $request)
    {
        //dd($request->all());

        /*
            $request =
            [
                "parte_id" => "13664",
                "label_id" => [
                    0 => "8"
                ],
                "to_ou_id" => "232", // No sirve
                "to_user_id" => "9186139", // No sirve
                "users" => [
                    0 => "14093235",
                    1 => "15343100",
                    2 => "16057392",
                    3 => "9186139",
                ],
                "enCopia" => [
                    0 => "0",
                    1 => "0",
                    2 => "1",
                    3 => "1",
                ],
                "categories" => [
                    0 => null,
                    1 => null,
                    2 => null,
                    3 => 1,
                ],
                "subject" => "PERMISO 08, 09 Y 10.02.2023",
                "body" => "saDAs",
                "priority" => "Normal",
                "limit_at" => "2023-02-14T15:37",
                "documents" => "1,319",
            ];
        */

        /* obtiene nuevo array con categorias */
        foreach ($request->users as $key => $user_id) {
            $categories[] = $request['category'.$key];
        }

        /* Arma dos array, con la combinación de users, enCopia y categories */
        $copias = [];
        foreach ($request->users as $key => $user_id) {
            if ($request->enCopia[$key] == 1) {
                $copias[$key]['user_id'] = $user_id;
                $copias[$key]['category'] = $categories[$key];
            } else {
                $users[$key]['user_id'] = $user_id;
                $users[$key]['category'] = $categories[$key];
            }
        }

        /*
            USERS
            array:2 [▼
                0 => array:2 [▼
                    "user_id" => "14093235"
                    "category" => null
                ]
                1 => array:2 [▼
                    "user_id" => "15343100"
                    "category" => null
                ]
            ]

            COPIAS
            array:2 [▼
                2 => array:2 [▼
                    "user_id" => "16057392"
                    "category" => null
                ]
                3 => array:2 [▼
                    "user_id" => "9186139"
                    "category" => 1
                ]
            ]
        */

        /** Tareas comunes para todos los requerimientos */
        /** Obtener el siguiente número de grupo */
        $group_number = Requirement::getNextGroupNumber();
        /** Generar un array con los id de documentos */
        $documents_ids = ($request->documents) ? explode(',', $request->documents) : null;
        /** Cadena vacía para armar el listado de correos */
        $emails = '';

        foreach ($users as $user) {
            /** Modelo User al que va dirigido el req */
            $toUser = User::find($user['user_id']);

            /** Chequea que el usuario sea autoridad de su OU */
            $to_authority = Authority::getAmIAuthorityOfMyOu(today(), 'manager', $user['user_id']);

            /** Crear el requerimiento */
            $requirement = Requirement::create([
                'subject' => $request->subject,
                'priority' => $request->priority,
                'status' => 'creado', // Cómo se llena en el otro store?
                'limit_at' => $request->limit_at,
                'user_id' => auth()->id(),
                'parte_id' => $request->parte_id,
                'group_number' => $group_number,
                'to_authority' => $to_authority,
                'category_id' => $user['category'],
            ]);

            /** Setear las categorias */
            $requirement->setLabels($request->label_id);

            /** No sé porque, pero ...primero hay que crear
             * todos los eventos de tipo copia. */
            foreach ($copias as $copia) {
                /** Modelo User al que va dirigido la copia */
                $toCopia = User::find($copia['user_id']);

                $event = Event::create([
                    'body' => $request->body,
                    'status' => 'en copia',
                    'from_user_id' => auth()->id(),
                    'form_ou_id' => auth()->user()->organizational_unit_id,
                    'to_user_id' => $toCopia->id,
                    'to_ou_id' => $toCopia->organizational_unit_id,
                    'requirement_id' => $requirement->id,
                    'to_authority' => $to_authority,
                ]);
            }

            /** A continuación Crea el primer evento */
            $event = Event::create([
                'body' => $request->body,
                'status' => 'creado',
                'from_user_id' => auth()->id(),
                'form_ou_id' => auth()->user()->organizational_unit_id,
                'to_user_id' => $toUser->id,
                'to_ou_id' => $toUser->organizational_unit_id,
                'requirement_id' => $requirement->id,
                'to_authority' => $to_authority,
            ]);

            /** Asociar documentos */
            if ($documents_ids) {
                foreach ($documents_ids as $document_id) {
                    $event->documents()->attach($document_id);
                }
            }

            /** Guardar el archivo */
            if ($request->hasFile('forfile')) {
                foreach ($request->file('forfile') as $file) {
                    $filename = $file->getClientOriginalName();
                    $fileModel = new File;
                    $fileModel->file = $file->store('ionline/requirements', ['disk' => 'gcs']);
                    $fileModel->name = $filename;
                    $fileModel->event_id = $event->id;
                    $fileModel->save();
                }
            }

            /** Notifica por correo al destinatario, en cola */
            $toUser->notify(new NewSgr($requirement, $event));

            /** Marca los eventos como vistos */
            $requirement->setEventsAsViewed;
        }

        /**
         * Manda correos a el listado de emails
         * ELIMINADO; porque ahora se envían los mails con notify() y en cola
         */
        // if (env('APP_ENV') == 'production') {
        //     preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $emails, $emails_validos);
        //     try {
        //         Mail::to($emails_validos[0])
        //             ->send(new RequirementNotification($requirement));
        //     } catch (\Exception $exception) {
        //         logger()->error($exception->getMessage());
        //     }
        // }

        session()->flash('info', 'Los requerimientos han sido creados.');

        /* Si es un requerimiento creado desde un parte envía a inbox de parte */
        if ($requirement->parte_id) {
            $return = 'documents.partes.index';
        } else {
            $return = 'requirements.inbox';
        }

        return redirect()->route($return);
    }

    public function director_store(Request $request)
    {

        /*
            $request =
            [
                "parte_id" => "13664",
                "label_id" => [
                    0 => "8"
                ],
                "to_ou_id" => "232", // No sirve
                "to_user_id" => "9186139", // No sirve
                "users" => [
                    0 => "14093235",
                    1 => "15343100",
                    2 => "16057392",
                    3 => "9186139",
                ],
                "enCopia" => [
                    0 => "0",
                    1 => "0",
                    2 => "1",
                    3 => "1",
                ],
                "subject" => "PERMISO 08, 09 Y 10.02.2023",
                "body" => "saDAs",
                "priority" => "Normal",
                "limit_at" => "2023-02-14T15:37",
                "documents" => "1,319",
            ];
        */

        /* Arma dos array, con la combinación de users, enCopia y categories */
        $copias = [];
        foreach ($request->users as $key => $user_id) {
            if ($request->enCopia[$key] == 1) {
                $copias[$key]['user_id'] = $user_id;
            } else {
                $users[$key]['user_id'] = $user_id;
            }
        }

        /*
            USERS
            array:2 [▼
                0 => array:2 [▼
                    "user_id" => "14093235"
                ]
                1 => array:2 [▼
                    "user_id" => "15343100"
                ]
            ]

            COPIAS
            array:2 [▼
                2 => array:2 [▼
                    "user_id" => "16057392"
                ]
                3 => array:2 [▼
                    "user_id" => "9186139"
                ]
            ]
        */

        /** Tareas comunes para todos los requerimientos */
        /** Obtener el siguiente número de grupo */
        $group_number = Requirement::getNextGroupNumber();
        /** Generar un array con los id de documentos */
        $documents_ids = ($request->documents) ? explode(',', $request->documents) : null;
        /** Cadena vacía para armar el listado de correos */
        $emails = '';

        foreach ($users as $user) {
            /** Modelo User al que va dirigido el req */
            $toUser = User::find($user['user_id']);

            /** Chequea que el usuario sea autoridad de su OU */
            $to_authority = Authority::getAmIAuthorityOfMyOu(today(), 'manager', $user['user_id']);

            /** Crear el requerimiento */
            $requirement = Requirement::create([
                'subject' => $request->subject,
                'priority' => $request->priority,
                'status' => 'creado', // Cómo se llena en el otro store?
                'limit_at' => $request->limit_at,
                'user_id' => auth()->id(),
                'parte_id' => $request->parte_id,
                'group_number' => $group_number,
                'to_authority' => $to_authority,
            ]);

            /** Setear las categorias */
            $requirement->setLabels($request->label_id);

            /** No sé porque, pero ...primero hay que crear
             * todos los eventos de tipo copia. */
            foreach ($copias as $copia) {
                /** Modelo User al que va dirigido la copia */
                $toCopia = User::find($copia['user_id']);

                $event = Event::create([
                    'body' => $request->body,
                    'status' => 'en copia',
                    'from_user_id' => auth()->id(),
                    'form_ou_id' => auth()->user()->organizational_unit_id,
                    'to_user_id' => $toCopia->id,
                    'to_ou_id' => $toCopia->organizational_unit_id,
                    'requirement_id' => $requirement->id,
                    'to_authority' => $to_authority,
                ]);
            }

            /** A continuación Crea el primer evento */
            $event = Event::create([
                'body' => $request->body,
                'status' => 'creado',
                'from_user_id' => auth()->id(),
                'form_ou_id' => auth()->user()->organizational_unit_id,
                'to_user_id' => $toUser->id,
                'to_ou_id' => $toUser->organizational_unit_id,
                'requirement_id' => $requirement->id,
                'to_authority' => $to_authority,
            ]);

            /** Asociar documentos */
            if ($documents_ids) {
                foreach ($documents_ids as $document_id) {
                    $event->documents()->attach($document_id);
                }
            }

            /** Guardar el archivo */
            if ($request->hasFile('forfile')) {
                foreach ($request->file('forfile') as $file) {
                    $filename = $file->getClientOriginalName();
                    $fileModel = new File;
                    $fileModel->file = $file->store('ionline/requirements', ['disk' => 'gcs']);
                    $fileModel->name = $filename;
                    $fileModel->event_id = $event->id;
                    $fileModel->save();
                }
            }

            /**
             * Ahoras los mails se envían con Notify y en cola
             */
            $toUser->notify(new NewSgr($requirement, $event));

            /** Cadena con correos de los destinatarios separados por "," */
            // if($toUser->email) {
            //     $emails .= $toUser->email . ',';
            // }

            /** Marca los eventos como vistos */
            $requirement->setEventsAsViewed;
        }

        /**
         * ELIMINADO: Ahora los email se envian con Notify y en cola
         * Manda correso a el listado de emails
         */
        // if (env('APP_ENV') == 'production') {
        //     preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $emails, $emails_validos);
        //     try {
        //         Mail::to($emails_validos[0])
        //             ->send(new RequirementNotification($requirement));
        //     } catch (\Exception $exception) {
        //         logger()->error($exception->getMessage());
        //     }
        // }

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

        return redirect()->route('requirements.createFromParte', $parte);
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
     */
    public function show(Requirement $requirement): View
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
            ->where('from_user_id', '<>', auth()->id())->get()->last();
        //dd($lastEvent);

        //si no existen respuestas de otras personas, se devuelve la ultima cualquiera.
        if ($lastEvent == null) {
            $lastEvent = Event::where('requirement_id', $requirement->id)->get()->last();
        }
        $firstEvent = Event::where('requirement_id', $requirement->id)
            //->where('from_user_id','<>',auth()->id())->get()
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
                $matrix2[$cont]['usuario'] = $user->fullName;
                $matrix2[$cont]['creado'] = 0;
                $matrix2[$cont]['respondido'] = 0;
                $matrix2[$cont]['cerrado'] = 0;
                $matrix2[$cont]['derivado'] = 0;
                $matrix2[$cont]['reabierto'] = 0;

                foreach ($user->requirements as $key3 => $requirement) {
                    if (($requirement->created_at >= $dateFrom) && ($requirement->created_at <= $dateTo)) {
                        if ($requirement->status == 'creado') {
                            $matrix[$key]['creado'] = $matrix[$key]['creado'] + 1;
                            $matrix2[$cont]['creado'] = $matrix2[$cont]['creado'] + 1;
                        }
                        if ($requirement->status == 'respondido') {
                            $matrix[$key]['respondido'] = $matrix[$key]['respondido'] + 1;
                            $matrix2[$cont]['respondido'] = $matrix2[$cont]['respondido'] + 1;
                        }
                        if ($requirement->status == 'cerrado') {
                            $matrix[$key]['cerrado'] = $matrix[$key]['cerrado'] + 1;
                            $matrix2[$cont]['cerrado'] = $matrix2[$cont]['cerrado'] + 1;
                        }
                        if ($requirement->status == 'derivado') {
                            $matrix[$key]['derivado'] = $matrix[$key]['derivado'] + 1;
                            $matrix2[$cont]['derivado'] = $matrix2[$cont]['derivado'] + 1;
                        }
                        if ($requirement->status == 'reabierto') {
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

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Requirement $requirement)
    {
        $id = $requirement->id;
        $requirement->events()->delete();
        $requirement->requirementStatus()->delete();
        $requirement->delete();

        session()->flash('success', 'El requerimiento '.$id.' ha sido eliminado');

        return redirect()->route('requirements.inbox');
    }
}
