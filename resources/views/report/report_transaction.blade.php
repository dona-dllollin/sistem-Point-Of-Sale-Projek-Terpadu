@extends('templates/main')
@section('css')
<link rel="stylesheet" href="{{ asset('css/report/report_transaction/style.css') }}">
@endsection
@section('content')
<div class="row page-title-header">
  <div class="col-12">
    <div class="page-header d-flex justify-content-between align-items-center">
      <h4 class="page-title">Laporan Transaksi</h4>
      <div class="print-btn-group">
        <div class="input-group">
          <div class="input-group-prepend">
            <div class="input-group-text">
              <i class="mdi mdi-export print-icon"></i>
            </div>
            <button class="btn btn-print" type="button" data-toggle="modal" data-target="#cetakModal">Export Laporan</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row modal-group">
  <div class="modal fade" id="cetakModal" tabindex="-1" role="dialog" aria-labelledby="cetakModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="cetakModalLabel">Export Laporan</h5>
          <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ url('/report/transaction/export') }}" name="export_form" method="POST" target="_blank">
            @csrf
            <div class="row">
              <div class="col-12">
                <div class="form-group row">
                  <div class="col-5 border rounded-left offset-col-1">
                    <div class="form-radio">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="jns_laporan" value="period" checked> Periode</label>
                    </div>
                  </div>
                  <div class="col-5 border rounded-right">
                    <div class="form-radio">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="jns_laporan" value="manual"> Manual</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 period-form">
                <div class="form-group row">
                  <div class="col-10 p-0 offset-col-1">
                    <p>Pilih waktu dan periode</p>
                  </div>
                  <div class="col-4 p-0 offset-col-1">
                    <input type="number" class="form-control form-control-lg time-input number-input dis-backspace input-notzero" name="time" value="1" min="1" max="4">
                  </div>
                  <div class="col-6 p-0">
                    <select class="form-control form-control-lg period-select" name="period">
                      <option value="minggu" selected="">Minggu</option>
                      <option value="bulan">Bulan</option>
                      <option value="tahun">Tahun</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-12 manual-form" hidden="">
                <div class="form-group row">
                  <div class="col-10 p-0 offset-col-1">
                    <p>Pilih tanggal awal dan akhir</p>
                  </div>
                  <div class="col-10 p-0 offset-col-1 input-group mb-2">
                    <input type="date" name="tgl_awal_export" class="form-control form-control-lg date" placeholder="Tanggal awal">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <i class="mdi mdi-calendar calendar-icon"></i>
                      </div>
                    </div>
                  </div>
                  <div class="col-10 p-0 offset-col-1 input-group">
                    <input type="date" name="tgl_akhir_export" class="form-control form-control-lg date" placeholder="Tanggal akhir">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <i class="mdi mdi-calendar calendar-icon"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-export">Export</button>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-12 mb-4">
    <div class="card card-noborder b-radius">
      <div class="card-body">
        <div class="row">
          <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
              <h5>Statistik Pemasukan</h5>
              <div class=" period-form col-4">
                <div class="form-group">
                  <form action="{{ url('/report/transaction')}}" method="GET">
                      <p>Filter Berdasarkan periode</p>
                    <select name="filter" class="form-control form-control-lg market-select" onchange="this.form.submit()" style="width: 100%">
                      <option value="hari" {{ $filter === 'hari' ? 'selected' : '' }}>Hari Ini</option>
                      <option value="minggu" {{ $filter === 'minggu' ? 'selected' : '' }}>1 Minggu Terakhir</option>
                      <option value="bulan" {{ $filter === 'bulan' ? 'selected' : '' }}>1 Bulan Terakhir</option>
                      <option value="tahun" {{ $filter === 'tahun' ? 'selected' : '' }}>1 Tahun Terakhir</option>
                      <option value="semua" {{ $filter === 'semua' ? 'selected' : '' }}>semua periode</option>
        
                       
                    </select>
                  </form>
                </div>
            </div>
          </div>
          <div class="col-12 mt-4">
            <div style="width: 100%; height: 300px;">
                <canvas id="myChart" ></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 grid-margin">
    <div class="card card-noborder b-radius">
      <div class="card-body">
        <div class="row">
          <div class="col-12 mb-2">
            <form name="filter_form" method="GET" action="{{ route('report.transaction') }}">
              @csrf
              <div class="form-group row align-items-center filter-group">
                <div class="col-lg-4 col-md-12 col-sm-12 col-12 search-div">
                  <input type="text" name="search" class="form-control form-control-lg" placeholder="Cari transaksi">
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 input-group">
                  <input type="date" name="tgl_awal" class="form-control form-control-lg date" placeholder="Tanggal awal">
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 input-group tgl-akhir-div">
                  <input type="date" name="tgl_akhir"  class="form-control form-control-lg date" placeholder="Tanggal akhir">
                </div>
                <div class="col-lg-2 col-md-4 col-sm-12 col-12 filter-btn-div">
                  <button class="btn btn-filter btn-sm btn-block" type="submit">Filter</button>
                </div>
              </div>
            </form>
          </div>
        	<div class="col-12">
            <ul class="list-date">
              @foreach($dates as $date)
              <li class="txt-light">{{ date('d M, Y', strtotime($date)) }}</li>
              {{-- <h4>{{ \Carbon\Carbon::parse($date)->format('d M Y') }}</h4> --}}
              <div class="table-responsive">
                <table class="table table-custom">
                  <tr>
                    <th>Kode Transaksi</th>
                    <th>Total</th>
                    <th>Bayar</th>
                    <th>Kembali</th>
                    <th></th>
                  </tr>
                  @foreach($transactions->where('created_at', '>=', $date . ' 00:00:00')->where('created_at', '<=', $date . ' 23:59:59') as $trx)
                  <tr>
                    <td class="td-1">
                      <span class="d-block font-weight-bold big-font">{{ $trx->kode_transaksi }}</span>
                      <span class="d-block mt-2 txt-light">{{ date('d M, Y', strtotime($trx->created_at)) . ' pada ' . date('H:i', strtotime($trx->created_at)) }}</span>
                    </td>
                    <td><span class="ammount-box bg-green"><i class="mdi mdi-coin"></i></span>Rp. {{ number_format($trx->total,2,',','.') }}</td>
                    <td class="text-success font-weight-bold">- Rp. {{ number_format($trx->bayar,2,',','.') }}</td>
                    <td>Rp. {{ number_format($trx->kembali,2,',','.') }}</td>
                    <td>
                      <button class="btn btn-selengkapnya font-weight-bold" type="button" data-target="#dropdownTransaksi{{ $trx->kode_transaksi }}"><i class="mdi mdi-chevron-down arrow-view"></i></button>
                    </td>
                  </tr>
                  <tr id="dropdownTransaksi{{ $trx->kode_transaksi }}" data-status="0" class="dis-none">
                    <td colspan="5" class="dropdown-content">
                      <div class="d-flex justify-content-between align-items-center">
                        <div class="kasir mb-3">
                          Kasir : {{ $trx->kasir->nama ?? 'Tidak ditemukan' }}
                        </div>
                        <div class="total-barang mb-3">
                          Total Barang : {{ $trx->item->count() }}
                        </div>
                      </div>
                      <table class="table">
                        @foreach($trx->item as $product)
                        <tr>
                          <td><span class="numbering">{{ $loop->iteration }}</span></td>
                          <td>
                            <span class="bold-td">{{ $product->product->nama_barang ?? "kosong"}}</span>
                            <span class="light-td mt-1">{{ $product->product->kode_barang ?? "kosong"}}</span>
                          </td>
                          <td><span class="ammount-box-2 bg-secondary"><i class="mdi mdi-cube-outline"></i></span> {{ $product->total_barang }}</td>
                          <td>
                            <span class="light-td mb-1">Harga</span>
                            <span class="bold-td">Rp. {{ number_format($product->product?->harga_jual,2,',','.')  }}</span>
                          </td>
                          <td>
                            <span class="light-td mb-1">Total Barang</span>
                            <span class="bold-td">Rp. {{ number_format($product->subtotal,2,',','.') }}</span>
                          </td>
                        </tr>
                        @endforeach
                      </table>
                    </td>
                  </tr>
                  @endforeach
                </table>
              </div>
              @endforeach
            </ul>
        	</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script src="{{ asset('plugins/js/Chart.min.js') }}"></script>
<script src="{{ asset('js/report/report_transaction/script.js') }}"></script>
<script type="text/javascript">
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($chartData->pluck('tanggal')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M Y'))) !!},
        datasets: [{
            label: '',
            data: {!! json_encode($chartData->pluck('total')) !!},
            backgroundColor: 'RGB(211, 234, 252)',
            borderColor: 'RGB(44, 77, 240)',
            borderWidth: 3
        }]
    },
    options: {
      responsive: true,
    maintainAspectRatio: false,
    animation: {
        duration: 0
    },
        title: {
            display: false,
            text: ''
        },
        scales: {
            yAxes: [{
              ticks: {
                  beginAtZero: false,
                  callback: function(value, index, values) {
                    if (parseInt(value) >= 1000) {
                       return 'Rp. ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    } else {
                       return 'Rp. ' + value;
                    }
                 }
              }
          }]
        },
        legend: {
            display: false
        },
        tooltips: {
            callbacks: {
               label: function(tooltipItem) {
                      return tooltipItem.yLabel;
               }
            }
        }
    }
});

// function changeData(chart, label_array, data_array){
//   chart.data = {
//       labels: label_array,
//       datasets: [{
//           label: '',
//           data: data_array,
//           backgroundColor: 'RGB(211, 234, 252)',
//           borderColor: 'RGB(44, 77, 240)',
//           borderWidth: 3
//       }]
//   }
//   chart.update();
// }

// $(document).on('submit', 'form[name=filter_form]', function(e){
//   e.preventDefault();
//   var request = new FormData(this);
//   $.ajax({
//       url: "{{ url('/report/transaction/filter') }}",
//       method: "POST",
//       data: request,
//       contentType: false,
//       cache: false,
//       processData: false,
//       success:function(data){
//         $('.list-date').html(data);
//       }
//   });
// });

// $(document).on('click', '.chart-filter', function(e){
//   e.preventDefault();
//   var data_filter = $(this).attr('data-filter');
//   if(data_filter == 'minggu'){
//     $('.btn-filter-chart').html('1 Minggu Terakhir');
//   }else if(data_filter == 'bulan'){
//     $('.btn-filter-chart').html('1 Bulan Terakhir');
//   }else if(data_filter == 'tahun'){
//     $('.btn-filter-chart').html('1 Tahun Terakhir');
//   }
//   $.ajax({
//     url: "{{ url('/report/transaction/chart') }}/" + data_filter,
//     method: "GET",
//     success:function(response){
//       if(response.incomes.length != 0){
//         changeData(myChart, response.incomes, response.total);
//       }
//     }
//   });
// });
</script>
@endsection