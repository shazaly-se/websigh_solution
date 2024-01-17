<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Auth;
use Session;
class AuthController extends Controller
{
    public function showregister(){
        return view("auth.register");
    }

    public function register(RegisterRequest $request) 
    {
     
        $user = User::create($request->validated());

        

        auth()->login($user);

        return redirect('/')->with('success', "Account successfully registered.");
    }

    public function showlogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

       

        if(Auth::attempt($credentials))
        {
            $request->session()->regenerate();
            return redirect('/')
                ->withSuccess('You have successfully logged in!');
        }

        return back()->withErrors([
            'email' => 'Your provided credentials do not match in our records.',
        ])->onlyInput('email');

    }

    public function logout()
    {
        Session::flush();
        
        Auth::logout();

        return redirect('/login');
    }

}
