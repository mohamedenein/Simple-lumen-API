<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\Verify_Email;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|array',
            'name.en' => 'required|string|min:4',
            'name.ar' => 'required|string|min:4',
            'phone' => 'numeric|unique:users|digits_between:7,11',
            'email' => 'required_without:phone|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = new User();
        $user->name = json_encode($request->name);
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();


        return response()->json(['message' => 'User register successfully']);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'login'    => 'required',
            'password' => 'required',
        ]);

        $login_type = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $request->merge([$login_type => $request->login]);

        if ($token = Auth::attempt($request->only($login_type, 'password'))) {

            if(Auth::user()->email_verified_at != null || Auth::user()->phone_verified_at != null){

                return response()->json(['token' => $token]);
            }

            return response()->json(['message' => 'Must verified your email or phone number'], 401);
        }

        return response()->json(['error' => 'These credentials do not match our records.'], 401);
    }


    public function SendVerifyEmail()
    {
        $user = Auth::user();
        if($user->email && $user->email_verified_at == null){

            Mail::to($user->email)->send(new Verify_Email($user));
            return response()->json(['message' => 'Verification mail send successfully']);
        }

        return response()->json(['message' => 'your email already verified or you register by phone number only']);
    }


    public function VerifyEmail()
    {
        Auth::user()->email_verified_at = Carbon::now();
        return response()->json(['message' => 'Email verified successfully']);
    }

    
    public function VerifyPhone()
    {
        Auth::user()->Phone_verified_at = Carbon::now();
        return response()->json(['message' => 'Phone number verified successfully']);

    }

}
