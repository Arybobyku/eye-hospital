<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM2.6</title>
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

        .tablee2 {
            border-left: 1px solid black;
            border-right: 1px solid black;
            border-collapse: collapse;

        }

        .sizesmall {
            font-size: 11;
        }

        .page_break {
            page-break-before: always;
        }
    </style>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;"></div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 2.6/TP/22
        </div>
        @include('print-rekam-medis.partials.header')
    </div>
    <div class="warp">
        <table class="tablee2" style="width: 100%; text-align: center;">
            <tr>
                <td style="text-align: center" colspan="4"><b>TRANSFER PASIEN</b></td>
            </tr>
        </table>
        <div class="sizesmall">
            <table class="tablee" style="width: 100%;">
                <tr>
                    <td style="border-right: 1px solid black; padding-left:5px; ">Tanggal Masuk :</td>
                    <td style="border-right: 1px solid black; padding-left:5px;">Tanggal Pindah :</td>
                    <td style="border-right: 1px solid black; padding-left:5px;">Asal Ruangan:</td>
                    <td style="padding-left: 5px;">Ruangan Selanjutnya:</td>
                </tr>
                <tr>
                    <td colspan="2"
                        style="padding-left: 5px; border-right: 1px solid black;  border-top: 1px solid black; ">Dokter
                        Yang
                        Merawat :</td>
                    <td colspan="2" style="padding-left: 5px; border-top: 1px solid black; "> Dokter Penanggung
                        Jawab(DPJP):
                    </td>
                </tr>
                <tr>
                    <td colspan="2"
                        style="padding-left: 5px; border-right: 1px solid black; vertical-align: top; border-top: 1px solid black; ">
                        Diagnosis
                        Utama:</td>
                    <td colspan="2" style="padding-left: 5px; border-top: 1px solid black; ">Perlu menjadi perhatian :
                        <table>
                            <tr>
                                <td colspan="2"></td>
                                <td><input type="checkbox"></td>
                                <td>Alergi. Sebutkan...........</td>
                                <td colspan="2"></td>
                                <td><input type="checkbox"></td>
                                <td>MRSA</td>
                            </tr>

                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"
                        style="padding-left: 5px; border-right: 1px solid black; border-top: 1px solid black; ">
                        Diagnosis Sekunder:
                    </td>
                    <td colspan="2" style="padding-left: 5px; border-top: 1px solid black; ">Alasan Perpindahan Pasien :
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-left: 5px; border-right: 1px solid black;">1. </td>
                    <td colspan="2" style="padding-left: 5px;">1. Kondisi Pasien: memburuk/stabil/tidak ada perubuhan
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-left: 5px; border-right: 1px solid black;">2.</td>
                    <td colspan="2" style="padding-left: 5px;">2. Fasilitas: Kurang memadai/membutuhkan peralatan yang
                        lebih baik</td>
                </tr>
                <tr>
                    <td colspan="2" style="border-right: 1px solid black; padding-left: 5px;">3.</td>
                    <td colspan="2" style="padding-left: 5px;">3. Tenaga: Membutuhkan tenaga yang lebih ahli/ Jumlah
                        tenaga kurang</td>
                </tr>
                <tr>
                    <td colspan="2" style="border-right: 1px solid black; padding-left: 5px;">4.</td>
                    <td colspan="2" style="padding-left: 5px;">4. lain-lain sebutkan :...................</td>
                </tr>
                <tr>
                    <td colspan="2" style="border-right: 1px solid black; vertical-align:top; padding-left: 5px;">5.
                    </td>
                    <td colspan="2"
                        style="width:100%; border-top: 1px solid black; padding-left: 5px; border-collapse: collapse;">
                        Metode perpindahan pasien:
                        <table>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td>Kursi Roda</td>
                                <td><input type="checkbox"></td>
                                <td>Tempat Tidur</td>
                                <td><input type="checkbox"></td>
                                <td>Branker/Stretcher</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"
                        style="vertical-align: top;  border-right: 1px solid black; border-top: 1px solid black; padding: 5px;">
                        Pasien/ keluarga mengetahui dan menyetujui <br> mengenai alasan perpindahan*)*)Ceklist pada <br>kota
                        yang tersedia untuk pernyataan yang sesuai <br>Bila pemberi persetujuan adalah keluarga
                        pasien, <br> lengkapi isian berikut: <br>Nama
                        :...............................................................................
                        <br>Hubungan
                        :...............................................................................</td>
                    <td colspan="2"
                        style="width:100%; border-top: 1px solid black; padding-left: 5px; border-collapse: collapse; vertical-align:canter;">
                        Peralatan yang menyertai pasien saat pindah :
                        <table >
                            <tr>
                                <td><input type="checkbox"></td>
                                <td>Portable</td>
                                <td><input type="checkbox"></td>
                                <td>Ventilor</td>
                                <td><input type="checkbox"></td>
                                <td>Alat Penghisap</td>
                                <td><input type="checkbox"></td>
                                <td>Keteter Urin</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td>Bagging</td>
                                <td><input type="checkbox"></td>
                                <td>Pompa Infus</td>
                                <td><input type="checkbox"></td>
                                <td>NGT</td>
                                <td colspan="2"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="border-top: 1px solid black; padding-left: 5px;"> Keadaan pasien saat pindah
                        :
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-left: 5px;">Keadaan Umum: Kesadaran..................</td>
                    <td>TD :..............mmHg</td>
                    <td>Suhu:............................&deg;C</td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-left: 5px;">Status Nyeri: ..................</td>
                    <td>Nadi :............x/menit</td>
                    <td>Pernapasan:..................x/menit</td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-left: 5px;">Tanda Tangan Keluarga</td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-left: 5px; padding-top:40px;">(...............................)</td>
                </tr>
                <tr style=" border-top: 1px solid black;">
                    <td colspan="2" style=" padding-left: 5px; border-right: 1px solid black;"><b>INFORMASI MEDIS</b>
                    </td>
                    <td colspan="2" style="padding-left: 5px;">Pendamping Pasien Saat Pindah:..................</td>
                </tr>
                <tr>
                    <td colspan="2"
                        style="border-top:1px solid black; padding-left: 5px; border-right: 1px solid black;">
                        <b>Berikan tanda pada kondisi yang sesuai</b>
                    </td>
                    <td colspan="2" style="padding-left: 5px;">Nama Petugas:..................</td>
                </tr>
                <tr>
                    <td colspan="2" style=" padding-left: 5px; border-right: 1px solid black;"><b>Disabilitas</b></td>
                    <td colspan="2" style="padding-left: 5px;"></td>
                </tr>
                <tr>
                    <td colspan="2" style=" padding-left: 5px; border-right: 1px solid black;">
                        <table>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td>Amputasi</td>
                                <td><input type="checkbox"></td>
                                <td>Kontraktur</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td>Paralis</td>
                                <td><input type="checkbox"></td>
                                <td>Ulkus Dikubitus</td>
                            </tr>
                        </table>
                    </td>
                    <td colspan="2" style="padding-left: 5px;"></td>
                <tr>
                    <td colspan="2" style=" padding-left: 5px; border-right: 1px solid black;"><b>Gangguan</b></td>
                    <td colspan="2" style="padding-left: 5px;"> </td>
                </tr>
                <tr>
                    <td colspan="2" style=" padding-left: 5px; border-right: 1px solid black;">
                        <table>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td>Mental</td>
                                <td><input type="checkbox"></td>
                                <td>Bicara</td>
                                <td><input type="checkbox"></td>
                                <td>Pendegaran</td>
                            </tr>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td>Sensasi</td>
                                <td><input type="checkbox"></td>
                                <td>Penglihatan</td>
                            </tr>
                        </table>
                    </td>
                    <td colspan="2" style="padding-left: 5px; border-top:1px solid black;">Pemeriksaan Fisik :</td>
                </tr>
                <tr>
                    <td colspan="2" style=" padding-left: 5px; border-right: 1px solid black;"><b>Inkotinensia</b></td>
                    <td colspan="2" style="padding-left: 5px;"> Status Generalis (temuan yang signifikan)</td>
                </tr>
                <tr>
                    <td colspan="2" style=" padding-left: 5px; border-right: 1px solid black;">
                        <table>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td>Urin</td>
                                <td><input type="checkbox"></td>
                                <td>Saliva</td>
                                <td><input type="checkbox"></td>
                                <td>Alvi</td>
                            </tr>
                        </table>
                    </td>
                    <td colspan="2" style="padding-left: 5px;">
                        .......................................................................................... </td>
                </tr>
                <tr>
                    <td colspan="2" style=" padding-left: 5px; border-right: 1px solid black;"><b>Inkotinensia</b></td>
                    <td colspan="2" style="padding-left: 5px;">Status Lokalis (Temuan yang signifikan) </td>
                </tr>
                <tr>
                    <td colspan="2" style=" padding-left: 5px; border-right: 1px solid black;">
                        <table>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td >Baik</td>
                                <td><input type="checkbox"></td>
                                <td >Sedang</td>
                                <td><input type="checkbox"></td>
                                <td >Buruk</td>
                            </tr>
                        </table>
                    </td>
                    <td colspan="2" style="padding-left: 5px;">
                        .................................................................................................
                    </td>
                </tr>
                </tr>
            </table>
        </div>
        <div class="page_break"></div>
        <table class="tablee" style="width: 100%;">
            <table class="tablee" style="width: 100%; font-size: 15px; padding:10px;">
                <tr>
                    <td colspan="2" style="border-right:1px solid black; padding-left: 5px;"><b>Status kemandirian</b>
                    </td>
                    <td style="border-right:1px solid black; padding-left: 5px; text-align: center">Mandiri</td>
                    <td style="border-right:1px solid black; padding-left: 5px; text-align: center">Butuh Bantuan</td>
                    <td style="align-text:canter; padding-left: 5px; text-align: center"> Tidak Mampu</td>
                </tr>
                <tr>
                    <td rowspan="2"
                        style="border-right:1px solid black; border-top:1px solid black; padding-left: 5px;">Aktivitas
                        ditempat tidur
                    </td>
                    <td style="border-right:1px solid black; border-top:1px solid black; padding-left: 5px;">Berguling
                    </td>
                    <td style="border-right:1px solid black; border-top:1px solid black;"></td>
                    <td style="border-right:1px solid black; border-top:1px solid black;"></td>
                    <td style="border-top:1px solid black;"></td>
                </tr>
                <tr>
                    <td style="border-right:1px solid black; border-top:1px solid black; padding-left: 5px;">Duduk</td>
                    <td style="border-right:1px solid black; border-top:1px solid black;"></td>
                    <td style="border-right:1px solid black; border-top:1px solid black;"></td>
                    <td style="border-top:1px solid black;"></td>
                </tr>
                <tr>
                    <td rowspan="4"
                        style="border-right:1px solid black; border-top:1px solid black; padding-left: 5px;">Hygiene
                        Pribadi</td>
                    <td style="border-right:1px solid black; border-top:1px solid black; padding-left: 5px;">Wajah,
                        rambut, tangan</td>
                    <td style="border-right:1px solid black; border-top:1px solid black; "></td>
                    <td style="border-right:1px solid black; border-top:1px solid black;"></td>
                    <td style="border-top:1px solid black;"></td>
                </tr>
                <tr>
                    <td style="border-right:1px solid black; border-top:1px solid black; padding-left: 5px;">Batang
                        tubuh & perinum</td>
                    <td style="border-right:1px solid black; border-top:1px solid black;"></td>
                    <td style="border-right:1px solid black; border-top:1px solid black;"></td>
                    <td style="border-top:1px solid black;"></td>
                </tr>
                <tr>
                    <td style="border-right:1px solid black; border-top:1px solid black; padding-left: 5px;">Ekstermitas
                        bawah</td>
                    <td style="border-right:1px solid black; border-top:1px solid black;"></td>
                    <td style="border-right:1px solid black; border-top:1px solid black;"></td>
                    <td style="border-top:1px solid black;"></td>
                </tr>
                <tr>
                    <td style="border-right:1px solid black; border-top:1px solid black; padding-left: 5px;">Mulut</td>
                    <td style="border-right:1px solid black; border-top:1px solid black;"></td>
                    <td style="border-right:1px solid black; border-top:1px solid black;"></td>
                    <td style="border-top:1px solid black;"></td>
                </tr>
                <tr>
                    <td rowspan="3"
                        style="border-right:1px solid black; border-top:1px solid black; padding-left: 5px;">Berpakaian
                    </td>
                    <td style="border-right:1px solid black; border-top:1px solid black; padding-left: 5px;">Ekstermitas
                        atas</td>
                    <td style="border-right:1px solid black; border-top:1px solid black;"></td>
                    <td style="border-right:1px solid black; border-top:1px solid black;"></td>
                    <td style="border-top:1px solid black;"></td>
                </tr>
                <tr>
                    <td style="border-right:1px solid black; border-top:1px solid black; padding-left: 5px;">Batang
                        tubuh</td>
                    <td style="border-right:1px solid black; border-top:1px solid black;"></td>
                    <td style="border-right:1px solid black; border-top:1px solid black;"></td>
                    <td style="border-top:1px solid black;"></td>
                </tr>
                <tr>
                    <td style="border-right:1px solid black; border-top:1px solid black; padding-left: 5px;">Ekstermitas
                        bawah</td>
                    <td style="border-right:1px solid black; border-top:1px solid black;"></td>
                    <td style="border-right:1px solid black; border-top:1px solid black;"></td>
                    <td style="border-top:1px solid black;"></td>
                </tr>
                <tr>
                    <td colspan="2"
                        style="border-right:1px solid black; border-top:1px solid black; padding-left: 5px;">Cara
                        memberi makan</td>
                    <td style="border-right:1px solid black; border-top:1px solid black;"></td>
                    <td style="border-right:1px solid black; border-top:1px solid black;"></td>
                    <td style="border-top:1px solid black;"></td>
                </tr>
                <tr>
                    <td rowspan="3"
                        style="border-right:1px solid black; border-top:1px solid black; padding-left: 5px;">Pergerakan
                    </td>
                    <td style="border-right:1px solid black; border-top:1px solid black; padding-left: 5px;">Jalan kaki
                    </td>
                    <td style="border-right:1px solid black; border-top:1px solid black;"></td>
                    <td style="border-right:1px solid black; border-top:1px solid black;"></td>
                    <td style="border-top:1px solid black;"></td>
                </tr>
                <tr>
                    <td style="border-right:1px solid black; border-top:1px solid black; padding-left: 5px;">Kursi roda
                    </td>
                    <td style="border-right:1px solid black; border-top:1px solid black;"></td>
                    <td style="border-right:1px solid black; border-top:1px solid black;"></td>
                    <td style="border-top:1px solid black;"></td>
                </tr>
            </table>
            <tr>
                <td style="border-top:1px solid black; padding-left: 5px;">Pemeriksaan penunjang/ diagnostic yang sudah
                    dilakukan (EKG,Lab,dll.)</td>
            </tr>
            <tr>
                <td style="border-top:1px solid black; padding-left: 5px;">intervensi/tindakan yang sudah dilakukan:
                </td>
            </tr>
            <tr>
                <td style="border-top:1px solid black; padding-left: 5px;">Diet:</td>
            </tr>
            <tr>
                <td style="border-top:1px solid black; padding-left: 5px;"> Rencana Perawatan Selanjutnya</td>
            </tr>
            <tr>
                <td style="padding-left:5px;">
                    ................................................................................................................................................................................
                </td>
            </tr>
            <tr>
                <td style="padding-left:5px;">
                    ................................................................................................................................................................................
                </td>
            </tr>
            <tr>
                <td style="padding-left:5px;">Terapi saat pindah</td>
            </tr>
            <table class="tablee" style="width: 100%; padding:5px">
                <tr>
                    <td
                        style="border-left:1px solid black; border-right:1px solid black; border-top:1px solid black; text-align: center;">
                        Nama Obat</td>
                    <td style=" border-right:1px solid black; text-align: center;">Jumlah</td>
                    <td style=" border-right:1px solid black; text-align: center;">Dosis</td>
                    <td style=" border-right:1px solid black; text-align: center;">Frekuensi</td>
                    <td style=" border-right:1px solid black; text-align: center;">Cara pemberian</td>
                </tr>
                <tr>
                    <td
                        style="border-left:1px solid black; border-right:1px solid black; border-top:1px solid black; text-align: center;">
                    </td>
                    <td style=" border-right:1px solid black; text-align: center; border-top:1px solid black;">&nbsp;
                    </td>
                    <td style=" border-right:1px solid black; text-align: center; border-top:1px solid black;"></td>
                    <td style=" border-right:1px solid black; text-align: center; border-top:1px solid black;"></td>
                    <td style=" border-right:1px solid black; text-align: center; border-top:1px solid black;"></td>
                </tr>
                <tr>
                    <td
                        style="border-left:1px solid black; border-right:1px solid black; text-align: center; border-top:1px solid black;">
                    </td>
                    <td style=" border-right:1px solid black; text-align: center; border-top:1px solid black;">&nbsp;
                    </td>
                    <td style=" border-right:1px solid black; text-align: center; border-top:1px solid black;"></td>
                    <td style=" border-right:1px solid black; text-align: center; border-top:1px solid black;"></td>
                    <td style=" border-right:1px solid black; text-align: center; border-top:1px solid black;"></td>
                </tr>
                <tr>
                    <td
                        style="border-left:1px solid black; border-right:1px solid black; text-align: center; border-top:1px solid black;">
                    </td>
                    <td style=" border-right:1px solid black; text-align: center; border-top:1px solid black;">&nbsp;
                    </td>
                    <td style=" border-right:1px solid black; text-align: center; border-top:1px solid black;"></td>
                    <td style=" border-right:1px solid black; text-align: center; border-top:1px solid black;"></td>
                    <td style=" border-right:1px solid black; text-align: center; border-top:1px solid black;"></td>
                </tr>
                <tr>
                    <td
                        style="border-left:1px solid black; border-right:1px solid black; text-align: center; border-top:1px solid black;">
                        &nbsp;</td>
                    <td style=" border-right:1px solid black; text-align: center; border-top:1px solid black;"></td>
                    <td style=" border-right:1px solid black; text-align: center; border-top:1px solid black;"></td>
                    <td style=" border-right:1px solid black; text-align: center; border-top:1px solid black;"></td>
                    <td style=" border-right:1px solid black; text-align: center; border-top:1px solid black;"></td>
                </tr>
            </table>
            <table style="width: 100%;">
                <tr>
                    <td style="padding-left: 5px;"> Dokter yang menggirim</td>
                    <td>Jam ...............</td>
                    <td colspan="2">Medan,..................................................</td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td>Dokter yang menerima</td>
                    <td>Jam,..........</td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-top:20px; padding-left: 5px;">
                        ....................................................................................</td>
                    <td colspan="2" style="padding-top:20px;">
                        ..............................................................</td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-left: 5px;"> Tanda tangan dan nama lengkap </td>
                    <td colspan="2"> Tanda tangan dan nama lengkap</td>
                </tr>
                <tr>
                    <td colspan="4" style="font-size: 15px; padding-top:40px; padding-left: 5px;"> Seluruh proses
                        pemindahan pasien telah selesai dan dilakukan sesuai standar prosedur operasional yang di
                        terapkan</td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-left: 5px;"> Perawat yang mengantar </td>
                    <td colspan="2"> Perawat yang menerima</td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-top:40px; padding-left: 5px;">
                        .................................................................................... </td>
                    <td colspan="2" style="padding-top:40px;">
                        ................................................................................</td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-left: 5px;"> Nama petugas dan tanda tangan </td>
                    <td colspan="2"> Nama petugas dan tanda tangan</td>
                </tr>
            </table>
        </table>
    </div>
</body>