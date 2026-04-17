<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPADU - Kota Bengkulu</title>
    <link href="https://fonts.googleapis.com/css2?family=Paytone+One&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(rgba(20, 50, 120, 0.53), rgba(20, 50, 120, 0.85)), 
                        url('{{ asset('image/KOMINFO.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            overflow-x: hidden;
        }

        /* Font SIPADU: Paytone One dengan ukuran awal */
        .brand-font {
            font-family: 'Paytone One', sans-serif;
            text-shadow: 0 10px 20px rgba(0,0,0,0.3);
        }

        /* Animasi Floating untuk Logo */
        .float-animation {
            animation: floating 3s ease-in-out infinite;
        }

        .float-delay {
            animation: floating 3s ease-in-out infinite;
            animation-delay: 1.5s;
        }

        @keyframes floating {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-12px) rotate(2deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }

        .btn-shadow {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .btn-glow:hover {
            box-shadow: 0 0 20px rgba(66, 153, 225, 0.5);
            transform: translateY(-3px);
        }

        .fade-in {
            animation: fadeIn 1.2s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .footer-link:hover {
            color: #63b3ed !important;
            text-decoration: underline !important;
        }

        /* Navy custom untuk 'SI' */
        .text-navy-custom {
            color: #19064f;
        }
    </style>
</head>
<body class="p-6">

    <div class="max-w-4xl w-full text-center text-white fade-in">
        
        <div class="mb-5 flex justify-center items-center gap-4 md:gap-2">
            <img src="{{ asset('image/LOGOKOMINFO.png') }}" class="drop-shadow-2xl object-contain float-animation" width="125" alt="Logo Kominfo">
            <img src="{{ asset('image/pemkot.png') }}" class="drop-shadow-2xl object-contain float-delay" width="90" alt="Logo Pemkot">
        </div>

        <h1 class="brand-font text-7xl md:text-9xl font-bold tracking-tight mb-2 drop-shadow-lg">
            <span class="text-navy-custom">SI</span>PADU
        </h1>
        
        <p class="text-lg md:text-xl font-medium text-blue-100 mb-6 tracking-wide drop-shadow-md">
            (Sistem Penyimpanan Arsip Terpadu)
        </p>

        <div class="w-12 h-1 bg-white/30 mx-auto mb-8 rounded-full"></div>

        <p class="text-lg md:text-2xl font-light leading-relaxed text-gray-100 mb-12 max-w-3xl mx-auto px-4">
            Platform cerdas untuk mengelola, mengamankan, dan mengakses dokumen kepegawaian Anda dalam satu ekosistem digital yang modern.
        </p>

        <div class="flex flex-col gap-5 items-center">
            <a href="/login" class="w-full max-w-md py-4 bg-[#2b6cb0] hover:bg-[#2c5282] transition-all duration-300 rounded-2xl font-bold text-lg flex items-center justify-center gap-3 btn-shadow btn-glow">
                <i class="fas fa-key text-sm"></i> Login
            </a>

            <a href="https://bkpsdmpangkat2023.carrd.co/" target="_blank" rel="noopener noreferrer" class="w-full max-w-md py-4 bg-[#802c6e] hover:bg-[#6b225c] transition-all duration-300 rounded-2xl font-bold text-lg flex items-center justify-center gap-3 btn-shadow btn-glow">
                <i class="fas fa-arrow-up text-sm"></i> Pengusulan Kenaikan Pangkat
            </a>
        </div>

        <div class="mt-8 leading-relaxed opacity-80">
            <p class="text-white/50 small" style="font-size: 0.75rem; letter-spacing: 0.05rem;">
                © 2026 Kominfo Kota Bengkulu
                <br>
                Dikembangkan Oleh <a href="https://www.linkedin.com/in/aurel-moura-athanafisah-4821a6217" target="_blank" class="footer-link font-bold text-white transition-colors duration-300" style="text-decoration: none;">
                    Aurel Moura
                </a>
            </p>
        </div>
    </div>

</body>
</html>