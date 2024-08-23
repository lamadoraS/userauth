<?php

namespace App\Http\Controllers;

use App\Mail\NewUserMail;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user =  User::with('roles')->simplePaginate(5); 
        return view('users.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        // dd();
        // dd($request->all());
        $roles = Role::all();

        // Pass the roles to the view
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
      $data = $request->validate([
        'role_id'=> 'required',
        'first_name'=> 'required|string|max:255',
        'last_name'=> 'required|string|max:255',
        'email'=> 'required|string|email|max:255|unique:users,email',
        'phone_number'=> 'required|digits:11',
        'password'=> 'required'

      ]);
    if($request->hasFile('image')){
        $image = $request->file('image');
        $imagePath = $image->store('profile_pictures', 'public');
        $data['image'] = $imagePath; 

    }else{
        $data['image'] = null;
    }

     

     $user =  User::create($data);

    //   Mail::to($user->email)->send(new NewUserMail($user, $data['password']));


    return redirect()->route('users.index')->with('success', 'User created successfully.');


    }


    /**
     * Display the specified resource.
     */
        public function show($id)
    {
        $user = User::with('roles')->findOrFail($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
        $roles = Role::all();

    // Pass the user and the roles to the view
    return view('users.edit', compact('user', 'roles'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
{
    // Validate the request including the image
    $validatedData = $request->validate([ 
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation rules as needed
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'phone_number' => 'required|digits:11',
    ]);

    // Handle image upload
    if ($request->hasFile('image')) {
        // Delete the old image if it exists
        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }

        // Store the new image
        $path = $request->file('image')->store('profile_pictures', 'public');
        $validatedData['image'] = $path;
    }

    // Update the user with the validated data
    $user->update($validatedData);

    return redirect()->route('users.index')->with('success', 'User updated successfully.');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
         $user->delete();
         return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }

    public function userCreate($id)
    {

        $check = Role::with('permissions')->find($id);
        $permissions = $check->permissions()->where('permission_name','=', 'create_user');

        if($permissions->exists()){
            $roles = Role::all();
            return view('users.create', compact('roles'));
        }else{
            abort(403);
        }
 
       
        
    }

    public function userEdit($id){
        
    }

           // dd($permissions);
       
        // dd($permissions[2]->permission_name);

        // foreach($permissions as $permission){
        //     // dd($permission->permission_name);
        //     // if($permission->permission_name === "create_user"){
        //     //     $roles = Role::all();
        //     //     return view('users.create', compact('roles'));
        //     // }
        //     //    return abort(403);
            
        // }
        // dd);
        // foreach($check->permission()->get())
        // if($check->permissions()->exists()){
        //     $roles = Role::all();

        //     // Pass the roles to the view
          
        // }else{
        //     abort(403);
        // }
        
    
}