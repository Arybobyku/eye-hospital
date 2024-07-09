<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM1.2</title>
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

        .sizesmall {
            font-size: 9;
        }

        .tablee {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .page_break {
            page-break-before: always;
        }
    </style>

</head>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;">
    </div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 1.2/FEPDKRJ/22
        </div>
        <table style="border-collapse: collapse;">
            {{-- HEADER --}}
            @include('print-rekam-medis.partials.header')
            {{-- PENGKAJIAN KEPERAWATAN MATA RAWAT JALAN --}}
            <tr style="border: 1px solid black; sizeSmall">
                <div style="width: 100%; text-align: center; margin-top: 0px; margin-top:5px; font-weight: bold">
                    FORMULIR EDUKASI PASIEN DAN KELUARGA RAWAT JALAN
                </div>
                <div style="width: 100%; text-align: center; margin-top: 0px; line-height: 21px; margin-bottom: 3px; ">
                    <i>(BERI TANDA CHEKLIST  PADA KOTAK YANG SESUAI DENGAN KEBUTUHAN
                        PASIEN DAN KELUARGA)</i>
                </div>
            </tr>
            {{-- Tanggal --}}
            <tr style="border: 1px solid black; width:100%">
                <div class="sizesmall ">
                    <table style="border-collapse: collapse; width:100%;">
                        <tr>
                            <td style="border-right: 1px solid black; width:100%;">
                                <b>Pengkajian Hambatan</b>
                                <table style="border-collapse: collapse; width:100%;">
                                    <tr>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Bahasa
                                        </td>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Cemas
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Pendegaran
                                        </td>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Emosi
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Masalah penglihatan
                                        </td>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Kongnitif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Bicara buruk
                                        </td>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Hilang memori
                                        </td>
                                    </tr>
                                </table>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Tidak ada partisipasi
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Secara fisiologi tidak mampu belajar
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Tidak ditemukan hambatan belajar
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            &nbsp;
                                        </td>
                                    </tr>
                                </table>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>>
                                        <td colspan="2">
                                            <b>Edukasi</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Tata Tertib RS
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Hak Dan Kewajiban Pasien
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            &nbsp;
                                        </td>
                                    </tr>
                                </table>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td>
                                            <b>Metode Cara Belajar Yang Disukai</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            1 = Audio
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            2 = Demonstrasi
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            3 = Lisan
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            4 = Tulisan
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            5 = Visual
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            &nbsp;
                                        </td>
                                    </tr>
                                </table>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>>
                                        <td colspan="2">
                                            <b>Keterangan</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            : Beri tanda "&#10004;" atau "0"
                                        </td>
                                    </tr>

                                </table>
                                <br><br><br><br><br><br><br><br><br><br><br><br>
                            </td>
                            <td style="border-right: 1px solid black; width:100%">
                                <b>Pengkajian Bicara :</b>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Normal
                                        </td>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Gangguan Bicara
                                        </td>
                                    </tr>
                                </table>
                                <b>Bahasa Sehari-hari :</b>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Indonesia
                                        </td>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Daerah
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            Jelaskan.....
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Inggris
                                        </td>
                                        <td><input type="checkbox" checked></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            Lainya.....
                                        </td>
                                    </tr>
                                </table>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td><b>Bahasa Isyarat :</b> </td>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Ya
                                        </td>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Tidak
                                        </td>
                                    </tr>
                                </table>
                                <b>Tingkat Pendidikan :</b>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            TK
                                        </td>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            SD
                                        </td>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            SMP
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            SMA
                                        </td>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Diploma
                                        </td>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Sarjana
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Lain-lain
                                        </td>
                                    </tr>
                                </table>
                                <b> Agama :</b>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Islam
                                        </td>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Protestan
                                        </td>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            katolik
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Hindu
                                        </td>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Budha
                                        </td>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Lain-lain
                                        </td>
                                    </tr>
                                </table>
                                <b>Tingkat Pengetahuan Kesehatan Pasien :</b>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Paham
                                        </td>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Kurang paham
                                        </td>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Tidak paham
                                        </td>
                                    </tr>
                                </table>
                                <b>Nilai-nilai Pasien Dan Budaya :</b>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Modern
                                        </td>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Moderat
                                        </td>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Konvesional
                                        </td>
                                    </tr>
                                </table>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td>Merokok</td>
                                        <td>:</td>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Ya
                                        </td>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Tidak
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Konsumsi Alkohol </td>
                                        <td>:</td>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Ya
                                        </td>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Tidak
                                        </td>
                                    </tr>
                                </table>
                                <b>Kesedian Menerima Informasi :</b>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Ya
                                        </td>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Tidak,alasan......
                                        </td>
                                    </tr>
                                </table>
                                <b>Rencana Pendidikan Kesehatan :</b>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Proses Penyakit
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Pengobatan/Tindakan
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Nutrisi
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Edukasi Kolaboratif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" checked></td>
                                        <td>
                                            Lain-lain................
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width:100%">
                                <b>Penerima Pendidikan</b>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td>
                                            P = Pasien
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            K = Keluarga
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            L = Lain-lain
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            &nbsp;
                                        </td>
                                    </tr>
                                </table>
                                <b>Frekuensi Edukasi</b>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td>
                                            1 = Edukasi Pertama
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            2 = Re-edukasi ke 2/3 atau lebih
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            &nbsp;
                                        </td>
                                    </tr>
                                </table>
                                <b>Evaluasi Respon </b>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td>
                                            1 = Tidak Mengerti
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            2 = Menyatakan Paham
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            3 = Mampu Menjelaskan
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            4 = Mampu Demonstrasi/Simulasi
                                        </td>
                                    </tr>
                                </table>
                                <div style="height: 400px">

                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </tr>
            {{-- Status Fungsional --}}
            <tr style="border: 1px solid black; width:100%">
                <table style="border-collapse: collapse; width:100%">
                    <tr>
                        <td style="">
                            Kebutuhan Privasi:
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td><input type="checkbox" checked></td>
                                    <td>Ya</td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td><input type="checkbox" checked></td>
                                    <td>Tidak</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </tr>
            <tr style="border: 1px solid black; width:100%">
                <table style="border-collapse: collapse; width:100%">
                    <tr>
                        <td style="">
                            Nama Pengkaji :..............
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td>Tanggal :..............</td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td>Jam :..............</td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td>Tanda Tangan :..............</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </tr>
            <div class="page_break"></div>
            <table class="tablee sizesmall" style="width:100%; position:relative; ">
                <tr class="tablee">
                    <th class="tablee">Tanggal</th>
                    <th class="tablee">Poliklinik</th>
                    <th class="tablee">Penjelasan Edukasi Tentang</th>
                    <th class="tablee">Tanda Tangan nama Petugas & Profesi</th>
                    <th class="tablee">Sasaran Edukasi (Nama & Hubungannya Dengan Pasien)</th>
                    <th class="tablee">Evaluasi</th>
                </tr>
                @for($i = 0; $i < 20; $i++)
                 <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> </td>
                    <td class="tablee"> </td>
                    <td class="tablee"> </td>
                    <td class="tablee"> </td>
                    <td class="tablee"> </td>
                    <td class="tablee">
                        <table>
                            <tr>
                                <td><input type="checkbox" checked></td>
                                <td>
                                    Sudah Dimengerti
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" checked></td>
                                <td>
                                    Re-Demonstrasi
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" checked></td>
                                <td>
                                    Re Edukasi
                                </td>
                            </tr>
                        </table>
                    </td>
                    </tr>
                    @endfor

            </table>
            {{-- Keluhan Utama --}}
        </table>
    </div>
</body>
<?php

// function bulans($bln)
// {
//     if ($bln == '01') {
//         $bln = 'Januari';
//     } elseif ($bln == '02') {
//         $bln = 'Februari';
//     } elseif ($bln == '03') {
//         $bln = 'Maret';
//     } elseif ($bln == '04') {
//         $bln = 'April';
//     } elseif ($bln == '05') {
//         $bln = 'Mei';
//     } elseif ($bln == '06') {
//         $bln = 'Juni';
//     } elseif ($bln == '07') {
//         $bln = 'Juli';
//     } elseif ($bln == '08') {
//         $bln = 'Agustus';
//     } elseif ($bln == '09') {
//         $bln = 'September';
//     } elseif ($bln == '10') {
//         $bln = 'Oktober';
//     } elseif ($bln == '11') {
//         $bln = 'November';
//     } elseif ($bln == '12') {
//         $bln = 'Desember';
//     }
//     return $bln;
// }

?>

</html>