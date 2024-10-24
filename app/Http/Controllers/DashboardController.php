<?php

namespace App\Http\Controllers;

use App\Models\Market;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    function viewDashboard()
    {
        if (Auth::user()->role === 'admin') {

            $kd_transaction = Transaction::select('kode_transaksi')
                ->latest()
                ->distinct()
                ->take(5)
                ->get();

            $transactions = Transaction::all();
            $array = array();
            foreach ($transactions as $no => $transaction) {
                array_push($array, $transactions[$no]->created_at->toDateString());
            }
            $dates = array_unique($array);
            rsort($dates);

            $arr_ammount = count($dates);

            $incomes_data = array();

            if ($arr_ammount > 7) {
                for ($i = 0; $i < 7; $i++) {
                    array_push($incomes_data, $dates[$i]);
                }
            } elseif ($arr_ammount > 0) {
                for ($i = 0; $i < $arr_ammount; $i++) {
                    array_push($incomes_data, $dates[$i]);
                }
            }
            $incomes = array_reverse($incomes_data);
            $kode_transaksi_dis = Transaction::select('kode_transaksi')
                ->distinct()
                ->get();

            $kode_transaksi_dis_daily = Transaction::whereDate('created_at', Carbon::now())
                ->select('kode_transaksi')
                ->distinct()
                ->get();

            $all_incomes = 0;
            $incomes_daily = 0;
            foreach ($kode_transaksi_dis as $kode) {
                $transaksi = Transaction::where('kode_transaksi', $kode->kode_transaksi)->first();
                $all_incomes += $transaksi->total;
            }
            foreach ($kode_transaksi_dis_daily as $kode) {
                $transaksi_daily = Transaction::where('kode_transaksi', $kode->kode_transaksi)->first();
                $incomes_daily += $transaksi_daily->total;
            }
            $customers_daily = count($kode_transaksi_dis_daily);
            $min_date = Transaction::min('created_at');
            $max_date = Transaction::max('created_at');
            // $market = Market::first();

            return view('dashboard', compact('kd_transaction', 'incomes', 'incomes_daily', 'customers_daily', 'all_incomes', 'min_date', 'max_date'));
        } else if (Auth::user()->role === 'kasir') {
        } else {
        }
    }
}
