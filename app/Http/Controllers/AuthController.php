<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'full_name'             => 'required|string|max:255',
            'username'              => 'required|string|max:255|unique:users,username',
            'password'              => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
            'email'                 => 'required|string|email|max:255|unique:users,email',
            'country_code'          => 'required|string|exists:countries,code'
        ]);

        if($validation->fails()){
            return response()->json([
                'error'     => true,
                'message'   => $validation->errors()
            ]);
        }

        $user = User::create($request->only(['full_name','username','email','country_code'])+[
            'password'  => Hash::make($request->password)
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'User Created Successfully',
            'data'      => $user
        ]);
    }

    public function login(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'email'     => 'required|email|exists:users,email',
            'password'  => 'required'
        ]);

        if($validation->fails()){
            return response()->json([
                'error'     => true,
                'message'   => $validation->errors()
            ]);
        }

        if(Auth::attempt(['email' => $request->email,'password' => $request->password])){
            $user = auth()->user();
            return response()->json([
                'success'   => true,
                'message'   => 'Login Successfull',
                'token'     => $user->createToken('auth_token')->plainTextToken
            ]);
        }else{
            return response()->json([
                'error'     => true,
                'message'   => 'Password Incorrect'
            ]);
        }
    }
}
