@extends('layouts.app')

@section('title', 'Master Data Unit Kerja - Arsip Digital')

@push('styles')
<style>
    .card-modern {
        border: none;
        border-radius: 20px;
        transition: all 0.3s ease;
        background: #ffffff;
        position: relative;
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
        cursor: pointer;
        display: inline-block;
    }
    .asn-count-badge:hover {
        background: #2563eb;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }
</style>
@endpush

@section('content')
<div class="main-content p-4">
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
            </div>
        </div>
        <div class="card-body p-0 mt-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
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
                        @foreach($unitKerjas as $i => $uk)
                        <tr>
                            <td class="ps-4 text-muted fw-medium">{{ $i+1 }}</td>
                            <td>
                                <span class="fw-bold text-dark">{{ $uk->name }}</span>
                            </td>
                            <td class="text-center">
                                <a href="#" class="asn-count-badge" onclick="showAsnList({{ $uk->id }}, '{{ addslashes($uk->name) }}')">
                                    {{ $uk->asn_count ?? 0 }} ASN
                                </a>
                            </td>
                            @if(session('role') == 'superadmin')
                            <td class="text-center pe-4">
                                <button class="btn btn-sm btn-warning" onclick="editUnitKerja({{ $uk->id }}, '{{ addslashes($uk->name) }}')"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-sm btn-danger" onclick="deleteUnitKerja({{ $uk->id }})"><i class="bi bi-trash"></i></button>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah/Edit Unit Kerja -->
<div class="modal fade" id="modalTambahUnitKerja" tabindex="-1" aria-labelledby="modalTambahUnitKerjaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formUnitKerja">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahUnitKerjaLabel">Tambah Unit Kerja</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="unitKerjaId">
          <div class="mb-3">
            <label for="unitKerjaName" class="form-label">Nama Unit Kerja</label>
            <input type="text" class="form-control" id="unitKerjaName" name="name" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-gradient-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal ASN List -->
<div class="modal fade" id="modalAsnList" tabindex="-1" aria-labelledby="modalAsnListLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAsnListLabel">Daftar ASN</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div id="asnListContent">Memuat...</div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
function showAsnList(unitKerjaId, unitKerjaName) {
    const modal = new bootstrap.Modal(document.getElementById('modalAsnList'));
    document.getElementById('modalAsnListLabel').textContent = 'Daftar ASN - ' + unitKerjaName;
    const content = document.getElementById('asnListContent');
    content.innerHTML = 'Memuat...';
    fetch(`/master/unitkerja/${unitKerjaId}/asn`)
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                if (data.data.length === 0) {
                    content.innerHTML = '<div class="text-muted">Tidak ada ASN pada unit kerja ini.</div>';
                } else {
                    let html = '<ul class="list-group">';
                    data.data.forEach(asn => {
                        html += `<li class='list-group-item'>${asn.name} (${asn.email})</li>`;
                    });
                    html += '</ul>';
                    content.innerHTML = html;
                }
            } else {
                content.innerHTML = '<div class="text-danger">Gagal memuat data ASN.</div>';
            }
        })
        .catch(() => content.innerHTML = '<div class="text-danger">Gagal memuat data ASN.</div>');
    modal.show();
}

function editUnitKerja(id, name) {
    document.getElementById('unitKerjaId').value = id;
    document.getElementById('unitKerjaName').value = name;
    document.getElementById('modalTambahUnitKerjaLabel').textContent = 'Edit Unit Kerja';
    new bootstrap.Modal(document.getElementById('modalTambahUnitKerja')).show();
}

function deleteUnitKerja(id) {
    if (!confirm('Yakin ingin menghapus unit kerja ini?')) return;
    fetch(`/master/unitkerja/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            showToast('Unit kerja berhasil dihapus', 'success');
            location.reload();
        } else {
            showToast('Gagal menghapus unit kerja', 'error');
        }
    })
    .catch(() => showToast('Gagal menghapus unit kerja', 'error'));
}

// Tambah/Edit submit
const form = document.getElementById('formUnitKerja');
form.addEventListener('submit', function(e) {
    e.preventDefault();
    const id = form.unitKerjaId.value;
    const name = form.unitKerjaName.value;
    const url = id ? `/master/unitkerja/${id}` : '/master/unitkerja';
    const method = id ? 'PUT' : 'POST';
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': form.querySelector('[name="_token"]').value
        },
        body: JSON.stringify({ name })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            showToast('Unit kerja berhasil disimpan', 'success');
            location.reload();
        } else {
            showToast('Gagal menyimpan unit kerja', 'error');
        }
    })
    .catch(() => showToast('Gagal menyimpan unit kerja', 'error'));
});
</script>
@endpush
