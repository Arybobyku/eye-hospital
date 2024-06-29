<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM1.3</title>
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
    </style>

</head>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;">
    </div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <?php $patimg = storage_path('app/public/images/PAT.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 1.3/PKMRJ/22
        </div>
        <table style="border-collapse: collapse;">
            {{-- HEADER --}}
            <tr style="border: 1px solid black;">
                <div style="width: 100%;">
                    <table style="width: 100%;">
                        <tr style="border: 1px solid black;">
                            <td style="border-right: 1px solid black; width:100%">
                                <img style="width: 100%;"
                                    src="data:image/png;base64,
                            <?php echo base64_encode(file_get_contents($fullpath)); ?>" />
                            </td>
                            <td style="width: 50%">
                                <table style="width: 100%" border="0">
                                    <tr>
                                        <td width="20%">Nama</td>
                                        <td width="1%">:</td>
                                        <td width=50%>..........</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">Tgl. Lahir</td>
                                        <td width="1%">:</td>
                                        <td width=50%>..........</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">No.RM</td>
                                        <td width="1%">:</td>
                                        <td width=50%>..........</td>
                                    </tr>
                                    <tr>
                                        <td width="10%">NIK</td>
                                        <td width="1%">:</td>
                                        <td width=50%>..........</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </tr>
            {{-- PENGKAJIAN KEPERAWATAN MATA RAWAT JALAN --}}
            <tr style="border: 1px solid black;">
                <div style="width: 100%; text-align: center; margin-top: 0px; margin-top:5px; font-weight: bold">
                    PENGKAJIAN KEPERAWATAN MATA RAWAT JALAN
                </div>
                <div style="width: 100%; text-align: center; margin-top: 0px; line-height: 21px; margin-bottom: 3px; ">
                    <i>(dilengkapi dalam waktu 2 jam pertama pasien masuk ruang rawat jalan)</i>
                </div>
            </tr>
            {{-- Tanggal --}}
            <tr style="border: 1px solid black; width:100%">
                <table style="border-collapse: collapse; width:100%">
                    <tr>
                        <td style="border-right: 1px solid black; width:100%">
                            Tanggal:
                        </td>
                        <td style="border-right: 1px solid black; width:100%">
                            Waktu:
                        </td>
                        <td style="width:100%">
                            Perawat Pengkaji:
                        </td>
                    </tr>
                </table>
            </tr>
            {{-- Status Fungsional --}}
            <tr style="border: 1px solid black; width:100%">
                <table style="border-collapse: collapse; width:100%">
                    <tr>
                        <td style="">
                            Status Fungsional:
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td><input type="checkbox" checked></td>
                                    <td>Jalan tanpa bantuan</td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td><input type="checkbox" checked></td>
                                    <td>Kursi Roda</td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td><input type="checkbox" checked></td>
                                    <td>Tempat Tidur Dorong</td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td><input type="checkbox" checked></td>
                                    <td>Jalan dengan bantuan</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </tr>
            {{-- Keluhan Utama --}}
            <tr style="border: 1px solid black; width:100%">
                <table style="border-collapse: collapse; width:100%">
                    <tr>
                        <td style="border-right: 1px solid black; width:100%">
                            <div style="width: 100%;height:50px"><b>Keluhan Utama</b></div>
                            <div style="border-top: 1px solid black; width:100%; height:1px;"></div>
                            <div style="width: 100%;height:100px"><b>Riwayat Penyakit:</b></div>
                        </td>
                        <td style="width:100%;">
                            <b>KASUS URGENT:</b>
                            <table>
                                <tr>
                                    <td><input type="checkbox" checked></td>
                                    <td>MATA MERAH</td>
                                </tr>
                            </table>
                            <table>
                                <tr>
                                    <td><input type="checkbox" checked></td>
                                    <td>TRAUMA/KESAKITAN/</td>
                                </tr>
                            </table>
                            <table>
                                <tr>
                                    <td><input type="checkbox" checked></td>
                                    <td>MATA KABUR MENDADAK</td>
                                </tr>
                            </table>
                            <table>
                                <tr>
                                    <td><input type="checkbox" checked></td>
                                    <td>BALITA / MANULA</td>
                                </tr>
                            </table>
                            <table>
                                <tr>
                                    <td><input type="checkbox" checked></td>
                                    <td>LAINYA</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </tr>
            {{-- PEMERIKSAAN FISIK --}}
            <tr>
                <table style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black; width:100%; padding:5px" >
                    <tr>
                        <b>PEMERIKSAAN FISIK</b>
                    </tr>
                    <tr>
                        <td>TD</td>
                        <td>....../.....mmHg</td>
                        <td>Nadi</td>
                        <td>...........x/menit</td>
                        <td>RR</td>
                        <td>...........x/menit</td>
                    </tr>
                    <tr>
                        <td>BB</td>
                        <td>...........kg</td>
                        <td>TB</td>
                        <td>...........cm</td>
                        <td>Suhu</td>
                        <td>.......... C</td>
                    </tr>
                </table>
            </tr>
            <tr>
                <table style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black; width:100%; padding:5px" >
                    <tr>
                        <b>RIWAYAT KESEHATAN</b>
                    </tr>
                    
                    <tr>
                        <td>1. Penyakit yang pernah diderita :</td>
                        <td><input type="checkbox" checked></td>
                        <td>Diabetes</td>
                        <td><input type="checkbox" checked></td>
                        <td>Hipertensi</td>
                        <td><input type="checkbox" checked></td>
                        <td>Jantung</td>
                        <td><input type="checkbox" checked></td>
                        <td>Hrpatitis</td>
                        <td><input type="checkbox" checked></td>
                        <td>Asma</td>
                    </tr>
                    <tr>
                        <table>
                            <tr><td>Lainnya :</td>
                            <td>...........................</td></tr>
                        </table>
                    </tr>
                    <tr>
                        <td>2. Pernah Dioperasi :</td>
                        <td><input type="checkbox" checked></td>
                                    <td>Tidak</td>
                                    <td><input type="checkbox" checked></td>
                                    <td>Ya</td>
                    </tr>
                    <tr>
                        <table>
                            <tr>
                                <td>Jenis Operasi :</td>
                                <td>................................</td>
                            </tr>
                        </table>
                    </tr>
                    <tr>
                        <td>3. Riwayat Alergi :</td>
                        <td><input type="checkbox" checked></td>
                                    <td>Tidak</td>
                                    <td><input type="checkbox" checked></td>
                                    <td>Ya</td>
                    </tr>
                    <tr>
                        <td>Alergi Terhadap :</td>
                        <td><input type="checkbox" checked></td>
                        <td>Makanan :......</td>
                        <td><input type="checkbox" checked></td>
                        <td>Obat :......</td>
                    </tr>
                    <tr>
                        <td>4. Obat yang digunakan saat ini :</td>
                        <td><input type="checkbox" checked></td>
                        <td>Obat Pencair Darah</td>
                        <td><input type="checkbox" checked></td>
                        <td>Obat Prostat</td>
                        <td><input type="checkbox" checked></td>
                        <td>Obat Asma</td>
                        <td><input type="checkbox" checked></td>
                        <td>Obat Alergi</td>
                    </tr>
                    <tr>
                        <td>Lainnya :..........</td>
                    </tr>
                </table>
            </tr>
            <tr>
                <table style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black; width:100%; padding:5px" >
                    <tr>
                        <b>PENILAIAN RESIKO JATUH</b>
                    </tr> 
                    <tr>
                        <td>Resiko Jatuh</td>
                        <td><input type="checkbox" checked></td>
                        <td>YA</td>
                        <td><input type="checkbox" checked></td>
                        <td>TIDAK</td>
                    </tr>
                </table>
            </tr>
            <tr>
                <table style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black; width:100%; padding:5px" >
                <tr>
                    <td>
                        <table>
                            <tr><b>SKRINING NYERI</b></tr>
                            <tr>
                                <td>
                    <img style="width: 100%;"
                                    src="data:image/png;base64,
                            <?php echo base64_encode(file_get_contents($patimg)); ?>" /></td></tr>
                        </table>
                    </td>
                            <td>
                                <table>
                                    <tr>
                                        <table>
                                            <tr>
                                        <td>Nyeri :</td>

                                        <td>
                                            <table><tr><td><input type="checkbox" checked></td>
                                         <td>Tidak Ada Nyeri</td></tr></table></td>

                                        <td>
                                            <table><tr><td><input type="checkbox" checked></td>
                                         <td>Nyeri Akut</td></tr></table></td>
                                         <td>
                                            <table><tr><td><input type="checkbox" checked></td>
                                         <td>Nyeri </td></tr></table></td>
                                            </tr>
                                        </table>
                                        </tr>
                                    <tr>
                                        <td>
                                        <table>
                                            <tr><td>
                                                <table>
                                                    <tr><td>Skala Nyeri : ..........</td>
                                                        <td>Lokasi : ..........</td></tr>
                                                </table>
                                            </td>
                                            <td>
                                                <table>
                                                    <tr> <td>Karakteristik : ..........</td>
                                                        <td>Durasi : ..........</td></tr></tr>
                                                </table>
                                            </td>
                                        </tr>
                                    <tr>
                                        <table>
                                            <tr>
                                        <td>Nyeri hilang bila :</td>
                                        <td>
                                            <table><tr><td><input type="checkbox" checked></td>
                                         <td>Minum Obat</td></tr></table></td>

                                         <td>
                                            <table><tr><td><input type="checkbox" checked></td>
                                         <td>Istirahat</td></tr></table></td>

                                         <td>
                                            <table><tr><td><input type="checkbox" checked></td>
                                         <td>Berubah Posisi</td></tr></table></td>
                                            </tr>
                                        </table>

                                    </tr>
                                    <tr>
                                        <table>
                                            <tr>
                                        <td>Lainnya : ...........</td></tr></table>
                                    </tr>
                                </table>
                            </td>
                </table>
            </tr>
        </table>
    </div>
</body>
<?php

function bulans($bln)
{
    if ($bln == '01') {
        $bln = 'Januari';
    } elseif ($bln == '02') {
        $bln = 'Februari';
    } elseif ($bln == '03') {
        $bln = 'Maret';
    } elseif ($bln == '04') {
        $bln = 'April';
    } elseif ($bln == '05') {
        $bln = 'Mei';
    } elseif ($bln == '06') {
        $bln = 'Juni';
    } elseif ($bln == '07') {
        $bln = 'Juli';
    } elseif ($bln == '08') {
        $bln = 'Agustus';
    } elseif ($bln == '09') {
        $bln = 'September';
    } elseif ($bln == '10') {
        $bln = 'Oktober';
    } elseif ($bln == '11') {
        $bln = 'November';
    } elseif ($bln == '12') {
        $bln = 'Desember';
    }
    return $bln;
}

?>

</html>
