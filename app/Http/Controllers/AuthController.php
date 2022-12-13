<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->method() == 'GET') {
            return view('auth.login');
        }

        $email = $request->email;
        $password = $request->password;
        $user = User::where('email', $email)->first();

        if ($user == null) {
            return redirect()
                ->back()
                ->withErrors([
                    'msg' => 'Email tidak ditemukan!'
                ]);
        }

        if (!Hash::check($password, $user->password)) {
            return redirect()
                ->back()
                ->withErrors([
                    'msg' => 'Password salah!'
                ]);
        }

        if (!session()->isStarted()) session()->start();
        session()->put('logged', true);
        session()->put('idUser', $user->id);
        return redirect()->route('home');
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}
