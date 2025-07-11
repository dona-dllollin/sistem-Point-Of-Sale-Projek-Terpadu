<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Market;
use App\Models\Product;
use App\Models\Satuan;
use App\Models\Supply;
use App\Models\Transaction;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Stmt\TryCatch;

class ProductController extends Controller
{
    // Show view product
    function viewProduct(Request $request)
    {
        $kategori = Categories::all();
        $toko = Market::all();
        $filter = $request->query('filter', 'created_at');
        $satuans = Satuan::all();
        $user = Auth::user();
        if ($user->role === 'admin') {

            $products = Product::orderBy($filter, 'desc')->get();
        } elseif ($user->role === 'kasir') {
            $products = Product::where('market_id', $user->market_id)->orderBy($filter, 'desc')->get();
        } else {
            return back();
        }
        return view('product.index', compact('products', 'toko', 'kategori', 'satuans'));
    }

    // halaman tambah barang
    function viewNewProduct()
    {
        $kategori = Categories::all();
        
        $satuan = Satuan::all();
        return view('product.create', compact('kategori', 'satuan'));
    }

    // fungsi tambah barang
    function createProduct(Request $request)
    {
        $check_product = Product::where('kode_barang', $request->kode_barang)
            ->count();

        $request->validate(
            [
                'nama_barang' => 'required',
                'kode_barang' => 'required',
                
                'harga_beli' => 'required|numeric',
                'harga_jual' => 'required|numeric',
               

            ],
            [
                'nama_barang.required' => 'nama barang harus diisi',

            ]
        );

        if ($request->hasFile('image')) {
            $request->validate(
                [
                    'image' => 'mimes:jpeg,jpg,png|image|file'
                ],
                [
                    'image.mimes' => 'ekstensi gambar harus jpeg, jpg, png',
                    'image.image' => 'Format gambar salah',
                    'image.file' => 'format gambar bukan file'
                ]
            );

            $gambar_file = $request->file('image');
            $ekstensi_gambar = $gambar_file->extension();
            $nama_gambar = date('ymdhis') . "." . $ekstensi_gambar;
            $gambar_file->move(public_path('pictures/product'), $nama_gambar);
        } else {
            $nama_gambar = "default.png";
        }

        if ($check_product == 0) {

            $market = Market::first();
            $product = Product::create([
                'kode_barang' => $request->kode_barang,
                'image' => $nama_gambar,
                'nama_barang' => $request->nama_barang,
                'satuan' =>  $request->satuan_berat,
                'stok' => 0,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
                'market_id' => $market->id,
                'keterangan' => 'habis'

            ]);

            $product->categories()->attach($request->kategori_barang);

            Session::flash('create_success', 'Barang baru berhasil ditambahkan');

            return Auth::user()->role === 'admin' ? redirect('/product') : redirect()->route('kasir.product', ['slug_market' => session('slug_market')]);
        } else {
            Session::flash('create_failed', 'Kode barang telah digunakan');

            return back()->withInput();
        }
    }


  

    // function updateProduct(Request $request)
    // {
    //     $check_product = Product::where('kode_barang', $request->kode_barang)->count();
    //     $product_data = Product::find($request->id);

    //     $request->validate(
    //         [
    //             'nama_barang' => 'required',
    //             'kode_barang' => 'required',
    //             'harga_beli' => 'required|numeric',
    //             'harga_jual' => 'required|numeric',
    //             'toko' => 'required',

    //         ],
    //         [
    //             'nama_barang.required' => 'nama barang harus diisi',

    //         ]
    //     );

    //     if ($check_product == 0 || $product_data->kode_barang == $request->kode_barang) {
    //         $product = Product::find($request->id);
    //         $product->kode_barang = $request->kode_barang;
    //         $product->nama_barang = $request->nama_barang;
    //         $product->satuan =  $request->satuan_berat;
    //         $product->harga_beli = $request->harga_beli;
    //         $product->harga_jual = $request->harga_jual;
    //         $product->market_id = $request->toko;

    //         if ($request->hasFile('image')) {

    //             $request->validate(
    //                 [
    //                     'image' => 'mimes:jpeg,jpg,png|image|file'
    //                 ],
    //                 [
    //                     'image.mimes' => 'ekstensi gambar harus jpeg, jpg, png',
    //                     'image.image' => 'Format gambar salah',
    //                     'image.file' => 'format gambar bukan file'
    //                 ]
    //             );

    //             if ($product->image !== 'default.png') {
    //                 $oldImage = public_path('pictures/product/' . $product->image);
    //                 if (file_exists($oldImage)) {
    //                     unlink($oldImage);
    //                 }
    //             }

    //             // Simpan gambar baru
    //             $image = $request->file('image');
    //             $imageName = time() . '.' . $image->getClientOriginalExtension();
    //             $image->move(public_path('pictures/product'), $imageName);

    //             // Update nama gambar di produk
    //             $product->image = $imageName;
    //         }

    //         // Sinkronkan kategori dengan produk
    //         $product->categories()->sync($request->input('kategori_barang'));

    //         Log::info('Before saving product: ', $product->toArray());
    //         if ($product->save()) {
    //             Log::info('Product saved successfully.');
    //         } else {
    //             Log::error('Failed to save product.');
    //         }

    //         Supply::where('kode_barang', $product->kode_barang)->update(['kode_barang' => $request->kode_barang]);


    //         Session::flash('update_success', 'Data barang berhasil diubah');

    //         return Auth::user()->role === 'admin' ? redirect('/product') : redirect()->route('kasir.product', ['slug_market' => session('slug_market')]);
    //     } else {
    //         Session::flash('update_failed', 'Kode barang telah digunakan');

    //         return back()->withInput();
    //     }
    // }



    function updateProduct(Request $request)
{
    $check_product = Product::where('kode_barang', $request->kode_barang)->count();
    $product_data = Product::find($request->id);

    $request->validate(
        [
            'nama_barang' => 'required',
            'kode_barang' => 'required',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'toko' => 'required',
        ],
        [
            'nama_barang.required' => 'nama barang harus diisi',
        ]
    );

    if ($check_product == 0 || $product_data->kode_barang == $request->kode_barang) {
        DB::beginTransaction();
        try {
            $product = Product::find($request->id);
            $oldStok = $product->stok; // ambil stok lama

            $product->kode_barang = $request->kode_barang;
            $product->nama_barang = $request->nama_barang;
            $product->satuan = $request->satuan_berat;
            $product->harga_beli = $request->harga_beli;
            $product->harga_jual = $request->harga_jual;
            $product->market_id = $request->toko;

            if ($request->hasFile('image')) {
                $request->validate(
                    [
                        'image' => 'mimes:jpeg,jpg,png|image|file'
                    ],
                    [
                        'image.mimes' => 'ekstensi gambar harus jpeg, jpg, png',
                        'image.image' => 'Format gambar salah',
                        'image.file' => 'format gambar bukan file'
                    ]
                );

                if ($product->image !== 'default.png') {
                    $oldImage = public_path('pictures/product/' . $product->image);
                    if (file_exists($oldImage)) {
                        unlink($oldImage);
                    }
                }

                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('pictures/product'), $imageName);
                $product->image = $imageName;
            }

            $product->categories()->sync($request->input('kategori_barang'));

            // HANDLE PENGURANGAN STOK
            if ($request->has('stok')) {
                $newStok = (int) $request->stok;

                if ($newStok > $oldStok) {
                    Session::flash('update_failed', 'Stok hanya boleh dikurangi, tidak boleh ditambah');
                    return back()->withInput();
                }

                $stokToReduce = $oldStok - $newStok;

                if ($stokToReduce > 0) {
                    $supplies = Supply::where('kode_barang', $product->kode_barang)
                        ->where('jumlah', '>', 0)
                        ->orderBy('created_at', 'desc')
                        ->get();

                    foreach ($supplies as $supply) {
                        if ($stokToReduce <= 0) break;

                        if ($supply->jumlah >= $stokToReduce) {
                            $supply->jumlah -= $stokToReduce;
                            $supply->save();
                            $stokToReduce = 0;
                        } else {
                            $stokToReduce -= $supply->jumlah;
                            $supply->jumlah = 0;
                            $supply->save();
                        }
                    }

                    if ($stokToReduce > 0) {
                        DB::rollBack();
                        Session::flash('update_failed', 'Stok supply tidak mencukupi.');
                        return back()->withInput();
                    }

                    $product->stok = $newStok;
                }
            }

            Log::info('Before saving product: ', $product->toArray());
            $product->save();
            Log::info('Product saved successfully.');

            // Update kode_barang di tabel supply (kalau diubah)
            Supply::where('kode_barang', $product_data->kode_barang)
                ->update(['kode_barang' => $request->kode_barang]);

            DB::commit();
            Session::flash('update_success', 'Data barang berhasil diubah');
            return Auth::user()->role === 'admin'
                ? redirect('/product')
                : redirect()->route('kasir.product', ['slug_market' => session('slug_market')]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal update product: ' . $e->getMessage());
            Session::flash('update_failed', 'Terjadi kesalahan: ' . $e->getMessage());
            return back()->withInput();
        }
    } else {
        Session::flash('update_failed', 'Kode barang telah digunakan');
        return back()->withInput();
    }
}

    // Delete Product
    function deleteProduct($id)
    {


        $product = Product::find($id);


        if ($product && $product->stok <= 0) {

            $product->categories()->detach();


            if ($product->image !== 'default.png') {
                $gambarPath = public_path('pictures/product/' . $product->image);

                if (file_exists($gambarPath)) {
                    unlink($gambarPath);
                }
            }

            // Menghapus produk
            $product->delete();

            Session::flash('delete_success', 'Barang berhasil dihapus');

            return redirect()->back();
        } else {
            Session::flash('delete_failed', 'Stok Barang Masih Ada, Produk Tidak Boleh Dihapus');
            return redirect()->back();
        }
    }

    // Delete Product
    function deleteProductKasir($slug_market, $id)
    {

        // Temukan produk berdasarkan ID
        $product = Product::find($id);
        // Jika produk ditemukan, hapus relasi kategori

        if ($product && $product->stok <= 0) {

            // Menghapus relasi kategori di tabel pivot
            $product->categories()->detach();

            // Jika gambar bukan default, hapus file gambar dari folder
            if ($product->image !== 'default.png') {
                $gambarPath = public_path('pictures/product/' . $product->image);

                // Periksa apakah file gambar ada di folder
                if (file_exists($gambarPath)) {
                    unlink($gambarPath); // Hapus file gambar
                }
            }


            // Menghapus produk
            $product->delete();

            Session::flash('delete_success', 'Barang berhasil dihapus');

            return redirect()->back();
        } else {
            Session::flash('delete_failed', 'Stok Barang Masih Ada, Produk Tidak Boleh Dihapus');
            return redirect()->back();
        }
    }
}
