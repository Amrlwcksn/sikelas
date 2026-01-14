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
        <!-- Sidebar -->
        <div class="sidebar">
            <a href="{{ route('admin.dashboard') }}" class="logo">Sikelas</a>
            <ul class="nav-links">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i data-lucide="layout-grid"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.students') }}" class="nav-item {{ request()->routeIs('admin.students') ? 'active' : '' }}">
                        <i data-lucide="users"></i>
                        <span>Mahasiswa</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.transactions') }}" class="nav-item {{ request()->routeIs('admin.transactions') ? 'active' : '' }}">
                        <i data-lucide="arrow-left-right"></i>
                        <span>Transaksi</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.rekap') }}" class="nav-item {{ request()->routeIs('admin.rekap') ? 'active' : '' }}">
                        <i data-lucide="bar-chart-3"></i>
                        <span>Rekap Kas</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.cek-saldo') }}" class="nav-item {{ request()->routeIs('admin.cek-saldo') ? 'active' : '' }}">
                        <i data-lucide="credit-card"></i>
                        <span>Cek Saldo</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.registrasi') }}" class="nav-item {{ request()->routeIs('admin.registrasi') ? 'active' : '' }}">
                        <i data-lucide="user-plus"></i>
                        <span>Registrasi</span>
                    </a>
                </li>
                
                <li style="margin-top: auto; padding-top: 2rem;">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-item" style="width: 100%; border: none; background: transparent; cursor: pointer; color: var(--danger);">
                            <i data-lucide="log-out"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            @if(session('success'))
                <div style="background: #f0fdf4; color: #166534; padding: 1rem; border-radius: 0.75rem; border: 1px solid #bbfcce; margin-bottom: 2rem; font-weight: 600;">
                    ✅ {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div style="background: #fef2f2; color: #991b1b; padding: 1rem; border-radius: 0.75rem; border: 1px solid #fee2e2; margin-bottom: 2rem; font-weight: 600;">
                    ❌ {{ session('error') }}
                </div>
            @endif
            @yield('content')
        </div>
    </div>
    <script>
        lucide.createIcons();
    </script>
    @stack('scripts')
</body>
</html>
