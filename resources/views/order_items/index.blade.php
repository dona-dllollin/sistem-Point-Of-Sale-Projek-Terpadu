@extends('templates/main')
@section('css')
 <!-- Custom styles for this page -->
 <link href="{{asset('sbAdmin/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">   <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.css" rel="stylesheet" />


   <style>
    /* Select2 v3.5.4 custom style agar mirip Bootstrap 4/5 */
.select2-container {
  display: block;
  width: 100% !important;
  box-sizing: border-box;
  /* margin-bottom: 0.5rem; */
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


  <!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
    <div class="col-12 mb-2">
        <div class="row align-items-center">
            <div class="col-lg-4 col-md-12 col-sm-12 mb-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Barang Terjual</h6>
            </div>
            <div class="col-lg-8 col-md-12 col-sm-12">
                <form name="filter_form" method="GET" action="{{ url('/order_items') }}">
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
                            <button class="btn btn-primary btn-sm btn-block btn-filter" type="button">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="text-align: center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Transaksi</th>
                        <th>Nama Barang</th>
                        <th>Jumlah Dibeli</th>
                        <th>Harga Barang</th>
                        <th>Total Harga</th>
                        <th>Tanggal Barang Dibeli</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $no = 1;
                    @endphp
                    @foreach ($orderItems as $item)
                    <tr>
                        <td>{{$no++}}</td>
                        <td>{{$item->transaction->kode_transaksi ?? "data transaksi hilang"}}</td>
                        <td>{{$item->product->nama_barang ?? "No Product Found"}}</td>
                        <td>{{$item->total_barang}}</td>
                        <td>{{$item->product->harga_jual ?? "No Product Found"}}</td>
                        <td>{{$item->subtotal}}</td>
                        <td>{{date('d M, Y', strtotime($item->created_at))}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-md-6">
                <p>Total Barang Terjual: <strong>{{ $orderItems->sum('total_barang') }}</strong></p>
            </div>
            <div class="col-md-6 text-right">
                <p>Total Pendapatan: <strong>Rp. {{ number_format($orderItems->sum('subtotal'), 0, ',', '.') }}</strong></p>
            </div>
        </div>
</div>
    
@endsection

@section('script')




<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.js"></script>

      <!-- Page level plugins -->
      <script src="{{asset('sbAdmin/vendor/datatables/jquery.dataTables.min.js')}}"></script>
      <script src="{{asset('sbAdmin/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  
      <!-- Page level custom scripts -->
      <script src="{{asset('sbAdmin/js/demo/datatables-demo.js')}}"></script>

      <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Cari Produk ...",
                allowClear: true,
                width: '100%',
            })
        })


        $(document).on("click", ".btn-filter", function () {
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