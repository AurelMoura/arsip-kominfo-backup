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
        background: #fff9db;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fcc419;
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
        box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.1);
        border-color: #4e73df;
    }
    .btn-view {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        transition: all 0.2s;
    }
    .btn-view:hover {
        background: #fff9db;
        border-color: #fcc419;
        transform: scale(1.1);
    }
</style>

<div class="main-content flex-grow-1 p-4" style="min-height: 100vh;">
    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <h3 class="fw-extrabold mb-1 text-dark">Master Data Penghargaan</h3>
            <p class="text-muted mb-0">Monitor dan kelola apresiasi prestasi seluruh pegawai.</p>
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

    {{-- Tabel Riwayat Penghargaan Pegawai --}}
    <div class="card card-modern shadow-sm border-0">
        <div class="card-header bg-transparent border-0 pt-4 px-4">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <div class="d-flex align-items-center">
                        <div class="icon-box me-3 shadow-sm bg-warning bg-opacity-10">
                            <i class="bi bi-trophy-fill text-warning"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-dark">Riwayat Penghargaan Pegawai</h5>
                            <small class="text-muted text-uppercase" style="font-size: 10px; letter-spacing: 1px;">Apresiasi & Prestasi ASN</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 mt-3 mt-md-0">
                    <div class="search-wrapper">
                        <i class="bi bi-search"></i>
                        <input type="text" id="searchPenghargaan" class="form-control shadow-sm" placeholder="Cari NIP atau Nama Pegawai...">
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-0 mt-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="tabelRiwayatPenghargaan">
                    <thead>
                        <tr>
                            <th class="ps-4">No</th>
                            <th>NIP</th>
                            <th>Nama Pegawai</th>
                            <th>Nama Penghargaan</th>
                            <th class="text-center">Tahun</th>
                            <th>Instansi Pemberi</th>
                            <th class="text-center pe-4">Berkas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayatPenghargaan as $index => $riwayat)
                            <tr>
                                <td class="ps-4 text-muted small">{{ $index + 1 }}</td>
                                <td class="font-monospace text-primary small">{{ $riwayat->pegawai_id }}</td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $riwayat->nama_pegawai }}</div>
                                    <div class="text-muted" style="font-size: 11px;">ASN Terdaftar</div>
                                </td>
                                <td>
                                    <span class="badge-custom bg-warning bg-opacity-10 text-warning-emphasis shadow-sm">
                                        <i class="bi bi-star-fill me-1" style="font-size: 10px;"></i> {{ $riwayat->nama_penghargaan }}
                                    </span>
                                </td>
                                <td class="text-center fw-medium text-secondary">{{ $riwayat->tahun ?? '-' }}</td>
                                <td class="text-muted small">{{ $riwayat->instansi_pemberi ?? '-' }}</td>
                                <td class="text-center pe-4">
                                    @if($riwayat->dokumen)
                                        <a href="{{ Storage::disk('public')->url($riwayat->dokumen) }}" target="_blank" class="btn btn-view btn-sm rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 35px; height: 35px;" title="Lihat Sertifikat">
                                            <i class="bi bi-file-earmark-pdf-fill text-danger"></i>
                                        </a>
                                    @else
                                        <span class="badge bg-light text-muted border py-2" style="font-size: 10px;">
                                            <i class="bi bi-file-earmark-x me-1"></i> No File
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="bi bi-award display-1 text-light"></i>
                                        <p class="text-muted mt-3">Belum ada riwayat penghargaan yang tercatat.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white border-0 py-3 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">Menampilkan total <strong>{{ $riwayatPenghargaan->count() }}</strong> data penghargaan.</small>
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill small fw-bold">
                        <i class="bi bi-info-circle me-1"></i> Data Real-time
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('searchPenghargaan').addEventListener('input', function() {
        const q = this.value.toLowerCase();
        const rows = document.querySelectorAll('#tabelRiwayatPenghargaan tbody tr');
        
        rows.forEach(row => {
            const isMatch = row.innerText.toLowerCase().includes(q);
            if (isMatch) {
                row.style.display = '';
                row.classList.add('fade-in');
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endsection