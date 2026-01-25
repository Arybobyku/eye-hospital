<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>REKAM MEDIS GENERAL - PENOLAKAN TINDAKAN ANESTESI</title>
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
            {{ $penolakan->jenis_form === 'penolakan' ? 'RM 4.2/PTA/22' : 'RM 4.3/PTA/22' }}
        </div>
        
        @include('print-rekam-medis.partials.header')
        
        <table class="tablee">
            <!-- HEADER TITLE -->
            <tr>
                <td colspan="4" class="header-row">
                    {{ $penolakan->jenis_form === 'penolakan' ? 'PENOLAKAN' : 'PERSETUJUAN' }} TINDAKAN ANESTESI
                </td>
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
                            <td style="width: 63%;"><strong>{{ $penolakan->dokter_pelaksana }}</strong></td>
                        </tr>
                        <tr>
                            <td>Pemberi Informasi</td>
                            <td>:</td>
                            <td><strong>{{ $penolakan->perawat_asisten }}</strong></td>
                        </tr>
                        <tr>
                            <td>Penerima Informasi/Pemberi {{ $penolakan->jenis_form === 'penolakan' ? 'Penolakan' : 'Persetujuan' }}*</td>
                            <td>:</td>
                            <td><strong>{{ $penolakan->penerima_informasi }}</strong></td>
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
                <td><strong>{{ $penolakan->status_fisik_asa }}</strong></td>
                <td style="text-align:center;">
                    <div class="tandai-checkbox {{ $penolakan->status_fisik_asa ? 'checked' : '' }}"></div>
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
                            <td><strong>{{ $penolakan->klinis }}</strong></td>
                        </tr>
                        <tr>
                            <td>Radiologi :</td>
                            <td><strong>{{ $penolakan->radiologi }}</strong></td>
                        </tr>
                        <tr>
                            <td>EKG :</td>
                            <td><strong>{{ $penolakan->ekg }}</strong></td>
                        </tr>
                        <tr>
                            <td>Laboratorium :</td>
                            <td><strong>{{ $penolakan->laboratorium }}</strong></td>
                        </tr>
                    </table>
                </td>
<td style="text-align:center;">
    <div class="tandai-checkbox {{
        ($penolakan->klinis || $penolakan->radiologi || $penolakan->ekg || $penolakan->laboratorium)
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
                                <input type="checkbox" {{ $penolakan->umum_intubasi ? 'checked' : '' }}>
                            </td>
                            <td style="width: 18%;">Intubasi</td>
                            <td style="width: 3%; text-align: center;">
                                <input type="checkbox" {{ $penolakan->umum_lma ? 'checked' : '' }}>
                            </td>
                            <td style="width: 18%;">LMA</td>
                            <td style="width: 3%; text-align: center;">
                                <input type="checkbox" {{ $penolakan->umum_fm ? 'checked' : '' }}>
                            </td>
                            <td style="width: 18%;">FM</td>
                            <td style="width: 3%; text-align: center;">
                                <input type="checkbox" {{ $penolakan->umum_tiva ? 'checked' : '' }}>
                            </td>
                            <td>TIVA</td>
                        </tr>
                        <tr>
                            <td style="width: 20%;">2. Regional:</td>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $penolakan->regional_spinal1 ? 'checked' : '' }}>
                            </td>
                            <td>Spinal</td>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $penolakan->regional_spinal2 ? 'checked' : '' }}>
                            </td>
                            <td>Epidural</td>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $penolakan->regional_blok_perifer ? 'checked' : '' }}>
                            </td>
                            <td colspan="3">Blok Perifer</td>
                        </tr>
                    </table>
                </td>
                <td style="text-align:center;">
                    <div class="tandai-checkbox {{
                        ($penolakan->umum_intubasi ||
                         $penolakan->umum_lma ||
                         $penolakan->umum_fm ||
                         $penolakan->umum_tiva ||
                         $penolakan->regional_spinal1 ||
                         $penolakan->regional_spinal2 ||
                         $penolakan->regional_blok_perifer)
                        ? 'checked' : '' }}">
                    </div>
                </td>
            </tr>
            
            <!-- 4. INDIKASI -->
            <tr>
                <td style="text-align:center;">4</td>
                <td>Indikasi Tindakan & Tujuan</td>
                <td><strong>{{ $penolakan->indikasi_tindakan }}</strong></td>
                <td style="text-align:center;">
                    <div class="tandai-checkbox {{ $penolakan->indikasi_tindakan ? 'checked' : '' }}"></div>
                </td>
            </tr>

            <!-- 5. TATA CARA -->
            <tr>
               <td style="text-align:center;">5</td>
               <td>Tata Cara Tindakan</td>
               <td><strong>{{ $penolakan->tata_cara_tindakan }}</strong></td>
               <td style="text-align:center;">
                   <div class="tandai-checkbox {{ $penolakan->tata_cara_tindakan ? 'checked' : '' }}"></div>
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
                                <input type="checkbox" {{ $penolakan->shock ? 'checked' : '' }}>
                            </td>
                            <td style="width: 45%;">Shock</td>
                            <td style="width: 5%; text-align: center;">
                                <input type="checkbox" {{ $penolakan->henti_jantung ? 'checked' : '' }}>
                            </td>
                            <td style="width: 45%;">Henti Jantung</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $penolakan->meninggal_dunia ? 'checked' : '' }}>
                            </td>
                            <td colspan="3">Meninggal dunia di meja operasi</td>
                        </tr>
                    </table>
                </td>
<td style="text-align:center;">
    <div class="tandai-checkbox {{
        ($penolakan->shock ||
         $penolakan->henti_jantung ||
         $penolakan->meninggal_dunia)
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
                                <input type="checkbox" {{ $penolakan->anestesi_umum_pernafasan ? 'checked' : '' }}>
                            </td>
                            <td>Sistem pernafasan : kejang dan penyempitan jalan nafas, kekurangan kadar O2 dalam darah, kekurangan atau kelebihan Co2 dalam darah, aspirasi pneumonia/masuknya isi lambung kedalam saluran nafas/paru</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $penolakan->anestesi_umum_jantung ? 'checked' : '' }}>
                            </td>
                            <td>Jantung dan pembuluh darah : tekanan darah turun, tekanan darah naik, gangguan irama jantung sampai henti jantung.</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $penolakan->anestesi_umum_saraf ? 'checked' : '' }}>
                            </td>
                            <td>Sistem saraf : kejang, bangun lambat, trauma saraf tepi.</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $penolakan->anestesi_umum_intubasi ? 'checked' : '' }}>
                            </td>
                            <td>Tindakan laringoskopi intubasi (gigi patah, luka mulut, pendarahan)</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $penolakan->anestesi_umum_suhu ? 'checked' : '' }}>
                            </td>
                            <td>Suhu tubuh meningkat/turun.</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $penolakan->anestesi_umum_posisi ? 'checked' : '' }}>
                            </td>
                            <td>Cedera akibat posisi saat operasi :</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <table class="inner-table">
                                    <tr>
                                        <td style="width: 5%; text-align: center;">
                                            <input type="checkbox" {{ $penolakan->posisi_cedera_mata ? 'checked' : '' }}>
                                        </td>
                                        <td style="width: 28%;">Cedera mata</td>
                                        <td style="width: 5%; text-align: center;">
                                            <input type="checkbox" {{ $penolakan->posisi_cedera_saraf ? 'checked' : '' }}>
                                        </td>
                                        <td style="width: 28%;">Cedera saraf</td>
                                        <td style="width: 5%; text-align: center;">
                                            <input type="checkbox" {{ $penolakan->posisi_cedera_kulit ? 'checked' : '' }}>
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
                                <input type="checkbox" {{ $penolakan->komplikasi_penurunan_tekanan ? 'checked' : '' }}>
                            </td>
                            <td style="width: 47%;">Penurunan tekanan darah</td>
                            <td style="width: 3%; text-align: center;">
                                <input type="checkbox" {{ $penolakan->komplikasi_anestesi_spinal ? 'checked' : '' }}>
                            </td>
                            <td style="width: 47%;">Anestesi spinal total (penurunan kesadaran, penurunan denyut jantung, nafas berhenti)</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $penolakan->komplikasi_reaksi_toksik ? 'checked' : '' }}>
                            </td>
                            <td>Reaksi toksik (kejang, henti jantung)</td>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $penolakan->komplikasi_reaksi_alergi ? 'checked' : '' }}>
                            </td>
                            <td>Reaksi alergi (syok anafilatik sampai meninggal)</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $penolakan->anestesi_regional_komplikasi_lanjutan ? 'checked' : '' }}>
                            </td>
                            <td>Komplikasi lanjutan</td>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $penolakan->anestesi_regional_nyeri_kepala ? 'checked' : '' }}>
                            </td>
                            <td>Nyeri kepala cekot-cekot</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $penolakan->anestesi_regional_nyeri_punggung ? 'checked' : '' }}>
                            </td>
                            <td>Nyeri punggung</td>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $penolakan->anestesi_regional_infeksi ? 'checked' : '' }}>
                            </td>
                            <td>Infeksi</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $penolakan->anestesi_regional_tidak_bisa_berkemih ? 'checked' : '' }}>
                            </td>
                            <td>Tidak bisa berkemih</td>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $penolakan->anestesi_regional_cedera_saraf ? 'checked' : '' }}>
                            </td>
                            <td>Cedera saraf</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" {{ $penolakan->anestesi_regional_pendarahan ? 'checked' : '' }}>
                            </td>
                            <td colspan="3">Pendarahan</td>
                        </tr>
                    </table>
                </td>
                <td style="text-align:center;">
                    <div class="tandai-checkbox {{
                        (
                            $penolakan->anestesi_umum_pernafasan ||
                            $penolakan->anestesi_umum_jantung ||
                            $penolakan->anestesi_umum_saraf ||
                            $penolakan->anestesi_umum_intubasi ||
                            $penolakan->anestesi_umum_suhu ||
                            $penolakan->anestesi_umum_posisi ||
                            $penolakan->posisi_cedera_mata ||
                            $penolakan->posisi_cedera_saraf ||
                            $penolakan->posisi_cedera_kulit ||
                            $penolakan->komplikasi_penurunan_tekanan ||
                            $penolakan->komplikasi_anestesi_spinal ||
                            $penolakan->komplikasi_reaksi_toksik ||
                            $penolakan->komplikasi_reaksi_alergi ||
                            $penolakan->anestesi_regional_komplikasi_lanjutan ||
                            $penolakan->anestesi_regional_nyeri_kepala ||
                            $penolakan->anestesi_regional_nyeri_punggung ||
                            $penolakan->anestesi_regional_infeksi ||
                            $penolakan->anestesi_regional_tidak_bisa_berkemih ||
                            $penolakan->anestesi_regional_cedera_saraf ||
                            $penolakan->anestesi_regional_pendarahan
                        ) ? 'checked' : ''
                    }}"></div>
                </td>

            </tr>
            
            <!-- 8. PROGNOSIS -->
            <tr>
                <td style="text-align: center;">8</td>
                <td>Prognosis</td>
                <td><strong>{{ $penolakan->prognosis }}</strong></td>
<td style="text-align:center;">
    <div class="tandai-checkbox {{ $penolakan->prognosis ? 'checked' : '' }}"></div>
</td>
            </tr>
            
            <!-- 9. ALTERNATIF -->
            <tr>
                <td style="text-align:center;">9</td>
                <td>Alternatif tindakan</td>
                <td><strong>{{ $penolakan->alternatif_tindakan }}</strong></td>
                <td style="text-align:center;">
                    <div class="tandai-checkbox {{ $penolakan->alternatif_tindakan ? 'checked' : '' }}"></div>
                </td>
            </tr>

            
            <!-- 10. LAIN-LAIN -->
            <tr>
                <td style="text-align:center;">10</td>
                <td>Lain-lain</td>
                <td><strong>{{ $penolakan->lain_lain }}</strong></td>
                <td style="text-align:center;">
                    <div class="tandai-checkbox {{ $penolakan->lain_lain ? 'checked' : '' }}"></div>
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
                    @if($penolakan->ttd_dokter)
                        <img src="{{ $penolakan->ttd_dokter }}" class="ttd-img" alt="TTD Dokter">
                    @else
                        <div style="height: 60px;"></div>
                    @endif
                    <div><strong>({{ $penolakan->nama_dokter_ttd }})</strong></div>
                    <div style="margin-top: 5px;">
                        Tanggal: <strong>{{ $penolakan->tanggal_dokter ? \Carbon\Carbon::parse($penolakan->tanggal_dokter)->format('d/m/Y') : '-' }}</strong>
                    </div>
                    <div>
                        Waktu: <strong>{{ $penolakan->waktu_dokter ? \Carbon\Carbon::parse($penolakan->waktu_dokter)->format('H:i') : '-' }}</strong>
                    </div>
                </td>
            </tr>
            <tr>
                <td style="text-align: justify; padding: 8px;">
                    Dengan ini menyatakan bahwa saya telah menerima informasi dari dokter sebagaimana di atas kemudian yang saya beri tanda/paraf di kolom kanannya, dan telah memahaminya
                </td>
                <td style="text-align: center;">
                    <div><strong>Pasien/Keluarga</strong></div>
                    @if($penolakan->ttd_pasien)
                        <img src="{{ $penolakan->ttd_pasien }}" class="ttd-img" alt="TTD Pasien">
                    @else
                        <div style="height: 60px;"></div>
                    @endif
                    <div><strong>({{ $penolakan->nama_pasien_ttd }})</strong></div>
                    <div style="margin-top: 5px;">
                        Tanggal: <strong>{{ $penolakan->tanggal_pasien ? \Carbon\Carbon::parse($penolakan->tanggal_pasien)->format('d/m/Y') : '-' }}</strong>
                    </div>
                    <div>
                        Waktu: <strong>{{ $penolakan->waktu_pasien ? \Carbon\Carbon::parse($penolakan->waktu_pasien)->format('H:i') : '-' }}</strong>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: justify; padding: 8px; font-size: 10px;">
                    * Bila pasien tidak kompeten atau tidak mau menerima informasi, maka penerima informasi adalah wali atau keluarga terdekat
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: justify; padding: 8px; line-height: 1.6;">
                    Yang bertanda tangan di bawah ini, saya, nama
                    <strong><u>{{ $penolakan->pernyataan_nama ?? '___________' }}</u></strong>,
                    tanggal lahir
                    <strong><u>
                        {{ $penolakan->pernyataan_tanggal_lahir
                            ? \Carbon\Carbon::parse($penolakan->pernyataan_tanggal_lahir)->format('d/m/Y')
                            : '___________' }}
                    </u></strong>,
                    <strong><u>
                        {{ $penolakan->pernyataan_jenis_kelamin === 'L'
                            ? 'laki-laki'
                            : ($penolakan->pernyataan_jenis_kelamin === 'P' ? 'perempuan' : '___________') }}
                    </u></strong>,
                    alamat
                    <strong><u>{{ $penolakan->pernyataan_alamat ?? '___________' }}</u></strong>,
                    dengan ini menyatakan
                    <strong>
                        {{ $penolakan->jenis_form === 'penolakan' ? 'PENOLAKAN' : 'PERSETUJUAN' }}
                    </strong>
                    untuk dilakukannya tindakan
                    <strong>ANESTESI</strong>
                    terhadap saya /
                    <strong><u>{{ $penolakan->pernyataan_hubungan ?? '___________' }}</u></strong>
                    saya*, bernama
                    <strong><u>{{ $penolakan->pernyataan_nama_pasien ?? '___________' }}</u></strong>,
                    tanggal lahir
                    <strong><u>
                        {{ $penolakan->pernyataan_tanggal_lahir_pasien
                            ? \Carbon\Carbon::parse($penolakan->pernyataan_tanggal_lahir_pasien)->format('d/m/Y')
                            : '___________' }}
                    </u></strong>,
                    <strong><u>
                        {{ $penolakan->pernyataan_jenis_kelamin_pasien === 'L'
                            ? 'laki-laki'
                            : ($penolakan->pernyataan_jenis_kelamin_pasien === 'P' ? 'perempuan' : '___________') }}
                    </u></strong>,
                    alamat
                    <strong><u>{{ $penolakan->pernyataan_alamat_pasien ?? '___________' }}</u></strong>.
                    <br><br>
                
                    Saya telah dijelaskan dan memahami tentang jenis tindakan pembiusan beserta manfaat,
                    risiko, dan komplikasi lain yang mungkin timbul.
                    <br>
                    Saya juga menyadari bahwa dokter melakukan suatu upaya dan oleh karena ilmu kedokteran
                    bukanlah ilmu pasti, maka keberhasilan tindakan kedokteran bukanlah keniscayaan,
                    melainkan sangat bergantung kepada izin Tuhan Yang Maha Esa.
                </td>
            </tr>

            <tr>
                <td colspan="2" style="padding: 8px;">
                    <!-- BARIS TANGGAL -->
                    <div style="margin-bottom:15px;">
                        <strong>Medan</strong>, 
                        tanggal <strong><u>{{ $penolakan->pernyataan_tanggal ? \Carbon\Carbon::parse($penolakan->pernyataan_tanggal)->format('d/m/Y') : '___________' }}</u></strong>
                        pukul <strong><u>{{ $penolakan->pernyataan_waktu ? \Carbon\Carbon::parse($penolakan->pernyataan_waktu)->format('H:i') : '_____' }} WIB</u></strong>
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
                                @if($penolakan->ttd_pasien_pernyataan)
                                    <img src="{{ $penolakan->ttd_pasien_pernyataan }}" class="ttd-img" alt="TTD Pasien">
                                @else
                                    <div style="height: 60px;"></div>
                                @endif
                            </td>
                            <td>
                                @if($penolakan->ttd_dokter_persetujuan)
                                    <img src="{{ $penolakan->ttd_dokter_persetujuan }}" class="ttd-img" alt="TTD Dokter">
                                @else
                                    <div style="height: 60px;"></div>
                                @endif
                            </td>
                            <td style="width:25%;">
                                @if($penolakan->ttd_keluarga)
                                    <img src="{{ $penolakan->ttd_keluarga }}" class="ttd-img" alt="TTD Keluarga">
                                @else
                                    <div style="height: 60px;"></div>
                                @endif
                            </td>
                            <td style="width:25%;">
                                @if($penolakan->ttd_perawat)
                                    <img src="{{ $penolakan->ttd_perawat }}" class="ttd-img" alt="TTD Perawat">
                                @else
                                    <div style="height: 60px;"></div>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>({{ $penolakan->nama_pasien_pernyataan }})</strong></td>
                            <td><strong>({{ $penolakan->nama_dokter_persetujuan }})</strong></td>
                            <td><strong>({{ $penolakan->nama_keluarga_ttd }})</strong></td>
                            <td><strong>({{ $penolakan->nama_perawat_ttd }})</strong></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>