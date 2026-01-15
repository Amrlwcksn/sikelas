<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center p-6 bg-main" style="background-image: radial-gradient(at 0% 0%, rgba(37, 99, 235, 0.1) 0px, transparent 50%), radial-gradient(at 100% 100%, rgba(15, 23, 42, 0.1) 0px, transparent 50%);">
        <div class="glass-card w-full max-w-[1100px] overflow-hidden flex flex-col lg:flex-row !p-0" style="min-height: 680px; background: rgba(255, 255, 255, 0.8);">
            <!-- Left Side: Banking Brand -->
            <div class="hidden lg:flex lg:w-3/5 relative p-16 flex-col justify-between text-white" style="background: var(--grad-banking);">
                <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center gap-4 mb-12">
                        <div style="width: 54px; height: 54px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary-accent); shadow: 0 10px 20px rgba(0,0,0,0.1); font-weight: 950; font-size: 1.75rem; font-family: 'Plus Jakarta Sans', sans-serif;">
                            G
                        </div>
                        <div>
                            <h1 class="text-4xl font-black tracking-tighter text-blue-500 leading-none">Genite24<span class="text-white">.</span></h1>
                            <p class="text-xs font-bold tracking-[0.2em] uppercase text-white/60 mt-1">Sikelas Platform</p>
                        </div>
                    </div>
                    
                    <h2 class="text-5xl font-black leading-tight tracking-tight text-white">Sistem Administrasi Keuangan Kas Kelas.</h2>
                    <p class="mt-6 text-xl text-slate-400 font-medium max-w-md">Memudahkan pengelolaan keuangan kelas secara transparan, rapi, dan efisien.</p>
                </div>

                <div class="relative z-10">
                    <div class="bg-white/10 backdrop-blur-xl p-6 rounded-2xl border border-white/10 inline-flex flex-col gap-2">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
                            <span class="text-sm font-bold tracking-widest uppercase text-white">Pemantauan Aktual</span>
                        </div>
                        <p class="text-xs text-white/60">Pantau saldo dan riwayat transaksi berdasarkan data terbaru yang telah dicatat dan diperbarui oleh admin.</p>
                    </div>
                </div>
            </div>

            <!-- Right Side: Login Logic -->
            <div class="w-full lg:w-2/5 p-12 lg:p-16 flex flex-col justify-center">
                <div class="mb-10">
                    <h3 class="text-3xl font-black text-slate-900 tracking-tight">Selamat Datang</h3>
                    <p class="text-slate-600 mt-2 font-medium">Akses dasbor keuangan melalui akun Anda.</p>
                </div>

                <x-auth-session-status class="mb-6" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- NPM Input -->
                    <div>
                        <label for="npm" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">NPM / Identitas</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i data-lucide="user" style="width: 18px; height: 18px;"></i>
                            </div>
                            <input id="npm" type="text" name="npm" value="{{ old('npm') }}" required autofocus 
                                class="w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all outline-none font-semibold text-slate-800" 
                                placeholder="Masukkan NPM">
                        </div>
                        <x-input-error :messages="$errors->get('npm')" class="mt-2" />
                    </div>

                    <!-- Password Input -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label for="password" class="block text-xs font-bold text-slate-400 uppercase tracking-widest">PIN / Kata Sandi</label>
                            @if (Route::has('password.request'))
                                <a class="text-xs font-bold text-primary-accent hover:underline" href="{{ route('password.request') }}">
                                    Lupa PIN?
                                </a>
                            @endif
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i data-lucide="lock" style="width: 18px; height: 18px;"></i>
                            </div>
                            <input id="password" type="password" name="password" required 
                                class="w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all outline-none font-semibold text-slate-800" 
                                placeholder="••••••••">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Options -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="flex items-center gap-2 cursor-pointer group">
                            <input id="remember_me" type="checkbox" class="w-4 h-4 rounded border-slate-300 text-primary-accent focus:ring-primary-accent" name="remember">
                            <span class="text-sm text-slate-600 group-hover:text-slate-900 transition-colors font-bold">Ingat saya</span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary w-full py-5 rounded-2xl text-lg shadow-xl shadow-blue-500/20">
                        Masuk Portal <i data-lucide="arrow-right" class="ml-2"></i>
                    </button>
                </form>

                <div class="mt-12 pt-8 border-t border-slate-100 text-center">
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-4">Butuh Bantuan Akses?</p>
                    <p class="text-xs text-slate-400 font-light tracking-widest mb-4">Silakan hubungi pengurus kelas untuk mendapatkan bantuan dan informasi lebih lanjut.</p>
                    <div class="flex justify-center gap-6">
                        <a href="#" class="text-slate-400 hover:text-primary-accent transition-colors"><i data-lucide="help-circle" style="width: 20px;"></i></a>
                        <a href="#" class="text-slate-400 hover:text-primary-accent transition-colors"><i data-lucide="message-square" style="width: 20px;"></i></a>
                        <a href="#" class="text-slate-400 hover:text-primary-accent transition-colors"><i data-lucide="globe" style="width: 20px;"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
