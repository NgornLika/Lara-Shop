<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    // Sign Up
    public function Signup() {
        return view('backend.register');
    }
    public function SignupSubmit(Request $request) {
        $name     = $request->name;
        $email    = $request->email;
        $password = Hash::make($request->password);
        $date     = date('Y-m-d H:i:s');
        $file     = $request->file('profile');
        $profile  =  $this->uploadFile($file);

        $user = DB::table('users')->insert([
            'name'       => $name,
            'email'      => $email,
            'password'   => $password,
            'profile'    => $profile,
            'created_at' => $date,
            'updated_at' => $date
        ]); 
        if($user){
            return redirect('signup')->with('message', 'Signup Submit');
        }else{
            return 'Error';
        }
    }
    // Sign In
    public function Signin() {
        return view('backend.login');
    }
    public function SigninSubmit(Request $request){
        $name_email = $request->name_email;
        $password   = $request->password;
        $remember   = $request->remember;

        if(Auth::attempt([
            'name'     => $name_email,
            'password' => $password
        ], $remember)) {
            return redirect('admin');
        }
        elseif(Auth::attempt([
            'email'    => $name_email,
            'password' => $password
        ], $remember)) {
            return redirect('admin');
        }
        else {
            return redirect('signup');
        }
    }

    //Logout
    public function SignOut() {
        Auth::logout();
        return redirect('signin');
    }
    
}
