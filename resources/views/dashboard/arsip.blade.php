@extends('layouts.app')

@section('title', 'Arsip Dokumen Pegawai - Arsip Digital')

@push('styles')
    <style>
        :root { 
            --sidebar-color: #1e3a5f; 
            --primary-blue: #3a86ff; 
            --primary-green: #06d6a0; 
            --primary-danger: #ef476f;
            --primary-warning: #ffd166;
            --bg-light: #f4f7fe;
        }

        body { 
            background-color: var(--bg-light); 
            font-family: 'Inter', sans-serif; 
            margin: 0; 
            color: #2d3748;
        }
        
        /* Sidebar Modern */
        .sidebar { 
            width: 260px; 
            height: 100vh; 
            background: var(--sidebar-color); 
            position: fixed; 
            color: white; 
            z-index: 1000; 
            transition: all 0.3s;
        }
        .nav-link { 
            color: #8d94a3; 
            margin: 5px 15px; 
            border-radius: 12px; 
            padding: 12px; 
            text-decoration: none; 
            display: block; 
            transition: 0.3s;
        }
        .nav-link.active { 
            background: var(--primary-blue); 
            color: white !important; 
            box-shadow: 0 4px 15px rgba(58, 134, 255, 0.3);
        }
        .nav-link:hover:not(.active) { 
            background: rgba(255,255,255,0.1); 
            color: white; 
        }
        
        /* Main Content */
        .main-content { margin-left: 260px; padding: 40px; transition: all 0.3s; }
        .page-header-label { 
            color: var(--primary-blue); 
            font-weight: 800; 
            font-size: 11px; 
            letter-spacing: 1.5px; 
            text-transform: uppercase; 
            border-left: 4px solid var(--primary-blue); 
            padding-left: 12px; 
            margin-bottom: 12px; 
        }
        
        /* Stat Cards Luxe */
        .card-stat { 
            border: none; 
            border-radius: 24px; 
            padding: 25px; 
            background: white; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.02); 
            height: 100%; 
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid rgba(226, 232, 240, 0.8);
        }
        .card-stat:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        }
        .card-stat .icon-box { 
            width: 55px; 
            height: 55px; 
            border-radius: 16px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-size: 26px; 
            margin-bottom: 18px; 
        }
        .stat-val { font-size: 32px; font-weight: 800; color: #1a202c; line-height: 1; margin-bottom: 8px; }
        .stat-label { font-size: 15px; font-weight: 700; color: #4a5568; }
        .stat-desc { font-size: 13px; color: #a0aec0; }

        /* Main Table Card Luxe */
        .main-table-card { 
            border: none; 
            border-radius: 28px; 
            background: white; 
            padding: 35px; 
            box-shadow: 0 10px 40px rgba(0,0,0,0.03); 
            border: 1px solid rgba(226, 232, 240, 0.8);
        }
        .table thead th { 
            background-color: #0f63e2; 
            color: #ffffff; 
            border: none; 
            padding: 18px; 
            font-weight: 700; 
            font-size: 13px; 
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .table thead th:first-child { border-radius: 15px 0 0 15px; }
        .table thead th:last-child { border-radius: 0 15px 15px 0; }
        .table tbody td { padding: 20px 18px; vertical-align: middle; border-bottom: 1px solid #f1f5f9; font-size: 14px; color: #4a5568; }
        
        .rejected-table .table thead th { background-color: #fff5f5; color: var(--primary-danger); }
        
        .doc-icon { color: var(--primary-danger); font-size: 22px; margin-right: 15px; }
        .badge-pdf { 
            background-color: #ebf4ff; 
            color: #3182ce; 
            font-weight: 800; 
            border-radius: 8px; 
            padding: 5px 12px; 
            font-size: 11px; 
        }
        
        /* Modal & Upload Area */
        .modal-content { border-radius: 30px; border: none; padding: 15px; }
        .upload-drop-zone { 
            border: 2px dashed #cbd5e1; 
            border-radius: 20px; 
            padding: 40px; 
            text-align: center; 
            background: #f8fbff; 
            cursor: pointer; 
            transition: all 0.3s; 
        }
        .upload-drop-zone:hover { border-color: var(--primary-blue); background: #f0f7ff; }
        
        .btn-upload-trigger { 
            background: linear-gradient(135deg, var(--primary-blue), #2563eb); 
            border: none; 
            border-radius: 14px; 
            padding: 14px 28px; 
            font-weight: 700; 
            color: white; 
            transition: 0.3s; 
            box-shadow: 0 6px 20px rgba(58, 134, 255, 0.3); 
        }
        .btn-upload-trigger:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(58, 134, 255, 0.4); color: white; }

        .info-panel { 
            background: linear-gradient(to right, #eff6ff, #dbeafe); 
            border-radius: 20px; 
            padding: 25px; 
            border-left: 6px solid var(--primary-blue); 
            margin-top: 40px; 
        }

        /* Responsive Mobile */
        @media (max-width: 991px) {
            .sidebar { width: 80px; }
            .sidebar .text-white, .sidebar small, .sidebar .ms-auto, .sidebar .text-truncate, .sidebar span { display: none; }
            .main-content { margin-left: 80px; padding: 20px; }
            .card-stat { padding: 15px; }
        }
    </style>
@endpush

@section('content')

<div class="main-content">
    <div class="d-flex justify-content-between align-items-start mb-5">
        <div>
            <div class="page-header-label">Portal Arsip Dokumen — Kominfo</div>
            <h1 class="fw-bold text-dark" style="font-size: 32px; letter-spacing: -1px;">Arsip Dokumen Pegawai</h1>
            <p class="text-muted">Kelola dan akses dokumen kepegawaian Anda dengan cerdas</p>
        </div>
        <button class="btn btn-upload-trigger" data-bs-toggle="modal" data-bs-target="#modalUpload">
            <i class="bi bi-cloud-arrow-up-fill me-2"></i> Upload Dokumen Baru
        </button>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card-stat">
                <div class="icon-box bg-warning bg-opacity-10 text-warning"><i class="bi bi-clock-history"></i></div>
                <h2 class="stat-val">{{ $pending }}</h2>
                <div class="stat-label">Menunggu Validasi</div>
                <div class="stat-desc">Belum disetujui admin</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-stat">
                <div class="icon-box bg-success bg-opacity-10 text-success"><i class="bi bi-patch-check"></i></div>
                <h2 class="stat-val">{{ $approved }}</h2>
                <div class="stat-label">Dokumen Disetujui</div>
                <div class="stat-desc">Sudah masuk arsip aman</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-stat">
                <div class="icon-box bg-danger bg-opacity-10 text-danger"><i class="bi bi-exclamation-triangle"></i></div>
                <h2 class="stat-val">{{ $rejectedCount }}</h2>
                <div class="stat-label">Dokumen Ditolak</div>
                <div class="stat-desc">Segera periksa & upload ulang</div>
            </div>
        </div>
    </div>

    <div class="main-table-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 text-primary rounded-4 p-3 me-3"><i class="bi bi-folder2-open fs-3"></i></div>
                <div>
                    <h5 class="fw-bold mb-1">Dokumen Tersimpan</h5>
                    <p class="text-muted small mb-0">Total: <strong>{{ $approvedAndPending->count() }}</strong> berkas</p>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="35%">Nama Dokumen</th>
                        <th width="20%">Tanggal Upload</th>
                        <th width="15%">Status</th>
                        <th width="10%">Tipe</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($approvedAndPending as $index => $doc)
                    <tr>
                        <td class="text-center"><span class="fw-bold text-muted">{{ $index + 1 }}</span></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-file-earmark-pdf-fill doc-icon"></i>
                                <span class="fw-bold text-dark">{{ $doc->title }}</span>
                            </div>
                        </td>
                        <td class="text-muted">{{ $doc->uploaded_at->format('d F Y') }}</td>
                        <td>
                            @if($doc->status === 'Pending')
                                <span class="badge rounded-pill bg-warning text-dark px-3 py-2" style="font-size: 11px;">Menunggu</span>
                            @elseif($doc->status === 'Approved')
                                <span class="badge rounded-pill bg-success px-3 py-2" style="font-size: 11px;">Disetujui</span>
                            @endif
                        </td>
                        <td><span class="badge-pdf">PDF</span></td>
                        <td class="text-center">
                            <a href="{{ url('/pegawai/arsip/view/'.$doc->id) }}" target="_blank" class="btn btn-sm btn-outline-primary border-0 fw-bold me-1"><i class="bi bi-eye"></i></a>
                            <a href="{{ url('/pegawai/arsip/download/'.$doc->id) }}" class="btn btn-sm btn-outline-success border-0 fw-bold"><i class="bi bi-download"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-folder-x fs-1 d-block mb-3 opacity-25"></i>
                            Belum ada dokumen yang disimpan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="main-table-card mt-5">
        <div class="d-flex align-items-center mb-4">
            <div class="bg-danger bg-opacity-10 text-danger rounded-4 p-3 me-3"><i class="bi bi-x-circle fs-3"></i></div>
            <div>
                <h5 class="fw-bold mb-1 text-danger">Dokumen Ditolak</h5>
                <p class="text-muted small mb-0">Total: <strong>{{ $rejected->count() }}</strong> berkas bermasalah</p>
            </div>
        </div>

        <div class="table-responsive rejected-table">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th width="25%">Nama Dokumen</th>
                        <th width="20%">Tanggal Upload</th>
                        <th width="30%">Alasan Penolakan</th>
                        <th width="20%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rejected as $index => $doc)
                    <tr>
                        <td class="text-center"><span class="fw-bold text-muted">{{ $index + 1 }}</span></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-file-earmark-pdf-fill doc-icon"></i>
                                <span class="fw-bold text-dark">{{ $doc->title }}</span>
                            </div>
                        </td>
                        <td class="text-muted">{{ $doc->uploaded_at->format('d F Y') }}</td>
                        <td>
                            <div class="p-2 px-3 bg-danger bg-opacity-10 text-danger rounded-3 small fw-bold">
                                {{ $doc->rejection_reason }}
                            </div>
                        </td>
                        <td class="text-center">
                            <a href="{{ url('/pegawai/arsip/view/'.$doc->id) }}" target="_blank" class="btn btn-sm btn-outline-primary border-0 fw-bold me-1"><i class="bi bi-eye"></i></a>
                            <form action="{{ url('/pegawai/arsip/delete/'.$doc->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger border-0 fw-bold"><i class="bi bi-trash"></i> Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-check-circle fs-1 d-block mb-3 text-success opacity-50"></i>
                            Tidak ada dokumen yang ditolak.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="info-panel shadow-sm">
        <div class="d-flex align-items-start">
            <i class="bi bi-info-circle-fill fs-3 text-primary me-4 mt-1"></i>
            <div>
                <h6 class="fw-bold text-dark" style="font-size: 16px;">Informasi Penting:</h6>
                <p class="text-muted small mb-0">Pastikan dokumen yang diunggah adalah hasil <strong>scan berkas asli</strong> dengan kapasitas 1 MB dalam format PDF. Admin akan memverifikasi keaslian dokumen.</p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUpload" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="fw-extrabold text-dark" style="font-size: 22px;">Unggah Dokumen Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ url('/pegawai/arsip/upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="form-label fw-bold text-secondary small text-uppercase">Jenis Dokumen *</label>
                        <select name="title" class="form-select border-2 py-3 px-3 shadow-sm rounded-4" style="border-color: #edf2f7;" required>
                            <option value="" selected disabled>-- Pilih Jenis Dokumen --</option>
                            @foreach($arsips as $arsip)
                                <option value="{{ $arsip->nama }}">{{ $arsip->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-bold text-secondary small text-uppercase">Berkas PDF *</label>
                        <div class="upload-drop-zone">
                            <i class="bi bi-file-earmark-pdf fs-1 text-primary mb-3"></i>
                            <input type="file" name="document" class="form-control shadow-sm" accept=".pdf" required>
                            <small class="text-muted d-block mt-3 fw-medium">Maksimum ukuran file: <strong>2MB</strong></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-primary w-100 fw-bold py-3 rounded-4 shadow-lg">Mulai Proses Unggah Berkas</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection