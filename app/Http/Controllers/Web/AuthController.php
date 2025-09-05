<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        // Redirect if already logged in
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function showRegister()
    {
        // Redirect if already logged in
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
        ]);

        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            // Redirect based on user role
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Selamat datang, Admin!');
            }
            
            return redirect()->intended('/dashboard')->with('success', 'Selamat datang, ' . Auth::user()->name . '!');
        }

        throw ValidationException::withMessages([
            'email' => ['Email atau password salah.'],
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'agree_terms' => 'required|accepted',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'agree_terms.required' => 'Anda harus menyetujui syarat dan ketentuan',
            'agree_terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan',
        ]);

        // Generate unique username from name
        $username = $this->generateUniqueUsername($request->name);

        $user = User::create([
            'name' => $request->name,
            'username' => $username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Default role
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Akun berhasil dibuat! Selamat datang, ' . $user->name . '!');
    }

    public function logout(Request $request)
    {
        $userName = Auth::user()->name ?? 'User';
        
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda berhasil logout. Sampai jumpa, ' . $userName . '!');
    }

    /**
     * Generate unique username from name
     */
    private function generateUniqueUsername($name)
    {
        $baseUsername = Str::slug($name);
        $username = $baseUsername;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . '_' . $counter;
            $counter++;
        }

        return $username;
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback(Request $request)
    {
        try {
            // Get user data from Google
            $googleUser = $request->all();
            
            // Check if user exists
            $user = User::where('email', $googleUser['email'])->first();
            
            if (!$user) {
                // Create new user
                $username = $this->generateUniqueUsername($googleUser['name']);
                
                $user = User::create([
                    'name' => $googleUser['name'],
                    'username' => $username,
                    'email' => $googleUser['email'],
                    'google_id' => $googleUser['id'] ?? null,
                    'avatar' => $googleUser['picture'] ?? null,
                    'password' => Hash::make(Str::random(16)), // Random password for OAuth users
                    'role' => 'user',
                ]);
            } else {
                // Update existing user with Google info
                $user->update([
                    'google_id' => $googleUser['id'] ?? $user->google_id,
                    'avatar' => $googleUser['picture'] ?? $user->avatar,
                ]);
            }

            Auth::login($user);
            return redirect()->route('dashboard')->with('success', 'Selamat datang, ' . $user->name . '!');

        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Gagal login dengan Google. Silakan coba lagi.']);
        }
    }
} 