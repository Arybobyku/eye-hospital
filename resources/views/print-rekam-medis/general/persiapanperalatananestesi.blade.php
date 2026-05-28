<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>PERSIAPAN PERALATAN ANESTESI</title>
    <style>
        @page { margin: 18px 20px 60px 20px; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            font-size: 9.5pt;
            color: #000;
        }

        .wrap { width: 100%; }

        .no-surat {
            text-align: right;
            font-size: 9.5pt;
            margin-bottom: 4px;
        }

        .patient-info {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }

        .patient-info td {
            font-size: 9.5pt;
            padding: 1px 4px;
            vertical-align: top;
        }

        .judul {
            text-align: center;
            font-weight: bold;
            font-size: 12pt;
            margin: 8px 0 10px 0;
            text-decoration: underline;
        }

        .form-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }

        .form-table td {
            font-size: 9.5pt;
            padding: 2px 5px;
            vertical-align: top;
        }

        .label-col { width: 150px; }
        .colon-col { width: 10px; }

        .section-title {
            font-weight: bold;
            font-size: 9.5pt;
            padding: 3px 8px;
            background: #f0f0f0;
            margin: 0;
        }

        .checklist-table {
            width: 100%;
            border-collapse: collapse;
        }

        .checklist-table td {
            font-size: 9.5pt;
            padding: 2px 6px;
            vertical-align: middle;
        }

        .cb-col { width: 22px; text-align: center; }

        .sign-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .sign-table td {
            text-align: center;
            vertical-align: top;
            padding: 5px 10px;
            font-size: 9.5pt;
        }

        .ttd-img {
            max-width: 120px;
            max-height: 60px;
            display: block;
            margin: 0 auto 2px auto;
        }

        .ttd-nama {
            display: inline-block;
            border-top: 1px solid #000;
            min-width: 150px;
            text-align: center;
            padding-top: 3px;
        }
    </style>
</head>
<body>
<?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>

<div class="wrap">
    <div class="no-surat">{{ $data->no_surat ?? 'RM 5.1/PPA/' . config('app.tahun_akreditasi','22') }}</div>

    @include('print-rekam-medis.partials.header')
    <div style="border: 1px solid #000; padding: 6px 10px; margin-top: 4px;">

    <div class="judul">PERSIAPAN PERALATAN ANESTESI</div>

    {{-- Form fields --}}
    <table class="form-table">
        <tr>
            <td class="label-col">Ruangan</td>
            <td class="colon-col">:</td>
            <td>{{ $data->ruangan ?? '' }}</td>
        </tr>
        <tr>
            <td class="label-col">Tanggal / Jam Tindakan</td>
            <td class="colon-col">:</td>
            <td>
                {{ $data->tanggal_tindakan ? \Carbon\Carbon::parse($data->tanggal_tindakan)->locale('id')->isoFormat('D MMMM YYYY') : '' }}
                @if($data->jam_tindakan) / {{ $data->jam_tindakan }} @endif WIB
            </td>
        </tr>
        <tr>
            <td class="label-col">Jenis Operasi</td>
            <td class="colon-col">:</td>
            <td>{{ $data->jenis_operasi ?? '' }}</td>
        </tr>
        <tr>
            <td class="label-col">Teknik Anestesia</td>
            <td class="colon-col">:</td>
            <td>{{ $data->teknik_anestesia ?? '' }}</td>
        </tr>
    </table>

    <hr style="border:none; border-top:1px solid #ccc; margin:4px 0;">

    {{-- LISTRIK --}}
    <div class="section-title">Listrik</div>
    <table class="checklist-table">
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_mesin_anestesia ? 'checked' : '' }}></td>
            <td>Mesin anestesia terhubung dengan sumber listrik, indikator (+) menyala.</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_layar_pemantauan ? 'checked' : '' }}></td>
            <td>Layar pemantauan terhubung dengan sumber listrik, indikator (+).</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_defibrilator ? 'checked' : '' }}></td>
            <td>Defibrilator terhubung dengan sumber listrik, indikator (+).</td>
        </tr>
    </table>

    {{-- GAS MEDIS --}}
    <div class="section-title" style="margin-top:4px;">Gas Medis</div>
    <table class="checklist-table">
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_selang_oksigen ? 'checked' : '' }}></td>
            <td>Selang oksigen terhubung antara sumber gas dengan mesin anestesia.</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_flow_o2 ? 'checked' : '' }}></td>
            <td>Flow meter O<sub>2</sub> di mesin anestesia berfungsi, aliran gas keluar dari mesin dapat dirasakan.</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_compressed_air ? 'checked' : '' }}></td>
            <td>Compressed air terhubung antara sumber gas dengan mesin anestesia.</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_flow_air ? 'checked' : '' }}></td>
            <td>Flow meter "Air" di mesin anestesia berfungsi, aliran gas keluar mesin dapat dirasakan.</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_n2o ? 'checked' : '' }}></td>
            <td>N<sub>2</sub>O terhubung antara sumber gas dengan mesin anestesia.</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_flow_n2o ? 'checked' : '' }}></td>
            <td>Flow meter N<sub>2</sub>O di mesin anestesia berfungsi, aliran gas keluar mesin dapat dirasakan.</td>
        </tr>
    </table>

    {{-- MESIN ANESTESIA --}}
    <div class="section-title" style="margin-top:4px;">Mesin Anestesia</div>
    <table class="checklist-table">
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_power_on ? 'checked' : '' }}></td>
            <td>Power ON</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_self_calibration ? 'checked' : '' }}></td>
            <td>Self calibration : DONE</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_tidak_bocor ? 'checked' : '' }}></td>
            <td>Tidak ada kebocoran sirkuit nafas</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_zat_volatil ? 'checked' : '' }}></td>
            <td>Zat volatil terisi</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_absorber_co2 ? 'checked' : '' }}></td>
            <td>Absorber CO<sub>2</sub> dalam kondisi baik</td>
        </tr>
    </table>

    {{-- MANAJEMEN JALAN NAFAS --}}
    <div class="section-title" style="margin-top:4px;">Manajemen Jalan Nafas</div>
    <table class="checklist-table">
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_sungkup_muka ? 'checked' : '' }}></td>
            <td>Sungkup muka dalam ukuran yang benar.</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_oropharyngeal ? 'checked' : '' }}></td>
            <td>Oropharyngeal airway (guedel) dalam ukuran yang benar.</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_laringoskop_baterai ? 'checked' : '' }}></td>
            <td>Batang laringoskop berisi baterai.</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_bilah_laringoskop ? 'checked' : '' }}></td>
            <td>Bilah laringoskop dalam ukuran yang benar.</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_gagang_bilah ? 'checked' : '' }}></td>
            <td>Gagang dan bilah laringoskop berfungsi baik.</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_ett_lma ? 'checked' : '' }}></td>
            <td>ETT atau LMA dalam ukuran yang benar, tidak bocor.</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_stilet ? 'checked' : '' }}></td>
            <td>Stilet (introduser)</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_semprit_cuff ? 'checked' : '' }}></td>
            <td>Semprit untuk mengembangkan cuff.</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_forceps_magill ? 'checked' : '' }}></td>
            <td>Forceps Magill</td>
        </tr>
    </table>
    <br>

    {{-- PEMANTAUAN --}}
    <div class="section-title" style="margin-top:4px;">Pemantauan</div>
    <table class="checklist-table">
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_kabel_ekg ? 'checked' : '' }}></td>
            <td>Kabel EKG terhubung dengan layar pemantau.</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_elektroda_ekg ? 'checked' : '' }}></td>
            <td>Elektroda EKG dalam jumlah dan ukuran sesuai.</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_nibp ? 'checked' : '' }}></td>
            <td>NIBP terhubung dengan layar pantau, ukuran manset sesuai.</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_spo2 ? 'checked' : '' }}></td>
            <td>SpO<sub>2</sub> terhubung dengan layar pantau, berfungsi baik.</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_kapnografi ? 'checked' : '' }}></td>
            <td>Kapnografi terhubung dengan layar pantau, berfungsi baik.</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_pemantau_suhu ? 'checked' : '' }}></td>
            <td>Pemantau suhu terhubung dengan layar pantau.</td>
        </tr>
    </table>

    {{-- LAIN-LAIN --}}
    <div class="section-title">Lain-lain</div>
    <table class="checklist-table">
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_stetoskop ? 'checked' : '' }}></td>
            <td>Stetoskop tersedia.</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_suction ? 'checked' : '' }}></td>
            <td>Suction berfungsi baik.</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_selang_suction ? 'checked' : '' }}></td>
            <td>Selang suction terhubung, kateter suction dalam ukuran yang benar.</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_plester ? 'checked' : '' }}></td>
            <td>Plester untuk fiksasi.</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_blanket_roll ? 'checked' : '' }}></td>
            <td>Blanket roll / hemotherm / radiant heater terhubung sumber listrik, berfungsi baik.</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_blanket_alas ? 'checked' : '' }}></td>
            <td>Blanket roll dilapisi alas.</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_xylocaine ? 'checked' : '' }}></td>
            <td>Xylocaine 2% Jelly</td>
        </tr>
    </table>

    {{-- OBAT-OBAT --}}
    <div class="section-title" style="margin-top:4px;">Obat-obat</div>
    <table class="checklist-table">
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_epinefrin ? 'checked' : '' }}></td>
            <td>Epinefrin</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_atropin ? 'checked' : '' }}></td>
            <td>Atropin</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_sedatif ? 'checked' : '' }}></td>
            <td>Sedatif (midazolam / propofol / etomidat / ketamin / tiopental)</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_opiat ? 'checked' : '' }}></td>
            <td>Opiat / opioid</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_pelumpuh_otot ? 'checked' : '' }}></td>
            <td>Pelumpuh otot</td>
        </tr>
        <tr>
            <td class="cb-col"><input type="checkbox" {{ $data->check_antibiotika ? 'checked' : '' }}></td>
            <td>Antibiotika</td>
        </tr>
        @if($data->lain_lain_obat)
        <tr>
            <td class="cb-col"></td>
            <td>Lain-lain : {{ $data->lain_lain_obat }}</td>
        </tr>
        @endif
    </table>

    {{-- TANDA TANGAN --}}
    <table class="sign-table" style="margin-top:16px;">
        <tr>
            <td style="width:50%;">
                <div>Pemeriksa</div>
                @if($data->ttd_perawat_anestesi)
                    <img src="{{ $data->ttd_perawat_anestesi }}" class="ttd-img" alt="TTD Perawat">
                @else
                    <div style="height:50px;"></div>
                @endif
                <div><span class="ttd-nama">( {{ $data->nama_perawat_anestesi ?? '' }} )</span></div>
                <div style="font-size:8.5pt;">(Perawat Anestesi)</div>
            </td>
            <td style="width:50%;">
                <div>dr. Anestesi</div>
                @if($data->ttd_dr_anestesi)
                    <img src="{{ $data->ttd_dr_anestesi }}" class="ttd-img" alt="TTD Dokter">
                @else
                    <div style="height:50px;"></div>
                @endif
                <div><span class="ttd-nama">( {{ $data->nama_dr_anestesi ?? '' }} )</span></div>
            </td>
        </tr>
    </table>

    </div>{{-- end border --}}
</div>
</body>
</html>
