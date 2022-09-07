<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //
    public function register(RegisterRequest $request){


        $user = User::create($request->validated());

        return $user->createToken($request->device_name)->plainTextToken;

    }

    public function login(LoginRequest $request){

        $user = User::where('email', $request->email)->first();
 
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken($request->device_name)->plainTextToken;

    }

    public function logout(Request $request){

        // $user = Auth::user();
        $user = User::where('email', $request->email)->first();
        $user->tokens()->delete();

        return response()->noContent();

    }
}
