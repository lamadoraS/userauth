<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $id;
    public function index()
    {
        //
        $role =  Role::simplePaginate(5); 
        return view('roles.index', compact('role'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //

    //     // Pass the roles to the view
    //     return view('roles.create');

    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        //
        $data = $request->validate([
            'role_name'=> 'required',
          ]);

          Role::create($data);
          return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Role $role)
    // {
    //     //
    //     return view('roles.edit', compact('role'));
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //
        $role->update($request->all());

        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Role $role)
    // {
    //     //
    //     $role->delete();
    //      return redirect()->route('roles.index');
    // }

    public function roleCreate($id)
    {

        $check = Role::with('permissions')->find($id);
        $permissions = $check->permissions()->where('permission_name','=', 'create_role');

        if($permissions->exists()){
            $roles = Role::all();
            return view('roles.create', compact('roles'));
        }else{
            abort(403);
        }
 
    }

    public function roleEdit($id, $roleId){

        $role = Role::findOrFail($roleId);
    
        // Get all roles
        $roles = Role::all();
    
        // Find the role of the current user making the request
        $check = Role::with('permissions')->find($id);
    
        // Check if the current user's role has the 'update_user' permission
        $permissions = $check->permissions()->where('permission_name', '=', 'update_role');
    
        // If the permission exists, allow the user to proceed with the edit
        if ($permissions->exists()) {
            return view('roles.edit', compact('role', 'roles'));
        } else {
            // If the permission does not exist, abort with a 403 Forbidden response
            abort(403);
        }
    }
    public function roleDelete($id, $roleId)
    {
    
        // Find the role to be deleted
        $role = Role::findOrFail($roleId);

        // Find the role of the current user making the request
        $currentUserRole = Role::with('permissions')->find($id);

        // Check if the current user's role has the 'delete_role' permission
        $permissions = $currentUserRole->permissions()->where('permission_name', '=', 'delete_role');

        // If the permission exists, allow the user to proceed with the deletion
        if ($permissions->exists()) {
            // Delete the role
            $role->delete();

            // Redirect back with a success message
            return redirect()->route('roles.index')->with('success', 'Role deleted successfully');
        } else {
            // If the permission does not exist, abort with a 403 Forbidden response
            abort(403, 'You do not have permission to delete roles.');
        }
    }

}
