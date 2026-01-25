<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>REKAM MEDIS GENERAL -  PENDIDIKAN EDUKASI PASIEN/KELUARGA TERINTEGRASI RAWAT INAP </title>
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

        .sizesmall {
            font-size: 9;
        }

        .tablee {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .page_break1 {
        page-break-after: always;
        }

        .page_break {
            page-break-before: always;
        }
        
        .td-center-nopad {
            text-align: center;
            padding: 0 !important;
        }

        .ttd-img1 {
            max-width: 150px;
            max-height: 50px;
            display: block;
            margin: 0 auto;          /* center horizontal */
        }
        .ttd-img2 {
            max-width: 60px;
            max-height: 60px;
            display: block;
            padding: 10%;       /* center horizontal */
        }
        .ttd-img3 {
            max-width: 100px;
            max-height: 100px;
            display: block;
            margin: 0 auto;          /* center horizontal */
        }
        
        .ttd-nama1 {
            margin-top: 6px;         /* jangan terlalu besar */
            font-size: 11px;
            text-align: center;      /* teks benar-benar center */
        }

        .page-break {
    page-break-before: always;
}


    </style>

</head>
    
<body>
    <div style="position:fixed; right: 13px; bottom: 10px;">
    </div>
    <?php $fullpath = storage_path('app/public/images/header_rme2.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 2.4/PEPKTRI/22
        </div>
        <table style="border-collapse: collapse;">
            @include('print-rekam-medis.partials.header2')
            <tr style="border: 1px solid black; width:100%">
                <div class="sizesmall ">
                    <table style="border-collapse: collapse; width:100%;">
                        <tr>
                            <td style="border-right: 1px solid black; width:100%;">
                                <b>Pengkajian Hambatan</b>
                                <table style="border-collapse: collapse; width:100%;">
                                    <tr>
                                        <td><input type="checkbox" {{ $edukasiPasien->hambatan_bahasa ? 'checked' : '' }}></td>
                                        <td>
                                            Bahasa
                                        </td>
                                        <td><input type="checkbox" {{ $edukasiPasien->hambatan_cemas ? 'checked' : '' }}></td>
                                        <td>
                                            Cemas
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" {{ $edukasiPasien->hambatan_pendengaran ? 'checked' : '' }}></td>
                                        <td>
                                            Pendengaran
                                        </td>
                                        <td><input type="checkbox" {{ $edukasiPasien->hambatan_emosi ? 'checked' : '' }}></td>
                                        <td>
                                            Emosi
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" {{ $edukasiPasien->hambatan_masalah_penglihatan ? 'checked' : '' }}></td>
                                        <td>
                                            Masalah penglihatan
                                        </td>
                                        <td><input type="checkbox" {{ $edukasiPasien->hambatan_kognitif ? 'checked' : '' }}></td>
                                        <td>
                                            Kognitif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" {{ $edukasiPasien->hambatan_bicara_buruk ? 'checked' : '' }}></td>
                                        <td>
                                            Bicara buruk
                                        </td>
                                        <td><input type="checkbox" {{ $edukasiPasien->hambatan_hilang_memori ? 'checked' : '' }}></td>
                                        <td>
                                            Hilang memori
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" {{ $edukasiPasien->hambatan_tidak_ada_partisipasi ? 'checked' : '' }}></td>
                                        <td>Tidak ada partisipasi</td>
                                        <td><input type="checkbox" {{ $edukasiPasien->hambatan_motivasi ? 'checked' : '' }}></td>
                                        <td>Motivasi</td>
                                    </tr>
                                </table>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td><input type="checkbox" {{ $edukasiPasien->hambatan_fisiologi_tidak_mampu ? 'checked' : '' }}></td>
                                        <td>
                                            Secara fisiologi tidak mampu belajar
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" {{ $edukasiPasien->hambatan_tidak_ditemukan ? 'checked' : '' }}></td>
                                        <td>
                                            Tidak ditemukan hambatan belajar
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            &nbsp;
                                        </td>
                                    </tr>
                                </table>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td colspan="2">
                                            <b>Edukasi</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" {{ $edukasiPasien->edukasi_tata_tertib_rs ? 'checked' : '' }}></td>
                                        <td>
                                            Tata Tertib RS
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" {{ $edukasiPasien->edukasi_hak_kewajiban ? 'checked' : '' }}></td>
                                        <td>
                                            Hak Dan Kewajiban Pasien
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            &nbsp;
                                        </td>
                                    </tr>
                                </table>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td colspan="6">
                                            <b>Metode Cara Belajar Yang Disukai</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            1 =  Audio
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            2 = Demonstrasi
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            3 = Lisan
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            4 = Tulisan
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            5 = Visual
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            &nbsp;
                                        </td>
                                    </tr>
                                </table>
                                
                                <br><br><br><br><br><br><br><br><br><br><br><br>
                            </td>
                            <td style="border-right: 1px solid black; width:100%">
                                <b>Pengkajian Bicara :</b>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td><input type="checkbox" {{ $edukasiPasien->bicara_normal ? 'checked' : '' }}></td>
                                        <td>
                                            Normal
                                        </td>
                                        <td><input type="checkbox" {{ $edukasiPasien->bicara_gangguan ? 'checked' : '' }}></td>
                                        <td>
                                            Gangguan Bicara
                                        </td>
                                    </tr>
                                </table>
                                <b>Bahasa Sehari-hari :</b>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td><input type="checkbox" {{ $edukasiPasien->bahasa_indonesia ? 'checked' : '' }}></td>
                                        <td>
                                            Indonesia
                                        </td>
                                        <td><input type="checkbox" {{ $edukasiPasien->bahasa_daerah ? 'checked' : '' }}></td>
                                        <td>
                                            Daerah : {{ $edukasiPasien->bahasa_daerah_text }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" {{ $edukasiPasien->bahasa_inggris ? 'checked' : '' }}></td>
                                        <td>
                                            Inggris
                                        </td>
                                        <td><input type="checkbox" {{ $edukasiPasien->bahasa_lainnya ? 'checked' : '' }}></td>
                                        <td>Lainnya: {{ $edukasiPasien->bahasa_lainnya_text }}</td>
                                    </tr>
                                </table>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td><b>Bahasa Isyarat :</b> </td>
                                        <td><input type="checkbox" {{ $edukasiPasien->bahasa_isyarat_ya ? 'checked' : '' }}></td>
                                        <td>
                                            Ya
                                        </td>
                                        <td><input type="checkbox" {{ $edukasiPasien->bahasa_isyarat_tidak ? 'checked' : '' }}></td>
                                        <td>
                                            Tidak
                                        </td>
                                    </tr>
                                </table>
                                <b>Tingkat Pendidikan :</b>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td><input type="checkbox" {{ $edukasiPasien->pendidikan_tk ? 'checked' : '' }}></td>
                                        <td>
                                            TK
                                        </td>
                                        <td><input type="checkbox" {{ $edukasiPasien->pendidikan_sd ? 'checked' : '' }}></td>
                                        <td>
                                            SD
                                        </td>
                                        <td><input type="checkbox" {{ $edukasiPasien->pendidikan_smp ? 'checked' : '' }}></td>
                                        <td>
                                            SMP
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" {{ $edukasiPasien->pendidikan_sma ? 'checked' : '' }}></td>
                                        <td>
                                            SMA
                                        </td>
                                        <td><input type="checkbox" {{ $edukasiPasien->pendidikan_diploma ? 'checked' : '' }}></td>
                                        <td>
                                            Diploma
                                        </td>
                                        <td><input type="checkbox" {{ $edukasiPasien->pendidikan_sarjana ? 'checked' : '' }}></td>
                                        <td>
                                            Sarjana
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" {{ $edukasiPasien->pendidikan_lainnya ? 'checked' : '' }}></td>
                                        <td colspan="5">
                                            Lain-lain  : {{ $edukasiPasien->pendidikan_lainnya_text }}
                                        </td>
                                    </tr>
                                </table>
                                <b> Agama :</b>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td><input type="checkbox" {{ $edukasiPasien->agama_islam ? 'checked' : '' }}></td>
                                        <td>
                                            Islam
                                        </td>
                                        <td><input type="checkbox" {{ $edukasiPasien->agama_protestan ? 'checked' : '' }}></td>
                                        <td>
                                            Protestan
                                        </td>
                                        <td><input type="checkbox" {{ $edukasiPasien->agama_katolik ? 'checked' : '' }}></td>
                                        <td>
                                            katolik
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" {{ $edukasiPasien->agama_hindu ? 'checked' : '' }}></td>
                                        <td>
                                            Hindu
                                        </td>
                                        <td><input type="checkbox" {{ $edukasiPasien->agama_budha ? 'checked' : '' }}></td>
                                        <td>
                                            Budha
                                        </td>
                                        <td><input type="checkbox" {{ $edukasiPasien->agama_lainnya ? 'checked' : '' }}></td>
                                        <td>
                                            Lain-lain
                                        </td>
                                    </tr>
                                </table>
                                <b>Tingkat Pengetahuan Kesehatan Pasien :</b>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td><input type="checkbox" {{ $edukasiPasien->pengetahuan_paham ? 'checked' : '' }}></td>
                                        <td>
                                            Paham
                                        </td>
                                        <td><input type="checkbox" {{ $edukasiPasien->pengetahuan_kurang_paham ? 'checked' : '' }}></td>
                                        <td>
                                            Kurang paham
                                        </td>
                                        <td><input type="checkbox" {{ $edukasiPasien->pengetahuan_tidak_paham ? 'checked' : '' }}></td>
                                        <td>
                                            Tidak paham
                                        </td>
                                    </tr>
                                </table>
                                <b>Nilai-nilai Pasien Dan Budaya :</b>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td><input type="checkbox" {{ $edukasiPasien->budaya_modern ? 'checked' : '' }}></td>
                                        <td>
                                            Modern
                                        </td>
                                        <td><input type="checkbox" {{ $edukasiPasien->budaya_moderat ? 'checked' : '' }}></td>
                                        <td>
                                            Moderat
                                        </td>
                                        <td><input type="checkbox" {{ $edukasiPasien->budaya_konvensional ? 'checked' : '' }}></td>
                                        <td>
                                            Konvesional
                                        </td>
                                    </tr>
                                </table>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td>Merokok</td>
                                        <td>:</td>
                                        <td><input type="checkbox" {{ $edukasiPasien->merokok_ya ? 'checked' : '' }}></td>
                                        <td>
                                            Ya
                                        </td>
                                        <td><input type="checkbox" {{ $edukasiPasien->merokok_tidak ? 'checked' : '' }}></td>
                                        <td>
                                            Tidak
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Konsumsi Alkohol </td>
                                        <td>:</td>
                                        <td><input type="checkbox" {{ $edukasiPasien->alkohol_ya ? 'checked' : '' }}></td>
                                        <td>
                                            Ya
                                        </td>
                                        <td><input type="checkbox" {{ $edukasiPasien->alkohol_tidak ? 'checked' : '' }}></td>
                                        <td>
                                            Tidak
                                        </td>
                                    </tr>
                                </table>
                                <b>Kesedian Menerima Informasi :</b>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td><input type="checkbox" {{ $edukasiPasien->menerima_info_ya ? 'checked' : '' }}></td>
                                        <td>
                                            Ya
                                        </td>
                                        <td><input type="checkbox" {{ $edukasiPasien->menerima_info_tidak ? 'checked' : '' }}></td>
                                        <td>
                                            Tidak,alasan :  {{ $edukasiPasien->menerima_info_alasan }}
                                        </td>
                                    </tr>
                                </table>
                                <b>Rencana Pendidikan Kesehatan :</b>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td><input type="checkbox" {{ $edukasiPasien->rencana_proses_penyakit ? 'checked' : '' }}></td>
                                        <td>
                                            Proses Penyakit
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" {{ $edukasiPasien->rencana_pengobatan_tindakan ? 'checked' : '' }}></td>
                                        <td>
                                            Pengobatan/Tindakan
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" {{ $edukasiPasien->rencana_nutrisi ? 'checked' : '' }}></td>
                                        <td>
                                            Nutrisi
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" {{ $edukasiPasien->rencana_edukasi_kolaboratif ? 'checked' : '' }}></td>
                                        <td>
                                            Edukasi Kolaboratif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" {{ $edukasiPasien->rencana_lain_lain ? 'checked' : '' }}></td>
                                        <td>
                                            Lain-lain, jelaskan {{ $edukasiPasien->rencana_lain_lain_text }}
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width:100%">
                                <b>Penerima Pendidikan</b>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td>
                                            P = Pasien
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            K = Keluarga
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            L = Lain-lain
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            &nbsp;
                                        </td>
                                    </tr>
                                </table>
                                <b>Frekuensi Edukasi</b>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td>
                                            1 = Edukasi Pertama
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            2 = Re-edukasi ke 2/3 atau lebih
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            &nbsp;
                                        </td>
                                    </tr>
                                </table>
                                <b>Evaluasi Respon </b>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td>
                                            1 = Tidak Mengerti
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            2 = Menyatakan Paham
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            3 = Mampu Menjelaskan
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            4 = Mampu Demonstrasi/Simulasi
                                        </td>
                                    </tr>
                                </table>
                                <div style="height: 400px">

                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </tr>
            {{-- Status Fungsional --}}
            <tr style="border: 1px solid black; width:100%">
                <table style="border-collapse: collapse; width:100%">
                    <tr>
                        <td style="">
                            Kebutuhan Privasi:
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td><input type="checkbox"  {{ $edukasiPasien->privasi_ya ? 'checked' : '' }}></td>
                                    <td>Ya</td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td><input type="checkbox" {{ $edukasiPasien->privasi_tidak ? 'checked' : '' }}></td>
                                    <td>Tidak</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </tr>
            <tr style="border: 1px solid black; width:100%">
                <table style="border-collapse: collapse; width:100%">
                    <tr>
                        <td >
                            Nama Pengkaji: {{ $edukasiPasien->nama_pengkaji }}
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td>Tanggal: {{ $edukasiPasien->tanggal_pengkaji }}</td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td>Jam: {{ $edukasiPasien->waktu_pengkaji }}</td>
                                </tr>
                            </table>
                        </td>
                        <td >Tanda Tangan:                                              
                        </td>
                        <td>                            
                            @if($edukasiPasien->ttd_dokter)
                            <img src="{{ $edukasiPasien->ttd_dokter }}"
                                class="ttd-img2"
                                alt="TTD">
                            @else
                                <div style="height: 50px;"></div>
                            @endif

                        </td>
                    </tr>
                </table>
            </tr>
            </table>
            <div class="page_break"></div>
            <table class="tablee sizesmall" style="width:100%; position:relative; border: 1px solid black; border-collapse: collapse;">
                <tr class="tablee">
                    <th rowspan="2" class="tablee" style="width: 5%; max-width: 50px; padding: 2px; white-space: nowrap; font-size: 8px;">Profesi</th>
                    <th rowspan="2" class="tablee">Tanggal <br> /jam</th>
                    <th rowspan="2" class="tablee">
                        <div>KEBUTUHAN EDUKASI / TOPIK EDUKASI</div> 
                        <div    >
                        @if($edukasiPasien->ttd_dokter_dpjp)
                            <img src="{{ $edukasiPasien->ttd_dokter_dpjp }}"
                                 class="ttd-img3"
                                 alt="TTD DPJP">
                        @else
                            <div style="height: 50px;"></div>
                        @endif
                        </div>
                        <div>{{$edukasiPasien->dokter_dpjp}}</div>
                    </th>
                    <th class="tablee">Penerima Pendidikan </th>
                    <th class="tablee">Metode</th>
                    <th class="tablee">Frekuensi edukasi</th>
                    <th class="tablee">Evaluasi Respon</th>
                    <th class="tablee" colspan ="2">Nama dan Tanda tangan </th>
                </tr>
                <tr class="tablee" style="padding: 5px; ">

                    <td class="tablee">
                        <table style="border-collapse: collapse; margin-left: 20px;">
                            <tr>
                                <td style="border: 1px solid black; width: 30px; height: 30px; text-align: center; vertical-align: middle;">P</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black; width: 30px; height: 30px; text-align: center; vertical-align: middle;">K</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black; width: 30px; height: 30px; text-align: center; vertical-align: middle;">L</td>
                            </tr>
                        </table>
                    </td>
                    <td class="tablee"> 
                        <table style="border-collapse: collapse; margin-left: 20px; margin-right: 20px; ">
                            <tr>
                                <td style="border: 1px solid black; width: 30px; height: 30px; text-align: center; vertical-align: middle;">1</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black; width: 30px; height: 30px; text-align: center; vertical-align: middle;">2</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black; width: 30px; height: 30px; text-align: center; vertical-align: middle;">3</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black; width: 30px; height: 30px; text-align: center; vertical-align: middle;">4</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black; width: 30px; height: 30px; text-align: center; vertical-align: middle;">5</td>
                            </tr>
                        </table>
                    </td>
                    <td class="tablee">                         
                        <table style="border-collapse: collapse; margin-left: 20px;">
                            <tr>
                                <td style="border: 1px solid black; width: 30px; height: 30px; text-align: center; vertical-align: middle;">1</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black; width: 30px; height: 30px; text-align: center; vertical-align: middle;">2</td>
                            </tr>
                        </table> 
                    </td>
                    <td class="tablee">                        
                        <table style="border-collapse: collapse;  margin-left: 20px;">
                            <tr>
                                <td style="border: 1px solid black; width: 30px; height: 30px; text-align: center; vertical-align: middle;">1</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black; width: 30px; height: 30px; text-align: center; vertical-align: middle;">2</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black; width: 30px; height: 30px; text-align: center; vertical-align: middle;">3</td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid black; width: 30px; height: 30px; text-align: center; vertical-align: middle;">4</td>
                            </tr>
                        </table> 
                    </td>
                    <td class="tablee" style="text-align: center;">Pemberi Edukasi</td>
                    <td class="tablee" style="text-align: center;">Penerima Edukasi </td>

                </tr>
                 <tr  class="tablee" style="padding: 5px; ">
                    <td rowspan="9" class="tablee"> Dokter </td>
                    <td rowspan="9" class="tablee">{{ $edukasiPasien->tanggal_dokter }}<br>{{ $edukasiPasien->waktu_dokter }}</td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" {{ $edukasiPasien->edukasi_dokter1 ? 'checked' : '' }}>
                                </td>
                                <td>Penjelasan penyakit, penyebab, tanda, gejala, prognosi dan terapi 
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->promotif_dokter_1 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->metode_dokter_1 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->profesional_dokter_1 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->evaluasi_dokter_1 ?? '-'}}</td>   
                    <td rowspan="9" class="tablee" style="vertical-align: middle; text-align: center;">
                        @if($edukasiPasien->ttd_pemberi_dokter)
                            <img src="{{ $edukasiPasien->ttd_pemberi_dokter}}"
                                 class="ttd-img1"
                                 alt="TTD Dokter">
                        @else
                            <div style="height: 50px;"></div>
                        @endif
                    
                        <div class="ttd-nama1">
                            ({{ $edukasiPasien->nama_pemberi_dokter ?? '-' }})
                        </div>
                    </td>

                    <td rowspan="9" class="tablee" style="vertical-align: middle; text-align: center;">
                        @if($edukasiPasien->ttd_penerima_dokter)
                            <img src="{{ $edukasiPasien->ttd_penerima_dokter }}"
                                 class="ttd-img1"
                                 alt="TTD Dokter">
                        @else
                            <div style="height: 50px;"></div>
                        @endif
                    
                        <div class="ttd-nama1">
                            ({{ $edukasiPasien->nama_penerima_dokter ?? '-' }})
                        </div>
                    </td>
                </tr>
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" {{ $edukasiPasien->edukasi_dokter2 ? 'checked' : '' }}>
                                </td>
                                <td>Hasil pemeriksaan penunjang  
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->promotif_dokter_2 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->metode_dokter_2 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->profesional_dokter_2 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->evaluasi_dokter_2 ?? '-'}}</td> 
                </tr>
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> 
                        <table >
                            <tr>
                                <td> <input type="checkbox" {{ $edukasiPasien->edukasi_dokter3 ? 'checked' : '' }}>
                                </td>
                                <td>Hasil pengobatan  
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->promotif_dokter_3 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->metode_dokter_3 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->profesional_dokter_3 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->evaluasi_dokter_3 ?? '-'}}</td>
                </tr>  
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" {{ $edukasiPasien->edukasi_dokter4 ? 'checked' : '' }}>
                                </td>
                                <td>Rencana penatalaksanaan/hasil yang tidak diharapkan 
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->promotif_dokter_4 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->metode_dokter_4 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->profesional_dokter_4 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->evaluasi_dokter_4 ?? '-'}}</td>
                </tr>
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" {{ $edukasiPasien->edukasi_dokter5 ? 'checked' : '' }}>
                                </td>
                                <td>Tindakan medis
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->promotif_dokter_5 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->metode_dokter_5 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->profesional_dokter_5 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->evaluasi_dokter_5 ?? '-'}}</td>
                </tr>   
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox"  {{ $edukasiPasien->edukasi_dokter6 ? 'checked' : '' }}>
                                </td>
                                <td>Nama obat, kegunaan, cara pemberian, efek samping dan interaksi  
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->promotif_dokter_6 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->metode_dokter_6 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->profesional_dokter_6 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->evaluasi_dokter_6 ?? '-'}}</td>
                </tr>  
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" {{ $edukasiPasien->edukasi_dokter7 ? 'checked' : '' }}>
                                </td>
                                <td>Perkiraan hari rawat 
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->promotif_dokter_7 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->metode_dokter_7 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->profesional_dokter_7 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->evaluasi_dokter_7 ?? '-'}}</td>
                </tr>  
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" {{ $edukasiPasien->edukasi_dokter8 ? 'checked' : '' }}>
                                </td>
                                <td>Komplikasi penyakit yang mungkin terjadi   
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->promotif_dokter_8 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->metode_dokter_8 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->profesional_dokter_8 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->evaluasi_dokter_8 ?? '-'}}</td>
                </tr>  
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox"  {{ $edukasiPasien->edukasi_dokter9 ? 'checked' : '' }}>
                                </td>
                                <td>Manajemen nyeri farmakologis  
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->promotif_dokter_9 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->metode_dokter_9 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->profesional_dokter_9 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->evaluasi_dokter_9 ?? '-'}}</td>
                </tr>  
                <tr class="tablee" style="padding: 5px; ">
                    <td rowspan="11" class="tablee"> Perawat/Bidan</td>
                    <td rowspan="11" class="tablee"> {{ $edukasiPasien->tanggal_perawat }}<br>{{ $edukasiPasien->waktu_perawat}}</td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" {{ $edukasiPasien->edukasi_perawat1 ? 'checked' : '' }}>
                                </td>
                                <td>Guna gelang nama
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->promotif_perawat_1 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->metode_perawat_1 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->profesional_perawat_1 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->evaluasi_perawat_1 ?? '-'}}</td>  
                    <td rowspan="11" class="tablee" style="vertical-align: middle; text-align: center;">
                        @if($edukasiPasien->ttd_pemberi_perawat)
                            <img src="{{ $edukasiPasien->ttd_pemberi_perawat }}"
                                 class="ttd-img1"
                                 alt="TTD Perawat">
                        @else
                            <div style="height: 50px;"></div>
                        @endif
                    
                        <div class="ttd-nama1">
                            ({{ $edukasiPasien->nama_pemberi_perawat ?? '-' }})
                        </div>
                    </td>

                    <td rowspan="11" class="tablee" style="vertical-align: middle; text-align: center;">
                        @if($edukasiPasien->ttd_penerima_perawat)
                            <img src="{{ $edukasiPasien->ttd_penerima_perawat }}"
                                 class="ttd-img1"
                                 alt="TTD Perawat">
                        @else
                            <div style="height: 50px;"></div>
                        @endif
                    
                        <div class="ttd-nama1">
                            ({{ $edukasiPasien->nama_penerima_perawat ?? '-' }})
                        </div>
                    </td>
               
                </tr>            
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" {{ $edukasiPasien->edukasi_perawat2 ? 'checked' : '' }}>
                                </td>
                                <td>Guna pemasangan infus
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->promotif_perawat_2 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->metode_perawat_2 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->profesional_perawat_2 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->evaluasi_perawat_2 ?? '-'}}</td>  
                </tr>
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" {{ $edukasiPasien->edukasi_perawat3 ? 'checked' : '' }}>
                                </td>
                                <td>Penundaan/terlambat  pelayanan, alasan alternatif lain 
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->promotif_perawat_3 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->metode_perawat_3 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->profesional_perawat_3 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->evaluasi_perawat_3 ?? '-'}}</td>   
                </tr>
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" {{ $edukasiPasien->edukasi_perawat4 ? 'checked' : '' }}>
                                </td>
                                <td>Penggunaan peralatan  medis yang aman 
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->promotif_perawat_4 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->metode_perawat_4 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->profesional_perawat_4 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->evaluasi_perawat_4 ?? '-'}}</td>    
                </tr>
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" {{ $edukasiPasien->edukasi_perawat5 ? 'checked' : '' }}>
                                </td>
                                <td>Manajemen nyeri farmakologis 
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->promotif_perawat_5 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->metode_perawat_5 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->profesional_perawat_5 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->evaluasi_perawat_5 ?? '-'}}</td>  
                </tr>
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox"  {{ $edukasiPasien->edukasi_perawat6 ? 'checked' : '' }}>
                                </td>
                                <td>Manajemen nyeri intervensi 
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->promotif_perawat_6 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->metode_perawat_6 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->profesional_perawat_6 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->evaluasi_perawat_6 ?? '-'}}</td>   
                </tr>
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" {{ $edukasiPasien->edukasi_tambahan1 ? 'checked' : '' }}>
                                </td>
                                <td>Edukasi persetujuan tindakan operasi 
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->promotif_tambahan1_1 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->metode_tambahan1_1 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->profesional_tambahan1_1 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->evaluasi_tambahan1_1 ?? '-'}}</td>  
                </tr>
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" {{ $edukasiPasien->edukasi_tambahan2 ? 'checked' : '' }}>
                                </td>
                                <td>Cara mencuci tangan yang benar 
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->promotif_tambahan1_2 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->metode_tambahan1_2 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->profesional_tambahan1_2 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->evaluasi_tambahan1_2 ?? '-'}}</td>   
                </tr>
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" {{ $edukasiPasien->edukasi_tambahan3 ? 'checked' : '' }}>
                                </td>
                                <td>Persetujuan biaya ... 
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->promotif_tambahan1_3 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->metode_tambahan1_3 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->profesional_tambahan1_3 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->evaluasi_tambahan1_3 ?? '-'}}</td>  
                </tr>
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" {{ $edukasiPasien->edukasi_tambahan4 ? 'checked' : '' }}>
                                </td>
                                <td>Pemberian imunisasi 
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->promotif_tambahan1_4 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->metode_tambahan1_4 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->profesional_tambahan1_4 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->evaluasi_tambahan1_4 ?? '-'}}</td>
                </tr>
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" {{ $edukasiPasien->edukasi_tambahan5 ? 'checked' : '' }}>
                                </td>
                                <td>Inisiasi menyusui dini   
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->promotif_tambahan1_5 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->metode_tambahan1_5 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->profesional_tambahan1_5 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->evaluasi_tambahan1_5 ?? '-'}}</td>  
                </tr>  
                <tr class="page-break" style="padding: 5px; ">
                    <td rowspan="5"  class="tablee td-center-nopad"></td>
                    <td rowspan="5" class="tablee td-center-nopad"></td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" {{ $edukasiPasien->edukasi_tambahan6 ? 'checked' : '' }}>
                                </td>
                                <td>Perawatan metode kangguru 
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->promotif_tambahan1_6 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->metode_tambahan1_6 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->profesional_tambahan1_6 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->evaluasi_tambahan1_6 ?? '-'}}</td>
                    <td rowspan="5" class="tablee td-center-nopad"></td>
                    <td rowspan="5" class="tablee td-center-nopad"></td>     
                </tr>
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" {{ $edukasiPasien->edukasi_tambahan7 ? 'checked' : '' }}>
                                </td>
                                <td>Cara merawat tali pusat dirumah 
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->promotif_tambahan1_7 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->metode_tambahan1_7 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->profesional_tambahan1_7 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->evaluasi_tambahan1_7 ?? '-'}}</td>   
                </tr>  
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" {{ $edukasiPasien->edukasi_tambahan8 ? 'checked' : '' }}>
                                </td>
                                <td>Imunisasi lanjutan  
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->promotif_tambahan1_8 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->metode_tambahan1_8 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->profesional_tambahan1_8 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->evaluasi_tambahan1_8 ?? '-'}}</td>   
                </tr>  
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" {{ $edukasiPasien->edukasi_tambahan9 ? 'checked' : '' }}>
                                </td>
                                <td>Intake output cairan   
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->promotif_tambahan1_9 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->metode_tambahan1_9 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->profesional_tambahan1_9 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->evaluasi_tambahan1_9 ?? '-'}}</td>   
                </tr>  
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" {{ $edukasiPasien->edukasi_tambahan10 ? 'checked' : '' }}>
                                </td>
                                <td>Pembatasan konsumsi ABG (air,buah,garam)  
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->promotif_tambahan1_10 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->metode_tambahan1_10 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->profesional_tambahan1_10 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->evaluasi_tambahan1_10 ?? '-'}}</td>  
                </tr>  
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee">Analisis/Lab  </td>
                    <td class="tablee">{{ $edukasiPasien->tanggal_analis }}<br>{{ $edukasiPasien->waktu_analis}}</td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" {{ $edukasiPasien->edukasi_analis ? 'checked' : '' }}>
                                </td>
                                <td>Pemeriksaan Lab 
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->promotif_analis ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->metode_analis ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->profesional_analis ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->evaluasi_analis ?? '-'}}</td>
                    <td  class="tablee" style="vertical-align: middle; text-align: center;">
                        @if($edukasiPasien->ttd_pemberi_analis)
                            <img src="{{ $edukasiPasien->ttd_pemberi_analis }}"
                                 class="ttd-img1"
                                 alt="TTD Analis Lab">
                        @else
                            <div style="height: 50px;"></div>
                        @endif
                    
                        <div class="ttd-nama1">
                            ({{ $edukasiPasien->nama_pemberi_analis?? '-' }})
                        </div>
                    </td>

                    <td class="tablee" style="vertical-align: middle; text-align: center;">
                        @if($edukasiPasien->ttd_penerima_analis)
                            <img src="{{ $edukasiPasien->ttd_penerima_analis }}"
                                 class="ttd-img1"
                                 alt="TTD Analis Lab">
                        @else
                            <div style="height: 50px;"></div>
                        @endif
                    
                        <div class="ttd-nama1">
                            ({{ $edukasiPasien->nama_penerima_analis ?? '-' }})
                        </div>
                    </td>   
                </tr>                      
                <tr class="tablee" style="padding: 5px; ">
                    <td rowspan="2" class="tablee">Ahli Gizi  </td>
                    <td rowspan="2" class="tablee">{{ $edukasiPasien->tanggal_gizi }}<br>{{ $edukasiPasien->waktu_gizi}}</td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" {{ $edukasiPasien->edukasi_gizi1 ? 'checked' : '' }}>
                                </td>
                                <td>Diet yang memadai/food mode 
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->promotif_gizi_1 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->metode_gizi_1 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->profesional_gizi_1 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->evaluasi_gizi_1 ?? '-'}}</td>   
                    <td rowspan="2" class="tablee" style="vertical-align: middle; text-align: center;">
                        @if($edukasiPasien->ttd_pemberi_gizi)
                            <img src="{{ $edukasiPasien->ttd_pemberi_gizi }}"
                                 class="ttd-img1"
                                 alt="TTD Ahli Gizi">
                        @else
                            <div style="height: 50px;"></div>
                        @endif
                    
                        <div class="ttd-nama1">
                            ({{ $edukasiPasien->nama_pemberi_gizi ?? '-' }})
                        </div>
                    </td>

                    <td rowspan="2" class="tablee" style="vertical-align: middle; text-align: center;">
                        @if($edukasiPasien->ttd_penerima_gizi)
                            <img src="{{ $edukasiPasien->ttd_penerima_gizi }}"
                                 class="ttd-img1"
                                 alt="TTD Ahli Gizi">
                        @else
                            <div style="height: 50px;"></div>
                        @endif
                    
                        <div class="ttd-nama1">
                            ({{ $edukasiPasien->nama_penerima_gizi ?? '-' }})
                        </div>
                    </td>
                </tr>
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" {{ $edukasiPasien->edukasi_gizi2 ? 'checked' : '' }}>
                                </td>
                                <td>Diet pasien pulang
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->promotif_gizi_2 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->metode_gizi_2 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->profesional_gizi_2 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->evaluasi_gizi_2 ?? '-'}}</td>  
                </tr>
                <tr class="tablee" style="padding: 5px; ">
                    <td rowspan="4" class="tablee">Farmasi  </td>
                    <td rowspan="4" class="tablee">{{$edukasiPasien->tanggal_farmasi}} <br> {{$edukasiPasien->waktu_farmasi}}</td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" {{ $edukasiPasien->edukasi_farmasi1 ? 'checked' : '' }}>
                                </td>
                                <td>Penggunaan obat-obatan secara efektif dan aman  
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->promotif_farmasi_1 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->metode_farmasi_1 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->profesional_farmasi_1 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->evaluasi_farmasi_1 ?? '-'}}</td>  
                    <td rowspan="4" class="tablee" style="vertical-align: middle; text-align: center;">
                        @if($edukasiPasien->ttd_pemberi_farmasi)
                            <img src="{{ $edukasiPasien->ttd_pemberi_farmasi }}"
                                 class="ttd-img1"
                                 alt="TTD Farmasi">
                        @else
                            <div style="height: 50px;"></div>
                        @endif
                    
                        <div class="ttd-nama1">
                            ({{ $edukasiPasien->nama_pemberi_farmasi ?? '-' }})
                        </div>
                    </td>

                    <td rowspan="4" class="tablee" style="vertical-align: middle; text-align: center;">
                        @if($edukasiPasien->ttd_penerima_farmasi)
                            <img src="{{ $edukasiPasien->ttd_penerima_farmasi }}"
                                 class="ttd-img1"
                                 alt="TTD Farmasi">
                        @else
                            <div style="height: 50px;"></div>
                        @endif
                    
                        <div class="ttd-nama1">
                            ({{ $edukasiPasien->nama_penerima_farmasi ?? '-' }})
                        </div>
                    </td>
                </tr>
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" {{ $edukasiPasien->edukasi_farmasi2 ? 'checked' : '' }}>
                                </td>
                                <td>Potensi efek samping obat 
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->promotif_farmasi_2 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->metode_farmasi_2 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->profesional_farmasi_2 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->evaluasi_farmasi_2 ?? '-'}}</td> 
                </tr>
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" {{ $edukasiPasien->edukasi_farmasi3 ? 'checked' : '' }}>
                                </td>
                                <td>Potensi interaksi obat antar obat konvensional, obat bebas, serta suplemen. 
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->promotif_farmasi_3 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->metode_farmasi_3 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->profesional_farmasi_3 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->evaluasi_farmasi_3 ?? '-'}}</td>  
                </tr>
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" {{ $edukasiPasien->edukasi_terapi ? 'checked' : '' }}>
                                </td>
                                <td>Terapi/obat pulang 
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->promotif_farmasi_4 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->metode_farmasi_4 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->profesional_farmasi_4 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->evaluasi_farmasi_4 ?? '-'}}</td>     
                </tr>
                <tr class="tablee" style="padding: 5px; ">
                    <td rowspan="2" class="tablee">Fisioterapis </td>
                    <td rowspan="2" class="tablee">{{$edukasiPasien->tanggal_fisio}} <br> {{$edukasiPasien->waktu_fisio}}</td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" {{ $edukasiPasien->edukasi_fisio1 ? 'checked' : '' }}>
                                </td>
                                <td>Tekhnik Rehabilitasi  
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->promotif_fisio_1 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->metode_fisio_1 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->profesional_fisio_1 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->evaluasi_fisio_1 ?? '-'}}</td> 
                    <td rowspan="2" class="tablee" style="vertical-align: middle; text-align: center;">
                        @if($edukasiPasien->ttd_pemberi_fisio)
                            <img src="{{ $edukasiPasien->ttd_pemberi_fisio }}"
                                 class="ttd-img1"
                                 alt="TTD Fisioterapis">
                        @else
                            <div style="height: 50px;"></div>
                        @endif
                    
                        <div class="ttd-nama1">
                            ({{ $edukasiPasien->nama_pemberi_fisio ?? '-' }})
                        </div>
                    </td>

                    <td rowspan="2" class="tablee" style="vertical-align: middle; text-align: center;">
                        @if($edukasiPasien->ttd_penerima_fisio)
                            <img src="{{ $edukasiPasien->ttd_penerima_fisio }}"
                                 class="ttd-img1"
                                 alt="TTD Fisioterapis">
                        @else
                            <div style="height: 50px;"></div>
                        @endif
                    
                        <div class="ttd-nama1">
                            ({{ $edukasiPasien->nama_penerima_fisio ?? '-' }})
                        </div>
                    </td>
                </tr>
                 <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" {{ $edukasiPasien->edukasi_fisio2 ? 'checked' : '' }}>
                                </td>
                                <td>Jenis-jenis Rehabilitasi
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->promotif_fisio_2 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->metode_fisio_2 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->profesional_fisio_2 ?? '-'}}</td>
                    <td class="tablee td-center-nopad"> {{ $edukasiPasien->evaluasi_fisio_2 ?? '-'}}</td> 
                </tr>   
              </table>
        </table>
    </div>
</body>

</html>