<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    //Show Register
    public function showRegister(){
        return view('auth.register');
    }

    //Save new  user data (Register)
    public function save(Request $request){
        $validated = $request->validate([
            'name'=>'required|string|min:5|max:50',
            'email'=>'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],

        // Hash the password before saving
        'password' => Hash::make($validated['password']),
    ]); 
       
         Auth::login($user);

        $request->session()->regenerate();

        return redirect('/dashboard');
        
    }

    //Show Login
    public function showLogin(){
        return view('auth.login');
    }

    //check Login
    public function check(Request $request){
         $validated = $request->validate([
            'email'=>'required|email',
            'password' => 'required|string|min:8',
        ]);
        $users = User::all();
    }

    // Show Dashboard
    public function showHomePage()
    {
        return view('dashboard');
    }


    public function login(Request $request){
        $credentials = $request->validate([
            'email'=>'required|email',
            'password' => 'required|string|min:8',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect('/dashboard');
        }
        return back()
                ->withErrors([
                    'email' => 'These credentials do not match our records.',
                ])
                ->onlyInput('email');
    }

     public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

}
