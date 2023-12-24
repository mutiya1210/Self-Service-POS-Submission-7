<?php

namespace App\Http\Controllers;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    
    public function index() {
       try {
            $produks = Produk::all();

            return response()->json([
                "pesan" => "Berhasil ambil data produk",
                "data" => $produks,
            ], 200);
       } catch (\Throwable $e) {
        return response()->json([
            "pesan"=> "gagal",
            "data" => $e->getMessage()
        ], );
       }
    }

    public function show($id) {
      try {
            $produk = Produk::findOrFail($id);

            return response()->json([
                "pesan" => "Berhasil ambil data produk",
                "data" => $produk,
            ], 200);
      } catch(\Throwable $e) {
            return response()->json([
                "pesan" => "gagal",
                "data" => $e->getMessage()
            ]);
      }
    }

    public function store(Request $request) {
       try {
            $validator = Validator::make($request->all(), [
                "nama_produk" => 'required|min:5',
                "harga_produk" => 'required|integer',
                "stok_produk" => 'required|integer',
                "gambar_produk" => 'required'
            ], [
                "required" => ":attribute wajib diisi",
                "integer" => ":attribute harus berupa angka",
                "min" =>    ":attribute minimal :min karakter",
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "pesan" => "gagal",
                    "data" => $validator->errors(),
                ], 401);
            }

            $produks = Produk::create(
                [
                    "nama_produk" => $request->nama_produk,
                    "harga_produk" => $request->harga_produk,
                    "stok_produk" => $request->stok_produk,
                    "gambar_produk" => $request->gambar_produk,
                ]
            );

            return response()->json([
                "pesan" => "berhasil membuat produk",
                "data" => $produks,
            ], 200);
       } catch(\Throwable $e) {
        return response()->json([
            "pesan" => "gagal",
            "data" => $e->getMessage(),
        ]);
       }
    }

    public function update(Request $request, $id)
    {
       try {
            $validator = Validator::make($request->all(), [
                "nama_produk" => 'required|min:5',
                "harga_produk" => 'required|integer',
                "stok_produk" => 'required|integer',
                "gambar_produk" => 'required'
            ], [
                "required" => ":attribute wajib diisi",
                "integer" => ":attribute harus berupa angka",
                "min" =>    ":attribute minimal :min karakter",
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "pesan" => "gagal",
                    "data" => $validator->errors(),
                ], 401);
            }
            $produk = Produk::findOrFail($id);
            $produk->update(
                [
                    "nama_produk" => $request->nama_produk,
                    "harga_produk" => $request->harga_produk,
                    "stok_produk" => $request->stok_produk,
                    "gambar_produk" => $request->gambar_produk,
                ]
            );

            return response()->json([
                "pesan" => "berhasil update produk",
                "data" => $produk,
            ], 200);
       } catch(\Throwable $e) {
        return response()->json(
            [
                "pesan" => "Gagal Update",
                "data" => $e->getMessage(),
            ]
        );
       }
    }
    public function destroy($id)
    {
       try {
            $produk = Produk::findOrFail($id);

            $produk->delete();

            return response()->json(
                [
                    "pesan" => "Berhasil Hapus Produk ". $produk->nama_produk,
                ]
            );
       } catch(\Throwable $e) {
            return response()->json([
                "pesan" => "gagal",
                "data" => $e->getMessage()
            ]);
       }
    }
}
