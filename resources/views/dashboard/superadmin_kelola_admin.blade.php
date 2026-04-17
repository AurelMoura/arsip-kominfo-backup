<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Admin - Arsip Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-color: #1e3a5f;
            --primary-blue: #4361ee;
            --accent-color: #4cc9f0;
            --bg-body: #f8fafc;
            --card-border: rgba(226, 232, 240, 0.6);
        }

        body {
            background-color: var(--bg-body);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1e293b;
            margin: 0;
            overflow-x: hidden;
        }

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

        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            padding: 40px;
        }

        .glass-card {
            background: #ffffff;
            border: 1px solid var(--card-border);
            box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
            border-radius: 24px;
            overflow: hidden;
        }

        .subtable th {
            background: #f8fafc;
            text-transform: uppercase;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            padding: 18px;
            color: #64748b;
        }

        .subtable td {
            padding: 16px 18px;
            vertical-align: middle;
        }

        .avatar-sm {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 800;
            color: white;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
        }

        .badge-role {
            padding: 5px 14px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); }
            .main-content { margin-left: 0; padding: 20px; }
        }
    </style>
</head>
<body>

@include('components.sidebar')

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Kelola Admin</h3>
            <p class="text-muted mb-0">Daftar semua akun administrator sistem.</p>
        </div>
        <a href="{{ url('/superadmin/tambah-admin') }}" class="btn btn-primary px-4 rounded-3 shadow-sm fw-bold">
            <i class="bi bi-person-plus-fill me-2"></i> Tambah Admin
        </a>
    </div>

    <div class="glass-card">
        <div class="table-responsive">
            <table class="table subtable mb-0 align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Admin</th>
                        <th>NIP</th>
                        <th>Role</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admins as $index => $admin)
                    <tr>
                        <td class="fw-bold text-muted">{{ $index + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-sm">{{ strtoupper(substr($admin->name, 0, 1)) }}</div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $admin->name }}</div>
                                    <small class="text-muted">ID: {{ $admin->id }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="fw-semibold">{{ $admin->pegawai_id ?? '-' }}</td>
                        <td>
                            <span class="badge-role {{ $admin->role === 'superadmin' ? 'bg-warning bg-opacity-10 text-warning' : 'bg-primary bg-opacity-10 text-primary' }}">
                                {{ $admin->role === 'superadmin' ? 'Super Admin' : 'Admin' }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($admin->role !== 'superadmin')
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-sm btn-outline-primary rounded-3 px-3" data-bs-toggle="modal" data-bs-target="#modalUbahPassword{{ $admin->id }}">
                                    <i class="bi bi-key me-1"></i> Ubah Password
                                </button>
                                <button class="btn btn-sm btn-outline-danger rounded-3 px-3" data-bs-toggle="modal" data-bs-target="#modalHapus{{ $admin->id }}">
                                    <i class="bi bi-trash me-1"></i> Hapus
                                </button>
                            </div>
                            @else
                            <span class="text-muted small">-</span>
                            @endif
                        </td>
                    </tr>

                    {{-- Modal Ubah Password --}}
                    @if($admin->role !== 'superadmin')
                    <div class="modal fade" id="modalUbahPassword{{ $admin->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 rounded-4 shadow-lg">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-bold"><i class="bi bi-key-fill text-primary me-2"></i> Ubah Password</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ url('/superadmin/admin/'.$admin->id.'/ubah-password') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <p class="text-muted mb-3">Ubah password untuk <strong>{{ $admin->name }}</strong></p>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-secondary text-uppercase small">Password Baru</label>
                                            <input type="password" name="password" class="form-control rounded-3" placeholder="Min. 6 karakter" required minlength="6">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-secondary text-uppercase small">Konfirmasi Password</label>
                                            <input type="password" name="password_confirmation" class="form-control rounded-3" placeholder="Ulangi password" required minlength="6">
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0 pt-0">
                                        <button type="button" class="btn btn-light rounded-3 fw-bold" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary rounded-3 fw-bold px-4">
                                            <i class="bi bi-check-lg me-1"></i> Simpan Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Hapus Admin --}}
                    <div class="modal fade" id="modalHapus{{ $admin->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 rounded-4 shadow-lg">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-bold"><i class="bi bi-exclamation-triangle-fill text-danger me-2"></i> Hapus Admin</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah Anda yakin ingin menghapus akun admin <strong>{{ $admin->name }}</strong>?</p>
                                    <p class="text-danger small mb-0"><i class="bi bi-info-circle me-1"></i> Tindakan ini tidak dapat dibatalkan.</p>
                                </div>
                                <div class="modal-footer border-0 pt-0">
                                    <button type="button" class="btn btn-light rounded-3 fw-bold" data-bs-dismiss="modal">Batal</button>
                                    <form action="{{ url('/superadmin/admin/'.$admin->id.'/hapus') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger rounded-3 fw-bold px-4">
                                            <i class="bi bi-trash me-1"></i> Ya, Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-people fs-1 d-block mb-2 opacity-25"></i>
                            Belum ada data admin.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
