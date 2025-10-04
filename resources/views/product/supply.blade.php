@extends('templates/main')
@section('css')
<link rel="stylesheet" href="{{ asset('css/manage_product/supply_product/supply/style.css') }}">
{{-- <link rel="stylesheet" href="{{ asset('css/manage_product/supply_product/statistics_supply/style.css') }}"> --}}
<link rel="stylesheet" href="{{ asset('css/manage_product/product/pagination.css') }}">

 <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.css" rel="stylesheet" />


   <style>
    /* Select2 v3.5.4 custom style agar mirip Bootstrap 4/5 */
.select2-container {
  display: block;
  width: 100% !important;
  box-sizing: border-box;
  margin-bottom: 0.5rem;
  font-size: 0.875rem;
  font-family: inherit;
}

.select2-container .select2-choice {
  height: 38px;
  padding: 0.375rem 0.75rem;
  border: 1px solid #ced4da;
  border-radius: 0.375rem;
  background-color: #fff;
  background-image: none;
  line-height: 1.5;
  color: #495057;
}

.select2-container .select2-choice .select2-arrow {
  border-left: none;
  background: none;
}

.select2-drop {
  border: 1px solid #ced4da;
  border-radius: 0.375rem;
  box-shadow: 0 0.25rem 0.75rem rgba(0,0,0,.05);
  margin-top: 2px;
  padding: 4px;
}

.select2-results .select2-highlighted {
  background-color: #007bff;
  color: white;
}

   </style>
@endsection
@section('content')
<div class="row page-title-header">
  <div class="col-12">
    <div class="page-header d-flex justify-content-between align-items-center">
      <h4 class="page-title">Riwayat Pasok</h4>
      <div class="d-flex justify-content-start">
        @if(auth()->user()->role == 'admin')
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
        @endif
        <div class="dropdown dropdown-search">
          <button class="btn btn-icons btn-inverse-primary btn-filter shadow-sm ml-2" type="button" id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="mdi mdi-magnify"></i>
          </button>
          <div class="dropdown-menu search-dropdown" aria-labelledby="dropdownMenuIconButton1">
            <div class="row">
              <div class="col-11">
                <input type="text" class="form-control" name="search" placeholder="Cari barang">
              </div>
            </div>
          </div>
        </div>
	      <a href="{{ url('/supply/new') }}" class="btn btn-icons btn-inverse-primary btn-new ml-2">
	      	<i class="mdi mdi-plus"></i>
	      </a>
      </div>
    </div>
  </div>
</div>

@forEach($supply as $trx)
  {{-- Modal untuk menampilkan form edit stok --}}
    <div class="modal fade" id="stokModal{{$trx->id}}" tabindex="-1" role="dialog" aria-labelledby="StokModalLabel{{$trx->id}}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Stok : {{$trx->product?->nama_barang}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form method="post" action="{{url('/supply/update/'. $trx->id)}}" id="stok_form_{{$trx->id}}" name="stok_form">
                @csrf
                <div class="form-group">
                <label>Jumlah Stok</label>
               <input type="text" class="form-control" name="jumlah" value="{{ old('jumlah', $trx->jumlah) }}" min="0" max="{{ $trx->jumlah }}" required>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="submit" id="submitAngsurBtn{{$trx->id}}" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </div>
    </form>
        </div>
    </div>
  @endforeach
<div class="row">

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
          <form action="{{ url('/supply/statistics/export') }}" name="export_form" method="POST" target="_blank">
            @csrf
            <div class="row ml-5">
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
                  </div>
                  <div class="col-10 p-0 offset-col-1 input-group">
                    <input type="date" name="tgl_akhir_export" class="form-control form-control-lg date" placeholder="Tanggal akhir">
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group row">
                  <div class="col-2  offset-col-1">
                    <div class="form-radio">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="format" value="pdf" checked> pdf</label>
                    </div>
                  </div>
                  <div class="col-2 ">
                    <div class="form-radio">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="format" value="excel"> excel</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 period-form">
                <div class="form-group row">
                  <div class="col-10 p-0 offset-col-1">
                    <p>Pilih Barang</p>
                  </div>
                  
                  <div class="col-10 p-0">
                     
                    <select name="kode_barang" id="kode_barang" class=" form-select select2">
                        <option value="">-- Pilih Produk --</option>
                        @foreach($produkList as $produk)
                            <option value="{{ $produk->kode_barang }}">
                                {{ $produk->nama_barang }} ({{ $produk->kode_barang }})
                            </option>
                        @endforeach
                    </select>
                  
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

  <div class="col-md-12 grid-margin">
    <div class="row align-items-center">
            <div class="col-lg-2 col-md-2 col-sm-2 mb-3">
               
            </div>
            <div class="col-lg-10 col-md-12 col-sm-12">
                <form name="filter_form" method="GET" action="{{ url('/supply') }}">
                    @csrf
                    <div class="form-row align-items-center">
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-2">
                            <p>Pilih Produk</p>
                            <select name="product_id" class=" select2">
                                <option value="">-- Semua Produk --</option>
                                @foreach($produkList as $produk)
                                    <option value="{{ $produk->id }}">
                                        {{ $produk->nama_barang }} ({{ $produk->kode_barang }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                              <p>Pilih tanggal awal</p>
                            <input type="date" name="start_date" class="form-control form-control-lg date" placeholder="Tanggal awal">
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12 mb-2">
                              <p>Pilih tanggal akhir</p>
                            <input type="date" name="end_date" class="form-control form-control-lg date" placeholder="Tanggal akhir">
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12 mb-2 mt-4"> 
                            <button class="btn btn-primary btn-sm btn-block button-filter" type="button">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <div class="card card-noborder b-radius">
      <div class="card-body">
        <div class="row">
        	<div class="col-12">
            <ul class="list-date">
              @foreach($suppliesByDate as $date => $supplies)
              <div class="product-item">
              <li class="txt-light">{{ date('d M, Y', strtotime($date)) }}</li>
              <div class="table-responsive">
                <table class="table table-custom">
                  <tr>
                    <th>Nama Barang</th>
                    <th>Kode Barang</th>
                    <th>Jumlah</th>
                    <th>Harga Beli</th>
                    <th>Total</th>
                    <th>Pemasok</th>
                  </tr>
                  @foreach($supplies as $supply)
                  <tr class="supply-row">
                    <td class="td-1">
                      <span class="d-block font-weight-bold big-font">{{ $supply->product?->nama_barang }}</span>
                      <span class="d-block mt-2 txt-light">{{ date('d M, Y', strtotime($supply->created_at)) . ' pada ' . date('H:i', strtotime($supply->created_at)) }}</span>
                    </td>
                    <td class="td-2 font-weight-bold">{{ $supply->kode_barang }}</td>
                    <td class="td-3 font-weight-bold"><span class="ammount-box bg-secondary"><i class="mdi mdi-cube-outline"></i></span>{{ $supply->jumlah }}</td>
                    <td class="font-weight-bold td-4"><input type="text" name="harga" value="{{ $supply->harga_beli }}" hidden=""><span class="ammount-box bg-green"><i class="mdi mdi-coin"></i></span>Rp. {{ number_format($supply->harga_beli,2,',','.') }}</td>
                    <td class="total-field font-weight-bold text-success"></td>
                    <td class="font-weight-bold text-Primary">{{$supply->user?->nama}}</td>
                    <td>
                         <button type="button" class="btn btn-edit btn-icons btn-rounded btn-secondary" style="background-color: yellow" data-toggle="modal" data-target="#stokModal{{$supply->id}}" >
                        <i class="mdi mdi-pencil"></i>
                    </button>
                    </td>
                  </tr>
                  @endforeach
                </table>
              </div>
            </div>
              @endforeach
            </ul>
            <div class="pagination-container">
              <ul class="pagination"></ul>
            </div>
        	</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/manage_product/supply_product/supply/script.js') }}"></script>
<script src="{{ asset('js/report/report_transaction/pagination.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.js"></script>
<script type="text/javascript">
  @if ($message = Session::get('create_success'))
    swal(
        "Berhasil!",
        "{{ $message }}",
        "success"
    );
  @endif

  @if ($message = Session::get('success'))
    swal(
        "Berhasil!",
        "{{ $message }}",
        "success"
    );
  @endif

   @if ($errors->any())
  @foreach($errors->all() as $error)
  
      swal(
          "",
          "{{ $error }}",
          "error"
      );
  
  @endforeach
@endif


   $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Cari produk...",
            allowClear: true,
            width: '100%'
        });
    });


     $(document).on("click", ".button-filter", function () {
    var tgl_awal = $("input[name=start_date]").val();
    var tgl_akhir = $("input[name=end_date]").val();

    var sArray = tgl_awal.split("-");
    var sDate = new Date(sArray[2], sArray[1], sArray[0]);
    var eArray = tgl_akhir.split("-");
    var eDate = new Date(eArray[2], eArray[1], eArray[0]);
    if (eDate < sDate) {
        swal("", "Tanggal akhir tidak boleh kurang dari tanggal awal", "error");
    } else {
        $("form[name=filter_form]").submit();
    }
});
     
</script>
@endsection