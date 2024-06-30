<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    public function registerPage(){
        return view('register');
    }

    public function registerSubmit(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();
        $data['password'] = Hash::make($request->password);
        $user = User::create($data);

        return redirect()->route('login-page')->with('success', 'Register successful!');
    }

    public function loginPage(){
        return view('login');
    }

    public function loginSubmit(Request $request){

        $validator = Validator::make($request->all(), [
            'user' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('user', 'password');
        if (Auth::attempt(['email' => $credentials['user'], 'password' => $credentials['password']]) ||
            Auth::attempt(['username' => $credentials['user'], 'password' => $credentials['password']])) {
            if (Auth::user()->type == "admin") {
                return redirect()->route('admin')->with('success', 'Admin login success');
            } else {
                return redirect()->route('home')->with('success', 'Login success');
            }

        }

        return redirect()->back()->withErrors(['user' => 'invalid username email or password','password' => 'invalid username email or password'])->withInput();
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login-page');
    }
}
