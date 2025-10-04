<?php

namespace App\Http\Controllers;

use App\Models\OrderItems;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date') ?? Carbon::today()->startOfMonth();
        $endDate = $request->input('end_date') ?? Carbon::today()->endOfMonth();
        $orderItems = OrderItems::whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc')->get();

        if ($request->input('product_id')) {
            $orderItems = $orderItems->where('product_id', $request->input('product_id'));
        }

              $produkList = Product::select('id', 'nama_barang', 'kode_barang')->get();

 
        
        return view('order_items.index', [
            'orderItems' => $orderItems,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'produkList' => $produkList,
        
        ]);
    }
}
