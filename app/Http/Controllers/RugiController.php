<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Rugi;
use App\Models\Supply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RugiController extends Controller
{
        public function index()
    {
        $rugi = Rugi::all();
        $produkList = Product::all();
        return view('rugi.index', compact('rugi', 'produkList'));
    }

    public function store(Request $request) {
        $jumlahRugi = (int) $request->jumlah;
        $hargaBeli = (float) $request->harga_beli;

         // Ambil data produk
    $product = Product::where('kode_barang', $request->kode_barang)->first();
    if (!$product) {
        return back()->withErrors(['kode_barang' => 'Produk tidak ditemukan.']);
    }


$supplies = Supply::where('kode_barang', $product->kode_barang)
    ->where('harga_beli', $hargaBeli)
    ->where('jumlah', '>', 0)
    ->orderBy('created_at', 'desc') // LIFO
    ->get();

$stokRugi = $jumlahRugi;

foreach ($supplies as $supply) {
    if ($stokRugi <= 0) break;

    $ambil = min($supply->jumlah, $stokRugi);

    // Kurangi stok dari batch ini
    $supply->jumlah -= $ambil;
    $supply->save();

    // Catat ke data_rugi
    Rugi::create([
        'kode_barang' => $product->kode_barang,
        'nama_barang' => $product->nama_barang,
        'jumlah' => $ambil,
        'harga_beli' => $supply->harga_beli,
        'total_kerugian' => $ambil * $supply->harga_beli,
        'alasan' => $request->alasan ?? 'rusak/kadaluarsa',
        'tanggal' => now(),
        'user_id' => auth()->user()->id,
    ]);

    $stokRugi -= $ambil;
}

if ($stokRugi > 0) {
    // Gagal: supply dengan harga yang cocok tidak cukup
    DB::rollBack();
    Session::flash('rugi_failed', 'Stok dengan harga tersebut tidak mencukupi.');
    return back()->withInput();
}

// Update stok produk juga
$product->stok -= $jumlahRugi;
$product->save();
  Session::flash('success', 'Data Kerugian Telah Ditambahkan');
    return back();

    }
}
