<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM4.9</title>
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

        .tablee4dot9 {
            border: 1px solid black;
            border-collapse: collapse;
            border-top: 0.5px solid;
            border-bottom: 0.5px solid;
        }

        .td14dot9 {
            border: 1px solid black;
            border-collapse: collapse;
            width: 30%;
            padding-left: 5px;
            padding-right: 5px;
        }

        .td24dot9 {
            border: 1px solid black;
            border-collapse: collapse;
            width: 4%;
            padding-left: 5px;
            padding-right: 5px;
        }

        .td34dot9 {
            border: 1px solid black;
            border-collapse: collapse;
            width: 32%;
            padding-left: 5px;
            padding-right: 5px;
        }

        .td44dot9 {
            border: 1px solid black;
            border-collapse: collapse;
            width: 4%;
            padding-left: 5px;
            padding-right: 5px;
        }

        .td54dot9 {
            border: 1px solid black;
            border-collapse: collapse;
            width: 30%;
            padding-left: 5px;
            padding-right: 5px;
        }

        .smallfont4dot9 {
            font-size: 9;
        }
    </style>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;"></div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM/4.9/CLKPO/22
        </div>
        
<table style="border-collapse: collapse;">
    {{-- HEADER --}}
    <tr style="border: 1px solid black;">
        <div style="width: 100%;">
            <table style="width: 100%;">
                <tr style="border: 1px solid black;">
                    <td style="border-right: 1px solid black; width:100%">
                        <img style="width: 70%;"
                            src="data:image/png;base64,
            <?php echo base64_encode(file_get_contents($fullpath)); ?>" />
                    </td>
                    <td style="width: 50%">
                        <div class="smallfont4dot9">
                        <table style="width: 100%" border="0">
                            <tr>
                                <td width="20%">Nama</td>
                                <td width="1%">:</td>
                                <td width=50%>{{ $data->nama }}</td>
                            </tr>
                            <tr>
                                <td width="20%">Tgl. Lahir</td>
                                <td width="1%">:</td>
                                <td width=50%>{{ $data->tanggal_lahir }}</td>
                            </tr>
                            <tr>
                                <td width="20%">No.RM</td>
                                <td width="1%">:</td>
                                <td width=50%>{{ $data->no_rm }}</td>
                            </tr>
                            <tr>
                                <td width="10%">NIK</td>
                                <td width="1%">:</td>
                                <td width=50%>{{ $data->nik }}</td>
                            </tr>
                        </table>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </tr>
</table>
    </div>
    <table class="tablee4dot9" style="width: 100%;">
        <tr>
            <td style="text-align: center; padding:5px;"><b>CHECKLIST KESELAMATAN PASIEN OPERASI</b></td>
        </tr>
    </table>
    <div class="smallfont4dot9">
        <table class="tablee4dot9" style="width: 100%;">
            <tr>
                <td class="td14dot9"><b>Sebelum Induksi anestesi/ Sign In <br> Waktu : {{ $data->signin_waktu }} </b></td>
                <td class="td24dot9"><b>--></b></td>
                <td class="td34dot9"><b>Sebelum Insisi/Time Out <br> Waktu :{{  $data->timeout_waktu }}</b></td>
                <td class="td44dot9"><b>--></b></td>
                <td class="td54dot9"><b>Sebelum Pasien Meninggalkan Kamar Operasi/ Sign Out <br> Waktu :{{  $data->signout_waktu }}</td>
            </tr>
            <tr style="vertical-align: top;">
                <td class="td14dot9">
                    <table>
                        <tr>
                            <td colspan="2"><b>Minimal ada perawat, perawat Anestesi dan Dokter Anestesi </b></td>
                        </tr>
                        <tr>
                            <td colspan="2">Apakah identitas pasien sudah benar, rencana tindakan sudah jelas, dan ada
                                persetujuan tindakan medis yang akan dilakukan ( <i>informed consent</i>) ? </td>
                        </tr>
                        <tr>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  ($data->signin_q1 ?? '') == 'ya' ? 'Checked' : '' }}></td>
                                        <td>Ya</td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  ($data->signin_q1 ?? '') == 'tidak' ? 'Checked' : '' }}></td>
                                        <td>Tidak</td>
                                    </tr>
                                </table>
                            </td>
                        <tr>
                            <td colspan="2">Apakah area yang akan dioperasi sudah diberi tanda ? </td>
                        </tr>
                        <tr>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  ($data->signin_q2 ?? '') == 'ya' ? 'Checked' : '' }}></td>
                                        <td>Ya</td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  ($data->signin_q2 ?? '') == 'tidak_diperlukan' ? 'Checked' : '' }}></td>
                                        <td>Tidak diperlukan</td>
                                    </tr>
                                </table>
                            </td>
                        <tr>
                            <td colspan="2">Apakah mesin anestesi dan obat-obatan sudah lengkap ? </td>
                        </tr>
                        <tr>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  ($data->signin_q3 ?? '') == 'ya' ? 'Checked' : '' }}></td>
                                        <td>Ya</td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  ($data->signin_q3 ?? '') == 'tidak' ? 'Checked' : '' }}></td>
                                        <td>Tidak</td>
                                    </tr>
                                </table>
                            </td>
                        <tr>
                            <td colspan="2"> Apakah sudah terpasang 'pulse oksimetri' pada pasien, dan sudah berfungsi
                                baik ? </td>
                        </tr>
                        <tr>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  ($data->signin_q4 ?? '') == 'ya' ? 'Checked' : '' }}></td>
                                        <td>Ya</td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  ($data->signin_q4 ?? '') == 'tidak' ? 'Checked' : '' }}></td>
                                        <td>Tidak</td>
                                    </tr>
                                </table>
                            </td>
                        <tr>
                            <td colspan="2">Apakah pasien memiliki riwayat alergi? </td>
                        </tr>
                        <tr>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  $data->signin_q5 == 'ya' ? 'Checked' : '' }}></td>
                                        <td>Ya</td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  $data->signin_q5 == 'tidak' ? 'Checked' : '' }}></td>
                                        <td>Tidak</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Apakah pasien memiliki gangguan pernapasan ? </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <table>
                                    <tr>
                                        <td> <input type="checkbox" {{  $data->signin_q6 == 'ya_tersedia' ? 'Checked' : '' }}></td>
                                        <td>Ya, dan alat/bantuan sudah tersedia</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  $data->signin_q6 == 'tidak' ? 'Checked' : '' }}></td>
                                        <td>Tidak</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Resiko perdarahan > 500ml(7ml/kg bagi anak-anak)</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <table>
                                    <tr>
                                        <td> <input type="checkbox" {{  $data->signin_q7 == 'ya_direncanakan' ? 'Checked' : '' }}></td>
                                        <td colspan="2">Ya, dan sudah direncanakan pemasangan infus 2 (<i>line</i>) dan
                                            tersedia cairan-cairan yang akan diberikan</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  $data->signin_q7 == 'tidak' ? 'Checked' : '' }}></td>
                                        <td>Tidak</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Tanda tangan dan nama</b></td>
                        </tr>

                        <tr>
                            <td colspan="2"> <u>dr. Anestesi :</u></td>
                        </tr>
                        <tr>
                            <td colspan="2"> <img src="{{ $data->signin_ttd_dr_anestesi }}" alt="Base64 Image" width="100px">  </td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>{{  $data->signin_nama_dr_anestesi }}</b>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><u>Perawat Anestesi :</u></td>
                        </tr>
                        <tr>
                            <td colspan="2"> <img src="{{ $data->signin_ttd_perawat_anestesi }}" alt="Base64 Image" width="100px">  </td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>{{  $data->signin_nama_perawat_anestesi }}</b>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><u>Perawat :</u></td>
                        </tr>
                        <tr> 
                            <td colspan="2"> <img src="{{ $data->signin_ttd_perawat }}" alt="Base64 Image" width="100px">  </td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>{{  $data->signin_nama_perawat }}</b>
                            </td>
                        </tr> 
                    </table>
                </td>
                <td class="td24dot9">
                    <table></table>
                </td>
                <td class="td34dot9">
                    <table>
                        <tr>
                            <td colspan="2"><b>Dengan perawat, perawat Anestesi dan Dokter Anestesi </b></td>
                        </tr>
                        <tr>
                            <td colspan="2"> Memastikan bahwa semua anggota tim medis sudah memperkenalkan diri(nama dan
                                peran masing-masing) </td>
                        </tr>
                        <tr>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  $data->timeout_q1 == 'ya' ? 'Checked' : '' }}></td>
                                        <td>Ya</td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  $data->timeout_q1 == 'tidak' ? 'Checked' : '' }}></td>
                                        <td>Tidak</td>
                                    </tr>
                                </table>
                            </td>
                        <tr>
                            <td colspan="2">Memastikan dan baca ulang nama pasien, tindakan medis dan area yang akan
                                diinsisi.</td>
                        </tr>
                        <tr>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  $data->timeout_q2 == 'ya' ? 'Checked' : '' }}></td>
                                        <td>Ya</td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  $data->timeout_q2 == 'tidak' ? 'Checked' : '' }}></td>
                                        <td>Tidak</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Apakah profilaksis antibiotik sudah di berikan 1 jam sebelumnya? </td>
                        </tr>
                        <tr>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  $data->timeout_q3 == 'ya' ? 'Checked' : '' }}></td>
                                        <td>Ya</td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  $data->timeout_q3 == 'tidak' ? 'Checked' : '' }}></td>
                                        <td>Tidak perlu</td>
                                    </tr>
                                </table>
                            </td>
                        <tr>
                            <td colspan="2"><b>Kejadian berisiko yang perlu diantisipasi untuk Dokter Bedah :</b></td>
                        </tr>
                        <tr>
                            <td colspan="2"> Apakah tindakan bersiko atau tindaan tidak rutin yang akan di lakukan ?
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td colspan="2">{{  $data->timeout_q4_tindakan_beresiko }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Berapa lama tindakan ini akan dikerjakan? </td>
                        </tr>
                        <tr>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td colspan="2">{{  $data->timeout_q4_lama_tindakan }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Apakah sudah antisipasi perdarahan?</td>
                        </tr>
                        <tr>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  $data->timeout_q4_antisipasi_perdarahan == 'ya' ? 'Checked' : '' }}></td>
                                        <td>Ya</td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  $data->timeout_q4_antisipasi_perdarahan == 'tidak' ? 'Checked' : '' }}></td>
                                        <td>Tidak</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Untuk Dokter Anastesi</b></td>
                        </tr>
                        <tr>
                            <td colspan="2">Apakah ada hal khusus untuk pasien ini?</td>
                        </tr>
                        <tr>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  $data->timeout_q5 == 'ya' ? 'Checked' : '' }}></td>
                                        <td>Ya</td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  $data->timeout_q5 == 'tidak' ? 'Checked' : '' }}></td>
                                        <td>Tidak</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Untuk TIm Perawat</b></td>
                        </tr>
                        <tr>
                            <td colspan="2">Apakah sudah dipastikan kesterilan peralatan?</td>
                        </tr>
                        <tr>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  $data->timeout_q6_kesterilan == 'ya' ? 'Checked' : '' }}></td>
                                        <td>Ya</td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  $data->timeout_q6_kesterilan == 'tidak' ? 'Checked' : '' }}></td>
                                        <td>Tidak</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Apakah alat implan yang di butuhkan sudah disterilan?</td>
                        </tr>
                        <tr>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  $data->timeout_q6_implan == 'ya' ? 'Checked' : '' }}></td>
                                        <td>Ya</td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  $data->timeout_q6_implan == 'tidak' ? 'Checked' : '' }}></td>
                                        <td>Tidak</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Apakah ada masalah dengan peralatan atau masalah alat yang dikhawatirkan?
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  $data->timeout_q6_masalah_alat == 'ya' ? 'Checked' : '' }}></td>
                                        <td>Ya</td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  $data->timeout_q6_masalah_alat == 'tidak' ? 'Checked' : '' }}></td>
                                        <td>Tidak</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Apakah hasil radiologi yang diperlukan sudah ada?</td>
                        </tr>
                        <tr>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  $data->timeout_q6_radiologi == 'ya' ? 'Checked' : '' }}></td>
                                        <td>Ya</td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  $data->timeout_q6_radiologi == 'tidak' ? 'Checked' : '' }}></td>
                                        <td>Tidak</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        
                         <tr>
                            <td colspan="2"><b>Tanda tangan dan nama</b></td>
                        </tr>
                        <tr>
                            <td colspan="2"><u>dr. Anestesi :</u></td>
                        </tr>
                        <tr> 
                            <td colspan="2"> <img src="{{ $data->timeout_ttd_dr_anestesi }}" alt="Base64 Image" width="100px">  </td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>{{  $data->timeout_nama_dr_anastesi }}</b>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><u>Perawat Anestesi :</u></td>
                        </tr>
                        <tr>
                            <td colspan="2"> <img src="{{ $data->timeout_ttd_perawat_anestesi }}" alt="Base64 Image" width="100px">  </td>
                        </tr>
                        <tr>   
                            <td colspan="2"><b>{{  $data->timeout_nama_perawat_anestesi }}</b>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><u>Perawat Sirkuler :</u></td>
                        </tr>
                        <tr> 
                            <td colspan="2"> <img src="{{ $data->timeout_ttd_perawat_sirkuler }}" alt="Base64 Image" width="100px">  </td>
                        </tr>
                        <tr>    
                            <td colspan="2"><b>{{  $data->timeout_nama_perawat_sirkuler }}</b>
                            </td>
                        </tr> 
                    </table>
                </td>
                <td class="td44dot9">
                    <table></table>
                </td>
                <td class="td54dot9">
                    <table>
                        <tr>
                            <td colspan="2"><b>Dengan perawat, perawat Anestesi dan Dokter Anestesi </b></td>
                        </tr>
                        <tr>
                            <td colspan="2"> Secara verbal perawat memastikan nama tindakan </td>
                        </tr>
                        <tr>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  $data->signout_q1 == 'ya' ? 'Checked' : '' }}></td>
                                        <td>Ya</td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  $data->signout_q1 == 'tidak' ? 'Checked' : '' }}></td>
                                        <td>Tidak</td>
                                    </tr>
                                </table>
                            </td>
                        <tr>
                            <td colspan="2">Kelengkapan alat, jumlah kasa dan jarum</td>
                        </tr>
                        <tr>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  $data->signout_q2 == 'lengkap' ? 'Checked' : '' }}></td>
                                        <td>Lengkap</td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  $data->signout_q2 == 'tidak' ? 'Checked' : '' }}></td>
                                        <td>Tidak</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Pelebelan spacimen (baca label spacimen dan nama pasien dengan keras) </td>
                        </tr>
                        <tr>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  $data->signout_q3 == 'ya' ? 'Checked' : '' }}></td>
                                        <td>Ya</td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  $data->signout_q3 == 'tidak' ? 'Checked' : '' }}></td>
                                        <td>Tidak </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Apakah ada masalah peralatan yang perlu disampaikan?</td>
                        </tr>
                        <tr>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  $data->signout_q4 == 'ya' ? 'Checked' : '' }}></td>
                                        <td>Ya</td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  $data->signout_q4 == 'tidak' ? 'Checked' : '' }}></td>
                                        <td>Tidak </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>Untuk Dokter Bedah, Dokter Anestesi dan Perawat </b></td>
                        </tr>
                        <tr>
                            <td colspan="2">Apakah ada catatan khusus untuk proses <i>recovery</i> dan penanganan
                                perawatan pasien ini </td>
                        </tr>
                        <tr>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  $data->signout_q5 == 'ya' ? 'Checked' : '' }}></td>
                                        <td>Ya</td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table style="margin-top: -10px">
                                    <tr>
                                        <td><input type="checkbox" {{  $data->signout_q5 == 'tidak' ? 'Checked' : '' }}></td>
                                        <td>Tidak</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                           <tr>
                            <td colspan="2" >Medan, {{  $data->created_at }}</td>
                        </tr>
                        
                        <tr>
                            <td colspan="2"><b>Tanda tangan dan nama</b></td>
                        </tr>
                        <tr>
                            <td colspan="2"><u>dr. Bedah :</u></td>
                        </tr>
                        <tr> 
                            <td colspan="2"> <img src="{{ $data->signout_ttd_dr_bedah }}" alt="Base64 Image" width="100px">  </td>
                        </tr>   
                        <tr>
                            <td colspan="2"><b>{{  $data->signout_nama_dr_bedah }}</b>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><u>dr. Anestesi :</u></td>
                        </tr>
                        <tr> 
                            <td colspan="2"> <img src="{{ $data->signout_ttd_dr_anestesi }}" alt="Base64 Image" width="100px">  </td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>{{  $data->signout_nama_dr_anestesi }}</b>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><u>Perawat Anestesi :</u></td>
                        </tr>
                        <tr> 
                            <td colspan="2"> <img src="{{ $data->signout_ttd_perawat_anestesi }}" alt="Base64 Image" width="100px">  </td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>{{  $data->signout_nama_perawat_anestesi }}</b>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><u>Perawat Instrumen :</u></td>
                        </tr>
                        <tr> 
                            <td colspan="2"> <img src="{{ $data->signout_ttd_perawat_instrument }}" alt="Base64 Image" width="100px">  </td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>{{  $data->signout_nama_perawat_instrument }}</b>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><u>Perawat Sirkuler :</u></td>
                        </tr>
                        <tr> 
                            <td colspan="2"> <img src="{{ $data->signout_ttd_perawat_sirkuler }}" alt="Base64 Image" width="100px">  </td>
                        </tr>
                        <tr>
                            <td colspan="2"><b>{{  $data->signout_nama_perawat_sirkuler }}</b>
                            </td>
                        </tr> 
                    </table>
                </td>
            </tr>
        </table>
    </div>
    {{-- <td class="td14dot9"><b>Minimal ada perawat, perawat Anestesi dan Dokter Anestesi </b></td>
    <td class="td24dot9"></td>
    <td class="td34dot9"><b>Dengan perawat, perawat Anestesi, Dokter Anestesi dan Dokter Bedah</b></td>
    <td class="td44dot9"></td>
    <td class="td54dot9"><b>Dengan Perawat, Perawat Anestesi, Dokter Anestesi dan Dokter Bedah</b></td> --}}
</body>