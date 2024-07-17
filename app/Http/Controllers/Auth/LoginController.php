<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

            if (!$user || !Hash::check($credentials['password'], $user->password)) {
                return response()->json([
                    'message' => 'Invalid Credentials',
                ]);
            }
            $code = rand(100000, 999999);
            $updateResult = $user->update([
                'otp_code' => $code,
            ]);

            // Http::asForm()->post('https://api.semaphore.co/api/v4/messages', [
            //    'apikey' => env('SEMAPHORE_API_KEY'),
            //    'number' => '09631157992', 
            //    'message' => 'This is your OTP Code: ' . $code,
            // ]);


            if ($updateResult) {
                return response()->json([
                    'status' => true,
                    'message' => 'OTP sent successfully',
                    'token' => $user->createToken("API TOKEN")->plainTextToken,
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

            return response()->json([
                'status' => true,
                'message' => 'OTP Verified Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }   
    public function resendOtp(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json(['status' => false, 'message' => 'User not authenticated.'], 401);
            }

            // Generate a new OTP
            $otpCode = rand(100000, 999999);

            // Update the OTP in the database
            $user->update([
                'otp_code' => $otpCode,
            ]);

            // Http::asForm()->post('https://api.semaphore.co/api/v4/messages', [
            //    'apikey' => env('SEMAPHORE_API_KEY'),
            //    'number' => '09631157992', 
            //    'message' => 'This is your OTP Code: ' . $otpCode,
            // ]);

            return response()->json(['status' => true, 'message' => 'New OTP sent.', 'otp_code' => $otpCode], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}

