<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM1.3</title>
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

        .fontsmall {
            font-size: 10;
        }
    </style>

</head>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;">
    </div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <?php $patimg = storage_path('app/public/images/PAT.png'); ?>
    
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            {{ $pengkajian->no_surat ?? 'RM 1.3/PKMRJ/' . config('app.tahun_akreditasi', '22') }}
        </div>
        @include('print-rekam-medis.partials.header')
        <table style="width: 100%; text-align: left;" cellpadding="0" cellspacing="0">
            {{-- PENGKAJIAN KEPERAWATAN MATA RAWAT JALAN --}}
            <tr style="border: 1px solid black;">
                <td>
                    <div style="width: 100%; text-align: center; margin-top: 0px; margin-top:5px; font-weight: bold">
                        PENGKAJIAN KEPERAWATAN MATA RAWAT JALAN
                    </div>
                    <div style="width: 100%; text-align: center; margin-top: 0px; line-height: 21px; margin-bottom: 3px; ">
                        <i>(dilengkapi dalam waktu 2 jam pertama pasien masuk ruang rawat jalan)</i>
                    </div>
                </td>
            </tr>
            {{-- Tanggal --}}
            <tr style="border: 1px solid black; width:100%">
                <td>
                    <table style="border-collapse: collapse; width:100%">
                        <tr>
                            <td style="border-right: 1px solid black; width:33.33%">
                                Tanggal: <b>{{ date('Y-m-d', strtotime($pengkajian->tanggal)) }}</b>
                            </td>
                            <td style="border-right: 1px solid black; width:33.33%">
                                Waktu: <b>{{ date('H:i', strtotime($pengkajian->waktu)) }}</b> WIB
                            </td>
                            <td style="width:33.34%">
                                Perawat Pengkaji: <b>{{ $pengkajian->perawat_pengkaji }}</b>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            {{-- Status Fungsional --}}
            <tr style="border: 1px solid black; width:100%">
                <td>
                    <table style="border-collapse: collapse; width:100%">
                        <tr>
                            <td style="vertical-align: middle;">
                                Status Fungsional:
                            </td>
                            <td style="vertical-align: middle; width: 20px;">
                                <input type="checkbox" {{ $pengkajian->jalan_tanpa_bantuan == '1' ? 'Checked' : '' }}>
                            </td>
                            <td style="vertical-align: middle;">
                                Jalan tanpa bantuan
                            </td>
                            <td style="vertical-align: middle; width: 20px;">
                                <input type="checkbox" {{ $pengkajian->kursi_roda == '1' ? 'Checked' : '' }}>
                            </td>
                            <td style="padding: 5px 0; vertical-align: middle;">
                                Kursi Roda
                            </td>
                            <td style="vertical-align: middle; width: 20px;">
                                <input type="checkbox" {{ $pengkajian->tempat_tidur_dorong == '1' ? 'Checked' : '' }}>
                            </td>
                            <td style="vertical-align: middle;">
                                Tempat Tidur Dorong
                            </td>
                            <td style="vertical-align: middle; width: 20px;">
                                <input type="checkbox" {{ $pengkajian->jalan_dengan_bantuan == '1' ? 'Checked' : '' }}>
                            </td>
                            <td style="vertical-align: middle;">
                                Jalan dengan bantuan
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            {{-- Keluhan Utama --}}
            <tr style="border: 1px solid black; width:100%">
                <td>
                    <table style="border-collapse: collapse; width:100%">
                        <tr>
                            <td style="border-right: 1px solid black; width:50%; vertical-align: top;">
                                <div style="width: 100%;height:50px">Keluhan Utama : <br>
                                    <b>{{ $pengkajian->keluhan_utama }}</b>
                                </div>
                                <div style="border-top: 1px solid black; width:100%; height:1px;"></div>
                                <div style="width: 100%;height:100px">Riwayat Penyakit : <br>
                                    <b>{{ $pengkajian->riwayat_penyakit }} </b>
                                </div>
                            </td>
                            <td style="width:50%; vertical-align: top; padding: 5px;">
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <td colspan="2" style="padding-bottom: 5px;">
                                            <b>KASUS URGENT:</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20px; vertical-align: middle; padding: 2px 0;">
                                            <input type="checkbox" {{ $pengkajian->urgent_mata_merah == '1' ? 'Checked' : '' }}>
                                        </td>
                                        <td style="vertical-align: middle; padding: 2px 0;">
                                            MATA MERAH
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20px; vertical-align: middle; padding: 2px 0;">
                                            <input type="checkbox" {{ $pengkajian->urgent_trauma_kesakitan == '1' ? 'Checked' : '' }}>
                                        </td>
                                        <td style="vertical-align: middle; padding: 2px 0;">
                                            TRAUMA/KESAKITAN
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20px; vertical-align: middle; padding: 2px 0;">
                                            <input type="checkbox" {{ $pengkajian->urgent_mata_kabur_mendadak == '1' ? 'Checked' : '' }}>
                                        </td>
                                        <td style="vertical-align: middle; padding: 2px 0;">
                                            MATA KABUR MENDADAK
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20px; vertical-align: middle; padding: 2px 0;">
                                            <input type="checkbox" {{ $pengkajian->urgent_balita_manula == '1' ? 'Checked' : '' }}>
                                        </td>
                                        <td style="vertical-align: middle; padding: 2px 0;">
                                            BALITA / MANULA
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20px; vertical-align: middle; padding: 2px 0;">
                                            <input type="checkbox" {{ $pengkajian->urgent_lain_lain == '1' ? 'Checked' : '' }}>
                                        </td>
                                        <td style="vertical-align: middle; padding: 2px 0;">
                                            LAINNYA: {{ $pengkajian->urgent_lain_lain_text }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            {{-- PEMERIKSAAN FISIK --}}
            <tr>
                <td>
                    <table style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black; width:100%; padding:5px">
                        <tr>
                            <td colspan="6"><b>PEMERIKSAAN FISIK</b></td>
                        </tr>
                        <tr>
                            <td>TD</td>
                            <td><b>{{ $pengkajian->td }} mmHg</b></td>
                            <td>Nadi</td>
                            <td><b>{{ $pengkajian->nadi }} /menit</b></td>
                            <td>RR</td>
                            <td><b>{{ $pengkajian->rr }} /menit</b></td>
                        </tr>
                        <tr>
                            <td>BB</td>
                            <td><b>{{ $pengkajian->bb }} kg</b></td>
                            <td>TB</td>
                            <td><b>{{ $pengkajian->tb }} cm</b></td>
                            <td>Suhu</td>
                            <td><b>{{ $pengkajian->suhu }} C</b></td>
                        </tr>
                    </table>
                </td>
            </tr>
            {{-- RIWAYAT KESEHATAN --}}
            <tr>
                <td>
                    <table style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black; width:100%; padding:5px">
                        <tr>
                            <td colspan="11"><b>RIWAYAT KESEHATAN</b></td>
                        </tr>
                        <tr>
                            <td>1. Penyakit yang pernah diderita :</td>
                            <td><input type="checkbox" {{ $pengkajian->penyakit_diabetes == '1' ? 'Checked' : '' }}></td>
                            <td>Diabetes</td>
                            <td><input type="checkbox" {{ $pengkajian->penyakit_hipertensi == '1' ? 'Checked' : '' }}></td>
                            <td>Hipertensi</td>
                            <td><input type="checkbox" {{ $pengkajian->penyakit_jantung == '1' ? 'Checked' : '' }}></td>
                            <td>Jantung</td>
                            <td><input type="checkbox" {{ $pengkajian->penyakit_hepatitis == '1' ? 'Checked' : '' }}></td>
                            <td>Hepatitis</td>
                            <td><input type="checkbox" {{ $pengkajian->penyakit_asma == '1' ? 'Checked' : '' }}></td>
                            <td>Asma</td>
                        </tr>
                        <tr>
                            <td colspan="11">
                                Lainnya : {{ $pengkajian->penyakit_lainnya_text }}
                            </td>
                        </tr>
                        <tr>
                            <td>2. Pernah Dioperasi :</td>
                            <td><input type="checkbox" {{ $pengkajian->pernah_operasi == '1' ? 'Checked' : '' }}></td>
                            <td >Ya</td>
                            <td><input type="checkbox" {{ $pengkajian->pernah_operasi == '0' ? 'Checked' : '' }}></td>
                            <td colspan="7">Tidak</td>
                        </tr>
                        <tr>
                            <td colspan="11">
                                Jenis Operasi : {{ $pengkajian->jenis_operasi }}
                            </td>
                        </tr>
                        <tr>
                            <td>3. Riwayat Alergi :</td>
                            <td><input type="checkbox" {{ $pengkajian->riwayat_alergi == '1' ? 'Checked' : '' }}></td>
                            <td >Ya</td>
                            <td><input type="checkbox" {{ $pengkajian->riwayat_alergi == '0' ? 'Checked' : '' }}></td>
                            <td colspan="7">Tidak</td>

                        </tr>
                        <tr>
                            <td>Alergi Terhadap :</td>
                            <td><input type="checkbox" {{ $pengkajian->alergi_makanan == '1' ? 'Checked' : '' }}></td>
                            <td colspan="9">Makanan : <b>{{ $pengkajian->alergi_makanan_text }}</b></td>
                        </tr>
                        <tr style="font-size: 10">
                            <td>4. Obat yang digunakan saat ini :</td>
                            <td><input type="checkbox" {{ $pengkajian->obat_pencair_darah == '1' ? 'Checked' : '' }}></td>
                            <td>Obat Pencair Darah</td>
                            <td><input type="checkbox" {{ $pengkajian->obat_prostat == '1' ? 'Checked' : '' }}></td>
                            <td>Obat Prostat</td>
                            <td><input type="checkbox" {{ $pengkajian->obat_asma == '1' ? 'Checked' : '' }}></td>
                            <td>Obat Asma</td>
                            <td><input type="checkbox" {{ $pengkajian->obat_alergi_steroid == '1' ? 'Checked' : '' }}></td>
                            <td colspan="3">Obat Alergi</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: right"><input type="checkbox" {{ $pengkajian->obat_lain == '1' ? 'Checked' : '' }}></td>
                            <td colspan="9" style="text-align: left">Lainnya : <b>{{ $pengkajian->obat_lain_text }}</b></td>
                        </tr>
                    </table>
                </td>
            </tr>
            {{-- PENILAIAN RESIKO JATUH --}}
            <tr>
                <td>
                    <table style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black; width:100%; padding:5px">
                        <tr>
                            <td colspan="5"><b>PENILAIAN RESIKO JATUH</b></td>
                        </tr>
                        <tr>
                            <td>Resiko Jatuh</td>
                            <td style="width: 1px;"><input type="checkbox" {{ $pengkajian->resiko_jatuh == '1' ? 'Checked' : '' }}></td>
                            <td>YA</td>
                            <td style="width: 1px;"><input type="checkbox" {{ $pengkajian->resiko_jatuh == '0' ? 'Checked' : '' }}></td>
                            <td>TIDAK</td>
                        </tr>
                    </table>
                </td>
            </tr>
            {{-- SKRINING NYERI --}}
            <tr>
                <td>
                    <table style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black; width:100%; padding:5px">
                        <tr>
                            <td style="width: 40%; vertical-align: top;">
                                <b>SKRINING NYERI</b><br>
                                <img style="width: 100%;" src="data:image/png;base64,<?php echo base64_encode(file_get_contents($patimg)); ?>" />
                                <table style="width: 100%;">
                                    <tr>
                                        <td style="text-align: center; font-size: 11px; padding: 2px;">
                                            <input type="radio" {{ $pengkajian->pain_scale_value == '0' ? 'checked' : '' }}><br>0
                                        </td>
                                        <td style="text-align: center; font-size: 11px; padding: 2px;">
                                            <input type="radio" {{ $pengkajian->pain_scale_value == '1' ? 'checked' : '' }}><br>1
                                        </td>
                                        <td style="text-align: center; font-size: 11px; padding: 2px;">
                                            <input type="radio" {{ $pengkajian->pain_scale_value == '2' ? 'checked' : '' }}><br>2
                                        </td>
                                        <td style="text-align: center; font-size: 11px; padding: 2px;">
                                            <input type="radio" {{ $pengkajian->pain_scale_value == '3' ? 'checked' : '' }}><br>3
                                        </td>
                                        <td style="text-align: center; font-size: 11px; padding: 2px;">
                                            <input type="radio" {{ $pengkajian->pain_scale_value == '4' ? 'checked' : '' }}><br>4
                                        </td>
                                        <td style="text-align: center; font-size: 11px; padding: 2px;">
                                            <input type="radio" {{ $pengkajian->pain_scale_value == '5' ? 'checked' : '' }}><br>5
                                        </td>
                                        <td style="text-align: center; font-size: 11px; padding: 2px;">
                                            <input type="radio" {{ $pengkajian->pain_scale_value == '6' ? 'checked' : '' }}><br>6
                                        </td>
                                        <td style="text-align: center; font-size: 11px; padding: 2px;">
                                            <input type="radio" {{ $pengkajian->pain_scale_value == '7' ? 'checked' : '' }}><br>7
                                        </td>
                                        <td style="text-align: center; font-size: 11px; padding: 2px;">
                                            <input type="radio" {{ $pengkajian->pain_scale_value == '8' ? 'checked' : '' }}><br>8
                                        </td>
                                        <td style="text-align: center; font-size: 11px; padding: 2px;">
                                            <input type="radio" {{ $pengkajian->pain_scale_value == '9' ? 'checked' : '' }}><br>9
                                        </td>
                                        <td style="text-align: center; font-size: 11px; padding: 2px;">
                                            <input type="radio" {{ $pengkajian->pain_scale_value == '10' ? 'checked' : '' }}><br>10
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 60%; vertical-align: top; padding: 5px;">
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <td style="width: 20px; vertical-align: middle; padding: 2px;">
                                            <input type="checkbox" {{ $pengkajian->tidak_ada_nyeri == '1' ? 'Checked' : '' }}>
                                        </td>
                                        <td style="vertical-align: middle; padding: 2px;">
                                            Tidak Ada Nyeri
                                        </td>
                                        <td style="width: 20px; vertical-align: middle; padding: 2px;">
                                            <input type="checkbox" {{ $pengkajian->nyeri_akut == '1' ? 'Checked' : '' }}>
                                        </td>
                                        <td style="vertical-align: middle; padding: 2px;">
                                            Nyeri Akut
                                        </td>
                                        <td style="width: 20px; vertical-align: middle; padding: 2px;">
                                            <input type="checkbox" {{ $pengkajian->nyeri_kronis == '1' ? 'Checked' : '' }}>
                                        </td>
                                        <td style="vertical-align: middle; padding: 2px;">
                                            Nyeri Kronis
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="padding: 10px 0;">
                                            Skala Nyeri : <b>{{ $pengkajian->skala_nyeri }}</b> &nbsp;&nbsp;
                                            Lokasi : <b>{{ $pengkajian->lokasi_nyeri }}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="padding-bottom: 10px;">
                                            Karakteristik : <b>{{ $pengkajian->karakteristik_nyeri }}</b> &nbsp;&nbsp;
                                            Durasi : <b>{{ $pengkajian->durasi_nyeri }}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" style="padding-bottom: 5px;">
                                            <b>Nyeri hilang bila :</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20px; vertical-align: middle; padding: 2px;">
                                            <input type="checkbox" {{ $pengkajian->nyeri_hilang_minum_obat == '1' ? 'Checked' : '' }}>
                                        </td>
                                        <td style="vertical-align: middle; padding: 2px;">
                                            Minum Obat
                                        </td>
                                        <td style="width: 20px; vertical-align: middle; padding: 2px;">
                                            <input type="checkbox" {{ $pengkajian->nyeri_hilang_istirahat == '1' ? 'Checked' : '' }}>
                                        </td>
                                        <td style="vertical-align: middle; padding: 2px;">
                                            Istirahat
                                        </td>
                                        <td style="width: 20px; vertical-align: middle; padding: 2px;">
                                            <input type="checkbox" {{ $pengkajian->nyeri_hilang_berubah_posisi == '1' ? 'Checked' : '' }}>
                                        </td>
                                        <td style="vertical-align: middle; padding: 2px;">
                                            Berubah Posisi
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20px; vertical-align: middle; padding: 2px;">
                                            <input type="checkbox" {{ $pengkajian->nyeri_hilang_lainnya == '1' ? 'Checked' : '' }}>
                                        </td>
                                        <td colspan="5" style="vertical-align: middle; padding: 2px;">
                                            Lainnya : <b>{{ $pengkajian->nyeri_hilang_lainnya_text }}</b>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            {{-- DIAGNOSA DAN INTERVENSI --}}
            <tr>
                <td>
                    <table style="border-top: 1px solid black; border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black; width:100%; padding:5px">
                        <tr>
                            <td colspan="2" style="text-align: center; padding: 5px;">
                                <b>DAFTAR DIAGNOSA KEPERAWATAN</b>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black; padding: 5px; width: 50%; vertical-align: top;">
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <td colspan="2" style="padding-bottom: 5px;">
                                            <b>Diagnosa Keperawatan</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20px; vertical-align: top; padding: 2px 0;">
                                            <input type="checkbox" {{ $pengkajian->diagnosa_gangguan_sensori == '1' ? 'checked' : '' }}>
                                        </td>
                                        <td style="vertical-align: top; padding: 2px 0;">
                                            Gangguan Sensori Persepsi: Visual berhubungan dengan penerimaan sensori.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20px; vertical-align: top; padding: 2px 0;">
                                            <input type="checkbox" {{ $pengkajian->diagnosa_resiko_jatuh == '1' ? 'checked' : '' }}>
                                        </td>
                                        <td style="vertical-align: top; padding: 2px 0;">
                                            Resiko Jatuh berhubungan dengan kesulitan visual dan tingkah laku
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20px; vertical-align: top; padding: 2px 0;">
                                            <input type="checkbox" {{ $pengkajian->diagnosa_resiko_infeksi == '1' ? 'checked' : '' }}>
                                        </td>
                                        <td style="vertical-align: top; padding: 2px 0;">
                                            Resiko Infeksi berhubungan dengan peningkatan paparan lingkungan yang berpatogen
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20px; vertical-align: top; padding: 2px 0;">
                                            <input type="checkbox" {{ $pengkajian->diagnosa_nyeri == '1' ? 'checked' : '' }}>
                                        </td>
                                        <td style="vertical-align: top; padding: 2px 0;">
                                            Nyeri berhubungan dengan agen cidera fisik
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20px; vertical-align: top; padding: 2px 0;">
                                            <input type="checkbox" {{ $pengkajian->diagnosa_kurang_pengetahuan == '1' ? 'checked' : '' }}>
                                        </td>
                                        <td style="vertical-align: top; padding: 2px 0;">
                                            Kurangnya pengetahuan berhubungan dengan kurang terpapar informasi
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20px; vertical-align: top; padding: 2px 0;">
                                            <input type="checkbox" {{ $pengkajian->diagnosa_cemas == '1' ? 'checked' : '' }}>
                                        </td>
                                        <td style="vertical-align: top; padding: 2px 0;">
                                            Cemas berhubungan dengan perubahan status kesehatan
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20px; vertical-align: top; padding: 2px 0;">
                                            <input type="checkbox" {{ $pengkajian->diagnosa_tertunda_pemulihan == '1' ? 'checked' : '' }}>
                                        </td>
                                        <td style="vertical-align: top; padding: 2px 0;">
                                            Tertundanya pemulihan post operasi berhubungan dengan ketidaknyamanan
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20px; vertical-align: top; padding: 2px 0;">
                                            <input type="checkbox" {{ $pengkajian->diagnosa_ketidakefektifan_proteksi == '1' ? 'checked' : '' }}>
                                        </td>
                                        <td style="vertical-align: top; padding: 2px 0;">
                                            Ketidakefektifan proteksi berhubungan dengan perawatan (pembedahan)
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style="border: 1px solid black; padding: 5px; width: 50%; vertical-align: top;">
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <td colspan="2" style="padding-bottom: 5px;">
                                            <b>Intervensi Keperawatan</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20px; vertical-align: top; padding: 2px 0;">
                                            <input type="checkbox" {{ $pengkajian->intervensi_pengkajian_awal == '1' ? 'checked' : '' }}>
                                        </td>
                                        <td style="vertical-align: top; padding: 2px 0;">
                                            Melakukan pengkajian awal mata dan mengamati keluhan pasien terutama kasus urgent
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20px; vertical-align: top; padding: 2px 0;">
                                            <input type="checkbox" {{ $pengkajian->intervensi_edukasi_jatuh == '1' ? 'checked' : '' }}>
                                        </td>
                                        <td style="vertical-align: top; padding: 2px 0;">
                                            Memberikan edukasi kepada keluarga tentang resiko jatuh
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20px; vertical-align: top; padding: 2px 0;">
                                            <input type="checkbox" {{ $pengkajian->intervensi_cuci_tangan == '1' ? 'checked' : '' }}>
                                        </td>
                                        <td style="vertical-align: top; padding: 2px 0;">
                                            Mencuci tangan sebelum dan sesudah kontak dengan pasien
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20px; vertical-align: top; padding: 2px 0;">
                                            <input type="checkbox" {{ $pengkajian->intervensi_edukasi_infeksi == '1' ? 'checked' : '' }}>
                                        </td>
                                        <td style="vertical-align: top; padding: 2px 0;">
                                            Mengajarkan pasien dan keluarga tentang tanda dan gejala infeksi agar melapor ke tenaga kesehatan saat terjadi
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20px; vertical-align: top; padding: 2px 0;">
                                            <input type="checkbox" {{ $pengkajian->intervensi_penilaian_nyeri == '1' ? 'checked' : '' }}>
                                        </td>
                                        <td style="vertical-align: top; padding: 2px 0;">
                                            Melakukan penilaian awal nyeri (<i>assesment</i>) dan melakukan penilaian derajat nyeri
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20px; vertical-align: top; padding: 2px 0;">
                                            <input type="checkbox" {{ $pengkajian->intervensi_tetes_mata == '1' ? 'checked' : '' }}>
                                        </td>
                                        <td style="vertical-align: top; padding: 2px 0;">
                                            Memberikan tetes mata sesuai petunjuk dokter
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20px; vertical-align: top; padding: 2px 0;">
                                            <input type="checkbox" {{ $pengkajian->intervensi_bersihkan_luka == '1' ? 'checked' : '' }}>
                                        </td>
                                        <td style="vertical-align: top; padding: 2px 0;">
                                            Membersihkan luka dan mengganti balutan
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20px; vertical-align: top; padding: 2px 0;">
                                            <input type="checkbox" {{ $pengkajian->intervensi_jelaskan_prosedur == '1' ? 'checked' : '' }}>
                                        </td>
                                        <td style="vertical-align: top; padding: 2px 0;">
                                            Menjelaskan kepada orangtua tindakan/prosedur yang akan dilakukan
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20px; vertical-align: top; padding: 2px 0;">
                                            <input type="checkbox" {{ $pengkajian->intervensi_info_preoperasi == '1' ? 'checked' : '' }}>
                                        </td>
                                        <td style="vertical-align: top; padding: 2px 0;">
                                            Menginformasikan kepada keluarga tentang preoperasi termasuk jadwal operasi
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20px; vertical-align: top; padding: 2px 0;">
                                            <input type="checkbox" {{ $pengkajian->intervensi_patching == '1' ? 'checked' : '' }}>
                                        </td>
                                        <td style="vertical-align: top; padding: 2px 0;">
                                            Membantu menggunakan <i>patching</i> jika diperlukan
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            {{-- TANDA TANGAN --}}
            <tr>
                <td>
                    <table style="border-top: 1px solid black; border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black; width:100%; padding:5px">
                        <tr>
                            <td style="padding: 10px;">
                                <div style="margin-bottom: 10px;">
                                    Tanggal: <b>{{ substr($pengkajian->tanggal_ttd, 0, 10) }}</b> &nbsp;&nbsp;&nbsp;
                                    Waktu: <b>{{ substr($pengkajian->waktu_ttd, 0, 5) }}</b> WIB
                                </div>
                                <div style="text-align: center; margin-top: 20px;">
                                    <div style="font-weight: bold; margin-bottom: 10px;">Perawat Yang Melakukan Pengkajian</div>
                                    @if($pengkajian->ttd_perawat)
                                        <img src="{{ $pengkajian->ttd_perawat }}" style="max-width: 200px; max-height: 100px; padding: 5px;" />
                                    @else
                                        <div style="height: 100px; margin: 0 auto; width: 200px;"></div>
                                    @endif
                                    <div style="margin-top: 10px; font-weight: bold;">
                                        {{ $pengkajian->nama_perawat_ttd }}
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>