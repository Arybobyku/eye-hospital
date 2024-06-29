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
            <tr style="border: 1px solid black; width:100%;">
                <b>PEMERIKSAAN FISIK</b>
        </table>
        </tr>
        </table>
    </div>
</body>

</html>
