<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --pine-green: #15803d;
        --soft-green-bg: #f0fdf4;
        --accent-indigo: #6366f1;
    }

    .section-card {
        border: none;
        border-radius: 24px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
        overflow: hidden;
        background: #ffffff;
    }

    .section-header {
        background: var(--primary-gradient);
        color: white;
        padding: 1.5rem 2rem;
    }

    .icon-box {
        background: rgba(255,255,255,0.2);
        width: 42px; height: 42px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 12px;
        backdrop-filter: blur(5px);
    }

    .sub-card {
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 20px;
        padding: 24px;
        height: 100%;
        transition: all 0.3s ease;
    }

    .sub-card:hover {
        border-color: var(--accent-indigo);
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.05);
    }

    .sub-card-header {
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1.25rem;
        display: flex; align-items: center; gap: 10px;
    }

    .form-label {
        font-size: 11px;
        font-weight: 800;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control {
        border-radius: 12px;
        padding: 12px 16px;
        border: 2px solid #f8fafc;
        background: #f8fafc;
        transition: 0.2s;
    }

    .form-control:focus {
        background: #fff;
        border-color: var(--accent-indigo);
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }

    /* Box Upload Modern */
    .upload-box {
        border: 2px dashed #cbd5e0;
        border-radius: 16px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        background: #fafafa;
        transition: 0.3s;
    }

    .upload-box:hover {
        border-color: var(--pine-green);
        background: var(--soft-green-bg);
    }

    /* Style Persis Gambar (Success Badge & Button) */
    .status-container {
        background-color: var(--soft-green-bg);
        border-radius: 16px; /* Super rounded */
        padding: 12px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 10px;
    }

    .status-text {
        color: var(--pine-green);
        font-weight: 600;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .status-icon-circle {
        background-color: var(--pine-green);
        color: white;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }

    .btn-lihat-dokumen {
        background-color: var(--pine-green);
        color: white;
        border: none;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        transition: opacity 0.2s;
        text-decoration: none;
    }

    .btn-lihat-dokumen:hover {
        color: white;
        opacity: 0.9;
    }

    .btn-edit-dokumen {
        background-color: #3b82f6;
        color: white;
        border: none;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        transition: opacity 0.2s;
        cursor: pointer;
    }

    .btn-edit-dokumen:hover {
        opacity: 0.9;
    }

    .btn-hapus-dokumen {
        background-color: #ef4444;
        color: white;
        border: none;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        transition: opacity 0.2s;
        cursor: pointer;
    }

    .btn-hapus-dokumen:hover {
        opacity: 0.9;
    }

    .doc-actions {
        display: flex;
        gap: 6px;
        align-items: center;
        flex-wrap: wrap;
    }

    .btn-save-main {
        background: var(--primary-gradient);
        border: none;
        padding: 14px 40px;
        border-radius: 14px;
        font-weight: 700;
        color: white;
        box-shadow: 0 10px 20px rgba(79, 172, 254, 0.3);
    }
</style>

<div class="card section-card">
    <div class="section-header d-flex align-items-center gap-3">
        <div class="icon-box"><i class="bi bi-card-text fs-5"></i></div>
        <div>
            <h5 class="fw-bold mb-0">H. Identitas Legal</h5>
            <small class="opacity-75">Dokumen resmi (Tanpa histori)</small>
        </div>
    </div>
    
    <div class="card-body p-4 p-lg-5">
        <div class="row g-4">
            
            <div class="col-md-6">
                <div class="sub-card">
                    <div class="sub-card-header"><i class="bi bi-person-vcard text-primary"></i> KTP — Kartu Tanda Penduduk</div>
                    <label class="form-label">NIK *</label>
                    <input type="text" class="form-control mb-3" name="nik_ktp" placeholder="16 digit NIK" value="{{ old('nik_ktp', $drhData?->identitas_legal['nik_ktp'] ?? '') }}">
                    
                    @if(!data_get($drhData, 'identitas_legal.file_ktp'))
                        <div class="upload-box" onclick="document.getElementById('file_ktp').click()">
                            <input type="file" name="file_ktp" accept=".pdf" class="d-none" id="file_ktp" onchange="previewName(this, 'ktp-filename')">
                            <i class="bi bi-cloud-arrow-up fs-4 text-muted mb-2 d-block"></i>
                            <span class="small fw-bold text-dark">Klik untuk Upload KTP</span>
                            <div id="ktp-filename" class="text-success small fw-bold mt-1"></div>
                        </div>
                    @else
                        <div class="status-container">
                            <div class="status-text">
                                <div class="status-icon-circle"><i class="bi bi-check-lg"></i></div>
                                Dokumen KTP Tersedia
                            </div>
                            <div class="doc-actions">
                                <a href="{{ url('/profile/drh/file/ktp/view') }}" target="_blank" class="btn-lihat-dokumen" title="Lihat"><i class="bi bi-eye-fill"></i></a>
                                <button type="button" class="btn-edit-dokumen" title="Edit" onclick="triggerReupload('file_ktp_edit', this)"><i class="bi bi-pencil-square"></i></button>
                                <input type="file" name="file_ktp" accept=".pdf" class="d-none" id="file_ktp_edit" onchange="previewReupload(this, 'ktp')">
                                <button type="button" class="btn-hapus-dokumen" title="Hapus" onclick="confirmDelete('ktp')"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <div class="sub-card">
                    <div class="sub-card-header"><i class="bi bi-file-earmark-text text-primary"></i> NPWP</div>
                    <label class="form-label">Nomor NPWP *</label>
                    <input type="text" class="form-control mb-3" name="nomor_npwp" placeholder="00.000.000.0-000.000" value="{{ old('nomor_npwp', $drhData?->identitas_legal['nomor_npwp'] ?? '') }}">
                    
                    @if(!data_get($drhData, 'identitas_legal.file_npwp'))
                        <div class="upload-box" onclick="document.getElementById('file_npwp').click()">
                            <input type="file" name="file_npwp" accept=".pdf" class="d-none" id="file_npwp" onchange="previewName(this, 'npwp-filename')">
                            <i class="bi bi-upload fs-4 text-muted mb-2 d-block"></i>
                            <span class="small fw-bold text-dark">Klik untuk Upload NPWP</span>
                            <div id="npwp-filename" class="text-success small fw-bold mt-1"></div>
                        </div>
                    @else
                        <div class="status-container">
                            <div class="status-text">
                                <div class="status-icon-circle"><i class="bi bi-check-lg"></i></div>
                                Dokumen NPWP Tersedia
                            </div>
                            <div class="doc-actions">
                                <a href="{{ url('/profile/drh/file/npwp/view') }}" target="_blank" class="btn-lihat-dokumen" title="Lihat"><i class="bi bi-eye-fill"></i></a>
                                <button type="button" class="btn-edit-dokumen" title="Edit" onclick="triggerReupload('file_npwp_edit', this)"><i class="bi bi-pencil-square"></i></button>
                                <input type="file" name="file_npwp" accept=".pdf" class="d-none" id="file_npwp_edit" onchange="previewReupload(this, 'npwp')">
                                <button type="button" class="btn-hapus-dokumen" title="Hapus" onclick="confirmDelete('npwp')"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <div class="sub-card">
                    <div class="sub-card-header"><i class="bi bi-shield-check text-primary"></i> BPJS</div>
                    <label class="form-label">Nomor BPJS *</label>
                    <input type="text" class="form-control mb-3" name="nomor_bpjs" placeholder="Masukkan nomor BPJS" value="{{ old('nomor_bpjs', $drhData?->identitas_legal['nomor_bpjs'] ?? '') }}">
                    
                    @if(!data_get($drhData, 'identitas_legal.file_bpjs'))
                        <div class="upload-box" onclick="document.getElementById('file_bpjs').click()">
                            <input type="file" name="file_bpjs" accept=".pdf" class="d-none" id="file_bpjs" onchange="previewName(this, 'bpjs-filename')">
                            <i class="bi bi-shield-plus fs-4 text-muted mb-2 d-block"></i>
                            <span class="small fw-bold text-dark">Klik untuk Upload BPJS</span>
                            <div id="bpjs-filename" class="text-success small fw-bold mt-1"></div>
                        </div>
                    @else
                        <div class="status-container">
                            <div class="status-text">
                                <div class="status-icon-circle"><i class="bi bi-check-lg"></i></div>
                                Dokumen BPJS Tersedia
                            </div>
                            <div class="doc-actions">
                                <a href="{{ url('/profile/drh/file/bpjs/view') }}" target="_blank" class="btn-lihat-dokumen" title="Lihat"><i class="bi bi-eye-fill"></i></a>
                                <button type="button" class="btn-edit-dokumen" title="Edit" onclick="triggerReupload('file_bpjs_edit', this)"><i class="bi bi-pencil-square"></i></button>
                                <input type="file" name="file_bpjs" accept=".pdf" class="d-none" id="file_bpjs_edit" onchange="previewReupload(this, 'bpjs')">
                                <button type="button" class="btn-hapus-dokumen" title="Hapus" onclick="confirmDelete('bpjs')"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <div class="sub-card">
                    <div class="sub-card-header"><i class="bi bi-people text-primary"></i> Kartu Keluarga (KK)</div>
                    <p class="text-muted mb-3" style="font-size: 11px;">Gunakan scan KK asli dalam format PDF (Maks 1 MB).</p>
                    
                    <div class="upload-box mb-2" onclick="document.getElementById('file_kk').click()">
                        <input type="file" name="file_kk" accept=".pdf" class="d-none" id="file_kk" onchange="previewName(this, 'kk-filename')">
                        <i class="bi bi-file-earmark-pdf fs-4 text-muted mb-1 d-block"></i>
                        <span class="small fw-bold text-dark">Pilih File KK</span>
                        <div id="kk-filename" class="text-success small fw-bold mt-1"></div>
                    </div>

                    @if(data_get($drhData, 'identitas_legal.file_kk'))
                        <div class="status-container mt-3">
                            <div class="status-text">
                                <div class="status-icon-circle"><i class="bi bi-check-lg"></i></div>
                                Dokumen KK Tersedia
                            </div>
                            <div class="doc-actions">
                                <a href="{{ url('/profile/drh/file/kk/view') }}" target="_blank" class="btn-lihat-dokumen" title="Lihat"><i class="bi bi-eye-fill"></i></a>
                                <button type="button" class="btn-edit-dokumen" title="Edit" onclick="triggerReupload('file_kk', this)"><i class="bi bi-pencil-square"></i></button>
                                <button type="button" class="btn-hapus-dokumen" title="Hapus" onclick="confirmDelete('kk')"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <div class="mt-5 pt-4 border-top text-center">
            <button type="button" class="btn btn-save-main px-5" onclick="saveSectionData(7)">
                <i class="bi bi-save2-fill me-2"></i> Simpan Data Identitas
            </button>
        </div>
    </div>
</div>

<script>
    function previewName(input, id) {
        const file = input.files[0];
        if (file) {
            document.getElementById(id).innerHTML = `<i class="bi bi-file-earmark-check"></i> ${file.name}`;
        }
    }

    function triggerReupload(inputId, btn) {
        document.getElementById(inputId).click();
    }

    function previewReupload(input, type) {
        const file = input.files[0];
        if (file) {
            const container = input.closest('.status-container');
            const statusText = container.querySelector('.status-text');
            statusText.innerHTML = `<div class="status-icon-circle" style="background-color: #3b82f6;"><i class="bi bi-arrow-repeat"></i></div> <span class="text-primary">File baru: ${file.name}</span>`;
        }
    }

    function confirmDelete(type) {
        const names = { ktp: 'KTP', npwp: 'NPWP', bpjs: 'BPJS', kk: 'KK' };
        if (confirm('Apakah Anda yakin ingin menghapus dokumen ' + (names[type] || type) + '? File yang sudah dihapus tidak bisa dikembalikan.')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ url('/profile/drh/file') }}/" + type + "/delete";

            const tokenInput = document.createElement('input');
            tokenInput.type = 'hidden';
            tokenInput.name = '_token';
            tokenInput.value = '{{ csrf_token() }}';

            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';

            form.appendChild(tokenInput);
            form.appendChild(methodInput);
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>