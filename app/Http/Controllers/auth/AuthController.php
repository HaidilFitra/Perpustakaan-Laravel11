<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cookie;


class AuthController extends Controller
{

    public function formRegister()
    {
        return view('auth.register');
    }

    public function formLogin()
    {
        return view('auth.login');
    }

    public function Register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'username' => 'required',
            'nama_lengkap' => 'required',
            'alamat' => 'required',
            'email' => 'required|email|unique:user',
            'password' => 'required|min:8',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        } else {
            User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'nama_lengkap' => $request->nama_lengkap,
                'alamat' => $request->alamat,
                'email' => $request->email,
            ]);
            return redirect()->route('formLogin');
        }
    }

    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required|recaptcha', 
        ]);

        if ($validate->fails()) {
            return back()->withErrors($validate)->withInput();
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            Cookie::queue('last_activity', time(), 60, null, null, true, true);
            return redirect()->route($this->getRedirectRoute(Auth::user()->role));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function checkTimeout()
    {
        if (!Auth::check()) {
            return response()->json(['timeout' => false, 'logged_in' => false]);
        }

        $lastActivity = Cookie::get('last_activity');
        $timeout = config('session.lifetime') * 60; // Convert minutes to seconds

        if (!$lastActivity || (time() - $lastActivity) > $timeout) {
            $this->performLogout();
            return response()->json([
                'timeout' => true, 
                'logged_in' => false, 
                'message' => 'Session expired',
                'redirect' => route('home')  // Add redirect URL
            ]);
        }

        // Update last activity time with secure cookie
        Cookie::queue('last_activity', time(), 60, null, null, true, true);
        return response()->json(['timeout' => false, 'logged_in' => true]);
    }

    private function getRedirectRoute($role)
    {
        $routes = [
            'administrator' => 'admin.dashboard',
            'petugas' => 'petugas.dashboard',
            'peminjam' => 'home',
        ];
        return $routes[$role];
    }

    public function logout(Request $request)
    {
        $this->performLogout($request);
        return redirect()->route('home');
    }

    private function performLogout($request = null)
    {
        Auth::logout();
        if ($request) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
        Cookie::queue(Cookie::forget('last_activity'));
    }
}
