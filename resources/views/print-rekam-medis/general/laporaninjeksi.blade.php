<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Form Laporan Injeksi Anti VECF</title>
    <style>
        @page {
            margin: 18px;
        }

        body {
            margin: 18px;
            font-family: Arial, sans-serif;
        }

        .wrap {
            width: 100%;
            height: auto;
            display: inline-block;
        }

        .fontsmall {
            font-size: 10px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        .table-border {
            border: 1px solid black;
        }

        .table-border td {
            border: 1px solid black;
            padding: 5px;
        }

        .checkbox-inline {
            display: inline-block;
            margin-right: 15px;
        }

        .signature-section {
            margin-top: 30px;
            text-align: right;
        }

        .signature-box {
            display: inline-block;
            text-align: center;
            margin-top: 10px;
        }

        .prosedur-list {
            margin: 20px 0;
            line-height: 1.8;
        }
    </style>
</head>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;"></div>
    
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <?php $patimg = storage_path('app/public/images/PAT.png'); ?>
    
    <div class="wrap">
        <!-- Nomor RM -->
        <div style="width:100%; text-align:right; margin-bottom:5px; font-size: 10pt;">
            {{ $injeksi->no_surat ?? 'RM 8.8/LIAV/' . config('app.tahun_akreditasi', '22') }}
        </div>

        <!-- Header -->
        @include('print-rekam-medis.partials.header')

        <!-- Judul -->
        <div style="font-weight: bold; text-align:center; margin-top:10px; font-size: 14pt;"> 
            <u>LAPORAN INJEKSI ANTI VECF</u> 
        </div>
        <br>

        <!-- Tanggal Operasi -->
        <div style="margin-top: 5px; text-align: right; font-size: 11pt;">
            <span>Tanggal Operasi: <strong>{{ $injeksi->tanggal_operasi ? \Carbon\Carbon::parse($injeksi->tanggal_operasi)->format('d-m-Y') : '_________________' }}</strong></span>
        </div>
        <br>

        <!-- Tabel Informasi Operasi -->
        <table class="table-border" style="margin-top:10px; font-size: 10pt;">
            <!-- Baris 1: Mata, Operator, Jam, Lama -->
            <tr>
                <td style="width: 20%;">
                    <table style="width: 100%; border-collapse: collapse; border: none;">
                        <tr>
                            <td style="white-space: nowrap; border: none;">
                                Mata:
                            </td>
                            <td style="white-space: nowrap; border: none;">
                                OD
                            </td>
                            <td style="border: none;">
                                <input type="checkbox" {{ $injeksi->mata_od ? 'checked' : '' }} disabled>
                            </td>
                            <td style="white-space: nowrap; border: none;">
                                OS
                            </td>
                            <td style="border: none;">
                                <input type="checkbox" {{ $injeksi->mata_os ? 'checked' : '' }} disabled>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width: 25%;">
                    <strong>Operator:</strong> {{ $injeksi->operator ?? '' }}
                </td>
                <td style="width: 25%;">
                    <strong>Jam Operasi:</strong>
                    {{ $injeksi->jam_operasi ? \Carbon\Carbon::parse($injeksi->jam_operasi)->format('H:i') : '' }}
                </td>

                <td style="width: 30%;">
                    <strong>Lama Operasi:</strong> {{ $injeksi->lama_operasi ?? '' }}
                </td>
            </tr>

            <!-- Baris 2: Diagnosa, Asisten -->
            <tr>
                <td colspan="2">
                    <strong>Diagnosis:</strong> {{ $injeksi->diagnosis ?? '' }}
                </td>
                <td colspan="2">
                    <strong>Asisten:</strong> {{ $injeksi->asisten ?? '' }}
                </td>
            </tr>

            <!-- Baris 3: Jenis Operasi, Anesthesia, Anesthesiologist -->
            <tr>
                <td colspan="1">
                    <strong>Jenis Operasi:</strong> {{ $injeksi->jenis_operasi ?? '' }}
                </td>
                <td colspan="1">
                    <strong>Anesthesia:</strong> {{ $injeksi->anesthesia ?? '' }}
                </td>
                <td colspan="2">
                    <strong>Anesthesiologist:</strong> {{ $injeksi->anesthesiologist ?? '' }}
                </td>
            </tr>
        </table>

        <!-- Prosedur Operasi -->
        <div class="prosedur-list" style="font-size: 11pt;">
            <ol style="line-height: 2;">
                <li>
                    Pasien berbaring dalam anestesi 
                    <strong>
                        @if($injeksi->jenis_anestesi == 'topical') topical
                        @elseif($injeksi->jenis_anestesi == 'local') local
                        @elseif($injeksi->jenis_anestesi == 'umum') umum
                        @else topical / local / umum
                        @endif
                    </strong>
                </li>

                <li>Dilakukan tindakan & antiseptis menggunakan providone iodin</li>

                <li>Dipasangkan eye drape</li>

                <li>Dipasangkan blefarostat</li>

                <li>
                    Dilakukan pengukuran menggunakan 
                    <strong>
                        @if($injeksi->alat_ukur == 'caliper') caliper
                        @elseif($injeksi->alat_ukur == 'trocar') trocar
                        @else caliper / trocar
                        @endif
                    </strong>
                    dengan jarak 
                    <strong>
                        @if($injeksi->jarak_ukur == '3.5') 3,5 mm
                        @elseif($injeksi->jarak_ukur == '4') 4 mm
                        @else 3,5 / 4 mm
                        @endif
                    </strong>
                    dari limbus
                    <br>
                    <span style="margin-left: 20px;">
                        Di kuadran 
                        <strong>
                            @if($injeksi->kuadran == 'superior') superior
                            @elseif($injeksi->kuadran == 'temporal') temporal
                            @else superior / temporal
                            @endif
                        </strong>
                    </span>
                </li>

                <li>
                    Dilakukan injeksi 
                    <strong>
                        @if($injeksi->jenis_injeksi == 'avastin') avastin
                        @elseif($injeksi->jenis_injeksi == 'intravitreal') intravitreal
                        @else avastin / intravitreal
                        @endif
                    </strong>
                    sebanyak <strong>{{ $injeksi->jumlah_injeksi ?? '.........' }}</strong> ml
                </li>

                <li>Diteteskan antibiotik</li>

                <li>Mata ditutup kassa & dop</li>

                <li>Tindakan selesai</li>
            </ol>
        </div>

        <!-- Tanda Tangan -->
        <div class="signature-section">
            <div style="display: inline-block; text-align: center;">
                <div style="margin-bottom: 5px; font-size: 11pt;">
                    <strong>Tanda Tangan DPJP / Dokter</strong>
                </div>
                
                @if($injeksi->ttd_dokter)
                    <div style="margin: 10px 0;">
                        <img src="{{ $injeksi->ttd_dokter }}" alt="TTD Dokter" style="max-width: 200px; max-height: 100px;">
                    </div>
                @else
                    <div style="height: 80px; margin: 10px 0;"></div>
                @endif

                <div style="font-size: 11pt;">
                    ( <u><strong>{{ $injeksi->nama_dokter ?? '................................' }}</strong></u> )
                </div>
            </div>
        </div>

        <br><br>

    </div>
</body>

</html>