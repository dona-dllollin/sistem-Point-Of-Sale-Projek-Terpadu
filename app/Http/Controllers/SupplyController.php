<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SupplyController extends Controller
{
        // Show View Supply
        public function index()
        {
        
            $suppliesByDate = Supply::orderBy('created_at', 'desc')
            ->get()
            ->groupBy(fn($supply) => $supply->created_at->toDateString());
    
                return view('product.supply', compact('suppliesByDate'));
        
        }

          // Show View New Supply
        public function viewNewSupply()
        {
           
                $products = Product::all()
                ->sortBy('kode_barang');

                return view('product.new_supply', compact('products'));
            
        }

        // Take Supply Product
        public function takeSupplyProduct($id) {
                $product = Product::where('kode_barang', '=', $id)->first();
                if($product) {
                    return response()->json(['product' => $product], 200);
                } else {
                    return response()->json(['message' => 'Data not found'], 404);
                }
                
        }

        // check supply product
        public function checkSupplyProduct($id) {
            $check_product = Product::where('kode_barang', '=', $id)->count();
            $product = Product::where('kode_barang', '=', $id)->first();
            if($check_product != 0) {
                return response()->json(['message' => 'Data found', 'product' => $product], 200);
            } else {
                return response()->json(['message' => 'Data not found'], 404);
            }
            
        }

        public function storeSupply(Request $request) {
    $supplyData = $request->input('supply');

    DB::beginTransaction();
    try {
        foreach ($supplyData as $supply) {
            // Cari produk berdasarkan kode_barang
            $product = Product::where('kode_barang', $supply['kode_barang'])->first();

            if (!$product) {
                return response()->json(['message' => 'Produk tidak ditemukan!'], 404);
            }

            // Simpan data supply ke tabel supplies
            Supply::create([
                'kode_barang' => $supply['kode_barang'],
                'product_id' => $product->id,
                'harga_beli' => $supply['harga_beli'] ?? null, // Simpan null jika harga kosong
                'jumlah' => $supply['jumlah'],
                'pemasok' => $supply['pemasok'] ?? null, // Pastikan input memiliki pemasok
                'user_id' => auth()->id(),
            ]);

            // Update stok dan keterangan produk
            $updateData = [
                'stok' => $product->stok + $supply['jumlah'], // Tambah stok
                'keterangan' => 'tersedia', // Set keterangan ke 'tersedia'
            ];

            // Update harga_beli hanya jika tidak kosong
            if (!empty($supply['harga_beli'])) {
                $updateData['harga_beli'] = $supply['harga_beli'];
            }

            // Update tabel products
            $product->update($updateData);
        }

        DB::commit();
        return response()->json(['message' => 'Data berhasil disimpan!']);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['message' => 'Terjadi kesalahan!', 'error' => $e->getMessage()], 500);
    }
}



    
}
