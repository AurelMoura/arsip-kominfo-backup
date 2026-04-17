<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIPADU Kominfo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-blue: #00529C;
            --accent-blue: #007bff;
            --bg-light: #f8fafc;
            --dark-blue: #002b5c;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-light);
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        /* LEFT SIDE - DYNAMIC GRADIENT & PARTICLES */
        .left-side {
            background: linear-gradient(135deg, #0a3d91 0%, #002b5c 100%);
            color: white;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        /* Floating Shapes Decoration */
        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 50%;
            z-index: -1;
            animation: float 20s infinite linear;
        }

        @keyframes float {
            0% { transform: translateY(0) rotate(0deg); }
            100% { transform: translateY(-100vh) rotate(360deg); }
        }

        /* GLASS ICON WITH PULSE */
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            padding: 25px;
            border-radius: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.4s ease;
            display: inline-block;
        }
        
        .glass-card:hover {
            transform: scale(1.05) rotate(2deg);
            background: rgba(255, 255, 255, 0.15);
        }

        /* BADGE MODERN */
        .badge-feature {
            background: rgba(255, 255, 255, 0.08);
            padding: 8px 18px;
            border-radius: 100px;
            font-size: 0.8rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            cursor: default;
        }

        .badge-feature:hover {
            background: white;
            color: var(--primary-blue);
            transform: translateY(-3px);
        }

        /* CARD LOGIN */
        .card-login {
            border-radius: 32px;
            border: none;
            padding: 60px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.06) !important;
        }

        .form-control {
            border-radius: 16px;
            padding: 14px 18px;
            background: #f8fafc;
            border: 2px solid #edf2f7;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 4px rgba(0, 82, 156, 0.1);
            background: #fff;
            transform: translateY(-1px);
        }

        .btn-primary {
            border-radius: 16px;
            padding: 16px;
            background: var(--primary-blue);
            border: none;
            font-weight: 700;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: var(--dark-blue);
            box-shadow: 0 10px 20px rgba(0, 82, 156, 0.25);
            transform: translateY(-2px);
        }

        .btn-light {
            border-radius: 16px;
            padding: 16px;
            font-weight: 600;
            border: 2px solid #edf2f7;
            background: white;
            transition: all 0.3s ease;
        }

        /* STEP TRANSITION */
        .step-transition {
            transition: all 0.4s ease;
        }

        .logo-kominfo {
            transition: transform 0.5s ease;
        }

        .logo-kominfo:hover {
            transform: scale(1.1);
        }

        /* Responsive */
        @media (max-width: 991px) {
            .left-side { display: none !important; }
            .card-login { padding: 40px 25px; width: 100% !important; }
            body { overflow: auto; }
        }
    </style>
</head>

<body>

<div class="container-fluid h-100 p-0">
    <div class="row g-0 h-100">

        <div class="col-md-6 left-side d-flex flex-column justify-content-center align-items-center text-center p-5">
            <div class="shape" style="width: 80px; height: 80px; top: 10%; left: 10%;"></div>
            <div class="shape" style="width: 120px; height: 120px; bottom: 15%; right: 10%; animation-delay: 2s;"></div>
            <div class="shape" style="width: 50px; height: 50px; top: 40%; right: 20%; animation-delay: 5s;"></div>

            <div class="mb-4 animate__animated animate__zoomIn">
                <div class="glass-card">
                    <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                        <circle cx="12" cy="13" r="3" stroke-opacity="0.5"></circle>
                        <path d="M12 10v3l2 2" stroke-opacity="0.8"></path>
                    </svg>
                </div>
            </div>

            <div class="animate__animated animate__fadeInDown">
                <h1 class="fw-bold mb-0 display-4" style="letter-spacing: 5px; text-shadow: 0 10px 20px rgba(0,0,0,0.2);">SIPADU</h1>
                <p class="text-uppercase fw-600 mb-4" style="letter-spacing: 2px; font-size: 0.85rem; color: rgba(255,255,255,0.9); font-weight: 600;">
                    Sistem Penyimpanan Arsip Terpadu
                </p>
                <div style="width: 60px; height: 4px; background: white; margin: 0 auto 30px auto; border-radius: 10px; opacity: 0.5;"></div>
            </div>

            <p class="opacity-75 px-lg-5 mb-4 animate__animated animate__fadeInUp" style="max-width: 500px; font-size: 1.05rem; line-height: 1.8; font-weight: 300;">
                Platform cerdas untuk mengelola, mengamankan, dan mengakses dokumen kepegawaian Anda dalam satu ekosistem digital yang modern.
            </p>

            <div class="d-flex gap-3 mt-2 flex-wrap justify-content-center animate__animated animate__fadeInUp animate__delay-1s">
                <span class="badge-feature"><i class="bi bi-shield-check me-2"></i>Encrypted</span>
                <span class="badge-feature"><i class="bi bi-lightning-charge me-2"></i>Fast Access</span>
                <span class="badge-feature"><i class="bi bi-hdd-network me-2"></i>Integrated</span>
            </div>
        </div>

        <div class="col-md-6 d-flex align-items-center justify-content-center bg-white">
            <div class="card card-login w-75 animate__animated animate__fadeInRight">
                <div class="text-center mb-5">
                    <img src="{{ asset('image/LOGOKOMINFO.png') }}" class="logo-kominfo mb-3" width="150" alt="Logo">
                    <h3 class="fw-bold text-dark mb-1">Selamat Datang</h3>
                    <p class="text-muted small">Silakan masuk untuk mengelola arsip digital</p>
                </div>

                <form action="{{ url('/login') }}" method="POST" id="loginForm">
                    @csrf
                    
                    @if(session('error')) 
                        <div class="alert alert-danger border-0 shadow-sm animate__animated animate__shakeX rounded-4" role="alert">
                            <small class="fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}</small>
                        </div> 
                    @endif

                    <div id="step1" class="step-transition">
                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary small mb-2 text-uppercase" style="letter-spacing: 1px;">Nomor Induk Pegawai (NIP)</label>
                            <input type="text" name="identifier" id="ident" class="form-control" placeholder="Masukkan 18 digit NIP" maxlength="18" inputmode="numeric" pattern="\d*" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                            <div class="invalid-feedback">NIP harus diisi dengan benar.</div>
                        </div>
                        <button type="button" onclick="nextStep()" class="btn btn-primary w-100 shadow-sm d-flex align-items-center justify-content-center">
                            <span>Lanjutkan</span>
                            <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </div>

                    <div id="step2" style="display:none" class="step-transition">
                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary small mb-2 text-uppercase" style="letter-spacing: 1px;">Kata Sandi</label>
                            <div class="position-relative">
                                <input type="password" name="password_input" id="passInput" class="form-control" placeholder="••••••••" required>
                                <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3 text-muted" id="togglePass" style="cursor:pointer;"></i>
                            </div>
                        </div>
                        <div class="d-flex gap-3">
                            <button type="button" onclick="prevStep()" class="btn btn-light w-25 shadow-sm text-muted">
                                <i class="bi bi-arrow-left"></i>
                            </button>
                            <button type="submit" class="btn btn-primary w-75 shadow-sm">
                                Masuk ke Sistem
                            </button>
                        </div>
                    </div>
                </form>

                <div class="mt-5 text-center">
                    <p class="text-muted small" style="font-size: 0.75rem;">
                        © 2026 Kominfo Kota Bengkulu
                        <br>
                        Dikembangkan Oleh
                        <a href="https://www.linkedin.com/in/aurel-moura-athanafisah-4821a6217" target="_blank" class="text-primary fw-bold text-decoration-none">
                            Aurel Moura
                        </a> 
                        <br>
                        
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function nextStep() {
        const identInput = document.getElementById('ident');
        const val = identInput.value.trim();
        if (val.length !== 18 || !/^\d{18}$/.test(val)) {
            identInput.classList.add('is-invalid');
            showNipToast('NIP harus tepat 18 digit angka.');
            identInput.focus();
            return;
        }
        identInput.classList.remove('is-invalid');
            
            const s1 = document.getElementById('step1');
            const s2 = document.getElementById('step2');

            s1.classList.add('animate__animated', 'animate__fadeOutLeft');
            
            setTimeout(() => {
                s1.style.display = 'none';
                s2.style.display = 'block';
                s2.classList.add('animate__animated', 'animate__fadeInRight');
            }, 300);
    }

    function showNipToast(msg) {
        let toast = document.getElementById('nipToast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'nipToast';
            toast.style.cssText = 'position:fixed;top:24px;left:50%;transform:translateX(-50%);z-index:9999;padding:12px 24px;border-radius:12px;background:#dc3545;color:#fff;font-size:14px;font-weight:600;box-shadow:0 4px 20px rgba(0,0,0,.15);opacity:0;transition:opacity .3s;';
            document.body.appendChild(toast);
        }
        toast.textContent = msg;
        toast.style.opacity = '1';
        setTimeout(() => { toast.style.opacity = '0'; }, 2000);
    }

    function prevStep() {
        const s1 = document.getElementById('step1');
        const s2 = document.getElementById('step2');

        s2.classList.remove('animate__fadeInRight');
        s2.classList.add('animate__fadeOutRight');

        setTimeout(() => {
            s2.style.display = 'none';
            s2.classList.remove('animate__fadeOutRight');
            s1.style.display = 'block';
            s1.classList.remove('animate__fadeOutLeft');
            s1.classList.add('animate__fadeInLeft');
        }, 300);
    }

    // Toggle Password Visibility
    const togglePass = document.getElementById('togglePass');
    const passInput = document.getElementById('passInput');
    
    togglePass.addEventListener('click', function() {
        const type = passInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passInput.setAttribute('type', type);
        this.classList.toggle('bi-eye');
        this.classList.toggle('bi-eye-slash');
    });

    // Enter Key Support
    document.getElementById('ident').addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            nextStep();
        }
    });
</script>

</body>
</html>