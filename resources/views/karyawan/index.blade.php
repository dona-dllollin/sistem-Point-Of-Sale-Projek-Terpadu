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


   {{-- Edit Modal --}}
<div class="row modal-group">
  <div class="modal fade" id="editModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{$item->id}}" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
    
        <form action="{{url('/karyawan/edit')}}" method="post">
          <div class="modal-header">
            <h5 class="modal-title" id="tambahModalLabel">Edit karyawan</h5>
            <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="tambah-modal-body">
              @csrf
                <div class="col-12">
                  <input type="hidden" name="id" value="{{$item->id}}">
              </div>
              <div class="form-group row">
                <label class="col-lg-3 col-md-3 col-sm-12 col-form-label font-weight-bold">No Karyawan</label>
                <div class="col-lg-9 col-md-9 col-sm-12">
                  <input type="text" class="form-control" name="no_karyawan" value="{{old('no_karyawan', $item->no_karyawan)}}">
                </div>
              </div>

              <div class="form-group row">
                <label class="col-lg-3 col-md-3 col-sm-12 col-form-label font-weight-bold">Nama</label>
                <div class="col-lg-9 col-md-9 col-sm-12">
                  <input type="text" class="form-control" name="nama" value="{{old('nama', $item->nama)}}">
                </div>
              </div>
              
              <div class="form-group row">
                <label class="col-lg-3 col-md-3 col-sm-12 col-form-label font-weight-bold">Nomor HP</label>
                <div class="col-lg-9 col-md-9 col-sm-12">
                  <input type="text" class="form-control" name="no_hp" value="{{old('no_hp',$item->no_hp)}}">
                </div>
              </div>
              
              <div class="form-group row">
                <label class="col-lg-3 col-md-3 col-sm-12 col-form-label font-weight-bold">Email</label>
                <div class="col-lg-9 col-md-9 col-sm-12">
                  <input type="text" class="form-control" name="email" value="{{old('email',$item->email)}}">
                </div>
              </div>
              
              <div class="form-group row">
                <label class="col-lg-3 col-md-3 col-sm-12 col-form-label font-weight-bold">Alamat</label>
                <div class="col-lg-9 col-md-9 col-sm-12">
                  {{-- <input type="text" class="form-control" name="email" value=""> --}}
                  <textarea name="alamat" class="form-control" rows="3" id="">{{old('alamat',$item->alamat)}}</textarea>
                </div>
              </div>
              
              <div class="form-group row">
                <label class="col-lg-3 col-md-3 col-sm-12 col-form-label font-weight-bold">Tanggal Masuk</label>
                <div class="col-lg-9 col-md-9 col-sm-12">
                  <input type="date" class="form-control" name="tanggal_masuk" value="{{old('tanggal_masuk',$item->tanggal_masuk)}}">
                </div>
              </div>

              <div class="form-group row">
                <label class="col-lg-3 col-md-3 col-sm-12 col-form-label font-weight-bold">Toko</label>
                <div class="col-lg-9 col-md-9 col-sm-12">
 
                  <select class="form-control" name="market_id">
                      @foreach($toko as $tk)
                  <option value="{{$tk->id}}" {{$tk->id === old('market_id',$item->market_id) ? 'selected' : ''}}>{{$tk->nama_toko}}</option>
                   @endforeach
                   </select>
                </div>
              </div>

          </div>
          <div class="modal-footer" id="edit-modal-footer">
            <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i> Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
   @endforeach

{{-- Tambah Modal --}}
<div class="row modal-group">
    <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
      
          <form action="{{url('/karyawan')}}" method="post">
            <div class="modal-header">
              <h5 class="modal-title" id="tambahModalLabel">Tambah karyawan</h5>
              <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="tambah-modal-body">
                @csrf
                  <div class="col-12">
                    <input type="hidden" name="id" value="">
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
                    <input type="text" class="form-control" name="no_karyawan" value="{{old('no_karyawan')}}">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-lg-3 col-md-3 col-sm-12 col-form-label font-weight-bold">Nama</label>
                  <div class="col-lg-9 col-md-9 col-sm-12">
                    <input type="text" class="form-control" name="nama" value="{{old('nama')}}">
                  </div>
                </div>
                
                <div class="form-group row">
                  <label class="col-lg-3 col-md-3 col-sm-12 col-form-label font-weight-bold">Nomor HP</label>
                  <div class="col-lg-9 col-md-9 col-sm-12">
                    <input type="text" class="form-control" name="no_hp" value="{{old('no_hp')}}">
                  </div>
                </div>
                
                <div class="form-group row">
                  <label class="col-lg-3 col-md-3 col-sm-12 col-form-label font-weight-bold">Email</label>
                  <div class="col-lg-9 col-md-9 col-sm-12">
                    <input type="text" class="form-control" name="email" value="{{old('email')}}">
                  </div>
                </div>
                
                <div class="form-group row">
                  <label class="col-lg-3 col-md-3 col-sm-12 col-form-label font-weight-bold">Alamat</label>
                  <div class="col-lg-9 col-md-9 col-sm-12">
                    {{-- <input type="text" class="form-control" name="email" value=""> --}}
                    <textarea name="alamat" class="form-control" rows="3" id="">{{old('alamat')}}</textarea>
                  </div>
                </div>
                
                <div class="form-group row">
                  <label class="col-lg-3 col-md-3 col-sm-12 col-form-label font-weight-bold">Tanggal Masuk</label>
                  <div class="col-lg-9 col-md-9 col-sm-12">
                    <input type="date" class="form-control" name="tanggal_masuk" value="{{old('tanggal_masuk')}}">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-lg-3 col-md-3 col-sm-12 col-form-label font-weight-bold">Toko</label>
                  <div class="col-lg-9 col-md-9 col-sm-12">
   
                    <select class="form-control" name="market_id">
                        <option value="">pilih toko</option>
                        @foreach($toko as $tk)
                    <option value="{{$tk->id}}" {{$tk->id == old('no_karyawan') ? 'selected' : ''}} >{{$tk->nama_toko}}</option>
                     @endforeach
                     </select>
                  </div>
                </div>

            </div>
            <div class="modal-footer" id="edit-modal-footer">
              <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i>Simpan</button>
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
        
            <a href="" class="btn btn-icons btn-primary btn-new ml-2" data-toggle="modal" data-target="#tambahModal" >
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
                            <button type="button" class="btn btn-edit btn-icons btn-rounded btn-secondary" style="background-color: yellow" data-toggle="modal" data-target="#editModal{{$item->id}}" data-edit="{{ $item->id }}">
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

@if (count($errors) > 0)
    <script>
        $( document ).ready(function() {
            $('#tambahModal').modal('show');
        });
    </script>
@endif



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