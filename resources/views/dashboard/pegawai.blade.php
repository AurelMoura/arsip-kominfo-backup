@extends('layouts.app')

@section('title', 'Dashboard Pegawai - Arsip Digital')

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
        .main-content { padding: 40px; transition: all 0.3s; }
        .page-header-label { 
            color: var(--primary-blue); 
            font-weight: 800; 
            font-size: 11px; 
            letter-spacing: 1.5px; 
            text-transform: uppercase; 
            border-left: 4px solid var(--primary-blue); 
            padding-left: 12px; 
            margin-bottom: 12px; 
            display: block;
        }
        
        /* Stat Cards Luxe */
        .stat-card { 
            border: none; 
            border-radius: 24px; 
            padding: 25px; 
            background: white; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.02); 
            transition: all 0.3s ease;
            border: 1px solid rgba(226, 232, 240, 0.8);
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        }
        
        /* Feature Cards Premium */
        .feature-card { 
            border: none; 
            border-radius: 28px; 
            padding: 40px; 
            background: white; 
            height: 100%; 
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); 
            border: 1px solid rgba(226, 232, 240, 0.8);
            position: relative;
            overflow: hidden;
        }
        .feature-card:hover { 
            transform: translateY(-10px); 
            box-shadow: 0 20px 40px rgba(0,0,0,0.06) !important; 
        }
        .icon-circle { 
            width: 65px; 
            height: 65px; 
            border-radius: 20px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-size: 30px; 
            margin-bottom: 25px; 
            box-shadow: 0 10px 20px rgba(58, 134, 255, 0.2);
        }
        
        .btn-action { 
            border-radius: 14px; 
            padding: 14px 24px; 
            font-weight: 700; 
            border: none; 
            width: 100%; 
            transition: 0.3s; 
            text-align: center;
        }
        .btn-action:hover {
            filter: brightness(1.1);
            transform: scale(1.02);
        }

        .info-box { 
            background: linear-gradient(to right, #eff6ff, #dbeafe); 
            border-radius: 20px; 
            padding: 25px; 
            border-left: 6px solid var(--primary-blue); 
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        }

        /* Custom Modal Modern */
        .modal-content { border-radius: 30px; border: none; overflow: hidden; }
        .modal-header-custom { 
            background: linear-gradient(135deg, var(--primary-blue), #2563eb); 
            color: white; 
            padding: 30px; 
        }

        @media (max-width: 991px) {
            .sidebar { width: 80px; }
            .sidebar .ms-3, .sidebar .text-truncate, .sidebar span, .sidebar small, .sidebar .ms-auto { display: none; }
            .main-content { margin-left: 80px; padding: 25px; }
        }
    </style>
@endpush

@section('content')

<div class="main-content text-start">
    <div class="mb-5">
        <span class="page-header-label">Dashboard Arsip Dokumen Kominfo</span>
        <h1 class="fw-bold mt-2" style="font-size: 36px; letter-spacing: -1px;">Selamat Datang, <span class="text-primary">{{ Session::get('name') }}</span></h1>
        <p class="text-muted" style="font-size: 15px;">Pegawai Kominfo • Bagian Umum & Kepegawaian</p>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="stat-card d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-4 me-4 shadow-sm"><i class="bi bi-folder-check fs-2"></i></div>
                <div>
                    <h3 class="fw-bold mb-0" style="font-size: 28px;">{{ \App\Models\Document::where('user_id', Session::get('user_id'))->count() }}</h3>
                    <small class="text-muted fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Dokumen Tersimpan</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card d-flex align-items-center">
                <div class="bg-success bg-opacity-10 text-success p-3 rounded-4 me-4 shadow-sm"><i class="bi bi-cloud-arrow-up-fill fs-2"></i></div>
                <div>
                    <h3 class="fw-bold mb-0" style="font-size: 28px;">{{ \App\Models\Document::where('user_id', Session::get('user_id'))->whereMonth('uploaded_at', now()->month)->whereYear('uploaded_at', now()->year)->count() }}</h3>
                    <small class="text-muted fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Upload Bulan Ini</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card d-flex align-items-center">
                <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-4 me-4 shadow-sm"><i class="bi bi-hourglass-split fs-2"></i></div>
                <div>
                    <h3 class="fw-bold mb-0" style="font-size: 28px;">0</h3>
                    <small class="text-muted fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Pengajuan Aktif</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="feature-card shadow-sm border-top border-4 border-primary">
                <div class="icon-circle bg-primary text-white shadow-sm"><i class="bi bi-file-earmark-medical"></i></div>
                <h4 class="fw-bold" style="font-size: 22px;">Arsip Dokumen Saya</h4>
                <p class="text-muted small mb-4" style="line-height: 1.6;">Kelola dokumen kepegawaian pribadi Anda mulai dari SK, Ijazah, hingga Sertifikat Pelatihan secara digital.</p>
                <a href="{{ url('/pegawai/arsip') }}" class="btn-action bg-primary text-white shadow-sm text-decoration-none d-inline-block">
                    <i class="bi bi-folder2-open me-2"></i> Buka Arsip Dokumen
                </a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="feature-card shadow-sm border-top border-4 border-success">
                <div class="icon-circle bg-success text-white shadow-sm"><i class="bi bi-send-check"></i></div>
                <h4 class="fw-bold" style="font-size: 22px;">Pengajuan Berkas</h4>
                <p class="text-muted small mb-4" style="line-height: 1.6;">Ajukan permohonan mutasi, kenaikan pangkat, atau cuti secara digital dengan proses pemantauan real-time.</p>
                <a href="{{ url('/pengajuan-berkas') }}" class="btn-action bg-success text-white shadow-sm text-decoration-none d-inline-block">
                    <i class="bi bi-box-arrow-up-right me-2"></i> Akses Portal Pengajuan
                </a>
            </div>
        </div>
    </div>

    <div class="info-box shadow-sm mb-5">
        <div class="d-flex align-items-start">
            <i class="bi bi-info-circle-fill fs-3 text-primary me-4 mt-1"></i>
            <div>
                <h6 class="fw-bold mb-1" style="font-size: 16px;">Perbedaan Arsip & Pengajuan</h6>
                <p class="text-muted small mb-0" style="font-size: 14px; line-height: 1.6;">Arsip digunakan untuk menyimpan dan melihat dokumen pribadi yang sudah valid, sedangkan Pengajuan digunakan untuk proses verifikasi dokumen baru oleh administrator.</p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUpdateKredensial" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header-custom text-center">
                <h4 class="fw-bold mb-1 text-white">Keamanan Akun</h4>
                <p class="opacity-75 text-white mb-0 small">Demi keamanan, Anda <strong>WAJIB</strong> mengganti password default sebelum mengakses fitur lainnya</p>
            </div>
            
            <form action="{{ url('/pegawai/update-password') }}" method="POST">
                @csrf
                <div class="modal-body p-5 text-start">
                    <div class="bg-light rounded-4 p-4 mb-4 border border-dashed border-primary border-opacity-20">
                        <div class="small text-muted mb-1">Akun Terdaftar:</div>
                        <div class="text-dark fw-bold" style="font-size: 16px;">{{ Session::get('name') }}</div>
                        <div class="text-primary small fw-bold">NIP: {{ Session::get('identifier') }}</div>
                    </div>

                    <div class="alert alert-danger rounded-3 py-2 px-3 mb-4">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i>
                        <small class="fw-bold">Anda wajib mengganti password sebelum dapat mengakses Arsip Dokumen dan Daftar Riwayat Hidup.</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-uppercase text-secondary" style="letter-spacing: 1px;">Password Baru *</label>
                        <input type="password" name="password_baru" class="form-control bg-light border-0 py-3 rounded-3" placeholder="Minimal 8 karakter dengan kombinasi huruf besar, kecil, angka, dan simbol" required>
                        <small class="d-block text-muted mt-2" style="font-size: 12px; line-height: 1.6;">
                            <strong>Syarat Password:</strong><br>
                            ✓ Minimal <strong>8 karakter</strong><br>
                            ✓ Mengandung <strong>huruf besar</strong> (A-Z)<br>
                            ✓ Mengandung <strong>huruf kecil</strong> (a-z)<br>
                            ✓ Mengandung <strong>angka</strong> (0-9)<br>
                            ✓ Mengandung <strong>simbol</strong> (@$!%*?&)
                        </small>
                    </div>

                    <div class="mb-0">
                        <label class="form-label small fw-bold text-uppercase text-secondary" style="letter-spacing: 1px;">Konfirmasi Password *</label>
                        <input type="password" name="konfirmasi_password" class="form-control bg-light border-0 py-3 rounded-3" placeholder="Ulangi password baru" required>
                    </div>
                </div>
                <div class="modal-footer border-0 p-5 pt-0">
                    <button type="submit" class="btn btn-primary px-4 py-3 fw-bold shadow rounded-3 w-100">
                        <i class="bi bi-check2-circle me-2"></i> Simpan Password Baru
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<style>
    .password-error-toast {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999;
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
        padding: 20px 30px;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(220, 53, 69, 0.3);
        min-width: 500px;
        text-align: center;
        border-left: 5px solid #fff;
        animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translate(-50%, -60%);
        }
        to {
            opacity: 1;
            transform: translate(-50%, -50%);
        }
    }

    .password-error-toast .close-toast {
        position: absolute;
        right: 15px;
        top: 15px;
        background: none;
        border: none;
        color: white;
        font-size: 20px;
        cursor: pointer;
        padding: 0;
    }

    .password-error-toast .close-toast:hover {
        opacity: 0.7;
    }

    .password-error-toast .icon {
        font-size: 24px;
        margin-bottom: 10px;
        display: block;
    }

    .password-error-toast .message {
        font-size: 14px;
        font-weight: 500;
        line-height: 1.6;
    }

    /* Success Toast Styles */
    .password-success-toast {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999;
        background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
        color: white;
        padding: 20px 30px;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(40, 167, 69, 0.3);
        min-width: 500px;
        text-align: center;
        border-left: 5px solid #fff;
        animation: slideIn 0.3s ease-out;
    }

    .password-success-toast .close-toast {
        position: absolute;
        right: 15px;
        top: 15px;
        background: none;
        border: none;
        color: white;
        font-size: 20px;
        cursor: pointer;
        padding: 0;
    }

    .password-success-toast .close-toast:hover {
        opacity: 0.7;
    }

    .password-success-toast .icon {
        font-size: 24px;
        margin-bottom: 10px;
        display: block;
    }

    .password-success-toast .message {
        font-size: 14px;
        font-weight: 500;
        line-height: 1.6;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var isFirstLogin = "{{ Session::get('is_first_login') }}";
        console.log("Status Login Pertama: " + isFirstLogin);

        // Tampilkan notifikasi error validasi password jika ada
        @if($errors->has('password_baru'))
            showPasswordErrorToast();
        @endif

        // Tampilkan notifikasi success jika password berhasil diubah
        @if(session('success') && strpos(session('success'), 'Password') !== false)
            showPasswordSuccessToast();
        @endif

        // Tampilkan modal untuk first login jika tidak ada error
        @if(!$errors->has('password_baru') && !$errors->has('konfirmasi_password'))
            if (isFirstLogin === "1" || isFirstLogin === "true") {
                var modalElement = document.getElementById('modalUpdateKredensial');
                var myModal = new bootstrap.Modal(modalElement);
                setTimeout(function() {
                    myModal.show();
                }, 500); // Sedikit delay agar transisi lebih smooth
            }
        @else
            // Jika ada error, tetap buka modal
            var modalElement = document.getElementById('modalUpdateKredensial');
            var myModal = new bootstrap.Modal(modalElement);
            setTimeout(function() {
                myModal.show();
            }, 500);
        @endif
    });

    function showPasswordErrorToast() {
        var toastContainer = document.createElement('div');
        toastContainer.className = 'password-error-toast';
        toastContainer.innerHTML = `
            <button class="close-toast" onclick="this.parentElement.remove();">&times;</button>
            <span class="icon">⚠️</span>
            <div class="message">
                <strong>Password tidak memenuhi kriteria keamanan.</strong><br>
                Pastikan password memiliki minimal 8 karakter dengan kombinasi huruf besar, huruf kecil, angka, dan simbol.
            </div>
        `;

        document.body.appendChild(toastContainer);

        // Auto-remove setelah 4 detik
        setTimeout(function() {
            if (toastContainer.parentElement) {
                toastContainer.remove();
            }
        }, 4000);
    }

    function showPasswordSuccessToast() {
        var toastContainer = document.createElement('div');
        toastContainer.className = 'password-success-toast';
        toastContainer.innerHTML = `
            <button class="close-toast" onclick="this.parentElement.remove();">&times;</button>
            <span class="icon">✅</span>
            <div class="message">
                <strong>PASSWORD BERHASIL DIUBAH</strong>
            </div>
        `;

        document.body.appendChild(toastContainer);

        // Auto-remove setelah 3 detik
        setTimeout(function() {
            if (toastContainer.parentElement) {
                toastContainer.remove();
            }
        }, 3000);
    }
</script>
@endpush

@endsection