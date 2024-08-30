<?php

namespace App\Http\Controllers;

use App\Mail\generatedTokenMail;
use App\Mail\NewUserMail;
use App\Models\AuditLog;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Token;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public $id;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::with('roles')->simplePaginate(5);

        return view('users.index', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'role_id' => 'required',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone_number' => 'required|digits:11',
            'password' => 'required'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('profile_pictures', 'public');
            $data['image'] = $imagePath;
        } else {
            $data['image'] = null;
        }

        $user = User::create($data);
        $token = $user->createToken("API TOKEN")->plainTextToken;

        // Determine the expiration date based on the user's role
        $expirationDate = null;
        if ($user->role_id !== 1) {
            $expirationDate = now()->addDays(5);
        }

        // Save the token and expiration date to the database
        Token::create([
            'user_id' => $user->id,
            'token_value' => $token,
            'expires_at' => $expirationDate,
        ]);

        // Mail::to($user->email)->send(new NewUserMail($user, $data['password']));

        AuditLog::create([
            'user_id' => $user->id,
            'action' => 'User ' . $user->first_name . ' ' . $user->last_name . ' has been Created',
            'timestamp' => now(),
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
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

        AuditLog::create([
            'user_id' => $user->id,
            'action' => 'User ' . $user->first_name . ' ' . $user->last_name . ' has been Updated',
            'timestamp' => now(),
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function userCreate($id)
    {
        $check = Role::with('permissions')->find($id);
        $permissions = $check->permissions()->where('permission_name', '=', 'create_user');

        if ($permissions->exists()) {
            $roles = Role::all();
            return view('users.create', compact('roles'));
        } else {
            abort(403);
        }
    }

    public function userEdit($id, $userId)
    {
        // Find the user to be edited
        $user = User::findOrFail($userId);

        // Get all roles
        $roles = Role::all();

        // Find the role of the current user making the request
        $check = Role::with('permissions')->find($id);

        // Check if the current user's role has the 'update_user' permission
        $permissions = $check->permissions()->where('permission_name', '=', 'update_user');

        // If the permission exists, allow the user to proceed with the edit
        if ($permissions->exists()) {
            return view('users.edit', compact('user', 'roles'));
        } else {
            // If the permission does not exist, abort with a 403 Forbidden response
            abort(403);
        }
    }

    public function userDelete($id, $userId)
    {
        // Find the user to be deleted
        $user = User::findOrFail($userId);

        // Find the role of the current user making the request
        $check = Role::with('permissions')->find($id);

        // Check if the current user's role has the 'delete_user' permission
        $permissions = $check->permissions()->where('permission_name', '=', 'delete_user');

        // If the permission exists, allow the user to proceed with the deletion
        if ($permissions->exists()) {
            // Delete the user
            $user->delete();
            AuditLog::create([
                'user_id' => $userId,
                'action' => 'User ' . $user->first_name . ' ' . $user->last_name . ' has been Deleted',
                'timestamp' => now(),
            ]);

            // Redirect back with a success message
            return redirect()->route('users.index')->with('success', 'User deleted successfully');
        } else {
            // If the permission does not exist, abort with a 403 Forbidden response
            abort(403, 'You do not have permission to delete users.');
        }
    }

    public function userShow($id, $userId)
    {
        // Find the role of the current user making the request
        $role = Role::with('permissions')->find($id);

        // Check if the current user's role has the 'show_user' permission
        $permissions = $role->permissions()->where('permission_name', '=', 'show_user');

        // If the permission exists, allow the user to proceed with showing the user
        if ($permissions->exists()) {
            // Find the user to be shown
            $user = User::findOrFail($userId);

            // Pass the user to the view
            return view('users.show', compact('user'));
        } else {
            // If the permission does not exist, abort with a 403 Forbidden response
            abort(403, 'You do not have permission to view user details.');
        }
    }

    public function generate($id)
    {
        $user = User::where('id', $id)->first();

        $token = $user->createToken("API TOKEN")->plainTextToken;

        // Determine the expiration date based on the user's role
        $expirationDate = $user->role_id === 1 ? null : now()->addDays(5);

        // Save the token and expiration date to the database
        Token::create([
            'user_id' => $user->id,
            'token_value' => $token,
            'expires_at' => $expirationDate, // Add the expiration date
        ]);

        AuditLog::create([
            'user_id' => $user->id,
            'action' => $user->first_name . ' ' . $user->last_name . ' new token updated',
            'timestamp' => now(),
        ]);

        // Mail::to($user->email)->send(new generatedTokenMail($user));

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }
}
