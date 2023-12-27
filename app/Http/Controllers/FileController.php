<?php

namespace App\Http\Controllers;

use App\Models\edukasi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function show($filename, $name)
    {
        if ($name == "bukti") {
            $filePath = storage_path('app/public/bukti/' . $filename);
        } else if ($name == "foto") {
            $filePath = storage_path('app/public/foto/' . $filename);
        } else{
            return response()->json([
                'success' => false,
                'message' => 'Wrong Folder.',
            ], 400);
        }

        if (file_exists($filePath)) {
            return response()->file($filePath);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'File Not Found',
            ], 404);
        }
    }

    public function update(Request $request, $param)
    {
        $edukasi = edukasi::findOrFail($param);
        if ($edukasi) {
            if ($request->foto !== $edukasi->foto) {
                $disk = Storage::disk('local');
                $file = 'foto' . $edukasi->foto;
                if ($disk->exists($file)) {
                    $disk->delete($file);
                }
                $foto = $request->file('foto');
                $foto->storeAs('public/foto', $foto->hashName());
                $edukasi->update([
                    'foto' => $foto->hashName(),
                ]);
                return response()->json([
                    'success' => true,
                    'message' => 'Foto Edukasi Updated',
                    'data' => $edukasi,
                ], 200);
            }
        }else{
            return response()->json(['error' => 'No file uploaded'], 404);
        }
    }
}