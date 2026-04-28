@extends('layouts.app')

@section('title', 'Aktivitas Pengguna - Superadmin')

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

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
        }

        .stat-label {
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 600;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 800;
            color: var(--primary-blue);
            margin-top: 8px;
        }

        .stat-value .stat-loading {
            display: inline-block;
            width: 60px;
            height: 28px;
            background: linear-gradient(90deg, #e2e8f0 25%, #f1f5f9 50%, #e2e8f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
            border-radius: 6px;
        }

        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
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

        /* ===== Loading Skeleton ===== */
        .skeleton-row td {
            padding: 14px 16px;
            border-bottom: 1px solid #e2e8f0;
        }

        .skeleton-bar {
            height: 14px;
            background: linear-gradient(90deg, #e2e8f0 25%, #f1f5f9 50%, #e2e8f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
            border-radius: 4px;
        }

        .skeleton-bar.w-70 { width: 70%; }
        .skeleton-bar.w-50 { width: 50%; }
        .skeleton-bar.w-40 { width: 40%; }
        .skeleton-bar.w-30 { width: 30%; }
        .skeleton-bar.w-60 { width: 60%; }

        /* ===== DataTable Controls ===== */
        .dt-controls {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px 14px;
            flex-wrap: wrap;
            gap: 10px;
            border-bottom: 1px solid #e2e8f0;
        }

        .dt-length-select {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #64748b;
        }

        .dt-length-select select {
            padding: 5px 10px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 13px;
            color: #1e293b;
            background: white;
            cursor: pointer;
            outline: none;
            transition: border-color 0.15s;
        }

        .dt-length-select select:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(58, 134, 255, 0.1);
        }

        .dt-search {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #64748b;
        }

        .dt-search input {
            padding: 6px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 13px;
            color: #1e293b;
            outline: none;
            min-width: 200px;
            transition: border-color 0.15s;
        }

        .dt-search input:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(58, 134, 255, 0.1);
        }

        .dt-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            flex-wrap: wrap;
            gap: 10px;
            border-top: 1px solid #e2e8f0;
        }

        .dt-info {
            font-size: 13px;
            color: #64748b;
        }

        .dt-pagination {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .dt-page-btn {
            min-width: 34px;
            height: 34px;
            border: 1px solid #e2e8f0;
            background: white;
            border-radius: 8px;
            font-size: 13px;
            color: #64748b;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 10px;
            transition: all 0.15s;
            font-weight: 500;
        }

        .dt-page-btn:hover:not(:disabled) {
            background: #eff6ff;
            border-color: var(--primary-blue);
            color: var(--primary-blue);
        }

        .dt-page-btn.active {
            background: var(--primary-blue);
            border-color: var(--primary-blue);
            color: white;
            font-weight: 700;
        }

        .dt-page-btn:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .dt-page-ellipsis {
            font-size: 13px;
            color: #94a3b8;
            padding: 0 4px;
        }

        @media (max-width: 1200px) {
            .activity-table th,
            .activity-table td {
                padding: 12px 10px;
                font-size: 12px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .dt-controls,
            .dt-footer {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
@endpush

@section('content')

<div class="main-content">
    <div class="mb-5">
        <div class="page-header-label">System Monitoring</div>
        <h1 class="fw-bold text-dark" style="letter-spacing: -1px;">Aktivitas Login Sistem</h1>
        <p class="text-muted small">Monitor semua aktivitas login admin, superadmin, dan pengguna di seluruh sistem</p>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total Login</div>
            <div class="stat-value" id="stat-total-login"><span class="stat-loading"></span></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Pengguna Aktif</div>
            <div class="stat-value" id="stat-unique-users"><span class="stat-loading"></span></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">IP Address Unik</div>
            <div class="stat-value" id="stat-unique-ips"><span class="stat-loading"></span></div>
        </div>
    </div>

    <div class="section-card shadow-sm">
        <div class="section-header">
            <i class="bi bi-clock-history" style="font-size: 20px;"></i>
            <h3>Riwayat Login Sistem</h3>
        </div>

        {{-- Top Controls: Show entries + Search --}}
        <div class="dt-controls">
            <div class="dt-length-select">
                Tampilkan
                <select id="dt-per-page">
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                entri
            </div>
            <div class="dt-search">
                Cari:
                <input type="text" id="dt-search-input" placeholder="Nama, IP, Browser...">
            </div>
        </div>

        {{-- Table --}}
        <div style="overflow-x: auto;">
            <table class="activity-table" id="activity-table">
                <thead>
                    <tr>
                        <th style="width: 18%;">Pengguna</th>
                        <th style="width: 12%;">IP Address</th>
                        <th style="width: 14%;">Browser</th>
                        <th style="width: 14%;">Sistem Operasi</th>
                        <th style="width: 18%;">Last Password Change</th>
                        <th style="width: 12%;">Password Changes</th>
                        <th style="width: 22%;">Waktu & Tanggal</th>
                    </tr>
                </thead>
                <tbody id="dt-tbody">
                    {{-- Data will be loaded via AJAX --}}
                </tbody>
            </table>
        </div>

        {{-- Empty state --}}
        <div id="dt-empty" class="empty-state" style="display: none;">
            <i class="bi bi-inbox"></i>
            <p id="dt-empty-text">Belum ada data aktivitas login</p>
        </div>

        {{-- Bottom: Info + Pagination --}}
        <div class="dt-footer" id="dt-footer">
            <div class="dt-info" id="dt-info"></div>
            <div class="dt-pagination" id="dt-pagination"></div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
(function () {
    const DATA_URL  = "{{ route('superadmin.user-activity.data') }}";
    const STATS_URL = "{{ route('superadmin.user-activity.stats') }}";

    const tbody        = document.getElementById('dt-tbody');
    const infoEl       = document.getElementById('dt-info');
    const paginationEl = document.getElementById('dt-pagination');
    const perPageEl    = document.getElementById('dt-per-page');
    const searchInput  = document.getElementById('dt-search-input');
    const emptyEl      = document.getElementById('dt-empty');
    const emptyText    = document.getElementById('dt-empty-text');
    const tableEl      = document.getElementById('activity-table');
    const footerEl     = document.getElementById('dt-footer');

    let currentPage = 1;
    let perPage     = 10;
    let searchQuery = '';
    let searchTimer = null;
    let isLoading   = false;

    // ── Stats (one-time load) ──────────────────────────
    function loadStats() {
        fetch(STATS_URL, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.json())
            .then(data => {
                document.getElementById('stat-total-login').textContent  = data.total_login.toLocaleString('id-ID');
                document.getElementById('stat-unique-users').textContent = data.unique_users.toLocaleString('id-ID');
                document.getElementById('stat-unique-ips').textContent   = data.unique_ips.toLocaleString('id-ID');
            })
            .catch(() => {
                document.getElementById('stat-total-login').textContent  = '-';
                document.getElementById('stat-unique-users').textContent = '-';
                document.getElementById('stat-unique-ips').textContent   = '-';
            });
    }

    // ── Skeleton loader ────────────────────────────────
    function showSkeleton() {
        let html = '';
        for (let i = 0; i < perPage; i++) {
            html += `<tr class="skeleton-row">
                <td><div class="skeleton-bar w-70" style="margin-bottom:4px"></div><div class="skeleton-bar w-40"></div></td>
                <td><div class="skeleton-bar w-60"></div></td>
                <td><div class="skeleton-bar w-50"></div></td>
                <td><div class="skeleton-bar w-50"></div></td>
                <td><div class="skeleton-bar w-60"></div></td>
                <td><div class="skeleton-bar w-30"></div></td>
                <td><div class="skeleton-bar w-70" style="margin-bottom:4px"></div><div class="skeleton-bar w-40"></div></td>
            </tr>`;
        }
        tbody.innerHTML = html;
        tableEl.style.display  = '';
        emptyEl.style.display  = 'none';
        footerEl.style.display = 'none';
    }

    // ── Fetch data from server ─────────────────────────
    function fetchData() {
        if (isLoading) return;
        isLoading = true;
        showSkeleton();

        const params = new URLSearchParams({
            page: currentPage,
            per_page: perPage,
            search: searchQuery,
        });

        fetch(`${DATA_URL}?${params}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.json())
            .then(data => {
                isLoading = false;
                renderRows(data.data);
                renderInfo(data);
                renderPagination(data.total_pages, data.page);

                const isEmpty = data.data.length === 0;
                tableEl.style.display  = isEmpty ? 'none' : '';
                emptyEl.style.display  = isEmpty ? 'block' : 'none';
                footerEl.style.display = isEmpty ? 'none' : 'flex';

                if (isEmpty) {
                    emptyText.textContent = searchQuery
                        ? 'Tidak ada data yang cocok dengan pencarian'
                        : 'Belum ada data aktivitas login';
                    emptyEl.querySelector('i').className = searchQuery ? 'bi bi-search' : 'bi bi-inbox';
                }
            })
            .catch(() => {
                isLoading = false;
                tbody.innerHTML = '';
                tableEl.style.display  = 'none';
                emptyEl.style.display  = 'block';
                emptyText.textContent  = 'Gagal memuat data, coba refresh halaman';
                footerEl.style.display = 'none';
            });
    }

    // ── Render table rows ──────────────────────────────
    function renderRows(rows) {
        let html = '';
        rows.forEach(a => {
            html += `<tr>
                <td>
                    <div class="user-info">
                        <span class="user-name">${escHtml(a.user_name)}</span>
                        <span class="user-nip">${escHtml(a.pegawai_id)}</span>
                    </div>
                </td>
                <td><span class="ip-address">${escHtml(a.ip_address)}</span></td>
                <td><span class="badge-device">${escHtml(a.browser)}</span></td>
                <td><span class="badge-system">${escHtml(a.os)}</span></td>
                <td><div class="time-info">${escHtml(a.last_password_change)}</div></td>
                <td><span class="badge-device" style="background:#fef3c7;color:#92400e;">${a.password_change_count}x</span></td>
                <td>
                    <div class="time-info">
                        <div><strong>${escHtml(a.login_date)}</strong></div>
                        <div>${escHtml(a.login_time)}</div>
                    </div>
                </td>
            </tr>`;
        });
        tbody.innerHTML = html;
    }

    // ── Render info text ───────────────────────────────
    function renderInfo(data) {
        const start = (data.page - 1) * data.per_page + 1;
        const end   = Math.min(data.page * data.per_page, data.total);
        let text    = `Menampilkan ${start} sampai ${end} dari ${data.total.toLocaleString('id-ID')} entri`;
        if (data.total < data.total_all) {
            text += ` (difilter dari ${data.total_all.toLocaleString('id-ID')} total entri)`;
        }
        infoEl.textContent = text;
    }

    // ── Render pagination ──────────────────────────────
    function renderPagination(totalPages, page) {
        paginationEl.innerHTML = '';

        function makeBtn(label, targetPage, disabled, active) {
            const btn = document.createElement('button');
            btn.className = 'dt-page-btn' + (active ? ' active' : '');
            btn.innerHTML = label;
            btn.disabled  = disabled;
            if (!disabled && !active) {
                btn.addEventListener('click', () => {
                    currentPage = targetPage;
                    fetchData();
                    tableEl.closest('.section-card').scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            }
            return btn;
        }

        function makeEllipsis() {
            const span = document.createElement('span');
            span.className   = 'dt-page-ellipsis';
            span.textContent = '…';
            return span;
        }

        // Previous
        paginationEl.appendChild(makeBtn('&#8249;', page - 1, page === 1, false));

        // Page numbers
        let pages = [];
        if (totalPages <= 7) {
            for (let i = 1; i <= totalPages; i++) pages.push(i);
        } else {
            pages.push(1);
            if (page > 3) pages.push('...');
            for (let i = Math.max(2, page - 1); i <= Math.min(totalPages - 1, page + 1); i++) {
                pages.push(i);
            }
            if (page < totalPages - 2) pages.push('...');
            pages.push(totalPages);
        }

        pages.forEach(p => {
            if (p === '...') {
                paginationEl.appendChild(makeEllipsis());
            } else {
                paginationEl.appendChild(makeBtn(p, p, false, p === page));
            }
        });

        // Next
        paginationEl.appendChild(makeBtn('&#8250;', page + 1, page === totalPages, false));
    }

    // ── Utility: escape HTML ───────────────────────────
    function escHtml(str) {
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    // ── Events ─────────────────────────────────────────
    perPageEl.addEventListener('change', () => {
        perPage     = parseInt(perPageEl.value);
        currentPage = 1;
        fetchData();
    });

    // Debounced search (300ms)
    searchInput.addEventListener('input', () => {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => {
            searchQuery = searchInput.value.trim();
            currentPage = 1;
            fetchData();
        }, 300);
    });

    // ── Init ───────────────────────────────────────────
    loadStats();
    fetchData();
})();
</script>
@endpush