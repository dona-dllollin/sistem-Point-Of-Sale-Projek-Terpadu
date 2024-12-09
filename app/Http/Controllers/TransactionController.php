<?php

namespace App\Http\Controllers;


use App\Models\Categories;
use App\Models\Market;
use App\Models\OrderItems;
use App\Models\Product;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $categories = Categories::all();
        $user = auth()->user();
        $markets = Market::all();

        $cart = session()->get('cart', []);
        $totalSubtotal = 0; // Untuk menyimpan total harga semua barang
        $totalQuantity = 0; // Untuk menyimpan total kuantitas semua barang

        foreach ($cart as $item) {
            $totalSubtotal += $item['subtotal']; // Menjumlahkan subtotal setiap item
            $totalQuantity += $item['quantity']; // Menjumlahkan quantity setiap item
        }


        if ($user->role === 'admin') {

            // Mulai query produk
            $products = Product::query();

            // Filter berdasarkan kategori
            if ($request->has('category_id') && $request->category_id != 'all') {
                $products->whereHas('categories', function ($query) use ($request) {
                    $query->where('categories.id', $request->category_id);
                });
            }

            // Filter berdasarkan toko jika role admin
            if (auth()->user()->role === 'admin' && $request->has('market_id') && $request->market_id != 'all') {
                $products->where('market_id', $request->market_id);
            }

            // Ambil produk berdasarkan filter
            $products = $products->get();
        } else if ($user->role === 'kasir') {
            $products = Product::where('market_id', $user->market_id);
            $products = $products->get();
        }

        return view('transaction/index', compact('products', 'categories', 'markets', 'totalQuantity', 'totalSubtotal'));
    }


    // Take Transaction Product
    public function transactionProduct($id)
    {

        $product = Product::where('kode_barang', '=', $id)
            ->first();

        $cart = session()->get('cart', []);

        $jumlahStok = $product->stok - (isset($cart[$product->id]) ? $cart[$product->id]['quantity'] : 0);
        // Jika barang sudah ada di keranjang, tambahkan jumlahnya
        if ($jumlahStok > 0) {

            if (isset($cart[$product->id])) {
                $cart[$product->id]['quantity']++;
                $cart[$product->id]['subtotal'] = $cart[$product->id]['price'] * $cart[$product->id]['quantity']; // Hitung subtotal

            } else {

                // Jika belum ada, tambahkan barang ke keranjang
                $cart[$product->id] = [
                    "name" => $product->nama_barang,
                    "price" => $product->harga_jual,
                    "quantity" => 1,
                    "kode_barang" => $product->kode_barang,
                    "subtotal" => $product->harga_jual
                ];
            }

            // Simpan kembali ke session
            session()->put('cart', $cart);
            // session()->forget('cart');

            $jumlahStok = $product->stok - (isset($cart[$product->id]) ? $cart[$product->id]['quantity'] : 0);

            // Kirim respons JSON
            return response()->json([
                'success' => true,
                'message' => 'Barang berhasil ditambahkan ke keranjang!',
                'cart' => $cart,
                'jumlahStok' => $jumlahStok
            ]);
        } else {
            return response()->json([
                'error' => true,
                'message' => 'Stok barang sudah habis'
            ]);
        }
    }

    // fungsi mengurangi item
    public function decreaseQuantity($id)
    {
        $product = Product::find($id);
        $cart = session()->get('cart', []);


        if (isset($cart[$id])) {
            $cart[$id]['quantity']--;
            $cart[$id]['subtotal'] = $cart[$id]['price'] * $cart[$id]['quantity'];

            // Jika quantity mencapai 0, hapus item
            if ($cart[$id]['quantity'] <= 0) {
                unset($cart[$id]);
            }
        }

        session()->put('cart', $cart);
        $jumlahStok = $product->stok - (isset($cart[$product->id]) ? $cart[$product->id]['quantity'] : 0);

        return response()->json([
            'success' => true,
            'cart' => $cart,
            'jumlahStok' => $jumlahStok
        ]);
    }

    //hapus item di session
    public function removeItem($id)
    {
        $product = Product::find($id);
        $cart = session()->get('cart', []);


        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        session()->put('cart', $cart);
        $jumlahStok = $product->stok - (isset($cart[$product->id]) ? $cart[$product->id]['quantity'] : 0);

        return response()->json([
            'success' => true,
            'cart' => $cart,
            'jumlahStok' => $jumlahStok
        ]);
    }


    public function increaseQuantity($id)
    {
        $product = Product::find($id);
        $cart = session()->get('cart', []);

        $jumlahStok = $product->stok - (isset($cart[$product->id]) ? $cart[$product->id]['quantity'] : 0);
        if ($jumlahStok > 0) {
            if (isset($cart[$id])) {
                $cart[$id]['quantity']++;
                $cart[$id]['subtotal'] = $cart[$id]['price'] * $cart[$id]['quantity'];
            }

            session()->put('cart', $cart);
            $jumlahStok = $product->stok - (isset($cart[$product->id]) ? $cart[$product->id]['quantity'] : 0);

            return response()->json([
                'success' => true,
                'cart' => $cart,
                'jumlahStok' => $jumlahStok
            ]);
        } else {
            return response()->json([
                'error' => true,
                'message' => 'Stok barang sudah habis'
            ]);
        }
    }



    // Check Transaction Product
    public function transactionProductCheck($id)
    {

        $product = Product::where('kode_barang', '=', $id)
            ->first();

        $cart = session()->get('cart', []);

        $jumlahStok = $product->stok - (isset($cart[$product->id]) ? $cart[$product->id]['quantity'] : 0);

        $product_check = Product::where('kode_barang', '=', $id)
            ->count();

        if ($product_check != 0) {
            // Jika barang sudah ada di keranjang, tambahkan jumlahnya
            if ($jumlahStok > 0) {

                if (isset($cart[$product->id])) {
                    $cart[$product->id]['quantity']++;
                    $cart[$product->id]['subtotal'] = $cart[$product->id]['price'] * $cart[$product->id]['quantity']; // Hitung subtotal

                } else {

                    // Jika belum ada, tambahkan barang ke keranjang
                    $cart[$product->id] = [
                        "name" => $product->nama_barang,
                        "price" => $product->harga_jual,
                        "quantity" => 1,
                        "kode_barang" => $product->kode_barang,
                        "subtotal" => $product->harga_jual
                    ];
                }

                // Simpan kembali ke session
                session()->put('cart', $cart);
                // session()->forget('cart');

                $jumlahStok = $product->stok - (isset($cart[$product->id]) ? $cart[$product->id]['quantity'] : 0);
                // Kirim respons JSON
                return response()->json([
                    'success' => true,
                    'message' => 'Barang berhasil ditambahkan ke keranjang!',
                    'cart' => $cart,
                    'jumlahStok' => $jumlahStok
                ]);
            } else {
                return response()->json([
                    'errorBarang' => true,
                    'message' => 'Stok barang sudah habis'
                ]);
            }
        } else {
            return response()->json([
                'errorKode' => true,
                'message' => 'kode barang tidak tersedia'
            ]);
        }


        // if ($product_check != 0) {
        //     $product = Product::where('kode_barang', '=', $id)
        //         ->first();
        //     $check = "tersedia";
        // } else {
        //     $product = '';
        //     $check = "tidak tersedia";
        // }

        // return response()->json([
        //     'product' => $product,
        //     'check' => $check
        // ]);
    }

    public function transactionProcess(Request $req)
    {
        DB::beginTransaction();

        try {

            $cart = session('cart', []);
            if (empty($cart)) {
                return back()->with('empty-cart', 'keranjang belanja kosong!');
            }

            $user = auth()->user();
            $user_id = $user->id;
            $market_id = 0;
            $market_id = $user->market_id ?? $req->market_id;

            $transaksi = Transaction::create([
                'user_id' => $user_id,
                'kode_transaksi' => $req->kode_transaksi,
                'total_harga' => $req->subtotal,
                'diskon' => $req->diskon,
                'bayar' => $req->bayar,
                'kembali' => $req->bayar - $req->total,
                'market_id' => $market_id,
            ]);

            foreach ($cart as $product_id => $item) {
                OrderItems::create([
                    'transaction_id' => $transaksi->id,
                    'product_id' => $product_id,
                    'total_barang' => $item['quantity'],
                    'subtotal' => $item['subtotal']
                ]);

                $product = Product::find($product_id);
                if ($product_id) {
                    $product->decrement('stok', $item['quantity']);
                }
            }

            // Hapus data keranjang di session
            session()->forget('cart');

            DB::commit();

            Session::flash('transaction_success', $transaksi);

            return back();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('transaction_error', 'Terjadi kesalahan saat menambahkan transaksi. error' . $e->getMessage());
        }
    }

    public function receiptTransaction($id)
    {
        $transaction = Transaction::find($id);
        $market = Market::find($transaction->market_id);
        $items = OrderItems::where('transaction_id', $id)->get();
        $diskon = $transaction->total_harga * $transaction->diskon / 100;
        $total = $transaction->total_harga - $diskon;
        $customPaper = array(0, 0, 400.00, 283.80);
        $pdf = Pdf::loadview('transaction.nota_transaksi', compact('transaction', 'market', 'items', 'diskon', 'total'))->setPaper($customPaper, 'landscape');
        return $pdf->stream();
    }
}
