<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Dokumen Admin - Arsip Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root { 
            --sidebar-color: #1e3a5f; 
            --primary-blue: #4361ee; 
            --accent-color: #4cc9f0;
            --bg-body: #f8fafc;
        }

        body { 
            background-color: var(--bg-body); 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            color: #1e293b;
        }

        /* Modern Sidebar */
        .sidebar { 
            width: 280px; 
            height: 100vh; 
            background: var(--sidebar-color); 
            position: fixed; 
            color: white; 
            z-index: 100;
            box-shadow: 10px 0 30px rgba(0,0,0,0.05);
            transition: all 0.3s;
        }

        .nav-link { 
            color: #94a3b8; 
            margin: 8px 15px; 
            border-radius: 12px; 
            transition: 0.3s all cubic-bezier(0.4, 0, 0.2, 1); 
            padding: 12px 15px;
            display: flex;
            align-items: center;
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

        /* Content Area */
        .main-content { margin-left: 280px; padding: 40px; }

        /* Fancy Stat Cards */
        .stat-card { 
            border: none; 
            border-radius: 20px; 
            padding: 24px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: #fff;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.08);
        }

        .stat-card::after {
            content: "";
            position: absolute;
            width: 80px;
            height: 80px;
            background: currentColor;
            opacity: 0.05;
            border-radius: 50%;
            right: -20px;
            bottom: -20px;
        }

        .icon-box { 
            width: 54px; height: 54px; 
            border-radius: 14px; 
            display: flex; align-items: center; justify-content: center; 
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        /* Table Styling */
        .table-container {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.02);
        }

        .table thead th { 
            background-color: transparent; 
            color: #64748b; 
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 1px;
            font-weight: 700;
            padding: 20px 15px;
            border-bottom: 1px solid #f1f5f9;
        }

        .table tbody td { 
            padding: 20px 15px; 
            vertical-align: middle; 
            border-bottom: 1px solid #f8fafc; 
            font-size: 14px;
        }

        .table tbody tr:hover {
            background-color: #fcfdfe;
        }

        /* Modern Badges */
        .badge {
            padding: 8px 14px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 11px;
        }
        .badge-status-pending { background: #fffbeb; color: #d97706; }
        .badge-status-approved { background: #f0fdf4; color: #16a34a; }
        .badge-status-rejected { background: #fef2f2; color: #dc2626; }

        /* Modal Overrides */
        .modal-content { border-radius: 24px; border: none; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); }
        .preview-card { border-radius: 16px; border: 1px solid #f1f5f9; background: #fff; }
        .preview-document-box { 
            border-radius: 16px; 
            background: #f8fafc; 
            border: 2px dashed #cbd5e1;
            transition: all 0.3s;
        }

        .btn-primary { background: var(--primary-blue); border: none; padding: 10px 20px; border-radius: 10px; }
        .btn-primary:hover { background: #3651d1; transform: translateY(-2px); }

        .user-profile-nav {
            background: rgba(255,255,255,0.05);
            border-radius: 15px;
            padding: 12px;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

@include('components.sidebar')

<div class="main-content">
    <div class="d-flex justify-content-between align-items-end mb-5">
        <div>
            <h2 class="fw-bold text-dark mb-1">Validasi Dokumen</h2>
            <p class="text-muted mb-0">Verifikasi berkas masuk dari sistem kepegawaian.</p>
        </div>
        <div class="d-none d-md-flex align-items-center bg-white p-2 rounded-4 shadow-sm border">
            <div class="bg-light p-2 rounded-3 me-3 text-primary"><i class="bi bi-calendar3"></i></div>
            <div class="me-3">
                <small class="text-muted d-block" style="font-size: 10px;">Hari ini</small>
                <span class="fw-bold small">{{ date('d M Y') }}</span>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card stat-card text-primary">
                <div class="icon-box bg-primary bg-opacity-10"><i class="bi bi-files"></i></div>
                <h3 class="fw-bold mb-0 text-dark">{{ $documents->count() }}</h3>
                <small class="text-muted fw-medium">Total Berkas</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card text-warning">
                <div class="icon-box bg-warning bg-opacity-10"><i class="bi bi- hourglass-split"></i></div>
                <h3 class="fw-bold mb-0 text-dark">{{ $pendingCount }}</h3>
                <small class="text-muted fw-medium">Menunggu</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card text-success">
                <div class="icon-box bg-success bg-opacity-10"><i class="bi bi-check2-all"></i></div>
                <h3 class="fw-bold mb-0 text-dark">{{ $approvedCount }}</h3>
                <small class="text-muted fw-medium">Disetujui</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card text-danger">
                <div class="icon-box bg-danger bg-opacity-10"><i class="bi bi-slash-circle"></i></div>
                <h3 class="fw-bold mb-0 text-dark">{{ $rejectedCount }}</h3>
                <small class="text-muted fw-medium">Ditolak</small>
            </div>
        </div>
    </div>

    <div class="table-container">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h5 class="fw-bold mb-0">Daftar Pengajuan</h5>
            <div class="input-group style="width: 250px;">
                <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control bg-light border-0 small" placeholder="Cari dokumen...">
            </div>
        </div>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th width="60" class="text-center">No</th>
                        <th>Informasi Dokumen</th>
                        <th>Pemilik</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aktif</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $index => $doc)
                        <tr>
                            <td class="text-center text-muted">{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $doc->title }}</div>
                                <small class="text-muted">{{ $doc->category ?? 'Umum' }}</small>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $doc->user->name ?? '-' }}</div>
                                <code class="text-primary" style="font-size: 11px;">{{ $doc->user->pegawai_id ?? '-' }}</code>
                            </td>
                            <td>{{ $doc->uploaded_at->format('d/m/Y') }}</td>
                            <td>
                                @if($doc->status === 'Pending')
                                    <span class="badge badge-status-pending">Menunggu</span>
                                @elseif($doc->status === 'Approved')
                                    <span class="badge badge-status-approved">Disetujui</span>
                                @elseif($doc->status === 'Rejected')
                                    <span class="badge badge-status-rejected">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                @if($doc->is_active)
                                    <span class="badge bg-primary text-white">Aktif</span>
                                @else
                                    <span class="badge bg-secondary text-white">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-primary btn-sm px-3 shadow-sm" onclick="openDocModal(this)"
                                    data-id="{{ $doc->id }}" data-title="{{ e($doc->title) }}"
                                    data-employee="{{ e($doc->user->name ?? '-') }}" data-nip="{{ e($doc->user->pegawai_id ?? '-') }}"
                                    data-uploaded="{{ $doc->uploaded_at->format('d F Y') }}" data-status="{{ $doc->status }}"
                                    data-category="{{ e($doc->category ?? '-') }}" data-filesize="{{ $doc->file_size ? number_format($doc->file_size / 1024, 2).' KB' : '-' }}"
                                    data-filepath="{{ url('/admin/pegawai/arsip/dokumen/'.$doc->id.'/view') }}" data-reason="{{ e($doc->rejection_reason) }}">
                                    Review
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <img src="https://illustrations.popsy.co/gray/empty-folder.svg" style="width: 120px;" class="mb-3">
                                <p class="text-muted">Tidak ada dokumen yang perlu divalidasi</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-0 px-4 pt-4">
                <h5 class="fw-bold mb-0">Detail Validasi Dokumen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pb-4">
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="preview-card p-3 mb-3">
                            <h6 class="fw-bold mb-3 small text-uppercase text-muted">Informasi Pegawai</h6>
                            <div class="mb-2"><small class="text-muted d-block">Nama Lengkap</small><span id="previewEmployeeName" class="fw-semibold">-</span></div>
                            <div class="mb-0"><small class="text-muted d-block">NIP</small><span id="previewEmployeeNip" class="fw-semibold text-primary">-</span></div>
                        </div>
                        <div class="preview-card p-3 mb-4">
                            <h6 class="fw-bold mb-3 small text-uppercase text-muted">Detail Berkas</h6>
                            <div class="mb-2"><small class="text-muted d-block">Nama File</small><span id="previewDocumentTitle" class="fw-semibold">-</span></div>
                            <div class="mb-2"><small class="text-muted d-block">Kategori</small><span id="previewDocumentCategory" class="badge bg-light text-dark">-</span></div>
                            <div class="mb-0"><small class="text-muted d-block">Ukuran</small><span id="previewDocumentSize" class="fw-semibold">-</span></div>
                        </div>
                        
                        <div class="alert alert-info border-0 rounded-4 p-3 mb-0">
                            <div class="d-flex gap-2">
                                <i class="bi bi-info-circle-fill"></i>
                                <small>Pastikan dokumen terbaca jelas sebelum menyetujui.</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="preview-document-box mb-4 overflow-hidden" style="height: 500px;">
                            <iframe id="documentPreview" src="" width="100%" height="100%" style="border:none;"></iframe>
                        </div>
                        <div class="text-end mb-3">
                            <a id="previewDirectLink" href="#" target="_blank" class="btn btn-outline-primary btn-sm"><i class="bi bi-box-arrow-up-right me-1"></i>Buka di Tab Baru</a>
                        </div>
                        
                        <div id="previewActions" class="d-flex gap-3 justify-content-end">
                            <button type="button" class="btn btn-outline-danger px-4" onclick="toggleRejectArea(true)">Tolak Berkas</button>
                            <form id="previewApproveForm" method="POST" class="m-0">
                                @csrf
                                <button type="button" class="btn btn-success px-4" onclick="submitApprove()">Setujui & Arsipkan</button>
                            </form>
                        </div>

                        <div id="rejectArea" class="mt-4 p-3 bg-light rounded-4" style="display:none;">
                            <label class="form-label fw-bold small">Alasan Penolakan</label>
                            <textarea id="previewRejectReason" class="form-control border-0 shadow-sm mb-3" rows="3" placeholder="Berikan alasan yang jelas..."></textarea>
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-link text-muted btn-sm" onclick="toggleRejectArea(false)">Batal</button>
                                <button type="button" class="btn btn-danger btn-sm px-3" onclick="submitRejectFromModal()">Kirim Penolakan</button>
                            </div>
                        </div>
                        <div id="previewRejectedNote" class="alert alert-danger mt-3 small" style="display:none;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // FUNGSI JAVASCRIPT TETAP SAMA SEPERTI ASLINYA (TIDAK BERUBAH)
    let currentPreviewId = null;

    function openDocModal(button) {
        const id = button.getAttribute('data-id');
        const title = button.getAttribute('data-title');
        const employee = button.getAttribute('data-employee');
        const nip = button.getAttribute('data-nip');
        const uploaded = button.getAttribute('data-uploaded');
        const status = button.getAttribute('data-status');
        const category = button.getAttribute('data-category');
        const filesize = button.getAttribute('data-filesize');
        const filepath = button.getAttribute('data-filepath');

        currentPreviewId = id;
        document.getElementById('previewDocumentTitle').innerText = title;
        document.getElementById('previewEmployeeName').innerText = employee;
        document.getElementById('previewEmployeeNip').innerText = nip;
        document.getElementById('previewDocumentCategory').innerText = category;
        document.getElementById('previewDocumentSize').innerText = filesize;

        document.getElementById('documentPreview').setAttribute('src', filepath);
        document.getElementById('previewDirectLink').setAttribute('href', filepath);

        const approveForm = document.getElementById('previewApproveForm');
        approveForm.setAttribute('action', "{{ url('/admin/validasi-dokumen') }}/" + id + "/approve");

        document.getElementById('previewRejectReason').value = '';
        document.getElementById('previewRejectedNote').style.display = 'none';
        toggleRejectArea(false);

        const modalEl = document.getElementById('previewModal');
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    }

    function toggleRejectArea(show) {
        const area = document.getElementById('rejectArea');
        area.style.display = show ? 'block' : 'none';
        if (show) {
            setTimeout(function() {
                area.scrollIntoView({ behavior: 'smooth', block: 'center' });
                document.getElementById('previewRejectReason').focus();
            }, 100);
        }
    }

    function submitApprove() {
        document.getElementById('previewApproveForm').submit();
    }

    function submitRejectFromModal() {
        const reason = document.getElementById('previewRejectReason').value.trim();
        if (reason.length < 10) {
            const note = document.getElementById('previewRejectedNote');
            note.innerText = 'Alasan penolakan harus minimal 10 karakter.';
            note.style.display = 'block';
            return;
        }

        const rejectForm = document.createElement('form');
        rejectForm.method = 'POST';
        rejectForm.action = "{{ url('/admin/validasi-dokumen') }}/" + currentPreviewId + "/reject";

        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = '{{ csrf_token() }}';

        const reasonField = document.createElement('input');
        reasonField.type = 'hidden';
        reasonField.name = 'reason';
        reasonField.value = reason;

        rejectForm.appendChild(tokenInput);
        rejectForm.appendChild(reasonField);
        document.body.appendChild(rejectForm);
        rejectForm.submit();
    }
</script>
</body>
</html>