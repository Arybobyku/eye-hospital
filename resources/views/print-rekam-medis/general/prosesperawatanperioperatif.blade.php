<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>REKAM MEDIS GENERAL - PROSES PERAWATAN PERI-OPERATIF</title>
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
                .smallfont1dot11 {
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
    <div style="position:fixed; right: 13px; bottom: 10px;">
    </div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <?php $eyero = storage_path('app/public/images/EYE-RO.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 1.10/PPOP/22
        </div>
        @include('print-rekam-medis.partials.header7')
<table style="width: 100%; border:1px solid">
            <tr>
                <td style="text-align: center">Tanggal :______________ </td>
                <td style="text-align: center">Jam : ___________________</td>
            </tr>
        </table>
        <table class="table1dot102" style="width: 100%;">
            <tr>
                <td class="smallfont1dot102" style="padding: 5px;"><b>A. CATATAN PERAWATAN SEBELUM OPERASI :</b>Bagian ini diisi oleh Perawat Ruangan</td>
            </tr>
            <tr>
                <td class="smallfont1dot11">
                    <table class="tablee1dot10" style="width:100%; padding:8px; font-weight:bold;">
                        <tr class="tablee1dot10">
                            <td class="tablee1dot10" style="padding: 5px">RUANGAN : </td>
                            <td class="tablee1dot10" style="padding: 5px"><table>
                                <tr>
                                    <td>JENIS PASIEN </td>
                                    <td><input type="checkbox" ></td>
                                    <td>UMUM</td>
                                    <td><input type="checkbox"></td>
                                    <td><AURANSI<</td>
                                    <td><input type="checkbox"></td>
                                    <td>BPJS<</td>
                                </tr>
                            </table>
                        </td>
                        </tr>
                        <tr>
                            <td class="tablee1dot10" style="padding: 5px">DIAGNOSIS : </td>
                            <td class="tablee1dot10" style="padding: 5px">TINDAKAN OPERASI : </td>
                        </tr>
                        <tr>
                            <td class="tablee1dot10" style="padding: 5px">DOKTER OPERATOR:</td>
                            <td class="tablee1dot10" style="padding: 5px">DOKTER ANESTESI :</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="smallfont1dot10">
                    <table style="padding: 5px">
                        <tr>
                            <td >1. Vital Signs</td>
                            <td >
                                <table style="width: 100%;">
                                    <tr>
                                        <td>Temp ___</td>
                                        <td>Nadi ___</td>
                                        <td>Pernafasan ____</td>
                                        <td>Tekanan Darah _____</td>
                                        <td>Tinggi ____</td>
                                        <td>Berat ____Kg </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>2. Riwayat Penyakit :</td>
                            <td> <table>
                                <tr>
                                    <td><input type="checkbox" ></td>
                                    <td>Hipertensi</td> 
                                    <td><input type="checkbox" ></td>
                                    <td>Diabetes</td>  
                                    <td><input type="checkbox" ></td>
                                    <td>Hepatitis</td>  
                                    <td><input type="checkbox" ></td>
                                    <td>Lain lain: ____________________________________</td>  
                                </tr></table></td>
                        </tr>
                        <tr>
                            <td>3. Alergi :</td>
                            <td> <table>
                                <tr>
                                    <td><input type="checkbox" ></td>
                                    <td>Tidak Ada</td> 
                                    <td><input type="checkbox" ></td>
                                    <td>Ya :  </td>  
                                </tr></table></td>
                        </tr>
                        <tr>
                            <td>4. Hasil KGD : ___________________</td>
                            <td> <b></b> Waktu Pengambilan Pukul : ____________________________________</td>
                        </tr>
                    </table>
                    </div>
                </td>
            </tr>
            <tr>
                    <td class="smallfont1dot102" style="padding: 5px;"><b>B. CATATAN PERAWATAN SEBELUM OPERASI :</b>Bagian ini dlengkapi oleh Perawat Ruangan dan Perawat Kamar Operasi</td>
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
                            <th class="tablee1dot10" style="width:10%">Ruang</th>
                            <th class="tablee1dot10" style="width:5%">OK</th>
                            <th class="tablee1dot10" style="width: 5%">OK</th>
                            <th class="tablee1dot10" style="width: 30%">Keterangan</th>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">1. Pemeriksaan Identitas Pasien</div></td>
                            <td style="text-align: center"><input type="checkbox" > </td>
                            <td style="text-align: center"><input type="checkbox" > </td>
                            <td style="text-align: center"><input type="checkbox" > </td>
                            <td style="text-align: center">_______________________</td>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">2. Pemeriksaan Gelang Nama</div></td>
                            <td style="text-align: center"><input type="checkbox" > </td>
                            <td style="text-align: center"><input type="checkbox" > </td>
                            <td style="text-align: center"><input type="checkbox"> </td>
                            <td style="text-align: center">_______________________</td>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">3. Formulir Persetujuan Operasi (Tanda Tangan)</div></td>
                            <td style="text-align: center"><input type="checkbox" > </td>
                            <td style="text-align: center"><input type="checkbox" > </td>
                            <td style="text-align: center"><input type="checkbox" > </td>
                            <td style="text-align: center">_______________________</td>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">4. Pemberian Premedikasi</div></td>
                            <td style="text-align: center"><input type="checkbox" ></td>
                            <td style="text-align: center"><input type="checkbox" > </td>
                            <td style="text-align: center"><input type="checkbox" > </td>
                            <td style="text-align: center">_______________________</td>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">5. Pemberian Makanan dan Minum yang terakhir</div></td>
                            <td style="text-align: center"><input type="checkbox" > </td>
                            <td style="text-align: center"><input type="checkbox" > </td>
                            <td style="text-align: center"><input type="checkbox"> </td>
                            <td style="text-align: center">_______________________</td>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">6. Alat Prothesa Luar, mis: Gigi Palsu, Kontak Lensa</div></td>
                            <td style="text-align: center"><input type="checkbox" ></td>
                            <td style="text-align: center"><input type="checkbox"> </td>
                            <td style="text-align: center"><input type="checkbox"> </td>
                            <td style="text-align: center">_______________________</td>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">7. Penjepit Rambut/Cat Kuku/Perhiasan</div></td>
                            <td style="text-align: center"><input type="checkbox" > </td>                          
                            <td style="text-align: center"><input type="checkbox"> </td> 
                            <td style="text-align: center"><input type="checkbox" > </td> 
                            <td style="text-align: center">_______________________</td>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">8. Status Pasien Terlampir</div></td>
                            <td style="text-align: center"><input type="checkbox" > </td>
                            <td style="text-align: center"><input type="checkbox" > </td>
                            <td style="text-align: center"><input type="checkbox" > </td>
                            <td style="text-align: center">_______________________</td>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">9. X-Ray/Scan *Pasien Terlampir</div></td>
                            <td style="text-align: center"><input type="checkbox" > </td>
                            <td style="text-align: center"><input type="checkbox" > </td>
                            <td style="text-align: center"><input type="checkbox" > </td>
                            <td style="text-align: center">_______________________</td>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">10. Persiapan Pencukuran Buku Mata</div></td>
                            <td style="text-align: center"><input type="checkbox" > </td>
                            <td style="text-align: center"><input type="checkbox" > </td>
                            <td style="text-align: center"><input type="checkbox" > </td>
                            <td style="text-align: center">_______________________</td>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">11. Pemeriksaan Darah (PMI/Lab. R.S*)</div></td>
                            <td style="text-align: center"><input type="checkbox" > </td>
                            <td style="text-align: center"><input type="checkbox" > </td>
                            <td style="text-align: center"><input type="checkbox" > </td>
                            <td style="text-align: center">_______________________</td>
                        </tr>
                        <tr>
                            <td><div style="margin-left: 10px">12. Site Marker</div></td>
                            <td style="text-align: center"><input type="checkbox" > </td>
                            <td style="text-align: center"><input type="checkbox" > </td>
                            <td style="text-align: center"><input type="checkbox" > </td>
                            <td style="text-align: center">_______________________</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <br>
            <tr>
                <td>
                    <table style="margin-left:30%;">
                        <tr>
                            <td>Diperiksa Oleh :</td>
                            <td>Perawat Ruangan </td>
                            <td>_____________ </td>
                            <td>Pkl : ________</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Perawat Kamar Bedah</td>
                            <td>____________ </td>
                            <td>Pkl : ________</td>
                        </tr>
                        <tr>
                                
                            
                            <td></td>
                            <td >   </td>
                            <td colspan="2">Tanggal :____________________</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <br>
        </table>   
    </div>
