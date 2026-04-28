{{-- Form Identitas Legal: Admin Buttons + Simpan Semua Data --}}
@php
    $isFormLocked = $isLocked ?? ($isLockedLegal ?? ($drhData?->identitas_legal['is_locked_legal'] ?? false));
    $isDrhLockedGlobal = $isDrhLocked ?? ($drhData?->is_drh_locked ?? false);
@endphp

{{-- LOCK/UNLOCK BUTTON FOR ADMIN/SUPERADMIN --}}
@if(session('role') === 'admin' || session('role') === 'superadmin')
    @if($isDrhLockedGlobal)
    <div class="mb-3 text-end">
        <button type="button" class="btn btn-warning fw-bold" id="unlock-all-drh-btn">
            <i class="bi bi-unlock-fill me-1"></i> Unlock Semua DRH
        </button>
    </div>
    @else
    <div class="mb-3 text-end">
        <button type="button" class="btn btn-danger fw-bold" id="lock-all-drh-btn">
            <i class="bi bi-lock-fill me-1"></i> Lock Semua DRH
        </button>
    </div>
    @endif
@endif

<div class="mt-4 pt-3 border-top text-center">
    <button type="button" class="btn btn-save-main px-5" onclick="showLockToastThenSave()">
        <i class="bi bi-save2-fill me-2"></i> Simpan Semua Data
    </button>
</div>

<script>
function showLockToastThenSave() {
    // Pakai SweetAlert jika ada, fallback alert jika tidak
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'warning',
            title: 'Perhatian',
            text: 'Semua data akan dikunci, hubungi admin jika ada perubahan data!',
            showCancelButton: true,
            confirmButtonText: 'Lanjutkan Simpan',
            cancelButtonText: 'Batal',
            allowOutsideClick: false
        }).then(function(result) {
            if (result.isConfirmed) {
                disableDrhEditDelete();
                var lockInput = document.getElementById('lockDrhInput');
                if (lockInput) lockInput.value = '1';
                saveSectionData(7);
            }
        });
    } else {
        if (confirm('Semua data akan dikunci, hubungi admin jika ada perubahan data! Lanjutkan simpan?')) {
            disableDrhEditDelete();
            var lockInput = document.getElementById('lockDrhInput');
            if (lockInput) lockInput.value = '1';
            saveSectionData(7);
        }
    }
}

// Disable all edit & delete buttons in DRH sections, allow add buttons
function disableDrhEditDelete() {
    // Edit buttons (specific classes to avoid disabling "Tambah" or other buttons)
    document.querySelectorAll('.srtf-edit-btn, .pend-edit-btn, .diklat-edit-btn, .jab-edit-btn, .awrd-edit-btn, .family-action-edit').forEach(function(btn) {
        btn.disabled = true;
        btn.style.pointerEvents = 'none';
        btn.style.opacity = 0.5;
    });
    // Delete buttons
    document.querySelectorAll('.srtf-hapus-btn, .pend-hapus-btn, .diklat-hapus-btn, .jab-hapus-btn, .awrd-hapus-btn, .family-action-delete').forEach(function(btn) {
        btn.disabled = true;
        btn.style.pointerEvents = 'none';
        btn.style.opacity = 0.5;
    });
    // Individual save buttons (Identitas Legal)
    document.querySelectorAll('.lf-save-single-btn').forEach(function(btn) {
        btn.disabled = true;
        btn.style.pointerEvents = 'none';
        btn.style.opacity = 0.45;
    });
}
</script>

<script>
$(document).ready(function() {
    // UNLOCK ALL DRH
    $('#unlock-all-drh-btn').on('click', function() {
        Swal.fire({
            icon: 'warning',
            title: 'Konfirmasi Unlock',
            text: 'Semua data DRH akan diunlock. Pegawai dapat mengedit dan menghapus data kembali.',
            showCancelButton: true,
            confirmButtonText: 'Ya, Unlock',
            cancelButtonText: 'Batal',
            allowOutsideClick: false
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('drh.legal.unlock') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        pegawai_id: {{ $drhData->id ?? 'null' }}
                    },
                    success: function(res) {
                        if (res.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: res.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            setTimeout(function() { location.reload(); }, 1200);
                        } else {
                            Swal.fire('Gagal', res.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Gagal', xhr.responseJSON?.message || 'Terjadi kesalahan', 'error');
                    }
                });
            }
        });
    });

    // LOCK ALL DRH
    $('#lock-all-drh-btn').on('click', function() {
        Swal.fire({
            icon: 'warning',
            title: 'Konfirmasi Lock',
            text: 'Semua data DRH akan dikunci. Tombol edit dan hapus akan dinonaktifkan.',
            showCancelButton: true,
            confirmButtonText: 'Ya, Lock',
            cancelButtonText: 'Batal',
            allowOutsideClick: false
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('admin.drh.lock.all') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        pegawai_id: {{ $drhData->id ?? 'null' }}
                    },
                    success: function(res) {
                        if (res.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: res.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            setTimeout(function() { location.reload(); }, 1200);
                        } else {
                            Swal.fire('Gagal', res.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Gagal', xhr.responseJSON?.message || 'Terjadi kesalahan', 'error');
                    }
                });
            }
        });
    });
});
</script>