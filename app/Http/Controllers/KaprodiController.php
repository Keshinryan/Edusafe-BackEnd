<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\kaprodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KaprodiController extends Controller
{
    /**
     * Display a listing of the kaprodi data.
     */
    public function index()
    { 
        $kaprodi = kaprodi::latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'List Data kaprodi',
            'kaprodi' => $kaprodi,
        ], 200);
    }
    /**
     * Store a newly created  kaprodi data.
     */
    public function store(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'name_k' => 'required',
            'password'=>'required',
            'nip'=> 'required',
            'prodi' => 'required',
            'NOHP' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $user = User::create([
            'name' => $request->name_k,
            'role' => $request->role,
            'password' => bcrypt($request->password),
        ]);
        $kaprodi = kaprodi::create([
            'name_k' => $request->name_k,
            'nip'=> $request->nip,
            'prodi' => $request->prodi,
            'NOHP' => $request->NOHP,
            'id_u' => $user->id,
        ]);
        if ($kaprodi) {
            return response()->json([
                'success' => true,
                'message' => 'kaprodi Berhasil ditambahkan',
                'kaprodi' => $kaprodi,
                'user'=>$user
            ], 201);
        }
        return response()->json([
            'success' => false,
            'message' => 'kaprodi Gagal ditambahkan',
        ], 409);
    }

    /**
     * Display the specified kaprodi data.
     */
    public function show($id)
    {
        $kaprodi = kaprodi::findOrFail($id);
        return response()->json([
            'success' => true,
            'message' => 'Detail Data kaprodi',
            'data' => $kaprodi
        ], 200);
    }

    /**
     * Update the specified kaprodi data.
     */
    public function update(Request $request, kaprodi $kaprodi)
    {   
        $validator = Validator::make($request->all(), [
            'name_k' => 'required',
            'nip'=> 'required',
            'prodi' => 'required',
            'NOHP' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $kaprodi = kaprodi::findOrFail($kaprodi->id);
        $user = user::findOrFail($kaprodi->id_u);
        if ($kaprodi) {
            if($request->password){
                $user->update([
                    'name_k' => $request->name_k,
                    'password'=> bcrypt($request->password),
                ]);
            }else{
                $user->update([
                    'name_k' => $request->name_k,
                ]);
            }
            $kaprodi->update([
                'name_k' => $request->name_k,
                'nip'=> $request->nip,
                'prodi' => $request->prodi,
                'NOHP' => $request->NOHP,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'kaprodi Updated',
                'kaprodi' => $kaprodi,
                'user'=>$user
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'kaprodi Not Found',
        ], 404);
    }

    /**
     * Remove the specified kaprodi data.
     */
    public function destroy($id)
    {   
        $kaprodi = kaprodi::findOrfail($id);
        $idu=$kaprodi->id_u;
        $user=user::findOrfail($idu);
        if ($kaprodi) {
            $kaprodi->delete();
            $user->delete();
            return response()->json([
                'success' => true,
                'message' => 'kaprodi Deleted',
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'kaprodi Not Found',
        ], 404);
    }
}
