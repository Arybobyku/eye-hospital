<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM1.2</title>
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

        .page_break {
            page-break-before: always;
        }
    </style>

</head>
<body>
    <div style="position:fixed; right: 13px; bottom: 10px;"></div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 1.2/FEPDKRJ/22
        </div>
        
        <table style="border-collapse: collapse;">
            {{-- HEADER --}}
            @include('print-rekam-medis.partials.header')
            
            {{-- TITLE SECTION --}}
            <tr style="border: 1px solid black;">
                <td>
                    <div style="width: 100%; text-align: center; margin-top: 5px; font-weight: bold">
                        FORMULIR EDUKASI PASIEN DAN KELUARGA RAWAT JALAN
                    </div>
                    <div style="width: 100%; text-align: center; line-height: 21px; margin-bottom: 3px;">
                        <i>(BERI TANDA CHEKLIST PADA KOTAK YANG SESUAI DENGAN KEBUTUHAN PASIEN DAN KELUARGA)</i>
                    </div>
                </td>
            </tr>
            
            {{-- MAIN CONTENT SECTION --}}
            <tr style="border: 1px solid black;">
                <td>
                    <div class="sizesmall">
                        <table style="border-collapse: collapse; width:100%;">
                            <tr>
                                {{-- COLUMN 1: PENGKAJIAN HAMBATAN --}}
                                <td style="border-right: 1px solid black; width:33.33%; vertical-align: top; padding: 10px;">
                                    <b>Pengkajian Hambatan</b>
                                    <table style="border-collapse: collapse; width:100%; margin-top: 5px;">
                                        <tr>
                                            <td style="width: 5%;"><input type="checkbox" {{ $edukasiPasien->hambatan_bahasa ? 'checked' : '' }}></td>
                                            <td style="width: 47%;">Bahasa</td>
                                            <td style="width: 5%;"><input type="checkbox" {{ $edukasiPasien->hambatan_cemas ? 'checked' : '' }}></td>
                                            <td style="width: 43%;">Cemas</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" {{ $edukasiPasien->hambatan_pendengaran ? 'checked' : '' }}></td>
                                            <td>Pendegaran</td>
                                            <td><input type="checkbox" {{ $edukasiPasien->hambatan_emosi ? 'checked' : '' }}></td>
                                            <td>Emosi</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" {{ $edukasiPasien->hambatan_penglihatan ? 'checked' : '' }}></td>
                                            <td>Masalah penglihatan</td>
                                            <td><input type="checkbox" {{ $edukasiPasien->hambatan_kognitif ? 'checked' : '' }}></td>
                                            <td>Kongnitif</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" {{ $edukasiPasien->hambatan_bicara_buruk ? 'checked' : '' }}></td>
                                            <td>Bicara buruk</td>
                                            <td><input type="checkbox" {{ $edukasiPasien->hambatan_hilang_memori ? 'checked' : '' }}></td>
                                            <td>Hilang memori</td>
                                        </tr>
                                    </table>
                                    
                                    <table style="border-collapse: collapse; width:100%; margin-top: 5px;">
                                        <tr>
                                            <td style="width: 5%;"><input type="checkbox" {{ $edukasiPasien->hambatan_tidak_partisipasi ? 'checked' : '' }}></td>
                                            <td>Tidak ada partisipasi</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" {{ $edukasiPasien->hambatan_fisiologi ? 'checked' : '' }}></td>
                                            <td>Secara fisiologi tidak mampu belajar</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" {{ $edukasiPasien->hambatan_tidak_ada ? 'checked' : '' }}></td>
                                            <td>Tidak ditemukan hambatan belajar</td>
                                        </tr>
                                    </table>
                                    
                                    <table style="border-collapse: collapse; width:100%; margin-top: 15px;">
                                        <tr>
                                            <td colspan="2"><b>Edukasi</b></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 5%;"><input type="checkbox" {{ $edukasiPasien->edukasi_tata_tertib ? 'checked' : '' }}></td>
                                            <td>Tata Tertib RS</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" {{ $edukasiPasien->edukasi_hak_kewajiban ? 'checked' : '' }}></td>
                                            <td>Hak Dan Kewajiban Pasien</td>
                                        </tr>
                                    </table>
                                    
                                    <table style="border-collapse: collapse; width:100%; margin-top: 15px;">
                                        <tr>
                                            <td colspan="2"><b>Metode Cara Belajar Yang Disukai</b></td>
                                        </tr>
                                        <tr>
                                            <td>1 = Audio</td>
                                        </tr>
                                        <tr>
                                            <td>2 = Demonstrasi</td>
                                        </tr>
                                        <tr>
                                            <td>3 = Lisan</td>
                                        </tr>
                                        <tr>
                                            <td>4 = Tulisan</td>
                                        </tr>
                                        <tr>
                                            <td>5 = Visual</td>
                                        </tr>
                                    </table>
                                </td>
                                
                                {{-- COLUMN 2: PENGKAJIAN BICARA & DETAIL LAINNYA --}}
                                <td style="border-right: 1px solid black; width:33.33%; vertical-align: top; padding: 10px;">
                                    <b>Pengkajian Bicara:</b>
                                    <table style="border-collapse: collapse; width:100%; margin-top: 5px;">
                                        <tr>
                                            <td style="width: 5%;"><input type="checkbox" {{ $edukasiPasien->bicara_normal ? 'checked' : '' }}></td>
                                            <td style="width: 25%;">Normal</td>
                                            <td style="width: 5%;"><input type="checkbox" {{ $edukasiPasien->bicara_gangguan ? 'checked' : '' }}></td>
                                            <td style="width: 65%;">Gangguan Bicara</td>
                                        </tr>
                                    </table>
                                    
                                    <b style="display: block; margin-top: 15px;">Bahasa Sehari-hari:</b>
                                    <table style="border-collapse: collapse; width:100%; margin-top: 5px;">
                                        <tr>
                                            <td style="width: 5%;"><input type="checkbox" {{ $edukasiPasien->bahasa_indonesia ? 'checked' : '' }}></td>
                                            <td style="width: 25%;">Indonesia</td>
                                            <td style="width: 5%;"><input type="checkbox" {{ $edukasiPasien->bahasa_daerah ? 'checked' : '' }}></td>
                                            <td style="width: 65%;">Daerah {{ $edukasiPasien->bahasa_daerah_jelaskan ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" {{ $edukasiPasien->bahasa_inggris ? 'checked' : '' }}></td>
                                            <td>Inggris</td>
                                            <td><input type="checkbox" {{ $edukasiPasien->bahasa_lainnya ? 'checked' : '' }}></td>
                                            <td>Lainnya {{ $edukasiPasien->bahasa_lainnya_jelaskan ?? '' }}</td>
                                        </tr>
                                    </table>
                                    
                                    <table style="border-collapse: collapse; width:100%; margin-top: 10px;">
                                        <tr>
                                            <td style="width: 40%;"><b>Bahasa Isyarat:</b></td>
                                            <td style="width: 5%;"><input type="checkbox" {{ $edukasiPasien->bahasa_isyarat_ya ? 'checked' : '' }}></td>
                                            <td style="width: 25%;">Ya</td>
                                            <td style="width: 5%;"><input type="checkbox" {{ $edukasiPasien->bahasa_isyarat_tidak ? 'checked' : '' }}></td>
                                            <td style="width: 25%;">Tidak</td>
                                        </tr>
                                    </table>
                                    
                                    <b style="display: block; margin-top: 15px;">Tingkat Pendidikan:</b>
                                    <table style="border-collapse: collapse; width:100%; margin-top: 5px;">
                                        <tr>
                                            <td style="width: 5%;"><input type="checkbox" {{ $edukasiPasien->pendidikan_tk ? 'checked' : '' }}></td>
                                            <td style="width: 28%;">TK</td>
                                            <td style="width: 5%;"><input type="checkbox" {{ $edukasiPasien->pendidikan_sd ? 'checked' : '' }}></td>
                                            <td style="width: 28%;">SD</td>
                                            <td style="width: 5%;"><input type="checkbox" {{ $edukasiPasien->pendidikan_smp ? 'checked' : '' }}></td>
                                            <td style="width: 29%;">SMP</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" {{ $edukasiPasien->pendidikan_sma ? 'checked' : '' }}></td>
                                            <td>SMA</td>
                                            <td><input type="checkbox" {{ $edukasiPasien->pendidikan_diploma ? 'checked' : '' }}></td>
                                            <td>Diploma</td>
                                            <td><input type="checkbox" {{ $edukasiPasien->pendidikan_sarjana ? 'checked' : '' }}></td>
                                            <td>Sarjana</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" {{ $edukasiPasien->pendidikan_lainnya ? 'checked' : '' }}></td>
                                            <td colspan="5">Lain-lain {{ $edukasiPasien->pendidikan_lainnya_jelaskan ?? '' }}</td>
                                        </tr>
                                    </table>
                                    
                                    <b style="display: block; margin-top: 15px;">Agama:</b>
                                    <table style="border-collapse: collapse; width:100%; margin-top: 5px;">
                                        <tr>
                                            <td style="width: 5%;"><input type="checkbox" {{ $edukasiPasien->agama_islam ? 'checked' : '' }}></td>
                                            <td style="width: 28%;">Islam</td>
                                            <td style="width: 5%;"><input type="checkbox" {{ $edukasiPasien->agama_protestan ? 'checked' : '' }}></td>
                                            <td style="width: 28%;">Protestan</td>
                                            <td style="width: 5%;"><input type="checkbox" {{ $edukasiPasien->agama_katolik ? 'checked' : '' }}></td>
                                            <td style="width: 29%;">Katolik</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" {{ $edukasiPasien->agama_hindu ? 'checked' : '' }}></td>
                                            <td>Hindu</td>
                                            <td><input type="checkbox" {{ $edukasiPasien->agama_budha ? 'checked' : '' }}></td>
                                            <td>Budha</td>
                                            <td><input type="checkbox" {{ $edukasiPasien->agama_lainnya ? 'checked' : '' }}></td>
                                            <td>Lain-lain</td>
                                        </tr>
                                    </table>
                                    
                                    <b style="display: block; margin-top: 15px;">Tingkat Pengetahuan Kesehatan Pasien:</b>
                                    <table style="border-collapse: collapse; width:100%; margin-top: 5px;">
                                        <tr>
                                            <td style="width: 5%;"><input type="checkbox" {{ $edukasiPasien->pengetahuan_paham ? 'checked' : '' }}></td>
                                            <td style="width: 28%;">Paham</td>
                                            <td style="width: 5%;"><input type="checkbox" {{ $edukasiPasien->pengetahuan_kurang_paham ? 'checked' : '' }}></td>
                                            <td style="width: 28%;">Kurang paham</td>
                                            <td style="width: 5%;"><input type="checkbox" {{ $edukasiPasien->pengetahuan_tidak_paham ? 'checked' : '' }}></td>
                                            <td style="width: 29%;">Tidak paham</td>
                                        </tr>
                                    </table>
                                    
                                    <b style="display: block; margin-top: 15px;">Nilai-nilai Pasien Dan Budaya:</b>
                                    <table style="border-collapse: collapse; width:100%; margin-top: 5px;">
                                        <tr>
                                            <td style="width: 5%;"><input type="checkbox" {{ $edukasiPasien->budaya_modern ? 'checked' : '' }}></td>
                                            <td style="width: 28%;">Modern</td>
                                            <td style="width: 5%;"><input type="checkbox" {{ $edukasiPasien->budaya_moderat ? 'checked' : '' }}></td>
                                            <td style="width: 28%;">Moderat</td>
                                            <td style="width: 5%;"><input type="checkbox" {{ $edukasiPasien->budaya_konvensional ? 'checked' : '' }}></td>
                                            <td style="width: 29%;">Konvesional</td>
                                        </tr>
                                    </table>
                                    
                                    <table style="border-collapse: collapse; width:100%; margin-top: 10px;">
                                        <tr>
                                            <td style="width: 30%;">Merokok</td>
                                            <td style="width: 5%;">:</td>
                                            <td style="width: 5%;"><input type="checkbox" {{ $edukasiPasien->merokok_ya ? 'checked' : '' }}></td>
                                            <td style="width: 25%;">Ya</td>
                                            <td style="width: 5%;"><input type="checkbox" {{ $edukasiPasien->merokok_tidak ? 'checked' : '' }}></td>
                                            <td style="width: 30%;">Tidak</td>
                                        </tr>
                                        <tr>
                                            <td>Konsumsi Alkohol</td>
                                            <td>:</td>
                                            <td><input type="checkbox" {{ $edukasiPasien->alkohol_ya ? 'checked' : '' }}></td>
                                            <td>Ya</td>
                                            <td><input type="checkbox" {{ $edukasiPasien->alkohol_tidak ? 'checked' : '' }}></td>
                                            <td>Tidak</td>
                                        </tr>
                                    </table>
                                    
                                    <b style="display: block; margin-top: 15px;">Kesedian Menerima Informasi:</b>
                                    <table style="border-collapse: collapse; width:100%; margin-top: 5px;">
                                        <tr>
                                            <td style="width: 5%;"><input type="checkbox" {{ $edukasiPasien->menerima_informasi_ya ? 'checked' : '' }}></td>
                                            <td style="width: 25%;">Ya</td>
                                            <td style="width: 5%;"><input type="checkbox" {{ $edukasiPasien->menerima_informasi_tidak ? 'checked' : '' }}></td>
                                            <td style="width: 65%;">Tidak, alasan: {{ $edukasiPasien->menerima_informasi_alasan ?? '' }}</td>
                                        </tr>
                                    </table>
                                    
                                    <b style="display: block; margin-top: 15px;">Rencana Pendidikan Kesehatan:</b>
                                    <table style="border-collapse: collapse; width:100%; margin-top: 5px;">
                                        <tr>
                                            <td style="width: 5%;"><input type="checkbox" {{ $edukasiPasien->rencana_proses_penyakit ? 'checked' : '' }}></td>
                                            <td>Proses Penyakit</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" {{ $edukasiPasien->rencana_pengobatan ? 'checked' : '' }}></td>
                                            <td>Pengobatan/Tindakan</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" {{ $edukasiPasien->rencana_nutrisi ? 'checked' : '' }}></td>
                                            <td>Nutrisi</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" {{ $edukasiPasien->rencana_edukasi_kolaboratif ? 'checked' : '' }}></td>
                                            <td>Edukasi Kolaboratif</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" {{ $edukasiPasien->rencana_lain_lain ? 'checked' : '' }}></td>
                                            <td>Lain-lain: {{ $edukasiPasien->rencana_lain_lain_jelaskan ?? '' }}</td>
                                        </tr>
                                    </table>
                                </td>
                                
                                {{-- COLUMN 3: PENERIMA PENDIDIKAN --}}
                                <td style="width:33.33%; vertical-align: top; padding: 10px;">
                                    <b>Penerima Pendidikan</b>
                                    <table style="border-collapse: collapse; width:100%; margin-top: 5px;">
                                        <tr>
                                            <td>P = Pasien</td>
                                        </tr>
                                        <tr>
                                            <td>K = Keluarga</td>
                                        </tr>
                                        <tr>
                                            <td>L = Lain-lain</td>
                                        </tr>
                                    </table>
                                    
                                    <b style="display: block; margin-top: 20px;">Frekuensi Edukasi</b>
                                    <table style="border-collapse: collapse; width:100%; margin-top: 5px;">
                                        <tr>
                                            <td>1 = Edukasi Pertama</td>
                                        </tr>
                                        <tr>
                                            <td>2 = Re-edukasi ke 2/3 atau lebih</td>
                                        </tr>
                                    </table>
                                    
                                    <b style="display: block; margin-top: 20px;">Evaluasi Respon</b>
                                    <table style="border-collapse: collapse; width:100%; margin-top: 5px;">
                                        <tr>
                                            <td>1 = Tidak Mengerti</td>
                                        </tr>
                                        <tr>
                                            <td>2 = Menyatakan Paham</td>
                                        </tr>
                                        <tr>
                                            <td>3 = Mampu Menjelaskan</td>
                                        </tr>
                                        <tr>
                                            <td>4 = Mampu Demonstrasi/Simulasi</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            
            {{-- KEBUTUHAN PRIVASI --}}
            <tr style="border: 1px solid black;">
                <td>
                    <table style="border-collapse: collapse; width:100%; padding: 5px;">
                        <tr>
                            <td style="width: 20%;">Kebutuhan Privasi:</td>
                            <td style="width: 5%;"><input type="checkbox" {{ $edukasiPasien->privasi_ya ? 'checked' : '' }}></td>
                            <td style="width: 10%;">Ya</td>
                            <td style="width: 5%;"><input type="checkbox" {{ $edukasiPasien->privasi_tidak ? 'checked' : '' }}></td>
                            <td style="width: 60%;">Tidak</td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            {{-- PENGKAJI INFO --}}
            <tr style="border: 1px solid black;">
                <td>
                    <table style="border-collapse: collapse; width:100%; padding: 5px;">
                        <tr>
                            <td style="width: 30%;">Nama Pengkaji: {{ $edukasiPasien->nama_pengkaji ?? '...............' }}</td>
                            <td style="width: 21%;">Tanggal: {{ $edukasiPasien->tanggal_pengkaji ? \Carbon\Carbon::parse($edukasiPasien->tanggal_pengkaji)->format('d/m/Y') : '...............' }}</td>
                            <td style="width: 17%;">Jam: {{ $edukasiPasien->waktu_pengkaji ? \Carbon\Carbon::parse($edukasiPasien->waktu_pengkaji)->format('H:i') : '...............' }}</td>
                            <td style="width: 17%;">Tanda Tangan: </td>
                            <td style="width: 15%; text-align: center;">
                                @if($edukasiPasien->ttd_pengkaji)
                                    <img src="{{ $edukasiPasien->ttd_pengkaji }}" style="max-width: 150px; max-height: 80px;" alt="TTD Pengkaji">
                                @else
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        {{-- TABLE EDUKASI DETAIL --}}
        <table class="tablee sizesmall" style="width:100%; border-collapse: collapse;">
            <thead>
                <tr class="tablee">
                    <th class="tablee">Tanggal</th>
                    <th class="tablee">Poliklinik</th>
                    <th class="tablee">Penjelasan Edukasi Tentang</th>
                    <th class="tablee">Tanda Tangan nama Petugas & Profesi</th>
                    <th class="tablee">Sasaran Edukasi (Nama & Hubungannya Dengan Pasien)</th>
                    <th class="tablee">Evaluasi</th>
                </tr>
            </thead>
            <tbody>
                {{-- ROW 1 --}}
                <tr class="tablee">
                    <td class="tablee">{{ $edukasiPasien->row1_tanggal ? \Carbon\Carbon::parse($edukasiPasien->row1_tanggal)->format('d/m/Y') : '' }}</td>
                    <td class="tablee">{{ $edukasiPasien->row1_poliklinik ?? '' }}</td>
                    <td class="tablee">{{ $edukasiPasien->row1_penjelasan_edukasi ?? '' }}</td>
                    <td class="tablee">{{ $edukasiPasien->row1_ttd_petugas ?? '' }}</td>
                    <td class="tablee">{{ $edukasiPasien->row1_sasaran_edukasi ?? '' }}</td>
                    <td class="tablee">
                        <table style="border: none;">
                            <tr>
                                <td style="border: none;"><input type="checkbox" {{ $edukasiPasien->row1_eval_sudah_dimengerti ? 'checked' : '' }} disabled></td>
                                <td style="border: none;">Sudah Dimengerti</td>
                            </tr>
                            <tr>
                                <td style="border: none;"><input type="checkbox" {{ $edukasiPasien->row1_eval_re_demonstrasi ? 'checked' : '' }} disabled></td>
                                <td style="border: none;">Re-Demonstrasi</td>
                            </tr>
                            <tr>
                                <td style="border: none;"><input type="checkbox" {{ $edukasiPasien->row1_eval_re_edukasi ? 'checked' : '' }} disabled></td>
                                <td style="border: none;">Re Edukasi</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                
                {{-- ROW 2 --}}
                <tr class="tablee">
                    <td class="tablee">{{ $edukasiPasien->row2_tanggal ? \Carbon\Carbon::parse($edukasiPasien->row2_tanggal)->format('d/m/Y') : '' }}</td>
                    <td class="tablee">{{ $edukasiPasien->row2_poliklinik ?? '' }}</td>
                    <td class="tablee">{{ $edukasiPasien->row2_penjelasan_edukasi ?? '' }}</td>
                    <td class="tablee">{{ $edukasiPasien->row2_ttd_petugas ?? '' }}</td>
                    <td class="tablee">{{ $edukasiPasien->row2_sasaran_edukasi ?? '' }}</td>
                    <td class="tablee">
                        <table style="border: none;">
                            <tr>
                                <td style="border: none;"><input type="checkbox" {{ $edukasiPasien->row2_eval_sudah_dimengerti ? 'checked' : '' }} disabled></td>
                                <td style="border: none;">Sudah Dimengerti</td>
                            </tr>
                            <tr>
                                <td style="border: none;"><input type="checkbox" {{ $edukasiPasien->row2_eval_re_demonstrasi ? 'checked' : '' }} disabled></td>
                                <td style="border: none;">Re-Demonstrasi</td>
                            </tr>
                            <tr>
                                <td style="border: none;"><input type="checkbox" {{ $edukasiPasien->row2_eval_re_edukasi ? 'checked' : '' }} disabled></td>
                                <td style="border: none;">Re Edukasi</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                
                {{-- ROW 3 --}}
                <tr class="tablee">
                    <td class="tablee">{{ $edukasiPasien->row3_tanggal ? \Carbon\Carbon::parse($edukasiPasien->row3_tanggal)->format('d/m/Y') : '' }}</td>
                    <td class="tablee">{{ $edukasiPasien->row3_poliklinik ?? '' }}</td>
                    <td class="tablee">{{ $edukasiPasien->row3_penjelasan_edukasi ?? '' }}</td>
                    <td class="tablee">{{ $edukasiPasien->row3_ttd_petugas ?? '' }}</td>
                    <td class="tablee">{{ $edukasiPasien->row3_sasaran_edukasi ?? '' }}</td>
                    <td class="tablee">
                        <table style="border: none;">
                            <tr>
                                <td style="border: none;"><input type="checkbox" {{ $edukasiPasien->row3_eval_sudah_dimengerti ? 'checked' : '' }} disabled></td>
                                <td style="border: none;">Sudah Dimengerti</td>
                            </tr>
                            <tr>
                                <td style="border: none;"><input type="checkbox" {{ $edukasiPasien->row3_eval_re_demonstrasi ? 'checked' : '' }} disabled></td>
                                <td style="border: none;">Re-Demonstrasi</td>
                            </tr>
                            <tr>
                                <td style="border: none;"><input type="checkbox" {{ $edukasiPasien->row3_eval_re_edukasi ? 'checked' : '' }} disabled></td>
                                <td style="border: none;">Re Edukasi</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body

<?php

// function bulans($bln)
// {
//     if ($bln == '01') {
//         $bln = 'Januari';
//     } elseif ($bln == '02') {
//         $bln = 'Februari';
//     } elseif ($bln == '03') {
//         $bln = 'Maret';
//     } elseif ($bln == '04') {
//         $bln = 'April';
//     } elseif ($bln == '05') {
//         $bln = 'Mei';
//     } elseif ($bln == '06') {
//         $bln = 'Juni';
//     } elseif ($bln == '07') {
//         $bln = 'Juli';
//     } elseif ($bln == '08') {
//         $bln = 'Agustus';
//     } elseif ($bln == '09') {
//         $bln = 'September';
//     } elseif ($bln == '10') {
//         $bln = 'Oktober';
//     } elseif ($bln == '11') {
//         $bln = 'November';
//     } elseif ($bln == '12') {
//         $bln = 'Desember';
//     }
//     return $bln;
// }

?>

</html>