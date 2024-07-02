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

        .tablee {
            border: 1px solid black;
            border-collapse: collapse;
        }
        .table2{
            border-bottom: 1px solid black;
            border-left: 1px solid black;
            border-right: 1px solid black;
        }
        .smallfont{
            font-size: 9;
        }
        .smallfont2{
            font-size: 10;
        }

        .page_break {
            page-break-before: always;
        }
    </style>

</head>

<body>
    
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>

        <div class="wrap">
            <div style="width:100%; text-align:right; margin-bottom:5px">
                RM 1.7/RMRJ/22
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
                <td style="text-align: center">Tanggal : {{ $ppo->tanggal }}</td>
                <td style="text-align: center">Jam : {{ $ppo->jam }} WIB</td>
            </tr>
        </table>
        <table class="table2" style="width: 100%;">
            <tr>
                <td class="smallfont2" style="padding: 5px;"><b>A. CATATAN PERAWATAN SEBELUM OPERASI :</b>Bagian ini diisi oleh Perawat Ruangan</td>
            </tr>
            <tr>
                <td>
                    <table class="tablee" style="width:100%; padding:8px">
                        <tr class="tablee">
                            <td class="tablee" style="padding: 5px">Ruangan : {{ $ppo->ruangan }}</td>
                            <td class="tablee" style="padding: 5px"><table>
                                <tr>
                                    <td>Jenis Pasien : </td>
                                    <td><input type="checkbox" {{ $roperasi->jenis_pembayaran == 'Umum' ? 'Checked' : '' }}></td>
                                    <td>Umum</td>
                                    <td><input type="checkbox" {{ $roperasi->jenis_pembayaran == 'Asuransi' ? 'Checked' : '' }}></td>
                                    <td>Asuransi</td>
                                    <td><input type="checkbox" {{ $roperasi->jenis_pembayaran == 'BPJS Kesehatan' ? 'Checked' : '' }}></td>
                                    <td>Bpjs</td>
                                </tr>
                            </table>
                        </td>
                        </tr>
                        <tr>
                            <td class="tablee" style="padding: 5px">Diagnosis : {{ $ppo->diagnosis }}</td>
                            <td class="tablee" style="padding: 5px">Tindakan Operasi : {{ $ppo->tindakan_operasi }}</td>
                        </tr>
                        <tr>
                            <td class="tablee" style="padding: 5px">Dokter Operator : {{ $ppo->dokter_operator }}</td>
                            <td class="tablee" style="padding: 5px">Dokter Anastesi : {{ $ppo->dokter_anastesi }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="smallfont">
                    <table style="padding: 5px">
                        <tr>
                            <td>1. Vital Sign :</td>
                            <td>Temp: <b>{{ $ppo->vs_temp }} </b> Nadi <b> {{ $ppo->vs_nadi }} </b> Pernafasan: <b> {{ $ppo->vs_pernapasan }} </b> Tekanan Darah: <b> {{ $ppo->vs_tekanan_darah }} </b> Tinggi: <b> {{ $ppo->vs_tinggi }} cm </b>, Berat:<b> {{ $ppo->vs_berat }} kg </b></td>
                        </tr>
                        <tr>
                            <td>2. Riwayat Penyakit :</td>
                            <td> <table>
                                <tr>
                                    <td><input type="checkbox" {{ $ro->penyakit_pernah_diderita_show == '1' ? 'Checked' : '' }}></td>
                                    <td>Hipertensi</td> 
                                    <td><input type="checkbox" {{ $ro->penyakit_pernah_diderita_show == '0' ? 'Checked' : '' }}></td>
                                    <td>Diabetes</td>  
                                    <td><input type="checkbox" {{ $ro->penyakit_pernah_diderita_show == '4' ? 'Checked' : '' }}></td>
                                    <td>Hepatitis</td>  
                                    <td><input type="checkbox" {{ $ro->penyakit_pernah_diderita_lainnya != '' ? 'Checked' : '' }}></td>
                                    <td>Lain lain: {{ $ro->penyakit_pernah_diderita_lainnya }}</td>  
                                </tr></table></td>
                        </tr>
                        <tr>
                            <td>3. Alergi :</td>
                            <td> <table>
                                <tr>
                                    <td><input type="checkbox" {{ $ppo->alergi_obatan == '' ? 'Checked' : '' }}></td>
                                    <td>Tidak Ada</td> 
                                    <td><input type="checkbox" {{ $ppo->alergi_obatan != '' ? 'Checked' : '' }}></td>
                                    <td>Ya : {{ $ppo->alergi_obatan }} </td>  
                                </tr></table></td>
                        </tr>
                        <tr>
                            <td>4. Hasil KGD :</td>
                            <td> <b>{{ $ppo->hasil_kgd }}</b> Waktu Pengambilan Pukul : <b> {{ $ppo->waktu_pengambilan_kgd }} WIB</b></td>
                        </tr>
                    </table>
                    </div>
                </td>
            </tr>
            <tr>
                    <td class="smallfont2" style="padding: 5px;"><b>B. CATATAN PERAWATAN SEBELUM OPERASI :</b>Bagian ini dlengkapi oleh Perawat Ruangan dan Perawat Kamar Operasi</td>
            </tr>
            <tr>
                <td>
                    <div class="smallfont">
                        <table style="margin-left: 50px;">
                            <tr>
                                <td><input type="checkbox" checked></td>
                                <td>Ya</td>
                                <td style="padding-left: 10px"><input type="checkbox" checked></td>
                                <td>Tidak</td>
                                <td style="padding-left: 10px"><input type="checkbox" checked></td>
                                <td>N/A </td>
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
                            <th class="tablee" style="width:10%">Ruang</th>
                            <th class="tablee" style="width:5%">OK</th>
                            <th class="tablee" style="width: 5%">OK</th>
                            <th class="tablee" style="width: 30%">Keterangan</th>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">1. Pemeriksaan Identitas Pasien</div></td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->r_pemeriksaan_identitas_pasien == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->ok1_pemeriksaan_identitas_pasien == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->ok2_pemeriksaan_identitas_pasien == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center">{{ $ppo->pemeriksaan_identitas_pasien_ket }}</td>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">2. Pemeriksaan Gelang Nama</div></td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->r_pemeriksaan_gelang_nama == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->ok1_pemeriksaan_gelang_nama == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->ok2_pemeriksaan_gelang_nama == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center">{{ $ppo->pemeriksaan_gelang_nama_ket }}</td>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">3. Formulir Persetujuan Operasi</div></td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->r_formulir_persetujuan_operasi == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->ok1_formulir_persetujuan_operasi == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->ok2_formulir_persetujuan_operasi == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center">{{ $ppo->formulir_persetujuan_operasi_ket }}</td>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">4. Pemberian Premedikasi</div></td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->r_pemberian_premedikasi == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->ok1_pemberian_premedikasi == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->ok2_pemberian_premedikasi == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center">{{ $ppo->pemberian_premedikasi_ket }}</td>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">5. Pemberian Makanan dan Minum yang terakhir</div></td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->r_pemberian_makan_minum_last == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->ok1_pemberian_makan_minum_last == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->ok2_pemberian_makan_minum_last == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center">{{ $ppo->pemberian_makan_minum_last_ket }}</td>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">6. Alat Prothesa Luar, mis: Gigi Palsu, Kontak Lensa</div></td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->r_alat_protesa_luar == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->ok1_alat_protesa_luar == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->ok2_alat_protesa_luar == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center">{{ $ppo->alat_protesa_luar_ket }}</td>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">7. Penjepit Rambut/Cat Kuku/Perhiasan</div></td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->r_alat_perhiasan== 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->ok1_alat_perhiasan == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->ok2_alat_perhiasan == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center">{{ $ppo->alat_perhiasan_ket }}</td>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">8. Status Pasien Terlampir</div></td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->r_status_pasien_terlampir == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->ok1_status_pasien_terlampir == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->ok2_status_pasien_terlampir == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center">{{ $ppo->status_pasien_terlampir_ket }}</td>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">9. X-Ray/Scan *Pasien Terlampir</div></td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->r_xray_scan == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->ok1_xray_scan == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->ok2_xray_scan == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center">{{ $ppo->xray_scan_ket }}</td>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">10. Persiapan Pencukuran Buku Mata</div></td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->r_pencukuran_bulu_mata == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->ok1_pencukuran_bulu_mata == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->ok2_pencukuran_bulu_mata == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center">{{ $ppo->pencukuran_bulu_mata_ket }}</td>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">11. Pemeriksaan Darah (PMI/Lab. R.S*)</div></td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->r_pemeriksaan_darah == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->ok1_pemeriksaan_darah == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->ok2_pemeriksaan_darah == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center">{{ $ppo->pemeriksaan_darah_ket }}</td>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">12. Site Marker</div></td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->r_site_marker == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->ok1_site_marker == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center"><input type="checkbox" {{ $ppo->ok2_site_marker == 'ada' ? 'Checked' : '' }}> </td>
                            <td style="text-align: center">{{ $ppo->site_marker_ket }}</td>
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
                            <td>Perawat Ruangan </td>
                            <td>: {{ $ppo->perawat_ruangan }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Perawat Kamar Bedah</td>
                            <td>: {{ $ppo->perawat_kamar_bedah }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal : @php
                                list($date, $time) = explode(' ', $ppo->created_at);
                                $timeWithoutMilliseconds = explode('.', $time)[0];
                            @endphp {{ $date }} </td>
                            <td colspan="2">, Pukul: {{ $timeWithoutMilliseconds }} </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <br>



        </table>
       

</body>

</html>

