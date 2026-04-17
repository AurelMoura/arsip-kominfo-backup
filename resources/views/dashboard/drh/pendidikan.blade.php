<div class="card section-card border-0 shadow-sm overflow-hidden" style="border-radius: 24px;">
    <div class="section-header d-flex align-items-center justify-content-between gap-3 p-4" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white;">
        <div class="d-flex align-items-center gap-3">
            <div class="icon-box shadow-sm" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(4px); border-radius: 14px; width: 48px; height: 48px; display: grid; place-items: center;">
                <i class="bi bi-mortarboard-fill fs-4"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-0" style="letter-spacing: 0.5px;">C. Riwayat Pendidikan</h5>
                <small class="opacity-75">Riwayat pendidikan formal dari jenjang SD hingga S3</small>
            </div>
        </div>
        <button type="button" class="btn btn-white btn-sm fw-bold rounded-pill px-3 shadow-sm" onclick="addPendidikan()" style="background: white; color: #2563eb; border: none; transition: all 0.3s ease;">
            <i class="bi bi-plus-lg me-1"></i> Tambah Data
        </button>
    </div>

    <div class="card-body p-4 p-lg-5 bg-white" id="pendidikanContainer">
        @if(count($pendidikanRows) > 0)
            @foreach($pendidikanRows as $index => $pendidikan)
                <div class="sub-card border-0 mb-4 position-relative shadow-sm" style="border-radius: 20px; background: #f8fafc; padding: 25px; transition: all 0.3s ease;">
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-white">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge rounded-pill bg-primary d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 12px;">{{ $index + 1 }}</span>
                            <span class="fw-bold text-dark" style="font-size: 15px;">Data Pendidikan</span>
                        </div>
                        @if(!empty($pendidikan['id']))
                        <button type="button" class="btn btn-outline-danger btn-sm border-0 rounded-pill px-3" onclick="hapusDataPendidikan(this, '{{ $pendidikan['id'] }}')" style="font-size: 13px;">
                            <i class="bi bi-trash3 me-1"></i> Hapus
                        </button>
                        @else
                        <button type="button" class="btn btn-outline-danger btn-sm border-0 rounded-pill px-3" onclick="deletePendidikanRow(this, '')" style="font-size: 13px;">
                            <i class="bi bi-trash3 me-1"></i> Hapus
                        </button>
                        @endif
                    </div>

                    <div class="row g-4">
                        @if(!empty($pendidikan['id']))
                            <input type="hidden" name="pendidikan[{{ $index }}][id]" value="{{ $pendidikan['id'] }}">
                        @endif
                        
                        <div class="col-md-6">
                            <label class="form-label">Jenjang Pendidikan <span class="text-danger">*</span></label>
                            <select class="form-select py-2 border-0 shadow-sm" name="pendidikan[{{ $index }}][jenjang]" style="border-radius: 12px;">
                                <option value="">Pilih jenjang</option>
                                @foreach($pendidikanList as $jenjangOption)
                                    <option value="{{ $jenjangOption->nama }}" {{ old('pendidikan.'.$index.'.jenjang', $pendidikan['jenjang'] ?? '') === $jenjangOption->nama ? 'selected' : '' }}>{{ $jenjangOption->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nama Sekolah / Universitas <span class="text-danger">*</span></label>
                            <input type="text" class="form-control py-2 border-0 shadow-sm" name="pendidikan[{{ $index }}][nama_sekolah]" value="{{ old('pendidikan.'.$index.'.nama_sekolah', $pendidikan['nama_sekolah'] ?? '') }}" placeholder="Contoh: Universitas Gadjah Mada" style="border-radius: 12px;">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tahun Masuk</label>
                            <input type="text" class="form-control py-2 border-0 shadow-sm text-center" name="pendidikan[{{ $index }}][tahun_masuk]" placeholder="20XX" value="{{ old('pendidikan.'.$index.'.tahun_masuk', $pendidikan['tahun_masuk'] ?? '') }}" style="border-radius: 12px;">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Tahun Lulus</label>
                            <input type="text" class="form-control py-2 border-0 shadow-sm text-center" name="pendidikan[{{ $index }}][tahun_lulus]" placeholder="20XX" value="{{ old('pendidikan.'.$index.'.tahun_lulus', $pendidikan['tahun_lulus'] ?? '') }}" style="border-radius: 12px;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nomor Ijazah</label>
                            <input type="text" class="form-control py-2 border-0 shadow-sm" name="pendidikan[{{ $index }}][nomor_ijazah]" placeholder="Masukan No. Ijazah" value="{{ old('pendidikan.'.$index.'.nomor_ijazah', $pendidikan['nomor_ijazah'] ?? '') }}" style="border-radius: 12px;">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Nama Pejabat Penandatangan Ijazah</label>
                            <input type="text" class="form-control py-2 border-0 shadow-sm" name="pendidikan[{{ $index }}][nama_pejabat]" placeholder="Contoh: Prof. Dr. John Doe" value="{{ old('pendidikan.'.$index.'.nama_pejabat', $pendidikan['nama_pejabat'] ?? '') }}" style="border-radius: 12px;">
                        </div>

                        <div class="col-12">
                            @php $pendidikanFile = old('pendidikan.'.$index.'.old_file', $pendidikan['file'] ?? null); @endphp
                            @if($pendidikanFile)
                                <div class="status-container">
                                    <div class="status-text">
                                        <div class="status-icon-circle"><i class="bi bi-check-lg"></i></div>
                                        Ijazah Tersedia
                                    </div>
                                    <div class="doc-actions">
                                        <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($pendidikanFile) }}" target="_blank" class="btn-lihat-dokumen" title="Lihat"><i class="bi bi-eye-fill"></i></a>
                                        <button type="button" class="btn-edit-dokumen" title="Edit" onclick="document.getElementById('pendidikan_reupload_{{ $index }}').click()"><i class="bi bi-pencil-square"></i></button>
                                        <input type="file" id="pendidikan_reupload_{{ $index }}" name="pendidikan[{{ $index }}][file]" accept=".pdf" class="d-none" onchange="drhReuploadPreview(this)">
                                        <button type="button" class="btn-hapus-dokumen" title="Hapus" onclick="deletePendidikanFile(this, '{{ $pendidikan['id'] ?? '' }}')"><i class="bi bi-trash"></i></button>
                                    </div>
                                </div>
                                <input type="hidden" name="pendidikan[{{ $index }}][old_file]" value="{{ $pendidikanFile }}">
                            @else
                                <div class="upload-box border-2 border-dashed d-flex flex-column align-items-center justify-content-center p-4 transition-all" style="border-radius: 16px; background: #fff; cursor: pointer;">
                                    <input type="file" id="pendidikan_file_{{ $index }}" name="pendidikan[{{ $index }}][file]" accept=".pdf" style="display:none;">
                                    <label for="pendidikan_file_{{ $index }}" class="w-100 text-center mb-0 pointer">
                                        <i class="bi bi-cloud-arrow-up text-primary mb-2" style="font-size: 2rem;"></i>
                                        <p class="mb-1 fw-bold text-dark">Upload Ijazah</p>
                                        <p class="mb-0 text-muted small">Format PDF (Maks. 1MB)</p>
                                    </label>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div id="emptyPendidikan" class="text-center py-5 border-2 border-dashed rounded-4" style="background: #fafafa; border-color: #e2e8f0;">
                <img src="https://cdn-icons-png.flaticon.com/512/3973/3973461.png" width="80" class="opacity-25 mb-3" alt="Empty">
                <h6 class="text-muted fw-bold">Belum ada riwayat pendidikan</h6>
                <p class="small text-muted mb-3">Klik tombol "Tambah Data" untuk mulai mengisi.</p>
                <button type="button" class="btn btn-primary btn-sm rounded-pill px-4" onclick="addPendidikan()">Tambah Sekarang</button>
            </div>
        @endif
    </div>

    <div class="card-body p-4 p-lg-5 pt-0 d-flex justify-content-end">
        <button type="button" class="btn btn-primary btn-lg fw-bold px-5 py-3 shadow" onclick="saveSectionData(2)" style="border-radius: 16px; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); background: #2563eb; border: none;">
            <i class="bi bi-cloud-arrow-up-fill me-2"></i> Simpan Riwayat Pendidikan
        </button>
    </div>
</div>

<style>
    /* Tambahan style khusus interaksi */
    .sub-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.08) !important;
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
    }
    
    .upload-box:hover {
        border-color: #2563eb !important;
        background: #eff6ff !important;
    }

    .btn-white:hover {
        background: #f8fafc !important;
        transform: scale(1.05);
    }

    .form-select, .form-control {
        transition: all 0.2s;
    }

    .form-select:focus, .form-control:focus {
        background: white !important;
        transform: translateY(-2px);
    }
</style>

@push('scripts')
<script>
// Hapus data pendidikan dari database (AJAX)
function hapusDataPendidikan(btn, id) {
    if (!id) return;
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Yakin ingin menghapus data pendidikan ini?',
            text: 'Data pendidikan yang dihapus tidak bisa dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d32f2f',
            cancelButtonColor: '#757575',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
            allowOutsideClick: false,
            allowEscapeKey: true
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/profile/drh/pendidikan/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire('Berhasil', data.message, 'success');
                        btn.closest('.sub-card').remove();
                    } else {
                        Swal.fire('Gagal', data.message || 'Gagal menghapus data.', 'error');
                    }
                })
                .catch(() => Swal.fire('Gagal', 'Terjadi kesalahan.', 'error'));
            }
        });
    } else {
        if (confirm('Apakah Anda yakin ingin menghapus data pendidikan ini? Data yang sudah dihapus tidak bisa dikembalikan.')) {
            fetch(`/profile/drh/pendidikan/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    btn.closest('.sub-card').remove();
                } else {
                    alert(data.message || 'Gagal menghapus data.');
                }
            })
            .catch(() => alert('Terjadi kesalahan.'));
        }
    }
}
function confirmDeleteRowPendidikan(btn) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: 'Data pendidikan yang dihapus tidak bisa dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d32f2f',
            cancelButtonColor: '#757575',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            allowOutsideClick: false,
            allowEscapeKey: true
        }).then((result) => {
            if (result.isConfirmed) {
                deletePendidikanRow(btn);
            }
        });
    } else {
        if (confirm('Apakah Anda yakin ingin menghapus data pendidikan? Data yang sudah dihapus tidak bisa dikembalikan.')) {
            deletePendidikanRow(btn);
        }
    }
}

function deletePendidikanRow(btn, id) {
    if (id) {
        // Sudah ada di database, tandai untuk dihapus
        let delInput = btn.closest('.sub-card').querySelector('input[name$="[_delete]"]');
        if (!delInput) {
            delInput = document.createElement('input');
            delInput.type = 'hidden';
            delInput.name = idInput.name.replace('[id]', '[_delete]');
            delInput.value = '1';
            btn.closest('.sub-card').appendChild(delInput);
        }
        btn.closest('.sub-card').style.display = 'none';
    } else {
        // Belum ada di database, hapus langsung
        btn.closest('.sub-card').remove();
    }
}

function deletePendidikanFile(btn, id) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Yakin ingin menghapus dokumen ini?',
            text: 'File dokumen yang dihapus tidak bisa dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d32f2f',
            cancelButtonColor: '#757575',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
            allowOutsideClick: false,
            allowEscapeKey: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Hapus file di backend jika ada id, atau kosongkan input file jika baru
                if (id) {
                    fetch(`/profile/drh/pendidikan/${id}/delete-file`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire('Berhasil', data.message, 'success');
                            // Hapus status dokumen saja, bukan seluruh data pendidikan
                            const statusContainer = btn.closest('.status-container');
                            if (statusContainer) statusContainer.remove();
                        } else {
                            Swal.fire('Gagal', data.message, 'error');
                        }
                    })
                    .catch(() => Swal.fire('Gagal', 'Terjadi kesalahan.', 'error'));
                } else {
                    // Untuk baris baru, kosongkan input file
                    const fileInput = btn.closest('.doc-actions').querySelector('input[type="file"]');
                    if (fileInput) fileInput.value = '';
                    const statusContainer = btn.closest('.status-container');
                    if (statusContainer) statusContainer.remove();
                    Swal.fire('Berhasil', 'Dokumen berhasil dihapus!', 'success');
                }
            }
        });
    } else {
        if (confirm('Apakah Anda yakin ingin menghapus dokumen ini? File yang sudah dihapus tidak bisa dikembalikan.')) {
            if (id) {
                fetch(`/profile/drh/pendidikan/${id}/delete-file`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                        const statusContainer = btn.closest('.status-container');
                        if (statusContainer) statusContainer.remove();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(() => alert('Terjadi kesalahan.'));
            } else {
                const fileInput = btn.closest('.doc-actions').querySelector('input[type="file"]');
                if (fileInput) fileInput.value = '';
                const statusContainer = btn.closest('.status-container');
                if (statusContainer) statusContainer.remove();
                alert('Dokumen berhasil dihapus!');
            }
        }
    }
}
</script>
@endpush