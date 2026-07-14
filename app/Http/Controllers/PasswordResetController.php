<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    public function showDirectForm()
    {
        return view('auth.reset-direct');
    }

    public function updateDirect(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.exists' => 'Email ini tidak terdaftar di sistem kami.'
        ]);

        $user = User::where('email', $request->email)->first();
        
        $user->forceFill([
            'password' => Hash::make($request->password)
        ])->save();

        return redirect()->route('login')->with('success', 'Password berhasil diubah. Silakan login dengan password baru.');
    }
}
