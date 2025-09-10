<?php

namespace App\Http\Controllers;

use App\Models\mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required',
            'name_m' => 'required',
            'nim' => 'required',
            'prodi' => 'required',
            'alamat' => 'required',
            'NOHP' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        // Create a new user record
        $user = User::create([
            'name' => $request->name,
            'role' => $request->role,
            'password' => bcrypt($request->password),
        ]);
        $mahasiswa = mahasiswa::create([
            'name_m' => $request->name_m,
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'alamat' => $request->alamat,
            'NOHP' => $request->NOHP,
            'id_u' => $user->id,
        ]);
        if ($mahasiswa) {
            return response()->json([
                'success' => true,
                'message' => 'User Berhasil Register',
                'mahasiswa' => $mahasiswa,
                'user' => $user
            ], 201);
        }
    }
    /**
     * Login a user.
     */
    public function login(Request $request)
    {   
        // Validate the user input
        $credentials = $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);
        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Authentication successful
            $user = Auth::user();
            error_log($user);
            Auth::login($user); // Log in the user programmatically
            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'data' => $user,   
            ],200);
        } else {
            // Authentication failed
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }
    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Logout successful'],200);
    }
}