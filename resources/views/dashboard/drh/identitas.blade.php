@extends('layouts.app')

@section('title', 'Identitas Legal - DRH')

@section('content')
<div class="main-content">
    <div class="d-flex flex-column flex-md-row align-items-start justify-content-between gap-3 mb-4">
        <div>
            <div style="color: #2563eb; font-weight: 700; font-size: 12px; letter-spacing: 1px; text-transform: uppercase; border-left: 3px solid #2563eb; padding-left: 10px; margin-bottom: 10px;">Daftar Riwayat Hidup</div>
            <h1 class="fw-bold">H. Identitas Legal</h1>
            <p class="text-muted small">Kelola data identitas legal secara terpisah dari form DRH utama.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ url('/profile/drh') }}" class="btn btn-outline-primary btn-sm">&larr; Kembali ke Halaman DRH</a>
        </div>
    </div>

    <div id="identitasStatus" class="mb-3"></div>

    <form id="identitasForm" action="{{ url('/profile/drh') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="step" id="identitasStep" value="7">
        @include('dashboard.drh.legal')
    </form>
</div>
@endsection

@push('scripts')
<script>
    async function submitIdentitasAjax() {
        const form = document.getElementById('identitasForm');
        const formData = new FormData(form);
        const statusBox = document.getElementById('identitasStatus');

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (data.status === 'success') {
                statusBox.innerHTML = '<div class="alert alert-success border-0 shadow-sm rounded-4 p-3"><i class="bi bi-check-circle-fill me-2"></i>' + (data.message || 'Data legal berhasil disimpan') + '</div>';
            } else {
                let msg = data.message || 'Gagal menyimpan data identitas legal';
                if (data.errors && typeof data.errors === 'object') {
                    msg = Object.values(data.errors).flat().join('<br>');
                }
                statusBox.innerHTML = '<div class="alert alert-danger border-0 shadow-sm rounded-4 p-3"><i class="bi bi-exclamation-triangle-fill me-2"></i>' + msg + '</div>';
            }
        } catch (e) {
            statusBox.innerHTML = '<div class="alert alert-danger border-0 shadow-sm rounded-4 p-3"><i class="bi bi-exclamation-triangle-fill me-2"></i>Terjadi kesalahan saat menyimpan data</div>';
        }
    }

    function saveSectionData(stepNumber) {
        document.getElementById('identitasStep').value = stepNumber;
        submitIdentitasAjax();
    }
</script>
@endpush
