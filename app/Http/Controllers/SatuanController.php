<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SatuanController extends Controller
{
    public function index()
    {
        $satuan = Satuan::all();

        return view('satuan&kategori.satuan', compact('satuan'));
    }

    public function create(Request $req)
    {
        $req->validate([
            'nama' => 'required|max:255'
        ], [
            'nama.required' => 'nama satuan tidak boleh kosong'
        ]);

        Satuan::create([
            'nama' => $req->nama
        ]);

        return back()->with('success', 'data satuan berhasil dibuat');
    }

    public function edit(Request $req)
    {
        $req->validate([
            'nama' => 'required|max:255'
        ], [
            'nama.required' => 'nama satuan tidak boleh kosong'
        ]);

        $satuan = Satuan::find($req->id);
        if (!$satuan) {
            Session::flash('error', 'data Satuan tidak tersedia');
            return;
        }

        $satuan->update([
            'nama' => $req->nama
        ]);

        return back()->with('success', 'data satuan berhasil diubah');
    }

    public function delete($id)
    {

        $satuan = Satuan::find($id);

        if (!$satuan) {
            Session::flash('error', 'data satuan tidak ditemukan');
            return;
        } else {
            $satuan->delete();
            Session::flash('success', 'Data satuan berhasil dihapus');

            return redirect()->back();
        }
    }
}
