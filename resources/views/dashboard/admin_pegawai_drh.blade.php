@php $isAdmin = $isAdmin ?? true; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail DRH Pegawai - {{ $user->name }}</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @if(!($isAdmin ?? true))
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    @endif
    
    <style>
        :root { 
            --sidebar-color: #1e3a5f; 
            --primary-blue: #4361ee; 
            --accent-blue: #eff6ff;
            --card-border: rgba(226, 232, 240, 0.6); 
        }

        body { 
            background: #f8fafc; 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            margin: 0; 
            color: #1e293b;
            overflow-x: hidden;
        }

        /* Sidebar Modern Styling */
        .sidebar { 
            width: 280px; 
            height: 100vh; 
            background: var(--sidebar-color); 
            position: fixed; 
            color: white; 
            z-index: 100;
            box-shadow: 10px 0 30px rgba(0,0,0,0.05);
        }

        /* Layout structure for pegawai (matches layouts/app.blade.php) */
        .app-shell {
            display: flex;
            min-height: 100vh;
        }

        .app-sidebar {
            width: 260px;
            min-width: 260px;
            max-width: 260px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: var(--sidebar-color);
            color: #fff;
            z-index: 1000;
            box-shadow: 10px 0 30px rgba(0, 0, 0, 0.05);
            overflow-y: auto;
        }

        .app-content {
            margin-left: 260px;
            width: calc(100% - 260px);
        }

        .app-main {
            padding: 40px;
        }

        .app-main .main-content {
            margin-left: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }

        .gs-nav-link {
            color: #8d94a3;
            margin: 5px 15px;
            border-radius: 12px;
            padding: 12px;
            text-decoration: none;
            display: block;
            font-weight: 500;
        }

        .gs-nav-link:hover,
        .gs-nav-link:focus {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.1);
        }

        .gs-nav-link.active {
            background: linear-gradient(135deg, var(--primary-blue), #2563eb);
            color: #ffffff !important;
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
        }

        .nav-link { 
            color: #94a3b8; 
            margin: 8px 15px; 
            border-radius: 12px; 
            transition: 0.3s all cubic-bezier(0.4, 0, 0.2, 1); 
            padding: 12px 15px;
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .nav-link i { font-size: 1.2rem; }

        .nav-link.active { 
            background: linear-gradient(135deg, var(--primary-blue), #3b82f6); 
            color: white; 
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.3);
        }

        .nav-link:hover:not(.active) { 
            background: rgba(255,255,255,0.05); 
            color: white; 
            transform: translateX(5px);
        }

        .user-profile-nav {
            background: rgba(255,255,255,0.05);
            border-radius: 15px;
            padding: 12px;
            margin: 0 15px 30px 15px;
        }

        /* Layout Main Content */
        .main-content { 
            margin-left: 280px; 
            padding: 40px; 
            min-height: 100vh; 
        }

        /* Modern Glass Card */
        .glass-card {
            background: #ffffff;
            border: 1px solid var(--card-border);
            box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
            border-radius: 24px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .glass-card:hover {
            box-shadow: 0 10px 30px -5px rgba(15, 23, 242, 0.08);
        }

        /* Custom Tab Styling */
        .nav-pills .nav-link {
            background: white;
            color: #64748b;
            border: 1px solid var(--card-border);
            margin-right: 10px;
            border-radius: 12px;
            padding: 10px 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .nav-pills .nav-link.active {
            background: var(--primary-blue);
            color: white;
            border-color: var(--primary-blue);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        /* Header Avatar & Profile */
        .avatar-avatar {
            width: 85px;
            height: 85px;
            border-radius: 22px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 34px;
            font-weight: 800;
            color: white;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border: 4px solid white;
            box-shadow: 0 10px 20px rgba(37,99,235,0.15);
        }

        .detail-header {
            background: white;
            border: 1px solid var(--card-border);
            padding: 2.5rem;
            border-radius: 28px;
            margin-bottom: 2rem;
            position: relative;
        }

        /* Tables and Info Boxes */
        .subtable {
            border-radius: 0;
            overflow: visible;
            border: 1px solid #f1f5f9;
            min-width: max-content;
        }

        .subtable th {
            background: #f8fafc;
            text-transform: uppercase;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            padding: 12px 13px;
            color: #64748b;
            white-space: nowrap;
        }

        .subtable td {
            padding: 11px 13px;
            vertical-align: middle;
            font-size: 0.79rem;
            white-space: nowrap;
        }

        .family-subtable th {
            font-size: 0.64rem;
            padding: 10px 12px;
        }

        .family-subtable td {
            font-size: 0.74rem;
            padding: 9px 12px;
        }

        .glass-card .table-responsive {
            overflow-x: auto;
            overflow-y: hidden;
            scrollbar-width: thin;
            scrollbar-color: rgba(148, 163, 184, 0.9) transparent;
        }

        .glass-card .table-responsive::-webkit-scrollbar {
            height: 10px;
        }

        .glass-card .table-responsive::-webkit-scrollbar-track {
            background: rgba(226, 232, 240, 0.5);
            border-radius: 999px;
        }

        .glass-card .table-responsive::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.95);
            border-radius: 999px;
        }

        .family-empty {
            border: 1px dashed #cbd5e1;
            border-radius: 18px;
            background: linear-gradient(180deg, #ffffff, #f8fafc);
        }

        .info-card-sm {
            border-radius: 18px;
            border: 1px solid #f1f5f9;
            background: #fdfdfd;
            transition: all 0.2s ease;
            padding: 20px;
        }

        .info-card-sm:hover {
            border-color: #3b82f6;
            background: #f0f7ff;
            transform: translateY(-2px);
        }

        .detail-list {
            border-radius: 18px;
            border: 1px solid #f1f5f9;
            overflow: hidden;
            background: #fff;
        }

        .detail-row {
            display: grid;
            grid-template-columns: 260px 1fr;
            gap: 18px;
            padding: 18px 22px;
            border-bottom: 1px solid #eef2f7;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-size: 12px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            display: flex;
            align-items: center;
        }

        .detail-value {
            font-size: 15px;
            font-weight: 700;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Sidebar Summary - Sticky */
        .sticky-summary {
            position: sticky;
            top: 40px;
        }

        .badge-status {
            padding: 6px 14px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
        }

        /* Animation */
        .fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media print {
            .sidebar, .app-sidebar, .no-print, .nav-pills, .sticky-summary { display: none !important; }
            .main-content { margin-left: 0 !important; padding: 0 !important; }
            .app-content { margin-left: 0 !important; width: 100% !important; }
            .app-main { padding: 0 !important; }
            .tab-content > .tab-pane { display: block !important; opacity: 1 !important; }
            .glass-card { border: none; box-shadow: none; }
        }

        /* Mobile Adjustments */
        @media (max-width: 991.98px) {
            .app-content { margin-left: 0 !important; width: 100% !important; }
            .app-main { padding: 16px !important; padding-top: calc(56px + 16px) !important; }
            .main-content { margin-left: 0 !important; }
            .nav-pills { flex-wrap: wrap !important; gap: 6px !important; }
            .nav-pills .nav-link { margin-right: 0 !important; font-size: 0.8rem !important; padding: 8px 12px !important; }
            .detail-row { grid-template-columns: 1fr; gap: 8px; }
        }
        @media (max-width: 575.98px) {
            .app-main { padding: 10px !important; padding-top: calc(56px + 10px) !important; }
        }
    </style>
</head>
<body>
<div data-pegawai-id="{{ $user->pegawai_id }}">
@if($isAdmin)
@include('components.sidebar')
<div class="main-content">
@else
<div class="app-shell">
    @include('components.sidebar')
    <div class="app-content">
        <main class="app-main">
            <div class="main-content">
@endif
    
    <div class="d-flex justify-content-between align-items-center mb-4 no-print fade-in-up">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                @if($isAdmin)
                <li class="breadcrumb-item"><a href="{{ url('/pegawai') }}" class="text-decoration-none">Pegawai</a></li>
                <li class="breadcrumb-item active">Detail DRH</li>
                @else
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active">Daftar Riwayat Hidup</li>
                @endif
            </ol>
        </nav>
        <div class="d-flex gap-2">
            @if($isAdmin)
            <a href="{{ url('/pegawai') }}" class="btn btn-light border px-4 rounded-3 fw-bold">
                <i class="bi bi-arrow-left me-2"></i> Kembali
            </a>
            @if($drhData?->is_drh_locked)
            <button type="button" class="btn btn-warning fw-bold px-4 rounded-3" id="admin-unlock-all-drh-btn"
                data-pegawai-id-drh="{{ $drhData->id }}">
                <i class="bi bi-unlock-fill me-2"></i> Unlock Semua DRH
            </button>
            @else
            <button type="button" class="btn btn-danger fw-bold px-4 rounded-3" id="admin-lock-all-drh-btn"
                data-pegawai-id-drh="{{ $drhData->id }}">
                <i class="bi bi-lock-fill me-2"></i> Lock Semua DRH
            </button>
            @endif
            <a href="{{ url('/admin/pegawai/'.$user->id.'/drh/print') }}" target="_blank" class="btn btn-primary px-4 rounded-3 shadow-sm fw-bold">
                <i class="bi bi-printer me-2"></i> Print Dokumen
            </a>
            @else
            <a href="{{ url('/profile/drh') }}" class="btn btn-light border px-4 rounded-3 fw-bold">
                <i class="bi bi-pencil-square me-2"></i> Edit DRH
            </a>
            <a href="{{ url('/pegawai/riwayat-hidup/print') }}" target="_blank" class="btn btn-primary px-4 rounded-3 shadow-sm fw-bold">
                <i class="bi bi-printer me-2"></i> Print Dokumen
            </a>
            @endif
        </div>
    </div>

    <div class="row g-4 fade-in-up">
        <div class="col-lg-9">
            
            <div class="detail-header shadow-sm border-0">
                <div class="row align-items-center">
                    <div class="col-md-auto text-center text-md-start mb-3 mb-md-0">
                        <div class="avatar-avatar mx-auto">
                            @if($drhData?->foto_profil)
                                <img src="{{ Storage::disk('public')->url($drhData->foto_profil) }}" alt="Foto Profil {{ $user->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            @endif
                        </div>
                    </div>
                    <div class="col-md ms-md-3">
                        <h1 class="fw-800 mb-1 text-dark" style="font-size: 2.2rem;">{{ $user->name }}</h1>
                        <div class="text-muted fw-semibold" style="font-size: 1rem;">NIP: {{ $user->pegawai_id ?? '-' }}</div>
                        <div class="d-flex flex-wrap gap-4 mt-3">
@php
    $pegawai = $drhData;
@endphp
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-briefcase-fill text-primary"></i>
                                <span class="fw-semibold text-dark">{{ $pegawai?->nama_jabatan ?? '-' }}</span>
                            </div>
                            @if($pegawai?->status_pegawai !== 'PPPK')
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-diagram-3-fill text-primary"></i>
                                <span class="fw-semibold text-dark">Eselon {{ $pegawai?->eselon_jabatan ?? '-' }}</span>
                            </div>
                            @endif
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-building text-primary"></i>
                                <span class=\"fw-semibold text-dark\">{{ $pegawai?->unit_kerja?->name ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <ul class="nav nav-pills mb-4 no-print scroll-x flex-nowrap pb-2" id="pills-tab" role="tablist" style="overflow-x: auto;">
                <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-pribadi"><i class="bi bi-person me-2"></i> Data Pribadi</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-keluarga"><i class="bi bi-heart me-2"></i> Keluarga</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-pendidikan"><i class="bi bi-mortarboard me-2"></i> Pendidikan</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-diklat"><i class="bi bi-journal-richtext me-2"></i> Diklat</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-karir"><i class="bi bi-bar-chart-steps me-2"></i> Riwayat Jabatan</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-penghargaan"><i class="bi bi-award me-2"></i> Penghargaan</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-sertifikasi"><i class="bi bi-patch-check me-2"></i> Sertifikasi</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-dokumen"><i class="bi bi-file-earmark-lock me-2"></i> Legalitas</button></li>
           <script>
document.addEventListener('DOMContentLoaded', function () {

    var sectionLockMap = {
        'keluarga':    'Keluarga',
        'pendidikan':  'Pendidikan',
        'diklat':      'Diklat',
        'jabatan':     'Jabatan',
        'penghargaan': 'Penghargaan',
        'sertifikasi': 'Sertifikasi',
        'dokumen':     'Legalitas',
    };

    document.querySelectorAll('.unlock-drh-btn').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            var section = btn.getAttribute('data-section');
            var isLocked = btn.getAttribute('data-locked') === 'true';
            var label = sectionLockMap[section] || section;
            var actionLabel = isLocked ? 'Unlock' : 'Lock';
            var actionText  = isLocked ? 'membuka kunci' : 'mengunci';

            if (!label) return;

            Swal.fire({
                icon: 'question',
                title: actionLabel + ' Data ' + label,
                text: 'Yakin ingin ' + actionText + ' data ' + label + '?',
                showCancelButton: true,
                confirmButtonText: 'Ya, ' + actionLabel,
                cancelButtonText: 'Batal',
                confirmButtonColor: isLocked ? '#2563eb' : '#dc3545',
                cancelButtonColor: '#64748b',
            }).then(function (result) {
                if (!result.isConfirmed) return;

                var endpoint = isLocked ? '/admin/drh/unlock-section' : '/admin/drh/lock-section';
                fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({
                        pegawai_id: document.querySelector('[data-pegawai-id]')?.getAttribute('data-pegawai-id'),
                        section: section,
                    }),
                })
                .then(function (res) { return res.json(); })
                .then(function (data) {
                    if (data.status === 'success') {
                        if (isLocked) {
                            Swal.fire({ icon: 'success', title: 'Berhasil Di-Unlock', text: 'Data ' + label + ' berhasil dibuka.', confirmButtonColor: '#2563eb' });
                            btn.setAttribute('data-locked', 'false');
                            btn.innerHTML = '<i class="bi bi-lock"></i> Lock Data ' + label;
                            btn.classList.remove('btn-success', 'btn-outline-secondary');
                            btn.classList.add('btn-outline-danger');
                        } else {
                            Swal.fire({ icon: 'success', title: 'Berhasil Di-Lock', text: 'Data ' + label + ' berhasil dikunci.', confirmButtonColor: '#2563eb' });
                            btn.setAttribute('data-locked', 'true');
                            btn.innerHTML = '<i class="bi bi-unlock"></i> Unlock Data ' + label;
                            btn.classList.remove('btn-outline-danger', 'btn-success');
                            btn.classList.add('btn-outline-secondary');
                        }
                    } else {
                        Swal.fire('Gagal', data.message || 'Terjadi kesalahan.', 'error');
                    }
                })
                .catch(function () { Swal.fire('Gagal', 'Tidak dapat menghubungi server.', 'error'); });
            });
        });
    });

    // UNLOCK SEMUA DRH (admin)
    var unlockAllBtn = document.getElementById('admin-unlock-all-drh-btn');
    if (unlockAllBtn) {
        unlockAllBtn.addEventListener('click', function () {
            var pegawaiId = unlockAllBtn.getAttribute('data-pegawai-id-drh');
            Swal.fire({
                icon: 'warning',
                title: 'Konfirmasi Unlock Semua DRH',
                text: 'Semua data DRH akan dibuka kuncinya. Pegawai dapat mengedit dan menghapus data kembali.',
                showCancelButton: true,
                confirmButtonText: 'Ya, Unlock Semua',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#f59e0b',
                cancelButtonColor: '#64748b',
            }).then(function (result) {
                if (!result.isConfirmed) return;
                fetch('/admin/drh/unlock-legal', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({ pegawai_id: pegawaiId }),
                })
                .then(function (res) { return res.json(); })
                .then(function (data) {
                    if (data.status === 'success') {
                        Swal.fire({ icon: 'success', title: 'Berhasil Di-Unlock', text: 'Semua data DRH berhasil dibuka kuncinya.', timer: 1500, showConfirmButton: false });
                        setTimeout(function () { location.reload(); }, 1200);
                    } else {
                        Swal.fire('Gagal', data.message || 'Terjadi kesalahan.', 'error');
                    }
                })
                .catch(function () { Swal.fire('Gagal', 'Tidak dapat menghubungi server.', 'error'); });
            });
        });
    }

    // LOCK SEMUA DRH (admin)
    var lockAllBtn = document.getElementById('admin-lock-all-drh-btn');
    if (lockAllBtn) {
        lockAllBtn.addEventListener('click', function () {
            var pegawaiId = lockAllBtn.getAttribute('data-pegawai-id-drh');
            Swal.fire({
                icon: 'warning',
                title: 'Konfirmasi Lock Semua DRH',
                text: 'Semua data DRH akan dikunci. Tombol edit dan hapus di sisi pegawai akan dinonaktifkan.',
                showCancelButton: true,
                confirmButtonText: 'Ya, Lock Semua',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#64748b',
            }).then(function (result) {
                if (!result.isConfirmed) return;
                fetch('/admin/drh/lock-all', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({ pegawai_id: pegawaiId }),
                })
                .then(function (res) { return res.json(); })
                .then(function (data) {
                    if (data.status === 'success') {
                        Swal.fire({ icon: 'success', title: 'Berhasil Di-Lock', text: 'Semua data DRH berhasil dikunci.', timer: 1500, showConfirmButton: false });
                        setTimeout(function () { location.reload(); }, 1200);
                    } else {
                        Swal.fire('Gagal', data.message || 'Terjadi kesalahan.', 'error');
                    }
                })
                .catch(function () { Swal.fire('Gagal', 'Tidak dapat menghubungi server.', 'error'); });
            });
        });
    }

});
</script>
            </ul>

            <div class="tab-content">
                
                <div class="tab-pane fade show active" id="tab-pribadi">
                    <div class="glass-card p-4 p-md-5">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3"><i class="bi bi-person-vcard fs-4 text-primary"></i></div>
                            <h5 class="fw-bold mb-0">Identitas Diri Lengkap</h5>
                        </div>
                        @php
                            $statusKawinMap = [
                                'BM' => 'Belum Menikah',
                                'M' => 'Menikah',
                                'CH' => 'Cerai Hidup',
                                'CM' => 'Cerai Mati',
                            ];

                            $pangkatLabel = $pegawai?->golongan_pangkat
                                ? trim(($pegawai->golongan_pangkat ?? '-') . ' - ' . ($pegawai->nama_pangkat ?? '-'))
                                : '-';

                            $eselonLabel = $pegawai?->eselon_jabatan
                                ? $pegawai->eselon_jabatan . ' (' . $pegawai->jenis_jabatan . ')'
                                : ($pegawai?->jenis_jabatan ?? '-');

                            $infoFields = [
                                ['label' => 'NIK (Nomor Induk Kependudukan)', 'value' => $pegawai?->no_nik ?? '-', 'icon' => 'card-heading'],
                                ['label' => 'Alamat Email Instansi', 'value' => $pegawai?->email ?? '-', 'icon' => 'envelope'],
                                ['label' => 'Nomor WhatsApp', 'value' => $pegawai?->no_hp ?? '-', 'icon' => 'whatsapp'],
                                ['label' => 'Golongan / Ruang', 'value' => $pangkatLabel, 'icon' => 'layers'],
                                ['label' => 'Jenis ASN', 'value' => $pegawai?->status_pegawai ?? '-', 'icon' => 'person-gear'],
                                ['label' => 'Status Kawin', 'value' => $statusKawinMap[$pegawai?->status_kawin ?? ''] ?? '-', 'icon' => 'heart'],
                                ['label' => 'Tempat, Tanggal Lahir', 'value' => ($pegawai?->tempat_lahir ?? '-') . ', ' . (optional($pegawai?->tanggal_lahir)->format('d F Y') ?? '-'), 'icon' => 'calendar-event'],
                                ['label' => 'Agama', 'value' => $pegawai?->nama_agama ?? '-', 'icon' => 'moon-stars'],
                                ['label' => 'Golongan Darah', 'value' => $pegawai?->gol_darah ?? '-', 'icon' => 'droplet'],
                                ['label' => 'Jenis Kelamin', 'value' => $pegawai?->jenis_kelamin === 'L' ? 'Laki-laki' : ($pegawai?->jenis_kelamin === 'P' ? 'Perempuan' : '-'), 'icon' => 'gender-ambiguous'],
                                ['label' => 'Kabupaten Asal', 'value' => $pegawai?->kabupaten_asal ?? '-', 'icon' => 'map'],
                                ['label' => 'Jabatan', 'value' => $pegawai?->nama_jabatan ?? '-', 'icon' => 'briefcase'],
                                ['label' => 'Jenis Jabatan', 'value' => strtoupper($pegawai?->jenis_jabatan ?? '-'), 'icon' => 'tag'],
                                ['label' => 'TMT Jabatan', 'value' => $pegawai?->tmt_jabatan ? $pegawai->tmt_jabatan->format('d F Y') : '-', 'icon' => 'calendar-date'],
                                ['label' => 'Eselon Jabatan', 'value' => $eselonLabel, 'icon' => 'diagram-3'],
                                ['label' => 'Alamat Domisili', 'value' => $pegawai?->alamat ?? 'Alamat belum diinput ke dalam sistem.', 'icon' => 'geo-alt'],
                                ['label' => 'Alamat Sesuai KTP', 'value' => $pegawai?->alamat_ktp ?? 'Alamat sesuai KTP belum diinput ke dalam sistem.', 'icon' => 'geo'],
                            ];

                            if ($pegawai?->status_pegawai === 'PPPK') {
                                $infoFields = array_filter($infoFields, function($f) {
                                    return !in_array($f['label'], ['Jenis Jabatan', 'Eselon Jabatan']);
                                });
                            }
                        @endphp
                        <div class="detail-list">
                            @foreach($infoFields as $f)
                            <div class="detail-row">
                                <div class="detail-label">{{ $f['label'] }}</div>
                                <div class="detail-value">
                                    <i class="bi bi-{{ $f['icon'] }} text-primary opacity-75"></i>
                                    <span>{{ $f['value'] }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-keluarga">
                                        @if($isAdmin)
                                        <div class="d-flex justify-content-end mb-2">
                                            @php $isKelLocked = $drhData?->is_locked_keluarga ?? false; @endphp
                                            <button class="btn btn-sm {{ $isKelLocked ? 'btn-outline-secondary' : 'btn-outline-danger' }} unlock-drh-btn" data-section="keluarga" data-locked="{{ $isKelLocked ? 'true' : 'false' }}" title="{{ $isKelLocked ? 'Unlock' : 'Lock' }} Data Keluarga"><i class="bi bi-{{ $isKelLocked ? 'unlock' : 'lock' }}"></i> {{ $isKelLocked ? 'Unlock' : 'Lock' }} Data Keluarga</button>
                                        </div>
                                        @endif
                    @php
                        $pasangan = $drhData->data_keluarga['pasangan'] ?? [];
                        $pasanganRows = !empty($pasangan['nama']) ? [$pasangan] : [];
                        $anakList = $drhData->data_keluarga['anak'] ?? [];
                        $pasanganFileUrl = !empty($pasangan['file']) ? Storage::disk('public')->url($pasangan['file']) : null;
                    @endphp

                    <div class="glass-card p-4 mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold mb-0 text-danger"><i class="bi bi-heart-fill me-2"></i> Data Pasangan</h5>
                        </div>
                        @if(count($pasanganRows) > 0)
                                <div class="table-responsive">
                                    <table class="table subtable family-subtable">
                                        <thead>
                                            <tr>
                                                <th>Nama Lengkap</th>
                                                <th>NIK</th>
                                                <th>Tempat, Tanggal Lahir</th>
                                                <th>Pekerjaan</th>
                                                <th>No. Akta Nikah</th>
                                                <th>Status</th>
                                                <th class="text-center">File</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pasanganRows as $row)
                                            <tr>
                                                <td class="fw-bold text-dark">{{ $row['nama'] ?? '-' }}</td>
                                                <td>{{ $row['nik'] ?? '-' }}</td>
                                                <td>{{ $row['tempat_lahir'] ?? '-' }}, {{ !empty($row['tanggal_lahir']) ? \Carbon\Carbon::parse($row['tanggal_lahir'])->format('d-m-Y') : '-' }}</td>
                                                <td class="{{ empty($row['pekerjaan']) ? 'text-muted opacity-50' : '' }}">{{ $row['pekerjaan'] ?? '-' }}</td>
                                                <td>{{ $row['no_akta_nikah'] ?? '-' }}</td>
                                                <td>{{ $row['status'] ?? '-' }} • {{ $row['status_hidup'] ?? '-' }}</td>
                                                <td class="text-center">
                                                    @if($pasanganFileUrl)
                                                        <a href="{{ $pasanganFileUrl }}" target="_blank" class="btn btn-sm btn-outline-danger"><i class="bi bi-file-earmark-pdf"></i></a>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                        @else
                            <div class="family-empty text-center py-5">
                                <i class="bi bi-heartbreak fs-1 text-muted opacity-25"></i>
                                <p class="text-muted mt-2 mb-0">Data pasangan belum tercatat.</p>
                            </div>
                        @endif
                    </div>

                    <div class="glass-card p-4 mb-4">
                        <h5 class="fw-bold mb-4 text-info"><i class="bi bi-people-fill me-2"></i> Data Anak</h5>
                        @if(is_array($anakList) && count($anakList) > 0)
                                <div class="table-responsive">
                                    <table class="table subtable family-subtable">
                                        <thead>
                                            <tr>
                                                <th>Nama Anak</th>
                                                <th>NIK</th>
                                                <th>Jenis Kelamin</th>
                                                <th>Tempat, Tanggal Lahir</th>
                                                <th>Pekerjaan</th>
                                                <th>Status Kawin</th>
                                                <th>Status Anak</th>
                                                <th class="text-center">File</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($anakList as $anak)
                                            <tr>
                                                <td class="fw-bold text-dark">{{ $anak['nama'] ?? '-' }}</td>
                                                <td>{{ $anak['nik'] ?? '-' }}</td>
                                                <td>{{ ($anak['jenis_kelamin'] ?? '') === 'L' ? 'Laki-laki' : (($anak['jenis_kelamin'] ?? '') === 'P' ? 'Perempuan' : '-') }}</td>
                                                <td>{{ $anak['tempat_lahir'] ?? '-' }}, {{ !empty($anak['tanggal_lahir']) ? \Carbon\Carbon::parse($anak['tanggal_lahir'])->format('d-m-Y') : '-' }}</td>
                                                <td class="{{ empty($anak['pekerjaan']) ? 'text-muted opacity-50' : '' }}">{{ $anak['pekerjaan'] ?? '-' }}</td>
                                                <td>{{ $anak['status_kawin'] ?? '-' }}</td>
                                                <td>{{ $anak['status_anak'] ?? '-' }}</td>
                                                <td class="text-center">
                                                    @if(!empty($anak['file']))
                                                        <a href="{{ Storage::disk('public')->url($anak['file']) }}" target="_blank" class="btn btn-sm btn-outline-info"><i class="bi bi-file-earmark-pdf"></i></a>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                        @else
                            <div class="family-empty text-center py-4">Data anak tidak ditemukan.</div>
                        @endif
                    </div>

                    @php
                        $orangTua = data_get($drhData, 'data_keluarga.orang_tua', []);
                        $ayah = $orangTua['ayah'] ?? [];
                        $ibu = $orangTua['ibu'] ?? [];
                        $mertua = data_get($drhData, 'data_keluarga.mertua', []);
                        $ayahMertua = $mertua['ayah'] ?? [];
                        $ibuMertua = $mertua['ibu'] ?? [];
                        $saudaraList = data_get($drhData, 'data_keluarga.saudara', []);
                    @endphp

                    @php
                        $orangTuaRows = [];
                        if (!empty($ayah['nama'])) {
                            $orangTuaRows[] = array_merge(['hubungan' => 'Ayah Kandung'], $ayah);
                        }
                        if (!empty($ibu['nama'])) {
                            $orangTuaRows[] = array_merge(['hubungan' => 'Ibu Kandung'], $ibu);
                        }
                    @endphp

                    <div class="glass-card p-4 mt-4 mb-4">
                        <h5 class="fw-bold mb-4 text-primary"><i class="bi bi-person-vcard-fill me-2"></i> Data Orang Tua</h5>
                        @if(count($orangTuaRows) > 0)
                                <div class="table-responsive">
                                    <table class="table subtable family-subtable">
                                        <thead>
                                            <tr>
                                                <th>Hubungan</th>
                                                <th>Nama</th>
                                                <th>NIK</th>
                                                <th>Tanggal Lahir</th>
                                                <th>Status Hidup</th>
                                                <th>Pekerjaan</th>
                                                <th>Alamat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orangTuaRows as $row)
                                            <tr>
                                                <td class="fw-semibold">{{ $row['hubungan'] ?? '-' }}</td>
                                                <td class="fw-bold text-dark">{{ $row['nama'] ?? '-' }}</td>
                                                <td>{{ $row['nik'] ?? '-' }}</td>
                                                <td>{{ !empty($row['tanggal_lahir']) ? \Carbon\Carbon::parse($row['tanggal_lahir'])->format('d-m-Y') : '-' }}</td>
                                                <td>{{ $row['status_hidup'] ?? '-' }}</td>
                                                <td class="{{ empty($row['pekerjaan']) ? 'text-muted opacity-50' : '' }}">{{ $row['pekerjaan'] ?? '-' }}</td>
                                                <td>{{ $row['alamat'] ?? '-' }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                        @else
                            <div class="family-empty text-center py-4">Data orang tua tidak ditemukan.</div>
                        @endif
                    </div>

                    @php
                        $mertuaRows = [];
                        if (!empty($ayahMertua['nama'])) {
                            $mertuaRows[] = array_merge(['hubungan' => 'Ayah Mertua'], $ayahMertua);
                        }
                        if (!empty($ibuMertua['nama'])) {
                            $mertuaRows[] = array_merge(['hubungan' => 'Ibu Mertua'], $ibuMertua);
                        }
                    @endphp

                    @if(count($mertuaRows) > 0)
                    <div class="glass-card p-4 mb-4">
                        <h5 class="fw-bold mb-4 text-warning"><i class="bi bi-house-heart-fill me-2"></i> Data Mertua</h5>
                            <div class="table-responsive">
                                <table class="table subtable family-subtable">
                                    <thead>
                                        <tr>
                                            <th>Hubungan</th>
                                            <th>Nama</th>
                                            <th>NIK</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Status Hidup</th>
                                            <th>Pekerjaan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($mertuaRows as $row)
                                        <tr>
                                            <td class="fw-semibold">{{ $row['hubungan'] ?? '-' }}</td>
                                            <td class="fw-bold text-dark">{{ $row['nama'] ?? '-' }}</td>
                                            <td>{{ $row['nik'] ?? '-' }}</td>
                                            <td>{{ !empty($row['tanggal_lahir']) ? \Carbon\Carbon::parse($row['tanggal_lahir'])->format('d-m-Y') : '-' }}</td>
                                            <td>{{ $row['status_hidup'] ?? '-' }}</td>
                                            <td class="{{ empty($row['pekerjaan']) ? 'text-muted opacity-50' : '' }}">{{ $row['pekerjaan'] ?? '-' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                    </div>
                    @endif

                    <div class="glass-card p-4 mt-4">
                        <h5 class="fw-bold mb-4 text-secondary"><i class="bi bi-people me-2"></i> Data Saudara</h5>
                        @if(is_array($saudaraList) && count($saudaraList) > 0)
                            <div class="table-responsive">
                                <table class="table subtable family-subtable">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>NIK</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Tempat Lahir</th>
                                            <th>Status Kawin</th>
                                            <th>Status Saudara</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Pekerjaan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($saudaraList as $saudara)
                                        <tr>
                                            <td class="fw-bold text-dark">{{ $saudara['nama'] ?? '-' }}</td>
                                            <td>{{ $saudara['nik'] ?? '-' }}</td>
                                            <td>{{ $saudara['jenis_kelamin'] === 'L' ? 'Laki-laki' : ($saudara['jenis_kelamin'] === 'P' ? 'Perempuan' : '-') }}</td>
                                            <td>{{ $saudara['tempat_lahir'] ?? '-' }}</td>
                                            <td>{{ $saudara['status_kawin'] ?? '-' }}</td>
                                            <td>{{ $saudara['status_saudara'] ?? '-' }}</td>
                                            <td>{{ !empty($saudara['tanggal_lahir']) ? \Carbon\Carbon::parse($saudara['tanggal_lahir'])->format('d-m-Y') : '-' }}</td>
                                            <td class="{{ empty($saudara['pekerjaan']) ? 'text-muted opacity-50' : '' }}">{{ $saudara['pekerjaan'] ?? '-' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="family-empty text-center py-4">Data saudara tidak ditemukan.</div>
                        @endif
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-pendidikan">
                                        @if($isAdmin)
                                        <div class="d-flex justify-content-end mb-2">
                                            @php $isPendLocked = $drhData?->is_locked_pendidikan ?? false; @endphp
                                            <button class="btn btn-sm {{ $isPendLocked ? 'btn-outline-secondary' : 'btn-outline-danger' }} unlock-drh-btn" data-section="pendidikan" data-locked="{{ $isPendLocked ? 'true' : 'false' }}" title="{{ $isPendLocked ? 'Unlock' : 'Lock' }} Data Pendidikan"><i class="bi bi-{{ $isPendLocked ? 'unlock' : 'lock' }}"></i> {{ $isPendLocked ? 'Unlock' : 'Lock' }} Data Pendidikan</button>
                                        </div>
                                        @endif
                    <div class="glass-card p-4 mb-4">
                        <h5 class="fw-bold mb-4 text-primary"><i class="bi bi-mortarboard-fill me-2"></i> Riwayat Pendidikan Formal</h5>
                        @php $pendidikanList = $drhData->riwayat_pendidikan ?? []; @endphp
                        <div class="table-responsive">
                            <table class="table subtable">
                                <thead>
                                    <tr>
                                        <th>Jenjang</th>
                                        <th>Nama Institusi</th>
                                        <th>Tahun Masuk</th>
                                        <th>Tahun Lulus</th>
                                        <th>Nomor Ijazah</th>
                                        <th class="text-center">File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pendidikanList as $pend)
                                    <tr>
                                        <td><span class="badge bg-primary bg-opacity-10 text-primary px-3">{{ $pend['jenjang'] }}</span></td>
                                        <td class="fw-bold">{{ $pend['nama_sekolah'] }}</td>
                                        <td>{{ $pend['tahun_masuk'] ?? '-' }}</td>
                                        <td>{{ $pend['tahun_lulus'] }}</td>
                                        <td class="small">{{ $pend['nomor_ijazah'] ?? '-' }}</td>
                                        <td class="text-center">
                                            @if(!empty($pend['file']))
                                                <a href="{{ asset('storage/'.$pend['file']) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="bi bi-file-earmark-pdf"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">Data riwayat pendidikan belum tersedia.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-diklat">
                                        @if($isAdmin)
                                        <div class="d-flex justify-content-end mb-2">
                                            @php $isDiklatLocked = $drhData?->is_locked_diklat ?? false; @endphp
                                            <button class="btn btn-sm {{ $isDiklatLocked ? 'btn-outline-secondary' : 'btn-outline-danger' }} unlock-drh-btn" data-section="diklat" data-locked="{{ $isDiklatLocked ? 'true' : 'false' }}" title="{{ $isDiklatLocked ? 'Unlock' : 'Lock' }} Data Diklat"><i class="bi bi-{{ $isDiklatLocked ? 'unlock' : 'lock' }}"></i> {{ $isDiklatLocked ? 'Unlock' : 'Lock' }} Data Diklat</button>
                                        </div>
                                        @endif
                    <div class="glass-card p-4">
                        <h5 class="fw-bold mb-4 text-info"><i class="bi bi-journal-richtext me-2"></i> Riwayat Diklat</h5>
                        @php $diklatList = $drhData->riwayat_diklat ?? []; @endphp
                        <div class="table-responsive">
                            <table class="table subtable">
                                <thead>
                                    <tr>
                                        <th>Nama Diklat</th>
                                        <th>Penyelenggara</th>
                                        <th>No. Sertifikat</th>
                                        <th>Tahun</th>
                                        <th class="text-center">File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($diklatList as $diklat)
                                    <tr>
                                        <td class="fw-bold text-dark">{{ $diklat['nama'] ?? '-' }}</td>
                                        <td>{{ $diklat['penyelenggara'] ?? '-' }}</td>
                                        <td>{{ $diklat['nomor_sertifikat'] ?? '-' }}</td>
                                        <td>{{ $diklat['tahun'] ?? '-' }}</td>
                                        <td class="text-center">
                                            @if(!empty($diklat['file']))
                                                <a href="{{ asset('storage/'.$diklat['file']) }}" target="_blank" class="btn btn-sm btn-outline-info"><i class="bi bi-file-earmark-pdf"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">Data riwayat diklat belum tersedia.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-karir">
                                        @if($isAdmin)
                                        <div class="d-flex justify-content-end mb-2">
                                            @php $isJabLocked = $drhData?->is_locked_jabatan ?? false; @endphp
                                            <button class="btn btn-sm {{ $isJabLocked ? 'btn-outline-secondary' : 'btn-outline-danger' }} unlock-drh-btn" data-section="jabatan" data-locked="{{ $isJabLocked ? 'true' : 'false' }}" title="{{ $isJabLocked ? 'Unlock' : 'Lock' }} Data Jabatan"><i class="bi bi-{{ $isJabLocked ? 'unlock' : 'lock' }}"></i> {{ $isJabLocked ? 'Unlock' : 'Lock' }} Data Jabatan</button>
                                        </div>
                                        @endif
                    <div class="glass-card p-4">
                        <h5 class="fw-bold mb-4 text-warning"><i class="bi bi-briefcase-fill me-2"></i> Riwayat Jabatan & Kepangkatan</h5>
                        @php $jabatanList = $drhData->riwayat_jabatan ?? []; @endphp
                        <div class="table-responsive">
                            <table class="table subtable">
                                <thead>
                                    <tr>
                                        <th>Jenis Jabatan</th>
                                        <th>Nama Jabatan</th>
                                        <th>Eselon</th>
                                        <th>TMT</th>
                                        <th>No. SK</th>
                                        <th>File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($jabatanList as $jab)
                                    <tr>
                                        <td>{{ $jab['jenis_jabatan'] ?? '-' }}</td>
                                        <td class="fw-bold text-dark">{{ $jab['nama_jabatan'] ?? $jab['jabatan'] ?? '-' }}</td>
                                        <td>{{ $jab['eselon'] ?? '-' }}</td>
                                        <td>{{ $jab['tmt'] }}</td>
                                        <td>{{ $jab['no_sk'] ?? '-' }}</td>
                                        <td>
                                            @if(!empty($jab['file']))
                                                <a href="{{ asset('storage/'.$jab['file']) }}" target="_blank" class="btn btn-sm btn-light">SK</a>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">Data riwayat jabatan belum tersedia.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-penghargaan">
                                        @if($isAdmin)
                                        <div class="d-flex justify-content-end mb-2">
                                            @php $isAwrdLocked = $drhData?->is_locked_penghargaan ?? false; @endphp
                                            <button class="btn btn-sm {{ $isAwrdLocked ? 'btn-outline-secondary' : 'btn-outline-danger' }} unlock-drh-btn" data-section="penghargaan" data-locked="{{ $isAwrdLocked ? 'true' : 'false' }}" title="{{ $isAwrdLocked ? 'Unlock' : 'Lock' }} Data Penghargaan"><i class="bi bi-{{ $isAwrdLocked ? 'unlock' : 'lock' }}"></i> {{ $isAwrdLocked ? 'Unlock' : 'Lock' }} Data Penghargaan</button>
                                        </div>
                                        @endif
                    <div class="glass-card p-4">
                        <h5 class="fw-bold mb-4 text-danger"><i class="bi bi-award-fill me-2"></i> Riwayat Penghargaan</h5>
                        @php $penghargaanList = $drhData->riwayat_penghargaan ?? []; @endphp
                        <div class="table-responsive">
                            <table class="table subtable">
                                <thead>
                                    <tr>
                                        <th>Nama Penghargaan</th>
                                        <th>Instansi Pemberi</th>
                                        <th>Tahun</th>
                                        <th class="text-center">File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($penghargaanList as $penghargaan)
                                    <tr>
                                        <td class="fw-bold text-dark">{{ $penghargaan['nama'] ?? '-' }}</td>
                                        <td>{{ $penghargaan['instansi'] ?? '-' }}</td>
                                        <td>{{ $penghargaan['tahun'] ?? '-' }}</td>
                                        <td class="text-center">
                                            @if(!empty($penghargaan['file']))
                                                <a href="{{ asset('storage/'.$penghargaan['file']) }}" target="_blank" class="btn btn-sm btn-outline-danger"><i class="bi bi-file-earmark-pdf"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">Data penghargaan belum tersedia.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-sertifikasi">
                                        @if($isAdmin)
                                        <div class="d-flex justify-content-end mb-2">
                                            @php $isSrtfLocked = $drhData?->is_locked_sertifikasi ?? false; @endphp
                                            <button class="btn btn-sm {{ $isSrtfLocked ? 'btn-outline-secondary' : 'btn-outline-danger' }} unlock-drh-btn" data-section="sertifikasi" data-locked="{{ $isSrtfLocked ? 'true' : 'false' }}" title="{{ $isSrtfLocked ? 'Unlock' : 'Lock' }} Data Sertifikasi"><i class="bi bi-{{ $isSrtfLocked ? 'unlock' : 'lock' }}"></i> {{ $isSrtfLocked ? 'Unlock' : 'Lock' }} Data Sertifikasi</button>
                                        </div>
                                        @endif
                    <div class="glass-card p-4">
                        <h5 class="fw-bold mb-4 text-success"><i class="bi bi-patch-check-fill me-2"></i> Riwayat Sertifikasi</h5>
                        @php $sertifikasiList = $drhData->riwayat_sertifikasi ?? []; @endphp
                        <div class="table-responsive">
                            <table class="table subtable">
                                <thead>
                                    <tr>
                                        <th>Nama Sertifikasi</th>
                                        <th>Lembaga Pelaksana</th>
                                        <th>Tahun</th>
                                        <th class="text-center">File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sertifikasiList as $sertifikasi)
                                    <tr>
                                        <td class="fw-bold text-dark">{{ $sertifikasi['nama'] ?? '-' }}</td>
                                        <td>{{ $sertifikasi['lembaga'] ?? '-' }}</td>
                                        <td>{{ $sertifikasi['tahun'] ?? '-' }}</td>
                                        <td class="text-center">
                                            @if(!empty($sertifikasi['file']))
                                                <a href="{{ asset('storage/'.$sertifikasi['file']) }}" target="_blank" class="btn btn-sm btn-outline-success"><i class="bi bi-file-earmark-pdf"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">Data sertifikasi belum tersedia.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-dokumen">
                                        @if($isAdmin)
                                        <div class="d-flex justify-content-end mb-2">
                                            @php $isLegalLocked = $drhData?->identitasLegal?->is_locked_legal ?? false; @endphp
                                            <button class="btn btn-sm {{ $isLegalLocked ? 'btn-outline-secondary' : 'btn-outline-danger' }} unlock-drh-btn" data-section="dokumen" data-locked="{{ $isLegalLocked ? 'true' : 'false' }}" title="Unlock Data Legalitas"><i class="bi bi-unlock"></i> Unlock Data Legalitas</button>
                                        </div>
                                        @endif
                    <div class="glass-card p-4">
                        <h5 class="fw-bold mb-4 text-success"><i class="bi bi-shield-lock-fill me-2"></i> Vault Dokumen Legalitas</h5>
                        @php
                            $vault = [
                                ['label' => 'Kartu Tanda Penduduk (KTP)', 'path' => data_get($drhData, 'identitas_legal.file_ktp'), 'type' => 'ktp', 'icon' => 'card-text'],
                                ['label' => 'NPWP (Pajak)', 'path' => data_get($drhData, 'identitas_legal.file_npwp'), 'type' => 'npwp', 'icon' => 'bank'],
                                ['label' => 'BPJS Kesehatan/Ketenagakerjaan', 'path' => data_get($drhData, 'identitas_legal.file_bpjs'), 'type' => 'bpjs', 'icon' => 'heart-pulse'],
                                ['label' => 'Kartu Keluarga (KK)', 'path' => data_get($drhData, 'identitas_legal.file_kk'), 'type' => 'kk', 'icon' => 'people'],
                            ];

                            $adminAnakList = data_get($drhData, 'data_keluarga.anak', []);
                            $adminJabatanList = $drhData->riwayat_jabatan ?? [];
                        @endphp
                        <div class="row g-4">
                            @foreach($vault as $doc)
                            <div class="col-md-6">
                                <div class="p-4 border rounded-4 d-flex align-items-center justify-content-between hover-shadow transition">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light p-3 rounded-4 me-3 text-success shadow-sm"><i class="bi bi-{{ $doc['icon'] }} fs-4"></i></div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $doc['label'] }}</div>
                                            @if($doc['type'] === 'ktp')
                                                <div class="small text-muted">Nomor: <span class="fw-semibold text-dark">{{ $drhData?->identitas_legal['nik_ktp'] ?? '-' }}</span></div>
                                            @elseif($doc['type'] === 'npwp')
                                                <div class="small text-muted">Nomor: <span class="fw-semibold text-dark">{{ $drhData?->identitas_legal['nomor_npwp'] ?? '-' }}</span></div>
                                            @elseif($doc['type'] === 'bpjs')
                                                <div class="small text-muted">Nomor: <span class="fw-semibold text-dark">{{ $drhData?->identitas_legal['nomor_bpjs'] ?? '-' }}</span></div>
                                            @elseif($doc['type'] === 'kk')
                                                <div class="small text-muted">Nomor: <span class="fw-semibold text-dark">{{ $drhData?->identitas_legal['nomor_kk'] ?? '-' }}</span></div>
                                            @endif
                                            <span class="small {{ $doc['path'] ? 'text-success' : 'text-danger' }} d-flex align-items-center">
                                                <i class="bi bi-{{ $doc['path'] ? 'check-circle-fill' : 'exclamation-circle' }} me-1"></i>
                                                {{ $doc['path'] ? 'Tersedia di Server' : 'Belum Diunggah' }}
                                            </span>
                                        </div>
                                    </div>
                                    @if($doc['path'])
                                    <div class="dropdown">
                                        <button class="btn btn-white border-0 p-2" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2 rounded-3">
                                            @php
                                                // Tambahkan cache-busting agar file terbaru selalu diambil
                                                $fileViewUrl = $isAdmin
                                                    ? url('/admin/drh/legal/'.$user->id.'/'.$doc['type'].'/view')
                                                    : url('/profile/drh/file/'.$doc['type'].'/view');
                                                if ($doc['path']) {
                                                    $fullPath = public_path('storage/' . $doc['path']);
                                                    $fileViewUrl .= '?t=' . (is_file($fullPath) ? filemtime($fullPath) : time());
                                                }
                                            @endphp
                                            <li><a class="dropdown-item rounded-2" href="{{ $fileViewUrl }}" target="_blank"><i class="bi bi-eye me-2"></i> Lihat</a></li>
                                            <li><a class="dropdown-item rounded-2" href="{{ $isAdmin ? url('/admin/drh/legal/'.$user->id.'/'.$doc['type'].'/download') : url('/profile/drh/file/'.$doc['type'].'/download') }}"><i class="bi bi-download me-2"></i> Unduh</a></li>
                                        </ul>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-lg-3 no-print">
            <div class="sticky-summary">
                
                @if($isAdmin)
                <div class="glass-card p-4 mb-4 text-center border-0 shadow-lg" style="background: linear-gradient(135deg, #1e3a8a, #3b82f6) !important;">
                    <i class="bi bi-folder2-open text-white fs-3 mb-3 d-inline-block"></i>
                    <h6 class="fw-bold text-white">Arsip Dokumen</h6>
                    <p class="small text-white opacity-75 mb-4">Lihat dan kelola seluruh dokumen arsip digital milik pegawai ini.</p>
                    <a href="{{ url('/admin/pegawai/'.$user->id.'/arsip') }}" class="btn btn-light w-100 py-2 rounded-3 fw-bold small">
                        <i class="bi bi-folder2-open me-1"></i> Kelola Arsip Dokumen
                    </a>
                </div>
                @endif

                <div class="glass-card p-4 mb-4 text-center border-0 shadow-sm">
                    <div class="bg-info bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                        <i class="bi bi-key text-info fs-3"></i>
                    </div>
                    <h6 class="fw-bold">Ganti Password</h6>
                    <p class="small text-muted mb-2">Jumlah pegawai ini mengganti password:</p>
                    <span class="badge bg-primary fs-6 px-3 py-2">{{ $user->password_change_count ?? 0 }} kali</span>
                </div>

                <div class="glass-card p-4 mb-4 text-center border-0 shadow-sm">
                    <div class="bg-warning bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                        <i class="bi bi-shield-lock text-warning fs-3"></i>
                    </div>
                    <h6 class="fw-bold">Keamanan Data</h6>
                    <p class="small text-muted mb-4">Seluruh dokumen ini bersifat rahasia dan hanya dapat diakses oleh Admin & Pegawai bersangkutan.</p>
                    <button class="btn btn-light w-100 py-2 rounded-3 fw-bold small"><i class="bi bi-info-circle me-1"></i> Log Akses Terakhir</button>
                </div>

                <div class="mt-4 px-2">
                    <p class="text-muted" style="font-size: 10px;">&copy; 2026 Kominfo Kota Bengkulu. <br>Dikembangkan oleh Aurel (Mahasiswa Informatika).</p>
                </div>
            </div>
        </div>
    </div>
</div>

@if($isAdmin)
</div>{{-- .main-content (admin) --}}
@else
            </div>{{-- .main-content (pegawai) --}}
        </main>
    </div>
</div>{{-- .app-shell --}}
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var triggerTabList = [].slice.call(document.querySelectorAll('#pills-tab button'));
        triggerTabList.forEach(function (triggerEl) {
            var tabTrigger = new bootstrap.Tab(triggerEl);
            triggerEl.addEventListener('click', function (event) {
                event.preventDefault();
                tabTrigger.show();
            });
        });
    });
</script>
</body>
</html>