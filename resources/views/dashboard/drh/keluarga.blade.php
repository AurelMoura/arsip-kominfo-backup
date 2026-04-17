<div class="card section-card border-0 shadow-sm overflow-hidden" style="border-radius: 24px;">
    <div class="section-header d-flex align-items-center justify-content-between gap-3 p-4" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white;">
        <div class="d-flex align-items-center gap-3">
            <div class="icon-box shadow-sm" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(4px); border-radius: 14px; width: 48px; height: 48px; display: grid; place-items: center;">
                <i class="bi bi-people-fill fs-4"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-0" style="letter-spacing: 0.5px;">B. Dokumen Keluarga</h5>
                <small class="opacity-75">Data Pasangan, Anak, Orang Tua Kandung, & Mertua</small>
            </div>
        </div>
        <div class="badge bg-white bg-opacity-20 rounded-pill px-3 py-2 text-uppercase" style="font-size: 10px; letter-spacing: 1px;">Step 2 of 8</div>
    </div>

    <div class="card-body p-4 p-lg-5 bg-white text-start">
        @php
            $statusKawin = $drhData?->status_kawin;
            $isMenikah = $statusKawin === 'M';
            $isBelumMenikah = $statusKawin === 'BM';
            $isCerai = in_array($statusKawin, ['CH', 'CM']);
        @endphp

        <div id="sectionPasangan" class="mb-5" style="display: {{ $isMenikah ? 'block' : 'none' }};">
            <h6 class="fw-bold text-primary d-flex align-items-center gap-2 mb-4">
                <i class="bi bi-heart-fill text-danger"></i> Data Suami / Istri
            </h6>
            <div class="sub-card border-0 shadow-sm" style="border-radius: 20px; background: #f8fafc; padding: 25px;">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">NIK Pasangan</label>
                        <div class="input-group">
                            <input type="text" class="form-control py-2 border-0 shadow-sm nik-lookup @error('nik_pasangan') is-invalid @enderror" name="nik_pasangan" placeholder="16 Digit NIK" value="{{ old('nik_pasangan', $drhData?->data_keluarga['pasangan']['nik'] ?? '') }}" style="border-radius: 12px 0 0 12px;">
                            <button type="button" class="btn btn-outline-primary btn-nik-search" title="Cari NIK" style="border-radius: 0 12px 12px 0; border: none; background: #e8f0fe;"><i class="bi bi-search"></i></button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Pasangan *</label>
                        <input type="text" class="form-control py-2 border-0 shadow-sm @error('nama_pasangan') is-invalid @enderror" name="nama_pasangan" placeholder="Nama Lengkap" value="{{ old('nama_pasangan', $drhData?->data_keluarga['pasangan']['nama'] ?? '') }}" style="border-radius: 12px;">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status Pasangan</label>
                        <select class="form-select py-2 border-0 shadow-sm" name="status_pasangan_select" style="border-radius: 12px;">
                            <option value="SUAMI" {{ old('status_pasangan_select', $drhData?->data_keluarga['pasangan']['status'] ?? '') === 'SUAMI' ? 'selected' : '' }}>SUAMI</option>
                            <option value="ISTRI" {{ old('status_pasangan_select', $drhData?->data_keluarga['pasangan']['status'] ?? '') === 'ISTRI' ? 'selected' : '' }}>ISTRI</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status Hidup</label>
                        <select class="form-select py-2 border-0 shadow-sm" name="status_hidup_pasangan" style="border-radius: 12px;">
                            <option value="Hidup" {{ old('status_hidup_pasangan', $drhData?->data_keluarga['pasangan']['status_hidup'] ?? '') === 'Hidup' ? 'selected' : '' }}>Hidup</option>
                            <option value="Meninggal" {{ old('status_hidup_pasangan', $drhData?->data_keluarga['pasangan']['status_hidup'] ?? '') === 'Meninggal' ? 'selected' : '' }}>Meninggal</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control py-2 border-0 shadow-sm" name="tempat_lahir_pasangan" placeholder="Kota" value="{{ old('tempat_lahir_pasangan', $drhData?->data_keluarga['pasangan']['tempat_lahir'] ?? '') }}" style="border-radius: 12px;">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control py-2 border-0 shadow-sm" name="tanggal_lahir_pasangan" value="{{ old('tanggal_lahir_pasangan', $drhData?->data_keluarga['pasangan']['tanggal_lahir'] ?? '') }}" style="border-radius: 12px;">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Pekerjaan</label>
                        <input type="text" class="form-control py-2 border-0 shadow-sm" name="pekerjaan_pasangan" placeholder="Pekerjaan Pasangan" value="{{ old('pekerjaan_pasangan', $drhData?->data_keluarga['pasangan']['pekerjaan'] ?? '') }}" style="border-radius: 12px;">
                    </div>
                    <div class="col-12">
                        <label class="form-label">No. Akta Nikah</label>
                        <input type="text" class="form-control py-2 border-0 shadow-sm" name="no_akta_nikah" placeholder="Masukkan Nomor Akta Nikah" value="{{ old('no_akta_nikah', $drhData?->data_keluarga['pasangan']['no_akta_nikah'] ?? '') }}" style="border-radius: 12px;">
                    </div>
                </div>
            </div>
        </div>

        <div id="sectionAnak" class="mb-5" style="display: {{ ($isMenikah || $isCerai) ? 'block' : 'none' }};">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-bold text-primary d-flex align-items-center gap-2 mb-0">
                    <i class="bi bi-person-hearts"></i> Data Anak
                </h6>
                <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm" onclick="addAnak()">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Anak
                </button>
            </div>
            <div id="anakContainer">
                @if(count($anakRows) > 0)
                    @foreach($anakRows as $index => $anak)
                        <div class="sub-card border-0 mb-4 shadow-sm position-relative" style="border-radius: 20px; background: #f8fafc; padding: 25px;">
                            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom border-white pb-2">
                                <span class="badge rounded-pill bg-primary px-3 py-2">Anak Ke-{{ $index + 1 }}</span>
                                <button type="button" class="btn btn-outline-danger btn-sm border-0 rounded-pill px-3" onclick="this.parentElement.parentElement.remove()"><i class="bi bi-trash3 me-1"></i> Hapus</button>
                            </div>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Anak *</label>
                                    <input type="text" class="form-control py-2 border-0 shadow-sm" name="anak[{{ $index }}][nama]" value="{{ old('anak.'.$index.'.nama', $anak['nama'] ?? '') }}" style="border-radius: 12px;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NIK Anak</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control py-2 border-0 shadow-sm nik-lookup" name="anak[{{ $index }}][nik]" value="{{ old('anak.'.$index.'.nik', $anak['nik'] ?? '') }}" style="border-radius: 12px 0 0 12px;">
                                        <button type="button" class="btn btn-outline-primary btn-nik-search" title="Cari NIK" style="border-radius: 0 12px 12px 0; border: none; background: #e8f0fe;"><i class="bi bi-search"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control py-2 border-0 shadow-sm" name="anak[{{ $index }}][tempat_lahir]" value="{{ old('anak.'.$index.'.tempat_lahir', $anak['tempat_lahir'] ?? '') }}" style="border-radius: 12px;">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control py-2 border-0 shadow-sm" name="anak[{{ $index }}][tanggal_lahir]" value="{{ old('anak.'.$index.'.tanggal_lahir', $anak['tanggal_lahir'] ?? '') }}" style="border-radius: 12px;">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Status Kawin</label>
                                    <select class="form-select py-2 border-0 shadow-sm" name="anak[{{ $index }}][status_kawin]" style="border-radius: 12px;">
                                        <option value="">Pilih</option>
                                        @foreach(['Belum Menikah', 'Menikah', 'Cerai Hidup', 'Cerai Mati'] as $skAnak)
                                            <option value="{{ $skAnak }}" {{ old('anak.'.$index.'.status_kawin', $anak['status_kawin'] ?? '') === $skAnak ? 'selected' : '' }}>{{ $skAnak }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Status Anak</label>
                                    <select class="form-select py-2 border-0 shadow-sm" name="anak[{{ $index }}][status_anak]" style="border-radius: 12px;">
                                        <option {{ old('anak.'.$index.'.status_anak', $anak['status_anak'] ?? '') === 'Kandung' ? 'selected' : '' }}>Kandung</option>
                                        <option {{ old('anak.'.$index.'.status_anak', $anak['status_anak'] ?? '') === 'Tiri' ? 'selected' : '' }}>Tiri</option>
                                        <option {{ old('anak.'.$index.'.status_anak', $anak['status_anak'] ?? '') === 'Angkat' ? 'selected' : '' }}>Angkat</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    @php $anakFile = old('anak.'.$index.'.old_file', $anak['file'] ?? null); @endphp
                                    @if($anakFile)
                                        <div class="alert alert-success border-0 shadow-sm d-flex justify-content-between align-items-center mb-0 px-3 py-2" style="border-radius: 12px; background: #f0fdf4;">
                                            <small class="fw-bold text-success"><i class="bi bi-file-earmark-check me-2"></i>Akta Kelahiran Tersedia</small>
                                            <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($anakFile) }}" target="_blank" class="btn btn-success btn-sm rounded-pill px-3">Lihat</a>
                                        </div>
                                        <input type="hidden" name="anak[{{ $index }}][old_file]" value="{{ $anakFile }}">
                                    @else
                                        <div class="upload-box border-2 border-dashed d-flex align-items-center justify-content-center p-3" style="border-radius: 12px; background: #fff; cursor: pointer;">
                                            <input type="file" id="anak_file_{{ $index }}" name="anak[{{ $index }}][file]" accept=".pdf" style="display:none;">
                                            <label for="anak_file_{{ $index }}" class="mb-0 small fw-bold text-muted pointer"><i class="bi bi-cloud-arrow-up text-primary me-2"></i>Upload Akta Kelahiran Anak (PDF)</label>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-5 border-2 border-dashed rounded-4" style="background: #fafafa; border-color: #e2e8f0;" id="emptyAnak">
                        <p class="text-muted small mb-0">Belum ada data anak. Klik "+ Tambah Anak".</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="mb-5">
            <h6 class="fw-bold text-primary d-flex align-items-center gap-2 mb-4">
                <i class="bi bi-person-badge-fill"></i> Data Orang Tua Kandung <span class="text-danger" style="font-size: 10px;">(Wajib)</span>
            </h6>
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="sub-card border-0 shadow-sm h-100" style="border-radius: 20px; background: #f8fafc; padding: 25px;">
                        <h6 class="fw-bold text-dark border-bottom border-white pb-3 mb-4"><i class="bi bi-gender-male me-2 text-primary"></i>Ayah Kandung</h6>
                        <div class="row g-3">
                            <div class="col-12"><label class="form-label">NIK Ayah</label><div class="input-group"><input type="text" class="form-control py-2 border-0 shadow-sm nik-lookup" name="nik_ayah" value="{{ old('nik_ayah', $drhData?->data_keluarga['orang_tua']['ayah']['nik'] ?? '') }}" style="border-radius: 12px 0 0 12px;"><button type="button" class="btn btn-outline-primary btn-nik-search" title="Cari NIK" style="border-radius: 0 12px 12px 0; border: none; background: #e8f0fe;"><i class="bi bi-search"></i></button></div></div>
                            <div class="col-12"><label class="form-label">Nama Ayah</label><input type="text" class="form-control py-2 border-0 shadow-sm" name="nama_ayah" value="{{ old('nama_ayah', $drhData?->data_keluarga['orang_tua']['ayah']['nama'] ?? '') }}" style="border-radius: 12px;"></div>
                            <div class="col-12"><label class="form-label">Alamat Ayah</label><textarea class="form-control py-2 border-0 shadow-sm" name="alamat_ayah" rows="2" style="border-radius: 12px;">{{ old('alamat_ayah', $drhData?->data_keluarga['orang_tua']['ayah']['alamat'] ?? '') }}</textarea></div>
                            <div class="col-md-6"><label class="form-label">Status Hidup</label><select class="form-select py-2 border-0 shadow-sm" name="status_ayah" style="border-radius: 12px;"><option value="Hidup" {{ old('status_ayah', $drhData?->data_keluarga['orang_tua']['ayah']['status_hidup'] ?? '') === 'Hidup' ? 'selected' : '' }}>Hidup</option><option value="Meninggal" {{ old('status_ayah', $drhData?->data_keluarga['orang_tua']['ayah']['status_hidup'] ?? '') === 'Meninggal' ? 'selected' : '' }}>Meninggal</option></select></div>
                            <div class="col-md-6"><label class="form-label">Tanggal Lahir</label><input type="date" class="form-control py-2 border-0 shadow-sm" name="tanggal_lahir_ayah" value="{{ old('tanggal_lahir_ayah', $drhData?->data_keluarga['orang_tua']['ayah']['tanggal_lahir'] ?? '') }}" style="border-radius: 12px;"></div>
                            <div class="col-12"><label class="form-label">Pekerjaan</label><input type="text" class="form-control py-2 border-0 shadow-sm" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah', $drhData?->data_keluarga['orang_tua']['ayah']['pekerjaan'] ?? '') }}" style="border-radius: 12px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="sub-card border-0 shadow-sm h-100" style="border-radius: 20px; background: #f8fafc; padding: 25px;">
                        <h6 class="fw-bold text-dark border-bottom border-white pb-3 mb-4"><i class="bi bi-gender-female me-2 text-danger"></i>Ibu Kandung</h6>
                        <div class="row g-3">
                            <div class="col-12"><label class="form-label">NIK Ibu</label><div class="input-group"><input type="text" class="form-control py-2 border-0 shadow-sm nik-lookup" name="nik_ibu" value="{{ old('nik_ibu', $drhData?->data_keluarga['orang_tua']['ibu']['nik'] ?? '') }}" style="border-radius: 12px 0 0 12px;"><button type="button" class="btn btn-outline-primary btn-nik-search" title="Cari NIK" style="border-radius: 0 12px 12px 0; border: none; background: #e8f0fe;"><i class="bi bi-search"></i></button></div></div>
                            <div class="col-12"><label class="form-label">Nama Ibu</label><input type="text" class="form-control py-2 border-0 shadow-sm" name="nama_ibu" value="{{ old('nama_ibu', $drhData?->data_keluarga['orang_tua']['ibu']['nama'] ?? '') }}" style="border-radius: 12px;"></div>
                            <div class="col-12"><label class="form-label">Alamat Ibu</label><textarea class="form-control py-2 border-0 shadow-sm" name="alamat_ibu" rows="2" style="border-radius: 12px;">{{ old('alamat_ibu', $drhData?->data_keluarga['orang_tua']['ibu']['alamat'] ?? '') }}</textarea></div>
                            <div class="col-md-6"><label class="form-label">Status Hidup</label><select class="form-select py-2 border-0 shadow-sm" name="status_ibu" style="border-radius: 12px;"><option value="Hidup" {{ old('status_ibu', $drhData?->data_keluarga['orang_tua']['ibu']['status_hidup'] ?? '') === 'Hidup' ? 'selected' : '' }}>Hidup</option><option value="Meninggal" {{ old('status_ibu', $drhData?->data_keluarga['orang_tua']['ibu']['status_hidup'] ?? '') === 'Meninggal' ? 'selected' : '' }}>Meninggal</option></select></div>
                            <div class="col-md-6"><label class="form-label">Tanggal Lahir</label><input type="date" class="form-control py-2 border-0 shadow-sm" name="tanggal_lahir_ibu" value="{{ old('tanggal_lahir_ibu', $drhData?->data_keluarga['orang_tua']['ibu']['tanggal_lahir'] ?? '') }}" style="border-radius: 12px;"></div>
                            <div class="col-12"><label class="form-label">Pekerjaan</label><input type="text" class="form-control py-2 border-0 shadow-sm" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu', $drhData?->data_keluarga['orang_tua']['ibu']['pekerjaan'] ?? '') }}" style="border-radius: 12px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="sectionMertua" class="mb-5" style="display: {{ $isMenikah ? 'block' : 'none' }};">
            <h6 class="fw-bold text-primary d-flex align-items-center gap-2 mb-4">
                <i class="bi bi-house-heart-fill"></i> Data Orang Tua Mertua
            </h6>
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="sub-card border-0 shadow-sm" style="border-radius: 20px; background: #f8fafc; padding: 25px;">
                        <h6 class="small fw-bold text-muted mb-3">Ayah Mertua</h6>
                        <div class="row g-3">
                            <div class="col-12"><label class="form-label">NIK</label><div class="input-group"><input type="text" class="form-control py-2 border-0 shadow-sm nik-lookup" name="nik_ayah_mertua" value="{{ old('nik_ayah_mertua', $drhData?->data_keluarga['mertua']['ayah']['nik'] ?? '') }}" style="border-radius: 12px 0 0 12px;"><button type="button" class="btn btn-outline-primary btn-nik-search" title="Cari NIK" style="border-radius: 0 12px 12px 0; border: none; background: #e8f0fe;"><i class="bi bi-search"></i></button></div></div>
                            <div class="col-12"><label class="form-label">Nama</label><input type="text" class="form-control py-2 border-0 shadow-sm" name="nama_ayah_mertua" value="{{ old('nama_ayah_mertua', $drhData?->data_keluarga['mertua']['ayah']['nama'] ?? '') }}" style="border-radius: 12px;"></div>
                            <div class="col-md-6"><label class="form-label">Tgl Lahir</label><input type="date" class="form-control py-2 border-0 shadow-sm" name="tanggal_lahir_ayah_mertua" value="{{ old('tanggal_lahir_ayah_mertua', $drhData?->data_keluarga['mertua']['ayah']['tanggal_lahir'] ?? '') }}" style="border-radius: 12px;"></div>
                            <div class="col-md-6"><label class="form-label">Status</label><select class="form-select py-2 border-0 shadow-sm" name="status_ayah_mertua" style="border-radius: 12px;"><option value="Hidup" {{ old('status_ayah_mertua', $drhData?->data_keluarga['mertua']['ayah']['status_hidup'] ?? '') === 'Hidup' ? 'selected' : '' }}>Hidup</option><option value="Meninggal" {{ old('status_ayah_mertua', $drhData?->data_keluarga['mertua']['ayah']['status_hidup'] ?? '') === 'Meninggal' ? 'selected' : '' }}>Meninggal</option></select></div>
                            <div class="col-12">
                                <label class="form-label">Pekerjaan</label>
                                <input type="text" class="form-control py-2 border-0 shadow-sm" name="pekerjaan_ayah_mertua" value="{{ old('pekerjaan_ayah_mertua', $drhData?->data_keluarga['mertua']['ayah']['pekerjaan'] ?? '') }}" style="border-radius: 12px;">
                                @if(data_get($drhData, 'data_keluarga.mertua.ayah.file'))
                                    <div class="mt-2"><a href="{{ url('/profile/drh/file/ayah_mertua/view') }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-3">Lihat Dokumen Mertua</a></div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="sub-card border-0 shadow-sm" style="border-radius: 20px; background: #f8fafc; padding: 25px;">
                        <h6 class="small fw-bold text-muted mb-3">Ibu Mertua</h6>
                        <div class="row g-3">
                            <div class="col-12"><label class="form-label">NIK</label><div class="input-group"><input type="text" class="form-control py-2 border-0 shadow-sm nik-lookup" name="nik_ibu_mertua" value="{{ old('nik_ibu_mertua', $drhData?->data_keluarga['mertua']['ibu']['nik'] ?? '') }}" style="border-radius: 12px 0 0 12px;"><button type="button" class="btn btn-outline-primary btn-nik-search" title="Cari NIK" style="border-radius: 0 12px 12px 0; border: none; background: #e8f0fe;"><i class="bi bi-search"></i></button></div></div>
                            <div class="col-12"><label class="form-label">Nama</label><input type="text" class="form-control py-2 border-0 shadow-sm" name="nama_ibu_mertua" value="{{ old('nama_ibu_mertua', $drhData?->data_keluarga['mertua']['ibu']['nama'] ?? '') }}" style="border-radius: 12px;"></div>
                            <div class="col-md-6"><label class="form-label">Tgl Lahir</label><input type="date" class="form-control py-2 border-0 shadow-sm" name="tanggal_lahir_ibu_mertua" value="{{ old('tanggal_lahir_ibu_mertua', $drhData?->data_keluarga['mertua']['ibu']['tanggal_lahir'] ?? '') }}" style="border-radius: 12px;"></div>
                            <div class="col-md-6"><label class="form-label">Status</label><select class="form-select py-2 border-0 shadow-sm" name="status_ibu_mertua" style="border-radius: 12px;"><option value="Hidup" {{ old('status_ibu_mertua', $drhData?->data_keluarga['mertua']['ibu']['status_hidup'] ?? '') === 'Hidup' ? 'selected' : '' }}>Hidup</option><option value="Meninggal" {{ old('status_ibu_mertua', $drhData?->data_keluarga['mertua']['ibu']['status_hidup'] ?? '') === 'Meninggal' ? 'selected' : '' }}>Meninggal</option></select></div>
                            <div class="col-12">
                                <label class="form-label">Pekerjaan</label>
                                <input type="text" class="form-control py-2 border-0 shadow-sm" name="pekerjaan_ibu_mertua" value="{{ old('pekerjaan_ibu_mertua', $drhData?->data_keluarga['mertua']['ibu']['pekerjaan'] ?? '') }}" style="border-radius: 12px;">
                                @if(data_get($drhData, 'data_keluarga.mertua.ibu.file'))
                                    <div class="mt-2"><a href="{{ url('/profile/drh/file/ibu_mertua/view') }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-3">Lihat Dokumen Mertua</a></div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-bold text-primary d-flex align-items-center gap-2 mb-0">
                    <i class="bi bi-people-fill"></i> Data Saudara Kandung
                </h6>
                <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm" onclick="addSaudara()">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Saudara
                </button>
            </div>
            <div id="saudaraContainer">
                @if(count($saudaraRows) > 0)
                    @foreach($saudaraRows as $index => $saudara)
                        <div class="sub-card border-0 mb-3 shadow-sm" style="border-radius: 16px; background: #f8fafc; padding: 25px;">
                            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom border-white pb-2">
                                <span class="fw-bold text-dark small">Saudara Ke-{{ $index + 1 }} <small class="text-muted">({{ $saudara['nama'] ?? 'Tanpa Nama' }})</small></span>
                                <button type="button" class="btn btn-link text-danger btn-sm p-0" onclick="this.parentElement.parentElement.remove()"><i class="bi bi-trash3"></i></button>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">NIK Saudara</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control py-2 border-0 shadow-sm nik-lookup" name="saudara[{{ $index }}][nik]" placeholder="16 Digit NIK" value="{{ old('saudara.'.$index.'.nik', $saudara['nik'] ?? '') }}" style="border-radius: 10px 0 0 10px;">
                                        <button type="button" class="btn btn-outline-primary btn-nik-search" title="Cari NIK" style="border-radius: 0 10px 10px 0; border: none; background: #e8f0fe;"><i class="bi bi-search"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Nama Lengkap *</label>
                                    <input type="text" class="form-control py-2 border-0 shadow-sm" name="saudara[{{ $index }}][nama]" placeholder="Nama Lengkap" value="{{ old('saudara.'.$index.'.nama', $saudara['nama'] ?? '') }}" style="border-radius: 10px;">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <select class="form-select py-2 border-0 shadow-sm" name="saudara[{{ $index }}][jenis_kelamin]" style="border-radius: 10px;">
                                        <option value="">Pilih</option>
                                        <option value="L" {{ old('saudara.'.$index.'.jenis_kelamin', $saudara['jenis_kelamin'] ?? '') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('saudara.'.$index.'.jenis_kelamin', $saudara['jenis_kelamin'] ?? '') === 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Status Kawin</label>
                                    <select class="form-select py-2 border-0 shadow-sm" name="saudara[{{ $index }}][status_kawin]" style="border-radius: 10px;">
                                        <option value="">Pilih</option>
                                        @foreach(['Belum Menikah', 'Menikah', 'Cerai Hidup', 'Cerai Mati'] as $skS)
                                            <option value="{{ $skS }}" {{ old('saudara.'.$index.'.status_kawin', $saudara['status_kawin'] ?? '') === $skS ? 'selected' : '' }}>{{ $skS }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Status Saudara</label>
                                    <select class="form-select py-2 border-0 shadow-sm" name="saudara[{{ $index }}][status_saudara]" style="border-radius: 10px;">
                                        <option value="">Pilih</option>
                                        <option value="Kandung" {{ old('saudara.'.$index.'.status_saudara', $saudara['status_saudara'] ?? '') === 'Kandung' ? 'selected' : '' }}>Kandung</option>
                                        <option value="Tiri" {{ old('saudara.'.$index.'.status_saudara', $saudara['status_saudara'] ?? '') === 'Tiri' ? 'selected' : '' }}>Tiri</option>
                                        <option value="Angkat" {{ old('saudara.'.$index.'.status_saudara', $saudara['status_saudara'] ?? '') === 'Angkat' ? 'selected' : '' }}>Angkat</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control py-2 border-0 shadow-sm" name="saudara[{{ $index }}][tanggal_lahir]" value="{{ old('saudara.'.$index.'.tanggal_lahir', $saudara['tanggal_lahir'] ?? '') }}" style="border-radius: 10px;">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Pekerjaan</label>
                                    <input type="text" class="form-control py-2 border-0 shadow-sm" name="saudara[{{ $index }}][pekerjaan]" placeholder="Pekerjaan Saudara" value="{{ old('saudara.'.$index.'.pekerjaan', $saudara['pekerjaan'] ?? '') }}" style="border-radius: 10px;">
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-4 border-2 border-dashed rounded-4" style="background: #fafafa; border-color: #e2e8f0;" id="emptySaudara">
                        <p class="text-muted small mb-0">Belum ada data saudara. Klik "+ Tambah Saudara".</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-5 pt-4 border-top d-flex justify-content-end">
            <button type="button" class="btn btn-primary btn-lg fw-bold px-5 py-3 shadow" onclick="saveSectionData(1)" style="border-radius: 16px; background: #2563eb; border: none; transition: all 0.3s ease;">
                <i class="bi bi-cloud-arrow-up-fill me-2"></i> Simpan Data Keluarga
            </button>
        </div>
    </div>
</div>

<style>
    /* Interaksi Hover pada Sub-card */
    .sub-card { transition: all 0.3s ease; border: 1px solid transparent; }
    .sub-card:hover { transform: translateY(-5px); box-shadow: 0 12px 25px rgba(0,0,0,0.06) !important; background: #fff !important; border: 1px solid #e2e8f0 !important; }
    
    /* Upload Box Style */
    .upload-box:hover { border-color: #2563eb !important; background: #eff6ff !important; }
    
    /* Form Label Styling */
    .form-label { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; font-weight: 700; }
    
    /* Button Hover */
    .btn-primary:hover { transform: scale(1.02); filter: brightness(1.1); }
    .pointer { cursor: pointer; }
</style>