@extends('layouts.app')

@section('content')
<style>
    .main-content {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }
    .card-modern {
        border: none;
        border-radius: 20px;
        transition: box-shadow 0.3s ease, transform 0.3s ease;
        background: #ffffff;
    }
    .card-modern:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.08) !important;
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
        font-size: 0.7rem;
        letter-spacing: 0.05em;
        color: #64748b;
        border: none;
    }
    .icon-box {
        width: 40px;
        height: 40px;
        background: #eef2ff;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4e73df;
    }
    .badge-custom {
        padding: 5px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 11px;
    }
    .font-monospace-small {
        font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
        font-size: 0.85rem;
    }
    /* Badge ASN clickable */
    .asn-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
        text-decoration: none;
    }
    .asn-badge:hover {
        transform: scale(1.08);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .asn-badge-filled {
        background: linear-gradient(135deg, #4e73df, #224abe);
        color: white;
    }
    .asn-badge-empty {
        background: #f1f5f9;
        color: #94a3b8;
        cursor: default;
    }
    /* Modal Detail */
    .modal-detail-header {
        background: linear-gradient(135deg, #4e73df, #224abe);
        color: white;
        border-radius: 16px 16px 0 0 !important;
    }
    .modal-detail-header .btn-close { filter: invert(1); }
    .asn-list-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .asn-list-item:last-child { border-bottom: none; }
    .asn-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 13px;
        color: #4e73df;
        flex-shrink: 0;
    }
</style>

<div class="main-content flex-grow-1 p-4" style="min-height: 100vh;">
    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <h3 class="fw-extrabold mb-1 text-dark">Master Pangkat & Golongan</h3>
            <p class="text-muted mb-0">Kelola standarisasi golongan ruang dan kepangkatan ASN.</p>
        </div>
        @if(session('role') == 'superadmin')
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <button class="btn btn-gradient-primary shadow rounded-pill px-4 py-2" data-bs-toggle="modal" data-bs-target="#modalTambahPangkat">
                <i class="bi bi-plus-circle-fill me-2"></i> Tambah Pangkat
            </button>
        </div>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 d-flex align-items-center mb-4" role="alert">
            <div class="icon-box bg-success bg-opacity-10 text-success me-3" style="width:30px; height:30px; border-radius:50%;">
                <i class="bi bi-check-lg"></i>
            </div>
            <div class="fw-medium text-success">{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Tabel Referensi Pangkat (langsung terbuka, tanpa collapse) --}}
    <div class="card card-modern shadow-sm">
        <div class="card-header bg-transparent border-0 pt-4 px-4">
            <div class="row align-items-center g-3">
                <div class="col-md-7">
                    <div class="d-flex align-items-center">
                        <div class="icon-box me-3 shadow-sm bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-layers-fill"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-dark">Referensi Golongan Ruang</h5>
                            <small class="text-muted">{{ $pangkats->count() }} pangkat terdaftar</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="search-wrapper position-relative">
                        <i class="bi bi-search position-absolute text-muted" style="left: 15px; top: 50%; transform: translateY(-50%);"></i>
                        <input type="text" id="searchPangkat" class="form-control rounded-pill ps-5 bg-light border-0" placeholder="Cari golongan atau nama pangkat...">
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-0 mt-3">
            <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="tabelPangkat">
                    <thead>
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Golongan</th>
                            <th>Nama Pangkat</th>
                            <th>Jenis ASN</th>
                            <th>Status</th>
                            <th class="text-center">ASN</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pangkats as $index => $pangkat)
                            <tr>
                                <td class="ps-4 text-muted small">{{ $index + 1 }}</td>
                                <td class="py-3 fw-bold text-primary font-monospace-small">{{ $pangkat->golongan }}</td>
                                <td class="py-3 fw-medium text-dark">{{ $pangkat->nama ?? '-' }}</td>
                                <td>
                                    <span class="badge-custom bg-info bg-opacity-10 text-info">{{ $pangkat->jenis_asn }}</span>
                                </td>
                                <td>
                                    <span class="badge-custom bg-{{ $pangkat->aktif == 'Y' ? 'success' : 'danger' }} bg-opacity-10 text-{{ $pangkat->aktif == 'Y' ? 'success' : 'danger' }}">
                                        <i class="bi bi-dot"></i> {{ $pangkat->aktif == 'Y' ? 'Aktif' : 'Non-Aktif' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($pangkat->pegawais_count > 0)
                                        <button class="asn-badge asn-badge-filled"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalAsnPangkat{{ $pangkat->id }}"
                                            title="Lihat daftar ASN">
                                            <i class="bi bi-people-fill" style="font-size:11px;"></i>
                                            {{ $pangkat->pegawais_count }} ASN
                                        </button>
                                    @else
                                        <span class="asn-badge asn-badge-empty">
                                            <i class="bi bi-person-x" style="font-size:11px;"></i> 0 ASN
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    @if(session('role') == 'superadmin')
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-outline-warning rounded-circle me-2"
                                            style="width:32px; height:32px; padding:0;"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEditPangkat{{ $pangkat->id }}"
                                            title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                        <form action="{{ url('/admin/master/pangkat', $pangkat->id) }}" method="POST"
                                            onsubmit="confirmDeleteSweetAlert(this); return false;" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle"
                                                style="width:32px; height:32px; padding:0;" title="Hapus">
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
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-layers display-4 text-light"></i>
                                    <p class="mt-2">Belum ada data referensi pangkat.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah Pangkat --}}
<div class="modal fade" id="modalTambahPangkat" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-plus-circle me-2 text-primary"></i>Tambah Pangkat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ url('/admin/master/pangkat') }}" method="POST">
                @csrf
                <div class="modal-body px-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Jenis ASN Target</label>
                        <select class="form-select form-select-lg rounded-3 fs-6" name="jenis_asn" required>
                            <option value="PNS">PNS</option>
                            <option value="PPPK">PPPK</option>
                            <option value="Keduanya">Keduanya (PNS & PPPK)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Golongan Ruang</label>
                        <input type="text" class="form-control form-control-lg rounded-3 fs-6" name="golongan" required placeholder="Cth: III/a atau IX">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Nama Pangkat (Opsional)</label>
                        <input type="text" class="form-control form-control-lg rounded-3 fs-6" name="nama" placeholder="Cth: Penata Muda">
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-gradient-primary rounded-pill px-4 shadow">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit + Modal Detail ASN per Pangkat --}}
@foreach($pangkats as $pangkat)

{{-- Modal Edit Pangkat --}}
<div class="modal fade" id="modalEditPangkat{{ $pangkat->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-pencil-square me-2 text-warning"></i>Edit Pangkat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ url('/admin/master/pangkat/'.$pangkat->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-body px-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Jenis ASN Target</label>
                        <select class="form-select form-select-lg rounded-3 fs-6" name="jenis_asn" required>
                            <option value="PNS" {{ $pangkat->jenis_asn === 'PNS' ? 'selected' : '' }}>PNS</option>
                            <option value="PPPK" {{ $pangkat->jenis_asn === 'PPPK' ? 'selected' : '' }}>PPPK</option>
                            <option value="Keduanya" {{ $pangkat->jenis_asn === 'Keduanya' ? 'selected' : '' }}>Keduanya</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Golongan Ruang</label>
                        <input type="text" class="form-control form-control-lg rounded-3 fs-6" name="golongan" required value="{{ $pangkat->golongan }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Nama Pangkat</label>
                        <input type="text" class="form-control form-control-lg rounded-3 fs-6" name="nama" value="{{ $pangkat->nama }}">
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning text-white rounded-pill px-4 shadow">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Detail ASN per Pangkat --}}
<div class="modal fade" id="modalAsnPangkat{{ $pangkat->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header modal-detail-header border-0 px-4 pt-4 pb-3">
                <div>
                    <h5 class="fw-bold mb-1">
                        <i class="bi bi-layers-fill me-2"></i>ASN — Golongan {{ $pangkat->golongan }}
                    </h5>
                    <small class="opacity-75">
                        {{ $pangkat->nama ?? '' }}{{ $pangkat->nama ? ' · ' : '' }}{{ $pangkat->pegawais_count }} pegawai
                    </small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 py-3" style="max-height: 420px; overflow-y: auto;">
                @if($pangkat->pegawais->isEmpty())
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-person-x display-4 text-light"></i>
                        <p class="mt-2 small">Belum ada ASN dengan golongan ini.</p>
                    </div>
                @else
                    @foreach($pangkat->pegawais as $pegawai)
                    <div class="asn-list-item">
                        <div class="asn-avatar">{{ strtoupper(substr($pegawai->nama_lengkap, 0, 2)) }}</div>
                        <div class="flex-grow-1">
                            <div class="fw-bold text-dark small">{{ $pegawai->nama_lengkap }}</div>
                            <div class="text-muted" style="font-size:11px;">NIP: {{ $pegawai->id }}</div>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2 small d-block mb-1 fw-bold">
                                Gol. {{ $pegawai->golongan_pangkat }}
                            </span>
                            <span class="badge {{ $pegawai->status_pegawai === 'PNS' ? 'bg-primary' : 'bg-warning text-dark' }} rounded-pill px-2 small">
                                {{ $pegawai->status_pegawai }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
            <div class="modal-footer border-0 pb-3 px-4">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@endforeach

@push('scripts')
<script>
    // Fitur Pencarian Pangkat
    document.getElementById('searchPangkat')?.addEventListener('input', function() {
        const q = this.value.toLowerCase();
        const rows = document.querySelectorAll('#tabelPangkat tbody tr');
        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(q) ? '' : 'none';
        });
    });
</script>
@endpush

@endsection