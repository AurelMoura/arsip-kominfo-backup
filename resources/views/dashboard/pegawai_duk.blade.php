@extends('layouts.app')

@section('title', 'Data Pegawai - Arsip Digital')

@push('styles')
<style>
    .card-modern {
        border: none;
        border-radius: 20px;
        transition: box-shadow 0.3s ease, transform 0.3s ease;
        background: #ffffff;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.04);
    }
    .card-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.07) !important;
    }
    .btn-gradient-primary {
        background: linear-gradient(45deg, #4e73df, #224abe);
        border: none;
        color: white;
        transition: all 0.3s;
    }
    .btn-gradient-primary:hover {
        filter: brightness(1.1);
        transform: scale(1.03);
        color: white;
    }
    .table thead th {
        background-color: #f8fafc;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 0.07em;
        color: #64748b;
        border-bottom: 1px solid #f1f5f9;
        font-weight: 700;
        padding: 14px 12px;
        white-space: nowrap;
    }
    .avatar-circle {
        width: 38px;
        height: 38px;
        background: linear-gradient(135deg, #eef2ff, #dbeafe);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #4e73df;
        font-size: 14px;
        flex-shrink: 0;
        overflow: hidden;
    }
    .search-wrapper {
        position: relative;
    }
    .search-wrapper i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        pointer-events: none;
    }
    .search-wrapper input {
        padding-left: 40px;
        border-radius: 50px;
        border: 1px solid #e2e8f0;
        transition: all 0.25s;
        background: #f8fafc;
    }
    .search-wrapper input:focus {
        box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.1);
        border-color: #4e73df;
        background: #fff;
    }
    .badge-status {
        padding: 5px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 11px;
        display: inline-flex;
        align-items: center;
        gap: 2px;
    }
    .stat-icon-box {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        flex-shrink: 0;
    }
    /* Action buttons inline */
    .action-btn-group {
        display: flex;
        align-items: center;
        gap: 6px;
        justify-content: center;
        flex-wrap: nowrap;
    }
    .btn-act {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 14px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .btn-act:hover { transform: translateY(-1px); }
    .btn-act-drh { background: #eff6ff; color: #2563eb; }
    .btn-act-drh:hover { background: #2563eb; color: #fff; }
    .btn-act-arsip { background: #f0fdf4; color: #16a34a; }
    .btn-act-arsip:hover { background: #16a34a; color: #fff; }
    .btn-act-key { background: #fffbeb; color: #d97706; }
    .btn-act-key:hover { background: #d97706; color: #fff; }
    .btn-act-danger { background: #fff1f2; color: #dc2626; }
    .btn-act-danger:hover { background: #dc2626; color: #fff; }
    .btn-act-success { background: #f0fdf4; color: #16a34a; }
    .btn-act-success:hover { background: #16a34a; color: #fff; }
    .btn-act-disabled { background: #f1f5f9; color: #94a3b8; cursor: not-allowed; }
    .status-reason {
        display: inline-block;
        margin-top: 6px;
        padding: 2px 8px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 600;
        color: #7c2d12;
        background: #ffedd5;
    }

    /* Page header label */
    .page-label {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: #3a86ff;
        border-left: 3px solid #3a86ff;
        padding-left: 10px;
    }

    /* Modal */
    .modal-content { border-radius: 20px !important; border: none !important; overflow: hidden; }
    .modal-header-custom {
        background: linear-gradient(45deg, #4e73df, #224abe);
        padding: 20px 24px;
        color: white;
    }
    .form-control {
        border-radius: 12px;
        padding: 11px 14px;
        border: 1px solid #e2e8f0;
        font-size: 14px;
    }
    .form-control:focus {
        box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.1);
        border-color: #4e73df;
    }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="row align-items-center mb-5">
    <div class="col-md-7">
        <p class="page-label mb-2">Manajemen Kepegawaian</p>
        <div class="d-flex align-items-center gap-3 mb-1">
            <h2 class="fw-bold mb-0 text-dark">Data Pegawai {{ $status_label ?? 'Aktif' }}</h2>
            @if($status === 'nonaktif')
            <span class="badge bg-danger bg-opacity-10 text-danger fw-bold px-3 py-2 rounded-pill">
                <i class="bi bi-exclamation-circle me-1"></i> Non Aktif
            </span>
            @else
            <span class="badge bg-success bg-opacity-10 text-success fw-bold px-3 py-2 rounded-pill">
                <i class="bi bi-check-circle me-1"></i> Aktif
            </span>
            @endif
        </div>
        <p class="text-muted mb-0">
            @if($status === 'nonaktif')
            Daftar pegawai dengan status akun non-aktif. Pegawai non-aktif tidak dapat mengakses sistem.
            @else
            Kelola akun, status, dan informasi kepegawaian seluruh ASN yang terdaftar dan aktif.
            @endif
        </p>
    </div>
    <div class="col-md-5 text-md-end mt-3 mt-md-0">
        @if($status !== 'nonaktif')
        <button class="btn btn-gradient-primary shadow rounded-pill px-4 py-2 fw-semibold"
            data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-person-plus-fill me-2"></i>Registrasi Pegawai
        </button>
        @else
        <a href="{{ url('/pegawai?status=aktif') }}" class="btn btn-outline-secondary shadow rounded-pill px-4 py-2 fw-semibold">
            <i class="bi bi-arrow-left me-2"></i>Kembali ke Data Aktif
        </a>
        @endif
    </div>
</div>

{{-- Stat Cards --}}
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card card-modern p-4">
            <div class="d-flex align-items-center">
                <div class="stat-icon-box {{ $status === 'nonaktif' ? 'bg-danger bg-opacity-10 text-danger' : 'bg-primary bg-opacity-10 text-primary' }} me-3">
                    <i class="bi {{ $status === 'nonaktif' ? 'bi-person-x-fill' : 'bi-people-fill' }}"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0 text-dark" style="font-size:28px;">{{ $total_pegawai ?? 0 }}</h3>
                    <small class="text-muted fw-semibold text-uppercase" style="font-size:10px; letter-spacing:.5px;">
                        @if($status === 'nonaktif')
                        Total Pegawai Non Aktif
                        @else
                        Total Pegawai Aktif
                        @endif
                    </small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-modern p-4">
            <div class="d-flex align-items-center">
                <div class="stat-icon-box bg-info bg-opacity-10 text-info me-3">
                    <i class="bi bi-person-vcard-fill"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0 text-dark" style="font-size:28px;">{{ $pegawai->count() }}</h3>
                    <small class="text-muted fw-semibold text-uppercase" style="font-size:10px; letter-spacing:.5px;">Ditampilkan</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-modern p-4">
            <div class="d-flex align-items-center">
                <div class="stat-icon-box {{ $status === 'nonaktif' ? 'bg-success bg-opacity-10 text-success' : 'bg-warning bg-opacity-10 text-warning' }} me-3">
                    <i class="bi {{ $status === 'nonaktif' ? 'bi-person-check-fill' : 'bi-person-exclamation-fill' }}"></i>
                </div>
                <div>
                    @if($status === 'nonaktif')
                    <h3 class="fw-bold mb-0 text-dark" style="font-size:28px;">{{ \App\Models\User::where('role', 'pegawai')->where('is_active', true)->count() }}</h3>
                    <small class="text-muted fw-semibold text-uppercase" style="font-size:10px; letter-spacing:.5px;">Akun Aktif</small>
                    @else
                    <h3 class="fw-bold mb-0 text-dark" style="font-size:28px;">{{ \App\Models\User::where('role', 'pegawai')->where('is_active', false)->count() }}</h3>
                    <small class="text-muted fw-semibold text-uppercase" style="font-size:10px; letter-spacing:.5px;">Akun Nonaktif</small>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if($status !== 'nonaktif')
{{-- Statistik PNS & PPPK --}}
<div class="row g-3 mb-4">
    {{-- PNS --}}
    <div class="col-md-6">
        <div class="card card-modern p-4 border-0 h-100" style="border-left: 4px solid #2563eb !important;">
            <div class="d-flex align-items-center mb-3">
                <div class="stat-icon-box bg-primary bg-opacity-10 text-primary me-3">
                    <i class="bi bi-person-badge-fill"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0 text-dark">PNS</h5>
                    <small class="text-muted" style="font-size:11px;">Pegawai Negeri Sipil</small>
                </div>
                <span class="ms-auto badge bg-primary fs-6 px-3 py-2" style="border-radius:12px;">{{ $statPns['total'] }}</span>
            </div>
            <div class="row g-2">
                <div class="col-6">
                    <div class="rounded-3 p-3 text-center" style="background:#eff6ff;">
                        <div class="fw-bold text-primary" style="font-size:22px;">{{ $statPns['L'] }}</div>
                        <small class="text-muted fw-semibold"><i class="bi bi-gender-male me-1"></i>Laki-laki</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="rounded-3 p-3 text-center" style="background:#fdf2f8;">
                        <div class="fw-bold text-danger" style="font-size:22px;">{{ $statPns['P'] }}</div>
                        <small class="text-muted fw-semibold"><i class="bi bi-gender-female me-1"></i>Perempuan</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- PPPK --}}
    <div class="col-md-6">
        <div class="card card-modern p-4 border-0 h-100" style="border-left: 4px solid #059669 !important;">
            <div class="d-flex align-items-center mb-3">
                <div class="stat-icon-box bg-success bg-opacity-10 text-success me-3">
                    <i class="bi bi-person-badge"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0 text-dark">PPPK</h5>
                    <small class="text-muted" style="font-size:11px;">Pegawai Pemerintah dengan Perjanjian Kerja</small>
                </div>
                <span class="ms-auto badge bg-success fs-6 px-3 py-2" style="border-radius:12px;">{{ $statPppk['total'] }}</span>
            </div>
            <div class="row g-2">
                <div class="col-6">
                    <div class="rounded-3 p-3 text-center" style="background:#f0fdf4;">
                        <div class="fw-bold text-success" style="font-size:22px;">{{ $statPppk['L'] }}</div>
                        <small class="text-muted fw-semibold"><i class="bi bi-gender-male me-1"></i>Laki-laki</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="rounded-3 p-3 text-center" style="background:#fdf2f8;">
                        <div class="fw-bold text-danger" style="font-size:22px;">{{ $statPppk['P'] }}</div>
                        <small class="text-muted fw-semibold"><i class="bi bi-gender-female me-1"></i>Perempuan</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- Tabel Utama --}}
<div class="card card-modern border-0">
    {{-- Card Header --}}
    <div class="card-header bg-transparent border-0 pt-4 pb-3 px-4">
        <div class="row align-items-center g-3">
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-box bg-primary bg-opacity-10 text-primary me-3">
                        <i class="bi bi-table"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Daftar Seluruh Pegawai</h5>
                        <p class="small text-muted mb-0">Status akun, jenis ASN, golongan, dan jabatan.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="search-wrapper">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchPegawai"
                        class="form-control py-2"
                        placeholder="Ketik NIP atau Nama untuk filter...">
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0" id="tabelPegawai">
                <thead>
                    <tr>
                        <th class="ps-4" style="width:50px;">No</th>
                        <th>Pegawai</th>
                        <th class="text-center">Status</th>
                        <th>Login Terakhir</th>
                        <th class="text-center">ASN</th>
                        <th class="text-center">Golongan</th>
                        <th>Jabatan</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pegawai as $index => $p)
                    <tr>
                        {{-- No --}}
                        <td class="ps-4 text-muted fw-semibold small">{{ $index + 1 }}</td>

                        {{-- Pegawai --}}
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-circle">
                                    @if($p->pegawai?->foto_profil)
                                        <img src="{{ Storage::disk('public')->url($p->pegawai->foto_profil) }}"
                                            alt="{{ $p->name }}"
                                            style="width:100%; height:100%; object-fit:cover;">
                                    @else
                                        {{ strtoupper(substr($p->name, 0, 1)) }}
                                    @endif
                                </div>
                                <div>
                                    <div class="fw-bold text-dark" style="font-size:13px;">{{ $p->name }}</div>
                                    <div class="text-muted" style="font-size:11px;">
                                        {{ $p->pegawai?->status_pegawai ?? 'Pegawai' }}
                                    </div>
                                    <div class="font-monospace text-primary fw-semibold" style="font-size:11px; margin-top:2px;">
                                        {{ $p->pegawai_id }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- Status Akun --}}
                        <td class="text-center">
                            @if($p->is_active)
                                <span class="badge-status bg-success bg-opacity-10 text-success">
                                    <i class="bi bi-circle-fill" style="font-size:6px;"></i> Aktif
                                </span>
                            @else
                                <span class="badge-status bg-danger bg-opacity-10 text-danger">
                                    <i class="bi bi-circle-fill" style="font-size:6px;"></i> Nonaktif
                                </span>
                                @if($p->deactivation_reason)
                                    <div class="status-reason">{{ $p->deactivation_reason }}</div>
                                @endif
                            @endif
                        </td>

                        {{-- Login Terakhir --}}
                        <td class="text-muted small">
                            {{ $p->last_login_at ? $p->last_login_at->format('d M Y H:i') : '-' }}
                        </td>

                        {{-- Jenis ASN --}}
                        <td class="text-center">
                            @php $asn = $p->pegawai?->status_pegawai; @endphp
                            @if($asn)
                                <span class="badge rounded-pill fw-bold px-3"
                                    style="font-size:11px; padding:5px 10px;
                                    background: {{ $asn === 'PNS' ? '#eff6ff' : '#fffbeb' }};
                                    color: {{ $asn === 'PNS' ? '#2563eb' : '#d97706' }};">
                                    {{ $asn }}
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>

                        {{-- Golongan --}}
                        <td class="text-center">
                            @if($p->pegawai?->golongan_pangkat)
                                <span class="badge rounded-pill fw-bold px-3"
                                    style="font-size:12px; padding:5px 12px; background:#f0f9ff; color:#0369a1; font-family:monospace;">
                                    {{ $p->pegawai->golongan_pangkat }}
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>

                        {{-- Jabatan --}}
                        <td class="small" style="max-width:180px;">
                            <span class="fw-medium text-dark text-truncate d-block">
                                {{ $p->pegawai?->nama_jabatan ?? '—' }}
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td class="pe-4">
                            <div class="action-btn-group">
                                {{-- Detail DRH --}}
                                <a href="{{ url('/admin/pegawai/'.$p->id.'/drh') }}"
                                    class="btn-act btn-act-drh"
                                    title="Lihat DRH {{ $p->name }}">
                                    <i class="bi bi-file-person-fill"></i>
                                    <span class="d-none d-xl-inline">DRH</span>
                                </a>

                                {{-- Kelola Arsip --}}
                                <a href="{{ url('/admin/pegawai/'.$p->id.'/arsip') }}"
                                    class="btn-act btn-act-arsip"
                                    title="Kelola Arsip {{ $p->name }}">
                                    <i class="bi bi-folder2-open"></i>
                                    <span class="d-none d-xl-inline">Arsip</span>
                                </a>


                                @if(Session::get('role') === 'superadmin')
                                    {{-- Reset Password (ke NIP) --}}
                                    <form id="resetPasswordForm-{{ $p->id }}" action="{{ url('/pegawai/'.$p->id.'/reset-password') }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="button" class="btn-act btn-act-key" title="Reset Password ke NIP"
                                            onclick="confirmResetPassword('{{ $p->id }}', '{{ $p->name }}', '{{ $p->pegawai_id }}')">
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                        </button>
                                    </form>
                                    
                                    {{-- Toggle Status (SUPERADMIN) --}}
                                    <form id="toggleStatusForm-{{ $p->id }}" action="{{ url('/pegawai/'.$p->id.'/toggle-status') }}" method="POST"
                                        class="d-inline ms-1"
                                        style="display:inline"
                                        @if(!$p->is_active && $p->can_reactivate) onsubmit="return false;" @endif>
                                        @csrf
                                        @if($p->is_active)
                                            <input type="hidden" name="deactivation_reason" value="">
                                            <button type="button" class="btn-act btn-act-danger"
                                                title="Nonaktifkan Akun"
                                                onclick="openDeactivateModal('toggleStatusForm-{{ $p->id }}', '{{ addslashes($p->name) }}')">
                                                <i class="bi bi-person-x-fill"></i>
                                            </button>
                                        @elseif($p->can_reactivate)
                                            <button type="button" class="btn-act btn-act-success" title="Aktifkan Akun"
                                                onclick="confirmAktifkan('toggleStatusForm-{{ $p->id }}', '{{ addslashes($p->name) }}')">
                                                <i class="bi bi-person-check-fill"></i>
                                            </button>
                                        @else
                                            <button type="button" class="btn-act btn-act-disabled"
                                                title="Tidak dapat diaktifkan kembali karena alasan {{ $p->deactivation_reason ?? 'nonaktif permanen' }}"
                                                disabled>
                                                <i class="bi bi-lock-fill"></i>
                                            </button>
                                        @endif
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5">
                            <i class="bi bi-people" style="font-size:3rem; color:#e2e8f0;"></i>
                            <p class="text-muted mt-2 mb-0">Belum ada pegawai terdaftar.</p>
                            <button class="btn btn-primary btn-sm rounded-pill mt-3"
                                data-bs-toggle="modal" data-bs-target="#modalTambah">
                                <i class="bi bi-person-plus-fill me-2"></i>Tambah Pegawai Pertama
                            </button>
                        </td>
                    </tr>

                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-top" style="background:#fafbff; border-radius:0 0 20px 20px;">
            <small class="text-muted">
                Menampilkan <strong>{{ $pegawai->count() }}</strong> pegawai terdaftar.
                <span class="text-success fw-semibold">{{ $pegawai->where('is_active', true)->count() }} aktif</span> ·
                <span class="text-danger fw-semibold">{{ $pegawai->where('is_active', false)->count() }} nonaktif</span>
            </small>
        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- MODAL: Registrasi Pegawai Baru --}}
{{-- ============================================================ --}}
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header-custom">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="fw-bold mb-1 text-white" id="modalTambahLabel">
                            <i class="bi bi-person-plus-fill me-2"></i>Registrasi Pegawai Baru
                        </h5>
                        <p class="mb-0 small opacity-75 text-white">Masukkan NIP dan nama lengkap sesuai SK.</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
            </div>

            <form action="{{ url('/pegawai/store') }}" method="POST" onsubmit="return validateNipForm(this)">
                @csrf
                <div class="modal-body p-4">
                    {{-- NIP + Lookup --}}
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary text-uppercase mb-2">
                            Nomor Induk Pegawai (NIP)
                        </label>
                        <div class="input-group">
                            <input type="text" name="nip" id="inputNip"
                                class="form-control @error('nip') is-invalid @enderror"
                                placeholder="Contoh: 198812310000..."
                                value="{{ old('nip') }}"
                                maxlength="18"
                                inputmode="numeric"
                                pattern="\d*"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                required>
                            <button type="button" class="btn btn-outline-primary rounded-end px-3" id="btnCariNip" onclick="cariNip()">
                                <i class="bi bi-search me-1"></i> Cari
                            </button>
                        </div>
                        <small id="nipStatus" class="form-text mt-1" style="display:none;"></small>
                        @error('nip')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nama Lengkap --}}
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary text-uppercase mb-2">
                            Nama Lengkap Sesuai SK
                        </label>
                        <input type="text" name="nama_lengkap" id="inputNama"
                            class="form-control"
                            placeholder="Masukkan nama lengkap..."
                            value="{{ old('nama_lengkap') }}"
                            required>
                    </div>

                    {{-- Info --}}
                    <div class="p-3 rounded-4 bg-info bg-opacity-10 border border-info border-opacity-20">
                        <div class="d-flex gap-3">
                            <i class="bi bi-info-circle-fill text-info fs-5 flex-shrink-0 mt-1"></i>
                            <p class="mb-0 small text-dark">
                                Password akun akan diatur sesuai <strong>NIP</strong> secara otomatis.
                                Pegawai <em>wajib</em> mengganti password saat login pertama kali.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-light px-4 rounded-pill fw-semibold" data-bs-dismiss="modal">
                        Batalkan
                    </button>
                    <button type="submit" class="btn btn-gradient-primary px-4 rounded-pill fw-bold shadow">
                        <i class="bi bi-person-check-fill me-2"></i>Daftarkan Pegawai
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Alasan Nonaktif Pegawai --}}
<div class="modal fade" id="modalNonaktifReason" tabindex="-1" aria-labelledby="modalNonaktifReasonLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header-custom">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="fw-bold mb-1 text-white" id="modalNonaktifReasonLabel">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>Konfirmasi Nonaktifkan Pegawai
                        </h5>
                        <p class="mb-0 small opacity-75 text-white">Pilih alasan nonaktif untuk melanjutkan.</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
            </div>
            <div class="modal-body p-4">
                <p class="mb-3 small text-muted">Akun: <strong id="nonaktifTargetName">-</strong></p>

                <div class="d-grid gap-2" id="nonaktifReasonOptions">
                    <label class="form-check p-3 rounded-3 border">
                        <input class="form-check-input" type="radio" name="nonaktif_reason_choice" value="Mutasi">
                        <span class="form-check-label ms-1">Mutasi</span>
                    </label>
                    <label class="form-check p-3 rounded-3 border">
                        <input class="form-check-input" type="radio" name="nonaktif_reason_choice" value="Pindah Instansi">
                        <span class="form-check-label ms-1">Pindah Instansi</span>
                    </label>
                    <label class="form-check p-3 rounded-3 border">
                        <input class="form-check-input" type="radio" name="nonaktif_reason_choice" value="Pensiun">
                        <span class="form-check-label ms-1">Pensiun</span>
                    </label>
                    <label class="form-check p-3 rounded-3 border">
                        <input class="form-check-input" type="radio" name="nonaktif_reason_choice" value="Meninggal">
                        <span class="form-check-label ms-1">Meninggal</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer border-0 px-4 pb-4 pt-0">
                <button type="button" class="btn btn-light px-4 rounded-pill fw-semibold" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger px-4 rounded-pill fw-bold" id="btnConfirmNonaktif">
                    <i class="bi bi-person-x-fill me-1"></i> Nonaktifkan
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function showCenterToast(message, type = 'warning', duration = 3200) {
        const existingToast = document.getElementById('centerToastMessage');
        if (existingToast) {
            existingToast.remove();
        }

        const colors = {
            success: '#16a34a',
            error: '#dc2626',
            warning: '#d97706',
            info: '#2563eb'
        };

        const toast = document.createElement('div');
        toast.id = 'centerToastMessage';
        toast.textContent = message;
        toast.style.cssText = `position:fixed;top:50%;left:50%;transform:translate(-50%,-50%) scale(.96);z-index:1065;padding:14px 18px;border-radius:12px;color:#fff;font-weight:700;box-shadow:0 14px 30px rgba(15,23,42,.28);background:${colors[type] || colors.info};opacity:0;transition:all .2s ease;`;
        document.body.appendChild(toast);

        requestAnimationFrame(() => {
            toast.style.opacity = '1';
            toast.style.transform = 'translate(-50%,-50%) scale(1)';
        });

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translate(-50%,-50%) scale(.96)';
            setTimeout(() => toast.remove(), 220);
        }, duration);
    }

    // ── Live search filter ─────────────────────────────────────────
    document.getElementById('searchPegawai')?.addEventListener('keyup', function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll('#tabelPegawai tbody tr').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    });

    // ── Validasi 18 digit NIP sebelum submit ──────────────────────
    function validateNipForm(form) {
        const nip = form.querySelector('[name="nip"]').value.trim();
        if (nip.length !== 18) {
            showToast('NIP harus tepat 18 digit. Saat ini: ' + nip.length + ' digit.', 'warning');
            return false;
        }
        return true;
    }

    // ── Lookup NIP via API ─────────────────────────────────────────
    function cariNip() {
        const nip = document.getElementById('inputNip').value.trim();
        const statusEl = document.getElementById('nipStatus');
        const namaEl = document.getElementById('inputNama');
        const btnCari = document.getElementById('btnCariNip');

        if (nip.length < 10) {
            showNipStatus('warning', 'Masukkan setidaknya 10 digit NIP untuk pencarian.');
            return;
        }

        btnCari.disabled = true;
        btnCari.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Mencari...';
        showNipStatus('info', 'Mencari data...');

        const apiUrl = "{{ url('api/cek-nip') }}";
        fetch(`${apiUrl}/${encodeURIComponent(nip)}`)
            .then(r => r.json())
            .then(data => {
                if (data?.nama_lengkap) {
                    namaEl.value = data.nama_lengkap;
                    showNipStatus('success', `✓ Ditemukan: <strong>${data.nama_lengkap}</strong>`);
                } else {
                    showNipStatus('warning', 'NIP tidak ditemukan di database SPLP. Isi nama manual.');
                }
            })
            .catch(() => showNipStatus('danger', 'Gagal menghubungi server lookup.'))
            .finally(() => {
                btnCari.disabled = false;
                btnCari.innerHTML = '<i class="bi bi-search me-1"></i> Cari';
            });
    }

    function showNipStatus(type, html) {
        const el = document.getElementById('nipStatus');
        el.style.display = 'block';
        el.className = `form-text mt-1 text-${type}`;
        el.innerHTML = html;
    }

    let selectedDeactivateFormId = null;
    const deactivateModalEl = document.getElementById('modalNonaktifReason');
    const deactivateModal = deactivateModalEl ? new bootstrap.Modal(deactivateModalEl) : null;

    function confirmAktifkan(formId, userName) {
        const toastEl = document.createElement('div');
        toastEl.id = 'toastAktifkanConfirm';
        toastEl.style.cssText = 'position:fixed;bottom:24px;right:24px;z-index:1090;background:#fff;border:1px solid #e2e8f0;border-radius:14px;box-shadow:0 8px 30px rgba(15,23,42,.15);padding:16px 20px;min-width:280px;max-width:340px;';
        toastEl.innerHTML = `
            <div class="d-flex align-items-center gap-2 mb-2">
                <i class="bi bi-person-check-fill text-success" style="font-size:18px;"></i>
                <span class="fw-bold text-dark" style="font-size:14px;">Aktifkan Pegawai</span>
            </div>
            <p class="text-muted mb-3" style="font-size:13px;">Aktifkan kembali akun <strong>${userName}</strong>?</p>
            <div class="d-flex gap-2 justify-content-end">
                <button class="btn btn-sm btn-light rounded-pill px-3" onclick="document.getElementById('toastAktifkanConfirm').remove()">Batal</button>
                <button class="btn btn-sm btn-success rounded-pill px-3" onclick="document.getElementById('${formId}').submit(); document.getElementById('toastAktifkanConfirm').remove()">Ya, Aktifkan</button>
            </div>`;
        const existing = document.getElementById('toastAktifkanConfirm');
        if (existing) existing.remove();
        document.body.appendChild(toastEl);
    }

    function openDeactivateModal(formId, userName) {
        selectedDeactivateFormId = formId;
        document.getElementById('nonaktifTargetName').textContent = userName;

        document.querySelectorAll('input[name="nonaktif_reason_choice"]').forEach(radio => {
            radio.checked = false;
        });

        deactivateModal?.show();
    }

    document.getElementById('btnConfirmNonaktif')?.addEventListener('click', function () {
        const selectedReason = document.querySelector('input[name="nonaktif_reason_choice"]:checked');
        if (!selectedReason) {
            alert('Pilih alasan nonaktif terlebih dahulu.');
            return;
        }

        if (!selectedDeactivateFormId) {
            return;
        }

        const form = document.getElementById(selectedDeactivateFormId);
        if (!form) {
            return;
        }

        const hiddenReasonInput = form.querySelector('input[name="deactivation_reason"]');
        if (hiddenReasonInput) {
            hiddenReasonInput.value = selectedReason.value;
        }

        deactivateModal?.hide();
        form.submit();
    });

    @if(session('duplicate_nip'))
        document.addEventListener('DOMContentLoaded', function () {
            const modalEl = document.getElementById('modalTambah');
            if (modalEl) {
                const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();
            }

            showCenterToast('pegawai tersebut sudah ditambahkan', 'warning');
        });
    @endif

    function confirmResetPassword(pegawaiId, pegawaiName, pegawaiNip) {
        Swal.fire({
            title: 'Reset Password?',
            html: `Reset password <strong>${pegawaiName}</strong> ke NIP: <strong>${pegawaiNip}</strong>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Reset',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`resetPasswordForm-${pegawaiId}`).submit();
            }
        });
    }
</script>
@endpush

@endsection
