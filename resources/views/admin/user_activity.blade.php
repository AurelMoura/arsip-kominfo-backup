@extends('layouts.app')

@section('title', 'Aktivitas Pengguna - Admin')

@push('styles')
    <style>
        :root {
            --sidebar-color: #1e3a5f;
            --primary-blue: #3a86ff;
            --light-blue: #eff6ff;
            --border-blue: #dbeafe;
        }

        body {
            background: #eef3fb;
            font-family: 'Inter', sans-serif;
            margin: 0;
        }

        .main-content {
            padding: 40px;
            min-height: 100vh;
        }

        .page-header-label {
            color: var(--primary-blue);
            font-weight: 700;
            font-size: 12px;
            letter-spacing: 1px;
            text-transform: uppercase;
            border-left: 3px solid var(--primary-blue);
            padding-left: 10px;
            margin-bottom: 10px;
        }

        .section-card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 10px 28px rgba(15, 23, 42, 0.08);
            background: white;
            margin-bottom: 20px;
        }

        .section-header {
            background: linear-gradient(90deg, var(--primary-blue), #2563eb);
            color: white;
            padding: 20px 25px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .section-header h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
        }

        .activity-table {
            width: 100%;
            border-collapse: collapse;
        }

        .activity-table th {
            background: #f8fafc;
            padding: 16px;
            text-align: left;
            font-weight: 700;
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 2px solid #e2e8f0;
        }

        .activity-table td {
            padding: 14px 16px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13px;
        }

        .activity-table tbody tr:hover {
            background: #f8fafc;
        }

        .user-info {
            font-weight: 600;
            color: #1e293b;
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .user-name {
            font-weight: 700;
            color: var(--primary-blue);
        }

        .user-nip {
            font-size: 11px;
            color: #64748b;
        }

        .badge-device {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            background: #eff6ff;
            color: var(--primary-blue);
        }

        .badge-system {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            background: #f0fdf4;
            color: #15803d;
            margin-right: 6px;
        }

        .ip-address {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            font-weight: 600;
            color: #64748b;
            background: #f1f5f9;
            padding: 2px 6px;
            border-radius: 4px;
        }

        .time-info {
            font-size: 12px;
            color: #64748b;
            line-height: 1.6;
        }

        .status-online {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #10b981;
            margin-right: 6px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 40px;
            color: #94a3b8;
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        @media (max-width: 1200px) {
            .activity-table th,
            .activity-table td {
                padding: 12px 10px;
                font-size: 12px;
            }
        }
    </style>
@endpush

@section('content')

<div class="main-content">
    <div class="mb-5">
        <div class="page-header-label">User Management</div>
        <h1 class="fw-bold text-dark" style="letter-spacing: -1px;">Aktivitas Login Pengguna</h1>
        <p class="text-muted small">Pantau semua aktivitas login admin dan pengguna sistem</p>
    </div>

    <div class="section-card shadow-sm">
        <div class="section-header">
            <i class="bi bi-clock-history" style="font-size: 20px;"></i>
            <h3>Riwayat Login Terbaru</h3>
        </div>

        <div style="padding: 20px;">
            @if($activities->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="activity-table">
                        <thead>
                            <tr>
                                <th style="width: 20%;">Pengguna</th>
                                <th style="width: 12%;">IP Address</th>
                                <th style="width: 15%;">Sistem Operasi</th>
                                <th style="width: 18%;">Last Password Change</th>
                                <th style="width: 15%;">Password Changes</th>
                                <th style="width: 20%;">Waktu & Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activities as $activity)
                                <tr>
                                    <td>
                                        <div class="user-info">
                                            <span class="user-name">{{ $activity['user_name'] }}</span>
                                            <span class="user-nip">NIP: {{ $activity['pegawai_id'] }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="ip-address">{{ $activity['ip_address'] }}</span>
                                    </td>
                                    <td>
                                        <span class="badge-system">{{ $activity['os'] }}</span>
                                    </td>
                                    <td>
                                        <div class="time-info">
                                            {{ $activity['last_password_change'] }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge-device" style="background: #fef3c7; color: #92400e;">{{ $activity['password_change_count'] }}x</span>
                                    </td>
                                    <td>
                                        <div class="time-info">
                                            <div><strong>{{ $activity['login_date'] }}</strong></div>
                                            <div>{{ $activity['login_time'] }}</div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <p>Belum ada data aktivitas login</p>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
