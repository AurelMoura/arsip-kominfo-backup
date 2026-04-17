<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Arsip Pegawai - Arsip Digital</title>
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
            margin: 0;
        }

        .main-content {
            margin-left: 280px;
            padding: 40px;
            min-height: 100vh;
        }

        .overview-card,
        .table-container,
        .stat-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.03);
            border: 1px solid #eef2f7;
        }

        .overview-card {
            padding: 28px;
        }

        .stat-card {
            padding: 22px;
        }

        .meta-box {
            background: #f8fbff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 14px 16px;
            height: 100%;
        }

        .table-container {
            padding: 24px;
        }

        .table thead th {
            color: #64748b;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 1px;
            font-weight: 700;
            padding: 16px 14px;
            border-bottom: 1px solid #f1f5f9;
        }

        .table tbody td {
            padding: 18px 14px;
            vertical-align: middle;
            border-bottom: 1px solid #f8fafc;
        }

        .badge-nip {
            background: #eff6ff;
            color: #2563eb;
            padding: 6px 12px;
            border-radius: 999px;
            font-weight: 700;
            font-family: 'Courier New', monospace;
        }

        .btn-soft {
            background: #eff6ff;
            color: #2563eb;
            border: 1px solid #bfdbfe;
            border-radius: 10px;
            padding: 8px 14px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
        }

        .btn-soft:hover {
            background: #dbeafe;
            color: #1d4ed8;
        }

        /* Modal Overrides */
        .modal-content { border-radius: 24px; border: none; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); }
        .preview-card { border-radius: 16px; border: 1px solid #f1f5f9; background: #fff; }
        .preview-document-box { 
            border-radius: 16px; 
            background: #f8fafc; 
            border: 2px dashed #cbd5e1;
            transition: all 0.3s;
        }
    </style>
</head>
<body>
@include('components.sidebar')

<div class="main-content">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-4">
        <div>
            <div class="text-uppercase fw-bold text-primary mb-2" style="font-size: 11px; letter-spacing: 1px;">Admin Arsip Pegawai</div>
            <h2 class="fw-bold text-dark mb-1">Kelola Arsip Pegawai</h2>
            <p class="text-muted mb-0">Data arsip ditarik dari relasi pegawai, akun user, dan dokumen yang dimiliki pegawai.</p>
        </div>
        <a href="{{ url('/pegawai') }}" class="btn-soft"><i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Pegawai</a>
    </div>

    <div class="overview-card mb-4">
        <div class="row g-4 align-items-center">
            <div class="col-lg-5">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-4 d-flex align-items-center justify-content-center text-white fw-bold" style="width: 72px; height: 72px; font-size: 30px; background: linear-gradient(135deg, #4361ee, #60a5fa);">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h3 class="fw-bold mb-1">{{ $user->pegawai?->nama_lengkap ?? $user->name }}</h3>
                        <span class="badge-nip">NIP: {{ $user->pegawai_id }}</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="row g-3">
                    <div class="col-md-6 col-xl-3">
                        <div class="meta-box">
                            <small class="text-muted d-block mb-1">Golongan</small>
                            <div class="fw-bold">{{ $user->pegawai?->golongan_pangkat ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="meta-box">
                            <small class="text-muted d-block mb-1">Jenis Jabatan</small>
                            <div class="fw-bold">{{ $user->pegawai?->jenis_jabatan ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="meta-box">
                            <small class="text-muted d-block mb-1">Nama Jabatan</small>
                            <div class="fw-bold">{{ $user->pegawai?->nama_jabatan ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="meta-box">
                            <small class="text-muted d-block mb-1">Eselon</small>
                            <div class="fw-bold">{{ $user->pegawai?->eselon_jabatan ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <small class="text-muted d-block mb-2">Total Dokumen</small>
                <div class="fs-2 fw-bold">{{ $documents->count() }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <small class="text-muted d-block mb-2">Disetujui</small>
                <div class="fs-2 fw-bold text-success">{{ $approvedCount }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <small class="text-muted d-block mb-2">Menunggu / Ditolak</small>
                <div class="fs-2 fw-bold text-warning">{{ $pendingCount + $rejectedCount }}</div>
            </div>
        </div>
    </div>

    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="fw-bold mb-1">Daftar Arsip</h5>
                <p class="text-muted small mb-0">Semua dokumen milik pegawai ini diambil dari relasi akun user dengan arsip dokumen.</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Dokumen</th>
                        <th>Nama File</th>
                        <th>Tanggal Upload</th>
                        <th>Status</th>
                        <th>Aktif</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $index => $doc)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-semibold">{{ $doc->title }}</td>
                        <td>{{ $doc->original_name }}</td>
                        <td>{{ optional($doc->uploaded_at)->format('d M Y H:i') ?? '-' }}</td>
                        <td>
                            @if($doc->status === 'Approved')
                                <span class="badge bg-success-subtle text-success border border-success-subtle">Disetujui</span>
                            @elseif($doc->status === 'Rejected')
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Ditolak</span>
                            @else
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle">Pending</span>
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
                            <button type="button" class="btn-soft" onclick="openReviewModal(this)"
                                data-id="{{ $doc->id }}"
                                data-title="{{ e($doc->title) }}"
                                data-originalname="{{ e($doc->original_name) }}"
                                data-uploaded="{{ optional($doc->uploaded_at)->format('d F Y H:i') ?? '-' }}"
                                data-status="{{ $doc->status }}"
                                data-filesize="{{ $doc->file_size ? number_format($doc->file_size / 1024, 2).' KB' : '-' }}"
                                data-filepath="{{ url('/admin/pegawai/arsip/dokumen/'.$doc->id.'/view') }}"
                                data-downloadpath="{{ url('/admin/pegawai/arsip/dokumen/'.$doc->id.'/download') }}">
                                <i class="bi bi-eye me-1"></i> Review
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-folder-x fs-1 d-block mb-3 opacity-50"></i>
                            Pegawai ini belum memiliki arsip dokumen.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Preview Dokumen -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-0 px-4 pt-4">
                <h5 class="fw-bold mb-0">Preview Dokumen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 pb-4">
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="preview-card p-3 mb-3">
                            <h6 class="fw-bold mb-3 small text-uppercase text-muted">Informasi Pegawai</h6>
                            <div class="mb-2"><small class="text-muted d-block">Nama Lengkap</small><span class="fw-semibold">{{ $user->pegawai?->nama_lengkap ?? $user->name }}</span></div>
                            <div class="mb-0"><small class="text-muted d-block">NIP</small><span class="fw-semibold text-primary">{{ $user->pegawai_id }}</span></div>
                        </div>
                        <div class="preview-card p-3 mb-3">
                            <h6 class="fw-bold mb-3 small text-uppercase text-muted">Detail Berkas</h6>
                            <div class="mb-2"><small class="text-muted d-block">Judul</small><span id="reviewDocTitle" class="fw-semibold">-</span></div>
                            <div class="mb-2"><small class="text-muted d-block">Nama File</small><span id="reviewDocOriginal" class="fw-semibold">-</span></div>
                            <div class="mb-2"><small class="text-muted d-block">Ukuran</small><span id="reviewDocSize" class="fw-semibold">-</span></div>
                            <div class="mb-2"><small class="text-muted d-block">Tanggal Upload</small><span id="reviewDocDate" class="fw-semibold">-</span></div>
                            <div class="mb-0"><small class="text-muted d-block">Status</small><span id="reviewDocStatus" class="badge">-</span></div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="preview-document-box mb-3 overflow-hidden" style="height: 500px;">
                            <iframe id="reviewDocPreview" src="" width="100%" height="100%" style="border:none;"></iframe>
                        </div>
                        <div class="d-flex gap-2 justify-content-end mb-3">
                            <a id="reviewOpenTab" href="#" target="_blank" class="btn btn-outline-primary btn-sm"><i class="bi bi-box-arrow-up-right me-1"></i>Buka di Tab Baru</a>
                            <a id="reviewDownload" href="#" class="btn btn-primary btn-sm"><i class="bi bi-download me-1"></i>Download</a>
                        </div>

                        <div id="reviewActions" class="d-flex gap-3 justify-content-end">
                            <button type="button" class="btn btn-outline-danger px-4" onclick="toggleReviewRejectArea(true)">Tolak Berkas</button>
                            <form id="reviewApproveForm" method="POST" class="m-0">
                                @csrf
                                <button type="button" class="btn btn-success px-4" onclick="submitReviewApprove()">Setujui & Arsipkan</button>
                            </form>
                        </div>

                        <div id="reviewRejectArea" class="mt-4 p-3 bg-light rounded-4" style="display:none;">
                            <label class="form-label fw-bold small">Alasan Penolakan</label>
                            <textarea id="reviewRejectReason" class="form-control border-0 shadow-sm mb-3" rows="3" placeholder="Berikan alasan yang jelas..."></textarea>
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-link text-muted btn-sm" onclick="toggleReviewRejectArea(false)">Batal</button>
                                <button type="button" class="btn btn-danger btn-sm px-3" onclick="submitReviewReject()">Kirim Penolakan</button>
                            </div>
                        </div>
                        <div id="reviewRejectedNote" class="alert alert-danger mt-3 small" style="display:none;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let currentReviewId = null;

    function openReviewModal(button) {
        const id = button.getAttribute('data-id');
        const title = button.getAttribute('data-title');
        const originalname = button.getAttribute('data-originalname');
        const uploaded = button.getAttribute('data-uploaded');
        const status = button.getAttribute('data-status');
        const filesize = button.getAttribute('data-filesize');
        const filepath = button.getAttribute('data-filepath');
        const downloadpath = button.getAttribute('data-downloadpath');

        currentReviewId = id;

        document.getElementById('reviewDocTitle').innerText = title;
        document.getElementById('reviewDocOriginal').innerText = originalname;
        document.getElementById('reviewDocSize').innerText = filesize;
        document.getElementById('reviewDocDate').innerText = uploaded;

        const statusEl = document.getElementById('reviewDocStatus');
        statusEl.innerText = status === 'Approved' ? 'Disetujui' : (status === 'Rejected' ? 'Ditolak' : 'Pending');
        statusEl.className = 'badge ' + (status === 'Approved' ? 'bg-success-subtle text-success border border-success-subtle' : (status === 'Rejected' ? 'bg-danger-subtle text-danger border border-danger-subtle' : 'bg-warning-subtle text-warning border border-warning-subtle'));

        document.getElementById('reviewDocPreview').setAttribute('src', filepath);
        document.getElementById('reviewOpenTab').setAttribute('href', filepath);
        document.getElementById('reviewDownload').setAttribute('href', downloadpath);

        const approveForm = document.getElementById('reviewApproveForm');
        approveForm.setAttribute('action', "{{ url('/admin/validasi-dokumen') }}/" + id + "/approve");

        document.getElementById('reviewRejectReason').value = '';
        document.getElementById('reviewRejectedNote').style.display = 'none';
        toggleReviewRejectArea(false);

        const modal = new bootstrap.Modal(document.getElementById('reviewModal'));
        modal.show();
    }

    function toggleReviewRejectArea(show) {
        const area = document.getElementById('reviewRejectArea');
        area.style.display = show ? 'block' : 'none';
        if (show) {
            setTimeout(function() {
                area.scrollIntoView({ behavior: 'smooth', block: 'center' });
                document.getElementById('reviewRejectReason').focus();
            }, 100);
        }
    }

    function submitReviewApprove() {
        document.getElementById('reviewApproveForm').submit();
    }

    function submitReviewReject() {
        const reason = document.getElementById('reviewRejectReason').value.trim();
        if (reason.length < 10) {
            const note = document.getElementById('reviewRejectedNote');
            note.innerText = 'Alasan penolakan harus minimal 10 karakter.';
            note.style.display = 'block';
            return;
        }

        const rejectForm = document.createElement('form');
        rejectForm.method = 'POST';
        rejectForm.action = "{{ url('/admin/validasi-dokumen') }}/" + currentReviewId + "/reject";

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
