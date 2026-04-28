<div class="card section-card border-0 shadow-sm overflow-hidden" style="border-radius: 24px;">
    <div class="section-header d-flex align-items-center justify-content-between gap-3 p-4" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: white;">
        <div class="d-flex align-items-center gap-3">
            <div class="icon-box shadow-sm" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(4px); border-radius: 14px; width: 48px; height: 48px; display: grid; place-items: center;">
                <i class="bi bi-people-fill fs-4"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-0" style="letter-spacing: 0.5px;">B. Dokumen Keluarga @if($isLockedKeluarga ?? false)<span class="badge ms-2" style="background:rgba(255,255,255,0.2);font-size:11px;"><i class="bi bi-lock-fill me-1"></i>Terkunci</span>@endif</h5>
                <small class="opacity-75">Data Pasangan, Anak, Orang Tua Kandung, & Mertua</small>
            </div>
        </div>
        <div class="badge bg-white bg-opacity-20 rounded-pill px-3 py-2 text-uppercase" style="font-size: 10px; letter-spacing: 1px;">Step 2 of 8</div>
    </div>

    <div class="card-body p-4 p-lg-5 bg-white text-start">
        @php
            $statusKawin = $drhData?->status_kawin;
            $isMenikah   = $statusKawin === 'M';
            $isCerai     = in_array($statusKawin, ['CH', 'CM']);
            $pData       = $drhData?->data_keluarga['pasangan'] ?? [];
            $hasPasangan = !empty($pData['nama']);
            $otData      = $drhData?->data_keluarga['orang_tua'] ?? [];
            $otAyah      = $otData['ayah'] ?? [];
            $otIbu       = $otData['ibu'] ?? [];
            $orangtua    = [];
            if (!empty($otAyah['nama'])) $orangtua[] = array_merge(['hubungan' => 'Ayah Kandung'], $otAyah);
            if (!empty($otIbu['nama']))  $orangtua[] = array_merge(['hubungan' => 'Ibu Kandung'], $otIbu);
            $hasOrangTua = count($orangtua) > 0;
            $mData       = $drhData?->data_keluarga['mertua'] ?? [];
            $mAyah       = $mData['ayah'] ?? [];
            $mIbu        = $mData['ibu'] ?? [];
            $mertua      = [];
            if (!empty($mAyah['nama'])) $mertua[] = array_merge(['hubungan' => 'Ayah Mertua'], $mAyah);
            if (!empty($mIbu['nama']))  $mertua[] = array_merge(['hubungan' => 'Ibu Mertua'], $mIbu);
            $hasMertua   = count($mertua) > 0;
            $isLockedKeluarga = $isLockedKeluarga ?? ($drhData?->is_locked_keluarga ?? false);
        @endphp

        {{-- ===== DATA PASANGAN ===== --}}
        <div id="sectionPasangan" class="mb-5" style="display: {{ $isMenikah ? 'block' : 'none' }};">
            <div class="d-flex justify-content-between align-items-center mb-4 gap-2 flex-wrap">
                <h6 class="fw-bold text-primary d-flex align-items-center gap-2 mb-0">
                    <i class="bi bi-heart-fill text-danger"></i> Data Suami / Istri
                </h6>
                @if(!$hasPasangan && !$isLockedKeluarga)
                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm"
                    onclick="openModalKeluarga('pasangan', null)">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Pasangan
                </button>
                @endif
            </div>
            <div class="glass-table-wrap p-3 p-lg-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Nama Lengkap</th>
                                <th>NIK</th>
                                <th>Tempat, Tanggal Lahir</th>
                                <th>Pekerjaan</th>
                                <th>No. Akta Nikah</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($hasPasangan)
                            <tr>
                                <td class="fw-semibold">{{ $pData['nama'] ?? '-' }}</td>
                                <td>{{ $pData['nik'] ?? '-' }}</td>
                                <td>{{ ($pData['tempat_lahir'] ?? '-') }}, {{ !empty($pData['tanggal_lahir']) ? \Carbon\Carbon::parse($pData['tanggal_lahir'])->format('d-m-Y') : '-' }}</td>
                                <td>{{ $pData['pekerjaan'] ?? '-' }}</td>
                                <td>{{ $pData['no_akta_nikah'] ?? '-' }}</td>
                                <td>{{ ($pData['status'] ?? '-') }} &bull; {{ ($pData['status_hidup'] ?? '-') }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" class="family-action-btn family-action-edit" title="Edit"
                                            onclick="openModalKeluarga('pasangan', this)"
                                            data-row='{{ json_encode(['id' => $pData['id'] ?? '', 'nik' => $pData['nik'] ?? '', 'nama' => $pData['nama'] ?? '', 'status' => $pData['status'] ?? '', 'status_hidup' => $pData['status_hidup'] ?? '', 'tempat_lahir' => $pData['tempat_lahir'] ?? '', 'tanggal_lahir' => !empty($pData['tanggal_lahir']) ? \Carbon\Carbon::parse($pData['tanggal_lahir'])->format('Y-m-d') : '', 'pekerjaan' => $pData['pekerjaan'] ?? '', 'no_akta_nikah' => $pData['no_akta_nikah'] ?? '']) }}'
                                            @disabled($isLockedKeluarga ?? false)
                                           >
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button type="button" class="family-action-btn family-action-delete" title="Hapus"
                                            onclick="deleteKeluarga('/profile/drh/keluarga/pasangan/{{ $pData['id'] ?? '' }}', this)"
                                            @disabled($isLockedKeluarga ?? false)
                                           >
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @else
                            <tr><td colspan="7" class="text-center text-muted py-4">Data belum diisi. Klik "Tambah Pasangan".</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ===== DATA ANAK ===== --}}
        <div id="sectionAnak" class="mb-5" style="display: {{ ($isMenikah || $isCerai) ? 'block' : 'none' }};">
            <div class="d-flex justify-content-between align-items-center mb-4 gap-2 flex-wrap">
                <h6 class="fw-bold text-primary d-flex align-items-center gap-2 mb-0">
                    <i class="bi bi-person-hearts"></i> Data Anak
                </h6>
                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm"
                    onclick="openModalKeluarga('anak', null)">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Anak
                </button>
            </div>
            <div class="glass-table-wrap p-3 p-lg-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="tblAnak">
                        <thead>
                            <tr>
                                <th>Nama Anak</th><th>NIK</th><th>Jenis Kelamin</th><th>Tempat Lahir</th><th>Tgl. Lahir</th><th>Pekerjaan</th><th>Status Kawin</th><th>Status Anak</th><th class="text-center">Akta</th><th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($anakRows as $anak)
                            <tr>
                                <td class="fw-bold text-dark">{{ $anak['nama'] ?? '-' }}</td>
                                <td class="text-muted small">{{ $anak['nik'] ?? '-' }}</td>
                                <td>{{ ($anak['jenis_kelamin'] ?? '') === 'L' ? 'Laki-laki' : (($anak['jenis_kelamin'] ?? '') === 'P' ? 'Perempuan' : '-') }}</td>
                                <td>{{ $anak['tempat_lahir'] ?? '-' }}</td>
                                <td>{{ !empty($anak['tanggal_lahir']) ? \Carbon\Carbon::parse($anak['tanggal_lahir'])->format('d-m-Y') : '-' }}</td>
                                <td>{{ $anak['pekerjaan'] ?? '-' }}</td>
                                <td>{{ $anak['status_kawin'] ?? '-' }}</td>
                                <td>{{ $anak['status_anak'] ?? '-' }}</td>
                                <td class="text-center">
                                    @if(!empty($anak['file']))
                                        <a href="{{ Storage::disk('public')->url($anak['file']) }}" target="_blank" class="btn btn-sm btn-outline-info py-0 px-2" title="Lihat Akta Kelahiran"><i class="bi bi-file-earmark-pdf"></i></a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <button type="button" class="family-action-btn family-action-edit" title="Edit"
                                            onclick="openModalKeluarga('anak', this)"
                                            data-row='{{ json_encode(['id' => $anak['id'] ?? '', 'nama' => $anak['nama'] ?? '', 'nik' => $anak['nik'] ?? '', 'jenis_kelamin' => $anak['jenis_kelamin'] ?? '', 'tempat_lahir' => $anak['tempat_lahir'] ?? '', 'tanggal_lahir' => !empty($anak['tanggal_lahir']) ? \Carbon\Carbon::parse($anak['tanggal_lahir'])->format('Y-m-d') : '', 'pekerjaan' => $anak['pekerjaan'] ?? '', 'status_kawin' => $anak['status_kawin'] ?? '', 'status_anak' => $anak['status_anak'] ?? '', 'file' => $anak['file'] ?? '']) }}'
                                            @disabled($isLockedKeluarga ?? false)
                                           >
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button type="button" class="family-action-btn family-action-delete" title="Hapus"
                                            onclick="deleteKeluarga('/profile/drh/anak/{{ $anak['id'] ?? '' }}', this)"
                                            @disabled($isLockedKeluarga ?? false)
                                           >
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="10" class="text-center text-muted py-4">Belum ada data anak. Klik "+ Tambah Anak".</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ===== DATA ORANG TUA KANDUNG ===== --}}
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4 gap-2 flex-wrap">
                <h6 class="fw-bold text-primary d-flex align-items-center gap-2 mb-0">
                    <i class="bi bi-person-badge-fill"></i> Data Orang Tua Kandung <span class="text-danger" style="font-size: 10px;">(Wajib)</span>
                </h6>
                @if(empty($otAyah['nama']))
                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm"
                    onclick="openModalKeluarga('orang-tua', null); setTimeout(function(){ document.getElementById('mOTHub').value = 'Ayah'; }, 200);">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Ayah Kandung
                </button>
                @endif
                @if(empty($otIbu['nama']))
                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm"
                    onclick="openModalKeluarga('orang-tua', null); setTimeout(function(){ document.getElementById('mOTHub').value = 'Ibu'; }, 200);">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Ibu Kandung
                </button>
                @endif
            </div>
            <div class="glass-table-wrap p-3 p-lg-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Hubungan</th><th>Nama</th><th>NIK</th><th>Tanggal Lahir</th><th>Status Hidup</th><th>Pekerjaan</th><th>Alamat</th><th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orangtua as $row)
                            @php $isAyahOT = ($row['hubungan'] ?? '') === 'Ayah Kandung'; @endphp
                            <tr>
                                <td class="fw-semibold">{{ $row['hubungan'] ?? '-' }}</td>
                                <td class="fw-semibold">{{ $row['nama'] ?? '-' }}</td>
                                <td>{{ $row['nik'] ?? '-' }}</td>
                                <td>{{ !empty($row['tanggal_lahir']) ? \Carbon\Carbon::parse($row['tanggal_lahir'])->format('d-m-Y') : '-' }}</td>
                                <td>{{ $row['status_hidup'] ?? '-' }}</td>
                                <td>{{ $row['pekerjaan'] ?? '-' }}</td>
                                <td>{{ $row['alamat'] ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" class="family-action-btn family-action-edit" title="Edit"
                                            onclick="openModalKeluarga('orang-tua', this)"
                                            data-row='{{ json_encode(['id' => $row['id'] ?? '', 'status_hub' => $isAyahOT ? 'Ayah' : 'Ibu', 'nik' => $row['nik'] ?? '', 'nama' => $row['nama'] ?? '', 'alamat' => $row['alamat'] ?? '', 'tanggal_lahir' => !empty($row['tanggal_lahir']) ? \Carbon\Carbon::parse($row['tanggal_lahir'])->format('Y-m-d') : '', 'status_hidup' => $row['status_hidup'] ?? '', 'pekerjaan' => $row['pekerjaan'] ?? '']) }}'
                                            @disabled($isLockedKeluarga ?? false)
                                           >
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button type="button" class="family-action-btn family-action-delete" title="Hapus"
                                            onclick="deleteKeluarga('/profile/drh/keluarga/orang-tua/{{ $row['id'] ?? '' }}', this)"
                                            @disabled($isLockedKeluarga ?? false)
                                           >
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="text-center text-muted py-4">Data belum diisi. Klik "Tambah Orang Tua".</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ===== DATA MERTUA ===== --}}
        <div id="sectionMertua" class="mb-5" style="display: {{ $isMenikah ? 'block' : 'none' }};">
            <div class="d-flex justify-content-between align-items-center mb-4 gap-2 flex-wrap">
                <h6 class="fw-bold text-primary d-flex align-items-center gap-2 mb-0">
                    <i class="bi bi-house-heart-fill"></i> Data Orang Tua Mertua
                </h6>
                @if(empty($mAyah['nama']))
                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm"
                    onclick="openModalKeluarga('mertua', null); setTimeout(function(){ document.getElementById('mMertuaHub').value = 'Ayah Mertua'; }, 200);">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Ayah Mertua
                </button>
                @endif
                @if(empty($mIbu['nama']))
                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm"
                    onclick="openModalKeluarga('mertua', null); setTimeout(function(){ document.getElementById('mMertuaHub').value = 'Ibu Mertua'; }, 200);">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Ibu Mertua
                </button>
                @endif
            </div>
            <div class="glass-table-wrap p-3 p-lg-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Hubungan</th><th>Nama</th><th>NIK</th><th>Tanggal Lahir</th><th>Status Hidup</th><th>Pekerjaan</th><th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mertua as $row)
                            @php $isAyahM = ($row['hubungan'] ?? '') === 'Ayah Mertua'; @endphp
                            <tr>
                                <td class="fw-semibold">{{ $row['hubungan'] ?? '-' }}</td>
                                <td class="fw-semibold">{{ $row['nama'] ?? '-' }}</td>
                                <td>{{ $row['nik'] ?? '-' }}</td>
                                <td>{{ !empty($row['tanggal_lahir']) ? \Carbon\Carbon::parse($row['tanggal_lahir'])->format('d-m-Y') : '-' }}</td>
                                <td>{{ $row['status_hidup'] ?? '-' }}</td>
                                <td>{{ $row['pekerjaan'] ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" class="family-action-btn family-action-edit" title="Edit"
                                            onclick="openModalKeluarga('mertua', this)"
                                            data-row='{{ json_encode(['id' => $row['id'] ?? '', 'status_hub' => $isAyahM ? 'Ayah Mertua' : 'Ibu Mertua', 'nik' => $row['nik'] ?? '', 'nama' => $row['nama'] ?? '', 'tanggal_lahir' => !empty($row['tanggal_lahir']) ? \Carbon\Carbon::parse($row['tanggal_lahir'])->format('Y-m-d') : '', 'status_hidup' => $row['status_hidup'] ?? '', 'pekerjaan' => $row['pekerjaan'] ?? '']) }}'
                                            @disabled($isLockedKeluarga ?? false)
                                           >
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button type="button" class="family-action-btn family-action-delete" title="Hapus"
                                            onclick="deleteKeluarga('/profile/drh/keluarga/mertua/{{ $row['id'] ?? '' }}', this)"
                                            @disabled($isLockedKeluarga ?? false)
                                           >
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="text-center text-muted py-4">Data belum diisi. Klik "Tambah Mertua".</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ===== DATA SAUDARA KANDUNG ===== --}}
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4 gap-2 flex-wrap">
                <h6 class="fw-bold text-primary d-flex align-items-center gap-2 mb-0">
                    <i class="bi bi-people-fill"></i> Data Saudara Kandung
                </h6>
                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm"
                    onclick="openModalKeluarga('saudara', null)">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Saudara
                </button>
            </div>
            <div class="glass-table-wrap p-3 p-lg-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Nama</th><th>NIK</th><th>Jenis Kelamin</th><th>Status Kawin</th><th>Status Saudara</th><th>Tgl. Lahir</th><th>Pekerjaan</th><th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($saudaraRows as $saudara)
                            <tr>
                                <td class="fw-bold text-dark">{{ $saudara['nama'] ?? '-' }}</td>
                                <td class="text-muted small">{{ $saudara['nik'] ?? '-' }}</td>
                                <td>{{ ($saudara['jenis_kelamin'] ?? '') === 'L' ? 'Laki-laki' : (($saudara['jenis_kelamin'] ?? '') === 'P' ? 'Perempuan' : '-') }}</td>
                                <td>{{ $saudara['status_kawin'] ?? '-' }}</td>
                                <td>{{ $saudara['status_saudara'] ?? '-' }}</td>
                                <td>{{ !empty($saudara['tanggal_lahir']) ? \Carbon\Carbon::parse($saudara['tanggal_lahir'])->format('d-m-Y') : '-' }}</td>
                                <td>{{ $saudara['pekerjaan'] ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <button type="button" class="family-action-btn family-action-edit" title="Edit"
                                            onclick="openModalKeluarga('saudara', this)"
                                            data-row='{{ json_encode(['id' => $saudara['id'] ?? '', 'nik' => $saudara['nik'] ?? '', 'nama' => $saudara['nama'] ?? '', 'jenis_kelamin' => $saudara['jenis_kelamin'] ?? '', 'tempat_lahir' => $saudara['tempat_lahir'] ?? '', 'tanggal_lahir' => !empty($saudara['tanggal_lahir']) ? \Carbon\Carbon::parse($saudara['tanggal_lahir'])->format('Y-m-d') : '', 'pekerjaan' => $saudara['pekerjaan'] ?? '', 'status_kawin' => $saudara['status_kawin'] ?? '', 'status_saudara' => $saudara['status_saudara'] ?? '']) }}'
                                            @disabled($isLockedKeluarga ?? false)
                                           >
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button type="button" class="family-action-btn family-action-delete" title="Hapus"
                                            onclick="deleteKeluarga('/profile/drh/saudara/{{ $saudara['id'] ?? '' }}', this)"
                                            @disabled($isLockedKeluarga ?? false)
                                           >
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="text-center text-muted py-4">Belum ada data saudara. Klik "+ Tambah Saudara".</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ===== SIMPAN SEMUA DATA BUTTON ===== --}}
        <div class="mt-4 pt-3 border-top text-center">
            <button type="button" class="btn btn-save-main px-5" onclick="saveKeluargaSection('all', this)">
                <i class="bi bi-save2-fill me-2"></i> Simpan Semua Data
            </button>
        </div>

    </div>
</div>

<style>
    .glass-table-wrap {
        border-radius: 20px;
        border: 1px solid rgba(148, 163, 184, 0.25);
        background: linear-gradient(135deg, rgba(248, 250, 252, 0.9), rgba(239, 246, 255, 0.82));
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        box-shadow: 0 12px 35px rgba(15, 23, 42, 0.08);
    }

    .glass-table-wrap .table thead th {
        white-space: nowrap;
        font-size: 0.76rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #475569;
        border-bottom-color: rgba(148, 163, 184, 0.32);
        background-color: rgba(255, 255, 255, 0.58);
    }

    .glass-table-wrap .table tbody td {
        border-bottom-color: rgba(148, 163, 184, 0.2);
        color: #0f172a;
    }

    .family-action-btn {
        width: 38px;
        height: 38px;
        border: 1.5px solid transparent;
        border-radius: 11px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        box-shadow: 0 8px 18px rgba(15, 23, 42, 0.08);
        transition: transform 0.18s ease, box-shadow 0.18s ease, background-color 0.18s ease, color 0.18s ease, border-color 0.18s ease;
    }

    .family-action-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 20px rgba(15, 23, 42, 0.12);
    }

    .family-action-edit {
        background: #ffffff;
        color: #2563eb;
        border-color: #2563eb;
    }

    .family-action-edit:hover {
        background: #eff6ff;
        color: #1d4ed8;
        border-color: #1d4ed8;
    }

    .family-action-delete {
        background: #e63946;
        color: #ffffff;
        border-color: #e63946;
    }

    .family-action-delete:hover {
        background: #d62839;
        color: #ffffff;
        border-color: #d62839;
    }

    .sub-card { transition: all 0.3s ease; border: 1px solid transparent; }
    .sub-card:hover { transform: translateY(-5px); box-shadow: 0 12px 25px rgba(0,0,0,0.06) !important; background: #fff !important; border: 1px solid #e2e8f0 !important; }
    .upload-box:hover { border-color: #2563eb !important; background: #eff6ff !important; }
    .form-label { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; font-weight: 700; }
    .btn-primary:hover { transform: scale(1.02); filter: brightness(1.1); }
    .pointer { cursor: pointer; }
</style>

{{-- ===== MODALS DATA KELUARGA ===== --}}

{{-- Modal Pasangan --}}
<div class="modal fade" id="modalPasangan" tabindex="-1" aria-labelledby="modalPasanganTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="modalPasanganTitle">Tambah Data Pasangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-3">
                <input type="hidden" id="mPasanganId">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">NIK</label>
                        <input type="text" class="form-control" id="mPasanganNik" placeholder="16 Digit NIK" maxlength="16">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap *</label>
                        <input type="text" class="form-control" id="mPasanganNama" placeholder="Nama Lengkap Pasangan">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status (Suami/Istri) *</label>
                        <select class="form-select" id="mPasanganStatus">
                            <option value="">-- Pilih --</option>
                            <option value="SUAMI">SUAMI</option>
                            <option value="ISTRI">ISTRI</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status Hidup *</label>
                        <select class="form-select" id="mPasanganStatusHidup">
                            <option value="Hidup">Hidup</option>
                            <option value="Meninggal">Meninggal</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" id="mPasanganTempatLahir" placeholder="Kota Kelahiran">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="mPasanganTanggalLahir">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pekerjaan</label>
                        <input type="text" class="form-control" id="mPasanganPekerjaan" placeholder="Pekerjaan Pasangan">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No. Akta Nikah</label>
                        <input type="text" class="form-control" id="mPasanganAkta" placeholder="Nomor Akta Nikah">
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary rounded-pill px-4" onclick="saveKeluargaModal('pasangan', this)">
                    <i class="bi bi-cloud-arrow-up-fill me-1"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Anak --}}
<div class="modal fade" id="modalAnak" tabindex="-1" aria-labelledby="modalAnakTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="modalAnakTitle">Tambah Data Anak</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-3">
                <input type="hidden" id="mAnakId">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">NIK</label>
                        <input type="text" class="form-control" id="mAnakNik" placeholder="16 Digit NIK" maxlength="16">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap *</label>
                        <input type="text" class="form-control" id="mAnakNama" placeholder="Nama Lengkap Anak">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jenis Kelamin *</label>
                        <select class="form-select" id="mAnakJK">
                            <option value="">-- Pilih --</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status Anak *</label>
                        <select class="form-select" id="mAnakStatusAnak">
                            <option value="">-- Pilih --</option>
                            <option value="Kandung">Kandung</option>
                            <option value="Tiri">Tiri</option>
                            <option value="Angkat">Angkat</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" id="mAnakTempatLahir" placeholder="Kota Kelahiran">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="mAnakTanggalLahir">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pekerjaan</label>
                        <input type="text" class="form-control" id="mAnakPekerjaan" placeholder="Pekerjaan">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status Kawin</label>
                        <select class="form-select" id="mAnakStatusKawin">
                            <option value="">-- Pilih --</option>
                            <option value="Menikah">Menikah</option>
                            <option value="Belum Menikah">Belum Menikah</option>
                            <option value="Cerai Hidup">Cerai Hidup</option>
                            <option value="Cerai Mati">Cerai Mati</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Akta Kelahiran <span class="text-muted small">(PDF, maks. 1 MB)</span></label>
                        <input type="file" class="form-control" id="mAnakFile" accept=".pdf,application/pdf">
                        <div id="mAnakFileInfo" class="form-text text-muted d-none"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary rounded-pill px-4" onclick="saveKeluargaModal('anak', this)">
                    <i class="bi bi-cloud-arrow-up-fill me-1"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Orang Tua --}}
<div class="modal fade" id="modalOrangTua" tabindex="-1" aria-labelledby="modalOrangTuaTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="modalOrangTuaTitle">Tambah Data Orang Tua</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-3">
                <input type="hidden" id="mOTId">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Hubungan *</label>
                        <select class="form-select" id="mOTHub">
                            <option value="">-- Pilih --</option>
                            <option value="Ayah">Ayah Kandung</option>
                            <option value="Ibu">Ibu Kandung</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">NIK</label>
                        <input type="text" class="form-control" id="mOTNik" placeholder="16 Digit NIK" maxlength="16">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap *</label>
                        <input type="text" class="form-control" id="mOTNama" placeholder="Nama Lengkap">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="mOTTanggalLahir">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status Hidup</label>
                        <select class="form-select" id="mOTStatusHidup">
                            <option value="Hidup">Hidup</option>
                            <option value="Meninggal">Meninggal</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pekerjaan</label>
                        <input type="text" class="form-control" id="mOTPekerjaan" placeholder="Pekerjaan">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" id="mOTAlamat" rows="2" placeholder="Alamat Lengkap"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary rounded-pill px-4" onclick="saveKeluargaModal('orang-tua', this)">
                    <i class="bi bi-cloud-arrow-up-fill me-1"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Mertua --}}
<div class="modal fade" id="modalMertua" tabindex="-1" aria-labelledby="modalMertuaTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="modalMertuaTitle">Tambah Data Mertua</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-3">
                <input type="hidden" id="mMertuaId">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Hubungan *</label>
                        <select class="form-select" id="mMertuaHub">
                            <option value="">-- Pilih --</option>
                            <option value="Ayah Mertua">Ayah Mertua</option>
                            <option value="Ibu Mertua">Ibu Mertua</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">NIK</label>
                        <input type="text" class="form-control" id="mMertuaNik" placeholder="16 Digit NIK" maxlength="16">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap *</label>
                        <input type="text" class="form-control" id="mMertuaNama" placeholder="Nama Lengkap">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="mMertuaTanggalLahir">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status Hidup</label>
                        <select class="form-select" id="mMertuaStatusHidup">
                            <option value="Hidup">Hidup</option>
                            <option value="Meninggal">Meninggal</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pekerjaan</label>
                        <input type="text" class="form-control" id="mMertuaPekerjaan" placeholder="Pekerjaan">
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary rounded-pill px-4" onclick="saveKeluargaModal('mertua', this)">
                    <i class="bi bi-cloud-arrow-up-fill me-1"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Saudara --}}
<div class="modal fade" id="modalSaudara" tabindex="-1" aria-labelledby="modalSaudaraTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="modalSaudaraTitle">Tambah Data Saudara</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-3">
                <input type="hidden" id="mSaudaraId">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">NIK</label>
                        <input type="text" class="form-control" id="mSaudaraNik" placeholder="16 Digit NIK" maxlength="16">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap *</label>
                        <input type="text" class="form-control" id="mSaudaraNama" placeholder="Nama Lengkap Saudara">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jenis Kelamin *</label>
                        <select class="form-select" id="mSaudaraJK">
                            <option value="">-- Pilih --</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status Saudara *</label>
                        <select class="form-select" id="mSaudaraStatus">
                            <option value="">-- Pilih --</option>
                            <option value="Kandung">Kandung</option>
                            <option value="Tiri">Tiri</option>
                            <option value="Angkat">Angkat</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" id="mSaudaraTempatLahir" placeholder="Kota Kelahiran">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="mSaudaraTanggalLahir">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pekerjaan</label>
                        <input type="text" class="form-control" id="mSaudaraPekerjaan" placeholder="Pekerjaan">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status Kawin</label>
                        <select class="form-select" id="mSaudaraStatusKawin">
                            <option value="">-- Pilih --</option>
                            <option value="Menikah">Menikah</option>
                            <option value="Belum Menikah">Belum Menikah</option>
                            <option value="Cerai Hidup">Cerai Hidup</option>
                            <option value="Cerai Mati">Cerai Mati</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary rounded-pill px-4" onclick="saveKeluargaModal('saudara', this)">
                    <i class="bi bi-cloud-arrow-up-fill me-1"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const _keluargaModalMap = {
    'pasangan':  '#modalPasangan',
    'anak':      '#modalAnak',
    'orang-tua': '#modalOrangTua',
    'mertua':    '#modalMertua',
    'saudara':   '#modalSaudara',
};


function openModalKeluarga(type, btnOrNull) {
    const modalEl = document.querySelector(_keluargaModalMap[type]);
    if (!modalEl) return;

    let isEdit = !!btnOrNull;
    if (!isEdit) {
        modalEl.querySelectorAll('input:not([type=hidden]), select, textarea').forEach(el => el.value = '');
        const idField = modalEl.querySelector('input[type=hidden]');
        if (idField) idField.value = '';
        // Hide file info hint for new entry
        const fileInfo = modalEl.querySelector('[id$="FileInfo"]');
        if (fileInfo) { fileInfo.textContent = ''; fileInfo.classList.add('d-none'); }
    }

    const titleEl = modalEl.querySelector('.modal-title');

    if (btnOrNull) {
        let d = null;
        // DEBUG: tampilkan isi data-row di console
        if (!btnOrNull.dataset.row) {
            console.warn('data-row attribute kosong! Tidak ada data yang bisa di-prefill.');
        } else {
            console.log('Isi data-row:', btnOrNull.dataset.row);
        }
        try {
            d = JSON.parse(btnOrNull.dataset.row);
        } catch (e) {
            alert('Gagal membaca data edit. Cek data-row di tombol edit!');
            console.error('Error parsing data-row:', e, btnOrNull.dataset.row);
            if (titleEl) titleEl.textContent = 'Tambah Data';
            bootstrap.Modal.getOrCreateInstance(modalEl).show();
            return;
        }
        if (!d || Object.keys(d).length === 0) {
            alert('Data edit kosong! Cek backend pengisian data-row.');
            console.warn('Data hasil parsing kosong:', d);
        }
        if (titleEl) titleEl.textContent = 'Edit Data';

        function setVal(sel, val, isDate) {
            const el = modalEl.querySelector(sel);
            if (!el) {
                console.warn('Input tidak ditemukan:', sel, 'di modal', modalEl);
                return;
            }
            if (val !== undefined && val !== null) {
                if (isDate && val) {
                    let v = val;
                    if (/^\d{4}-\d{2}-\d{2}$/.test(val)) {
                        v = val;
                    } else {
                        const parsed = new Date(val);
                        if (!isNaN(parsed.getTime())) {
                            v = parsed.toISOString().split('T')[0];
                        }
                    }
                    el.value = v;
                } else {
                    el.value = val;
                }
            }
        }

        if (type === 'pasangan') {
            setVal('#mPasanganId', d.id);
            setVal('#mPasanganNik', d.nik);
            setVal('#mPasanganNama', d.nama);
            setVal('#mPasanganStatus', d.status);
            setVal('#mPasanganStatusHidup', d.status_hidup);
            setVal('#mPasanganTempatLahir', d.tempat_lahir);
            setVal('#mPasanganTanggalLahir', d.tanggal_lahir, true);
            setVal('#mPasanganPekerjaan', d.pekerjaan);
            setVal('#mPasanganAkta', d.no_akta_nikah);
        } else if (type === 'anak') {
            setVal('#mAnakId', d.id);
            setVal('#mAnakNik', d.nik);
            setVal('#mAnakNama', d.nama);
            setVal('#mAnakJK', d.jenis_kelamin);
            setVal('#mAnakTempatLahir', d.tempat_lahir);
            setVal('#mAnakTanggalLahir', d.tanggal_lahir, true);
            setVal('#mAnakPekerjaan', d.pekerjaan);
            setVal('#mAnakStatusAnak', d.status_anak);
            setVal('#mAnakStatusKawin', d.status_kawin);
            // Reset file input; show existing file info
            const anakFileInput = modalEl.querySelector('#mAnakFile');
            if (anakFileInput) anakFileInput.value = '';
            const anakFileInfo = modalEl.querySelector('#mAnakFileInfo');
            if (anakFileInfo) {
                if (d.file) {
                    anakFileInfo.textContent = 'File saat ini: ' + d.file.split('/').pop();
                    anakFileInfo.classList.remove('d-none');
                } else {
                    anakFileInfo.textContent = '';
                    anakFileInfo.classList.add('d-none');
                }
            }
        } else if (type === 'orang-tua') {
            setVal('#mOTId', d.id);
            setVal('#mOTHub', d.status_hub);
            setVal('#mOTNik', d.nik);
            setVal('#mOTNama', d.nama);
            setVal('#mOTAlamat', d.alamat);
            setVal('#mOTTanggalLahir', d.tanggal_lahir, true);
            setVal('#mOTStatusHidup', d.status_hidup);
            setVal('#mOTPekerjaan', d.pekerjaan);
        } else if (type === 'mertua') {
            setVal('#mMertuaId', d.id);
            setVal('#mMertuaHub', d.status_hub);
            setVal('#mMertuaNik', d.nik);
            setVal('#mMertuaNama', d.nama);
            setVal('#mMertuaTanggalLahir', d.tanggal_lahir, true);
            setVal('#mMertuaStatusHidup', d.status_hidup);
            setVal('#mMertuaPekerjaan', d.pekerjaan);
        } else if (type === 'saudara') {
            setVal('#mSaudaraId', d.id);
            setVal('#mSaudaraNik', d.nik);
            setVal('#mSaudaraNama', d.nama);
            setVal('#mSaudaraJK', d.jenis_kelamin);
            setVal('#mSaudaraTempatLahir', d.tempat_lahir);
            setVal('#mSaudaraTanggalLahir', d.tanggal_lahir, true);
            setVal('#mSaudaraPekerjaan', d.pekerjaan);
            setVal('#mSaudaraStatus', d.status_saudara);
            setVal('#mSaudaraStatusKawin', d.status_kawin);
        }
    } else {
        if (titleEl) titleEl.textContent = 'Tambah Data';
    }

    bootstrap.Modal.getOrCreateInstance(modalEl).show();
}

function saveKeluargaModal(type, btn) {
    const modalEl = document.querySelector(_keluargaModalMap[type]);
    if (!modalEl) return;

    let id = '', url = '';
    const fd = new FormData();
    fd.append('_token', '{{ csrf_token() }}');

    if (type === 'pasangan') {
        id = modalEl.querySelector('#mPasanganId').value;
        fd.append('nik',           modalEl.querySelector('#mPasanganNik').value);
        fd.append('nama',          modalEl.querySelector('#mPasanganNama').value);
        fd.append('status',        modalEl.querySelector('#mPasanganStatus').value);
        fd.append('status_hidup',  modalEl.querySelector('#mPasanganStatusHidup').value);
        fd.append('tempat_lahir',  modalEl.querySelector('#mPasanganTempatLahir').value);
        fd.append('tanggal_lahir', modalEl.querySelector('#mPasanganTanggalLahir').value);
        fd.append('pekerjaan',     modalEl.querySelector('#mPasanganPekerjaan').value);
        fd.append('no_akta_nikah', modalEl.querySelector('#mPasanganAkta').value);
        url = id ? `/profile/drh/keluarga/pasangan/${id}` : '/profile/drh/keluarga/pasangan';
    } else if (type === 'anak') {
        id = modalEl.querySelector('#mAnakId').value;
        fd.append('nik',           modalEl.querySelector('#mAnakNik').value);
        fd.append('nama',          modalEl.querySelector('#mAnakNama').value);
        fd.append('jenis_kelamin', modalEl.querySelector('#mAnakJK').value);
        fd.append('tempat_lahir',  modalEl.querySelector('#mAnakTempatLahir').value);
        fd.append('tanggal_lahir', modalEl.querySelector('#mAnakTanggalLahir').value);
        fd.append('pekerjaan',     modalEl.querySelector('#mAnakPekerjaan').value);
        fd.append('status_anak',   modalEl.querySelector('#mAnakStatusAnak').value);
        fd.append('status_kawin',  modalEl.querySelector('#mAnakStatusKawin').value);
        const anakFileEl = modalEl.querySelector('#mAnakFile');
        if (anakFileEl && anakFileEl.files.length > 0) {
            fd.append('file', anakFileEl.files[0]);
        }
        url = id ? `/profile/drh/anak/${id}` : '/profile/drh/keluarga/anak';
    } else if (type === 'orang-tua') {
        id = modalEl.querySelector('#mOTId').value;
        fd.append('status_hub',    modalEl.querySelector('#mOTHub').value);
        fd.append('nik',           modalEl.querySelector('#mOTNik').value);
        fd.append('nama',          modalEl.querySelector('#mOTNama').value);
        fd.append('alamat',        modalEl.querySelector('#mOTAlamat').value);
        fd.append('tanggal_lahir', modalEl.querySelector('#mOTTanggalLahir').value);
        fd.append('status_hidup',  modalEl.querySelector('#mOTStatusHidup').value);
        fd.append('pekerjaan',     modalEl.querySelector('#mOTPekerjaan').value);
        url = id ? `/profile/drh/keluarga/orang-tua/${id}` : '/profile/drh/keluarga/orang-tua';
    } else if (type === 'mertua') {
        id = modalEl.querySelector('#mMertuaId').value;
        fd.append('status_hub',    modalEl.querySelector('#mMertuaHub').value);
        fd.append('nik',           modalEl.querySelector('#mMertuaNik').value);
        fd.append('nama',          modalEl.querySelector('#mMertuaNama').value);
        fd.append('tanggal_lahir', modalEl.querySelector('#mMertuaTanggalLahir').value);
        fd.append('status_hidup',  modalEl.querySelector('#mMertuaStatusHidup').value);
        fd.append('pekerjaan',     modalEl.querySelector('#mMertuaPekerjaan').value);
        url = id ? `/profile/drh/keluarga/mertua/${id}` : '/profile/drh/keluarga/mertua';
    } else if (type === 'saudara') {
        id = modalEl.querySelector('#mSaudaraId').value;
        fd.append('nik',            modalEl.querySelector('#mSaudaraNik').value);
        fd.append('nama',           modalEl.querySelector('#mSaudaraNama').value);
        fd.append('jenis_kelamin',  modalEl.querySelector('#mSaudaraJK').value);
        fd.append('tempat_lahir',   modalEl.querySelector('#mSaudaraTempatLahir').value);
        fd.append('tanggal_lahir',  modalEl.querySelector('#mSaudaraTanggalLahir').value);
        fd.append('pekerjaan',      modalEl.querySelector('#mSaudaraPekerjaan').value);
        fd.append('status_saudara', modalEl.querySelector('#mSaudaraStatus').value);
        fd.append('status_kawin',   modalEl.querySelector('#mSaudaraStatusKawin').value);
        url = id ? `/profile/drh/saudara/${id}` : '/profile/drh/keluarga/saudara';
    }

    if (id) fd.append('_method', 'PUT');

    const origText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

    fetch(url, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
        body: fd
    })
    .then(r => r.text())
    .then(text => {
        let data;
        try {
            data = JSON.parse(text);
        } catch (e) {
            console.error('Response bukan JSON:', text);
            Swal.fire({ icon: 'error', title: 'Server Error', text: 'Terjadi kesalahan pada server. Coba lagi.' });
            return;
        }
        if (data.status === 'success' || data.success || data.message) {
            bootstrap.Modal.getOrCreateInstance(modalEl).hide();
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: data.message || 'Data berhasil disimpan.', timer: 1800, showConfirmButton: false })
                .then(() => location.reload());
        } else {
            const msg = data.errors ? Object.values(data.errors).flat().join('\n') : (data.message || 'Gagal menyimpan data.');
            Swal.fire({ icon: 'error', title: 'Gagal', text: msg });
        }
    })
    .catch(() => Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan koneksi.' }))
    .finally(() => { btn.disabled = false; btn.innerHTML = origText; });
}

function deleteKeluarga(url, btn) {
    Swal.fire({
        icon: 'warning',
        title: 'Hapus Data?',
        text: 'Data yang dihapus tidak dapat dikembalikan.',
        showCancelButton: true,
        confirmButtonColor: '#e63946',
        cancelButtonText: 'Batal',
        confirmButtonText: 'Ya, Hapus'
    }).then(result => {
        if (!result.isConfirmed) return;

        const origText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

        const fd = new FormData();
        fd.append('_token', '{{ csrf_token() }}');
        fd.append('_method', 'DELETE');

        fetch(url, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
            body: fd
        })
        .then(r => r.text())
        .then(text => {
            let data;
            try {
                data = JSON.parse(text);
            } catch (e) {
                Swal.fire({ icon: 'error', title: 'Server Error', text: 'Terjadi kesalahan pada server.' });
                return;
            }
            Swal.fire({ icon: 'success', title: 'Dihapus!', text: data.message || 'Data berhasil dihapus.', timer: 1500, showConfirmButton: false })
                .then(() => location.reload());
        })
        .catch(() => Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal menghapus data.' }))
        .finally(() => { btn.disabled = false; btn.innerHTML = origText; });
    });
}
</script>
@endpush

