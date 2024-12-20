@extends('templates/main')
@section('css')
<link rel="stylesheet" href="{{ asset('css/manage_product/new_product/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/manage_product/new_product/multiSelect.css') }}">
@endsection
@section('content')
<div class="row page-title-header">
  <div class="col-12">
    <div class="page-header d-flex justify-content-start align-items-center">
      <div class="quick-link-wrapper d-md-flex flex-md-wrap">
        <ul class="quick-links">
          <li><a href="{{Auth::user()->role === 'admin' ? route('admin.product') : route('kasir.product', ['slug_market' => session('slug_market')]) }}">Daftar Barang</a></li>
          <li><a href="{{ Auth::user()->role === 'admin' ? url('/product/new') : url('/toko/' . session('slug_market') . '/product/new') }} ">Barang Baru</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<div class="row modal-group">
  <div class="modal fade" id="scanModal" tabindex="-1" role="dialog" aria-labelledby="scanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="scanModalLabel">Scan Barcode</h5>
	        <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
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
	      <div class="modal-footer" id="btn-scan-action" hidden="">
	        <button type="button" class="btn btn-primary btn-sm font-weight-bold rounded-0 btn-continue">Lanjutkan</button>
	        <button type="button" class="btn btn-outline-secondary btn-sm font-weight-bold rounded-0 btn-repeat">Ulangi</button>
	      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="formatModal" tabindex="-1" role="dialog" aria-labelledby="formatModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
      	<div class="modal-header">
	        <h5 class="modal-title" id="formatModalLabel">Format Upload</h5>
	        <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	    </div>
	    <div class="modal-body">
	    	<div class="row">
	    		<div class="col-12 img-import-area">
	    			<img src="{{ asset('images/instructions/ImportProduct.jpg') }}" class="img-import">
	    		</div>
	    	</div>
	    </div>
      </div>
	</div>
  </div>
</div>
{{-- <div class="row"> --}}
	{{-- <div class="col-lg-8 col-md-12 col-sm-12 mb-4"> --}}
		<div class="card card-noborder b-radius">
			<div class="card-body">
				<form action="{{url('/product/create')}}" method="post" name="create_form" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
			  			<label class="col-12 font-weight-bold col-form-label">Kode Barang <span class="text-danger">*</span></label>
					  	<div class="col-12">
					  		<div class="input-group">
					  			<input type="text" class="form-control number-input" value="{{old('kode_barang')}}" name="kode_barang" placeholder="Masukkan Kode Barang">
					  			<div class="inpu-group-prepend">
					  				<button class="btn btn-inverse-primary btn-sm btn-scan shadow-sm ml-2" type="button" data-toggle="modal" data-target="#scanModal"><i class="mdi mdi-crop-free"></i></button>
					  			</div>
					  		</div>
					  	</div>
						@error('kode_barang')
						<div class="col-12 error-notice text-danger">{{$message}}</div>
						@enderror
					</div>
					<div class="form-group row">
					  	<div class="col-lg-6 col-md-6 col-sm-12 space-bottom">
					  		<div class="row">
					  			<label class="col-12 font-weight-bold col-form-label">Nama Barang <span class="text-danger">*</span></label>
							  	<div class="col-12">
							  		<input type="text" class="form-control" name="nama_barang" placeholder="Masukkan Nama Barang">
							  	</div>
								  @error('nama_barang')
								  <div class="col-12 error-notice text-danger">{{$message}}</div>
								  @enderror
					  		</div>
					  	</div>
					
				
					  	<div class="col-lg-6 col-md-6 col-sm-12 space-bottom">
					  		<div class="row">
					  			<label class="col-12 font-weight-bold col-form-label">Foto Barang <span class="text-danger">*</span></label>
							  	<div class="col-12">
                                            <input name="image" id="image" type="file" class="custom-file-input" 
                                                accept="image/*"
                                                onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0]); document.getElementById('fileLabel').textContent = this.files[0].name;">
                                                <label class=" custom-file-label" id="fileLabel">Choose File</label>
                                    
                                      <div class="col-sm-12 text-center mt-3" ><img id="output" src="" class="img-fluid" style="width: 30%"></div>

							  	</div>
					  		</div>
					  	</div>
					</div>
					
					<div class="form-group row">
					  	<div class="col-lg-6 col-md-6 col-sm-12 space-bottom">
					  		<div class="row">
					  			<label class="col-12 font-weight-bold col-form-label">Satuan Barang</label>
							  	<div class="col-12">
							  		<div class="input-group">
							  			<input type="text" class="form-control number-input" name="satuan" placeholder="Masukkan Satuan Barang">
							  			<div class="input-group-append">
							  				<select class="form-control" name="satuan_berat">
												@foreach ($satuan as $item)						
												<option value="{{$item->nama}}">{{$item->nama}}</option>
												@endforeach
							  				</select>
							  			</div>
							  		</div>
							  	</div>
					  		</div>
					  	</div>
					  	<div class="col-lg-6 col-md-6 col-sm-12">
					  		<div class="row">
					  			<label class="col-12 font-weight-bold col-form-label">Toko</label>
							  	<div class="col-12">
                                    @if(Auth::user()->role === 'admin')
                                    <select class="form-control" name="toko">
                                        @foreach($toko as $tk)
							  			<option value="{{$tk->id}}">{{$tk->nama_toko}}</option>
							  			@endforeach
							  		</select>
                                    @else
                                    <input type="text" class="form-control" disabled value="{{Auth::user()->market->nama_toko}}">
                                    <input type="hidden" name="toko" value="{{ Auth::user()->market->id }}">
                                    @endif
							  	</div>
								  @error('toko')
								  <div class="col-12 error-notice text-danger">{{$message}}</div>
								  @enderror
					  		</div>
					  	</div>
					</div>
                    <div class="form-group row">
						
                        <div class="col-lg-6 col-md-6 col-sm-12 space-bottom">
                            <div class="row">
                                <label class="col-12 font-weight-bold col-form-label"> Stok <span class="text-danger">*</span></label>
                                <div class="col-12">
                                  
                                    <input type="text" class="form-control number-input" name="stok" placeholder="Masukkan jumlah stok barang">
                               
                              </div>
							  @error('stok')
							  <div class="col-12 error-notice text-danger">{{$message}}</div>
							  @enderror
                            </div>
                        </div>
                    
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="row">
                                <label class="col-12 font-weight-bold col-form-label">Kategori </label>
                                <div class="col-12">
                                    
                                        <select class="form-control" name="kategori_barang" multiple data-multi-select>
                                        @foreach($kategori as $kt)
							  			<option value="{{$kt->id}}">{{$kt->name}}</option>
							  			@endforeach
							  		</select>
                                    
                                </div>
                            </div>
                        </div>
                  </div>
					<div class="form-group row">
						
					  	<div class="col-lg-6 col-md-6 col-sm-12 space-bottom">
					  		<div class="row">
					  			<label class="col-12 font-weight-bold col-form-label">Harga Beli Barang <span class="text-danger">*</span></label>
							  	<div class="col-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp. </span>
                                        </div>
							  		<input type="text" class="form-control number-input" name="harga_beli" placeholder="Masukkan Harga Beli Barang">
							  	</div>
                                </div>
								@error('harga_beli')
								<div class="col-12 error-notice text-danger">{{$message}}</div>
								@enderror
					  		</div>
					  	</div>
					  
					  	<div class="col-lg-6 col-md-6 col-sm-12">
					  		<div class="row">
					  			<label class="col-12 font-weight-bold col-form-label">Harga Jual Barang <span class="text-danger">*</span></label>
							  	<div class="col-12">
							  		<div class="input-group">
							  			<div class="input-group-prepend">
							  				<span class="input-group-text">Rp. </span>
							  			</div>
							  			<input type="text" class="form-control number-input" name="harga_jual" placeholder="Masukkan Harga Jual Barang">
							  		</div>
							  	</div>
								  @error('harga_jual')
								  <div class="col-12 error-notice text-danger">{{$message}}</div>
								  @enderror
					  		</div>
					  	</div>
					</div>
					<div class="row">
						<div class="col-12 mt-2 d-flex justify-content-end">
					  		<button class="btn btn-simpan btn-sm" type="submit"><i class="mdi mdi-content-save"></i> Simpan</button>
					  	</div>
					</div>
				</form>
			</div>
		</div>
	{{-- </div> --}}
	{{-- <div class="col-lg-4 col-md-12 col-sm-12">
		<div class="row">
			<div class="col-12 stretch-card bg-dark-blue">
				<div class="card text-white card-noborder b-radius">
					<div class="card-body">
						<form action="{{ url('/product/import') }}" method="post" enctype="multipart/form-data">
							@csrf
							<div class="d-flex justify-content-between pb-2 align-items-center">
			                  <h2 class="font-weight-semibold mb-0">Import</h2>
			                  <input type="file" name="excel_file" hidden="" accept=".xls, .xlsx">
			                  <a href="#" class="excel-file">
			                  	<div class="icon-holder">
				                   <i class="mdi mdi-upload"></i>
				                </div>
			                  </a>
			                </div>
			                <div class="d-flex justify-content-between">
			                  <h5 class="font-weight-semibold mb-0">Upload file excel</h5>
			                  <p class="text-white excel-name">Pilih File</p>
			                </div>
			                <button class="btn btn-block mt-3 btn-upload" type="submit" hidden="">Import Data</button>
						</form>
					</div>
				</div>
			</div>
			<div class="col-12 mt-4">
				<div class="card card-noborder b-radius">
					<div class="card-body">
						<h4 class="card-title mb-1">Langkah - Langkah Import</h4>
	                    <div class="d-flex py-2 border-bottom">
	                      <div class="wrapper">
	                        <p class="font-weight-semibold text-gray mb-0">1. Siapkan data dengan format Excel (.xls atau .xlsx)</p>
	                        <small class="text-muted">
	                        	<a href="" role="button" class="link-how" data-toggle="modal" data-target="#formatModal">Selengkapnya</a>
	                    	</small>
	                      </div>
	                    </div>
	                    <div class="d-flex py-2 border-bottom">
	                      <div class="wrapper">
	                        <p class="font-weight-semibold text-gray mb-0">2. Jika sudah sesuai pilih file</p>
	                      </div>
	                    </div>
	                    <div class="d-flex py-2">
	                      <div class="wrapper">
	                        <p class="font-weight-semibold text-gray mb-0">3. Klik simpan, maka data otomatis tersimpan</p>
	                      </div>
	                    </div>
					</div>
				</div>
			</div>
		</div>
	</div> --}}
{{-- </div> --}}
@endsection
@section('script')
<script src="{{ asset('plugins/js/quagga.min.js') }}"></script>
<script src="{{ asset('js/manage_product/new_product/script.js') }}"></script>
<script src="{{ asset('js/manage_product/new_product/multiSelect.js') }}"></script>
<script type="text/javascript">
  @if ($message = Session::get('create_failed'))
    swal(
        "",
        "{{ $message }}",
        "error"
    );
  @endif

  @if ($message = Session::get('import_failed'))
    swal(
        "",
        "{{ $message }}",
        "error"
    );
  @endif
</script>
@endsection