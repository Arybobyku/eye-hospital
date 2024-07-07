<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM2.3</title>
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

        .table4 {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .tablee {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .tablee2 {
            border-bottom: 1px solid black;
            border-left: 1px solid black;
            border-right: 1px solid black;
            border-collapse: collapse;

        }

        .td1 {
            border-right: 1px solid black;
            border-collapse: collapse;
            width: 25%;
        }

        .td2 {
            border-right: 1px solid black;
            border-collapse: collapse;
            width: 25%;
        }

        .td3 {
            border-right: 1px solid black;
            border-collapse: collapse;
            width: 25%;
        }

        .td4 {
            border-right: 1px solid black;
            border-collapse: collapse;
            width: 25%;
        }
        .tdb {
            border-right: 1px solid black;
            border-collapse: collapse;
            width: 50%;
        }
        .tdd {
            border-collapse: collapse;
            width: 50%;
        }

        .td1x {
            border-bottom: 1px solid black;
            border-left: 1px solid black;
            border-right: 1px solid black;
            border-collapse: collapse;
            width: 50%;
        }

        .td2x {
            border-left: 1px solid black;
            border-bottom: 1px solid black;
            border-collapse: collapse;
            width: 50%;
        }

        .smallfont {
            font-size: 10;
        }
    </style>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;"></div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 2.3/COK/22
        </div>

        <table style="border-collapse: collapse;">
            {{-- HEADER --}}
            <tr style="border: 1px solid black;">
                <div style="width: 100%;">
                    <table style="width: 100%;">
                        <tr style="border: 1px solid black;">
                            <td style="border-right: 1px solid black; width:40%">
                                <img style="width: 100%;" src="data:image/png;base64,
            <?php echo base64_encode(file_get_contents($fullpath)); ?>" />
                            </td>
                            <td style="border-right: 1px solid black; width:25%;text-align:center; ">
                                <h4>CATATAN OPERASI</h4>
                            </td>
                            <td style="width: 35%">
                                <table style="width: 100%" border="0">
                                    <tr>
                                        <td width="20%">Nama</td>
                                        <td width="1%">:</td>
                                        <td width=50%>{{ $pasien->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">Tgl. Lahir</td>
                                        <td width="1%">:</td>
                                        <td width=50%>{{ $pasien->tanggal_lahir }}</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">No.RM</td>
                                        <td width="1%">:</td>
                                        <td width=50%>{{ $pasien->rekam_medis }}</td>
                                    </tr>
                                    <tr>
                                        <td width="10%">NIK</td>
                                        <td width="1%">:</td>
                                        <td width=50%>{{ $pasien->no_identitas }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </tr>
        </table>
        {{-- END HEADER --}}

    </div>
    <div class="smallfont">
        <table class="tablee2" cellpadding="5" style="width: 100%; ">
            <tr>
                <td class="td1x">Dokter Bedah : <b>{{ $cok->dokter_bedah }}</b></td>
                <td class="td2x">Perawat Scrub : <b>{{ $cok->perawat_scrub }}</b></td>
                <td rowspan="3" class="td2x">
                    Tanggal : <b>{{ $cok->tanggal }}</b> <br><br>
                    Operasi Mulai: <b>{{ $cok->operasi_mulai }}</b><br> <br>
                    Operasi Selesai: <b>{{ $cok->operasi_selesai }}</b>
            </tr>
            <tr>
                <td class="td1x">Dokter Anastesi : <b>{{ $cok->dokter_anastesi }}</b></td>
                <td class="td2x">Diagnosis Pra Bedah : <b> {{ $cok->diagnosis_pra_bedah }}</b></td>
            </tr>
            <tr>
                <td class="td1x">Tindakan Operasi : <b>{{ $cok->tindakan_operasi }}</b></td>
                <td class="td2x">Diagnosis Pasca Bedah : <b>{{ $cok->diagnosis_pasca_bedah }}</b></td>
            </tr>
        </table>
        <table class="tablee2" width="100%" cellpadding="2">
            <tr>
                <td rowspan="3" class="td1">Anestesi</td>
                <td><input type="checkbox" {{ $cok->an_topical == 'ada' ? 'Checked' : '' }}></td>
                <td class="td2"> Topikal</td>
                <td><input type="checkbox" {{ $cok->an_retrobulbar_peribulbar == 'ada' ? 'Checked' : '' }}></td>
                <td class="td3">Retrobulbar/Peribulbar</td>
                <td><input type="checkbox" {{ $cok->an_sub_conjunctival == 'ada' ? 'Checked' : '' }}></td>
                <td class="td4">Subconjunctival</td>
            </tr>
            <tr>
                <td><input type="checkbox" {{ $cok->an_intracamelar == 'ada' ? 'Checked' : '' }}></td>
                <td class="td2"> Intracamelar</td>
                <td><input type="checkbox" {{ $cok->an_nu_bius_umum == 'ada' ? 'Checked' : '' }}></td>
                <td class="td3">NU/bius umum</td>
                <td><input type="checkbox" {{ $cok->an_xylocain == 'ada' ? 'Checked' : '' }}></td>
                <td class="td4">Xylocain</td>
            </tr>
            <tr>
                <td></td>
                <td class="td2"></td>
                <td></td>
                <td class="td3"></td>
                <td><input type="checkbox" {{ $cok->an_lidocain == 'ada' ? 'Checked' : '' }}></td>
                <td class="td4">Lidocain</td>
            </tr>
            <tr>
                <td class="td1" style="border-top: 1px solid black;">Insisi</td>
                <td style="border-top: 1px solid black;"><input type="checkbox" {{ $cok->in_kornea == 'ada' ? 'Checked' : '' }}></td>
                <td style="border-top: 1px solid black;" class="td2"> Kornea</td>
                <td style="border-top: 1px solid black;"><input type="checkbox" {{ $cok->in_limbus == 'ada' ? 'Checked' : '' }}></td>
                <td style="border-top: 1px solid black;" class="td3">Limbus</td>
                <td style="border-top: 1px solid black;"><input type="checkbox" {{ $cok->in_sclera == 'ada' ? 'Checked' : '' }}></td>
                <td style="border-top: 1px solid black;" class="td4">Sclera</td>
            </tr>
            <tr>
                <td rowspan="2" style="border-top: 1px solid black;" class="td1">Wound(Tunnel)</td>
                <td style="border-top: 1px solid black;"><input type="checkbox" {{ $cok->wt_main_port == 'ada' ? 'Checked' : '' }}></td>
                <td style="border-top: 1px solid black;" class="td2"> Main port</td>
                <td style="border-top: 1px solid black;"><input type="checkbox" {{ $cok->wt_two_side_port == 'ada' ? 'Checked' : '' }}></td>
                <td style="border-top: 1px solid black;" class="td3">Two Side Port</td>
                <td style="border-top: 1px solid black;"><input type="checkbox" {{ $cok->wt_one_side_port == 'ada' ? 'Checked' : '' }}></td>
                <td style="border-top: 1px solid black;" class="td4">One Side Port</td>
            </tr>
            <tr>
                <td><input type="checkbox" {{ $cok->wt_keratome_2_koma_75_mm == 'ada' ? 'Checked' : '' }}></td>
                <td class="td2"> Keratome 2.75mm</td>
                <td><input type="checkbox" {{ $cok->wt_crescen_knife == 'ada' ? 'Checked' : '' }}></td>
                <td class="td3">Crescen knife</td>
                <td></td>
                <td class="td4"></td>
            </tr>
            <tr>
                <td style="border-top: 1px solid black;" class="td1" rowspan="2">Capsulotomi Anterior</td>
                <td style="border-top: 1px solid black;"><input type="checkbox" {{ $cok->cs_ccc == 'ada' ? 'Checked' : '' }}></td>
                <td style="border-top: 1px solid black;" class="td2"> CCC</td>
                <td style="border-top: 1px solid black;"><input type="checkbox" {{ $cok->cs_x_mas_tree == 'ada' ? 'Checked' : '' }}></td>
                <td style="border-top: 1px solid black;" class="td3">X'mas tree</td>
                <td style="border-top: 1px solid black;"><input type="checkbox" {{ $cok->cs_linear == 'ada' ? 'Checked' : '' }}></td>
                <td style="border-top: 1px solid black;" class="td4">Linear</td>
            </tr>
            <tr>
                <td><input type="checkbox" {{ $cok->cs_can_opener == 'ada' ? 'Checked' : '' }}></td>
                <td class="td2">Can Opener</td>
                <td><input type="checkbox" {{ $cok->cs_tryphan_blue == 'ada' ? 'Checked' : '' }}></td>
                <td class="td3">Tryphan blue</td>
                <td></td>
                <td class="td4"></td>
            </tr>
            <tr>
                <td class="td1" style="border-top: 1px solid black;">Teknik Tambahan</td>
                <td style="border-top: 1px solid black;"><input type="checkbox" {{ $cok->tb_ctr == 'ada' ? 'Checked' : '' }}></td>
                <td style="border-top: 1px solid black;" class="td2"> CTR</td>
                <td style="border-top: 1px solid black;"><input type="checkbox" {{ $cok->tb_kapsulotomi_posterior == 'ada' ? 'Checked' : '' }}></td>
                <td style="border-top: 1px solid black;" class="td3">Kapsulotomi posterior</td>
                <td style="border-top: 1px solid black;"><input type="checkbox" {{ $cok->tb_vitrektomi_anterior == 'ada' ? 'Checked' : '' }}></td>
                <td style="border-top: 1px solid black;" class="td4">Vitrektomi anterior</td>
            </tr>
            <tr>
                <td class="td1" style="border-top: 1px solid black;">Cairan Irigasi</td>
                <td style="border-top: 1px solid black;"><input type="checkbox" {{ $cok->ci_rl == 'ada' ? 'Checked' : '' }}></td>
                <td style="border-top: 1px solid black;" class="td2"> RL</td>
                <td style="border-top: 1px solid black;"><input type="checkbox" {{ $cok->ci_bss == 'ada' ? 'Checked' : '' }}></td>
                <td style="border-top: 1px solid black;" class="td3">B.S.S</td>
                <td style="border-top: 1px solid black;"></td>
                <td style="border-top: 1px solid black;" class="td4"></td>
            </tr>
            <tr>
                <td rowspan="2" style="border-top: 1px solid black;" class="td1">Lensa Intra Okular</td>
                <td style="border-top: 1px solid black;"><input type="checkbox" {{ $cok->lio_dalam_kantung_kapsul == 'ada' ? 'Checked' : '' }}></td>
                <td style="border-top: 1px solid black;" class="td2"> Dalam Kantung Kapsul</td>
                <td style="border-top: 1px solid black;"><input type="checkbox" {{ $cok->lio_bilik_mata_depan == 'ada' ? 'Checked' : '' }}></td>
                <td style="border-top: 1px solid black;" class="td3">Bilik mata depan</td>
                <td style="border-top: 1px solid black;"><input type="checkbox" {{ $cok->lio_sulcus_siliaris == 'ada' ? 'Checked' : '' }}></td>
                <td style="border-top: 1px solid black;" class="td4">Sulcus siliaris</td>
            </tr>
            <tr>
                <td><input type="checkbox" {{ $cok->lio_diluar_kantong_kapsul == 'ada' ? 'Checked' : '' }}></td>
                <td class="td2">Diluar Kantung Kapsul</td>
                <td><input type="checkbox" {{ $cok->lio_afakia == 'ada' ? 'Checked' : '' }}></td>
                <td class="td3">Afakia</td>
                <td><input type="checkbox" {{ $cok->lio_fiksasi_scleral == 'ada' ? 'Checked' : '' }}></td>
                <td class="td4">Fiksasi Scleral</td>
            </tr>
            <tr>
                <td class="td1" style="border-top: 1px solid black;">Cairan Viskoelastik</td>
                <td style="border-top: 1px solid black;"><input type="checkbox" {{ $cok->cv_hpmc == 'ada' ? 'Checked' : '' }}></td>
                <td style="border-top: 1px solid black;" class="td2"> HPMC</td>
                <td style="border-top: 1px solid black;"><input type="checkbox" {{ $cok->cv_viscoat == 'ada' ? 'Checked' : '' }}></td>
                <td style="border-top: 1px solid black;" class="td3">Viscoat</td>
                <td style="border-top: 1px solid black;"><input type="checkbox" {{ $cok->cv_hyaluronic_acid == 'ada' ? 'Checked' : '' }}></td>
                <td style="border-top: 1px solid black;" class="td4">Hyaluronic acid</td>
            </tr>
            <tr>
                <td class="td1" style="border-top: 1px solid black;">Benang</td>
                <td style="border-top: 1px solid black;"><input type="checkbox" {{ $cok->benang_tanpa_jahitan == 'ada' ? 'Checked' : '' }}></td>
                <td style="border-top: 1px solid black;" class="td2"> Tanpa Jaitan</td>
                <td style="border-top: 1px solid black;"><input type="checkbox" {{ $cok->benang_ethylon_10_0 == 'ada' ? 'Checked' : '' }}></td>
                <td style="border-top: 1px solid black;" class="td3">Ethylon 10-0</td>
                <td style="border-top: 1px solid black;"><input type="checkbox" {{ $cok->benang_vicryl_8_0 == 'ada' ? 'Checked' : '' }}></td>
                <td style="border-top: 1px solid black;" class="td4">Vicryl 8-0 </td>
            </tr>
            <tr>
                <td rowspan="4" style="border-top: 1px solid black;" class="td1">Komplikasi</td>
                <td style="border-top: 1px solid black;"><input type="checkbox" {{ $cok->kompikasi_tidak_ada == 'ada' ? 'Checked' : '' }}></td>
                <td style="border-top: 1px solid black;" class="td2"> Tidak ada</td>
                <td style="border-top: 1px solid black;"><input type="checkbox" {{ $cok->kompikasi_pcr == 'ada' ? 'Checked' : '' }}></td>
                <td style="border-top: 1px solid black;" class="td3">PCR</td>
                <td style="border-top: 1px solid black;"><input type="checkbox" {{ $cok->kompikasi_prolaps_vitreous == 'ada' ? 'Checked' : '' }}></td>
                <td style="border-top: 1px solid black;" class="td4">Prolaps vitreous</td>
            </tr>
            <tr>
                <td><input type="checkbox" {{ $cok->kompikasi_drop_nucleus == 'ada' ? 'Checked' : '' }}></td>
                <td class="td2"> Drop Nucleus</td>
                <td><input type="checkbox" {{ $cok->kompikasi_perdarahan == 'ada' ? 'Checked' : '' }}></td>
                <td class="td3">Perdarahan</td>
                <td><input type="checkbox" {{ $cok->kompikasi_corneal_burn == 'ada' ? 'Checked' : '' }}></td>
                <td class="td4"> Corneal burn</td>
            </tr>
            <tr>
                <td><input type="checkbox" {{ $cok->kompikasi_convert_to_ecce == 'ada' ? 'Checked' : '' }}></td>
                <td class="td2"> Conert to ECCE</td>
                <td><input type="checkbox" {{ $cok->kompikasi_convert_to_icce == 'ada' ? 'Checked' : '' }}></td>
                <td class="td3"> Conert to ICCE</td>
                <td></td>
                <td class="td4"></td>
            </tr>
        </table>
        <table class="tablee" width="100%" cellpadding="5">
            <tr>
                <td class="tda" colspan="2" style="border-Right: 1px solid black;">
                    Intruksi Paska Operasi:
                </td>
                <td class="tdac"> </td>
                <td class="tdbd">

                </td>
            </tr>
            <tr>
                <td ><input type="checkbox" {{ $cok->ipo_pdb2jpo == 'ada' ? 'Checked' : '' }}></td>
                <td class="tdb">
                    Perban dibuka 2 jam paska operasi
                </td>
                <td ><input type="checkbox" {{ $cok->ipo_pdbddtksdto == 'ada' ? 'Checked' : '' }}></td>
                <td class="tdd">
                    Perban dibuka dan ditutup kembali setelah ditetes obat
                </td>
            </tr>
            <tr>
                <td ><input type="checkbox" {{ $cok->ipo_omdpspdb == 'ada' ? 'Checked' : '' }}></td>
                <td class="tdb">
                    Obat mulai di pakai setelah perban di buka
                </td>
                <td ><input type="checkbox" {{ $cok->ipo_psdipo == 'ada' ? 'Checked' : '' }}></td>
                <td class="tdd">
                    pantangan sesuai dengan insturksi post operasi
                </td>
            </tr>
        </table>
        <table class="tablee2" width="100%" cellpadding="10">
            <tr>
                <td colspan="2">
                    Catatan Tambahan :  {{ $cok->catatan_tambahan }}
                </td>
                
            </tr>
            <tr>
                <td colspan="2" style="border-bottom: 1px solid black"></td>
            </tr>
            <tr>
                <td width="60%">

                </td>
                <td width="40%" style="text-align: center">
                    <u>Operator</u>
                </td>
            </tr>
            <tr>
                <td width="60%">
                     
                </td>
                <td width="40%">

                </td>
            </tr>
            <tr>
                <td>

                </td>
                <td style="text-align: center">
                    (dr {{ $cok->operator }})
                </td>
            </tr>
        </table>
    </div>
</body>
