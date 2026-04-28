<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Admin - Arsip Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        :root {
            --sidebar-color: #1e3a5f;
            --primary-blue: #4361ee;
            --accent-color: #4cc9f0;
            --bg-body: #f8fafc;
            --glass-bg: rgba(255, 255, 255, 0.95);
        }

        body {
            background-color: var(--bg-body);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1e293b;
            margin: 0;
            overflow-x: hidden;
        }

        /* Main Content Centering */
        .main-content {
            margin-left: 260px; /* Sesuai margin sidebar global */
            min-height: 100vh;
            display: flex;
            align-items: center; 
            justify-content: center; 
            padding: 40px;
            background-image: 
                radial-gradient(at 0% 0%, rgba(67, 97, 238, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(76, 201, 240, 0.05) 0px, transparent 50%);
        }

        .container-wrapper {
            width: 100%;
            max-width: 580px;
        }

        .form-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 28px;
            padding: 45px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }

        .form-card:hover { transform: translateY(-5px); }

        .form-control {
            border: 2px solid #e2e8f0;
            padding: 14px 20px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background-color: #f8fafc;
        }

        .form-control:focus {
            background-color: #fff;
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.15);
            transform: scale(1.01);
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--primary-blue), #3b82f6);
            border: none;
            padding: 16px;
            border-radius: 16px;
            font-weight: 700;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 15px -3px rgba(67, 97, 238, 0.3);
            color: white;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(67, 97, 238, 0.4);
            filter: brightness(1.1);
            color: white;
        }

        .icon-box {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, rgba(67, 97, 238, 0.1), rgba(76, 201, 240, 0.1));
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .input-group-custom { position: relative; }
        .input-group-custom i {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            cursor: pointer;
            z-index: 10;
        }

        @media (max-width: 991px) {
            .main-content { 
                margin-left: 0; 
                padding: 16px;
                padding-top: calc(56px + 16px);
            }
        }
    </style>
</head>
<body>

@include('components.sidebar')

<div class="main-content">
    <div class="container-wrapper animate__animated animate__fadeInUp">
        
        <!-- <div class="text-center mb-5">
            <h2 class="fw-bold text-dark mb-2">Tambah Admin Baru</h2>
            <p class="text-muted">Lengkapi formulir di bawah untuk menambah pengelola sistem.</p>
        </div> -->

        <div class="form-card">
            <div class="d-flex flex-column align-items-center text-center mb-4">
                <div class="icon-box">
                    <i class="bi bi-shield-lock-fill text-primary fs-3"></i>
                </div>
                <h5 class="fw-bold mb-1">Data Akun Admin</h5>
                <span class="badge bg-light text-primary border border-primary-subtle px-3 py-2 rounded-pill">Privilege: Administrator</span>
            </div>

            <form action="{{ url('/superadmin/store-admin') }}" method="POST" id="adminForm">
                @csrf

                <div class="mb-4">
                    <label class="form-label fw-bold text-secondary text-uppercase small">Username (18 Digit NIP)</label>
                    <input type="text" name="nip" id="adminNipInput" class="form-control rounded-4 @error('nip') is-invalid @enderror"
                           placeholder="Masukkan 18 angka" value="{{ old('nip') }}" required maxlength="18" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    @error('nip')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-secondary text-uppercase small">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control rounded-4 @error('nama_lengkap') is-invalid @enderror"
                           placeholder="Masukkan nama " value="{{ old('nama_lengkap') }}" required>
                    @error('nama_lengkap')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-secondary text-uppercase small">Password</label>
                    <div class="input-group-custom">
                        <input type="password" name="password" id="password" class="form-control rounded-4 @error('password') is-invalid @enderror"
                               placeholder="Min. 8 karakter" required minlength="8"
                               pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}">
                        <i class="bi bi-eye" id="togglePassword"></i>
                    </div>
                    <small class="text-muted d-block mt-2">Gunakan minimal 8 karakter dengan huruf besar, huruf kecil, angka, dan simbol (@$!%*?&).</small>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-secondary text-uppercase small">Konfirmasi Password</label>
                    <div class="input-group-custom">
                        <input type="password" name="password_confirmation" id="password_confirm" class="form-control rounded-4"
                               placeholder="Ulangi password" required minlength="8">
                        <i class="bi bi-eye" id="toggleConfirmPassword"></i>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-submit w-100 mt-3">
                    <i class="bi bi-person-plus-fill me-2"></i> Buat Akun Admin
                </button>
            </form>
        </div>

        <div class="text-center mt-4">
            <a href="{{ url('/dashboard') }}" class="text-decoration-none text-muted small">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function showLocalToast(message, type = 'warning') {
        if (typeof window.showToast === 'function') {
            window.showToast(message, type);
            return;
        }

        const existingToast = document.getElementById('localToastMessage');
        if (existingToast) {
            existingToast.remove();
        }

        const colors = {
            success: '#16a34a',
            error: '#dc2626',
            warning: '#d97706',
            info: '#2563eb'
        };

        const toast = document.createElement('div');
        toast.id = 'localToastMessage';
        toast.textContent = message;
        toast.style.cssText = `position:fixed;top:20px;right:20px;z-index:9999;padding:12px 16px;border-radius:10px;color:#fff;font-weight:600;box-shadow:0 8px 20px rgba(0,0,0,.15);background:${colors[type] || colors.info};opacity:0;transform:translateY(-10px);transition:all .2s ease;`;
        document.body.appendChild(toast);

        requestAnimationFrame(() => {
            toast.style.opacity = '1';
            toast.style.transform = 'translateY(0)';
        });

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(-10px)';
            setTimeout(() => toast.remove(), 220);
        }, 2500);
    }

    // Validasi NIP
    function validateAdminNip() {
        const nip = document.getElementById('adminNipInput').value.trim();
        if (nip.length !== 18 || !/^\d{18}$/.test(nip)) {
            showLocalToast('Username/NIP harus tepat 18 digit angka.', 'warning');
            return false;
        }
        return true;
    }

    // Toggle Show/Hide Password
    const setupToggle = (inputId, toggleId) => {
        const input = document.getElementById(inputId);
        const toggle = document.getElementById(toggleId);
        
        toggle.addEventListener('click', function() {
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    };

    setupToggle('password', 'togglePassword');
    setupToggle('password_confirm', 'toggleConfirmPassword');

    // Animasi Loading & Validasi saat Submit
    document.getElementById('adminForm').onsubmit = function(e) {
        if (!validateAdminNip()) {
            e.preventDefault();
            return false;
        }
        
        const btn = this.querySelector('.btn-submit');
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Memproses...';
        btn.style.opacity = '0.7';
        btn.style.pointerEvents = 'none';
    };

    // Modal fallback
    window.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.modal').forEach(function(modal) {
            if (modal.parentNode !== document.body) document.body.appendChild(modal);
        });
    });
</script>
</body>
</html>