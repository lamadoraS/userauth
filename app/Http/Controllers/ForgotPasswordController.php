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

        // Mail::to($user->email)->send(new forgotPasswordMail($code));

        
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
        dd($request->all());
    }
}