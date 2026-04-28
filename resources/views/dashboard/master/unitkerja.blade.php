@extends('layouts.app')

@section('title', 'Master Data Unit Kerja - Arsip Digital')

@push('styles')
<style>
    /* Custom Styles Modern - Disamakan dengan halaman Agama */
    .card-modern {
        border: none;
        border-radius: 20px;
        transition: all 0.3s ease;
        background: #ffffff;
        position: relative;
    }
    
    .card-modern:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.05) !important;
    }

    .btn-gradient-primary {
        background: linear-gradient(45deg, #4e73df, #224abe);
        border: none;
        color: white;
        transition: all 0.3s;
    }
    .btn-gradient-primary:hover {
        filter: brightness(1.1);
        transform: scale(1.05);
        color: white;
    }

    .table thead th {
        background-color: #f8fafc;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        color: #64748b;
        border: none;
    }

    .avatar-circle {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    .asn-count-badge {
        background: #eff6ff;
        color: #2563eb;
        padding: 6px 14px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 13px;
        text-decoration: none;
        transition: all 0.2s;
        border: 1px solid #dbeafe;
    }
    .asn-count-badge:hover {
        background: #2563eb;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }

    /* Modal Detail ASN (disamakan dengan halaman Agama) */
    .modal-detail-header {
        background: linear-gradient(135deg, #4e73df, #224abe);
        color: white;
        border-radius: 16px 16px 0 0 !important;
    }
    .modal-detail-header .btn-close {
        filter: invert(1);
    }
    .asn-list-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 8px;
        border-bottom: 1px solid #f1f5f9;
        border-radius: 10px;
        transition: background 0.15s;
        text-decoration: none;
        color: inherit;
    }
    .asn-list-item:last-child { border-bottom: none; }
    .asn-list-item:hover {
        background: #f0f4ff;
        text-decoration: none;
        color: inherit;
    }
    .asn-list-item:hover .asn-drh-btn { opacity: 1; transform: translateX(0); }

    .asn-detail-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 13px;
        color: #4e73df;
        flex-shrink: 0;
        transition: transform 0.2s;
    }
    .asn-list-item:hover .asn-detail-avatar { transform: scale(1.1); }

    .asn-drh-btn {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #4e73df;
        color: white;
        border-radius: 8px;
        padding: 4px 10px;
        font-size: 11px;
        font-weight: 700;
        opacity: 0;
        transform: translateX(4px);
        transition: all 0.2s;
        flex-shrink: 0;
        text-decoration: none;
    }
</style>
@endpush

@section('content')

<div class="mb-5">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h3 class="fw-extrabold mb-1 text-dark">Master Data Unit Kerja</h3>
            <p class="text-muted mb-0">Kelola data unit kerja untuk ASN.</p>
        </div>
        @if(session('role') == 'superadmin')
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <button class="btn btn-gradient-primary shadow rounded-pill px-4 py-2" data-bs-toggle="modal" data-bs-target="#modalTambahUnitKerja">
                <i class="bi bi-plus-circle-fill me-2"></i> Tambah Unit Kerja
            </button>
        </div>
        @endif
    </div>
</div>

<div class="card card-modern shadow-sm border-0 mb-4">
    <div class="card-header bg-transparent border-0 pt-4 px-4">
        <div class="row align-items-center g-3">
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-primary bg-opacity-10 p-2 rounded-3 me-3 text-primary">
                        <i class="bi bi-building"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Referensi Unit Kerja</h5>
                        <small class="text-muted">{{ $unitKerjas->count() }} unit kerja terdaftar</small>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="search-wrapper position-relative">
                    <i class="bi bi-search position-absolute text-muted" style="left: 15px; top: 50%; transform: translateY(-50%);"></i>
                    <input type="text" id="searchMainUnit" class="form-control rounded-pill ps-5 bg-light border-0" placeholder="Cari nama unit kerja...">
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-body p-0 mt-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="tabelUnitKerja">
                <thead>
                    <tr>
                        <th class="ps-4" style="width:50px;">No</th>
                        <th>Nama Unit Kerja</th>
                        <th class="text-center">ASN</th>
                        @if(session('role') == 'superadmin')
                        <th class="text-center pe-4">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($unitKerjas as $i => $uk)
                    <tr>
                        <td class="ps-4 text-muted fw-medium">{{ $i+1 }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle me-3 text-uppercase" style="background: #eef2ff; color: #4e73df; font-size: 12px;">
                                    {{ substr($uk->name, 0, 1) }}
                                </div>
                                <span class="fw-bold text-dark">{{ $uk->name }}</span>
                            </div>
                        </td>
                        <td class="text-center">
                            <a href="{{ url('/master/unitkerja/'.$uk->id.'/asn-detail') }}" class="asn-count-badge">
                                {{ $uk->asn_count ?? 0 }}
                            </a>
                        </td>
                        @if(session('role') == 'superadmin')
                        <td class="text-center pe-4">
                            <button class="btn btn-sm btn-outline-warning rounded-circle me-2" style="width: 32px; height: 32px; padding: 0;" onclick="editUnitKerja({{ $uk->id }}, '{{ addslashes($uk->name) }}')" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger rounded-circle" style="width: 32px; height: 32px; padding: 0;" onclick="deleteUnitKerja({{ $uk->id }})" title="Hapus">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ session('role') == 'superadmin' ? 4 : 3 }}" class="text-center py-5 text-muted">Belum ada data unit kerja.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Tambah/Edit Unit Kerja --}}
<div class="modal fade" id="modalTambahUnitKerja" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-bold text-dark mb-0" id="modalTambahUnitKerjaLabel">Tambah Unit Kerja</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formUnitKerja">
                @csrf
                <div class="modal-body px-4">
                    <input type="hidden" name="id" id="unitKerjaId">
                    <div class="mb-3">
                        <label for="unitKerjaName" class="form-label fw-semibold small">Nama Unit Kerja</label>
                        <input type="text" class="form-control form-control-lg rounded-3 fs-6" id="unitKerjaName" name="name" required placeholder="Contoh: Bidang E-Government">
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-gradient-primary rounded-pill px-4">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal ASN List --}}
<div class="modal fade" id="modalAsnList" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header modal-detail-header border-0 px-4 pt-4 pb-3">
                <div>
                    <h5 class="fw-bold mb-1" id="modalAsnListLabel">Daftar ASN</h5>
                    <small class="opacity-75" id="modalAsnListCountLabel">0 pegawai terdaftar</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 py-3" style="max-height: 420px; overflow-y: auto;">
                <div id="asnListContent">Memuat...</div>
            </div>
            <div class="modal-footer border-0 pb-3 px-4">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
const unitKerjaCsrfToken = document.querySelector('input[name="_token"]')?.value || document.querySelector('meta[name="csrf-token"]')?.content;

// Fungsi Search Sederhana
document.getElementById('searchMainUnit').addEventListener('keyup', function() {
    let value = this.value.toLowerCase();
    let rows = document.querySelectorAll('#tabelUnitKerja tbody tr');
    rows.forEach(row => {
        row.style.display = (row.innerText.toLowerCase().indexOf(value) > -1) ? "" : "none";
    });
});

function showAsnList(event, unitKerjaId, unitKerjaName) {
    event.preventDefault();

    const modalElement = document.getElementById('modalAsnList');
    const modal = new bootstrap.Modal(modalElement);
    document.getElementById('modalAsnListLabel').innerHTML = `<i class="bi bi-people-fill me-2"></i>Daftar ASN — ${unitKerjaName}`;
    document.getElementById('modalAsnListCountLabel').textContent = 'Memuat data...';
    const content = document.getElementById('asnListContent');
    content.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div><p class="mt-2 small text-muted">Memuat data...</p></div>';
    
    fetch(`/master/unitkerja/${unitKerjaId}/asn`)
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                if (data.data.length === 0) {
                    document.getElementById('modalAsnListCountLabel').textContent = '0 pegawai terdaftar';
                    content.innerHTML = '<div class="text-center py-4 text-muted"><i class="bi bi-person-x display-4 text-light"></i><p class="mt-2 small">Tidak ada ASN pada unit kerja ini.</p></div>';
                } else {
                    document.getElementById('modalAsnListCountLabel').textContent = `${data.data.length} pegawai terdaftar`;
                    let html = '';

                    data.data.forEach(asn => {
                        const nama = asn.nama ?? '-';
                        const nip = asn.nip ?? '-';
                        const initial = (nama || '--').substring(0, 2).toUpperCase();
                        const drhButton = asn.drh_url
                            ? `<span class="asn-drh-btn"><i class="bi bi-file-person-fill"></i> DRH</span>`
                            : '<span class="text-muted small">DRH tidak tersedia</span>';

                        const wrapperStart = asn.drh_url
                            ? `<a href="${asn.drh_url}" target="_blank" class="asn-list-item">`
                            : '<div class="asn-list-item">';

                        const wrapperEnd = asn.drh_url ? '</a>' : '</div>';

                        html += `
                        ${wrapperStart}
                            <div class="asn-detail-avatar">${initial}</div>
                            <div class="flex-grow-1">
                                <div class="fw-bold text-dark small">${nama}</div>
                                <div class="text-muted" style="font-size:11px;">NIP: ${nip}</div>
                            </div>
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2 small fw-semibold me-2">
                                ${unitKerjaName}
                            </span>
                            ${drhButton}
                        ${wrapperEnd}`;
                    });
                    content.innerHTML = html;
                }
            } else {
                document.getElementById('modalAsnListCountLabel').textContent = 'Gagal memuat data';
                content.innerHTML = '<div class="text-danger">Gagal memuat data ASN.</div>';
                showToast(data.message || 'Gagal memuat data ASN.', 'error');
            }
        })
        .catch(() => {
            document.getElementById('modalAsnListCountLabel').textContent = 'Gagal memuat data';
            content.innerHTML = '<div class="text-danger">Gagal memuat data ASN.</div>';
            showToast('Gagal memuat data ASN.', 'error');
        });

    modal.show();
}

function editUnitKerja(id, name) {
    document.getElementById('unitKerjaId').value = id;
    document.getElementById('unitKerjaName').value = name;
    document.getElementById('modalTambahUnitKerjaLabel').textContent = 'Edit Unit Kerja';
    const modal = new bootstrap.Modal(document.getElementById('modalTambahUnitKerja'));
    modal.show();
}

function deleteUnitKerja(id) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: 'Data unit kerja yang dihapus tidak bisa dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d32f2f',
        cancelButtonColor: '#757575',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    })
    .then((result) => {
        if (!result.isConfirmed) {
            return;
        }

        showToast('Menghapus data...', 'warning');

        fetch(`/master/unitkerja/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': unitKerjaCsrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(async (res) => {
            const data = await res.json();
            return { ok: res.ok, data };
        })
        .then(({ ok, data }) => {
            if (ok && data.status === 'success') {
                showToast(data.message || 'Data berhasil dihapus.', 'success');
                setTimeout(() => location.reload(), 500);
                return;
            }

            showToast(data.message || 'Gagal menghapus data.', 'error');
        })
        .catch(() => {
            showToast('Terjadi kesalahan saat menghapus data.', 'error');
        });
    });
}

const form = document.getElementById('formUnitKerja');
form.addEventListener('submit', function(e) {
    e.preventDefault();
    const id = document.getElementById('unitKerjaId').value;
    const name = document.getElementById('unitKerjaName').value;
    const url = id ? `/master/unitkerja/${id}` : '/master/unitkerja';
    const method = id ? 'PUT' : 'POST';
    
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': unitKerjaCsrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ name })
    })
    .then(async (res) => {
        const data = await res.json();
        return { ok: res.ok, data };
    })
    .then(({ ok, data }) => {
        if (ok && data.status === 'success') {
            showToast(data.message || 'Data berhasil disimpan.', 'success');
            setTimeout(() => location.reload(), 500);
            return;
        }

        showToast(data.message || 'Gagal menyimpan data.', 'error');
    })
    .catch(() => {
        showToast('Terjadi kesalahan saat menyimpan data.', 'error');
    });
});
</script>
@endpush
