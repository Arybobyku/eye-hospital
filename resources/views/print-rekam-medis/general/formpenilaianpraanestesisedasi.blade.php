<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>PENILAIAN PRA-ANESTESI DAN SEDASI</title>
    <style>
        @page { margin: 18px; }
        body { margin: 18px; font-family: Arial, sans-serif; font-size: 11px; }
        
        .wrap {
            width: 100%;
            height: auto;
            display: inline-block;
        }
        
        .left { display: inline-block; float: left; }
        .right { display: inline-block; float: right;}
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .border-table {
            border: 1px solid black;
        }
        
        .border-table td, .border-table th {
            border: 1px solid black;
            padding: 5px;
        }
        
        .no-border td {
            border: none;
            padding: 2px;
        }
        
        .checkbox {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 1px solid black;
            text-align: center;
            line-height: 12px;
            margin: 0 3px;
        }
        
        .checkbox-checked {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 1px solid black;
            text-align: center;
            line-height: 10px;
            margin: 0 3px;
        }
        
        .section-title {
            font-weight: bold;
            background-color: #f0f0f0;
            padding: 5px;
            margin-top: 10px;
        }
        
        .underline {
            border-bottom: 1px solid black;
            display: inline-block;
            min-width: 100px;
        }
        
        .signature-box {
            text-align: center;
            padding: 10px;
        }
        
        .header-patient {
            margin-bottom: 10px;
        }
        
        .form-row {
            margin-bottom: 8px;
        }
        
        .dotted-line {
            border-bottom: 1px dotted black;
            display: inline-block;
            min-width: 150px;
        }
    </style>
</head>
<body>
<div style="position:fixed; right: 13px; bottom: 10px;"></div>
<?php $fullpath = storage_path('app/public/images/header_rme.png');  ?>  
<div class="wrap">
	<div style="width:100%; text-align:right; margin-bottom:5px">
		RM 4.4/PPADS/22
	</div>
	@include('print-rekam-medis.partials.header')
    
    
    <!-- Title -->
    <table class="border-table">
        <tr>
            <td style="font-weight: bold; text-align: center; padding: 7px; font-size: 13px;">
                PENILAIAN PRA-ANESTESI DAN SEDASI
            </td>
        </tr>
    </table>
    
    <!-- Section: Diisi oleh Pasien / Keluarga -->
    <div style="margin-top: 10px; font-weight: bold; padding: 5px; background-color: #e0e0e0;">
        Diisi oleh Pasien / Keluarga :
    </div>
    
    <!-- SOSIAL -->
    <div class="section-title">SOSIAL</div>
    <div class="form-row" style="padding: 5px;">
        <table class="no-border">
            <tr>
                <td width="10%">Umur</td>
                <td width="15%"><span class="underline">{{ $data->umur ?? '' }}</span></td>
                <td width="15%">Jenis kelamin :</td>
                <td width="5%">
                    <span class="checkbox{{ $data->jenis_kelamin_pasien == 'L' ? '-checked' : '' }}">{{ $data->jenis_kelamin_pasien == 'L' ? '✓' : '' }}</span> L
                </td>
                <td width="5%">
                    <span class="checkbox{{ $data->jenis_kelamin_pasien == 'P' ? '-checked' : '' }}">{{ $data->jenis_kelamin_pasien == 'P' ? '✓' : '' }}</span> P
                </td>
                <td width="10%">Menikah :</td>
                <td width="5%">
                    <span class="checkbox{{ $data->menikah == 'Y' ? '-checked' : '' }}">{{ $data->menikah == 'Y' ?  : '' }}</span> Y
                </td>
                <td width="5%">
                    <span class="checkbox{{ $data->menikah == 'T' ? '-checked' : '' }}">{{ $data->menikah == 'T' ?  : '' }}</span> T
                </td>
                <td width="10%">Pekerjaan</td>
                <td width="20%"><span class="underline">{{ $data->pekerjaan ?? '' }}</span></td>
            </tr>
        </table>
    </div>
    
    <!-- KEBIASAAN -->
    <div class="section-title">KEBIASAAN</div>
    <div class="form-row" style="padding: 5px;">
        <table class="no-border">
            <tr>
                <td width="10%">Merokok :</td>
                <td width="3%">
                    <span class="checkbox {{ $data->kebiasaan_merokok == 'Y' ? '-checked' : '' }}">{{ $data->kebiasaan_merokok == 'T' ? '✓' : '' }}</span> T
                </td>
                <td width="3%">
                    <span class="checkbox{{ $data->kebiasaan_merokok == 'Y' ? '-checked' : '' }}">{{ $data->kebiasaan_merokok == 'Y' ? '✓' : '' }}</span> Y
                </td>
                <td width="15%">, Sebanyak : <span class="underline">{{ $data->kebiasaan_merokok_jumlah ?? '' }}</span></td>
                <td width="15%">Kopi/Teh/Cola :</td>
                <td width="3%">
                    <span class="checkbox{{ $data->kebiasaan_kopi == 'T' ? '-checked' : '' }}">{{ $data->kebiasaan_kopi == 'T' ? '✓' : '' }}</span> T
                </td>
                <td width="3%">
                    <span class="checkbox{{ $data->kebiasaan_kopi == 'Y' ? '-checked' : '' }}">{{ $data->kebiasaan_kopi == 'Y' ? '✓' : '' }}</span> Y
                </td>
                <td width="48%">, Sebanyak : <span class="underline">{{ $data->kebiasaan_kopi_jumlah ?? '' }}</span></td>
            </tr>
            <tr>
                <td>Alkohol :</td>
                <td>
                    <span class="checkbox{{ $data->kebiasaan_alkohol == 'T' ? '-checked' : '' }}">{{ $data->kebiasaan_alkohol == 'T' ? '✓' : '' }}</span> T
                </td>
                <td>
                    <span class="checkbox{{ $data->kebiasaan_alkohol == 'Y' ? '-checked' : '' }}">{{ $data->kebiasaan_alkohol == 'Y' ? '✓' : '' }}</span> Y
                </td>
                <td>, Sebanyak : <span class="underline">{{ $data->kebiasaan_alkohol_jumlah ?? '' }}</span></td>
                <td>Olah raga rutin :</td>
                <td>
                    <span class="checkbox{{ $data->kebiasaan_olahraga == 'T' ? '-checked' : '' }}">{{ $data->kebiasaan_olahraga == 'T' ? '✓' : '' }}</span> T
                </td>
                <td>
                    <span class="checkbox{{ $data->kebiasaan_olahraga == 'Y' ? '-checked' : '' }}">{{ $data->kebiasaan_olahraga == 'Y' ? '✓' : '' }}</span> Y
                </td>
                <td>, Sebanyak : <span class="underline">{{ $data->kebiasaan_olahraga_jumlah ?? '' }}</span></td>
            </tr>
        </table>
    </div>
    
    <!-- PENGOBATAN -->
    <div class="section-title">PENGOBATAN (Sebutkan dosis per hari dan lama konsumsi)</div>
    <div class="form-row" style="padding: 5px;">
        <table class="no-border">
            <tr>
                <td width="25%">Obat yang biasa diminum</td>
                <td width="2%">:</td>
                <td width="73%"><span class="dotted-line" style="width: 90%;">{{ $data->obat_biasa_diminum ?? '' }}</span></td>
            </tr>
            <tr>
                <td>Aspirin/Plavix rutin</td>
                <td>:</td>
                <td>
                    <span class="checkbox{{ $data->aspirin_plavix == 'T' ? '-checked' : '' }}">{{ $data->aspirin_plavix == 'T' ? '✓' : '' }}</span> T
                    <span class="checkbox{{ $data->aspirin_plavix == 'Y' ? '-checked' : '' }}">{{ $data->aspirin_plavix == 'Y' ? '✓' : '' }}</span> Y,
                    <span class="dotted-line" style="width: 70%;">{{ $data->aspirin_plavix_keterangan ?? '' }}</span>
                </td>
            </tr>
            <tr>
                <td>Obat anti sakit</td>
                <td>:</td>
                <td>
                    <span class="checkbox{{ $data->obat_anti_sakit == 'T' ? '-checked' : '' }}">{{ $data->obat_anti_sakit == 'T' ? '✓' : '' }}</span> T
                    <span class="checkbox{{ $data->obat_anti_sakit == 'Y' ? '-checked' : '' }}">{{ $data->obat_anti_sakit == 'Y' ? '✓' : '' }}</span> Y,
                    <span class="dotted-line" style="width: 70%;">{{ $data->obat_anti_sakit_keterangan ?? '' }}</span>
                </td>
            </tr>
            <tr>
                <td>Alergi obat</td>
                <td>:</td>
                <td>
                    <span class="checkbox{{ $data->alergi_obat == 'T' ? '-checked' : '' }}">{{ $data->alergi_obat == 'T' ? '✓' : '' }}</span> T
                    <span class="checkbox{{ $data->alergi_obat == 'Y' ? '-checked' : '' }}">{{ $data->alergi_obat == 'Y' ? '✓' : '' }}</span> Y,
                    <span class="dotted-line" style="width: 70%;">{{ $data->alergi_obat_keterangan ?? '' }}</span>
                </td>
            </tr>
            <tr>
                <td>Alergi makanan</td>
                <td>:</td>
                <td>
                    <span class="checkbox{{ $data->alergi_makanan == 'T' ? '-checked' : '' }}">{{ $data->alergi_makanan == 'T' ? '✓' : '' }}</span> T
                    <span class="checkbox{{ $data->alergi_makanan == 'Y' ? '-checked' : '' }}">{{ $data->alergi_makanan == 'Y' ? '✓' : '' }}</span> Y,
                    <span class="dotted-line" style="width: 70%;">{{ $data->alergi_makanan_keterangan ?? '' }}</span>
                </td>
            </tr>
            <tr>
                <td>Alergi, lain-lain</td>
                <td>:</td>
                <td>
                    <span class="checkbox{{ $data->alergi_lainnya == 'T' ? '-checked' : '' }}">{{ $data->alergi_lainnya == 'T' ? '✓' : '' }}</span> T
                    <span class="checkbox{{ $data->alergi_lainnya == 'Y' ? '-checked' : '' }}">{{ $data->alergi_lainnya == 'Y' ? '✓' : '' }}</span> Y,
                    <span class="dotted-line" style="width: 70%;">{{ $data->alergi_lainnya_keterangan ?? '' }}</span>
                </td>
            </tr>
        </table>
    </div>
    
    <!-- RIWAYAT KELUARGA -->
    <div class="section-title">RIWAYAT KELUARGA - Apakah keluarga pernah mendapat permasalahan seperti di bawah ini?</div>
    <div class="form-row" style="padding: 5px;">
        <table class="no-border">
            <tr>
                <td width="35%">Perdarahan yang tidak normal :</td>
                <td width="3%">
                    <span class="checkbox{{ $data->riwayat_keluarga_perdarahan == 'T' ? '-checked' : '' }}">{{ $data->riwayat_keluarga_perdarahan == 'T' ? '✓' : '' }}</span> T
                </td>
                <td width="3%">
                    <span class="checkbox{{ $data->riwayat_keluarga_perdarahan == 'Y' ? '-checked' : '' }}">{{ $data->riwayat_keluarga_perdarahan == 'Y' ? '✓' : '' }}</span> Y
                </td>
                <td width="15%">Diabetes :</td>
                <td width="3%">
                    <span class="checkbox{{ $data->riwayat_keluarga_diabetes == 'T' ? '-checked' : '' }}">{{ $data->riwayat_keluarga_diabetes == 'T' ? '✓' : '' }}</span> T
                </td>
                <td width="3%">
                    <span class="checkbox{{ $data->riwayat_keluarga_diabetes == 'Y' ? '-checked' : '' }}">{{ $data->riwayat_keluarga_diabetes == 'Y' ? '✓' : '' }}</span> Y
                </td>
                <td width="38%"></td>
            </tr>
            <tr>
                <td>Permasalahan dalam pembiusan :</td>
                <td>
                    <span class="checkbox{{ $data->riwayat_keluarga_pembiusan == 'T' ? '-checked' : '' }}">{{ $data->riwayat_keluarga_pembiusan == 'T' ? '✓' : '' }}</span> T
                </td>
                <td>
                    <span class="checkbox{{ $data->riwayat_keluarga_pembiusan == 'Y' ? '-checked' : '' }}">{{ $data->riwayat_keluarga_pembiusan == 'Y' ? '✓' : '' }}</span> Y
                </td>
                <td>Asma :</td>
                <td>
                    <span class="checkbox{{ $data->riwayat_keluarga_asma == 'T' ? '-checked' : '' }}">{{ $data->riwayat_keluarga_asma == 'T' ? '✓' : '' }}</span> T
                </td>
                <td>
                    <span class="checkbox{{ $data->riwayat_keluarga_asma == 'Y' ? '-checked' : '' }}">{{ $data->riwayat_keluarga_asma == 'Y' ? '✓' : '' }}</span> Y
                </td>
                <td></td>
            </tr>
            <tr>
                <td>Gangguan irama jantung :</td>
                <td>
                    <span class="checkbox{{ $data->riwayat_keluarga_irama_jantung == 'T' ? '-checked' : '' }}">{{ $data->riwayat_keluarga_irama_jantung == 'T' ? '✓' : '' }}</span> T
                </td>
                <td>
                    <span class="checkbox{{ $data->riwayat_keluarga_irama_jantung == 'Y' ? '-checked' : '' }}">{{ $data->riwayat_keluarga_irama_jantung == 'Y' ? '✓' : '' }}</span> Y
                </td>
                <td colspan="4"><span class="dotted-line" style="width: 90%;">{{ $data->riwayat_kel_lainnya ?? '' }}</span></td>
            </tr>
        </table>
    </div>
    
    <!-- RIWAYAT PENYAKIT PASIEN -->
    <div class="section-title">RIWAYAT PENYAKIT PASIEN : Apakah pasien pernah menderita penyakit di bawah ini ?</div>
    <div class="form-row" style="padding: 5px;">
        <table class="no-border">
            <tr>
                <td width="35%">Perdarahan yang tidak normal :</td>
                <td width="3%">
                    <span class="checkbox{{ $data->riwayat_pasien_perdarahan == 'Y' ? '-checked' : '' }}">{{ $data->riwayat_pasien_perdarahan == 'Y' ? '✓' : '' }}</span> Y
                </td>
                <td width="3%">
                    <span class="checkbox{{ $data->riwayat_pasien_perdarahan == 'T' ? '-checked' : '' }}">{{ $data->riwayat_pasien_perdarahan == 'T' ? '✓' : '' }}</span> T
                </td>
                <td width="15%">Mengorok :</td>
                <td width="3%">
                    <span class="checkbox{{ $data->riwayat_pasien_mengorok == 'Y' ? '-checked' : '' }}">{{ $data->riwayat_pasien_mengorok == 'Y' ? '✓' : '' }}</span> Y
                </td>
                <td width="3%">
                    <span class="checkbox{{ $data->riwayat_pasien_mengorok == 'T' ? '-checked' : '' }}">{{ $data->riwayat_pasien_mengorok == 'T' ? '✓' : '' }}</span> T
                </td>
                <td width="38%"></td>
            </tr>
            <tr>
                <td>Nyeri dada :</td>
                <td>
                    <span class="checkbox{{ $data->riwayat_pasien_nyeri_dada == 'Y' ? '-checked' : '' }}">{{ $data->riwayat_pasien_nyeri_dada == 'Y' ? '✓' : '' }}</span> Y
                </td>
                <td>
                    <span class="checkbox{{ $data->riwayat_pasien_nyeri_dada == 'T' ? '-checked' : '' }}">{{ $data->riwayat_pasien_nyeri_dada == 'T' ? '✓' : '' }}</span> T
                </td>
                <td>Hepatitis :</td>
                <td>
                    <span class="checkbox{{ $data->riwayat_pasien_hepatitis == 'Y' ? '-checked' : '' }}">{{ $data->riwayat_pasien_hepatitis == 'Y' ? '✓' : '' }}</span> Y
                </td>
                <td>
                    <span class="checkbox{{ $data->riwayat_pasien_hepatitis == 'T' ? '-checked' : '' }}">{{ $data->riwayat_pasien_hepatitis == 'T' ? '✓' : '' }}</span> T
                </td>
                <td></td>
            </tr>
            <tr>
                <td>Sakit maag :</td>
                <td>
                    <span class="checkbox{{ $data->riwayat_pasien_maag == 'Y' ? '-checked' : '' }}">{{ $data->riwayat_pasien_maag == 'Y' ? '✓' : '' }}</span> Y
                </td>
                <td>
                    <span class="checkbox{{ $data->riwayat_pasien_maag == 'T' ? '-checked' : '' }}">{{ $data->riwayat_pasien_maag == 'T' ? '✓' : '' }}</span> T
                </td>
                <td>Hipertensi :</td>
                <td>
                    <span class="checkbox{{ $data->riwayat_pasien_hipertensi == 'Y' ? '-checked' : '' }}">{{ $data->riwayat_pasien_hipertensi == 'Y' ? '✓' : '' }}</span> Y
                </td>
                <td>
                    <span class="checkbox{{ $data->riwayat_pasien_hipertensi == 'T' ? '-checked' : '' }}">{{ $data->riwayat_pasien_hipertensi == 'T' ? '✓' : '' }}</span> T
                </td>
                <td></td>
            </tr>
            <tr>
                <td>Anemia :</td>
                <td>
                    <span class="checkbox{{ $data->riwayat_pasien_anemia == 'Y' ? '-checked' : '' }}">{{ $data->riwayat_pasien_anemia == 'Y' ? '✓' : '' }}</span> Y
                </td>
                <td>
                    <span class="checkbox{{ $data->riwayat_pasien_anemia == 'T' ? '-checked' : '' }}">{{ $data->riwayat_pasien_anemia == 'T' ? '✓' : '' }}</span> T
                </td>
                <td>Diabetes :</td>
                <td>
                    <span class="checkbox{{ $data->riwayat_pasien_diabetes == 'Y' ? '-checked' : '' }}">{{ $data->riwayat_pasien_diabetes == 'Y' ? '✓' : '' }}</span> Y
                </td>
                <td>
                    <span class="checkbox{{ $data->riwayat_pasien_diabetes == 'T' ? '-checked' : '' }}">{{ $data->riwayat_pasien_diabetes == 'T' ? '✓' : '' }}</span> T
                </td>
                <td></td>
            </tr>
            <tr>
                <td>Serangan jantung :</td>
                <td>
                    <span class="checkbox{{ $data->riwayat_pasien_serangan_jantung == 'Y' ? '-checked' : '' }}">{{ $data->riwayat_pasien_serangan_jantung == 'Y' ? '✓' : '' }}</span> Y
                </td>
                <td>
                    <span class="checkbox{{ $data->riwayat_pasien_serangan_jantung == 'T' ? '-checked' : '' }}">{{ $data->riwayat_pasien_serangan_jantung == 'T' ? '✓' : '' }}</span> T
                </td>
                <td>Pingsan :</td>
                <td>
                    <span class="checkbox{{ $data->riwayat_pasien_pingsan == 'Y' ? '-checked' : '' }}">{{ $data->riwayat_pasien_pingsan == 'Y' ? '✓' : '' }}</span> Y
                </td>
                <td>
                    <span class="checkbox{{ $data->riwayat_pasien_pingsan == 'T' ? '-checked' : '' }}">{{ $data->riwayat_pasien_pingsan == 'T' ? '✓' : '' }}</span> T
                </td>
                <td></td>
            </tr>
            <tr>
                <td>Asma :</td>
                <td>
                    <span class="checkbox{{ $data->riwayat_pasien_asma == 'Y' ? '-checked' : '' }}">{{ $data->riwayat_pasien_asma == 'Y' ? '✓' : '' }}</span> Y
                </td>
                <td>
                    <span class="checkbox{{ $data->riwayat_pasien_asma == 'T' ? '-checked' : '' }}">{{ $data->riwayat_pasien_asma == 'T' ? '✓' : '' }}</span> T
                </td>
                <td colspan="4"><span class="dotted-line" style="width: 90%;">{{ $data->riwayat_penyakit_lainnya ?? '' }}</span></td>
            </tr>
        </table>
    </div>
    
    <!-- Additional Questions -->
    <div class="form-row" style="padding: 5px;">
        <table class="no-border">
            <tr>
                <td width="50%">Apakah pasien pernah mendapatkan transfusi darah ?</td>
                <td width="3%">
                    <span class="checkbox{{ $data->transfusi_darah == 'Y' ? '-checked' : '' }}">{{ $data->transfusi_darah == 'Y' ? '✓' : '' }}</span> Y
                </td>
                <td width="3%">
                    <span class="checkbox{{ $data->transfusi_darah == 'T' ? '-checked' : '' }}">{{ $data->transfusi_darah == 'T' ? '✓' : '' }}</span> T
                </td>
                <td width="44%">Bila Ya, tahun berapa? <span class="underline">{{ $data->transfusi_darah_tahun ?? '' }}</span></td>
            </tr>
            <tr>
                <td>Apakah pasien pernah di periksa untuk diagnosis HIV ?</td>
                <td>
                    <span class="checkbox{{ $data->pemeriksaan_hiv == 'Y' ? '-checked' : '' }}">{{ $data->pemeriksaan_hiv == 'Y' ? '✓' : '' }}</span> Y
                </td>
                <td>
                    <span class="checkbox{{ $data->pemeriksaan_hiv == 'T' ? '-checked' : '' }}">{{ $data->pemeriksaan_hiv == 'T' ? '✓' : '' }}</span> T
                </td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3">Bila Ya, tahun berapa? <span class="underline">{{ $data->pemeriksaan_hiv_tahun  ?? '' }}</span></td>
                <td>Hasil pemeriksaan HIV ? 
                    <span class="checkbox{{ $data->hasil_hiv == 'Positif' ? '-checked' : '' }}">{{ $data->hasil_hiv == 'Positif' ? '✓' : '' }}</span> Positif
                    <span class="checkbox{{ $data->hasil_hiv == 'Negatif' ? '-checked' : '' }}">{{ $data->hasil_hiv == 'Negatif' ? '✓' : '' }}</span> Negatif
                </td>
            </tr>
        </table>
    </div>
    
    <!-- Alat Bantu -->
    <div class="form-row" style="padding: 5px;">
        <table class="no-border">
            <tr>
                <td width="20%">Apakah pasien memakai :</td>
                <td width="3%">
                    <span class="checkbox{{ in_array('Alat bantu dengar', $alat_bantu_dengar ?? []) ? '-checked' : '' }}">{{ in_array('Alat bantu dengar', $alat_bantu_dengar ?? []) ? '✓' : '' }}</span>
                </td>
                <td width="20%">Alat bantu dengar</td>
                <td width="3%">
                    <span class="checkbox{{ in_array('Kacamata', $kacamata ?? []) ? '-checked' : '' }}">{{ in_array('Kacamata', $kacamata ?? []) ? '✓' : '' }}</span>
                </td>
                <td width="54%">Kacamata</td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <span class="checkbox{{ in_array('Gigi palsu', $gigi_palsu ?? []) ? '-checked' : '' }}">{{ in_array('Gigi palsu', $gigi_palsu ?? []) ? '✓' : '' }}</span>
                </td>
                <td>Gigi palsu</td>
                <td>
                    <span class="checkbox{{ in_array('Lain-lain', $alat_bantu_lainnya ?? []) ? '-checked' : '' }}">{{ in_array('Lain-lain', $alat_bantu_lainnya ?? []) ? '✓' : '' }}</span>
                </td>
                <td>Lain-lain : <span class="dotted-line" style="width: 70%;">{{ $data->alat_bantu_lainnya ?? '' }}</span></td>
            </tr>
        </table>
    </div>
    
    <!-- Riwayat Operasi -->
    <div class="form-row" style="padding: 5px;">
        <table class="no-border">
            <tr>
                <td width="15%">Riwayat operasi :</td>
                <td width="3%">
                    <span class="checkbox{{ $data->riwayat_operasi == 'Belum pernah operasi' ? '-checked' : '' }}">{{ $data->riwayat_operasi == 'Belum pernah operasi' ? '✓' : '' }}</span>
                </td>
                <td width="25%">Belum pernah operasi</td>
                <td width="3%">
                    <span class="checkbox{{ $data->riwayat_operasi == 'Pernah Operasi' ? '-checked' : '' }}">{{ $data->riwayat_operasi == 'Pernah Operasi' ? '✓' : '' }}</span>
                </td>
                <td width="54%">Pernah Operasi, tahun <span class="underline">{{ $data->riwayat_operasi_tahun ?? '' }}</span> Jenis operasi <span class="underline">{{ $data->riwayat_operasi_jenis ?? '' }}</span></td>
</tr>
</table>
</div>
<!-- Jenis Anestesi -->
<div class="form-row" style="padding: 5px;">
    <div>Jenis anestesi yang digunakan dan sebutkan keluhan / reaksi yang dialami :</div>
    <table class="no-border" style="margin-top: 5px;">
        <tr>
            <td width="3%">
                <span class="checkbox{{ $data->anestesi_lokal_reaksi == 'Anestesi lokal' ? '-checked' : '' }}">{{ $data->anestesi_lokal_reaksi == 'Anestesi lokal' ? '✓' : '' }}</span>
            </td>
            <td width="97%">Anestesi lokal - keluhan/reaksi : <span class="dotted-line" style="width: 75%;">{{ $data->anestesi_lokal_keluhan ?? '' }}</span></td>
        </tr>
        <tr>
            <td>
                <span class="checkbox{{ $data->anestesi_regional_reaksi == 'Anestesi regional' ? '-checked' : '' }}">{{ $data->anestesi_regional_reaksi == 'Anestesi regional' ? '✓' : '' }}</span>
            </td>
            <td>Anestesi regional - keluhan/reaksi : <span class="dotted-line" style="width: 73%;">{{ $data->anestesi_regional_keluhan ?? '' }}</span></td>
        </tr>
        <tr>
            <td>
                <span class="checkbox{{ $data->anestesi_umum_sedasi_reaksi == 'Anestesi umum/sedasi' ? '-checked' : '' }}">{{ $data->anestesi_umum_sedasi_reaksi == 'Anestesi umum/sedasi' ? '✓' : '' }}</span>
            </td>
            <td>Anestesi umum/sedasi - keluhan/reaksi: <span class="dotted-line" style="width: 70%;">{{ $data->anestesi_umum_sedasi_reaksi ?? '' }}</span></td>
        </tr>
    </table>
</div>

<!-- KHUSUS PASIEN HAMIL -->
<div class="section-title">KHUSUS PASIEN HAMIL :</div>
<div class="form-row" style="padding: 5px;">
    <table class="no-border">
        <tr>
            <td width="20%">Jumlah kehamilan</td>
            <td width="15%"><span class="underline">{{ $data->jumlah_kehamilan ?? '' }}</span></td>
            <td width="15%">Jumlah anak</td>
            <td width="15%"><span class="underline">{{ $data->jumlah_anak ?? '' }}</span></td>
            <td width="20%">Menstruasi terakhir</td>
            <td width="15%"><span class="underline">{{ $data->menstruasi_terakhir ?? '' }}</span></td>
        </tr>
        <tr>
            <td>Menyusui :</td>
            <td colspan="5">
                <span class="checkbox{{ $data->menyusui == 'Y' ? '-checked' : '' }}">{{ $data->menyusui == 'Y' ? '✓' : '' }}</span> Y
                <span class="checkbox{{ $data->menyusui == 'T' ? '-checked' : '' }}">{{ $data->menyusui == 'T' ? '✓' : '' }}</span> T
            </td>
        </tr>
    </table>
</div>

<!-- Signature Pasien/Keluarga -->
<div style="margin-top: 20px;">
    <table style="width: 100%;">
        <tr>
            <td width="50%">
                <div style="padding: 5px;">
                    Tanggal Pengisian : {{ $data->tanggal_pengisian ?? '..............................' }}
                </div>
            </td>
            <td width="50%"></td>
        </tr>
        <tr>
            <td width="50%" style="text-align: center; padding-top: 10px;">
                Tanda Tangan Pasien/Keluarga
            </td>
            <td width="50%" style="text-align: center; padding-top: 10px;">
                Perawat
            </td>
        </tr>
        <tr>
            <td style="text-align: center; padding-top: 10px; padding-bottom: 10px;">
                @if(!empty($data->ttd_pasien))
                    <img src="{{ $data->ttd_pasien }}" alt="TTD Pasien" width="150px">
                @endif
            </td>
            <td style="text-align: center; padding-top: 10px; padding-bottom: 10px;">
                @if(!empty($data->ttd_perawat))
                    <img src="{{ $data->ttd_perawat }}" alt="TTD Perawat" width="150px">
                @endif
            </td>
        </tr>
        <tr>
            <td style="text-align: center; padding-bottom: 10px;">
                ( {{ $data->nama_pasien_ttd ?? '..............................' }} )
            </td>
            <td style="text-align: center; padding-bottom: 10px;">
                ( {{ $data->nama_perawat_ttd ?? '..............................' }} )
            </td>
        </tr>
    </table>
</div>

<!-- PAGE BREAK untuk halaman ke-2 -->
<div style="page-break-before: always;"></div>

<!-- Header Page 2 -->
<div style="width:100%; text-align:right; margin-bottom:5px">
    RM 4.4/PPADS/22
</div>

@include('print-rekam-medis.partials.header')


<!-- Section: Diisi oleh Dokter -->
<div style="margin-top: 10px; font-weight: bold; padding: 5px; background-color: #e0e0e0;">
    Diisi oleh Dokter
</div>

<!-- KAJIAN SISTEM -->
<div class="section-title">KAJIAN SISTEM</div>
<div class="form-row" style="padding: 5px;">
    <table class="no-border">
        <tr>
            <td width="30%">Hilangnya gigi</td>
            <td width="3%">
                <span class="checkbox{{ $data->hilang_gigi == 'Ya' ? '-checked' : '' }}">{{ $data->hilang_gigi == 'Ya' ? '✓' : '' }}</span> Ya
            </td>
            <td width="3%">
                <span class="checkbox{{ $data->hilang_gigi == 'Tidak' ? '-checked' : '' }}">{{ $data->hilang_gigi == 'Tidak' ? '✓' : '' }}</span> Tidak
            </td>
            <td width="20%">Obesitas</td>
            <td width="3%">
                <span class="checkbox{{ $data->obesitas == 'Ya' ? '-checked' : '' }}">{{ $data->obesitas == 'Ya' ? '✓' : '' }}</span> Ya
            </td>
            <td width="3%">
                <span class="checkbox{{ $data->obesitas == 'Tidak' ? '-checked' : '' }}">{{ $data->obesitas == 'Tidak' ? '✓' : '' }}</span> Tidak
            </td>
            <td width="38%"></td>
        </tr>
        <tr>
            <td>Masalah mobilisasi leher</td>
            <td>
                <span class="checkbox{{ $data->mobilisasi_leher == 'Ya' ? '-checked' : '' }}">{{ $data->mobilisasi_leher == 'Ya' ? '✓' : '' }}</span> Ya
            </td>
            <td>
                <span class="checkbox{{ $data->mobilisasi_leher == 'Tidak' ? '-checked' : '' }}">{{ $data->mobilisasi_leher == 'Tidak' ? '✓' : '' }}</span> Tidak
            </td>
            <td>Sakit dada</td>
            <td>
                <span class="checkbox{{ $data->sakit_dada == 'Ya' ? '-checked' : '' }}">{{ $data->sakit_dada == 'Ya' ? '✓' : '' }}</span> Ya
            </td>
            <td>
                <span class="checkbox{{ $data->sakit_dada == 'Tidak' ? '-checked' : '' }}">{{ $data->sakit_dada == 'Tidak' ? '✓' : '' }}</span> Tidak
            </td>
            <td></td>
        </tr>
        <tr>
            <td>Leher pendek</td>
            <td>
                <span class="checkbox{{ $data->leher_pendek == 'Ya' ? '-checked' : '' }}">{{ $data->leher_pendek == 'Ya' ? '✓' : '' }}</span> Ya
            </td>
            <td>
                <span class="checkbox{{ $data->leher_pendek == 'Tidak' ? '-checked' : '' }}">{{ $data->leher_pendek == 'Tidak' ? '✓' : '' }}</span> Tidak
            </td>
            <td>Stroke</td>
            <td>
                <span class="checkbox{{ $data->stroke == 'Ya' ? '-checked' : '' }}">{{ $data->stroke == 'Ya' ? '✓' : '' }}</span> Ya
            </td>
            <td>
                <span class="checkbox{{ $data->stroke == 'Tidak' ? '-checked' : '' }}">{{ $data->stroke == 'Tidak' ? '✓' : '' }}</span> Tidak
            </td>
            <td></td>
        </tr>
        <tr>
            <td>Denyut jantung tidak normal</td>
            <td>
                <span class="checkbox{{ $data->denyut_jantung == 'Ya' ? '-checked' : '' }}">{{ $data->denyut_jantung == 'Ya' ? '✓' : '' }}</span> Ya
            </td>
            <td>
                <span class="checkbox{{ $data->denyut_jantung == 'Tidak' ? '-checked' : '' }}">{{ $data->denyut_jantung == 'Tidak' ? '✓' : '' }}</span> Tidak
            </td>
            <td>Kejang</td>
            <td>
                <span class="checkbox{{ $data->kejang == 'Ya' ? '-checked' : '' }}">{{ $data->kejang == 'Ya' ? '✓' : '' }}</span> Ya
            </td>
            <td>
                <span class="checkbox{{ $data->kejang == 'Tidak' ? '-checked' : '' }}">{{ $data->kejang == 'Tidak' ? '✓' : '' }}</span> Tidak
            </td>
            <td></td>
        </tr>
        <tr>
            <td>Sesak napas</td>
            <td>
                <span class="checkbox{{ $data->sesak_napas == 'Ya' ? '-checked' : '' }}">{{ $data->sesak_napas == 'Ya' ? '✓' : '' }}</span> Ya
            </td>
            <td>
                <span class="checkbox{{ $data->sesak_napas == 'Tidak' ? '-checked' : '' }}">{{ $data->sesak_napas == 'Tidak' ? '✓' : '' }}</span> Tidak
            </td>
            <td>Sedang hamil</td>
            <td>
                <span class="checkbox{{ $data->sedang_hamil == 'Ya' ? '-checked' : '' }}">{{ $data->sedang_hamil == 'Ya' ? '✓' : '' }}</span> Ya
            </td>
            <td>
                <span class="checkbox{{ $data->sedang_hamil == 'Tidak' ? '-checked' : '' }}">{{ $data->sedang_hamil == 'Tidak' ? '✓' : '' }}</span> Tidak
            </td>
            <td></td>
        </tr>
    </table>
</div>

<!-- PEMERIKSAAN FISIK -->
<div class="section-title">PEMERIKSAAN FISIK</div>
<div class="form-row" style="padding: 5px;">
    <table class="no-border">
        <tr>
            <td width="10%">GCS :</td>
            <td width="15%"><span class="underline">{{ $data->gcs ?? '' }}</span></td>
            <td width="15%">Tekanan darah :</td>
            <td width="15%"><span class="underline">{{ $data->tekanan_darah ?? '' }}</span></td>
            <td width="10%">Nadi :</td>
            <td width="10%"><span class="underline">{{ $data->nadi ?? '' }}</span></td>
            <td width="10%">Suhu :</td>
            <td width="15%"><span class="underline">{{ $data->suhu ?? '' }}</span></td>
        </tr>
        <tr>
            <td>RR :</td>
            <td><span class="underline">{{ $data->rr ?? '' }}</span></td>
            <td>Tinggi :</td>
            <td><span class="underline">{{ $data->tinggi ?? '' }}</span></td>
            <td>Berat :</td>
            <td><span class="underline">{{ $data->berat ?? '' }}</span></td>
            <td>BMI :</td>
            <td><span class="underline">{{ $data->bmi ?? '' }}</span></td>
        </tr>
        <tr>
            <td>VAS :</td>
            <td colspan="7"><span class="underline">{{ $data->vas ?? '' }}</span></td>
        </tr>
    </table>
</div>

<div class="form-row" style="padding: 5px;">
    <table class="no-border">
        <tr>
            <td width="25%">Buka mulut > 2 jari</td>
            <td width="3%">
                <span class="checkbox{{ $data->buka_mulut == 'Y' ? '-checked' : '' }}">{{ $data->buka_mulut == 'Y' ? '✓' : '' }}</span> Y
            </td>
            <td width="3%">
                <span class="checkbox{{ $data->buka_mulut == 'T' ? '-checked' : '' }}">{{ $data->buka_mulut == 'T' ? '✓' : '' }}</span> T
            </td>
            <td width="20%">Gigi palsu</td>
            <td width="3%">
                <span class="checkbox{{ $data->gigi_palsu_dokter == 'Y' ? '-checked' : '' }}">{{ $data->gigi_palsu_dokter == 'Y' ? '✓' : '' }}</span> Y
            </td>
            <td width="3%">
                <span class="checkbox{{ $data->gigi_palsu_dokter == 'T' ? '-checked' : '' }}">{{ $data->gigi_palsu_dokter == 'T' ? '✓' : '' }}</span> T
            </td>
            <td width="43%"></td>
        </tr>
        <tr>
            <td>Jarak thyromental > 3 jari</td>
            <td>
                <span class="checkbox{{ $data->jarak_thyromental == 'Y' ? '-checked' : '' }}">{{ $data->jarak_thyromental == 'Y' ? '✓' : '' }}</span> Y
            </td>
            <td>
                <span class="checkbox{{ $data->jarak_thyromental == 'T' ? '-checked' : '' }}">{{ $data->jarak_thyromental == 'T' ? '✓' : '' }}</span> T
            </td>
            <td>Mallampati</td>
            <td colspan="3">
                <span class="checkbox{{ $data->mallampati == 'I' ? '-checked' : '' }}">{{ $data->mallampati == 'I' ? '✓' : '' }}</span> I
                <span class="checkbox{{ $data->mallampati == 'II' ? '-checked' : '' }}">{{ $data->mallampati == 'II' ? '✓' : '' }}</span> II
                <span class="checkbox{{ $data->mallampati == 'III' ? '-checked' : '' }}">{{ $data->mallampati == 'III' ? '✓' : '' }}</span> III
                <span class="checkbox{{ $data->mallampati == 'IV' ? '-checked' : '' }}">{{ $data->mallampati == 'IV' ? '✓' : '' }}</span> IV
            </td>
        </tr>
        <tr>
            <td>Gerakan leher maksimal</td>
            <td>
                <span class="checkbox{{ $data->gerakan_leher == 'Y' ? '-checked' : '' }}">{{ $data->gerakan_leher == 'Y' ? '✓' : '' }}</span> Y
            </td>
            <td>
                <span class="checkbox{{ $data->gerakan_leher == 'T' ? '-checked' : '' }}">{{ $data->gerakan_leher == 'T' ? '✓' : '' }}</span> T
            </td>
            <td colspan="4"></td>
        </tr>
    </table>
</div>

<!-- KEADAAN UMUM -->
<div class="section-title">KEADAAN UMUM</div>
<div class="form-row" style="padding: 5px;">
    <table class="no-border">
        <tr>
            <td width="15%">Kepala :</td>
            <td width="35%"><span class="dotted-line" style="width: 90%;">{{ $data->kepala ?? '' }}</span></td>
            <td width="15%">Sklera :</td>
            <td width="35%"><span class="dotted-line" style="width: 90%;">{{ $data->sklera ?? '' }}</span></td>
        </tr>
        <tr>
            <td>Conjugtiva :</td>
            <td><span class="dotted-line" style="width: 90%;">{{ $data->konjungtiva ?? '' }}</span></td>
            <td>Leher :</td>
            <td><span class="dotted-line" style="width: 90%;">{{ $data->leher ?? '' }}</span></td>
        </tr>
        <tr>
            <td>Jantung :</td>
            <td colspan="3"><span class="dotted-line" style="width: 95%;">{{ $data->jantung ?? '' }}</span></td>
        </tr>
        <tr>
            <td>Paru-paru :</td>
            <td colspan="3"><span class="dotted-line" style="width: 95%;">{{ $data->paru_paru ?? '' }}</span></td>
        </tr>
        <tr>
            <td>Abdomen :</td>
            <td colspan="3"><span class="dotted-line" style="width: 95%;">{{ $data->abdomen ?? '' }}</span></td>
        </tr>
        <tr>
            <td>Ekstremitas :</td>
            <td colspan="3"><span class="dotted-line" style="width: 95%;">{{ $data->ekstremitas ?? '' }}</span></td>
        </tr>
    </table>
</div>

<!-- LABORATORIUM -->
<div class="section-title">LABORATORIUM (bila tersedia)</div>
<div class="form-row" style="padding: 5px;">
    <table class="no-border">
        <tr>
            <td width="3%">
                <span class="checkbox{{ !empty($data->hb_ht_plt) ? '-checked' : '' }}">{{ !empty($data->hb_ht_plt) ? '✓' : '' }}</span>
            </td>
            <td width="20%">Hb/Ht/Plt :</td>
            <td width="27%"><span class="dotted-line" style="width: 90%;">{{ $data->hb_ht_plt ?? '' }}</span></td>
            <td width="3%">
                <span class="checkbox{{ !empty($data->sgot_sgpt) ? '-checked' : '' }}">{{ !empty($data->sgot_sgpt) ? '✓' : '' }}</span>
            </td>
            <td width="20%">SGOT/SGPT :</td>
            <td width="27%"><span class="dotted-line" style="width: 90%;">{{ $data->sgot_sgpt ?? '' }}</span></td>
        </tr>
        <tr>
            <td>
                <span class="checkbox{{ !empty($data->ppt_aptt) ? '-checked' : '' }}">{{ !empty($data->ppt_aptt) ? '✓' : '' }}</span>
            </td>
            <td>PPT/APTT :</td>
            <td><span class="dotted-line" style="width: 90%;">{{ $data->ppt_aptt ?? '' }}</span></td>
            <td>
                <span class="checkbox{{ !empty($data->glukosa_darah) ? '-checked' : '' }}">{{ !empty($data->glukosa_darah) ? '✓' : '' }}</span>
            </td>
            <td>Glukosa darah :</td>
            <td><span class="dotted-line" style="width: 90%;">{{ $data->glukosa_darah ?? '' }}</span></td>
        </tr>
        <tr>
            <td>
                <span class="checkbox{{ !empty($data->ekg) ? '-checked' : '' }}">{{ !empty($data->ekg) ? '✓' : '' }}</span>
            </td>
            <td>EKG (40 Tahun keatas) :</td>
            <td><span class="dotted-line" style="width: 90%;">{{ $data->ekg ?? '' }}</span></td>
            <td>
                <span class="checkbox{{ !empty($data->rontgen_dada) ? '-checked' : '' }}">{{ !empty($data->rontgen_dada) ? '✓' : '' }}</span>
            </td>
            <td>Rontgen dada :</td>
            <td><span class="dotted-line" style="width: 90%;">{{ $data->rontgen_dada ?? '' }}</span></td>
        </tr>
    </table>
</div>

<!-- DIAGNOSIS & ASA CLASSIFICATION -->
<div class="form-row" style="padding: 5px;">
    <table style="width: 100%; border: 1px solid black; border-collapse: collapse;">
        <tr>
            <td width="50%" style="border: 1px solid black; padding: 5px; vertical-align: top;">
                <div style="font-weight: bold; margin-bottom: 5px;">DIAGNOSIS (ICD X)</div>
                <div style="margin-bottom: 5px;">1. <span class="dotted-line" style="width: 85%;">{{ $data->diagnosis_1 ?? '' }}</span></div>
                <div style="margin-bottom: 5px; margin-left: 15px;"><span class="dotted-line" style="width: 90%;">{{ $data->diagnosis_1_lanjutan ?? '' }}</span></div>
                <div>2. <span class="dotted-line" style="width: 85%;">{{ $data->diagnosis_2 ?? '' }}</span></div>
            </td>
            <td width="50%" style="border: 1px solid black; padding: 5px; vertical-align: top;">
                <div style="font-weight: bold; margin-bottom: 5px;">ASA CLASSIFICATION</div>
                <table class="no-border">
                    <tr>
                        <td width="10%">
                            <span class="checkbox{{ $data->asa_classification == 'ASA 1' ? '-checked' : '' }}">{{ $data->asa_classification == 'ASA 1' ? '✓' : '' }}</span>
                        </td>
                        <td width="90%">ASA 1 Pasien normal yang sehat</td>
                    </tr>
                    <tr>
                        <td>
                            <span class="checkbox{{ $data->asa_classification == 'ASA 2' ? '-checked' : '' }}">{{ $data->asa_classification == 'ASA 2' ? '✓' : '' }}</span>
                        </td>
                        <td>ASA 2 Pasien dengan penyakit sistemik ringan</td>
                    </tr>
                    <tr>
                        <td>
                            <span class="checkbox{{ $data->asa_classification == 'ASA 3' ? '-checked' : '' }}">{{ $data->asa_classification == 'ASA 3' ? '✓' : '' }}</span>
                        </td>
                        <td>ASA 3 Pasien dengan penyakit sistemik berat</td>
                    </tr>
                    <tr>
                        <td>
                            <span class="checkbox{{ $data->asa_classification == 'ASA 4' ? '-checked' : '' }}">{{ $data->asa_classification == 'ASA 4' ? '✓' : '' }}</span>
                        </td>
                        <td>ASA 4 Pasien dengan penyakit sistemik berat yang mengancam nyawa</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>

<!-- PERENCANAAN ANESTESI -->
<div class="section-title">PERENCANAAN ANESTESI</div>
<div class="form-row" style="padding: 5px;">
    <div style="margin-bottom: 5px;"><strong>Teknik Anestesi dan Sedasi :</strong></div>
    <table class="no-border">
        <tr>
            <td width="3%">
                <span class="checkbox{{ $data->teknik_anestesi == 'Sedasi' ? '-checked' : '' }}">{{ $data->teknik_anestesi == 'Sedasi' ? '✓' : '' }}</span>
            </td>
            <td width="97%">Sedasi : <span class="dotted-line" style="width: 88%;">{{ $data->sedasi_detail ?? '' }}</span></td>
        </tr>
        <tr>
            <td>
                <span class="checkbox{{ $data->teknik_anestesi == 'GA' ? '-checked' : '' }}">{{ $data->teknik_anestesi == 'GA' ? '✓' : '' }}</span>
            </td>
            <td>GA : <span class="dotted-line" style="width: 91%;">{{ $data->ga_detail ?? '' }}</span></td>
        </tr>
        <tr>
            <td>
                <span class="checkbox{{ in_array('Regional', explode(',', $data->teknik_anestesi ?? '')) ? '-checked' : '' }}">{{ in_array('Regional', explode(',', $data->teknik_anestesi ?? '')) ? '✓' : '' }}</span>
            </td>
            <td>Regional : 
                <span class="checkbox{{ in_array('Spinal', explode(',', $data->regional_detail ?? '')) ? '-checked' : '' }}">{{ in_array('Spinal', explode(',', $data->regional_detail ?? '')) ? '✓' : '' }}</span> Spinal
                <span class="checkbox{{ in_array('Epidural', explode(',', $data->regional_detail ?? '')) ? '-checked' : '' }}">{{ in_array('Epidural', explode(',', $data->regional_detail ?? '')) ? '✓' : '' }}</span> Epidural
                <span class="checkbox{{ in_array('Kaudal', explode(',', $data->regional_detail ?? '')) ? '-checked' : '' }}">{{ in_array('Kaudal', explode(',', $data->regional_detail ?? '')) ? '✓' : '' }}</span> Kaudal
                <span class="checkbox{{ in_array('Blok Perifer', explode(',', $data->regional_detail ?? '')) ? '-checked' : '' }}">{{ in_array('Blok Perifer', explode(',', $data->regional_detail ?? '')) ? '✓' : '' }}</span> Blok Perifer
            </td>
        </tr>
    </table>
</div>

<div class="form-row" style="padding: 5px;">
    <div style="margin-bottom: 5px;"><strong>Monitoring :</strong></div>
    <table class="no-border">
        <tr>
            <td>
                <span class="checkbox{{ in_array('EKG', explode(',', $data->monitoring ?? '')) ? '-checked' : '' }}">{{ in_array('EKG', explode(',', $data->monitoring ?? '')) ? '✓' : '' }}</span> EKG
                <span class="checkbox{{ in_array('SpO2', explode(',', $data->monitoring ?? '')) ? '-checked' : '' }}">{{ in_array('SpO2', explode(',', $data->monitoring ?? '')) ? '✓' : '' }}</span> SpO2
                <span class="checkbox{{ in_array('NIBP', explode(',', $data->monitoring ?? '')) ?'-checked' : '' }}">{{ in_array('NIBP', explode(',', $data->monitoring ?? '')) ? '✓' : '' }}</span> NIBP
<span class="checkbox{{ in_array('Temp', explode(',', $data->monitoring ?? '')) ? '-checked' : '' }}">{{ in_array('Temp', explode(',', $data->monitoring ?? '')) ? '✓' : '' }}</span> Temp
<span class="checkbox{{ in_array('Lain-lain', explode(',', $data->monitoring ?? '')) ? '-checked' : '' }}">{{ in_array('Lain-lain', explode(',', $data->monitoring ?? '')) ? '✓' : '' }}</span> Lain-lain <span class="underline">{{ $data->monitoring_lainnya ?? '' }}</span>
</td>
</tr>
</table>
</div>

<div class="form-row" style="padding: 5px;">
    <div style="margin-bottom: 5px;"><strong>Perawatan pasca anestesi :</strong></div>
    <table class="no-border">
        <tr>
            <td>
                <span class="checkbox{{ $data->perawatan_pasca == 'Rawat inap' ? '-checked' : '' }}">{{ $data->perawatan_pasca == 'Rawat inap' ? '✓' : '' }}</span> Rawat inap
                <span class="checkbox{{ $data->perawatan_pasca == 'Rawat jalan' ? '-checked' : '' }}">{{ $data->perawatan_pasca == 'Rawat jalan' ? '✓' : '' }}</span> Rawat jalan
                <span class="checkbox{{ $data->perawatan_pasca == 'ICU' ? '-checked' : '' }}">{{ $data->perawatan_pasca == 'ICU' ? '✓' : '' }}</span> ICU
                <span class="checkbox{{ $data->perawatan_pasca == 'HDU' ? '-checked' : '' }}">{{ $data->perawatan_pasca == 'HDU' ? '✓' : '' }}</span> HDU
            </td>
        </tr>
    </table>
</div>

<!-- PERSIAPAN PRA ANESTESI -->
<div class="section-title">PERSIAPAN PRA ANESTESI</div>
<div class="form-row" style="padding: 5px;">
    <table class="no-border">
        <tr>
            <td width="20%">Puasa mulai :</td>
            <td width="30%">Jam <span class="underline">{{ $data->puasa_jam ?? '' }}</span></td>
            <td width="15%">Tanggal :</td>
            <td width="35%"><span class="underline">{{ $data->puasa_tanggal ?? '' }}</span></td>
        </tr>
        <tr>
            <td>Rencana Operasi :</td>
            <td>Jam <span class="underline">{{ $data->rencana_operasi_jam ?? '' }}</span></td>
            <td>Tanggal :</td>
            <td><span class="underline">{{ $data->rencana_operasi_tanggal ?? '' }}</span></td>
        </tr>
    </table>
</div>

<div class="form-row" style="padding: 5px;">
    <table class="no-border">
        <tr>
            <td width="15%">CATATAN :</td>
            <td width="85%"><span class="dotted-line" style="width: 95%;">{{ $data->catatan ?? '' }}</span></td>
        </tr>
    </table>
</div>

<!-- Signature Dokter Anestesi -->
<div style="margin-top: 30px;">
    <table style="width: 100%;">
        <tr>
            <td width="60%"></td>
            <td width="40%" style="text-align: center;">
                Dokter Anestesi
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align: center; padding-top: 10px; padding-bottom: 10px;">
                @if(!empty($data->ttd_dokter_anestesi))
                    <img src="{{ $data->ttd_dokter_anestesi }}" alt="TTD Dokter Anestesi" width="150px">
                @endif
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align: center; padding-bottom: 10px;">
                ( {{ $data->nama_dokter_anestesi ?? '..............................' }} )
            </td>
        </tr>
    </table>
</div>

