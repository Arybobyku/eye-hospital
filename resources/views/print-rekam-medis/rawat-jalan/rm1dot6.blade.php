<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM1.6</title>
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
    <div style="position:fixed; right: 13px; bottom: 10px;">
    </div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <?php $eyero = storage_path('app/public/images/EYE-RO.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 1.6/RPPRJ/22
        </div>

        @include('print-rekam-medis.partials.header')
        {{-- table content --}}
        <h3 style="text-align: center">RESUME PERAWATAN PASIEN RAWAT JALAN</h3>
        <table class="tablee" style="width:100%; position:relative">
            <tr class="tablee">
                <th class="tablee">Tanggal kunjungan</th>
                <th class="tablee">Poli</th>
                <th class="tablee">Diagnosa</th>
                <th class="tablee">Terapi/Tindakan</th>
                <th class="tablee">Dokter</th>
            </tr>
            @foreach ($ro as $dataRo)
            <tr class="tablee" style="padding: 5px">
                <td class="tablee"> <br> <b> @php
                    list($date, $time) = explode(' ', $dataRo->created_at);
                    $timeWithoutMilliseconds = explode('.', $time)[0];
                @endphp {{ $date }}/<br>{{ $timeWithoutMilliseconds }}</b> </td>
                <td class="tablee"> <br> <b></b> </td>
                <td class="tablee"> <br> {{ $dataRo->keluhan_utama }}</td>
                <td class="tablee"> <br> </td>
                <td class="tablee"> <br> {{ $dataRo->nama_dokter }}</td>
            </tr>
            @endforeach
            {{-- <tr class="tablee" style="padding: 5px">
                <td class="tablee"> <br> </td>
                <td class="tablee"> <br> </td>
                <td class="tablee"> <br> </td>
                <td class="tablee"> <br> </td>
                <td class="tablee"> <br> </td>
            </tr> --}}

        </table>
    </div>
</body>

</html>