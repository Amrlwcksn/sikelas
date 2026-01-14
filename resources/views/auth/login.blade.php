<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="flex w-full max-w-[1000px] bg-white rounded-[2rem] shadow-lg overflow-hidden min-h-[600px]">
            <!-- Left Side: Visual -->
            <div class="hidden lg:flex lg:w-1/2 relative p-12 flex-col justify-between text-white overflow-hidden">
                <div class="absolute inset-0 z-0">
                    <img src="{{ asset('images/login-bg.png') }}" class="w-full h-full object-cover" alt="Background">
                    <div class="absolute inset-0 bg-primary/20 backdrop-blur-[2px]"></div>
                </div>
                
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center border border-white/30">
                            <span class="text-xl font-bold">S</span>
                        </div>
                        <h1 class="text-2xl font-bold tracking-tight">Sikelas</h1>
                    </div>
                    <h2 class="text-4xl font-extrabold leading-tight">Kelola Kas Kelas <br> Lebih Profesional.</h2>
                    <p class="mt-4 text-white/80 text-lg">Platform manajemen keuangan kelas yang transparan, aman, dan mudah digunakan.</p>
                </div>

                <div class="relative z-10 flex gap-4 text-sm font-medium">
                    <div class="bg-white/10 backdrop-blur-md px-4 py-2 rounded-full border border-white/20">Modern</div>
                    <div class="bg-white/10 backdrop-blur-md px-4 py-2 rounded-full border border-white/20">Secure</div>
                    <div class="bg-white/10 backdrop-blur-md px-4 py-2 rounded-full border border-white/20">Efficient</div>
                </div>
            </div>

            <!-- Right Side: Form -->
            <div class="w-full lg:w-1/2 p-12 flex flex-col justify-center">
                <div class="mb-10 text-center lg:text-left">
                    <h3 class="text-3xl font-bold text-main mb-2">Selamat Datang</h3>
                    <p class="text-text-muted">Silakan masuk menggunakan NPM Anda.</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- NPM -->
                    <div>
                        <label for="npm" class="block text-sm font-semibold text-main mb-2">NPM</label>
                        <input id="npm" type="text" name="npm" value="{{ old('npm') }}" required autofocus 
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none" placeholder="Masukkan NPM Anda">
                        <x-input-error :messages="$errors->get('npm')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex justify-between mb-2">
                            <label for="password" class="block text-sm font-semibold text-main">Password</label>
                            @if (Route::has('password.request'))
                                <a class="text-sm font-medium text-primary hover:primary-hover" href="{{ route('password.request') }}">
                                    Lupa Password?
                                </a>
                            @endif
                        </div>
                        <input id="password" type="password" name="password" required 
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none" placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <label for="remember_me" class="flex items-center gap-3 cursor-pointer group">
                        <input id="remember_me" type="checkbox" class="w-5 h-5 rounded border-slate-300 text-primary shadow-sm focus:ring-0 focus:ring-offset-0" name="remember">
                        <span class="text-sm text-text-muted group-hover:text-main transition-colors">Ingat saya untuk 30 hari</span>
                    </label>

                    <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; padding: 1.25rem; border-radius: 1rem; font-size: 1.125rem;">
                        Masuk Ke Akun
                    </button>
                </form>

                <div class="mt-10 pt-10 border-t border-slate-100 text-center">
                    <p class="text-sm text-text-muted">Butuh akses? Hubungi pengurus kelas Anda.</p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
