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

        .tablee {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .page_break {
            page-break-before: always;
        }

        .table tr td {
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
            {{ $data->no_surat ?? 'RM 2.10/CPPTRI/' . config('app.tahun_akreditasi', '22') }}
        </div>
        @include('print-rekam-medis.partials.header')
        <h3 style="text-align: center">CATATAN PERKEMBANGAN PASIEN TERINTEGERASI RAWAT INAP</h3>
        <table class="tablee" style="width:100%; position:relative">
            <tr class="tablee">
                <th class="tablee" style="width:5%; text-align:center;">Tanggal <br>/Jam</th>
                <th class="tablee" style="width:5%; text-align:center;">Profesi Pemberi Asuhan</th>
                <th class="tablee" style="width:35%;">
                    Hasil Asesmen Pasien dan Pemberian Pelayanan <br>
                    <span style="font-weight: normal !important; font-family: inherit;">
                        (Tuliskan dengan format SOAP/ADIME, disertai sasaran, Tulis nama, beri paraf pada akhir catatan)
                    </span>
                </th>
                <th class="tablee" style="width:45%;">
                    Instruksi PPA Termasuk Pasca Bedah <br>
                    <span style="font-weight: normal !important; font-family: inherit;">
                        (Tuliskan dengan format SOAP/ADIME, disertai sasaran, Tulis nama, beri paraf pada akhir catatan)
                    </span>
                </th>
                <th class="tablee" style="width:10%;">
                    Review & Verifikasi DPJP <br>
                    <span style="font-weight: normal !important; font-family: inherit;">
                        (Tulis nama, beri paraf, tgl, jam)
                    </span>
                </th>
            </tr>
        
            @foreach ($data['cppt_rows'] as $row)
            <tr>
                {{-- Tanggal / Jam --}}
                <td class="tablee">
                    {{ !empty($row['tanggal']) ? \Carbon\Carbon::parse($row['tanggal'])->format('d/m/Y') : '' }}
                    <br>
                    {{ $row['jam'] ?? '' }}
                </td>
            
                {{-- Profesi --}}
                <td class="tablee">
                    {{ $row['profesi'] ?? '' }}
                </td>
            
                {{-- Hasil Asesmen --}}
                <td class="tablee">
                    {!! nl2br(e($row['hasil_asesmen'] ?? '')) !!}
                </td>
            
                {{-- Instruksi PPA --}}
                <td class="tablee">
                    {!! nl2br(e($row['instruksi_ppa'] ?? '')) !!}
            
                    @if(!empty($row['nama_ppa']))
                        <br><br>
                        <strong>Nama PPA:</strong> {{ $row['nama_ppa'] }}
                    @endif
            
                    @if(!empty($row['ttd_ppa']))
                        <br><br>
                        <img
                            src="{{ $row['ttd_ppa'] }}"
                            style="width:120px; height:auto;"
                            alt="TTD PPA">
                    @endif
                </td>
            
                {{-- Review DPJP --}}
                <td class="tablee" style="text-align:center;">
                    @if(!empty($row['ttd_dpjp']))
                        <img
                            src="{{ $row['ttd_dpjp'] }}"
                            style="width:120px; height:auto;"
                            alt="TTD DPJP">
                        <br>
                    @endif
            
                    <strong>{{ $row['nama_dpjp'] ?? '' }}</strong>
                    <br>
            
                    @if(!empty($row['tanggal_review']))
                        {{ \Carbon\Carbon::parse($row['tanggal_review'])->format('d/m/Y') }}
                    @endif
                    {{ $row['jam_review'] ?? '' }}
                </td>
            </tr>
            @endforeach
            
            
        </table>
        
    </div>
</body>

</html>
