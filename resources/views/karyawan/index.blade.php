@extends('templates/main')
@section('css')
 <!-- Custom styles for this page -->
 <link href="{{asset('sbAdmin/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">  
@endsection
@section('content')

@foreach ($karyawans as $item)
    
{{-- Detail Modal --}}
<div class="modal fade" id="detailModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{$item->id}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Detail Karyawan</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
              </button>
          </div>
          <div class="modal-body m-auto table-responsive">
           <table style="text-align:justify;"  class="table" width="100%">
            <tr>
                <td>
                    Nama Karyawan
                </td>
                <td>
                    :
                </td>
                <td>
                    {{$item->nama}}
                </td>
            </tr>
            <tr>
                <td>
                    Nomor Karyawan
                </td>
                <td>:</td>
                <td>
                    {{$item->no_karyawan}}
                </td>
            </tr>
            <tr>
                <td>
                    Nomor HP
                </td>
                <td>:</td>
                <td>
                    {{$item->no_hp}}
                </td>
            </tr>
            <tr>
                <td>
                    Email
                </td>
                <td>:</td>
                <td>
                    {{$item->email}}
                </td>
            </tr>
            <tr>
                <td>
                    tanggal Masuk
                </td>
                <td>:</td>
                <td>
                    {{date('d M, Y', strtotime($item->tanggal_masuk))}}
                </td>
            </tr>
            <tr>
                <td>
                    Alamat
                </td>
                <td>:</td>
                <td>
                    {{$item->alamat}}
                </td>
            </tr>
            <tr>
                <td>
                    Toko
                </td>
                <td>:</td>
                <td>
                    {{$item->market->nama_toko}}
                </td>
            </tr>
           </table>
          </div>
          <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
          </div>
      </div>
    </div>
   </div>
   @endforeach


  {{-- karyawan modal --}}
  <div class="row modal-group">
    <div class="modal fade" id="karyawanModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
      
          <form method="post" id="karyawanForm">
            <div class="modal-header">
              <h5 class="modal-title" id="modalTitle">Tambah / Edit karyawan</h5>
              <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="tambah-modal-body">
                @csrf
                  <div class="col-12">
                    <input type="hidden" name="_method" id="method" value="POST">
                    <input type="hidden" name="id" id="karyawanId">
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
                  <label class="col-lg-3 col-md-3 col-sm-12 col-form-label font-weight-bold">No Karyawan</label>
                  <div class="col-lg-9 col-md-9 col-sm-12">
                    <input type="text" class="form-control" name="no_karyawan" id="no_karyawan" value="{{old('no_karyawan')}}">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-lg-3 col-md-3 col-sm-12 col-form-label font-weight-bold">Nama</label>
                  <div class="col-lg-9 col-md-9 col-sm-12">
                    <input type="text" class="form-control" name="nama" id="nama" value="{{old('nama')}}">
                  </div>
                </div>
                
                <div class="form-group row">
                  <label class="col-lg-3 col-md-3 col-sm-12 col-form-label font-weight-bold">Nomor HP</label>
                  <div class="col-lg-9 col-md-9 col-sm-12">
                    <input type="text" class="form-control" name="no_hp" id="no_hp" value="{{old('no_hp')}}">
                  </div>
                </div>
                
                <div class="form-group row">
                  <label class="col-lg-3 col-md-3 col-sm-12 col-form-label font-weight-bold">Email</label>
                  <div class="col-lg-9 col-md-9 col-sm-12">
                    <input type="text" class="form-control" name="email" id="email" value="{{old('email')}}">
                  </div>
                </div>
                
                <div class="form-group row">
                  <label class="col-lg-3 col-md-3 col-sm-12 col-form-label font-weight-bold">Alamat</label>
                  <div class="col-lg-9 col-md-9 col-sm-12">
                    {{-- <input type="text" class="form-control" name="email" value=""> --}}
                    <textarea name="alamat" class="form-control" rows="3" id="alamat">{{old('alamat')}}</textarea>
                  </div>
                </div>
                
                <div class="form-group row">
                  <label class="col-lg-3 col-md-3 col-sm-12 col-form-label font-weight-bold">Tanggal Masuk</label>
                  <div class="col-lg-9 col-md-9 col-sm-12">
                    <input type="date" class="form-control" name="tanggal_masuk" id="tanggal_masuk" value="{{old('tanggal_masuk')}}">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-lg-3 col-md-3 col-sm-12 col-form-label font-weight-bold">Toko</label>
                  <div class="col-lg-9 col-md-9 col-sm-12">
   
                    <select class="form-control" name="market_id" id="market_id">
                        <option value="">pilih toko</option>
                        @foreach($toko as $tk)
                    <option value="{{$tk->id}}" {{$tk->id == old('no_karyawan') ? 'selected' : ''}} >{{$tk->nama_toko}}</option>
                     @endforeach
                     </select>
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
        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        
            <a href="" class="btn btn-icons btn-primary btn-new ml-2 btnTambah" id="btnTambah" >
                <i class="mdi mdi-plus"></i>
            </a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="text-align: center">
                <thead>
                    <tr>
                        <th>No Karyawan</th>
                        <th>Nama</th>
                        <th>Nomor HP</th>
                        <th>Tanggal Masuk</th>
                        <th>Toko</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($karyawans as $item)
                    <tr>
                        <td>{{$item->no_karyawan}}</td>
                        <td>{{$item->nama}}</td>
                        <td>{{$item->no_hp}}</td>
                        <td>{{date('d M, Y', strtotime($item->tanggal_masuk))}}</td>
                        <td>{{$item->market->nama_toko}}</td>
                        <td>
                            <button type="button" class="btn btn-edit btn-icons btn-rounded btn-secondary btnEdit" style="background-color: yellow"
                              data-id="{{ $item->id }}" 
                              data-nama="{{ $item->nama }}"
                              data-email="{{ $item->email }}"
                              data-no_karyawan="{{ $item->no_karyawan }}"
                              data-no_hp="{{ $item->no_hp }}"
                              data-alamat="{{ $item->alamat }}"
                              data-tanggal_masuk="{{ $item->tanggal_masuk }}"
                              data-market_id="{{ $item->market_id }}"
                              >
                                <i class="mdi mdi-pencil"></i>
                            </button>

                            <button type="button" class="btn btn-view btn-icons btn-rounded" style="background-color: rgb(0, 190, 79)" data-toggle="modal" data-target="#detailModal{{$item->id}}" data-detail="{{ $item->id }}">
                                <i class="mdi mdi-eye"></i>
                            </button>
        
                         <form action="{{url('/karyawan/delete/'. $item->id)}}" method="POST" onsubmit="return confirmDelete(event)" class="d-inline">
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
            $('#karyawanModal').modal('show');
        });
    </script>
@endif


<script>
  $(document).ready(function () {
    // Fungsi untuk membuka modal tambah
    $('.btnTambah').click(function (e) {
        e.preventDefault()
        $('#karyawanForm').attr('action', '/karyawan'); // URL untuk tambah
        $('#method').val('POST'); // Method untuk tambah
        $('#modalTitle').text('Tambah Karyawan');
        $('#modalSubmit').text('Tambah');
        $('#karyawanForm')[0].reset(); // Reset semua field
        $('#karyawanModal').modal('show');
    });

    // Fungsi untuk membuka modal edit
    $('.btnEdit').click(function () {
        const id = $(this).data('id');
        const url = `/karyawan/edit`;
        
        // Ambil data karyawan dari tombol edit
        const nama = $(this).data('nama');
        const email = $(this).data('email');
        const no_karyawan = $(this).data('no_karyawan');
        const no_hp = $(this).data('no_hp');
        const alamat = $(this).data('alamat');
        const tanggal_masuk = $(this).data('tanggal_masuk');
        const toko = $(this).data('toko');

        // Set data ke form
        $('#karyawanForm').attr('action', url); // URL untuk edit
        $('#method').val('POST'); // Method untuk edit
        $('#modalTitle').text('Edit Karyawan');
        $('#modalSubmit').text('Update');
        $('#karyawanId').val(id);
        $('#nama').val(nama);
        $('#email').val(email);
        $('#no_karyawan').val(no_karyawan);
        $('#no_hp').val(no_hp);
        $('#alamat').val(alamat);
        $('#tanggal_masuk').val(tanggal_masuk);
        $('#market_id').val(toko);

        $('#karyawanModal').modal('show');
    });
});

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
@endsection