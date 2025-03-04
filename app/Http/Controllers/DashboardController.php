<?php

namespace App\Http\Controllers;

use App\Models\Market;
use App\Models\Pengeluaran;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{


    public function viewDashboard(Request $request)
    {
        $filter = $request->get('filter', 'tahun');

        $startDate = now();
        $endDate = now();

        $startDateExp = now();
        $endDateExp = now();

        if ($filter == 'hari') {
            $startDate = $startDate->startOfDay();
            $endDate = $endDate->endOfDay();

            $startDateExp = $startDate->startOfDay();
            $endDateExp = $endDate->endOfDay();

        } elseif ($filter == 'minggu') {
            $startDate = $startDate->startOfWeek();
            $endDate = $endDate->endOfWeek();

            $startDateExp = $startDate->startOfWeek();
            $endDateExp = $endDate->endOfWeek();
        } elseif ($filter == 'bulan') {
            $startDate = $startDate->startOfMonth();
            $endDate = $endDate->endOfMonth();

            $startDateExp = $startDate->startOfMonth();
            $endDateExp = $endDate->endOfMonth();
        } elseif ($filter == 'tahun') {
            $startDate = $startDate->startOfYear();
            $endDate = $endDate->endOfYear();

            $startDateExp = $startDate->startOfYear();
            $endDateExp = $endDate->endOfYear();
        } else {
            $startDate = Transaction::min('created_at'); // Ambil data dari transaksi pertama
            $endDate = Transaction::max('created_at');

            $startDateExp = Pengeluaran::min('created_at');
            $endDateExp = Pengeluaran::max('created_at');
        }


        // Hitung total pelanggan (jumlah transaksi unik)
        $total_pelanggan = Transaction::whereBetween('created_at', [$startDate, $endDate])->distinct('kode_transaksi')->count('kode_transaksi');

        // Hitung total pemasukan
        $total_pemasukan = Transaction::whereBetween('created_at', [$startDate, $endDate])
        ->sum('total');

        // Hitung total pengeluaran
        $total_pengeluaran = Pengeluaran::whereBetween('created_at', [$startDateExp, $endDateExp])
        ->sum('jumlah');

        // Hitung total keuntungan
        $total_keuntungan = $total_pemasukan - $total_pengeluaran;

          // Ambil data pemasukan & pengeluaran untuk chart
          $incomeData = Transaction::whereBetween('created_at', [$startDate, $endDate])
          ->selectRaw('DATE(created_at) as tanggal, SUM(total) as total')
          ->groupBy('tanggal')
          ->orderBy('tanggal')
          ->pluck('total', 'tanggal');

      $expenseData = Pengeluaran::whereBetween('created_at', [$startDateExp, $endDateExp])
          ->selectRaw('DATE(created_at) as tanggal, SUM(jumlah) as total')
          ->groupBy('tanggal')
          ->orderBy('tanggal')
          ->pluck('total', 'tanggal');

        // Ambil tanggal transaksi tertua dan terbaru
        $min_date = Transaction::min('created_at');
        $max_date = Transaction::max('created_at');

        return view('dashboard', compact(
            'incomeData', 
            'total_pelanggan', 
            'total_pemasukan', 
            'total_pengeluaran', 
            'total_keuntungan', 
            'filter',
            'expenseData',
            'min_date', 
            'max_date'
        ));
    }
}
