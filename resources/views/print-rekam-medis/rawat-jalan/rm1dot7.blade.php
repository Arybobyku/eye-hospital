<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM1.7/RMRJ/22</title>
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

        .page_break {
            page-break-before: always;
        }
    </style>

</head>

<body>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <?php $eyero = storage_path('app/public/images/EYE-RO.png'); ?>
    @foreach ($ro as $dataRo)
        <div class="wrap">
            <div style="width:100%; text-align:right; margin-bottom:5px">
                RM 1.7/RMRJ/22
            </div>
            @include('print-rekam-medis.partials.header')
            <table style="width: 100%; text-align: left;" cellpadding="0" cellspacing="0">
                <thead>
                    <th align="center" colspan="2" style="border-left:1px solid; border-right:1px solid;border-bottom:1px solid; padding: 5px">RESUME MEDIS RAWAT
                        JALAN</th>
                </thead>
                <tbody>
                    <tr>
                        <td align="left" valign="top"
                            style="border: 1px solid black; padding: 5px; width: 40%; height: 75px;">Annamnese</td>
                        <td align="left" style="border: 1px solid black; padding: 5px; width: 40%; height: 75px">
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top"
                            style="border: 1px solid black; padding: 5px; width: 40%; height: 50px;">Pemeriksaan Fisik
                        </td>
                        <td align="left" style="border: 1px solid; padding: 5px; width: 40%; height: 50px">
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top"
                            style="border: 1px solid ; padding: 5px; width: 40%; height: 35px;">Alergi Obat</td>
                        <td align="left" style="border: 1px solid; padding: 5px; width: 40%; height: 35px">
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top"
                            style="border: 1px solid; padding: 5px; width: 40%; height: 50px;">Hasil Penunjang
                            Medis Laboratorium/Radiologi/Dll</td>
                        <td align="left" style="border: 1px solid; padding: 5px; width: 40%; height: 50px">
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top"
                            style="border: 1px solid; padding: 5px; width: 40%; height: 75px;">Diagnosa
                        </td>
                        <td align="left" style="border: 1px solid; padding: 5px; width: 40%; height: 75px">
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top"
                            style="border: 1px solid; padding: 5px; width: 40%; height: 75px;">Tindakan
                        </td>
                        <td align="left" style="border: 1px solid; padding: 5px; width: 40%; height: 75px">
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top"
                            style="border: 1px solid; padding: 5px; width: 40%; height: 75px;">Terapi
                        </td>
                        <td align="left" style="border: 1px solid; padding: 5px; width: 40%; height: 75px">
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top"
                            style="border: 1px solid; padding: 5px; width: 40%; height: 35px;">Instruksi/Anjuran
                            dan Edukasi</td>
                        <td align="left" style="border: 1px solid ; padding: 5px; width: 40%; height: 35px">
                        </td>
                    </tr>
                    <tr>
                        <td align="left" style="border: 1px solid; padding: 5px; width: 40%; height: 25px;">
                            Kontrol pada tanggal</td>
                        <td align="left" style="border: 1px solid; padding: 5px; width: 40%; height: 25px">Di
                        </td>
                    </tr>
                </tbody>

            </table>
            <br />
            <br />
            <table style="width: 100%; text-align: center">
                <tr>
                    <td>Tanggal, {{ $dataRo->tanggal }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Dokter Yang Memeriksa</td>
                </tr>
                <tr>
                    <td style="width: 100%; height: 60px"></td>
                </tr>
                <tr>
                    <td> {{ $dataRo->nama_dokter }}</td>
                </tr>
            </table>
        </div>
        @if ($loop->index < count($ro) - 1)
            <div class="page_break"></div>
        @endif
    @endforeach
</body>

</html>
