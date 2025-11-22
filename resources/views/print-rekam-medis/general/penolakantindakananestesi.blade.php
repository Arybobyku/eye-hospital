<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>REKAM MEDIS GENERAL - PENOLAKAN TINDAKAN ANESTESI</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: white;
        }
        
        .container {
            max-width: 210mm;
            margin: 0 auto;
            background: white;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid black;
        }
        
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            vertical-align: top;
            font-size: 11px;
        }
        
        .header {
            text-align: center;
            font-weight: bold;
            background: white;
            font-size: 12px;
            padding: 10px;
        }
        
        .section-header {
            text-align: center;
            font-weight: bold;
            background: white;
            font-size: 11px;
            padding: 8px;
        }
        
        .col-number {
            width: 30px;
            text-align: center;
            font-weight: bold;
        }
        
        .col-label {
            width: 150px;
            font-weight: bold;
        }
        
        .col-content {
            width: auto;
        }
        
        .col-signature {
            width: 120px;
            text-align: center;
        }
        
        .checkbox-group {
            margin: 3px 0;
        }
        
        .checkbox-inline {
            display: inline-block;
            margin-right: 15px;
        }
        
        .indent {
            padding-left: 20px;
        }
        
        ul {
            margin-left: 20px;
            margin-top: 5px;
        }
        
        ul li {
            margin-bottom: 3px;
        }
        
        .footer-text {
            font-size: 10px;
            line-height: 1.5;
        }
        
        @media print {
            body {
                padding: 0;
            }
            .container {
                max-width: 100%;
            }
        }
    </style>

</head>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;">
    </div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <?php $eyero = storage_path('app/public/images/EYE-RO.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 1.10/PPOP/22
        </div>
        @include('print-rekam-medis.partials.header')
    <table style="width: 100%;">
            <tr>
                <td colspan="4" class="header">PENOLAKAN TINDAKAN ANESTESI</td>
            </tr>
            <tr>
                <td colspan="4" class="section-header">PEMBERIAN INFORMASI TINDAKAN PEMBEDAAN</td>
            </tr>
            <tr>
                <td colspan="4" style=" padding: 6px 8px;">Dokter Pelaksana Tindakan:</td>
            </tr>
            <tr>
                <td colspan="4" style="padding: 6px 8px;">Telah memberikan penjelasan kepada pasien/wali/keluarga</td>
            </tr>
            <tr>
                <td colspan="4" style="padding: 6px 8px;">Program Informasi/Edukasi Pasien/wali*:</td>
            </tr>
            <tr>
                <td class="col-number"></td>
                <td class="col-label" style="font-weight: bold;">JENIS INFORMASI</td>
                <td class="col-content" style="font-weight: bold;">ISI INFORMASI</td>
                <td class="col-signature" style="font-weight: bold;">TANDA (√)</td>
            </tr>
            <tr>
                <td class="col-number">1.</td>
                <td class="col-label">Diagnosis (WD & DD)</td>
                <td class="col-content">Sesuai Poli, KKA</td>
                <td class="col-signature"></td>
            </tr>
            <tr>
                <td class="col-number">2.</td>
                <td class="col-label">Dasar Diagnosis</td>
                <td class="col-content">
                    Anamnesis<br>
                    Pemfis<br>
                    Penunjang
                </td>
                <td class="col-signature"></td>
            </tr>
            <tr>
                <td class="col-number">3.</td>
                <td class="col-label">Tindakan Kedokteran</td>
                <td class="col-content">
                    <div class="checkbox-group">
                        <span class="checkbox-inline">☐ Spinal</span>
                        <span class="checkbox-inline">☐ Epidural ☐ LSEA</span>
                        <span class="checkbox-inline">☐ GA</span>
                        <span class="checkbox-inline">☐ TIVA</span>
                    </div>
                    <div class="checkbox-group">
                        <span class="checkbox-inline">☐ Ketofol</span>
                        <span class="checkbox-inline">☐ Intubasi ☐ Terpasang ☐ ETB Bulat</span>
                    </div>
                    <div class="checkbox-group">
                        <span class="checkbox-inline">☐ Block Regional: ____________</span>
                    </div>
                </td>
                <td class="col-signature"></td>
            </tr>
            <tr>
                <td class="col-number">4.</td>
                <td class="col-label">Tata Cara/Tahapan</td>
                <td class="col-content"></td>
                <td class="col-signature"></td>
            </tr>
            <tr>
                <td class="col-number">5.</td>
                <td class="col-label">Risiko</td>
                <td class="col-content">
                    <div style="margin-bottom: 5px;"><em>Kebutuhan darah & atau apusan</em></div>
                    <div style="margin-bottom: 5px;">☐ Autograf Darah</div>
                    <ul style="list-style-type: disc;">
                        <li>Penyulit, seperti: ☐ Alergy dan alat pernapasan dalam sedasi, kebanyakan, kulit ☐ obat dalam darah, bekerjanya dan terkoleksi ☐ air dalam darah, apakah permintaan/manfaat tindakan ini akan membandingkan harapan pasien apakah sebelum dikelola</li>
                        <li>Dapat terjadi komplikasi dengan keluasan tingkat dosis obat anaf, gangguan irama jantung sampai tidak jantung ☐ Status atau faktor lainnya, banyak dari tidak jantung, apalagi saat hipertensi, koma sampai kematian praboedahan</li>
                        <li>Selain tindakan klinis</li>
                        <li>Pengawasan secara alat untuk tidak membuat sampai diberi pemeriksaan belka (waktu operasi)</li>
                    </ul>
                    <div style="margin-top: 8px;"><strong>Kemungkinan</strong></div>
                    <ul style="list-style-type: disc;">
                        <li>Celana ablas jantuh asal operasi</li>
                        <li>☐ Memiliki : ☐ Panas kembali ☐ Pernapasan tidak dapat</li>
                        <li>☐ Kerjasama dapat : ☐ Perkiraan dapat terbatas</li>
                        <li>☐ Kembali dapat : ☐ Pernapasan dalam darah : ☐ Aspirasi darah ☐ alur pertumbuhan kesadaran, pernapasan sistem tidak bermaksud, hipotensi dengan terjadi banyak : ☐ retensi apakah tidak dapat obat manfaat</li>
                        <li>☐ Bedak dapat menunjuk : ☐ Nyeri berada oleh obat</li>
                        <li>☐ Pemulihan kemungkinan : ☐ diakr berada celana : ☐ Prak intracranial dapat</li>
                        <li>☐ Celana obat</li>
                        <li>☐ Pertakutan</li>
                    </ul>
                </td>
                <td class="col-signature"></td>
            </tr>
            <tr>
                <td class="col-number">6.</td>
                <td class="col-label">Prognosis</td>
                <td class="col-content"></td>
                <td class="col-signature"></td>
            </tr>
            <tr>
                <td class="col-number">7.</td>
                <td class="col-label">Lain-lain</td>
                <td class="col-content"></td>
                <td class="col-signature"></td>
            </tr>
            <tr>
                <td colspan="4" class="footer-text" style="padding: 10px;">
                    Dengan ini saya menyatakan bahwa saya telah <em>menerangkan</em> hal-hal di atas secara benar dan jelas dan memberikan kesempatan untuk bertanya dan atau berdiskusi.
                </td>
            </tr>
            <tr>
                <td colspan="4" class="footer-text" style="padding: 10px;">
                    Dengan ini saya menyatakan bahwa saya telah menerima informasi sebagaimana di atas yang saya beri tanda/paraf di kolom kanannya, dan telah memahaminya
                </td>
            </tr>
            <tr>
                <td colspan="4" class="footer-text" style="padding: 10px;">
                    *Beri tanda kolom kanan/lajur paling kanan dengan tanda √ atau paraf untuk informasi yang TELAH dapat diberikan
                </td>
            </tr>
        </table>
    </div>
</body>
