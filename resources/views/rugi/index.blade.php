@extends('templates/main')
@section('css')
 <!-- Custom styles for this page -->
 <link href="{{asset('sbAdmin/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">  
 {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}



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




  {{-- karyawan modal --}}
  <div class="row modal-group">
    <div class="modal fade" id="rugiModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
      
          <form method="post" id="karyawanForm">
            <div class="modal-header">
              <h5 class="modal-title" id="modalTitle">Tambah / Edit Kerugian</h5>
              <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="tambah-modal-body">
                @csrf
                  <div class="col-12">
                    <input type="hidden" name="_method" id="method" value="POST">
                    <input type="hidden" name="id" id="rugiId">
                </div>
                @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    @foreach($errors->all() as $error)
                    <ul>
                      <li>{{$error}}</li>
                    </ul>
                    @endforeach
                  </div>
                  @endif
                <div class="form-group row">
                  <label class="col-lg-3 col-md-3 col-sm-12 col-form-label font-weight-bold">Kode Barang</label>
                  <div class="col-lg-9 col-md-9 col-sm-12">
                    <select name="kode_barang" id="kode_barang" class=" form-select select2" onchange="fetchHargaBeli(this.value)">
                        <option value="">-- Pilih Produk --</option>
                        @foreach($produkList as $produk)
                            <option value="{{ $produk->kode_barang }}">
                                {{ $produk->nama_barang }} ({{ $produk->kode_barang }})
                            </option>
                        @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-lg-3 col-md-3 col-sm-12 col-form-label font-weight-bold">Harga Beli (dari supply)</label>
                  <div class="col-lg-9 col-md-9 col-sm-12">
                    <select name="harga_beli" id="harga_beli" class="form-select form-control">
                        <option value="">-- Pilih Harga Beli --</option>
                        {{-- Diisi via JavaScript (AJAX) berdasarkan kode_barang --}}
                    </select>
                  </div>
                </div>
                
                <div class="form-group row">
                  <label class="col-lg-3 col-md-3 col-sm-12 col-form-label font-weight-bold">Jumlah Barang Rugi</label>
                  <div class="col-lg-9 col-md-9 col-sm-12">
                     <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" value="{{old('jumlah')}}" required>
                  </div>
                </div>
                
                <div class="form-group row">
                  <label class="col-lg-3 col-md-3 col-sm-12 col-form-label font-weight-bold">Alasan</label>
                  <div class="col-lg-9 col-md-9 col-sm-12">
                    <input type="text" class="form-control" name="alasan" id="alasan" value="{{old('alasan')}}">
                  </div>
                </div>

            </div>
            <div class="modal-footer" id="edit-modal-footer">
              <button type="submit" id="modalSubmit" class="btn btn-primary"><i class="mdi mdi-content-save"></i>Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Data Kerugian</h6>
        
            <a href="" class="btn btn-icons btn-primary btn-new ml-2 btnTambah" id="btnTambah" >
                <i class="mdi mdi-plus"></i>
            </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="text-align: center">
                <thead>
                    <tr>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Harga Beli</th>
                        <th>Alasan</th>
                        <th>Total_Kerugian</th>
                        <th>diinput oleh</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rugi as $item)
                    <tr>
                        <td>{{$item->kode_barang}}</td>
                        <td>{{$item->nama_barang}}</td>
                        <td>{{$item->jumlah}}</td>
                        <td>{{ number_format($item->harga_beli, 2, ',', '.')}}</td>
                        <td>{{ $item->alasan}}</td>
                        <td>{{ number_format($item->total_kerugian, 2, ',', '.')}}</td>
                        <td>{{ $item->user->nama}}</td>
                        <td>{{date('d M, Y', strtotime($item->Tanggal))}}</td>
                        <td>
{{--         
                         <form action="{{url('/karyawan/delete/'. $item->id)}}" method="POST" onsubmit="return confirmDelete(event)" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-icons btn-rounded btn-secondary ml-1 btn-delete" style="background-color: rgb(255, 75, 75)" >
                                <i class="mdi mdi-close"></i>
                            </button>
                        </form> --}}
                          </td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
    
@endsection

@section('script')

<script>
   @if ($message = Session::get('success'))
    swal(
        "Berhasil!",
        "{{ $message }}",
        "success"
    );
  @endif

//   @if ($errors->any())
//   @foreach($errors->all() as $error)
  
//       swal(
//           "",
//           "{{ $error }}",
//           "error"
//       );
  
//   @endforeach
// @endif

 $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Cari produk...",
            allowClear: true,
            width: '100%'
        });
    });

function confirmDelete(event) {
        event.preventDefault(); // Menghentikan form dari pengiriman langsung

        swal({
      title: "Apa Anda Yakin?",
      text: "Data karyawan akan terhapus, klik oke untuk melanjutkan",
      icon: "warning",
      buttons: true,
      dangerMode: true,
         }).then((willDelete) => {
            if (willDelete) {
                event.target.submit();
            } else {
                swal('batal menghapus data karyawan');
            }
        });
    }

</script>



@if ($errors->any())
    <script>
        $( document ).ready(function() {

      @if (session('modal_mode') === 'edit')

        $('#karyawanForm').attr('action', '/karyawan/edit'); // URL untuk edit
        $('#method').val('POST'); // Method untuk edit
        $('#modalTitle').text('Edit Karyawan');
        $('#modalSubmit').text('Update');
        $('#karyawanId').val('{{ session('modal_data.id') }}');
        $('#nama').val('{{ session('modal_data.nama') }}');
        $('#email').val('{{ session('modal_data.email') }}');
        $('#no_karyawan').val('{{ session('modal_data.no_karyawan') }}');
        $('#no_hp').val('{{ session('modal_data.no_hp') }}');
        $('#alamat').val('{{ session('modal_data.alamat') }}');
        $('#tanggal_masuk').val('{{ session('modal_data.tanggal_masuk') }}');
        $('#optionPilihToko').attr('hidden', true)
        $('#market_id').val('{{ session('modal_data.market_id') }}');
      @else
        $('#optionPilihToko').removeAttr('hidden')
        $('#karyawanForm').attr('action', '/karyawan'); // URL untuk tambah
        $('#method').val('POST'); // Method untuk tambah
        $('#modalTitle').text('Tambah Karyawan');
        $('#modalSubmit').text('Tambah');
        $('#karyawanForm')[0].reset(); // Reset semua field
      @endif

          $('#rugiModal').modal('show');
        });
    </script>
@endif


<script>
  $(document).ready(function () {
    // Fungsi untuk membuka modal tambah
    $('.btnTambah').click(function (e) {
        e.preventDefault()
        $('#karyawanForm').attr('action', '/rugi'); // URL untuk tambah
        $('#method').val('POST'); // Method untuk tambah
        $('#modalTitle').text('Tambah Kerugian');
        $('#modalSubmit').text('Tambah');
        $('#karyawanForm')[0].reset(); // Reset semua field
        $('#rugiModal').modal('show');
    });


});


function fetchHargaBeli(kodeBarang) {
    fetch(`/supply/harga-beli/${kodeBarang}`)
        .then(res => res.json())
        .then(data => {
            const hargaSelect = document.getElementById('harga_beli');
            hargaSelect.innerHTML = `<option value="">-- Pilih Harga Beli --</option>`;
            data.forEach(harga => {
                hargaSelect.innerHTML += `<option value="${harga}">${harga}</option>`;
            });
        });
}

</script>





        {{-- <!-- Bootstrap core JavaScript-->
        <script src="{{asset('sbAdmin/vendor/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('sbAdmin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

        <!-- Core plugin JavaScript-->
        <script src="{{asset('sbAdmin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

        <!-- Custom scripts for all pages-->
        <script src="{{asset('sbAdmin/js/sb-admin-2.min.js')}}"></script> --}}

      <!-- Page level plugins -->
      <script src="{{asset('sbAdmin/vendor/datatables/jquery.dataTables.min.js')}}"></script>
      <script src="{{asset('sbAdmin/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  
      <!-- Page level custom scripts -->
      <script src="{{asset('sbAdmin/js/demo/datatables-demo.js')}}"></script>

      {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
      {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}

    
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.js"></script>
      
@endsection