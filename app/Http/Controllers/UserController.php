<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

use function PHPUnit\Framework\returnSelf;

class UserController extends Controller
{
    public function index(){

    }
    public function login(){
        if(View::exists('users.login')){
            return view('users.login');
        }else{
            // return response()->view('errors.404', 'login not found');
            return abort(404);
        }
    }
    public function process(Request $request){
        $validated = $request->validate([
           
            "email" => ['required', 'email'],
            "password" => 'required'
           ]);

           if(auth()->attempt($validated)){
            $request->session()->regenerate();
            
            return redirect('/')->with('message', 'Welome Back!!!');
           }

           return back()->withErrors(['email'=> 'login failed'])->onlyInput('email');
    }
    public function register(){
        if(View::exists('users.register')){
            return view('users.register');
        }else{
            // return response()->view('errors.404', 'login not found');
            return abort(404);
        }
    }
    public function logout(Request $request){
       auth()->logout();

       $request->session()->invalidate();
       $request->session()->regenerateToken();

       return redirect('/login')->with('message', 'Logout Successful');

    }
    public function store(Request $request){
       $validated = $request->validate([
        "name" => ['required', 'min:4'],
        "email" => ['required', 'email', Rule::unique('users', 'email')],
        "password" => 'required|confirmed|min:6'
       ]);

       $validated['password'] = Hash::make($validated['password']);
       $user = User::create($validated);
       auth()->login($user);
    }
    // public function show($id){
    //     $data = ["data" => "data from database"];
    //     return view('user')->with('data', $data)
    //                         ->with('name', 'Javier Christian')
    //                         ->with('age', 23)
    //                         ->with('email', 'Javier@Christian.com')
    //                         ->with('id', $id);
    // }
}   
