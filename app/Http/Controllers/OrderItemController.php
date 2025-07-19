<?php

namespace App\Http\Controllers;

use App\Models\OrderItems;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date') ?? OrderItems::min('created_at');
        $endDate = $request->input('end_date') ?? OrderItems::max('created_at');
        $orderItems = OrderItems::whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc')->get();

        if ($request->input('product_id')) {
            $orderItems = $orderItems->where('product_id', $request->input('product_id'));
        }

              $produkList = Product::all();

 
        
        return view('order_items.index', [
            'orderItems' => $orderItems,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'produkList' => $produkList,
        
        ]);
    }
}
