<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sikelas</title>
    <link rel="stylesheet" href="{{ asset('css/sikelas.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @stack('styles')
</head>
<body style="background-color: #f8fafc; padding: 1.5rem 1rem;">
    <div style="max-width: 540px; margin: 0 auto;">
        @yield('content')
    </div>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
    @stack('scripts')
</body>
</html>
