<div class="card section-card border-0 shadow-sm overflow-hidden" style="border-radius: 24px;">
    <div class="section-header d-flex align-items-center justify-content-between gap-3 p-4" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white;">
        <div class="d-flex align-items-center gap-3">
            <div class="icon-box shadow-sm" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(4px); border-radius: 14px; width: 48px; height: 48px; display: grid; place-items: center;">
                <i class="bi bi-briefcase-fill fs-4"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-0" style="letter-spacing: 0.5px;">E. Riwayat Jabatan</h5>
                <small class="opacity-75">Riwayat jabatan dan kepangkatan selama berkarir</small>
            </div>
        </div>
        <button type="button" class="btn btn-white btn-sm fw-bold rounded-pill px-3 shadow-sm" onclick="addJabatan()" style="background: white; color: #2563eb; border: none; transition: all 0.3s ease;">
            <i class="bi bi-plus-lg me-1"></i> Tambah Jabatan
        </button>
    </div>

    <div class="card-body p-4 p-lg-5 bg-white" id="jabatanContainer">
        @if(count($jabatanRows) > 0)
            @foreach($jabatanRows as $index => $jabatan)
                <div class="sub-card border-0 mb-4 position-relative shadow-sm" style="border-radius: 20px; background: #f8fafc; padding: 25px; transition: all 0.3s ease;">
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-white">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge rounded-pill bg-primary d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 12px;">{{ $index + 1 }}</span>
                            <span class="fw-bold text-dark" style="font-size: 15px;">Data Riwayat Jabatan</span>
                        </div>
                        <button type="button" class="btn btn-outline-danger btn-sm border-0 rounded-pill px-3" onclick="deleteJabatanRow(this, '{{ $jabatan['id'] ?? '' }}')" style="font-size: 13px;">
                            <i class="bi bi-trash3 me-1"></i> Hapus
                        </button>
                    </div>

                    <div class="row g-4">
                        @if(!empty($jabatan['id']))
                            <input type="hidden" name="riwayat_jabatan[{{ $index }}][id]" value="{{ $jabatan['id'] }}">
                        @endif

                        @if(($drhData?->status_pegawai ?? '') === 'PPPK')
                        {{-- PPPK: hanya Nama Jabatan (text), TMT, No SK, Upload SK --}}
                        <div class="col-md-12">
                            <label class="form-label">Nama Jabatan</label>
                            <input type="text" class="form-control py-2 border-0 shadow-sm" name="riwayat_jabatan[{{ $index }}][nama_jabatan]" value="{{ old('riwayat_jabatan.'.$index.'.nama_jabatan', $jabatan['nama_jabatan'] ?? '') }}" placeholder="Masukkan nama jabatan" style="border-radius: 12px;">
                            <input type="hidden" name="riwayat_jabatan[{{ $index }}][jenis_jabatan]" value="">
                            <input type="hidden" name="riwayat_jabatan[{{ $index }}][eselon]" value="">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">TMT Jabatan</label>
                            <input type="date" class="form-control py-2 border-0 shadow-sm" name="riwayat_jabatan[{{ $index }}][tmt]" value="{{ old('riwayat_jabatan.'.$index.'.tmt', $jabatan['tmt'] ?? '') }}" style="border-radius: 12px;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nomor SK</label>
                            <input type="text" class="form-control py-2 border-0 shadow-sm" name="riwayat_jabatan[{{ $index }}][no_sk]" value="{{ old('riwayat_jabatan.'.$index.'.no_sk', $jabatan['no_sk'] ?? '') }}" placeholder="Masukan No. SK" style="border-radius: 12px;">
                        </div>
                        @else
                        {{-- PNS: Jenis Jabatan, Eselon, Nama Jabatan (dropdown), No SK, TMT --}}
                        <div class="col-md-4">
                            <label class="form-label">Jenis Jabatan</label>
                            <select class="form-select py-2 border-0 shadow-sm rj-jenis" data-index="{{ $index }}" style="border-radius: 12px;" onchange="rjOnJenisChange(this, false)">
                                <option value="">Pilih Jenis Jabatan</option>
                                <option value="STRUKTURAL" {{ ($jabatan['jenis_jabatan'] ?? '') === 'STRUKTURAL' ? 'selected' : '' }}>Struktural</option>
                                <option value="JFT" {{ ($jabatan['jenis_jabatan'] ?? '') === 'JFT' ? 'selected' : '' }}>JFT (Fungsional Tertentu)</option>
                                <option value="JFU" {{ ($jabatan['jenis_jabatan'] ?? '') === 'JFU' ? 'selected' : '' }}>JFU (Fungsional Umum)</option>
                            </select>
                            <input type="hidden" name="riwayat_jabatan[{{ $index }}][jenis_jabatan]" class="rj-jenis-hidden" value="{{ $jabatan['jenis_jabatan'] ?? '' }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Eselon</label>
                            <select class="form-select py-2 border-0 shadow-sm rj-eselon" data-index="{{ $index }}" style="border-radius: 12px;" onchange="rjOnEselonChange(this, false)" disabled>
                                <option value="">Pilih Eselon</option>
                            </select>
                            <input type="hidden" name="riwayat_jabatan[{{ $index }}][eselon]" class="rj-eselon-hidden" value="{{ $jabatan['eselon'] ?? '' }}">
                            <input type="hidden" class="rj-saved-eselon" value="{{ $jabatan['eselon'] ?? '' }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Nama Jabatan</label>
                            <select class="form-select py-2 border-0 shadow-sm rj-nama" data-index="{{ $index }}" style="border-radius: 12px;" onchange="this.closest('.sub-card').querySelector('.rj-nama-hidden').value = this.value" disabled>
                                <option value="">Pilih Nama Jabatan</option>
                            </select>
                            <input type="hidden" name="riwayat_jabatan[{{ $index }}][nama_jabatan]" class="rj-nama-hidden" value="{{ $jabatan['nama_jabatan'] ?? '' }}">
                            <input type="hidden" class="rj-saved-nama" value="{{ $jabatan['nama_jabatan'] ?? '' }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nomor SK</label>
                            <input type="text" class="form-control py-2 border-0 shadow-sm" name="riwayat_jabatan[{{ $index }}][no_sk]" value="{{ old('riwayat_jabatan.'.$index.'.no_sk', $jabatan['no_sk'] ?? '') }}" placeholder="Masukan No. SK" style="border-radius: 12px;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">TMT</label>
                            <input type="date" class="form-control py-2 border-0 shadow-sm" name="riwayat_jabatan[{{ $index }}][tmt]" value="{{ old('riwayat_jabatan.'.$index.'.tmt', $jabatan['tmt'] ?? '') }}" style="border-radius: 12px;">
                        </div>
                        @endif

                        <div class="col-12">
                            @php $jabatanFile = old('riwayat_jabatan.'.$index.'.old_file', $jabatan['file'] ?? null); @endphp
                            @if($jabatanFile)
                                <div class="status-container">
                                    <div class="status-text">
                                        <div class="status-icon-circle"><i class="bi bi-check-lg"></i></div>
                                        SK Jabatan Tersedia
                                    </div>
                                    <div class="doc-actions">
                                        <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($jabatanFile) }}" target="_blank" class="btn-lihat-dokumen" title="Lihat"><i class="bi bi-eye-fill"></i></a>
                                        <button type="button" class="btn-edit-dokumen" title="Edit" onclick="document.getElementById('jabatan_reupload_{{ $index }}').click()"><i class="bi bi-pencil-square"></i></button>
                                        <input type="file" id="jabatan_reupload_{{ $index }}" name="riwayat_jabatan[{{ $index }}][file]" accept=".pdf" class="d-none" onchange="drhReuploadPreview(this)">
                                        <button type="button" class="btn-hapus-dokumen" title="Hapus" onclick="confirmDeleteDrhDoc('jabatan', '{{ $jabatan['id'] ?? '' }}')"><i class="bi bi-trash"></i></button>
                                    </div>
                                </div>
                                <input type="hidden" name="riwayat_jabatan[{{ $index }}][old_file]" value="{{ $jabatanFile }}">
                            @else
                                <div class="upload-box border-2 border-dashed d-flex flex-column align-items-center justify-content-center p-4 transition-all" style="border-radius: 16px; background: #fff; cursor: pointer;">
                                    <input type="file" id="jabatan_file_{{ $index }}" name="riwayat_jabatan[{{ $index }}][file]" accept=".pdf" style="display:none;">
                                    <label for="jabatan_file_{{ $index }}" class="w-100 text-center mb-0 pointer">
                                        <i class="bi bi-cloud-arrow-up text-primary mb-2" style="font-size: 2rem;"></i>
                                        <p class="mb-1 fw-bold text-dark">Upload SK Jabatan</p>
                                        <p class="mb-0 text-muted small">Format PDF (Maks. 1MB)</p>
                                    </label>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
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
        <button type="button" class="btn btn-primary btn-lg fw-bold px-5 py-3 shadow mt-4" onclick="saveSectionData(4)" style="border-radius: 16px; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); background: #2563eb; border: none;">
            <i class="bi bi-cloud-arrow-up-fill me-2"></i> Simpan Riwayat Jabatan
        </button>
    </div>
</div>

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
                            alert(data.message);
                        }
                    })
                    .catch(() => alert('Terjadi kesalahan.'));
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

