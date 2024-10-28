@extends('templates/main')
@section('css')
<link rel="stylesheet" href="{{ asset('css/manage_product/product/style.css') }}">
@endsection
@section('content')
<div class="row page-title-header">
  <div class="col-12">
    <div class="page-header d-flex justify-content-between align-items-center">
      <h4 class="page-title">Daftar Barang</h4>
      <div class="d-flex justify-content-start">
      	<div class="dropdown">
	        <button class="btn btn-icons btn-inverse-primary btn-filter shadow-sm" type="button" id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	          <i class="mdi mdi-filter-variant"></i>
	        </button>
	        <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton1">
	          <h6 class="dropdown-header">Urut Berdasarkan :</h6>
	          <div class="dropdown-divider"></div>
	        <a href="{{Auth::user()->role === 'admin' ? route('admin.product', ['filter' => 'kode_barang']) : route('kasir.product', ['slug_market' => session('slug_market'), 'filter' => 'kode_barang'])}}" class="dropdown-item filter-btn" data-filter="kode_barang">Kode Barang</a>
            <a href="{{Auth::user()->role === 'admin' ? route('admin.product', ['filter' => 'nama_barang']) : route('kasir.product', ['slug_market' => session('slug_market'), 'filter' => 'nama_barang'])}}" class="dropdown-item filter-btn" data-filter="nama_barang">Nama Barang</a>
            <a href="{{Auth::user()->role === 'admin' ? route('admin.product', ['filter' => 'satuan']) : route('kasir.product', ['slug_market' => session('slug_market'), 'filter' => 'satuan'])}}" class="dropdown-item filter-btn" data-filter="satuan_barang">Satuan Barang</a>
            <a href="{{Auth::user()->role === 'admin' ? route('admin.product', ['filter' => 'stok']) : route('kasir.product', ['slug_market' => session('slug_market'), 'filter' => 'stok'])}}" class="dropdown-item filter-btn" data-filter="stok">Stok Barang</a>
            <a href="{{Auth::user()->role === 'admin' ? route('admin.product', ['filter' => 'harga_jual']) : route('kasir.product', ['slug_market' => session('slug_market'), 'filter' => 'harga_jual'])}}" class="dropdown-item filter-btn" data-filter="harga">Harga Barang</a>
            <a href="{{Auth::user()->role === 'admin' ? route('admin.product', ['filter' => 'market_id']) : route('kasir.product', ['slug_market' => session('slug_market'), 'filter' => 'market_id'])}}" class="dropdown-item filter-btn" data-filter="toko"> Toko</a>
	        </div>
	    </div>
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
	      <a href="{{ url('/product/new') }}" class="btn btn-icons btn-inverse-primary btn-new ml-2">
	      	<i class="mdi mdi-plus"></i>
	      </a>
      </div>
    </div>
  </div>
</div>
<div class="row modal-group">
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{ url('/product/update') }}" method="post" name="update_form">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit Barang</h5>
            <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="edit-modal-body">
              @csrf
              <div class="row" hidden="">
                <div class="col-12">
                  <input type="text" name="id">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-lg-3 col-md-3 col-sm-12 col-form-label font-weight-bold">Kode Barang</label>
                <div class="col-lg-7 col-md-7 col-sm-10 col-10">
                  <input type="text" class="form-control" name="kode_barang">
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-2">
                  <button class="btn btn-inverse-primary btn-sm btn-scan shadow-sm" type="button"><i class="mdi mdi-crop-free"></i></button>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 offset-lg-3 offset-md-3 error-notice" id="kode_barang_error"></div>
              </div>
              <div class="form-group row">
                <label class="col-lg-3 col-md-3 col-sm-12 col-form-label font-weight-bold">Jenis Barang</label>
                <div class="col-lg-9 col-md-9 col-sm-12">
                  <select class="form-control" name="jenis_barang">
                    <option value="Produksi">Produksi</option>
                    <option value="Konsumsi">Konsumsi</option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-lg-3 col-md-3 col-sm-12 col-form-label font-weight-bold">Nama Barang</label>
                <div class="col-lg-9 col-md-9 col-sm-12">
                  <input type="text" class="form-control" name="nama_barang">
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 offset-lg-3 offset-md-3 error-notice" id="nama_barang_error"></div>
              </div>
              <div class="form-group row">
                <label class="col-lg-3 col-md-3 col-sm-12 col-form-label font-weight-bold">Berat Barang</label>
                <div class="col-lg-9 col-md-9 col-sm-12">
                  <div class="input-group">
                      <input type="text" class="form-control number-input input-notzero" name="berat_barang">
                      <div class="input-group-append">
                        <select class="form-control" name="satuan_berat">
                          <option value="kg">Kilogram</option>
                          <option value="g">Gram</option>
                          <option value="ml">Miligram</option>
                          <option value="oz">Ons</option>
                          <option value="l">Liter</option>
                          <option value="ml">Mililiter</option>
                        </select>
                      </div>
                    </div>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-lg-3 col-md-3 col-sm-12 col-form-label font-weight-bold">Merek Barang</label>
                <div class="col-lg-9 col-md-9 col-sm-12">
                  <input type="text" class="form-control" name="merek">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-lg-3 col-md-3 col-sm-12 col-form-label font-weight-bold">Stok Barang</label>
                <div class="col-lg-9 col-md-9 col-sm-12">
                  <input type="text" class="form-control number-input" name="stok">
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 offset-lg-3 offset-md-3 error-notice" id="stok_error"></div>
              </div>
              <div class="form-group row">
                <label class="col-lg-3 col-md-3 col-sm-12 col-form-label font-weight-bold">Harga Barang</label>
                <div class="col-lg-9 col-md-9 col-sm-12">
                  <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">Rp. </span>
                      </div>
                      <input type="text" class="form-control number-input input-notzero" name="harga">
                  </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 offset-lg-3 offset-md-3 error-notice" id="harga_error"></div>
              </div>
          </div>
          <div class="modal-body" id="scan-modal-body" hidden="">
            <div class="row">
              <div class="col-12 text-center" id="area-scan">
              </div>
              <div class="col-12 barcode-result" hidden="">
                <h5 class="font-weight-bold">Hasil</h5>
                <div class="form-border">
                  <p class="barcode-result-text"></p>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer" id="edit-modal-footer">
            <button type="submit" class="btn btn-update"><i class="mdi mdi-content-save"></i> Simpan</button>
          </div>
          <div class="modal-footer" id="scan-modal-footer" hidden="">
            <button type="button" class="btn btn-primary btn-sm font-weight-bold rounded-0 btn-continue">Lanjutkan</button>
            <button type="button" class="btn btn-outline-secondary btn-sm font-weight-bold rounded-0 btn-repeat">Ulangi</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="row">
  {{-- <div class="col-12">
    <div class="alert alert-primary d-flex justify-content-between align-items-center" role="alert">
      @if($supply_system->status == false)
      <div class="text-instruction">
        <i class="mdi mdi-information-outline mr-2"></i> Aktifkan sistem stok dan pasok barang dengan klik tombol disamping
      </div>
      <a href="{{ url('/supply/system/active') }}" class="btn stok-btn">Aktifkan</a>
      @else
      <div class="text-instruction">
        <i class="mdi mdi-information-outline mr-2"></i> Nonaktifkan sistem stok dan pasok barang dengan klik tombol disamping
      </div>
      <a href="{{ url('/supply/system/nonactive') }}" class="btn stok-btn">Nonaktifkan</a>
      @endif
    </div>
  </div> --}}
  <div class="col-12 grid-margin">
    <div class="card card-noborder b-radius">
      <div class="card-body">
        <div class="row">
        	<div class="col-12 table-responsive">
        		<table class="table table-custom">
              <thead>
                <tr>
                  <th>Gambar</th>
                  <th>Kode Barang</th>
                  <th>Nama Barang</th>
                  <th>Stok</th>
                  <th>Harga</th>
                  <th>keterangan</th>
                  <th>Toko</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($products as $product)
              	<tr>
                    <td>
                        <img src="{{asset('pictures/'. $product->image)}}" alt="" >
                    </td>
                  <td>
                    <span class="kd-barang-field">{{ $product->kode_barang }}</span><br><br>
                  </td>
                  <td>
                    <span class="nama-barang-field">{{ $product->nama_barang }}</span>
                  </td>
                  <td><span class="ammount-box bg-secondary"><i class="mdi mdi-cube-outline"></i></span>{{ $product->stok }}</td>
                  <td><span class="ammount-box bg-green"><i class="mdi mdi-coin"></i></span>Rp. {{ number_format($product->harga_jual,2,',','.') }}</td>
                  
                  <td>
                    @if($product->keterangan == 'tersedia')
                    <span class="btn tersedia-span">{{ $product->keterangan }}</span>
                    @else
                    <span class="btn habis-span">{{ $product->keterangan }}</span>
                    @endif
                  </td>
                  {{-- <td>
                    @foreach($product->categories->take(1) as $index => $kategori)
                    <span class="btn kategori-span">{{$kategori->name}}</span>
                    @endforeach
                    @if($product->categories->count() > 1)
                    <span class="btn" style="font-size: 20px">...</span>
                @endif
                  </td> --}}
                  <td>
                    <span class="nama-barang-field">{{ $product->market->nama_toko }}</span>
                  </td>
                  <td>
                    <button type="button" class="btn btn-edit btn-icons btn-rounded btn-secondary" style="background-color: yellow" data-toggle="modal" data-target="#editModal" data-edit="{{ $product->id }}">
                        <i class="mdi mdi-pencil"></i>
                    </button>

                 <form action="{{ Auth::user()->role === 'admin' ?  url('/product/delete/'. $product->id) : route('product.delete', ['slug_market' => session('slug_market'), 'id' => $product->id])}}" method="POST" onsubmit="return confirmDelete(event)" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-icons btn-rounded btn-secondary ml-1 btn-delete" style="background-color: rgb(255, 75, 75)" >
                        <i class="mdi mdi-close"></i>
                    </button>
                </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
        	</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script src="{{ asset('plugins/js/quagga.min.js') }}"></script>
<script src="{{ asset('js/manage_product/product/script.js') }}"></script>
<script type="text/javascript">
  @if ($message = Session::get('create_success'))
    swal(
        "Berhasil!",
        "{{ $message }}",
        "success"
    );
  @endif

  @if ($message = Session::get('update_success'))
    swal(
        "Berhasil!",
        "{{ $message }}",
        "success"
    );
  @endif

  @if ($message = Session::get('delete_success'))
    swal(
        "Berhasil!",
        "{{ $message }}",
        "success"
    );
  @endif  

  @if ($message = Session::get('import_success'))
    swal(
        "Berhasil!",
        "{{ $message }}",
        "success"
    );
  @endif

  @if ($message = Session::get('update_failed'))
    swal(
        "",
        "{{ $message }}",
        "error"
    );
  @endif


  $(document).on('click', '.btn-edit', function(){
    var data_edit = $(this).attr('data-edit');
    $.ajax({
      method: "GET",
      url: "{{ url('/product/edit') }}/" + data_edit,
      success:function(response)
      {
        $('input[name=id]').val(response.product.id);
        $('input[name=kode_barang]').val(response.product.kode_barang);
        $('input[name=nama_barang]').val(response.product.nama_barang);
        $('input[name=merek]').val(response.product.merek);
        $('input[name=stok]').val(response.product.stok);
        $('input[name=harga]').val(response.product.harga);
        var berat_barang = response.product.berat_barang.split(" ");
        $('input[name=berat_barang]').val(berat_barang[0]);
        $('select[name=jenis_barang] option[value="'+ response.product.jenis_barang +'"]').prop('selected', true);
        $('select[name=satuan_berat] option[value="'+ berat_barang[1] +'"]').prop('selected', true);
        validator.resetForm();
      }
    });
  });


function confirmDelete(event) {
        event.preventDefault(); // Menghentikan form dari pengiriman langsung

        swal({
      title: "Apa Anda Yakin?",
      text: "Data barang akan terhapus, klik oke untuk melanjutkan",
      icon: "warning",
      buttons: true,
      dangerMode: true,
         }).then((willDelete) => {
            if (willDelete) {
                event.target.submit();
            } else {
                swal('Your imaginary file is safe!');
            }
        });
    }

</script>
@endsection