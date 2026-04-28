@extends('layouts.app')

@push('styles')
        <style>
            @media print {
                @page {
                    margin: 2cm;
                }
                body {
                    margin: 0 !important;
                    padding: 0 !important;
                }
                .section-header, .kop-header, .kop, .kop-surat {
                    margin-top: 0 !important;
                    padding-top: 0 !important;
                }
                .main-content, .container, .card, .section-card, .sub-card, .card-body, .row, .col-md-6, .col-md-12, .col-md-3, .col-12 {
                    margin-top: 0 !important;
                    margin-bottom: 0 !important;
                    padding-top: 0 !important;
                    padding-bottom: 0 !important;
                }
                .main-content {
                    padding: 0 !important;
                }
                .page-header-label, h1, h2, h3, h4, h5, h6, p, label, .form-label, .alert, .alert-warning, .alert-dismissible, .rounded-4, .shadow-sm, .mb-4, .mb-3, .mb-0, .pb-2, .pb-4, .pt-0, .pt-4, .gap-3, .gap-2, .py-5, .py-4, .py-3, .py-2, .py-1, .px-4, .px-3, .px-2, .px-1 {
                    margin: 0 !important;
                    padding: 0 !important;
                }
                * {
                    box-sizing: border-box !important;
                }
                html, body {
                    width: 100% !important;
                    height: 100% !important;
                    font-size: 12pt !important;
                }
                /* Gunakan satuan cm/mm untuk spacing jika diperlukan */
                .main-content, .container, .section-card, .sub-card {
                    width: 100% !important;
                    max-width: 100% !important;
                }
                /* Hilangkan elemen yang tidak perlu di print */
                .btn, .step-progress, .btn-back-profile, .success-notification, .alert, .alert-warning, .alert-dismissible, .shadow-sm, .rounded-4, .upload-box, .doc-actions, .btn-lihat-dokumen, .btn-edit-dokumen, .btn-hapus-dokumen {
                    display: none !important;
                }
            }
        </style>
    <style>
        :root { 
            --sidebar-color: #1e3a5f; 
            --primary-blue: #2563eb; 
            --light-blue: #eff6ff; 
            --border-blue: #dbeafe; 
        }
        
        /* AGGRESSIVE OVERRIDE: Make DRH page match admin layout */
        html, body {
            margin: 0 !important;
            padding: 0 !important;
        }
        
        .app-shell {
            display: flex !important;
            flex-direction: row !important;
            min-height: 100vh !important;
            width: 100% !important;
        }
        
        .app-content {
            flex: 1 !important;
            width: 1px !important;
            overflow-x: hidden !important;
            display: flex !important;
            flex-direction: column !important;
            margin-left: 0 !important;
            padding: 0 !important;
        }
        
        .app-main {
            padding: 20px !important;
            width: 100% !important;
            margin: 0 !important;
            flex: 1 !important;
            overflow-x: hidden !important;
        }
        
        .app-main .main-content {
            margin-left: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }
        
        body { background: #eef3fb; font-family: 'Inter', sans-serif; margin: 0; }
        .main-content { padding: 0; min-height: 100vh; width: 100%; margin: 0; }
        .container, .container-fluid { padding-left: 0 !important; padding-right: 0 !important; margin-left: 0 !important; margin-right: 0 !important; }
        .page-header-label { color: #2563eb; font-weight: 700; font-size: 12px; letter-spacing: 1px; text-transform: uppercase; border-left: 3px solid #2563eb; padding-left: 10px; margin-bottom: 10px; }
        .icon-box { width: 42px; height: 42px; border-radius: 14px; background: rgba(255,255,255,0.18); display: grid; place-items: center; font-size: 1.1rem; }
        
        /* Remove all padding from form elements */
        #drhForm { padding: 0; margin: 0; }
        .form-step { margin: 0; padding: 0; }
        
        .section-card { border: none; border-radius: 18px; overflow: hidden; box-shadow: 0 10px 28px rgba(15, 23, 42, 0.08); background: white; margin-bottom: 16px; }
        .section-card .card-body { background: #fbfdff; }
        .sub-card { background: var(--light-blue); border: 1px solid var(--border-blue); border-radius: 14px; padding: 20px; margin-bottom: 16px; position: relative; transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .sub-card:hover { transform: translateY(-2px); box-shadow: 0 12px 24px rgba(15, 23, 42, 0.08); }
        .sub-card-header { font-size: 13px; font-weight: 700; color: #2563eb; margin-bottom: 15px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #dbeafe; padding-bottom: 8px; }

        /* Progress Steps */
        .step-progress { display: flex; justify-content: space-between; gap: 10px; margin-bottom: 20px; background: white; padding: 16px; border-radius: 18px; box-shadow: 0 4px 18px rgba(0,0,0,0.08); overflow-x: auto; }
        .step-item { flex: 1; text-align: center; font-size: 11px; font-weight: 700; color: #94a3b8; min-width: 70px; cursor: pointer; border: none; background: none; padding: 0; text-transform: uppercase; }
        .step-item:focus { outline: none; }
        .step-item { flex: 1; text-align: center; font-size: 10px; font-weight: 700; color: #cbd5e1; min-width: 65px; }
        .step-item.disabled { opacity: 0.45; pointer-events: none; cursor: not-allowed; }
        .step-item.disabled .step-num { border-color: #e2e8f0; }
        .step-item.active { color: var(--primary-blue); }
        .step-num { width: 26px; height: 26px; line-height: 23px; border: 2px solid #cbd5e1; border-radius: 50%; display: block; margin: 0 auto 5px; background: white; }
        .step-item.active .step-num { background: var(--primary-blue); color: white; border-color: var(--primary-blue); }

        /* Card Styles */
        .section-card { border: none; border-radius: 18px; overflow: hidden; box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06); background: white; margin-bottom: 16px; }
        .section-header { background: linear-gradient(90deg, #2563eb, #1d4ed8); color: white; padding: 14px 20px; }
        .sub-card { background: var(--light-blue); border: 1px solid var(--border-blue); border-radius: 14px; padding: 20px; margin-bottom: 16px; position: relative; }
        .sub-card-header { font-size: 13px; font-weight: 700; color: #2563eb; margin-bottom: 15px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #dbeafe; padding-bottom: 8px; }

        .form-label { font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 6px; }
        .form-control, .form-select { border-radius: 10px; padding: 10px 15px; border: 1px solid #e2e8f0; background-color: #f8fafc; font-size: 14px; }
        .form-control:focus { background-color: white; border-color: var(--primary-blue); box-shadow: none; }
        
        /* Override Bootstrap padding on DRH card bodies */
        .section-card .card-body.p-4,
        .section-card .card-body.p-lg-5 {
            padding: 24px !important;
        }
        @media (min-width: 992px) {
            .section-card .card-body {
                padding: 24px !important;
            }
        }

        .upload-box { border: 2px dashed #93c5fd; background: #f8fbff; border-radius: 12px; padding: 15px; color: #2563eb; text-align: center; cursor: pointer; font-size: 13px; transition: 0.2s; }
        .upload-box:hover { background: #eff6ff; }
        .empty-state { border: 2px dashed #cbd5e1; border-radius: 14px; padding: 40px; text-align: center; color: #94a3b8; font-size: 14px; }

        /* Shared DRH Document Status Styles */
        .status-container {
            background-color: #f0fdf4;
            border-radius: 16px;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 10px;
        }
        .status-text {
            color: #15803d;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .status-icon-circle {
            background-color: #15803d;
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
            background-color: #15803d;
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
        .btn-lihat-dokumen:hover { color: white; opacity: 0.9; }
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
        .btn-edit-dokumen:hover { opacity: 0.9; }
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
        .btn-hapus-dokumen:hover { opacity: 0.9; }
        .doc-actions {
            display: flex;
            gap: 6px;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn-back-profile {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.3px;
            color: #1d4ed8;
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            border: 1px solid #93c5fd;
            text-decoration: none;
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.12);
        }

        .btn-back-profile:hover {
            color: #1e3a8a;
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            border-color: #60a5fa;
        }

        .btn-nav-group { background: white; padding: 16px 20px; border-radius: 18px; display: flex; justify-content: space-between; gap: 10px; flex-wrap: wrap; margin-top: 20px; }
        .form-step { display: none; }
        .form-step.active { display: block; animation: slideUp 0.4s ease-out; }
        @keyframes slideUp { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }

        /* Success Notification Styles */
        .success-notification {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #10b981;
            color: white;
            padding: 14px 20px;
            width: auto !important;
            max-width: min(520px, calc(100vw - 32px));
            border-radius: 12px;
            box-shadow: 0 20px 50px rgba(16, 185, 129, 0.3);
            z-index: 9999;
            animation: slideDown 0.3s ease-out;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            font-size: 15px;
        }

        @keyframes slideDown {
            from { top: -100px; opacity: 0; }
            to { top: 50%; opacity: 1; }
        }

        @keyframes slideUp_out {
            from { top: 50%; opacity: 1; }
            to { top: -100px; opacity: 0; }
        }

        .success-notification.fade-out {
            animation: slideUp_out 0.3s ease-out forwards;
        }

        .notification-content {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .notification-content i {
            font-size: 24px;
        }

        /* Ensure full width content without gaps */
        .main-content > * {
            width: 100%;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        .main-content form {
            width: 100%;
            margin: 0;
            padding: 0;
            max-width: none !important;
        }
        
        .section-card,
        .step-progress,
        .alert,
        .btn-nav-group {
            margin-left: 0 !important;
            margin-right: 0 !important;
            max-width: none !important;
        }

        @media (max-width: 991px) { 
            .app-main {
                padding: 15px !important;
            }
        }
        @media (max-width: 576px) { 
            .app-main { padding: 10px !important; }
            .step-item { min-width: 48px !important; font-size: 8px !important; }
            .step-num { width: 20px !important; height: 20px !important; line-height: 18px !important; font-size: 10px !important; }
            .step-progress { padding: 10px 8px !important; gap: 4px !important; }
            .section-card .card-body { padding: 14px !important; }
            .sub-card { padding: 14px !important; }
            .btn-nav-group { padding: 12px !important; flex-direction: column !important; }
            .btn-nav-group .btn { width: 100% !important; }
        }
        }

        /* Stack all input columns vertically for DRH steps B-G */
        .form-step:not(:first-child) .row > [class*="col-"] {
            width: 100%;
            flex: 0 0 100%;
            max-width: 100%;
        }

        /* Ringkasan tampilan data terisi: detail berbaris ke samping */
        .drh-row-view .row {
            display: grid !important;
            grid-template-columns: repeat(6, minmax(170px, 1fr));
            gap: 12px !important;
            overflow-x: auto;
        }

        .drh-row-view .row > [class*="col-"] {
            width: 100% !important;
            max-width: 100% !important;
            flex: unset !important;
        }

        .drh-row-view .form-control,
        .drh-row-view .form-select,
        .drh-row-view textarea {
            background: #f8fafc;
        }

        #drhAddModal .modal-dialog {
            max-width: 960px;
        }

        #drhAddModal .modal-body {
            max-height: 70vh;
            overflow-y: auto;
        }

        /* Tabel data tersimpan DRH */
        .drh-subtable { border-radius: 16px; overflow: hidden; border: 1px solid #f1f5f9; }
        .drh-subtable th { background: #f8fafc; text-transform: uppercase; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.05em; padding: 18px; color: #64748b; }
        .drh-subtable td { padding: 16px; vertical-align: middle; }
    </style>
@endpush

@section('content')

<div class="main-content">
    <!-- Success Notification -->
    <div id="successNotification" class="success-notification" style="display: none;">
        <i class="bi bi-check-circle-fill"></i>
        <span id="notificationMessage">Data berhasil disimpan</span>
    </div>

    <div class="d-flex flex-column flex-md-row align-items-start justify-content-between gap-3 mb-4">
        <div>
            <div class="page-header-label">Daftar Riwayat Hidup</div>
            <h1 class="fw-bold">Daftar Riwayat Hidup</h1>
            <p class="text-muted small">Lengkapi data DRH Anda dan navigasi langsung ke setiap bagian melalui huruf di atas.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ url('/profile') }}" class="btn-back-profile">
                <i class="bi bi-arrow-left-circle-fill"></i>
                <span>Kembali ke Kelola Profil</span>
            </a>
        </div>
    </div>
    <div class="step-progress">
        <button class="step-item active" id="s0" type="button" onclick="setStep(0)"><span class="step-num">A</span>Profil</button>
        <button class="step-item" id="s1" type="button" onclick="setStep(1)"><span class="step-num">B</span>Jabatan</button>
        <button class="step-item" id="s2" type="button" onclick="setStep(2)"><span class="step-num">C</span>Keluarga</button>
        <button class="step-item" id="s3" type="button" onclick="setStep(3)"><span class="step-num">D</span>Pendidikan</button>
        <button class="step-item" id="s4" type="button" onclick="setStep(4)"><span class="step-num">E</span>Diklat</button>
        <button class="step-item" id="s5" type="button" onclick="setStep(5)"><span class="step-num">F</span>Penghargaan</button>
        <button class="step-item" id="s6" type="button" onclick="setStep(6)"><span class="step-num">G</span>Sertifikasi</button>
        <button class="step-item" id="s7" type="button" onclick="setStep(7)"><span class="step-num">H</span>Legal</button>
    </div>

    @if (!$profilDasarLengkap)
        <div class="alert alert-warning alert-dismissible fade show border-0 shadow-sm mb-4 rounded-4 p-4 text-start" role="alert">
            <div class="d-flex align-items-start">
                <i class="bi bi-exclamation-triangle-fill me-3" style="font-size: 20px; color: #ff9800;"></i>
                <div>
                    <h6 class="fw-bold mb-2" style="color: #ff6f00;">⚠️ Isi A. PROFIL DASAR terlebih dahulu</h6>
                    <p class="mb-0 small">Bagian B sampai H terkunci sampai Profil Dasar selesai disimpan. Lengkapi data A untuk membuka semua bagian DRH.</p>
                </div>
            </div>
        </div>
    @endif




    <form id="drhForm" action="{{ url('/profile/drh') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="step" id="stepInput" value="0">
        <input type="hidden" name="lock_drh" id="lockDrhInput" value="">
        @php
            $anakRows = old('anak', $drhData?->data_keluarga['anak'] ?? []);
            $saudaraRows = old('saudara', $drhData?->data_keluarga['saudara'] ?? []);
            $pendidikanRows = old('pendidikan', $pendidikanRows ?? []);
            $diklatRows = old('diklat', $drhData?->riwayat_diklat ?? []);
            $jabatanRows = old('riwayat_jabatan', $drhData?->riwayat_jabatan ?? []);
            $awardRows = old('award', $drhData?->riwayat_penghargaan ?? []);
            $sertifRows = old('sertif', $drhData?->riwayat_sertifikasi ?? []);
        @endphp

        <div class="form-step active">
            @include('dashboard.drh.isidata.profildasar')
        </div>

        <div class="form-step">
            @include('dashboard.drh.isidata.jabatan')
        </div>

        <div class="form-step">
            @include('dashboard.drh.isidata.keluarga')
        </div>

        <div class="form-step">
            @include('dashboard.drh.isidata.pendidikan')
        </div>

        <div class="form-step">
            @include('dashboard.drh.isidata.diklat')
        </div>

        <div class="form-step">
            @include('dashboard.drh.isidata.penghargaan')
        </div>

        <div class="form-step">
            @include('dashboard.drh.isidata.sertifikasi')
        </div>

        <div class="form-step">
            @include('dashboard.drh.isidata.legal')
        </div>
    </form>

    <div class="modal fade" id="drhAddModal" tabindex="-1" aria-labelledby="drhAddModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 18px;">
                <div class="modal-header" style="background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #fff;">
                    <h5 class="modal-title fw-bold" id="drhAddModalLabel">Tambah Data DRH</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="drhAddModalBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary rounded-pill px-4" id="drhAddModalSaveBtn">Tambahkan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Data Anak / Saudara -->
    <div class="modal fade" id="editRowModal" tabindex="-1" aria-labelledby="editRowModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 18px;">
                <div class="modal-header" style="background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #fff;">
                    <h5 class="modal-title fw-bold" id="editRowModalLabel">Edit Data</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" id="editRowModalBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light rounded-pill px-4" id="editRowModalCancelBtn" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary rounded-pill px-4" id="editRowModalSaveBtn">
                        <i class="bi bi-cloud-arrow-up-fill me-2"></i>Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
    
</div>

@push('scripts')
<script>
    const uiToBackendStepMap = [0, 4, 1, 2, 3, 5, 6, 7];
    const backendToUiStepMap = { 0: 0, 4: 1, 1: 2, 2: 3, 3: 4, 5: 5, 6: 6, 7: 7 };

    function uiStepToBackendStep(uiStep) {
        return uiToBackendStepMap[uiStep] ?? 0;
    }

    // Initialize current step from localStorage (persists across page refresh) or from server session
    const serverBackendStep = {{ session('step', old('step', 0)) }};
    let serverStep = backendToUiStepMap[serverBackendStep] ?? 0;
    let storedStep = localStorage.getItem('drhCurrentStep');
    let cur = storedStep !== null ? parseInt(storedStep) : serverStep;
    if (Number.isNaN(cur)) {
        cur = 0;
    }
    console.log('Server step:', serverStep, 'Stored step:', storedStep, 'Using:', cur);
    
    // Function to save current step to localStorage
    function saveCurrentStepToStorage() {
        localStorage.setItem('drhCurrentStep', cur);
        console.log('Saved current step to localStorage:', cur);
    }
    
    let counts = { p: {{ count($pendidikanRows) - 1 }}, d: {{ count($diklatRows) - 1 }}, j: {{ count($jabatanRows) - 1 }}, a: {{ count($anakRows) - 1 }}, aw: {{ count($awardRows) - 1 }}, s: {{ count($sertifRows) - 1 }}, sa: {{ count($saudaraRows) - 1 }} };
    const steps = document.getElementsByClassName("form-step");
    const progs = document.getElementsByClassName("step-item");
    cur = Math.max(0, Math.min(cur, steps.length - 1));
    let profileComplete = {{ $profilDasarLengkap ? 'true' : 'false' }};

    function canAccessStep(index) {
        if (index === 0) return true;
        return profileComplete;
    }

    function renderStep() {
        for (let i = 0; i < steps.length; i++) {
            steps[i].classList.toggle('active', i === cur);
            progs[i].classList.toggle('active', i === cur);
            const accessible = canAccessStep(i);
            progs[i].classList.toggle('disabled', !accessible);
            progs[i].disabled = !accessible;
        }
        updateButtonText();
        document.getElementById('stepInput').value = uiStepToBackendStep(cur);
    }

    function handleRestrictedStep(index) {
        if (!canAccessStep(index)) {
            showToast('Lengkapi Profil Dasar terlebih dahulu sebelum mengisi bagian lain.', 'warning');
            return false;
        }
        return true;
    }

    // Show success notification with auto-hide
    function showSuccessNotification(message = 'Data berhasil disimpan') {
        const notification = document.getElementById('successNotification');
        const messageSpan = document.getElementById('notificationMessage');
        
        messageSpan.textContent = message;
        notification.style.display = 'flex';
        notification.classList.remove('fade-out');
        
        // Auto hide after 3 seconds
        setTimeout(() => {
            notification.classList.add('fade-out');
            setTimeout(() => {
                notification.style.display = 'none';
            }, 300);
        }, 3000);
    }

    function showCenteredToastAndRedirectToJabatan(message) {
        showSuccessNotification(message);
        setTimeout(() => {
            const targetStep = 1;
            if (typeof profileComplete !== 'undefined') {
                profileComplete = true;
            }
            setStep(targetStep);
            saveCurrentStepToStorage();
        }, 1600);
    }

    // Submit form via AJAX
    // Replace upload-box with dokumen tersedia display after successful form submission
    function replaceUploadBoxWithSuccess(input, filePath) {
        const uploadBox = input.closest('.upload-box');
        if (!uploadBox) {
            return;
        }
        
        if (!input.files || !input.files[0] || !filePath) {
            return;
        }
        
        const inputName = input.getAttribute('name') || '';
        const uid = 'reupload_' + Math.random().toString(36).substr(2, 9);

        // Determine section and ID for delete
        let section = '';
        let rowId = '';
        const subCard = input.closest('.sub-card');
        if (subCard) {
            const hiddenId = subCard.querySelector('input[type="hidden"][name$="[id]"]');
            if (hiddenId) rowId = hiddenId.value;
        }
        if (inputName.startsWith('pendidikan')) section = 'pendidikan';
        else if (inputName.startsWith('diklat')) section = 'diklat';
        else if (inputName.startsWith('riwayat_jabatan')) section = 'jabatan';
        else if (inputName.startsWith('sertif')) section = 'sertifikasi';
        else if (inputName.startsWith('award')) section = 'penghargaan';

        const deleteBtn = (section && rowId)
            ? '<button type="button" class="btn-hapus-dokumen" onclick="confirmDeleteDrhDoc(\'' + section + '\', \'' + rowId + '\')"><i class="bi bi-trash"></i></button>'
            : '';

        const successHtml = '<div class="status-container">' +
            '<div class="status-text"><div class="status-icon-circle"><i class="bi bi-check-lg"></i></div>Dokumen Tersedia</div>' +
            '<div class="doc-actions">' +
            '<a href="' + filePath + '" target="_blank" class="btn-lihat-dokumen"><i class="bi bi-eye-fill"></i></a>' +
            '<button type="button" class="btn-edit-dokumen" onclick="document.getElementById(\'' + uid + '\').click()"><i class="bi bi-pencil-square"></i></button>' +
            '<input type="file" id="' + uid + '" name="' + inputName + '" accept=".pdf" class="d-none" onchange="drhReuploadPreview(this)">' +
            deleteBtn +
            '</div></div>';
        
        uploadBox.outerHTML = successHtml;
    }

    // Update all file input labels after successful form submission
    function updateAllFileInputLabels(filePaths) {
        const form = document.getElementById('drhForm');
        const fileInputs = form.querySelectorAll('input[type="file"]');
        
        let fileIndex = 0;
        fileInputs.forEach(function(input) {
            if (input.files && input.files[0] && fileIndex < filePaths.length) {
                replaceUploadBoxWithSuccess(input, filePaths[fileIndex]);
                fileIndex++;
            }
        });
    }

    function setupProfilDasarFieldValidation() {
        const requiredFieldNames = [
            'nik',
            'email',
            'no_hp',
            'alamat_domisili',
            'alamat_sesuai_ktp',
            'tempat_lahir',
            'kabupaten_asal',
            'tanggal_lahir',
            'jenis_kelamin',
            'agama',
            'golongan_darah',
            'status_pegawai',
            'jenis_asn',
            'golongan',
            'tmt',
            'unit_kerja_id'
        ];

        requiredFieldNames.forEach((fieldName) => {
            const field = document.querySelector(`#drhForm [name="${fieldName}"]`);
            if (!field) return;

            const clearValidation = () => {
                field.setCustomValidity('');
                field.classList.remove('is-invalid');
            };

            field.addEventListener('input', clearValidation);
            field.addEventListener('change', clearValidation);
        });
    }

    function validateProfilDasarRequiredFields() {
        const requiredFieldNames = [
            'nik',
            'email',
            'no_hp',
            'alamat_domisili',
            'alamat_sesuai_ktp',
            'tempat_lahir',
            'kabupaten_asal',
            'tanggal_lahir',
            'jenis_kelamin',
            'agama',
            'golongan_darah',
            'status_pegawai',
            'jenis_asn',
            'golongan',
            'tmt',
            'unit_kerja_id'
        ];

        let firstInvalidField = null;

        requiredFieldNames.forEach((fieldName) => {
            const field = document.querySelector(`#drhForm [name="${fieldName}"]`);
            if (!field) return;

            const rawValue = (field.value || '').toString().trim();
            if (rawValue === '') {
                field.classList.add('is-invalid');
                field.setCustomValidity('Please fill out this field');
                if (!firstInvalidField) {
                    firstInvalidField = field;
                }
            } else {
                field.classList.remove('is-invalid');
                field.setCustomValidity('');
            }
        });

        if (firstInvalidField) {
            showToast('Lengkapi semua kolom wajib pada Profil Dasar.', 'warning');
            firstInvalidField.focus();
            firstInvalidField.reportValidity();
            return false;
        }

        return true;
    }

    function formatDateYmdToDmy(dateValue) {
        if (!dateValue || typeof dateValue !== 'string') {
            return '-';
        }
        const parts = dateValue.split('-');
        if (parts.length !== 3) {
            return dateValue;
        }
        return `${parts[2]}-${parts[1]}-${parts[0]}`;
    }

    function applyLatestJabatanToProfilDasar(latestJabatan) {
        if (!latestJabatan || typeof latestJabatan !== 'object') {
            return;
        }

        const jenisEl = document.getElementById('profilDasarJenisJabatan');
        const eselonEl = document.getElementById('profilDasarEselonJabatan');
        const namaEl = document.getElementById('profilDasarNamaJabatan');
        const tmtEl = document.getElementById('profilDasarTmtJabatan');

        if (jenisEl) jenisEl.value = latestJabatan.jenis_jabatan || '-';
        if (eselonEl) eselonEl.value = latestJabatan.eselon_jabatan || '-';
        if (namaEl) namaEl.value = latestJabatan.nama_jabatan || '-';
        if (tmtEl) tmtEl.value = latestJabatan.tmt_jabatan ? formatDateYmdToDmy(latestJabatan.tmt_jabatan) : '-';
    }

    async function submitFormAjax() {
        const form = document.getElementById('drhForm');

        if (cur === 0 && !validateProfilDasarRequiredFields()) {
            return;
        }

        const formData = new FormData(form);
        formData.set('step', uiStepToBackendStep(cur));
        
        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            console.log('API Response:', data); // Debug log
            
            if (data.status === 'success') {
                profileComplete = true;
                // Update all file input labels after successful submission with file paths
                if (data.files && data.files.length > 0) {
                    updateAllFileInputLabels(data.files);
                }
                applyLatestJabatanToProfilDasar(data.latest_jabatan);
                renderStep();
                if (cur === 0) {
                    showCenteredToastAndRedirectToJabatan(data.message || 'data berhasil disimpan, untuk mengisi jabatan isi seluruh riawayat jabatan anda!');
                } else {
                    showSuccessNotification(data.message);
                }
                // Stay on current page - don't redirect
            } else {
                // Handle validation errors
                let errorMessage = data.message || 'Gagal menyimpan data';
                if (data.errors && typeof data.errors === 'object') {
                    // Format validation errors
                    const errorList = Object.values(data.errors)
                        .flat()
                        .join(' | ');
                    errorMessage = 'Validasi Error: ' + errorList;
                }
                console.error('Validation errors:', data.errors);
                showToast(errorMessage, 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showToast('Terjadi kesalahan saat menyimpan data: ' + error.message, 'error');
        }
    }

    function moveOrSubmit() {
        // Set step value
        document.getElementById('stepInput').value = uiStepToBackendStep(cur);
        
        // Submit via AJAX instead of traditional form submit
        submitFormAjax();
    }

    function move(n) {
        const nextIndex = cur + n;
        if (!handleRestrictedStep(nextIndex)) return;
        cur = nextIndex;
        saveCurrentStepToStorage();
        renderStep();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function setStep(index) {
        if (index < 0 || index >= steps.length || index === cur) return;
        if (!handleRestrictedStep(index)) return;
        steps[cur].classList.remove("active");
        progs[cur].classList.remove("active");
        cur = index;
        steps[cur].classList.add("active");
        progs[cur].classList.add("active");
        saveCurrentStepToStorage();
        renderStep();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function updateButtonText() {
        // Button text update logic (tidak ada button untuk di-update di current DOM)
        // Function ini tetap ada untuk compatibility
    }

    // Save section data directly from the section's save button
    function saveSectionData(stepNumber) {
        cur = stepNumber;
        saveCurrentStepToStorage();
        document.getElementById('stepInput').value = uiStepToBackendStep(cur);
        submitFormAjax();
    }

    // ======= Per-section Keluarga Save (sub_step) =======

    async function saveKeluargaSection(subStep, btn) {
        if (btn) { btn.disabled = true; btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...'; }

        // Collect fields from the right form panel or section
        const formData = new FormData();
        formData.append('_token', document.querySelector('#drhForm input[name="_token"]').value);
        formData.append('step', String(uiStepToBackendStep(2)));
        formData.append('sub_step', subStep);

        // Determine which container to collect fields from
        let containers = [];
        if (subStep === 'pasangan') {
            containers = [document.getElementById('formPasangan')];
        } else if (subStep === 'anak') {
            const sec = document.getElementById('sectionAnak');
            // Collect hidden inputs (existing rows) + form sub-cards (new rows) + file inputs
            sec.querySelectorAll('input[type="hidden"], input[type="text"], input[type="date"], select').forEach(el => {
                if (el.name) formData.append(el.name, el.value);
            });
            sec.querySelectorAll('input[type="file"]').forEach(el => {
                if (el.name && el.files[0]) formData.append(el.name, el.files[0]);
            });
        } else if (subStep === 'orang_tua') {
            containers = [document.getElementById('formOrangTua')];
        } else if (subStep === 'mertua') {
            containers = [document.getElementById('formMertua')];
        } else if (subStep === 'saudara') {
            const sec = document.getElementById('saudaraContainer').closest('.mb-5') || document.querySelector('[id^="saudara"]').closest('.mb-5');
            const cont = document.getElementById('saudaraContainer');
            cont.querySelectorAll('input[type="hidden"], input[type="text"], input[type="date"], select').forEach(el => {
                if (el.name) formData.append(el.name, el.value);
            });
        }

        // For single-form panels (pasangan, orang_tua, mertua base fields)
        if (containers.length > 0) {
            containers.forEach(cont => {
                if (!cont) return;
                cont.querySelectorAll('input[type="text"], input[type="date"], input[type="hidden"], select, textarea').forEach(el => {
                    if (el.name) formData.append(el.name, el.value);
                });
            });
        }

        // DEBUG: Log FormData for debugging
        console.log(`Form data for ${subStep}:`, {
            step: '1',
            sub_step: subStep,
            fields: Array.from(formData.entries()).filter(([k, v]) => k !== '_token').map(([k, v]) => `${k}: ${v instanceof File ? '[File]' : v}`)
        });

        try {
            const response = await fetch('/profile/drh', {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            });
            const data = await response.json();
            console.log('Save response for ' + subStep + ':', data);

            if (data.status === 'success') {
                // Validasi bahwa data.data ada dan bukan undefined
                if (!data.data) {
                    console.warn('Warning: Backend returned success but data.data is empty or undefined', data);
                    showToast('Data berhasil disimpan tapi respons kosong. Refresh halaman untuk memastikan.', 'warning');
                    // Refresh halaman setelah 1 detik
                    setTimeout(() => location.reload(), 1000);
                } else {
                    console.log('Calling renderKeluargaView with data:', data.data);
                    renderKeluargaView(subStep, data.data);
                    showSuccessNotification(data.message || 'Data berhasil disimpan');
                }
            } else {
                let msg = data.message || 'Gagal menyimpan data';
                if (data.errors) {
                    const errorDetails = Object.entries(data.errors)
                        .map(([field, errors]) => {
                            const fieldLabel = field.replace(/_/g, ' ').replace(/pasangan|anak|saudara/gi, '');
                            return `${fieldLabel}: ${Array.isArray(errors) ? errors[0] : errors}`;
                        })
                        .join('\n');
                    msg = `${msg}:\n${errorDetails}`;
                    console.error('Validation errors:', data.errors);
                }
                showToast(msg, 'error');
            }
        } catch (err) {
            console.error('Fetch error:', err);
            showToast('Terjadi kesalahan: ' + err.message, 'error');
        } finally {
            if (btn) { btn.disabled = false; btn.innerHTML = '<i class="bi bi-cloud-arrow-up-fill me-2"></i> Simpan' + (subStep === 'anak' ? ' Data Anak' : subStep === 'saudara' ? ' Data Saudara' : ''); }
        }
    }

    function editKeluargaSection(section) {
        const formEl = document.getElementById('form' + section);
        const viewEl = document.getElementById('view' + section);
        if (formEl) formEl.style.display = 'block';
        if (viewEl) viewEl.style.display = 'none';
    }

    function renderKeluargaView(subStep, data) {
        // Defensive check: ensure data is not undefined or null
        if (!data) {
            console.error('renderKeluargaView called with undefined/null data for subStep:', subStep);
            showToast('Error: Data untuk di-render tidak tersedia. Silakan refresh halaman.', 'error');
            return;
        }

        const displayVal = (val) => (val === null || val === undefined || val === '') ? '-' : String(val);
        const rawVal = (val) => (val === null || val === undefined) ? '' : String(val);
        const escHtml = (val) => rawVal(val)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
        const toYmd = (val) => {
            const raw = rawVal(val).trim();
            if (!raw) return '';
            const m = raw.match(/^(\d{4}-\d{2}-\d{2})/);
            if (m) return m[1];
            const d = new Date(raw);
            if (Number.isNaN(d.getTime())) return raw;
            const y = d.getFullYear();
            const mo = String(d.getMonth() + 1).padStart(2, '0');
            const da = String(d.getDate()).padStart(2, '0');
            return `${y}-${mo}-${da}`;
        };

        if (subStep === 'pasangan') {
            // Extra defensive check for pasangan - ensure all ID elements exist
            const vpNama = document.getElementById('vpNama');
            const vpPekerjaan = document.getElementById('vpPekerjaan');
            const vpNik = document.getElementById('vpNik');
            const vpTtl = document.getElementById('vpTtl');
            const vpAkta = document.getElementById('vpAkta');
            const vpStatus = document.getElementById('vpStatus');
            const viewPasangan = document.getElementById('viewPasangan');
            const formPasangan = document.getElementById('formPasangan');
            
            if (!vpNama || !viewPasangan) {
                console.error('Required DOM elements for pasangan not found');
                showToast('Error: Halaman tidak siap untuk menampilkan data. Refresh halaman.', 'error');
                return;
            }

            vpNama.textContent      = displayVal(data.nama);
            if (vpPekerjaan) vpPekerjaan.textContent = displayVal(data.pekerjaan);
            if (vpNik) vpNik.textContent       = displayVal(data.nik);
            if (vpTtl) vpTtl.textContent       = displayVal(data.tempat_lahir) + ', ' + displayVal(toYmd(data.tanggal_lahir) || '-');
            if (vpAkta) vpAkta.textContent      = displayVal(data.no_akta_nikah);
            if (vpStatus) vpStatus.textContent    = displayVal(data.status) + ' \u2022 ' + displayVal(data.status_hidup);
            viewPasangan.style.display = 'block';
            if (formPasangan) formPasangan.style.display = 'none';

            const editBtn = viewPasangan.querySelector('button.family-action-edit');
            const delBtn = viewPasangan.querySelector('button.family-action-delete');
            if (editBtn) {
                const rowData = {
                    id: data.id || '',
                    nik: rawVal(data.nik),
                    nama: rawVal(data.nama),
                    status: rawVal(data.status),
                    status_hidup: rawVal(data.status_hidup),
                    tempat_lahir: rawVal(data.tempat_lahir),
                    tanggal_lahir: toYmd(data.tanggal_lahir),
                    pekerjaan: rawVal(data.pekerjaan),
                    no_akta_nikah: rawVal(data.no_akta_nikah),
                };
                editBtn.setAttribute('onclick', 'openEditPasanganModal(this)');
                editBtn.dataset.row = JSON.stringify(rowData);
            }
            if (delBtn) {
                delBtn.disabled = !data.id;
                delBtn.setAttribute('onclick', data.id ? `deleteDrhSavedRow('/profile/drh/keluarga/pasangan/${data.id}', this)` : '');
            }

        } else if (subStep === 'orang_tua') {
            const ay = data.ayah || {}, ib = data.ibu || {};
            const setText = (id, value) => {
                const el = document.getElementById(id);
                if (el) el.textContent = displayVal(value);
            };
            setText('vtAyahNama', ay.nama);
            setText('vtAyahNik', ay.nik);
            setText('vtAyahTgl', toYmd(ay.tanggal_lahir) || '-');
            setText('vtAyahStatus', ay.status_hidup);
            setText('vtAyahPekerjaan', ay.pekerjaan);
            setText('vtAyahAlamat', ay.alamat);
            setText('vtIbuNama', ib.nama);
            setText('vtIbuNik', ib.nik);
            setText('vtIbuTgl', toYmd(ib.tanggal_lahir) || '-');
            setText('vtIbuStatus', ib.status_hidup);
            setText('vtIbuPekerjaan', ib.pekerjaan);
            setText('vtIbuAlamat', ib.alamat);
            document.getElementById('viewOrangTua').style.display = 'block';
            document.getElementById('formOrangTua').style.display = 'none';

            const ayahRow = document.getElementById('vtAyahNama')?.closest('tr');
            if (ayahRow) {
                const editBtn = ayahRow.querySelector('button.family-action-edit');
                const delBtn = ayahRow.querySelector('button.family-action-delete');
                if (editBtn) {
                    editBtn.setAttribute('onclick', 'openEditOrangTuaModal(this)');
                    editBtn.dataset.row = JSON.stringify({
                        id: ay.id || '',
                        hubungan: 'Ayah Kandung',
                        status_hub: ay.status_hub || 'Ayah',
                        nik: rawVal(ay.nik),
                        nama: rawVal(ay.nama),
                        alamat: rawVal(ay.alamat),
                        tanggal_lahir: toYmd(ay.tanggal_lahir),
                        status_hidup: rawVal(ay.status_hidup),
                        pekerjaan: rawVal(ay.pekerjaan),
                    });
                }
                if (delBtn) {
                    delBtn.disabled = !ay.id;
                    delBtn.setAttribute('onclick', ay.id ? `deleteDrhSavedRow('/profile/drh/keluarga/orang-tua/${ay.id}', this)` : '');
                }
            }

            const ibuRow = document.getElementById('vtIbuNama')?.closest('tr');
            if (ibuRow) {
                const editBtn = ibuRow.querySelector('button.family-action-edit');
                const delBtn = ibuRow.querySelector('button.family-action-delete');
                if (editBtn) {
                    editBtn.setAttribute('onclick', 'openEditOrangTuaModal(this)');
                    editBtn.dataset.row = JSON.stringify({
                        id: ib.id || '',
                        hubungan: 'Ibu Kandung',
                        status_hub: ib.status_hub || 'Ibu',
                        nik: rawVal(ib.nik),
                        nama: rawVal(ib.nama),
                        alamat: rawVal(ib.alamat),
                        tanggal_lahir: toYmd(ib.tanggal_lahir),
                        status_hidup: rawVal(ib.status_hidup),
                        pekerjaan: rawVal(ib.pekerjaan),
                    });
                }
                if (delBtn) {
                    delBtn.disabled = !ib.id;
                    delBtn.setAttribute('onclick', ib.id ? `deleteDrhSavedRow('/profile/drh/keluarga/orang-tua/${ib.id}', this)` : '');
                }
            }

        } else if (subStep === 'mertua') {
            const ay = data.ayah || {}, ib = data.ibu || {};
            const setText = (id, value) => {
                const el = document.getElementById(id);
                if (el) el.textContent = displayVal(value);
            };
            setText('vmAyahNama', ay.nama);
            setText('vmAyahNik', ay.nik);
            setText('vmAyahTgl', toYmd(ay.tanggal_lahir) || '-');
            setText('vmAyahStatus', ay.status_hidup);
            setText('vmAyahPekerjaan', ay.pekerjaan);
            setText('vmIbuNama', ib.nama);
            setText('vmIbuNik', ib.nik);
            setText('vmIbuTgl', toYmd(ib.tanggal_lahir) || '-');
            setText('vmIbuStatus', ib.status_hidup);
            setText('vmIbuPekerjaan', ib.pekerjaan);
            document.getElementById('viewMertua').style.display = 'block';
            document.getElementById('formMertua').style.display = 'none';

            const ayahRow = document.getElementById('vmAyahNama')?.closest('tr');
            if (ayahRow) {
                const editBtn = ayahRow.querySelector('button.family-action-edit');
                const delBtn = ayahRow.querySelector('button.family-action-delete');
                if (editBtn) {
                    editBtn.setAttribute('onclick', 'openEditMertuaModal(this)');
                    editBtn.dataset.row = JSON.stringify({
                        id: ay.id || '',
                        hubungan: 'Ayah Mertua',
                        status_hub: ay.status_hub || 'Ayah Mertua',
                        nik: rawVal(ay.nik),
                        nama: rawVal(ay.nama),
                        tanggal_lahir: toYmd(ay.tanggal_lahir),
                        status_hidup: rawVal(ay.status_hidup),
                        pekerjaan: rawVal(ay.pekerjaan),
                    });
                }
                if (delBtn) {
                    delBtn.disabled = !ay.id;
                    delBtn.setAttribute('onclick', ay.id ? `deleteDrhSavedRow('/profile/drh/keluarga/mertua/${ay.id}', this)` : '');
                }
            }

            const ibuRow = document.getElementById('vmIbuNama')?.closest('tr');
            if (ibuRow) {
                const editBtn = ibuRow.querySelector('button.family-action-edit');
                const delBtn = ibuRow.querySelector('button.family-action-delete');
                if (editBtn) {
                    editBtn.setAttribute('onclick', 'openEditMertuaModal(this)');
                    editBtn.dataset.row = JSON.stringify({
                        id: ib.id || '',
                        hubungan: 'Ibu Mertua',
                        status_hub: ib.status_hub || 'Ibu Mertua',
                        nik: rawVal(ib.nik),
                        nama: rawVal(ib.nama),
                        tanggal_lahir: toYmd(ib.tanggal_lahir),
                        status_hidup: rawVal(ib.status_hidup),
                        pekerjaan: rawVal(ib.pekerjaan),
                    });
                }
                if (delBtn) {
                    delBtn.disabled = !ib.id;
                    delBtn.setAttribute('onclick', ib.id ? `deleteDrhSavedRow('/profile/drh/keluarga/mertua/${ib.id}', this)` : '');
                }
            }

        } else if (subStep === 'anak') {
            const cont = document.getElementById('anakContainer');
            // Remove all pending form sub-cards (newly added unsaved rows)
            cont.querySelectorAll('.sub-card').forEach(sc => sc.remove());
            // Re-render the table and hidden inputs
            if (!data || data.length === 0) {
                cont.innerHTML = `<div class="text-center py-5 border-2 border-dashed rounded-4" style="background: #fafafa; border-color: #e2e8f0;" id="emptyAnak"><p class="text-muted small mb-0">Belum ada data anak. Klik "+ Tambah Anak".</p></div>`;
                return;
            }
            let hiddenHtml = '<div class="d-none" id="anakHiddenInputs">';
            let tbodyHtml = '';
            data.forEach((a, i) => {
                if (a.id) hiddenHtml += `<input type="hidden" name="anak[${i}][id]" value="${escHtml(a.id)}">`;
                hiddenHtml += `<input type="hidden" name="anak[${i}][nama]" value="${escHtml(rawVal(a.nama))}">`;
                hiddenHtml += `<input type="hidden" name="anak[${i}][nik]" value="${escHtml(rawVal(a.nik))}">`;
                hiddenHtml += `<input type="hidden" name="anak[${i}][jenis_kelamin]" value="${escHtml(rawVal(a.jenis_kelamin))}">`;
                hiddenHtml += `<input type="hidden" name="anak[${i}][tempat_lahir]" value="${escHtml(rawVal(a.tempat_lahir))}">`;
                hiddenHtml += `<input type="hidden" name="anak[${i}][tanggal_lahir]" value="${escHtml(rawVal(a.tanggal_lahir))}">`;
                hiddenHtml += `<input type="hidden" name="anak[${i}][pekerjaan]" value="${escHtml(rawVal(a.pekerjaan))}">`;
                hiddenHtml += `<input type="hidden" name="anak[${i}][status_kawin]" value="${escHtml(rawVal(a.status_kawin))}">`;
                hiddenHtml += `<input type="hidden" name="anak[${i}][status_anak]" value="${escHtml(rawVal(a.status_anak))}">`;
                if (a.file) hiddenHtml += `<input type="hidden" name="anak[${i}][old_file]" value="${escHtml(a.file)}">`;
                const jkLbl = a.jenis_kelamin === 'L' ? 'Laki-laki' : a.jenis_kelamin === 'P' ? 'Perempuan' : '-';
                const rowJson = JSON.stringify({id:a.id,nama:a.nama||'',nik:a.nik||'',jenis_kelamin:a.jenis_kelamin||'',tempat_lahir:a.tempat_lahir||'',tanggal_lahir:toYmd(a.tanggal_lahir)||'',pekerjaan:a.pekerjaan||'',status_kawin:a.status_kawin||'',status_anak:a.status_anak||'',file:a.file||'',file_url:a.file_url||''}).replace(/"/g,'&quot;');
                const pekerjaanClass = (!a.pekerjaan || a.pekerjaan === '-') ? 'text-muted opacity-50' : '';
                const editBtn = `<button type="button" class="family-action-btn family-action-edit" onclick="openEditAnakModal(this)" data-row="${rowJson}" title="Edit"><i class="bi bi-pencil-square"></i></button>`;
                const delBtn  = `<button type="button" class="family-action-btn family-action-delete" onclick="${a.id ? `deleteDrhSavedRow('/profile/drh/anak/${a.id}', this)` : ''}" title="Hapus" ${a.id ? '' : 'disabled'}><i class="bi bi-trash3"></i></button>`;
                tbodyHtml += `<tr><td class="fw-bold text-dark">${escHtml(displayVal(a.nama))}</td><td class="text-muted small">${escHtml(displayVal(a.nik))}</td><td>${jkLbl}</td><td>${escHtml(displayVal(a.tempat_lahir))}</td><td>${escHtml(displayVal(toYmd(a.tanggal_lahir) || '-'))}</td><td class="${pekerjaanClass}">${escHtml(displayVal(a.pekerjaan))}</td><td>${escHtml(displayVal(a.status_kawin))}</td><td>${escHtml(displayVal(a.status_anak))}</td><td class="text-center"><div class="d-flex gap-1 justify-content-center">${editBtn}${delBtn}</div></td></tr>`;
            });
            hiddenHtml += '</div>';
            cont.innerHTML = hiddenHtml + `<div class="table-responsive" id="anakTableWrap"><table class="table drh-subtable mb-3"><thead><tr><th>Nama Anak</th><th>NIK</th><th>Jenis Kelamin</th><th>Tempat Lahir</th><th>Tgl. Lahir</th><th>Pekerjaan</th><th>Status Kawin</th><th>Status Anak</th><th class="text-center">Aksi</th></tr></thead><tbody>${tbodyHtml}</tbody></table></div>`;
            counts.a = data.length;

        } else if (subStep === 'saudara') {
            const cont = document.getElementById('saudaraContainer');
            cont.querySelectorAll('.sub-card').forEach(sc => sc.remove());
            if (!data || data.length === 0) {
                cont.innerHTML = `<div class="text-center py-4 border-2 border-dashed rounded-4" style="background: #fafafa; border-color: #e2e8f0;" id="emptySaudara"><p class="text-muted small mb-0">Belum ada data saudara. Klik "+ Tambah Saudara".</p></div>`;
                return;
            }
            const jkLabel = (jk) => jk === 'L' ? 'Laki-laki' : jk === 'P' ? 'Perempuan' : '-';
            let hiddenHtml = '<div class="d-none" id="saudaraHiddenInputs">';
            let tbodyHtml = '';
            data.forEach((s, i) => {
                if (s.id) hiddenHtml += `<input type="hidden" name="saudara[${i}][id]" value="${escHtml(s.id)}">`;
                hiddenHtml += `<input type="hidden" name="saudara[${i}][nik]" value="${escHtml(rawVal(s.nik))}">`;
                hiddenHtml += `<input type="hidden" name="saudara[${i}][nama]" value="${escHtml(rawVal(s.nama))}">`;
                hiddenHtml += `<input type="hidden" name="saudara[${i}][jenis_kelamin]" value="${escHtml(rawVal(s.jenis_kelamin))}">`;
                hiddenHtml += `<input type="hidden" name="saudara[${i}][tempat_lahir]" value="${escHtml(rawVal(s.tempat_lahir))}">`;
                hiddenHtml += `<input type="hidden" name="saudara[${i}][status_kawin]" value="${escHtml(rawVal(s.status_kawin))}">`;
                hiddenHtml += `<input type="hidden" name="saudara[${i}][status_saudara]" value="${escHtml(rawVal(s.status_saudara))}">`;
                hiddenHtml += `<input type="hidden" name="saudara[${i}][tanggal_lahir]" value="${escHtml(rawVal(s.tanggal_lahir))}">`;
                hiddenHtml += `<input type="hidden" name="saudara[${i}][pekerjaan]" value="${escHtml(rawVal(s.pekerjaan))}">`;
                const rowJson  = JSON.stringify({id:s.id,nik:s.nik||'',nama:s.nama||'',jenis_kelamin:s.jenis_kelamin||'',tempat_lahir:s.tempat_lahir||'',tanggal_lahir:toYmd(s.tanggal_lahir)||'',pekerjaan:s.pekerjaan||'',status_kawin:s.status_kawin||'',status_saudara:s.status_saudara||'',file:s.file||'',file_url:s.file_url||''}).replace(/"/g,'&quot;');
                const editBtn  = `<button type="button" class="family-action-btn family-action-edit" onclick="openEditSaudaraModal(this)" data-row="${rowJson}" title="Edit"><i class="bi bi-pencil-square"></i></button>`;
                const delBtn   = `<button type="button" class="family-action-btn family-action-delete" onclick="${s.id ? `deleteDrhSavedRow('/profile/drh/saudara/${s.id}', this)` : ''}" title="Hapus" ${s.id ? '' : 'disabled'}><i class="bi bi-trash3"></i></button>`;
                tbodyHtml += `<tr><td class="fw-bold text-dark">${escHtml(displayVal(s.nama))}</td><td class="text-muted small">${escHtml(displayVal(s.nik))}</td><td>${jkLabel(s.jenis_kelamin)}</td><td>${escHtml(displayVal(s.status_kawin))}</td><td>${escHtml(displayVal(s.status_saudara))}</td><td>${escHtml(displayVal(toYmd(s.tanggal_lahir) || '-'))}</td><td>${escHtml(displayVal(s.pekerjaan))}</td><td class="text-center"><div class="d-flex gap-1 justify-content-center">${editBtn}${delBtn}</div></td></tr>`;
            });
            hiddenHtml += '</div>';
            cont.innerHTML = hiddenHtml + `<div class="table-responsive" id="saudaraTableWrap"><table class="table drh-subtable mb-3"><thead><tr><th>Nama</th><th>NIK</th><th>Jenis Kelamin</th><th>Status Kawin</th><th>Status Saudara</th><th>Tgl. Lahir</th><th>Pekerjaan</th><th class="text-center">Aksi</th></tr></thead><tbody>${tbodyHtml}</tbody></table></div>`;
            counts.sa = data.length;
        }
    }

    // ======= End Per-section Keluarga Save =======

    function highlightSavedStep() {
        const stepItem = progs[cur];
        if (!stepItem) return;
        stepItem.style.transition = 'box-shadow 0.4s ease, transform 0.4s ease';
        stepItem.style.boxShadow = '0 0 0 4px rgba(40, 167, 69, 0.35)';
        stepItem.style.transform = 'scale(1.02)';
        setTimeout(() => {
            stepItem.style.boxShadow = '';
            stepItem.style.transform = '';
        }, 2000);
    }

    // On load, restore the current step and family section state
    renderStep();
    toggleFamilyLogic();
    setupProfilDasarFieldValidation();

    @if(session('success'))
        showSuccessNotification('{{ session('success') }}');
        highlightSavedStep();
    @endif

    @if(session('error'))
        showToast('{{ session('error') }}', 'error');
    @endif

    function toggleFamilyLogic() {
        const statusEl = document.getElementById('statusPegawai');
        if (!statusEl) return;

        const sectionPasangan = document.getElementById('sectionPasangan');
        const sectionAnak = document.getElementById('sectionAnak');
        const sectionMertua = document.getElementById('sectionMertua');

        const statusMap = {
            M: 'Menikah',
            BM: 'Belum Menikah',
            CH: 'Cerai Hidup',
            CM: 'Cerai Mati'
        };

        const currentStatusRaw = (statusEl.value || '').trim();
        const currentStatus = statusMap[currentStatusRaw] || currentStatusRaw;
        const setVisible = (el, isVisible) => {
            if (el) el.style.display = isVisible ? 'block' : 'none';
        };

        if (currentStatus === 'Menikah') {
            setVisible(sectionPasangan, true);
            setVisible(sectionAnak, true);
            setVisible(sectionMertua, true);
        } else if (currentStatus === 'Belum Menikah') {
            setVisible(sectionPasangan, false);
            setVisible(sectionAnak, false);
            setVisible(sectionMertua, false);
        } else {
            setVisible(sectionPasangan, false);
            setVisible(sectionAnak, true);
            setVisible(sectionMertua, false);
        }
    }

    // --- DINAMIS PENDIDIKAN ---
    const masterPendidikanOptions = @json(
        $pendidikanList
            ->pluck('nama')
            ->filter()
            ->values()
    );

    function getPendidikanSelectOptionsHtml(selectedValue = '') {
        const normalizedSelected = String(selectedValue || '').trim();
        const options = ['<option value="">Pilih Jenjang Pendidikan</option>'];

        masterPendidikanOptions.forEach((namaPendidikan) => {
            const selected = normalizedSelected === String(namaPendidikan) ? ' selected' : '';
            options.push(`<option value="${namaPendidikan}"${selected}>${namaPendidikan}</option>`);
        });

        return options.join('');
    }

    function addPendidikan() {
        counts.p++;
        const cont = document.getElementById("pendidikanContainer");
        const empty = document.getElementById("emptyPendidikan");
        if (empty) empty.style.display = "none";
        const div = document.createElement("div");
        div.className = "sub-card text-start";
        div.id = "pendidikan_row_" + counts.p;
        div.innerHTML = `
            <div class="sub-card-header"><span>Pendidikan ${counts.p}</span><button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.parentElement.remove()"><i class="bi bi-trash"></i></button></div>
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Jenjang Pendidikan *</label>
                    <select class="form-select" name="pendidikan[${counts.p}][jenjang]">${getPendidikanSelectOptionsHtml()}</select>
                </div>
                <div class="col-md-6"><label class="form-label">Nama Sekolah / Universitas *</label><input type="text" class="form-control" name="pendidikan[${counts.p}][nama_sekolah]"></div>
                <div class="col-md-6"><label class="form-label">Tahun Masuk</label><input type="text" class="form-control" name="pendidikan[${counts.p}][tahun_masuk]" placeholder="2000"></div>
                <div class="col-md-6"><label class="form-label">Tahun Lulus</label><input type="text" class="form-control" name="pendidikan[${counts.p}][tahun_lulus]" placeholder="2004"></div>
                <div class="col-md-6"><label class="form-label">No. Ijazah</label><input type="text" class="form-control" name="pendidikan[${counts.p}][nomor_ijazah]" placeholder="Nomor Ijazah"></div>
                <div class="col-md-6"><label class="form-label">Nama Pejabat TTD Ijazah</label><input type="text" class="form-control" name="pendidikan[${counts.p}][nama_pejabat]" placeholder="Nama pejabat penandatangan"></div>
                <div class="col-12">
                    <div class="upload-box">
                        <input type="file" id="pendidikan_file_${counts.p}" name="pendidikan[${counts.p}][file]" accept=".pdf" style="display:none;">
                        <label for="pendidikan_file_${counts.p}" style="cursor: pointer; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-upload"></i> Upload Ijazah (PDF, maks 1 MB)
                        </label>
                    </div>
                </div>
            </div>`;
        cont.appendChild(div);
        div.scrollIntoView({ behavior: 'smooth' });
    }

    // --- DINAMIS DIKLAT ---
    function addDiklat() {
        counts.d++;
        const cont = document.getElementById("diklatContainer");
        const empty = document.getElementById("emptyDiklat");
        if (empty) empty.style.display = "none";
        const div = document.createElement("div");
        div.className = "sub-card text-start";
        div.id = "diklat_row_" + counts.d;
        div.innerHTML = `
            <div class="sub-card-header"><span>Diklat ${counts.d}</span><button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.parentElement.remove()"><i class="bi bi-trash"></i></button></div>
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Nama Diklat *</label><input type="text" class="form-control" name="diklat[${counts.d}][nama]"></div>
                <div class="col-md-6"><label class="form-label">Penyelenggara *</label><input type="text" class="form-control" name="diklat[${counts.d}][penyelenggara]"></div>
                <div class="col-md-6"><label class="form-label">Nomor Sertifikat</label><input type="text" class="form-control" name="diklat[${counts.d}][nomor_sertifikat]"></div>
                <div class="col-md-6"><label class="form-label">Tahun</label><input type="text" class="form-control" name="diklat[${counts.d}][tahun]" placeholder="2020"></div>
                <div class="col-12">
                    <div class="upload-box">
                        <input type="file" id="diklat_file_${counts.d}" name="diklat[${counts.d}][file]" accept=".pdf" style="display:none;">
                        <label for="diklat_file_${counts.d}" style="cursor: pointer; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-upload"></i> Upload Sertifikat Diklat (PDF, maks 1 MB)
                        </label>
                    </div>
                </div>
            </div>`;
        cont.appendChild(div);
        div.scrollIntoView({ behavior: 'smooth' });
    }

    // --- DINAMIS JABATAN ---
    const pppkMasterJabatanOptions = @json(
        $jabatanList
            ->filter(fn($j) => in_array($j->jenis_asn, ['PPPK', 'Keduanya']))
            ->pluck('nama_jabatan')
            ->values()
    );

    function getPppkJabatanSelectOptionsHtml() {
        const options = ['<option value="">Pilih Nama Jabatan</option>'];
        pppkMasterJabatanOptions.forEach((namaJabatan) => {
            options.push(`<option value="${namaJabatan}">${namaJabatan}</option>`);
        });
        return options.join('');
    }

    function addJabatan() {
        counts.j++;
        const cont = document.getElementById("jabatanContainer");
        const empty = document.getElementById("emptyJabatan");
        if (empty) empty.style.display = "none";
        const div = document.createElement("div");
        div.className = "sub-card text-start";

        const isPPPK = (document.getElementById('jenisAsn')?.value || '') === 'PPPK';

        if (isPPPK) {
            div.innerHTML = `
                <div class="sub-card-header"><span>Jabatan ${counts.j}</span><button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.parentElement.remove()"><i class="bi bi-trash"></i></button></div>
                <div class="row g-3">
                    <div class="col-md-12"><label class="form-label">Nama Jabatan</label>
                        <select class="form-select" name="riwayat_jabatan[${counts.j}][nama_jabatan]">
                            ${getPppkJabatanSelectOptionsHtml()}
                        </select>
                        <input type="hidden" name="riwayat_jabatan[${counts.j}][jenis_jabatan]" value="">
                        <input type="hidden" name="riwayat_jabatan[${counts.j}][eselon]" value="">
                    </div>
                    <div class="col-md-6"><label class="form-label">TMT Jabatan</label><input type="date" class="form-control" name="riwayat_jabatan[${counts.j}][tmt]"></div>
                    <div class="col-md-6"><label class="form-label">No. SK</label><input type="text" class="form-control" name="riwayat_jabatan[${counts.j}][no_sk]" placeholder="Masukan No. SK"></div>
                    <div class="col-12">
                        <div class="upload-box">
                            <input type="file" id="jabatan_file_${counts.j}" name="riwayat_jabatan[${counts.j}][file]" accept=".pdf" style="display:none;">
                            <label for="jabatan_file_${counts.j}" style="cursor: pointer; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;"><i class="bi bi-upload"></i> Upload SK Jabatan (PDF, maks 1 MB)</label>
                        </div>
                    </div>
                </div>`;
        } else {
            div.innerHTML = `
                <div class="sub-card-header"><span>Jabatan ${counts.j}</span><button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.parentElement.remove()"><i class="bi bi-trash"></i></button></div>
                <div class="row g-3">
                    <div class="col-md-4"><label class="form-label">Jenis Jabatan</label>
                        <select class="form-select rj-jenis" data-index="${counts.j}" onchange="rjOnJenisChange(this, false)">
                            <option value="">Pilih Jenis Jabatan</option>
                            <option value="STRUKTURAL">Struktural</option>
                            <option value="JFT">JFT (Fungsional Tertentu)</option>
                            <option value="JFU">JFU (Fungsional Umum)</option>
                        </select>
                        <input type="hidden" name="riwayat_jabatan[${counts.j}][jenis_jabatan]" class="rj-jenis-hidden" value="">
                    </div>
                    <div class="col-md-4"><label class="form-label">Eselon</label>
                        <select class="form-select rj-eselon" data-index="${counts.j}" onchange="rjOnEselonChange(this, false)" disabled>
                            <option value="">Pilih Eselon</option>
                        </select>
                        <input type="hidden" name="riwayat_jabatan[${counts.j}][eselon]" class="rj-eselon-hidden" value="">
                        <input type="hidden" class="rj-saved-eselon" value="">
                    </div>
                    <div class="col-md-4"><label class="form-label">Nama Jabatan</label>
                        <select class="form-select rj-nama" data-index="${counts.j}" onchange="this.closest('.sub-card, .row').querySelector('.rj-nama-hidden').value = this.value" disabled>
                            <option value="">Pilih Nama Jabatan</option>
                        </select>
                        <input type="hidden" name="riwayat_jabatan[${counts.j}][nama_jabatan]" class="rj-nama-hidden" value="">
                        <input type="hidden" class="rj-saved-nama" value="">
                    </div>
                    <div class="col-md-6"><label class="form-label">No. SK</label><input type="text" class="form-control" name="riwayat_jabatan[${counts.j}][no_sk]"></div>
                    <div class="col-md-6"><label class="form-label">TMT</label><input type="date" class="form-control" name="riwayat_jabatan[${counts.j}][tmt]"></div>
                    <div class="col-12">
                        <div class="upload-box">
                            <input type="file" id="jabatan_file_${counts.j}" name="riwayat_jabatan[${counts.j}][file]" accept=".pdf" style="display:none;">
                            <label for="jabatan_file_${counts.j}" style="cursor: pointer; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;"><i class="bi bi-upload"></i> Upload SK Jabatan (PDF, maks 1 MB)</label>
                        </div>
                    </div>
                </div>`;
        }
        cont.appendChild(div);
        div.scrollIntoView({ behavior: 'smooth' });
    }

    // --- DINAMIS PENGHARGAAN ---
    function addAward() {
        counts.aw++;
        const cont = document.getElementById("awardContainer");
        const empty = document.getElementById("emptyAward");
        if (empty) empty.style.display = "none";
        const div = document.createElement("div");
        div.className = "sub-card text-start";
        div.innerHTML = `
            <div class="sub-card-header"><span>Penghargaan ${counts.aw}</span><button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.parentElement.remove()"><i class="bi bi-trash"></i></button></div>
            <div class="row g-3">
                <div class="col-md-8"><label class="form-label">Nama Penghargaan *</label><input type="text" class="form-control" name="award[${counts.aw}][nama]"></div>
                <div class="col-md-4"><label class="form-label">Tahun *</label><input type="text" class="form-control" name="award[${counts.aw}][tahun]" placeholder="2020"></div>
                <div class="col-md-8"><label class="form-label">Instansi Pemberi *</label><input type="text" class="form-control" name="award[${counts.aw}][instansi]" placeholder="Nama instansi/lembaga pemberi"></div>
                <div class="col-md-4"><label class="form-label opacity-0 d-block">Upload</label>
                    <div class="upload-box">
                        <input type="file" id="award_file_${counts.aw}" name="award[${counts.aw}][file]" accept=".pdf" style="display:none;">
                        <label for="award_file_${counts.aw}" style="cursor: pointer; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-upload me-2"></i> Upload Piagam / Sertifikat
                        </label>
                    </div>
                </div>
            </div>`;
        cont.appendChild(div);
        // Auto-scroll ke row baru
        div.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    // --- DINAMIS SERTIFIKASI ---
    function addSertif() {
        counts.s++;
        const cont = document.getElementById("sertifContainer");
        const empty = document.getElementById("emptySertif");
        if (empty) empty.style.display = "none";
        const div = document.createElement("div");
        div.className = "sub-card text-start";
        div.innerHTML = `
            <div class="sub-card-header"><span>Sertifikasi ${counts.s}</span><button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.parentElement.remove()"><i class="bi bi-trash"></i></button></div>
            <div class="row g-3">
                <div class="col-md-8"><label class="form-label">Nama Sertifikasi *</label><input type="text" class="form-control" name="sertif[${counts.s}][nama]" placeholder="Nama sertifikasi / kompetensi"></div>
                <div class="col-md-4"><label class="form-label">Tahun *</label><input type="text" class="form-control" name="sertif[${counts.s}][tahun]" placeholder="2020"></div>
                <div class="col-md-8"><label class="form-label">Lembaga Pelaksana *</label><input type="text" class="form-control" name="sertif[${counts.s}][lembaga]" placeholder="Nama lembaga sertifikasi"></div>
                <div class="col-md-4"><label class="form-label opacity-0 d-block">Upload</label>
                    <div class="upload-box">
                        <input type="file" id="sertif_file_${counts.s}" name="sertif[${counts.s}][file]" accept=".pdf" style="display:none;">
                        <label for="sertif_file_${counts.s}" style="cursor: pointer; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-upload me-2"></i> Upload Sertifikat
                        </label>
                    </div>
                </div>
            </div>`;
        cont.appendChild(div);
        // Auto-scroll ke row baru
        div.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function addAnak() {
        counts.a++;
        const cont = document.getElementById("anakContainer");
        const empty = document.getElementById("emptyAnak");
        if (empty) empty.style.display = "none";
        const div = document.createElement("div");
        div.className = "sub-card";
        div.innerHTML = `
            <div class="sub-card-header"><span class="text-primary">Anak ke-${counts.a}</span><button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.parentElement.remove()"><i class="bi bi-trash"></i></button></div>
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Nama Anak *</label><input type="text" class="form-control" name="anak[${counts.a}][nama]"></div>
                <div class="col-md-6"><label class="form-label">NIK</label><div class="input-group"><input type="text" class="form-control nik-lookup" name="anak[${counts.a}][nik]" minlength="16" maxlength="16" inputmode="numeric" pattern="[0-9]{16}" style="border-radius: 12px 0 0 12px;"><button type="button" class="btn btn-outline-primary btn-nik-search" title="Cari NIK" style="border-radius: 0 12px 12px 0; border: none; background: #e8f0fe;"><i class="bi bi-search"></i></button></div></div>
                <div class="col-md-4"><label class="form-label">Jenis Kelamin</label><select class="form-select" name="anak[${counts.a}][jenis_kelamin]"><option value="">Pilih</option><option value="L">Laki-laki</option><option value="P">Perempuan</option></select></div>
                <div class="col-md-4"><label class="form-label">Tempat Lahir</label><input type="text" class="form-control" name="anak[${counts.a}][tempat_lahir]"></div>
                <div class="col-md-4"><label class="form-label">Tanggal Lahir</label><input type="date" class="form-control" name="anak[${counts.a}][tanggal_lahir]"></div>
                <div class="col-md-6"><label class="form-label">Pekerjaan</label><input type="text" class="form-control" name="anak[${counts.a}][pekerjaan]"></div>
                <div class="col-md-3"><label class="form-label">Status Kawin</label><select class="form-select" name="anak[${counts.a}][status_kawin]"><option value="">Pilih</option><option>Belum Menikah</option><option>Menikah</option><option>Cerai Hidup</option><option>Cerai Mati</option></select></div>
                <div class="col-md-3"><label class="form-label">Status Anak</label><select class="form-select" name="anak[${counts.a}][status_anak]"><option>Kandung</option><option>Tiri</option><option>Angkat</option></select></div>
                <div class="col-md-6">
                    <label class="form-label">Akta Kelahiran</label>
                    <div class="upload-box">
                        <input type="file" id="anak_file_${counts.a}" name="anak[${counts.a}][file]" accept=".pdf" style="display:none;">
                        <label for="anak_file_${counts.a}" style="cursor: pointer; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;"><i class="bi bi-upload me-2"></i> Upload Akta Kelahiran</label>
                    </div>
                </div>
            </div>`;
        cont.appendChild(div);
        div.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function addSaudara() {
        counts.sa++;
        const cont = document.getElementById("saudaraContainer");
        const empty = document.getElementById("emptySaudara");
        if (empty) empty.style.display = "none";
        const div = document.createElement("div");
        div.className = "sub-card mb-3";
        div.innerHTML = `
            <div class="sub-card-header d-flex justify-content-between align-items-center">
                <span class="text-primary">Saudara ke-${counts.sa}</span>
                <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.parentElement.remove()"><i class="bi bi-trash"></i></button>
            </div>
            <div class="row g-3 pt-3">
                <div class="col-md-4"><label class="form-label">NIK</label><div class="input-group"><input type="text" class="form-control nik-lookup" name="saudara[${counts.sa}][nik]" placeholder="16 digit NIK" minlength="16" maxlength="16" inputmode="numeric" pattern="[0-9]{16}" style="border-radius: 10px 0 0 10px;"><button type="button" class="btn btn-outline-primary btn-nik-search" title="Cari NIK" style="border-radius: 0 10px 10px 0; border: none; background: #e8f0fe;"><i class="bi bi-search"></i></button></div></div>
                <div class="col-md-4"><label class="form-label">Nama Saudara *</label><input type="text" class="form-control" name="saudara[${counts.sa}][nama]" placeholder="Nama lengkap"></div>
                <div class="col-md-4"><label class="form-label">Jenis Kelamin</label><select class="form-select" name="saudara[${counts.sa}][jenis_kelamin]"><option value="">Pilih</option><option value="L">Laki-laki</option><option value="P">Perempuan</option></select></div>
                <div class="col-md-4"><label class="form-label">Tempat Lahir</label><input type="text" class="form-control" name="saudara[${counts.sa}][tempat_lahir]" placeholder="Kota/kabupaten"></div>
                <div class="col-md-4"><label class="form-label">Tanggal Lahir</label><input type="date" class="form-control" name="saudara[${counts.sa}][tanggal_lahir]"></div>
                <div class="col-md-4"><label class="form-label">Status Kawin</label><select class="form-select" name="saudara[${counts.sa}][status_kawin]"><option value="">Pilih</option><option>Belum Menikah</option><option>Menikah</option><option>Cerai Hidup</option><option>Cerai Mati</option></select></div>
                <div class="col-md-4"><label class="form-label">Status Saudara</label><select class="form-select" name="saudara[${counts.sa}][status_saudara]"><option value="">Pilih</option><option>Kandung</option><option>Tiri</option><option>Angkat</option></select></div>
                <div class="col-md-4"><label class="form-label">Pekerjaan</label><input type="text" class="form-control" name="saudara[${counts.sa}][pekerjaan]" placeholder="Pekerjaan saudara"></div>
            </div>`;
        cont.appendChild(div);
        div.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    const drhAddModalEl = document.getElementById('drhAddModal');
    const drhAddModal = drhAddModalEl ? new bootstrap.Modal(drhAddModalEl) : null;
    const drhAddModalBody = document.getElementById('drhAddModalBody');
    const drhAddModalTitle = document.getElementById('drhAddModalLabel');
    const drhAddModalSaveBtn = document.getElementById('drhAddModalSaveBtn');

    let drhPendingNode = null;
    let drhPendingTarget = null;

    function openDrhAddModal(title, createFn, targetSelector) {
        const target = document.querySelector(targetSelector);
        if (!target || !drhAddModal || !drhAddModalBody) {
            createFn();
            return;
        }

        const beforeCount = target.querySelectorAll('.sub-card').length;
        createFn();
        const allCards = target.querySelectorAll('.sub-card');
        const createdNode = allCards[allCards.length - 1];

        if (!createdNode || allCards.length === beforeCount) {
            return;
        }

        drhPendingNode = createdNode;
        drhPendingTarget = target;

        drhAddModalTitle.textContent = title;
        drhAddModalBody.innerHTML = '';
        drhAddModalBody.appendChild(createdNode);
        drhAddModal.show();
    }

    if (drhAddModalSaveBtn) {
        drhAddModalSaveBtn.addEventListener('click', function () {
            if (drhPendingNode && drhPendingTarget) {
                drhPendingTarget.appendChild(drhPendingNode);
                drhPendingNode = null;
                drhPendingTarget = null;
            }
            drhAddModal?.hide();
        });
    }

    if (drhAddModalEl) {
        drhAddModalEl.addEventListener('hidden.bs.modal', function () {
            if (drhPendingNode) {
                drhPendingNode.remove();
                drhPendingNode = null;
                drhPendingTarget = null;
            }
            drhAddModalBody.innerHTML = '';
        });
    }

    function wrapAddWithModal(fnName, title, targetSelector) {
        const originalFn = window[fnName];
        if (typeof originalFn !== 'function') return;

        window[fnName] = function () {
            openDrhAddModal(title, originalFn, targetSelector);
        };
    }

    function deleteDrhSavedRow(url, btn) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: 'Data yang dihapus tidak bisa dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d32f2f',
            cancelButtonColor: '#757575',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(url, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.status === 'success') {
                        btn.closest('tr, .sub-card').remove();
                        showSuccessNotification(data.message || 'Data berhasil dihapus.');
                    } else {
                        Swal.fire('Gagal', data.message || 'Gagal menghapus data.', 'error');
                    }
                })
                .catch(() => Swal.fire('Gagal', 'Terjadi kesalahan server.', 'error'));
            }
        });
    }

    // ======= Edit Modal untuk Anak & Saudara =======
    let _editRowModal = null;
    let _editRowType = null;
    let _editRowId = null;
    let _editRowTr = null;
    let _editRowStatusHub = null;

    function toggleRowEditCancelButton(type, isActive) {
        const btnId = type === 'anak' ? 'cancelEditAnakBtn' : type === 'saudara' ? 'cancelEditSaudaraBtn' : null;
        if (!btnId) return;
        const btn = document.getElementById(btnId);
        if (!btn) return;
        btn.classList.toggle('d-none', !isActive);
        btn.disabled = !isActive;
    }

    function clearCurrentRowEditState() {
        toggleRowEditCancelButton('anak', false);
        toggleRowEditCancelButton('saudara', false);
        _editRowType = null;
        _editRowId = null;
        _editRowTr = null;
        _editRowStatusHub = null;
    }

    function cancelCurrentRowEdit(type) {
        if (!type || _editRowType !== type) return;
        _getEditModal().hide();
    }

    function _getEditModal() {
        if (!_editRowModal) {
            _editRowModal = new bootstrap.Modal(document.getElementById('editRowModal'));
        }
        return _editRowModal;
    }

    function _esc(str) {
        return String(str || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    function _toYmd(val) {
        const raw = String(val || '').trim();
        if (!raw) return '';
        const m = raw.match(/^(\d{4}-\d{2}-\d{2})/);
        if (m) return m[1];
        const d = new Date(raw);
        if (Number.isNaN(d.getTime())) return raw;
        const y = d.getFullYear();
        const mo = String(d.getMonth() + 1).padStart(2, '0');
        const da = String(d.getDate()).padStart(2, '0');
        return `${y}-${mo}-${da}`;
    }

    function openEditAnakModal(btn) {
        if (!btn?.dataset?.row) return;
        const data = JSON.parse(btn.dataset.row);
        _editRowType = 'anak';
        _editRowId   = data.id;
        _editRowTr   = btn.closest('tr');
        toggleRowEditCancelButton('anak', true);
        toggleRowEditCancelButton('saudara', false);
        document.getElementById('editRowModalLabel').textContent = 'Edit Data Anak';
        const jkOpts = [['', 'Pilih'], ['L', 'Laki-laki'], ['P', 'Perempuan']].map(([v, l]) =>
            `<option value="${v}" ${data.jenis_kelamin === v && v !== '' ? 'selected' : ''}>${l}</option>`).join('');
        const skOpts = ['', 'Belum Menikah', 'Menikah', 'Cerai Hidup', 'Cerai Mati'].map(s =>
            `<option value="${s}" ${data.status_kawin === s && s !== '' ? 'selected' : ''}>${s || 'Pilih'}</option>`).join('');
        const saOpts = ['', 'Kandung', 'Tiri', 'Angkat'].map(s =>
            `<option value="${s}" ${data.status_anak === s && s !== '' ? 'selected' : ''}>${s || 'Pilih'}</option>`).join('');
        document.getElementById('editRowModalBody').innerHTML = `
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label fw-semibold">Nama Anak *</label><input type="text" class="form-control" id="erNama" value="${_esc(data.nama)}"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">NIK</label><input type="text" class="form-control" id="erNik" value="${_esc(data.nik)}" maxlength="16" inputmode="numeric"></div>
                <div class="col-md-4"><label class="form-label fw-semibold">Jenis Kelamin</label><select class="form-select" id="erJk">${jkOpts}</select></div>
                <div class="col-md-4"><label class="form-label fw-semibold">Tempat Lahir</label><input type="text" class="form-control" id="erTl" value="${_esc(data.tempat_lahir)}"></div>
                <div class="col-md-4"><label class="form-label fw-semibold">Tanggal Lahir</label><input type="date" class="form-control" id="erTgl" value="${_esc(_toYmd(data.tanggal_lahir))}"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Pekerjaan</label><input type="text" class="form-control" id="erPkj" value="${_esc(data.pekerjaan)}"></div>
                <div class="col-md-3"><label class="form-label fw-semibold">Status Kawin</label><select class="form-select" id="erSk">${skOpts}</select></div>
                <div class="col-md-3"><label class="form-label fw-semibold">Status Anak</label><select class="form-select" id="erSa">${saOpts}</select></div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Akta Kelahiran (PDF)${data.file_url ? ' <a href="'+_esc(data.file_url)+'" target="_blank" class="ms-2 small text-primary">Lihat file lama</a>' : ''}</label>
                    <input type="file" class="form-control" id="erFile" accept=".pdf">
                    <small class="text-muted">Biarkan kosong untuk tidak mengganti file</small>
                </div>
            </div>`;
        _getEditModal().show();
    }

    function openEditSaudaraModal(btn) {
        if (!btn?.dataset?.row) return;
        const data = JSON.parse(btn.dataset.row);
        _editRowType = 'saudara';
        _editRowId   = data.id;
        _editRowTr   = btn.closest('tr');
        toggleRowEditCancelButton('anak', false);
        toggleRowEditCancelButton('saudara', true);
        document.getElementById('editRowModalLabel').textContent = 'Edit Data Saudara';
        const jkOpts = [['', 'Pilih'], ['L', 'Laki-laki'], ['P', 'Perempuan']].map(([v, l]) =>
            `<option value="${v}" ${data.jenis_kelamin === v && v !== '' ? 'selected' : ''}>${l}</option>`).join('');
        const skOpts = ['', 'Belum Menikah', 'Menikah', 'Cerai Hidup', 'Cerai Mati'].map(s =>
            `<option value="${s}" ${data.status_kawin === s && s !== '' ? 'selected' : ''}>${s || 'Pilih'}</option>`).join('');
        const ssOpts = ['', 'Kandung', 'Tiri', 'Angkat'].map(s =>
            `<option value="${s}" ${data.status_saudara === s && s !== '' ? 'selected' : ''}>${s || 'Pilih'}</option>`).join('');
        document.getElementById('editRowModalBody').innerHTML = `
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label fw-semibold">Nama Saudara *</label><input type="text" class="form-control" id="erNama" value="${_esc(data.nama)}"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">NIK</label><input type="text" class="form-control" id="erNik" value="${_esc(data.nik)}" maxlength="16" inputmode="numeric"></div>
                <div class="col-md-4"><label class="form-label fw-semibold">Jenis Kelamin</label><select class="form-select" id="erJk">${jkOpts}</select></div>
                <div class="col-md-4"><label class="form-label fw-semibold">Tempat Lahir</label><input type="text" class="form-control" id="erTl" value="${_esc(data.tempat_lahir)}"></div>
                <div class="col-md-4"><label class="form-label fw-semibold">Tanggal Lahir</label><input type="date" class="form-control" id="erTgl" value="${_esc(_toYmd(data.tanggal_lahir))}"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Pekerjaan</label><input type="text" class="form-control" id="erPkj" value="${_esc(data.pekerjaan)}"></div>
                <div class="col-md-3"><label class="form-label fw-semibold">Status Kawin</label><select class="form-select" id="erSk">${skOpts}</select></div>
                <div class="col-md-3"><label class="form-label fw-semibold">Status Saudara</label><select class="form-select" id="erSs">${ssOpts}</select></div>
            </div>`;
        _getEditModal().show();
    }

    function openEditPasanganModal(btn) {
        if (!btn?.dataset?.row) return;
        const data = JSON.parse(btn.dataset.row);
        _editRowType = 'pasangan';
        _editRowId = data.id;
        _editRowTr = btn.closest('tr');
        _editRowStatusHub = null;
        toggleRowEditCancelButton('anak', false);
        toggleRowEditCancelButton('saudara', false);
        document.getElementById('editRowModalLabel').textContent = 'Edit Data Pasangan';
        const statusOpts = ['', 'SUAMI', 'ISTRI'].map(s =>
            `<option value="${s}" ${data.status === s && s !== '' ? 'selected' : ''}>${s || 'Pilih'}</option>`).join('');
        const hidupOpts = ['', 'Hidup', 'Meninggal'].map(s =>
            `<option value="${s}" ${data.status_hidup === s && s !== '' ? 'selected' : ''}>${s || 'Pilih'}</option>`).join('');
        document.getElementById('editRowModalBody').innerHTML = `
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label fw-semibold">Nama *</label><input type="text" class="form-control" id="erNama" value="${_esc(data.nama)}"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">NIK</label><input type="text" class="form-control" id="erNik" value="${_esc(data.nik)}" maxlength="16" inputmode="numeric"></div>
                <div class="col-md-4"><label class="form-label fw-semibold">Status Pasangan</label><select class="form-select" id="erStatusPasangan">${statusOpts}</select></div>
                <div class="col-md-4"><label class="form-label fw-semibold">Status Hidup</label><select class="form-select" id="erStatusHidup">${hidupOpts}</select></div>
                <div class="col-md-4"><label class="form-label fw-semibold">Tanggal Lahir</label><input type="date" class="form-control" id="erTgl" value="${_esc(_toYmd(data.tanggal_lahir))}"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Tempat Lahir</label><input type="text" class="form-control" id="erTl" value="${_esc(data.tempat_lahir)}"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Pekerjaan</label><input type="text" class="form-control" id="erPkj" value="${_esc(data.pekerjaan)}"></div>
                <div class="col-12"><label class="form-label fw-semibold">No. Akta Nikah</label><input type="text" class="form-control" id="erNoAkta" value="${_esc(data.no_akta_nikah)}"></div>
            </div>`;
        _getEditModal().show();
    }

    function openEditOrangTuaModal(btn) {
        if (!btn?.dataset?.row) return;
        const data = JSON.parse(btn.dataset.row);
        _editRowType = 'orang-tua';
        _editRowId = data.id;
        _editRowTr = btn.closest('tr');
        _editRowStatusHub = data.status_hub || (data.hubungan === 'Ayah Kandung' ? 'Ayah' : 'Ibu');
        toggleRowEditCancelButton('anak', false);
        toggleRowEditCancelButton('saudara', false);
        document.getElementById('editRowModalLabel').textContent = `Edit Data ${_esc(data.hubungan || 'Orang Tua')}`;
        const hidupOpts = ['', 'Hidup', 'Meninggal'].map(s =>
            `<option value="${s}" ${data.status_hidup === s && s !== '' ? 'selected' : ''}>${s || 'Pilih'}</option>`).join('');
        document.getElementById('editRowModalBody').innerHTML = `
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label fw-semibold">Nama *</label><input type="text" class="form-control" id="erNama" value="${_esc(data.nama)}"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">NIK</label><input type="text" class="form-control" id="erNik" value="${_esc(data.nik)}" maxlength="16" inputmode="numeric"></div>
                <div class="col-md-4"><label class="form-label fw-semibold">Tanggal Lahir</label><input type="date" class="form-control" id="erTgl" value="${_esc(_toYmd(data.tanggal_lahir))}"></div>
                <div class="col-md-4"><label class="form-label fw-semibold">Status Hidup</label><select class="form-select" id="erStatusHidup">${hidupOpts}</select></div>
                <div class="col-md-4"><label class="form-label fw-semibold">Pekerjaan</label><input type="text" class="form-control" id="erPkj" value="${_esc(data.pekerjaan)}"></div>
                <div class="col-12"><label class="form-label fw-semibold">Alamat</label><textarea class="form-control" id="erAlamat" rows="2">${_esc(data.alamat)}</textarea></div>
            </div>`;
        _getEditModal().show();
    }

    function openEditMertuaModal(btn) {
        if (!btn?.dataset?.row) return;
        const data = JSON.parse(btn.dataset.row);
        _editRowType = 'mertua';
        _editRowId = data.id;
        _editRowTr = btn.closest('tr');
        _editRowStatusHub = data.status_hub || (data.hubungan === 'Ayah Mertua' ? 'Ayah Mertua' : 'Ibu Mertua');
        toggleRowEditCancelButton('anak', false);
        toggleRowEditCancelButton('saudara', false);
        document.getElementById('editRowModalLabel').textContent = `Edit Data ${_esc(data.hubungan || 'Mertua')}`;
        const hidupOpts = ['', 'Hidup', 'Meninggal'].map(s =>
            `<option value="${s}" ${data.status_hidup === s && s !== '' ? 'selected' : ''}>${s || 'Pilih'}</option>`).join('');
        document.getElementById('editRowModalBody').innerHTML = `
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label fw-semibold">Nama *</label><input type="text" class="form-control" id="erNama" value="${_esc(data.nama)}"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">NIK</label><input type="text" class="form-control" id="erNik" value="${_esc(data.nik)}" maxlength="16" inputmode="numeric"></div>
                <div class="col-md-4"><label class="form-label fw-semibold">Tanggal Lahir</label><input type="date" class="form-control" id="erTgl" value="${_esc(_toYmd(data.tanggal_lahir))}"></div>
                <div class="col-md-4"><label class="form-label fw-semibold">Status Hidup</label><select class="form-select" id="erStatusHidup">${hidupOpts}</select></div>
                <div class="col-md-4"><label class="form-label fw-semibold">Pekerjaan</label><input type="text" class="form-control" id="erPkj" value="${_esc(data.pekerjaan)}"></div>
            </div>`;
        _getEditModal().show();
    }

    document.getElementById('editRowModalSaveBtn').addEventListener('click', async function () {
        if (!_editRowType) return;
        const btn = this;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';

        const isCreate = !_editRowId;
        const fd = new FormData();
        if (!isCreate) fd.append('_method', 'PUT');
        fd.append('nama',    (document.getElementById('erNama')?.value || '').trim());
        fd.append('nik',     (document.getElementById('erNik')?.value || '').trim());
        fd.append('jenis_kelamin', document.getElementById('erJk')?.value || '');
        fd.append('tempat_lahir',  (document.getElementById('erTl')?.value || '').trim());
        fd.append('tanggal_lahir', document.getElementById('erTgl')?.value || '');
        fd.append('pekerjaan',     (document.getElementById('erPkj')?.value || '').trim());
        if (_editRowType === 'anak' || _editRowType === 'saudara') {
            fd.append('status_kawin',  document.getElementById('erSk')?.value || '');
        }
        if (_editRowType === 'pasangan') {
            fd.append('status', document.getElementById('erStatusPasangan')?.value || '');
            fd.append('status_hidup', document.getElementById('erStatusHidup')?.value || '');
            fd.append('no_akta_nikah', (document.getElementById('erNoAkta')?.value || '').trim());
        } else if (_editRowType === 'orang-tua' || _editRowType === 'mertua') {
            fd.append('status_hidup', document.getElementById('erStatusHidup')?.value || '');
            if (_editRowType === 'orang-tua') {
                fd.append('alamat', (document.getElementById('erAlamat')?.value || '').trim());
            }
            if (isCreate && _editRowStatusHub) {
                fd.append('status_hub', _editRowStatusHub);
            }
        }

        if (_editRowType === 'anak') {
            fd.append('status_anak', document.getElementById('erSa')?.value || '');
        } else if (_editRowType === 'saudara') {
            fd.append('status_saudara', document.getElementById('erSs')?.value || '');
        }
        if (_editRowType === 'anak') {
            const fileInput = document.getElementById('erFile');
            if (fileInput?.files.length > 0) fd.append('file', fileInput.files[0]);
        }

        let url = '';
        if (isCreate) {
            url = `/profile/drh/keluarga/${_editRowType}`;
        } else if (_editRowType === 'anak') {
            url = `/profile/drh/anak/${_editRowId}`;
        } else if (_editRowType === 'saudara') {
            url = `/profile/drh/saudara/${_editRowId}`;
        } else {
            url = `/profile/drh/keluarga/${_editRowType}/${_editRowId}`;
        }

        try {
            const res  = await fetch(url, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: fd,
            });
            const json = await res.json();
            if (json.status === 'success') {
                _getEditModal().hide();
                showSuccessNotification(json.message || 'Data berhasil diperbarui.');
                const d = json.data;
                if (_editRowTr) {
                    if (_editRowType === 'anak') {
                        const jkLbl = d.jenis_kelamin === 'L' ? 'Laki-laki' : d.jenis_kelamin === 'P' ? 'Perempuan' : '-';
                        _editRowTr.cells[0].textContent = d.nama || '-';
                        _editRowTr.cells[1].textContent = d.nik || '-';
                        _editRowTr.cells[2].textContent = jkLbl;
                        _editRowTr.cells[3].textContent = d.tempat_lahir || '-';
                        _editRowTr.cells[4].textContent = _toYmd(d.tanggal_lahir) || '-';
                        _editRowTr.cells[5].textContent = d.pekerjaan || '-';
                        _editRowTr.cells[6].textContent = d.status_kawin || '-';
                        _editRowTr.cells[7].textContent = d.status_anak || '-';
                        const editBtn = _editRowTr.querySelector('button[onclick*="openEditAnakModal"]');
                        if (editBtn) editBtn.dataset.row = JSON.stringify({ ...d, tanggal_lahir: _toYmd(d.tanggal_lahir) });
                        if (d.id) {
                            const delBtn = _editRowTr.querySelector('button[onclick*="deleteDrhSavedRow"]');
                            if (delBtn) delBtn.setAttribute('onclick', `deleteDrhSavedRow('/profile/drh/anak/${d.id}', this)`);
                        }
                    } else if (_editRowType === 'saudara') {
                        const jkLbl = d.jenis_kelamin === 'L' ? 'Laki-laki' : d.jenis_kelamin === 'P' ? 'Perempuan' : '-';
                        _editRowTr.cells[0].textContent = d.nama || '-';
                        _editRowTr.cells[1].textContent = d.nik || '-';
                        _editRowTr.cells[2].textContent = jkLbl;
                        _editRowTr.cells[3].textContent = d.status_kawin || '-';
                        _editRowTr.cells[4].textContent = d.status_saudara || '-';
                        _editRowTr.cells[5].textContent = _toYmd(d.tanggal_lahir) || '-';
                        _editRowTr.cells[6].textContent = d.pekerjaan || '-';
                        const editBtn = _editRowTr.querySelector('button[onclick*="openEditSaudaraModal"]');
                        if (editBtn) editBtn.dataset.row = JSON.stringify({ ...d, tanggal_lahir: _toYmd(d.tanggal_lahir) });
                        if (d.id) {
                            const delBtn = _editRowTr.querySelector('button[onclick*="deleteDrhSavedRow"]');
                            if (delBtn) delBtn.setAttribute('onclick', `deleteDrhSavedRow('/profile/drh/saudara/${d.id}', this)`);
                        }
                    } else if (_editRowType === 'pasangan') {
                        _editRowTr.cells[0].textContent = d.nama || '-';
                        _editRowTr.cells[1].textContent = d.nik || '-';
                        _editRowTr.cells[2].textContent = `${d.tempat_lahir || '-'}, ${_toYmd(d.tanggal_lahir) || '-'}`;
                        _editRowTr.cells[3].textContent = d.pekerjaan || '-';
                        _editRowTr.cells[4].textContent = d.no_akta_nikah || '-';
                        _editRowTr.cells[5].textContent = `${d.status || '-'} • ${d.status_hidup || '-'}`;
                        const editBtn = _editRowTr.querySelector('button[onclick*="openEditPasanganModal"]');
                        const delBtn = _editRowTr.querySelector('button[onclick*="/profile/drh/keluarga/pasangan/"]');
                        if (editBtn) editBtn.dataset.row = JSON.stringify({ ...d, tanggal_lahir: _toYmd(d.tanggal_lahir) });
                        if (delBtn && d.id) delBtn.setAttribute('onclick', `deleteDrhSavedRow('/profile/drh/keluarga/pasangan/${d.id}', this)`);
                    } else if (_editRowType === 'orang-tua') {
                        _editRowTr.cells[1].textContent = d.nama || '-';
                        _editRowTr.cells[2].textContent = d.nik || '-';
                        _editRowTr.cells[3].textContent = _toYmd(d.tanggal_lahir) || '-';
                        _editRowTr.cells[4].textContent = d.status_hidup || '-';
                        _editRowTr.cells[5].textContent = d.pekerjaan || '-';
                        _editRowTr.cells[6].textContent = d.alamat || '-';
                        const editBtn = _editRowTr.querySelector('button[onclick*="openEditOrangTuaModal"]');
                        const delBtn = _editRowTr.querySelector('button[onclick*="/profile/drh/keluarga/orang-tua/"]');
                        if (editBtn) editBtn.dataset.row = JSON.stringify({ ...d, hubungan: _editRowTr.cells[0]?.textContent || '' , tanggal_lahir: _toYmd(d.tanggal_lahir) });
                        if (delBtn && d.id) delBtn.setAttribute('onclick', `deleteDrhSavedRow('/profile/drh/keluarga/orang-tua/${d.id}', this)`);
                    } else if (_editRowType === 'mertua') {
                        _editRowTr.cells[1].textContent = d.nama || '-';
                        _editRowTr.cells[2].textContent = d.nik || '-';
                        _editRowTr.cells[3].textContent = _toYmd(d.tanggal_lahir) || '-';
                        _editRowTr.cells[4].textContent = d.status_hidup || '-';
                        _editRowTr.cells[5].textContent = d.pekerjaan || '-';
                        const editBtn = _editRowTr.querySelector('button[onclick*="openEditMertuaModal"]');
                        const delBtn = _editRowTr.querySelector('button[onclick*="/profile/drh/keluarga/mertua/"]');
                        if (editBtn) editBtn.dataset.row = JSON.stringify({ ...d, hubungan: _editRowTr.cells[0]?.textContent || '', tanggal_lahir: _toYmd(d.tanggal_lahir) });
                        if (delBtn && d.id) delBtn.setAttribute('onclick', `deleteDrhSavedRow('/profile/drh/keluarga/mertua/${d.id}', this)`);
                    }
                }
            } else {
                Swal.fire('Gagal', json.message || 'Gagal menyimpan data.', 'error');
            }
        } catch (e) {
            Swal.fire('Gagal', 'Terjadi kesalahan server.', 'error');
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-cloud-arrow-up-fill me-2"></i>Simpan';
        }
    });

    document.getElementById('editRowModal').addEventListener('hidden.bs.modal', function () {
        clearCurrentRowEditState();
    });
    // ======= End Edit Modal =======

    // Hapus seluruh sub-seksi keluarga (pasangan / orang_tua / mertua)
    function deleteKeluargaSection(subStep, btn) {
        const sectionNameMap = { pasangan: 'Data Pasangan', orang_tua: 'Data Orang Tua', mertua: 'Data Mertua' };
        const panelIdMap = { pasangan: 'Pasangan', orang_tua: 'OrangTua', mertua: 'Mertua' };

        Swal.fire({
            title: 'Hapus ' + (sectionNameMap[subStep] || 'Data') + '?',
            text: 'Semua data yang tersimpan akan dihapus permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d32f2f',
            cancelButtonColor: '#757575',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (!result.isConfirmed) return;

            if (btn) { btn.disabled = true; btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'; }

            fetch('/profile/drh/keluarga/' + subStep, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.status === 'success') {
                    const panelId = panelIdMap[subStep];
                    const viewEl = document.getElementById('view' + panelId);
                    const formEl = document.getElementById('form' + panelId);
                    if (viewEl) viewEl.style.display = 'none';
                    if (formEl) {
                        // Clear all form controls in the form panel
                        formEl.querySelectorAll('input[type="text"], input[type="date"], textarea').forEach(el => { el.value = ''; });
                        formEl.querySelectorAll('input[type="file"]').forEach(el => { el.value = ''; });
                        formEl.querySelectorAll('select').forEach(el => {
                            if (el.options.length > 0) {
                                el.selectedIndex = 0;
                            }
                        });
                        formEl.style.display = 'block';
                    }
                    showSuccessNotification(data.message || 'Data berhasil dihapus.');
                } else {
                    Swal.fire('Gagal', data.message || 'Gagal menghapus data.', 'error');
                }
            })
            .catch(() => Swal.fire('Gagal', 'Terjadi kesalahan server.', 'error'))
            .finally(() => {
                if (btn) { btn.disabled = false; btn.innerHTML = '<i class="bi bi-trash me-1"></i> Hapus'; }
            });
        });
    }

    wrapAddWithModal('addPendidikan', 'Tambah Data Riwayat Pendidikan', '#pendidikanContainer');
    wrapAddWithModal('addDiklat', 'Tambah Data Riwayat Diklat', '#diklatContainer');
    wrapAddWithModal('addJabatan', 'Tambah Data Riwayat Jabatan', '#jabatanContainer');
    wrapAddWithModal('addAward', 'Tambah Data Riwayat Penghargaan', '#awardContainer');
    wrapAddWithModal('addSertif', 'Tambah Data Riwayat Sertifikasi', '#sertifContainer');
    wrapAddWithModal('addAnak', 'Tambah Data Anak', '#anakContainer');
    wrapAddWithModal('addSaudara', 'Tambah Data Saudara', '#saudaraContainer');

    window.onload = () => {
        if (!profileComplete) {
            for (let i = 1; i < progs.length; i++) {
                progs[i].disabled = true;
                progs[i].classList.add('disabled');
            }
        }
        toggleFamilyLogic();
    };

    // Handle file upload preview for both static and dynamic file inputs
    document.addEventListener('change', function(e) {
        const input = e.target;
        if (!input.matches('input[type="file"]')) {
            return;
        }

        const file = input.files[0];
        if (!file) {
            return;
        }

        const maxSize = 1024 * 1024;
        if (file.size > maxSize) {
            showToast('File ' + file.name + ' terlalu besar. Maksimal 1 MB.', 'warning');
            input.value = '';
            return;
        }

        if (file.type !== 'application/pdf') {
            showToast('File ' + file.name + ' harus berformat PDF.', 'warning');
            input.value = '';
            return;
        }

        // Update the label with file name
        const label = document.querySelector('label[for="' + input.id + '"]');
        if (label) {
            label.innerHTML = '<i class="bi bi-check-circle-fill me-2 text-success"></i>' + file.name + ' <small>(PDF, ' + (file.size / 1024 / 1024).toFixed(2) + ' MB)</small>';
        }
    });

    // ===== NIK LOOKUP KELUARGA =====
    // Mapping: dari nama input NIK → field-field terkait yang bisa diisi
    const nikFieldMap = {
        'nik_pasangan': {
            nama: 'nama_pasangan',
            tempat_lahir: 'tempat_lahir_pasangan',
            tanggal_lahir: 'tanggal_lahir_pasangan',
            pekerjaan: 'pekerjaan_pasangan',
        },
        'nik_ayah': {
            nama: 'nama_ayah',
            tanggal_lahir: 'tanggal_lahir_ayah',
            pekerjaan: 'pekerjaan_ayah',
            alamat: 'alamat_ayah',
        },
        'nik_ibu': {
            nama: 'nama_ibu',
            tanggal_lahir: 'tanggal_lahir_ibu',
            pekerjaan: 'pekerjaan_ibu',
            alamat: 'alamat_ibu',
        },
        'nik_ayah_mertua': {
            nama: 'nama_ayah_mertua',
            tanggal_lahir: 'tanggal_lahir_ayah_mertua',
            pekerjaan: 'pekerjaan_ayah_mertua',
        },
        'nik_ibu_mertua': {
            nama: 'nama_ibu_mertua',
            tanggal_lahir: 'tanggal_lahir_ibu_mertua',
            pekerjaan: 'pekerjaan_ibu_mertua',
        },
    };

    function formatDateForInput(dateStr) {
        if (!dateStr) return null;
        // Already YYYY-MM-DD
        if (/^\d{4}-\d{2}-\d{2}$/.test(dateStr)) return dateStr;
        // Try parsing
        const d = new Date(dateStr);
        if (isNaN(d.getTime())) return null;
        return d.toISOString().split('T')[0];
    }

    function cekNikKeluarga(nikInput) {
        const nik = nikInput.value.trim();
        if (!nik || nik.length < 6) return;

        const inputName = nikInput.getAttribute('name');
        const container = nikInput.closest('.sub-card, .card-body, .row');
        const btn = nikInput.parentElement.querySelector('.btn-nik-search');

        // Show loading
        if (btn) {
            btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
            btn.disabled = true;
        }

        fetch(`/api/cek-keluarga/${encodeURIComponent(nik)}`)
            .then(r => r.json())
            .then(res => {
                if (res.success && res.data) {
                    const data = res.data;

                    // Check if it's an array-type field (anak[0][nik], saudara[1][nik])
                    const arrayMatch = inputName.match(/^(anak|saudara)\[(\d+)\]\[nik\]$/);

                    if (arrayMatch) {
                        const prefix = arrayMatch[1];
                        const idx = arrayMatch[2];
                        // Fill array fields by name pattern
                        fillField(container, `${prefix}[${idx}][nama]`, data.nama);
                        fillField(container, `${prefix}[${idx}][tempat_lahir]`, data.tempat_lahir);
                        fillField(container, `${prefix}[${idx}][tanggal_lahir]`, formatDateForInput(data.tanggal_lahir));
                        fillField(container, `${prefix}[${idx}][pekerjaan]`, data.pekerjaan);
                        fillSelectField(container, `${prefix}[${idx}][jenis_kelamin]`, data.jenis_kelamin);
                    } else {
                        // Fixed fields (pasangan, ayah, ibu, mertua)
                        const map = nikFieldMap[inputName];
                        if (map) {
                            if (map.nama) fillField(container, map.nama, data.nama);
                            if (map.tempat_lahir) fillField(container, map.tempat_lahir, data.tempat_lahir);
                            if (map.tanggal_lahir) fillField(container, map.tanggal_lahir, formatDateForInput(data.tanggal_lahir));
                            if (map.pekerjaan) fillField(container, map.pekerjaan, data.pekerjaan);
                            if (map.alamat) fillField(container, map.alamat, data.alamat);
                        }
                    }

                    // Flash green on filled fields
                    nikInput.style.boxShadow = '0 0 0 3px rgba(34,197,94,0.3)';
                    setTimeout(() => { nikInput.style.boxShadow = ''; }, 2000);
                } else {
                    // NIK not found - don't clear existing data
                    nikInput.style.boxShadow = '0 0 0 3px rgba(239,68,68,0.3)';
                    setTimeout(() => { nikInput.style.boxShadow = ''; }, 2000);
                }
            })
            .catch(() => {
                nikInput.style.boxShadow = '0 0 0 3px rgba(239,68,68,0.3)';
                setTimeout(() => { nikInput.style.boxShadow = ''; }, 2000);
            })
            .finally(() => {
                if (btn) {
                    btn.innerHTML = '<i class="bi bi-search"></i>';
                    btn.disabled = false;
                }
            });
    }

    function fillField(container, fieldName, value) {
        if (!value) return;
        const el = document.querySelector(`[name="${fieldName}"]`);
        if (el) el.value = value;
    }

    function fillSelectField(container, fieldName, value) {
        if (!value) return;
        const el = document.querySelector(`select[name="${fieldName}"]`);
        if (el) {
            for (let opt of el.options) {
                if (opt.value === value) { el.value = value; break; }
            }
        }
    }

    // Event delegation: blur on NIK inputs
    document.addEventListener('focusout', function(e) {
        if (e.target.matches('input.nik-lookup')) {
            cekNikKeluarga(e.target);
        }
    });

    // Event delegation: click on search button
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-nik-search');
        if (btn) {
            const nikInput = btn.parentElement.querySelector('input.nik-lookup');
            if (nikInput) cekNikKeluarga(nikInput);
        }
    });

    // Terapkan pembatasan NIK 16 digit pada semua input NIK (termasuk elemen dinamis)
    document.addEventListener('input', function(e) {
        const target = e.target;
        if (!(target instanceof HTMLInputElement)) return;

        const nameAttr = target.getAttribute('name') || '';
        const isNikField = nameAttr === 'nik' || nameAttr === 'nik_ktp' || nameAttr.includes('[nik]') || nameAttr.startsWith('nik_');

        if (!isNikField) return;

        target.value = target.value.replace(/\D/g, '').slice(0, 16);
    });

    // === DRH Document Edit/Delete Functions ===
    function drhReuploadPreview(input) {
        const file = input.files[0];
        if (file) {
            const container = input.closest('.alert') || input.closest('.status-container');
            if (container) {
                const textEl = container.querySelector('.fw-bold.text-success, .status-text');
                if (textEl) {
                    textEl.innerHTML = '<i class="bi bi-arrow-repeat text-primary me-2"></i><span class="text-primary">File baru: ' + file.name + '</span>';
                }
            }
        }
    }

    function confirmDeleteDrhDoc(section, id) {
        const names = {
            pendidikan: 'Ijazah', diklat: 'Sertifikat Diklat', jabatan: 'SK Jabatan',
            sertifikasi: 'Sertifikat', penghargaan: 'Piagam'
        };
        const label = names[section] || 'Dokumen';
        
        if (typeof Swal === 'undefined') {
            // Fallback if SweetAlert2 not loaded
            if (confirm('Apakah Anda yakin ingin menghapus dokumen ' + label + '? File yang sudah dihapus tidak bisa dikembalikan.')) {
                deleteDocument(section, id);
            }
            return;
        }

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: 'Dokumen ' + label + ' yang dihapus tidak bisa dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d32f2f',
            cancelButtonColor: '#757575',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            allowOutsideClick: false,
            allowEscapeKey: true
        }).then((result) => {
            if (result.isConfirmed) {
                deleteDocument(section, id);
            }
        });
    }

    function deleteDocument(section, id) {
        showToast('Menghapus dokumen...', 'info');
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = "{{ url('/profile/drh/dokumen') }}/" + section + "/" + id + "/delete-file";

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
</script>
@endpush

@endsection