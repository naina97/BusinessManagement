<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index(Request $requuest)
    {
        return view('auth.login');
    }
    public function store(Request $request)
    {
        $validationRule    = [];
        $validationMessage = [];

        $validationRule = [
            'email'    => 'required|email',
            'password' => 'required',
        ];

        $validationMessage = [
            'email.required'    => 'Email is required',
            'email.email'       => 'Enter a valid email',
            'password.required' => 'Password is required',
            
        ];
        $validatedData     = $request->validate($validationRule, $validationMessage);
        // $remember_me = $request->has('remember_me');

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            if (!Auth::user()->email_verified_at) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Please verify your email.');
            }
            return redirect()->route('dashboard')->with('success', 'Login successful');
        } else {
            return redirect()->route('login')->with('error', 'Invalid email or password');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
        // if (Auth::guard('web')->logout())
        // {
        //     return redirect()->route('login')->with('success', 'Logout success');
        // }
        
    }
    //register function
    public function showRegister()
    {
        return view('auth.register');
    }

    public function storeRegister(Request $request)
    {
        $validationRule    = [];
        $validationMessage = [];

        $validationRule = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ];

        $validationMessage = [
            'first_name.required'  => "First name is required",
            'last_name.required' => "Last name required",
            'email.required'  => "Email is required",
            'email.email' => "Please enter a valid email address",
            'email.unique' => "This email is already registered. Please try another",
            'password.required' => "Password is required",
            'password.min' => "Password must be at least 6 characters",
            
        ];
        $validatedData     = $request->validate($validationRule, $validationMessage);
        try
        {
          
            $user = new User();
    
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->email_verified_at = now(); // Explicitly set to null
            if ($user->save())
            {
                DB::commit();
                $status       = 'success';
                $message_text = 'Registration successful';
            }
            else
            {
                $status       = 'error';
                $message_text = 'Registration failed';
            }
        }
        catch (Throwable $e)
        {
            $status       = 'error';
            $message_text = 'Registration failed '. $e->getMessage();

        }
        return redirect()->route('login')->with($status, $message_text);
    }
}
