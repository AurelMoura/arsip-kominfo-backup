<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
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

    .btn-save-main {
        background: var(--primary-gradient);
        border: none;
        padding: 14px 40px;
        border-radius: 14px;
        font-weight: 700;
        color: white;
        box-shadow: 0 10px 20px rgba(79, 172, 254, 0.3);
    }

    .legal-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }

    .legal-table thead tr {
        background: #f8fafc;
    }

    .legal-table thead th {
        padding: 14px 18px;
        font-size: 11px;
        font-weight: 800;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e2e8f0;
    }

    .legal-table tbody tr {
        transition: background 0.2s;
    }

    .legal-table tbody tr:hover {
        background: #f8fafc;
    }

    .legal-table tbody td {
        padding: 14px 18px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
        color: #334155;
        vertical-align: middle;
    }

    .legal-table tbody tr:last-child td {
        border-bottom: none;
    }

    .doc-label {
        font-weight: 700;
        color: #1e293b;
    }

    .doc-nomor {
        font-size: 13px;
        color: #64748b;
        margin-top: 2px;
    }

    .btn-aksi-file {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        text-decoration: none;
        transition: opacity 0.2s, transform 0.1s;
        cursor: pointer;
    }

    .btn-aksi-file:hover:not(.is-locked) {
        opacity: 0.85;
        transform: scale(1.05);
    }

    .btn-aksi-view  { background: #e0f2fe; color: #0284c7; }
    .btn-aksi-edit  { background: #fef3c7; color: #d97706; }
    .btn-aksi-hapus { background: #fee2e2; color: #dc2626; }

    .btn-aksi-file.is-locked {
        opacity: 0.4 !important;
        pointer-events: none !important;
        cursor: not-allowed !important;
    }

    .badge-ada {
        background: #dcfce7;
        color: #15803d;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 20px;
        display: inline-block;
    }

    .badge-tidak {
        background: #f1f5f9;
        color: #94a3b8;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 20px;
        display: inline-block;
    }

    /* ── Form-mode (row belum ada data) ── */
    .lf-input {
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 8px 12px;
        font-size: 13px;
        width: 100%;
        color: #1e293b;
        background: #fff;
        transition: border-color .2s, box-shadow .2s;
        outline: none;
    }
    .lf-input:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,.12); }
    .lf-input::placeholder { color: #b0bec5; }
    .lf-upload-btn {
        display: inline-flex; align-items: center; gap: 6px;
        background: #f1f5f9;
        border: 1.5px dashed #cbd5e1;
        border-radius: 10px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        cursor: pointer;
        transition: background .15s, border-color .15s;
        white-space: nowrap;
    }
    .lf-upload-btn:hover { background: #e0f2fe; border-color: #38bdf8; color: #0284c7; }
    .lf-upload-btn.has-file { background: #f0fdf4; border-color: #86efac; color: #15803d; }
    .lf-file-name { font-size: 11px; color: #15803d; margin-top: 4px; font-weight: 600; display: none; }
    .lf-file-name.show { display: block; }
    .lf-save-single-btn {
        display: inline-flex; align-items: center; gap: 5px;
        background: linear-gradient(135deg,#2563eb,#1d4ed8);
        border: none;
        border-radius: 10px;
        padding: 8px 16px;
        font-size: 12px;
        font-weight: 700;
        color: #fff;
        cursor: pointer;
        transition: opacity .15s, transform .1s;
        white-space: nowrap;
    }
    .lf-save-single-btn:hover { opacity: .88; transform: translateY(-1px); }
    .lf-save-single-btn:disabled { opacity: .45; cursor: not-allowed; transform: none; }
    .lf-file-cell { display: flex; flex-direction: column; gap: 5px; }
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

        @php
            $identitasLegal = $drhData?->identitas_legal ?? [];
            $nikKtp    = $identitasLegal['nik_ktp']    ?? null;
            $nomorNpwp = $identitasLegal['nomor_npwp'] ?? null;
            $nomorBpjs = $identitasLegal['nomor_bpjs'] ?? null;
            $nomorKk   = $identitasLegal['nomor_kk']   ?? null;
            $fileKtp   = $identitasLegal['file_ktp']   ?? null;
            $fileNpwp  = $identitasLegal['file_npwp']  ?? null;
            $fileBpjs  = $identitasLegal['file_bpjs']  ?? null;
            $fileKk    = $identitasLegal['file_kk']    ?? null;
            $isLocked  = $isLockedLegal ?? ($identitasLegal['is_locked_legal'] ?? false);
        @endphp

        <div class="mb-4">
            <table class="legal-table" id="legalTable">
                <thead>
                    <tr>
                        <th style="width:28%">Dokumen</th>
                        <th style="width:28%">Nomor</th>
                        <th>File</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    {{-- KTP --}}
                    <tr id="row-ktp">
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span style="background:#eff6ff;color:#2563eb;width:34px;height:34px;border-radius:10px;display:inline-flex;align-items:center;justify-content:center;">
                                    <i class="bi bi-person-vcard"></i>
                                </span>
                                <div>
                                    <div class="doc-label">KTP</div>
                                    <div class="doc-nomor">Kartu Tanda Penduduk</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($nikKtp)
                                <span class="fw-semibold">{{ $nikKtp }}</span>
                            @else
                                <input type="text" class="lf-input" name="nik_ktp" id="nik_ktp_input"
                                       placeholder="16 digit NIK" maxlength="16" inputmode="numeric"
                                       oninput="this.value=this.value.replace(/\D/g,'').slice(0,16)"
                                       @if($isLocked) disabled @endif>
                            @endif
                        </td>
                        <td>
                            @if($nikKtp)
                                @if($fileKtp)
                                    <span class="badge-ada"><i class="bi bi-check-circle me-1"></i>Ada</span>
                                @else
                                    <span class="badge-tidak"><i class="bi bi-dash-circle me-1"></i>Belum</span>
                                @endif
                            @else
                                <div class="lf-file-cell">
                                    <input type="file" name="file_ktp" accept=".pdf" class="d-none" id="file_ktp"
                                           onchange="lfPreview(this,'lf-fname-ktp','lf-btn-ktp')" @if($isLocked) disabled @endif>
                                    <label for="file_ktp" class="lf-upload-btn" id="lf-btn-ktp"
                                           @if($isLocked) style="pointer-events:none;opacity:.5;" @endif>
                                        <i class="bi bi-cloud-arrow-up"></i>
                                        <span>Pilih File</span>
                                    </label>
                                    <div class="lf-file-name" id="lf-fname-ktp"></div>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2 justify-content-center">
                                @if($nikKtp)
                                    @if($fileKtp)
                                        <a href="{{ url('/profile/drh/file/ktp/view') }}?t={{ time() }}" target="_blank"
                                           class="btn-aksi-file btn-aksi-view" title="Lihat File">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    @endif
                                    <button type="button"
                                            class="btn-aksi-file btn-aksi-edit legal-edit-btn @if($isLocked) is-locked @endif"
                                            title="Edit" onclick="openEditModal('ktp', '{{ $nikKtp }}', {{ $fileKtp ? 'true' : 'false' }})"
                                            @if($isLocked) disabled @endif>
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <button type="button"
                                            class="btn-aksi-file btn-aksi-hapus legal-hapus-btn @if($isLocked) is-locked @endif"
                                            title="Hapus" onclick="confirmDeleteLegal('ktp')"
                                            @if($isLocked) disabled @endif>
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                @else
                                    <button type="button" class="lf-save-single-btn" id="lf-save-ktp"
                                            onclick="lfSaveSingle('ktp')" @if($isLocked) disabled @endif>
                                        <i class="bi bi-save2-fill"></i> Simpan
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>

                    {{-- NPWP --}}
                    <tr id="row-npwp">
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span style="background:#f5f3ff;color:#7c3aed;width:34px;height:34px;border-radius:10px;display:inline-flex;align-items:center;justify-content:center;">
                                    <i class="bi bi-file-earmark-text"></i>
                                </span>
                                <div>
                                    <div class="doc-label">NPWP</div>
                                    <div class="doc-nomor">Nomor Pokok Wajib Pajak</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($nomorNpwp)
                                <span class="fw-semibold">{{ $nomorNpwp }}</span>
                            @else
                                <input type="text" class="lf-input" name="nomor_npwp"
                                       placeholder="00.000.000.0-000.000"
                                       @if($isLocked) disabled @endif>
                            @endif
                        </td>
                        <td>
                            @if($nomorNpwp)
                                @if($fileNpwp)
                                    <span class="badge-ada"><i class="bi bi-check-circle me-1"></i>Ada</span>
                                @else
                                    <span class="badge-tidak"><i class="bi bi-dash-circle me-1"></i>Belum</span>
                                @endif
                            @else
                                <div class="lf-file-cell">
                                    <input type="file" name="file_npwp" accept=".pdf" class="d-none" id="file_npwp"
                                           onchange="lfPreview(this,'lf-fname-npwp','lf-btn-npwp')" @if($isLocked) disabled @endif>
                                    <label for="file_npwp" class="lf-upload-btn" id="lf-btn-npwp"
                                           @if($isLocked) style="pointer-events:none;opacity:.5;" @endif>
                                        <i class="bi bi-cloud-arrow-up"></i>
                                        <span>Pilih File</span>
                                    </label>
                                    <div class="lf-file-name" id="lf-fname-npwp"></div>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2 justify-content-center">
                                @if($nomorNpwp)
                                    @if($fileNpwp)
                                        <a href="{{ url('/profile/drh/file/npwp/view') }}?t={{ time() }}" target="_blank"
                                           class="btn-aksi-file btn-aksi-view" title="Lihat File">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    @endif
                                    <button type="button"
                                            class="btn-aksi-file btn-aksi-edit legal-edit-btn @if($isLocked) is-locked @endif"
                                            title="Edit" onclick="openEditModal('npwp', '{{ $nomorNpwp }}', {{ $fileNpwp ? 'true' : 'false' }})"
                                            @if($isLocked) disabled @endif>
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <button type="button"
                                            class="btn-aksi-file btn-aksi-hapus legal-hapus-btn @if($isLocked) is-locked @endif"
                                            title="Hapus" onclick="confirmDeleteLegal('npwp')"
                                            @if($isLocked) disabled @endif>
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                @else
                                    <button type="button" class="lf-save-single-btn" id="lf-save-npwp"
                                            onclick="lfSaveSingle('npwp')" @if($isLocked) disabled @endif>
                                        <i class="bi bi-save2-fill"></i> Simpan
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>

                    {{-- BPJS --}}
                    <tr id="row-bpjs">
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span style="background:#f0fdf4;color:#15803d;width:34px;height:34px;border-radius:10px;display:inline-flex;align-items:center;justify-content:center;">
                                    <i class="bi bi-shield-check"></i>
                                </span>
                                <div>
                                    <div class="doc-label">BPJS</div>
                                    <div class="doc-nomor">Badan Penyelenggara Jaminan Sosial</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($nomorBpjs)
                                <span class="fw-semibold">{{ $nomorBpjs }}</span>
                            @else
                                <input type="text" class="lf-input" name="nomor_bpjs"
                                       placeholder="Nomor BPJS"
                                       @if($isLocked) disabled @endif>
                            @endif
                        </td>
                        <td>
                            @if($nomorBpjs)
                                @if($fileBpjs)
                                    <span class="badge-ada"><i class="bi bi-check-circle me-1"></i>Ada</span>
                                @else
                                    <span class="badge-tidak"><i class="bi bi-dash-circle me-1"></i>Belum</span>
                                @endif
                            @else
                                <div class="lf-file-cell">
                                    <input type="file" name="file_bpjs" accept=".pdf" class="d-none" id="file_bpjs"
                                           onchange="lfPreview(this,'lf-fname-bpjs','lf-btn-bpjs')" @if($isLocked) disabled @endif>
                                    <label for="file_bpjs" class="lf-upload-btn" id="lf-btn-bpjs"
                                           @if($isLocked) style="pointer-events:none;opacity:.5;" @endif>
                                        <i class="bi bi-cloud-arrow-up"></i>
                                        <span>Pilih File</span>
                                    </label>
                                    <div class="lf-file-name" id="lf-fname-bpjs"></div>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2 justify-content-center">
                                @if($nomorBpjs)
                                    @if($fileBpjs)
                                        <a href="{{ url('/profile/drh/file/bpjs/view') }}?t={{ time() }}" target="_blank"
                                           class="btn-aksi-file btn-aksi-view" title="Lihat File">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    @endif
                                    <button type="button"
                                            class="btn-aksi-file btn-aksi-edit legal-edit-btn @if($isLocked) is-locked @endif"
                                            title="Edit" onclick="openEditModal('bpjs', '{{ $nomorBpjs }}', {{ $fileBpjs ? 'true' : 'false' }})"
                                            @if($isLocked) disabled @endif>
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <button type="button"
                                            class="btn-aksi-file btn-aksi-hapus legal-hapus-btn @if($isLocked) is-locked @endif"
                                            title="Hapus" onclick="confirmDeleteLegal('bpjs')"
                                            @if($isLocked) disabled @endif>
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                @else
                                    <button type="button" class="lf-save-single-btn" id="lf-save-bpjs"
                                            onclick="lfSaveSingle('bpjs')" @if($isLocked) disabled @endif>
                                        <i class="bi bi-save2-fill"></i> Simpan
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>

                    {{-- KK --}}
                    <tr id="row-kk">
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span style="background:#fff7ed;color:#ea580c;width:34px;height:34px;border-radius:10px;display:inline-flex;align-items:center;justify-content:center;">
                                    <i class="bi bi-people"></i>
                                </span>
                                <div>
                                    <div class="doc-label">Kartu Keluarga</div>
                                    <div class="doc-nomor">KK</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($nomorKk)
                                <span class="fw-semibold">{{ $nomorKk }}</span>
                            @else
                                <input type="text" class="lf-input" name="nomor_kk"
                                       placeholder="Nomor KK"
                                       @if($isLocked) disabled @endif>
                            @endif
                        </td>
                        <td>
                            @if($nomorKk)
                                @if($fileKk)
                                    <span class="badge-ada"><i class="bi bi-check-circle me-1"></i>Ada</span>
                                @else
                                    <span class="badge-tidak"><i class="bi bi-dash-circle me-1"></i>Belum</span>
                                @endif
                            @else
                                <div class="lf-file-cell">
                                    <input type="file" name="file_kk" accept=".pdf" class="d-none" id="file_kk"
                                           onchange="lfPreview(this,'lf-fname-kk','lf-btn-kk')" @if($isLocked) disabled @endif>
                                    <label for="file_kk" class="lf-upload-btn" id="lf-btn-kk"
                                           @if($isLocked) style="pointer-events:none;opacity:.5;" @endif>
                                        <i class="bi bi-cloud-arrow-up"></i>
                                        <span>Pilih File</span>
                                    </label>
                                    <div class="lf-file-name" id="lf-fname-kk"></div>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2 justify-content-center">
                                @if($nomorKk)
                                    @if($fileKk)
                                        <a href="{{ url('/profile/drh/file/kk/view') }}?t={{ time() }}" target="_blank"
                                           class="btn-aksi-file btn-aksi-view" title="Lihat File">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    @endif
                                    <button type="button"
                                            class="btn-aksi-file btn-aksi-edit legal-edit-btn @if($isLocked) is-locked @endif"
                                            title="Edit" onclick="openEditModal('kk', '{{ $nomorKk }}', {{ $fileKk ? 'true' : 'false' }})"
                                            @if($isLocked) disabled @endif>
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <button type="button"
                                            class="btn-aksi-file btn-aksi-hapus legal-hapus-btn @if($isLocked) is-locked @endif"
                                            title="Hapus" onclick="confirmDeleteLegal('kk')"
                                            @if($isLocked) disabled @endif>
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                @else
                                    <button type="button" class="lf-save-single-btn" id="lf-save-kk"
                                            onclick="lfSaveSingle('kk')" @if($isLocked) disabled @endif>
                                        <i class="bi bi-save2-fill"></i> Simpan
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        @include('dashboard.drh.legal_form')

    </div>
</div>

{{-- Modal Edit --}}
<div class="modal fade" id="modalEditIdentitas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:20px; border:none; overflow:hidden;">
            <div class="modal-header border-0 pb-0" style="background: var(--primary-gradient);">
                <h6 class="modal-title text-white fw-bold" id="modalEditTitle">Edit Data</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div id="modalEditBody"></div>
            </div>
        </div>
    </div>
</div>

<script>
    const _lfConfig = {
        ktp:  { nomor: 'nik_ktp',    file: 'file_ktp',  label: 'KTP' },
        npwp: { nomor: 'nomor_npwp', file: 'file_npwp', label: 'NPWP' },
        bpjs: { nomor: 'nomor_bpjs', file: 'file_bpjs', label: 'BPJS' },
        kk:   { nomor: 'nomor_kk',   file: 'file_kk',   label: 'Kartu Keluarga' }
    };

    function lfPreview(input, nameId, btnId) {
        const el = document.getElementById(nameId);
        const btn = document.getElementById(btnId);
        if (input.files[0]) {
            el.textContent = input.files[0].name;
            el.classList.add('show');
            if (btn) btn.classList.add('has-file');
        } else {
            el.textContent = '';
            el.classList.remove('show');
            if (btn) btn.classList.remove('has-file');
        }
    }

    function lfSaveSingle(type) {
        const cfg   = _lfConfig[type];
        const btn   = document.getElementById('lf-save-' + type);
        const nomEl = document.querySelector(`[name="${cfg.nomor}"]`);
        const filEl = document.getElementById(cfg.file);

        if (!nomEl || !nomEl.value.trim()) {
            Swal.fire({ icon: 'warning', title: 'Nomor tidak boleh kosong',
                toast: true, position: 'top-end', showConfirmButton: false, timer: 2000 });
            return;
        }

        const formData = new FormData();
        formData.append('step', 7);
        formData.append('_token', '{{ csrf_token() }}');
        formData.append(cfg.nomor, nomEl.value.trim());
        if (filEl && filEl.files[0]) formData.append(cfg.file, filEl.files[0]);

        if (btn) { btn.disabled = true; btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Menyimpan...'; }

        fetch('{{ url('/profile/drh') }}', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({ icon: 'success', title: data.message || 'Data berhasil disimpan',
                    toast: true, position: 'top-end', showConfirmButton: false, timer: 2000 });
                setTimeout(() => location.reload(), 1200);
            } else {
                Swal.fire({ icon: 'error', title: data.message || 'Gagal menyimpan',
                    toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 });
                if (btn) { btn.disabled = false; btn.innerHTML = '<i class="bi bi-save2-fill"></i> Simpan'; }
            }
        })
        .catch(() => {
            Swal.fire({ icon: 'error', title: 'Terjadi kesalahan jaringan',
                toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 });
            if (btn) { btn.disabled = false; btn.innerHTML = '<i class="bi bi-save2-fill"></i> Simpan'; }
        });
    }

    function openEditModal(type, currentValue, hasFile) {
        const names        = { ktp: 'KTP', npwp: 'NPWP', bpjs: 'BPJS', kk: 'Kartu Keluarga' };
        const fields       = { ktp: 'nik_ktp', npwp: 'nomor_npwp', bpjs: 'nomor_bpjs', kk: 'nomor_kk' };
        const placeholders = { ktp: '16 digit NIK', npwp: '00.000.000.0-000.000', bpjs: 'Nomor BPJS', kk: 'Nomor KK' };
        const fileFields   = { ktp: 'file_ktp', npwp: 'file_npwp', bpjs: 'file_bpjs', kk: 'file_kk' };
        const viewUrls     = { ktp: '{{ url('/profile/drh/file/ktp/view') }}?t={{ time() }}', npwp: '{{ url('/profile/drh/file/npwp/view') }}?t={{ time() }}', bpjs: '{{ url('/profile/drh/file/bpjs/view') }}?t={{ time() }}', kk: '{{ url('/profile/drh/file/kk/view') }}?t={{ time() }}' };

        const currentFileHtml = hasFile
            ? `<div class="mb-3 p-3 rounded-3" style="background:#f0fdf4;border:1px solid #86efac;">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-file-earmark-pdf-fill text-success fs-5"></i>
                        <span class="fw-semibold text-success" style="font-size:13px;">File ${names[type]} tersedia</span>
                    </div>
                    <a href="${viewUrls[type]}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-3" style="font-size:11px;">
                        <i class="bi bi-eye me-1"></i>Lihat File Saat Ini
                    </a>
                </div>
               </div>`
            : `<div class="mb-3 p-3 rounded-3" style="background:#f8fafc;border:1px solid #e2e8f0;">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-file-earmark-x text-secondary fs-5"></i>
                    <span class="text-secondary" style="font-size:13px;">Belum ada file ${names[type]}</span>
                </div>
               </div>`;

        document.getElementById('modalEditTitle').textContent = 'Edit ' + names[type];
        document.getElementById('modalEditBody').innerHTML = `
            <div class="mb-3">
                <label class="form-label">Nomor ${names[type]}</label>
                <input type="text" class="form-control" id="editNomor_${type}"
                    value="${currentValue || ''}" placeholder="${placeholders[type]}"
                    ${type === 'ktp' ? 'maxlength="16" inputmode="numeric" pattern="[0-9]{16}" oninput="this.value=this.value.replace(/[^0-9]/g,\'\').slice(0,16)"' : ''}>
            </div>
            ${currentFileHtml}
            <div class="mb-3">
                <label class="form-label">Upload File Baru (PDF, opsional)</label>
                <input type="file" class="form-control" id="editFile_${type}" accept=".pdf"
                    onchange="lfEditPreview(this, '${type}')"> 
                <div id="editFilePreview_${type}" class="mt-2" style="display:none;">
                    <div class="p-2 rounded-3 d-flex align-items-center gap-2" style="background:#eff6ff;border:1px solid #bfdbfe;">
                        <i class="bi bi-file-earmark-pdf-fill text-primary"></i>
                        <span id="editFileName_${type}" class="fw-semibold text-primary" style="font-size:12px;"></span>
                        <span id="editFileSize_${type}" class="text-muted" style="font-size:11px;"></span>
                    </div>
                </div>
                <div class="form-text text-muted">${hasFile ? 'Upload file baru untuk mengganti file yang sudah ada' : 'Pilih file PDF untuk diunggah'}</div>
            </div>
            <div class="d-flex gap-2 justify-content-end mt-4">
                <button type="button" class="btn btn-secondary btn-sm rounded-pill px-4"
                        data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary btn-sm rounded-pill px-4"
                        onclick="submitEdit('${type}', '${fields[type]}', '${fileFields[type]}')">
                    <i class="bi bi-save2 me-1"></i> Simpan
                </button>
            </div>
        `;

        const modal = new bootstrap.Modal(document.getElementById('modalEditIdentitas'));
        modal.show();
    }

    function lfEditPreview(input, type) {
        const previewEl  = document.getElementById('editFilePreview_' + type);
        const nameEl     = document.getElementById('editFileName_' + type);
        const sizeEl     = document.getElementById('editFileSize_' + type);
        if (input.files[0]) {
            const file = input.files[0];
            const sizeKb = (file.size / 1024).toFixed(1);
            const sizeDisplay = file.size > 1024 * 1024
                ? (file.size / (1024 * 1024)).toFixed(2) + ' MB'
                : sizeKb + ' KB';
            nameEl.textContent = file.name;
            sizeEl.textContent = '(' + sizeDisplay + ')';
            previewEl.style.display = 'block';
        } else {
            previewEl.style.display = 'none';
        }
    }

    function submitEdit(type, fieldName, fileFieldName) {
        const nomorEl = document.getElementById('editNomor_' + type);
        const fileEl  = document.getElementById('editFile_' + type);

        if (!nomorEl.value.trim()) {
            Swal.fire({ icon: 'warning', title: 'Nomor tidak boleh kosong',
                toast: true, position: 'top-end', showConfirmButton: false, timer: 2000 });
            return;
        }

        const formData = new FormData();
        formData.append('step', 7);
        formData.append('_token', '{{ csrf_token() }}');
        formData.append(fieldName, nomorEl.value.trim());
        if (fileEl.files[0]) {
            formData.append(fileFieldName, fileEl.files[0]);
        }

        Swal.fire({ icon: 'info', title: 'Menyimpan...', toast: true,
            position: 'top-end', showConfirmButton: false, timer: 1000 });

        fetch('{{ url('/profile/drh') }}', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            bootstrap.Modal.getInstance(document.getElementById('modalEditIdentitas')).hide();
            if (data.status === 'success') {
                Swal.fire({ icon: 'success', title: data.message || 'Data berhasil disimpan',
                    toast: true, position: 'top-end', showConfirmButton: false, timer: 2000 });
                setTimeout(() => location.reload(), 1200);
            } else {
                Swal.fire({ icon: 'error', title: data.message || 'Gagal menyimpan',
                    toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 });
            }
        })
        .catch(() => {
            Swal.fire({ icon: 'error', title: 'Terjadi kesalahan',
                toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 });
        });
    }

    function confirmDeleteLegal(type) {
        const names   = { ktp: 'KTP', npwp: 'NPWP', bpjs: 'BPJS', kk: 'KK' };
        const docName = names[type] || type;

        Swal.fire({
            icon: 'warning',
            title: 'Konfirmasi Hapus',
            text: `Data ${docName} akan dihapus dari database.`,
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            confirmButtonColor: '#ef4444',
            cancelButtonText: 'Batal',
            cancelButtonColor: '#64748b',
            width: '380px',
            customClass: { popup: 'rounded-4 shadow-lg' }
        }).then((result) => {
            if (!result.isConfirmed) return;

            Swal.fire({ icon: 'info', title: 'Menghapus...', toast: true,
                position: 'top-end', showConfirmButton: false, timer: 1200 });

            fetch(`{{ url('/profile/drh/file') }}/${type}/delete`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new URLSearchParams({ _method: 'DELETE' })
            })
            .then(r => r.json())
            .then(data => {
                if (data.status === 'success' || data.success) {
                    Swal.fire({ icon: 'success',
                        title: data.message || `Dokumen ${docName} berhasil dihapus`,
                        toast: true, position: 'top-end', showConfirmButton: false, timer: 2000 });
                    setTimeout(() => location.reload(), 1200);
                } else {
                    Swal.fire({ icon: 'error',
                        title: data.message || 'Gagal menghapus dokumen',
                        toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 });
                }
            })
            .catch(() => {
                Swal.fire({ icon: 'error', title: 'Gagal menghapus dokumen',
                    toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 });
            });
        });
    }

    function previewName(input, id) {
        const file = input.files[0];
        if (file) {
            document.getElementById(id).innerHTML = `<i class="bi bi-file-earmark-check"></i> ${file.name}`;
        }
    }

    function saveSectionData(stepNumber) {
        const form = document.getElementById('identitasForm');
        if (form) {
            document.getElementById('identitasStep').value = stepNumber;
        }
        submitIdentitasAjax();
    }
</script>
