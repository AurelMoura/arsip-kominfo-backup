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

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background: var(--bg-light);
            color: #2d3748;
            overflow-x: hidden;
        }

        .app-shell {
            display: flex;
            flex-direction: row;
            min-height: 100vh;
            width: 100%;
            max-width: 100%;
            position: relative;
            overflow-x: hidden;
        }

        .app-sidebar,
        .sidebar.app-sidebar {
            width: var(--sidebar-width);
            min-width: var(--sidebar-width);
            max-width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-color);
            color: #fff;
            z-index: 1000;
            box-shadow: 10px 0 30px rgba(0, 0, 0, 0.05);
            overflow-y: auto;
            flex-shrink: 0;
            position: relative;
        }

        .app-content {
            flex: 1;
            width: 1px;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }

        .app-main {
            padding: 40px;
            width: 100%;
            overflow-x: hidden;
            flex: 1;
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

        @media (max-width: 991.98px) {
            /* Sidebar is handled by components/sidebar.blade.php (fixed+transform) */
            .app-content {
                margin-left: 0 !important;
                width: 100% !important;
            }

            .app-main {
                padding: 16px !important;
                padding-top: calc(56px + 16px) !important;
            }

            .app-main .main-content {
                margin-left: 0 !important;
                padding: 0 !important;
                width: 100% !important;
            }
        }

        /* ===== GLOBAL RESPONSIVE HELPERS ===== */

        /* Tables on mobile */
        @media (max-width: 767.98px) {
            .app-main {
                padding: 12px !important;
                padding-top: calc(56px + 12px) !important;
            }

            /* Reduce heavy card paddings */
            .card-body { padding: 1rem !important; }
            .p-4 { padding: 1rem !important; }
            .p-5 { padding: 1.25rem !important; }
            .p-lg-5 { padding: 1rem !important; }

            /* Page headings */
            h1 { font-size: 1.4rem !important; }
            h2 { font-size: 1.2rem !important; }
            h3 { font-size: 1.1rem !important; }

            /* Header rows that should stack */
            .d-flex.justify-content-between:not(.no-stack) {
                flex-wrap: wrap !important;
                gap: 10px !important;
            }

            /* Stat cards row */
            .row.g-4 > .col-md-3,
            .row.g-4 > .col-md-4,
            .row.g-3 > .col-md-3,
            .row.g-3 > .col-md-4 {
                margin-bottom: 8px;
            }
        }

        /* Ensure horizontal scroll for wide tables globally */
        .table-responsive-always {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
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
