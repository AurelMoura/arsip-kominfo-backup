@extends('layouts.app')

@section('content')
<style>
    .main-content {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        min-height: 100vh;
    }
    .page-card {
        border: none;
        border-radius: 22px;
        background: #fff;
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.08);
    }
    .hero-box {
        background: linear-gradient(135deg, #4e73df, #224abe);
        color: #fff;
        border-radius: 22px;
        padding: 24px;
    }
    .pegawai-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 18px 0;
        border-bottom: 1px solid #eef2f7;
    }
    .pegawai-item:last-child {
        border-bottom: none;
    }
    .pegawai-meta {
        display: flex;
        align-items: center;
        gap: 14px;
        min-width: 0;
    }
    .pegawai-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1d4ed8;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        overflow: hidden;
    }
    .pegawai-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .pegawai-name {
        font-weight: 700;
        color: #0f172a;
    }
    .pegawai-subtext {
        color: #64748b;
        font-size: 0.85rem;
    }
    .pegawai-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: flex-end;
    }
    .badge-soft {
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 700;
    }
    .btn-drh {
        border-radius: 999px;
        padding: 8px 16px;
        font-weight: 700;
    }
    @media (max-width: 767px) {
        .pegawai-item {
            flex-direction: column;
            align-items: stretch;
        }
        .pegawai-actions {
            justify-content: flex-start;
        }
    }
</style>

<div class="main-content p-4">
    <div class="d-flex flex-column flex-md-row align-items-start justify-content-between gap-3 mb-4">
        <div>
            <div class="text-primary fw-bold text-uppercase small mb-2" style="letter-spacing: .08em;">Master Jabatan</div>
            <h3 class="fw-extrabold text-dark mb-1">Detail ASN Jabatan</h3>
            <p class="text-muted mb-0">Daftar ASN dengan jabatan {{ $jabatan->nama_jabatan }}.</p>
        </div>
        <a href="{{ url('/admin/master/jabatan') }}" class="btn btn-light border rounded-pill px-4 fw-bold">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="hero-box mb-4">
        <div class="d-flex flex-column flex-lg-row align-items-start justify-content-between gap-3">
            <div>
                <h4 class="fw-bold mb-2">{{ $jabatan->nama_jabatan }}</h4>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge bg-light text-primary rounded-pill px-3 py-2">{{ $jabatan->jenis_asn }}</span>
                    <span class="badge bg-light text-dark rounded-pill px-3 py-2">{{ $jabatan->jenis_jabatan ?? 'Tanpa Jenis Jabatan' }}</span>
                    <span class="badge bg-light text-dark rounded-pill px-3 py-2">{{ $jabatan->eselon ? 'Eselon '.$jabatan->eselon : 'Tanpa Eselon' }}</span>
                </div>
            </div>
            <div class="text-lg-end">
                <div class="fs-2 fw-extrabold">{{ $jabatan->pegawais_count }}</div>
                <div class="opacity-75">Jumlah ASN</div>
            </div>
        </div>
    </div>

    <div class="page-card p-4 p-lg-5">
        @if($jabatan->pegawais->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-person-x display-5 text-secondary opacity-25"></i>
                <p class="mt-3 mb-0">Belum ada ASN dengan jabatan ini.</p>
            </div>
        @else
            @foreach($jabatan->pegawais as $pegawai)
                <div class="pegawai-item">
                    <div class="pegawai-meta">
                        <div class="pegawai-avatar">
                            @if($pegawai->foto_profil)
                                <img src="{{ Storage::disk('public')->url($pegawai->foto_profil) }}" alt="{{ $pegawai->nama_lengkap }}">
                            @else
                                {{ strtoupper(substr($pegawai->nama_lengkap ?? '-', 0, 2)) }}
                            @endif
                        </div>
                        <div class="min-w-0">
                            <div class="pegawai-name">{{ $pegawai->nama_lengkap }}</div>
                            <div class="pegawai-subtext">NIP: {{ $pegawai->id }}</div>
                            <div class="pegawai-subtext">Jabatan: {{ $pegawai->nama_jabatan ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="pegawai-actions">
                        @if($pegawai->eselon_jabatan)
                            <span class="badge-soft bg-info bg-opacity-10 text-info">Eselon {{ $pegawai->eselon_jabatan }}</span>
                        @endif
                        <span class="badge-soft {{ $pegawai->status_pegawai === 'PNS' ? 'bg-primary text-white' : 'bg-warning text-dark' }}">{{ $pegawai->status_pegawai ?? '-' }}</span>
                        @if($pegawai->user?->id)
                            <a href="{{ url('/admin/pegawai/'.$pegawai->user->id.'/drh') }}" class="btn btn-primary btn-drh" target="_blank">
                                <i class="bi bi-file-earmark-person me-2"></i>DRH
                            </a>
                        @else
                            <span class="btn btn-light border btn-drh disabled">DRH</span>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection