<?php

namespace App\Http\Controllers;

use App\Models\edukasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
Storage::disk('local')->makeDirectory('foto');

class EdukasiController extends Controller
{
    /**
     * Display a listing of the edukasi data.
     */
    public function index()
    {
        $edukasi = edukasi::latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'List Data Edukasi',
            'data' => $edukasi,
        ], 200);
    }
    /**
     * Store a newly created new edukasi data.
     */
    public function store(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'isi' => 'required',
            'foto' => 'required|file'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
            $foto = $request->file('foto');
            $foto->storeAs('public/foto', $foto->hashName());
            $edukasi = edukasi::create([
                'judul' => $request->judul,
                'isi' => $request->isi,
                'foto' => $foto->hashName(),
        ]);
        if ($edukasi) {
            return response()->json([
                'success' => true,
                'message' => 'Edukasi Berhasil ditambahkan',
                'data' => $edukasi
            ], 201);
        }
    }

    /**
     * Display the specified edukasi data.
     */
    public function show($id)
    {
        $edukasi = edukasi::findOrFail($id);
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Edukasi',
            'data' => $edukasi
        ], 200);
    }

    /**
     * Update the specified edukasi data.
     */
    public function update(Request $request, edukasi $edukasi)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'isi' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $edukasi = edukasi::findOrFail($edukasi->id);
        if ($edukasi) {
            if ($request->file('foto') == '') {
                $edukasi->update([
                    'judul' => $request->judul,
                    'isi' => $request->isi,
                ]);
            } else {
                $disk = Storage::disk('local');
                $file = 'foto' . $edukasi->foto;
                if ($disk->exists($file)) {
                    $disk->delete($file);
                }
                $foto = $request->file('foto');
                $foto->storeAs('public/foto', $foto->hashName());
                $edukasi->update([
                    'judul' => $request->judul,
                    'isi' => $request->isi,
                    'foto' => $foto->hashName(),
                ]);
            }
            return response()->json([
                'success' => true,
                'message' => 'Edukasi Updated',
                'data' => $edukasi,
            ], 200);
        } 
    }
    
    /**
     * Remove the specified edukasi data.
     */
    public function destroy( $id)
    {
        $edukasi = edukasi::findOrfail($id);
        if ($edukasi) {
            $edukasi->delete();
            return response()->json([
                'success' => true,
                'message' => 'edukasi Deleted',
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'edukasi Not Found',
        ], 404);
    }
}
