<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\NewUserMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    //
    public function createUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users,email',
                'phone_number'=> 'required|digits:11',
                'image'=> 'nullable|image|mimes:jpg,png,jpeg|max:2048', // Validate the image
                 'password' => 'required|string|min:8',
            ]);

           
                
            // if($validateUser->fails()){
            //     return response()->json([
            //         'status' => false,
            //         'message' => 'Validation error',
            //         'errors' => $validateUser->errors()
            //     ], 401);
            // }

          
            // Handle the image upload if it exists
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('profile_pictures', 'public');
            }
           

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone_number'=> $request->phone_number,
                'password' => Hash::make($request->input('password')),
                'role_id' => 4,
                'image' => $imagePath // Save the image path to the database
            ]);


            Mail::to($user->email)->send(new NewUserMail($user, $password));

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
