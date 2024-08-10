<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM2.2</title>
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
        .tablee2dot2 {
            border: 1px solid black;
            border-collapse: collapse;
            border-bottom: 0.5px solid;
        }

        .tablee2dot22 {
            border-bottom: 1px solid black;
            border-left: 1px solid black;
            border-right: 1px solid black;
            border-collapse: collapse;

        }

        .td12dot2 {
            border: 1px solid black;
            border-collapse: collapse;
            width: 50%;
        }

        .td12dot2x {
            border-bottom: 1px solid black;
            border-left: 1px solid black;
            border-right: 1px solid black;
            border-collapse: collapse;
            width: 50%;
        }

        .td22dot2x {
            border-left: 1px solid black;
            border-right: 1px solid black;
            border-collapse: collapse;
            width: 50%;
        }

        .td22dot2 {
            border: 1px solid black;
            border-collapse: collapse;
            width: 50%;
        }

        .td-left-rigt-2dot2 {
            border-left: 1px solid black;
            border-right: 1px solid black;
            border-collapse: collapse;
            width: 33%;
        }

        .page_break_2dot2 {
            page-break-before: always;
        }

        .td-top-bottom-2dot2 {

            border-bottom: 1px solid black;
            border-collapse: collapse;
            width: 50%;
        }
    </style>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;"></div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 2.2/LP/22
        </div>
        @include('print-rekam-medis.partials.header')
    </div>
    <table class="tablee2dot22" style="width: 100%;">
        <tr>
            <td style="text-align: center" colspan="4"><b>LAPORAN PEMBEDAHAN</b></td>
        </tr>
        <tr class="tablee2dot2">
            <td style="padding:5px">Ruang Operasi </td>
            <td>: <b>{{ $lp != null && $lp->ruang_operasi }}</b></td>
            <td style="padding:5px">Kamar </td>
            <td>: <b>{{ $lp != null && $lp->kamar }}</b></td>

        </tr>
        <tr class="tablee2dot22">
            <td style="padding:5px">Akut/Terencana </td>
            <td>: <b>{{ $lp != null && $lp->akut_terencana }}</b></td>
            <td style="padding:5px">Tanggal </td>
            <td>: <b>{{ $lp != null && $lp->tanggal }}</b></td>
        </tr>
    </table>
    <table class="tablee2dot22" style="width: 100%;">
        <tr>
            <td style="padding:5px">Pembedahan : <b>{{ $lp != null && $lp->pembedahan }}</td>
            <td class="td-left-rigt-2dot2" style="padding:5px;">Asisten I : <b>{{ $lp != null && $lp->asisten_1 }}</b></td>
            <td style="padding:5px">Perawat Instrumen : <b>{{ $lp != null && $lp->perawat_instrument }}</b></td>
        </tr>
        <tr style="vertical-align: top;">
            <td style="padding:5px">Ahli Anastesi : <b>{{ $lp != null && $lp->ahli_anastesi }}</b></td>
            <td class="td-left-rigt-2dot2" style="padding:5px">Asisten II : <b>{{ $lp != null && $lp->asisten_2 }}</b></td>
            <td style="padding:5px">Jenis Anastesi :
                <table style="border-collapse: collapse; width:100%">
                    <tr>
                        <td>
                            <input type="checkbox" {{ $lp != null && $lp->ja_umum == 'Ya' ? 'Checked' : '' }}>
                        </td>
                        <td>
                            Umum
                        </td>
                        <td>
                            <input type="checkbox" {{ $lp != null && $lp->ja_bsp == 'Ya' ? 'Checked' : '' }}>
                        </td>
                        <td>
                            BSP*
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" {{ $lp != null && $lp->ja_spiral == 'Ya' ? 'Checked' : '' }}>
                        </td>
                        <td>
                            Spiral
                        </td>
                        <td>
                            <input type="checkbox" {{ $lp != null && $lp->ja_csp == 'Ya' ? 'Checked' : '' }}>
                        </td>
                        <td>
                            CSP*
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" {{ $lp != null && $lp->ja_epidural == 'Ya' ? 'Checked' : '' }}>
                        </td>
                        <td>
                            Epidural
                        </td>
                        <td>
                            <input type="checkbox" {{ $lp != null && $lp->ja_lokal == 'Ya' ? 'Checked' : '' }}>
                        </td>
                        <td>
                            Lokal
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table class="tablee2dot22" style="width: 100%;">
        <tr>
            <td class="td12dot2x">
                <table style="height: 100px">
                    <tr>
                        <td> Diagnosis Pra-Bedah :</td>
                    </tr>
                    <tr>
                        <td><b>{{ $lp != null && $lp->diagnosa_pra_bedah }}</b></td>
                    </tr>
                </table>
            </td>
            <td class="td12dot2x">
                <table style="height: 100px">
                    <tr>
                        <td> Indikasi Operasi :</td>
                    </tr>
                    <tr>
                        <td><b>{{ $lp != null && $lp->indikasi_operasi }}</b></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="td12dot2x">
                <table style="height: 100px">
                    <tr>
                        <td> Diagnosis Pasca-Bedah :</td>
                    </tr>
                    <tr>
                        <td><b>{{ $lp != null && $lp->diagnosa_pasca_bedah }}</b></td>
                    </tr>
                </table>
            </td>
            <td class="td22dot2">
                <table style="height: 100px">
                    <tr>
                        <td> Jenis Operasi :</td>
                    </tr>
                    <tr>
                        <td><b>{{ $lp != null && $lp->jenis_operasi }}</b></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="td12dot2">
                <table style="height: 100px">
                    <tr>
                        <td> Desinfeksi kulit dengan : </td>
                    </tr>
                    <tr>
                        <td><b>{{ $lp != null && $lp->desinfeksi_kulit_dengan }}</b></td>
                    </tr>
                </table>
            </td>
            <td class="td22dot2">
                <table style="height: 100px">
                    <tr>
                        <td> Posisi Penderita Desinfeksi : (Bila Perlu Dengan Gambar)</td>
                    </tr>
                    <tr>
                        <td><b>{{ $lp != null && $lp->posisi_penderita_desinfeksi }}</b></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table class="tablee2dot22" style="width: 100%;">
        <tr style="vertical-align: top;">
            <td class="td-top-bottom-2dot2" style="padding:5px">
                Jam Operasi Dimulai : <br> <b>{{ $lp != null && $lp->jam_operasi_dimulai }}</b>
            </td>
            <td class="td-top-bottom-2dot2" style="padding:5px">
                Jam Operasi Selesai: <br><b>{{ $lp != null && $lp->jam_operasi_selesai }}</b>
            </td>
            <td class="td12dot2x" style="padding:5px">
                Lama Operasi Berlangsung : <br><b>{{ $lp != null && $lp->lama_operasi_berlansung }}</b>
            </td>
            <td class="td12dot2x" style="padding:5px">
                Jenis Bahan Yang Dikirim kelabolatorium Untuk Pemeriksaan: <br><b>{{ $lp != null && $lp->jenis_bahan_yang_dikirim_ke_laboratorium }}</b>
                <br><br><br>
            </td>
        </tr>
    </table>
    <table class="tablee2dot22" style="width: 100%;">
        <tr>
            <td class="td12dot2x">
                <table style="height: 100px">
                    <tr>
                        <td> Macam Syatan (Bila Perlu Dengan Gambar) : <br><b>{{ $lp != null && $lp->macam_sayatan }}</b></td>
                    </tr>
                    <tr>
                        <td><br></td>
                    </tr>
                </table>
            </td>
            <td class="td12dot2x">
                <table style="height: 100px">
                    <tr>
                        <td> Posisi Sayatan (Bila Perlu Dengan Gambar) : <br><b>{{ $lp != null && $lp->posisi_sayatan }}</b></td>
                    </tr>
                    <tr>
                        <td><br></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table class="tablee2dot22" style="width: 100%;">
        <tr>
            <td class="td12dot2x">
                <table style="height: 100px">
                    <tr>
                        <td> Teknik Operasi dan Temuan Intra/Operasi : <br><b>{{ $lp != null && $lp->teknik_operasi_dan_temuan_intra }}</b></td>
                    </tr>
                    <tr>
                        <td><br></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <div class="page_break_2dot2"></div>
    <table class="tablee2dot2" style="width: 100%" ;>
        <tr>
            <td style="padding:5px">
                Penggunaan AMHP Khusus:
            </td>
            <td>
                <input type="checkbox" {{ $lp != null && $lp->penggunaan_amhp_khusus == 'Ya' ? 'Checked' : '' }}>
            </td>
            <td>
                Ya
            </td>
            <td>
                <input type="checkbox"  {{ $lp != null && $lp->penggunaan_amhp_khusus == 'Tidak' ? 'Checked' : '' }}>
            </td>
            <td>
                Tidak
            </td>
        </tr>
        <tr>
            <td colspan="5" style="padding:5px">
                Jenis dan Jumlah (AMHP Khusus) : <b>{{ $lp != null && $lp->jenis_dan_jumlah_amhp_khusus }}</b>
            </td>
        </tr>
    </table>
    <table class="tablee2dot22" style="width: 100%" ;>
        <tr>
            <td class="td22dot2x" style="width: 30%;">
                <table style="width: 100%; border-collapse:collapse;">
                    <tr>
                        <td colspan="4">Komplikasi Intra Operasi:</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" {{ $lp != null && $lp->komplikasi_intra_operasi == 'Ya' ? 'Checked' : '' }}></td>
                        <td>Ya</td>
                        <td><input type="checkbox" {{ $lp != null && $lp->komplikasi_intra_operasi == 'Tidak' ? 'Checked' : '' }}></td>
                        <td>Tidak</td>
                    </tr>
                    <tr style="border-top: 1px solid ">
                        <td style="border-top: 1px solid" colspan="4">Pendarahan : <b>{{ $lp != null && $lp->perdarahan }} cc</b></td>
                    </tr>
                </table>
            </td>
            <td class="td12dot2x" style="width: 70%; padding:5px; vertical-align: top">
                Penjabaran komlikasi Intra-Operasi : <br><b>{{ $lp != null && $lp->penjabaran_komplikasi_intra_operasi }}</b>
            </td>
        </tr>
        {{-- <tr>
            <td>
                <table style="width: 50%" ;>
                    <tr>
                        <td style="padding:5px">
                            <input type="checkbox" checked>
                        </td>
                        <td>
                            Ya
                        </td>
                        <td>
                            <input type="checkbox" checked>
                        </td>
                        <td>
                            Tidak
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="td12dot2" style="padding:5px">
                Perdarahan :.................cc
            </td>
        </tr> --}}
    </table>
    <table class="tablee2dot22" style="width: 100%">
        <tr>
            <td style="height:200px; vertical-align:top">Intruksi Anastesi : <br><b>{{ $lp != null && $lp->instruksi_anastesi }}</b></td>
            {{-- Inputan nanti masukkan height yang atas kurangi di sesuaikan --}}
        </tr>
    </table>
    <table class="tablee2dot22" style="width: 100%; border-top:none">
        <tr>
            <td colspan="4" style=" vertical-align:top">Instruksi Pasca-Bedah: </td>
            
        </tr>
        <tr>
            <td style="vertical-align:top">1. Kontrol Nadi / Tensi / Pernapasan / Suhu </td>
            <td style="vertical-align:top">: <b>{{ $lp != null && $lp->ipb_kontrol }}</b></td>
            
            <td style="vertical-align:top">5. Obat-obatan</td>
            <td style="vertical-align:top">: <b>{{ $lp != null && $lp->ipb_obat_obatan }}</b></td>
        </tr>
        <tr>
            <td style="vertical-align:top">2. Puasa</td>
            <td style="vertical-align:top">: <b>{{ $lp != null && $lp->ipb_puasa }}</b></td>
            
            <td style="vertical-align:top">6. Ganti Balut</td>
            <td style="vertical-align:top">: <b>{{ $lp != null && $lp->ipb_ganti_balut }}</b></td>
        </tr>
        <tr>
            <td style="vertical-align:top">3. Drain</td>
            <td style="vertical-align:top">: <b>{{ $lp != null && $lp->ipb_drain }}</b></td>
            
            <td style="vertical-align:top">7. Lain - Lain</td>
            <td style="vertical-align:top">: <b>{{ $lp != null && $lp->ipb_lainnya }}</b></td>
        </tr>
        <tr>
            <td style="vertical-align:top">4. Infus</td>
            <td style="vertical-align:top">: <b>{{ $lp != null && $lp->ipb_inpus }}</b></td>
            
            <td style="vertical-align:top"></td>
            <td style="vertical-align:top"></td>
        </tr>
        <tr>
            <td style="vertical-align:top;height:75px">&nbsp;</td>
            <td style="vertical-align:top"></td>
            
            <td style="vertical-align:top"></td>
            <td style="vertical-align:top"></td>
        </tr>
        <tr>
            <td style="vertical-align:top;"></td>
            <td style="vertical-align:top"></td>
            <td colspan="2" style="vertical-align:top;text-align:center">Medan,
                  {{-- @php
                list($date, $time) = explode(' ', $lp != null && $lp->created_at);
                $timeWithoutMilliseconds = explode('.', $time)[0];
            @endphp {{ $date }}  Pukul {{ $timeWithoutMilliseconds }} --}}
            </td>
        </tr>
        <tr>
            <td style="vertical-align:top;"></td>
            <td style="vertical-align:top"></td>
            <td colspan="2" style="vertical-align:top;text-align:center;padding-top:10px;">Operator Bedah</td>
        </tr>
        <tr>
            <td style="vertical-align:top;"></td>
            <td style="vertical-align:top"></td>
            <td style="vertical-align:top"></td>
            <td style="vertical-align:top;text-align:center;height:70px"></td>
            
        </tr>
        <tr>
            <td style="vertical-align:top;"></td>
            <td style="vertical-align:top"></td>
            <td colspan="2" style="vertical-align:top;text-align:center;">( {{ $lp != null && $lp->operator_bedah }} )<br>Tanda Tangan dan Nama Jelas</td>
        </tr>
    </table>
</body>