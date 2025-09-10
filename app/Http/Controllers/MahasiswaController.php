<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the mahasiswa data.
     */
    public function index()
    {
        $mahasiswa = mahasiswa::latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'List Data mahasiswa',
            'data' => $mahasiswa
        ], 200);
    }
    /**
     * Store a newly created mahasiswa data.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_m' => 'required',
            'nim' => 'required',
            'prodi' => 'required',
            'alamat' => 'required',
            'NOHP' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $user = User::create([
            'name' => $request->name_m,
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
                'message' => 'mahasiswa Berhasil ditambahkan',
                'mahasiswa' => $mahasiswa,
                'user' => $user
            ], 201);
        }
        return response()->json([
            'success' => false,
            'message' => 'mahasiswa Gagal ditambahkan',
        ], 409);
    }

    /**
     * Display the specified mahasiswa data.
     */
    public function show($id)
    {
        $mahasiswa = mahasiswa::findOrFail($id);
        return response()->json([
            'success' => true,
            'message' => 'Detail Data mahasiswa',
            'data' => $mahasiswa
        ], 200);
    }

    /**
     * Update the specified mahasiswa data.
     */
    public function update(Request $request, mahasiswa $mahasiswa)
    {
        $validator = Validator::make($request->all(), [
            'name_m' => 'required',
            'nim' => 'required',
            'prodi' => 'required',
            'alamat' => 'required',
            'NOHP' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $mahasiswa = mahasiswa::findOrFail($mahasiswa->id);
        $user = user::findOrFail($mahasiswa->id_u);
        if ($mahasiswa) {
            if ($request->password) {
                $user->update([
                    'name' => $request->name_m,
                    'password' => bcrypt($request->password),
                ]);
            } else {
                $user->update([
                    'name_m' => $request->name_m,
                ]);
            }
            $mahasiswa->update([
                'name_m' => $request->name_m,
                'nim' => $request->nim,
                'prodi' => $request->prodi,
                'alamat' => $request->alamat,
                'NOHP' => $request->NOHP,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'mahasiswa Updated',
                'mahasiswa' => $mahasiswa,
                'user'=>$user
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'mahasiswa Not Found',
        ], 404);
    }

    /**
     * Remove the specified mahasiswa data.
     */
    public function destroy($id)
    {
        $mahasiswa = mahasiswa::findOrfail($id);
        $idu=$mahasiswa->id_u;
        $user=user::findOrfail($idu);
        if ($mahasiswa) {
            $mahasiswa->delete();
            $user->delete();
            return response()->json([
                'success' => true,
                'message' => 'Mahasiswa Deleted',
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Mahasiswa Not Found',
        ], 404);
    }
}