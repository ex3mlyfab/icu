<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    //
    public function index()
    {
        return view('pages.permission');
    }

    public function assignRole()
    {
        return view('pages.assign-role');
    }
    public function storePermissions(Request $request)
    {
        $permissions = $request->permissions;
        foreach($permissions as $permission){
            Permission::create(['name' => $permission]);
        }
        // $role = $request->role;

        return response(['message'=> 'Permissions Added successfully'], 200);
    }
    public function getPermissions(Request $request)
    {
        $perPage = $request->input('per_page', 21);
        $search = $request->input('search');

        $query = Permission::query();
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        if($request->page == "all"){
            $permissions = $query->all();
        }else{
        $permissions = $query->paginate($perPage);
        }

        return response()->json($permissions);

    }

    public function createRole(Request $request)
    {
        $role = $request->name;
        $permissions = $request->permissions;
        $role = Role::create(['name' => $role,
        'guard_name' => 'web']);
        // $role = Role::find($role);
        $role->syncPermissions($permissions);
        return redirect()->route('role.assign');
    }

    public function getRoles()
    {
        $roles = Role::all();
        return response($roles, 200);
    }
    public function updateRole(Request $request)
    {
        $role = $request->role;
        $permissions = $request->permissions;
        $role = Role::find($role);
        $role->syncPermissions($permissions);
        return response($role, 200);
    }
    public function createRolePage()
    {
        return view('pages.create-role');
    }

    public function getallPermission()
    {
        $permissions = Permission::all();
        return response($permissions, 200);
    }
}
