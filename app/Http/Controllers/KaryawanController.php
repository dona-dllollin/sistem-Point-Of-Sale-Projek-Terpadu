<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Market;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
        $validatedData = $request->validate(
            [
                'nama' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'no_karyawan' => 'required|string|max:50|unique:karyawans,no_karyawan',
                'no_hp' => 'required|string|max:20',
                'alamat' => 'nullable|string|max:500', // Optional
                'tanggal_masuk' => 'required|date',
                'market_id' => 'required|exists:markets,id', // Foreign key harus ada di tabel markets
            ],
            [
                'nama.required' => 'nama karyawan harus diisi',
                'email.required' => 'email harus diisi',
                'email.email' => 'format email tidak sesuai',
                'no_karyawan.required' => 'nomor karyawan harus diisi',
                'no_karyawan.unique' => 'nomor karyawan sudah digunakan',
                'no_hp.required' => 'nomor hp harus diisi',
                'tanggal_masuk' => 'tanggal masuk harus diisi',
                'market_id.required' => 'toko harus diisi',
                'modal_type' => $request->modal_type
            ]
        );


        // Menyimpan data ke database
        Karyawan::create([
            'nama' => $validatedData['nama'],
            'email' => $validatedData['email'],
            'no_karyawan' => $validatedData['no_karyawan'],
            'no_hp' => $validatedData['no_hp'],
            'alamat' => $validatedData['alamat'] ?? null,
            'tanggal_masuk' => $validatedData['tanggal_masuk'],
            'market_id' => $validatedData['market_id'],
        ]);

        // Redirect ke halaman sebelumnya atau ke halaman lain dengan pesan sukses
        return back()->with('success', 'Data karyawan berhasil ditambahkan!');
    }

    public function edit(Request $req)
    {
        // Validasi data yang diterima dari form
        $validatedData = $req->validate(
            [
                'nama' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'no_karyawan' => 'required|string|max:50|unique:karyawans,no_karyawan,' . $req->id,
                'no_hp' => 'required|string|max:20',
                'alamat' => 'nullable|string|max:500', // Optional
                'tanggal_masuk' => 'required|date',
                'market_id' => 'required|exists:markets,id', // Foreign key harus ada di tabel markets
            ],
            [
                'nama.required' => 'nama karyawan harus diisi',
                'email.required' => 'email harus diisi',
                'email.email' => 'format email tidak sesuai',
                'no_karyawan.required' => 'nomor karyawan harus diisi',
                'no_karyawan.unique' => 'nomor karyawan sudah digunakan',
                'no_hp.required' => 'nomor hp harus diisi',
                'tanggal_masuk' => 'tanggal masuk harus diisi',
                'market_id.required' => 'toko harus diisi',
                'modal_type' => $req->modal_type
            ]
        );

        $karyawan = Karyawan::find($req->id);
        if (!$karyawan) {
            Session::flash('error', 'data karyawan tidak tersedia');
            return;
        }

        $karyawan->update([
            'nama' => $validatedData['nama'],
            'email' => $validatedData['email'],
            'no_karyawan' => $validatedData['no_karyawan'],
            'no_hp' => $validatedData['no_hp'],
            'alamat' => $validatedData['alamat'] ?? null,
            'tanggal_masuk' => $validatedData['tanggal_masuk'],
            'market_id' => $validatedData['market_id'],
        ]);

        return back()->with('success', 'Data karyawan berhasil diEdit!')->withInput()->withErrors($validatedData);
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
