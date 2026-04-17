<div class="card section-card border-0 shadow-sm overflow-hidden" style="border-radius: 24px;">
    <div class="section-header d-flex align-items-center justify-content-between gap-3 p-4" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white;">
        <div class="d-flex align-items-center gap-3">
            <div class="icon-box shadow-sm" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(4px); border-radius: 14px; width: 48px; height: 48px; display: grid; place-items: center;">
                <i class="bi bi-trophy-fill fs-4"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-0" style="letter-spacing: 0.5px;">F. Riwayat Penghargaan</h5>
                <small class="opacity-75">Penghargaan, tanda jasa, dan piagam yang pernah diterima</small>
            </div>
        </div>
        <button type="button" class="btn btn-white btn-sm fw-bold rounded-pill px-3 shadow-sm" onclick="addAward()" style="background: white; color: #2563eb; border: none; transition: all 0.3s ease;">
            <i class="bi bi-plus-lg me-1"></i> Tambah Penghargaan
        </button>
    </div>

    <div class="card-body p-4 p-lg-5 bg-white" id="awardContainer">
        @if(count($awardRows) > 0)
            @foreach($awardRows as $index => $award)
                <div class="sub-card border-0 mb-4 position-relative shadow-sm" style="border-radius: 20px; background: #f8fafc; padding: 25px; transition: all 0.3s ease;">
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-white">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge rounded-pill bg-primary d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 12px;">{{ $index + 1 }}</span>
                            <span class="fw-bold text-dark" style="font-size: 15px;">Data Penghargaan</span>
                        </div>
                        <button type="button" class="btn btn-outline-danger btn-sm border-0 rounded-pill px-3" onclick="deletePenghargaanRow(this, '{{ $award['id'] ?? '' }}')" style="font-size: 13px;">
                            <i class="bi bi-trash3 me-1"></i> Hapus
                        </button>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-8">
                            <label class="form-label">Nama Penghargaan *</label>
                            <input class="form-control py-2 border-0 shadow-sm" list="penghargaanOptions_{{ $index }}" name="award[{{ $index }}][nama]" value="{{ old('award.'.$index.'.nama', $award['nama'] ?? '') }}" placeholder="Ketik atau pilih penghargaan..." autocomplete="off" style="border-radius: 12px;">
                            <datalist id="penghargaanOptions_{{ $index }}">
                                @foreach($masterPenghargaanList ?? [] as $mp)
                                    <option value="{{ $mp->nama_penghargaan }}">{{ $mp->instansi_pemberi ? $mp->nama_penghargaan . ' - ' . $mp->instansi_pemberi : $mp->nama_penghargaan }}</option>
                                @endforeach
                            </datalist>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Tahun Terima *</label>
                            <input type="text" class="form-control py-2 border-0 shadow-sm text-center" name="award[{{ $index }}][tahun]" placeholder="20XX" value="{{ old('award.'.$index.'.tahun', $award['tahun'] ?? '') }}" style="border-radius: 12px;">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Instansi / Lembaga Pemberi *</label>
                            <input type="text" class="form-control py-2 border-0 shadow-sm" name="award[{{ $index }}][instansi]" placeholder="Contoh: Presiden Republik Indonesia / Walikota Bengkulu" value="{{ old('award.'.$index.'.instansi', $award['instansi'] ?? '') }}" style="border-radius: 12px;">
                        </div>

                        <div class="col-12">
                            @php $awardFile = old('award.'.$index.'.old_file', $award['file'] ?? null); @endphp
                            @if($awardFile)
                                <div class="status-container">
                                    <div class="status-text">
                                        <div class="status-icon-circle"><i class="bi bi-check-lg"></i></div>
                                        Piagam Tersedia
                                    </div>
                                    <div class="doc-actions">
                                        <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($awardFile) }}" target="_blank" class="btn-lihat-dokumen" title="Lihat"><i class="bi bi-eye-fill"></i></a>
                                        <button type="button" class="btn-edit-dokumen" title="Edit" onclick="document.getElementById('award_reupload_{{ $index }}').click()"><i class="bi bi-pencil-square"></i></button>
                                        <input type="file" id="award_reupload_{{ $index }}" name="award[{{ $index }}][file]" accept=".pdf" class="d-none" onchange="drhReuploadPreview(this)">
                                        <button type="button" class="btn-hapus-dokumen" title="Hapus" onclick="confirmDeleteDrhDoc('penghargaan', '{{ $award['id'] ?? '' }}')"><i class="bi bi-trash"></i></button>
                                    </div>
                                </div>
                                <input type="hidden" name="award[{{ $index }}][old_file]" value="{{ $awardFile }}">
                            @else
                                <div class="upload-box border-2 border-dashed d-flex flex-column align-items-center justify-content-center p-4 transition-all" style="border-radius: 16px; background: #fff; cursor: pointer;">
                                    <input type="file" id="award_file_{{ $index }}" name="award[{{ $index }}][file]" accept=".pdf" style="display:none;">
                                    <label for="award_file_{{ $index }}" class="w-100 text-center mb-0 pointer">
                                        <i class="bi bi-award text-primary mb-2" style="font-size: 2rem;"></i>
                                        <p class="mb-1 fw-bold text-dark">Upload Piagam / Sertifikat Penghargaan</p>
                                        <p class="mb-0 text-muted small">Format PDF (Maks. 1MB)</p>
                                    </label>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
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
        }).then((result) => {
            if (result.isConfirmed) {
                if (id) {
                    fetch(`/profile/drh/penghargaan/${id}`, {
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
        if (confirm('Apakah Anda yakin ingin menghapus data penghargaan? Data yang sudah dihapus tidak bisa dikembalikan.')) {
            if (id) {
                fetch(`/profile/drh/penghargaan/${id}`, {
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