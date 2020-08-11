<?php

namespace App\Http\Controllers\Rrhh;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $roles = Role::All();
        $permissions = Permission::OrderBy('name')->get();

        return view('rrhh.role.manage')
            ->withUser($user)
            ->withRoles($roles)
            ->withPermissions($permissions);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function attach(Request $request, User $user)
    {
        $user->syncRoles      ( is_array($request->input('roles'))       ? $request->input('roles')       : array() );
        $user->syncPermissions( is_array($request->input('permissions')) ? $request->input('permissions') : array() );

        session()->flash('success', 'Se actualizaron los roles al usuario '.$user->name.'.');

        return redirect()->route('rrhh.roles.index', $user->id);
    }
}
