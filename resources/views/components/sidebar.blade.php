@php
    $role = Session::get('role');
    $pegawaiSidebar = null;

    if (Session::get('identifier')) {
        $pegawaiSidebar = \App\Models\Pegawai::where('id', Session::get('identifier'))->first();
    }

    $isPegawai = $role === 'pegawai';
    
    $isMasterActive = request()->is('admin/master/*') || request()->is('master/*');
@endphp

<style>
    :root {
        --sidebar-width: 260px;
    }

    body {
        overflow-x: hidden;
    }

    /* ===================== SIDEBAR ===================== */
    .sidebar.app-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        width: var(--sidebar-width);
        min-width: var(--sidebar-width);
        max-width: var(--sidebar-width);
        height: 100vh;
        margin: 0;
        overflow-y: auto;
        z-index: 1040;
        background: #1e3a5f;
        transition: transform 0.3s ease;
    }

    .app-content,
    .main-content {
        margin-left: var(--sidebar-width) !important;
        width: calc(100% - var(--sidebar-width)) !important;
        min-height: 100vh;
        transition: margin-left 0.3s ease, width 0.3s ease;
    }

    .app-main,
    main {
        margin-left: 0 !important;
        width: 100% !important;
    }

    /* ===================== NAV LINKS ===================== */
    .gs-nav-link {
        color: #8d94a3;
        margin: 5px 15px;
        border-radius: 12px;
        padding: 12px;
        text-decoration: none;
        display: block;
        font-weight: 500;
        transition: all 0.2s;
    }
    .gs-nav-link:hover, .gs-nav-link:focus {
        color: #ffffff;
        background: rgba(255,255,255,0.1);
    }
    .gs-nav-link.active {
        background: linear-gradient(135deg, var(--primary-blue, #3a86ff), #2563eb);
        color: #ffffff !important;
        box-shadow: 0 4px 15px rgba(58,134,255,0.3);
    }

    .sidebar.app-sidebar::-webkit-scrollbar { width: 4px; }
    .sidebar.app-sidebar::-webkit-scrollbar-thumb {
        background: rgba(255,255,255,0.1);
        border-radius: 10px;
    }

    /* ===================== OVERLAY ===================== */
    .sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        z-index: 1039;
        backdrop-filter: blur(2px);
        transition: opacity 0.3s ease;
    }
    .sidebar-overlay.show {
        display: block;
    }

    /* ===================== TOPBAR HP ===================== */
    .mobile-topbar {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 56px;
        background: #1e3a5f;
        z-index: 1030;
        align-items: center;
        padding: 0 16px;
        gap: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.2);
    }

    .mobile-topbar .topbar-title {
        font-size: 15px;
        font-weight: 700;
        background: linear-gradient(135deg, #60a5fa, #a78bfa);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        letter-spacing: 1px;
    }

    .btn-hamburger {
        background: rgba(255,255,255,0.1);
        border: none;
        border-radius: 10px;
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
        cursor: pointer;
        transition: background 0.2s;
        flex-shrink: 0;
    }
    .btn-hamburger:hover {
        background: rgba(255,255,255,0.2);
    }

    /* ===================== RESPONSIVE ===================== */
    @media (max-width: 991.98px) {

        /* Sidebar tersembunyi ke kiri di HP */
        .sidebar.app-sidebar {
            transform: translateX(-100%);
        }

        /* Ketika sidebar terbuka */
        .sidebar.app-sidebar.sidebar-open {
            transform: translateX(0);
        }

        /* Konten full width di HP */
        .app-content,
        .main-content {
            margin-left: 0 !important;
            width: 100% !important;
            padding-top: 56px !important; /* beri ruang untuk topbar */
        }

        /* Tampilkan topbar HP */
        .mobile-topbar {
            display: flex;
        }

        /* Header actions yang bertumpuk */
        .d-flex.justify-content-between.align-items-center:not(.no-stack) {
            flex-wrap: wrap !important;
            gap: 8px !important;
        }
    }

    /* ================================================================
       GLOBAL MOBILE RESPONSIVE — Semua Halaman (Pegawai / Admin / Superadmin)
       Berlaku untuk SEMUA halaman karena semua include komponen sidebar ini.
       ================================================================ */
    @media (max-width: 767.98px) {

        /* ---- Content area padding ---- */
        .main-content, .app-main {
            padding: 12px !important;
            padding-top: calc(56px + 12px) !important;
        }

        /* ---- Toast: geser ke bawah topbar mobile (56px) ---- */
        #toastContainer {
            top: calc(56px + 8px) !important;
            right: 8px !important;
            left: 8px !important;
            width: auto !important;
        }

        /* ---- Page headings ---- */
        h1 { font-size: 1.35rem !important; }
        h2 { font-size: 1.18rem !important; }
        h3 { font-size: 1.05rem !important; }

        /* ---- Header/title area: wrap when narrow ---- */
        .d-flex.justify-content-between,
        .d-flex.justify-content-between.align-items-end,
        .d-flex.justify-content-between.align-items-start,
        .d-flex.justify-content-between.align-items-center {
            flex-wrap: wrap !important;
            gap: 12px !important;
        }

        /* ---- Card padding ---- */
        .card-body { padding: 1rem !important; }
        .card-header { padding: 0.75rem 1rem !important; }
        .main-table-card, .table-container {
            padding: 14px !important;
            border-radius: 16px !important;
        }

        /* ---- Tables: always horizontally scrollable ---- */
        .table-responsive {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
        }

        /* ---- Buttons ---- */
        .btn { font-size: 0.82rem !important; }
        .btn-sm { font-size: 0.75rem !important; padding: 5px 10px !important; }

        /* ---- Banner & info panels ---- */
        .welcome-banner { padding: 18px !important; border-radius: 16px !important; }
        .welcome-icon {
            width: 44px !important; height: 44px !important;
            font-size: 1.3rem !important; border-radius: 12px !important;
        }
        .info-panel { padding: 16px !important; border-radius: 14px !important; }

        /* ================================================================
           STATISTIK CARDS — Kotak 1:1, SEMUA MUAT DALAM 1 BARIS
           ================================================================ */

        /* Row yang berisi stat-card/card-stat → satu baris flex, tidak wrap */
        .row:has(> [class*="col"] > .stat-card),
        .row:has(> [class*="col"] > .card-stat) {
            --bs-gutter-x: 0;
            --bs-gutter-y: 0;
            display: flex !important;
            flex-wrap: nowrap !important;
            gap: 8px !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        /* Setiap kolom: lebar sama rata, hilangkan padding Bootstrap gutter */
        .row:has(> [class*="col"] > .stat-card) > [class*="col"],
        .row:has(> [class*="col"] > .card-stat) > [class*="col"] {
            flex: 1 1 0 !important;
            min-width: 0 !important;
            max-width: none !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            width: auto !important;
        }

        /* Stat card: kotak 1:1, isi tengah */
        .stat-card, .card-stat {
            aspect-ratio: 1 / 1 !important;
            padding: 8px 5px !important;
            border-radius: 14px !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
            width: 100% !important;
            height: auto !important;
            min-height: 0 !important;
            margin: 0 !important;
            overflow: hidden !important;
            transition: none !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.07) !important;
        }

        /* Icon box (.icon-box) di dalam stat-card */
        .stat-card .icon-box, .card-stat .icon-box {
            width: 28px !important; height: 28px !important;
            min-width: 28px !important;
            border-radius: 8px !important;
            font-size: 0.8rem !important;
            padding: 0 !important;
            margin-bottom: 4px !important;
            margin-right: 0 !important;
            flex-shrink: 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        /* Variant icon bulat (bg-*-opacity p-3 rounded-4) misal di halaman Pegawai */
        .stat-card .p-3.rounded-4 {
            padding: 5px !important;
            margin-right: 0 !important;
            margin-bottom: 4px !important;
            border-radius: 8px !important;
            width: 28px !important; height: 28px !important;
            min-width: 28px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        .stat-card .p-3.rounded-4 i { font-size: 0.8rem !important; }

        /* Angka statistik */
        .stat-card h1, .stat-card h2, .stat-card h3,
        .card-stat h1, .card-stat h2, .card-stat h3, .stat-val {
            font-size: 1.05rem !important;
            font-weight: 800 !important;
            margin: 2px 0 !important;
            line-height: 1 !important;
        }

        /* Angka dengan inline style "font-size: 28px" (misal halaman Pegawai) */
        .stat-card [style*="font-size: 28"],
        .stat-card [style*="font-size:28"] {
            font-size: 1.05rem !important;
        }

        /* Label teks */
        .stat-card p, .stat-card small,
        .card-stat p, .card-stat small, .stat-label {
            font-size: 0.57rem !important;
            line-height: 1.2 !important;
            margin: 0 !important;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
        }

        /* Sembunyikan deskripsi agar lebih ringkas */
        .stat-desc { display: none !important; }

        /* Variant d-flex (icon di kiri): override ke kolom untuk bentuk kotak */
        .stat-card.d-flex {
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
        }
        .stat-card.d-flex > div:first-child {
            margin-right: 0 !important;
            margin-bottom: 4px !important;
        }
        .stat-card.d-flex [class*="me-"] {
            margin-right: 0 !important;
        }

        /* ================================================================
           MODALS — Ukuran mobile yang rapi
           ================================================================ */

        .modal-dialog {
            margin: 8px auto !important;
            width: calc(100vw - 16px) !important;
            max-width: calc(100vw - 16px) !important;
        }
        .modal-dialog.modal-lg,
        .modal-dialog.modal-xl,
        .modal-dialog.modal-xxl {
            max-width: calc(100vw - 16px) !important;
        }
        .modal-content {
            border-radius: 20px !important;
            max-height: 92vh !important;
            overflow-y: auto !important;
        }
        .modal-header { padding: 1rem 1.25rem !important; }
        .modal-body {
            padding: 1rem !important;
            max-height: 65vh !important;
            overflow-y: auto !important;
        }
        .modal-footer {
            padding: 0.75rem 1rem !important;
            flex-wrap: wrap !important;
            gap: 8px !important;
        }
        .modal-footer .btn {
            flex: 1 1 auto !important;
            text-align: center !important;
        }
    }

    @media print {
        .sidebar.app-sidebar { display: none !important; }
        .mobile-topbar { display: none !important; }
        .app-content, .main-content {
            margin-left: 0 !important;
            width: 100% !important;
        }
    }
</style>

{{-- ========== TOPBAR MOBILE (hanya muncul di HP) ========== --}}
<div class="mobile-topbar">
    <button class="btn-hamburger" onclick="toggleSidebar()" id="hamburgerBtn">
        <i class="bi bi-list" id="hamburgerIcon"></i>
    </button>
    <span class="topbar-title">KOMINFO</span>
    <div class="ms-auto d-flex align-items-center gap-2">
        <div class="rounded-circle overflow-hidden" style="width:32px;height:32px;flex-shrink:0;">
            @if($pegawaiSidebar?->foto_profil)
                <img src="{{ Storage::disk('public')->url($pegawaiSidebar->foto_profil) }}" alt="Foto" style="width:100%;height:100%;object-fit:cover;">
            @else
                <div class="bg-primary d-flex align-items-center justify-content-center text-white fw-bold" style="width:100%;height:100%;font-size:14px;">
                    {{ strtoupper(substr(Session::get('name', 'U'), 0, 1)) }}
                </div>
            @endif
        </div>
    </div>
</div>

{{-- ========== OVERLAY ========== --}}
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

{{-- ========== SIDEBAR ========== --}}
<aside class="sidebar app-sidebar d-flex flex-column p-3" id="appSidebar">
    <div class="d-flex align-items-center mb-5 px-2 mt-2">
        <div class="d-flex align-items-center gap-2">
            <div class="bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center p-1" style="width: 45px; height: 45px; flex-shrink: 0;">
                <img src="{{ asset('image/pemkot.png') }}" style="width: 100%; height: 100%; object-fit: contain;" alt="Pemkot">
            </div>
            <div class="bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center p-1" style="width: 45px; height: 45px; flex-shrink: 0;">
                <img src="{{ asset('image/LOGOKOMINFO.png') }}" style="width: 100%; height: 100%; object-fit: contain;" alt="Kominfo">
            </div>
        </div>
        <div class="lh-1 ms-3 gs-brand-text">
            <div class="fw-bold" style="font-size: 16px; letter-spacing: 1.5px; background: linear-gradient(135deg, #60a5fa, #a78bfa); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">KOMINFO</div>
            <small style="font-size: 10px; color: #94a3b8;">Arsip Digital</small>
        </div>
        {{-- Tombol close khusus di dalam sidebar untuk HP --}}
        <button class="btn-hamburger ms-auto d-lg-none" onclick="toggleSidebar()">
            <i class="bi bi-x-lg" style="font-size:16px;"></i>
        </button>
    </div>

    <a href="{{ url($role === 'admin' || $role === 'superadmin' ? '/dashboard' : '/profile') }}" class="bg-white bg-opacity-10 rounded-4 p-3 d-flex align-items-center mb-4 mx-1 border border-white border-opacity-10 text-decoration-none shadow-sm">
        <div class="rounded-circle me-2 shadow-sm overflow-hidden" style="width: 40px; height: 40px; flex-shrink: 0;">
            @if($pegawaiSidebar?->foto_profil)
                <img src="{{ Storage::disk('public')->url($pegawaiSidebar->foto_profil) }}" alt="Foto Profil" style="width: 100%; height: 100%; object-fit: cover;">
            @else
                <div class="bg-primary d-flex align-items-center justify-content-center text-white fw-bold" style="width: 100%; height: 100%; font-size: 16px;">
                    {{ strtoupper(substr(Session::get('name', 'U'), 0, 1)) }}
                </div>
            @endif
        </div>

        <div class="overflow-hidden gs-profile-text" style="font-size: 12px;">
            <div class="fw-bold text-truncate" style="color: #e2e8f0;">{{ Session::get('name') }}</div>
            <small class="text-truncate d-block" style="color: #60a5fa;">NIP: {{ Session::get('identifier') }}</small>
            <small class="text-truncate d-block mt-1 gs-role" style="color: #a78bfa; font-weight: 600; letter-spacing: 0.5px;">{{ strtoupper($role ?? 'USER') }}</small>
        </div>
        <i class="bi bi-person-circle ms-auto opacity-75 text-white gs-profile-action"></i>
    </a>

    <ul class="nav nav-pills flex-column mb-auto">
        @if($isPegawai)
            <li>
                <a href="{{ url('/dashboard') }}" class="gs-nav-link {{ request()->is('dashboard') ? 'active' : '' }} mb-2">
                    <i class="bi bi-grid-fill me-2"></i><span class="gs-nav-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/pegawai/arsip') }}" class="gs-nav-link {{ request()->is('pegawai/arsip*') ? 'active' : '' }} mb-2">
                    <i class="bi bi-folder2-open me-2"></i><span class="gs-nav-text">Arsip Dokumen</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/pegawai/riwayat-hidup') }}" class="gs-nav-link {{ request()->is('pegawai/riwayat-hidup*') ? 'active' : '' }} mb-2">
                    <i class="bi bi-file-person-fill me-2"></i><span class="gs-nav-text">Daftar Riwayat Hidup</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/pengajuan-berkas') }}" class="gs-nav-link {{ request()->is('pengajuan-berkas*') ? 'active' : '' }} mb-2">
                    <i class="bi bi-send-fill me-2"></i><span class="gs-nav-text">Pengajuan Berkas</span>
                </a>
            </li>
        @else
            <li>
                <a href="{{ url('/dashboard') }}" class="gs-nav-link {{ request()->is('dashboard') ? 'active' : '' }} mb-2">
                    <i class="bi bi-grid-fill me-2"></i><span class="gs-nav-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#" class="gs-nav-link d-flex align-items-center {{ request()->is('pegawai*') ? 'active' : '' }} mb-0"
                    onclick="event.preventDefault(); var c = bootstrap.Collapse.getOrCreateInstance(document.getElementById('dropdownDataPegawai')); c.toggle();">
                    <i class="bi bi-person-badge me-2"></i>
                    <span class="gs-nav-text">Data Pegawai</span>
                    <i class="bi bi-chevron-down ms-auto gs-nav-text" style="font-size: 11px; transition: transform 0.3s; {{ request()->is('pegawai*') ? 'transform: rotate(180deg);' : '' }}"></i>
                </a>
                <div class="collapse {{ request()->is('pegawai*') ? 'show' : '' }}" id="dropdownDataPegawai">
                    <ul class="nav flex-column ps-3 mt-1" style="font-size: 13px;">
                        <li><a href="{{ url('/pegawai?status=aktif') }}" class="gs-nav-link py-1 mb-0 {{ request()->input('status') === 'aktif' || !request()->has('status') ? 'active' : '' }}"><i class="bi bi-circle-fill me-2" style="font-size: 5px;"></i><span class="gs-nav-text">Data Pegawai Aktif</span></a></li>
                        <li><a href="{{ url('/pegawai?status=nonaktif') }}" class="gs-nav-link py-1 mb-0 {{ request()->input('status') === 'nonaktif' ? 'active' : '' }}"><i class="bi bi-circle-fill me-2" style="font-size: 5px;"></i><span class="gs-nav-text">Data Pegawai Non Aktif</span></a></li>
                    </ul>
                </div>
            </li>
            <li>
                <a href="#" class="gs-nav-link d-flex align-items-center {{ $isMasterActive ? 'active' : '' }} mb-0" 
                    onclick="event.preventDefault(); var c = bootstrap.Collapse.getOrCreateInstance(document.getElementById('dropdownDataReferensi')); c.toggle();">
                    <i class="bi bi-database-fill-gear me-2"></i>
                    <span class="gs-nav-text">Data Referensi</span>
                    <i class="bi bi-chevron-down ms-auto gs-nav-text" style="font-size: 11px; transition: transform 0.3s; {{ $isMasterActive ? 'transform: rotate(180deg);' : '' }}"></i>
                </a>
                <div class="collapse {{ $isMasterActive ? 'show' : '' }}" id="dropdownDataReferensi">
                    <ul class="nav flex-column ps-3 mt-1" style="font-size: 13px;">
                        <li><a href="{{ url('/admin/master/agama') }}" class="gs-nav-link py-1 mb-0 {{ request()->is('admin/master/agama') ? 'active' : '' }}"><i class="bi bi-circle-fill me-2" style="font-size: 5px;"></i><span class="gs-nav-text">Agama</span></a></li>
                        <li><a href="{{ url('/admin/master/pendidikan') }}" class="gs-nav-link py-1 mb-0 {{ request()->is('admin/master/pendidikan') ? 'active' : '' }}"><i class="bi bi-circle-fill me-2" style="font-size: 5px;"></i><span class="gs-nav-text">Pendidikan</span></a></li>
                        <li><a href="{{ url('/admin/master/arsip') }}" class="gs-nav-link py-1 mb-0 {{ request()->is('admin/master/arsip') ? 'active' : '' }}"><i class="bi bi-circle-fill me-2" style="font-size: 5px;"></i><span class="gs-nav-text">Arsip</span></a></li>
                        <li><a href="{{ url('/admin/master/jabatan') }}" class="gs-nav-link py-1 mb-0 {{ request()->is('admin/master/jabatan') ? 'active' : '' }}"><i class="bi bi-circle-fill me-2" style="font-size: 5px;"></i><span class="gs-nav-text">Jabatan</span></a></li>
                        <li><a href="{{ url('/admin/master/pangkat') }}" class="gs-nav-link py-1 mb-0 {{ request()->is('admin/master/pangkat') ? 'active' : '' }}"><i class="bi bi-circle-fill me-2" style="font-size: 5px;"></i><span class="gs-nav-text">Pangkat</span></a></li>
                        <li><a href="{{ url('/master/unitkerja') }}" class="gs-nav-link py-1 mb-0 {{ request()->is('master/unitkerja') ? 'active' : '' }}"><i class="bi bi-circle-fill me-2" style="font-size: 5px;"></i><span class="gs-nav-text">Unit Kerja</span></a></li>
                    </ul>
                </div>
            </li>
            <li><a href="{{ url('/admin/duk') }}" class="gs-nav-link {{ request()->is('admin/duk*') ? 'active' : '' }} mb-2"><i class="bi bi-file-earmark-list me-2"></i><span class="gs-nav-text">DUK</span></a></li>
            <li><a href="{{ url('/admin/validasi-dokumen') }}" class="gs-nav-link {{ request()->is('admin/validasi-dokumen*') ? 'active' : '' }}"><i class="bi bi-shield-check me-2"></i><span class="gs-nav-text">Validasi Dokumen</span></a></li>
            @if($role === 'admin')
            <li><a href="{{ url('/admin/user-activity') }}" class="gs-nav-link {{ request()->is('admin/user-activity*') ? 'active' : '' }}"><i class="bi bi-clock-history me-2"></i><span class="gs-nav-text">User Activity</span></a></li>
            @elseif($role === 'superadmin')
            <li><a href="{{ url('/superadmin/user-activity') }}" class="gs-nav-link {{ request()->is('superadmin/user-activity*') ? 'active' : '' }}"><i class="bi bi-clock-history me-2"></i><span class="gs-nav-text">User Activity</span></a></li>
            @endif
            @if($role === 'superadmin')
            <li><a href="{{ url('/superadmin/tambah-admin') }}" class="gs-nav-link {{ request()->is('superadmin/tambah-admin') ? 'active' : '' }}"><i class="bi bi-person-plus-fill me-2"></i><span class="gs-nav-text">Tambah Admin</span></a></li>
            <li><a href="{{ url('/superadmin/kelola-admin') }}" class="gs-nav-link {{ request()->is('superadmin/kelola-admin') ? 'active' : '' }}"><i class="bi bi-people-fill me-2"></i><span class="gs-nav-text">Kelola Admin</span></a></li>
            @endif
        @endif
    </ul>

    <div class="mt-auto pt-3 border-top border-secondary border-opacity-20">
        <a href="{{ url('/logout') }}" class="gs-nav-link text-danger fw-bold">
            <i class="bi bi-box-arrow-left me-2"></i><span class="gs-nav-text">Logout</span>
        </a>
    </div>
</aside>

<script>
    function toggleSidebar() {
        var sidebar  = document.getElementById('appSidebar');
        var overlay  = document.getElementById('sidebarOverlay');
        var icon     = document.getElementById('hamburgerIcon');
        var isOpen   = sidebar.classList.contains('sidebar-open');

        if (isOpen) {
            sidebar.classList.remove('sidebar-open');
            overlay.classList.remove('show');
            icon.className = 'bi bi-list';
            document.body.style.overflow = '';
        } else {
            sidebar.classList.add('sidebar-open');
            overlay.classList.add('show');
            icon.className = 'bi bi-x-lg';
            document.body.style.overflow = 'hidden'; // cegah scroll body saat sidebar terbuka
        }
    }

    // Tutup sidebar otomatis kalau link diklik (navigasi pindah halaman)
    document.querySelectorAll('.sidebar.app-sidebar a[href]:not([href="#"])').forEach(function(link) {
        link.addEventListener('click', function() {
            if (window.innerWidth < 992) {
                var sidebar = document.getElementById('appSidebar');
                var overlay = document.getElementById('sidebarOverlay');
                sidebar.classList.remove('sidebar-open');
                overlay.classList.remove('show');
                document.body.style.overflow = '';
            }
        });
    });
</script>