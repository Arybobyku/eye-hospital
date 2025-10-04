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
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Bahasa
                                        </td>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Cemas
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Pendegaran
                                        </td>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Emosi
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Masalah penglihatan
                                        </td>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Kongnitif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Bicara buruk
                                        </td>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Hilang memori
                                        </td>
                                    </tr>
                                </table>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Tidak ada partisipasi
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Secara fisiologi tidak mampu belajar
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" ></td>
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
                                    <tr>>
                                        <td colspan="2">
                                            <b>Edukasi</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Tata Tertib RS
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" ></td>
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
                                        <td><input type="checkbox"></td>
                                        <td>
                                             Audio
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Demonstrasi
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Lisan
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Tulisan
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Visual
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
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Normal
                                        </td>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Gangguan Bicara
                                        </td>
                                    </tr>
                                </table>
                                <b>Bahasa Sehari-hari :</b>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Indonesia
                                        </td>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Daerah
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Inggris
                                        </td>
                                        <td><input type="checkbox" ></td>
                                        <td>Lainnya</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            Bahasa :
                                        </td>
                                    </tr>
                                </table>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td><b>Bahasa Isyarat :</b> </td>
                                        <td><input type="checkbox"></td>
                                        <td>
                                            Ya
                                        </td>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Tidak
                                        </td>
                                    </tr>
                                </table>
                                <b>Tingkat Pendidikan :</b>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            TK
                                        </td>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            SD
                                        </td>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            SMP
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            SMA
                                        </td>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Diploma
                                        </td>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Sarjana
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Lain-lain 
                                        </td>
                                    </tr>
                                </table>
                                <b> Agama :</b>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Islam
                                        </td>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Protestan
                                        </td>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            katolik
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Hindu
                                        </td>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Budha
                                        </td>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Lain-lain
                                        </td>
                                    </tr>
                                </table>
                                <b>Tingkat Pengetahuan Kesehatan Pasien :</b>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Paham
                                        </td>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Kurang paham
                                        </td>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Tidak paham
                                        </td>
                                    </tr>
                                </table>
                                <b>Nilai-nilai Pasien Dan Budaya :</b>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Modern
                                        </td>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Moderat
                                        </td>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Konvesional
                                        </td>
                                    </tr>
                                </table>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td>Merokok</td>
                                        <td>:</td>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Ya
                                        </td>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Tidak
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Konsumsi Alkohol </td>
                                        <td>:</td>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Ya
                                        </td>
                                        <td><input type="checkbox"></td>
                                        <td>
                                            Tidak
                                        </td>
                                    </tr>
                                </table>
                                <b>Kesedian Menerima Informasi :</b>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Ya
                                        </td>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Tidak,alasan : 
                                        </td>
                                    </tr>
                                </table>
                                <b>Rencana Pendidikan Kesehatan :</b>
                                <table style="border-collapse: collapse; width:100%">
                                    <tr>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Proses Penyakit
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Pengobatan/Tindakan
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Nutrisi
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Edukasi Kolaboratif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" ></td>
                                        <td>
                                            Lain-lain : 
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
                                    <td><input type="checkbox"></td>
                                    <td>Ya</td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td><input type="checkbox"></td>
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
                        <td style="">
                            Nama Pengkaji :..............
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td>Tanggal :..............</td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td>Jam :..............</td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table>
                                <tr>
                                    <td>Tanda Tangan :..............</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </tr>
            <div class="page_break"></div>
            <table class="tablee sizesmall" style="width:100%; position:relative; ">
                <tr class="tablee">
                    <th rowspan="2" class="tablee">Profesi</th>
                    <th rowspan="2" class="tablee">Tanggal <br> /jam</th>
                    <th rowspan="2" class="tablee">
                        <div>KEBUTUHAN EDUKASI / TOPIK EDUKASI</div> 
                        <div style="margin-top: 90px;">----------------------------</div>
                        <div>(Dokter DPJP)</div>
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
                            <tr">
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


                 <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> Dokter </td>
                    <td class="tablee"> <br></td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" >
                                </td>
                                <td>Penjelasan penyakit, pemyebab, tanda, gejala, prognosi dan terapi 
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class="tablee"> <br></td>
                    <td class="tablee"> <br></td>
                    <td class="tablee"> <br></td>
                    <td class="tablee"> <br></td>   
                    <td class="tablee"> <br></td> 
                    <td class="tablee"> <br></td>
                </tr>
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> </td>
                    <td class="tablee"></td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" >
                                </td>
                                <td>Hasil pemeriksaan penunjang  
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>   
                    <td class="tablee"></td> 
                    <td class="tablee"></td>
                </tr>
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> </td>
                    <td class="tablee"></td>
                    <td class="tablee"> 
                        <table >
                            <tr>
                                <td> <input type="checkbox" >
                                </td>
                                <td>Hasil pengobatan  
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>   
                    <td class="tablee"></td> 
                    <td class="tablee"></td>
                </tr>  
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> </td>
                    <td class="tablee"></td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" >
                                </td>
                                <td>Rencana penatalaksanaan\hasil yang tidak diharapkan 
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>   
                    <td class="tablee"></td> 
                    <td class="tablee"></td>
                </tr>  
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> </td>
                    <td class="tablee"></td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" >
                                </td>
                                <td>Nama obat, kegunaan, cara pemberian, efek samping dan interaksi  
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>   
                    <td class="tablee"></td> 
                    <td class="tablee"></td>
                </tr>  
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> </td>
                    <td class="tablee"></td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" >
                                </td>
                                <td>Perkiraan hari rawat 
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>   
                    <td class="tablee"></td> 
                    <td class="tablee"></td>
                </tr>  
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> </td>
                    <td class="tablee"></td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" >
                                </td>
                                <td>Komplikasi penyakit yang mungkin terjadi   
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>   
                    <td class="tablee"></td> 
                    <td class="tablee"></td>
                </tr>  
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> </td>
                    <td class="tablee"></td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" >
                                </td>
                                <td>Manajemen nyeri farmakologis  
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>   
                    <td class="tablee"></td> 
                    <td class="tablee"></td>
                </tr>  
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> Perawat/Bidan</td>
                    <td class="tablee"></td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" >
                                </td>
                                <td>Guna gelang nama
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>   
                    <td class="tablee"></td> 
                    <td class="tablee"></td>
                </tr>            
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> </td>
                    <td class="tablee"></td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" >
                                </td>
                                <td>Guna pemasangan infus
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>   
                    <td class="tablee"></td> 
                    <td class="tablee"></td>
                </tr>
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> </td>
                    <td class="tablee"></td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" >
                                </td>
                                <td>Guna pemasangan infus
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>   
                    <td class="tablee"></td> 
                    <td class="tablee"></td>
                </tr>
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> </td>
                    <td class="tablee"></td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" >
                                </td>
                                <td>Penundan/terlambat  pelayanan, alasan alternatif lain 
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>   
                    <td class="tablee"></td> 
                    <td class="tablee"></td>
                </tr>
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> </td>
                    <td class="tablee"></td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" >
                                </td>
                                <td>Penggunaan peralatan  medis yang aman 
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>   
                    <td class="tablee"></td> 
                    <td class="tablee"></td>
                </tr>
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> </td>
                    <td class="tablee"></td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" >
                                </td>
                                <td>Manajemen nyeri farmakologis 
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>   
                    <td class="tablee"></td> 
                    <td class="tablee"></td>
                </tr>
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> </td>
                    <td class="tablee"></td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" >
                                </td>
                                <td>Manajemen nyeri intervensi 
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>   
                    <td class="tablee"></td> 
                    <td class="tablee"></td>
                </tr>
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> </td>
                    <td class="tablee"></td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" >
                                </td>
                                <td>Edukasi persetujuan tindakan operasi 
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>   
                    <td class="tablee"></td> 
                    <td class="tablee"></td>
                </tr>
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> </td>
                    <td class="tablee"></td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" >
                                </td>
                                <td>Cara mencuci tangan yang benar 
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>   
                    <td class="tablee"></td> 
                    <td class="tablee"></td>
                </tr>
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> </td>
                    <td class="tablee"> <br></td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" >
                                </td>
                                <td>Persetujuan biaya ... 
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class="tablee"> <br></td>
                    <td class="tablee"> <br></td>
                    <td class="tablee"> <br></td>
                    <td class="tablee"> <br></td>   
                    <td class="tablee"> <br></td> 
                    <td class="tablee"> <br></td>
                </tr>
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> </td>
                    <td class="tablee"></td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" >
                                </td>
                                <td>Pemberian imunisasi 
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>   
                    <td class="tablee"></td> 
                    <td class="tablee"></td>
                </tr>
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> </td>
                    <td class="tablee"></td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" >
                                </td>
                                <td>Inisiasi menyusui dini   
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>   
                    <td class="tablee"></td> 
                    <td class="tablee"></td>
                </tr>  
                <tr class="tablee page_break1" style="padding: 5px; ">
                    <td class="tablee"> </td>
                    <td class="tablee"></td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" >
                                </td>
                                <td>Perawatan metode kangguru 
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>   
                    <td class="tablee"></td> 
                    <td class="tablee"></td>
                </tr>
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" >
                                </td>
                                <td>Cara merawat tali pusat dirumah 
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>   
                    <td class="tablee"></td> 
                    <td class="tablee"></td>
                </tr>  
                                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> </td>
                    <td class="tablee"></td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" >
                                </td>
                                <td>Imunisasi lanjutan  
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>   
                    <td class="tablee"></td> 
                    <td class="tablee"></td>
                </tr>  
                                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> </td>
                    <td class="tablee"></td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" >
                                </td>
                                <td>Intake output cairan   
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>   
                    <td class="tablee"></td> 
                    <td class="tablee"></td>
                </tr>  
                                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> </td>
                    <td class="tablee"></td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" >
                                </td>
                                <td>Pembatasan konsumsi ABG (air,buah,garam)  
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>   
                    <td class="tablee"></td> 
                    <td class="tablee"></td>
                </tr>  
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee">Analis/Lab</td>
                    <td class="tablee"></td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" >
                                </td>
                                <td>Pemeriksaan Lab 
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>   
                    <td class="tablee"></td> 
                    <td class="tablee"></td>
                </tr>                      
                                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee">Ahli Gizi  </td>
                    <td class="tablee"></td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" >
                                </td>
                                <td>Diet yang memadai/food mode 
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>   
                    <td class="tablee"></td> 
                    <td class="tablee"></td>
                </tr>
                                                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> </td>
                    <td class="tablee"></td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" >
                                </td>
                                <td>Diet pasien pulang
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>   
                    <td class="tablee"></td> 
                    <td class="tablee"></td>
                </tr>
                                                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee">Farmasi  </td>
                    <td class="tablee"></td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" >
                                </td>
                                <td>Penggunaan obat-obatan secara efektif dan aman  
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>   
                    <td class="tablee"></td> 
                    <td class="tablee"></td>
                </tr>
                                                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> </td>
                    <td class="tablee"></td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" >
                                </td>
                                <td>Potensi efek samping obat 
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>   
                    <td class="tablee"></td> 
                    <td class="tablee"></td>
                </tr>
                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> </td>
                    <td class="tablee"></td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" >
                                </td>
                                <td>Potensi interaksi obat antar obat konvensional, obat bebas, serta suplemen. 
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>   
                    <td class="tablee"></td> 
                    <td class="tablee"></td>
                </tr>
                                                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> </td>
                    <td class="tablee"></td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" >
                                </td>
                                <td>Terapi/obat pulang 
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>   
                    <td class="tablee"></td> 
                    <td class="tablee"></td>
                </tr>
                                                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee">Fisioterapis </td>
                    <td class="tablee"></td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" >
                                </td>
                                <td>Tekhnik Rehabilitasi  
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>   
                    <td class="tablee"></td> 
                    <td class="tablee"></td>
                </tr>
                                                <tr class="tablee" style="padding: 5px; ">
                    <td class="tablee"> </td>
                    <td class="tablee"></td>
                    <td class="tablee"> 
                        <table>
                            <tr>
                                <td> <input type="checkbox" >
                                </td>
                                <td>Jenis-jenis Rehabilitasi
                                </td>
                            </tr>
                        </table>
                    </td>                
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>
                    <td class="tablee"></td>   
                    <td class="tablee"></td> 
                    <td class="tablee"></td>
                </tr>   
              </table>


            </table>
        </table>
    </div>
</body>

</html>