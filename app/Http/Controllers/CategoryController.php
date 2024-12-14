<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Categories::all();

        return view('satuan&kategori.kategori', compact('categories'));
    }

    public function create(Request $req)
    {
        $req->validate([
            'name' => 'required|max:255'
        ], [
            'name.required' => 'nama satuan tidak boleh kosong'
        ]);


        if ($req->hasFile('gambar')) {
            $req->validate(
                [
                    'gambar' => 'mimes:jpeg,jpg,png|image|file'
                ],
                [
                    'gambar.mimes' => 'ekstensi gambar harus jpeg, jpg, png',
                    'gambar.image' => 'Format gambar salah',
                    'gambar.file' => 'format gambar bukan file'
                ]
            );

            $gambar_file = $req->file('gambar');
            $ekstensi_gambar = $gambar_file->extension();
            $nama_gambar = date('ymdhis') . "." . $ekstensi_gambar;
            $gambar_file->move(public_path('pictures/'), $nama_gambar);
        } else {
            $nama_gambar = "default.jpg";
        }

        Categories::create([
            'name' => $req->name,
            'gambar' => $nama_gambar
        ]);

        return back()->with('success', 'data kategori berhasil dibuat');
    }

    public function edit(Request $req)
    {
        $req->validate([
            'name' => 'required|max:255'
        ], [
            'name.required' => 'nama satuan tidak boleh kosong'
        ]);

        $kategori = Categories::find($req->id);
        if (!$kategori) {
            Categories::flash('error', 'data Satuan tidak tersedia');
            return;
        }

        if ($req->hasFile('gambar')) {

            $req->validate(
                [
                    'gambar' => 'mimes:jpeg,jpg,png|image|file'
                ],
                [
                    'gambar.mimes' => 'ekstensi gambar harus jpeg, jpg, png',
                    'gambar.image' => 'Format gambar salah',
                    'gambar.file' => 'format gambar bukan file'
                ]
            );

            if ($kategori->gambar !== 'default.jpg') {
                $oldImage = public_path('pictures/' . $kategori->gambar);
                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }

            // Simpan gambar baru
            $image = $req->file('gambar');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('pictures/'), $imageName);
        }

        $kategori->update([
            'name' => $req->name,
            'gambar' => $imageName
        ]);

        return back()->with('success', 'data kategori berhasil diubah');
    }

    public function delete($id)
    {

        $kategori = Categories::find($id);

        if (!$kategori) {
            Session::flash('error', 'data kategori tidak ditemukan');
            return;
        } else {
            $kategori->products()->detach();
            $kategori->delete();

            Session::flash('success', 'Data kategori berhasil dihapus');

            return redirect()->back();
        }
    }
}
