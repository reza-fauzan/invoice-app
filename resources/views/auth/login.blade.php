<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Invoice App</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .mesh-bg {
            background-color: #0f172a;
            background-image: 
                radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), 
                radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(339,49%,30%,1) 0, transparent 50%);
        }
        .blob {
            position: absolute;
            filter: blur(60px);
            z-index: 0;
            opacity: 0.6;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-50 flex items-center justify-center relative overflow-hidden">
    <!-- Animated Background Blobs -->
    <div class="blob bg-blue-400 w-96 h-96 rounded-full top-[-10%] left-[-10%] mix-blend-multiply animate-blob"></div>
    <div class="blob bg-purple-400 w-96 h-96 rounded-full bottom-[-10%] right-[-10%] mix-blend-multiply animate-blob animation-delay-2000"></div>
    <div class="blob bg-pink-400 w-96 h-96 rounded-full top-[20%] right-[20%] mix-blend-multiply animate-blob animation-delay-4000"></div>

    <div class="w-full max-w-[1000px] flex rounded-[2rem] shadow-[0_20px_50px_rgba(8,_112,_184,_0.1)] overflow-hidden m-4 relative z-10 bg-white">
        
        <!-- Left Side: Branding/Image -->
        <div class="hidden lg:flex lg:w-5/12 mesh-bg p-12 text-white flex-col justify-between relative overflow-hidden">
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-16">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-md border border-white/10">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/>
                            <line x1="16" y1="17" x2="8" y2="17"/>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold tracking-wide">InvoiceApp</span>
                </div>
                <h1 class="text-4xl font-extrabold leading-tight mb-4">Kelola Tagihan<br>Lebih Cerdas.</h1>
                <p class="text-slate-300 text-lg">Sistem manajemen invoice modern untuk mempercepat bisnis dan operasional Anda.</p>
            </div>
            
            <div class="relative z-10">
                <div class="flex items-center gap-4">
                    <div class="flex -space-x-3">
                        <div class="w-10 h-10 rounded-full border-2 border-slate-800 bg-blue-500 flex items-center justify-center text-xs font-bold">1k+</div>
                        <div class="w-10 h-10 rounded-full border-2 border-slate-800 bg-purple-500 flex items-center justify-center">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        </div>
                    </div>
                    <p class="text-sm font-medium text-slate-300">Bergabung dengan pengguna lainnya</p>
                </div>
            </div>
            
            <!-- Decorative circles -->
            <div class="absolute top-[-20%] right-[-10%] w-72 h-72 border-[40px] border-white/5 rounded-full"></div>
            <div class="absolute bottom-[-10%] left-[-20%] w-96 h-96 border-[60px] border-white/5 rounded-full"></div>
        </div>

        <!-- Right Side: Form -->
        <div class="w-full lg:w-7/12 p-8 sm:p-14 lg:p-16 bg-white/80 backdrop-blur-xl">
            <div class="max-w-md mx-auto">
                <div class="mb-10 text-center lg:text-left">
                    <h2 class="text-3xl font-bold text-slate-800 mb-2">Selamat Datang 👋</h2>
                    <p class="text-slate-500 font-medium">Silakan masuk untuk melanjutkan ke dashboard.</p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-50/80 border border-red-100 text-red-600 px-5 py-4 rounded-xl mb-8 text-sm backdrop-blur-sm flex items-start gap-3 shadow-sm">
                        <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <div>
                            <span class="font-semibold block mb-1">Terjadi Kesalahan:</span>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="space-y-1.5">
                        <label for="email" class="block text-sm font-semibold text-slate-700">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                                class="block w-full pl-11 pr-4 py-3.5 rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all shadow-sm placeholder:text-slate-400"
                                placeholder="nama@perusahaan.com">
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input type="password" id="password" name="password" required
                                class="block w-full pl-11 pr-4 py-3.5 rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all shadow-sm placeholder:text-slate-400"
                                placeholder="••••••••">
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <label class="flex items-center space-x-3 cursor-pointer group">
                            <div class="relative flex items-center justify-center">
                                <input type="checkbox" name="remember" class="peer sr-only">
                                <div class="w-5 h-5 rounded border-2 border-slate-300 peer-checked:bg-blue-600 peer-checked:border-blue-600 transition-colors"></div>
                                <svg class="absolute w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span class="text-sm font-medium text-slate-600 group-hover:text-slate-800 transition-colors">Ingat saya</span>
                        </label>
                        <a href="#" class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors">Lupa password?</a>
                    </div>

                    <button type="submit"
                        class="relative w-full py-3.5 px-4 bg-slate-900 hover:bg-blue-600 text-white font-semibold rounded-xl overflow-hidden group transition-all duration-300 hover:shadow-[0_8px_25px_rgba(37,99,235,0.3)] hover:-translate-y-0.5 mt-4">
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            Masuk ke Dashboard
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </span>
                    </button>
                </form>

                @if(!$adminExists)
                <div class="mt-10 pt-8 border-t border-slate-100 text-center">
                    <div class="inline-block p-4 rounded-2xl bg-blue-50/50 border border-blue-100">
                        <h3 class="text-sm font-bold text-slate-800 mb-1">Aplikasi Baru Diinstall?</h3>
                        <p class="text-xs text-slate-500 mb-3">Sistem mendeteksi belum ada akun admin.</p>
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-white border border-slate-200 text-sm font-bold text-blue-600 rounded-lg hover:border-blue-200 hover:bg-blue-50 transition-all shadow-sm">
                            Setup Akun Admin
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
