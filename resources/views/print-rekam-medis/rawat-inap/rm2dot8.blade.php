<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM2.8</title>
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

        .td1 {
            width: 32%;
            padding-left: 5px;
            padding-right: 5px;
        }

        .td2 {
            width: 14%;
            padding-left: 5px;
            padding-right: 5px;
        }

        .td3 {
            width: 1%;
            padding-left: 5px;
            padding-right: 5px;
        }

        .td4 {
            width: 7%;
            padding-left: 5px;
            padding-right: 5px;
        }

        .td5 {
            width: 10%;
            padding-left: 5px;
            padding-right: 5px;
        }

        .td6 {
            width: 32%;
            padding-left: 5px;
            padding-right: 5px;
        }


        .tablee2 {
            border-left: 1px solid black;
            border-right: 1px solid black;
            border-collapse: collapse;

        }

        .logo {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 200px;
            /* Ubah ukuran sesuai kebutuhan Anda */
        }

        .sizesmall {
            font-size: 9.7;
        }


        .page_break {
            page-break-before: always;
        }
    </style>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;"></div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 2.8/PAKRI/22
        </div>
        @include('print-rekam-medis.partials.header')
    </div>
    <div class="wrap">
        <table class="tablee2" style="width: 100%; text-align: center;">
            <tr>
                <td style="text-align: center" colspan="4"><b>PENGKAJIAN AWAL KEPERAWATAN RAWAT INAP</b></td>
            </tr>
        </table>
        <table class="tablee2" style="width:100%;">
            <tr>
                <td class="td1" style="border-right:1px solid black; border-top:1px solid black; ">Tgl masuk:</td>
                <td class="td2" style="border-top:1px solid black;">Sumber data :</td>
                <td class="td3" style="border-top:1px solid black;"><input type="checkbox"></td>
                <td class="td4" style="border-top:1px solid black;">Pasien</td>
                <td class="td3" style="border-top:1px solid black;"><input type="checkbox"></td>
                <td class="td5" style="border-top:1px solid black;">Keluarga</td>
                <td class="td6" style="border-left:1px solid black; border-top:1px solid black; ">Ruangan:</td>
            </tr>
            <tr>
                <td class="td1" style="border-right:1px solid "></td>
                <td class="td2"></td>
                <td class="td3"><input type="checkbox"></td>
                <td class="td4">Lainnya:</td>
                <td class="td3" colspan="2">........</td>
                <td class="td6" style="border-left:1px solid black; "></td>
            </tr>
            <tr>
                <td class="td1" style="border-right:1px solid ">Gelang Identifikasi:</td>
                <td class="td2"></td>
                <td class="td3"></td>
                <td class="td4"></td>
                <td class="td3" colspan="2"></td>
                <td class="td6" style="border-left:1px solid black; "></td>
            </tr>
            <tr>
                <td>
                    <table>
                        <td><input type="checkbox"></td>
                        <td>Ya</td>
                        <td><input type="checkbox"></td>
                        <td>Tidak</td>
                    </table>
                </td>
                <td style="border-left:1px solid black;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="border-left:1px solid black;"></td>
            </tr>
        </table>
        <table class="tablee" style="width: 100%;">
            <div class="sizesmall">
                <table style="width: 100%;">
                    <tr>
                        <td colspan="11" style="padding-left: 5px;">
                            <b><u>PSIKOSOSIAL</u></b>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-left: 5px;"> Status Pernikahan</td>
                        <td><input type="checkbox"></td>
                        <td>Single</td>
                        <td><input type="checkbox"></td>
                        <td>Menikah</td>
                        <td><input type="checkbox"></td>
                        <td>Bercerai</td>
                        <td><input type="checkbox"></td>
                        <td colspan="3">Janda/duda</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 5px;">Anak</td>
                        <td><input type="checkbox"></td>
                        <td>Tidak ada</td>
                        <td><input type="checkbox"></td>
                        <td colspan="7">Ada, jumlah anak.........</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 5px;">Pendidikan Terakhir</td>
                        <td><input type="checkbox"></td>
                        <td>SD</td>
                        <td><input type="checkbox"></td>
                        <td>SMP</td>
                        <td><input type="checkbox"></td>
                        <td>SMA</td>
                        <td><input type="checkbox"></td>
                        <td>Akademi</td>
                        <td><input type="checkbox"></td>
                        <td>Sarjana</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="checkbox"></td>
                        <td colspan="9">Lainnya</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 5px;">Warganegara</td>
                        <td><input type="checkbox"></td>
                        <td>WNI</td>
                        <td><input type="checkbox"></td>
                        <td colspan="7  ">WNA</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 5px;">Pekerjaan</td>
                        <td><input type="checkbox"></td>
                        <td>PNS</td>
                        <td><input type="checkbox"></td>
                        <td>Swasta</td>
                        <td><input type="checkbox"></td>
                        <td>TNI/Polri</td>
                        <td><input type="checkbox"></td>
                        <td colspan="3">Tidak Bekerja</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 5px;">Tinggal Bersama</td>
                        <td><input type="checkbox"></td>
                        <td>Suami/Istri</td>
                        <td><input type="checkbox"></td>
                        <td>Anak</td>
                        <td><input type="checkbox"></td>
                        <td>Orangtua</td>
                        <td><input type="checkbox"></td>
                        <td>Sendiri</td>
                        <td><input type="checkbox"></td>
                        <td>Lainnya</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="4">Nama:..........................</td>
                        <td colspan="6">No telpon:................</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="4">Nama:..........................</td>
                        <td colspan="6">No telpon:................</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 5px;">Kebiasaan</td>
                        <td><input type="checkbox"></td>
                        <td>Merokok</td>
                        <td><input type="checkbox"></td>
                        <td>Alkohol</td>
                        <td><input type="checkbox"></td>
                        <td>Lainnya</td>
                        <td colspan="4">Jenis dan jumlah perhari:......</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 5px;">Agama</td>
                        <td><input type="checkbox"></td>
                        <td>Islam</td>
                        <td><input type="checkbox"></td>
                        <td>Kristen</td>
                        <td><input type="checkbox"></td>
                        <td>Katolik</td>
                        <td><input type="checkbox"></td>
                        <td>Hindu</td>
                        <td><input type="checkbox"></td>
                        <td>Budha</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 5px;">Masalah dalam berbicara</td>
                        <td><input type="checkbox"></td>
                        <td>Tidak</td>
                        <td><input type="checkbox"></td>
                        <td colspan="7">Ya, jelaskan</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 5px;" colspan="11">Bahasa sehari-hari.............................</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 5px;">Perlu Penterjemah</td>
                        <td><input type="checkbox"></td>
                        <td>Tidak</td>
                        <td><input type="checkbox"></td>
                        <td colspan="7">Ya,Bahasa.......................</td>
                </table>
                <table style="width: 100%;">
                    <tr>
                        <td colspan="11" style="padding-left: 5px;">
                            <b><u>KEBUTUHAN KOMUNIKASI/PENDIDIKAN DAN PENGAJARAN</u></b>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-left: 5px;"><b>Bicara:</b></td>
                        <td style="text-align: right"><input type="checkbox"></td>
                        <td>Normal</td>
                        <td style="text-align: right"><input type="checkbox"></td>
                        <td colspan="7">Serangan awal gangguan bicara, kapan:________</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 5px;"><b>Bahasa Sehari-hari:</b></td>
                        <td style="text-align: right"><input type="checkbox"></td>
                        <td>Indonesia, aktif/pasif</td>
                        <td style="text-align: right"><input type="checkbox"></td>
                        <td colspan="7">Daerah, jelaskan____</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="text-align: right"><input type="checkbox"></td>
                        <td>Inggris, aktif/pasif</td>
                        <td style="text-align: right"><input type="checkbox"></td>
                        <td colspan="7">Lain-lain, jelaskan____</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 5px;"><b>Perlu Penterjemah:</b></td>
                        <td style="text-align: right"><input type="checkbox"></td>
                        <td>Ya</td>
                        <td style="text-align: right"><input type="checkbox"></td>
                        <td colspan="7">Tidak</td>
                    </tr>
                </table>
                <table style="width: 100%;">
                    <tr>
                        <td colspan="8" style="padding-left: 5px;">
                            <b><u>Hambatan Belajar</u></b>
                        </td>
                        <td colspan="3"><b><u>Cara belajar yang disukai</u></b> </td>
                    </tr>
                    <tr>
                        <td style="padding-left: 5px;"><input type="checkbox"></td>
                        <td>Bahasa</td>
                        <td style="text-align: right"><input type="checkbox"></td>
                        <td colspan="4">Cemas</td>
                        <td style="text-align: right"><input type="checkbox"></td>
                        <td>Kongnitif</td>
                        <td style="text-align: right"> <input type="checkbox"></td>
                        <td>Audio-Visual/gambar</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 5px;"><input type="checkbox"></td>
                        <td>Pendegaran</td>
                        <td style="text-align: right"><input type="checkbox"></td>
                        <td colspan="4">Emosi</td>
                        <td style="text-align: right"><input type="checkbox"></td>
                        <td>Diskusi</td>
                        <td style="text-align: right"> <input type="checkbox"></td>
                        <td>Membaca</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 5px;"><input type="checkbox"></td>
                        <td>Hilang Memori</td>
                        <td style="text-align: right"><input type="checkbox"></td>
                        <td colspan="2">Kesulitan Bicara</td>
                        <td style="text-align: right"></td>
                        <td></td>
                        <td style="text-align: right"> <input type="checkbox"></td>
                        <td>Menulis</td>
                        <td style="text-align: right"> <input type="checkbox"></td>
                        <td>Menulis</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 5px;"><input type="checkbox"></td>
                        <td>Motivasi Buruk</td>
                        <td style="text-align: right"><input type="checkbox"></td>
                        <td colspan="4">Tidak Ada Partispasi dari caregiver</td>
                        <td style="text-align: right"><input type="checkbox"></td>
                        <td>Mendengar</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 5px;"><input type="checkbox"></td>
                        <td>Masalah Penglihatan</td>
                        <td style="text-align: right"><input type="checkbox"></td>
                        <td colspan="8">Tidak Ditemukan Hambatan Belajar</td>
                    </tr>
                    <tr>
                        <td style="padding-left: 5px;"><input type="checkbox"></td>
                        <td colspan="10">Secara Fisiologi Tidak Mampu Belajar</td>
                    </tr>
                </table>
                <table style="width: 100%">
                    <tr>
                        <td><b>Tingkat Pendidikan:</b></td>
                        <td><input type="checkbox"></td>
                        <td>TK</td>
                        <td><input type="checkbox"></td>
                        <td>SD</td>
                        <td><input type="checkbox"></td>
                        <td>SMP</td>
                        <td><input type="checkbox"></td>
                        <td>SMA</td>
                        <td><input type="checkbox"></td>
                        <td>Akademi</td>
                        <td><input type="checkbox"></td>
                        <td>Sarjana</td>
                        <td><input type="checkbox"></td>
                        <td>Lain-lain</td>
                    </tr>

                </table>
                <table style="width: 100%">
                    <tr>
                        <td><b>Potensial Kebutuhan Pembelajaran:</b></td>
                        <td><input type="checkbox"></td>
                        <td>Proses Penyakit</td>
                        <td><input type="checkbox"></td>
                        <td>Pengobatan/Tindakan</td>
                        <td><input type="checkbox"></td>
                        <td>Terapi/Obat</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="checkbox"></td>
                        <td>Nutrisi</td>
                        <td><input type="checkbox"></td>
                        <td colspan="3">Lain-lain,Jelaskan...........................</td>
                    </tr>
                </table>
            </div>
        </table>
        <div class="page_break"></div>
        <table class="tablee" style="width: 100%">
            <table>
                <tr>
                    <td colspan="11" style="padding-left: 5px;"><b>Keluhan Utama :</b></td>
                </tr>
                <tr>
                    <td colspan="11" style="padding-left: 5px;">Penyakit Yang Pernah Diderita :</td>
                </tr>
                <tr>
                    <td style="padding-left: 5px; width:56%;">Tiba di ruang rawat dengan cara :</td>
                    <td><input type="checkbox"></td>
                    <td>Jalan</td>
                    <td><input type="checkbox"></td>
                    <td>Kursi Roda</td>
                    <td><input type="checkbox"></td>
                    <td colspan="5">Branker</td>
                </tr>
            </table>
            <table>
                <tr>
                    <td style="padding-left: 5px;" colspan="11"><b><u>Keadaan Umum</u></b></td>
                </tr>
                <tr>
                    <td style="padding-left: 5px;">TANDA VITAL</td>
                    <td colspan="10">Tekanan Darah: &nbsp;mm/Hg, RR: &nbsp;HR: &nbsp; Suhu &nbsp; &deg;C</td>
                </tr>
                <tr>
                    <td style="padding-left: 5px;">Tingkat Kedasaran: </td>
                    <td style="text-align: right"><input type="checkbox"></td>
                    <td>Conpos Metis</td>
                    <td style="text-align: right"><input type="checkbox"></td>
                    <td>Apatis</td>
                    <td style="text-align: right"><input type="checkbox"></td>
                    <td>Delirium</td>
                    <td style="text-align: right"><input type="checkbox"></td>
                    <td>Somnolen</td>
                </tr>
                <tr>
                    <td> </td>
                    <td style="text-align: right"><input type="checkbox"></td>
                    <td>Sopor Koma</td>
                    <td style="text-align: right"><input type="checkbox"></td>
                    <td>Koma</td>
                    <td colspan="4">GCS:E_M_V_</td>
                </tr>
            </table>
            <table>
                <tr>
                    <td style="padding-left: 5px;"><b><u>Skala Nyeri :</u></b></td>
                </tr>
            </table>
            <table>
                <tr>
                    <td style="padding-left: 10px;" rowspan="4"> <img src="images/PAT.png" alt="Logo" class="logo"></td>
                </tr>
                <tr>
                    <td style="padding-left: 15px;"><input type="checkbox"></td>
                    <td>Nyeri kronis</td>
                    <td>Lokasi:</td>
                    <td style="padding-left:50px">Waktu</td>
                </tr>
                <tr>
                    <td style="padding-left: 15px;"><input type="checkbox"></td>
                    <td>Nyeri Akur</td>
                    <td>Lokasi:</td>
                    <td style="padding-left:50px">Waktu</td>
                </tr>
                <tr>
                    <td style="padding-left: 15px;"><input type="checkbox"></td>
                    <td>Tidak Ada Nyeri</td>
                    <td>Lokasi:</td>
                    <td style="padding-left:50px">Waktu</td>
                </tr>
            </table>
            <tr>
                <td style="padding-left: 5px"><b><u>PEMERIKSAAN FISIK</u></b></td>
            </tr>
            <table class="tablee" style="width: 100%; font-size: 15px; padding:10px;">
                <tr>
                    <td style="border-right:1px solid black; padding-left: 5px;">Pernapasan</td>
                    <td style="text-align: right"><input type="checkbox"></td>
                    <td>Normal</td>
                </tr>
                <tr>
                    <td style="border-right:1px solid black;"></td>
                    <td style="text-align: right"><input type="checkbox"></td>
                    <td>Suara Pernapasan.................</td>
                </tr>
                <tr>
                    <td style="border-right:1px solid black; border-top:1px solid black; padding-left: 5px;">
                        Cardiovaskuler</td>
                    <td style="border-top:1px solid black; text-align: right;"><input type="checkbox"></td>
                    <td style="border-top:1px solid black;"> Suara & irama jantung normal</td>
                </tr>
                <tr>
                    <td style="border-right:1px solid black;"></td>
                    <td style="text-align: right"><input type="checkbox"></td>
                    <td>Irama ireguler</td>
                </tr>
                <tr>
                    <td style="border-right:1px solid black; border-top:1px solid black; padding-left: 5px;">Persyarafan
                    </td>
                    <td style="border-top:1px solid black; text-align: right;"><input type="checkbox"></td>
                    <td style="border-top:1px solid black;"> Pupil Isokor /anisokor*)</td>
                </tr>
                <tr>
                    <td style="border-right:1px solid black;"></td>
                    <td style="text-align: right"><input type="checkbox"></td>
                    <td>Kelumpuhan.....................</td>
                </tr>
                <tr>
                    <td style="border-right:1px solid black; border-top:1px solid black; padding-left: 5px;">Perkemihan
                    </td>
                    <td style="border-top:1px solid black; text-align: right;"><input type="checkbox"></td>
                    <td style="border-top:1px solid black; ">Normal</td>
                </tr>
                <tr>
                    <td style="border-right:1px solid black;"></td>
                    <td style="text-align: right"><input type="checkbox"></td>
                    <td>Retensi Urine.....................</td>
                </tr>
                <tr>
                    <td style="border-right:1px solid black;"></td>
                    <td style="text-align: right"><input type="checkbox"></td>
                    <td>Pola BAB/BAK +/-</td>
                </tr>
                <tr>
                    <td style="border-right:1px solid black; border-top:1px solid black; padding-left: 5px;">Pencernaan
                    </td>
                    <td style="border-top:1px solid black; text-align: right"><input type="checkbox"></td>
                    <td style="border-top:1px solid black;"> Normal</td>
                </tr>
                <tr>
                    <td style="border-right:1px solid black;"></td>
                    <td style="text-align: right"><input type="checkbox"></td>
                    <td>Bising usus +/-</td>
                </tr>
                <tr>
                    <td style="border-right:1px solid black; border-top:1px solid black; padding-left: 5px;">
                        Musculoskeletal</td>
                    <td style="border-top:1px solid black; text-align: right;"><input type="checkbox"></td>
                    <td style="border-top:1px solid black; "> Normal</td>
                </tr>
                <tr>
                    <td style="border-right:1px solid black;"></td>
                    <td style="text-align: right"><input type="checkbox"></td>
                    <td>Fraktur &nbsp; Lokasi....... </td>
                </tr>
                <tr>
                    <td style="border-right:1px solid black;"></td>
                    <td style="text-align: right"><input type="checkbox"></td>
                    <td>Luka &nbsp; Lokasi....... </td>
                </tr>
                <tr>
                    <td style="border-right:1px solid black;"></td>
                    <td style="text-align: right"><input type="checkbox"></td>
                    <td>Oedema </td>
                </tr>
            </table>
        </table>