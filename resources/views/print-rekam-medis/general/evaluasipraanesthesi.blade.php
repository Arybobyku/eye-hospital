<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>EVALUASI PRA ANESTHESI</title>
    <style>
    @page { margin: 15px 18px; size: A4; }
    body { margin: 0; font-family: Arial, sans-serif; font-size: 9px; line-height: 1.35; color: #000; }
    table { width: 100%; border-collapse: collapse; }
    tr { page-break-inside: avoid; }
    td { padding: 1px 3px; vertical-align: middle; }

    .outer-box { border: 1px solid #000; }
    .outer-box td { border: 1px solid #000; }

    .section-title {
        background-color: #b0b0b0;
        font-weight: bold;
        font-size: 9px;
        padding: 2px 5px;
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
    .uv  { border-bottom: 1px solid #444; min-width: 60px; display: inline-block; padding: 0 2px; }
    .uv2 { border-bottom: 1px solid #444; min-width: 120px; display: inline-block; padding: 0 2px; }
    .uv3 { border-bottom: 1px solid #444; min-width: 180px; display: inline-block; padding: 0 2px; }
    .uv4 { border-bottom: 1px solid #444; width: 95%; display: inline-block; padding: 0 2px; }

    .no-surat { text-align: right; font-size: 8px; margin-bottom: 2px; }
    .title-main { text-align: center; font-weight: bold; font-size: 11px; padding: 3px 0; letter-spacing: 1px; }

    /* lab 2-col */
    .lab-key { width: 25%; font-weight: normal; }
    .lab-sep { width: 1%; }
    .lab-val { width: 22%; }
    </style>
</head>
<body>
<?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>

{{-- ===================== HALAMAN 1 ===================== --}}
<div class="no-surat">{{ $epa->no_surat ?? 'RM 4.10/EPA/22' }}</div>
@include('print-rekam-medis.partials.header')

{{-- JUDUL --}}
<table class="outer-box" style="margin-top:3px;">
    <tr>
        <td colspan="10" class="title-main">EVALUASI PRA ANESTHESI</td>
    </tr>
    <tr>
        <td style="width:34%;">Ruangan : <span class="uv">{{ $epa->ruangan ?? '' }}</span></td>
        <td style="width:33%;">Tgl : <span class="uv">{{ $epa->tanggal ?? '' }}</span></td>
        <td style="width:33%;">Jam : <span class="uv">{{ $epa->jam ?? '' }}</span></td>
    </tr>
</table>

{{-- DIISI OLEH PASIEN label --}}
<table style="margin-top:2px;">
    <tr>
        <td class="section-title" style="text-align:center; letter-spacing:2px;">
            DIISI &nbsp;:&nbsp; OLEH PASIEN
        </td>
    </tr>
</table>

{{-- Umur / JK / Menikah / Pekerjaan --}}
<table style="margin-top:1px;">
    <tr>
        <td style="width:18%;">Umur : <span class="uv">{{ $epa->umur ?? '' }}</span></td>
        <td style="width:auto; white-space:nowrap;">Jenis Kelamin</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->jk ?? '') == 'L' ? 'checked' : '' }}></td>
        <td class="lbl">L</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->jk ?? '') == 'P' ? 'checked' : '' }}></td>
        <td class="lbl">P</td>
        <td class="gap"></td>
        <td style="white-space:nowrap;">Menikah :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->menikah ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->menikah ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td class="gap"></td>
        <td>Pekerjaan : <span class="uv2">{{ $epa->pekerjaan ?? '' }}</span></td>
    </tr>
</table>

{{-- ===== KEBIASAAN ===== --}}
<table style="margin-top:3px;">
    <tr><td colspan="14" class="section-title">KEBIASAAN</td></tr>
    <tr>
        <td class="q" style="width:13%;">Merokok :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->merokok ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->merokok ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td class="q">Sebanyak : <span class="uv">{{ $epa->merokok_sebanyak ?? '' }}</span></td>
        <td class="gap"></td>
        <td class="q" style="width:17%;">Kopi/teh/soda :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->kopi_teh_soda ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->kopi_teh_soda ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td>Sebanyak : <span class="uv">{{ $epa->kopi_teh_soda_sebanyak ?? '' }}</span></td>
    </tr>
    <tr>
        <td class="q">Alkohol :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->alkohol ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->alkohol ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td class="q">Sebanyak : <span class="uv">{{ $epa->alkohol_sebanyak ?? '' }}</span></td>
        <td class="gap"></td>
        <td class="q">Olahraga rutin :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->olahraga_rutin ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->olahraga_rutin ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td>Sebanyak : <span class="uv">{{ $epa->olahraga_rutin_sebanyak ?? '' }}</span></td>
    </tr>
</table>

{{-- ===== PENGOBATAN ===== --}}
<table style="margin-top:3px;">
    <tr><td colspan="6" class="section-title">PENGOBATAN : Sebutkan dosis atau jumlah pil per hari</td></tr>
    <tr>
        <td style="width:30%; padding:1px 4px;">
            Obat resep : <span class="uv3">{{ $epa->obat_resep ?? '' }}</span>
        </td>
        <td style="width:70%; padding:1px 4px;">
            Obat bebas (Vitamin, herbal) : <span class="uv3">{{ $epa->obat_bebas ?? '' }}</span>
        </td>
    </tr>
    <tr>
        <td colspan="6" style="border-top:1px solid #aaa; padding:0;"></td>
    </tr>
    <tr>
        <td class="q" style="width:32%;">Penggunaan Aspirin rutin :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->aspirin_rutin ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->aspirin_rutin ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td>Dosis dan frekuensi : <span class="uv2">{{ $epa->aspirin_dosis ?? '' }}</span></td>
    </tr>
    <tr>
        <td class="q">Obat Anti sakit :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->obat_anti_sakit ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->obat_anti_sakit ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td>Dosis dan frekuensi : <span class="uv2">{{ $epa->obat_anti_sakit_dosis ?? '' }}</span></td>
    </tr>
    <tr>
        <td class="q">Injeksi steroid tahun-tahun terakhir :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->injeksi_steroid ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->injeksi_steroid ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td>Tanggal dan lokasi injeksi : <span class="uv2">{{ $epa->injeksi_steroid_info ?? '' }}</span></td>
    </tr>
    <tr>
        <td class="q">Alergi obat :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->alergi_obat ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->alergi_obat ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td>Daftar obat dan tipe reaksi : <span class="uv2">{{ $epa->alergi_obat_daftar ?? '' }}</span></td>
    </tr>
    <tr>
        <td colspan="6" style="border-top:1px solid #aaa; padding:0;"></td>
    </tr>
    <tr>
        <td colspan="6" style="padding:0;">
            <table style="width:100%;">
                <tr>
                    <td class="q" style="white-space:nowrap;">Alergi lateks :</td>
                    <td class="cbc"><input type="checkbox" {{ ($epa->alergi_lateks ?? '') == 'Y' ? 'checked' : '' }}></td>
                    <td class="lbl">Y</td>
                    <td class="cbc"><input type="checkbox" {{ ($epa->alergi_lateks ?? '') == 'T' ? 'checked' : '' }}></td>
                    <td class="lbl">T</td>
                    <td class="gap"></td>
                    <td class="q" style="white-space:nowrap;">Alergi plaster :</td>
                    <td class="cbc"><input type="checkbox" {{ ($epa->alergi_plaster ?? '') == 'Y' ? 'checked' : '' }}></td>
                    <td class="lbl">Y</td>
                    <td class="cbc"><input type="checkbox" {{ ($epa->alergi_plaster ?? '') == 'T' ? 'checked' : '' }}></td>
                    <td class="lbl">T</td>
                    <td class="gap"></td>
                    <td class="q" style="white-space:nowrap;">Alergi makanan :</td>
                    <td class="cbc"><input type="checkbox" {{ ($epa->alergi_makanan ?? '') == 'Y' ? 'checked' : '' }}></td>
                    <td class="lbl">Y</td>
                    <td class="cbc"><input type="checkbox" {{ ($epa->alergi_makanan ?? '') == 'T' ? 'checked' : '' }}></td>
                    <td class="lbl">T</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

{{-- ===== RIWAYAT KELUARGA ===== --}}
<table style="margin-top:3px;">
    <tr><td colspan="11" class="section-title">RIWAYAT KELUARGA : apakah keluarga mendapat permasalahan seperti di bawah ini ?</td></tr>
    <tr>
        <td class="q" style="width:27%;">Perdarahan yang tidak normal :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->kel_perdarahan ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->kel_perdarahan ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td class="gap"></td>
        <td class="q" style="width:27%;">Serangan jantung :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->kel_serangan_jantung ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->kel_serangan_jantung ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
    </tr>
    <tr>
        <td class="q">Pembekuan darah tidak normal :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->kel_pembekuan ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->kel_pembekuan ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td class="gap"></td>
        <td class="q">Hipertensi :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->kel_hipertensi ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->kel_hipertensi ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
    </tr>
    <tr>
        <td class="q">Permasalahan pembuluh darah :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->kel_pembuluh_darah ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->kel_pembuluh_darah ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td class="gap"></td>
        <td class="q">Tuberkulosis :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->kel_tuberkulosis ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->kel_tuberkulosis ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
    </tr>
    <tr>
        <td class="q">Operasi jantung koroner :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->kel_operasi_jantung ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->kel_operasi_jantung ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td class="gap"></td>
        <td class="q">Penyakit berat lainnya :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->kel_penyakit_berat_lainnya ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->kel_penyakit_berat_lainnya ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
    </tr>
    <tr>
        <td class="q">Diabetes :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->kel_diabetes ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->kel_diabetes ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td colspan="6"></td>
    </tr>
    <tr>
        <td colspan="11" style="padding:1px 4px;">
            Jelaskan penyakit keluarga apabila dijawab "Ya" : <span class="uv4">{{ $epa->kel_jelaskan ?? '' }}</span>
        </td>
    </tr>
</table>

{{-- ===== KOMUNIKASI ===== --}}
<table style="margin-top:3px;">
    <tr><td colspan="11" class="section-title">Komunikasi</td></tr>
    <tr>
        <td style="width:15%; white-space:nowrap;">Bahasa :</td>
        <td class="cbc"><input type="checkbox" {{ $epa->bahasa_indonesia ? 'checked' : '' }}></td>
        <td class="lbl">Indonesia</td>
        <td class="cbc"><input type="checkbox" {{ $epa->bahasa_lainnya_cb ? 'checked' : '' }}></td>
        <td class="lbl">Lainnya</td>
        <td colspan="6">: <span class="uv3">{{ $epa->bahasa_lainnya ?? '' }}</span></td>
    </tr>
    <tr>
        <td class="q">Gangguan Penglihatan/Buta :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->gangguan_penglihatan ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->gangguan_penglihatan ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td colspan="6"></td>
    </tr>
    <tr>
        <td class="q">Gangguan Pendengaran/Tuli :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->gangguan_pendengaran ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->gangguan_pendengaran ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td colspan="6"></td>
    </tr>
    <tr>
        <td class="q">Gangguan Bicara :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->gangguan_bicara ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->gangguan_bicara ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td colspan="6"></td>
    </tr>
</table>

{{-- ===== RIWAYAT PENYAKIT PASIEN ===== --}}
<table style="margin-top:3px;">
    <tr><td colspan="11" class="section-title">RIWAYAT PENYAKIT PASIEN : apakah pasien pernah menderita penyakit di bawah ini?</td></tr>
    <tr>
        <td class="q" style="width:27%;">Perdarahan yang tidak normal :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->rp_perdarahan ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->rp_perdarahan ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td class="gap"></td>
        <td class="q" style="width:27%;">Serangan jantung/Nyeri dada :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->rp_serangan_jantung ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->rp_serangan_jantung ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
    </tr>
    <tr>
        <td class="q">Pembekuan darah tidak normal :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->rp_pembekuan ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->rp_pembekuan ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td class="gap"></td>
        <td class="q">Hepatitis/sakit kuning :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->rp_hepatitis ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->rp_hepatitis ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
    </tr>
    <tr>
        <td class="q">Sakit maag :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->rp_sakit_maag ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->rp_sakit_maag ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td class="gap"></td>
        <td class="q">Sumbatan jalan nafas saat tidur/Mengorok :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->rp_sleep_apnea ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->rp_sleep_apnea ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
    </tr>
    <tr>
        <td class="q">Sesak Napas :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->rp_sesak_napas ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->rp_sesak_napas ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td class="gap"></td>
        <td class="q">Penyakit berat lainnya :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->rp_penyakit_berat_lainnya ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->rp_penyakit_berat_lainnya ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
    </tr>
    <tr>
        <td class="q">Asma :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->rp_asma ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->rp_asma ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td colspan="6"></td>
    </tr>
    <tr>
        <td class="q">Diabetes :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->rp_diabetes ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->rp_diabetes ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td colspan="6"></td>
    </tr>
    <tr>
        <td class="q">Pingsan :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->rp_pingsan ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->rp_pingsan ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td colspan="6"></td>
    </tr>
    <tr>
        <td class="q">Stroke :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->rp_stroke ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->rp_stroke ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td colspan="6"></td>
    </tr>
    <tr>
        <td colspan="11" style="padding:1px 4px;">
            Jelaskan penyakit yang dijawab "Ya" : <span class="uv4">{{ $epa->rp_jelaskan ?? '' }}</span>
        </td>
    </tr>
    <tr>
        <td class="q" style="width:42%;">Apakah pasien pernah mendapatkan transfusi darah?</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->transfusi_darah ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->transfusi_darah ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td class="gap"></td>
        <td colspan="5">Bila ya, tahun berapa? <span class="uv">{{ $epa->transfusi_darah_tahun ?? '' }}</span></td>
    </tr>
    <tr>
        <td class="q">Apakah pasien pernah diperiksa untuk diagnosis HIV?</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->hiv_diperiksa ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->hiv_diperiksa ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td class="gap"></td>
        <td colspan="5">Bila ya, tahun berapa? <span class="uv">{{ $epa->hiv_tahun ?? '' }}</span></td>
    </tr>
    <tr>
        <td class="q">Hasil pemeriksaan HIV :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->hiv_hasil ?? '') == 'Positif' ? 'checked' : '' }}></td>
        <td class="lbl">Positif</td>
        <td class="gap"></td>
        <td class="cbc"><input type="checkbox" {{ ($epa->hiv_hasil ?? '') == 'Negatif' ? 'checked' : '' }}></td>
        <td class="lbl">Negatif</td>
        <td colspan="5"></td>
    </tr>
    <tr>
        <td colspan="11" style="padding:0;">
            <table style="width:100%;">
                <tr>
                    <td class="q" style="white-space:nowrap;">Apakah pasien memakai :</td>
                    <td class="q" style="white-space:nowrap;">Lensa kontak :</td>
                    <td class="cbc"><input type="checkbox" {{ ($epa->lensa_kontak ?? '') == 'Y' ? 'checked' : '' }}></td>
                    <td class="lbl">Y</td>
                    <td class="cbc"><input type="checkbox" {{ ($epa->lensa_kontak ?? '') == 'T' ? 'checked' : '' }}></td>
                    <td class="lbl">T</td>
                    <td class="q" style="white-space:nowrap;">Kacamata :</td>
                    <td class="cbc"><input type="checkbox" {{ ($epa->kacamata ?? '') == 'Y' ? 'checked' : '' }}></td>
                    <td class="lbl">Y</td>
                    <td class="cbc"><input type="checkbox" {{ ($epa->kacamata ?? '') == 'T' ? 'checked' : '' }}></td>
                    <td class="lbl">T</td>
                    <td class="q" style="white-space:nowrap;">Alat bantu dengar :</td>
                    <td class="cbc"><input type="checkbox" {{ ($epa->alat_bantu_dengar ?? '') == 'Y' ? 'checked' : '' }}></td>
                    <td class="lbl">Y</td>
                    <td class="cbc"><input type="checkbox" {{ ($epa->alat_bantu_dengar ?? '') == 'T' ? 'checked' : '' }}></td>
                    <td class="lbl">T</td>
                    <td class="q" style="white-space:nowrap;">Gigi Palsu :</td>
                    <td class="cbc"><input type="checkbox" {{ ($epa->gigi_palsu_alat ?? '') == 'Y' ? 'checked' : '' }}></td>
                    <td class="lbl">Y</td>
                    <td class="cbc"><input type="checkbox" {{ ($epa->gigi_palsu_alat ?? '') == 'T' ? 'checked' : '' }}></td>
                    <td class="lbl">T</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="11" style="padding:1px 4px;">
            Riwayat operasi, tahun dan jenis operasi : <span class="uv4">{{ $epa->riwayat_operasi ?? '' }}</span>
        </td>
    </tr>
    <tr>
        <td colspan="11" style="padding:1px 4px;">Jenis anestesi yang digunakan dan sebutkan komplikasi/reaksi yang dialami :</td>
    </tr>
    <tr>
        <td colspan="11" style="padding:1px 4px 1px 14px;">
            &bull; Anestesia lokal — komplikasi/reaksi : <span class="uv4">{{ $epa->anestesi_lokal_komplikasi ?? '' }}</span>
        </td>
    </tr>
    <tr>
        <td colspan="11" style="padding:1px 4px 1px 14px;">
            &bull; Anestesia regional — komplikasi/reaksi : <span class="uv4">{{ $epa->anestesi_regional_komplikasi ?? '' }}</span>
        </td>
    </tr>
    <tr>
        <td colspan="11" style="padding:1px 4px 1px 14px;">
            &bull; Anestesia umum — komplikasi/reaksi : <span class="uv4">{{ $epa->anestesi_umum_komplikasi ?? '' }}</span>
        </td>
    </tr>
    <tr>
        <td colspan="6" style="padding:1px 4px;">
            Tanggal terakhir kali periksa kesehatan ke dokter : <span class="uv">{{ $epa->tgl_terakhir_periksa ?? '' }}</span>
        </td>
        <td colspan="5" style="padding:1px 4px;">dimana : <span class="uv2">{{ $epa->tempat_periksa ?? '' }}</span></td>
    </tr>
    <tr>
        <td colspan="11" style="padding:1px 4px;">
            Untuk penyakit gangguan apa : <span class="uv4">{{ $epa->penyakit_gangguan ?? '' }}</span>
        </td>
    </tr>
</table>

{{-- ===== KHUSUS PEREMPUAN ===== --}}
<table style="margin-top:3px;">
    <tr><td colspan="8" class="section-title">KHUSUS PASIEN PEREMPUAN :</td></tr>
    <tr>
        <td style="width:24%; padding:1px 4px;">Jumlah kehamilan : <span class="uv">{{ $epa->jumlah_kehamilan ?? '' }}</span></td>
        <td style="width:22%; padding:1px 4px;">Jumlah anak : <span class="uv">{{ $epa->jumlah_anak ?? '' }}</span></td>
        <td style="width:26%; padding:1px 4px;">Menstruasi terakhir : <span class="uv">{{ $epa->menstruasi_terakhir ?? '' }}</span></td>
        <td class="q" style="white-space:nowrap;">Menyusui :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->menyusui ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->menyusui ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
    </tr>
</table>


{{-- ===================== HALAMAN 2 ===================== --}}
<div style="page-break-before: always;"></div>

<div class="no-surat">{{ $epa->no_surat ?? 'RM 4.10/EPA/22' }}</div>

{{-- Nama / NRM / Tanggal box --}}
<table class="outer-box" style="margin-top:3px;">
    <tr>
        <td style="width:60%;">Nama : {{ $epa->nama ?? ($pasien->nama ?? '') }}</td>
        <td style="width:40%;">NRM : {{ $epa->no_rm ?? ($pasien->rekam_medis ?? '') }}</td>
    </tr>
    <tr>
        <td colspan="2">Tanggal : {{ $epa->tanggal ?? '' }}</td>
    </tr>
</table>

{{-- DIISI OLEH DOKTER label --}}
<table style="margin-top:2px;">
    <tr>
        <td class="section-title" style="text-align:center; letter-spacing:2px;">
            DIISI OLEH DOKTER
        </td>
    </tr>
</table>

{{-- ===== KAJIAN SISTEM ===== --}}
<table style="margin-top:2px;">
    <tr><td colspan="11" class="sub-label">KAJIAN SISTEM</td></tr>
    <tr>
        <td class="q" style="width:27%;">Hilangnya gigi :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->dok_hilangnya_gigi ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->dok_hilangnya_gigi ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td class="gap"></td>
        <td class="q" style="width:27%;">Sakit dada :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->dok_sakit_dada ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->dok_sakit_dada ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
    </tr>
    <tr>
        <td class="q">Masalah mobilisasi leher :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->dok_mobilisasi_lider ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->dok_mobilisasi_lider ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td class="gap"></td>
        <td class="q">Denyut jantung tidak normal :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->dok_denyut_jantung ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->dok_denyut_jantung ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
    </tr>
    <tr>
        <td class="q">Leher pendek :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->dok_lebar_perotok ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->dok_lebar_perotok ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td class="gap"></td>
        <td class="q">Muntah :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->dok_muntah ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->dok_muntah ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
    </tr>
    <tr>
        <td class="q">Batuk :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->dok_sakit_tenggorokan ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->dok_sakit_tenggorokan ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td class="gap"></td>
        <td class="q">Susah kencing :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->dok_perut_pusing ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->dok_perut_pusing ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
    </tr>
    <tr>
        <td class="q">Sesak nafas :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->dok_sesak_nafas ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->dok_sesak_nafas ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td class="gap"></td>
        <td class="q">Kejang :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->dok_kejang ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->dok_kejang ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
    </tr>
    <tr>
        <td class="q">Baru saja menderita infeksi :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->dok_baru_infeksi ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->dok_baru_infeksi ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td class="gap"></td>
        <td class="q">Sedang hamil :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->dok_sedang_hamil ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->dok_sedang_hamil ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
    </tr>
    <tr>
        <td class="q">Saluran nafas atas :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->dok_saluran_nafas_atas ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->dok_saluran_nafas_atas ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td class="gap"></td>
        <td class="q">Pingsan :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->dok_pingsan ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->dok_pingsan ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
    </tr>
    <tr>
        <td class="q">Periode menstruasi tidak normal :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->dok_menstruasi_tidak_normal ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->dok_menstruasi_tidak_normal ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td class="gap"></td>
        <td class="q">Obesitas :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->dok_obesitas ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->dok_obesitas ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
    </tr>
    <tr>
        <td class="q">Stroke :</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->dok_stroke ?? '') == 'Y' ? 'checked' : '' }}></td>
        <td class="lbl">Y</td>
        <td class="cbc"><input type="checkbox" {{ ($epa->dok_stroke ?? '') == 'T' ? 'checked' : '' }}></td>
        <td class="lbl">T</td>
        <td colspan="6"></td>
    </tr>
    <tr>
        <td colspan="11" style="padding:1px 4px;">
            Keterangan : <span class="uv4">{{ $epa->dok_keterangan ?? '' }}</span>
        </td>
    </tr>
</table>

{{-- ===== KEADAAN UMUM ===== --}}
<table style="margin-top:3px;">
    <tr><td colspan="4" class="sub-label">KEADAAN UMUM</td></tr>
    <tr>
        <td style="width:25%; padding:1px 4px;">Kesadaran : <span class="uv">{{ $epa->kesadaran ?? '' }}</span></td>
        <td style="width:25%; padding:1px 4px;">Visue : <span class="uv">{{ $epa->visue ?? '' }}</span></td>
        <td style="width:25%; padding:1px 4px;">Faring : <span class="uv">{{ $epa->faring ?? '' }}</span></td>
        <td style="width:25%; padding:1px 4px;">Gigi palsu : <span class="uv">{{ $epa->gigi_palsu ?? '' }}</span></td>
    </tr>
</table>

{{-- ===== PEMERIKSAAN FISIK ===== --}}
<table style="margin-top:3px;">
    <tr><td colspan="5" class="sub-label">PEMERIKSAAN FISIK</td></tr>
    <tr>
        <td style="width:20%; padding:1px 4px;">Tinggi : <span class="uv">{{ $epa->tinggi ?? '' }}</span> cm</td>
        <td style="width:20%; padding:1px 4px;">Berat : <span class="uv">{{ $epa->berat ?? '' }}</span> kg</td>
        <td style="width:20%; padding:1px 4px;">TD : <span class="uv">{{ $epa->td ?? '' }}</span></td>
        <td style="width:20%; padding:1px 4px;">Nadi : <span class="uv">{{ $epa->nadi ?? '' }}</span></td>
        <td style="width:20%; padding:1px 4px;">Suhu : <span class="uv">{{ $epa->suhu ?? '' }}</span></td>
    </tr>
    <tr>
        <td colspan="5" style="padding:1px 4px;">Paru-paru : <span class="uv4">{{ $epa->paru_paru ?? '' }}</span></td>
    </tr>
    <tr>
        <td colspan="5" style="padding:1px 4px;">Jantung : <span class="uv4">{{ $epa->jantung ?? '' }}</span></td>
    </tr>
    <tr>
        <td colspan="5" style="padding:1px 4px;">Abdomen : <span class="uv4">{{ $epa->abdomen ?? '' }}</span></td>
    </tr>
    <tr>
        <td colspan="5" style="padding:1px 4px;">Ekstrimitas : <span class="uv4">{{ $epa->ekstrimitas ?? '' }}</span></td>
    </tr>
    <tr>
        <td colspan="5" style="padding:1px 4px;">Neurologi (bila dapat diperiksa) : <span class="uv4">{{ $epa->neurologi ?? '' }}</span></td>
    </tr>
    <tr>
        <td colspan="5" style="padding:1px 4px;">Keterangan : <span class="uv4">{{ $epa->fisik_keterangan ?? '' }}</span></td>
    </tr>
</table>

{{-- ===== LABORATORIUM ===== --}}
<table style="margin-top:3px;">
    <tr><td colspan="4" class="sub-label">LABORATORIUM (bila tersedia)</td></tr>
    <tr>
        <td class="lab-key">Hb/Ht</td>
        <td class="lab-sep">:</td>
        <td class="lab-val"><span class="uv2">{{ $epa->lab_hb_ht ?? '' }}</span></td>
        <td style="width:2%"></td>
        <td class="lab-key">Rontgen dada</td>
        <td class="lab-sep">:</td>
        <td><span class="uv2">{{ $epa->lab_rontgen_dada ?? '' }}</span></td>
    </tr>
    <tr>
        <td class="lab-key">PT/APTT</td>
        <td class="lab-sep">:</td>
        <td class="lab-val"><span class="uv2">{{ $epa->lab_pt_aptt ?? '' }}</span></td>
        <td></td>
        <td class="lab-key">EKG</td>
        <td class="lab-sep">:</td>
        <td><span class="uv2">{{ $epa->lab_ekg ?? '' }}</span></td>
    </tr>
    <tr>
        <td class="lab-key">Tes kehamilan</td>
        <td class="lab-sep">:</td>
        <td class="lab-val"><span class="uv2">{{ $epa->lab_tes_kehamilan ?? '' }}</span></td>
        <td></td>
        <td class="lab-key">Na/Cl</td>
        <td class="lab-sep">:</td>
        <td><span class="uv2">{{ $epa->lab_co2 ?? '' }}</span></td>
    </tr>
    <tr>
        <td class="lab-key">Kalium</td>
        <td class="lab-sep">:</td>
        <td class="lab-val"><span class="uv2">{{ $epa->lab_kalium ?? '' }}</span></td>
        <td></td>
        <td class="lab-key">Kreatinin</td>
        <td class="lab-sep">:</td>
        <td><span class="uv2">{{ $epa->lab_kreatinin ?? '' }}</span></td>
    </tr>
    <tr>
        <td class="lab-key">Ureum</td>
        <td class="lab-sep">:</td>
        <td class="lab-val"><span class="uv2">{{ $epa->lab_uream ?? '' }}</span></td>
        <td></td>
        <td class="lab-key">Glukosa</td>
        <td class="lab-sep">:</td>
        <td><span class="uv2">{{ $epa->lab_glukosa ?? '' }}</span></td>
    </tr>
    <tr>
        <td class="lab-key">Lain-lain</td>
        <td class="lab-sep">:</td>
        <td colspan="5"><span class="uv4">{{ $epa->lab_lain_lain ?? '' }}</span></td>
    </tr>
    <tr>
        <td class="lab-key">Keterangan</td>
        <td class="lab-sep">:</td>
        <td colspan="5"><span class="uv4">{{ $epa->lab_keterangan ?? '' }}</span></td>
    </tr>
</table>

{{-- ===== DIAGNOSIS / ASA ===== --}}
<table style="margin-top:3px;">
    <tr><td colspan="4" class="sub-label">DIAGNOSIS :</td></tr>
    <tr>
        <td colspan="4" style="padding:2px 4px; font-weight:bold;">Klasifikasi berdasarkan ASA :</td>
    </tr>
    <tr>
        <td style="width:2%; padding:1px 4px;"><input type="checkbox" {{ ($epa->asa_klasifikasi ?? '') == '1' ? 'checked' : '' }}></td>
        <td colspan="3" style="padding:1px 4px;">1. &nbsp; <b>ASA 1</b> &nbsp; Pasien normal yang sehat</td>
    </tr>
    <tr>
        <td style="padding:1px 4px;"><input type="checkbox" {{ ($epa->asa_klasifikasi ?? '') == '2' ? 'checked' : '' }}></td>
        <td colspan="3" style="padding:1px 4px;">2. &nbsp; <b>ASA 2</b> &nbsp; Pasien dengan penyakit sistemik ringan</td>
    </tr>
    <tr>
        <td style="padding:1px 4px;"><input type="checkbox" {{ ($epa->asa_klasifikasi ?? '') == '3' ? 'checked' : '' }}></td>
        <td colspan="3" style="padding:1px 4px;">3. &nbsp; <b>ASA 3</b> &nbsp; Pasien dengan penyakit sistemik berat</td>
    </tr>
    <tr>
        <td style="padding:1px 4px;"><input type="checkbox" {{ ($epa->asa_klasifikasi ?? '') == '4' ? 'checked' : '' }}></td>
        <td colspan="3" style="padding:1px 4px;">4. &nbsp; <b>ASA 4</b> &nbsp; Pasien dengan penyakit sistemik berat yang mengancam nyawa</td>
    </tr>
</table>

{{-- ===== REKOMENDASI ANESTESI ===== --}}
<table style="margin-top:3px;">
    <tr><td colspan="12" class="sub-label">REKOMENDASI TINDAKAN ANESTESI YANG DIPILIH :</td></tr>
    <tr>
        <td style="width:2%; padding:1px 2px;"><input type="checkbox" {{ $epa->rek_anestesi_umum ? 'checked' : '' }}></td>
        <td style="width:17%; padding:1px 3px; white-space:nowrap;"><b>Anestesi Umum :</b></td>
        <td class="cbc"><input type="checkbox" {{ $epa->rek_au_intevena ? 'checked' : '' }}></td>
        <td style="padding:1px 3px; white-space:nowrap;">Intravena</td>
        <td class="cbc"><input type="checkbox" {{ $epa->rek_au_sungkup_muka ? 'checked' : '' }}></td>
        <td style="padding:1px 3px; white-space:nowrap;">Sungkup Muka</td>
        <td class="cbc"><input type="checkbox" {{ $epa->rek_au_lma ? 'checked' : '' }}></td>
        <td style="padding:1px 3px; white-space:nowrap;">Laringeal Mask Airway (LMA)</td>
        <td class="cbc"><input type="checkbox" {{ $epa->rek_au_ett ? 'checked' : '' }}></td>
        <td style="padding:1px 3px;" colspan="3">Pipa Endotrakeal Tube (ETT)</td>
    </tr>
    <tr>
        <td style="padding:1px 2px;"><input type="checkbox" {{ $epa->rek_regional ? 'checked' : '' }}></td>
        <td style="padding:1px 3px; white-space:nowrap;"><b>Regional Anestesi :</b></td>
        <td class="cbc"><input type="checkbox" {{ $epa->rek_reg_spinal ? 'checked' : '' }}></td>
        <td style="padding:1px 3px; white-space:nowrap;">Spinal Anestesi Blok</td>
        <td class="cbc"><input type="checkbox" {{ $epa->rek_reg_epidural ? 'checked' : '' }}></td>
        <td style="padding:1px 3px; white-space:nowrap;">Epidural</td>
        <td class="cbc"><input type="checkbox" {{ $epa->rek_reg_cse ? 'checked' : '' }}></td>
        <td style="padding:1px 3px; white-space:nowrap;">Kombinasi Spinal Epidural</td>
        <td class="cbc"><input type="checkbox" {{ $epa->rek_reg_pnb ? 'checked' : '' }}></td>
        <td style="padding:1px 3px;" colspan="3">Peripheral Nerve Block</td>
    </tr>
    <tr>
        <td style="padding:1px 2px;"><input type="checkbox" {{ $epa->rek_umum_plus_regional ? 'checked' : '' }}></td>
        <td colspan="11" style="padding:1px 3px;"><b>Anestesi Umum + Regional Anestesi</b></td>
    </tr>
    <tr>
        <td colspan="6" style="padding:1px 4px;">
            Puasa mulai : &nbsp;
            Jam <span class="uv">{{ $epa->puasa_mulai_jam ?? '' }}</span>
            &nbsp; Tanggal <span class="uv">{{ $epa->puasa_mulai_tanggal ?? '' }}</span>
        </td>
        <td colspan="6" style="padding:1px 4px;">
            Rencana tiba di OK : &nbsp;
            Jam <span class="uv">{{ $epa->rencana_elasi_jam ?? '' }}</span>
            &nbsp; Tanggal <span class="uv">{{ $epa->rencana_elasi_tanggal ?? '' }}</span>
        </td>
    </tr>
    <tr>
        <td colspan="12" style="padding:1px 4px;">
            Rencana Operasi : &nbsp;
            Jam <span class="uv">{{ $epa->rencana_operasi_jam ?? '' }}</span>
            &nbsp; Tanggal <span class="uv">{{ $epa->rencana_operasi_tanggal ?? '' }}</span>
        </td>
    </tr>
</table>

{{-- ===== TANDA TANGAN ===== --}}
<table style="margin-top:12px;">
    <tr>
        <td style="width:60%;"></td>
        <td style="width:40%; text-align:center; vertical-align:bottom;">
            <div style="margin-bottom:4px;">Tanda Tangan</div>
            <div style="height:65px; text-align:center;">
                @if(!empty($epa->ttd_dokter))
                    <img src="{{ $epa->ttd_dokter }}" style="height:60px; max-width:180px; object-fit:contain;" />
                @endif
            </div>
            <div style="border-top:1px solid #000; padding-top:3px; margin:0 20px;">
                ({{ $epa->nama_dokter ?? 'Dr._________________' }})
            </div>
            @if(!empty($epa->ttd_dokter_timestamp))
                <div style="font-size:7.5px; color:#555; margin-top:2px;">{{ $epa->ttd_dokter_timestamp }}</div>
            @endif
        </td>
    </tr>
</table>

</body>
</html>
