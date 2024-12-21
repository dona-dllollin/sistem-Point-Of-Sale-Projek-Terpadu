<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SatuanController extends Controller
{
    public function index()
    {
        $satuan = Satuan::all();

        return view('satuan&kategori.satuan', compact('satuan'));
    }

    public function create(Request $req)
    {
        $rules = [
            'nama' => 'required|max:255'
        ];

        $messages = [
            'nama.required' => 'nama satuan tidak boleh kosong'
        ];

        $validator = Validator::make($req->all(), $rules, $messages);

        if ($validator->fails()) {
            session()->flash('modal_mode', $req->id !== null ? 'edit' : 'add');
            session()->flash('modal_data', $req->all());

            return redirect()->back()->withErrors($validator);
        }

        Satuan::create([
            'nama' => $req->nama
        ]);

        return back()->with('success', 'data satuan berhasil dibuat');
    }


    public function edit(Request $req)
    {
        $rules = [
            'nama' => 'required|max:255'
        ];

        $messages = [
            'nama.required' => 'nama satuan tidak boleh kosong'
        ];

        $validator = Validator::make($req->all(), $rules, $messages);

        if ($validator->fails()) {
            session()->flash('modal_mode', $req->has('id') ? 'edit' : 'add');
            session()->flash('modal_data', $req->all());

            return redirect()->back()->withErrors($validator);
        }

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
