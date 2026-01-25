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
            @php
            if (is_array($data->resume_rows)) {
                $resumeRows = $data->resume_rows;
            } else {
                $resumeRows = json_decode($data->resume_rows, true) ?? [];
            }
        @endphp
        
        
        @if(!empty($resumeRows))
            @foreach($resumeRows as $row)
                <tr class="tablee">
                    <td class="tablee">
                        {{ !empty($row['tanggal_kunjungan']) 
                            ? \Carbon\Carbon::parse($row['tanggal_kunjungan'])->format('d/m/Y') 
                            : '' }}
                    </td>
                    <td class="tablee">
                        {{ $row['poli'] ?? '' }}
                    </td>
                    <td class="tablee">
                        {{ $row['diagnosa'] ?? '' }}
                    </td>
                    <td class="tablee">
                        {{ $row['terapi_tindakan'] ?? '' }}
                    </td>
                    <td class="tablee">
                        {{ $row['dokter'] ?? '' }}
                    </td>
                </tr>
            @endforeach
        @else
            <tr class="tablee">
                <td class="tablee" colspan="5" style="text-align:center">
                    Tidak ada data kunjungan
                </td>
            </tr>
        @endif
        
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