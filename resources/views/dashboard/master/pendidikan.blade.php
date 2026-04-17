@extends('layouts.app')

@section('title', 'Master Data Pendidikan - Arsip Digital')

@push('styles')
<style>
    /* Custom Styles untuk kesan Modern */
    .card-modern {
        border: none;
        border-radius: 20px;
        transition: all 0.3s ease;
        background: #ffffff;
        position: relative;
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
        background-color: #f8fafc;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        color: #64748b;
        border: none;
    }

    .badge-status {
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 11px;
    }

    .avatar-circle {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    .asn-count-badge {
        background: #eff6ff;
        color: #2563eb;
        padding: 6px 14px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 13px;
        text-decoration: none;
        transition: all 0.2s;
        border: 1px solid #dbeafe;
    }
    .asn-count-badge:hover {
        background: #2563eb;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }

    /* Modal Detail ASN */
    .modal-detail-header {
        background: linear-gradient(135deg, #4e73df, #224abe);
        color: white;
        border-radius: 16px 16px 0 0 !important;
    }
    .modal-detail-header .btn-close {
        filter: invert(1);
    }
    .asn-list-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 8px;
        border-bottom: 1px solid #f1f5f9;
        border-radius: 10px;
        transition: background 0.15s;
        text-decoration: none;
        color: inherit;
    }
    .asn-list-item:last-child { border-bottom: none; }
    .asn-list-item:hover {
        background: #f0f4ff;
        text-decoration: none;
        color: inherit;
    }
    .asn-list-item:hover .asn-drh-btn { opacity: 1; transform: translateX(0); }
    
    .asn-detail-avatar {
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
        transition: transform 0.2s;
    }
    .asn-list-item:hover .asn-detail-avatar { transform: scale(1.1); }
    
    .asn-drh-btn {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #4e73df;
        color: white;
        border-radius: 8px;
        padding: 4px 10px;
        font-size: 11px;
        font-weight: 700;
        opacity: 0;
        transform: translateX(4px);
        transition: all 0.2s;
        flex-shrink: 0;
        text-decoration: none;
    }
</style>
@endpush

@section('content')

<div class="mb-5">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h3 class="fw-extrabold mb-1 text-dark">Master Data Pendidikan</h3>
            <p class="text-muted mb-0">Kelola informasi referensi pendidikan dan distribusi pegawai.</p>
        </div>
        @if(session('role') == 'superadmin')
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <button class="btn btn-gradient-primary shadow rounded-pill px-4 py-2" data-bs-toggle="modal" data-bs-target="#modalTambahPendidikan">
                <i class="bi bi-plus-circle-fill me-2"></i> Tambah Pendidikan
            </button>
        </div>
        @endif
    </div>
</div>

<div class="card card-modern shadow-sm border-0 mb-4">
        <div class="card-header bg-transparent border-0 pt-4 px-4">
            <div class="row align-items-center g-3">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-primary bg-opacity-10 p-2 rounded-3 me-3 text-primary">
                            <i class="bi bi-mortarboard-fill"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Referensi Pendidikan</h5>
                            <small class="text-muted">{{ $pendidikans->count() }} pendidikan terdaftar</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="search-wrapper position-relative">
                        <i class="bi bi-search position-absolute text-muted" style="left: 15px; top: 50%; transform: translateY(-50%);"></i>
                        <input type="text" id="searchMainPendidikan" class="form-control rounded-pill ps-5 bg-light border-0" placeholder="Cari nama pendidikan...">
                    </div>
                </div>
            </div>
        </div>
    
    <div class="card-body p-0 mt-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="tabelMainPendidikan">
                <thead>
                    <tr>
                        <th class="ps-4" style="width:50px;">No</th>
                        <th>Nama Pendidikan</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">ASN</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendidikans as $index => $pendidikan)
                        <tr>
                            <td class="ps-4 text-muted fw-medium">{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3 text-uppercase" style="background: #eef2ff; color: #4e73df; font-size: 12px;">
                                        {{ substr($pendidikan->nama, 0, 1) }}
                                    </div>
                                    <span class="fw-bold text-dark">{{ $pendidikan->nama }}</span>
                                </div>
                            </td>
                            <td class="text-center">
                                @if($pendidikan->aktif == 'Y')
                                    <span class="badge-status bg-success bg-opacity-10 text-success">
                                        <i class="bi bi-dot"></i> Aktif
                                    </span>
                                @else
                                    <span class="badge-status bg-danger bg-opacity-10 text-danger">
                                        <i class="bi bi-dot"></i> Non-Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="#" class="asn-count-badge" data-bs-toggle="modal" data-bs-target="#modalDetailASN{{ $pendidikan->id }}">
                                    {{ $pendidikan->pegawais_count }} ASN
                                </a>
                            </td>
                            <td class="text-center pe-4">
                                @if(session('role') == 'superadmin')
                                <button class="btn btn-sm btn-outline-warning rounded-circle me-2" style="width: 32px; height: 32px; padding: 0;" data-bs-toggle="modal" data-bs-target="#modalEditPendidikan{{ $pendidikan->id }}" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="{{ url('/admin/master/pendidikan', $pendidikan->id) }}" method="POST" class="d-inline" onsubmit="confirmDeleteSweetAlert(this); return false;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" style="width: 32px; height: 32px; padding: 0;" title="Hapus">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                                @else
                                <span class="text-muted small">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Belum ada data pendidikan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Tambah Pendidikan --}}
<div class="modal fade" id="modalTambahPendidikan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-bold text-dark mb-0">Tambah Referensi Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ url('/admin/master/pendidikan') }}" method="POST">
                @csrf
                <div class="modal-body px-4">
                    <label class="form-label fw-semibold small">Nama Pendidikan</label>
                    <input type="text" class="form-control form-control-lg rounded-3 fs-6" name="nama" required placeholder="Contoh: D3, S1, S2">
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-gradient-primary rounded-pill px-4">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($pendidikans as $pendidikan)
{{-- Modal Edit --}}
<div class="modal fade" id="modalEditPendidikan{{ $pendidikan->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-bold">Perbarui Referensi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ url('/admin/master/pendidikan/'.$pendidikan->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-body px-4">
                    <label class="form-label fw-semibold small">Nama Pendidikan</label>
                    <input type="text" class="form-control form-control-lg rounded-3 fs-6" name="nama" required value="{{ $pendidikan->nama }}">
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning text-white rounded-pill px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Detail ASN --}}
<div class="modal fade" id="modalDetailASN{{ $pendidikan->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header modal-detail-header border-0 px-4 pt-4 pb-3">
                <div>
                    <h5 class="fw-bold mb-1">
                        <i class="bi bi-people-fill me-2"></i>Daftar ASN — {{ $pendidikan->nama }}
                    </h5>
                    <small class="opacity-75">{{ $pendidikan->pegawais_count }} pegawai terdaftar</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 py-3" style="max-height: 420px; overflow-y: auto;">
                @php
                    $unique_pegawais = $pendidikan->riwayat_pendidikan->map(function ($rp) {
                        return $rp->pegawai;
                    })->unique('id')->values();
                @endphp
                @if($unique_pegawais->isEmpty())
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-person-x display-4 text-light"></i>
                        <p class="mt-2 small">Belum ada ASN dengan pendidikan ini.</p>
                    </div>
                @else
                    @foreach($unique_pegawais as $pegawai)
                    <a href="{{ url('/admin/pegawai/'.$pegawai->user?->id.'/drh') }}" target="_blank" class="asn-list-item">
                        <div class="asn-detail-avatar">{{ strtoupper(substr($pegawai->nama_lengkap, 0, 2)) }}</div>
                        <div class="flex-grow-1">
                            <div class="fw-bold text-dark small">{{ $pegawai->nama_lengkap }}</div>
                            <div class="text-muted" style="font-size:11px;">NIP: {{ $pegawai->id }}</div>
                        </div>
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2 small fw-semibold me-2">
                            {{ $pendidikan->nama }}
                        </span>
                        <span class="asn-drh-btn">
                            <i class="bi bi-file-person-fill"></i> DRH
                        </span>
                    </a>
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

@endsection
