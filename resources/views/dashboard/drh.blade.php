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
        body { background: #eef3fb; font-family: 'Inter', sans-serif; margin: 0; }
        .main-content { padding: 28px; min-height: 100vh; }
        .page-header-label { color: #2563eb; font-weight: 700; font-size: 12px; letter-spacing: 1px; text-transform: uppercase; border-left: 3px solid #2563eb; padding-left: 10px; margin-bottom: 10px; }
        .icon-box { width: 42px; height: 42px; border-radius: 14px; background: rgba(255,255,255,0.18); display: grid; place-items: center; font-size: 1.1rem; }
        .section-card { border: none; border-radius: 18px; overflow: hidden; box-shadow: 0 10px 28px rgba(15, 23, 42, 0.08); background: white; margin-bottom: 20px; }
        .section-card .card-body { background: #fbfdff; }
        .sub-card { background: var(--light-blue); border: 1px solid var(--border-blue); border-radius: 14px; padding: 20px; margin-bottom: 20px; position: relative; transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .sub-card:hover { transform: translateY(-2px); box-shadow: 0 12px 24px rgba(15, 23, 42, 0.08); }
        .sub-card-header { font-size: 13px; font-weight: 700; color: #2563eb; margin-bottom: 15px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #dbeafe; padding-bottom: 8px; }

        /* Progress Steps */
        .step-progress { display: flex; justify-content: space-between; gap: 10px; margin-bottom: 30px; background: white; padding: 20px; border-radius: 18px; box-shadow: 0 4px 18px rgba(0,0,0,0.08); overflow-x: auto; }
        .step-item { flex: 1; text-align: center; font-size: 11px; font-weight: 700; color: #94a3b8; min-width: 70px; cursor: pointer; border: none; background: none; padding: 0; text-transform: uppercase; }
        .step-item:focus { outline: none; }
        .step-item { flex: 1; text-align: center; font-size: 10px; font-weight: 700; color: #cbd5e1; min-width: 65px; }
        .step-item.disabled { opacity: 0.45; pointer-events: none; cursor: not-allowed; }
        .step-item.disabled .step-num { border-color: #e2e8f0; }
        .step-item.active { color: var(--primary-blue); }
        .step-num { width: 26px; height: 26px; line-height: 23px; border: 2px solid #cbd5e1; border-radius: 50%; display: block; margin: 0 auto 5px; background: white; }
        .step-item.active .step-num { background: var(--primary-blue); color: white; border-color: var(--primary-blue); }

        /* Card Styles */
        .section-card { border: none; border-radius: 18px; overflow: hidden; box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06); background: white; margin-bottom: 20px; }
        .section-header { background: linear-gradient(90deg, #2563eb, #1d4ed8); color: white; padding: 18px 25px; }
        .sub-card { background: var(--light-blue); border: 1px solid var(--border-blue); border-radius: 14px; padding: 20px; margin-bottom: 20px; position: relative; }
        .sub-card-header { font-size: 13px; font-weight: 700; color: #2563eb; margin-bottom: 15px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #dbeafe; padding-bottom: 8px; }

        .form-label { font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 6px; }
        .form-control, .form-select { border-radius: 10px; padding: 10px 15px; border: 1px solid #e2e8f0; background-color: #f8fafc; font-size: 14px; }
        .form-control:focus { background-color: white; border-color: var(--primary-blue); box-shadow: none; }

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

        .btn-nav-group { background: white; padding: 20px 30px; border-radius: 18px; display: flex; justify-content: space-between; gap: 10px; flex-wrap: wrap; margin-top: 25px; }
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
            padding: 24px 32px;
            border-radius: 12px;
            box-shadow: 0 20px 50px rgba(16, 185, 129, 0.3);
            z-index: 9999;
            animation: slideDown 0.3s ease-out;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            font-size: 16px;
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

        @media (max-width: 991px) { .sidebar { display: none; } .main-content { margin-left: 0; } }

        /* Stack all input columns vertically for DRH steps B-G */
        .form-step:not(:first-child) .row > [class*="col-"] {
            width: 100%;
            flex: 0 0 100%;
            max-width: 100%;
        }
    </style>


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
        <button class="step-item" id="s1" type="button" onclick="setStep(1)"><span class="step-num">B</span>Keluarga</button>
        <button class="step-item" id="s2" type="button" onclick="setStep(2)"><span class="step-num">C</span>Pendidikan</button>
        <button class="step-item" id="s3" type="button" onclick="setStep(3)"><span class="step-num">D</span>Diklat</button>
        <button class="step-item" id="s4" type="button" onclick="setStep(4)"><span class="step-num">E</span>Jabatan</button>
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
            @include('dashboard.drh.profildasar')
        </div>

        <div class="form-step">
            @include('dashboard.drh.keluarga')
        </div>

        <div class="form-step">
            @include('dashboard.drh.pendidikan')
        </div>

        <div class="form-step">
            @include('dashboard.drh.diklat')
        </div>

        <div class="form-step">
            @include('dashboard.drh.jabatan')
        </div>

        <div class="form-step">
            @include('dashboard.drh.penghargaan')
        </div>

        <div class="form-step">
            @include('dashboard.drh.sertifikasi')
        </div>

        <div class="form-step">
            @include('dashboard.drh.legal')
        </div>
    </form>
</div>
</div>

@push('scripts')
<script>
    // Initialize current step from localStorage (persists across page refresh) or from server session
    let serverStep = {{ session('step', old('step', 0)) }};
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
        document.getElementById('stepInput').value = cur;
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

    async function submitFormAjax() {
        const form = document.getElementById('drhForm');
        const formData = new FormData(form);
        
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
                renderStep();
                showSuccessNotification(data.message);
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
        document.getElementById('stepInput').value = cur;
        
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
        document.getElementById('stepInput').value = cur;
        submitFormAjax();
    }

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
    @if(session('success'))
        <div id="autoHideAlert" class=\"alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4 rounded-4 p-4 text-start\" role=\"alert\" style=\"background: #d4edda; border-left: 4px solid #28a745;\">
            <div class=\"d-flex align-items-start\">
                <i class=\"bi bi-check-circle-fill me-3\" style=\"font-size: 24px; color: #28a745; flex-shrink: 0;\"></i>
                <div>
                    <h6 class=\"fw-bold mb-2\" style=\"color: #155724;\">{{ session('success') }}</h6>
                    <p class=\"mb-0 small\">Data profil dasar Anda telah tersimpan dengan baik di sistem</p>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4 rounded-4 p-3 text-start" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    // On load, restore the current step and family section state
    renderStep();
    toggleFamilyLogic();

    @if(session('success'))
        showSuccessNotification('{{ session('success') }}');
        highlightSavedStep();
        // Auto-hide success alert after 3 seconds
        var autoHideAlert = document.getElementById('autoHideAlert');
        if (autoHideAlert) {
            setTimeout(function() {
                autoHideAlert.classList.remove('show');
                autoHideAlert.classList.add('fade');
                setTimeout(function() { autoHideAlert.remove(); }, 300);
            }, 3000);
        }
    @endif

    function toggleFamilyLogic() {
        const st = document.getElementById("statusPegawai").value;
        if (st === "Menikah") {
            // Show: Pasangan, Anak, Mertua
            document.getElementById("sectionPasangan").style.display = "block";
            document.getElementById("sectionAnak").style.display = "block";
            document.getElementById("sectionMertua").style.display = "block";
        } else if (st === "Belum Menikah") {
            // Hide: Pasangan, Anak, Mertua
            document.getElementById("sectionPasangan").style.display = "none";
            document.getElementById("sectionAnak").style.display = "none";
            document.getElementById("sectionMertua").style.display = "none";
        } else { // Cerai Hidup or Cerai Mati
            // Show: Anak only, Hide: Pasangan, Mertua
            document.getElementById("sectionPasangan").style.display = "none";
            document.getElementById("sectionAnak").style.display = "block";
            document.getElementById("sectionMertua").style.display = "none";
        }
    }

    // --- DINAMIS PENDIDIKAN ---
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
                    <select class="form-select" name="pendidikan[${counts.p}][jenjang]"><option>SD</option><option>SMP</option><option>SMA</option><option>D1</option><option>D2</option><option>D3</option><option>D4</option><option>S1</option><option>S2</option><option>S3</option></select>
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
                        <input type="text" class="form-control" name="riwayat_jabatan[${counts.j}][nama_jabatan]" placeholder="Masukkan nama jabatan">
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
                <div class="col-md-6"><label class="form-label">NIK</label><div class="input-group"><input type="text" class="form-control nik-lookup" name="anak[${counts.a}][nik]" style="border-radius: 12px 0 0 12px;"><button type="button" class="btn btn-outline-primary btn-nik-search" title="Cari NIK" style="border-radius: 0 12px 12px 0; border: none; background: #e8f0fe;"><i class="bi bi-search"></i></button></div></div>
                <div class="col-md-6"><label class="form-label">Tempat Lahir</label><input type="text" class="form-control" name="anak[${counts.a}][tempat_lahir]"></div>
                <div class="col-md-6"><label class="form-label">Tanggal Lahir</label><input type="date" class="form-control" name="anak[${counts.a}][tanggal_lahir]"></div>
                <div class="col-md-6"><label class="form-label">Status Kawin</label><select class="form-select" name="anak[${counts.a}][status_kawin]"><option value="">Pilih</option><option>Belum Menikah</option><option>Menikah</option><option>Cerai Hidup</option><option>Cerai Mati</option></select></div>
                <div class="col-md-6"><label class="form-label">Status Anak</label><select class="form-select" name="anak[${counts.a}][status_anak]"><option>Kandung</option><option>Tiri</option><option>Angkat</option></select></div>
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
                <div class="col-md-4"><label class="form-label">NIK</label><div class="input-group"><input type="text" class="form-control nik-lookup" name="saudara[${counts.sa}][nik]" placeholder="16 digit NIK" style="border-radius: 10px 0 0 10px;"><button type="button" class="btn btn-outline-primary btn-nik-search" title="Cari NIK" style="border-radius: 0 10px 10px 0; border: none; background: #e8f0fe;"><i class="bi bi-search"></i></button></div></div>
                <div class="col-md-4"><label class="form-label">Nama Saudara *</label><input type="text" class="form-control" name="saudara[${counts.sa}][nama]" placeholder="Nama lengkap"></div>
                <div class="col-md-4"><label class="form-label">Jenis Kelamin</label><select class="form-select" name="saudara[${counts.sa}][jenis_kelamin]"><option value="">Pilih</option><option value="L">Laki-laki</option><option value="P">Perempuan</option></select></div>
                <div class="col-md-4"><label class="form-label">Status Kawin</label><select class="form-select" name="saudara[${counts.sa}][status_kawin]"><option value="">Pilih</option><option>Belum Menikah</option><option>Menikah</option><option>Cerai Hidup</option><option>Cerai Mati</option></select></div>
                <div class="col-md-4"><label class="form-label">Status Saudara</label><select class="form-select" name="saudara[${counts.sa}][status_saudara]"><option value="">Pilih</option><option>Kandung</option><option>Tiri</option><option>Angkat</option></select></div>
                <div class="col-md-4"><label class="form-label">Tanggal Lahir</label><input type="date" class="form-control" name="saudara[${counts.sa}][tanggal_lahir]"></div>
                <div class="col-12"><label class="form-label">Pekerjaan</label><input type="text" class="form-control" name="saudara[${counts.sa}][pekerjaan]" placeholder="Pekerjaan saudara"></div>
            </div>`;
        cont.appendChild(div);
        div.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

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