<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sikelas Mahasiswa</title>
    <link rel="stylesheet" href="{{ asset('css/sikelas.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    @stack('styles')
</head>
<body style="background-color: var(--bg-main); padding: 1.5rem 1rem; min-height: 100vh;">
    <div style="max-width: 480px; margin: 0 auto;">
        <!-- Mobile Banking Header -->
        <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding: 0 0.5rem;">
            <div style="display: flex; align-items: center; gap: 0.875rem;">
                <div style="width: 42px; height: 42px; background: var(--grad-button); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 950; font-size: 1.5rem; shadow: 0 4px 12px rgba(37, 99, 235, 0.2);">G</div>
                <div>
                    <span style="font-size: 0.6rem; color: var(--secondary); font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em;">by Genite24</span>
                    <h1 style="font-size: 1.25rem; font-weight: 900; margin-top: -0.125rem; tracking: -0.05em; color: var(--primary-accent);">SIKELAS<span class="text-primary">.</span></h1>
                </div>
            </div>
            <div style="display: flex; gap: 0.75rem;">
                <a href="{{ route('student.settings') }}" style="width: 44px; height: 44px; border-radius: 12px; background: white; border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; color: var(--primary); shadow: var(--shadow-glass); transition: all 0.2s;" onmouseover="this.style.transform='rotate(90deg)'" onmouseout="this.style.transform='rotate(0deg)'">
                    <i data-lucide="settings" style="width: 22px; height: 22px;"></i>
                </a>
            </div>
        </header>

        @yield('content')
        
        <!-- Bottom Spacer -->
        <div style="height: 2rem;"></div>
    </div>

    <script>
        lucide.createIcons();
    </script>
    @stack('scripts')
</body>
</html>
