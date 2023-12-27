<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $User = User::latest()->first();
        return response()->json([
            'success' => true,
            'message' => 'List Data User',
            'data' => $User->id
        ], 200);
    }
    /**
     * Store a newly created resource in storage.
     */

     public function store(Request $request)
     {
         $validator = Validator::make($request->all(), [
             'name' => 'required',
             'role' => 'required',
             'password' => 'required',
         ]);
     
         if ($validator->fails()) {
             return response()->json(['errors' => $validator->errors()], 400);
         }
     
         $user = User::create([
             'name' => $request->name,
             'role' => $request->role,
             'password' => bcrypt($request->password), // Hash the password before storing
         ]);
     
         if ($user) {
             return response()->json([
                 'success' => true,
                 'message' => 'User Berhasil ditambahkan',
                 'data' => $user
             ], 201);
         }
     
         return response()->json([
             'success' => false,
             'message' => 'User Gagal ditambahkan',
         ], 409);
     }
     
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $User = User::findOrFail($id);
        return response()->json([
            'success' => true,
            'message' => 'Detail Data User',
            'data' => $User
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $User)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'role' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $User = User::findOrFail($User->id);
        if ($User) {
            $User->update([
                'name' => $request->name,
                'role' => $request->role,
                'password' => $request->password,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'User Updated',
                'data' => $User
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'User Not Found',
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $User = User::findOrfail($id);
        if ($User) {
            $User->delete();
            $User=User::latest()->get();
            return response()->json([
                'success' => true,
                'message' => 'User Deleted',
                'data' => $User,
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'User Not Found',
        ], 404);
    }
}
