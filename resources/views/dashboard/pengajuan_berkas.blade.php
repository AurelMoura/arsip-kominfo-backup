@extends('layouts.app')

@section('title', 'Pengajuan Berkas - Arsip Digital')

@push('styles')
    <style>
        :root { 
            --sidebar-color: #1e3a5f; 
            --primary-blue: #3a86ff; 
            --primary-green: #06d6a0; 
            --bg-light: #f4f7fe;
        }

        body { 
            background-color: var(--bg-light); 
            font-family: 'Inter', sans-serif; 
            margin: 0; 
            color: #2d3748;
        }
        
        /* Main Content */
        .main-content { 
            padding: 40px; 
            transition: all 0.3s;
        }
        .page-header-label { 
            color: var(--primary-blue); 
            font-weight: 800; 
            font-size: 11px; 
            letter-spacing: 1.5px; 
            text-transform: uppercase; 
            margin-bottom: 8px; 
            display: block;
        }
        
        /* Content Card */
        .content-card { 
            background: white; 
            border-radius: 24px; 
            padding: 40px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.02); 
            border: 1px solid rgba(226, 232, 240, 0.8);
        }
        
        .section-title { font-size: 32px; font-weight: 800; color: #1a202c; letter-spacing: -0.5px; }
        .section-subtitle { font-size: 15px; color: #718096; margin-bottom: 30px; }
        
        /* Info Box */
        .info-box { 
            background: #f0fff4; 
            border-left: 6px solid var(--primary-green); 
            padding: 24px; 
            border-radius: 16px; 
            margin-bottom: 35px;
        }
        .info-box-title { font-weight: 700; color: #22543d; font-size: 16px; margin-bottom: 5px; }
        
        /* Link Input Group */
        .link-input-group { margin-bottom: 30px; }
        .link-label { display: block; font-weight: 700; color: #4a5568; margin-bottom: 10px; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; }
        .link-input { 
            padding: 14px 20px; 
            border: 2px solid #edf2f7; 
            border-radius: 14px; 
            font-size: 15px; 
            background: #f8fafc; 
            color: #4a5568;
            font-weight: 500;
            width: 100%;
        }
        
        /* Action Button */
        .btn-link-external { 
            background: var(--primary-green); 
            color: white; 
            border: none; 
            padding: 18px 30px; 
            border-radius: 16px; 
            font-weight: 700; 
            width: 100%; 
            font-size: 16px; 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            gap: 12px;
            box-shadow: 0 6px 20px rgba(6, 214, 160, 0.25);
        }
        .btn-link-external:hover { 
            background: #05b98a; 
            transform: translateY(-3px); 
            box-shadow: 0 10px 25px rgba(6, 214, 160, 0.35);
            color: white;
        }
        
        /* Instruction Section */
        .instruction-section { 
            margin-top: 50px; 
            padding-top: 30px; 
            border-top: 2px dashed #edf2f7; 
        }
        .instruction-title { font-size: 20px; font-weight: 800; color: #1a202c; margin-bottom: 25px; display: flex; align-items: center; gap: 10px; }
        .instruction-item { display: flex; gap: 20px; margin-bottom: 24px; align-items: flex-start; }
        .instruction-number { 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            width: 36px; 
            height: 36px; 
            background: linear-gradient(135deg, #3a86ff, #2563eb); 
            color: white; 
            border-radius: 12px; 
            font-weight: 700; 
            flex-shrink: 0; 
            box-shadow: 0 4px 10px rgba(58, 134, 255, 0.3);
        }
        .instruction-text { font-size: 15px; color: #4a5568; line-height: 1.6; }
        
        /* Important Note */
        .important-note { 
            background: linear-gradient(to right, #eff6ff, #dbeafe); 
            border: 1px solid #bfdbfe; 
            border-radius: 18px; 
            padding: 25px; 
            margin-top: 40px; 
        }
        .important-note-title { font-weight: 800; color: #1e40af; margin-bottom: 8px; font-size: 15px; }
        .important-note-text { font-size: 14px; color: #1e3a8a; opacity: 0.9; }

        /* Responsive Mobile */
        @media (max-width: 991px) {
            .sidebar { width: 80px; }
            .sidebar .text-white, .sidebar small, .sidebar .ms-auto, .sidebar .nav-link span { display: none; }
            .sidebar .nav-link { text-align: center; margin: 5px 10px; }
            .sidebar .nav-link i { margin: 0 !important; font-size: 20px; }
            .main-content { margin-left: 80px; padding: 20px; }
            .content-card { padding: 25px; }
        }
    </style>
@endpush

@section('content')

<div class="main-content">
    <div class="mb-5">
        <div class="page-header-label">Portal Pengajuan Berkas — Kominfo</div>
        <h1 class="section-title">Pengajuan Berkas</h1>
        <p class="section-subtitle">Layanan pengajuan administrasi kepegawaian secara terpadu.</p>
    </div>
    
    <div class="content-card">
        <div class="info-box">
            <div class="d-flex align-items-center">
                <div class="bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; font-size: 20px;">
                    🚀
                </div>
                <div>
                    <div class="info-box-title">Sistem Upload Dokumen Resmi</div>
                    <p class="mb-0 text-success small fw-medium">Upload dokumen melalui portal resmi Pemerintah Provinsi</p>
                </div>
            </div>
        </div>
        
        <div class="link-input-group">
            <label class="link-label">Tautan Portal Upload</label>
            <div class="position-relative">
                <input type="text" class="link-input" value="https://bkpsdmpangkat2023.carrd.co/" readonly>
                <i class="bi bi-link-45deg position-absolute end-0 top-50 translate-middle-y me-3 text-muted fs-5"></i>
            </div>
        </div>
        
        <button class="btn-link-external" onclick="window.open('https://bkpsdmpangkat2023.carrd.co/', '_blank')">
            <i class="bi bi-box-arrow-up-right fs-5"></i> Akses Portal Eksternal
        </button>
        
        <div class="instruction-section">
            <h3 class="instruction-title">
                <i class="bi bi-info-square-fill text-primary"></i> Panduan Pengajuan
            </h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="instruction-item">
                        <span class="instruction-number">01</span>
                        <span class="instruction-text">Klik tombol <strong>Akses Portal Eksternal</strong> untuk membuka sistem upload BKPSDM.</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="instruction-item">
                        <span class="instruction-number">02</span>
                        <span class="instruction-text">Gunakan <strong>NIP & Password</strong> resmi yang diberikan oleh pihak Provinsi.</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="instruction-item">
                        <span class="instruction-number">03</span>
                        <span class="instruction-text">Siapkan dokumen (KK, KTP, SK, Ijazah) dalam format <strong>PDF bersih</strong>.</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="instruction-item">
                        <span class="instruction-number">04</span>
                        <span class="instruction-text">Pastikan ukuran file di bawah <strong>1MB</strong> agar proses sinkronisasi lancar.</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="important-note shadow-sm">
            <div class="d-flex gap-3">
                <div class="bg-primary bg-opacity-10 p-2 rounded-3 h-100">
                    <i class="bi bi-exclamation-triangle-fill text-primary fs-5"></i>
                </div>
                <div>
                    <div class="important-note-title">Catatan Penting!  </div>
                    <p class="important-note-text mb-0">
                        Semua unggah dokumen dilakukan melalui sistem eksternal resmi Provinsi. Mohon diingat bahwa sistem ini   <strong>tidak terhubung otomatis</strong> dengan Arsip Digital KOMINFO
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection