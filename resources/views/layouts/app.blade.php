<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Invoice App — Kelola invoice, pelanggan, dan pembayaran dengan mudah.">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') — Invoice App</title>

    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Anti-flicker: set theme before paint --}}
    <script>
        (function() {
            const theme = localStorage.getItem('theme') || 'light';
            if (theme === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        })();
    </script>
</head>
<body>
    {{-- Sidebar Overlay (Mobile) --}}
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    {{-- Sidebar --}}
    <aside class="sidebar" id="sidebar">
        {{-- Logo --}}
        <div class="sidebar-logo">
            <div class="logo-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: #fff;">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
            </div>
            <div>
                <div class="logo-text">InvoiceApp</div>
                <div class="logo-subtitle">Manajemen Invoice</div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="sidebar-nav">
            <a href="{{ url('/dashboard') }}" class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7" rx="1"/>
                    <rect x="14" y="3" width="7" height="7" rx="1"/>
                    <rect x="3" y="14" width="7" height="7" rx="1"/>
                    <rect x="14" y="14" width="7" height="7" rx="1"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ url('/pelanggan') }}" class="nav-item {{ request()->is('pelanggan*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                Pelanggan
            </a>

            @if(auth()->check() && auth()->user()->role === 'admin')
            <a href="{{ url('/karyawan') }}" class="nav-item {{ request()->is('karyawan*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M12 21v-2a4 4 0 0 0-4-4H4a4 4 0 0 0-4 4v2"/>
                </svg>
                Manajemen Karyawan
            </a>
            @endif


            <div class="nav-dropdown {{ request()->is('kendaraan*', 'jenis-kendaraan*', 'merk-kendaraan*') ? 'open' : '' }}" id="kendaraanDropdown">
                <button type="button" class="nav-item nav-dropdown-trigger {{ request()->is('kendaraan*', 'jenis-kendaraan*', 'merk-kendaraan*') ? 'active' : '' }}" onclick="toggleSidebarDropdown('kendaraanDropdown')">
                    <span style="display: flex; align-items: center; gap: 10px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="1" y="3" width="15" height="13"/>
                            <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/>
                            <circle cx="5.5" cy="18.5" r="2.5"/>
                            <circle cx="18.5" cy="18.5" r="2.5"/>
                        </svg>
                        Kendaraan
                    </span>
                    <svg class="chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="transition: transform 0.2s ease;">
                        <polyline points="9 18 15 12 9 6"/>
                    </svg>
                </button>
                <div class="nav-dropdown-items" style="{{ request()->is('kendaraan*', 'jenis-kendaraan*', 'merk-kendaraan*') ? 'display: block;' : 'display: none;' }}">
                    <a href="{{ url('/kendaraan') }}" class="nav-item {{ request()->is('kendaraan') ? 'active' : '' }}" style="padding-left: 36px; font-size: 13.5px; display: flex; align-items: center; gap: 8px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="16"/>
                            <line x1="8" y1="12" x2="16" y2="12"/>
                        </svg>
                        Daftar Kendaraan
                    </a>
                    <a href="{{ url('/jenis-kendaraan') }}" class="nav-item {{ request()->is('jenis-kendaraan*') ? 'active' : '' }}" style="padding-left: 36px; font-size: 13.5px; display: flex; align-items: center; gap: 8px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;">
                            <circle cx="12" cy="12" r="3"/>
                            <line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/>
                            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                            <line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/>
                            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                        </svg>
                        Jenis Kendaraan
                    </a>
                    <a href="{{ url('/merk-kendaraan') }}" class="nav-item {{ request()->is('merk-kendaraan*') ? 'active' : '' }}" style="padding-left: 36px; font-size: 13.5px; display: flex; align-items: center; gap: 8px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;">
                            <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                            <line x1="7" y1="7" x2="7.01" y2="7"/>
                        </svg>
                        Merk Kendaraan
                    </a>
                </div>
            </div>

            <a href="{{ url('/invoice') }}" class="nav-item {{ request()->is('invoice*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
                Invoice
            </a>

            <a href="{{ url('/pembayaran') }}" class="nav-item {{ request()->is('pembayaran*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                    <line x1="1" y1="10" x2="23" y2="10"/>
                </svg>
                Pembayaran
            </a>
        </nav>

        {{-- Footer --}}
        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}" style="margin: 0; padding: 0; width: 100%;">
                @csrf
                <button type="submit" class="upgrade-btn" style="width: 100%; border: none; cursor: pointer;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="main-content">
        {{-- Top Bar --}}
        <header class="top-bar">
            <div style="display: flex; align-items: center; gap: 16px;">
                <button class="mobile-menu-btn" onclick="toggleSidebar()" aria-label="Toggle menu">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="12" x2="21" y2="12"/>
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <line x1="3" y1="18" x2="21" y2="18"/>
                    </svg>
                </button>
                <h2 style="margin: 0; font-size: 18px; font-weight: 700; color: var(--color-text); letter-spacing: -0.01em;">@yield('title')</h2>
            </div>

            <div class="top-bar-actions">
                {{-- Theme Toggle --}}
                <button class="theme-toggle" id="themeToggle" aria-label="Toggle dark mode" onclick="toggleTheme()">
                    {{-- Sun icon (visible in dark mode) --}}
                    <svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="5"/>
                        <line x1="12" y1="1" x2="12" y2="3"/>
                        <line x1="12" y1="21" x2="12" y2="23"/>
                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
                        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                        <line x1="1" y1="12" x2="3" y2="12"/>
                        <line x1="21" y1="12" x2="23" y2="12"/>
                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/>
                        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                    </svg>
                    {{-- Moon icon (visible in light mode) --}}
                    <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
                    </svg>
                </button>

                 {{-- Notification Bell --}}
                 @php
                     $globalOverdueInvoices = \App\Models\Invoice::with('pelanggan')
                         ->where('status_pembayaran', 'Unpaid')
                         ->whereNotNull('tanggal_jatuh_tempo')
                         ->where('tanggal_jatuh_tempo', '<', now()->toDateString())
                         ->latest()
                         ->take(5)
                         ->get();
                     $globalOverdueCount = \App\Models\Invoice::where('status_pembayaran', 'Unpaid')
                         ->whereNotNull('tanggal_jatuh_tempo')
                         ->where('tanggal_jatuh_tempo', '<', now()->toDateString())
                         ->count();
                 @endphp
                 <style>
                     .notification-item:hover {
                         background-color: var(--color-surface-hover) !important;
                     }
                     @keyframes notificationFadeIn {
                         from { opacity: 0; transform: translateY(-4px); }
                         to { opacity: 1; transform: translateY(0); }
                     }
                 </style>
                 <div style="position: relative; display: inline-block;">
                     <button class="icon-btn" id="notificationBtn" aria-label="Notifications" onclick="toggleNotificationDropdown(event)" style="position: relative;">
                         <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                             <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                             <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                         </svg>
                         @if($globalOverdueCount > 0)
                             <span style="position: absolute; top: -5px; right: -5px; background-color: var(--color-danger); color: #fff; font-size: 9px; font-weight: 700; width: 16px; height: 16px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 0 0 2px var(--color-surface); line-height: 1; pointer-events: none;">
                                 {{ $globalOverdueCount }}
                             </span>
                         @endif
                     </button>
                     
                     <div class="notification-dropdown" id="notificationDropdown" style="display: none; position: absolute; top: 100%; right: 0; width: 340px; background-color: var(--color-surface); border: 1px solid var(--color-border); border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.15); z-index: 9999; margin-top: 8px; overflow: hidden; animation: notificationFadeIn 0.2s ease;">
                         <div style="padding: 14px 16px; border-bottom: 1px solid var(--color-border); display: flex; justify-content: space-between; align-items: center; background-color: var(--color-surface);">
                             <h4 style="margin: 0; font-size: 13px; font-weight: 700; color: var(--color-text); text-transform: uppercase; letter-spacing: 0.05em;">Tagihan Terlambat</h4>
                             <span class="badge {{ $globalOverdueCount > 0 ? 'badge-unpaid' : 'badge-paid' }}" style="font-size: 11px; padding: 2px 8px;">{{ $globalOverdueCount }} Total</span>
                         </div>
                         <div style="max-height: 280px; overflow-y: auto;">
                             @forelse($globalOverdueInvoices as $inv)
                                 <a href="{{ route('invoice.show', $inv) }}" style="display: block; padding: 12px 16px; border-bottom: 1px solid var(--color-border-light); text-decoration: none; transition: background 0.15s;" class="notification-item">
                                     <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                                         <span class="mono" style="font-size: 12px; font-weight: 700; color: var(--color-text);">{{ $inv->nomor_invoice }}</span>
                                         <span style="font-size: 11px; color: var(--color-danger); font-weight: 600;">Lewat {{ (int) now()->startOfDay()->diffInDays($inv->tanggal_jatuh_tempo->startOfDay()) }} hari</span>
                                     </div>
                                     <div style="font-size: 12px; color: var(--color-text-secondary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 2px;">
                                         {{ $inv->pelanggan->nama_pelanggan }}
                                     </div>
                                     <div style="display: flex; justify-content: space-between; align-items: center; font-size: 11px; color: var(--color-text-muted);">
                                         <span>Jatuh tempo: {{ $inv->tanggal_jatuh_tempo->format('d/m/Y') }}</span>
                                         <span style="font-weight: 600; color: var(--color-text);">Rp {{ number_format($inv->total_tagihan, 0, ',', '.') }}</span>
                                     </div>
                                 </a>
                             @empty
                                 <div style="padding: 32px 16px; text-align: center; color: var(--color-text-muted);">
                                     <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 auto 10px; opacity: 0.5; color: var(--color-success);">
                                         <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                         <polyline points="22 4 12 14.01 9 11.01"/>
                                     </svg>
                                     <div style="font-size: 13px; font-weight: 600; color: var(--color-text-secondary);">Semua tagihan lunas!</div>
                                     <div style="font-size: 11px; margin-top: 2px;">Tidak ada invoice yang melewati jatuh tempo.</div>
                                 </div>
                             @endforelse
                         </div>
                         @if($globalOverdueCount > 0)
                             <div style="padding: 10px 16px; border-top: 1px solid var(--color-border); text-align: center; background-color: var(--color-bg);">
                                 <a href="{{ route('invoice.index', ['status' => 'Overdue']) }}" style="font-size: 11px; font-weight: 700; color: var(--color-primary); text-decoration: none;">
                                     Lihat Semua Tagihan Terlambat &rarr;
                                 </a>
                             </div>
                         @endif
                     </div>
                 </div>

                {{-- Avatar --}}
                <div class="avatar">A</div>
            </div>
        </header>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div style="padding: 32px 32px 0;">
                <div class="alert alert-success animate-fade-in">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div style="padding: 32px 32px 0;">
                <div class="alert alert-danger animate-fade-in">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="15" y1="9" x2="9" y2="15"/>
                        <line x1="9" y1="9" x2="15" y2="15"/>
                    </svg>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        {{-- Page Content --}}
        <main class="content-area animate-fade-in">
            @hasSection('page-actions')
                <div class="page-header" style="justify-content: flex-end; margin-bottom: 20px;">
                    <div class="page-header-actions">
                        @yield('page-actions')
                    </div>
                </div>
            @endif
            @yield('content')
        </main>
    </div>

    {{-- Sidebar Toggle Script --}}
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('open');
            overlay.classList.toggle('open');
        }

        function toggleSidebarDropdown(id) {
            const dropdown = document.getElementById(id);
            if (dropdown) {
                const isOpen = dropdown.classList.contains('open');
                const items = dropdown.querySelector('.nav-dropdown-items');
                if (isOpen) {
                    dropdown.classList.remove('open');
                    if (items) items.style.display = 'none';
                } else {
                    dropdown.classList.add('open');
                    if (items) items.style.display = 'block';
                }
            }
        }

        function toggleTheme() {
            const html = document.documentElement;
            const isDark = html.getAttribute('data-theme') === 'dark';

            if (isDark) {
                html.removeAttribute('data-theme');
                localStorage.setItem('theme', 'light');
            } else {
                html.setAttribute('data-theme', 'dark');
                localStorage.setItem('theme', 'dark');
            }
        }

        function toggleNotificationDropdown(event) {
            event.stopPropagation();
            const dropdown = document.getElementById('notificationDropdown');
            if (dropdown) {
                const isShowing = dropdown.style.display === 'block';
                dropdown.style.display = isShowing ? 'none' : 'block';
            }
        }

        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('notificationDropdown');
            const btn = document.getElementById('notificationBtn');
            if (dropdown && !dropdown.contains(event.target) && event.target !== btn && !event.target.closest('#notificationBtn')) {
                dropdown.style.display = 'none';
            }
        });
    </script>

    @stack('modals')
    @stack('scripts')
</body>
</html>
