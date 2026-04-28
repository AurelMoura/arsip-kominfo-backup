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
    {{-- DEBUG: hapus setelah fix --}}
    {{ dump($isAdmin, $user->id) }}
    <form id="identitasForm" 
    action="{{ $isAdmin ? url('/admin/pegawai/'.$user->id.'/drh/save') : url('/profile/drh') }}" 
    method="POST" 
    enctype="multipart/form-data">
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
                Swal.fire({
                    icon: 'success',
                    title: data.message || 'Data legal berhasil disimpan',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000
                });
                statusBox.innerHTML = '';
            } else {
                let msg = data.message || 'Gagal menyimpan data identitas legal';
                if (data.errors && typeof data.errors === 'object') {
                    msg = Object.values(data.errors).flat().join('\n');
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: msg,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                statusBox.innerHTML = '';
            }
        } catch (e) {
            Swal.fire({
                icon: 'error',
                title: 'Terjadi kesalahan saat menyimpan data',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            statusBox.innerHTML = '';
        }
    }

    function saveSectionData(stepNumber) {
        document.getElementById('identitasStep').value = stepNumber;
        submitIdentitasAjax();
    }
</script>
@endpush
