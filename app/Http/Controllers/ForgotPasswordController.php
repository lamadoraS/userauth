<?php

namespace App\Http\Controllers;

use App\Mail\forgotPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    //

    public function index(){
        return view('auth.forgotPassword');
    }

    public function verify(Request $request){
            $validatedData = $request->validate([
            'email' => 'required|email',
         ]);

        $user = User::where('email', $validatedData['email'])->first();

        if (!$user) {
            return redirect()->back()->withErrors(['email' => "Email doesn't exist."]);
        }

        $code = rand(100000, 999999);
        $user->update([
            'otp_code' => $code,
        ]);

        Mail::to($user->email)->send(new forgotPasswordMail($code));

        
        return redirect()->to('/forgotModal');


    }

    public function verifyModal(){
        return view('auth.ForgotPasswordModal');
    }

    public function verifyCode(Request $request){

        $data = $request->validate([
            'otp_code' => 'required',
        ]);

        $user = User::where('otp_code', $data['otp_code'])->first();

        if (!$user) {
            return redirect()->back()->withErrors(['otp_code' => 'Invalid OTP.']);
        }

            return redirect()->to('/reset-password');
    }

    public function showResetForm()
    {
        return view('auth.resetPassword');
    }

    public function resetPassword(Request $request)
{
    // Validate the request data
    $validatedData = $request->validate([
        'password' => 'required|string|min:8|confirmed', // Ensure the password is at least 8 characters and matches the confirmation
        'password_confirmation' => 'required|string|min:8', // Ensure confirmation is provided
    ]);

    // Get the user's OTP code from session
    $otpCode = session('otp_code'); // Retrieve OTP code from session

    if (!$otpCode) {
        return redirect()->back()->withErrors(['otp_code' => 'Invalid OTP.']);
    }

    // Find the user by OTP code
    $user = User::where('otp_code', $otpCode)->first();

    if (!$user) {
        return redirect()->back()->withErrors(['otp_code' => 'Invalid OTP.']);
    }

    // Update the user's password
    $user->password = bcrypt($validatedData['password']);
    $user->otp_code = null; // Clear the OTP code
    $user->save();

    // Clear the OTP code from session
    session()->forget('otp_code');

    // Redirect to login page with a success message
    return redirect()->route('login')->with('status', 'Password has been successfully updated. Please log in.');
}

}