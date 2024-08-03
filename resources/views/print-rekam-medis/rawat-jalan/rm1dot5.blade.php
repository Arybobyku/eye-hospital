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
            border: 1px solid black;
            border-collapse: collapse;
        }

        .page_break {
            page-break-before: always;
        }

        .table tr td{
            border: 1px solid #767676;
            border-collapse: collapse;
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
            @foreach ($cppt as $itemcppt)
                <tr class="tablee" style="padding: 5px">
                    <td class="tablee" style="padding: 5px"><b> @php
                        [$date, $time] = explode(' ', $itemcppt->created_at);
                        $timeWithoutMilliseconds = explode('.', $time)[0];
                    @endphp
                            {{ $date }}/<br>{{ $timeWithoutMilliseconds }}</b> </td>
                    <td class="tablee" style="padding: 5px"> <b></b> </td>
                    <td class="tablee">
                        <table style="padding: 5px">
                            <tr>
                                <td><b> Subject : </b><br>
                                    {!! $itemcppt->subjek !!} </td>
                            </tr>

                            <tr>
                                <td> <b>Object : </b>
                                    <br>
                                    {!! $itemcppt->objek !!}
                                </td>
                            </tr>

                            <tr>
                                <td> <b>Assassment : </b>
                                    <br>
                                    {!! $itemcppt->asesmen !!}
                                </td>
                            </tr>

                            <tr>
                                <td><b> Plan : </b>
                                    <br>
                                    {!! $itemcppt->plan !!}
                                </td>
                            </tr>

                        </table>
                    </td>
                    <td class="tablee"> <br>
                    </td>
                    <td class="tablee"> <br>
                        <img src="{{ $itemcppt->ttd }}" alt="Base64 Image" width="100%">
                    </td>
                </tr>
            @endforeach


        </table>
    </div>
</body>

</html>
