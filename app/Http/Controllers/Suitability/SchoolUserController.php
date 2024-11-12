<?php

namespace App\Http\Controllers\Suitability;

use App\Models\Suitability\SchoolUser;
use App\Models\Suitability\School;
use App\Models\User;
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
    public function indexAdmin(Request $request)
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
        $users = SchoolUser::with('user')->get()->sortBy(function($schoolUser) {
            return $schoolUser->user->name;
        });
        $schools = School::orderBy('name')->get();
        $communes = Commune::orderBy('name')->get();
    
        return view('suitability.users.index', compact('adminUsers', 'users', 'schools', 'communes', 'request'));
    }

    public function indexUser(Request $request)
    {
        $schools = School::orderBy('name')->get();
        $query = UserExternal::whereHas('psiRequests');
    
        // Aplicar filtros
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }
    
        // Filtrar por colegio si se selecciona uno
        if ($request->filled('school_id')) {
            $query->whereHas('psiRequests.school', function ($q) use ($request) {
                $q->where('id', $request->input('school_id'));
            });
        }
    
        $users = $query->paginate(100);
    
        return view('suitability.users.index-user', compact('users', 'schools', 'request'));
    }

    public function convertAdmin(Request $request)
    {
        // Validación de los datos
        $request->validate([
            'user_external_id' => 'required|exists:users_external,id',
            'school_id' => 'required|exists:schools,id',
        ]);

        // Creación del registro SchoolUser
        $schoolUser = new SchoolUser();
        $schoolUser->user_external_id = $request->user_external_id;
        $schoolUser->school_id = $request->school_id;
        $schoolUser->admin = 1;
        $schoolUser->save();

        session()->flash('success', 'Usuario asignado como administrador del colegio exitosamente');

        return redirect()->route('suitability.users.indexAdmin');
    }

    
    
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('suitability.users.create');        
    }

    public function createUserAdmin()
    {
        //
        $schools = School::orderBy('name')->get();
        return view('suitability.users.create-admin', compact('schools'));
        
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

    public function storeUserAdmin(Request $request)
    {
        
        $user = UserExternal::updateOrCreate(
            ['id' => $request->id],
            $request->all()
        );
    
        
        if ($user->wasRecentlyCreated) {
            session()->flash('success', 'Usuario asignado al colegio correctamente.');
        } else {
            session()->flash('info', 'Datos del usuario actualizado correctamente.');
        }
    
        
        SchoolUser::updateOrCreate(
            ['user_external_id' => $user->id, 'school_id' => $request->school_id], // Condiciones de búsqueda
            ['admin' => 1] 
        );
    
        // Asigna el permiso de administrador al usuario
        $user->givePermissionTo('Suitability: admin');
    
        return redirect()->route('suitability.users.indexAdmin');
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
    public function editUser(UserExternal $userExternal)
    {
        return view('suitability.users.edit', ['userExternal' => $userExternal]);  
        
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SchoolUser  $schoolUser
     * @return \Illuminate\Http\Response
     */
    public function updateUser(Request $request, UserExternal $userExternal)
    {
        $userExternal->fill($request->all());
        $userExternal->save();
        session()->flash('success', 'Usuario Externo actualizado exitosamente');
        return redirect()->route('suitability.users.indexUser');
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

    public function editUserAdmin(UserExternal $userExternal)
    {
        return view('suitability.users.edit-admin', ['user' => $userExternal]);
    }

    public function updateUserAdmin(Request $request, UserExternal $userExternal)
    {
        $userExternal->fill($request->all());
        $userExternal->save();

        session()->flash('success', 'Usuario Externo actualizado exitosamente');
        return redirect()->route('suitability.users.indexAdmin');
    }


}
