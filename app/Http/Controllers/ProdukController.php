<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::all();
        return response()->json([
            'status' => 'success',
            'data' => $produks
        ]);
    }

    public function show($id)
    {
        $produk = Produk::find($id);
        if (!$produk) {
            return response()->json([
                'status' => 'error',
                'message' =>'produk not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $produk
        ]);
    }
    
    public function create(Request $request)
    {
        $rules = [
            'nama_produk' => 'required|string',
            'deskripsi_produk' => 'required|string',
            'gambar_produk' => 'required|url',
            'kategori_id' => 'required|integer',
            'stok' => 'required|integer'
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $produk = Produk::create($data);

        return response()->json(['status' => 'success', 'data' => $produk ]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'nama_produk' => 'required|string',
            'deskripsi_produk' => 'required|string',
            'gambar_produk' => 'required|url',
            'kategori_id' => 'required|integer',
            'stok' => 'required|integer'
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ], 400);
        }

        $produk = Produk::find($id);

        if (!$produk) {
            return response()->json([
                'status' => 'error',
                'message' => 'produk not found'
            ], 404);
        }

        $produk->fill($data);

        $produk->save();

        return response()->json([
            'status' => 'success',
            'data' => $produk
        ]);
    }

    public function destroy($id)
    {
        $produk = Produk::find($id);

        if (!$produk) {
            return response()->json([
                'status' => 'error',
                'message' => 'produk not found'
            ], 404);
        }

        $produk->delete();
        
        return response()->json([
            'status' => 'success',
            'message' => 'produk deleted'
        ]);
    }
}
