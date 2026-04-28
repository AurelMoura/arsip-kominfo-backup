<div class="card section-card border-0 shadow-sm overflow-hidden" style="border-radius: 24px;">
    <div class="section-header d-flex align-items-center justify-content-between gap-3 p-4" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white;">
        <div class="d-flex align-items-center gap-3">
            <div class="icon-box shadow-sm" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(4px); border-radius: 14px; width: 48px; height: 48px; display: grid; place-items: center;">
                <i class="bi bi-person-badge-fill fs-4"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-0" style="letter-spacing: 0.5px;">A. Profil Dasar</h5>
                <small class="opacity-75">Kelola identitas pribadi dan informasi kepegawaian Anda</small>
            </div>
        </div>
        <div class="badge bg-white bg-opacity-20 rounded-pill px-3 py-2 text-uppercase" style="font-size: 10px; letter-spacing: 1px;">Step 1 of 8</div>
    </div>

    <div class="card-body p-4 p-lg-5 text-start bg-white">
        <div class="row g-4 mb-5">
            <div class="col-12">
                <h6 class="fw-bold text-primary d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-info-circle-fill"></i> Identitas Akun
                </h6>
            </div>
            <div class="col-md-6">
                <label class="form-label">NIP Sistem</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0" style="border-radius: 12px 0 0 12px;"><i class="bi bi-key-fill text-muted"></i></span>
                    <input type="text" class="form-control bg-light border-start-0 py-2" value="{{ Session::get('identifier') }}" style="border-radius: 0 12px 12px 0; font-weight: 600; color: #64748b;" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Nama Terdaftar</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0" style="border-radius: 12px 0 0 12px;"><i class="bi bi-person-check-fill text-muted"></i></span>
                    <input type="text" class="form-control bg-light border-start-0 py-2" value="{{ Session::get('name') }}" style="border-radius: 0 12px 12px 0; font-weight: 600; color: #64748b;" readonly>
                </div>
            </div>
        </div>

        <hr class="my-5 opacity-10">

        <div class="row g-4 mb-5">
            <div class="col-12">
                <h6 class="fw-bold text-primary d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-person-lines-fill"></i> Data Pribadi
                </h6>
            </div>
            <div class="col-md-12">
                <label class="form-label">Nomor Induk Kependudukan (NIK) <span class="text-danger">*</span></label>
                <input type="text" class="form-control py-2 shadow-sm" name="nik" placeholder="Masukan 16 digit NIK sesuai KTP" value="{{ old('nik', $drhData?->no_nik ?? '') }}" minlength="16" maxlength="16" inputmode="numeric" pattern="[0-9]{16}" style="border-radius: 12px;">
            </div>
            <div class="col-12">
                <label class="form-label">Alamat Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control py-2 shadow-sm" name="email" placeholder="nama@kominfo.go.id" value="{{ old('email', $drhData?->email ?? '') }}" style="border-radius: 12px;">
            </div>
            <div class="col-12">
                <label class="form-label">No. Handphone (WhatsApp) <span class="text-danger">*</span></label>
                <input type="text" class="form-control py-2 shadow-sm" name="no_hp" placeholder="Contoh: 0812..." value="{{ old('no_hp', $drhData?->no_hp ?? '') }}" style="border-radius: 12px;">
            </div>
            <div class="col-12">
                <label class="form-label">Alamat Lengkap Domisili <span class="text-danger">*</span></label>
                <textarea class="form-control shadow-sm" name="alamat_domisili" rows="3" placeholder="Nama jalan, nomor rumah, RT/RW, dsb" style="border-radius: 12px;">{{ old('alamat_domisili', $drhData?->alamat ?? '') }}</textarea>
            </div>
            <div class="col-12">
                <label class="form-label">Alamat Sesuai KTP <span class="text-danger">*</span></label>
                <textarea class="form-control shadow-sm" name="alamat_sesuai_ktp" rows="3" placeholder="Alamat lengkap sesuai KTP" style="border-radius: 12px;">{{ old('alamat_sesuai_ktp', $drhData?->alamat_ktp ?? '') }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                <input type="text" class="form-control py-2 shadow-sm" name="tempat_lahir" placeholder="Kota" value="{{ old('tempat_lahir', $drhData?->tempat_lahir ?? '') }}" style="border-radius: 12px;">
            </div>
            <div class="col-md-6">
                <label class="form-label">Kabupaten Asal <span class="text-danger">*</span></label>
                <input type="text" class="form-control py-2 shadow-sm" name="kabupaten_asal" placeholder="Kabupaten" value="{{ old('kabupaten_asal', $drhData?->kabupaten_asal ?? '') }}" style="border-radius: 12px;">
            </div>
            <div class="col-12">
                <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                <input type="date" class="form-control py-2 shadow-sm" name="tanggal_lahir" value="{{ old('tanggal_lahir', $drhData?->tanggal_lahir?->format('Y-m-d') ?? '') }}" style="border-radius: 12px;">
            </div>
            <div class="col-12">
                <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                <select class="form-select py-2 shadow-sm" name="jenis_kelamin" style="border-radius: 12px;">
                    <option value="">Pilih</option>
                    <option value="Laki-laki" {{ old('jenis_kelamin', ($drhData?->jenis_kelamin === 'L' ? 'Laki-laki' : ($drhData?->jenis_kelamin === 'P' ? 'Perempuan' : ''))) === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin', ($drhData?->jenis_kelamin === 'L' ? 'Laki-laki' : ($drhData?->jenis_kelamin === 'P' ? 'Perempuan' : ''))) === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label">Agama <span class="text-danger">*</span></label>
                <select class="form-select py-2 shadow-sm" name="agama" style="border-radius: 12px;">
                    <option value="">Pilih</option>
                    @foreach($agamaList as $agama)
                    <option value="{{ $agama->nama }}" {{ old('agama', $drhData?->nama_agama ?? '') === $agama->nama ? 'selected' : '' }}>{{ $agama->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <label class="form-label">Golongan Darah <span class="text-danger">*</span></label>
                <select class="form-select py-2 shadow-sm" name="golongan_darah" style="border-radius: 12px;">
                    <option value="">Pilih</option>
                    <option value="A" {{ old('golongan_darah', $drhData?->gol_darah ?? '') === 'A' ? 'selected' : '' }}>A</option>
                    <option value="B" {{ old('golongan_darah', $drhData?->gol_darah ?? '') === 'B' ? 'selected' : '' }}>B</option>
                    <option value="AB" {{ old('golongan_darah', $drhData?->gol_darah ?? '') === 'AB' ? 'selected' : '' }}>AB</option>
                    <option value="O" {{ old('golongan_darah', $drhData?->gol_darah ?? '') === 'O' ? 'selected' : '' }}>O</option>
                </select>
            </div>
        </div>

        <hr class="my-5 opacity-10">

        <div class="row g-4 mb-4">
            <div class="col-12">
                <h6 class="fw-bold text-primary d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-briefcase-fill"></i> Informasi Kepegawaian
                </h6>
            </div>
            <div class="col-12">
                <label class="form-label">Status Pernikahan <span class="text-danger">*</span></label>
                <select class="form-select py-2 shadow-sm" id="statusPegawai" name="status_pegawai" onchange="toggleFamilyLogic()" style="border-radius: 12px;">
                    <option value="Belum Menikah" {{ old('status_pegawai', ($drhData?->status_kawin === 'BM' ? 'Belum Menikah' : ($drhData?->status_kawin === 'M' ? 'Menikah' : ($drhData?->status_kawin === 'CH' ? 'Cerai Hidup' : ($drhData?->status_kawin === 'CM' ? 'Cerai Mati' : ''))))) === 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                    <option value="Menikah" {{ old('status_pegawai', ($drhData?->status_kawin === 'BM' ? 'Belum Menikah' : ($drhData?->status_kawin === 'M' ? 'Menikah' : ($drhData?->status_kawin === 'CH' ? 'Cerai Hidup' : ($drhData?->status_kawin === 'CM' ? 'Cerai Mati' : ''))))) === 'Menikah' ? 'selected' : '' }}>Menikah</option>
                    <option value="Cerai Hidup" {{ old('status_pegawai', ($drhData?->status_kawin === 'BM' ? 'Belum Menikah' : ($drhData?->status_kawin === 'M' ? 'Menikah' : ($drhData?->status_kawin === 'CH' ? 'Cerai Hidup' : ($drhData?->status_kawin === 'CM' ? 'Cerai Mati' : ''))))) === 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                    <option value="Cerai Mati" {{ old('status_pegawai', ($drhData?->status_kawin === 'BM' ? 'Belum Menikah' : ($drhData?->status_kawin === 'M' ? 'Menikah' : ($drhData?->status_kawin === 'CH' ? 'Cerai Hidup' : ($drhData?->status_kawin === 'CM' ? 'Cerai Mati' : ''))))) === 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label">Jenis ASN <span class="text-danger">*</span></label>
                <select class="form-select py-2 shadow-sm" id="jenisAsn" name="jenis_asn" onchange="handleAsnChange(false)" style="border-radius: 12px;">
                    <option value="">Pilih jenis</option>
                    <option value="PNS" {{ old('jenis_asn', $drhData?->status_pegawai ?? '') === 'PNS' ? 'selected' : '' }}>PNS</option>
                    <option value="PPPK" {{ old('jenis_asn', $drhData?->status_pegawai ?? '') === 'PPPK' ? 'selected' : '' }}>PPPK</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Jabatan</label>
                <input type="text" id="profilDasarJenisJabatan" class="form-control py-2 shadow-sm bg-light" value="{{ $drhData?->jenis_jabatan ?? '-' }}" style="border-radius: 12px;" readonly disabled>
            </div>
            <div class="col-md-6">
                <label class="form-label">Eselon</label>
                <input type="text" id="profilDasarEselonJabatan" class="form-control py-2 shadow-sm bg-light" value="{{ $drhData?->eselon_jabatan ?? '-' }}" style="border-radius: 12px;" readonly disabled>
            </div>
            <div class="col-12">
                <label class="form-label">Nama Jabatan</label>
                <input type="text" id="profilDasarNamaJabatan" class="form-control py-2 shadow-sm bg-light" value="{{ $drhData?->nama_jabatan ?? '-' }}" style="border-radius: 12px;" readonly disabled>
            </div>
            <div class="col-md-6">
                <label class="form-label">TMT Jabatan</label>
                <input type="text" id="profilDasarTmtJabatan" class="form-control py-2 shadow-sm bg-light" value="{{ $drhData?->tmt_jabatan ? $drhData->tmt_jabatan->format('d-m-Y') : '-' }}" style="border-radius: 12px;" readonly disabled>
            </div>
            <div class="col-12">
                <div class="alert alert-info border-0 rounded-4 mb-0" style="background: #eff6ff; color: #1e40af;">
                    Data jabatan, eselon, nama jabatan, dan TMT jabatan diisi otomatis dari bagian E. Riwayat Jabatan.
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Golongan/Pangkat <span class="text-danger">*</span></label>
                <select class="form-select py-2 shadow-sm" id="golongan" name="golongan" style="border-radius: 12px;">
                    <option value="">Pilih golongan</option>
                </select>
                <input type="hidden" id="savedGolongan" value="{{ old('golongan', $drhData?->golongan_pangkat ?? '') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">TMT (Terhitung Mulai Tanggal) <span class="text-danger">*</span></label>
                <input type="date" class="form-control py-2 shadow-sm" name="tmt" value="{{ old('tmt', $drhData?->tmt?->format('Y-m-d') ?? '') }}" style="border-radius: 12px;">
            </div>
            <div class="col-12">
                <label class="form-label">Unit Kerja <span class="text-danger">*</span></label>
                <select class="form-select py-2 shadow-sm" name="unit_kerja_id" style="border-radius: 12px;">
                    <option value="">Pilih unit kerja</option>
                    @foreach($unitKerjaList as $unitKerja)
                    <option value="{{ $unitKerja->id }}" {{ old('unit_kerja_id', $drhData?->unit_kerja_id ?? '') == $unitKerja->id ? 'selected' : '' }}>{{ $unitKerja->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mt-5 pt-4 border-top d-flex justify-content-end">
            <button type="button" class="btn btn-primary btn-lg fw-bold px-5 py-3 shadow" onclick="saveSectionData(0)" style="border-radius: 16px; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); background: #2563eb; border: none;">
                <i class="bi bi-cloud-arrow-up-fill me-2"></i> Simpan Profil Dasar
            </button>
        </div>
    </div>
</div>

<style>
    /* Tambahan style khusus untuk interaksi form */
    .form-control:focus, .form-select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1) !important;
        transform: translateY(-1px);
    }
    
    .form-label {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #475569;
        margin-bottom: 8px;
    }

    .section-card {
        transition: transform 0.3s ease;
    }

    button[type="button"]:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2) !important;
        background: #1d4ed8 !important;
    }
</style>

<script>
    const savedGolongan = document.getElementById('savedGolongan') ? document.getElementById('savedGolongan').value : '';
    const pangkatsData = @json($pangkatList);

    function loadGolongan(jenisAsn, isRestore) {
        const golSelect = document.getElementById('golongan');
        let currentVal = golSelect.value;
        if (isRestore && savedGolongan) {
            currentVal = savedGolongan;
        }

        const filtered = pangkatsData.filter(p => !jenisAsn || p.jenis_asn === jenisAsn || p.jenis_asn === 'Keduanya');

        golSelect.innerHTML = '<option value="">Pilih golongan</option>';
        filtered.forEach(p => {
            const opt = document.createElement('option');
            opt.value = p.golongan;
            opt.textContent = `${p.golongan} - ${p.nama}`;
            if (p.golongan === currentVal) {
                opt.selected = true;
            }
            golSelect.appendChild(opt);
        });
    }

    function handleAsnChange(isRestore) {
        const jenisAsn = document.getElementById('jenisAsn').value;
        loadGolongan(jenisAsn, isRestore);
    }

    // Auto-trigger cascade on page load if data exists
    document.addEventListener('DOMContentLoaded', function() {
        const asnSelect = document.getElementById('jenisAsn');
        if (asnSelect.value) {
            handleAsnChange(true);
        } else {
            loadGolongan('', true);
        }
    });
</script>