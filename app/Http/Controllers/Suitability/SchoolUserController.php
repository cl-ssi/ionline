<?php

namespace App\Http\Controllers\Suitability;

use App\Models\Suitability\SchoolUser;
use App\Models\Suitability\School;
use App\User;
use App\Models\UserExternal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Commune;

class SchoolUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $adminUsersQuery = SchoolUser::with(['user', 'school.commune'])
            ->where('admin', 1);
    
        if ($request->filled('school_id')) {
            $adminUsersQuery->where('school_id', $request->input('school_id'));
        }
    
        if ($request->filled('user_external_id')) {
            $adminUsersQuery->where('user_external_id', $request->input('user_external_id'));
        }
    
        if ($request->filled('commune_id')) {
            $adminUsersQuery->whereHas('school.commune', function ($query) use ($request) {
                $query->where('id', $request->input('commune_id'));
            });
        }
    
        $adminUsers = $adminUsersQuery->get();
        $users = UserExternal::orderBy('name')->get();
        $schools = School::orderBy('name')->get();
        $communes = Commune::orderBy('name')->get();
    
        return view('suitability.users.index', compact('adminUsers', 'users', 'schools', 'communes'));
    }
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('suitability.users.create');
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
        $school_user = new SchoolUser($request->All());
        $school_user->admin = 1;
        $school_user->save();
        $user = UserExternal::find($request->user_external_id);
        $user->givePermissionTo('Suitability: admin');

        session()->flash('success', 'Se Asigno al Usuario Externo como Administrador al colegio');
        return redirect()->back();
    }

    public function storeuser(Request $request)
    {
        //
        //$user = new User($request->All());
        $buscador = UserExternal::find($request->id);
        if ($buscador)
        {
            session()->flash('danger', 'Usuario ya se encontraba ingresado como Usuario Externo');
        }
        else
        {
        $user = new UserExternal($request->All());
        //$user->email_personal = $request->email;
        //$user->external = 1;
        //$user->givePermissionTo('Suitability: admin');
        $user->save();
        session()->flash('success', 'Se Asigno al Usuario al colegio');
        }
        return redirect()->route('suitability.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SchoolUser  $schoolUser
     * @return \Illuminate\Http\Response
     */
    public function show(SchoolUser $schoolUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SchoolUser  $schoolUser
     * @return \Illuminate\Http\Response
     */
    public function edit(SchoolUser $schoolUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SchoolUser  $schoolUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SchoolUser $schoolUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SchoolUser  $schoolUser
     * @return \Illuminate\Http\Response
     */
    public function destroy($schoolUser)
    {
        
        $schooluser = SchoolUser::find($schoolUser);
        $schooluser->delete();
        session()->flash('success', 'Usuario Eliminado como Administrador Exitosamente');        
        return redirect()->back();

    }
}
