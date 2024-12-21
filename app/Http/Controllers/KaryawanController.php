<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Market;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class KaryawanController extends Controller
{
    public function index()
    {
        $toko = Market::all();
        $karyawans = Karyawan::all();
        return view('karyawan.index', compact('karyawans', 'toko'));
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $rules = [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_karyawan' => 'required|string|max:50|unique:karyawans,no_karyawan',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'nullable|string|max:500', // Optional
            'tanggal_masuk' => 'required|date',
            'market_id' => 'required|exists:markets,id', // Foreign key harus ada di tabel markets
        ];

        $messages = [
            'nama.required' => 'nama karyawan harus diisi',
            'email.required' => 'email harus diisi',
            'email.email' => 'format email tidak sesuai',
            'no_karyawan.required' => 'nomor karyawan harus diisi',
            'no_karyawan.unique' => 'nomor karyawan sudah digunakan',
            'no_hp.required' => 'nomor hp harus diisi',
            'tanggal_masuk' => 'tanggal masuk harus diisi',
            'market_id.required' => 'toko harus diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // Mode edit atau tambah berdasarkan apakah ada 'id'
            session()->flash('modal_mode', $request->id !== null ? 'edit' : 'add');
            session()->flash('modal_data', $request->all());

            return redirect()->back()->withErrors($validator);
        }

        // Menyimpan data ke database
        Karyawan::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_karyawan' => $request->no_karyawan,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat ?? null,
            'tanggal_masuk' => $request->tanggal_masuk,
            'market_id' => $request->market_id,
        ]);

        // Redirect ke halaman sebelumnya atau ke halaman lain dengan pesan sukses
        return back()->with('success', 'Data karyawan berhasil ditambahkan!');
    }

    public function edit(Request $req)
    {
        // Validasi data yang diterima dari form
        $rules =
            [
                'nama' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'no_karyawan' => 'required|string|max:50|unique:karyawans,no_karyawan,' . $req->id,
                'no_hp' => 'required|string|max:20',
                'alamat' => 'nullable|string|max:500', // Optional
                'tanggal_masuk' => 'required|date',
                'market_id' => 'required|exists:markets,id', // Foreign key harus ada di tabel markets
            ];
        $messages =
            [
                'nama.required' => 'nama karyawan harus diisi',
                'email.required' => 'email harus diisi',
                'email.email' => 'format email tidak sesuai',
                'no_karyawan.required' => 'nomor karyawan harus diisi',
                'no_karyawan.unique' => 'nomor karyawan sudah digunakan',
                'no_hp.required' => 'nomor hp harus diisi',
                'tanggal_masuk' => 'tanggal masuk harus diisi',
                'market_id.required' => 'toko harus diisi',
            ];

        $karyawan = Karyawan::find($req->id);
        if (!$karyawan) {
            Session::flash('error', 'data karyawan tidak tersedia');
            return;
        }

        $validator = Validator::make($req->all(), $rules, $messages);
        if ($validator->fails()) {
            // Mode edit atau tambah berdasarkan apakah ada 'id'
            session()->flash('modal_mode', $req->id !== null ? 'edit' : 'add');
            session()->flash('modal_data', $req->all());

            return redirect()->back()->withErrors($validator);
        }

        $karyawan->update([
            'nama' => $req->nama,
            'email' => $req->email,
            'no_karyawan' => $req->no_karyawan,
            'no_hp' => $req->no_hp,
            'alamat' => $req->alamat ?? null,
            'tanggal_masuk' => $req->tanggal_masuk,
            'market_id' => $req->market_id,
        ]);

        return back()->with('success', 'Data karyawan berhasil diEdit!');
    }


    public function delete($id)
    {
        $karyawan = Karyawan::find($id);

        if (!$karyawan) {
            Session::flash('error', 'data karyawan tidak ditemukan');
            return;
        } else {
            $karyawan->delete();
            Session::flash('success', 'Data Karyawan berhasil dihapus');

            return redirect()->back();
        }
    }
}
