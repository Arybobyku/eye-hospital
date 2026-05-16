<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>LAPORAN OPERASI</title>
    <style>
        @page {
            margin: 18px;
        }

        body {
            margin: 18px;
            font-family: Arial, sans-serif;
            font-size: 10pt;
        }

        .wrap {
            width: 100%;
            height: auto;
            display: inline-block;
        }

        .right {
            display: inline-block;
            float: right;
        }
    </style>
</head>

<body>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <div class="wrap">

        {{-- ── Nomor Surat ── --}}
        <div style="width:100%; text-align:right; margin-bottom:5px; font-size:10pt;">
            {{ $data->no_surat ?? 'RM 5.0/LO/' . config('app.tahun_akreditasi', '22') }}
        </div>

        {{-- ── Header RS + Identitas Pasien ── --}}
        @include('print-rekam-medis.partials.header')

        <br>

        {{-- ── LAPORAN OPERASI BOX ── --}}
        <table style="width:100%; border-collapse:collapse; border:1px solid black; font-size:10pt;">

            {{-- Title Row --}}
            <tr>
                <td colspan="4" style="text-align:center; font-weight:bold; font-size:13pt; padding:8px; border-bottom:1px solid black;">
                    LAPORAN OPERASI
                </td>
            </tr>

            {{-- Ahli bedah | Asisten dokter --}}
            <tr>
                <td style="padding:5px 8px; width:20%;">Ahli bedah</td>
                <td style="padding:5px 8px; width:30%; border-bottom:1px solid #999;">
                    {{ $data->ahli_bedah ?: '' }}
                </td>
                <td style="padding:5px 8px; width:20%;">Asisten dokter</td>
                <td style="padding:5px 8px; width:30%; border-bottom:1px solid #999;">
                    {{ $data->asisten_dokter ?: '' }}
                </td>
            </tr>

            {{-- Ahli anestesi | Instrumen --}}
            <tr>
                <td style="padding:5px 8px;">Ahli anestesi</td>
                <td style="padding:5px 8px; border-bottom:1px solid #999;">
                    {{ $data->ahli_anestesi ?: '' }}
                </td>
                <td style="padding:5px 8px;">Instrumen</td>
                <td style="padding:5px 8px; border-bottom:1px solid #999;">
                    {{ $data->instrumen ?: '' }}
                </td>
            </tr>

            {{-- Diagnosa prabedah | Pembedahan mulai/selesai --}}
            <tr>
                <td style="padding:5px 8px; border-top:1px solid black; vertical-align:top;">Diagnosa prabedah</td>
                <td style="padding:5px 8px; border-top:1px solid black; vertical-align:top;">
                    {{ $data->diagnosa_prabedah ?: '' }}
                </td>
                <td colspan="2" style="padding:5px 8px; border-top:1px solid black; vertical-align:top; line-height:22px;">
                    Pembedahan &nbsp; mulai pukul : {{ $data->pembedahan_mulai_pukul ?: '………………' }}<br>
                    Pembedahan selesai pukul : {{ $data->pembedahan_selesai_pukul ?: '………………' }}
                </td>
            </tr>

            {{-- Diagnosa pasca bedah | Lama Tindakan --}}
            <tr>
                <td style="padding:5px 8px; vertical-align:top;">Diagnosa pasca bedah</td>
                <td style="padding:5px 8px; vertical-align:top;">
                    {{ $data->diagnosa_pasca_bedah ?: '' }}
                </td>
                <td style="padding:5px 8px; vertical-align:top;">Lama Tindakan</td>
                <td style="padding:5px 8px; vertical-align:top;">
                    {{ $data->lama_tindakan ?: '………………' }}
                </td>
            </tr>

            {{-- Tanggal --}}
            <tr>
                <td style="padding:5px 8px; border-top:1px solid black;">Tanggal</td>
                <td colspan="3" style="padding:5px 8px; border-top:1px solid black;">
                    @if($data->tanggal)
                        {{ \Carbon\Carbon::parse($data->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}
                    @else
                        ………………………………
                    @endif
                </td>
            </tr>

            {{-- Jenis pembedahan | Macam pembedahan --}}
            <tr>
                <td style="padding:5px 8px; border-top:1px solid black;">Jenis pembedahan</td>
                <td style="padding:5px 8px; border-top:1px solid black;">
                    {{ $data->jenis_pembedahan ?: '………………………………' }}
                </td>
                <td style="padding:5px 8px; border-top:1px solid black;">Macam pembedahan</td>
                <td style="padding:5px 8px; border-top:1px solid black;">
                    {{ $data->macam_pembedahan ?: '………………………………' }}
                </td>
            </tr>

            {{-- Checkboxes Jenis / Tipe --}}
            <tr>
                <td colspan="4" style="padding:6px 8px; border-top:1px solid black; line-height:24px;">
                    <input type="checkbox" {{ $data->jenis_besar ? 'checked' : '' }}> Besar &nbsp;&nbsp;&nbsp;
                    <input type="checkbox" {{ $data->tipe_elektif ? 'checked' : '' }}> Elektif &nbsp;&nbsp;&nbsp;
                    <input type="checkbox" {{ $data->tipe_emergency ? 'checked' : '' }}> <em>Emergency</em>
                    <br>
                    <input type="checkbox" {{ $data->jenis_sedang ? 'checked' : '' }}> Sedang &nbsp;&nbsp;
                    <input type="checkbox" {{ $data->jenis_kecil ? 'checked' : '' }}> Kecil &nbsp;&nbsp;&nbsp;
                    <input type="checkbox" {{ $data->tipe_khusus ? 'checked' : '' }}> Khusus
                </td>
            </tr>

            {{-- Transfusi --}}
            <tr>
                <td colspan="4" style="padding:6px 8px; border-top:1px solid black;">
                    Transfusi &nbsp;&nbsp; :
                    &nbsp; <input type="checkbox" {{ $data->transfusi_tidak ? 'checked' : '' }}> Tidak &nbsp;&nbsp;&nbsp;
                    <input type="checkbox" {{ $data->transfusi_ya ? 'checked' : '' }}> Ya, Jenis / Jumlah :
                    {{ $data->transfusi_jenis_jumlah ?: '…………………/…………' }}
                </td>
            </tr>

            {{-- Jenis Implan --}}
            <tr>
                <td colspan="4" style="padding:6px 8px; border-top:1px solid black;">
                    Jenis Implan :
                    &nbsp; <input type="checkbox" {{ $data->implan_tidak ? 'checked' : '' }}> Tidak &nbsp;&nbsp;&nbsp;
                    <input type="checkbox" {{ $data->implan_ya ? 'checked' : '' }}> Ya, Jenis / Jumlah :
                    {{ $data->implan_jenis_jumlah ?: '…………………………………………………………………' }}
                </td>
            </tr>

            {{-- Uraian Pembedahan --}}
            <tr>
                <td colspan="4" style="padding:8px; border-top:1px solid black;">
                    <strong>Uraian Pembedahan</strong>
                    <br><br>
                    @if($data->uraian_pembedahan)
                        {!! nl2br(e($data->uraian_pembedahan)) !!}
                    @else
                        ……………………………………………………………………………………………………………………………...<br>
                        ……………………………………………………………………………………………………………………………...<br>
                        ……………………………………………………………………………………………………………………………...<br>
                        ……………………………………………………………………………………………………………………………...<br>
                        ……………………………………………………………………………………………………………………………...<br>
                        ……………………………………………………………………………………………………………………………...<br>
                    @endif
                </td>
            </tr>

        </table>

        <br>

        {{-- ── PAGE 2: Komplikasi, Patologi, TTD ── --}}
        <table style="width:100%; border-collapse:collapse; border:1px solid black; font-size:10pt;">
            <tr>

                {{-- Kiri: Komplikasi + Konsultasi + Perdarahan --}}
                <td style="width:55%; border-right:1px solid black; padding:10px 12px; vertical-align:top; line-height:26px;">
                    Komplikasi Intra-Operasi &nbsp;: {{ $data->komplikasi_intra_operasi ?: '…………………………….…' }}
                    <br>
                    ………………………………………………………………..<br><br>
                    Konsultasi Intra Operasi &nbsp; : {{ $data->konsultasi_intra_operasi ?: '…………………………….…' }}
                    <br>
                    ………………………………………………………………..<br><br>
                    Jumlah Perdarahan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $data->jumlah_perdarahan ?: '………………………………..' }}
                </td>

                {{-- Kanan: Jaringan ke Patologi + TTD --}}
                <td style="width:45%; padding:10px 12px; vertical-align:top; text-align:center;">
                    <div style="text-align:left; margin-bottom:10px;">
                        Jaringan ke Patologi
                        <br>
                        <input type="checkbox" {{ $data->jaringan_patologi_ya ? 'checked' : '' }}> Ya
                        <br>
                        <input type="checkbox" {{ $data->jaringan_patologi_tidak ? 'checked' : '' }}> Tidak
                    </div>

                    <div style="text-align:center; margin-top:10px;">
                        <strong>Tandatangan dokter bedah</strong>
                        <br><br>
                        @if($data->ttd_dokter)
                            <img src="{{ $data->ttd_dokter }}" alt="TTD Dokter" style="max-width:180px; max-height:80px;">
                            <br>
                        @else
                            <br><br><br>
                        @endif
                        ( dr. {{ $data->nama_dokter ?: '……………………………' }} )
                    </div>
                </td>

            </tr>
        </table>

    </div>
</body>
</html>
