<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index()
    {
        if (!Session::has('status_login')) {
            return view('login');
        } else {
            return redirect('/');
        }
    }

    public function submit(Request $request)
    {
        if ($request->input('username') == null or $request->input('password') == null) {
            return redirect('/login')->with('info', "Harap Isi Username dan Password");
        } else {
            $getuser = UserModel::where('username', $request->username)->get();
            if (sizeof($getuser) > 0) {
                if (password_verify($request->password, $getuser[0]->password)) {
                    Session::put('status_login', true);
                    Session::put('username', $request->username);
                    return redirect('/');
                } else {
                    return redirect('/login')->with('warning', "Password Salah");
                }
            } else {
                return redirect('/login')->with('warning', "Username Tidak Terdaftar");
            }
        }
    }

    public function logout()
    {
        if (Session::has('status_login')) {
            Session::flush();
            Session::invalidate();
            return redirect('/login')->with('logout_success', 'Logout Berhasil!');
        } else {
            return redirect('/login')->with('invalid', 'Silakan Login Dahulu!');
        }
    }
}