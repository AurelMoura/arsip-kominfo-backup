<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print DRH - {{ $user->name }}</title>
    <style>
        @page {
            size: A4;
            margin: 0;
            margin-top: 2mm;
        }

        @page :first {
            margin: 0;
            margin-top: 2mm;
        }

        /* Adjust margins for legal paper size */
        @media print {
            @page {
                size: A4;
                margin: 0;
                margin-top: 0mm;
            }
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            color: #1f2937;
            font-size: 12px;
            line-height: 1.45;
            background: #f3f4f6;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            margin-top: 80px;
            background: #ffffff;
            padding: 0;
        }

        .sheet {
            padding: 14mm;
            margin: 0;
            padding-top: 4mm;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 3px solid #111827;
            padding-bottom: 8px;
            margin-bottom: 12px;
            margin-top: 0;
            position: relative;
            z-index: 10;
        }

        .header-table td {
            vertical-align: middle;
        }

        .logo-cell {
            width: 90px;
        }

        .logo-cell img {
            width: 78px;
            height: auto;
        }

        .text-cell {
            text-align: center;
        }

        .text-cell h1,
        .text-cell h2,
        .text-cell p {
            margin: 0;
        }

        .text-cell h2 {
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 0.4px;
        }

        .text-cell h1 {
            font-size: 24px;
            margin: 2px 0 4px;
            font-weight: 800;
        }

        .text-cell p {
            font-size: 11px;
        }

        .document-title {
            text-align: center;
            margin: 18px 0 20px;
        }

        .document-title h3 {
            margin: 0;
            font-size: 18px;
            letter-spacing: 1px;
        }

        .document-title p {
            margin: 6px 0 0;
            color: #4b5563;
            font-size: 11px;
        }

        .profile-box {
            border: 1px solid #d1d5db;
            border-radius: 12px;
            padding: 14px;
            margin-bottom: 18px;
        }

        .profile-layout {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        .profile-photo,
        .profile-main {
            display: table-cell;
            vertical-align: middle;
            padding: 0;
        }

        .profile-photo {
            width: 100px;
            padding-right: 12px;
            text-align: center;
        }

        .profile-main {
            padding-left: 12px;
        }

        .photo-frame {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            overflow: hidden;
            background: #dbeafe;
            border: 2px solid #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 800;
            color: #2563eb;
            margin: auto;
        }

        .photo-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-main h4 {
            margin: 0;
            font-size: 22px;
        }

        .profile-main .nip {
            margin-top: 4px;
            font-size: 13px;
            font-weight: 700;
            color: #2563eb;
        }

        .meta-grid {
            margin-top: 12px;
            width: 100%;
            border-collapse: collapse;
        }

        .meta-grid td {
            padding: 4px 0;
            vertical-align: top;
        }

        .meta-grid .label {
            width: 170px;
            color: #6b7280;
            font-weight: 700;
        }

        .meta-grid .separator {
            width: 14px;
            text-align: center;
        }

        .section {
            margin-bottom: 18px;
            page-break-inside: avoid;
        }

        .section-title {
            background: #eff6ff;
            border-left: 5px solid #2563eb;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 13px;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .detail-table,
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .detail-table td {
            border-bottom: 1px solid #e5e7eb;
            padding: 7px 6px;
            vertical-align: top;
        }

        .detail-table tr:last-child td {
            border-bottom: none;
        }

        .detail-table .label {
            width: 180px;
            color: #6b7280;
            font-weight: 700;
        }

        .detail-table .separator {
            width: 16px;
            text-align: center;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #d1d5db;
            padding: 7px 8px;
            vertical-align: top;
            text-align: left;
        }

        .data-table th {
            background: #f3f4f6;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .grid-two {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        .grid-two .col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-right: 8px;
        }

        .grid-two .col:last-child {
            padding-right: 0;
            padding-left: 8px;
        }

        .mini-card {
            border: 1px solid #d1d5db;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 10px;
        }

        .mini-card h5 {
            margin: 0 0 8px;
            font-size: 12px;
        }

        .empty-text {
            color: #6b7280;
            font-style: italic;
            padding: 6px 0;
        }

        .footer-note {
            margin-top: 22px;
            padding-top: 12px;
            border-top: 1px solid #d1d5db;
            font-size: 10px;
            color: #6b7280;
            text-align: center;
        }

        /* Control Buttons */
        .control-buttons {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            display: flex;
            gap: 10px;
            background: white;
            padding: 10px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-control {
            padding: 10px 16px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-download {
            background: #2563eb;
            color: white;
        }

        .btn-download:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .btn-print {
            background: #059669;
            color: white;
        }

        .btn-print:hover {
            background: #047857;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
        }

        .btn-control:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Paper size selector */
        .paper-selector {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
            background: white;
            padding: 12px 16px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .paper-selector select {
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid #d1d5db;
            font-size: 13px;
        }

        @media print {
            body {
                background: #ffffff;
            }

            .page {
                width: 100%;
                min-height: auto;
            }

            .sheet {
                padding: 0;
            }

            .control-buttons,
            .paper-selector {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <!-- Paper Size Selector -->
    <div class="paper-selector" id="paperSelector">
        <label for="paperSize" style="font-size: 13px; font-weight: 600; margin-right: 8px;">Ukuran Kertas:</label>
        <select id="paperSize" onchange="changePaperSize(this.value)">
            <option value="a4">A4 (210 x 297mm) - Standar</option>
            <option value="legal">Legal (216 x 356mm)</option>
            <option value="folio">Folio (216 x 330mm)</option>
        </select>
    </div>

    <!-- Control Buttons -->
    <div class="control-buttons" id="controlButtons">
        <button id="btn-download" class="btn-control btn-download" onclick="downloadPDF()" title="Download PDF">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
            <span>Download PDF</span>
        </button>
        <button id="btn-print" class="btn-control btn-print" onclick="printDRH()" title="Print DRH">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
            <span>Print DRH</span>
        </button>
    </div>

    <div class="page" id="pageContent">
        <div class="sheet">
            <table class="header-table">
                <tr>
                    <td class="logo-cell">
                        <img src="{{ asset('image/pemkot.png') }}" alt="Logo Pemerintah Kota Bengkulu">
                    </td>
                    <td class="text-cell">
                        <h2>PEMERINTAH KOTA BENGKULU</h2>
                        <h1>DINAS KOMUNIKASI DAN INFORMATIKA</h1>
                        <p>Jl. Jati Raya No. 01 Kota Bengkulu, Telp. (0736) 21003, Kode Pos 38227</p>
                        <p>www.bengkulukota.go.id | kominfo@bengkulukota.go.id</p>
                    </td>
                </tr>
            </table>

            @if(!$drhData)
                <div class="document-title">
                    <h3>DAFTAR RIWAYAT HIDUP</h3>
                    <p>Data DRH pegawai tidak ditemukan.</p>
                </div>
            @else
                @php
                    $pegawai = $drhData;
                    $statusKawinMap = [
                        'BM' => 'Belum Menikah',
                        'M' => 'Menikah',
                        'CH' => 'Cerai Hidup',
                        'CM' => 'Cerai Mati',
                    ];
                    $jenisKelaminLabel = $pegawai->jenis_kelamin === 'L' ? 'Laki-laki' : ($pegawai->jenis_kelamin === 'P' ? 'Perempuan' : '-');
                    $pangkatLabel = $pegawai->golongan_pangkat
                        ? trim(($pegawai->golongan_pangkat ?? '-') . ' - ' . ($pegawai->nama_pangkat ?? '-'))
                        : '-';
                    $eselonLabel = $pegawai->eselon_jabatan
                        ? $pegawai->eselon_jabatan . ' (' . $pegawai->jenis_jabatan . ')'
                        : ($pegawai->jenis_jabatan ?? '-');
                    $pasangan = data_get($pegawai, 'data_keluarga.pasangan', []);
                    $anakList = data_get($pegawai, 'data_keluarga.anak', []);
                    $orangTua = data_get($pegawai, 'data_keluarga.orang_tua', []);
                    $mertua = data_get($pegawai, 'data_keluarga.mertua', []);
                    $saudaraList = data_get($pegawai, 'data_keluarga.saudara', []);
                    $riwayatPendidikan = $pegawai->riwayat_pendidikan ?? [];
                    $riwayatDiklat = $pegawai->riwayat_diklat ?? [];
                    $riwayatJabatan = $pegawai->riwayat_jabatan ?? [];
                    $riwayatPenghargaan = $pegawai->riwayat_penghargaan ?? [];
                    $riwayatSertifikasi = $pegawai->riwayat_sertifikasi ?? [];
                    $legal = $pegawai->identitas_legal ?? [];
                @endphp

                <div class="document-title">
                    <h3>DAFTAR RIWAYAT HIDUP</h3>

                </div>

                <div class="profile-box">
                    <div class="profile-layout">
                        <div class="profile-main">
                            <h4>{{ $user->name }}</h4>
                            <div class="nip">NIP: {{ $user->pegawai_id ?? '-' }}</div>
                            <table class="meta-grid">
                                <tr>
                                    <td class="label">Jabatan Saat Ini</td>
                                    <td class="separator">:</td>
                                    <td>{{ $pegawai->nama_jabatan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="label">Unit Kerja</td>
                                    <td class="separator">:</td>
                                    <td>{{ $pegawai->unit_kerja?->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="label">Jenis ASN</td>
                                    <td class="separator">:</td>
                                    <td>{{ $pegawai->status_pegawai ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="profile-photo">
                            <div class="photo-frame">
                                @if($pegawai?->foto_profil)
                                    <img src="{{ Storage::disk('public')->url($pegawai->foto_profil) }}" alt="Foto Profil">
                                @else
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section">
                    <div class="section-title">I. Data Pribadi</div>
                    <table class="detail-table">
                        <tr><td class="label">NIK</td><td class="separator">:</td><td>{{ $pegawai->no_nik ?? '-' }}</td></tr>
                        <tr><td class="label">Email Instansi</td><td class="separator">:</td><td>{{ $pegawai->email ?? '-' }}</td></tr>
                        <tr><td class="label">Nomor WhatsApp</td><td class="separator">:</td><td>{{ $pegawai->no_hp ?? '-' }}</td></tr>
                        <tr><td class="label">Golongan / Ruang</td><td class="separator">:</td><td>{{ $pangkatLabel }}</td></tr>
                        <tr><td class="label">Status Kawin</td><td class="separator">:</td><td>{{ $statusKawinMap[$pegawai->status_kawin ?? ''] ?? '-' }}</td></tr>
                        <tr><td class="label">Tempat, Tanggal Lahir</td><td class="separator">:</td><td>{{ $pegawai->tempat_lahir ?? '-' }}, {{ optional($pegawai->tanggal_lahir)->format('d F Y') ?? '-' }}</td></tr>
                        <tr><td class="label">Agama</td><td class="separator">:</td><td>{{ $pegawai->nama_agama ?? '-' }}</td></tr>
                        <tr><td class="label">Jenis Kelamin</td><td class="separator">:</td><td>{{ $jenisKelaminLabel }}</td></tr>
                        <tr><td class="label">Golongan Darah</td><td class="separator">:</td><td>{{ $pegawai->gol_darah ?? '-' }}</td></tr>
                        <tr><td class="label">Kabupaten Asal</td><td class="separator">:</td><td>{{ $pegawai->kabupaten_asal ?? '-' }}</td></tr>
                        <tr><td class="label">Jabatan Saat Ini</td><td class="separator">:</td><td>{{ $pegawai->nama_jabatan ?? '-' }}</td></tr>
                        @if($pegawai->status_pegawai !== 'PPPK')
                        <tr><td class="label">Jenis Jabatan</td><td class="separator">:</td><td>{{ strtoupper($pegawai->jenis_jabatan ?? '-') }}</td></tr>
                        <tr><td class="label">Eselon Jabatan</td><td class="separator">:</td><td>{{ $eselonLabel }}</td></tr>
                        @endif
                        <tr><td class="label">Alamat Domisili</td><td class="separator">:</td><td>{{ $pegawai->alamat ?? '-' }}</td></tr>
                    </table>
                </div>

                <div class="section">
                    <div class="section-title">II. Data Keluarga</div>

                    <div class="mini-card">
                        <h5>Data Pasangan</h5>
                        @if(!empty($pasangan['nama']))
                            <table class="detail-table">
                                <tr><td class="label">Nama Lengkap</td><td class="separator">:</td><td>{{ $pasangan['nama'] ?? '-' }}</td></tr>
                                <tr><td class="label">NIK</td><td class="separator">:</td><td>{{ $pasangan['nik'] ?? '-' }}</td></tr>
                                <tr><td class="label">Tempat, Tanggal Lahir</td><td class="separator">:</td><td>{{ $pasangan['tempat_lahir'] ?? '-' }}, {{ $pasangan['tanggal_lahir'] ?? '-' }}</td></tr>
                                <tr><td class="label">No. Akta Nikah</td><td class="separator">:</td><td>{{ $pasangan['no_akta_nikah'] ?? '-' }}</td></tr>
                                <tr><td class="label">Pekerjaan</td><td class="separator">:</td><td>{{ $pasangan['pekerjaan'] ?? '-' }}</td></tr>
                            </table>
                        @else
                            <div class="empty-text">Data pasangan belum tercatat.</div>
                        @endif
                    </div>

                    <div class="mini-card">
                        <h5>Data Anak</h5>
                        @if(is_array($anakList) && count($anakList) > 0)
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>NIK</th>
                                        <th>Tempat, Tanggal Lahir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($anakList as $index => $anak)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $anak['nama'] ?? '-' }}</td>
                                            <td>{{ $anak['nik'] ?? '-' }}</td>
                                            <td>{{ $anak['tempat_lahir'] ?? '-' }}, {{ $anak['tanggal_lahir'] ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="empty-text">Data anak belum tercatat.</div>
                        @endif
                    </div>

                    <div class="grid-two">
                        <div class="col">
                            <div class="mini-card">
                                <h5>Orang Tua</h5>
                                <table class="detail-table">
                                    <tr><td class="label">Ayah</td><td class="separator">:</td><td>{{ data_get($orangTua, 'ayah.nama', '-') }}</td></tr>
                                    <tr><td class="label">NIK Ayah</td><td class="separator">:</td><td>{{ data_get($orangTua, 'ayah.nik', '-') }}</td></tr>
                                    <tr><td class="label">Pekerjaan Ayah</td><td class="separator">:</td><td>{{ data_get($orangTua, 'ayah.pekerjaan', '-') }}</td></tr>
                                    <tr><td class="label">Ibu</td><td class="separator">:</td><td>{{ data_get($orangTua, 'ibu.nama', '-') }}</td></tr>
                                    <tr><td class="label">NIK Ibu</td><td class="separator">:</td><td>{{ data_get($orangTua, 'ibu.nik', '-') }}</td></tr>
                                    <tr><td class="label">Pekerjaan Ibu</td><td class="separator">:</td><td>{{ data_get($orangTua, 'ibu.pekerjaan', '-') }}</td></tr>
                                </table>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mini-card">
                                <h5>Mertua</h5>
                                <table class="detail-table">
                                    <tr><td class="label">Ayah Mertua</td><td class="separator">:</td><td>{{ data_get($mertua, 'ayah.nama', '-') }}</td></tr>
                                    <tr><td class="label">NIK Ayah Mertua</td><td class="separator">:</td><td>{{ data_get($mertua, 'ayah.nik', '-') }}</td></tr>
                                    <tr><td class="label">Pekerjaan Ayah Mertua</td><td class="separator">:</td><td>{{ data_get($mertua, 'ayah.pekerjaan', '-') }}</td></tr>
                                    <tr><td class="label">Ibu Mertua</td><td class="separator">:</td><td>{{ data_get($mertua, 'ibu.nama', '-') }}</td></tr>
                                    <tr><td class="label">NIK Ibu Mertua</td><td class="separator">:</td><td>{{ data_get($mertua, 'ibu.nik', '-') }}</td></tr>
                                    <tr><td class="label">Pekerjaan Ibu Mertua</td><td class="separator">:</td><td>{{ data_get($mertua, 'ibu.pekerjaan', '-') }}</td></tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mini-card">
                        <h5>Data Saudara</h5>
                        @if(is_array($saudaraList) && count($saudaraList) > 0)
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>NIK</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Status Kawin</th>
                                        <th>Status Saudara</th>
                                        <th>Pekerjaan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($saudaraList as $index => $saudara)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $saudara['nama'] ?? '-' }}</td>
                                            <td>{{ $saudara['nik'] ?? '-' }}</td>
                                            <td>{{ $saudara['jenis_kelamin'] === 'L' ? 'Laki-laki' : ($saudara['jenis_kelamin'] === 'P' ? 'Perempuan' : '-') }}</td>
                                            <td>{{ $saudara['status_kawin'] ?? '-' }}</td>
                                            <td>{{ $saudara['status_saudara'] ?? '-' }}</td>
                                            <td>{{ $saudara['pekerjaan'] ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="empty-text">Data saudara belum tercatat.</div>
                        @endif
                    </div>
                </div>

                <div class="section">
                    <div class="section-title">III. Riwayat Pendidikan</div>
                    @if(is_array($riwayatPendidikan) && count($riwayatPendidikan) > 0)
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Jenjang</th>
                                    <th>Institusi</th>
                                    <th>Tahun Masuk</th>
                                    <th>Tahun Lulus</th>
                                    <th>No. Ijazah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riwayatPendidikan as $index => $pendidikan)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $pendidikan['jenjang'] ?? '-' }}</td>
                                        <td>{{ $pendidikan['nama_sekolah'] ?? '-' }}</td>
                                        <td>{{ $pendidikan['tahun_masuk'] ?? '-' }}</td>
                                        <td>{{ $pendidikan['tahun_lulus'] ?? '-' }}</td>
                                        <td>{{ $pendidikan['nomor_ijazah'] ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-text">Riwayat pendidikan belum tersedia.</div>
                    @endif
                </div>

                <div class="section">
                    <div class="section-title">IV. Riwayat Diklat</div>
                    @if(is_array($riwayatDiklat) && count($riwayatDiklat) > 0)
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Diklat</th>
                                    <th>Penyelenggara</th>
                                    <th>No. Sertifikat</th>
                                    <th>Tahun</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riwayatDiklat as $index => $diklat)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $diklat['nama'] ?? '-' }}</td>
                                        <td>{{ $diklat['penyelenggara'] ?? '-' }}</td>
                                        <td>{{ $diklat['nomor_sertifikat'] ?? '-' }}</td>
                                        <td>{{ $diklat['tahun'] ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-text">Riwayat diklat belum tersedia.</div>
                    @endif
                </div>

                <div class="section">
                    <div class="section-title">V. Riwayat Jabatan</div>
                    @if(is_array($riwayatJabatan) && count($riwayatJabatan) > 0)
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Jenis Jabatan</th>
                                    <th>Nama Jabatan</th>
                                    <th>Eselon</th>
                                    <th>TMT</th>
                                    <th>No. SK</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riwayatJabatan as $index => $jabatan)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $jabatan['jenis_jabatan'] ?? '-' }}</td>
                                        <td>{{ $jabatan['nama_jabatan'] ?? $jabatan['jabatan'] ?? '-' }}</td>
                                        <td>{{ $jabatan['eselon'] ?? '-' }}</td>
                                        <td>{{ !empty($jabatan['tmt']) ? \Carbon\Carbon::parse($jabatan['tmt'])->format('d F Y') : '-' }}</td>
                                        <td>{{ $jabatan['no_sk'] ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-text">Riwayat jabatan belum tersedia.</div>
                    @endif
                </div>

                <div class="section">
                    <div class="section-title">VI. Riwayat Penghargaan</div>
                    @if(is_array($riwayatPenghargaan) && count($riwayatPenghargaan) > 0)
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Penghargaan</th>
                                    <th>Instansi Pemberi</th>
                                    <th>Tahun</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riwayatPenghargaan as $index => $penghargaan)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $penghargaan['nama'] ?? '-' }}</td>
                                        <td>{{ $penghargaan['instansi'] ?? '-' }}</td>
                                        <td>{{ $penghargaan['tahun'] ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-text">Riwayat penghargaan belum tersedia.</div>
                    @endif
                </div>

                <div class="section">
                    <div class="section-title">VII. Riwayat Sertifikasi</div>
                    @if(is_array($riwayatSertifikasi) && count($riwayatSertifikasi) > 0)
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Sertifikasi</th>
                                    <th>Lembaga Pelaksana</th>
                                    <th>Tahun</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riwayatSertifikasi as $index => $sertifikasi)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $sertifikasi['nama'] ?? '-' }}</td>
                                        <td>{{ $sertifikasi['lembaga'] ?? '-' }}</td>
                                        <td>{{ $sertifikasi['tahun'] ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-text">Riwayat sertifikasi belum tersedia.</div>
                    @endif
                </div>

                <div class="section">
                    <div class="section-title">VIII. Legalitas</div>
                    <table class="detail-table">
                        <tr><td class="label">Nomor KTP</td><td class="separator">:</td><td>{{ $legal['nik_ktp'] ?? '-' }}</td></tr>
                        <tr><td class="label">Nomor NPWP</td><td class="separator">:</td><td>{{ $legal['nomor_npwp'] ?? '-' }}</td></tr>
                        <tr><td class="label">Nomor BPJS</td><td class="separator">:</td><td>{{ $legal['nomor_bpjs'] ?? '-' }}</td></tr>
                    </table>
                </div>

                <div class="footer-note">
                    Dokumen ini dihasilkan otomatis oleh sistem pada {{ date('d/m/Y H:i') }}.
                </div>
            @endif
        </div>
    </div>
</body>
</html> </div>
    </div>

    <!-- jsPDF and html2pdf for Direct Client-side Download -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        let currentPaperSize = 'a4';

        // Change paper size and adjust page dimensions
        function changePaperSize(size) {
            currentPaperSize = size;
            const pageContent = document.getElementById('pageContent');
            const { width, height } = getPaperDimensions(size);
            
            pageContent.style.width = width + 'mm';
            pageContent.style.minHeight = height + 'mm';
            
            // Update all sheet widths for consistency
            const sheets = document.querySelectorAll('.sheet');
            sheets.forEach(sheet => {
                // Keep padding but adjust internal width for consistency
                sheet.style.maxWidth = 'none';
            });
            
            // Update paper selector value
            const paperSelector = document.getElementById('paperSize');
            if (paperSelector) {
                paperSelector.value = size;
            }
        }

        // Get paper dimensions in millimeters
        function getPaperDimensions(size) {
            const dimensions = {
                'a4': { width: 210, height: 297 },
                'legal': { width: 216, height: 356 },
                'folio': { width: 216, height: 330 }
            };
            return dimensions[size] || dimensions['a4'];
        }

        // Download PDF dengan html2pdf
        function downloadPDF() {
            const element = document.getElementById('pageContent');
            const btn = document.getElementById('btn-download');
            const originalContent = btn.innerHTML;
            
            // Show loading state
            btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="animation: spin 1s linear infinite;"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg> Memproses...`;
            btn.disabled = true;

            const { width, height } = getPaperDimensions(currentPaperSize);
            
            // Determine PDF format
            let pdfFormat = 'a4';
            if (currentPaperSize === 'legal') {
                pdfFormat = [216, 356]; // Legal size in mm
            } else if (currentPaperSize === 'folio') {
                pdfFormat = [216, 330]; // Folio size in mm
            }

            const opt = {
                margin: [0, 0, 0, 0],
                filename: 'DRH_{{ str_replace(" ", "_", $user->name) }}_' + new Date().getTime() + '.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, useCORS: true, logging: false, allowTaint: true },
                jsPDF: { unit: 'mm', format: pdfFormat, orientation: 'portrait' },
                pagebreak: { mode: ['css', 'legacy'] }
            };

            html2pdf().set(opt).from(element).save().then(function() {
                btn.innerHTML = originalContent;
                btn.disabled = false;
            }).catch(function(err) {
                console.error(err);
                btn.innerHTML = originalContent;
                btn.disabled = false;
                alert('Terjadi kesalahan saat membuat PDF: ' + (err.message || 'Silakan coba lagi.'));
            });
        }

        // Print DRH menggunakan browser print dialog
        function printDRH() {
            const btn = document.getElementById('btn-print');
            const originalContent = btn.innerHTML;
            
            btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="animation: spin 1s linear infinite;"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg> Loading...`;
            btn.disabled = true;

            setTimeout(function() {
                window.print();
                btn.innerHTML = originalContent;
                btn.disabled = false;
            }, 500);
        }

        // Inline CSS untuk animasi spin
        const style = document.createElement('style');
        style.textContent = `
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
            
            /* Print styles untuk kertas legal dan variasi lain */
            @media print {
                @page {
                    margin: 0 !important;
                    padding: 0 !important;
                }
                
                @page :first {
                    margin: 0 !important;
                    padding: 0 !important;
                }
                
                body {
                    margin: 0 !important;
                    padding: 0 !important;
                }
                
                .page {
                    width: 100% !important;
                    margin: 0 !important;
                    padding: 0 !important;
                    min-height: auto !important;
                    margin-top: 0 !important;
                }
                
                .sheet {
                    padding: 5mm 14mm 14mm 14mm !important;
                    margin: 0 !important;
                    page-break-after: always;
                }
                
                .sheet:last-child {
                    page-break-after: auto;
                }
            }
        `;
        document.head.appendChild(style);

        // Initialize paper size on page load
        window.addEventListener('load', function() {
            changePaperSize('a4');
        });
    </script>
</body>
</html>