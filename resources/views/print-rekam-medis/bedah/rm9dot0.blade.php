<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM9.0</title>
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

        .tablee9dot0 {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .td19dot0 {
            border: 1px solid black;
            border-collapse: collapse;
            width: 25%;
            padding-left: 5px;
            padding-right: 5px;
        }

        .td29dot0 {
            width: 7%;
            padding-left: 5px;
            padding-right: 5px;
        }

        .td39dot0 {
            width: 3%;
            padding-left: -10px;
            padding-right: -10px;
        }

        .steps9dot0 {
            margin-left: -30px;
        }
    </style>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;"></div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 9.0/LOP/22
        </div>
        @include('print-rekam-medis.partials.header')
    </div>
    <div>
        <H4 style="text-align: center;">LAPORAN OPERASI PTERYGIUM</H4>
        @if ($tindakan5 != null && $tindakan5->namatindakan == 'Laporan Operasi Pterygium')
            
        <table class="tablee8dot10" style="width: 100%;">
            <p style="text-align: right; padding-bottom: 4%;"> Tgl. Operasi
                :{{ $tindakan5->tanggal }}</p>
            <table class="tablee8dot10" style="width: 100%; padding-left: 10px; padding-right: 10px;">
                <tr>
                    <td class="td28dot10">
                        Mata :
                    </td>
                    <td class="td38dot10">OD</td>
                    <td class="td38dot10"><input type="checkbox" {{ $tindakan5->od == 'Ya' ? 'Checked' : ''}}></td>
                    <td class="td38dot10">OS</td>
                    <td class="td38dot10"><input type="checkbox" {{ $tindakan5->os == 'Ya' ? 'Checked' : ''}}></td>
                    <td class="td18dot10">
                        Operator : {{ $tindakan5->nama_operator }}
                    </td>
                    <td class="td18dot10">
                        Jam operasi : {{ $tindakan5->jam_operasi }}
                    </td>
                    <td class="td18dot10">
                        Lama Operasi : {{ $tindakan5->lama_operasi }}
                    </td>
                </tr>
                <tr>
                    <td class="td18dot10" colspan="6">
                        Diagnosis : {{ $tindakan5->diagnosis}}
                    </td>
                    <td class="td18dot10" colspan="2">
                        Asisten: {{ $tindakan5->asisten }}
                    </td>
                </tr>
                <tr>
                    <td class="td18dot10" colspan="5">
                        Jenis Operasi : {{ $tindakan5->jenis_operasi }}
                    </td>
                    <td class="td18dot10" colspan="2">
                        Anesteshia : {{ $tindakan5->anesthesia }}
                    </td>
                    <td class="td18dot10">
                        Anesthesiologist : {{ $tindakan5->anesthesiologist }}
                    </td>
                </tr>
            </table>
            <table>
                <ol>
                    <ol class="steps9dot0" style="padding-top: 3%;">
                        <li style="Margin-bottom: 10px">Pasien dalam posisi SUPINE di tempat tidur dan Anastesi Parabulper.</li>
                        <li style="Margin-bottom: 10px">Teknik A & Antiseptic.</li>
                        <li style="Margin-bottom: 10px">Tutup duklubang steril.</li>
                        <li style="Margin-bottom: 10px">Pasang Blefarostat.</li>
                        <li style="Margin-bottom: 10px">Injeksi Lidocain pada caput dan corpus pterygium.</li>
                        <li style="Margin-bottom: 10px">Pisahkan dari epitrkornea hingga bersih.</li>
                        <li style="Margin-bottom: 10px">Atasi pendarahan.</li>
                        <li style="Margin-bottom: 10px">Gunting corpus pterygium.</li>
                        <li style="Margin-bottom: 10px">Buat graft dari Konjungtiva bagian sup or</li>
                        <li style="Margin-bottom: 10px">Geser ke medial, jahit tepinya</li>
                        <li style="Margin-bottom: 10px">Salp</li>
                        <li style="Margin-bottom: 10px">Operasi selesai</li>
                    </ol>
            </table>
            <table style="width: 100%; text-align:center;  padding-top: 1%; padding-bottom: 3%; padding-right: 10%">
                <tr>
                    <td>Perawat</td>
                    <td> Operator</td>
                </tr> <br><br><br>
                <tr>
                    <td>( {{ $tindakan5->asisten }} )</td>
                    <td> ( {{ $tindakan5->nama_operator }} )</td>
                </tr>
            </table>
        </table>
        @endif
    </div>