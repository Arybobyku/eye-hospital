<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM8.8</title>
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

        .tablee8dot8 {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .td18dot8 {
            border: 1px solid black;
            border-collapse: collapse;
            width: 25%;
            padding-left: 5px;
            padding-right: 5px;
        }

        .td28dot8 {
            width: 7%;
            padding-left: 5px;
            padding-right: 5px;
        }

        .td38dot8 {
            width: 3%;
            padding-left: -10px;
            padding-right: -10px;
        }

        .steps8dot8 {
            margin-left: -50px;
        }
    </style>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;"></div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 8.8/LIAV/22
        </div>
        @include('print-rekam-medis.partials.header')
    </div>
    <div>
        <H4 style="text-align: center;"> <u>LAPORAN INJEKSI ANTI VEGA </u></H4>
        @if ($tindakan2 != null && $tindakan2->namatindakan == 'Injeksi Antivega')
            
        
        <table class="tablee8dot10" style="width: 100%;">
            <p style="text-align: right; padding-bottom: 4%;"> Tgl. Operasi
                :{{ $tindakan2->tanggal }}</p>
            <table class="tablee8dot10" style="width: 100%; padding-left: 10px; padding-right: 10px;">
                <tr>
                    <td class="td28dot10">
                        Mata :
                    </td>
                    <td class="td38dot10">OD</td>
                    <td class="td38dot10"><input type="checkbox" {{ $tindakan2->od == 'Ya' ? 'Checked' : ''}}></td>
                    <td class="td38dot10">OS</td>
                    <td class="td38dot10"><input type="checkbox" {{ $tindakan2->os == 'Ya' ? 'Checked' : ''}}></td>
                    <td class="td18dot10">
                        Operator : {{ $tindakan2->nama_operator }}
                    </td>
                    <td class="td18dot10">
                        Jam operasi : {{ $tindakan2->jam_operasi }}
                    </td>
                    <td class="td18dot10">
                        Lama Operasi : {{ $tindakan2->lama_operasi }}
                    </td>
                </tr>
                <tr>
                    <td class="td18dot10" colspan="6">
                        Diagnosis : {{ $tindakan2->diagnosis}}
                    </td>
                    <td class="td18dot10" colspan="2">
                        Asisten: {{ $tindakan2->asisten }}
                    </td>
                </tr>
                <tr>
                    <td class="td18dot10" colspan="5">
                        Jenis Operasi : {{ $tindakan2->jenis_operasi }}
                    </td>
                    <td class="td18dot10" colspan="2">
                        Anesteshia : {{ $tindakan2->anesthesia }}
                    </td>
                    <td class="td18dot10">
                        Anesthesiologist : {{ $tindakan2->anesthesiologist }}
                    </td>
                </tr>
            </table>
            <table>
                <ol>
                    <ol class="steps8dot8" style="padding-top: 3%;">
                        <li style="Margin-bottom: 10px">Pasien berbaring dalam anestesi topical/ local/ umum.</li>
                        <li style="Margin-bottom: 10px">Dilakukan tindakan a & antiseptis menggunakan providone iodin.</li>
                        <li style="Margin-bottom: 10px">Dipasangkan eye drape.</li>
                        <li style="Margin-bottom: 10px">Dipasangkan blefarostat.</li>
                        <li style="Margin-bottom: 10px">Dilakukan pengukuran menggunakan caliper/trocar dengan jarak 3,5/4mm dari limbus di kuadran superior/temporal.</li>
                        <li style="Margin-bottom: 10px">Dilakukan injeksi avasin / intravitreal sebanyak ........... ml.</li>
                        <li style="Margin-bottom: 10px">Diteteskan antibiotik.</li>
                        <li style="Margin-bottom: 10px">Mata ditutup kasa & dop.</li>
                        <li style="Margin-bottom: 10px">tindakan selesai</li>
                    </ol>
            </table>
            <table style="width: 100%; text-align:right;  padding-top: 1%; padding-bottom: 3%; padding-right: 10%">
                <tr>
                    <td> Tanda Tangan DPJP/Dokter</td>
                </tr> <br><br><br>
                <tr>
                    <td> (.........................................)</td>
                </tr>
            </table>
            @endif
    </div>