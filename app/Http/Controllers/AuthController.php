<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function index()
    {
        return view('login');
    }

    function create()
    {
        return view('registrasi');
    }

    function login(Request $request)
    {
        $request->validate(
            [
                'email' => 'required',
                'password' => 'required'
            ],
            [
                'email.required' => 'email wajib di isi',
                'password.required' => 'Password wajib di isi'
            ]
        );

        $dataLogin = [
            'email' => $request->email,
            'password' => $request->password

        ];

        if (Auth::attempt($dataLogin)) {
            if (Auth::user()->role === 'admin') {
                return "halo admin";
            } elseif (Auth::user()->role === 'kasir') {
                $toko = Auth::user()->market->nama_toko;
                return "kasir dari toko {$toko}";
            } else {
                return '';
            }
        }

        return 'email dan password salah';
    }
}
