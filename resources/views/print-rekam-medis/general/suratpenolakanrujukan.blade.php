<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>REKAM MEDIS GENERAL - SURAT KONSUL</title>
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
            margin-right: 65px;
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


        .text-above {
            text-align: center;
            margin-bottom: 5px;
        }
    </style>

</head>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;">
    </div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            {{ $data->no_surat ?? 'RM 9.5/SPPR/' . config('app.tahun_akreditasi', '22') }}
        </div>
        @include('print-rekam-medis.partials.header')
        <br />

        <br>

        <div style="font-weight: bold; text-align:center">
            SURAT PERNYATAAN PENOLAKAN RUJUKAN
        </div>

        <table style="width: 100%; margin-top: 20px" cellpadding="0" cellspacing="0">
            <tr>
                <td> Saya yang bertanda tangan dibawah ini : <br>

                    <br>
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="width: 10%;">Nama</td>
                            <td style="width: 50%;">: {{ $data->pembuat_nama }}</td>
                        </tr>
                        <tr>
                            <td style="width: 10%;">NIK</td>
                            <td style="width: 50%;">: {{ $data->pembuat_nik }}</td>
                        </tr>
                        <tr>
                            <td style="width: 10%;">Alamat</td>
                            <td style="width: 50%;">: {{ $data->pembuat_alamat }}</td>
                        </tr>
                    </table>
                    <br>
                    Selaku keluarga / pendamping telah mendapatkan penjelasan tentang keadaan pasien oleh dokter,
                    menyatakan bahwa pasien :
                    <br>
                </td>
            </tr>
            <tr>
                <td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 5px">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="width: 10%;">Nama Pasien</td>
                            <td style="width: 50%;">: {{ $data->pasien_nama }}</td>
                        </tr>
                        <tr>
                            <td style="width: 10%;">NIK</td>
                            <td style="width: 50%;">: {{ $data->pasien_alamat }}</td>
                        </tr>
                        <tr>
                            <td style="width: 10%;">Alamat</td>
                            <td style="width: 50%;">: {{ $data->pasien_alamat }}</td>
                        </tr>
                    </table>
                    <br>

                    <div style="font-weight: bold; text-align:center">
                        SURAT PERNYATAAN PENOLAKAN RUJUKAN
                    </div>
                    <br>
                    Persetujuan ini diberikan dengan penuh kesadaran dengan kemungkinan terjadinya akibat sampingan dari
                    tindakan tersebut diluar dari tanggung jawab RSK Mata Prima Vision. <br>
                    <br>
                    Demikian surat persetujuan ini dibuat dengan rasa tanggung jawab dan tanpa paksaan.
                    <br>
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td colspan="2">
                                <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td style="text-align: right; padding-right: 35%; padding-top: 60px;">Medan,
                                          {{ \Carbon\Carbon::parse($data->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center; padding-bottom: 20px;">Mengetahui Dokter,<br> Pernyataan,
                                        </td>
                                        <td></td>
                                        <td style="text-align: center; padding-bottom: 20px;">Yang Membuat
                                        </td>
                                    </tr>
                                    <td style="text-align: center;">
                                        <img src="{{ $data->ttd_dokter }}" alt="Base64 Image"
                                            width="40%">
                                    </td>
                                    <td></td>
                                    <td style="text-align: center;">
                                        <img src="{{ $data->ttd_pembuat }}" alt="Base64 Image" width="40%">
                                    </td>

                                    <tr>
                                        <td style="text-align: center; padding-top: 20px;">
                                            ({{ $data->nama_dokter_ttd }})
                                        </td>
                                        <td style="text-align: center; padding-top: 20px;"></td>
                                        <td style="text-align: center; padding-top: 20px;">
                                            ({{ $data->pembuat_nama }})</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
            </tr>


        </table>
    </div>
</body>

</html>
