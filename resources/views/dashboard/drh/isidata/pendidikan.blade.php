<div class="card section-card border-0 shadow-sm overflow-hidden" style="border-radius: 24px;">
@php $isLocked = $isLockedPendidikan ?? ($drhData?->is_locked_pendidikan ?? false); @endphp
    <div class="section-header d-flex align-items-center justify-content-between gap-3 p-4" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white;">
        <div class="d-flex align-items-center gap-3">
            <div class="icon-box shadow-sm" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(4px); border-radius: 14px; width: 48px; height: 48px; display: grid; place-items: center;">
                <i class="bi bi-mortarboard-fill fs-4"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-0" style="letter-spacing: 0.5px;">C. Riwayat Pendidikan @if($isLocked)<span class="badge ms-2" style="background:rgba(255,255,255,0.2);font-size:11px;"><i class="bi bi-lock-fill me-1"></i>Terkunci</span>@endif</h5>
                <small class="opacity-75">Riwayat pendidikan formal dari jenjang SD hingga S3</small>
            </div>
        </div>
        <button type="button" class="btn btn-white btn-sm fw-bold rounded-pill px-3 shadow-sm" onclick="addPendidikan()" style="background: white; color: #2563eb; border: none; transition: all 0.3s ease;">
            <i class="bi bi-plus-lg me-1"></i> Tambah Data
        </button>
    </div>

    <div class="card-body p-4 p-lg-5 bg-white" id="pendidikanContainer">
        @if(count($pendidikanRows) > 0)
            {{-- Hidden inputs to preserve existing row data on form submit --}}
            <div class="d-none">
                @foreach($pendidikanRows as $index => $pendidikan)
                    @if(!empty($pendidikan['id']))
                        <input type="hidden" name="pendidikan[{{ $index }}][id]" value="{{ $pendidikan['id'] }}">
                    @endif
                    <input type="hidden" name="pendidikan[{{ $index }}][jenjang]" value="{{ $pendidikan['jenjang'] ?? '' }}">
                    <input type="hidden" name="pendidikan[{{ $index }}][nama_sekolah]" value="{{ $pendidikan['nama_sekolah'] ?? '' }}">
                    <input type="hidden" name="pendidikan[{{ $index }}][tahun_masuk]" value="{{ $pendidikan['tahun_masuk'] ?? '' }}">
                    <input type="hidden" name="pendidikan[{{ $index }}][tahun_lulus]" value="{{ $pendidikan['tahun_lulus'] ?? '' }}">
                    <input type="hidden" name="pendidikan[{{ $index }}][nomor_ijazah]" value="{{ $pendidikan['nomor_ijazah'] ?? '' }}">
                    <input type="hidden" name="pendidikan[{{ $index }}][nama_pejabat]" value="{{ $pendidikan['nama_pejabat'] ?? '' }}">
                    @if(!empty($pendidikan['file']))
                        <input type="hidden" name="pendidikan[{{ $index }}][old_file]" value="{{ $pendidikan['file'] }}">
                    @endif
                @endforeach
            </div>
            <div class="table-responsive">
                <table class="table drh-subtable mb-3">
                    <thead>
                        <tr>
                            <th>Jenjang</th>
                            <th>Nama Institusi</th>
                            <th>Tahun Masuk</th>
                            <th>Tahun Lulus</th>
                            <th>No. Ijazah</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendidikanRows as $index => $pendidikan)
                        {{-- Baris Tampil --}}
                        <tr id="pend-view-{{ $pendidikan['id'] }}">
                            <td><span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill" id="pend-disp-jenjang-{{ $pendidikan['id'] }}">{{ $pendidikan['jenjang'] ?? '-' }}</span></td>
                            <td class="fw-bold text-dark" id="pend-disp-nama-{{ $pendidikan['id'] }}">{{ $pendidikan['nama_sekolah'] ?? '-' }}</td>
                            <td id="pend-disp-masuk-{{ $pendidikan['id'] }}">{{ $pendidikan['tahun_masuk'] ?? '-' }}</td>
                            <td id="pend-disp-lulus-{{ $pendidikan['id'] }}">{{ $pendidikan['tahun_lulus'] ?? '-' }}</td>
                            <td class="text-muted small" id="pend-disp-ijazah-{{ $pendidikan['id'] }}">{{ $pendidikan['nomor_ijazah'] ?? '-' }}</td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    @if(!empty($pendidikan['file']))
                                    <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($pendidikan['file']) }}" target="_blank" class="btn btn-sm btn-outline-primary" id="pend-file-link-{{ $pendidikan['id'] }}" title="Lihat File" style="border-radius:8px;width:34px;height:34px;display:inline-flex;align-items:center;justify-content:center;">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                    </a>
                                    @endif
                                    @if(!empty($pendidikan['id']))
                                    <button type="button" class="btn btn-sm btn-warning pend-edit-btn" title="Edit" style="border-radius:8px;width:34px;height:34px;display:inline-flex;align-items:center;justify-content:center;"
                                        @disabled($isLockedPendidikan ?? false)
                                        onclick="openEditPendidikanModal(
                                            {{ $pendidikan['id'] }},
                                            '{{ addslashes($pendidikan['jenjang'] ?? '') }}',
                                            '{{ addslashes($pendidikan['nama_sekolah'] ?? '') }}',
                                            '{{ $pendidikan['tahun_masuk'] ?? '' }}',
                                            '{{ $pendidikan['tahun_lulus'] ?? '' }}',
                                            '{{ addslashes($pendidikan['nomor_ijazah'] ?? '') }}',
                                            '{{ addslashes($pendidikan['nama_pejabat'] ?? '') }}'
                                        )">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger pend-hapus-btn" title="Hapus" style="border-radius:8px;width:34px;height:34px;display:inline-flex;align-items:center;justify-content:center;"
                                        @disabled($isLockedPendidikan ?? false)
                                        onclick="deleteDrhSavedRow('/profile/drh/pendidikan/{{ $pendidikan['id'] }}', this)">
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
            <div id="emptyPendidikan" class="text-center py-5 border-2 border-dashed rounded-4" style="background: #fafafa; border-color: #e2e8f0;">
                <div class="mb-3">
                    <i class="bi bi-mortarboard opacity-25" style="font-size: 4rem;"></i>
                </div>
                <h6 class="text-muted fw-bold">Belum ada riwayat pendidikan</h6>
                <p class="small text-muted mb-3">Klik tombol "Tambah Data" untuk mulai mengisi.</p>
                <button type="button" class="btn btn-primary btn-sm rounded-pill px-4" onclick="addPendidikan()">Tambah Sekarang</button>
            </div>
        @endif
    </div>

    <div class="card-body p-4 p-lg-5 pt-0 d-flex justify-content-end">
        <button type="button" class="btn btn-primary btn-lg fw-bold px-5 py-3 shadow" onclick="saveSectionData(3)" style="border-radius: 16px; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); background: #2563eb; border: none;">
            <i class="bi bi-cloud-arrow-up-fill me-2"></i> Simpan Riwayat Pendidikan
        </button>
    </div>
</div>

{{-- ===================== MODAL EDIT PENDIDIKAN ===================== --}}
<div class="modal fade" id="editPendidikanModal" tabindex="-1" aria-labelledby="editPendidikanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            {{-- Header --}}
            <div class="modal-header border-0 px-4 py-3" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);">
                <h5 class="modal-title fw-bold text-white" id="editPendidikanModalLabel">
                    <i class="bi bi-pencil-square me-2"></i>Edit Data Riwayat Pendidikan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body p-4" style="background: #f8fafc;">
                <div class="card border-0 shadow-sm p-4" style="border-radius: 16px; background: white;">
                    <input type="hidden" id="edit-pend-id">

                    {{-- Row 1: Jenjang & Nama Institusi --}}
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-4">
                            <label class="form-label">JENJANG PENDIDIKAN</label>
                            <select class="form-select" id="edit-pend-jenjang">
                                <option value="">Pilih Jenjang</option>
                                @if(isset($pendidikanList) && count($pendidikanList) > 0)
                                    @foreach($pendidikanList as $pendidikan)
                                        <option value="{{ $pendidikan->nama }}">{{ $pendidikan->nama }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-12 col-md-8">
                            <label class="form-label">NAMA INSTITUSI / SEKOLAH</label>
                            <input type="text" class="form-control" id="edit-pend-nama" placeholder="Nama sekolah / universitas...">
                        </div>
                    </div>

                    {{-- Row 2: Tahun Masuk & Tahun Lulus --}}
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label">TAHUN MASUK</label>
                            <input type="number" class="form-control" id="edit-pend-masuk" placeholder="Contoh: 2000" min="1900" max="2099">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">TAHUN LULUS</label>
                            <input type="number" class="form-control" id="edit-pend-lulus" placeholder="Contoh: 2004" min="1900" max="2099">
                        </div>
                    </div>

                    {{-- Row 3: No. Ijazah & Nama Pejabat --}}
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label">NO. IJAZAH</label>
                            <input type="text" class="form-control" id="edit-pend-ijazah" placeholder="Nomor ijazah...">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">NAMA PEJABAT PENANDA TANGAN</label>
                            <input type="text" class="form-control" id="edit-pend-pejabat" placeholder="Nama pejabat...">
                        </div>
                    </div>

                    {{-- Upload File --}}
                    <div class="mb-1">
                        <label class="form-label">UPLOAD IJAZAH / DOKUMEN PENDIDIKAN</label>
                        <div class="upload-box border-2 border-dashed rounded-3 text-center py-3 px-3" style="border-color: #cbd5e1; cursor: pointer; transition: all 0.2s;" onclick="document.getElementById('edit-pend-file').click()">
                            <i class="bi bi-cloud-upload text-primary fs-4 mb-1 d-block"></i>
                            <span class="text-primary small fw-semibold" id="edit-pend-file-label">Upload Dokumen Pendidikan (PDF, maks 1 MB)</span>
                            <input type="file" id="edit-pend-file" accept=".pdf" class="d-none" onchange="editPendidikanFileChange(this)">
                        </div>
                        <div id="edit-pend-file-existing" class="mt-2 d-none">
                            <small class="text-muted"><i class="bi bi-file-earmark-pdf text-danger me-1"></i>File dokumen saat ini tersimpan. Upload baru untuk mengganti.</small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="modal-footer border-0 px-4 pb-4 pt-2 bg-white d-flex justify-content-between">
                <button type="button" class="btn btn-outline-secondary fw-semibold px-4" data-bs-dismiss="modal" style="border-radius: 10px;">
                    <i class="bi bi-x-lg me-1"></i>Batal
                </button>
                <button type="button" class="btn btn-primary fw-bold px-5" id="editPendidikanSaveBtn" onclick="submitEditPendidikan()" style="border-radius: 10px; background: #2563eb; border: none;">
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
    .btn-white:hover {
        background: #f8fafc !important;
        transform: scale(1.05);
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
    function getPendidikanCsrfToken() {
        var metaTag = document.querySelector('meta[name="csrf-token"]');
        if (metaTag) return metaTag.getAttribute('content');
        var match = document.cookie.match(/XSRF-TOKEN=([^;]+)/);
        if (match) return decodeURIComponent(match[1]);
        return '';
    }

    // =============================================
    // BUKA MODAL EDIT PENDIDIKAN (pre-fill data lama)
    // =============================================
    function openEditPendidikanModal(id, jenjang, nama, tahunMasuk, tahunLulus, nomorIjazah, namaPejabat) {
        // Reset file input
        document.getElementById('edit-pend-file').value = '';
        document.getElementById('edit-pend-file-label').textContent = 'Upload Dokumen Pendidikan (PDF, maks 1 MB)';

        // Isi field dengan data lama
        document.getElementById('edit-pend-id').value      = id;
        document.getElementById('edit-pend-nama').value    = nama;
        document.getElementById('edit-pend-masuk').value   = tahunMasuk;
        document.getElementById('edit-pend-lulus').value   = tahunLulus;
        document.getElementById('edit-pend-ijazah').value  = nomorIjazah;
        document.getElementById('edit-pend-pejabat').value = namaPejabat;

        // Set jenjang dropdown
        var jenjangSelect = document.getElementById('edit-pend-jenjang');
        jenjangSelect.value = jenjang;

        // Tampilkan info file lama jika ada
        var fileLink = document.getElementById('pend-file-link-' + id);
        var existingFileInfo = document.getElementById('edit-pend-file-existing');
        if (fileLink) {
            existingFileInfo.classList.remove('d-none');
        } else {
            existingFileInfo.classList.add('d-none');
        }

        // Buka modal
        var modal = new bootstrap.Modal(document.getElementById('editPendidikanModal'));
        modal.show();
    }

    // =============================================
    // HANDLER PERUBAHAN FILE
    // =============================================
    function editPendidikanFileChange(input) {
        var label = document.getElementById('edit-pend-file-label');
        if (input.files && input.files[0]) {
            label.textContent = input.files[0].name;
        } else {
            label.textContent = 'Upload Dokumen Pendidikan (PDF, maks 1 MB)';
        }
    }

    // =============================================
    // SUBMIT EDIT PENDIDIKAN → UPDATE DATABASE
    // =============================================
    function submitEditPendidikan() {
        var btn      = document.getElementById('editPendidikanSaveBtn');
        var origHtml = btn.innerHTML;

        // Ambil semua nilai dari form
        try {
            var id         = document.getElementById('edit-pend-id').value;
            var jenjang    = document.getElementById('edit-pend-jenjang').value;
            var nama       = document.getElementById('edit-pend-nama').value.trim();
            var masuk      = document.getElementById('edit-pend-masuk').value;
            var lulus      = document.getElementById('edit-pend-lulus').value;
            var ijazah     = document.getElementById('edit-pend-ijazah').value.trim();
            var pejabat    = document.getElementById('edit-pend-pejabat').value.trim();
            var fileInput  = document.getElementById('edit-pend-file');
            var csrfToken  = getPendidikanCsrfToken();
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
                Swal.fire('Perhatian', 'Nama institusi tidak boleh kosong.', 'warning');
            } else {
                alert('Nama institusi tidak boleh kosong.');
            }
            return;
        }

        // Aktifkan spinner
        btn.disabled  = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...';

        // Siapkan FormData (multipart agar mendukung upload file)
        var formData = new FormData();
        formData.append('jenjang',       jenjang);
            formData.append('nama_instansi', nama);
            formData.append('tahun_masuk',   masuk);
            formData.append('tahun_keluar',  lulus);
            formData.append('no_ijazah',     ijazah);
            formData.append('nama_pejabat',  pejabat);
        if (fileInput.files[0]) {
            formData.append('file', fileInput.files[0]);
        }

        // Kirim ke endpoint POST khusus update (karena FormData multipart
        // tidak membaca _method=PUT di Laravel, gunakan route POST /update)
        fetch('/profile/drh/pendidikan/' + id + '/update', {
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
                var dispJenjang = document.getElementById('pend-disp-jenjang-' + id);
                var dispNama    = document.getElementById('pend-disp-nama-'    + id);
                var dispMasuk   = document.getElementById('pend-disp-masuk-'   + id);
                var dispLulus   = document.getElementById('pend-disp-lulus-'   + id);
                var dispIjazah  = document.getElementById('pend-disp-ijazah-'  + id);

                if (dispJenjang) dispJenjang.textContent = jenjang || '-';
                if (dispNama)    dispNama.textContent    = nama    || '-';
                if (dispMasuk)   dispMasuk.textContent   = masuk   || '-';
                if (dispLulus)   dispLulus.textContent   = lulus   || '-';
                if (dispIjazah)  dispIjazah.textContent  = ijazah  || '-';

                // Update link file jika ada file baru yang diupload
                if (data.data && data.data.file_url) {
                    var link = document.getElementById('pend-file-link-' + id);
                    if (link) {
                        link.href = data.data.file_url;
                    } else {
                        // Buat link baru jika sebelumnya tidak ada file
                        var tdAksi = document.querySelector('#pend-view-' + id + ' td:last-child .d-flex');
                        if (tdAksi) {
                            var newLink = document.createElement('a');
                            newLink.href      = data.data.file_url;
                            newLink.target    = '_blank';
                            newLink.id        = 'pend-file-link-' + id;
                            newLink.className = 'btn btn-sm btn-outline-primary';
                            newLink.title     = 'Lihat File';
                            newLink.style     = 'border-radius:8px;width:34px;height:34px;display:inline-flex;align-items:center;justify-content:center;';
                            newLink.innerHTML = '<i class="bi bi-file-earmark-pdf"></i>';
                            tdAksi.insertBefore(newLink, tdAksi.firstChild);
                        }
                    }
                }

                // Tutup modal
                bootstrap.Modal.getInstance(document.getElementById('editPendidikanModal')).hide();

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
    // FUNGSI GENERIK toggle edit row (inline fallback)
    // =============================================
    function toggleEditRow(prefix, id) {
        var viewRow = document.getElementById(prefix + '-view-' + id);
        var editRow = document.getElementById(prefix + '-edit-' + id);
        if (!viewRow || !editRow) return;
        viewRow.classList.toggle('d-none');
        editRow.classList.toggle('d-none');
    }

    // =============================================
    // HAPUS DATA PENDIDIKAN (AJAX DELETE)
    // =============================================
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
            }).then(function(result) {
                if (result.isConfirmed) {
                    fetch('/profile/drh/pendidikan/' + id, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': getPendidikanCsrfToken(),
                            'Accept': 'application/json'
                        }
                    })
                    .then(function(res) { return res.json(); })
                    .then(function(data) {
                        if (data.status === 'success') {
                            Swal.fire('Berhasil', data.message, 'success');
                            btn.closest('.sub-card').remove();
                        } else {
                            Swal.fire('Gagal', data.message || 'Gagal menghapus data.', 'error');
                        }
                    })
                    .catch(function() { Swal.fire('Gagal', 'Terjadi kesalahan.', 'error'); });
                }
            });
        } else {
            if (confirm('Apakah Anda yakin ingin menghapus data pendidikan ini?')) {
                fetch('/profile/drh/pendidikan/' + id, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': getPendidikanCsrfToken(),
                        'Accept': 'application/json'
                    }
                })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    if (data.status === 'success') {
                        if (typeof showToast === 'function') showToast(data.message, 'success');
                        btn.closest('.sub-card').remove();
                    } else {
                        if (typeof showToast === 'function') showToast(data.message || 'Gagal menghapus data.', 'error');
                    }
                })
                .catch(function() {
                    if (typeof showToast === 'function') showToast('Terjadi kesalahan.', 'error');
                });
            }
        }
    }
</script>

