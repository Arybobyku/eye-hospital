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
        }
    </style>

</head>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;">
    </div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 10.4/LE/22
        </div>
        @include('print-rekam-medis.partials.header')
        <br />

        <br>

        <div style="font-weight: bold; text-align:center">
            FORM TINDAKAN EPILASI
        </div>
        <br>
        <div class="">
            <span class="right"> Tanggal:
                {{ \Carbon\Carbon::parse($data->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }} </span>
        </div>

        <br>

        <table style="width: 100%;" cellpadding="0" cellspacing="0">
            <tr>
                <td style="width: 100%; font-size: 12pt; line-height: 22px;   text-align: justify">Diagnosa:
                    {{ $data->diagnosa }}
                    <br>

                    <table class="tablee">
                        <tr>
                            <td>Mata :</td>
                            <td>OD</td>
                            <td>
                                <input type="checkbox" {{ $data->mata_od ? 'checked' : '' }}>
                            </td>
                            <td>OS</td>
                            <td>
                                <input type="checkbox" {{ $data->mata_os ? 'checked' : '' }}>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <br>

            <tr>
                <td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 5px; text-align: justify">
                    Langkah-langkah Tindakan Laser Fokal :
                    <br>
                </td>
                <br>
                <br>
                <br>
            </tr>
            <tr>
                <td style="width: 100%; font-size: 12pt; line-height: 22px; padding-top: 5px">
                    1.Dilakukan tetes Pantocain pada mata <br>
                    2.Evaluasi Triakisis <br>
                    3.Epilasi Triakisis <br>
                    4.Tetes mata antibiotic pada mata <br>
                    5.Tindakan selesai <br>
                    <br>
                    <br>
                    <br>
                    <br>

                    <div class="right">Tanda Tangan DPJP
                        <br>
                        <img src="{{ $data->ttd_dpjp }}" alt="Base64 Image" width="200px">
                        <br>
                        <br>
                        ({{ $data->nama_dpjp }})
                        <br>
                        <br>
                    </div>

            </tr>

        </table>
    </div>
</body>

</html>
