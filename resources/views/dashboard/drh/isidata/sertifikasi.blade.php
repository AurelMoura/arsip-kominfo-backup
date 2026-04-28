<div class="card section-card border-0 shadow-sm overflow-hidden" style="border-radius: 24px;">
@php $isLocked = $isLockedSertifikasi ?? ($drhData?->is_locked_sertifikasi ?? false); @endphp
    <div class="section-header d-flex align-items-center justify-content-between gap-3 p-4" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white;">
        <div class="d-flex align-items-center gap-3">
            <div class="icon-box shadow-sm" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(4px); border-radius: 14px; width: 48px; height: 48px; display: grid; place-items: center;">
                <i class="bi bi-patch-check-fill fs-4"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-0" style="letter-spacing: 0.5px;">G. Riwayat Sertifikasi @if($isLocked)<span class="badge ms-2" style="background:rgba(255,255,255,0.2);font-size:11px;"><i class="bi bi-lock-fill me-1"></i>Terkunci</span>@endif</h5>
                <small class="opacity-75">Sertifikasi profesi dan kompetensi yang telah diperoleh</small>
            </div>
        </div>
        <button type="button" class="btn btn-white btn-sm fw-bold rounded-pill px-3 shadow-sm" onclick="addSertif()" style="background: white; color: #2563eb; border: none; transition: all 0.3s ease;">
            <i class="bi bi-plus-lg me-1"></i> Tambah Sertifikasi
        </button>
    </div>

    <div class="card-body p-4 p-lg-5 bg-white" id="sertifContainer">
        @if(count($sertifRows) > 0)
            {{-- Hidden inputs to preserve existing row data on form submit --}}
            <div class="d-none">
                @foreach($sertifRows as $index => $sertif)
                    @if(!empty($sertif['id']))
                        <input type="hidden" name="sertif[{{ $index }}][id]" value="{{ $sertif['id'] }}">
                    @endif
                    <input type="hidden" name="sertif[{{ $index }}][nama]" value="{{ $sertif['nama'] ?? '' }}">
                    <input type="hidden" name="sertif[{{ $index }}][tahun]" value="{{ $sertif['tahun'] ?? '' }}">
                    <input type="hidden" name="sertif[{{ $index }}][lembaga]" value="{{ $sertif['lembaga'] ?? '' }}">
                    @if(!empty($sertif['file']))
                        <input type="hidden" name="sertif[{{ $index }}][old_file]" value="{{ $sertif['file'] }}">
                    @endif
                @endforeach
            </div>
            <div class="table-responsive">
                <table class="table drh-subtable mb-3">
                    <thead>
                        <tr>
                            <th>Nama Sertifikasi</th>
                            <th>Tahun</th>
                            <th>Lembaga Pelaksana</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sertifRows as $index => $sertif)
                        {{-- Baris Tampil --}}
                        <tr id="srtf-view-{{ $sertif['id'] }}">
                            <td class="fw-bold text-dark" id="srtf-disp-nama-{{ $sertif['id'] }}">{{ $sertif['nama'] ?? '-' }}</td>
                            <td id="srtf-disp-tahun-{{ $sertif['id'] }}">{{ $sertif['tahun'] ?? '-' }}</td>
                            <td id="srtf-disp-lembaga-{{ $sertif['id'] }}">{{ $sertif['lembaga'] ?? '-' }}</td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    @if(!empty($sertif['file']))
                                    <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($sertif['file']) }}" target="_blank" class="btn btn-sm btn-outline-primary" id="srtf-file-link-{{ $sertif['id'] }}" title="Lihat File" style="border-radius:8px;width:34px;height:34px;display:inline-flex;align-items:center;justify-content:center;">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                    </a>
                                    @endif
                                    @if(!empty($sertif['id']))
                                    <button type="button" class="btn btn-sm btn-warning srtf-edit-btn" title="Edit" style="border-radius:8px;width:34px;height:34px;display:inline-flex;align-items:center;justify-content:center;"
                                        @disabled($isLockedSertifikasi ?? false)
                                        onclick="openEditSertifModal(
                                            {{ $sertif['id'] }},
                                            '{{ addslashes($sertif['nama'] ?? '') }}',
                                            '{{ $sertif['tahun'] ?? '' }}',
                                            '{{ addslashes($sertif['lembaga'] ?? '') }}'
                                        )">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger srtf-hapus-btn" title="Hapus" style="border-radius:8px;width:34px;height:34px;display:inline-flex;align-items:center;justify-content:center;"
                                        @disabled($isLockedSertifikasi ?? false)
                                        onclick="deleteDrhSavedRow('/profile/drh/sertifikasi/{{ $sertif['id'] }}', this)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div id="emptySertif" class="text-center py-5 border-2 border-dashed rounded-4" style="background: #fafafa; border-color: #e2e8f0;">
                <div class="mb-3">
                    <i class="bi bi-award opacity-25" style="font-size: 4rem;"></i>
                </div>
                <h6 class="text-muted fw-bold">Belum ada data sertifikasi</h6>
                <p class="small text-muted mb-3">Tambahkan sertifikasi keahlian kamu untuk memperkuat profil profesional.</p>
                <button type="button" class="btn btn-primary btn-sm rounded-pill px-4" onclick="addSertif()">Tambah Sekarang</button>
            </div>
        @endif
    </div>

    <div class="card-body p-4 p-lg-5 pt-0 d-flex justify-content-end border-top mt-2">
        <button type="button" class="btn btn-primary btn-lg fw-bold px-5 py-3 shadow mt-4" onclick="saveSectionData(6)" style="border-radius: 16px; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); background: #2563eb; border: none;">
            <i class="bi bi-cloud-arrow-up-fill me-2"></i> Simpan Riwayat Sertifikasi
        </button>
    </div>
</div>

{{-- ===================== MODAL EDIT SERTIFIKASI ===================== --}}
<div class="modal fade" id="editSertifModal" tabindex="-1" aria-labelledby="editSertifModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            {{-- Header --}}
            <div class="modal-header border-0 px-4 py-3" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);">
                <h5 class="modal-title fw-bold text-white" id="editSertifModalLabel">
                    <i class="bi bi-pencil-square me-2"></i>Edit Data Riwayat Sertifikasi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body p-4" style="background: #f8fafc;">
                <div class="card border-0 shadow-sm p-4" style="border-radius: 16px; background: white;">
                    <input type="hidden" id="edit-sertif-id">

                    {{-- Nama Sertifikasi --}}
                    <div class="row g-3 mb-3">
                        <div class="col-12">
                            <label class="form-label">NAMA SERTIFIKASI</label>
                            <input type="text" class="form-control" id="edit-sertif-nama" placeholder="Nama sertifikasi...">
                        </div>
                    </div>

                    {{-- Lembaga & Tahun --}}
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-8">
                            <label class="form-label">LEMBAGA PELAKSANA</label>
                            <input type="text" class="form-control" id="edit-sertif-lembaga" placeholder="Nama lembaga pelaksana...">
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label">TAHUN</label>
                            <input type="number" class="form-control" id="edit-sertif-tahun" placeholder="Contoh: 2022" min="1900" max="2099">
                        </div>
                    </div>

                    {{-- Upload File --}}
                    <div class="mb-1">
                        <label class="form-label">UPLOAD SERTIFIKAT (PDF)</label>
                        <div class="upload-box border-2 border-dashed rounded-3 text-center py-3 px-3" style="border-color: #cbd5e1; cursor: pointer; transition: all 0.2s;" onclick="document.getElementById('edit-sertif-file').click()">
                            <i class="bi bi-cloud-upload text-primary fs-4 mb-1 d-block"></i>
                            <span class="text-primary small fw-semibold" id="edit-sertif-file-label">Upload Sertifikat (PDF, maks 1 MB)</span>
                            <input type="file" id="edit-sertif-file" accept=".pdf" class="d-none" onchange="editSertifFileChange(this)">
                        </div>
                        <div id="edit-sertif-file-existing" class="mt-2 d-none">
                            <small class="text-muted"><i class="bi bi-file-earmark-pdf text-danger me-1"></i>File sertifikat saat ini tersimpan. Upload baru untuk mengganti.</small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="modal-footer border-0 px-4 pb-4 pt-2 bg-white d-flex justify-content-between">
                <button type="button" class="btn btn-outline-secondary fw-semibold px-4" data-bs-dismiss="modal" style="border-radius: 10px;">
                    <i class="bi bi-x-lg me-1"></i>Batal
                </button>
                <button type="button" class="btn btn-primary fw-bold px-5" id="editSertifSaveBtn" onclick="submitEditSertif()" style="border-radius: 10px; background: #2563eb; border: none;">
                    <i class="bi bi-check-lg me-1"></i>Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>
{{-- ================================================================= --}}

<style>
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
    .form-label {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        font-weight: 700;
    }
</style>

@push('scripts')
<script>
    // =============================================
    // HELPER: Ambil CSRF token
    // =============================================
    function getSertifCsrfToken() {
        var metaTag = document.querySelector('meta[name="csrf-token"]');
        if (metaTag) return metaTag.getAttribute('content');
        var match = document.cookie.match(/XSRF-TOKEN=([^;]+)/);
        if (match) return decodeURIComponent(match[1]);
        return '';
    }

    // =============================================
    // BUKA MODAL EDIT SERTIFIKASI (pre-fill data lama)
    // =============================================
    function openEditSertifModal(id, nama, tahun, lembaga) {
        // Reset file input
        document.getElementById('edit-sertif-file').value = '';
        document.getElementById('edit-sertif-file-label').textContent = 'Upload Sertifikat (PDF, maks 1 MB)';

        // Isi semua field dengan data lama
        document.getElementById('edit-sertif-id').value      = id;
        document.getElementById('edit-sertif-nama').value    = nama;
        document.getElementById('edit-sertif-tahun').value   = tahun;
        document.getElementById('edit-sertif-lembaga').value = lembaga;

        // Tampilkan info file lama jika ada
        var fileLink         = document.getElementById('srtf-file-link-' + id);
        var existingFileInfo = document.getElementById('edit-sertif-file-existing');
        if (fileLink) {
            existingFileInfo.classList.remove('d-none');
        } else {
            existingFileInfo.classList.add('d-none');
        }

        // Buka modal
        var modal = new bootstrap.Modal(document.getElementById('editSertifModal'));
        modal.show();
    }

    // =============================================
    // HANDLER PERUBAHAN FILE
    // =============================================
    function editSertifFileChange(input) {
        var label = document.getElementById('edit-sertif-file-label');
        if (input.files && input.files[0]) {
            label.textContent = input.files[0].name;
        } else {
            label.textContent = 'Upload Sertifikat (PDF, maks 1 MB)';
        }
    }

    // =============================================
    // SUBMIT EDIT SERTIFIKASI → UPDATE DATABASE
    // =============================================
    function submitEditSertif() {
        var btn      = document.getElementById('editSertifSaveBtn');
        var origHtml = btn.innerHTML;

        try {
            var id        = document.getElementById('edit-sertif-id').value;
            var nama      = document.getElementById('edit-sertif-nama').value.trim();
            var tahun     = document.getElementById('edit-sertif-tahun').value;
            var lembaga   = document.getElementById('edit-sertif-lembaga').value.trim();
            var fileInput = document.getElementById('edit-sertif-file');
            var csrfToken = getSertifCsrfToken();
        } catch (syncErr) {
            if (typeof Swal !== 'undefined') {
                Swal.fire('Gagal', 'Terjadi kesalahan inisialisasi form.', 'error');
            } else {
                alert('Terjadi kesalahan inisialisasi form.');
            }
            return;
        }

        // Validasi wajib
        if (!nama) {
            if (typeof Swal !== 'undefined') {
                Swal.fire('Perhatian', 'Nama sertifikasi tidak boleh kosong.', 'warning');
            } else {
                alert('Nama sertifikasi tidak boleh kosong.');
            }
            return;
        }

        // Aktifkan spinner
        btn.disabled  = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...';

        // Siapkan FormData (multipart agar mendukung upload file)
        var formData = new FormData();
        formData.append('nama_sertifikasi', nama);
        formData.append('tahun',            tahun);
        formData.append('lembaga_pelaksana', lembaga);
        if (fileInput.files[0]) {
            formData.append('file', fileInput.files[0]);
        }

        // Kirim ke endpoint POST /update (sama polanya dengan diklat)
        fetch('/profile/drh/sertifikasi/' + id + '/update', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(function(res) {
            var contentType = res.headers.get('content-type') || '';
            if (!contentType.includes('application/json')) {
                btn.disabled  = false;
                btn.innerHTML = origHtml;
                var msg = res.status === 419
                    ? 'Sesi telah habis (CSRF). Silakan refresh halaman.'
                    : 'Server mengembalikan respons tidak valid (status ' + res.status + ').';
                if (typeof Swal !== 'undefined') {
                    Swal.fire('Gagal', msg, 'error');
                } else {
                    alert('Gagal: ' + msg);
                }
                return null;
            }
            return res.json();
        })
        .then(function(data) {
            if (data === null) return;

            btn.disabled  = false;
            btn.innerHTML = origHtml;

            if (data.status === 'success') {
                // Update tampilan baris tabel dengan data terbaru
                var dispNama   = document.getElementById('srtf-disp-nama-'   + id);
                var dispTahun  = document.getElementById('srtf-disp-tahun-'  + id);
                var dispLembaga = document.getElementById('srtf-disp-lembaga-' + id);

                if (dispNama)    dispNama.textContent    = nama    || '-';
                if (dispTahun)   dispTahun.textContent   = tahun   || '-';
                if (dispLembaga) dispLembaga.textContent = lembaga || '-';

                // Update link file jika ada file baru yang diupload
                if (data.data && data.data.file_url) {
                    var link = document.getElementById('srtf-file-link-' + id);
                    if (link) {
                        link.href = data.data.file_url;
                    } else {
                        // Buat link baru jika sebelumnya tidak ada file
                        var tdAksi = document.querySelector('#srtf-view-' + id + ' td:last-child .d-flex');
                        if (tdAksi) {
                            var newLink = document.createElement('a');
                            newLink.href      = data.data.file_url;
                            newLink.target    = '_blank';
                            newLink.id        = 'srtf-file-link-' + id;
                            newLink.className = 'btn btn-sm btn-outline-primary';
                            newLink.title     = 'Lihat File';
                            newLink.style     = 'border-radius:8px;width:34px;height:34px;display:inline-flex;align-items:center;justify-content:center;';
                            newLink.innerHTML = '<i class="bi bi-file-earmark-pdf"></i>';
                            tdAksi.insertBefore(newLink, tdAksi.firstChild);
                        }
                    }
                }

                // Tutup modal
                bootstrap.Modal.getInstance(document.getElementById('editSertifModal')).hide();

                if (typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message, timer: 1500, showConfirmButton: false });
                }
            } else {
                if (typeof Swal !== 'undefined') {
                    Swal.fire('Gagal', data.message || 'Gagal menyimpan perubahan.', 'error');
                } else {
                    alert('Gagal: ' + (data.message || 'Gagal menyimpan perubahan.'));
                }
            }
        })
        .catch(function() {
            btn.disabled  = false;
            btn.innerHTML = origHtml;
            if (typeof Swal !== 'undefined') {
                Swal.fire('Gagal', 'Terjadi kesalahan jaringan atau server.', 'error');
            } else {
                alert('Terjadi kesalahan jaringan atau server.');
            }
        });
    }

    // =============================================
    // HAPUS DATA SERTIFIKASI (sudah ada via deleteDrhSavedRow)
    // Fungsi lama deleteSertifikasiRow dipertahankan untuk kompatibilitas
    // =============================================
    function deleteSertifikasiRow(btn, id) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: 'Data sertifikasi yang dihapus tidak bisa dikembalikan!',
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
                    if (id) {
                        fetch(`/profile/drh/sertifikasi/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': getSertifCsrfToken(),
                                'Accept': 'application/json'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status === 'success') {
                                Swal.fire('Berhasil', data.message, 'success');
                                btn.closest('.sub-card').remove();
                            } else {
                                Swal.fire('Gagal', data.message, 'error');
                            }
                        })
                        .catch(() => Swal.fire('Gagal', 'Terjadi kesalahan.', 'error'));
                    } else {
                        btn.closest('.sub-card').remove();
                    }
                }
            });
        } else {
            if (confirm('Apakah Anda yakin ingin menghapus data sertifikasi?')) {
                if (id) {
                    fetch(`/profile/drh/sertifikasi/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': getSertifCsrfToken(),
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            if (typeof showToast === 'function') showToast(data.message, 'success');
                            btn.closest('.sub-card').remove();
                        } else {
                            if (typeof showToast === 'function') showToast(data.message, 'error');
                        }
                    })
                    .catch(() => {
                        if (typeof showToast === 'function') showToast('Terjadi kesalahan.', 'error');
                    });
                } else {
                    btn.closest('.sub-card').remove();
                }
            }
        }
    }

    // =============================================
    // INLINE SAVE (dipertahankan, tidak dihapus)
    // =============================================
    function saveInlineSertif(id, btn) {
        const nama    = document.getElementById('srtf-f-nama-'   + id).value.trim();
        const tahun   = document.getElementById('srtf-f-tahun-'  + id).value;
        const lembaga = document.getElementById('srtf-f-lembaga-'+ id).value;
        const fileInput = document.getElementById('srtf-f-file-' + id);

        if (!nama) {
            if (typeof Swal !== 'undefined') Swal.fire('Perhatian', 'Nama sertifikasi tidak boleh kosong.', 'warning');
            return;
        }

        const formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('nama_sertifikasi', nama);
        formData.append('tahun', tahun);
        formData.append('lembaga_pelaksana', lembaga);
        if (fileInput.files[0]) formData.append('file', fileInput.files[0]);

        const origHtml = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...';

        fetch(`/profile/drh/sertifikasi/${id}`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': getSertifCsrfToken(), 'Accept': 'application/json' },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = origHtml;
            if (data.status === 'success') {
                document.getElementById('srtf-disp-nama-'   + id).textContent = nama    || '-';
                document.getElementById('srtf-disp-tahun-'  + id).textContent = tahun   || '-';
                document.getElementById('srtf-disp-lembaga-'+ id).textContent = lembaga || '-';
                if (data.data?.file_url) {
                    const link = document.getElementById('srtf-file-link-' + id);
                    if (link) link.href = data.data.file_url;
                }
                toggleEditRow('srtf', id);
                if (typeof Swal !== 'undefined')
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message, timer: 1500, showConfirmButton: false });
            } else {
                if (typeof Swal !== 'undefined') Swal.fire('Gagal', data.message || 'Gagal menyimpan.', 'error');
            }
        })
        .catch(() => {
            btn.disabled = false;
            btn.innerHTML = origHtml;
            if (typeof Swal !== 'undefined') Swal.fire('Gagal', 'Terjadi kesalahan server.', 'error');
        });
    }
</script>
@endpush

