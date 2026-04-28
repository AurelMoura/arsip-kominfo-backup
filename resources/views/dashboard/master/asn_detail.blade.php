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
            <div class="text-primary fw-bold text-uppercase small mb-2" style="letter-spacing: .08em;">Master Data</div>
            <h3 class="fw-extrabold text-dark mb-1">{{ $heading }}</h3>
            <p class="text-muted mb-0">{{ $subHeading }}</p>
        </div>
        <a href="{{ $backUrl }}" class="btn btn-light border rounded-pill px-4 fw-bold">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="hero-box mb-4">
        <div class="d-flex flex-column flex-lg-row align-items-start justify-content-between gap-3">
            <div>
                <h4 class="fw-bold mb-2">{{ $referenceName ?: '-' }}</h4>
                <span class="badge bg-light text-primary rounded-pill px-3 py-2">{{ $referenceType }}</span>
            </div>
            <div class="text-lg-end">
                <div class="fs-2 fw-extrabold">{{ $asnCount }}</div>
                <div class="opacity-75">Jumlah ASN</div>
            </div>
        </div>
    </div>

    <div class="page-card p-4 p-lg-5">
        <div class="mb-4">
            <div class="position-relative">
                <i class="bi bi-search position-absolute text-muted" style="left: 14px; top: 50%; transform: translateY(-50%);"></i>
                <input type="text" id="asnSearchInput" class="form-control rounded-pill ps-5" placeholder="Cari nama atau NIP ASN...">
            </div>
        </div>

        @if($asns->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-person-x display-5 text-secondary opacity-25"></i>
                <p class="mt-3 mb-0">Belum ada ASN pada data referensi ini.</p>
            </div>
        @else
            <div id="asnListWrap">
                @foreach($asns as $pegawai)
                    <div class="pegawai-item asn-row" data-search="{{ strtolower(($pegawai->nama_lengkap ?? '').' '.$pegawai->id) }}">
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
                            </div>
                        </div>
                        <div class="pegawai-actions">
                            <span class="badge-soft {{ ($pegawai->status_pegawai ?? '') === 'PNS' ? 'bg-primary text-white' : 'bg-warning text-dark' }}">{{ $pegawai->status_pegawai ?? '-' }}</span>
                            <a href="{{ url('/admin/pegawai/by-pegawai/'.$pegawai->id.'/drh') }}" class="btn btn-primary btn-drh" target="_blank">
                                <i class="bi bi-file-earmark-person me-2"></i>DRH
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div id="asnSearchEmpty" class="text-center text-muted py-4 d-none">
                Tidak ada ASN yang cocok dengan pencarian.
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    const asnSearchInput = document.getElementById('asnSearchInput');
    const asnRows = Array.from(document.querySelectorAll('.asn-row'));
    const asnSearchEmpty = document.getElementById('asnSearchEmpty');

    if (asnSearchInput) {
        asnSearchInput.addEventListener('input', function () {
            const keyword = this.value.toLowerCase().trim();
            let visibleCount = 0;

            asnRows.forEach((row) => {
                const haystack = row.getAttribute('data-search') || '';
                const visible = !keyword || haystack.includes(keyword);
                row.classList.toggle('d-none', !visible);
                if (visible) visibleCount++;
            });

            if (asnSearchEmpty) {
                asnSearchEmpty.classList.toggle('d-none', visibleCount > 0);
            }
        });
    }
</script>
@endpush
@endsection