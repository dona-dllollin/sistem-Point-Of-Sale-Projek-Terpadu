<?php

namespace App\Http\Controllers;

use App\Models\Market;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    function viewDashboard(Request $request)
    {
        $user = auth()->user();

        if ($user->role === 'admin') {



            $marketId = $request->query('market_id');


            $kd_transaction = Transaction::select('kode_transaksi')
                ->when($marketId, function ($query) use ($marketId) {
                    return $query->where('market_id', $marketId);
                })
                ->latest()
                ->distinct()
                ->take(5)
                ->get();

            $transactions = Transaction::when($marketId, function ($query) use ($marketId) {
                return $query->where('market_id', $marketId);
            })->get();

            $kode_transaksi_dis = Transaction::select('kode_transaksi')
                ->when($marketId, function ($query) use ($marketId) {
                    return $query->where('market_id', $marketId);
                })
                ->distinct()
                ->get();

            $kode_transaksi_dis_daily = Transaction::when($marketId, function ($query) use ($marketId) {
                return $query->where('market_id', $marketId);
            })
                ->whereDate('created_at', Carbon::now())
                ->select('kode_transaksi')
                ->distinct()
                ->get();
        } elseif ($user->role === 'kasir') {
            $kd_transaction = Transaction::where('market_id', $user->market_id)
                ->select('kode_transaksi')
                ->latest()
                ->distinct()
                ->take(5)
                ->get();

            $transactions = Transaction::where('market_id', $user->market_id)->get();

            $kode_transaksi_dis = Transaction::where('market_id', $user->market_id)
                ->select('kode_transaksi')
                ->distinct()
                ->get();

            $kode_transaksi_dis_daily = Transaction::where('market_id', $user->market_id)
                ->whereDate('created_at', Carbon::now())
                ->select('kode_transaksi')
                ->distinct()
                ->get();
        }

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


        $all_incomes = 0;
        $incomes_daily = 0;

        foreach ($kode_transaksi_dis as $kode) {
            $transaksi = Transaction::where('kode_transaksi', $kode->kode_transaksi)->first();
            $all_incomes += $transaksi->total_harga;
        }

        foreach ($kode_transaksi_dis_daily as $kode) {
            $transaksi_daily = Transaction::where('kode_transaksi', $kode->kode_transaksi)->first();
            $incomes_daily += $transaksi_daily->total_harga;
        }
        $customers_daily = count($kode_transaksi_dis_daily);
        $min_date = Transaction::min('created_at');
        $max_date = Transaction::max('created_at');
        $markets = Market::all();

        return view('dashboard', compact('kd_transaction', 'incomes', 'incomes_daily', 'customers_daily', 'all_incomes', 'min_date', 'max_date', 'markets'));
    }
}
