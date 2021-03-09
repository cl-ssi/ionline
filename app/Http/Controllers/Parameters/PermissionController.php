<?php

namespace App\Http\Controllers\Parameters;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index($guard)
    {
        
        $permissions = Permission::where('guard_name',$guard)->OrderBy('name')->get();
        $roles = Role::All();
        return view('parameters.permissions.index', compact('permissions','roles','guard'));
    }

    public function create($guard)
    {
                        
        return view('parameters.permissions.create',compact('guard'));
    }


    public function store(Request $request)
    {
        $permission = new Permission($request->All());
        $permission->save();

        return redirect()->route('parameters.permissions.index',$request->guard_name);
    }

    public function edit(Permission $permission)
    {
        return view('parameters.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $permission->fill($request->all());
        $permission->save();
        session()->flash('success', 'Permiso: '.$permission->name.' ha sido actualizado.');

        return redirect()->route('parameters.permissions.index',$permission->guard_name);
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        session()->flash('success', 'Permiso: '.$permission->name.' ha sido eliminado.');

        return redirect()->route('parameters.permissions.index',$permission->guard_name);
    }
}
