<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // 1. Logika Admin: Otomatis buat akun jika belum ada (Tanpa Register Manual)
        if ($request->email === 'admin@gmail.com' && $request->password === '12345678') {
            
            // Mencari user admin, jika tidak ditemukan maka dibuat otomatis
            $admin = User::firstOrCreate(
                ['email' => 'admin@gmail.com'],
                [
                    'name' => 'Admin Powerhaul',
                    'password' => Hash::make('12345678'),
                ]
            );

            // Melakukan login resmi ke sistem Laravel (Penting untuk Middleware 'auth')
            Auth::login($admin);
            
            // Regenerasi session untuk keamanan
            $request->session()->regenerate();
            
            // Menyimpan role di session (opsional, untuk pengecekan tambahan)
            session(['role' => 'admin']);
            
            return redirect()->route('dashboard.admin');
        }

        // 2. Logika User Biasa (Hasil Register yang ada di Database)
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            session(['role' => 'user']);
            return redirect()->route('dashboard');
        }

        // Jika gagal login
        return back()->with('error', 'Email atau Password salah!');
    }

    public function logout(Request $request)
    {
        // Logout dari sistem
        Auth::logout();
        
        // Membersihkan dan mematikan session
        $request->session()->invalidate();
        
        // Membuat ulang token CSRF baru
        $request->session()->regenerateToken();

        // Kembali ke halaman utama (home)
        return redirect('/'); 
    }
}