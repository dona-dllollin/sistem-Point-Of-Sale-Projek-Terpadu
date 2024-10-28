<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    // Show view product
    function viewProduct(Request $request)
    {

        $filter = $request->query('filter', 'kode_barang');
        $user = Auth::user();
        if ($user->role === 'admin') {

            $products = Product::orderBy($filter)->get();
        } elseif ($user->role === 'kasir') {
            $products = Product::where('market_id', $user->market_id)->orderBy($filter)->get();
        } else {
            return back();
        }
        return view('product.index', compact('products'));
    }


    // Delete Product
    function deleteProduct($id)
    {

        // Temukan produk berdasarkan ID
        $product = Product::find($id);
        // Jika produk ditemukan, hapus relasi kategori

        if ($product) {

            // Menghapus relasi kategori di tabel pivot
            $product->categories()->detach();

            // Menghapus produk
            $product->delete();

            Session::flash('delete_success', 'Barang berhasil dihapus');

            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    // Delete Product
    function deleteProductKasir($slug_market, $id)
    {

        // Temukan produk berdasarkan ID
        $product = Product::find($id);
        // Jika produk ditemukan, hapus relasi kategori

        if ($product) {

            // Menghapus relasi kategori di tabel pivot
            $product->categories()->detach();

            // Menghapus produk
            $product->delete();

            Session::flash('delete_success', 'Barang berhasil dihapus');

            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }
}
