@extends('templates/main')
@section('css')
<link rel="stylesheet" href="{{ asset('css/dashboard/style.css') }}">
@endsection
@section('content')
<div class="row page-title-header">
  <div class="col-12">
    <div class="page-header d-flex justify-content-between align-items-center">
      <h4 class="page-title">Dashboard</h4>
    
      {{-- @if(auth()->user()->role === 'admin')
      <div class=" period-form col-4">
        <div class="form-group">
              <p>Filter Berdasarkan Toko</p>
            <select name="market_id" class="form-control form-control-lg market-select" style="width: 100%">
              <option value="all" {{ request('market_id') === 'all' ? 'selected' : '' }}>semua Toko</option>
                @foreach ($markets as $market)
                    <option value="{{ $market->id }}" {{ $market->id == request('market_id') ? 'selected' : '' }}>{{ $market->nama_toko }}</option>
                @endforeach
            </select>
        </div>
      </div>
      @endif --}}
      
    
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
                  <h5>{{ $customers_daily }} Orang</h5>
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
                  <h5 class="text-white">{{ number_format($all_incomes,2,',','.') }}</h5>
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
                <h5 class="font-weight-semibold chart-title">Pemasukan 1 Minggu Terakhir</h5>
                <div class="dropdown">
                  <button class="btn btn-filter-chart icon-btn dropdown-toggle" type="button" id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Minggu
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton1">
                    <a class="dropdown-item chart-filter" href="#" data-filter="hari">Hari</a>
                    <a class="dropdown-item chart-filter" href="#" data-filter="minggu">Minggu</a>
                    <a class="dropdown-item chart-filter" href="#" data-filter="bulan">Bulan</a>
                    <a class="dropdown-item chart-filter" href="#" data-filter="tahun">Tahun</a>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <canvas id="myChart" style="width: 100%; height: 315px;"></canvas>
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
                  <h5 class="text-white">{{ number_format($all_incomes,2,',','.') }}</h5>
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
                  <h5 class="text-white">{{ $customers_daily }} Orang</h5>
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
                <h5 class="font-weight-semibold chart-title">Pemasukan 1 Minggu Terakhir</h5>
                <div class="dropdown">
                  <button class="btn btn-filter-chart icon-btn dropdown-toggle" type="button" id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Minggu
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton1">
                    <a class="dropdown-item chart-filter" href="#" data-filter="hari">Hari</a>
                    <a class="dropdown-item chart-filter" href="#" data-filter="minggu">Minggu</a>
                    <a class="dropdown-item chart-filter" href="#" data-filter="bulan">Bulan</a>
                    <a class="dropdown-item chart-filter" href="#" data-filter="tahun">Tahun</a>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <canvas id="myChart" style="width: 100%; height: 315px;"></canvas>
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
  
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
        @if(count($incomes) != 0)
        @foreach($incomes as $income)
        "{{ date('d M, Y', strtotime($income)) }}",
        @endforeach
        @endif
        ],
        datasets: [{
            label: '',
            data: [
            @if(count($incomes) != 0)
            @foreach($incomes as $income)
            @php
            $total = \App\Models\Transaction::whereDate('created_at', $income)
            ->sum('total_harga');
            @endphp
            "{{ $total }}",
            @endforeach
            @endif
            ],
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

$(document).on('click', '.chart-filter', function(e){
  e.preventDefault();
  var data_filter = $(this).attr('data-filter');
  if(data_filter == 'hari'){
    $('.btn-filter-chart').html('Hari');
    $('.chart-title').html('Pemasukan 1 Hari Terakhir');
  }else if(data_filter == 'minggu'){
    $('.btn-filter-chart').html('Minggu');
    $('.chart-title').html('Pelanggan 1 Minggu Terakhir');
  }
  $.ajax({
    url: "{{ url('/dashboard/chart') }}/" + data_filter,
    method: "GET",
    success:function(response){
      if(data_filter == 'pemasukan'){
        if(response.incomes.length != 0){
          changeDataPemasukan(myChart, response.incomes, response.total);
        }
      }else if(data_filter == 'pelanggan'){
        if(response.customers.length != 0){
          changeDataPelanggan(myChart, response.customers, response.jumlah);
        }
      }
    }
  });
});

// $(document).on('click', '.btn-view-transaction', function(){
//   var check_access = $(this).attr('data-access');
//   if(check_access == 1){
//     window.open("{{ url('/report/transaction') }}", "_self");
//   }else{
//     swal(
//         "",
//         "Maaf anda tidak memiliki akses",
//         "error"
//     );
//   }
// });


//filter market
$(document).on('change', '.market-select', function(){
  const url = new URL(window.location.href)
  if ($(this).val() !== 'all'){
    url.searchParams.set('market_id', $(this).val())
  } else {
    url.searchParams.delete('market_id')
  }
  window.location.href = url.toString()
})
</script>
@endsection