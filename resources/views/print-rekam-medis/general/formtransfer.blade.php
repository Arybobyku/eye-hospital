<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>TRANSFER PASIEN</title>
    <style>
        @page { margin: 18px; }
        body { margin: 18px; font-family: Arial, sans-serif; font-size: 11px; }
        
        .wrap {
            width: 100%;
            height: auto;
            display: inline-block;
        }
        
        .left { display: inline-block; float: left; }
        .right { display: inline-block; float: right;}
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .border-table {
            border: 1px solid black;
        }
        
        .border-table td, .border-table th {
            border: 1px solid black;
            padding: 5px;
        }
        
        .no-border td {
            border: none;
            padding: 3px;
        }
        
        .checkbox {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 1px solid black;
            text-align: center;
            line-height: 12px;
            margin: 0 3px;
            vertical-align: middle;
        }
        
        .checkbox-checked {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 1px solid black;
            text-align: center;
            line-height: 12px;
            margin: 0 3px;
            vertical-align: middle;
        }
        
        .section-title {
            font-weight: bold;
            background-color: #f0f0f0;
            padding: 5px;
            margin-top: 10px;
        }
        
        .underline {
            border-bottom: 1px solid black;
            display: inline-block;
            min-width: 100px;
        }
        
        .dotted-line {
            border-bottom: 1px dotted black;
            display: inline-block;
            min-width: 150px;
        }
        
        .box-input {
            border: 1px solid black;
            padding: 3px 5px;
            display: inline-block;
            min-width: 150px;
        }
        
        .header-patient {
            margin-bottom: 10px;
        }
        
        .form-row {
            margin-bottom: 5px;
        }
        
        .label-box {
            border: 1px solid black;
            padding: 30px;
            text-align: center;
            margin-bottom: 10px;
        }
        
        .table-terapi {
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
        }
        
        .table-terapi th, .table-terapi td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }
        
        .table-terapi th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div style="position:fixed; right: 13px; bottom: 10px;"></div>

<?php $fullpath = storage_path('app/public/images/header_rme.png');  ?>  
<div class="wrap">
	<div style="width:100%; text-align:right; margin-bottom:5px">
		RM 2.6/TP/22
	</div>
	@include('print-rekam-medis.partials.header')
    
    
    <!-- Title -->
    <table class="border-table">
        <tr>
            <td style="font-weight: bold; text-align: center; padding: 10px; font-size: 14px;">
                TRANSFER PASIEN
            </td>
        </tr>
    </table>
    
    <!-- Info Transfer -->
    <table class="border-table" style="margin-top: 10px;">
        <tr>
            <td width="25%" style="padding: 5px;">Tanggal Masuk :</td>
            <td width="25%" style="padding: 5px;">{{ $data->tanggal_masuk ?? '' }}</td>
            <td width="25%" style="padding: 5px;">Tanggal Pindah :</td>
            <td width="25%" style="padding: 5px;">{{ $data->tanggal_pindah ?? '' }}</td>
        </tr>
        <tr>
            <td style="padding: 5px;">Asal Ruangan :</td>
            <td style="padding: 5px;">{{ $data->asal_ruangan ?? '' }}</td>
            <td style="padding: 5px;">Ruangan Selanjutnya :</td>
            <td style="padding: 5px;">{{ $data->ruangan_selanjutnya ?? '' }}</td>
        </tr>
        <tr>
            <td style="padding: 5px;">Dokter Yang Merawat :</td>
            <td colspan="3" style="padding: 5px;">{{ $data->dokter_yang_merawat ?? '' }}</td>
        </tr>
        <tr>
            <td style="padding: 5px;">Dokter Penanggung Jawab (DPJP) :</td>
            <td colspan="3" style="padding: 5px;">{{ $data->dpjp ?? '' }}</td>
        </tr>
    </table>
    
    <!-- Diagnosis dan Perhatian -->
    <table class="border-table" style="margin-top: 10px;">
        <tr>
            <td width="50%" style="padding: 5px; vertical-align: top;">
                <strong>Dianosa Utama :</strong><br>
                {{ $data->diagnosa_utama ?? '' }}
            </td>
            <td width="50%" style="padding: 5px; vertical-align: top;">
                <strong>Perlu menjadi perhatian :</strong><br>
                <span class="checkbox{{ in_array('Alergi', $alergi ?? []) ? '-checked' : '' }}">{{ in_array('Alergi', $alergi ?? []) ? '✓' : '' }}</span> Alergi, sebutkan <span class="dotted-line">{{ $data->alergi ?? '' }}</span><br>
                <span class="checkbox{{ in_array('MRSA', $mrsa ?? []) ? '-checked' : '' }}">{{ in_array('MRSA', $mrsa ?? []) ? '' : '' }}</span> MRSA
            </td>
        </tr>
    </table>
    
    <!-- Diagnosis Sekunder -->
    <table class="border-table" style="margin-top: 10px;">
        <tr>
            <td style="padding: 5px;">
                <strong>Diagnosa Sekunder :</strong>
                <ol style="margin: 5px 0; padding-left: 20px;">
                    <li>{{ $data->diagnosa_sekunder_1 ?? '' }}</li>
                    <li>{{ $data->diagnosa_sekunder_2 ?? '' }}</li>
                    <li>{{ $data->diagnosa_sekunder_3 ?? '' }}</li>
                    <li>{{ $data->diagnosa_sekunder_4 ?? '' }}</li>
                    <li>{{ $data->diagnosa_sekunder_5 ?? '' }}</li>
                </ol>
            </td>
        </tr>
    </table>
    
    <!-- Alasan dan Metode Perpindahan -->
    <table class="border-table" style="margin-top: 10px;">
        <tr>
            <td width="50%" style="padding: 5px; vertical-align: top;">
                <strong>Alasan perpindahan pasien :</strong><br>
                <div style="margin-top: 5px;">
                    1. Kondisi pasien : 
                    <span class="checkbox{{ $data->kondisi_pasien == 'memburuk' ? '-checked' : '' }}">{{ $data->kondisi_pasien == 'memburuk' ? '' : '' }}</span> memburuk 
                    <span class="checkbox{{ $data->kondisi_pasien == 'stabil' ? '-checked' : '' }}">{{ $data->kondisi_pasien == 'stabil' ? '' : '' }}</span> stabil
                    <span class="checkbox{{ $data->kondisi_pasien == 'tidak ada perubahan' ? '-checked' : '' }}">{{ $data->kondisi_pasien == 'tidak ada perubahan' ? '✓' : '' }}</span> tidak ada perubahan
                </div>
                <div style="margin-top: 5px;">
                    2. Fasilitas : 
                    <span class="checkbox{{ $data->fasilitas == 'kurang memadai' ? '-checked' : '' }}">{{ $data->fasilitas == 'kurang memadai' ? '✓' : '' }}</span> kurang memadai
                    <span class="checkbox{{ $data->fasilitas == 'membutuhkan peralatan yang lebih baik' ? '-checked' : '' }}">{{ $data->fasilitas == 'membutuhkan peralatan yang lebih baik' ? '✓' : '' }}</span> membutuhkan peralatan yang lebih baik
                </div>
                <div style="margin-top: 5px;">
                    3. Tenaga : 
                    <span class="checkbox{{ $data->tenaga == 'membutuhkan tenaga yang lebih ahli' ? '-checked' : '' }}">{{ $data->tenaga == 'membutuhkan tenaga yang lebih ahli' ? '✓' : '' }}</span> membutuhkan tenaga yang lebih ahli  
                    <span class="checkbox{{ $data->tenaga == 'jumlah tenaga kurang' ? '-checked' : '' }}">{{ $data->tenaga == 'jumlah tenaga kurang' ? '✓' : '' }}</span> jumlah tenaga kurang
                </div>
                <div style="margin-top: 5px;">
                    4. Lain-lain sebutkan : <span class="dotted-line">{{ $data->alasan_lainnya ?? '' }}</span>
                </div>
            </td>
            <td width="50%" style="padding: 5px; vertical-align: top;">
                <strong>Metode perpindahan pasien :</strong><br>
                <div style="margin-top: 5px;">
                    <span class="checkbox{{ $data->metode_perpindahan == 'Kursi Roda' ? '-checked' : '' }}">{{ $data->metode_perpindahan == 'Kursi Roda' ? '✓' : '' }}</span> Kursi Roda<br>
                    <span class="checkbox{{ $data->metode_perpindahan == 'Tempat tidur' ? '-checked' : '' }}">{{ $data->metode_perpindahan == 'Tempat tidur' ? '✓' : '' }}</span> Tempat tidur<br>
                    <span class="checkbox{{ $data->metode_perpindahan == 'Brankar/ stretcher' ? '-checked' : '' }}">{{ $data->metode_perpindahan == 'Brankar/ stretcher' ? '✓' : '' }}</span> Brankar/ stretcher
                </div>
            </td>
        </tr>
    </table>
    
    <!-- Persetujuan -->
    <table class="border-table" style="margin-top: 10px;">
        <tr>
            <td style="padding: 5px;">
                <span class="checkbox{{ $data->persetujuan_transfer == 'Ya' ? '-checked' : '' }}">{{ $data->persetujuan_transfer == 'Ya' ? '✓' : '' }}</span> 
                <strong>Pasien / keluarga mengetahui dan menyetujui mengenai alasan perpindahan*)</strong><br>
                <em style="font-size: 9px;">*) Ceklist pada kotak yang tersedia untuk pernyataan yang sesuai</em>
            </td>
        </tr>
    </table>
    
    <!-- Info Keluarga -->
    <table class="border-table" style="margin-top: 10px;">
        <tr>
            <td style="padding: 5px;">
                <strong>Bila pemberi persetujuan adalah keluarga pasien, lengkapi isian berikut :</strong><br>
                <table class="no-border" style="margin-top: 5px;">
                    <tr>
                        <td width="15%">Nama</td>
                        <td width="2%">:</td>
                        <td width="83%"><span class="dotted-line" style="width: 90%;">{{ $data->nama_keluarga ?? '' }}</span></td>
                    </tr>
                    <tr>
                        <td>Hubungan</td>
                        <td>:</td>
                        <td><span class="dotted-line" style="width: 90%;">{{ $data->hubungan_keluarga ?? '' }}</span></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
    <!-- Peralatan dan Keadaan Pasien -->
    <table class="border-table" style="margin-top: 10px;">
        <tr>
            <td width="50%" style="padding: 5px; vertical-align: top;">
                <strong>Peralatan yang menyertai pasien saat pindah :</strong><br>
                <div style="margin-top: 5px;">
                    <span class="checkbox{{ in_array('Portable', $data->peralatan ?? []) ? '-checked' : '' }}">{{ in_array('Portable', $data->peralatan ?? []) ? '✓' : '' }}</span> Portable<br>
                    <span class="checkbox{{ in_array('Alat Penghisap', $data->peralatan ?? []) ? '-checked' : '' }}">{{ in_array('Alat Penghisap', $data->peralatan ?? []) ? '✓' : '' }}</span> Alat Penghisap<br>
                    <span class="checkbox{{ in_array('Bagging', $data->peralatan ?? []) ? '-checked' : '' }}">{{ in_array('Bagging', $data->peralatan ?? []) ? '✓' : '' }}</span> Bagging<br>
                    <span class="checkbox{{ in_array('NGT', $data->peralatan ?? []) ? '-checked' : '' }}">{{ in_array('NGT', $data->peralatan ?? []) ? '✓' : '' }}</span> NGT<br>
                    <span class="checkbox{{ in_array('Ventilator', $data->peralatan ?? []) ? '-checked' : '' }}">{{ in_array('Ventilator', $data->peralatan ?? []) ? '✓' : '' }}</span> Ventilator<br>
                    <span class="checkbox{{ in_array('Kateter Urin', $data->peralatan ?? []) ? '-checked' : '' }}">{{ in_array('Kateter Urin', $data->peralatan ?? []) ? '✓' : '' }}</span> Kateter Urin<br>
                    <span class="checkbox{{ in_array('Pompa Infus', $data->peralatan ?? []) ? '-checked' : '' }}">{{ in_array('Pompa Infus', $data->peralatan ?? []) ? '✓' : '' }}</span> Pompa Infus
                </div>
            </td>
            <td width="50%" style="padding: 5px; vertical-align: top;">
                <strong>Keadaan pasien saat pindah :</strong><br>
                <table class="no-border" style="margin-top: 5px;">
                    <tr>
                        <td width="40%">Keadaan Umum</td>
                        <td width="2%">:</td>
                        <td width="58%">{{ $data->keadaan_umum ?? '' }}</td>
                    </tr>
                    <tr>
                        <td>Kesadaran</td>
                        <td>:</td>
                        <td>{{ $data->kesadaran ?? '' }}</td>
                    </tr>
                    <tr>
                        <td>Status Nyeri</td>
                        <td>:</td>
                        <td>{{ $data->status_nyeri ?? '' }}</td>
                    </tr>
                    <tr>
                        <td>TD</td>
                        <td>:</td>
                        <td>{{ $data->tekanan_darah ?? '' }} mmHg</td>
                    </tr>
                    <tr>
                        <td>Nadi</td>
                        <td>:</td>
                        <td>{{ $data->nadi ?? '' }} x/menit</td>
                    </tr>
                    <tr>
                        <td>Suhu</td>
                        <td>:</td>
                        <td>{{ $data->suhu ?? '' }} °C</td>
                    </tr>
                    <tr>
                        <td>Pernafasan</td>
                        <td>:</td>
                        <td>{{ $data->pernafasan ?? '' }} x/menit</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
    <!-- TTD Keluarga -->
    <table class="border-table" style="margin-top: 10px;">
        <tr>
            <td style="padding: 5px; text-align: center;">
                <div style="margin-bottom: 5px;"><strong>Tanda Tangan Keluarga</strong></div>
                <div style="margin: 10px 0;">
                    @if(!empty($data->ttd_keluarga))
                        <img src="{{ $data->ttd_keluarga }}" alt="TTD Keluarga" width="150px">
                    @endif
                </div>
                <div>( {{ $data->nama_keluarga_ttd ?? '..............................' }} )</div>
            </td>
        </tr>
    </table>
    
    <!-- INFORMASI MEDIS -->
    <table class="border-table" style="margin-top: 10px;">
        <tr>
            <td colspan="2" style="padding: 5px; background-color: #f0f0f0;">
                <strong>INFORMASI MEDIS</strong>
            </td>
        </tr>
        <tr>
            <td width="50%" style="padding: 5px; vertical-align: top;">
                <strong>Pendamping Pasien saat pindah :</strong><br>
                <div style="margin-top: 5px;">
                    Nama Petugas : <span class="dotted-line" style="width: 60%;">{{ $data->nama_pendamping ?? '' }}</span>
                </div>
                <div style="margin-top: 10px; font-size: 9px; font-style: italic;">
                    *Berikan tanda pada kondisi yang sesuai
                </div>
            </td>
            <td width="50%" style="padding: 5px; vertical-align: top;">
                <strong>Disabilitas</strong><br>
                <table style="width: 100%; margin-top: 5px;">
                    <tr>
                        <td width="50%">
                            <span class="checkbox{{ in_array('Amputasi', $data->disabilitas ?? []) ? '-checked' : '' }}">{{ in_array('Amputasi', $data->disabilitas ?? []) ? '✓' : '' }}</span> Amputasi<br>
                            <span class="checkbox{{ in_array('Paralisis', $data->disabilitas ?? []) ? '-checked' : '' }}">{{ in_array('Paralisis', $data->disabilitas ?? []) ? '✓' : '' }}</span> Paralisis<br>
                            <span class="checkbox{{ in_array('Gangguan Mental', $data->disabilitas ?? []) ? '-checked' : '' }}">{{ in_array('Gangguan Mental', $data->disabilitas ?? []) ? '✓' : '' }}</span> Gangguan Mental
                        </td>
                        <td width="50%">
                            <span class="checkbox{{ in_array('Kontraktur', $data->disabilitas ?? []) ? '-checked' : '' }}">{{ in_array('Kontraktur', $data->disabilitas ?? []) ? '✓' : '' }}</span> Kontraktur<br>
                            <span class="checkbox{{ in_array('Ulkus Dikubitus', $data->disabilitas ?? []) ? '-checked' : '' }}">{{ in_array('Ulkus Dikubitus', $data->disabilitas ?? []) ? '✓' : '' }}</span> Ulkus Dikubitus
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
    <!-- Gangguan -->
    <table class="border-table" style="margin-top: 10px;">
        <tr>
            <td width="50%" style="padding: 5px; vertical-align: top;">
                <strong>Gangguan</strong><br>
                <table style="width: 100%; margin-top: 5px;">
                    <tr>
                        <td width="50%">
                            <span class="checkbox{{ in_array('Bicara', $data->gangguan ?? []) ? '-checked' : '' }}">{{ in_array('Bicara', $data->gangguan ?? []) ? '✓' : '' }}</span> Bicara<br>
                            <span class="checkbox{{ in_array('Pendengaran', $data->gangguan ?? []) ? '-checked' : '' }}">{{ in_array('Pendengaran', $data->gangguan ?? []) ? '✓' : '' }}</span> Pendengaran
                        </td>
                        <td width="50%">
                            <span class="checkbox{{ in_array('Penglihatan', $data->gangguan ?? []) ? '-checked' : '' }}">{{ in_array('Penglihatan', $data->gangguan ?? []) ? '✓' : '' }}</span> Penglihatan<br>
                            <span class="checkbox{{ in_array('Sensasi', $data->gangguan ?? []) ? '-checked' : '' }}">{{ in_array('Sensasi', $data->gangguan ?? []) ? '✓' : '' }}</span> Sensasi
                        </td>
                    </tr>
                </table>
            </td>
            <td width="50%" style="padding: 5px; vertical-align: top;">
                <strong>Inkotinensia</strong><br>
                <table style="width: 100%; margin-top: 5px;">
                    <tr>
                        <td width="33%">
                            <span class="checkbox{{ in_array('Urin', $data->inkontinensia ?? []) ? '-checked' : '' }}">{{ in_array('Urin', $data->inkontinensia ?? []) ? '✓' : '' }}</span> Urin
                        </td>
                        <td width="33%">
                            <span class="checkbox{{ in_array('Saliva', $data->inkontinensia ?? []) ? '-checked' : '' }}">{{ in_array('Saliva', $data->inkontinensia ?? []) ? '✓' : '' }}</span> Saliva
                        </td>
                        <td width="34%">
                            <span class="checkbox{{ in_array('Alvi', $data->inkontinensia ?? []) ? '-checked' : '' }}">{{ in_array('Alvi', $data->inkontinensia ?? []) ? '✓' : '' }}</span> Alvi
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
    <!-- Potensial Rehabilitasi -->
    <table class="border-table" style="margin-top: 10px;">
        <tr>
            <td style="padding: 5px;">
                <strong>Potensial untuk dilakukan rehabilitasi</strong><br>
                <span class="checkbox{{ $data->potensial_rehabilitasi == 'Baik' ? '-checked' : '' }}">{{ $data->potensial_rehabilitasi == 'Baik' ? '✓' : '' }}</span> Baik
                <span class="checkbox{{ $data->potensial_rehabilitasi == 'Sedang' ? '-checked' : '' }}">{{ $data->potensial_rehabilitasi == 'Sedang' ? '✓' : '' }}</span> Sedang
                <span class="checkbox{{ $data->potensial_rehabilitasi == 'Buruk' ? '-checked' : '' }}">{{ $data->potensial_rehabilitasi == 'Buruk' ? '✓' : '' }}</span> Buruk
            </td>
        </tr>
    </table>
    
    <!-- Pemeriksaan Fisik -->
    <table class="border-table" style="margin-top: 10px;">
        <tr>
            <td style="padding: 5px;">
                <strong>Pemeriksaan Fisik :</strong><br>
                <div style="margin-top: 5px;">
                    <strong>Status Generalis (temuan yang signifikan)</strong><br>
                    {{ $data->status_generalis ?? '' }}
                </div>
                <div style="margin-top: 10px;">
                    <strong>Status Lokalis (temuan yang signifikan)</strong><br>
                    {{ $data->status_lokalis ?? '' }}
                </div>
            </td>
        </tr>
    </table>
    
    <!-- PAGE BREAK untuk halaman ke-2 -->
    <div style="page-break-before: always;"></div>
    
    <!-- Status Kemandirian -->
    <table class="border-table" style="margin-top: 10px;">
        <tr>
            <td colspan="4" style="padding: 5px; background-color: #f0f0f0;">
                <strong>Status Kemandirian</strong>
            </td>
        </tr>
        <tr style="background-color: #f9f9f9;">
            <td width="25%" style="padding: 5px; text-align: center;"><strong>Aktivitas</strong></td>
            <td width="25%" style="padding: 5px; text-align: center;"><strong>Mandiri</strong></td>
            <td width="25%" style="padding: 5px; text-align: center;"><strong>Butuh bantuan</strong></td>
            <td width="25%" style="padding: 5px; text-align: center;"><strong>Tidak mampu</strong></td>
        </tr>
        <tr>
            <td style="padding: 5px;"><strong>Aktivitas ditempat tidur</strong></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td style="padding: 5px; padding-left: 15px;">Berguling</td>
            <td style="padding: 5px; text-align: center;">
                <span class="checkbox{{ $data->aktivitas_berguling == 'Mandiri' ? '-checked' : '' }}">{{ $data->aktivitas_berguling == 'Mandiri' ? '✓' : '' }}</span>
            </td>
            <td style="padding: 5px; text-align: center;">
                <span class="checkbox{{ $data->aktivitas_berguling == 'Butuh bantuan' ? '-checked' : '' }}">{{ $data->aktivitas_berguling == 'Butuh bantuan' ? '✓' : '' }}</span>
            </td>
            <td style="padding: 5px; text-align: center;">
                <span class="checkbox{{ $data->aktivitas_berguling == 'Tidak mampu' ? '-checked' : '' }}">{{ $data->aktivitas_berguling == 'Tidak mampu' ? '✓' : '' }}</span>
            </td>
        </tr>
        <tr>
            <td style="padding: 5px; padding-left: 15px;">Duduk</td>
            <td style="padding: 5px; text-align: center;">
                <span class="checkbox{{ $data->aktivitas_duduk == 'Mandiri' ? '-checked' : '' }}">{{ $data->aktivitas_duduk =='Mandiri' ? '✓' : '' }}</span>
</td>
<td style="padding: 5px; text-align: center;">
<span class="checkbox{{ $data->aktivitas_duduk == 'Butuh bantuan' ? '-checked' : '' }}">{{ $data->aktivitas_duduk == 'Butuh bantuan' ? '✓' : '' }}</span>
</td>
<td style="padding: 5px; text-align: center;">
<span class="checkbox{{ $data->aktivitas_duduk == 'Tidak mampu' ? '-checked' : '' }}">{{ $data->aktivitas_duduk == 'Tidak mampu' ? '✓' : '' }}</span>
</td>
</tr>
<tr>
<td style="padding: 5px;"><strong>Hygiene Pribadi</strong></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr>
<td style="padding: 5px; padding-left: 15px;">Wajah, rambut, tangan</td>
<td style="padding: 5px; text-align: center;">
<span class="checkbox{{ $data->hygiene_wajah == 'Mandiri' ? '-checked' : '' }}">{{ $data->hygiene_wajah == 'Mandiri' ? '✓' : '' }}</span>
</td>
<td style="padding: 5px; text-align: center;">
<span class="checkbox{{ $data->hygiene_wajah == 'Butuh bantuan' ? '-checked' : '' }}">{{ $data->hygiene_wajah == 'Butuh bantuan' ? '✓' : '' }}</span>
</td>
<td style="padding: 5px; text-align: center;">
<span class="checkbox{{ $data->hygiene_wajah == 'Tidak mampu' ? '-checked' : '' }}">{{ $data->hygiene_wajah == 'Tidak mampu' ? '✓' : '' }}</span>
</td>
</tr>
<tr>
<td style="padding: 5px; padding-left: 15px;">Batang tubuh & perineum</td>
<td style="padding: 5px; text-align: center;">
<span class="checkbox{{ $data->hygiene_tubuh == 'Mandiri' ? '-checked' : '' }}">{{ $data->hygiene_tubuh == 'Mandiri' ? '✓' : '' }}</span>
</td>
<td style="padding: 5px; text-align: center;">
<span class="checkbox{{ $data->hygiene_tubuh == 'Butuh bantuan' ? '-checked' : '' }}">{{ $data->hygiene_tubuh == 'Butuh bantuan' ? '✓' : '' }}</span>
</td>
<td style="padding: 5px; text-align: center;">
<span class="checkbox{{ $data->hygiene_tubuh == 'Tidak mampu' ? '-checked' : '' }}">{{ $data->hygiene_tubuh == 'Tidak mampu' ? '✓' : '' }}</span>
</td>
</tr>
<tr>
<td style="padding: 5px; padding-left: 15px;">Ekstermitas bawah</td>
<td style="padding: 5px; text-align: center;">
<span class="checkbox{{ $data->hygiene_ekstremitas == 'Mandiri' ? '-checked' : '' }}">{{ $data->hygiene_ekstremitas == 'Mandiri' ? '✓' : '' }}</span>
</td>
<td style="padding: 5px; text-align: center;">
<span class="checkbox{{ $data->hygiene_ekstremitas == 'Butuh bantuan' ? '-checked' : '' }}">{{ $data->hygiene_ekstremitas == 'Butuh bantuan' ? '✓' : '' }}</span>
</td>
<td style="padding: 5px; text-align: center;">
<span class="checkbox{{ $data->hygiene_ekstremitas == 'Tidak mampu' ? '-checked' : '' }}">{{ $data->hygiene_ekstremitas == 'Tidak mampu' ? '✓' : '' }}</span>
</td>
</tr>
<tr>
<td style="padding: 5px; padding-left: 15px;">Mulut</td>
<td style="padding: 5px; text-align: center;">
<span class="checkbox{{ $data->hygiene_mulut == 'Mandiri' ? '-checked' : '' }}">{{ $data->hygiene_mulut == 'Mandiri' ? '✓' : '' }}</span>
</td>
<td style="padding: 5px; text-align: center;">
<span class="checkbox{{ $data->hygiene_mulut == 'Butuh bantuan' ? '-checked' : '' }}">{{ $data->hygiene_mulut == 'Butuh bantuan' ? '✓' : '' }}</span>
</td>
<td style="padding: 5px; text-align: center;">
<span class="checkbox{{ $data->hygiene_mulut == 'Tidak mampu' ? '-checked' : '' }}">{{ $data->hygiene_mulut == 'Tidak mampu' ? '✓' : '' }}</span>
</td>
</tr>
<tr>
<td style="padding: 5px;"><strong>Berpakaian</strong></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr>
<td style="padding: 5px; padding-left: 15px;">Ekstermitas atas</td>
<td style="padding: 5px; text-align: center;">
<span class="checkbox{{ $data->pakaian_atas == 'Mandiri' ? '-checked' : '' }}">{{ $data->pakaian_atas == 'Mandiri' ? '✓' : '' }}</span>
</td>
<td style="padding: 5px; text-align: center;">
<span class="checkbox{{ $data->pakaian_atas == 'Butuh bantuan' ? '-checked' : '' }}">{{ $data->pakaian_atas == 'Butuh bantuan' ? '✓' : '' }}</span>
</td>
<td style="padding: 5px; text-align: center;">
<span class="checkbox{{ $data->pakaian_atas == 'Tidak mampu' ? '-checked' : '' }}">{{ $data->pakaian_atas == 'Tidak mampu' ? '✓' : '' }}</span>
</td>
</tr>
<tr>
<td style="padding: 5px; padding-left: 15px;">Batang tubuh</td>
<td style="padding: 5px; text-align: center;">
<span class="checkbox{{ $data->pakaian_tubuh == 'Mandiri' ? '-checked' : '' }}">{{ $data->pakaian_tubuh == 'Mandiri' ? '✓' : '' }}</span>
</td>
<td style="padding: 5px; text-align: center;">
<span class="checkbox{{ $data->pakaian_tubuh == 'Butuh bantuan' ? '-checked' : '' }}">{{ $data->pakaian_tubuh == 'Butuh bantuan' ? '✓' : '' }}</span>
</td>
<td style="padding: 5px; text-align: center;">
<span class="checkbox{{ $data->pakaian_tubuh == 'Tidak mampu' ? '-checked' : '' }}">{{ $data->pakaian_tubuh == 'Tidak mampu' ? '✓' : '' }}</span>
</td>
</tr>
<tr>
<td style="padding: 5px; padding-left: 15px;">Ekstermitas bawah</td>
<td style="padding: 5px; text-align: center;">
<span class="checkbox{{ $data->pakaian_bawah == 'Mandiri' ? '-checked' : '' }}">{{ $data->pakaian_bawah == 'Mandiri' ? '✓' : '' }}</span>
</td>
<td style="padding: 5px; text-align: center;">
<span class="checkbox{{ $data->pakaian_bawah == 'Butuh bantuan' ? '-checked' : '' }}">{{ $data->pakaian_bawah == 'Butuh bantuan' ? '✓' : '' }}</span>
</td>
<td style="padding: 5px; text-align: center;">
<span class="checkbox{{ $data->pakaian_bawah == 'Tidak mampu' ? '-checked' : '' }}">{{ $data->pakaian_bawah == 'Tidak mampu' ? '✓' : '' }}</span>
</td>
</tr>
<tr>
<td style="padding: 5px;"><strong>Cara memberi makan</strong></td>
<td style="padding: 5px; text-align: center;">
<span class="checkbox{{ $data->cara_makan == 'Mandiri' ? '-checked' : '' }}">{{ $data->cara_makan == 'Mandiri' ? '✓' : '' }}</span>
</td>
<td style="padding: 5px; text-align: center;">
<span class="checkbox{{ $data->cara_makan == 'Butuh bantuan' ? '-checked' : '' }}">{{ $data->cara_makan == 'Butuh bantuan' ? '✓' : '' }}</span>
</td>
<td style="padding: 5px; text-align: center;">
<span class="checkbox{{ $data->cara_makan == 'Tidak mampu' ? '-checked' : '' }}">{{ $data->cara_makan == 'Tidak mampu' ? '✓' : '' }}</span>
</td>
</tr>
<tr>
<td style="padding: 5px;"><strong>Pergerakan</strong></td>
<td></td>
<td></td>
<td></td>
</tr>
<tr>
<td style="padding: 5px; padding-left: 15px;">Jalan kaki</td>
<td style="padding: 5px; text-align: center;">
<span class="checkbox{{ $data->pergerakan_jalan == 'Mandiri' ? '-checked' : '' }}">{{ $data->pergerakan_jalan == 'Mandiri' ? '✓' : '' }}</span>
</td>
<td style="padding: 5px; text-align: center;">
<span class="checkbox{{ $data->pergerakan_jalan == 'Butuh bantuan' ? '-checked' : '' }}">{{ $data->pergerakan_jalan == 'Butuh bantuan' ? '✓' : '' }}</span>
</td>
<td style="padding: 5px; text-align: center;">
<span class="checkbox{{ $data->pergerakan_jalan == 'Tidak mampu' ? '-checked' : '' }}">{{ $data->pergerakan_jalan == 'Tidak mampu' ? '✓' : '' }}</span>
</td>
</tr>
<tr>
<td style="padding: 5px; padding-left: 15px;">Kursi roda</td>
<td style="padding: 5px; text-align: center;">
<span class="checkbox{{ $data->pergerakan_kursi_roda == 'Mandiri' ? '-checked' : '' }}">{{ $data->pergerakan_kursi_roda == 'Mandiri' ? '✓' : '' }}</span>
</td>
<td style="padding: 5px; text-align: center;">
<span class="checkbox{{ $data->pergerakan_kursi_roda == 'Butuh bantuan' ? '-checked' : '' }}">{{ $data->pergerakan_kursi_roda == 'Butuh bantuan' ? '✓' : '' }}</span>
</td>
<td style="padding: 5px; text-align: center;">
<span class="checkbox{{ $data->pergerakan_kursi_roda == 'Tidak mampu' ? '-checked' : '' }}">{{ $data->pergerakan_kursi_roda == 'Tidak mampu' ? '✓' : '' }}</span>
</td>
</tr>
</table>

<!-- Pemeriksaan Penunjang -->
<table class="border-table" style="margin-top: 10px;">
    <tr>
        <td style="padding: 5px;">
            <strong>Pemeriksaan penunjang / diagnostic yang sudah dilakukan (EKG, Lab, dll).</strong><br>
            <div style="margin-top: 5px;">
                {{ $data->pemeriksaan_penunjang ?? '' }}
            </div>
        </td>
    </tr>
</table>

<!-- Intervensi / Tindakan -->
<table class="border-table" style="margin-top: 10px;">
    <tr>
        <td style="padding: 5px;">
            <strong>Intervensi / tindakan yang sudah dilakukan :</strong><br>
            <div style="margin-top: 5px;">
                {{ $data->intervensi_tindakan ?? '' }}
            </div>
        </td>
    </tr>
</table>

<!-- Diet -->
<table class="border-table" style="margin-top: 10px;">
    <tr>
        <td style="padding: 5px;">
            <strong>Diet :</strong> {{ $data->diet ?? '' }}
        </td>
    </tr>
</table>

<!-- Rencana Perawatan -->
<table class="border-table" style="margin-top: 10px;">
    <tr>
        <td style="padding: 5px;">
            <strong>Rencana Perawatan Selanjutnya</strong><br>
            <div style="margin-top: 5px;">
                {{ $data->rencana_perawatan ?? '' }}
            </div>
        </td>
    </tr>
</table>

<!-- Terapi Saat Pindah -->
<table class="border-table" style="margin-top: 10px;">
    <tr>
        <td colspan="10" style="padding: 5px; background-color: #f0f0f0; text-align: center;">
            <strong>Terapi Saat Pindah</strong>
        </td>
    </tr>
    <tr style="background-color: #f9f9f9;">
        <th style="padding: 5px; width: 20%;">Nama Obat</th>
        <th style="padding: 5px; width: 10%;">Jumlah</th>
        <th style="padding: 5px; width: 10%;">Dosis</th>
        <th style="padding: 5px; width: 10%;">Frekuensi</th>
        <th style="padding: 5px; width: 10%;">Cara Pemberian</th>
        <th style="padding: 5px; width: 20%;">Nama Obat</th>
        <th style="padding: 5px; width: 10%;">Jumlah</th>
        <th style="padding: 5px; width: 10%;">Dosis</th>
        <th style="padding: 5px; width: 10%;">Frekuensi</th>
        <th style="padding: 5px; width: 10%;">Cara Pemberian</th>
    </tr>
    @if(!empty($data->terapi_obat) && is_array($data->terapi_obat))
        @foreach($data->terapi_obat as $index => $obat)
            @if($index % 2 == 0)
                <tr>
                    <td style="padding: 5px;">{{ $obat['nama_obat'] ?? '' }}</td>
                    <td style="padding: 5px;">{{ $obat['jumlah'] ?? '' }}</td>
                    <td style="padding: 5px;">{{ $obat['dosis'] ?? '' }}</td>
                    <td style="padding: 5px;">{{ $obat['frekuensi'] ?? '' }}</td>
                    <td style="padding: 5px;">{{ $obat['cara_pemberian'] ?? '' }}</td>
                    @if(isset($data->terapi_obat[$index + 1]))
                        <td style="padding: 5px;">{{ $data->terapi_obat[$index + 1]['nama_obat'] ?? '' }}</td>
                        <td style="padding: 5px;">{{ $data->terapi_obat[$index + 1]['jumlah'] ?? '' }}</td>
                        <td style="padding: 5px;">{{ $data->terapi_obat[$index + 1]['dosis'] ?? '' }}</td>
                        <td style="padding: 5px;">{{ $data->terapi_obat[$index + 1]['frekuensi'] ?? '' }}</td>
                        <td style="padding: 5px;">{{ $data->terapi_obat[$index + 1]['cara_pemberian'] ?? '' }}</td>
                    @else
                        <td style="padding: 5px;"></td>
                        <td style="padding: 5px;"></td>
                        <td style="padding: 5px;"></td>
                        <td style="padding: 5px;"></td>
                        <td style="padding: 5px;"></td>
                    @endif
                </tr>
            @endif
        @endforeach
    @else
        <tr>
            <td style="padding: 5px;"></td>
            <td style="padding: 5px;"></td>
            <td style="padding: 5px;"></td>
            <td style="padding: 5px;"></td>
            <td style="padding: 5px;"></td>
            <td style="padding: 5px;"></td>
            <td style="padding: 5px;"></td>
            <td style="padding: 5px;"></td>
            <td style="padding: 5px;"></td>
            <td style="padding: 5px;"></td>
        </tr>
    @endif
</table>

<!-- Signatures -->
<table style="width: 100%; margin-top: 20px;">
    <tr>
        <td width="50%" style="padding: 10px; vertical-align: top;">
            <div style="text-align: center;">
                <strong>Dokter yang mengirim</strong> Jam {{ $data->jam_dokter_mengirim ?? '............' }}<br>
                <div style="margin: 20px 0;">
                    @if(!empty($data->ttd_dokter_mengirim))
                        <img src="{{ $data->ttd_dokter_mengirim }}" alt="TTD Dokter Mengirim" width="150px">
                    @endif
                </div>
                <div style="border-bottom: 1px solid black; display: inline-block; min-width: 200px;">
                    {{ $data->nama_dokter_mengirim ?? '' }}
                </div><br>
                <small>Tanda tangan dan nama lengkap</small>
            </div>
            <div style="text-align: right; margin-top: 10px;">
                Medan, {{ $data->tanggal_transfer ?? '................................' }}
            </div>
        </td>
        <td width="50%" style="padding: 10px; vertical-align: top;">
            <div style="text-align: center;">
                <strong>Dokter yang menerima</strong> Jam {{ $data->jam_dokter_menerima ?? '............' }}<br>
                <div style="margin: 20px 0;">
                    @if(!empty($data->ttd_dokter_menerima))
                        <img src="{{ $data->ttd_dokter_menerima }}" alt="TTD Dokter Menerima" width="150px">
                    @endif
                </div>
                <div style="border-bottom: 1px solid black; display: inline-block; min-width: 200px;">
                    {{ $data->nama_dokter_menerima ?? '' }}
                </div><br>
                <small>Tanda tangan dan nama lengkap</small>
            </div>
        </td>
    </tr>
</table>

<!-- Footer Statement -->
<table class="border-table" style="margin-top: 20px;">
    <tr>
        <td style="padding: 10px; text-align: center;">
            <strong>Seluruh proses pemindahan pasien telah selesai dan dilakukan sesuai standar prosedur operasional yang diterapkan</strong>
        </td>
    </tr>
</table>

<!-- Perawat Signatures -->
<table style="width: 100%; margin-top: 20px;">
    <tr>
        <td width="50%" style="padding: 10px; vertical-align: top;">
            <div style="text-align: center;">
                <strong>Perawat yang mengantar</strong><br>
                <div style="margin: 20px 0;">
                    @if(!empty($data->ttd_perawat_mengantar))
                        <img src="{{ $data->ttd_perawat_mengantar }}" alt="TTD Perawat Mengantar" width="150px">
                    @endif
                </div>
                <div style="border-bottom: 1px solid black; display: inline-block; min-width: 200px;">
                    {{ $data->nama_perawat_mengantar ?? '' }}
                </div><br>
                <small>Nama petugas dan tanda tangan</small>
            </div>
        </td>
        <td width="50%" style="padding: 10px; vertical-align: top;">
            <div style="text-align: center;">
                <strong>Perawat yang menerima</strong><br>
                <div style="margin: 20px 0;">
                    @if(!empty($data->ttd_perawat_menerima))
                        <img src="{{ $data->ttd_perawat_menerima }}" alt="TTD Perawat Menerima" width="150px">
                    @endif
                </div>
                <div style="border-bottom: 1px solid black; display: inline-block; min-width: 200px;">
                    {{ $data->nama_perawat_menerima ?? '' }}
                </div><br>
                <small>Nama petugas dan tanda tangan</small>
            </div>
        </td>
    </tr>
</table>
</div>
</body>
</html>