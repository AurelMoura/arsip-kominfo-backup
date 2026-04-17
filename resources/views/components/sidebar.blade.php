@php
    $role = Session::get('role');
    $pegawaiSidebar = null;

    if (Session::get('identifier')) {
        $pegawaiSidebar = \App\Models\Pegawai::where('id', Session::get('identifier'))->first();
    }

    $isPegawai = $role === 'pegawai';
@endphp

{{-- Self-contained sidebar styles (works in any layout) --}}
<style>
    .sidebar.app-sidebar {
        width: var(--sidebar-width, 280px);
        min-width: var(--sidebar-width, 280px);
        max-width: var(--sidebar-width, 280px);
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        background: var(--sidebar-color, #1e3a5f);
        color: #fff;
        z-index: 1000;
        box-shadow: 10px 0 30px rgba(0,0,0,0.05);
        overflow-y: auto;
    }
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
    @media (max-width: 991px) {
        .gs-brand-text, .gs-profile-text, .gs-nav-text, .gs-profile-action, .gs-role {
            display: none !important;
        }
        .sidebar.app-sidebar {
            width: 80px;
            min-width: 80px;
            max-width: 80px;
        }
    }
    @media print {
        .sidebar.app-sidebar { display: none !important; }
    }
</style>

<aside class="sidebar app-sidebar d-flex flex-column p-3">
    <div class="d-flex align-items-center mb-5 px-2 mt-2">
        <div class="d-flex align-items-center gap-2">
            <img src="{{ asset('image/pemkot.png') }}" width="38" class="rounded-circle shadow-sm bg-white p-1" alt="Pemkot">
            <img src="{{ asset('image/LOGOKOMINFO.png') }}" width="38" class="rounded-circle shadow-sm bg-white p-1" alt="Kominfo">
        </div>
        <div class="lh-1 ms-3 gs-brand-text">
            <div class="fw-bold" style="font-size: 16px; letter-spacing: 1.5px; background: linear-gradient(135deg, #60a5fa, #a78bfa); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">KOMINFO</div>
            <small style="font-size: 10px; color: #94a3b8;">Arsip Digital</small>
        </div>
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
                <a href="{{ url('/pegawai') }}" class="gs-nav-link {{ request()->is('pegawai') ? 'active' : '' }} mb-2">
                    <i class="bi bi-person-badge me-2"></i>
                    <span class="gs-nav-text">Data Pegawai</span>
                </a>
            </li>
            <li>
                <a href="#" class="gs-nav-link d-flex align-items-center {{ request()->is('admin/master/*') ? 'active' : '' }} mb-0" 
                    onclick="event.preventDefault(); var c = bootstrap.Collapse.getOrCreateInstance(document.getElementById('dropdownDataReferensi')); c.toggle();">
                    <i class="bi bi-database-fill-gear me-2"></i>
                    <span class="gs-nav-text">Data Referensi</span>
                    <i class="bi bi-chevron-down ms-auto gs-nav-text" style="font-size: 11px; transition: transform 0.3s; {{ request()->is('admin/master/*') ? 'transform: rotate(180deg);' : '' }}"></i>
                </a>
                <div class="collapse {{ request()->is('admin/master/*') ? 'show' : '' }}" id="dropdownDataReferensi">
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
            <li>
                <a href="{{ url('/admin/duk') }}" class="gs-nav-link {{ request()->is('admin/duk*') ? 'active' : '' }} mb-2">
                    <i class="bi bi-file-earmark-list me-2"></i><span class="gs-nav-text">DUK</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/admin/validasi-dokumen') }}" class="gs-nav-link {{ request()->is('admin/validasi-dokumen*') ? 'active' : '' }}">
                    <i class="bi bi-shield-check me-2"></i><span class="gs-nav-text">Validasi Dokumen</span>
                </a>
            </li>
            @if($role === 'admin')
            <li>
                <a href="{{ url('/admin/user-activity') }}" class="gs-nav-link {{ request()->is('admin/user-activity*') ? 'active' : '' }}">
                    <i class="bi bi-clock-history me-2"></i><span class="gs-nav-text">User Activity</span>
                </a>
            </li>
            @elseif($role === 'superadmin')
            <li>
                <a href="{{ url('/superadmin/user-activity') }}" class="gs-nav-link {{ request()->is('superadmin/user-activity*') ? 'active' : '' }}">
                    <i class="bi bi-clock-history me-2"></i><span class="gs-nav-text">User Activity</span>
                </a>
            </li>
            @endif
            @if($role === 'superadmin')
            <li>
                <a href="{{ url('/superadmin/tambah-admin') }}" class="gs-nav-link {{ request()->is('superadmin/tambah-admin') ? 'active' : '' }}">
                    <i class="bi bi-person-plus-fill me-2"></i><span class="gs-nav-text">Tambah Admin</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/superadmin/kelola-admin') }}" class="gs-nav-link {{ request()->is('superadmin/kelola-admin') ? 'active' : '' }}">
                    <i class="bi bi-people-fill me-2"></i><span class="gs-nav-text">Kelola Admin</span>
                </a>
            </li>
            @endif
        @endif
    </ul>

    <div class="mt-auto pt-3 border-top border-secondary border-opacity-20">
        <a href="{{ url('/logout') }}" class="gs-nav-link text-danger fw-bold">
            <i class="bi bi-box-arrow-left me-2"></i><span class="gs-nav-text">Logout</span>
        </a>
    </div>
</aside>
