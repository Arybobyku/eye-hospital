<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>PENGKAJIAN AWAL MEDIS MATA</title>
    <style>
    @page { margin: 15px 18px; size: A4; }
    body { margin: 0; font-family: Arial, sans-serif; font-size: 9px; line-height: 1.35; color: #000; }
    table { width: 100%; border-collapse: collapse; page-break-inside: auto; }
    tr { page-break-inside: avoid; page-break-after: auto; }
    td, th { padding: 1px 3px; vertical-align: middle; }

    .outer-box { border: 1px solid #000; }
    .outer-box td { border: 1px solid #000; }

    .section-title {
        background-color: #b0b0b0;
        font-weight: bold;
        font-size: 9px;
        padding: 2px 6px;
        letter-spacing: 0.3px;
    }
    .sub-label {
        background-color: #d8d8d8;
        font-weight: bold;
        font-size: 8.5px;
        padding: 2px 5px;
    }

    /* checkbox columns */
    .cbc { width: 13px; text-align: center; padding: 1px 0; }
    .lbl { padding: 1px 4px 1px 1px; white-space: nowrap; }
    .gap { width: 8px; }
    .q   { padding: 1px 4px; }

    /* underline value */
    .uv  { border-bottom: 1px solid #444; min-width: 55px; display: inline-block; padding: 0 2px; }
    .uv2 { border-bottom: 1px solid #444; min-width: 110px; display: inline-block; padding: 0 2px; }
    .uv3 { border-bottom: 1px solid #444; min-width: 180px; display: inline-block; padding: 0 2px; }
    .uv4 { border-bottom: 1px solid #444; width: 95%; display: inline-block; padding: 0 2px; }

    .no-surat    { text-align: right; font-size: 8px; margin-bottom: 2px; }
    .title-main  { text-align: center; font-weight: bold; font-size: 11px; padding: 3px 0; letter-spacing: 1px; }
    .title-sub   { text-align: center; font-size: 8px; padding-bottom: 3px; }

    /* mata tabel */
    .mata-table { border-collapse: collapse; width: 100%; }
    .mata-table th { background: #e0e8f0; border: 1px solid #888; padding: 2px 4px; text-align: center; font-size: 8.5px; }
    .mata-table td { border: 1px solid #888; padding: 2px 4px; font-size: 8.5px; }

    /* nested table reset – override .outer-box td border */
    .itd { border: none !important; padding: 1px 2px !important; vertical-align: middle !important; }
    </style>
</head>
<body>
<?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>

{{-- ===================== HALAMAN 1 ===================== --}}
<div class="no-surat">{{ $pamm->no_surat ?? 'RM 7.7/PAMM/22' }}</div>
@include('print-rekam-medis.partials.header')

{{-- JUDUL --}}
<table class="outer-box" style="margin-top:3px;">
    <tr>
        <td class="title-main">PENGKAJIAN AWAL MEDIS MATA</td>
    </tr>
    <tr>
        <td class="title-sub">(Diisi oleh Dokter dalam waktu 24 jam sejak pertama pasien masuk rumah sakit)</td>
    </tr>
    <tr>
        <td style="padding:2px 4px;">
            Tanggal : <span class="uv">{{ $pamm->tanggal ?? '' }}</span>
            &nbsp;&nbsp;
            Jam : <span class="uv">{{ $pamm->jam ?? '' }}</span>
        </td>
    </tr>
</table>

{{-- ALERGI & SUMBER DATA --}}
<table style="margin-top:3px;">
    <tr>
        <td colspan="9" class="section-title">ALERGI &amp; SUMBER DATA</td>
    </tr>
    <tr>
        <td colspan="9" style="padding:1px 4px;">
            Alergi : <span class="uv4">{{ $pamm->alergi ?? '' }}</span>
        </td>
    </tr>
    <tr>
        <td class="q" style="white-space:nowrap;">Sumber Data :</td>
        <td class="cbc"><input type="checkbox" {{ $pamm->sumber_pasien ? 'checked' : '' }}></td>
        <td class="lbl">Pasien</td>
        <td class="cbc"><input type="checkbox" {{ $pamm->sumber_keluarga ? 'checked' : '' }}></td>
        <td class="lbl">Keluarga</td>
        <td class="cbc"><input type="checkbox" {{ $pamm->sumber_teman ? 'checked' : '' }}></td>
        <td class="lbl">Teman</td>
        <td class="cbc"><input type="checkbox" {{ $pamm->sumber_lainnya ? 'checked' : '' }}></td>
        <td class="lbl">Lainnya : <span class="uv2">{{ $pamm->sumber_lainnya_text ?? '' }}</span></td>
    </tr>
</table>

{{-- PENILAIAN NYERI --}}
<table style="margin-top:3px;">
    <tr><td colspan="2" class="section-title">PENILAIAN NYERI (VAS)</td></tr>
    <tr>
        <td style="width:42%; padding:2px 4px; vertical-align:top;">
            {{-- VAS Image --}}
            <?php $vasPath = storage_path('app/public/images/vas.png'); ?>
            @if(file_exists($vasPath))
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents($vasPath)) }}"
                     style="width:100%; max-width:260px;" />
            @endif
        </td>
        <td style="width:58%; padding:2px 4px; vertical-align:top;">
            <table style="width:100%;">
                <tr>
                    <td>Nyeri :</td>
                    <td class="cbc"><input type="checkbox" {{ ($pamm->nyeri_ada ?? '') == 'tidak' ? 'checked' : '' }}></td>
                    <td class="lbl">Tidak</td>
                    <td class="cbc"><input type="checkbox" {{ ($pamm->nyeri_ada ?? '') == 'ya' ? 'checked' : '' }}></td>
                    <td class="lbl">Ya</td>
                </tr>
                <tr>
                    <td colspan="5" style="padding:1px 0;">
                        Skala nyeri : <span class="uv">{{ $pamm->skala_nyeri_text ?? $pamm->skala_nyeri ?? '' }}</span>
                        &nbsp; (Intensitas 0 – 10)
                    </td>
                </tr>
                <tr>
                    <td colspan="5" style="padding:1px 0;">
                        Nyeri Karakteristik : <span class="uv3">{{ $pamm->nyeri_karakteristik ?? '' }}</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" style="padding:1px 0;">
                        Lokasi : <span class="uv3">{{ $pamm->nyeri_lokasi ?? '' }}</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" style="padding:1px 0;">
                        Durasi : <span class="uv3">{{ $pamm->nyeri_durasi ?? '' }}</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" style="padding:1px 0;">
                        Frekuensi : <span class="uv">{{ $pamm->nyeri_frekuensi ?? '' }}</span> x/hari
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

{{-- ANAMNESA --}}
<table style="margin-top:3px;">
    <tr><td colspan="2" class="section-title">ANAMNESA</td></tr>
    <tr>
        <td colspan="2" style="padding:1px 4px;">
            Keluhan Utama : <span class="uv4">{{ $pamm->keluhan_utama ?? '' }}</span>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding:1px 4px;">
            Riwayat Penyakit Sekarang : <span class="uv4">{{ $pamm->riwayat_penyakit_sekarang ?? '' }}</span>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding:1px 4px; font-weight:bold;">
            Riwayat Penyakit Dahulu dan Riwayat Pengobatan :
        </td>
    </tr>
    <tr>
        <td style="width:50%; padding:1px 4px; border-right:1px solid #aaa;">
            Riwayat Penyakit Dahulu : <br>
            <span class="uv4">{{ $pamm->riwayat_penyakit_dahulu ?? '' }}</span>
        </td>
        <td style="width:50%; padding:1px 4px;">
            Riwayat Pengobatan : <br>
            <span class="uv4">{{ $pamm->riwayat_pengobatan ?? '' }}</span>
        </td>
    </tr>
</table>

{{-- RIWAYAT PENYAKIT KELUARGA --}}
<table style="margin-top:3px;">
    <tr><td colspan="24" class="section-title">RIWAYAT PENYAKIT KELUARGA</td></tr>
    <tr>
        <td class="cbc"><input type="checkbox" {{ $pamm->rpk_hipertensi ? 'checked' : '' }}></td>
        <td class="lbl">Hipertensi</td>
        <td class="cbc"><input type="checkbox" {{ $pamm->rpk_diabetes ? 'checked' : '' }}></td>
        <td class="lbl">Diabetes</td>
        <td class="cbc"><input type="checkbox" {{ $pamm->rpk_jantung ? 'checked' : '' }}></td>
        <td class="lbl">Jantung</td>
        <td class="cbc"><input type="checkbox" {{ $pamm->rpk_stroke ? 'checked' : '' }}></td>
        <td class="lbl">Stroke</td>
        <td class="cbc"><input type="checkbox" {{ $pamm->rpk_dialysis ? 'checked' : '' }}></td>
        <td class="lbl">Dialysis</td>
        <td class="cbc"><input type="checkbox" {{ $pamm->rpk_asthma ? 'checked' : '' }}></td>
        <td class="lbl">Asthma</td>
        <td class="cbc"><input type="checkbox" {{ $pamm->rpk_kejang ? 'checked' : '' }}></td>
        <td class="lbl">Kejang</td>
        <td class="cbc"><input type="checkbox" {{ $pamm->rpk_liver ? 'checked' : '' }}></td>
        <td class="lbl">Liver</td>
        <td class="cbc"><input type="checkbox" {{ $pamm->rpk_cancer ? 'checked' : '' }}></td>
        <td class="lbl">Cancer</td>
        <td class="cbc"><input type="checkbox" {{ $pamm->rpk_tbc ? 'checked' : '' }}></td>
        <td class="lbl">TBC</td>
        <td class="cbc"><input type="checkbox" {{ $pamm->rpk_glaukoma ? 'checked' : '' }}></td>
        <td class="lbl">Glaukoma</td>
        <td class="cbc"><input type="checkbox" {{ $pamm->rpk_std ? 'checked' : '' }}></td>
        <td class="lbl">STD</td>
    </tr>
    <tr>
        <td class="cbc"><input type="checkbox" {{ $pamm->rpk_perdarahan ? 'checked' : '' }}></td>
        <td class="lbl">Perdarahan</td>
        <td class="cbc"><input type="checkbox" {{ $pamm->rpk_lain_lain ? 'checked' : '' }}></td>
        <td colspan="21" class="lbl">Lain-lain : <span class="uv3">{{ $pamm->rpk_lain_lain_text ?? '' }}</span></td>
    </tr>
</table>

{{-- RIWAYAT OPERASI & TRANSFUSI --}}
<table style="margin-top:3px;">
    <tr>
        <td class="q" style="width:22%; white-space:nowrap;">Riwayat Operasi :</td>
        <td class="cbc"><input type="checkbox" {{ ($pamm->riwayat_operasi ?? '') == 'Tidak' ? 'checked' : '' }}></td>
        <td class="lbl">Tidak</td>
        <td class="cbc"><input type="checkbox" {{ ($pamm->riwayat_operasi ?? '') == 'Ya' ? 'checked' : '' }}></td>
        <td class="lbl">Ya,</td>
        <td>Jenis &amp; Kapan : <span class="uv3">{{ $pamm->riwayat_operasi_keterangan ?? '' }}</span></td>
    </tr>
    <tr>
        <td class="q" style="white-space:nowrap;">Riwayat Transfusi :</td>
        <td class="cbc"><input type="checkbox" {{ ($pamm->riwayat_transfusi ?? '') == 'Tidak' ? 'checked' : '' }}></td>
        <td class="lbl">Tidak</td>
        <td class="cbc"><input type="checkbox" {{ ($pamm->riwayat_transfusi ?? '') == 'Ya' ? 'checked' : '' }}></td>
        <td class="lbl">Ya,</td>
        <td>
            <table style="border-collapse:collapse; border:none; width:100%;">
                <tr>
                    <td style="border:none; white-space:nowrap; padding:1px 4px 1px 0;">Reaksi Transfusi :</td>
                    <td class="cbc" style="border:none;"><input type="checkbox" {{ ($pamm->reaksi_transfusi ?? '') == 'Tidak' ? 'checked' : '' }}></td>
                    <td class="lbl" style="border:none;">Tidak</td>
                    <td class="cbc" style="border:none;"><input type="checkbox" {{ ($pamm->reaksi_transfusi ?? '') == 'Ya' ? 'checked' : '' }}></td>
                    <td class="lbl" style="border:none; white-space:nowrap;">Ya, reaksi yang timbul : <span class="uv2">{{ $pamm->reaksi_transfusi_text ?? '' }}</span></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

{{-- SOSIAL --}}
<table style="margin-top:3px;">
    <tr><td class="section-title">Riwayat Pekerjaan, Sosial, Ekonomi, Psikologi dan Kebiasaan :</td></tr>
    <tr><td style="padding:2px 4px;"><span class="uv4">{{ $pamm->riwayat_sosial ?? '' }}</span></td></tr>
</table>

{{-- TANDA-TANDA VITAL --}}
<table class="outer-box" style="margin-top:3px;">
    <tr><td colspan="12" class="section-title">TANDA-TANDA VITAL</td></tr>
    <tr>
        <td class="q" style="white-space:nowrap;">Keadaan Umum :</td>
        <td class="cbc"><input type="checkbox" {{ ($pamm->keadaan_umum ?? '') == 'Baik' ? 'checked' : '' }}></td>
        <td class="lbl">Baik</td>
        <td class="cbc"><input type="checkbox" {{ ($pamm->keadaan_umum ?? '') == 'Sedang' ? 'checked' : '' }}></td>
        <td class="lbl">Sedang</td>
        <td class="cbc"><input type="checkbox" {{ ($pamm->keadaan_umum ?? '') == 'Lemah' ? 'checked' : '' }}></td>
        <td class="lbl">Lemah</td>
        <td class="cbc"><input type="checkbox" {{ ($pamm->keadaan_umum ?? '') == 'Jelek' ? 'checked' : '' }}></td>
        <td class="lbl">Jelek</td>
        <td class="gap"></td>
        <td class="q itd">Gizi :</td>
        <td class="itd">
            <table style="border-collapse:collapse; border:none;">
                <tr>
                    <td class="cbc itd"><input type="checkbox" {{ ($pamm->gizi ?? '') == 'Baik' ? 'checked' : '' }}></td>
                    <td class="lbl itd">Baik</td>
                    <td class="cbc itd"><input type="checkbox" {{ ($pamm->gizi ?? '') == 'Sedang' ? 'checked' : '' }}></td>
                    <td class="lbl itd">Sedang</td>
                    <td class="cbc itd"><input type="checkbox" {{ ($pamm->gizi ?? '') == 'Kurang' ? 'checked' : '' }}></td>
                    <td class="lbl itd">Kurang</td>
                    <td class="cbc itd"><input type="checkbox" {{ ($pamm->gizi ?? '') == 'Buruk' ? 'checked' : '' }}></td>
                    <td class="lbl itd">Buruk</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="6" style="padding:1px 4px;">
            GCS : E <span class="uv">{{ $pamm->gcs_e ?? '' }}</span>
            M <span class="uv">{{ $pamm->gcs_m ?? '' }}</span>
            V <span class="uv">{{ $pamm->gcs_v ?? '' }}</span>
        </td>
        <td colspan="3" style="padding:1px 4px;">BB : <span class="uv">{{ $pamm->bb ?? '' }}</span> kg</td>
        <td class="gap"></td>
        <td colspan="2" style="padding:1px 4px;">
            <table style="border-collapse:collapse; border:none; width:100%;">
                <tr>
                    <td class="itd" style="white-space:nowrap;">Tindakan Resusitasi :</td>
                    <td class="cbc itd"><input type="checkbox" {{ ($pamm->tindakan_resusitasi ?? '') == 'Ya' ? 'checked' : '' }}></td>
                    <td class="lbl itd">Ya</td>
                    <td class="cbc itd"><input type="checkbox" {{ ($pamm->tindakan_resusitasi ?? '') == 'Tidak' ? 'checked' : '' }}></td>
                    <td class="lbl itd">Tidak</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="4" style="padding:1px 4px;">Tensi : <span class="uv">{{ $pamm->tensi ?? '' }}</span> mmHg</td>
        <td colspan="4" style="padding:1px 4px;">Suhu : <span class="uv">{{ $pamm->suhu_ttv ?? '' }}</span> °C</td>
        <td colspan="4" style="padding:1px 4px;">Nadi : <span class="uv">{{ $pamm->nadi_ttv ?? '' }}</span> x/mnt</td>
    </tr>
    <tr>
        <td colspan="4" style="padding:1px 4px;">Respirasi : <span class="uv">{{ $pamm->respirasi ?? '' }}</span> x/mnt</td>
        <td colspan="8" style="padding:1px 4px;">
            <table style="border-collapse:collapse; border:none; width:100%;">
                <tr>
                    <td class="itd" style="white-space:nowrap;">Saturasi O2 : <span class="uv">{{ $pamm->saturasi_o2 ?? '' }}</span> % &nbsp; pada</td>
                    <td class="cbc itd"><input type="checkbox" {{ ($pamm->oksigen_jenis ?? '') == 'suhu_ruangan' ? 'checked' : '' }}></td>
                    <td class="lbl itd" style="white-space:nowrap;">Suhu ruangan</td>
                    <td class="cbc itd"><input type="checkbox" {{ ($pamm->oksigen_jenis ?? '') == 'nasal_canule' ? 'checked' : '' }}></td>
                    <td class="lbl itd" style="white-space:nowrap;">Nasal canule</td>
                    <td class="cbc itd"><input type="checkbox" {{ ($pamm->oksigen_jenis ?? '') == 'nrb' ? 'checked' : '' }}></td>
                    <td class="lbl itd">NRB</td>
                    <td class="cbc itd"><input type="checkbox" {{ ($pamm->oksigen_jenis ?? '') == 'lainnya' ? 'checked' : '' }}></td>
                    <td class="lbl itd">Lainnya <span class="uv">{{ $pamm->oksigen_lainnya_text ?? '' }}</span></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

{{-- PEMERIKSAAN FISIK --}}
<table style="margin-top:3px;">
    <tr><td colspan="12" class="sub-label">PEMERIKSAAN FISIK</td></tr>
    <tr>
        <td class="q" style="white-space:nowrap;">Keadaan Umum :</td>
        <td class="cbc"><input type="checkbox" {{ $pamm->pf_ku_baik ? 'checked' : '' }}></td>
        <td class="lbl">Baik</td>
        <td class="cbc"><input type="checkbox" {{ $pamm->pf_ku_sedang ? 'checked' : '' }}></td>
        <td class="lbl">Sedang</td>
        <td class="cbc"><input type="checkbox" {{ $pamm->pf_ku_lemah ? 'checked' : '' }}></td>
        <td class="lbl">Lemah</td>
        <td class="cbc"><input type="checkbox" {{ $pamm->pf_ku_buruk ? 'checked' : '' }}></td>
        <td class="lbl">Buruk</td>
        <td colspan="3"></td>
    </tr>
    <tr>
        <td class="q" style="white-space:nowrap;">Kesadaran :</td>
        <td class="cbc"><input type="checkbox" {{ $pamm->pf_kes_cm ? 'checked' : '' }}></td>
        <td class="lbl">CM</td>
        <td class="cbc"><input type="checkbox" {{ $pamm->pf_kes_somnolen ? 'checked' : '' }}></td>
        <td class="lbl">Somnolen</td>
        <td class="cbc"><input type="checkbox" {{ $pamm->pf_kes_koma ? 'checked' : '' }}></td>
        <td class="lbl">Koma</td>
        <td colspan="5"></td>
    </tr>
    <tr>
        <td colspan="12" style="padding:1px 4px;">
            GCS : E <span class="uv">{{ $pamm->pf_gcs_e ?? '' }}</span>
            &nbsp; V <span class="uv">{{ $pamm->pf_gcs_v ?? '' }}</span>
            &nbsp; M <span class="uv">{{ $pamm->pf_gcs_m ?? '' }}</span>
        </td>
    </tr>
    <tr>
        <td colspan="6" style="padding:1px 4px;">Tekanan Darah : <span class="uv">{{ $pamm->tekanan_darah ?? '' }}</span> mmHg</td>
        <td colspan="2" style="padding:1px 4px; white-space:nowrap;">Nadi : <span class="uv">{{ $pamm->nadi_pf ?? '' }}</span> x/menit</td>
        <td class="cbc"><input type="checkbox" {{ ($pamm->nadi_regularitas ?? '') == 'regular' ? 'checked' : '' }}></td>
        <td class="lbl">regular /</td>
        <td class="cbc"><input type="checkbox" {{ ($pamm->nadi_regularitas ?? '') == 'irregular' ? 'checked' : '' }}></td>
        <td class="lbl">irregular</td>
    </tr>
    <tr>
        <td colspan="4" style="padding:1px 4px;">SpO2 : <span class="uv">{{ $pamm->spo2 ?? '' }}</span> %</td>
        <td colspan="4" style="padding:1px 4px;">Reflex Cahaya : <span class="uv">{{ $pamm->reflex_cahaya ?? '' }}</span></td>
        <td colspan="4" style="padding:1px 4px;">Akral : <span class="uv">{{ $pamm->akral ?? '' }}</span> &nbsp; Temp : <span class="uv">{{ $pamm->temp ?? '' }}</span> °C</td>
    </tr>
    <tr>
        <td colspan="12" style="padding:1px 4px;">&bull; Kepala : <span class="uv4">{{ $pamm->kepala ?? '' }}</span></td>
    </tr>
    <tr>
        <td colspan="12" style="padding:1px 4px;">&bull; Leher : <span class="uv4">{{ $pamm->leher ?? '' }}</span></td>
    </tr>
    <tr>
        <td colspan="12" style="padding:1px 4px; font-weight:bold;">&bull; Jantung</td>
    </tr>
    <tr>
        <td colspan="6" style="padding:1px 14px;">Inspeksi : <span class="uv4">{{ $pamm->jantung_inspeksi ?? '' }}</span></td>
        <td colspan="6" style="padding:1px 4px;">Palpasi : <span class="uv4">{{ $pamm->jantung_palpasi ?? '' }}</span></td>
    </tr>
    <tr>
        <td colspan="6" style="padding:1px 14px;">Perkusi : <span class="uv4">{{ $pamm->jantung_perkusi ?? '' }}</span></td>
        <td colspan="6" style="padding:1px 4px;">Auskultasi : <span class="uv4">{{ $pamm->jantung_auskultasi ?? '' }}</span></td>
    </tr>
</table>

{{-- PEMERIKSAAN MATA --}}
<table class="mata-table" style="margin-top:3px;">
    <tr>
        <th colspan="3" style="background:#b0b0b0; font-size:9px; letter-spacing:0.3px;">&bull; MATA</th>
    </tr>
    <tr>
        <th style="width:40%;">Pemeriksaan</th>
        <th style="width:30%;">OD</th>
        <th style="width:30%;">OS</th>
    </tr>
    <tr>
        <td>Visus</td>
        <td>{{ $pamm->mata_visus_od ?? '' }}</td>
        <td>{{ $pamm->mata_visus_os ?? '' }}</td>
    </tr>
    <tr>
        <td>Pergerakan Bola Mata</td>
        <td>{{ $pamm->mata_pgbm_od ?? '' }}</td>
        <td>{{ $pamm->mata_pgbm_os ?? '' }}</td>
    </tr>
    <tr>
        <td>Palpebra Superior</td>
        <td>{{ $pamm->mata_palpebra_sup_od ?? '' }}</td>
        <td>{{ $pamm->mata_palpebra_sup_os ?? '' }}</td>
    </tr>
    <tr>
        <td>Palpebra Inferior</td>
        <td>{{ $pamm->mata_palpebra_inf_od ?? '' }}</td>
        <td>{{ $pamm->mata_palpebra_inf_os ?? '' }}</td>
    </tr>
    <tr>
        <td>Kornea</td>
        <td>{{ $pamm->mata_kornea_od ?? '' }}</td>
        <td>{{ $pamm->mata_kornea_os ?? '' }}</td>
    </tr>
    <tr>
        <td>Iris</td>
        <td>{{ $pamm->mata_iris_od ?? '' }}</td>
        <td>{{ $pamm->mata_iris_os ?? '' }}</td>
    </tr>
    <tr>
        <td>Konjungtiva Bulbi</td>
        <td>{{ $pamm->mata_konjungtiva_od ?? '' }}</td>
        <td>{{ $pamm->mata_konjungtiva_os ?? '' }}</td>
    </tr>
    <tr>
        <td>Sekret</td>
        <td>{{ $pamm->mata_sekret_od ?? '' }}</td>
        <td>{{ $pamm->mata_sekret_os ?? '' }}</td>
    </tr>
    <tr>
        <td>Tekanan Bola Mata</td>
        <td>{{ $pamm->mata_tio_od ?? '' }}</td>
        <td>{{ $pamm->mata_tio_os ?? '' }}</td>
    </tr>
    <tr>
        <td>Pupil — Reflek</td>
        <td>{{ $pamm->mata_pupil_reflek_od ?? '' }}</td>
        <td>{{ $pamm->mata_pupil_reflek_os ?? '' }}</td>
    </tr>
    <tr>
        <td>Pupil — Ukuran</td>
        <td>{{ $pamm->mata_pupil_ukuran_od ?? '' }}</td>
        <td>{{ $pamm->mata_pupil_ukuran_os ?? '' }}</td>
    </tr>
    <tr>
        <td>Pupil — Isokor</td>
        <td>{{ $pamm->mata_pupil_isokor_od ?? '' }}</td>
        <td>{{ $pamm->mata_pupil_isokor_os ?? '' }}</td>
    </tr>
</table>

{{-- STATUS LOKALIS & PENUNJANG --}}
<table style="margin-top:3px;">
    <tr><td class="section-title">STATUS LOKALIS SKEMA</td></tr>
    <tr>
        <td style="padding:2px 4px; min-height:60px;">
            <span class="uv4">{{ $pamm->status_lokalis ?? '' }}</span>
        </td>
    </tr>
</table>

<table style="margin-top:3px;">
    <tr><td class="section-title">PEMERIKSAAN PENUNJANG (Laboratorium, EKG, X-Ray, Lain-lain)</td></tr>
    <tr><td style="padding:2px 4px;"><span class="uv4">{{ $pamm->pemeriksaan_penunjang ?? '' }}</span></td></tr>
</table>

<table style="margin-top:3px;">
    <tr><td class="section-title">DIAGNOSA KERJA</td></tr>
    <tr><td style="padding:2px 4px;"><span class="uv4">{{ $pamm->diagnosa_kerja ?? '' }}</span></td></tr>
</table>

<table style="margin-top:3px;">
    <tr><td class="section-title">DIAGNOSA DIFERENSIAL</td></tr>
    <tr><td style="padding:2px 4px;"><span class="uv4">{{ $pamm->diagnosa_diferensial ?? '' }}</span></td></tr>
</table>

<table style="margin-top:3px;">
    <tr><td class="section-title">TERAPI</td></tr>
    <tr><td style="padding:2px 4px;"><span class="uv4">{{ $pamm->terapi ?? '' }}</span></td></tr>
</table>

<table style="margin-top:3px;">
    <tr><td class="section-title">RENCANA KERJA</td></tr>
    <tr><td style="padding:2px 4px;"><span class="uv4">{{ $pamm->rencana_kerja ?? '' }}</span></td></tr>
</table>

{{-- HASIL PEMBEDAHAN --}}
<table style="margin-top:3px;">
    <tr><td class="section-title">HASIL PEMBEDAHAN</td></tr>
    <tr><td style="padding:2px 4px;"><span class="uv4">{{ $pamm->hasil_pembedahan ?? '' }}</span></td></tr>
</table>

{{-- DISPOSISI --}}
<table style="margin-top:3px;">
    <tr><td colspan="8" class="section-title">DISPOSISI</td></tr>
    <tr>
        <td class="cbc"><input type="checkbox" {{ $pamm->cb_boleh_pulang ? 'checked' : '' }}></td>
        <td colspan="7" style="padding:1px 4px;">
            Boleh pulang jam keluar : <span class="uv">{{ $pamm->disposisi_pulang_jam ?? '' }}</span>
            &nbsp; WIB &nbsp;&nbsp; Tanggal : <span class="uv">{{ $pamm->disposisi_pulang_tanggal ?? '' }}</span>
        </td>
    </tr>
    <tr>
        <td class="cbc"><input type="checkbox" {{ $pamm->cb_kontrol_poliklinik ? 'checked' : '' }}></td>
        <td class="q" style="width:28%;">Kontrol Poliklinik :</td>
        <td class="cbc"><input type="checkbox" {{ ($pamm->kontrol_poliklinik ?? '') == 'Tidak' ? 'checked' : '' }}></td>
        <td class="lbl">Tidak</td>
        <td class="cbc"><input type="checkbox" {{ ($pamm->kontrol_poliklinik ?? '') == 'Ya' ? 'checked' : '' }}></td>
        <td class="lbl">Ya</td>
        <td><span class="uv2">{{ $pamm->kontrol_tujuan ?? '' }}</span></td>
        <td>Tgl : <span class="uv">{{ $pamm->kontrol_tanggal ?? '' }}</span></td>
    </tr>
    <tr>
        <td class="cbc"><input type="checkbox" {{ $pamm->cb_dirawat_ruangan ? 'checked' : '' }}></td>
        <td colspan="3" style="padding:1px 4px;">Dirawat di ruangan : <span class="uv2">{{ $pamm->dirawat_ruangan ?? '' }}</span></td>
        <td class="cbc"><input type="checkbox" {{ $pamm->cb_dirawat_kelas ? 'checked' : '' }}></td>
        <td colspan="3" style="padding:1px 4px;">Kelas : <span class="uv">{{ $pamm->dirawat_kelas ?? '' }}</span></td>
    </tr>
</table>

{{-- REKOMENDASI & CATATAN --}}
<table style="margin-top:3px;">
    <tr>
        <td style="width:50%; border:1px solid #888; vertical-align:top; padding:2px 4px;">
            <div class="sub-label" style="margin-bottom:3px;">REKOMENDASI (SARAN)</div>
            <span class="uv4">{{ $pamm->rekomendasi ?? '' }}</span>
        </td>
        <td style="width:50%; border:1px solid #888; vertical-align:top; padding:2px 4px;">
            <div class="sub-label" style="margin-bottom:3px;">CATATAN PENTING</div>
            <span class="uv4">{{ $pamm->catatan_penting ?? '' }}</span>
        </td>
    </tr>
</table>

{{-- TANDA TANGAN --}}
<table style="margin-top:14px;">
    <tr>
        <td style="width:55%;"></td>
        <td style="width:45%; text-align:center; vertical-align:bottom;">
            <div>
                {{ $pamm->kota_ttd ?? 'Medan' }},
                <span class="uv">{{ $pamm->tanggal_ttd ?? '' }}</span>
                &nbsp; Jam : <span class="uv">{{ $pamm->jam_ttd ?? '' }}</span> WIB
            </div>
            <div style="height:65px; text-align:center; margin-top:4px;">
                @if(!empty($pamm->ttd_dpjp))
                    <img src="{{ $pamm->ttd_dpjp }}" style="height:60px; max-width:180px; object-fit:contain;" />
                @endif
            </div>
            <div style="border-top:1px solid #000; padding-top:3px; margin:0 20px;">
                ( {{ $pamm->nama_dpjp ?? '________________________________' }} )
            </div>
            @if(!empty($pamm->ttd_dpjp_timestamp))
                <div style="font-size:7.5px; color:#555; margin-top:2px;">{{ $pamm->ttd_dpjp_timestamp }}</div>
            @endif
        </td>
    </tr>
</table>

</body>
</html>
