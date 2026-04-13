<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume Medis Rawat Inap - {{ $data->nama ?? '' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header h2 {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .header .form-code {
            font-size: 10pt;
            color: #666;
        }

        .patient-info {
            margin-bottom: 15px;
        }

        .patient-info table {
            width: 100%;
            border-collapse: collapse;
        }

        .patient-info td {
            padding: 3px 0;
            font-size: 10pt;
        }

        .patient-info .label {
            width: 120px;
            font-weight: normal;
        }

        .patient-info .colon {
            width: 10px;
        }

        .patient-info .value {
            border-bottom: 1px dotted #000;
            padding-left: 5px;
        }

        .section {
            margin-bottom: 15px;
            page-break-inside: avoid;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 11pt;
        }

        .field-row {
            margin-bottom: 8px;
        }

        .field-label {
            font-weight: bold;
            margin-bottom: 3px;
            font-size: 10pt;
        }

        .field-value {
            border: 1px solid #000;
            padding: 5px;
            min-height: 25px;
            background: #fff;
        }

        .field-value.textarea {
            min-height: 60px;
        }

        .inline-fields {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }

        .inline-field {
            display: table-cell;
            padding-right: 10px;
        }

        .inline-field:last-child {
            padding-right: 0;
        }

        .checkbox-group {
            margin-top: 5px;
        }

        .checkbox-item {
            display: inline-block;
            margin-right: 15px;
            margin-bottom: 5px;
        }

        .checkbox {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 1px solid #000;
            margin-right: 5px;
            vertical-align: middle;
            position: relative;
        }

        .checkbox.checked::after {
            content: '✓';
            position: absolute;
            top: -3px;
            left: 2px;
            font-size: 14pt;
            font-weight: bold;
        }

        .radio-group {
            display: inline-block;
        }

        .radio-item {
            display: inline-block;
            margin-right: 15px;
        }

        .radio {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 1px solid #000;
            border-radius: 50%;
            margin-right: 5px;
            vertical-align: middle;
            position: relative;
        }

        .radio.checked::after {
            content: '';
            position: absolute;
            top: 3px;
            left: 3px;
            width: 8px;
            height: 8px;
            background: #000;
            border-radius: 50%;
        }

        .therapy-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 9pt;
        }

        .therapy-table th,
        .therapy-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        .therapy-table th {
            background: #f0f0f0;
            font-weight: bold;
        }

        .signature-section {
            margin-top: 20px;
            text-align: right;
        }

        .signature-box {
            display: inline-block;
            text-align: center;
            margin-top: 10px;
        }

        .signature-image {
            width: 150px;
            height: 80px;
            border: 1px solid #000;
            margin: 10px 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .signature-image img {
            max-width: 100%;
            max-height: 100%;
        }

        .footer-note {
            margin-top: 30px;
            font-size: 9pt;
            border-top: 1px solid #000;
            padding-top: 10px;
        }

        .footer-note p {
            margin-bottom: 3px;
        }

        @media print {
            body {
                padding: 10px;
            }
            
            .page-break {
                page-break-after: always;
            }
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <div class="header">
        <h2>RESUME MEDIS</h2>
        <div class="form-code">RM 3.5/RM/22</div>
    </div>

    <!-- IDENTITAS PASIEN -->
    <div class="patient-info">
        <table>
            <tr>
                <td class="label">Nama</td>
                <td class="colon">:</td>
                <td class="value">{{ $data->nama ?? '................................' }}</td>
                <td style="width: 30px;"></td>
                <td class="label" style="width: 80px;">No.RM</td>
                <td class="colon">:</td>
                <td class="value" style="width: 150px;">{{ $data->no_rm ?? '..................' }}</td>
            </tr>
            <tr>
                <td class="label">Tgl. Lahir</td>
                <td class="colon">:</td>
                <td class="value">
                    {{ $data->tanggal_lahir ? \Carbon\Carbon::parse($data->tanggal_lahir)->format('d/m/Y') : '................................' }}
                    &nbsp;&nbsp;&nbsp;
                    {{ $data->jenis_kelamin == 'L' ? 'L' : ($data->jenis_kelamin == 'P' ? 'P' : 'L/P') }}
                </td>
                <td></td>
                <td class="label">NIK</td>
                <td class="colon">:</td>
                <td class="value">{{ $data->nik ?? '..................' }}</td>
            </tr>
        </table>
    </div>

    <!-- INFORMASI RAWAT INAP -->
    <div class="section">
        <div class="inline-fields">
            <div class="inline-field" style="width: 50%;">
                <div class="field-label">Tanggal Masuk</div>
                <div class="field-value">
                    {{ $data->tanggal_masuk ? \Carbon\Carbon::parse($data->tanggal_masuk)->format('d/m/Y') : '' }}
                </div>
            </div>
            <div class="inline-field" style="width: 50%;">
                <div class="field-label">Tanggal Keluar / Tanggal Meninggal</div>
                <div class="field-value">
                    {{ $data->tanggal_keluar ? \Carbon\Carbon::parse($data->tanggal_keluar)->format('d/m/Y') : '' }}
                </div>
            </div>
        </div>

        <div class="field-row">
            <div class="field-label">Ruang Rawat terakhir</div>
            <div class="field-value">{{ $data->ruang_rawat ?? '' }}</div>
        </div>

        <div class="field-row">
            <div class="field-label">Penanggung Pembayaran</div>
            <div class="field-value">{{ $data->penanggung_pembayaran ?? '' }}</div>
        </div>

        <div class="field-row">
            <div class="field-label">Dokter Penanggung Jawab (DPJP)</div>
            <div class="field-value">dr. {{ $data->dpjp ?? '......................................................................' }}</div>
        </div>

        <div class="field-row">
            <div class="field-label">
                Rawat Tim Dokter: 
                <div class="radio-group">
                    <div class="radio-item">
                        <span class="radio {{ $data->rawat_tim == 'tidak' ? 'checked' : '' }}"></span> Tidak
                    </div>
                    <div class="radio-item">
                        <span class="radio {{ $data->rawat_tim == 'ya' ? 'checked' : '' }}"></span> Ya, Oleh
                    </div>
                </div>
            </div>
            @if($data->rawat_tim == 'ya')
            <div style="margin-left: 20px; margin-top: 5px;">
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 50%; padding: 3px;">1. dr. {{ $data->tim_dokter_1 ?? '................................' }}</td>
                        <td style="width: 50%; padding: 3px;">3. dr. {{ $data->tim_dokter_3 ?? '................................' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 3px;">2. dr. {{ $data->tim_dokter_2 ?? '................................' }}</td>
                        <td style="padding: 3px;">4. dr. {{ $data->tim_dokter_4 ?? '................................' }}</td>
                    </tr>
                </table>
            </div>
            @endif
        </div>
    </div>

    <!-- DATA KLINIS -->
    <div class="section">
        <div class="field-row">
            <div class="field-label">Alasan Dirawat</div>
            <div class="field-value textarea">{{ $data->alasan_dirawat ?? '' }}</div>
        </div>

        <div class="field-row">
            <div class="field-label">Diagnosa Masuk</div>
            <div class="field-value textarea">{{ $data->diagnosa_masuk ?? '' }}</div>
        </div>

        <div class="inline-fields">
            <div class="inline-field" style="width: 75%;">
                <div class="field-label">Diagnosa Keluar (Diagnosa Utama)</div>
                <div class="field-value">{{ $data->diagnosa_keluar ?? '' }}</div>
            </div>
            <div class="inline-field" style="width: 25%;">
                <div class="field-label">ICD</div>
                <div class="field-value">{{ $data->icd_utama ?? '' }}</div>
            </div>
        </div>

        <div class="field-row">
            <div class="field-label">Diagnosis Sekunder</div>
            <div class="field-value" style="padding: 3px;">
                @if($data->diagnosa_sekunder_1)
                <div>1. {{ $data->diagnosa_sekunder_1 }}</div>
                @endif
                @if($data->diagnosa_sekunder_2)
                <div>2. {{ $data->diagnosa_sekunder_2 }}</div>
                @endif
                @if($data->diagnosa_sekunder_3)
                <div>3. {{ $data->diagnosa_sekunder_3 }}</div>
                @endif
                @if($data->diagnosa_sekunder_4)
                <div>4. {{ $data->diagnosa_sekunder_4 }}</div>
                @endif
                @if(!$data->diagnosa_sekunder_1 && !$data->diagnosa_sekunder_2 && !$data->diagnosa_sekunder_3 && !$data->diagnosa_sekunder_4)
                <div>1. ........................................................................</div>
                <div>2. ........................................................................</div>
                <div>3. ........................................................................</div>
                <div>4. ........................................................................</div>
                @endif
            </div>
        </div>

        <div class="field-row">
            <div class="field-label">Penyebab Kematian (Secara Klinis)</div>
            <div class="field-value textarea">{{ $data->penyebab_kematian ?? '' }}</div>
        </div>

        <div class="field-row">
            <div class="field-label">Pemeriksaan Fisik Yang penting</div>
            <div class="field-value textarea">{{ $data->pemeriksaan_fisik ?? '' }}</div>
        </div>

        <div class="field-row">
            <div class="field-label">Laboratorium Yang Penting</div>
            <div class="field-value textarea">{{ $data->laboratorium ?? '' }}</div>
        </div>
    </div>

    <div class="page-break"></div>

    <!-- HALAMAN 2 -->
    <div class="section">
        <div class="field-row">
            <div class="field-label">Radiologi</div>
            <div class="field-value textarea">{{ $data->radiologi ?? '' }}</div>
        </div>

        <div class="field-row">
            <div class="field-label">Penunjang Lain</div>
            <div class="field-value textarea">{{ $data->penunjang_lain ?? '' }}</div>
        </div>

        <div class="inline-fields">
            <div class="inline-field" style="width: 75%;">
                <div class="field-label">Tindakan / Operasi</div>
                <div class="field-value">{{ $data->tindakan_operasi ?? '' }}</div>
            </div>
            <div class="inline-field" style="width: 25%;">
                <div class="field-label">ICD</div>
                <div class="field-value">{{ $data->icd_tindakan ?? '' }}</div>
            </div>
        </div>

        <div class="field-row">
            <div class="field-label">Pengobatan Selama Dirawat</div>
            <div class="field-value textarea">{{ $data->pengobatan ?? '' }}</div>
        </div>
    </div>

    <!-- KONDISI PULANG -->
    <div class="section">
        <div class="field-label">Kondisi Pulang</div>
        <div class="checkbox-group">
            <div class="checkbox-item">
                <span class="checkbox {{ $data->kondisi_sembuh ? 'checked' : '' }}"></span> Sembuh
            </div>
            <div class="checkbox-item">
                <span class="checkbox {{ $data->kondisi_pindah_rs ? 'checked' : '' }}"></span> Pindah RS
            </div>
            <div class="checkbox-item">
                <span class="checkbox {{ $data->kondisi_pulang_sendiri ? 'checked' : '' }}"></span> Pulang atas Permintaan Sendiri
            </div>
            <div class="checkbox-item">
                <span class="checkbox {{ $data->kondisi_meninggal ? 'checked' : '' }}"></span> Meninggal
            </div>
            <div class="checkbox-item">
                <span class="checkbox {{ $data->kondisi_lainnya ? 'checked' : '' }}"></span> Lain-Lain
            </div>
        </div>
    </div>

    <!-- FOLLOW UP -->
    <div class="section">
        <div class="section-title">Instruksi dan Edukasi Lanjutan (follow up)</div>

        <div class="inline-fields">
            <div class="inline-field" style="width: 33%;">
                <div class="field-label">Kontrol Tanggal</div>
                <div class="field-value">
                    {{ $data->kontrol_tanggal ? \Carbon\Carbon::parse($data->kontrol_tanggal)->format('d/m/Y') : '' }}
                </div>
            </div>
            <div class="inline-field" style="width: 33%;">
                <div class="field-label">Diet</div>
                <div class="field-value">{{ $data->diet ?? '' }}</div>
            </div>
            <div class="inline-field" style="width: 34%;">
                <div class="field-label">Latihan</div>
                <div class="field-value">{{ $data->latihan ?? '' }}</div>
            </div>
        </div>

        <div class="field-row">
            <div class="field-label">Segera kembali ke rumah Sakit, langsung ke Gawat Darurat, bila terjadi:</div>
            <div class="field-value textarea">{{ $data->kondisi_darurat ?? '' }}</div>
        </div>
    </div>

    <!-- TERAPI PULANG -->
    <div class="section">
        <div class="section-title">Terapi Pulang</div>
        <table class="therapy-table">
            <thead>
                <tr>
                    <th style="width: 25%;">Nama Obat</th>
                    <th style="width: 10%;">Jumlah</th>
                    <th style="width: 15%;">Dosis</th>
                    <th style="width: 15%;">Frekuensi</th>
                    <th style="width: 20%;">Cara Pemberian</th>
                    <th style="width: 15%;"></th>
                </tr>
            </thead>
            <tbody>
                @if($data->terapi_pulang && is_array($data->terapi_pulang) && count($data->terapi_pulang) > 0)
                    @foreach($data->terapi_pulang as $obat)
                    <tr>
                        <td>{{ $obat['nama_obat'] ?? '' }}</td>
                        <td>{{ $obat['jumlah'] ?? '' }}</td>
                        <td>{{ $obat['dosis'] ?? '' }}</td>
                        <td>{{ $obat['frekuensi'] ?? '' }}</td>
                        <td>{{ $obat['cara_pemberian'] ?? '' }}</td>
                        <td></td>
                    </tr>
                    @endforeach
                @else
                    @for($i = 0; $i < 5; $i++)
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    @endfor
                @endif
            </tbody>
        </table>
    </div>

    <!-- TANDA TANGAN -->
    <div class="signature-section">
        <div>Tanggal, {{ now()->format('d/m/Y') }}</div>
        <div style="margin-top: 10px; font-weight: bold;">Yang membuat</div>
        
        <div class="signature-box">
            @if($data->dokter_ttd)
            <div class="signature-image">
                <img src="{{ $data->dokter_ttd }}" alt="Tanda Tangan Dokter">
            </div>
            @else
            <div class="signature-image">
                <div style="color: #ccc;">(Tanda Tangan)</div>
            </div>
            @endif
            <div style="border-bottom: 1px solid #000; padding-top: 5px; min-width: 200px;">
                {{ $data->nama_dokter ?? '' }}
            </div>
            <div style="font-size: 9pt; margin-top: 3px;">Nama Jelas dan Tandatangan</div>
        </div>
    </div>

    <!-- FOOTER NOTE -->
    <div class="footer-note">
        <p>1. Lembar Asli Untuk arsip rekam Medis</p>
        <p>2. Lembar Kedua Untuk Pasien</p>
        <p>3. Lembar Ketiga Untuk Penjamin</p>
    </div>

</body>
</html>