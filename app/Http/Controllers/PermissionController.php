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
    // public function create()
    // {
    //     //
    //     $roles = Role::all();
    //    return view('permissions.create', compact('roles'));

    // }

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
    // public function edit(Permission $permission)
    // {
    //     //
    //     $roles = Role::all(); // Fetching all roles
    //     $permissionRoles = $permission->roles->pluck('id')->toArray(); // Fetching roles associated with this permission

    //     return view('permissions.edit', compact('permission', 'roles', 'permissionRoles'));

    // }

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
    // public function destroy(Permission $permission)
    // {
    //     //
    //     $permission->delete();
    //     return redirect()->route('permissions.index');
    // }
    public function permissionCreate($id)
    {
        $check = Role::with('permissions')->find($id);
        $permissions = $check->permissions()->where('permission_name', '=', 'create_permission');

        if ($permissions->exists()) {
            $roles = Role::all();
            return view('permissions.create', compact('roles'));
        } else {
            abort(403);
        }
    }
    public function permissionEdit($id, $permissionId)
    {
        // Find the permission by ID
        $permission = Permission::findOrFail($permissionId);
    
        // Get all roles
        $roles = Role::all();
    
        // Find the role of the current user making the request
        $userRole = Role::with('permissions')->find($id);
    
        // Check if the current user's role has the 'update_permission' permission
        $hasPermission = $userRole->permissions()->where('permission_name', 'update_permission');
    
        // If the permission exists, allow the user to proceed with the edit
        if ($hasPermission) {
            // Fetching roles associated with this permission
            $permissionRoles = $permission->roles->pluck('id')->toArray(); 
    
            // Return the view with the necessary data
            return view('permissions.edit', compact('permission', 'roles', 'permissionRoles'));
        } else {
            // If the permission does not exist, abort with a 403 Forbidden response
            abort(403);
        }
    }
    public function permissionDelete($id, $permissionId)
{
   
    // Find the role to be deleted
    $permission = Permission::findOrFail($permissionId);

    // Find the role of the current user making the request
    $currentPermissionRole = Role::with('permissions')->find($id);

    // Check if the current user's role has the 'delete_role' permission
    $permissions = $currentPermissionRole->permissions()->where('permission_name', '=', 'delete_permission');

    // If the permission exists, allow the user to proceed with the deletion
    if ($permissions->exists()) {
        // Delete the role
        $permission->delete();

        // Redirect back with a success message
        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully');
    } else {
        // If the permission does not exist, abort with a 403 Forbidden response
        abort(403, 'You do not have permission to delete roles.');
    }
}
   
}
