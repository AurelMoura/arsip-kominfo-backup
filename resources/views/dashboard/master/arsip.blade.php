@extends('layouts.app')

@section('content')
<style>
    /* Sinkronisasi Tema Modern */
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
    .btn-gradient-primary {
        background: linear-gradient(45deg, #4e73df, #224abe);
        border: none;
        color: white;
        transition: all 0.3s;
    }
    .btn-gradient-primary:hover {
        filter: brightness(1.1);
        transform: scale(1.05);
        color: white;
    }
    .table thead th {
        background-color: #f1f5f9;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        color: #64748b;
        border: none;
    }
    .icon-shape {
        width: 40px;
        height: 40px;
        background: #eef2ff;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4e73df;
    }
    .badge-status {
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 11px;
    }
    /* Animasi Baris Tabel */
    .table-hover tbody tr {
        transition: all 0.2s;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(78, 115, 223, 0.02);
    }
</style>

<div class="main-content flex-grow-1 p-4" style="min-height: 100vh;">
    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <h3 class="fw-extrabold mb-1 text-dark">Master Dokumen Arsip</h3>
            <p class="text-muted mb-0">Kelola kategori dan standarisasi dokumen administrasi.</p>
        </div>
        @if(session('role') == 'superadmin')
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <button class="btn btn-gradient-primary shadow rounded-pill px-4 py-2" data-bs-toggle="modal" data-bs-target="#modalTambahArsip">
                <i class="bi bi-folder-plus me-2"></i> Tambah Kategori
            </button>
        </div>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 d-flex align-items-center mb-4" role="alert">
            <div class="icon-shape bg-success bg-opacity-10 text-success me-3" style="width: 30px; height: 30px; border-radius: 50%;">
                <i class="bi bi-check-lg"></i>
            </div>
            <div class="fw-medium text-success">{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card card-modern shadow-sm border-0">
        <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="icon-shape me-3 shadow-sm">
                    <i class="bi bi-archive-fill"></i>
                </div>
                <h5 class="fw-bold mb-0">Daftar Kategori Arsip</h5>
            </div>
            <div class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill small fw-bold">
                {{ $arsips->count() }} Kategori Terdaftar
            </div>
        </div>
        
        <div class="card-body p-0 mt-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4" style="width: 80px;">No</th>
                            <th>Kategori Kebutuhan Arsip</th>
                            <th class="text-center">Status</th>
                            <th class="text-end pe-4">Manajemen Aksi</th>

                    </thead>
                    <tbody>
                        @forelse($arsips as $index => $arsip)
                            <tr>
                                <td class="ps-4 text-muted fw-medium">{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3 p-2 bg-light rounded-3 text-secondary" style="font-size: 1.2rem;">
                                            <i class="bi bi-file-earmark-text"></i>
                                        </div>
                                        <span class="fw-bold text-dark">{{ $arsip->nama }}</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if($arsip->aktif == 'ya')
                                        <span class="badge-status bg-success bg-opacity-10 text-success">
                                            <i class="bi bi-check-circle-fill me-1"></i> Aktif
                                        </span>
                                    @else
                                        <span class="badge-status bg-danger bg-opacity-10 text-danger">
                                            <i class="bi bi-x-circle-fill me-1"></i> Tidak Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    @if(session('role') == 'superadmin')
                                    <div class="btn-group">
                                        <button title="Edit" class="btn btn-sm btn-outline-warning rounded-circle me-2" style="width: 35px; height: 35px;" data-bs-toggle="modal" data-bs-target="#modalEditArsip{{ $arsip->id }}">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                        <form action="{{ url('/admin/master/arsip', $arsip->id) }}" method="POST" onsubmit="confirmDeleteSweetAlert(this, 'Yakin ingin menghapus kategori arsip?', 'Kategori arsip yang dihapus tidak bisa dikembalikan!'); return false;" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button title="Hapus" type="submit" class="btn btn-sm btn-outline-danger rounded-circle" style="width: 35px; height: 35px;">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                    @else
                                    <span class="text-muted small">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="bi bi-folder2-open display-1 text-light"></i>
                                        <p class="text-muted mt-3">Belum ada kategori arsip yang ditambahkan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white border-0 py-3 px-4">
                <small class="text-muted"><i class="bi bi-info-circle me-1"></i> Gunakan kategori ini untuk pengelompokan file dokumen pegawai.</small>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahArsip" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-plus-circle me-2 text-primary"></i>Tambah Kategori Arsip</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ url('/admin/master/arsip') }}" method="POST">
                @csrf
                <div class="modal-body px-4">
                    <div class="form-group mb-2">
                        <label class="form-label fw-semibold small text-muted text-uppercase">Nama / Kategori Arsip</label>
                        <input type="text" class="form-control form-control-lg rounded-3 fs-6" name="nama" required placeholder="Cth: SK PPPK, Riwayat SKP, dll.">
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-gradient-primary rounded-pill px-4">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit Arsip (Vibe Modern) --}}
@foreach($arsips as $arsip)
<div class="modal fade" id="modalEditArsip{{ $arsip->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-pencil-square me-2 text-warning"></i>Perbarui Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ url('/admin/master/arsip/'.$arsip->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body px-4">
                    <div class="form-group mb-2">
                        <label class="form-label fw-semibold small text-muted text-uppercase">Nama / Kategori Arsip</label>
                        <input type="text" class="form-control form-control-lg rounded-3 fs-6" name="nama" required value="{{ $arsip->nama }}">
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning text-white rounded-pill px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection