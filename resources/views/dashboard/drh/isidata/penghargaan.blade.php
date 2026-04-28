<div class="card section-card border-0 shadow-sm overflow-hidden" style="border-radius: 24px;">
@php $isLocked = $isLockedPenghargaan ?? ($drhData?->is_locked_penghargaan ?? false); @endphp
    <div class="section-header d-flex align-items-center justify-content-between gap-3 p-4" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white;">
        <div class="d-flex align-items-center gap-3">
            <div class="icon-box shadow-sm" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(4px); border-radius: 14px; width: 48px; height: 48px; display: grid; place-items: center;">
                <i class="bi bi-trophy-fill fs-4"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-0" style="letter-spacing: 0.5px;">F. Riwayat Penghargaan @if($isLocked)<span class="badge ms-2" style="background:rgba(255,255,255,0.2);font-size:11px;"><i class="bi bi-lock-fill me-1"></i>Terkunci</span>@endif</h5>
                <small class="opacity-75">Penghargaan, tanda jasa, dan piagam yang pernah diterima</small>
            </div>
        </div>
        <button type="button" class="btn btn-white btn-sm fw-bold rounded-pill px-3 shadow-sm" onclick="addAward()" style="background: white; color: #2563eb; border: none; transition: all 0.3s ease;">
            <i class="bi bi-plus-lg me-1"></i> Tambah Penghargaan
        </button>
    </div>

    <div class="card-body p-4 p-lg-5 bg-white" id="awardContainer">
        @if(count($awardRows) > 0)
            {{-- Hidden inputs to preserve existing row data on form submit --}}
            <div class="d-none">
                @foreach($awardRows as $index => $award)
                    @if(!empty($award['id']))
                        <input type="hidden" name="award[{{ $index }}][id]" value="{{ $award['id'] }}">
                    @endif
                    <input type="hidden" name="award[{{ $index }}][nama]" value="{{ $award['nama'] ?? '' }}">
                    <input type="hidden" name="award[{{ $index }}][tahun]" value="{{ $award['tahun'] ?? '' }}">
                    <input type="hidden" name="award[{{ $index }}][instansi]" value="{{ $award['instansi'] ?? '' }}">
                    @if(!empty($award['file']))
                        <input type="hidden" name="award[{{ $index }}][old_file]" value="{{ $award['file'] }}">
                    @endif
                @endforeach
            </div>
            <div class="table-responsive">
                <table class="table drh-subtable mb-3">
                    <thead>
                        <tr>
                            <th>Nama Penghargaan</th>
                            <th>Tahun</th>
                            <th>Instansi Pemberi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($awardRows as $index => $award)
                        {{-- Baris Tampil --}}
                        <tr id="awrd-view-{{ $award['id'] }}">
                            <td class="fw-bold text-dark" id="awrd-disp-nama-{{ $award['id'] }}">{{ $award['nama'] ?? '-' }}</td>
                            <td id="awrd-disp-tahun-{{ $award['id'] }}">{{ $award['tahun'] ?? '-' }}</td>
                            <td id="awrd-disp-instansi-{{ $award['id'] }}">{{ $award['instansi'] ?? '-' }}</td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    @if(!empty($award['file']))
                                    <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($award['file']) }}" target="_blank" class="btn btn-sm btn-outline-primary" id="awrd-file-link-{{ $award['id'] }}" title="Lihat File" style="border-radius:8px;width:34px;height:34px;display:inline-flex;align-items:center;justify-content:center;">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                    </a>
                                    @endif
                                    @if(!empty($award['id']))
                                    <button type="button" class="btn btn-sm btn-warning awrd-edit-btn" title="Edit" style="border-radius:8px;width:34px;height:34px;display:inline-flex;align-items:center;justify-content:center;"
                                        @disabled($isLockedPenghargaan ?? false)
                                        onclick="openEditPenghargaanModal(
                                            {{ $award['id'] }},
                                            '{{ addslashes($award['nama'] ?? '') }}',
                                            '{{ $award['tahun'] ?? '' }}',
                                            '{{ addslashes($award['instansi'] ?? '') }}'
                                        )">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger awrd-hapus-btn" title="Hapus" style="border-radius:8px;width:34px;height:34px;display:inline-flex;align-items:center;justify-content:center;"
                                        @disabled($isLockedPenghargaan ?? false)
                                        onclick="deleteDrhSavedRow('/profile/drh/penghargaan/{{ $award['id'] }}', this)">
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
            <div id="emptyAward" class="text-center py-5 border-2 border-dashed rounded-4" style="background: #fafafa; border-color: #e2e8f0;">
                <div class="mb-3">
                    <i class="bi bi-award-fill opacity-25" style="font-size: 4rem;"></i>
                </div>
                <h6 class="text-muted fw-bold">Belum ada riwayat penghargaan</h6>
                <p class="small text-muted mb-3">Punya prestasi atau piagam? Klik tombol di bawah untuk mencatatnya.</p>
                <button type="button" class="btn btn-primary btn-sm rounded-pill px-4" onclick="addAward()">Tambah Sekarang</button>
            </div>
        @endif
    </div>

    <div class="card-body p-4 p-lg-5 pt-0 d-flex justify-content-end border-top mt-2">
        <button type="button" class="btn btn-primary btn-lg fw-bold px-5 py-3 shadow mt-4" onclick="saveSectionData(5)" style="border-radius: 16px; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); background: #2563eb; border: none;">
            <i class="bi bi-cloud-arrow-up-fill me-2"></i> Simpan Riwayat Penghargaan
        </button>
    </div>
</div>

{{-- ===================== MODAL EDIT PENGHARGAAN ===================== --}}
<div class="modal fade" id="editPenghargaanModal" tabindex="-1" aria-labelledby="editPenghargaanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            {{-- Header --}}
            <div class="modal-header border-0 px-4 py-3" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);">
                <h5 class="modal-title fw-bold text-white" id="editPenghargaanModalLabel">
                    <i class="bi bi-pencil-square me-2"></i>Edit Data Riwayat Penghargaan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body p-4" style="background: #f8fafc;">
                <div class="card border-0 shadow-sm p-4" style="border-radius: 16px; background: white;">
                    <input type="hidden" id="edit-awrd-id">

                    {{-- Row 1: Nama Penghargaan --}}
                    <div class="row g-3 mb-3">
                        <div class="col-12">
                            <label class="form-label">NAMA PENGHARGAAN / TANDA JASA</label>
                            <input type="text" class="form-control" id="edit-awrd-nama" placeholder="Nama penghargaan atau tanda jasa...">
                        </div>
                    </div>

                    {{-- Row 2: Tahun & Instansi Pemberi --}}
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-4">
                            <label class="form-label">TAHUN</label>
                            <input type="number" class="form-control" id="edit-awrd-tahun" placeholder="Contoh: 2020" min="1900" max="2099">
                        </div>
                        <div class="col-12 col-md-8">
                            <label class="form-label">INSTANSI PEMBERI</label>
                            <input type="text" class="form-control" id="edit-awrd-instansi" placeholder="Nama instansi atau lembaga pemberi penghargaan...">
                        </div>
                    </div>

                    {{-- Upload File --}}
                    <div class="mb-1">
                        <label class="form-label">UPLOAD PIAGAM / DOKUMEN PENGHARGAAN</label>
                        <div class="upload-box border-2 border-dashed rounded-3 text-center py-3 px-3" style="border-color: #cbd5e1; cursor: pointer; transition: all 0.2s;" onclick="document.getElementById('edit-awrd-file').click()">
                            <i class="bi bi-cloud-upload text-primary fs-4 mb-1 d-block"></i>
                            <span class="text-primary small fw-semibold" id="edit-awrd-file-label">Upload Piagam / Dokumen Penghargaan (PDF, maks 1 MB)</span>
                            <input type="file" id="edit-awrd-file" accept=".pdf" class="d-none" onchange="editPenghargaanFileChange(this)">
                        </div>
                        <div id="edit-awrd-file-existing" class="mt-2 d-none">
                            <small class="text-muted"><i class="bi bi-file-earmark-pdf text-danger me-1"></i>File piagam saat ini tersimpan. Upload baru untuk mengganti.</small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="modal-footer border-0 px-4 pb-4 pt-2 bg-white d-flex justify-content-between">
                <button type="button" class="btn btn-outline-secondary fw-semibold px-4" data-bs-dismiss="modal" style="border-radius: 10px;">
                    <i class="bi bi-x-lg me-1"></i>Batal
                </button>
                <button type="button" class="btn btn-primary fw-bold px-5" id="editPenghargaanSaveBtn" onclick="submitEditPenghargaan()" style="border-radius: 10px; background: #2563eb; border: none;">
                    <i class="bi bi-check-lg me-1"></i>Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>
{{-- ============================================================= --}}

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
    .form-select, .form-control {
        transition: all 0.2s;
    }
    .form-select:focus, .form-control:focus {
        background: white !important;
        transform: translateY(-2px);
    }
</style>

<script>
    // =============================================
    // HELPER: Ambil CSRF token
    // =============================================
    function getPenghargaanCsrfToken() {
        var metaTag = document.querySelector('meta[name="csrf-token"]');
        if (metaTag) return metaTag.getAttribute('content');
        var match = document.cookie.match(/XSRF-TOKEN=([^;]+)/);
        if (match) return decodeURIComponent(match[1]);
        return '';
    }

    // =============================================
    // BUKA MODAL EDIT PENGHARGAAN (pre-fill data lama)
    // =============================================
    function openEditPenghargaanModal(id, nama, tahun, instansi) {
        // Reset file input
        document.getElementById('edit-awrd-file').value            = '';
        document.getElementById('edit-awrd-file-label').textContent = 'Upload Piagam / Dokumen Penghargaan (PDF, maks 1 MB)';

        // Isi semua field dengan data lama
        document.getElementById('edit-awrd-id').value       = id;
        document.getElementById('edit-awrd-nama').value     = nama;
        document.getElementById('edit-awrd-tahun').value    = tahun;
        document.getElementById('edit-awrd-instansi').value = instansi;

        // Tampilkan info file lama jika ada
        var fileLink         = document.getElementById('awrd-file-link-' + id);
        var existingFileInfo = document.getElementById('edit-awrd-file-existing');
        if (fileLink) {
            existingFileInfo.classList.remove('d-none');
        } else {
            existingFileInfo.classList.add('d-none');
        }

        // Buka modal
        var modal = new bootstrap.Modal(document.getElementById('editPenghargaanModal'));
        modal.show();
    }

    // =============================================
    // HANDLER PERUBAHAN FILE
    // =============================================
    function editPenghargaanFileChange(input) {
        var label = document.getElementById('edit-awrd-file-label');
        if (input.files && input.files[0]) {
            label.textContent = input.files[0].name;
        } else {
            label.textContent = 'Upload Piagam / Dokumen Penghargaan (PDF, maks 1 MB)';
        }
    }

    // =============================================
    // SUBMIT EDIT PENGHARGAAN → UPDATE DATABASE
    // =============================================
    function submitEditPenghargaan() {
        var btn      = document.getElementById('editPenghargaanSaveBtn');
        var origHtml = btn.innerHTML;

        try {
            var id        = document.getElementById('edit-awrd-id').value;
            var nama      = document.getElementById('edit-awrd-nama').value.trim();
            var tahun     = document.getElementById('edit-awrd-tahun').value;
            var instansi  = document.getElementById('edit-awrd-instansi').value.trim();
            var fileInput = document.getElementById('edit-awrd-file');
            var csrfToken = getPenghargaanCsrfToken();
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
                Swal.fire('Perhatian', 'Nama penghargaan tidak boleh kosong.', 'warning');
            } else {
                alert('Nama penghargaan tidak boleh kosong.');
            }
            return;
        }

        // Aktifkan spinner
        btn.disabled  = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...';

        // Siapkan FormData (multipart agar mendukung upload file)
        var formData = new FormData();
        formData.append('nama_penghargaan', nama);
        formData.append('tahun',            tahun);
        formData.append('instansi_pemberi', instansi);
        if (fileInput.files[0]) {
            formData.append('file', fileInput.files[0]);
        }

        // Kirim ke endpoint POST /update
        fetch('/profile/drh/penghargaan/' + id + '/update', {
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
                var dispNama     = document.getElementById('awrd-disp-nama-'     + id);
                var dispTahun    = document.getElementById('awrd-disp-tahun-'    + id);
                var dispInstansi = document.getElementById('awrd-disp-instansi-' + id);

                if (dispNama)     dispNama.textContent     = nama     || '-';
                if (dispTahun)    dispTahun.textContent    = tahun    || '-';
                if (dispInstansi) dispInstansi.textContent = instansi || '-';

                // Update link file jika ada file baru yang diupload
                if (data.data && data.data.file_url) {
                    var link = document.getElementById('awrd-file-link-' + id);
                    if (link) {
                        link.href = data.data.file_url;
                    } else {
                        // Buat link baru jika sebelumnya tidak ada file
                        var tdAksi = document.querySelector('#awrd-view-' + id + ' td:last-child .d-flex');
                        if (tdAksi) {
                            var newLink = document.createElement('a');
                            newLink.href      = data.data.file_url;
                            newLink.target    = '_blank';
                            newLink.id        = 'awrd-file-link-' + id;
                            newLink.className = 'btn btn-sm btn-outline-primary';
                            newLink.title     = 'Lihat File';
                            newLink.style     = 'border-radius:8px;width:34px;height:34px;display:inline-flex;align-items:center;justify-content:center;';
                            newLink.innerHTML = '<i class="bi bi-file-earmark-pdf"></i>';
                            tdAksi.insertBefore(newLink, tdAksi.firstChild);
                        }
                    }
                }

                // Tutup modal
                bootstrap.Modal.getInstance(document.getElementById('editPenghargaanModal')).hide();

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
    // FUNGSI GENERIK toggle edit row
    // =============================================
    function toggleEditRow(prefix, id) {
        var viewRow = document.getElementById(prefix + '-view-' + id);
        var editRow = document.getElementById(prefix + '-edit-' + id);
        if (!viewRow || !editRow) return;
        viewRow.classList.toggle('d-none');
        editRow.classList.toggle('d-none');
    }

    // =============================================
    // HAPUS DATA PENGHARGAAN (AJAX DELETE)
    // =============================================
    function deletePenghargaanRow(btn, id) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: 'Data penghargaan yang dihapus tidak bisa dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d32f2f',
                cancelButtonColor: '#757575',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal',
                allowOutsideClick: false,
                allowEscapeKey: true
            }).then(function(result) {
                if (result.isConfirmed) {
                    if (id) {
                        fetch('/profile/drh/penghargaan/' + id, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': getPenghargaanCsrfToken(),
                                'Accept': 'application/json'
                            }
                        })
                        .then(function(res) { return res.json(); })
                        .then(function(data) {
                            if (data.status === 'success') {
                                Swal.fire('Berhasil', data.message, 'success');
                                btn.closest('.sub-card').remove();
                            } else {
                                Swal.fire('Gagal', data.message, 'error');
                            }
                        })
                        .catch(function() { Swal.fire('Gagal', 'Terjadi kesalahan.', 'error'); });
                    } else {
                        btn.closest('.sub-card').remove();
                    }
                }
            });
        } else {
            if (confirm('Apakah Anda yakin ingin menghapus data penghargaan?')) {
                if (id) {
                    fetch('/profile/drh/penghargaan/' + id, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': getPenghargaanCsrfToken(),
                            'Accept': 'application/json'
                        }
                    })
                    .then(function(res) { return res.json(); })
                    .then(function(data) {
                        if (data.status === 'success') {
                            if (typeof showToast === 'function') showToast(data.message, 'success');
                            btn.closest('.sub-card').remove();
                        } else {
                            if (typeof showToast === 'function') showToast(data.message, 'error');
                        }
                    })
                    .catch(function() {
                        if (typeof showToast === 'function') showToast('Terjadi kesalahan.', 'error');
                    });
                } else {
                    btn.closest('.sub-card').remove();
                }
            }
        }
    }
</script>

