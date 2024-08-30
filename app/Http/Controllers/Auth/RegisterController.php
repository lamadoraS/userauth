<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\NewUserMail;
use App\Models\AuditLog;
use App\Models\Token;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class RegisterController extends Controller
{
    public function createUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users,email',
                'phone_number' => 'required|digits:11',
                'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', 
                'password' => 'required|string|min:8',
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('profile_pictures', 'public');
            }

            $password = $request->input('password');

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => $password,
                'role_id' => 4, 
                'image' => $imagePath 
            ]);

            AuditLog::create([
                'user_id' => $user->id,
                'action' => 'User ' . $user->first_name . ' ' . $user->last_name . ' has registered their account',
                'timestamp' => now(),
            ]);

           
            $token = $user->createToken("API TOKEN")->plainTextToken;

            Token::create([
                'user_id' => $user->id,
                'token_value' => $token,
                'expires_at' => Carbon::now()->addDays(5)
            ]);

            
            Mail::to($user->email)->send(new NewUserMail($user, $password));

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
