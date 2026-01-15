<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Sikelas</title>
    <link rel="stylesheet" href="{{ asset('css/sikelas.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    @stack('styles')
</head>
<body>
    <div class="admin-container">
        <!-- Mobile Nav Toggle -->
        <button class="mobile-nav-toggle" id="menuToggle">
            <i data-lucide="menu"></i>
        </button>

        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <a href="{{ route('admin.dashboard') }}" class="logo" style="flex-direction: row; align-items: center; gap: 0.75rem;">
                <div style="width: 36px; height: 36px; min-width: 36px; background: var(--grad-button); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 900; font-size: 1.25rem;">G</div>
                <div style="display: flex; flex-direction: column;">
                    <span style="font-size: 1.35rem; line-height: 1;">Genite24<span class="text-blue-600">.</span></span>
                    <span style="font-size: 0.6rem; font-weight: 700; tracking: 0.1em; text-transform: uppercase; color: var(--text-muted); margin-top: 0.125rem;">Sikelas Platform</span>
                </div>
            </a>
            
            <nav class="nav-links">
                <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i data-lucide="layout-dashboard"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('admin.students') }}" class="nav-item {{ request()->routeIs('admin.students') ? 'active' : '' }}">
                    <i data-lucide="users-round"></i>
                    <span>Mahasiswa</span>
                </a>
                
                <a href="{{ route('admin.transactions') }}" class="nav-item {{ request()->routeIs('admin.transactions') ? 'active' : '' }}">
                    <i data-lucide="arrow-left-right"></i>
                    <span>Transaksi</span>
                </a>
                
                <a href="{{ route('admin.rekap') }}" class="nav-item {{ request()->routeIs('admin.rekap') ? 'active' : '' }}">
                    <i data-lucide="line-chart"></i>
                    <span>Rekap Kas</span>
                </a>
                
                <a href="{{ route('admin.cek-saldo') }}" class="nav-item {{ request()->routeIs('admin.cek-saldo') ? 'active' : '' }}">
                    <i data-lucide="wallet"></i>
                    <span>Cek Saldo</span>
                </a>
                
                <a href="{{ route('admin.registrasi') }}" class="nav-item {{ request()->routeIs('admin.registrasi') ? 'active' : '' }}">
                    <i data-lucide="user-plus-2"></i>
                    <span>Registrasi</span>
                </a>
                
                <div style="margin-top: auto; padding-top: 2rem;">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-item" style="width: 100%; border: none; background: transparent; cursor: pointer; color: var(--danger);">
                            <i data-lucide="log-out"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content">
            <!-- Header/Top Nav -->
            <header class="header-content" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem;">
                <div>
                    <h2 style="font-size: 1.1rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Authorized Access</h2>
                    <h1 style="font-size: 2.25rem; font-weight: 900; letter-spacing: -0.05em; margin-top: 0.25rem;">Administrator</h1>
                </div>
                <div style="display: flex; gap: 1.25rem; align-items: center;">
                    <div style="text-align: right; display: none; @media (min-width: 641px) { display: block; }">
                        <div style="font-size: 0.875rem; font-weight: 800; color: var(--primary);">ADMIN SYSTEM</div>
                        <div style="font-size: 0.75rem; color: var(--success); font-weight: 700;">• ONLINE</div>
                    </div>
                    <div style="width: 54px; height: 54px; min-width: 54px; border-radius: 18px; background: var(--grad-button); display: flex; align-items: center; justify-content: center; color: white; box-shadow: 0 8px 16px rgba(37, 99, 235, 0.2);">
                        <i data-lucide="user-cog"></i>
                    </div>
                </div>
            </header>

            <!-- Alerts (Responsive) -->
            <div style="max-width: 100%;">
                @if(session('success'))
                    <div class="glass-card" style="background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.2); color: #065f46; margin-bottom: 2rem; padding: 1.25rem;">
                        <div style="display: flex; gap: 0.75rem; align-items: center;">
                            <i data-lucide="check-circle-2" style="width: 24px; height: 24px;"></i>
                            <span style="font-weight: 700; font-size: 0.95rem;">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif
                @if(session('error'))
                    <div class="glass-card" style="background: rgba(239, 68, 68, 0.1); border-color: rgba(239, 68, 68, 0.2); color: #991b1b; margin-bottom: 2rem; padding: 1.25rem;">
                        <div style="display: flex; gap: 0.75rem; align-items: center;">
                            <i data-lucide="alert-circle" style="width: 24px; height: 24px;"></i>
                            <span style="font-weight: 700; font-size: 0.95rem;">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif
            </div>

            @yield('content')
        </main>
    </div>
    
    <script>
        lucide.createIcons();

        // Mobile Menu Toggle
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        
        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('show');
            const icon = menuToggle.querySelector('i');
            if (sidebar.classList.contains('show')) {
                icon.setAttribute('data-lucide', 'x');
            } else {
                icon.setAttribute('data-lucide', 'menu');
            }
            lucide.createIcons();
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 1024 && 
                !sidebar.contains(e.target) && 
                !menuToggle.contains(e.target) && 
                sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
                menuToggle.querySelector('i').setAttribute('data-lucide', 'menu');
                lucide.createIcons();
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
