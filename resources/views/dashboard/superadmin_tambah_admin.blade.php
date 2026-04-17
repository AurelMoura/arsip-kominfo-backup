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

        /* Sidebar Styles (Consistent with other pages) */
        .sidebar {
            width: 280px;
            height: 100vh;
            background: var(--sidebar-color);
            position: fixed;
            color: white;
            z-index: 100;
            box-shadow: 10px 0 30px rgba(0,0,0,0.05);
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

        /* Main Content Centering */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            display: flex;
            align-items: center; /* Vertical Center */
            justify-content: center; /* Horizontal Center */
            padding: 40px;
            background-image: 
                radial-gradient(at 0% 0%, rgba(67, 97, 238, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(76, 201, 240, 0.05) 0px, transparent 50%);
        }

        .container-wrapper {
            width: 100%;
            max-width: 580px;
        }

        /* Modern Glassmorphism Card */
        .form-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 28px;
            padding: 45px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }

        .form-card:hover {
            transform: translateY(-5px);
        }

        /* Interactive Inputs */
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

        .form-label {
            margin-left: 5px;
            letter-spacing: 0.5px;
        }

        /* Modern Button */
        .btn-submit {
            background: linear-gradient(135deg, var(--primary-blue), #3b82f6);
            border: none;
            padding: 16px;
            border-radius: 16px;
            font-weight: 700;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 15px -3px rgba(67, 97, 238, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(67, 97, 238, 0.4);
            filter: brightness(1.1);
        }

        .btn-submit:active {
            transform: scale(0.98);
        }

        /* Icon Animation */
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

        /* Input Icon Wrapper */
        .input-group-custom {
            position: relative;
        }

        .input-group-custom i {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            cursor: pointer;
        }

        /* Responsive Sidebar */
        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>

@include('components.sidebar')

<div class="main-content">
    <div class="container-wrapper animate__animated animate__fadeInUp">
        
        <div class="text-center mb-5">
            <h2 class="fw-bold text-dark mb-2">Tambah Admin Baru</h2>
            <p class="text-muted">Lengkapi formulir di bawah untuk menambah pengelola sistem.</p>
        </div>

        <div class="form-card">
            <div class="d-flex flex-column align-items-center text-center mb-4">
                <div class="icon-box">
                    <i class="bi bi-shield-lock-fill text-primary fs-3"></i>
                </div>
                <h5 class="fw-bold mb-1">Data Akun Admin</h5>
                <span class="badge bg-light text-primary border border-primary-subtle px-3 py-2 rounded-pill">Privilege: Administrator</span>
            </div>

            <form action="{{ url('/superadmin/store-admin') }}" method="POST" id="adminForm" onsubmit="return validateAdminNip()">
                @csrf

                <div class="mb-4">
                    <label class="form-label fw-bold text-secondary text-uppercase small">username (18digit) </label>
                    <input type="text" name="nip" id="adminNipInput" class="form-control rounded-4 @error('nip') is-invalid @enderror"
                           placeholder="Masukkan 18 angka" value="{{ old('nip') }}" required maxlength="18" inputmode="numeric" pattern="\d*" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    @error('nip')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-secondary text-uppercase small">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control rounded-4 @error('nama_lengkap') is-invalid @enderror"
                           placeholder="Masukkan nama lengkap beserta gelar" value="{{ old('nama_lengkap') }}" required>
                    @error('nama_lengkap')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-secondary text-uppercase small">Password</label>
                    <div class="input-group-custom">
                        <input type="password" name="password" id="password" class="form-control rounded-4 @error('password') is-invalid @enderror"
                               placeholder="Min. 6 karakter" required minlength="6">
                        <i class="bi bi-eye" id="togglePassword"></i>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-secondary text-uppercase small">Konfirmasi Password</label>
                    <div class="input-group-custom">
                        <input type="password" name="password_confirmation" id="password_confirm" class="form-control rounded-4"
                               placeholder="Ulangi password" required minlength="6">
                        <i class="bi bi-eye" id="toggleConfirmPassword"></i>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-submit w-100 mt-3">
                    <i class="bi bi-person-plus-fill me-2"></i> Buat Akun Admin
                </button>
        </div>

        <div class="text-center mt-4">
            <a href="{{ url('/superadmin/dashboard') }}" class="text-decoration-none text-muted small">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function validateAdminNip() {
        const nip = document.getElementById('adminNipInput').value.trim();
        if (nip.length !== 18 || !/^\d{18}$/.test(nip)) {
            let toast = document.getElementById('nipToast');
            if (!toast) {
                toast = document.createElement('div');
                toast.id = 'nipToast';
                toast.style.cssText = 'position:fixed;top:24px;left:50%;transform:translateX(-50%);z-index:9999;padding:12px 24px;border-radius:12px;background:#dc3545;color:#fff;font-size:14px;font-weight:600;box-shadow:0 4px 20px rgba(0,0,0,.15);opacity:0;transition:opacity .3s;';
                document.body.appendChild(toast);
            }
            toast.textContent = 'NIP harus tepat 18 digit angka.';
            toast.style.opacity = '1';
            setTimeout(() => { toast.style.opacity = '0'; }, 2000);
            return false;
        }
        return true;
    }

    // Fitur Interaktif: Toggle Show/Hide Password
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
            </form>
        </div>

        <div class="text-center mt-4">
            <a href="{{ url('/superadmin/dashboard') }}" class="text-decoration-none text-muted small">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

<!-- Fallback: pastikan modal selalu di-append ke body -->
<script>
window.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.modal').forEach(function(modal) {
    if (modal.parentNode !== document.body) document.body.appendChild(modal);
  });
});
</script>

    setupToggle('password', 'togglePassword');
    setupToggle('password_confirm', 'toggleConfirmPassword');

    // Animasi sederhana saat submit
    document.getElementById('adminForm').onsubmit = function() {
        const btn = this.querySelector('.btn-submit');
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Memproses...';
        btn.style.opacity = '0.7';
    };
</script>
</body>
</html>