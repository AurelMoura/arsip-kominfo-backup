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
        background: #e0f2fe;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0ea5e9;
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
        box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
        border-color: #0ea5e9;
    }
    .btn-file {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #0ea5e9;
        transition: all 0.2s;
    }
    .btn-file:hover {
        background: #0ea5e9;
        color: #ffffff;
        transform: translateY(-2px);
    }
</style>

<div class="main-content flex-grow-1 p-4" style="min-height: 100vh;">
    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <h3 class="fw-extrabold mb-1 text-dark">Master Data Diklat</h3>
            <p class="text-muted mb-0">Pemantauan riwayat pendidikan dan pelatihan struktural maupun teknis.</p>
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

    {{-- Tabel Riwayat Diklat --}}
    <div class="card card-modern shadow-sm border-0">
        <div class="card-header bg-transparent border-0 pt-4 px-4">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <div class="d-flex align-items-center">
                        <div class="icon-box me-3 shadow-sm">
                            <i class="bi bi-mortarboard-fill"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-dark">Riwayat Diklat Pegawai</h5>
                            <small class="text-muted text-uppercase" style="font-size: 10px; letter-spacing: 1px;">Pengembangan SDM & Karier</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 mt-3 mt-md-0">
                    <div class="search-wrapper">
                        <i class="bi bi-search"></i>
                        <input type="text" id="searchDiklat" class="form-control shadow-sm" placeholder="Cari NIP atau Nama Pegawai...">
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-0 mt-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="tabelRiwayatDiklat">
                    <thead>
                        <tr>
                            <th class="ps-4">No</th>
                            <th>NIP</th>
                            <th>Nama Pegawai</th>
                            <th>Nama Diklat</th>
                            <th>Penyelenggara</th>
                            <th>No. Sertifikat</th>
                            <th class="text-center">Tahun</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayatDiklat as $index => $riwayat)
                            <tr>
                                <td class="ps-4 text-muted small">{{ $index + 1 }}</td>
                                <td class="font-monospace text-info small fw-bold">{{ $riwayat->pegawai_id }}</td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $riwayat->nama_pegawai }}</div>
                                    <div class="text-muted" style="font-size: 11px;">Aktif Kepegawaian</div>
                                </td>
                                <td>
                                    <span class="badge-custom bg-info bg-opacity-10 text-info border border-info border-opacity-10 shadow-sm">
                                        <i class="bi bi-book-half me-1"></i> {{ $riwayat->nama_diklat }}
                                    </span>
                                </td>
                                <td class="text-muted small fw-medium">{{ $riwayat->penyelenggara ?? '-' }}</td>
                                <td class="small font-monospace">{{ $riwayat->no_sertifikat ?? '-' }}</td>
                                <td class="text-center fw-bold text-secondary">{{ $riwayat->tahun ?? '-' }}</td>
                                <td class="text-center pe-4">
                                    @if($riwayat->dokumen)
                                        <a href="{{ Storage::disk('public')->url($riwayat->dokumen) }}" target="_blank" class="btn btn-file btn-sm rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 35px; height: 35px;" title="Lihat Berkas Sertifikat">
                                            <i class="bi bi-file-earmark-check-fill"></i>
                                        </a>
                                    @else
                                        <span class="text-muted opacity-50" title="Tidak ada berkas">
                                            <i class="bi bi-file-earmark-x" style="font-size: 18px;"></i>
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="bi bi-journal-album display-1 text-light"></i>
                                        <p class="text-muted mt-3">Belum ada riwayat diklat yang terdaftar.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3 px-4 text-end">
            <span class="text-muted small">Total Data Diklat: <strong>{{ $riwayatDiklat->count() }}</strong> entri</span>
        </div>
    </div>
</div>

<script>
    document.getElementById('searchDiklat').addEventListener('input', function() {
        const q = this.value.toLowerCase();
        const rows = document.querySelectorAll('#tabelRiwayatDiklat tbody tr');
        
        rows.forEach(row => {
            const isMatch = row.innerText.toLowerCase().includes(q);
            row.style.display = isMatch ? '' : 'none';
        });
    });
</script>
@endsection