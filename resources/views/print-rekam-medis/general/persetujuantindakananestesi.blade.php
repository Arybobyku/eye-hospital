<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>REKAM MEDIS GENERAL - PERSETUJUAN TINDAKAN ANESTESI</title>
    <style>
        @page {
            margin: 18px;
        }

        body {
            margin: 18px;
            font-family: Arial, sans-serif;
            font-size: 11px;
        }
        .tandai-checkbox {
            width: 12px;
            height: 12px;
            border: 1px solid #000;
            display: inline-block;
            position: relative;
        }

        .tandai-checkbox.checked::after {
            content: "X";
            position: absolute;
            top: -2px;
            left: 2px;
            font-size: 12px;
            font-weight: bold;
        }


        .wrap {
            width: 100%;
            height: auto;
            display: inline-block;
        }

        .tablee {
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
        }

        .tablee td,
        .tablee th {
            border: 1px solid black;
            padding: 6px;
            vertical-align: top;
        }

        .tablee th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }

        .header-row {
            font-weight: bold;
            text-align: center;
            background-color: #ffffff;
        }
        .inner-table {
            width: 100%;
            border-collapse: collapse;
        }

        .inner-table td {
            border: none;
            vertical-align: middle;
            padding: 0;
        }

        /* checkbox */
        .inner-table td input[type="checkbox"] {
            display: block;
            margin: 0 auto;
        }

        /* teks setelah checkbox */
        .inner-table td + td {
            padding-left: 3px;
        }
        .line {
            display: inline-block;
            border-bottom: 1px solid #000;
            min-width: 120px;
            height: 12px;
            vertical-align: bottom;
        }

        .line.short {
            min-width: 80px;
        }

        .line.long {
            min-width: 100px;
        }

        .ttd-img {
            max-width: 150px;
            max-height: 80px;
            display: block;
            margin: 5px auto;
        }

    </style>
</head>

<body>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 4.2/PTA/22
        </div>
        
        @include('print-rekam-medis.partials.header')
        
        <table class="tablee">
            <!-- HEADER TITLE -->
            <tr>
                <td colspan="4" class="header-row">PERSETUJUAN TINDAKAN ANESTESI</td>
            </tr>
            
            <!-- SUB HEADER -->
            <tr>
                <td colspan="4" class="header-row">PEMBERIAN INFORMASI TINDAKAN PEMBIUSAN</td>
            </tr>
            
            <!-- INFORMASI DOKTER & PENERIMA -->
            <tr>
                <td colspan="4">
                    <table class="inner-table">
                        <tr>
                            <td style="width: 35%;">Dokter Pelaksana Tindakan</td>
                            <td style="width: 2%;">:</td>
                            <td style="width: 63%;"><strong>{{ $data->dokter_pelaksana }}</strong></td>
                        </tr>
                        <tr>
                            <td>Pemberi Informasi</td>
                            <td>:</td>
                            <td><strong>{{ $data->pemberi_informasi }}</strong></td>
                        </tr>
                        <tr>
                            <td>Penerima Informasi/Pemberi Persetujuan*</td>
                            <td>:</td>
                            <td><strong>{{ $data->penerima_informasi }}</strong></td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <!-- HEADER KOLOM -->
            <tr>
                <th style="width: 5%;">NO</th>
                <th style="width: 25%;">JENIS INFORMASI</th>
                <th style="width: 55%;">ISI INFORMASI</th>
                <th style="width: 15%;">TANDAI (X)</th>
            </tr>
            
            <!-- 1. DIAGNOSIS -->
            <tr>
                <td style="text-align: center;">1</td>
                <td>Diagnosis (WD & DD)</td>
                <td><strong>{{ $data->diagnosis }}</strong></td>
                <td style="text-align:center;">
                    <div class="tandai-checkbox {{ $data->diagnosis_check ? 'checked' : '' }}"></div>
                </td>

            </tr>
            
            <!-- 2. DASAR DIAGNOSIS -->
            <tr>
                <td style="text-align: center;">2</td>
                <td>Dasar Diagnosis</td>
                <td>
                    <table class="inner-table">
                        <tr>
                            <td style="width: 25%;">Klinis :</td>
                            <td><strong>{{ $data->dasar_diagnosis_klinis }}</strong></td>
                        </tr>
                        <tr>
                            <td>Radiologi :</td>
                            <td><strong>{{ $data->dasar_diagnosis_radiologi }}</strong></td>
                        </tr>
                        <tr>
                            <td>EKG :</td>
                            <td><strong>{{ $data->dasar_diagnosis_ekg }}</strong></td>
                        </tr>
                        <tr>
                            <td>Laboratorium :</td>
                            <td><strong>{{ $data->data_diagnosis_laboratorium }}</strong></td>
                        </tr>
                    </table>
                </td>
<td style="text-align:center;">
    <div class="tandai-checkbox {{
        ($data->dasar_diagnosis_check)
        ? 'checked' : '' }}">
    </div>
</td>
            </tr>
            
            <!-- 3. TINDAKAN KEDOKTERAN -->
            <tr>
                <td style="text-align: center;">3</td>
                <td>Tindakan Kedokteran</td>
                <td>
                    <table class="inner-table">
                        <tr>
                            <td colspan="9" style="font-weight: bold;">Anestesi / Pembiusan</td>
                        </tr>
                        <tr>
                            <td style="width: 15%;">1. Umum:</td>
                            <td style="width: 3%; text-align: center;">
                                <input type="checkbox" {{ $data->anestesi_umum ? 'checked' : '' }}>
                            </td>
                            <td style="width: 18%;">Intubasi</td>
                            <td style="width: 3%; text-align: center;">
                                <input type="checkbox" {{ $data->anestesi_umum_intubasi ? 'checked' : '' }}>
                            </td>
                            <td style="width: 18%;">LMA</td>
                            <td style="width: 3%; text-align: center;">
                                <input type="checkbox" {{ $data->anestesi_umum_lma ? 'checked' : '' }}>
                            </td>
                            <td style="width: 18%;">FM</td>
                            <td style="width: 3%; text-align: center;">
                                <input type="checkbox" {{ $data->anestesi_umum_fm ? 'checked' : '' }}>
                            </td>
                            <td>TIVA</td>
                            <td style="width: 3%; text-align: center;">
                                <input type="checkbox" {{ $data->anestesi_umum_tiva ? 'checked' : '' }}>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 20%;">2. Regional:</td>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $data->anestesi_regional ? 'checked' : '' }}>
                            </td>
                            <td>Spinal</td>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $data->anestesi_regional_spinal ? 'checked' : '' }}>
                            </td>
                            <td>Epidural</td>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $data->anestesi_regional_epidural ? 'checked' : '' }}>
                            </td>
                            <td colspan="3">Blok Perifer</td>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $data->anestesi_regional_blok_perifer ? 'checked' : '' }}>
                        </tr>
                    </table>
                </td>
                <td style="text-align:center;">
                    <div class="tandai-checkbox {{
                        ($data->tindakan_anestesi_check)
                        ? 'checked' : '' }}">
                    </div>
                </td>
            </tr>
            
            <!-- 4. INDIKASI -->
            <tr>
                <td style="text-align:center;">4</td>
                <td>Indikasi Tindakan & Tujuan</td>
                <td><strong>{{ $data->indikasi_tujuan }}</strong></td>
                <td style="text-align:center;">
                    <div class="tandai-checkbox {{ $data->indikasi_tujuan_check ? 'checked' : '' }}"></div>
                </td>
            </tr>

            <!-- 5. TATA CARA -->
            <tr>
               <td style="text-align:center;">5</td>
               <td>Tata Cara Tindakan</td>
               <td><strong>{{ $data->tata_cara }}</strong></td>
               <td style="text-align:center;">
                   <div class="tandai-checkbox {{ $data->tata_cara_check ? 'checked' : '' }}"></div>
               </td>
            </tr>

            
            <!-- 6. RISIKO -->
            <tr>
                <td style="text-align: center;">6</td>
                <td>Risiko</td>
                <td>
                    <table class="inner-table">
                        <tr>
                            <td style="width: 5%; text-align: center;">
                                <input type="checkbox" {{ $data->risiko_shock ? 'checked' : '' }}>
                            </td>
                            <td style="width: 45%;">Shock</td>
                            <td style="width: 5%; text-align: center;">
                                <input type="checkbox" {{ $data->risiko_henti_jantung ? 'checked' : '' }}>
                            </td>
                            <td style="width: 45%;">Henti Jantung</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $data->risiko_meninggal_dunia ? 'checked' : '' }}>
                            </td>
                            <td colspan="3">Meninggal dunia di meja operasi</td>
                        </tr>
                    </table>
                </td>
<td style="text-align:center;">
    <div class="tandai-checkbox {{
        ($data->risiko_check)
        ? 'checked' : '' }}">
    </div>
</td>

            
            <!-- 7. KOMPLIKASI -->
            <tr>
                <td style="text-align: center;">7</td>
                <td>Komplikasi</td>
                <td>
                    <div style="font-weight: bold; margin-bottom: 5px;">1. Anestesi Umum</div>
                    <table class="inner-table">
                        <tr>
                            <td style="width: 3%; text-align: center;">
                                <input type="checkbox" {{ $data->komplikasi_umum_kejang_nafas ? 'checked' : '' }}>
                            </td>
                            <td>Sistem pernafasan : kejang dan penyempitan jalan nafas, kekurangan kadar O2 dalam darah, kekurangan atau kelebihan Co2 dalam darah, aspirasi pneumonia/masuknya isi lambung kedalam saluran nafas/paru</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $data->komplikasi_umum_jantung ? 'checked' : '' }}>
                            </td>
                            <td>Jantung dan pembuluh darah : tekanan darah turun, tekanan darah naik, gangguan irama jantung sampai henti jantung.</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $data->anestesi_umum_saraf ? 'checked' : '' }}>
                            </td>
                            <td>Sistem saraf : kejang, bangun lambat, trauma saraf tepi.</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $data->anestesi_umum_intubasi ? 'checked' : '' }}>
                            </td>
                            <td>Tindakan laringoskopi intubasi (gigi patah, luka mulut, pendarahan)</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $data->anestesi_umum_suhu ? 'checked' : '' }}>
                            </td>
                            <td>Suhu tubuh meningkat/turun.</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $data->anestesi_umum_posisi ? 'checked' : '' }}>
                            </td>
                            <td>Cedera akibat posisi saat operasi :</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <table class="inner-table">
                                    <tr>
                                        <td style="width: 5%; text-align: center;">
                                            <input type="checkbox" {{ $data->posisi_cedera_mata ? 'checked' : '' }}>
                                        </td>
                                        <td style="width: 28%;">Cedera mata</td>
                                        <td style="width: 5%; text-align: center;">
                                            <input type="checkbox" {{ $data->posisi_cedera_saraf ? 'checked' : '' }}>
                                        </td>
                                        <td style="width: 28%;">Cedera saraf</td>
                                        <td style="width: 5%; text-align: center;">
                                            <input type="checkbox" {{ $data->posisi_cedera_kulit ? 'checked' : '' }}>
                                        </td>
                                        <td>Cedera kulit/jaringan lunak</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    
                    <div style="font-weight: bold; margin-top: 10px; margin-bottom: 5px;">2. Anestesi Regional: <i>Spinal / Epidural</i></div>
                    <table class="inner-table">
                        <tr>
                            <td colspan="4" style="font-weight: bold;">Komplikasi segera:</td>
                        </tr>
                        <tr>
                            <td style="width: 3%; text-align: center;">
                                <input type="checkbox" {{ $data->komplikasi_penurunan_tekanan ? 'checked' : '' }}>
                            </td>
                            <td style="width: 47%;">Penurunan tekanan darah</td>
                            <td style="width: 3%; text-align: center;">
                                <input type="checkbox" {{ $data->komplikasi_anestesi_spinal ? 'checked' : '' }}>
                            </td>
                            <td style="width: 47%;">Anestesi spinal total (penurunan kesadaran, penurunan denyut jantung, nafas berhenti)</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $data->komplikasi_reaksi_toksik ? 'checked' : '' }}>
                            </td>
                            <td>Reaksi toksik (kejang, henti jantung)</td>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $data->komplikasi_reaksi_alergi ? 'checked' : '' }}>
                            </td>
                            <td>Reaksi alergi (syok anafilatik sampai meninggal)</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $data->anestesi_regional_komplikasi_lanjutan ? 'checked' : '' }}>
                            </td>
                            <td>Komplikasi lanjutan</td>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $data->anestesi_regional_nyeri_kepala ? 'checked' : '' }}>
                            </td>
                            <td>Nyeri kepala cekot-cekot</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $data->anestesi_regional_nyeri_punggung ? 'checked' : '' }}>
                            </td>
                            <td>Nyeri punggung</td>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $data->anestesi_regional_infeksi ? 'checked' : '' }}>
                            </td>
                            <td>Infeksi</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $data->anestesi_regional_tidak_bisa_berkemih ? 'checked' : '' }}>
                            </td>
                            <td>Tidak bisa berkemih</td>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $data->anestesi_regional_cedera_saraf ? 'checked' : '' }}>
                            </td>
                            <td>Cedera saraf</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $data->anestesi_regional_pendarahan ? 'checked' : '' }}>
                            </td>
                            <td colspan="3">Pendarahan</td>
                        </tr>
                    </table>
                </td>
                <td style="text-align:center;">
                    <div class="tandai-checkbox {{
                        (
                            $data->anestesi_umum_pernafasan ||
                            $data->anestesi_umum_jantung ||
                            $data->anestesi_umum_saraf ||
                            $data->anestesi_umum_intubasi ||
                            $data->anestesi_umum_suhu ||
                            $data->anestesi_umum_posisi ||
                            $data->posisi_cedera_mata ||
                            $data->posisi_cedera_saraf ||
                            $data->posisi_cedera_kulit ||
                            $data->komplikasi_penurunan_tekanan ||
                            $data->komplikasi_anestesi_spinal ||
                            $data->komplikasi_reaksi_toksik ||
                            $data->komplikasi_reaksi_alergi ||
                            $data->anestesi_regional_komplikasi_lanjutan ||
                            $data->anestesi_regional_nyeri_kepala ||
                            $data->anestesi_regional_nyeri_punggung ||
                            $data->anestesi_regional_infeksi ||
                            $data->anestesi_regional_tidak_bisa_berkemih ||
                            $data->anestesi_regional_cedera_saraf ||
                            $data->anestesi_regional_pendarahan
                        ) ? 'checked' : ''
                    }}"></div>
                </td>

            </tr>
            
            <!-- 8. PROGNOSIS -->
            <tr>
                <td style="text-align: center;">8</td>
                <td>Prognosis</td>
                <td><strong>{{ $data->prognosis }}</strong></td>
<td style="text-align:center;">
    <div class="tandai-checkbox {{ $data->prognosis ? 'checked' : '' }}"></div>
</td>
            </tr>
            
            <!-- 9. ALTERNATIF -->
            <tr>
                <td style="text-align:center;">9</td>
                <td>Alternatif tindakan</td>
                <td><strong>{{ $data->alternatif_tindakan }}</strong></td>
                <td style="text-align:center;">
                    <div class="tandai-checkbox {{ $data->alternatif_tindakan ? 'checked' : '' }}"></div>
                </td>
            </tr>

            
            <!-- 10. LAIN-LAIN -->
            <tr>
                <td style="text-align:center;">10</td>
                <td>Lain-lain</td>
                <td><strong>{{ $data->lain_lain }}</strong></td>
                <td style="text-align:center;">
                    <div class="tandai-checkbox {{ $data->lain_lain ? 'checked' : '' }}"></div>
                </td>
            </tr>
        </table>
        
        <!-- PERNYATAAN -->
        <table class="tablee" style="margin-top: 10px;">
            <tr>
                <td style="width: 70%; text-align: justify; padding: 8px;">
                    Dengan ini menyatakan bahwa saya telah menerangkan hal-hal di atas secara benar dan jelas dan memberikan kesempatan untuk bertanya dan atau berdiskusi
                </td>
                <td style="width: 30%; text-align: center;">
                    <div><strong>Dokter Pelaksana</strong></div>
                    @if($data->ttd_dokter)
                        <img src="{{ $data->ttd_dokter }}" class="ttd-img" alt="TTD Dokter">
                    @else
                        <div style="height: 60px;"></div>
                    @endif
                    <div><strong>({{ $data->nama_dokter_ttd }})</strong></div>
                    <div style="margin-top: 5px;">
                        Tanggal: <strong>{{ $data->tanggal_dokter ? \Carbon\Carbon::parse($data->tanggal_dokter)->format('d/m/Y') : '-' }}</strong>
                    </div>
                    <div>
                        Waktu: <strong>{{ $data->waktu_dokter ? \Carbon\Carbon::parse($data->waktu_dokter)->format('H:i') : '-' }}</strong>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="text-align: justify; padding: 8px;">
                    Dengan ini menyatakan bahwa saya telah menerima informasi dari dokter sebagaimana di atas kemudian yang saya beri tanda/paraf di kolom kanannya, dan telah memahaminya
                </td>
                <td style="text-align: center;">
                    <div><strong>Pasien/Keluarga</strong></div>
                    @if($data->ttd_pasien)
                        <img src="{{ $data->ttd_pasien }}" class="ttd-img" alt="TTD Pasien">
                    @else
                        <div style="height: 60px;"></div>
                    @endif
                    <div><strong>({{ $data->nama_pasien_ttd }})</strong></div>
                    <div style="margin-top: 5px;">
                        Tanggal: <strong>{{ $data->tanggal_pasien ? \Carbon\Carbon::parse($data->tanggal_pasien)->format('d/m/Y') : '-' }}</strong>
                    </div>
                    <div>
                        Waktu: <strong>{{ $data->waktu_pasien ? \Carbon\Carbon::parse($data->waktu_pasien)->format('H:i') : '-' }}</strong>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: justify; padding: 8px; font-size: 10px;">
                    * Bila pasien tidak kompeten atau tidak mau menerima informasi, maka penerima informasi adalah wali atau keluarga terdekat
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: justify; padding: 8px;">
                    Yang bertanda tangan di bawah ini, saya, nama
                    <strong><u>{{ $data->pernyataan_nama }}</u></strong>,
                    tanggal lahir
                    <strong><u>{{ $data->pernyataan_tanggal_lahir ? \Carbon\Carbon::parse($data->pernyataan_tanggal_lahir)->format('d/m/Y') : '_____' }}</u></strong>,
                    <strong><u>{{ $data->pernyataan_jenis_kelamin == 'L' ? 'laki-laki' : 'perempuan' }}</u></strong>,
                    alamat
                    <strong><u>{{ $data->pernyataan_alamat }}</u></strong>,
                    dengan ini menyatakan
                    <strong>PERSETUJUAN</strong>
                    untuk dilakukannya tindakan
                    <strong>ANESTESI</strong>
                    terhadap saya /
                    <strong><u>{{ $data->pernyataan_hubungan }}</u></strong>
                    saya* bernama
                    <strong><u>{{ $data->pernyataan_nama_pasien }}</u></strong>,
                    tanggal lahir
                    <strong><u>{{ $data->pernyataan_tanggal_lahir_pasien ? \Carbon\Carbon::parse($data->pernyataan_tanggal_lahir_pasien)->format('d/m/Y') : '_____' }}</u></strong>,
                    <strong><u>{{ $data->pernyataan_jenis_kelamin_pasien == 'L' ? 'laki-laki' : 'perempuan' }}</u></strong>,
                    alamat
                    <strong><u>{{ $data->pernyataan_alamat_pasien }}</u></strong>.
                    <br><br>
                    Saya telah dijelaskan dan memahami tentang jenis tindakan pembiusan beserta manfaat, risiko dan komplikasi lain yang mungkin timbul.
                    <br>
                    Saya juga menyadari bahwa dokter melakukan suatu upaya dan oleh karena ilmu kedokteran bukanlah ilmu pasti,
                    maka keberhasilan tindakan kedokteran bukanlah keniscayaan, melainkan sangat bergantung kepada izin Tuhan Yang Maha Esa.
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding: 8px;">
                    <!-- BARIS TANGGAL -->
                    <div style="margin-bottom:15px;">
                        <strong>Medan</strong>, 
                        tanggal <strong><u>{{ $data->pernyataan_tanggal ? \Carbon\Carbon::parse($data->pernyataan_tanggal)->format('d/m/Y') : '_____' }}</u></strong>
                        pukul <strong><u>{{ $data->pernyataan_waktu ? \Carbon\Carbon::parse($data->pernyataan_waktu)->format('H:i') : '___' }}</u></strong>
                    </div>

                    <!-- TANDA TANGAN -->
                    <table class="inner-table" style="width:100%; text-align:center;">
                        <tr>
                            <td style="width:25%;"><strong>Yang Menyatakan</strong></td>
                            <td style="width:25%;"><strong>Dokter</strong></td>
                            <td colspan="2" style="width:50%;"><strong>Saksi</strong></td>
                        </tr>
                        <tr>
                            <td>
                                @if($data->ttd_pasien_pernyataan)
                                    <img src="{{ $data->ttd_pasien_pernyataan }}" class="ttd-img" alt="TTD Pasien">
                                @else
                                    <div style="height: 60px;"></div>
                                @endif
                            </td>
                            <td>
                                @if($data->ttd_dokter_persetujuan)
                                    <img src="{{ $data->ttd_dokter_persetujuan }}" class="ttd-img" alt="TTD Dokter">
                                @else
                                    <div style="height: 60px;"></div>
                                @endif
                            </td>
                            <td style="width:25%;">
                                @if($data->ttd_keluarga)
                                    <img src="{{ $data->ttd_keluarga }}" class="ttd-img" alt="TTD Keluarga">
                                @else
                                    <div style="height: 60px;"></div>
                                @endif
                            </td>
                            <td style="width:25%;">
                                @if($data->ttd_perawat)
                                    <img src="{{ $data->ttd_perawat }}" class="ttd-img" alt="TTD Perawat">
                                @else
                                    <div style="height: 60px;"></div>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>({{ $data->nama_pasien_pernyataan }})</strong></td>
                            <td><strong>({{ $data->nama_dokter_persetujuan }})</strong></td>
                            <td><strong>({{ $data->nama_keluarga_ttd }})</strong></td>
                            <td><strong>({{ $data->nama_perawat_ttd }})</strong></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>