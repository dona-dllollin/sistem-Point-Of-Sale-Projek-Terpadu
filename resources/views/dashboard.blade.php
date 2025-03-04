@extends('templates/main')
@section('css')
<link rel="stylesheet" href="{{ asset('css/dashboard/style.css') }}">
@endsection
@section('content')
<div class="row page-title-header">
  <div class="col-12">
    <div class="page-header d-flex justify-content-between align-items-center">
      <h4 class="page-title">Dashboard</h4>
    
      
      <div class=" period-form col-4">
        <div class="form-group">
          <form action="{{ Auth::user()->role === 'admin' ? url('/dashboard') : route('kasir.dashboard', ['slug_market' => session('slug_market')])}}" method="GET">
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
  </div>
</div>

<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-12 col-12">
    <div class="row">
      <div class="col-lg-6 col-md-12 col-sm-6 col-12 mb-4">
        <div class="card b-radius card-noborder">
          <div class="card-body custom-card-p">
            <div class="row">
              <div class="col-12 d-flex justify-content-start align-items-center icon-card">
                <div class="icon-round-2">
                  <i class="mdi mdi-account-multiple"></i>
                </div>
                <div class="ml-3">
                  <p class="m-0">Total Pelanggan</p>
                  <h5>{{ $total_pelanggan }} Orang</h5>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6 col-md-12 col-sm-6 col-12 mb-4">
        <div class="card b-radius card-noborder bg-blue">
          <div class="card-body custom-card-p">
            <div class="row">
              <div class="col-12 d-flex justify-content-start align-items-center icon-card">
                <div class="icon-round text-white">
                  Rp
                </div>
                <div class="ml-3">
                  <p class="m-0 text-white">Total Pemasukan</p>
                  <h5 class="text-white">{{ number_format($total_pemasukan,2,',','.') }}</h5>
                  {{-- <p class="m-0 txt-light">{{ date('d M, Y', strtotime($min_date)) }} - {{ date('d M, Y', strtotime($max_date)) }}</p> --}}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-4">
        <div class="card b-radius card-noborder">
          <div class="card-body">
            <div class="row">
              <div class="col-12 mb-4 d-flex justify-content-between align-items-center">
                <h5 class="font-weight-semibold chart-title">{{ $filter !== 'semua' ? 'Pemasukan 1 ' . $filter . ' Terakhir' : 'Pemasukan pada semua periode' }}</h5>
              </div>
              <div class="col-12">
                <canvas id="incomeChart" style="width: 100%; height: 315px;"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-6 col-md-6 col-sm-12 col-12">
    <div class="row">
      <div class="col-lg-6 col-md-12 col-sm-6 col-12 mb-4">
        <div class="card b-radius card-noborder bg-red">
          <div class="card-body custom-card-p">
            <div class="row">
              <div class="col-12 d-flex justify-content-start align-items-center icon-card">
                <div class="icon-round-3 text-white">
                  Rp
                </div>
                <div class="ml-3">
                  <p class="m-0 text-white">Total Pengeluaran</p>
                  <h5 class="text-white">{{ number_format($total_pengeluaran,2,',','.') }}</h5>
                  {{-- <p class="m-0 txt-light">{{ date('d M, Y', strtotime($min_date)) }} - {{ date('d M, Y', strtotime($max_date)) }}</p> --}}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-12 col-sm-6 col-12 mb-4">
        <div class="card b-radius card-noborder bg-hijau">
          <div class="card-body custom-card-p">
            <div class="row">
              <div class="col-12 d-flex justify-content-start align-items-center icon-card">
                <div class="icon-round-4 text-white">
                  Rp
                </div>
                <div class="ml-3">
                  <p class="m-0 text-white">Total Keuntungan</p>
                  <h5 class="text-white">{{ number_format($total_keuntungan,2,',','.') }}</h5>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-4">
        <div class="card b-radius card-noborder">
          <div class="card-body">
            <div class="row">
              <div class="col-12 mb-4 d-flex justify-content-between align-items-center">
                <h5 class="font-weight-semibold chart-title">{{ $filter !== 'semua' ? 'Pengeluaran 1 ' . $filter . ' Terakhir' : 'Pengeluaran pada semua periode' }}</h5>
              </div>
              <div class="col-12">
                <canvas id="expenseChart" style="width: 100%; height: 315px;"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/dashboard/script.js') }}"></script>
<script src="{{ asset('plugins/js/Chart.min.js') }}"></script>
<script src="{{ asset('plugins/js/ChartRadius.js') }}"></script>
<script type="text/javascript">
@if ($message = Session::get('update_success'))
  swal(
      "Berhasil!",
      "{{ $message }}",
      "success"
  );
@endif
  
var ctx = document.getElementById('incomeChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_map(fn($date) => date('d M, Y', strtotime($date)), array_keys($incomeData->toArray()))) !!},
        datasets: [{
            label: 'Pemasukan',
            data:{!! json_encode(array_values($incomeData->toArray())) !!},
            backgroundColor: 'RGB(44, 77, 240)',
            borderColor: 'RGB(44, 77, 240)',
            borderWidth: 0
        }]
    },
    options: {
        title: {
            display: false,
            text: ''
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    callback: function(value, index, values) {
                      if (parseInt(value) >= 1000) {
                         return 'Rp. ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                      } else {
                         return 'Rp. ' + value;
                      }
                   }
                }
            }],
            xAxes: [{
                barPercentage: 0.2
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

var ctz = document.getElementById('expenseChart').getContext('2d');
var myChart = new Chart(ctz, {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_map(fn($date) => date('d M, Y', strtotime($date)), array_keys($expenseData->toArray()))) !!},
        datasets: [{
            label: 'Pengeluaran',
            data:{!! json_encode(array_values($expenseData->toArray())) !!},
            backgroundColor: 'RGB(168, 60, 50)',
            borderColor: 'RGB(168, 60, 50)',
            borderWidth: 0
        }]
    },
    options: {
        title: {
            display: false,
            text: ''
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    callback: function(value, index, values) {
                      if (parseInt(value) >= 1000) {
                         return 'Rp. ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                      } else {
                         return 'Rp. ' + value;
                      }
                   }
                }
            }],
            xAxes: [{
                barPercentage: 0.2
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





</script>
@endsection