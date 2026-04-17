@extends('layouts.app')

@section('content')
<style>
    /* Sinkronisasi Tema Modern Dashboard */
    .main-content {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }
    .card-modern {
        border: none;
        border-radius: 20px;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
    }
    .card-modern:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.05) !important;
    }
    .table thead th {
        background-color: #f1f5f9;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 0.05em;
        color: #64748b;
        border: none;
    }
    .icon-box {
        width: 40px;
        height: 40px;
        background: #ecfdf5;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #10b981;
    }
    .badge-custom {
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 11px;
    }
    .search-wrapper {
        position: relative;
    }
    .search-wrapper i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }
    .search-wrapper input {
        padding-left: 40px;
        border-radius: 50px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }
    .search-wrapper input:focus {
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        border-color: #10b981;
    }
    .btn-action {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        transition: all 0.2s;
    }
    .btn-action:hover {
        background: #ecfdf5;
        border-color: #10b981;
        transform: scale(1.1);
    }
</style>

<div class="main-content flex-grow-1 p-4" style="min-height: 100vh;">
    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <h3 class="fw-extrabold mb-1 text-dark">Master Sertifikasi Pegawai</h3>
            <p class="text-muted mb-0">Manajemen data diklat, kursus, dan sertifikasi keahlian.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 d-flex align-items-center mb-4" role="alert">
            <div class="icon-box bg-success bg-opacity-10 text-success me-3" style="width: 30px; height: 30px; border-radius: 50%;">
                <i class="bi bi-check-lg"></i>
            </div>
            <div class="fw-medium text-success">{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Tabel Riwayat Sertifikasi --}}
    <div class="card card-modern shadow-sm border-0">
        <div class="card-header bg-transparent border-0 pt-4 px-4">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <div class="d-flex align-items-center">
                        <div class="icon-box me-3 shadow-sm">
                            <i class="bi bi-patch-check-fill"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-dark">Riwayat Sertifikasi / Diklat</h5>
                            <small class="text-muted text-uppercase" style="font-size: 10px; letter-spacing: 1px;">Pengembangan Kompetensi Pegawai</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 mt-3 mt-md-0">
                    <div class="search-wrapper">
                        <i class="bi bi-search"></i>
                        <input type="text" id="searchSertifikasi" class="form-control shadow-sm" placeholder="Cari NIP atau Nama Pegawai...">
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-0 mt-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="tabelRiwayatSertifikasi">
                    <thead>
                        <tr>
                            <th class="ps-4">No</th>
                            <th>NIP</th>
                            <th>Nama Pegawai</th>
                            <th>Nama Sertifikasi</th>
                            <th class="text-center">Tahun</th>
                            <th>Lembaga Pelaksana</th>
                            <th class="text-center pe-4">Dokumen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayatSertifikasi as $index => $riwayat)
                            <tr>
                                <td class="ps-4 text-muted small">{{ $index + 1 }}</td>
                                <td class="font-monospace text-success small fw-bold">{{ $riwayat->pegawai_id }}</td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $riwayat->nama_pegawai }}</div>
                                    <div class="text-muted" style="font-size: 11px;">Data Kepegawaian</div>
                                </td>
                                <td>
                                    <span class="badge-custom bg-success bg-opacity-10 text-success border border-success border-opacity-10 shadow-sm">
                                        <i class="bi bi-award-fill me-1"></i> {{ $riwayat->nama_sertifikasi }}
                                    </span>
                                </td>
                                <td class="text-center fw-medium text-secondary">{{ $riwayat->tahun ?? '-' }}</td>
                                <td class="text-muted small fw-medium">{{ $riwayat->lembaga_pelaksana ?? '-' }}</td>
                                <td class="text-center pe-4">
                                    @if($riwayat->dokumen)
                                        <a href="{{ Storage::disk('public')->url($riwayat->dokumen) }}" target="_blank" class="btn btn-action btn-sm rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 35px; height: 35px;" title="Unduh / Lihat Sertifikat">
                                            <i class="bi bi-file-earmark-arrow-down-fill text-success"></i>
                                        </a>
                                    @else
                                        <span class="text-muted" style="font-size: 10px;">
                                            <i class="bi bi-slash-circle me-1"></i> Kosong
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="bi bi-journal-x display-1 text-light"></i>
                                        <p class="text-muted mt-3">Belum ada riwayat diklat atau sertifikasi yang tercatat.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white border-0 py-3 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">Total ditemukan <strong>{{ $riwayatSertifikasi->count() }}</strong> entri data.</small>
                    <div class="badge bg-emerald-100 text-emerald-800 rounded-pill px-3 py-2 small" style="background-color: #ecfdf5; color: #065f46;">
                        <i class="bi bi-shield-lock-fill me-1"></i> Data Terverifikasi
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('searchSertifikasi').addEventListener('input', function() {
        const q = this.value.toLowerCase();
        const rows = document.querySelectorAll('#tabelRiwayatSertifikasi tbody tr');
        
        rows.forEach(row => {
            const isMatch = row.innerText.toLowerCase().includes(q);
            row.style.display = isMatch ? '' : 'none';
        });
    });
</script>
@endsection