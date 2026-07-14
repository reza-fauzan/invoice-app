@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="animate-fade-in">
    <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Informasi Pribadi -->
        <div class="bg-[var(--color-surface)] border border-[var(--color-border)] rounded-xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-[var(--color-border)] bg-[var(--color-surface-hover)]/30">
                <h3 class="text-[15px] font-semibold text-[var(--color-text)]">Informasi Pribadi</h3>
            </div>
            <div class="p-6">
                <div class="flex items-center gap-6 mb-8">
                    <div class="w-20 h-20 rounded-full bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400 flex items-center justify-center text-2xl font-bold shrink-0">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="text-lg font-bold text-[var(--color-text)]">{{ auth()->user()->name }}</div>
                        <div class="text-sm text-[var(--color-text-secondary)]">{{ auth()->user()->email }}</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-[var(--color-text)] mb-2">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                            class="w-full px-4 py-2.5 rounded-lg border border-[var(--color-border)] bg-[var(--color-bg)] focus:bg-[var(--color-surface)] text-[var(--color-text)] focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors sm:text-sm">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-[var(--color-text)] mb-2">Alamat Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="w-full px-4 py-2.5 rounded-lg border border-[var(--color-border)] bg-[var(--color-bg)] focus:bg-[var(--color-surface)] text-[var(--color-text)] focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors sm:text-sm">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Keamanan -->
        <div class="bg-[var(--color-surface)] border border-[var(--color-border)] rounded-xl overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-[var(--color-border)] bg-[var(--color-surface-hover)]/30 flex justify-between items-center">
                <h3 class="text-[15px] font-semibold text-[var(--color-text)]">Ganti Password</h3>
                <span class="text-xs text-[var(--color-text-muted)] bg-[var(--color-bg)] px-2 py-1 rounded border border-[var(--color-border)]">Opsional</span>
            </div>
            <div class="p-6">
                <p class="text-sm text-[var(--color-text-secondary)] mb-6">Biarkan kosong jika Anda tidak ingin mengubah password saat ini.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-medium text-[var(--color-text)] mb-2">Password Baru</label>
                        <input type="password" id="password" name="password"
                            class="w-full px-4 py-2.5 rounded-lg border border-[var(--color-border)] bg-[var(--color-bg)] focus:bg-[var(--color-surface)] text-[var(--color-text)] focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors sm:text-sm"
                            placeholder="••••••••">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-[var(--color-text)] mb-2">Konfirmasi Password Baru</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="w-full px-4 py-2.5 rounded-lg border border-[var(--color-border)] bg-[var(--color-bg)] focus:bg-[var(--color-surface)] text-[var(--color-text)] focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-colors sm:text-sm"
                            placeholder="••••••••">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-2">
            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
