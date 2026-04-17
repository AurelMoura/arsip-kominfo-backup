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
        <h2 class="fw-bold mb-1 text-dark">Data Pegawai</h2>
        <p class="text-muted mb-0">Kelola akun, status, dan informasi kepegawaian seluruh ASN yang terdaftar.</p>
    </div>
    <div class="col-md-5 text-md-end mt-3 mt-md-0">
        <button class="btn btn-gradient-primary shadow rounded-pill px-4 py-2 fw-semibold"
            data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-person-plus-fill me-2"></i>Registrasi Pegawai
        </button>
    </div>
</div>

{{-- Stat Cards --}}
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card card-modern p-4">
            <div class="d-flex align-items-center">
                <div class="stat-icon-box bg-primary bg-opacity-10 text-primary me-3">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0 text-dark" style="font-size:28px;">{{ $total_pegawai ?? 0 }}</h3>
                    <small class="text-muted fw-semibold text-uppercase" style="font-size:10px; letter-spacing:.5px;">Total Pegawai</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-modern p-4">
            <div class="d-flex align-items-center">
                <div class="stat-icon-box bg-success bg-opacity-10 text-success me-3">
                    <i class="bi bi-person-check-fill"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0 text-dark" style="font-size:28px;">{{ $pegawai->where('is_active', true)->count() }}</h3>
                    <small class="text-muted fw-semibold text-uppercase" style="font-size:10px; letter-spacing:.5px;">Akun Aktif</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-modern p-4">
            <div class="d-flex align-items-center">
                <div class="stat-icon-box bg-danger bg-opacity-10 text-danger me-3">
                    <i class="bi bi-person-x-fill"></i>
                </div>
                <div>
                    <h3 class="fw-bold mb-0 text-dark" style="font-size:28px;">{{ $pegawai->where('is_active', false)->count() }}</h3>
                    <small class="text-muted fw-semibold text-uppercase" style="font-size:10px; letter-spacing:.5px;">Akun Nonaktif</small>
                </div>
            </div>
        </div>
    </div>
</div>

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
                        <th>NIP</th>
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
                                </div>
                            </div>
                        </td>

                        {{-- NIP --}}
                        <td>
                            <span class="font-monospace text-primary fw-semibold" style="font-size:12px; background:#eff6ff; padding:4px 10px; border-radius:6px;">
                                {{ $p->pegawai_id }}
                            </span>
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
                                    {{-- Ubah Password (Modal) --}}
                                    <button type="button" class="btn-act btn-act-key" title="Ubah Password" data-bs-toggle="modal" data-bs-target="#modalUbahPassword" data-id="{{ $p->id }}" data-nama="{{ $p->name }}">
                                        <i class="bi bi-key-fill"></i>
                                    </button>
                                    {{-- Toggle Status (SUPERADMIN) --}}
                                    <form action="{{ url('/pegawai/'.$p->id.'/toggle-status') }}" method="POST"
                                        class="d-inline ms-1"
                                        style="display:inline"
                                        onsubmit="if(!confirm('{{ $p->is_active ? 'Nonaktifkan' : 'Aktifkan' }} akun {{ addslashes($p->name) }}?')) return false;">
                                        @csrf
                                        @if($p->is_active)
                                            <button type="submit" class="btn-act btn-act-danger" title="Nonaktifkan Akun">
                                                <i class="bi bi-person-x-fill"></i>
                                            </button>
                                        @else
                                            <button type="submit" class="btn-act btn-act-success" title="Aktifkan Akun">
                                                <i class="bi bi-person-check-fill"></i>
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

{{-- MODAL: Ubah Password Pegawai (HANYA 1X DI LUAR LOOP) --}}
<div class="modal fade" id="modalUbahPassword" tabindex="-1" aria-labelledby="modalUbahPasswordLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header-custom text-center">
                <h4 class="fw-bold mb-1 text-white" id="modalUbahPasswordLabel">
                    <i class="bi bi-key-fill me-2"></i>Ubah Password Pegawai
                </h4>
                <p class="opacity-75 text-white mb-0 small">Masukkan password baru untuk pegawai berikut.</p>
            </div>
            <form id="formUbahPassword" autocomplete="off">
                @csrf
                <input type="hidden" name="user_id" id="ubahPasswordUserId">
                <div class="modal-body p-5 text-start">
                    <div class="bg-light rounded-4 p-4 mb-4 border border-dashed border-primary border-opacity-20">
                        <div class="small text-muted mb-1">Nama Pegawai:</div>
                        <div class="text-dark fw-bold" style="font-size: 16px;" id="ubahPasswordNama"></div>
                    </div>
                    <div id="ubahPasswordError" class="alert alert-danger rounded-3 py-2 px-3 mb-4 d-none"></div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-uppercase text-secondary" style="letter-spacing: 1px;">Password Baru *</label>
                        <input type="password" name="password_baru" class="form-control bg-light border-0 py-3 rounded-3" placeholder="Minimal 8 karakter dengan kombinasi huruf besar, kecil, angka, dan simbol" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold text-uppercase text-secondary" style="letter-spacing: 1px;">Konfirmasi Password *</label>
                        <input type="password" name="konfirmasi_password" class="form-control bg-light border-0 py-3 rounded-3" placeholder="Ulangi password baru" required>
                    </div>
                </div>
                <div class="modal-footer border-0 p-5 pt-0">
                    <button type="button" class="btn btn-light px-4 py-3 rounded-pill fw-semibold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-gradient-primary px-4 py-3 rounded-pill fw-bold shadow">Simpan Password Baru</button>
                </div>
            </form>
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

@push('scripts')
<script>
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
</script>
@endpush

@endsection
