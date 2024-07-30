<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM3.2</title>
    <style>
        @page {
            margin: 18px;
        }

        body {
            margin: 18px;
        }

        .wrap {
            width: 100%;
            height: auto;
            display: inline-block;
        }

        .tablee {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .tablee2 {
            border-left: 1px solid black;
            border-right: 1px solid black;
            border-collapse: collapse;
        }
    </style>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;"></div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 3.2/KADPPB/22
        </div>
        @include('print-rekam-medis.partials.header')
    </div>
    <div class="wrap">
        <table class="tablee2" style="width: 100%; text-align: center;">
            <tr>
                <td style="text-align: center"><b>KUNJUNGAN AWAL DIETITIAN PADA PASIEN BARU</b></td>
            </tr>
        </table>
    </div>
    <table class="tablee" style="width: 100%">
        <tr>
            <td style="padding-left: 5px; padding-bottom:40px">Diagnose Medis:</td>
        </tr>
        <tr>
            <td>1. Resiko malnutrisi berdasarkan hasil skrining gizi oleh perawat, kondisi pasien termasuk ketegori:
            </td>
        </tr>
        <table>
            <tr>
                <td><input type="checkbox"></td>
                <td>Resiko Ringan(Nilai MST 0-1)</td>
            </tr>
            <tr>
                <td><input type="checkbox"></td>
                <td>Resiko Sedang(Nilai MST &#8805;>=2-3)</td>
            </tr>
            <tr>
                <td><input type="checkbox"></td>
                <td>Resiko Tinggi(Nilai MST 4-5)</td>
            </tr>
        </table>
        <tr>
            <td style="padding-top: 10px">2. Pasien mempunyai kondisi khusus:
            </td>
        </tr>
        <table>
            <tr>
                <td><input type="checkbox"></td>
                <td>Ya</td>
            </tr>
            <tr>
                <td><input type="checkbox"></td>
                <td>Tidak</td>
            </tr>
        </table>
        <tr>
            <td style="padding-top: 10px">3. Alergi Makanan:
            </td>
        </tr>
        <table>
            <tr>
                <td><input type="checkbox"></td>
                <td>Telur</td>
                <td><input type="checkbox"></td>
                <td>Udang</td>
            </tr>
            <tr>
                <td><input type="checkbox"></td>
                <td>Susu sapi & Produk Olahannya</td>
                <td><input type="checkbox"></td>
                <td>Ikan</td>
            </tr>
            <tr>
                <td><input type="checkbox"></td>
                <td>Kacang Kedelai / Tanah</td>
                <td><input type="checkbox"></td>
                <td>Hazelnut / Almond</td>
            </tr>
            <tr>
                <td><input type="checkbox"></td>
                <td>Gluten / Gandum</td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="padding-top: 10px">4. Preskripsi :</td>
                <td><input type="checkbox"></td>
                <td>Makanan Biasa</td>
                <td><input type="checkbox"></td>
                <td>Diet Khusus</td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="padding-top: 10px">5. Tindak Lanjut :</td>
                <td><input type="checkbox"></td>
                <td>Perlu asuhan gizi (lanjutkan ke Asesmen gizi)</td>
            </tr>
            <tr>
                <td></td>
                <td><input type="checkbox"></td>
                <td>Belum perluh asuhan gizi</td>
            </tr>
        </table>
        <tr>
            <td>6. Kesimpulan:</td>
        </tr>
        <tr>
            <td style="text-align: right; padding-top:20px;">Tgl:........................Jam:........................WIB</td>
        </tr>
        <tr>
            <td style="text-align: right; Padding-right:110px;"><b>Ahli Gizi,</b></td>
        </tr>
        <tr>
            <td style="text-align: right; padding-top:30px;">......................................................................</td>
        </tr>
        <tr>
        <td style="text-align: right; Padding-right:80px;"><i>Nama & Tanda Tangan</i></td>
        </tr>
    </table>
</body>