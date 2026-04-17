@extends('layouts.app')

@section('title', 'Kelola Profil - Arsip Digital')

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
        .main-content { padding: 40px; }
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
        
        /* Custom Cards Luxe */
        .card-custom { 
            border: none; 
            border-radius: 24px; 
            background: white; 
            overflow: hidden; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.02);
            border: 1px solid rgba(226, 232, 240, 0.8);
            transition: transform 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        }

        .form-control { 
            background-color: #f8fafc; 
            border: 2px solid #edf2f7; 
            padding: 12px 18px; 
            border-radius: 14px; 
            font-size: 14px;
            color: #4a5568;
            transition: all 0.3s;
        }
        .form-control:focus { 
            background-color: white; 
            box-shadow: 0 0 0 4px rgba(58, 134, 255, 0.1); 
            border-color: var(--primary-blue); 
        }
        
        .btn-primary { 
            background: linear-gradient(135deg, var(--primary-blue), #2563eb); 
            border: none; 
            border-radius: 14px; 
            padding: 12px 25px; 
            font-weight: 700; 
            box-shadow: 0 4px 15px rgba(58, 134, 255, 0.3);
            transition: all 0.3s;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(58, 134, 255, 0.4);
            filter: brightness(1.1);
        }

        /* Modal Styles Luxe */
        .modal-content { border-radius: 30px; border: none; padding: 10px; }
        .modal-header { border-radius: 20px 20px 0 0; }

        @media (max-width: 991px) {
            .sidebar { width: 80px; }
            .sidebar .lh-1, .sidebar .text-white, .sidebar small, .sidebar span { display: none; }
            .main-content { margin-left: 80px; padding: 25px; }
        }
    </style>
@endpush

@section('content')

<div class="main-content">
    <div class="mb-5">
        <div class="page-header-label">Account Settings</div>
        <h1 class="fw-bold text-dark" style="letter-spacing: -1px;">Kelola Profil</h1>
        <p class="text-muted small">Perbarui kredensial akun dan lengkapi Daftar Riwayat Hidup (DRH) Anda</p>
    </div>

    <!-- Tabel Informasi Profil Dasar (Read-only) -->
    <div class="card card-custom shadow-sm mb-5">
        <div class="bg-primary text-white p-4 d-flex align-items-center justify-content-between" style="background: linear-gradient(135deg, var(--primary-blue), #2563eb) !important;">
            <div class="d-flex align-items-center">
                <div class="bg-white bg-opacity-20 rounded-3 p-3 me-3 shadow-sm"><i class="bi bi-info-circle fs-4"></i></div>
                <div>
                    <h6 class="fw-bold mb-1" style="font-size: 17px;">INFORMASI KONTAK DAN KEPEGAWAIAN</h6>
                    <p class="opacity-75 mb-0 small">Informasi pribadi yang terdaftar dari profil dasar</p>
                </div>
            </div>
            <button class="btn btn-light btn-sm fw-bold text-primary px-4 py-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalUpdateKredensial" style="white-space: nowrap; border-radius: 8px;">
                <i class="bi bi-shield-lock me-2"></i> Ubah Password
            </button>
        </div>
        
        <div class="card-body p-5">
            <div class="d-flex gap-5 align-items-start flex-wrap">
                <!-- Foto Profil Upload -->
                <div class="text-center" style="min-width: 150px;">
                    <div class="rounded-circle overflow-hidden mx-auto mb-3 shadow" style="width: 130px; height: 130px; border: 4px solid #e2e8f0; background: #f8fafc;" id="foto-preview-wrapper">
                        @if($pegawaiData?->foto_profil)
                            <img src="{{ Storage::disk('public')->url($pegawaiData->foto_profil) }}" alt="Foto Profil" style="width: 100%; height: 100%; object-fit: cover;" id="foto-preview">
                        @else
                            <div class="d-flex align-items-center justify-content-center w-100 h-100 text-white fw-bold" style="font-size: 48px; background: linear-gradient(135deg, var(--primary-blue), #2563eb);" id="foto-initial">
                                {{ strtoupper(substr(Session::get('name'), 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <label for="inputFotoProfil" class="btn btn-sm btn-outline-primary rounded-pill px-3" style="cursor: pointer; font-size: 12px;">
                        <i class="bi bi-camera me-1"></i> Ganti Foto
                    </label>
                    <input type="file" id="inputFotoProfil" accept="image/*" class="d-none">
                    <div id="foto-upload-status" class="mt-2" style="font-size: 11px;"></div>
                </div>

                <!-- Tabel Informasi -->
                <div class="flex-grow-1">
            <div class="table-responsive">
                <table class="table table-borderless">
                    <tbody>
                        <tr style="border-bottom: 2px solid #e2e8f0;">
                            <td class="fw-bold text-secondary" style="width: 30%; padding: 14px 0;">NAMA LENGKAP</td>
                            <td style="padding: 14px 0; color: #2d3748;">{{ $pegawaiData?->nama_lengkap ?? '-' }}</td>
                        </tr>
                        <tr style="border-bottom: 2px solid #e2e8f0;">
                            <td class="fw-bold text-secondary" style="padding: 14px 0;">NIP</td>
                            <td style="padding: 14px 0; color: #2d3748;">{{ $pegawaiData?->id ?? '-' }}</td>
                        </tr>
                        <tr style="border-bottom: 2px solid #e2e8f0;">
                            <td class="fw-bold text-secondary" style="padding: 14px 0;">GOLONGAN</td>
                            <td style="padding: 14px 0; color: #2d3748;">{{ $pegawaiData?->golongan_pangkat ?? '-' }}</td>
                        </tr>
                        <tr style="border-bottom: 2px solid #e2e8f0;">
                            <td class="fw-bold text-secondary" style="padding: 14px 0;">JABATAN</td>
                            <td style="padding: 14px 0; color: #2d3748;">{{ $pegawaiData?->nama_jabatan ?? '-' }}</td>
                        </tr>
                        <tr style="border-bottom: 2px solid #e2e8f0;">
                            <td class="fw-bold text-secondary" style="padding: 14px 0;">UNIT KERJA</td>
                            <td style="padding: 14px 0; color: #2d3748;">{{ $pegawaiData?->unit_kerja?->name ?? '-' }}</td>
                        </tr>
                        <tr style="border-bottom: 2px solid #e2e8f0;">
                            <td class="fw-bold text-secondary" style="padding: 14px 0;">EMAIL</td>
                            <td style="padding: 14px 0; color: #2d3748;">{{ $pegawaiData?->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-secondary" style="padding: 14px 0;">NO HP</td>
                            <td style="padding: 14px 0; color: #2d3748;">{{ $pegawaiData?->no_hp ?? '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
                </div><!-- end tabel -->
            </div><!-- end d-flex -->
        </div>
    </div>

    <div class="card card-custom card-hover shadow-sm mb-5 p-5 text-center border-0">
        <div class="bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center shadow-sm" style="width: 70px; height: 70px;">
            <i class="bi bi-file-earmark-person fs-2"></i>
        </div>
        <h5 class="fw-bold mb-2" style="font-size: 22px;">Daftar Riwayat Hidup (DRH)</h5>
        <p class="text-muted small mb-4 mx-auto" style="max-width: 500px;">Lengkapi dan kelola data kurikulum vitae, pendidikan, dan pengalaman kerja Anda secara profesional dalam satu sistem terpusat.</p>
        <div class="col-md-4 mx-auto">
            <a href="{{ url('/profile/drh') }}" class="btn btn-primary w-100 py-3 shadow-lg">
                <i class="bi bi-file-earmark-text me-2"></i> Buka Portal DRH
            </a>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUpdateKredensial" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-primary text-white border-0 p-5 rounded-4 shadow-sm" style="background: linear-gradient(135deg, var(--primary-blue), #2563eb) !important;">
                <div class="text-center w-100">
                    <div class="bg-white bg-opacity-20 rounded-circle p-3 d-inline-block mb-3"><i class="bi bi-shield-lock fs-1"></i></div>
                    <h5 class="modal-title fw-bold d-block">Ubah Kredensial Akun</h5>
                    <p class="mb-0 opacity-75 small">Pastikan password baru Anda aman dan unik</p>
                </div>
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-4" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ url('/pegawai/update-password') }}" method="POST">
                @csrf
                <div class="modal-body p-5">
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Username Baru</label>
                        <input type="text" name="username_baru" class="form-control py-3 rounded-4 shadow-sm" value="{{ Session::get('name') }}" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Password Baru</label>
                        <input type="password" name="password_baru" class="form-control py-3 rounded-4 shadow-sm" placeholder="Minimal 8 karakter dengan kombinasi huruf besar, kecil, angka, dan simbol" required>
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
                        <label class="form-label small fw-bold text-secondary text-uppercase">Konfirmasi Password</label>
                        <input type="password" name="konfirmasi_password" class="form-control py-3 rounded-4 shadow-sm" placeholder="Ulangi password baru" required>
                    </div>
                </div>
                <div class="modal-footer border-0 p-5 pt-0">
                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-4 fw-bold shadow-lg">Simpan Kredensial Baru</button>
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
    // Handle password validation error and success notifications
    document.addEventListener('DOMContentLoaded', function() {
        @if($errors->has('password_baru') || $errors->has('konfirmasi_password'))
            showPasswordErrorToast();
        @endif

        @if(session('success') && strpos(session('success'), 'Password') !== false)
            showPasswordSuccessToast();
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

<script>
document.getElementById('inputFotoProfil').addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;

    const status = document.getElementById('foto-upload-status');
    status.innerHTML = '<span class="text-muted">Mengupload...</span>';

    const formData = new FormData();
    formData.append('foto_profil', file);
    formData.append('_token', '{{ csrf_token() }}');

    fetch('{{ url("/profile/upload-foto") }}', {
        method: 'POST',
        headers: {
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            // Update preview di card
            const wrapper = document.getElementById('foto-preview-wrapper');
            wrapper.innerHTML = `<img src="${data.url}" style="width:100%;height:100%;object-fit:cover;" id="foto-preview">`;

            // Update avatar di sidebar
            const sidebar = document.querySelector(".app-sidebar .rounded-circle.overflow-hidden");
            if (sidebar) {
                sidebar.innerHTML = `<img src="${data.url}" style="width:100%;height:100%;object-fit:cover;">`;
            }

            status.innerHTML = '<span class="text-success"><i class="bi bi-check-circle me-1"></i>Foto berhasil diperbarui</span>';
        } else {
            status.innerHTML = `<span class="text-danger"><i class="bi bi-x-circle me-1"></i>${data.message || 'Gagal upload foto'}</span>`;
        }
    })
    .catch(() => {
        status.innerHTML = '<span class="text-danger"><i class="bi bi-x-circle me-1"></i>Terjadi kesalahan</span>';
    });
});
</script>
@endpush

@endsection