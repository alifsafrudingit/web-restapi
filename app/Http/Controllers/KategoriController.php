<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();
        return response()->json([
            'status' => 'success',
            'data' => $kategoris
        ]);
    }

    public function show($id)
    {
        $kategori = Kategori::find($id);
        if (!$kategori) {
            return response()->json([
                'status' => 'error',
                'message' =>'kategori not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $kategori
        ]);
    }
    
    public function create(Request $request)
    {
        $rules = [
            'nama_kategori_produk' => 'required|string',
            'deskripsi_kategori_produk' => 'string'
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $kategori = Kategori::create($data);

        return response()->json(['status' => 'success', 'data' => $kategori ]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'nama_kategori_produk' => 'string',
            'deskripsi_kategori_produk' => 'string'
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $kategori = Kategori::find($id);

        if (!$kategori) {
            return response()->json([
                'status' => 'error',
                'message' => 'kategori not found'
            ], 404);
        }

        $kategori->fill($data);

        $kategori->save();

        return response()->json([
            'status' => 'success',
            'data' => $kategori
        ]);
    }

    public function destroy($id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return response()->json([
                'status' => 'error',
                'message' => 'kategori not found'
            ], 404);
        }

        $kategori->delete();
        
        return response()->json([
            'status' => 'success',
            'message' => 'kategori deleted'
        ]);
    }
}
