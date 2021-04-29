<?php

namespace App\Http\Controllers\Rrhh;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rrhh\storeUser;
use App\Http\Requests\Rrhh\updatePassword;
use App\Rrhh\Authority;
use App\User;
use App\Rrhh\OrganizationalUnit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Rrhh\UserBankAccount;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$users = User::Search($request->get('name'))->orderBy('name','Asc')->paginate(50);
        $users = User::getUsersBySearch($request->get('name'))->orderBy('name','Asc')->paginate(150);
        return view('rrhh.index', compact('users'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function directory(Request $request)
    {
        $users = User::getUsersBySearch($request->name)->has('telephones')->orderBy('name','Asc')->paginate(20);
/*
        if ($request->get('ou')) {
            //$users = User::has('telephones')->where('organizational_unit_id',$request->get('ou'))->orderBy('name')->paginate(20);
            $users = $users->has('telephones')->where('organizational_unit_id',$request->get('ou'))->orderBy('name')->paginate(20);
        }
        else {
            //$users = User::has('telephones')->Search($request->get('name'))->orderBy('name','Asc')->paginate(20);
            $users = $users->has('telephones')->Search($request->get('name'))->orderBy('name','Asc')->paginate(20);
        }
*/
        /* Devuelve sólo Dirección, ya que de él dependen todas las unidades organizacionales hacia abajo */
        $organizationalUnit = OrganizationalUnit::Find(1);
        return view('rrhh.directory')->withUsers($users)->withOrganizationalUnit($organizationalUnit);
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
        $user->password = bcrypt($request->id);

        if ($request->has('organizationalunit')) {
            if ($request->filled('organizationalunit')) {
                $user->organizationalunit()->associate($request->input('organizationalunit'));
            }
            else {
                $user->organizationalunit()->dissociate();
            }
        }

        $user->save();

        if($request->hasFile('photo')){
            $path = $request->file('photo')
                ->storeAs('public',$user->id.'.'.$request->file('photo')->clientExtension());
        }

        $user->givePermissionTo('Users: must change password');
        $user->givePermissionTo('Authorities: view');
        $user->givePermissionTo('Calendar: view');
        $user->givePermissionTo('Requirements: create');


        session()->flash('info', 'El usuario '.$user->name.' ha sido creado.');

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
        $user_id=$user->id;
        $ouRoots = OrganizationalUnit::where('level', 1)->get();
        $bankaccount = UserBankAccount::where('user_id',$user_id)->get();
        return view('rrhh.edit')
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
            }
            else {
                $user->organizationalunit()->dissociate();
            }
        }

        $user->save();

        session()->flash('success', 'El usuario '.$user->name.' ha sido actualizado.');

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

        $user->delete();

        session()->flash('success', 'El usuario '.$user->name.' ha sido eliminado');

        return redirect()->route('rrhh.users.index');
    }

    /**
     * Show the form for change password.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function editPassword() {
        return view('rrhh.edit_password');
    }

    /**
     * Update the current loged user password
     *
     * @param  \Illuminate\Http\updatePassword  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(updatePassword $request) {
        if(Hash::check($request->password, Auth()->user()->password)) {
            Auth()->user()->password = bcrypt($request->newpassword);
            Auth()->user()->save();

            session()->flash('success', 'Su clave ha sido cambiada con éxito.');

            if( Auth()->user()->hasPermissionTo('Users: must change password') ) {
                Auth()->user()->revokePermissionTo('Users: must change password');
                Auth::login(Auth()->user());
            }

        }
        else {
            session()->flash('danger', 'La clave actual es erronea.');
        }

        return redirect()->route('home');
    }

    /**
     * Reset user password.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(User $user) {
        $user->password = bcrypt($user->id);
        $user->save();

        session()->flash('success', 'La clave ha sido reseteada a: '.$user->id);

        return redirect()->route('rrhh.users.edit', $user->id);
    }


    public function switch(User $user) {
        if (session()->has('god')) {
            /* Clean session var */
            session()->pull('god');
        }
        else {
            /* set god session var = user_id */
            session(['god' => Auth::id()]);
        }

        Auth::login($user);
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
        $current_authority = Authority::getAuthorityFromDate($ou_id,Carbon::now(),'manager');
        if($current_authority) {
            $authority = $current_authority->user;
        }
        $users = User::where('organizational_unit_id', $ou_id)->orderBy('name')->get();
        if ($authority <> null) {
            if(!$users->find($authority)) {
                $users->push($authority);
            }}
        return $users;
    }

    public function getAutorityFromOu($ou_id)
    {
        $authority = Authority::getAuthorityFromDate($ou_id,Carbon::now(),'manager');
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
        $users = User::Search($request->get('name'))->permission('Service Request')->orderBy('name','Asc')->paginate(500);
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
            }
            else {
                $user->organizationalunit()->dissociate();
            }
        }

        $user->save();

        if($request->hasFile('photo')){
            $path = $request->file('photo')
                ->storeAs('public',$user->id.'.'.$request->file('photo')->clientExtension());
        }

        $user->givePermissionTo('Users: must change password');
        $user->givePermissionTo('Authorities: view');
        $user->givePermissionTo('Calendar: view');
        $user->givePermissionTo('Requirements: create');
        $user->givePermissionTo('Service Request');
        $user->givePermissionTo('Service Request: fulfillments');
        $user->givePermissionTo('Service Request: fulfillments responsable');


        session()->flash('info', 'El usuario '.$user->name.' ha sido creado.');

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
            }
            else {
                $user->organizationalunit()->dissociate();
            }
        }

        $user->save();

        session()->flash('success', 'El usuario '.$user->name.' ha sido actualizado.');

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

        session()->flash('success', 'El usuario '.$user->name.' ha sido eliminado');

        return redirect()->route('rrhh.users.service_requests.index');
    }


}
