<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>REKAM MEDIS GENERAL - MONITORING EFEK SAMPING OBAT</title>
    <style>
    @page { margin: 18px; }

    body { margin: 18px; }
        .wrap {
            width: 100%;
            height: auto;
            display: inline-block;
        }


		.left { display: inline-block; float: left; }
		.right { display: inline-block; float: right;}

        .img-wrapper {
    position: relative;
    display: inline-block;
    text-align: center;
  }

  .img-wrapper img {
    display: block;
    max-width: 100%;
    height: auto;
  }
  .tablee {
    border: 1px solid black;
    border-collapse: collapse;
    text-align: center;
    padding: 5px;
  }

   .text-above {
    text-align: center;
    margin-bottom: 5px;
  }

    </style>

</head>
<body>
<div style="position:fixed; right: 13px; bottom: 10px;">
</div>
<?php $fullpath = storage_path('app/public/images/header_rme.png');  ?>
<div class="wrap">
	<div style="width:100%; text-align:right; margin-bottom:5px">
        {{ $data->no_surat ?? 'RM 3.8/MESO/' . config('app.tahun_akreditasi', '22') }}
	</div>
	@include('print-rekam-medis.partials.header')
    <!-- ================= ALERGI / REAKSI ================= -->
<table style="width:100%; border-left:1px solid black; border-right:1px solid black; border-bottom:1px solid black;" cellpadding="4" cellspacing="0">
    <tr>
        <td colspan="6" style="padding-left:8px; font-weight:bold;">
            ALERGI / REAKSI
        </td>
    </tr>

    <tr>
        <td style="width:3%; text-align:center;">
            {{ ($data->tidak_ada_alergi ?? false) ? '[X]' : '[ ]' }}
        </td>
        <td colspan="5">Tidak ada alergi</td>
    </tr>

    <tr>
        <td style="text-align:center;">
            {{ ($data->alergi_obat_check ?? false) ? '[X]' : '[ ]' }}
        </td>
        <td colspan="2">
            Alergi Obat, sebutkan :
            {{ $data->alergi_obat ?? '.............................' }}
        </td>
        <td colspan="3">
            Reaksi :
            {{ $data->alergi_obat_reaksi ?? '.............................' }}
        </td>
    </tr>

    <tr>
        <td style="text-align:center;">
            {{ ($data->alergi_makanan_check ?? false) ? '[X]' : '[ ]' }}
        </td>
        <td colspan="2">
            Alergi Makanan, sebutkan :
            {{ $data->alergi_makanan ?? '.............................' }}
        </td>
        <td colspan="3">
            Reaksi :
            {{ $data->alergi_makanan_reaksi ?? '.............................' }}
        </td>
    </tr>

    <tr>
        <td style="text-align:center;">
            {{ ($data->alergi_lainnya_check ?? false) ? '[X]' : '[ ]' }}
        </td>
        <td colspan="2">
            Alergi Lainnya, sebutkan :
            {{ $data->alergi_lainnya ?? '.............................' }}
        </td>
        <td colspan="3">
            Reaksi :
            {{ $data->alergi_lainnya_reaksi ?? '.............................' }}
        </td>
    </tr>

    <tr>
        <td colspan="6" style="padding-left:20px;">
            Diberitahukan ke Dokter / Apoteker / Ahli Gizi :
            Ya {{ ($data->diberitahu_alergi ?? '') == 'Ya' ? '[X]' : '[ ]' }}
            &nbsp;&nbsp;
            Tidak {{ ($data->diberitahu_alergi ?? '') == 'Tidak' ? '[X]' : '[ ]' }}
            &nbsp;&nbsp;
            Pukul :
            {{ $data->diberitahu_alergi_pukul ?? '......' }}
        </td>
    </tr>

    <tr>
        <td colspan="6" style="padding-left:20px;">
            Gelang tanda alergi dipasang (warna merah) :
            Ya {{ ($data->gelang_alergi ?? '') == 'Ya' ? '[X]' : '[ ]' }}
            &nbsp;&nbsp;
            Tidak {{ ($data->gelang_alergi ?? '') == 'Tidak' ? '[X]' : '[ ]' }}
        </td>
    </tr>

    <tr>
        <td style="text-align:center;">
            {{ ($data->tidak_diketahui ?? false) ? '[X]' : '[ ]' }}
        </td>
        <td colspan="5">Tidak Diketahui</td>
    </tr>
</table>
@php
    function cb($cond) {
        return $cond ? '[X]' : '[ ]';
    }
@endphp

<!-- KEADAAN UMUM & PEMERIKSAAN FISIK -->
<table style="width:100%; border-collapse:collapse; border:1px solid black;" cellpadding="3" cellspacing="0">

    <!-- HEADER -->
    <tr>
        <td colspan="3" style="border:1px solid black; text-align:center; font-weight:bold; background:#eee;">
            Keadaan Umum
        </td>
        <td colspan="4" style="border:1px solid black; text-align:center; font-weight:bold; background:#e9f0dc;">
            Pemeriksaan Fisik
        </td>
    </tr>

    <!-- Kesadaran -->
    <tr>
        <td style="border:1px solid black;">Kesadaran</td>
        <td colspan="2" style="border:1px solid black;">
            {{ $data->kesadaran ?? '................' }}
        </td>

        <td style="border:1px solid black;">Pernafasan</td>
        <td style="border:1px solid black;">{{ cb($data->pernafasan == 'Normal') }} Normal</td>
        <td style="border:1px solid black;">{{ cb($data->pernafasan == 'Batuk') }} Batuk</td>
        <td style="border:1px solid black;">{{ cb($data->pernafasan == 'Sesak') }} Sesak</td>
    </tr>

    <!-- GCS -->
    <tr>
        <td style="border:1px solid black;">GCS</td>
        <td colspan="2" style="border:1px solid black;">
            E {{ $data->gcs_e ?? '-' }} /
            V {{ $data->gcs_v ?? '-' }} /
            M {{ $data->gcs_m ?? '-' }}
        </td>

        <td style="border:1px solid black;">Penglihatan</td>
        <td style="border:1px solid black;">{{ cb($data->penglihatan == 'Baik') }} Baik</td>
        <td style="border:1px solid black;">{{ cb($data->penglihatan == 'Rusak') }} Rusak</td>
        <td style="border:1px solid black;">{{ cb($data->penglihatan == 'Alat Bantu') }} Alat Bantu</td>
    </tr>

    <!-- Tekanan Darah -->
    <tr>
        <td style="border:1px solid black;">Tekanan Darah</td>
        <td style="border:1px solid black;">
            {{ $data->tekanan_darah ?? '....' }}
        </td>
        <td style="border:1px solid black;">mmHg</td>

        <td style="border:1px solid black;">Pendengaran</td>
        <td style="border:1px solid black;">{{ cb($data->pendengaran == 'Baik') }} Baik</td>
        <td style="border:1px solid black;">{{ cb($data->pendengaran == 'Rusak') }} Rusak</td>
        <td style="border:1px solid black;">{{ cb($data->pendengaran == 'Alat Bantu') }} Alat Bantu</td>
    </tr>

    <!-- Pols -->
    <tr>
        <td style="border:1px solid black;">Pols</td>
        <td style="border:1px solid black;">
            {{ $data->pols ?? '....' }}
        </td>
        <td style="border:1px solid black;">x/menit</td>

        <td style="border:1px solid black;">Bicara</td>
        <td style="border:1px solid black;">{{ cb($data->bicara == 'Normal') }} Normal</td>
        <td style="border:1px solid black;">{{ cb($data->bicara == 'Gangguan') }} Gangguan</td>
        <td style="border:1px solid black;"></td>
    </tr>

    <!-- RR -->
    <tr>
        <td style="border:1px solid black;">RR</td>
        <td style="border:1px solid black;">
            {{ $data->rr ?? '....' }}
        </td>
        <td style="border:1px solid black;">x/menit</td>

        <td style="border:1px solid black;">Mulut</td>
        <td style="border:1px solid black;">{{ cb($data->mulut == 'Bersih') }} Bersih</td>
        <td style="border:1px solid black;">{{ cb($data->mulut == 'Kotor') }} Kotor</td>
        <td style="border:1px solid black;">{{ cb($data->mulut == 'Gigi Palsu') }} Gigi Palsu</td>
    </tr>

    <!-- SPO2 -->
    <tr>
        <td style="border:1px solid black;">SpO₂</td>
        <td style="border:1px solid black;">
            {{ $data->spo2 ?? '....' }}
        </td>
        <td style="border:1px solid black;">%</td>

        <td style="border:1px solid black;">Refleks Menelan</td>
        <td style="border:1px solid black;">{{ cb($data->refleks_menelan == 'Normal') }} Normal</td>
        <td style="border:1px solid black;">{{ cb($data->refleks_menelan == 'Sulit') }} Sulit</td>
        <td style="border:1px solid black;">{{ cb($data->refleks_menelan == 'Rusak') }} Rusak</td>
    </tr>

    <!-- Suhu -->
    <tr>
        <td style="border:1px solid black;">Suhu Tubuh</td>
        <td style="border:1px solid black;">
            {{ $data->suhu ?? '....' }}
        </td>
        <td style="border:1px solid black;">°C</td>

        <td style="border:1px solid black;">Gastrointestinal</td>
        <td style="border:1px solid black;">{{ cb($data->gastro == 'Normal') }} Normal</td>
        <td style="border:1px solid black;">{{ cb($data->gastro == 'Refluks') }} Refluks</td>
        <td style="border:1px solid black;">
            {{ cb($data->gastro == 'Nausea') }} Nausea
            {{ cb($data->gastro == 'Muntah') }} Muntah
        </td>
    </tr>

    <!-- Berat Badan -->
    <tr>
        <td style="border:1px solid black;">Berat Badan</td>
        <td style="border:1px solid black;">
            {{ $data->berat_badan ?? '....' }}
        </td>
        <td style="border:1px solid black;">Kg</td>

        <td style="border:1px solid black;">Defekasi</td>
        <td style="border:1px solid black;">{{ cb($data->defekasi == 'Normal') }} Normal</td>
        <td style="border:1px solid black;">{{ cb($data->defekasi == 'Retensio') }} Retensio</td>
        <td style="border:1px solid black;"></td>
    </tr>

    <!-- Tinggi Badan -->
    <tr>
        <td style="border:1px solid black;">Tinggi Badan</td>
        <td style="border:1px solid black;">
            {{ $data->tinggi_badan ?? '....' }}
        </td>
        <td style="border:1px solid black;">Cm</td>

        <td style="border:1px solid black;">Miksi</td>
        <td style="border:1px solid black;">{{ cb($data->miksi == 'Normal') }} Normal</td>
        <td style="border:1px solid black;">{{ cb($data->miksi == 'Retensio') }} Retensio</td>
        <td style="border:1px solid black;"></td>
    </tr>

    <!-- Lingkar Kepala -->
    <tr>
        <td style="border:1px solid black;">Lingkar Kepala</td>
        <td style="border:1px solid black;">
            {{ $data->lingkar_kepala ?? '....' }}
        </td>
        <td style="border:1px solid black;">Cm</td>

        <td style="border:1px solid black;">Pola Tidur</td>
        <td style="border:1px solid black;">{{ cb($data->pola_tidur == 'Normal') }} Normal</td>
        <td style="border:1px solid black;">{{ cb($data->pola_tidur == 'Insomnia') }} Insomnia</td>
        <td style="border:1px solid black;"></td>
    </tr>

    <!-- LILA -->
    <tr>
        <td style="border:1px solid black;">LiLA</td>
        <td style="border:1px solid black;">
            {{ $data->lila ?? '....' }}
        </td>
        <td style="border:1px solid black;">Cm</td>

        <td style="border:1px solid black;">Kulit</td>
        <td style="border:1px solid black;">{{ cb($data->kulit == 'Normal') }} Normal</td>
        <td colspan="2" style="border:1px solid black;">
            {{ cb($data->kulit == 'Luka') }} Luka
            @if($data->kulit == 'Luka')
                , Lokasi: {{ $data->kulit_lokasi }}
            @endif
        </td>
    </tr>

</table>
<!-- END KEADAAN UMUM & PEMERIKSAAN FISIK -->
<!-- ================= RIWAYAT PSIKOSOSIAL KULTURAL SPIRITUAL ================= -->
<table style="width:100%; border-collapse:collapse; border:1px solid black; margin-top:10px;" cellpadding="4" cellspacing="0">

    <!-- HEADER -->
    <tr>
        <td colspan="6" style="border:1px solid black; text-align:center; font-weight:bold; background:#d0e0f0; padding:8px;">
            RIWAYAT PSIKOSOSIAL KULTURAL SPIRITUAL
        </td>
    </tr>

    <!-- STATUS PSIKOLOGIS -->
    <tr>
        <td colspan="6" style="border:1px solid black; font-weight:bold; padding:6px;">
            Status Psikologis
        </td>
    </tr>
    <tr>
        <td colspan="6" style="border:1px solid black; padding:6px;">
            {{ cb($data->psikologis_cemas ?? false) }} Cemas
            &nbsp;&nbsp;&nbsp;
            {{ cb($data->psikologis_takut ?? false) }} Takut
            &nbsp;&nbsp;&nbsp;
            {{ cb($data->psikologis_marah ?? false) }} Marah
            &nbsp;&nbsp;&nbsp;
            {{ cb($data->psikologis_sedih ?? false) }} Sedih
            &nbsp;&nbsp;&nbsp;
            {{ cb($data->psikologis_bunuh_diri ?? false) }} Kecenderungan bunuh diri
        </td>
    </tr>
    <tr>
        <td colspan="6" style="border:1px solid black; padding:6px;">
            {{ cb(!empty($data->psikologis_lainnya)) }} Lain-lain, sebutkan
            {{ $data->psikologis_lainnya ?? '............................................................................' }}
        </td>
    </tr>

    <!-- STATUS SOSIAL -->
    <tr>
        <td colspan="6" style="border:1px solid black; font-weight:bold; padding:6px;">
            Status Sosial
        </td>
    </tr>
    <tr>
        <td colspan="6" style="border:1px solid black; padding:6px;">
            Hubungan pasien dengan anggota keluarga :
            {{ cb(($data->hubungan_keluarga ?? '') == 'Baik') }} Baik
            &nbsp;&nbsp;&nbsp;
            {{ cb(($data->hubungan_keluarga ?? '') == 'Tidak Baik') }} Tidak Baik
        </td>
    </tr>
    <tr>
        <td colspan="6" style="border:1px solid black; padding:6px;">
            Tempat tinggal : Rumah/Apartemen/Panti/Lainnya :
            {{ $data->tempat_tinggal ?? '............................................................................' }}
        </td>
    </tr>
    <tr>
        <td colspan="6" style="border:1px solid black; padding:6px;">
            Kerabat yang dapat dihubungi :
            Nama : {{ $data->kerabat_nama ?? '..................' }}
            &nbsp;&nbsp;
            Hubungan : {{ $data->kerabat_hubungan ?? '..................' }}
            &nbsp;&nbsp;
            Telepon : {{ $data->kerabat_telepon ?? '..................' }}
        </td>
    </tr>

    <!-- STATUS KULTURAL -->
    <tr>
        <td colspan="6" style="border:1px solid black; font-weight:bold; padding:6px;">
            Status Kultural
        </td>
    </tr>
    <tr>
        <td colspan="6" style="border:1px solid black; padding:6px;">
            Bahasa Sehari-hari :
            {{ cb(($data->bahasa_sehari ?? '') == 'Indonesia') }} Indonesia
            &nbsp;&nbsp;&nbsp;
            {{ cb(str_contains($data->bahasa_sehari ?? '', 'Daerah')) }} Daerah, sebutkan:
            {{ $data->bahasa_daerah_sebutkan ?? '..................' }}
            &nbsp;&nbsp;&nbsp;
            {{ cb(str_contains($data->bahasa_sehari ?? '', 'Inggris')) }} Inggris: aktif/pasif
        </td>
    </tr>
    <tr>
        <td colspan="6" style="border:1px solid black; padding:6px;">
            {{ cb(!empty($data->bahasa_sehari) && !in_array($data->bahasa_sehari, ['Indonesia', 'Daerah', 'Inggris'])) }}
            Lain-lain, sebutkan {{ $data->bahasa_sehari ?? '............................................................................' }}
        </td>
    </tr>
    <tr>
        <td colspan="6" style="border:1px solid black; padding:6px;">
            Perlu penterjemah :
            {{ cb(($data->perlu_penterjemah ?? '') == 'Ya') }} Ya, Bahasa {{ $data->penterjemah_bahasa ?? '.......................' }}
            &nbsp;&nbsp;&nbsp;
            {{ cb(($data->perlu_penterjemah ?? '') == 'Tidak') }} Tidak
        </td>
    </tr>

    <!-- STATUS SPIRITUAL -->
    <tr>
        <td colspan="6" style="border:1px solid black; font-weight:bold; padding:6px;">
            Status Spiritual
        </td>
    </tr>
    <tr>
        <td colspan="6" style="border:1px solid black; padding:6px; height:40px; vertical-align:top;">
            Nilai-nilai atau kepercayaan yang dianut
            {{ $data->spiritual_kepercayaan ?? '............................................................................' }}
            <br>
            ............................................................................................................................................................................................................
        </td>
    </tr>

</table>

<!-- ================= KHUSUS UNTUK WANITA ================= -->
@if(($data->jenis_kelamin ?? '') == 'Perempuan' || ($data->jenis_kelamin ?? '') == 'P')
<table style="width:100%; border-collapse:collapse; border:1px solid black; margin-top:10px;" cellpadding="4" cellspacing="0">

    <!-- HEADER -->
    <tr>
        <td colspan="4" style="border:1px solid black; text-align:center; font-weight:bold; background:#f0e0d0; padding:8px;">
            KHUSUS UNTUK WANITA
        </td>
    </tr>

    <!-- HAMIL -->
    <tr>
        <td style="border:1px solid black; width:20%; padding:6px;">
            Hamil :
        </td>
        <td colspan="3" style="border:1px solid black; padding:6px;">
            {{ cb(($data->hamil ?? '') == 'Ya') }} Ya, HPHT {{ $data->hpht ?? '.......................' }}
            &nbsp;&nbsp;&nbsp;&nbsp;
            {{ cb(($data->hamil ?? '') == 'Tidak') }} Tidak
        </td>
    </tr>

    <!-- KELUHAN MENSTRUASI -->
    <tr>
        <td style="border:1px solid black; padding:6px; vertical-align:top;">
            Keluhan Menstruasi :
        </td>
        <td colspan="3" style="border:1px solid black; padding:6px;">
            {{ $data->keluhan_menstruasi ?? '.............................................................................................................' }}
        </td>
    </tr>

</table>
@endif

<!-- ================= SKRINING RISIKO CEDERA/JATUH ================= -->
<table style="width:100%; border-collapse:collapse; border:1px solid black; margin-top:10px;" cellpadding="4" cellspacing="0">

    <!-- HEADER -->
    <tr>
        <td colspan="4" style="border:1px solid black; text-align:center; font-weight:bold; background:#ffe0d0; padding:8px;">
            SKRINING RISIKO CEDERA/JATUH
        </td>
    </tr>

    <!-- RISIKO CEDERA/JATUH -->
    <tr>
        <td style="border:1px solid black; padding:6px; width:20%; font-weight:bold; vertical-align:top;">
            Risiko Cedera/Jatuh
        </td>
        <td colspan="3" style="border:1px solid black; padding:6px;">
            {{ cb(($data->risiko_jatuh ?? '') == 'Ya') }} Ya, maka lakukan pemasangan :
            &nbsp;&nbsp;&nbsp;&nbsp;
            {{ cb(($data->risiko_jatuh ?? '') == 'Tidak') }} Tidak

            <br><br>

            <div style="margin-left: 30px;">
                {{ cb(($data->pemasangan_gelang ?? false)) }} Gelang risiko jatuh
                <br>
                {{ cb(($data->pemasangan_segitiga ?? false)) }} Segitiga risiko jatuh
            </div>
        </td>
    </tr>

    <!-- DIBERITAHUKAN KE DOKTER -->
    <tr>
        <td style="border:1px solid black; padding:6px; font-weight:bold;">
            Diberitahukan ke dokter
        </td>
        <td colspan="3" style="border:1px solid black; padding:6px;">
            {{ cb(($data->risiko_jatuh_dokter ?? '') == 'Ya') }} Ya, pukul : {{ $data->risiko_jatuh_dokter_pukul ?? '......' }}
            &nbsp;&nbsp;&nbsp;&nbsp;
            {{ cb(($data->risiko_jatuh_dokter ?? '') == 'Tidak') }} Tidak
        </td>
    </tr>

</table>

<!-- ================= PENILAIAN RISIKO DEKUBITUS (SKALA NORTON) ================= -->
<table style="width:100%; border-collapse:collapse; border:1px solid black; margin-top:10px;" cellpadding="4" cellspacing="0">

    <!-- HEADER -->
    <tr>
        <td colspan="5" style="border:1px solid black; text-align:center; font-weight:bold; background:#e0f0e0; padding:8px;">
            PENILAIAN RISIKO DEKUBITUS (SKALA NORTON)
        </td>
    </tr>

    <!-- TABLE HEADER -->
    <tr style="background:#f5f5f5;">
        <th style="border:1px solid black; padding:6px; text-align:center; width:20%;">Yang Dinilai</th>
        <th style="border:1px solid black; padding:6px; text-align:center; width:20%;">4</th>
        <th style="border:1px solid black; padding:6px; text-align:center; width:20%;">3</th>
        <th style="border:1px solid black; padding:6px; text-align:center; width:20%;">2</th>
        <th style="border:1px solid black; padding:6px; text-align:center; width:20%;">1</th>
    </tr>

    <!-- KELUHAN FISIK -->
    <tr>
        <td style="border:1px solid black; padding:6px;">Keluhan Fisik</td>
        <td style="border:1px solid black; padding:6px; text-align:center;">
            {{ cb(($data->norton_fisik ?? '') == '4') }} Baik
        </td>
        <td style="border:1px solid black; padding:6px; text-align:center;">
            {{ cb(($data->norton_fisik ?? '') == '3') }} Sedang
        </td>
        <td style="border:1px solid black; padding:6px; text-align:center;">
            {{ cb(($data->norton_fisik ?? '') == '2') }} Buruk
        </td>
        <td style="border:1px solid black; padding:6px;">
            {{ cb(($data->norton_fisik ?? '') == '1') }} Sangat buruk
        </td>
    </tr>

    <!-- STATUS MENTAL -->
    <tr>
        <td style="border:1px solid black; padding:6px;">Status Mental</td>
        <td style="border:1px solid black; padding:6px; text-align:center;">
            {{ cb(($data->norton_mental ?? '') == '4') }} Sadar
        </td>
        <td style="border:1px solid black; padding:6px; text-align:center;">
            {{ cb(($data->norton_mental ?? '') == '3') }} Apatis
        </td>
        <td style="border:1px solid black; padding:6px; text-align:center;">
            {{ cb(($data->norton_mental ?? '') == '2') }} Bingung
        </td>
        <td style="border:1px solid black; padding:6px;">
            {{ cb(($data->norton_mental ?? '') == '1') }} Stupor
        </td>
    </tr>

    <!-- AKTIVITAS -->
    <tr>
        <td style="border:1px solid black; padding:6px;">Aktivitas</td>
        <td style="border:1px solid black; padding:6px; text-align:center;">
            {{ cb(($data->norton_aktivitas ?? '') == '4') }} Jalan sendiri
        </td>
        <td style="border:1px solid black; padding:6px; text-align:center;">
            {{ cb(($data->norton_aktivitas ?? '') == '3') }} Dengan bantuan
        </td>
        <td style="border:1px solid black; padding:6px; text-align:center;">
            {{ cb(($data->norton_aktivitas ?? '') == '2') }} Kursi roda
        </td>
        <td style="border:1px solid black; padding:6px;">
            {{ cb(($data->norton_aktivitas ?? '') == '1') }} Di tempat tidur
        </td>
    </tr>

    <!-- MOBILITAS -->
    <tr>
        <td style="border:1px solid black; padding:6px;">Mobilitas</td>
        <td style="border:1px solid black; padding:6px; text-align:center;">
            {{ cb(($data->norton_mobilitas ?? '') == '4') }} Bebas bergerak
        </td>
        <td style="border:1px solid black; padding:6px; text-align:center;">
            {{ cb(($data->norton_mobilitas ?? '') == '3') }} Gerak terbatas
        </td>
        <td style="border:1px solid black; padding:6px; text-align:center;">
            {{ cb(($data->norton_mobilitas ?? '') == '2') }} Sangat terbatas
        </td>
        <td style="border:1px solid black; padding:6px;">
            {{ cb(($data->norton_mobilitas ?? '') == '1') }} Tidak bergerak
        </td>
    </tr>

    <!-- INKONTINENSIA -->
    <tr>
        <td style="border:1px solid black; padding:6px;">Inkontinensia</td>
        <td style="border:1px solid black; padding:6px; text-align:center;">
            {{ cb(($data->norton_inkontinensia ?? '') == '4') }} Kontinen
        </td>
        <td style="border:1px solid black; padding:6px; text-align:center;">
            {{ cb(($data->norton_inkontinensia ?? '') == '3') }} Kadang inkontinen
        </td>
        <td style="border:1px solid black; padding:6px; text-align:center;">
            {{ cb(($data->norton_inkontinensia ?? '') == '2') }} Selalu inkontinen
        </td>
        <td style="border:1px solid black; padding:6px;">
            {{ cb(($data->norton_inkontinensia ?? '') == '1') }} Inkontinen urin & alvi
        </td>
    </tr>

    <!-- TOTAL SKOR -->
    @php
        $nortonTotal =
            (int)($data->norton_fisik ?? 0) +
            (int)($data->norton_mental ?? 0) +
            (int)($data->norton_aktivitas ?? 0) +
            (int)($data->norton_mobilitas ?? 0) +
            (int)($data->norton_inkontinensia ?? 0);

        // Tentukan kategori risiko
        $nortonKategori = '';
        if ($nortonTotal >= 16 && $nortonTotal <= 20) {
            $nortonKategori = '16-20 : Tidak ada risiko';
        } elseif ($nortonTotal >= 12 && $nortonTotal <= 15) {
            $nortonKategori = '12-15 : Risiko Sedang';
        } elseif ($nortonTotal > 0 && $nortonTotal < 12) {
            $nortonKategori = '<12 : Risiko Tinggi';
        }
    @endphp

    <tr style="background:#ffffcc;">
        <td colspan="5" style="border:1px solid black; padding:8px; font-weight:bold;">
            Jumlah Skor : {{ $nortonTotal }}
            &nbsp;&nbsp;&nbsp;&nbsp;
            {{ $nortonKategori }}
        </td>
    </tr>

</table>


<!-- ================= PENILAIAN SKALA NYERI ================= -->
<table style="width:100%; border-collapse:collapse; border:1px solid black; margin-top:10px;" cellpadding="4" cellspacing="0">
    <!-- HEADER -->
    <tr>
        <td colspan="6" style="border:1px solid black; text-align:center; font-weight:bold; background:#ffe0f0; padding:8px;">
            PENILAIAN SKALA NYERI
        </td>
    </tr>

    <!-- KELUHAN NYERI -->
    <tr>
        <td style="border:1px solid black; padding:6px; width:20%; font-weight:bold;">
            Keluhan Nyeri
        </td>
        <td colspan="5" style="border:1px solid black; padding:6px;">
            {{ cb(($data->keluhan_nyeri ?? '') == 'Ada') }} Ada, Skala nyeri
            <strong>{{ $data->skala_nyeri ?? '......' }}</strong>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            {{ cb(($data->keluhan_nyeri ?? '') == 'Tidak ada') }} Tidak ada
        </td>
    </tr>

    @if(($data->keluhan_nyeri ?? '') == 'Ada')
    @php
        $skalaNyeri = (int)($data->skala_nyeri ?? 0);
        $skalaNyeri = max(0, min(10, $skalaNyeri));

        function getWarnaBox($nilai, $nilaiAktif) {
            if ($nilai == $nilaiAktif) {
                return 'background: #FFD700; font-weight: bold; font-size: 14pt; border: 3px solid #FF6B00;';
            } elseif ($nilai <= 3) {
                return 'background: #C8E6C9;';
            } elseif ($nilai <= 6) {
                return 'background: #FFE082;';
            } else {
                return 'background: #EF9A9A;';
            }
        }
    @endphp

    <!-- GAMBAR TUBUH & SKALA NYERI -->
    <tr>
        <td colspan="6" style="border: solid black; padding:15px;">
            <table style="width:100%; border:none;">
                <tr>
                    <!-- Kolom Kiri: Gambar Lokasi Nyeri -->
                    <td colspan="6" style=" padding:15px;">
        <table style="width:100%; border:none;">
            <tr>
                <!-- Kolom Kiri: Gambar Lokasi Nyeri -->
                <td style="width:40%; text-align:center; vertical-align:top; padding-right:15px; #ddd;">
                    <div style="font-weight:bold; margin-bottom:10px; font-size:12pt;">GAMBAR LOKASI NYERI</div>

                    @php
                        $hasGambar = false;
                        $imgSrc = '';

                        if(!empty($data->nyeri_gambar) && $data->nyeri_gambar != 'null' && $data->nyeri_gambar != 'undefined') {
                            $imageData = $data->nyeri_gambar;
                            $hasGambar = true;

                            if (strpos($imageData, 'data:image') === 0) {
                                $imgSrc = $imageData;
                            } elseif (preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', trim($imageData))) {
                                $imgSrc = 'data:image/png;base64,' . $imageData;
                            } else {
                                $imgSrc = $imageData;
                            }
                        }
                    @endphp

                    @if($hasGambar && !empty($imgSrc))
                        <img src="{{ $imgSrc }}" style="max-width:200px; max-height:350px;  #ccc; margin:5px auto; display:block;" />
                    @else
                        <img src="{{ public_path('images/body_diagram.svg') }}" style="max-width:200px; max-height:350px;  #ccc; margin:5px auto; display:block; border-radius:5px;" />
                    @endif

                    <div style="margin-top:8px; font-size:9px; color:#666;">
                        (Pasien menandai lokasi nyeri pada gambar tubuh)
                    </div>
                </td>

                <!-- Kolom Kanan: Skala Nyeri -->
                <td style="width:60%; vertical-align:top; padding-left:15px;">
                    <!-- ... sisa kode skala nyeri ... -->
                </td>
            </tr>
        </table>
    </td>

                    <!-- Kolom Kanan: Skala Nyeri -->
                    <td style="width:60%; vertical-align:top; padding-left:15px;">
                        <div style="font-weight:bold; text-align:center; margin-bottom:15px; font-size:13pt;">
                            BERAPAKAH SKALA NYERI ANDA?
                        </div>

                        <!-- Face Scale Row -->
                        <table style="width:100%; border:none; margin-bottom:15px;">
                            <tr>
                                <!-- Face 0 (Tidak Nyeri) -->
                                <td style="text-align:center; width:16.6%; padding:8px 3px; {{ $skalaNyeri == 0 ? 'border:3px solid #4CAF50; background:#A5D6A7; border-radius:8px;' : 'border:1px solid #ddd; border-radius:8px; opacity:0.5;' }}">
                                    <div style="margin-bottom:3px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="40" height="40">
                                            <circle cx="50" cy="50" r="45" fill="#4CAF50" stroke="#2E7D32" stroke-width="2"/>
                                            <circle cx="35" cy="40" r="5" fill="#2E7D32"/>
                                            <circle cx="65" cy="40" r="5" fill="#2E7D32"/>
                                            <path d="M30 60 Q50 80 70 60" fill="none" stroke="#2E7D32" stroke-width="3" stroke-linecap="round"/>
                                        </svg>
                                    </div>
                                    <div style="font-size:8px; {{ $skalaNyeri == 0 ? 'font-weight:bold;' : '' }}">Tidak nyeri</div>
                                </td>

                                <!-- Face 1-2 (Nyeri Ringan) -->
                                <td style="text-align:center; width:16.6%; padding:8px 3px; {{ $skalaNyeri >= 1 && $skalaNyeri <= 2 ? 'border:3px solid #8BC34A; background:#C5E1A5; border-radius:8px;' : 'border:1px solid #ddd; border-radius:8px; opacity:0.5;' }}">
                                    <div style="margin-bottom:3px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="40" height="40">
                                            <circle cx="50" cy="50" r="45" fill="#8BC34A" stroke="#558B2F" stroke-width="2"/>
                                            <circle cx="35" cy="42" r="5" fill="#558B2F"/>
                                            <circle cx="65" cy="42" r="5" fill="#558B2F"/>
                                            <path d="M30 62 Q50 75 70 62" fill="none" stroke="#558B2F" stroke-width="3" stroke-linecap="round"/>
                                        </svg>
                                    </div>
                                    <div style="font-size:8px; {{ $skalaNyeri >= 1 && $skalaNyeri <= 2 ? 'font-weight:bold;' : '' }}">Nyeri ringan</div>
                                </td>

                                <!-- Face 3-4 (Nyeri Sedang) -->
                                <td style="text-align:center; width:16.6%; padding:8px 3px; {{ $skalaNyeri >= 3 && $skalaNyeri <= 4 ? 'border:3px solid #FFC107; background:#FFE082; border-radius:8px;' : 'border:1px solid #ddd; border-radius:8px; opacity:0.5;' }}">
                                    <div style="margin-bottom:3px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="40" height="40">
                                            <circle cx="50" cy="50" r="45" fill="#FFC107" stroke="#F57F17" stroke-width="2"/>
                                            <circle cx="35" cy="40" r="5" fill="#F57F17"/>
                                            <circle cx="65" cy="40" r="5" fill="#F57F17"/>
                                            <line x1="30" y1="65" x2="70" y2="65" stroke="#F57F17" stroke-width="3" stroke-linecap="round"/>
                                        </svg>
                                    </div>
                                    <div style="font-size:8px; {{ $skalaNyeri >= 3 && $skalaNyeri <= 4 ? 'font-weight:bold;' : '' }}">Nyeri sedang</div>
                                </td>

                                <!-- Face 5-6 (Nyeri Berat) -->
                                <td style="text-align:center; width:16.6%; padding:8px 3px; {{ $skalaNyeri >= 5 && $skalaNyeri <= 6 ? 'border:3px solid #FF9800; background:#FFCC80; border-radius:8px;' : 'border:1px solid #ddd; border-radius:8px; opacity:0.5;' }}">
                                    <div style="margin-bottom:3px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="40" height="40">
                                            <circle cx="50" cy="50" r="45" fill="#FF9800" stroke="#E65100" stroke-width="2"/>
                                            <circle cx="35" cy="42" r="5" fill="#E65100"/>
                                            <circle cx="65" cy="42" r="5" fill="#E65100"/>
                                            <path d="M30 72 Q50 55 70 72" fill="none" stroke="#E65100" stroke-width="3" stroke-linecap="round"/>
                                        </svg>
                                    </div>
                                    <div style="font-size:8px; {{ $skalaNyeri >= 5 && $skalaNyeri <= 6 ? 'font-weight:bold;' : '' }}">Nyeri berat</div>
                                </td>

                                <!-- Face 7-8 (Nyeri Sangat Berat) -->
                                <td style="text-align:center; width:16.6%; padding:8px 3px; {{ $skalaNyeri >= 7 && $skalaNyeri <= 8 ? 'border:3px solid #F44336; background:#EF9A9A; border-radius:8px;' : 'border:1px solid #ddd; border-radius:8px; opacity:0.5;' }}">
                                    <div style="margin-bottom:3px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="40" height="40">
                                            <circle cx="50" cy="50" r="45" fill="#F44336" stroke="#C62828" stroke-width="2"/>
                                            <circle cx="35" cy="42" r="5" fill="#C62828"/>
                                            <circle cx="65" cy="42" r="5" fill="#C62828"/>
                                            <path d="M30 76 Q50 58 70 76" fill="none" stroke="#C62828" stroke-width="3" stroke-linecap="round"/>
                                            <path d="M25 35 Q20 20 15 35" fill="none" stroke="#1565C0" stroke-width="2" stroke-linecap="round"/>
                                            <path d="M75 35 Q70 20 65 35" fill="none" stroke="#1565C0" stroke-width="2" stroke-linecap="round"/>
                                        </svg>
                                    </div>
                                    <div style="font-size:8px; {{ $skalaNyeri >= 7 && $skalaNyeri <= 8 ? 'font-weight:bold;' : '' }}">Sangat berat</div>
                                </td>

                                <!-- Face 9-10 (Nyeri Tak Tertahankan) -->
                                <td style="text-align:center; width:16.6%; padding:8px 3px; {{ $skalaNyeri >= 9 && $skalaNyeri <= 10 ? 'border:3px solid #B71C1C; background:#FF5252; border-radius:8px;' : 'border:1px solid #ddd; border-radius:8px; opacity:0.5;' }}">
                                    <div style="margin-bottom:3px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="40" height="40">
                                            <circle cx="50" cy="50" r="45" fill="#B71C1C" stroke="#7F0000" stroke-width="2"/>
                                            <circle cx="35" cy="40" r="5" fill="#7F0000"/>
                                            <circle cx="65" cy="40" r="5" fill="#7F0000"/>
                                            <path d="M28 80 Q50 55 72 80" fill="none" stroke="#7F0000" stroke-width="3" stroke-linecap="round"/>
                                            <path d="M22 35 Q15 15 10 35" fill="none" stroke="#1565C0" stroke-width="2.5" stroke-linecap="round"/>
                                            <path d="M78 35 Q71 15 66 35" fill="none" stroke="#1565C0" stroke-width="2.5" stroke-linecap="round"/>
                                            <line x1="40" y1="55" x2="36" y2="68" stroke="#1565C0" stroke-width="2" stroke-linecap="round"/>
                                            <line x1="60" y1="55" x2="64" y2="68" stroke="#1565C0" stroke-width="2" stroke-linecap="round"/>
                                        </svg>
                                    </div>
                                    <div style="font-size:8px; {{ $skalaNyeri >= 9 && $skalaNyeri <= 10 ? 'font-weight:bold;' : '' }}">Tak tertahankan</div>
                                </td>
                            </tr>
                        </table>

                        <!-- Number Scale dengan Warna -->
                        <table style="width:100%; border:none; margin-bottom:10px; border-collapse:collapse;">
                            <tr>
                                @for($i = 0; $i <= 9; $i++)
                                <td style="text-align:center; border:1px solid black; padding:8px 5px; width:10%;
                                    {{ getWarnaBox($i, $skalaNyeri) }}">
                                    {{ $i }}
                                </td>
                                @endfor
                            </tr>
                        </table>

                        <!-- Gradient Bar -->
                        <div style="width:100%; height:20px; background:linear-gradient(to right, #4CAF50, #8BC34A, #FFEB3B, #FF9800, #F44336, #B71C1C); margin:10px 0; border-radius:5px;"></div>

                        <!-- Labels -->
                        <table style="width:100%; border:none;">
                            <tr>
                                <td style="text-align:left; font-size:11px; font-weight:bold;">Tidak nyeri</td>
                                <td style="text-align:center; font-size:11px; font-weight:bold;">Nyeri sedang</td>
                                <td style="text-align:right; font-size:11px; font-weight:bold;">Nyeri hebat</td>
                            </tr>
                        </table>

                        <!-- Selected Score Box -->
                        <div style="margin-top:15px; padding:10px; background:#FFF8E1; border:2px solid #FFC107; border-radius:5px; text-align:center;">
                            <span style="font-size:11pt;">Skala Nyeri Terpilih: </span>
                            <span style="font-size:13pt; font-weight:bold; background:#FFD700; padding:3px 10px; border-radius:3px;">
                                {{ $skalaNyeri }}
                            </span>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- LOKASI -->
    <tr>
        <td style="border:1px solid black; padding:6px; font-weight:bold; width:20%;">
            Lokasi
        </td>
        <td colspan="5" style="border:1px solid black; padding:6px;">
            {{ $data->nyeri_lokasi ?? '................................................' }}
        </td>
    </tr>

    <!-- NYERI MENJALAR & ONSET -->
    <tr>
        <td style="border:1px solid black; padding:6px; font-weight:bold;">
            Nyeri berpindah/menjalar
        </td>
        <td style="border:1px solid black; padding:6px; width:25%;">
            {{ cb(($data->nyeri_menjalar ?? '') == 'Ada') }} Ada, ke: {{ $data->nyeri_menjalar_ke ?? '......' }}
            &nbsp;&nbsp;
            {{ cb(($data->nyeri_menjalar ?? '') == 'Tidak ada') }} Tidak ada
        </td>
        <td style="border:1px solid black; padding:6px; font-weight:bold; width:15%;">
            Onset nyeri
        </td>
        <td colspan="3" style="border:1px solid black; padding:6px;">
            {{ cb(($data->onset_nyeri ?? '') == 'Akut') }} &lt; 3 bulan = Akut
            &nbsp;&nbsp;&nbsp;&nbsp;
            {{ cb(($data->onset_nyeri ?? '') == 'Kronik') }} &gt; 3 bulan = Kronik
        </td>
    </tr>

    <!-- RASA NYERI -->
    <tr>
        <td style="border:1px solid black; padding:6px; font-weight:bold; vertical-align:top;">
            Rasa Nyeri
        </td>
        <td colspan="5" style="border:1px solid black; padding:6px;">
            <table style="width:100%; border:none;">
                <tr>
                    <td style="border:none; padding:3px;">{{ cb($data->nyeri_seperti_ditusuk ?? false) }} Seperti ditusuk</td>
                    <td style="border:none; padding:3px;">{{ cb($data->nyeri_seperti_ditikam ?? false) }} Seperti ditikam</td>
                    <td style="border:none; padding:3px;">{{ cb($data->nyeri_berdenyut ?? false) }} Seperti berdenyut</td>
                </tr>
                <tr>
                    <td style="border:none; padding:3px;">{{ cb($data->nyeri_seperti_dipukul ?? false) }} Seperti dipukul</td>
                    <td style="border:none; padding:3px;">{{ cb($data->nyeri_seperti_kram ?? false) }} Seperti kram</td>
                    <td style="border:none; padding:3px;">{{ cb($data->nyeri_seperti_dibakar ?? false) }} Seperti dibakar</td>
                </tr>
                <tr>
                    <td style="border:none; padding:3px;">{{ cb($data->nyeri_tajam ?? false) }} Nyeri tajam</td>
                    <td style="border:none; padding:3px;">{{ cb($data->nyeri_tumpul ?? false) }} Nyeri tumpul</td>
                    <td style="border:none; padding:3px;">{{ cb($data->nyeri_seperti_ditarik ?? false) }} Seperti ditarik</td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- FREKUENSI & LAMA NYERI -->
    <tr>
        <td style="border:1px solid black; padding:6px; font-weight:bold;">
            Frekuensi nyeri
        </td>
        <td style="border:1px solid black; padding:6px;">
            {{ cb(($data->frekuensi_nyeri ?? '') == '1-2 jam') }} 1-2 jam
            &nbsp;&nbsp;
            {{ cb(($data->frekuensi_nyeri ?? '') == '3-4 jam') }} 3-4 jam
            &nbsp;&nbsp;
            {{ cb(($data->frekuensi_nyeri ?? '') == '>4 jam') }} &gt;4 jam
        </td>
        <td style="border:1px solid black; padding:6px; font-weight:bold;">
            Lama nyeri
        </td>
        <td colspan="3" style="border:1px solid black; padding:6px;">
            {{ cb(($data->lama_nyeri ?? '') == '<30 menit') }} &lt;30 menit
            &nbsp;&nbsp;
            {{ cb(($data->lama_nyeri ?? '') == '30-60 menit') }} 30-60 menit
            &nbsp;&nbsp;
            {{ cb(($data->lama_nyeri ?? '') == '>60 menit') }} &gt;60 menit
        </td>
    </tr>

    <!-- NYERI MEMBURUK & BERKURANG -->
    <tr>
        <td style="border:1px solid black; padding:6px; font-weight:bold;">
            Nyeri memburuk bila
        </td>
        <td style="border:1px solid black; padding:6px;">
            {{ $data->nyeri_memburuk ?? '......' }}
        </td>
        <td style="border:1px solid black; padding:6px; font-weight:bold;">
            Nyeri berkurang bila
        </td>
        <td colspan="3" style="border:1px solid black; padding:6px;">
            {{ $data->nyeri_berkurang ?? '......' }}
        </td>
    </tr>

    @else
    <!-- Keterangan jika tidak ada keluhan nyeri -->
    <tr>
        <td colspan="6" style="border:1px solid black; padding:15px; text-align:center; color:#666;">
            <em>Tidak ada keluhan nyeri</em>
        </td>
    </tr>
    @endif
</table>
<!-- ================= SKRINING GIZI (MST) ================= -->
<table style="width:100%; border-collapse:collapse; border:1px solid black; margin-top:10px;" cellpadding="4" cellspacing="0">

    <!-- HEADER -->
    <tr>
        <td colspan="3" style="border:1px solid black; text-align:center; font-weight:bold; background:#fff0d0; padding:8px;">
            SKRINING GIZI
        </td>
    </tr>

    <!-- TABLE HEADER -->
    <tr style="background:#f5f5f5;">
        <th style="border:1px solid black; padding:6px; text-align:center; width:10%;">No</th>
        <th style="border:1px solid black; padding:6px;">Parameter (berdasarkan MST)</th>
        <th style="border:1px solid black; padding:6px; text-align:center; width:15%;">Skor</th>
    </tr>

    <!-- PARAMETER 1 -->
    <tr>
        <td style="border:1px solid black; padding:6px; text-align:center; vertical-align:top;">1</td>
        <td style="border:1px solid black; padding:6px; vertical-align:top;">
            Apakah pasien mengalami penurunan BB yang tidak diinginkan dalam 3 bulan terakhir?
            <br><br>
            0 = tidak ada penurunan BB<br>
            1 = penurunan 1-5 kg<br>
            2 = penurunan 6-10 kg<br>
            3 = penurunan 11-15 kg<br>
            4 = penurunan &gt;15 kg
        </td>
        <td style="border:1px solid black; padding:6px; text-align:center; vertical-align:top;">
            {{ cb(($data->gizi_penurunan_bb ?? '') == '0') }} 0<br>
            {{ cb(($data->gizi_penurunan_bb ?? '') == '1') }} 1<br>
            {{ cb(($data->gizi_penurunan_bb ?? '') == '2') }} 2<br>
            {{ cb(($data->gizi_penurunan_bb ?? '') == '3') }} 3<br>
            {{ cb(($data->gizi_penurunan_bb ?? '') == '4') }} 4
        </td>
    </tr>

    <!-- PARAMETER 2 -->
    <tr>
        <td style="border:1px solid black; padding:6px; text-align:center; vertical-align:top;">2</td>
        <td style="border:1px solid black; padding:6px; vertical-align:top;">
            Apakah asupan makanan berkurang karena tidak nafsu makan?
            <br><br>
            0 = Tidak<br>
            1 = Ya
        </td>
        <td style="border:1px solid black; padding:6px; text-align:center; vertical-align:top;">
            {{ cb(($data->gizi_asupan_makanan ?? '') == '0') }} 0<br>
            {{ cb(($data->gizi_asupan_makanan ?? '') == '1') }} 1
        </td>
    </tr>

    <!-- TOTAL SKOR & INTERPRETASI -->
    @php
        $giziTotal = (int)($data->gizi_penurunan_bb ?? 0) + (int)($data->gizi_asupan_makanan ?? 0);
    @endphp

    <tr style="background:#ffffcc;">
        <td colspan="3" style="border:1px solid black; padding:8px;">
            <strong>Total Skor : {{ $giziTotal }}</strong>
            <br>
            @if($giziTotal > 2)
            <span style="color:red; font-weight:bold;">
                (Bila skor &gt;2 dan/atau pasien dengan penyakit yang berat dilakukan pengkajian lanjutan oleh ahli gizi)
            </span>
            @endif
        </td>
    </tr>

    @if($giziTotal > 2)
    <!-- SUDAH DIBACA AHLI GIZI -->
    <tr>
        <td colspan="3" style="border:1px solid black; padding:6px;">
            Sudah dibaca dan diketahui ahli gizi :
            {{ cb(($data->gizi_ke_ahli ?? '') == 'Ya') }} Ya, pukul {{ $data->gizi_ke_ahli_pukul ?? '...........' }}
            &nbsp;&nbsp;&nbsp;&nbsp;
            {{ cb(($data->gizi_ke_ahli ?? '') == 'Tidak') }} Tidak
        </td>
    </tr>
    @endif

</table>

<!-- ================= STATUS FUNGSIONAL/TINGKAT KETERGANTUNGAN ================= -->
<table style="width:100%; border-collapse:collapse; border:1px solid black; margin-top:10px;" cellpadding="4" cellspacing="0">

    <!-- HEADER -->
    <tr>
        <td colspan="2" style="border:1px solid black; text-align:center; font-weight:bold; background:#e0e0ff; padding:8px;">
            STATUS FUNGSIONAL / TINGKAT KETERGANTUNGAN
        </td>
    </tr>

    <!-- AKTIVITAS DAN MOBILISASI -->
    <tr>
        <td style="border:1px solid black; padding:6px; width:30%; vertical-align:top;">
            Aktivitas dan Mobilisasi :
        </td>
        <td style="border:1px solid black; padding:6px;">
            {{ cb(($data->status_fungsional ?? '') == 'Mandiri') }} Mandiri
            <br>
            {{ cb(($data->status_fungsional ?? '') == 'Perlu bantuan minimal') }} Perlu bantuan minimal, sebutkan
            {{ $data->status_fungsional_bantuan ?? '................................' }}
            <br>
            {{ cb(($data->status_fungsional ?? '') == 'Ketergantungan total') }} Ketergantungan total
        </td>
    </tr>

    <!-- DILAPOR KE DOKTER -->
    <tr>
        <td style="border:1px solid black; padding:6px;">
            Dilapor ke dokter :
        </td>
        <td style="border:1px solid black; padding:6px;">
            {{ cb(($data->fungsional_ke_dokter ?? '') == 'Ya') }} Ya, pukul {{ $data->fungsional_ke_dokter_pukul ?? '...........' }}
            &nbsp;&nbsp;&nbsp;&nbsp;
            {{ cb(($data->fungsional_ke_dokter ?? '') == 'Tidak') }} Tidak
            <br>
            <span style="font-size:11px; font-style:italic;">
                (bila ketergantungan total kolaborasi dengan DPJP, apakah perlu untuk konsul ke rehabilitasi medik)
            </span>
        </td>
    </tr>

</table>

<!-- ================= DIAGNOSA KEPERAWATAN ================= -->
<table style="width:100%; border-collapse:collapse; border:1px solid black; margin-top:10px;" cellpadding="4" cellspacing="0">

    <!-- HEADER -->
    <tr>
        <td colspan="3" style="border:1px solid black; text-align:center; font-weight:bold; background:#d0f0d0; padding:8px;">
            DIAGNOSA KEPERAWATAN
        </td>
    </tr>

    <!-- TABLE HEADER -->
    <tr style="background:#f5f5f5;">
        <th style="border:1px solid black; padding:6px; width:33%;">DIAGNOSA KEPERAWATAN</th>
        <th style="border:1px solid black; padding:6px; width:33%;">TUJUAN</th>
        <th style="border:1px solid black; padding:6px; width:34%;">INTERVENSI</th>
    </tr>

    <!-- CONTENT -->
    <tr>
        <td style="border:1px solid black; padding:6px; vertical-align:top; min-height:100px;">
            {{ $data->diagnosa_keperawatan ?? '' }}
        </td>
        <td style="border:1px solid black; padding:6px; vertical-align:top;">
            {{ $data->diagnosa_tujuan ?? '' }}
        </td>
        <td style="border:1px solid black; padding:6px; vertical-align:top;">
            {{ $data->diagnosa_intervensi ?? '' }}
        </td>
    </tr>

</table>

<!-- ================= RENCANA PEMULANGAN PASIEN (DISCHARGE PLANNING) ================= -->
<table style="width:100%; border-collapse:collapse; border:1px solid black; margin-top:10px;" cellpadding="4" cellspacing="0">

    <!-- HEADER -->
    <tr>
        <td colspan="4" style="border:1px solid black; text-align:center; font-weight:bold; background:#d0e8f0; padding:8px;">
            RENCANA PEMULANGAN PASIEN (DISCHARGE PLANNING)
        </td>
    </tr>

    <!-- ESTIMASI TANGGAL PULANG & TAHU RENCANA PULANG -->
    <tr>
        <td style="border:1px solid black; padding:6px; font-weight:bold; width:30%;">
            Estimasi tanggal pemulangan pasien
        </td>
        <td style="border:1px solid black; padding:6px; width:35%;">
            {{ $data->estimasi_pemulangan ?? '....................................' }}
        </td>
        <td style="border:1px solid black; padding:6px; font-weight:bold; width:15%;">
            Apakah Pasien/keluarga tahu rencana pulang?
        </td>
        <td style="border:1px solid black; padding:6px; width:20%;">
            {{ cb(($data->tahu_rencana_pulang ?? '') == 'Ya') }} Ya
            &nbsp;&nbsp;
            {{ cb(($data->tahu_rencana_pulang ?? '') == 'Tidak') }} Tidak
        </td>
    </tr>

    <!-- KETERANGAN RENCANA PULANG - HEADER -->
    <tr>
        <td colspan="4" style="border:1px solid black; padding:6px; font-weight:bold; background:#f5f5f5;">
            Keterangan Rencana Pulang
        </td>
    </tr>

    <!-- HEADER KOLOM -->
    <tr style="background:#fafafa;">
        <td style="border:1px solid black; padding:6px; font-weight:bold; text-align:center;">
            Keterangan Rencana Pulang
        </td>
        <td style="border:1px solid black; padding:6px; text-align:center; width:10%;">Ya</td>
        <td style="border:1px solid black; padding:6px; text-align:center; width:10%;">Tidak</td>
        <td style="border:1px solid black; padding:6px; text-align:center; width:40%;">Keterangan</td>
    </tr>

    <!-- BERPENGARUH TERHADAP -->
    <tr>
        <td style="border:1px solid black; padding:6px; vertical-align:top;">
            Apakah rawat inap berpengaruh terhadap:<br>
            - Pasien dan Keluarga<br>
            - Pekerjaan<br>
            - Keuangan
        </td>
        <td style="border:1px solid black; padding:6px; text-align:center;">
            {{ cb(($data->dp_berpengaruh ?? '') == 'Ya') }}
        </td>
        <td style="border:1px solid black; padding:6px; text-align:center;">
            {{ cb(($data->dp_berpengaruh ?? '') == 'Tidak') }}
        </td>
        <td style="border:1px solid black; padding:6px;">
            {{ $data->dp_berpengaruh_ket ?? '' }}
        </td>
    </tr>

    <!-- MASALAH PEMENUHAN KEBUTUHAN -->
    <tr>
        <td style="border:1px solid black; padding:6px; vertical-align:top;">
            Masalah pemenuhan kebutuhan yang dihadapi saat pulang
        </td>
        <td colspan="2" style="border:1px solid black; padding:6px; text-align:center; vertical-align:top;">
            <!-- Checkbox list di kiri -->
        </td>
        <td style="border:1px solid black; padding:6px; vertical-align:top;">
            {{ $data->dp_lainnya ?? '' }}
        </td>
    </tr>

    <!-- CHECKBOX MASALAH -->
    <tr>
        <td colspan="4" style="border:1px solid black; padding:8px;">
            <table style="width:100%; border:none;">
                <tr>
                    <td style="border:none; width:33%; padding:3px;">
                        {{ cb($data->dp_mobilitas ?? false) }} Mobilitas Fisik
                    </td>
                    <td style="border:none; width:33%; padding:3px;">
                        {{ cb($data->dp_hygiene ?? false) }} Personal Hygiene
                    </td>
                    <td style="border:none; width:34%; padding:3px;">
                        {{ cb($data->dp_obat ?? false) }} Kepatuhan Minum Obat
                    </td>
                </tr>
                <tr>
                    <td style="border:none; padding:3px;">
                        {{ cb($data->dp_diet ?? false) }} Pengaturan Diet
                    </td>
                    <td style="border:none; padding:3px;">
                        {{ cb($data->dp_makanan ?? false) }} Menyiapkan makanan/minum
                    </td>
                    <td style="border:none; padding:3px;">
                        {{ cb($data->dp_lainnya_check ?? false) }} Lainnya
                        @if(!empty($data->dp_lainnya))
                            : {{ $data->dp_lainnya }}
                        @endif
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- YANG MERAWAT -->
    <tr>
        <td style="border:1px solid black; padding:6px; font-weight:bold; vertical-align:top;">
            Apakah ada yang membantu kebutuhan tersebut diatas (yang merawat pasien)?
        </td>
        <td style="border:1px solid black; padding:6px; text-align:center;">
            {{ cb(($data->dp_ada_yang_membantu ?? '') == 'Ya') }}
        </td>
        <td style="border:1px solid black; padding:6px; text-align:center;">
            {{ cb(($data->dp_ada_yang_membantu ?? '') == 'Tidak') }}
        </td>
        <td style="border:1px solid black; padding:6px;">
            Yang merawat: {{ $data->dp_yang_merawat ?? '' }}
        </td>
    </tr>

    <!-- PERALATAN MEDIS -->
    <tr>
        <td style="border:1px solid black; padding:6px; font-weight:bold; vertical-align:top;">
            Apakah pasien menggunakan peralatan medis dirumah setelah keluar rumah sakit (cateter, NGT, double lumen, oksigen)?
        </td>
        <td style="border:1px solid black; padding:6px; text-align:center;">
            {{ cb(($data->dp_peralatan_medis ?? '') == 'Ya') }}
        </td>
        <td style="border:1px solid black; padding:6px; text-align:center;">
            {{ cb(($data->dp_peralatan_medis ?? '') == 'Tidak') }}
        </td>
        <td style="border:1px solid black; padding:6px;">
            Alat yang digunakan:<br>
            {{ $data->dp_peralatan_medis_ket ?? '' }}
        </td>
    </tr>

    <!-- ALAT BANTU -->
    <tr>
        <td style="border:1px solid black; padding:6px; font-weight:bold; vertical-align:top;">
            Apakah pasien memerlukan alat bantu setelah keluar dari rumah sakit (tongkat, kursi roda, walker dll)?
        </td>
        <td style="border:1px solid black; padding:6px; text-align:center;">
            {{ cb(($data->dp_alat_bantu ?? '') == 'Ya') }}
        </td>
        <td style="border:1px solid black; padding:6px; text-align:center;">
            {{ cb(($data->dp_alat_bantu ?? '') == 'Tidak') }}
        </td>
        <td style="border:1px solid black; padding:6px;">
            Alat yang digunakan:<br>
            {{ $data->dp_alat_bantu_ket ?? '' }}
        </td>
    </tr>

    <!-- PERAWATAN LANJUTAN -->
    <tr>
        <td style="border:1px solid black; padding:6px; font-weight:bold; vertical-align:top;">
            Apakah ketika pulang masih ada perawatan lanjutan/khusus yang harus dilakukan dirumah (rawat luka, perawatan bayi, injeksi lantus dll)?
        </td>
        <td style="border:1px solid black; padding:6px; text-align:center;">
            {{ cb(($data->dp_perawatan_lanjutan ?? '') == 'Ya') }}
        </td>
        <td style="border:1px solid black; padding:6px; text-align:center;">
            {{ cb(($data->dp_perawatan_lanjutan ?? '') == 'Tidak') }}
        </td>
        <td style="border:1px solid black; padding:6px;">
            Jenis Perawatan:<br>
            {{ $data->dp_perawatan_lanjutan_ket ?? '' }}
        </td>
    </tr>

    <!-- MASALAH KHUSUS -->
    <tr>
        <td style="border:1px solid black; padding:6px; font-weight:bold; vertical-align:top;">
            Apakah pasien memiliki masalah seperti nyeri kronis, kelelahan, batasan asupan cairan atau batasan aktivitas setelah keluar dari rumah sakit?
        </td>
        <td style="border:1px solid black; padding:6px; text-align:center;">
            {{ cb(($data->dp_masalah_khusus ?? '') == 'Ya') }}
        </td>
        <td style="border:1px solid black; padding:6px; text-align:center;">
            {{ cb(($data->dp_masalah_khusus ?? '') == 'Tidak') }}
        </td>
        <td style="border:1px solid black; padding:6px;">
            Cara mengatasinya:<br>
            {{ $data->dp_masalah_khusus_ket ?? '' }}
        </td>
    </tr>

    <!-- ALAT TRANSPORTASI -->
    <tr>
        <td style="border:1px solid black; padding:6px; font-weight:bold; vertical-align:top;">
            Apakah alat transportasi pasien untuk pulang aman sesuai dengan kondisi pasien saat keluar rumah sakit?
        </td>
        <td style="border:1px solid black; padding:6px; text-align:center;">
            {{ cb(($data->dp_transportasi_aman ?? '') == 'Ya') }}
        </td>
        <td style="border:1px solid black; padding:6px; text-align:center;">
            {{ cb(($data->dp_transportasi_aman ?? '') == 'Tidak') }}
        </td>
        <td style="border:1px solid black; padding:6px;">
            Alat transportasi:<br>
            {{ $data->dp_transportasi_ket ?? '' }}
        </td>
    </tr>

    <!-- EDUKASI -->
    <tr>
        <td style="border:1px solid black; padding:6px; font-weight:bold; vertical-align:top;">
            Apakah pasien dan keluarga memerlukan edukasi kesehatan keluar dari rumah sakit obat-obatan, nyeri, diet, mencari pertolongan, followup, dll?
        </td>
        <td style="border:1px solid black; padding:6px; text-align:center;">
            {{ cb(($data->dp_edukasi ?? '') == 'Ya') }}
        </td>
        <td style="border:1px solid black; padding:6px; text-align:center;">
            {{ cb(($data->dp_edukasi ?? '') == 'Tidak') }}
        </td>
        <td style="border:1px solid black; padding:6px;">
            Jenis edukasi:<br>
            {{ $data->dp_edukasi_ket ?? '' }}
        </td>
    </tr>

    <!-- FOOTER RM -->
    <tr>
        <td colspan="4" style="border:1px solid black; padding:8px; text-align:center; font-weight:bold; background:#e0e0e0;">
            RM 7.8/AAKRI/{{ config('app.tahun_akreditasi', '2022') }}
        </td>
    </tr>

</table>
<!-- ================= PERAWAT YANG MENGKAJI ================= -->
<table style="width:100%; border-collapse:collapse; border:1px solid black; margin-top:10px;" cellpadding="4" cellspacing="0">

    <tr>
        <td style="border:1px solid black; padding:20px; text-align:center;">
            <div style="margin-bottom:10px;">
                Tanggal, {{ $data->tanggal_kaji ?? '.............................' }}
                pukul {{ $data->pukul_kaji ?? '...........' }}
            </div>

            <div style="margin-bottom:10px; font-weight:bold;">
                Perawat yang mengkaji
            </div>

            @if(!empty($data->perawat_ttd))
            <div style="margin:15px 0;">
                <img src="{{ $data->perawat_ttd }}" style="max-width:200px; max-height:100px; border:1px solid #ccc;" />
            </div>
            @else
            <div style="margin:60px 0;">
                <!-- Space untuk TTD manual -->
            </div>
            @endif

            <div style="margin-top:10px;">
                ( {{ $data->perawat_nama ?? '.............................' }} )
            </div>
        </td>
    </tr>

</table>
