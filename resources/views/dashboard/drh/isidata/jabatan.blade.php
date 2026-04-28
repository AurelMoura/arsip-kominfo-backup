<div class="card section-card border-0 shadow-sm overflow-hidden" style="border-radius: 24px;">
@php $isLocked = $isLockedJabatan ?? ($drhData?->is_locked_jabatan ?? false); @endphp
    <div class="section-header d-flex align-items-center justify-content-between gap-3 p-4" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white;">
        <div class="d-flex align-items-center gap-3">
            <div class="icon-box shadow-sm" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(4px); border-radius: 14px; width: 48px; height: 48px; display: grid; place-items: center;">
                <i class="bi bi-briefcase-fill fs-4"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-0" style="letter-spacing: 0.5px;">E. Riwayat Jabatan @if($isLocked)<span class="badge ms-2" style="background:rgba(255,255,255,0.2);font-size:11px;"><i class="bi bi-lock-fill me-1"></i>Terkunci</span>@endif</h5>
                <small class="opacity-75">Riwayat jabatan dan kepangkatan selama berkarir</small>
            </div>
        </div>
        <button type="button" class="btn btn-white btn-sm fw-bold rounded-pill px-3 shadow-sm" onclick="addJabatan()" style="background: white; color: #2563eb; border: none; transition: all 0.3s ease;">
            <i class="bi bi-plus-lg me-1"></i> Tambah Jabatan
        </button>
    </div>

    <div class="card-body p-4 p-lg-5 bg-white" id="jabatanContainer">
        @if(count($jabatanRows) > 0)
            {{-- Hidden inputs to preserve existing row data on form submit --}}
            <div class="d-none">
                @foreach($jabatanRows as $index => $jabatan)
                    @if(!empty($jabatan['id']))
                        <input type="hidden" name="riwayat_jabatan[{{ $index }}][id]" value="{{ $jabatan['id'] }}">
                    @endif
                    <input type="hidden" name="riwayat_jabatan[{{ $index }}][jenis_jabatan]" value="{{ $jabatan['jenis_jabatan'] ?? '' }}">
                    <input type="hidden" name="riwayat_jabatan[{{ $index }}][eselon]" value="{{ $jabatan['eselon'] ?? '' }}">
                    <input type="hidden" name="riwayat_jabatan[{{ $index }}][nama_jabatan]" value="{{ $jabatan['nama_jabatan'] ?? '' }}">
                    <input type="hidden" name="riwayat_jabatan[{{ $index }}][no_sk]" value="{{ $jabatan['no_sk'] ?? '' }}">
                    <input type="hidden" name="riwayat_jabatan[{{ $index }}][tmt]" value="{{ $jabatan['tmt'] ?? '' }}">
                    @if(!empty($jabatan['file']))
                        <input type="hidden" name="riwayat_jabatan[{{ $index }}][old_file]" value="{{ $jabatan['file'] }}">
                    @endif
                @endforeach
            </div>
            <div class="table-responsive">
                <table class="table drh-subtable mb-3">
                    <thead>
                        <tr>
                            <th>Jenis Jabatan</th>
                            <th>Nama Jabatan</th>
                            <th>Eselon</th>
                            <th>TMT</th>
                            <th>No. SK</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jabatanRows as $index => $jabatan)
                        {{-- Baris Tampil --}}
                        <tr id="jab-view-{{ $jabatan['id'] }}">
                            <td><span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill" id="jab-disp-jenis-{{ $jabatan['id'] }}">{{ $jabatan['jenis_jabatan'] ?: '-' }}</span></td>
                            <td class="fw-bold text-dark" id="jab-disp-nama-{{ $jabatan['id'] }}">{{ $jabatan['nama_jabatan'] ?? '-' }}</td>
                            <td id="jab-disp-eselon-{{ $jabatan['id'] }}">{{ $jabatan['eselon'] ?: '-' }}</td>
                            <td id="jab-disp-tmt-{{ $jabatan['id'] }}">{{ $jabatan['tmt'] ?? '-' }}</td>
                            <td class="text-muted small" id="jab-disp-no_sk-{{ $jabatan['id'] }}">{{ $jabatan['no_sk'] ?? '-' }}</td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    @if(!empty($jabatan['file']))
                                    <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($jabatan['file']) }}" target="_blank" class="btn btn-sm btn-outline-primary" id="jab-file-link-{{ $jabatan['id'] }}" title="Lihat File SK" style="border-radius:8px;width:34px;height:34px;display:inline-flex;align-items:center;justify-content:center;">
                                        <i class="bi bi-file-earmark-pdf"></i>
                                    </a>
                                    @endif
                                    @if(!empty($jabatan['id']))
                                    <button type="button" class="btn btn-sm btn-warning jab-edit-btn" title="Edit" style="border-radius:8px;width:34px;height:34px;display:inline-flex;align-items:center;justify-content:center;"
                                        @disabled($isLockedJabatan ?? false)
                                        onclick="openEditJabatanModal({{ $jabatan['id'] }}, '{{ addslashes($jabatan['jenis_jabatan'] ?? '') }}', '{{ addslashes($jabatan['eselon'] ?? '') }}', '{{ addslashes($jabatan['nama_jabatan'] ?? '') }}', '{{ addslashes($jabatan['no_sk'] ?? '') }}', '{{ $jabatan['tmt'] ?? '' }}')">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger jab-hapus-btn" title="Hapus" style="border-radius:8px;width:34px;height:34px;display:inline-flex;align-items:center;justify-content:center;"
                                        @disabled($isLockedJabatan ?? false)
                                        onclick="deleteDrhSavedRow('/profile/drh/jabatan/{{ $jabatan['id'] }}', this)">
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
            <div id="emptyJabatan" class="text-center py-5 border-2 border-dashed rounded-4" style="background: #fafafa; border-color: #e2e8f0;">
                <div class="mb-3">
                    <i class="bi bi-briefcase opacity-25" style="font-size: 4rem;"></i>
                </div>
                <h6 class="text-muted fw-bold">Belum ada riwayat jabatan</h6>
                <p class="small text-muted mb-3">Klik tombol "Tambah Jabatan" untuk mencatat perjalanan karir Anda.</p>
                <button type="button" class="btn btn-primary btn-sm rounded-pill px-4" onclick="addJabatan()">Tambah Sekarang</button>
            </div>
        @endif
    </div>

    <div class="card-body p-4 p-lg-5 pt-0 d-flex justify-content-end border-top mt-2">
        <button type="button" class="btn btn-primary btn-lg fw-bold px-5 py-3 shadow mt-4" onclick="saveSectionData(1)" style="border-radius: 16px; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); background: #2563eb; border: none;">
            <i class="bi bi-cloud-arrow-up-fill me-2"></i> Simpan Riwayat Jabatan
        </button>
    </div>
</div>

{{-- ===================== MODAL EDIT JABATAN ===================== --}}
<div class="modal fade" id="editJabatanModal" tabindex="-1" aria-labelledby="editJabatanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            {{-- Header --}}
            <div class="modal-header border-0 px-4 py-3" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);">
                <h5 class="modal-title fw-bold text-white" id="editJabatanModalLabel">
                    <i class="bi bi-pencil-square me-2"></i>Edit Data Riwayat Jabatan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body p-4" style="background: #f8fafc;">
                <div class="card border-0 shadow-sm p-4" style="border-radius: 16px; background: white;">
                    <input type="hidden" id="edit-jab-id">

                    {{-- Row 1: Jenis, Eselon, Nama --}}
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-4">
                            <label class="form-label">JENIS JABATAN</label>
                            <select class="form-select" id="edit-jab-jenis" onchange="editModalOnJenisChange()">
                                <option value="">Pilih Jenis Jabatan</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label">ESELON</label>
                            <select class="form-select" id="edit-jab-eselon" onchange="editModalOnEselonChange()" disabled>
                                <option value="">Pilih Eselon</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label">NAMA JABATAN</label>
                            <select class="form-select" id="edit-jab-nama" disabled>
                                <option value="">Pilih Nama Jabatan</option>
                            </select>
                        </div>
                    </div>

                    {{-- Row 2: No SK & TMT --}}
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label">NO. SK</label>
                            <input type="text" class="form-control" id="edit-jab-no_sk" placeholder="Nomor SK...">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">TMT</label>
                            <input type="date" class="form-control" id="edit-jab-tmt">
                        </div>
                    </div>

                    {{-- Upload File --}}
                    <div class="mb-1">
                        <label class="form-label">UPLOAD SK JABATAN</label>
                        <div class="upload-box border-2 border-dashed rounded-3 text-center py-3 px-3" style="border-color: #cbd5e1; cursor: pointer; transition: all 0.2s;" onclick="document.getElementById('edit-jab-file').click()">
                            <i class="bi bi-cloud-upload text-primary fs-4 mb-1 d-block"></i>
                            <span class="text-primary small fw-semibold" id="edit-jab-file-label">Upload SK Jabatan (PDF, maks 1 MB)</span>
                            <input type="file" id="edit-jab-file" accept=".pdf" class="d-none" onchange="editModalFileChange(this)">
                        </div>
                        <div id="edit-jab-file-existing" class="mt-2 d-none">
                            <small class="text-muted"><i class="bi bi-file-earmark-pdf text-danger me-1"></i>File SK saat ini tersimpan. Upload baru untuk mengganti.</small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="modal-footer border-0 px-4 pb-4 pt-2 bg-white d-flex justify-content-between">
                <button type="button" class="btn btn-outline-secondary fw-semibold px-4" data-bs-dismiss="modal" style="border-radius: 10px;">
                    <i class="bi bi-x-lg me-1"></i>Batal
                </button>
                <button type="button" class="btn btn-primary fw-bold px-5" id="editJabatanSaveBtn" onclick="submitEditJabatan()" style="border-radius: 10px; background: #2563eb; border: none;">
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
</style>

<script>
    // =============================================
    // HELPER: Ambil CSRF token (meta tag atau cookie)
    // =============================================
    function getCsrfToken() {
        // Prioritas 1: meta tag (standar Laravel)
        var metaTag = document.querySelector('meta[name="csrf-token"]');
        if (metaTag) return metaTag.getAttribute('content');

        // Prioritas 2: cookie XSRF-TOKEN (fallback)
        var match = document.cookie.match(/XSRF-TOKEN=([^;]+)/);
        if (match) return decodeURIComponent(match[1]);

        // Tidak ditemukan — kembalikan string kosong agar fetch tetap jalan
        // (server akan tolak dengan 419, tertangkap di .catch)
        return '';
    }

    // =============================================
    // FUNGSI ASLI (tidak diubah)
    // =============================================
    function rjOnJenisChange(jenisSelect, isRestore) {
        const card = jenisSelect.closest('.sub-card') || jenisSelect.closest('.row');
        const eselonSelect = card.querySelector('.rj-eselon');
        const namaSelect = card.querySelector('.rj-nama');
        const jenisHidden = card.querySelector('.rj-jenis-hidden');

        if (jenisHidden) jenisHidden.value = jenisSelect.value;

        eselonSelect.innerHTML = '<option value="">Pilih Eselon</option>';
        eselonSelect.disabled = true;
        namaSelect.innerHTML = '<option value="">Pilih Nama Jabatan</option>';
        namaSelect.disabled = true;

        const jenis = jenisSelect.value;
        if (!jenis) return;

        fetch(`/api/jabatan/eselon/${encodeURIComponent(jenis)}`)
            .then(r => r.json())
            .then(eselons => {
                if (eselons.length === 0) {
                    eselonSelect.innerHTML = '<option value="" selected>— Tanpa Eselon —</option>';
                    eselonSelect.disabled = true;
                    const eselonHidden = card.querySelector('.rj-eselon-hidden');
                    if (eselonHidden) eselonHidden.value = '';
                    rjLoadNamaJabatan(card, jenis, null, isRestore);
                } else {
                    eselons.forEach(e => {
                        const opt = document.createElement('option');
                        opt.value = e;
                        opt.textContent = e;
                        eselonSelect.appendChild(opt);
                    });
                    eselonSelect.disabled = false;

                    if (isRestore) {
                        const savedEselon = card.querySelector('.rj-saved-eselon')?.value || '';
                        if (savedEselon) {
                            eselonSelect.value = savedEselon;
                            if (eselonSelect.value === savedEselon) {
                                rjOnEselonChange(eselonSelect, true);
                            }
                        }
                    }
                }
            });
    }

    function rjOnEselonChange(eselonSelect, isRestore) {
        const card = eselonSelect.closest('.sub-card') || eselonSelect.closest('.row');
        const jenisSelect = card.querySelector('.rj-jenis');
        const namaSelect = card.querySelector('.rj-nama');
        const eselonHidden = card.querySelector('.rj-eselon-hidden');

        if (eselonHidden) eselonHidden.value = eselonSelect.value;

        namaSelect.innerHTML = '<option value="">Pilih Nama Jabatan</option>';
        namaSelect.disabled = true;

        const eselon = eselonSelect.value;
        if (!eselon) return;

        rjLoadNamaJabatan(card, jenisSelect.value, eselon, isRestore);
    }

    function rjLoadNamaJabatan(card, jenis, eselon, isRestore) {
        const namaSelect = card.querySelector('.rj-nama');
        const namaHidden = card.querySelector('.rj-nama-hidden');
        let url = `/api/jabatan/nama?jenis=${encodeURIComponent(jenis)}`;
        if (eselon) {
            url += `&eselon=${encodeURIComponent(eselon)}`;
        }

        fetch(url)
            .then(r => r.json())
            .then(jabatans => {
                jabatans.forEach(j => {
                    const opt = document.createElement('option');
                    opt.value = j.nama_jabatan;
                    opt.textContent = j.nama_jabatan;
                    namaSelect.appendChild(opt);
                });
                namaSelect.disabled = false;

                if (isRestore) {
                    const savedNama = card.querySelector('.rj-saved-nama')?.value || '';
                    if (savedNama) {
                        namaSelect.value = savedNama;
                        if (namaHidden) namaHidden.value = savedNama;
                    }
                }
            });
    }

    function deleteJabatanRow(btn, id) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: 'Data jabatan yang dihapus tidak bisa dikembalikan!',
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
                        fetch(`/profile/drh/jabatan/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': getCsrfToken(),
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
            if (confirm('Apakah Anda yakin ingin menghapus data jabatan? Data yang sudah dihapus tidak bisa dikembalikan.')) {
                if (id) {
                    fetch(`/profile/drh/jabatan/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': getCsrfToken(),
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            showToast(data.message, 'success');
                            btn.closest('.sub-card').remove();
                        } else {
                            showToast(data.message, 'error');
                        }
                    })
                    .catch(() => showToast('Terjadi kesalahan.', 'error'));
                } else {
                    btn.closest('.sub-card').remove();
                }
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.rj-jenis').forEach(function(jenisSelect) {
            if (jenisSelect.value) {
                rjOnJenisChange(jenisSelect, true);
            }
        });
    });
</script>

<script>
    // =============================================
    // FUNGSI GENERIK (tidak diubah)
    // =============================================
    function toggleEditRow(prefix, id) {
        const viewRow = document.getElementById(prefix + '-view-' + id);
        const editRow = document.getElementById(prefix + '-edit-' + id);
        if (!viewRow || !editRow) return;
        viewRow.classList.toggle('d-none');
        editRow.classList.toggle('d-none');
    }

    // =============================================
    // FUNGSI MODAL EDIT JABATAN
    // =============================================

    let _editModalRestoreEselon = '';
    let _editModalRestoreNama   = '';

    function openEditJabatanModal(id, jenis, eselon, nama, no_sk, tmt) {
        document.getElementById('edit-jab-file').value       = '';
        document.getElementById('edit-jab-file-label').textContent = 'Upload SK Jabatan (PDF, maks 1 MB)';

        document.getElementById('edit-jab-id').value    = id;
        document.getElementById('edit-jab-no_sk').value = no_sk;
        document.getElementById('edit-jab-tmt').value   = tmt;

        _editModalRestoreEselon = eselon;
        _editModalRestoreNama   = nama;

        const existingFileInfo = document.getElementById('edit-jab-file-existing');
        const fileLink = document.getElementById('jab-file-link-' + id);
        if (fileLink) {
            existingFileInfo.classList.remove('d-none');
        } else {
            existingFileInfo.classList.add('d-none');
        }

        const jenisSelect = document.getElementById('edit-jab-jenis');
        jenisSelect.innerHTML = '<option value="">Pilih Jenis Jabatan</option>';
        document.getElementById('edit-jab-eselon').innerHTML = '<option value="">Pilih Eselon</option>';
        document.getElementById('edit-jab-eselon').disabled  = true;
        document.getElementById('edit-jab-nama').innerHTML   = '<option value="">Pilih Nama Jabatan</option>';
        document.getElementById('edit-jab-nama').disabled    = true;

        fetch('/api/jabatan/jenis')
            .then(r => r.json())
            .then(jenisList => {
                jenisList.forEach(j => {
                    const opt = document.createElement('option');
                    opt.value = j;
                    opt.textContent = j;
                    jenisSelect.appendChild(opt);
                });
                if (jenis) {
                    jenisSelect.value = jenis;
                    editModalOnJenisChange(true);
                }
            })
            .catch(() => {
                const opt = document.createElement('option');
                opt.value = jenis;
                opt.textContent = jenis;
                jenisSelect.appendChild(opt);
                jenisSelect.value = jenis;
                editModalOnJenisChange(true);
            });

        const modal = new bootstrap.Modal(document.getElementById('editJabatanModal'));
        modal.show();
    }

    function editModalOnJenisChange(isRestore) {
        const jenis        = document.getElementById('edit-jab-jenis').value;
        const eselonSelect = document.getElementById('edit-jab-eselon');
        const namaSelect   = document.getElementById('edit-jab-nama');

        eselonSelect.innerHTML = '<option value="">Pilih Eselon</option>';
        eselonSelect.disabled  = true;
        namaSelect.innerHTML   = '<option value="">Pilih Nama Jabatan</option>';
        namaSelect.disabled    = true;

        if (!jenis) return;

        fetch(`/api/jabatan/eselon/${encodeURIComponent(jenis)}`)
            .then(r => r.json())
            .then(eselons => {
                if (eselons.length === 0) {
                    eselonSelect.innerHTML = '<option value="" selected>— Tanpa Eselon —</option>';
                    eselonSelect.disabled  = true;
                    editModalLoadNama(jenis, null, isRestore);
                } else {
                    eselons.forEach(e => {
                        const opt = document.createElement('option');
                        opt.value = e;
                        opt.textContent = e;
                        eselonSelect.appendChild(opt);
                    });
                    eselonSelect.disabled = false;

                    if (isRestore && _editModalRestoreEselon) {
                        eselonSelect.value = _editModalRestoreEselon;
                        if (eselonSelect.value === _editModalRestoreEselon) {
                            editModalLoadNama(jenis, _editModalRestoreEselon, isRestore);
                        }
                    }
                }
            });
    }

    function editModalOnEselonChange() {
        const jenis  = document.getElementById('edit-jab-jenis').value;
        const eselon = document.getElementById('edit-jab-eselon').value;
        editModalLoadNama(jenis, eselon, false);
    }

    function editModalLoadNama(jenis, eselon, isRestore) {
        const namaSelect = document.getElementById('edit-jab-nama');
        namaSelect.innerHTML = '<option value="">Pilih Nama Jabatan</option>';
        namaSelect.disabled  = true;

        let url = `/api/jabatan/nama?jenis=${encodeURIComponent(jenis)}`;
        if (eselon) url += `&eselon=${encodeURIComponent(eselon)}`;

        fetch(url)
            .then(r => r.json())
            .then(jabatans => {
                jabatans.forEach(j => {
                    const opt = document.createElement('option');
                    opt.value = j.nama_jabatan;
                    opt.textContent = j.nama_jabatan;
                    namaSelect.appendChild(opt);
                });
                namaSelect.disabled = false;

                if (isRestore && _editModalRestoreNama) {
                    namaSelect.value = _editModalRestoreNama;
                }
            });
    }

    function editModalFileChange(input) {
        const label = document.getElementById('edit-jab-file-label');
        if (input.files && input.files[0]) {
            label.textContent = input.files[0].name;
        } else {
            label.textContent = 'Upload SK Jabatan (PDF, maks 1 MB)';
        }
    }

    function submitEditJabatan() {
        // ── PERBAIKAN: Semua kode dibungkus try-catch synchronous ──────────────
        // Sebelumnya, jika getCsrfToken() atau getElementById() melempar error
        // sebelum Promise dibuat, blok .catch() pada fetch tidak pernah berjalan
        // sehingga btn.disabled tidak pernah di-reset → tombol terus muter.
        const btn      = document.getElementById('editJabatanSaveBtn');
        const origHtml = btn.innerHTML;

        // Aktifkan spinner setelah memastikan semua elemen ada
        try {
            var id        = document.getElementById('edit-jab-id').value;
            var jenis     = document.getElementById('edit-jab-jenis').value;
            var eselon    = document.getElementById('edit-jab-eselon').value;
            var nama      = document.getElementById('edit-jab-nama').value.trim();
            var no_sk     = document.getElementById('edit-jab-no_sk').value.trim();
            var tmt       = document.getElementById('edit-jab-tmt').value;
            var fileInput = document.getElementById('edit-jab-file');
            var csrfToken = getCsrfToken(); // pakai helper, tidak akan throw
        } catch (syncErr) {
            // Elemen DOM tidak ditemukan — jangan disable tombol
            if (typeof Swal !== 'undefined') {
                Swal.fire('Gagal', 'Terjadi kesalahan inisialisasi form.', 'error');
            } else {
                alert('Terjadi kesalahan inisialisasi form.');
            }
            return;
        }

        if (!nama) {
            if (typeof Swal !== 'undefined') {
                Swal.fire('Perhatian', 'Nama jabatan tidak boleh kosong.', 'warning');
            } else {
                alert('Nama jabatan tidak boleh kosong.');
            }
            return;
        }

        // Baru disable tombol setelah semua validasi synchronous lolos
        btn.disabled   = true;
        btn.innerHTML  = '<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...';

        var formData = new FormData();
        formData.append('jenis_jabatan', jenis);
        formData.append('nama_jabatan', nama);
        formData.append('eselon', eselon);
        formData.append('tmt', tmt);
        formData.append('no_sk', no_sk);
        if (fileInput.files[0]) {
            formData.append('file', fileInput.files[0]);
        }

        // PERBAIKAN UTAMA: _method:'PUT' di FormData TIDAK dibaca Laravel saat
        // Content-Type multipart/form-data (ada file upload). Route PUT tidak
        // akan pernah cocok. Solusi: kirim ke endpoint POST khusus update.
        fetch(`/profile/drh/jabatan/${id}/update`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(function(res) {
            // Tangani response non-JSON (HTML error page, redirect 302, dsb.)
            var contentType = res.headers.get('content-type') || '';
            if (!contentType.includes('application/json')) {
                // Server tidak mengembalikan JSON → reset tombol & tampilkan error
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
                return null; // hentikan chain
            }
            return res.json();
        })
        .then(function(data) {
            if (data === null) return; // sudah ditangani di atas

            btn.disabled  = false;
            btn.innerHTML = origHtml;

            if (data.status === 'success') {
                var dispJenis  = document.getElementById('jab-disp-jenis-'  + id);
                var dispNama   = document.getElementById('jab-disp-nama-'   + id);
                var dispEselon = document.getElementById('jab-disp-eselon-' + id);
                var dispTmt    = document.getElementById('jab-disp-tmt-'    + id);
                var dispNoSk   = document.getElementById('jab-disp-no_sk-'  + id);

                if (dispJenis)  dispJenis.textContent  = jenis  || '-';
                if (dispNama)   dispNama.textContent   = nama   || '-';
                if (dispEselon) dispEselon.textContent = eselon || '-';
                if (dispTmt)    dispTmt.textContent    = tmt    || '-';
                if (dispNoSk)   dispNoSk.textContent   = no_sk  || '-';

                if (data.data && data.data.file_url) {
                    var link = document.getElementById('jab-file-link-' + id);
                    if (link) link.href = data.data.file_url;
                }

                bootstrap.Modal.getInstance(document.getElementById('editJabatanModal')).hide();

                if (typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message, timer: 1500, showConfirmButton: false });
                }
            } else {
                if (typeof Swal !== 'undefined') {
                    Swal.fire('Gagal', data.message || 'Gagal menyimpan.', 'error');
                } else {
                    alert('Gagal: ' + (data.message || 'Gagal menyimpan.'));
                }
            }
        })
        .catch(function() {
            // Network error, JSON parse error, dsb.
            btn.disabled  = false;
            btn.innerHTML = origHtml;
            if (typeof Swal !== 'undefined') {
                Swal.fire('Gagal', 'Terjadi kesalahan jaringan atau server.', 'error');
            } else {
                alert('Terjadi kesalahan jaringan atau server.');
            }
        });
    }
</script>

