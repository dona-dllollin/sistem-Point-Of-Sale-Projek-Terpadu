<?php

namespace App\Http\Controllers;

use App\Models\Market;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function reportTransaction(Request $request)
{
    $user = auth()->user();

    $chartFilter = $request->get('filter', 'tahun');

    if ($chartFilter == 'hari') {
        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->endOfDay();


    } elseif ($chartFilter == 'minggu') {
        $startDate = Carbon::now()->startOfWeek();
        $endDate = Carbon::now()->endOfWeek();


    } elseif ($chartFilter == 'bulan') {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

    } elseif ($chartFilter == 'tahun') {
        $startDate = Carbon::now()->startOfYear();
        $endDate = Carbon::now()->endOfYear();

    } else {
        $startDate = Transaction::min('created_at'); // Ambil data dari transaksi pertama
        $endDate = Transaction::max('created_at');
    }
    // Filter tanggal awal dan akhir
    $dataStart = $request->tgl_awal ?? Transaction::min('created_at');
    $dataEnd = $request->tgl_akhir ?? Transaction::max('created_at');

    // Ambil data transaksi dengan order_items dan product terkait (eager loading)
    $transactions = Transaction::with(['item.product', 'kasir'])
        ->whereBetween('created_at', [$dataStart, $dataEnd])
        ->orderBy('created_at', 'desc')
        ->get();

    // Ambil daftar tanggal unik dari transaksi
    $dates = $transactions->pluck('created_at')->map(fn($dt) => $dt->toDateString())->unique()->values()->all();

    // Siapkan data untuk chart: group by tanggal dan jumlahkan total
    $chartData = Transaction::whereBetween('created_at', [$startDate, $endDate])
        ->selectRaw('DATE(created_at) as tanggal, SUM(total) as total')
        ->groupBy('tanggal')
        ->orderBy('tanggal', 'asc')
        ->get();

    return view('report.report_transaction', [
        'transactions' => $transactions,
        'dates' => $dates,
        'chartData' => $chartData,
        'dataStart' => $dataStart,
        'dataEnd' => $dataEnd,
        'filter' => $chartFilter
    ]);
}


public function exportTransaction(Request $req)
{
    $jenis_laporan = $req->jns_laporan;
    $current_time = Carbon::now()->format('Y-m-d') . ' 23:59:59';

    if ($jenis_laporan == 'period') {
        if ($req->period == 'minggu') {
            $last_time = Carbon::now()->subWeeks($req->time)->format('Y-m-d') . ' 00:00:00';
        } elseif ($req->period == 'bulan') {
            $last_time = Carbon::now()->subMonths($req->time)->format('Y-m-d') . ' 00:00:00';
        } elseif ($req->period == 'tahun') {
            $last_time = Carbon::now()->subYears($req->time)->format('Y-m-d') . ' 00:00:00';
        }
        $tgl_awal = $last_time;
        $tgl_akhir = $current_time;
    } else {
        $tgl_awal = $req->tgl_awal_export;
        $tgl_akhir = $req->tgl_akhir_export;
    }

    $transactions = Transaction::whereBetween('created_at', [$tgl_awal, $tgl_akhir])
        ->orderBy('created_at')
        ->get()
        ->groupBy(function ($item) {
            return $item->created_at->format('Y-m-d');
        });

    $pemasukan = 0;
    foreach ($transactions as $transactionGroup) {
        foreach ($transactionGroup as $transaction) {
            $pemasukan += $transaction->total;
        }
    }

    $market = Market::first();

    $pdf = PDF::loadView('report.export_report_transaction', [
        'groupedTransactions' => $transactions,
        'tgl_awal' => $tgl_awal,
        'tgl_akhir' => $tgl_akhir,
        'market' => $market,
        'pemasukan' => $pemasukan,
    ]);

    return $pdf->stream();
}


}

