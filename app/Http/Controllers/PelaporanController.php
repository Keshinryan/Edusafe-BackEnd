<?php

namespace App\Http\Controllers;

use App\Models\mahasiswa;
use App\Models\pelaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

Storage::disk('local')->makeDirectory('bukti');

class PelaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pelaporan = pelaporan::latest()->get();
        $mahasiswa = mahasiswa::whereIn('id', $pelaporan->pluck('id_m'))->get();
        return response()->json([
            'success' => true,
            'message' => 'List Data pelaporan',
            'data' => $pelaporan,
            'mahasiswa' => $mahasiswa
        ], 200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $mahasiswa = mahasiswa::where('id_u', '=', $request->id_m)->value('id');
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required',
            'waktu' => 'required',
            'tempat' => 'required',
            'deskripsi' => 'required',
            'bukti' => 'required|file',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $bukti = $request->file('bukti');
        $bukti->storeAs('public/bukti', $bukti->hashName());
        $pelaporan = pelaporan::create([
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'tempat' => $request->tempat,
            'deskripsi' => $request->deskripsi,
            'bukti' => $bukti->hashName(),
            'id_m' => $mahasiswa,
        ]);
        if ($pelaporan) {
            return response()->json([
                'success' => true,
                'message' => 'pelaporan Berhasil ditambahkan',
                'data' => $pelaporan
            ], 201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pelaporan = pelaporan::findOrFail($id);
        return response()->json([
            'success' => true,
            'message' => 'Detail Data pelaporan',
            'data' => $pelaporan
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, pelaporan $pelaporan)
    {// Logging the request data for debugging purposes
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Find the pelaporan instance by its ID
        $pelaporan = pelaporan::findOrFail($pelaporan->id);

        if ($pelaporan) {
            // Update the status field
            $pelaporan->update([
                'status' => $request->status,
            ]);

            // Return a JSON response with the updated data
            return response()->json([
                'success' => true,
                'message' => 'pelaporan Updated',
                'data' => $pelaporan
            ], 200);
        }

        // Return a JSON response if the pelaporan instance is not found
        return response()->json([
            'success' => false,
            'message' => 'pelaporan Not Found',
        ], 404);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pelaporan = pelaporan::findOrfail($id);
        $disk = Storage::disk('local');
        $file = 'bukti' . $pelaporan->bukti;
        if ($disk->exists($file)) {
            $disk->delete($file);
        }
        if ($pelaporan) {
            $pelaporan->delete();
            return response()->json([
                'success' => true,
                'message' => 'pelaporan Deleted',
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'pelaporan Not Found',
        ], 404);
    }
}