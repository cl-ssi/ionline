<?php

namespace App\Http\Controllers\Rrhh;

use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Rrhh\OrganizationalUnit;
use App\Rrhh\Authority;
use App\Models\Rrhh\UserBankAccount;
use App\Models\Parameters\AccessLog;
use App\Models\Establishment;
use App\Models\ClCommune;
use App\Http\Requests\Rrhh\updatePassword;
use App\Http\Requests\Rrhh\storeUser;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::getUsersBySearch($request->get('name'))
            ->filter('organizational_unit_id',$request->input('organizational_unit_id'))
            ->filter('permission',$request->input('permission'))
            ->with([
                'organizationalUnit',
                'permissions',
                'roles',
            ])->orderBy('name', 'Asc')->paginate(100);

        $permissions = Permission::orderBy('name')->pluck('name');

        $can = [
            'be god' => auth()->user()->can('be god'),
            'Users: edit' => auth()->user()->can('Users: edit'),
        ];

        return view('rrhh.index', compact('users','permissions','can'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function directory(Request $request, Establishment $establishment = null, OrganizationalUnit $organizationalUnit = null)
    {
        $establishments_ids = explode(',',env('APP_SS_ESTABLISHMENTS'));
        
        $establishments = Establishment::whereIn('id',$establishments_ids)->orderBy('official_name')->get();

        if ($request->input('name')) {
            $users = User::with('organizationalUnit','organizationalUnit.establishment','telephones')
                ->findByUser($request->get('name'))
                ->withTrashed(false)
                ->orderBy('name')
                ->paginate(50);
        }
        elseif($organizationalUnit) {
            $users = User::with('organizationalUnit','organizationalUnit.establishment','telephones')
                ->where('organizational_unit_id',$organizationalUnit->id)
                ->withTrashed(false)
                ->orderBy('name')
                ->paginate(50);
        }
        else {
            $users = collect();
        }

        return view('rrhh.directory', compact('establishments','establishment','users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //$ouRoot = OrganizationalUnit::find(1);
        $ouRoots = OrganizationalUnit::where('level', 1)->get();
        return view('rrhh.create')->withOuRoots($ouRoots);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(storeUser $request)
    {
        $user = new User($request->All());

        /** Ya no crearemos el password por defecto */
        //$user->password = bcrypt($request->id);

        if ($request->has('organizationalunit')) {
            if ($request->filled('organizationalunit')) {
                $user->organizationalunit()->associate($request->input('organizationalunit'));
            } else {
                $user->organizationalunit()->dissociate();
            }
        }

        $user->save();

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')
                ->storeAs('public', $user->id . '.' . $request->file('photo')->clientExtension());
        }

        foreach($request->input('permissions') as $permission) {
            $user->givePermissionTo($permission);
        }
        // $user->givePermissionTo('Authorities: view');
        // $user->givePermissionTo('Calendar: view');
        // $user->givePermissionTo('Requirements: create');


        session()->flash('info', 'El usuario ' . $user->name . ' ha sido creado.');

        return redirect()->route('rrhh.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //$ouRoot = OrganizationalUnit::find(1);
        $user_id = $user->id;
        /* FIXME: cambiar cuando creemos un componente para seleccionar OU más eficiente */
        $ouRoots = OrganizationalUnit::with([
            'childs',
            'childs.establishment',
            'childs.childs',
            'childs.childs.establishment',
            'childs.childs.childs',
            'childs.childs.childs.establishment',
            'childs.childs.childs.childs',
            'childs.childs.childs.childs.establishment',
        ])->where('level', 1)->get();

        $bankaccount = UserBankAccount::where('user_id', $user_id)->get();
        $communes = ClCommune::pluck('name','id');

        return view('rrhh.edit')
            ->withCommunes($communes)
            ->withUser($user)
            ->withBankaccount($bankaccount)
            ->withouRoots($ouRoots);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->fill($request->all());

        if ($request->has('organizationalunit')) {
            if ($request->filled('organizationalunit')) {
                $user->organizationalunit()->associate($request->input('organizationalunit'));
            } else {
                $user->organizationalunit()->dissociate();
            }
        }

        if ($user->isDirty('email_personal')) {
            // dd('full cocaina');
            $user->email_verified_at = null;
            $user->save();
            $user->sendEmailVerificationNotification();
        } else {
            $user->save();
        }

        session()->flash('success', 'El usuario ' . $user->name . ' ha sido actualizado.');

        return redirect()->route('rrhh.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        /* Primero Limpiamos todos los roles */
        $user->roles()->detach();
        /* Segundo limpiamos permisos y contraseña */
        $user->syncPermissions([]);
        $user->givePermissionTo('Users: must change password');
        $user->givePermissionTo('Nuevo iOnline');
        $user->password = null;
        $user->save();

        $user->delete();

        session()->flash('success', 'El usuario ' . $user->name . ' ha sido eliminado');

        return redirect()->route('rrhh.users.index');
    }

    /**
     * Redirect to VC link if is set
     *
     * @param  $alias  $user->alias
     * @return \Illuminate\Http\Redirect
     */
    public function getVcLink($alias) 
    {
        $user = User::where('vc_alias',$alias)->first();
        return ($user AND $user->vc_link) ? redirect($user->vc_link) : abort(404);
    }


    /**
     * Show the form for change password.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function editPassword()
    {
        return view('rrhh.edit_password');
    }

    /**
     * Update the current loged user password
     *
     * @param  \Illuminate\Http\updatePassword  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(updatePassword $request)
    {
        $weakPaswords = [
            auth()->id(),
            auth()->id().auth()->user()->dv,
            'salud123',
            'Salud123',
            '123salud',
        ];

        if(in_array($request->newpassword, $weakPaswords)) {
            session()->flash('danger', 'La nueva clave no puede ser su run o una clave simple.');
        } else {
            if (Hash::check($request->password, Auth()->user()->password)) {
                Auth()->user()->password = bcrypt($request->newpassword);
                auth()->user()->password_changed_at = now();
                Auth()->user()->save();
    
                session()->flash('success', 'Su clave ha sido cambiada con éxito.');
    
                if (Auth()->user()->hasPermissionTo('Users: must change password')) {
                    Auth()->user()->revokePermissionTo('Users: must change password');
                    Auth::login(Auth()->user());
                }
            } else {
                session()->flash('danger', 'La clave actual es erronea.');
            }
        }

        return redirect()->back();
    }

    /**
     * Reset user password.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(User $user)
    {
        $user->password = bcrypt($user->id);
        $user->password_changed_at = null;
        $user->save();

        session()->flash('success', 'La clave ha sido reseteada a: ' . $user->id);

        return redirect()->route('rrhh.users.edit', $user->id);
    }


    public function switch(User $user)
    {
        if (session()->has('god')) {
            /* Clean session god (user_id) */
            session()->pull('god');
        } else {
            /* set god session to user_id */
            session(['god' => Auth::id()]);
        }

        Auth::login($user);

        /** Registrar el switch */
        if (session()->has('god')) {
            /** Log access */
            auth()->user()->accessLogs()->create([
                'type' => 'switch',
                'switch_id' => session()->get('god'),
                'enviroment' => env('OLD_SERVER') ? 'Servidor':'Cloud Run'
            ]);
        }

        return back();
    }

    /**
     * Display a listing of users from an OrganizationalUnit.
     *
     * @return \Illuminate\Http\Response
     */
    public function getFromOu($ou_id)
    {
        $authority = null;
        $current_authority = Authority::getAuthorityFromDate($ou_id, Carbon::now(), 'manager');
        if ($current_authority) {
            $authority = $current_authority->user;
        }
        $users = User::where('organizational_unit_id', $ou_id)->orderBy('name')->get();
        if ($authority <> null) {
            if (!$users->find($authority)) {
                $users->push($authority);
            }
        }
        return $users;
    }

    public function getAutorityFromOu($ou_id)
    {
        $authority = Authority::getAuthorityFromDate($ou_id, Carbon::now(), 'manager');
        return $authority;
    }








    //funciones users service_requests

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_sr(Request $request)
    {
        $users = User::Search($request->get('name'))->permission('Service Request')->orderBy('name', 'Asc')->paginate(500);
        return view('rrhh.users_service_requests.index', compact('users'));
    }

    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function directory_sr(Request $request)
    // {
    //     if ($request->get('ou')) {
    //         $users = User::has('telephones')->where('organizational_unit_id',$request->get('ou'))->orderBy('name')->paginate(20);
    //     }
    //     else {
    //         $users = User::has('telephones')->Search($request->get('name'))->orderBy('name','Asc')->paginate(20);
    //     }
    //
    //     /* Devuelve sólo Dirección, ya que de él dependen todas las unidades organizacionales hacia abajo */
    //     $organizationalUnit = OrganizationalUnit::Find(1);
    //     return view('rrhh.users_service_requests.directory')->withUsers($users)->withOrganizationalUnit($organizationalUnit);
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_sr()
    {

        //$ouRoot = OrganizationalUnit::find(1);
        $ouRoots = OrganizationalUnit::where('establishment_id', 1)->get();
        // $ouRoots = OrganizationalUnit::find(84);
        // dd($ouRoots);
        return view('rrhh.users_service_requests.create')->withOuRoots($ouRoots);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_sr(storeUser $request)
    {
        $user = new User($request->All());
        $user->password = bcrypt($request->id);

        if ($request->has('organizationalunit')) {
            if ($request->filled('organizationalunit')) {
                $user->organizationalunit()->associate($request->input('organizationalunit'));
            } else {
                $user->organizationalunit()->dissociate();
            }
        }

        $user->save();

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')
                ->storeAs('public', $user->id . '.' . $request->file('photo')->clientExtension());
        }

        $user->givePermissionTo('Users: must change password');
        $user->givePermissionTo('Authorities: view');
        $user->givePermissionTo('Calendar: view');
        $user->givePermissionTo('Requirements: create');
        $user->givePermissionTo('Service Request');
        $user->givePermissionTo('Service Request: fulfillments');
        $user->givePermissionTo('Service Request: fulfillments responsable');


        session()->flash('info', 'El usuario ' . $user->name . ' ha sido creado.');

        return redirect()->route('rrhh.users.service_requests.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show_sr(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit_sr(User $user)
    {
        $ouRoot = OrganizationalUnit::find(84);
        return view('rrhh.users_service_requests.edit')
            ->withUser($user)
            ->withOuRoot($ouRoot);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update_sr(Request $request, User $user)
    {
        $user->fill($request->all());

        if ($request->has('organizationalunit')) {
            if ($request->filled('organizationalunit')) {
                $user->organizationalunit()->associate($request->input('organizationalunit'));
            } else {
                $user->organizationalunit()->dissociate();
            }
        }

        $user->save();

        session()->flash('success', 'El usuario ' . $user->name . ' ha sido actualizado.');

        return redirect()->route('rrhh.users.service_requests.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy_sr(User $user)
    {
        /* Primero Limpiamos todos los roles */
        $user->roles()->detach();

        $user->delete();

        session()->flash('success', 'El usuario ' . $user->name . ' ha sido eliminado');

        return redirect()->route('rrhh.users.service_requests.index');
    }

    public function drugs()
    {
        $users = User::permission('Drugs')->get();
        return view('drugs.users', compact('users'));
    }

    public function openNotification($notification)
    {
        $notification = auth()->user()->notifications->find($notification);
        $route = $notification->data['action'];
        $notification->markAsRead();
        return redirect($route);
    }

    public function allNotifications()
    {
        // $notifications = auth()->user()->notifications;
        return view('notifications.index');
    }

    public function clearNotifications()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->route('allNotifications');
    }

    public function lastAccess()
    {
        // $notifications = auth()->user()->notifications;
        //dd('último acceso');
        $accessLogs = AccessLog::latest()->paginate(100);
        return view('rrhh.last_access.index', compact('accessLogs'));
        //return view('rrhh.users.last_access.index');
    }
}
