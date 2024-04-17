<?php

namespace App\Http\Controllers\Rem;

use App\Models\Rem\UserRem;
use App\Http\Controllers\Controller;
use App\Models\Establishment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class UserRemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $usersRem = UserRem::join('establishments', 'rem_users.establishment_id', '=', 'establishments.id')
        //     ->whereNull('rem_users.deleted_at')
        //     ->orderBy('establishments.name', 'ASC')
        //     ->get();
        $usersRem = UserRem::whereNull('deleted_at')->get();


        return view('rem.user.index', compact('usersRem'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $establishments = Establishment::orderBy('name', 'ASC')->get();
        $users = User::orderBy('name', 'ASC')->get();

        return view('rem.user.create', compact('establishments', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $establishments = Establishment::whereIn('id', $request->establishment_id)->get();
        foreach ($establishments as $establishment) {
            // Verificar si el usuario ya está asignado al establecimiento
            $existingUserRem = UserRem::where('user_id', $request->user_id)
                ->where('establishment_id', $establishment->id)
                ->first();

            if ($existingUserRem) {
                // Eliminar al usuario asignado al establecimiento
                $existingUserRem->delete();
            }

            $userRem = new UserRem([
                'user_id' => $request->user_id,
                'establishment_id' => $establishment->id
            ]);
            $userRem->save();
            $userRem->user->givePermissionTo('Rem: user');
        }

        session()->flash('info', 'El usuario ha sido asignado a los establecimientos seleccionados.');
        return redirect()->route('rem.users.index');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rem\UserRem  $userRem
     * @return \Illuminate\Http\Response
     */
    public function show(UserRem $userRem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rem\UserRem  $userRem
     * @return \Illuminate\Http\Response
     */
    public function edit(UserRem $userRem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRemRequest  $request
     * @param  \App\Models\Rem\UserRem  $userRem
     * @return \Illuminate\Http\Response
     */
    public function update(UserRem $request, UserRem $userRem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rem\UserRem  $userRem
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userRem = UserRem::findOrFail($id);
        //$userRem->user->revokePermissionTo(['Rem: user']);
        $userRem->delete();
        session()->flash('success', 'Usuario Eliminado para cargar al Establecimiento: ' . $userRem->establishment->name . ' de sus funciones como REM');
        return redirect()->route('rem.users.index');
    }
}
