<div class="card section-card border-0 shadow-sm overflow-hidden" style="border-radius: 24px;">
    <div class="section-header d-flex align-items-center justify-content-between gap-3 p-4" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white;">
        <div class="d-flex align-items-center gap-3">
            <div class="icon-box shadow-sm" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(4px); border-radius: 14px; width: 48px; height: 48px; display: grid; place-items: center;">
                <i class="bi bi-journal-check fs-4"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-0" style="letter-spacing: 0.5px;">D. Riwayat Diklat</h5>
                <small class="opacity-75">Riwayat pelatihan dan pendidikan kedinasan</small>
            </div>
        </div>
        <button type="button" class="btn btn-white btn-sm fw-bold rounded-pill px-3 shadow-sm" onclick="addDiklat()" style="background: white; color: #2563eb; border: none; transition: all 0.3s ease;">
            <i class="bi bi-plus-lg me-1"></i> Tambah Diklat
        </button>
    </div>

    <div class="card-body p-4 p-lg-5 bg-white" id="diklatContainer">
        @if(count($diklatRows) > 0)
            @foreach($diklatRows as $index => $diklat)
                <div class="sub-card border-0 mb-4 position-relative shadow-sm" style="border-radius: 20px; background: #f8fafc; padding: 25px; transition: all 0.3s ease;">
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-white">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge rounded-pill bg-primary d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 12px;">{{ $index + 1 }}</span>
                            <span class="fw-bold text-dark" style="font-size: 15px;">Data Pelatihan / Diklat</span>
                        </div>
                        <button type="button" class="btn btn-outline-danger btn-sm border-0 rounded-pill px-3" onclick="deleteDiklatRow(this, '{{ $diklat['id'] ?? '' }}')" style="font-size: 13px;">
                            <i class="bi bi-trash3 me-1"></i> Hapus
                        </button>
                    </div>

                    <div class="row g-4">
                        @if(!empty($diklat['id']))
                            <input type="hidden" name="diklat[{{ $index }}][id]" value="{{ $diklat['id'] }}">
                        @endif

                        <div class="col-md-6">
                            <label class="form-label">Nama Diklat *</label>
                            <input class="form-control py-2 border-0 shadow-sm" list="diklatOptions_{{ $index }}" name="diklat[{{ $index }}][nama]" value="{{ old('diklat.'.$index.'.nama', $diklat['nama'] ?? '') }}" placeholder="Ketik atau pilih diklat/sertifikasi..." autocomplete="off" style="border-radius: 12px;">
                            <datalist id="diklatOptions_{{ $index }}">
                                @foreach($masterSertifikasiList ?? [] as $ms)
                                    <option value="{{ $ms->nama_sertifikasi }}">{{ $ms->lembaga_pemberi ? $ms->nama_sertifikasi . ' - ' . $ms->lembaga_pemberi : $ms->nama_sertifikasi }}</option>
                                @endforeach
                            </datalist>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Instansi Penyelenggara *</label>
                            <input type="text" class="form-control py-2 border-0 shadow-sm" name="diklat[{{ $index }}][penyelenggara]" value="{{ old('diklat.'.$index.'.penyelenggara', $diklat['penyelenggara'] ?? '') }}" placeholder="Contoh: BKPSDM / Kominfo RI" style="border-radius: 12px;">
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">Nomor Sertifikat / STTPP</label>
                            <input type="text" class="form-control py-2 border-0 shadow-sm" name="diklat[{{ $index }}][nomor_sertifikat]" value="{{ old('diklat.'.$index.'.nomor_sertifikat', $diklat['nomor_sertifikat'] ?? '') }}" placeholder="Masukan No. Sertifikat" style="border-radius: 12px;">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Tahun Pelaksanaan</label>
                            <input type="text" class="form-control py-2 border-0 shadow-sm text-center" name="diklat[{{ $index }}][tahun]" placeholder="20XX" value="{{ old('diklat.'.$index.'.tahun', $diklat['tahun'] ?? '') }}" style="border-radius: 12px;">
                        </div>

                        <div class="col-12">
                            @php $diklatFile = old('diklat.'.$index.'.old_file', $diklat['file'] ?? null); @endphp
                            @if($diklatFile)
                                <div class="status-container">
                                    <div class="status-text">
                                        <div class="status-icon-circle"><i class="bi bi-check-lg"></i></div>
                                        Sertifikat Tersedia
                                    </div>
                                    <div class="doc-actions">
                                        <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($diklatFile) }}" target="_blank" class="btn-lihat-dokumen" title="Lihat"><i class="bi bi-eye-fill"></i></a>
                                        <button type="button" class="btn-edit-dokumen" title="Edit" onclick="document.getElementById('diklat_reupload_{{ $index }}').click()"><i class="bi bi-pencil-square"></i></button>
                                        <input type="file" id="diklat_reupload_{{ $index }}" name="diklat[{{ $index }}][file]" accept=".pdf" class="d-none" onchange="drhReuploadPreview(this)">
                                        <button type="button" class="btn-hapus-dokumen" title="Hapus" onclick="confirmDeleteDrhDoc('diklat', '{{ $diklat['id'] ?? '' }}')"><i class="bi bi-trash"></i></button>
                                    </div>
                                </div>
                                <input type="hidden" name="diklat[{{ $index }}][old_file]" value="{{ $diklatFile }}">
                            @else
                                <div class="upload-box border-2 border-dashed d-flex flex-column align-items-center justify-content-center p-4 transition-all" style="border-radius: 16px; background: #fff; cursor: pointer;">
                                    <input type="file" id="diklat_file_{{ $index }}" name="diklat[{{ $index }}][file]" accept=".pdf" style="display:none;">
                                    <label for="diklat_file_{{ $index }}" class="w-100 text-center mb-0 pointer">
                                        <i class="bi bi-cloud-arrow-up text-primary mb-2" style="font-size: 2rem;"></i>
                                        <p class="mb-1 fw-bold text-dark">Upload Sertifikat Diklat</p>
                                        <p class="mb-0 text-muted small">Format PDF (Maks. 1MB)</p>
                                    </label>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div id="emptyDiklat" class="text-center py-5 border-2 border-dashed rounded-4" style="background: #fafafa; border-color: #e2e8f0;">
                <div class="mb-3">
                    <i class="bi bi-journal-x opacity-25" style="font-size: 4rem;"></i>
                </div>
                <h6 class="text-muted fw-bold">Belum ada riwayat diklat</h6>
                <p class="small text-muted mb-3">Klik tombol "Tambah Diklat" untuk menambahkan riwayat pelatihan Anda.</p>
                <button type="button" class="btn btn-primary btn-sm rounded-pill px-4" onclick="addDiklat()">Tambah Sekarang</button>
            </div>
        @endif
    </div>

    <div class="card-body p-4 p-lg-5 pt-0 d-flex justify-content-end border-top mt-2">
        <button type="button" class="btn btn-primary btn-lg fw-bold px-5 py-3 shadow mt-4" onclick="saveSectionData(3)" style="border-radius: 16px; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); background: #2563eb; border: none;">
            <i class="bi bi-cloud-arrow-up-fill me-2"></i> Simpan Riwayat Diklat
        </button>
    </div>
</div>

<style>
    /* Interaksi Hover pada kartu diklat */
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
</style>

@push('scripts')
<script>
function deleteDiklatRow(btn, id) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: 'Data diklat yang dihapus tidak bisa dikembalikan!',
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
                    fetch(`/profile/drh/diklat/${id}`, {
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
        if (confirm('Apakah Anda yakin ingin menghapus data diklat? Data yang sudah dihapus tidak bisa dikembalikan.')) {
            if (id) {
                fetch(`/profile/drh/diklat/${id}`, {
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
</script>
@endpush