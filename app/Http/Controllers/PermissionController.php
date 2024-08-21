<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $permission =  Permission::simplePaginate(5); 
        return view('permissions.index', compact('permission'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $roles = Role::all();
       return view('permissions.create', compact('roles'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        // dd($request->all());
        $data = $request->validate([
            'permission_name'=> 'required',
          ]);

          $options = [];
          foreach($request['role_id'] as $i => $role){
           
            $options[$i] = $role;
          }
        //   dd($options);

       
         $permission =  Permission::create($data);
         $permission->roles()->attach($options);
        //   Permission::with('roles')->whereIn('role_id' , $request['role_id']);
        //   Role::with('permissions')->whereIn('permission_id', $permissionId);
          return redirect()->route('permissions.index');
    }



    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        //
        $roles = Role::all(); // Fetching all roles
        $permissionRoles = $permission->roles->pluck('id')->toArray(); // Fetching roles associated with this permission

        return view('permissions.edit', compact('permission', 'roles', 'permissionRoles'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        //
        $data = $request->validate([
            'permission_name' => 'required',
        ]);

        $permission->update($data);

        // Syncing roles with the permission
        $permission->roles()->sync($request->input('role_id', []));

        return redirect()->route('permissions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        //
        $permission->delete();
        return redirect()->route('permissions.index');
    }
}
