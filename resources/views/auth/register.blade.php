<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Admin - Invoice App</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .mesh-bg {
            background-color: #0f172a;
            background-image: 
                radial-gradient(at 100% 100%, hsla(253,16%,7%,1) 0, transparent 50%), 
                radial-gradient(at 50% 100%, hsla(225,39%,30%,1) 0, transparent 50%), 
                radial-gradient(at 0% 100%, hsla(339,49%,30%,1) 0, transparent 50%);
        }
        .blob {
            position: absolute;
            filter: blur(60px);
            z-index: 0;
            opacity: 0.6;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-50 flex items-center justify-center relative overflow-hidden p-4">
    <!-- Animated Background Blobs -->
    <div class="blob bg-blue-400 w-96 h-96 rounded-full bottom-[-10%] left-[-10%] mix-blend-multiply"></div>
    <div class="blob bg-purple-400 w-96 h-96 rounded-full top-[-10%] right-[-10%] mix-blend-multiply"></div>

    <div class="w-full max-w-[1000px] flex flex-row-reverse rounded-[2rem] shadow-[0_20px_50px_rgba(8,_112,_184,_0.1)] overflow-hidden relative z-10 bg-white">
        
        <!-- Right Side: Branding -->
        <div class="hidden lg:flex lg:w-5/12 mesh-bg p-12 text-white flex-col justify-between relative overflow-hidden">
            <div class="relative z-10 text-right">
                <div class="flex items-center justify-end gap-3 mb-16">
                    <span class="text-2xl font-bold tracking-wide">InvoiceApp</span>
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-md border border-white/10">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                    </div>
                </div>
                <h1 class="text-4xl font-extrabold leading-tight mb-4 text-right">Langkah<br>Pertama.</h1>
                <p class="text-slate-300 text-lg text-right">Buat akun Administrator pertama untuk memegang kendali penuh aplikasi.</p>
            </div>
            
            <!-- Decorative elements -->
            <div class="absolute top-[30%] left-[-20%] w-64 h-64 border-[30px] border-white/5 rounded-full"></div>
            <div class="absolute bottom-[-10%] right-[-20%] w-80 h-80 border-[40px] border-white/5 rounded-full"></div>
        </div>

        <!-- Left Side: Form -->
        <div class="w-full lg:w-7/12 p-8 sm:p-14 lg:p-16 bg-white/80 backdrop-blur-xl">
            <div class="max-w-md mx-auto">
                <div class="mb-10 text-center lg:text-left">
                    <div class="inline-flex items-center justify-center px-3 py-1 rounded-full bg-blue-100 text-blue-700 font-bold text-xs uppercase tracking-wider mb-4">Setup Initial</div>
                    <h2 class="text-3xl font-bold text-slate-800 mb-2">Buat Akun Admin</h2>
                    <p class="text-slate-500 font-medium">Lengkapi form di bawah untuk membuat akun utama Anda.</p>
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

                <form action="{{ route('register') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <div class="space-y-1.5">
                        <label for="name" class="block text-sm font-semibold text-slate-700">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                                class="block w-full pl-11 pr-4 py-3.5 rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all shadow-sm placeholder:text-slate-400"
                                placeholder="John Doe">
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label for="email" class="block text-sm font-semibold text-slate-700">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="block w-full pl-11 pr-4 py-3.5 rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all shadow-sm placeholder:text-slate-400"
                                placeholder="admin@perusahaan.com">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
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

                        <div class="space-y-1.5">
                            <label for="password_confirmation" class="block text-sm font-semibold text-slate-700">Konfirmasi Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                    class="block w-full pl-11 pr-4 py-3.5 rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white text-slate-800 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all shadow-sm placeholder:text-slate-400"
                                    placeholder="••••••••">
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                        class="relative w-full py-4 px-4 bg-slate-900 hover:bg-blue-600 text-white font-bold rounded-xl overflow-hidden group transition-all duration-300 hover:shadow-[0_8px_25px_rgba(37,99,235,0.3)] hover:-translate-y-0.5 mt-6">
                        <span class="relative z-10 flex items-center justify-center gap-2">
                            Selesaikan Setup
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </span>
                    </button>
                </form>

                <div class="mt-8 text-center text-sm font-medium text-slate-500">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 hover:text-slate-800 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali ke halaman Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
