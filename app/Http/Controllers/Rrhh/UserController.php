<?php

namespace App\Http\Controllers\Rrhh;

use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Rrhh\OrganizationalUnit;
use App\Models\Rrhh\Authority;
use App\Models\Rrhh\UserBankAccount;
use App\Models\Parameters\AccessLog;
use App\Models\Establishment;
use App\Models\ClCommune;
use App\Http\Requests\Rrhh\updatePassword;
use App\Http\Requests\Rrhh\storeUser;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

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
            ->filter('role',$request->input('roles'))
            ->with([
                'organizationalUnit',
                'permissions',
                'roles',
            ])
            ->orderBy('full_name', 'asc')
            ->paginate(100);

        $permissions = Permission::orderBy('name')->pluck('name');
        $roles = Role::orderBy('name')->pluck('name');

        $can = [
            'be god' => auth()->user()->can('be god'),
            'Users: edit' => auth()->user()->can('Users: edit'),
        ];

        $request->flash();
        
        return view('rrhh.index', compact('users','permissions','roles','can'));
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
                ->whereExternal(false)
                ->orderBy('name')
                ->paginate(50);
        }
        elseif($organizationalUnit) {
            $users = User::with('organizationalUnit','organizationalUnit.establishment','telephones')
                ->where('organizational_unit_id',$organizationalUnit->id)
                ->withTrashed(false)
                ->whereExternal(false)
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
        $roles = Role::whereNot('name','god')->orderBy('name')->get();
        return view('rrhh.create', compact('ouRoots','roles'));
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

        /** 
         * Ya no crearemos el password por defecto 
         * por que no todos los usuarios necesitan acceso a la plataforma
         * 
         * El usuario puede crearse una nueva contraseña en la opción "Olvido su contraseña"
         * o bien el administrador que lo esta creando puede utilizar la opción "Resetear clave"
         */
        //$user->password = bcrypt($request->id);

        if ($request->has('organizationalunit')) {
            if ($request->filled('organizationalunit')) {
                $user->organizationalunit()->associate($request->input('organizationalunit'));
            } else {
                $user->organizationalunit()->dissociate();
            }
        }

        $user->save();

        if($request->has('roles')) {
            foreach($request->input('roles') as $role) {
                $user->assignRole($role);
            }
        }
        $user->givePermissionTo('Users: must change password');


        session()->flash('info', 'El usuario ' . $user->name . 
            ' ha sido creado. Puede generar una nueva clave en la opción: "Olvido su contraseña" en el login o bien el administrador que lo esta creando puede utilizar la opción "Resetear clave"');

        return redirect()->route('rrhh.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $communes = ClCommune::pluck('name','id');

        return view('rrhh.edit')
            ->withCommunes($communes)
            ->withUser($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        /* Primero Limpiamos todos los roles */
        $user->roles()->detach();
        /* Segundo limpiamos permisos y contraseña */
        $user->syncPermissions([]);

        $user->password = null;
        $user->save();

        // Eliminar de authorities todos los registros donde aparezca el usuario desde hoy en adelante
        Authority::where('user_id', $user->id)->where('date', '>=', now()->startOfDay())->delete();
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
     * @param  \App\Models\User  $user
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
            if (Hash::check($request->password, auth()->user()->password)) {
                auth()->user()->password = bcrypt($request->newpassword);
                auth()->user()->password_changed_at = now();
                auth()->user()->save();
    
                session()->flash('success', 'Su clave ha sido cambiada con éxito.');
    
                if (auth()->user()->hasPermissionTo('Users: must change password')) {
                    auth()->user()->revokePermissionTo('Users: must change password');
                    Auth::login(auth()->user());
                }
            } else {
                session()->flash('danger', 'La clave actual es erronea.');
                return redirect()->route('home');
            }
        }

        return redirect()->back();
    }

    /**
     * Reset user password.
     *
     * @param  \App\Models\User  $user
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

    public function drugs()
    {
        $daysAgo = 15;

        $lastLogs = AccessLog::with('user','switchUser')
            ->where('type', 'drugs')
            ->where('created_at', '>', now()->subDays($daysAgo))
            ->whereHas('user', function($query) {
                $query->whereHas('organizationalUnit', function($query) {
                    $query->whereHas('establishment', function($subQuery) {
                        $subQuery->where('id', auth()->user()->organizationalUnit->establishment_id);
                    });
                });
            })
            ->latest()
            ->get();

        $users = User::permission('Drugs')->get();

        return view('drugs.users', compact('users','lastLogs', 'daysAgo'));
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
