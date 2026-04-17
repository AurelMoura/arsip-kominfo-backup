<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Arsip Digital</title>
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

        /* Main Content Styles */
        .main-content { margin-left: 280px; padding: 40px; min-height: 100vh; }

        /* Modern Stat Cards */
        .stat-card { 
            border: none; 
            border-radius: 24px; 
            padding: 28px;
            background: white;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
        }

        .stat-card::before {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: currentColor;
            opacity: 0.03;
            border-radius: 0 0 0 100%;
        }

        .icon-box { 
            width: 56px; 
            height: 56px; 
            border-radius: 16px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        /* Hero Alert Section */
        .welcome-banner {
            background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            padding: 35px;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.02);
            position: relative;
        }

        .welcome-icon {
            width: 60px;
            height: 60px;
            background: var(--primary-blue);
            color: white;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            box-shadow: 0 8px 16px rgba(67, 97, 238, 0.2);
        }

        .header-profile {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 50px;
            padding: 8px 20px;
            transition: 0.3s;
        }

        .header-profile:hover {
            background: #f8fafc;
        }
    </style>
</head>
<body>

@include('components.sidebar')

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold text-dark mb-1">Dashboard Overview</h2>
            <p class="text-muted mb-0">Selamat datang kembali di pusat kendali arsip digital.</p>
        </div>
        <div class="header-profile shadow-sm d-flex align-items-center">
             <i class="bi bi-person-circle me-2 text-primary fs-5"></i> 
             <span class="fw-bold text-dark" style="font-size: 14px;">{{ Session::get('name') }}</span>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card stat-card text-primary">
                <div class="icon-box bg-primary bg-opacity-10">
                    <i class="bi bi-people-fill"></i>
                </div>
                <h2 class="fw-bold mb-1 text-dark">{{ \App\Models\User::where('role', 'pegawai')->count() }}</h2>
                <p class="text-muted fw-medium mb-0">Total Pegawai Terdaftar</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card text-success">
                <div class="icon-box bg-success bg-opacity-10">
                    <i class="bi bi-file-earmark-text-fill"></i>
                </div>
                <h2 class="fw-bold mb-1 text-dark">{{ \App\Models\Document::count() }}</h2>
                <p class="text-muted fw-medium mb-0">Total Dokumen Terinput</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card text-warning">
                <div class="icon-box bg-warning bg-opacity-10">
                    <i class="bi bi-clock-history"></i>
                </div>
                <h2 class="fw-bold mb-1 text-dark">{{ \App\Models\Document::where('status', 'Pending')->count() }}</h2>
                <p class="text-muted fw-medium mb-0">Permintaan Validasi</p>
            </div>
        </div>
    </div>

    <div class="welcome-banner mt-5">
        <div class="row align-items-center">
            <div class="col-auto">
                <div class="welcome-icon">
                    <i class="bi bi-lightning-charge-fill"></i>
                </div>
            </div>
            <div class="col">
                <h4 class="fw-bold text-dark mb-2">Siap untuk mulai bekerja?</h4>
                <p class="text-muted mb-0 pe-md-5">Anda memiliki <span class="text-primary fw-bold">{{ \App\Models\Document::where('status', 'Pending')->count() }} dokumen</span> yang memerlukan tinjauan hari ini. Klik menu <strong>Validasi Dokumen</strong> untuk memprosesnya sekarang.</p>
            </div>
            <div class="col-md-auto mt-3 mt-md-0">
                <a href="{{ url('/admin/validasi-dokumen') }}" class="btn btn-primary px-4 py-2 rounded-3 shadow-sm fw-bold">
                    Proses Sekarang <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>