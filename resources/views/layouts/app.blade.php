<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Arsip Digital')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-color: #1e3a5f;
            --primary-blue: #3a86ff;
            --bg-light: #f4f7fe;
            --sidebar-width: 260px;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: var(--bg-light);
            color: #2d3748;
        }

        .app-shell {
            display: flex;
            min-height: 100vh;
        }

        .app-sidebar {
            width: var(--sidebar-width);
            min-width: var(--sidebar-width);
            max-width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: var(--sidebar-color);
            color: #fff;
            z-index: 1000;
            box-shadow: 10px 0 30px rgba(0, 0, 0, 0.05);
            overflow-y: auto;
        }

        .app-content {
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
        }

        .app-main {
            padding: 40px;
        }

        /* Normalize legacy page wrappers after moving to global layout */
        .app-main .main-content {
            margin-left: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }

        .gs-nav-link {
            color: #8d94a3;
            margin: 5px 15px;
            border-radius: 12px;
            padding: 12px;
            text-decoration: none;
            display: block;
            font-weight: 500;
        }

        .gs-nav-link:hover,
        .gs-nav-link:focus {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.1);
        }

        .gs-nav-link.active {
            background: linear-gradient(135deg, var(--primary-blue), #2563eb);
            color: #ffffff !important;
            box-shadow: 0 4px 15px rgba(58, 134, 255, 0.3);
        }

        @media (max-width: 991px) {
            :root {
                --sidebar-width: 80px;
            }

            .gs-brand-text,
            .gs-profile-text,
            .gs-nav-text,
            .gs-profile-action,
            .gs-role {
                display: none !important;
            }

            .app-main {
                padding: 25px;
            }

            .app-main .main-content {
                margin-left: 0 !important;
                padding: 0 !important;
                width: 100% !important;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
<div class="app-shell">
    @include('components.sidebar')

    <div class="app-content">
        <main class="app-main">
            @yield('content')
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Toast Component -->
@include('components.toast')
@include('components.toast-helpers')
@include('components.sweetalert-helpers')

<!-- Animasi transisi halaman dihapus agar navigasi dan modal lebih responsif -->
@stack('scripts')

<!-- Session Flash to Toast -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        showToast('{{ session('success') }}', 'success');
    @endif
    @if(session('error'))
        showToast('{{ session('error') }}', 'error');
    @endif
    @if(session('warning'))
        showToast('{{ session('warning') }}', 'warning');
    @endif
    @if(session('info'))
        showToast('{{ session('info') }}', 'info');
    @endif

    // Auto-submit forms with delete action show success toast
    document.querySelectorAll('form[method="POST"][action*="delete"], form[method="POST"][action*="destroy"]').forEach(form => {
        const originalSubmit = form.onsubmit;
        form.addEventListener('submit', function(e) {
            // Check if confirm was shown and user clicked OK
            if (this.getAttribute('onsubmit') && this.getAttribute('onsubmit').includes('confirm')) {
                // The browser confirm already happened
                showToast('Menghapus data...', 'info');
            }
        });
    });
});
</script>
</body>
</html>
