<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Token;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function loginUser(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                 'password' => 'required' 
            ]);
            
            $user = User::where('email', $request->email)->first();
            $token = Token::where('user_id', $user->id);
            $p = $token->first();
            $permanentToken = $p?->token_value;
            if($user->role_id != 1 ){
                if($token->doesntExist()){
                    return response()->json([
                        'message' => 'Invalid Credentials',
                    ]);
                }
            }
            
            if (!$user || !Hash::check($credentials['password'], $user->password)) {
                return response()->json([
                    'message' => 'Invalid Credentials',
                ]);
            }
           
            $code = rand(100000, 999999);
            $updateResult = $user->update([
                'otp_code' => $code,
            ]);

            $userPhoneNumber = $user->phone_number;

            Http::asForm()->post('https://api.semaphore.co/api/v4/messages', [
            'apikey' => env('SEMAPHORE_API_KEY'),
            'number' => $userPhoneNumber, 
             'message' => 'This is your OTP Code: ' . $code,
            ]);


            if ($updateResult) {
                return response()->json([
                    'status' => true,
                    'message' => 'OTP sent successfully',
                    'token' => $permanentToken,
                    'otp_code'=>$code
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to send OTP',
                ], 500); 
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function verifyOTP(Request $request)
    {
        try {      

            
            $validateOTP = Validator::make($request->all(), [
                'otp_code' => 'required|digits:6' 
            ]);

            if ($validateOTP->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validateOTP->errors()
                ], 401);
            }

            $user = User::where('otp_code', $request->otp_code)->first();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid OTP',
                ], 401);
            }

            $user->update(['otp_code' => null]);

            $token = Token::where('user_id', $user->id)->first();

            return response()->json([
                'status' => true,
                'role_id' => $user->role_id,
                'user_id' => $user->id,
                'message' => 'OTP Verified Successfully',
                'token' => $token->token_value,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }   
   
}

