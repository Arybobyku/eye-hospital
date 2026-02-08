<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM2.9</title>
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

        .tablee2dot9 {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .tablee2dot92 {
            border-left: 1px solid black;
            border-right: 1px solid black;
            border-collapse: collapse;

        }

        .td12dot9 {
            width: 2%;
        }

        .td22dot9 {
            width: 98%;
        }

        .smallfont2dot9 {
            font-size: 10;
        }
    </style>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;"></div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png');  ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 2.9/PPPJ/22
        </div>
        @include('print-rekam-medis.partials.header')
    </div>
    <div class="smallfont2dot9">
        <table class="tablee2dot92" style="width: 100%; text-align: center;">
            <tr>
                <td style="text-align: center" colspan="4"><b>PELAKSANAAN PENCEGAHAN PASIEN JATUH</b></td>
            </tr>
        </table>
        <table class="tablee2dot9" style="width :100%">
            <table style="width: 100%; margin:3px;">
                <tr>
                    <td>Tanggal Pelaksanaan</td>
                    <td> : {{ $data->tanggal_pelaksanaan ?? '' }}
</td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td> : Berikan tanda ceklis pada box tindakan yang dilakukan</td>
                </tr>
            </table>
            <table style="width: 100%; margin:16px;">
                <tr>
                    <td colspan="2">1. Tindakan Berisiko Jatuh</td>
                </tr>
                <tr >
                    <td colspan="2" style="padding-bottom: 10px">Lakukan Perawatan yang Baik</td>
                </tr>
                <tr>
                    <td colspan="2">2. Resiko Jatuh Rendah</td>
                </tr>
                <tr>
                    <td colspan="2">Catatan Tindakan Beresiko Jatuh: </td>
                </tr>
                <tr>
                    <td colspan="2">{{ $data->catatan_beresiko_jatuh ?? '' }}</td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-top: 10px">Lakukan Intervensi jatuh standart:</td>
                </tr>
                <tr>
                    <td class="td12dot9"><input type="checkbox" {{ $data != null && $data->rendah_benda_pribadi == 'Ya' ? 'Checked' : '' }}></td>
                    <td class="td22dot9">Benda-benda pribadi dalam jangkauan (telepon genggam, bel pasien, air
                        minum,kacamata, dll)</td>
                </tr>
                <tr>
                    <td><input type="checkbox" {{ $data != null && $data->rendah_roda_terkunci == 'Ya' ? 'Checked' : '' }}></td>
                    <td>Roda tempat tidur dalam posisi terkunci</td>
                </tr>
                <tr>
                    <td><input type="checkbox" {{ $data != null && $data->rendah_posisi_rendah == 'Ya' ? 'Checked' : '' }}></td>
                    <td>Posisikan tempat tidur pada posi rendah</td>
                </tr>
                <tr>
                    <td><input type="checkbox" {{ $data != null && $data->rendah_pagar_pengaman == 'Ya' ? 'Checked' : '' }}></td>
                    <td>Pagar pengaman tempat tidur dinaikkan</td>
                </tr>
                <tr>
                    <td><input type="checkbox" {{ $data != null && $data->rendah_monitor_berkala == 'Ya' ? 'Checked' : '' }}></td>
                    <td>Monitor kebutuhan pasien secara berkala, kunjungi pasien minimal 2 kali dalam 1 shift</td>
                </tr>
                <tr>
                    <td><input type="checkbox" {{ $data != null && $data->rendah_edukasi == 'Ya' ? 'Checked' : '' }}></td>
                    <td>Berikan edukasi untuk menjegah jatuh kepada pasien dan keluarga. Berikan brosur mencegah jatuh
                        jika ada</td>
                </tr>
                <tr>
                    <td><input type="checkbox" {{ $data != null && $data->rendah_pintu_lampu == 'Ya' ? 'Checked' : '' }}></td>
                    <td>Biarkan pintu terbuka, gunakan lampu pada malam hari</td>
                </tr>
                <tr>
                    <td><input type="checkbox" {{ $data != null && $data->rendah_alat_bantu == 'Ya' ? 'Checked' : '' }}></td>
                    <td>Gunakan alat bantu jalan (walker,handrail)</td>
                </tr>
                <tr>
                    <td><input type="checkbox" {{ $data != null && $data->rendah_alas_kaki == 'Ya' ? 'Checked' : '' }}></td>
                    <td>Anjurkan pasien mengggunakan kaus kaki atau sandal/ sepatu yang tidak licin</td>
                </tr><br>
                <tr>
                    <td colspan="2">3. Resiko Jatuh tinggi</td>
                </tr>
                <tr>
                    <td colspan="2">Lakukan Intervensi Jatuh Tinggi:</td>
                </tr>
                <tr>
                    <td><input type="checkbox" {{ $data != null && $data->tinggi_semua_standar == 'Ya' ? 'Checked' : '' }}></td>
                    <td>Lakukan semua intervensi jatuh standar</td>
                </tr>
                <tr>
                    <td><input type="checkbox" {{ $data != null && $data->tinggi_gelang_kuning == 'Ya' ? 'Checked' : '' }}></td>
                    <td>Pasangkan gelang khusus (warna kuning) sebagai tanda risiko pasien jatuh</td>
                </tr>
                <tr>
                    <td><input type="checkbox" {{ $data != null && $data->tinggi_tanda_pintu == 'Ya' ? 'Checked' : '' }}></td>
                    <td>Berikan tanda risiko pasien jatuh pada pintu kamar pasien atau pada bed pasien</td>
                </tr>
                <tr>
                    <td><input type="checkbox" {{ $data != null && $data->tinggi_dekat_nurse == 'Ya' ? 'Checked' : '' }}></td>
                    <td>Pasien ditempatkan dekat nurse station</td>
                </tr>
                <tr>
                    <td><input type="checkbox" {{ $data != null && $data->tinggi_kunjungi_1jam == 'Ya' ? 'Checked' : '' }}></td>
                    <td>Kunjungi dan monitor pasien setiap 1 jam</td>
                </tr>
                <tr>
                    <td><input type="checkbox" {{ $data != null && $data->tinggi_edukasi_obat == 'Ya' ? 'Checked' : '' }}></td>
                    <td>Edukasi pasien tentang efek samping obat yang diberikan</td>
                </tr>
                <tr>
                    <td><input type="checkbox" {{ $data != null && $data->tinggi_dampingi_kamar_mandi == 'Ya' ? 'Checked' : '' }}></td>
                    <td>Dampingi pasien ke kamar mandi dan tidak meninggalkan pasien di kamar mandi,</td>
                </tr>
                <tr>
                    <td><input type="checkbox" {{ $data != null && $data->tinggi_tempat_duduk == 'Ya' ? 'Checked' : '' }}></td>
                    <td>Anjurkan menggunakan tempat duduk di kamar mandi saat pasien mandi</td>
                </tr>
                <tr>
                    <td><input type="checkbox" {{ $data != null && $data->tinggi_bel_toilet == 'Ya' ? 'Checked' : '' }}></td>
                    <td>Informasikan cara menggunakan bel di toilet untuk memanggil perawat, pintu kamar mandi jangan
                        dikunci</td>
                </tr>
                <tr>
                    <td><input type="checkbox" {{ $data != null && $data->tinggi_komunikasi_shift == 'Ya' ? 'Checked' : '' }}></td>
                    <td>Komunikasikan risiko pasien jatuh pada saat laporan antara shift</td>
                </tr>
            </table>
            <table style="width: 100%; text-align:center; margin-left:30%">
                <tr>
                    <td>Petugas yang melaksanakaan pencegahan</td>
                </tr>
                <tr>
                     <td>    <img src="{{ $data->ttd_petugas }}" alt="Base64 Image" width="100px">  </td>
                </tr>
                <tr>
                     <td> {{ $data->nama_petugas_ttd ?? '' }}</td>
                </tr>
            </table>
        </table>
        
    </div>