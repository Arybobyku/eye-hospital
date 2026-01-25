<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>REKAM MEDIS GENERAL - SURAT KONTROL ULANG</title>
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


        .left {
            display: inline-block;
            float: left;
        }

        .right {
            display: inline-block;
            float: right;
        }

        .img-wrapper {
            position: relative;
            display: inline-block;
            text-align: center;
        }

        .img-wrapper img {
            display: block;
            max-width: 100%;
            height: auto;
        }

        .line {
            display: inline-block;
            width: 95%;
            border-bottom: 2px dotted black;
            /* garis di bawah */
            vertical-align: middle;
            padding-top: 19px;
            /* tambah jarak antara teks dan garis */
        }

        .tablee {
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
            padding: 5px;
        }

        .text-above {
            text-align: center;
            margin-bottom: 5px;
        }
    </style>

</head>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;">
    </div>
    <?php $fullpath = storage_path('app/public/images/header_rme3.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 9.5/SRB/22
        </div>
        @include('print-rekam-medis.partials.header4')
        <table
            style="width: 100%;  border-right: 1px solid black; border-left: 1px solid black; border-bottom: 1px solid black;"
            cellpadding="0" cellspacing="0">
            <tr>
                <td style="width: 30%; padding-left: 20px; padding-top: 20px;">Nama Pasien</td>
                <td style="width: 70%; padding-top: 20px;">: {{ $data->nama_pasien }}</td>
            </tr>
            <tr>
                <td style="width: 30%; padding-left: 20px;">Tempat Tanggal Lahir</td>
                <td style="width: 70%;">: {{ $data->tempat_tanggal_lahir }}</td>
            </tr>
            <tr>
                <td style="width: 30%; padding-left: 20px;">No. RM</td>
                <td style="width: 70%;">: {{ $data->no_rm }}</td>
            </tr>
            <tr>
                <td style="width: 30%; padding-left: 20px; padding-top: 20px;">Diagnosa</td>
                <td style="width: 70%; padding-top: 20px;">: {{ $data->diagnosa }}</td>
            </tr>
            <tr>
                <td style="width: 30%; padding-left: 20px;">Tindak Lanjut Yang Dianjurkan</td>
                <td style="width: 70%;"><br></td>
            </tr>
            <tr>
                <td style="width: 30%; padding-left: 20px;">1.Pengobatan, dengan obat</td>
                <td style="width: 70%;">: {{ $data->pengobatan_dengan_obat }}</td>
            </tr>
            <tr>
                <td colspan="2" style="width: 100%;  padding-left: 20px; padding-top: 10px;">2. Kontrol lebih lanjut
                </td>
            </tr>
            <tr>
                <td colspan="2" style="width: 100%;  padding-left: 37px;">1) &nbsp; Kontrol ulang di Rumah Sakit
                    Khusus Mata Prima Vision Medan </td>
            </tr>
            <tr>
                <td style="width: 30%; padding-left: 60px;">Tanggal</td>
                <td style="width: 70%;">:
                    {{ \Carbon\Carbon::parse($data->tanggal_kontrol_rs)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
            </tr>
            <tr>
                <td colspan="2" style="width: 100%;  padding-left: 37px;">2) &nbsp; Kontrol di Fasilitas Kesehatan
                    Tingkat Pertama </td>
            </tr>
            <tr>
                <td colspan="2" style="width: 100%;  padding-left: 37px;">3) &nbsp; Sembuh </td>
            </tr>
            <tr>
                <td colspan="2" style="padding-top: 30px;">
                     <table style="border: 1px solid black; margin-left: auto; margin-right: 0; padding: 5px;" cellpadding="5" cellspacing="0">
                        <tr>
                            <td style="text-align: center; border-bottom: 1px solid black;">Medan,
                                {{ \Carbon\Carbon::parse($data->tanggal_surat)->locale('id')->isoFormat('D MMMM YYYY') }}
                            <td>
                        </tr>
                        <tr>
                            <td style="text-align: center; border-bottom: 1px solid black;">DPJP</td>
                        </tr>
                        <tr>
                            <td style="text-align: center; padding-top: 50px; width: 200px;">
                                <img src="{{ $data->ttd_dpjp }}" alt="Base64 Image" width="200px">
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">({{ $data->nama_dpjp }})</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
