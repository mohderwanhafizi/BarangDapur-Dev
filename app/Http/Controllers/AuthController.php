<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class AuthController extends Controller
{
    public function __construct(
        protected InventoryService $inventoryService
    ) {}

    public function redirect()
    {
        // Stateless() wajib untuk cross-device testing (Mobile <-> PC) guna IP
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Cari user atau cipta user baru
            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'password' => bcrypt(Str::random(16)), // Guna Str::random yang diimport
                    'email_verified_at' => now(),
                ]
            );

            Auth::login($user, true);

            // Sync barang dari Guest ke akaun User
            $this->inventoryService->syncGuestItems($user->email, $user->id);

            return redirect()->intended('/dashboard')->with('success', 'Berjaya log masuk!');

        } catch (Exception $e) {
            // Jika masih ada error malformed, mesej $e->getMessage() akan beritahu puncanya
            return redirect('/login')->with('error', 'Gagal log masuk: ' . $e->getMessage());
        }
    }

    /**
     * Log masuk manual
     */
    public function loginManual(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            $this->inventoryService->syncGuestItems($request->email, Auth::id());

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors(['email' => 'E-mel atau kata laluan tidak tepat.'])->onlyInput('email');
    }

    /**
     * Log keluar
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}