<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM1.10/PPPO/22</title>
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

        .tablee1dot10 {
            border: 1px solid black;
            border-collapse: collapse;
        }
        .table1dot102{
            border-bottom: 1px solid black;
            border-left: 1px solid black;
            border-right: 1px solid black;
        }
        .smallfont1dot10{
            font-size: 9;
        }
        .smallfont1dot102{
            font-size: 10;
        }

        .page_break1dot10 {
            page-break-before: always;
        }
    </style>

</head>

<body>
    
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>

        <div class="wrap">
            <div style="width:100%; text-align:right; margin-bottom:5px">
                RM 1.10/PPPO/22
            </div>
            @include('print-rekam-medis.partials.header')
        </div>
        <table style="width: 100%;">
            <tr>
                <td style="text-align: center"><b>PROSES PERAWATAN PERI OPERATIVE</b></td>
            </tr>
            <tr>
                <td style="text-align: center"><i>Peri-Operative Care Process</i></td>
            </tr>
        </table>
        <table style="width: 100%; border:1px solid">
            <tr>
                <td style="text-align: center">
                    Tanggal : 
                    @if($perawatanPeriOperative->tanggal)
                        @php
                            $dt = \Carbon\Carbon::parse($perawatanPeriOperative->tanggal);
                        @endphp
                        {{ $dt->format('d') }}
                        {{ formatBulan($dt->format('m')) }}
                        {{ $dt->format('Y') }}
                    @endif
                </td>
                <td style="text-align: center">
                    Jam : 
                    @if($perawatanPeriOperative->waktu)
                        {{ $perawatanPeriOperative->waktu }}
                    @endif
                    WIB
                </td>
            </tr>
        </table>
        <table class="table1dot102" style="width: 100%;">
            <tr>
                <td class="smallfont1dot102" style="padding: 5px;"><b>A. CATATAN PERAWATAN SEBELUM OPERASI :</b> Bagian ini diisi oleh Perawat Ruangan</td>
            </tr>
            <tr>
                <td>
                    <table class="tablee1dot10" style="width:100%; padding:8px">
                        <tr class="tablee1dot10">
                            <td class="tablee1dot10" style="padding: 5px">Ruangan : {{ $perawatanPeriOperative->ruangan ?? '' }}</td>
                            <td class="tablee1dot10" style="padding: 5px">
                                <table>
                                    <tr>
                                        <td>Jenis Pasien : </td>
                                        <td><input type="checkbox" {{ $perawatanPeriOperative->jenis_pasien == 'Umum' ? 'checked' : '' }}></td>
                                        <td>Umum</td>
                                        <td><input type="checkbox" {{ $perawatanPeriOperative->jenis_pasien == 'Asuransi' ? 'checked' : '' }}></td>
                                        <td>Asuransi</td>
                                        <td><input type="checkbox" {{ $perawatanPeriOperative->jenis_pasien == 'BPJS' ? 'checked' : '' }}></td>
                                        <td>BPJS</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="tablee1dot10" style="padding: 5px">Diagnosis : {{ $perawatanPeriOperative->diagnosis ?? '' }}</td>
                            <td class="tablee1dot10" style="padding: 5px">Tindakan Operasi : {{ $perawatanPeriOperative->tindakan_operasi ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="tablee1dot10" style="padding: 5px">Dokter Operator : {{ $perawatanPeriOperative->dokter_operator ?? '' }}</td>
                            <td class="tablee1dot10" style="padding: 5px">Dokter Anestesi : {{ $perawatanPeriOperative->dokter_anestesi ?? '' }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="smallfont1dot10">
                    <table style="padding: 5px">
                        <tr>
                            <td>1. Vital Sign :</td>
                            <td>Temp: <b>{{ $perawatanPeriOperative->vital_temp ?? '' }}</b> Nadi <b>{{ $perawatanPeriOperative->vital_nadi ?? '' }}</b> Pernafasan: <b>{{ $perawatanPeriOperative->vital_pernapasan ?? '' }}</b> Tekanan Darah: <b>{{ $perawatanPeriOperative->vital_tekanan_darah ?? '' }}</b> Tinggi: <b>{{ $perawatanPeriOperative->vital_tinggi ?? '' }} cm</b>, Berat:<b>{{ $perawatanPeriOperative->vital_berat ?? '' }} kg</b></td>
                        </tr>
                        <tr>
                            <td>2. Riwayat Penyakit :</td>
                            <td>
                                <table>
                                    <tr>
                                        <td><input type="checkbox" {{ $perawatanPeriOperative->riwayat_hipertensi ? 'checked' : '' }}></td>
                                        <td>Hipertensi</td> 
                                        <td><input type="checkbox" {{ $perawatanPeriOperative->riwayat_diabetes ? 'checked' : '' }}></td>
                                        <td>Diabetes</td>  
                                        <td><input type="checkbox" {{ $perawatanPeriOperative->riwayat_hepatitis ? 'checked' : '' }}></td>
                                        <td>Hepatitis</td>  
                                        <td><input type="checkbox" {{ $perawatanPeriOperative->riwayat_lainnya ? 'checked' : '' }}></td>
                                        <td>Lain lain: {{ $perawatanPeriOperative->riwayat_lainnya_text ?? '' }}</td>  
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>3. Alergi :</td>
                            <td>
                                <table>
                                    <tr>
                                        <td><input type="checkbox" {{ $perawatanPeriOperative->alergi_tidak_tahu ? 'checked' : '' }}></td>
                                        <td>Tidak Tahu</td> 
                                        <td><input type="checkbox" {{ $perawatanPeriOperative->alergi_ya ? 'checked' : '' }}></td>
                                        <td>Ya : {{ $perawatanPeriOperative->alergi_ya_text ?? '' }}</td>  
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>4. Hasil KGD :</td>
                            <td><b>{{ $perawatanPeriOperative->hasil_kgd ?? '' }}</b> Waktu Pengambilan Pukul : <b>{{ $perawatanPeriOperative->waktu_pengambilan_kgd ?? '' }} WIB</b></td>
                        </tr>
                    </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="smallfont1dot102" style="padding: 5px;"><b>B. CATATAN PERAWATAN SEBELUM OPERASI :</b> Bagian ini dilengkapi oleh Perawat Ruangan dan Perawat Kamar Operasi</td>
            </tr>
            <tr>
                <td>
                    <div class="smallfont1dot10">
                        <table style="margin-left: 50px;">
                            <tr>
                                <td><input type="checkbox"></td>
                                <td>Ya</td>
                                <td style="padding-left: 10px"><input type="checkbox"></td>
                                <td>Tidak</td>
                                <td style="padding-left: 10px"><input type="checkbox"></td>
                                <td>N/A</td>
                                <td style="padding-left: 10px">Tidak Tersedia</td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <table style="width: 100%; border-collapse:collapse;">
                        <tr>
                            <th style="width:50%;"></th>
                            <th class="tablee1dot10" style="width:10%">Ruang</th>
                            <th class="tablee1dot10" style="width:5%">OK</th>
                            <th class="tablee1dot10" style="width: 5%">OK</th>
                            <th class="tablee1dot10" style="width: 30%">Keterangan</th>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">1. Pemeriksaan Identitas Pasien</div></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_1_identitas_ruang ? 'checked' : '' }}></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_1_identitas_ok1 ? 'checked' : '' }}></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_1_identitas_ok2 ? 'checked' : '' }}></td>
                            <td style="text-align: center">{{ $perawatanPeriOperative->checklist_1_keterangan ?? '' }}</td>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">2. Pemeriksaan Gelang Nama</div></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_2_gelang_ruang ? 'checked' : '' }}></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_2_gelang_ok1 ? 'checked' : '' }}></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_2_gelang_ok2 ? 'checked' : '' }}></td>
                            <td style="text-align: center">{{ $perawatanPeriOperative->checklist_2_keterangan ?? '' }}</td>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">3. Formulir Persetujuan Operasi</div></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_3_persetujuan_ruang ? 'checked' : '' }}></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_3_persetujuan_ok1 ? 'checked' : '' }}></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_3_persetujuan_ok2 ? 'checked' : '' }}></td>
                            <td style="text-align: center">{{ $perawatanPeriOperative->checklist_3_keterangan ?? '' }}</td>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">4. Pemberian Premedikasi</div></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_4_premedikasi_ruang ? 'checked' : '' }}></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_4_premedikasi_ok1 ? 'checked' : '' }}></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_4_premedikasi_ok2 ? 'checked' : '' }}></td>
                            <td style="text-align: center">{{ $perawatanPeriOperative->checklist_4_keterangan ?? '' }}</td>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">5. Pemberian Makanan dan Minum yang terakhir</div></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_5_makan_minum_ruang ? 'checked' : '' }}></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_5_makan_minum_ok1 ? 'checked' : '' }}></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_5_makan_minum_ok2 ? 'checked' : '' }}></td>
                            <td style="text-align: center">{{ $perawatanPeriOperative->checklist_5_keterangan ?? '' }}</td>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">6. Alat Prothesa Luar, mis: Gigi Palsu, Kontak Lensa</div></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_6_prothesa_ruang ? 'checked' : '' }}></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_6_prothesa_ok1 ? 'checked' : '' }}></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_6_prothesa_ok2 ? 'checked' : '' }}></td>
                            <td style="text-align: center">{{ $perawatanPeriOperative->checklist_6_keterangan ?? '' }}</td>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">7. Penjepit Rambut/Cat Kuku/Perhiasan</div></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_7_perhiasan_ruang ? 'checked' : '' }}></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_7_perhiasan_ok1 ? 'checked' : '' }}></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_7_perhiasan_ok2 ? 'checked' : '' }}></td>
                            <td style="text-align: center">{{ $perawatanPeriOperative->checklist_7_keterangan ?? '' }}</td>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">8. Status Pasien Terlampir</div></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_8_status_ruang ? 'checked' : '' }}></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_8_status_ok1 ? 'checked' : '' }}></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_8_status_ok2 ? 'checked' : '' }}></td>
                            <td style="text-align: center">{{ $perawatanPeriOperative->checklist_8_keterangan ?? '' }}</td>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">9. X-Ray/Scan *Pasien Terlampir</div></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_9_xray_ruang ? 'checked' : '' }}></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_9_xray_ok1 ? 'checked' : '' }}></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_9_xray_ok2 ? 'checked' : '' }}></td>
                            <td style="text-align: center">{{ $perawatanPeriOperative->checklist_9_keterangan ?? '' }}</td>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">10. Persiapan Pencukuran Bulu Mata</div></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_10_pencukuran_ruang ? 'checked' : '' }}></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_10_pencukuran_ok1 ? 'checked' : '' }}></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_10_pencukuran_ok2 ? 'checked' : '' }}></td>
                            <td style="text-align: center">{{ $perawatanPeriOperative->checklist_10_keterangan ?? '' }}</td>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">11. Pemeriksaan Darah (PMI/Lab. R.S*)</div></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_11_darah_ruang ? 'checked' : '' }}></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_11_darah_ok1 ? 'checked' : '' }}></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_11_darah_ok2 ? 'checked' : '' }}></td>
                            <td style="text-align: center">{{ $perawatanPeriOperative->checklist_11_keterangan ?? '' }}</td>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">12. Site Marker</div></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_12_site_marker_ruang ? 'checked' : '' }}></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_12_site_marker_ok1 ? 'checked' : '' }}></td>
                            <td style="text-align: center"><input type="checkbox" {{ $perawatanPeriOperative->checklist_12_site_marker_ok2 ? 'checked' : '' }}></td>
                            <td style="text-align: center">{{ $perawatanPeriOperative->checklist_12_keterangan ?? '' }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <br>
            <tr>
                <td>
                    <table style="margin-left:20%;">
                        <tr>
                            <td>Diperiksa Oleh :</td>
                            <td>Perawat Ruangan</td>
                            <td>: {{ $perawatanPeriOperative->nama_perawat_ruangan ?? '' }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Perawat Kamar Bedah</td>
                            <td>: {{ $perawatanPeriOperative->nama_perawat_kamar_bedah ?? '' }}</td>
                        </tr>
                        <tr>  
                            <td>
                                Tanggal : 
                                @if($perawatanPeriOperative->ttd_perawat_ruangan_tanggal)
                                    @php
                                        $dt = \Carbon\Carbon::parse($perawatanPeriOperative->ttd_perawat_ruangan_tanggal);
                                    @endphp
                                    {{ $dt->format('d') }}
                                    {{ formatBulan($dt->format('m')) }}
                                    {{ $dt->format('Y') }}
                                @endif
                            </td>
                            <td colspan="2">
                                Pukul: 
                                @if($perawatanPeriOperative->ttd_perawat_ruangan_waktu)
                                    {{ $perawatanPeriOperative->ttd_perawat_ruangan_waktu }}
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <br>
        </table>

</body>

</html>