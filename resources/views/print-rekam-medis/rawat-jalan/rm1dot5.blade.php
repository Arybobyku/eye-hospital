<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM1.5</title>
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
            border:1px solid black;
            border-collapse: collapse;
        }
        .page_break{
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
            RM 1.5/CPPT/22
        </div>
        @include('print-rekam-medis.partials.header')
        {{-- table content --}}
        <h3 style="text-align: center">CATATAN PERKEMBANGAN PASIEN TERINTEGERASI RAWAT JALAN</h3>
        <table class="tablee" style="width:100%; position:relative">
            <tr class="tablee">
                <th class="tablee">Tanggal/Jam</th>
                <th class="tablee">Profesionnal Pemberi Asuhan (PPA)</th>
                <th class="tablee">Hasil Asesmen Pasien dan Pemberian Pelayanan (SOAP)</th>
                <th class="tablee">Instruksi PPA Termasuk Pasca Bedah</th>
                <th class="tablee">Review & Verifikasi DPJP (Paraf)</th>
            </tr>
            @foreach ($ro as $dataRo)
                
            
            <tr class="tablee" style="padding: 5px"> 
                <td class="tablee" style="padding: 5px"><b> @php
                    list($date, $time) = explode(' ', $dataRo->created_at);
                    $timeWithoutMilliseconds = explode('.', $time)[0];
                @endphp {{ $date }}/<br>{{ $timeWithoutMilliseconds }}</b> </td>
                <td class="tablee" style="padding: 5px"> <b>{{ $dataRo->nama_dokter }}</b> </td>
                <td class="tablee"> 
                    <table style="padding: 5px">
                        <tr>
                            <td> Subject : <br></td>
                        </tr> 
                        <br><br>
                        <tr>
                            <td> Object :</td>
                        </tr> 
                        <br><br>
                        <tr>
                            <td> Assassment :</td>
                        </tr> 
                        <br><br>
                        <tr>
                            <td> Plan :</td>
                        </tr>
                        <br><br> 
                    </table>
                 </td>
                 <td class="tablee"> <br> </td>
                 <td class="tablee"> <br> </td>
            </tr>
            @endforeach
           

        </table>
    </div>
</body>

</html>