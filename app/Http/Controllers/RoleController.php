<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $role =  Role::simplePaginate(5); 
        return view('roles.index', compact('role'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        // Pass the roles to the view
        return view('roles.create');

    }

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
    public function edit(Role $role)
    {
        //
        return view('roles.edit', compact('role'));
    }

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
    public function destroy(Role $role)
    {
        //
        $role->delete();
         return redirect()->route('roles.index');
    }

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

    
}
