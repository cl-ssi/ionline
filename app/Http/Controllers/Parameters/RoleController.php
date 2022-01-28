<?php

namespace App\Http\Controllers\Parameters;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::All();

        return view('parameters.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::All();
        return view('parameters.roles.create',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* Almaceno el array de permisos en una variable, si no viene ningún
         * permisos seleccionado entonces dejo un array vacio para que no
         * de error en la asiganción de permisos al rol */
        $permissions = is_array($request->input('permissions')) ? $request->input('permissions') : array();

        /* Tengo que eliminar el array de permisos del request para poder crear el rol*/
        $request->request->remove('permissions');

        $role = Role::create($request->All());

        $role->givePermissionTo($permissions);

        session()->flash('info', 'El Rol '.$role->name.' ha sido creado.');

        return redirect()->route('parameters.roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('name')->where('guard_name','web')->pluck('id','name');
        //dd($permissions);
        return view('parameters.roles.edit', compact('role','permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        /* Almaceno el array de permisos en una variable, si no viene ningún
         * permisos seleccionado entonces dejo un array vacio para que no
         * de error en la asiganción de permisos al rol */
        $permissions = is_array($request->input('permissions')) ? $request->input('permissions') : array();

        /* Tengo que eliminar el array de permisos del request para poder crear el rol*/
        $request->request->remove('permissions');

        $role->fill($request->all());
        $role->save();

        $role->syncPermissions($permissions);

        session()->flash('success', 'Rol: '.$role->name.' ha sido actualizado.');

        return redirect()->route('parameters.roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        session()->flash('success', 'Rol: '.$role->name.' ha sido eliminado.');

        $role->delete();

        return redirect()->route('parameters.roles.index');
    }
}
