<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request)
    {
        $user = User::create([
            'name' => sanitize($request->name),
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->roles()->attach(Role::where('name', config('constants.roles.user'))->first());

        auth()->login($user);

        return redirect()->route('dashboard');
    }

    public function apiRegister(RegisterRequest $request)
    {
        $user = User::create([
            'name' => sanitize($request->name),
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->roles()->attach(Role::where('name', config('constants.roles.user'))->first());

        return response()->json(['user' => $user, 'token' => $user->createToken('api-token')->plainTextToken], 201);
    }
}
