<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>REKAM MEDIS GENERAL - KUNJUNGAN AWAL DIETITIAN PADA PASIEN BARU</title>
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


        .left {
            display: inline-block;
            float: left;
        }

        .right {
            display: inline-block;
            float: right;
        }

        .img-wrapper {
            position: relative;
            display: inline-block;
            text-align: center;
        }

        .img-wrapper img {
            display: block;
            max-width: 100%;
            height: auto;
        }

        .tablee {
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
            padding: 5px;
        }

        .text-above {
            text-align: center;
            margin-bottom: 5px;
        }
    </style>

</head>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;">
    </div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 3.2/KADPPB/22
        </div>
        @include('print-rekam-medis.partials.header')
        <table style="width: 100%;  border: 1px solid black;" cellpadding="0" cellspacing="0">
            <tr>
                <td style="font-weight: bold; text-align: center; padding: 7px; border-bottom: 1px solid black;">
                    KUNJUNGAN AWAL DIETITIAN PADA PASIEN BARU
                </td>
            </tr>
            <tr>
                <td style="padding-bottom: 30px; padding-left: 8px;">Diagnose Medis : {{ $data->diagnosa_medis }}</td>
            </tr>
            <tr>
                <td style ="padding-left: 2px;">1. Risiko malnutrisi berdasarkan hasil skrining gizi oleh perawat,
                    kondisi pasien termasuk kategori :</td>
            </tr>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td style="padding-left: 15px;"><input type="checkbox"
                                    {{ $data->risiko_malnutrisi == 'Risiko ringan (Nilai MST 0-1)' ? 'Checked' : '' }}>
                            </td>
                            <td> Risiko ringan (Nilai MST 0-1) </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td style="padding-left: 15px;"><input type="checkbox"
                                    {{ $data->risiko_malnutrisi == 'Risiko sedang (Nilai MST ≥ 2-3)' ? 'checked' : '' }}>
                            </td>
                            <td> Risiko sedang (Nilai MST >= 2-3) </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td style="padding-left: 15px;"><input type="checkbox"
                                    {{ $data->risiko_malnutrisi == 'Risiko tinggi (Nilai MST 4-5)' ? 'checked' : '' }}>
                            </td>
                            <td> Risiko Tinggi (Nilai MST 4-5) </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding-top: 20px; padding-left: 2px;">2. Pasien mempunyai kondisi khusus : </td>
            </tr>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td style="padding-left: 15px;"><input type="checkbox"
                                    {{ $data->kondisi_khusus != 'Tidak' ? 'Checked' : '' }}></td>
                            <td>Ya</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td style="padding-left: 15px;"><input type="checkbox"
                                    {{ $data->kondisi_khusus == 'Tidak' ? 'Checked' : '' }}></td>
                            <td>Tidak</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding-top: 20px; padding-left: 2px;">3. Alergi makanan : </td>
            </tr>
            <tr>
                <td>
                    <table style="width: 80%;">
                        <tr>
                            <td style="width: 1%; padding-left: 15px;"><input type="checkbox"
                                    {{ $data->alergi_telur ? 'Checked' : '' }}></td>
                            <td style="width: 39%;">Telur</td>
                            <td style="width: 1%;"><input type="checkbox" {{ $data->alergi_udang ? 'Checked' : '' }}>
                            </td>
                            <td style="width: 39%;">Udang</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table style="width: 80%;">
                        <tr>
                            <td style="width: 1%; padding-left: 15px;"><input type="checkbox"
                                    {{ $data->alergi_susu ? 'Checked' : '' }}></td>
                            <td style="width: 39%;">Susu sapi & pruduk olahannya</td>
                            <td style="width: 1%;"><input type="checkbox" {{ $data->alergi_ikan ? 'Checked' : '' }}></td>
                            <td style="width: 39%;">Ikan</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table style="width: 80%;">
                        <tr>
                            <td style="width: 1%; padding-left: 15px;"><input type="checkbox"
                                    {{ $data->alergi_kacang ? 'Checked' : '' }}></td>
                            <td style="width: 39%;">Kacang kedelai/ tanah </td>
                            <td style="width: 1%;"><input type="checkbox" {{ $data->alergi_hazelnut ? 'Checked' : '' }}>
                            </td>
                            <td style="width: 39%;">Hazelnut/ Almond</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td style="padding-left: 15px;"><input type="checkbox"
                                    {{ $data->alergi_gluten ? 'Checked' : '' }}></td>
                            <td>Gluten/ gandum </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table style="width: 80%;">
                        <tr>
                            <td style="width: 30%; padding-top: 20px;">4. Preskripsi diet :</td>
                            <td style="width: 1%; padding-top: 20px;"><input type="checkbox"
                                    {{ $data->preskripsi_diet == 'Makanan Biasa' ? 'Checked' : '' }}></td>
                            <td style="width: 20%; padding-top: 20px;">Makanan biasa</td>
                            <td style="width: 1%; padding-top: 20px;"><input type="checkbox"
                                    {{ $data->preskripsi_diet != 'Makanan Biasa' ? 'Checked' : '' }}></td>
                            <td style="width: 29%; padding-top: 20px;"> Diet Khusus</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table style="width: 80%;">
                        <tr>
                            <td style="width: 30%; padding-top: 20px; padding-left: 2px;">5. Tindak lanjut :</td>
                            <td style="width: 1%; padding-top: 20px;"><input type="checkbox"
                                    {{ $data->tindak_lanjut != 'Belum perlu asuhan gizi' ? 'Checked' : '' }}></td>
                            <td style="width: 49%; padding-top: 20px;">Perluh asuhan gizi (lanjutkan ke Asesmen gizi)
                            </td>
                            <td style="width: 1%;"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table style="width: 80%;">
                        <tr>
                            <td style="width: 30%;"><br></td>
                            <td style="width: 1%;"><input type="checkbox"
                                    {{ $data->tindak_lanjut == 'Belum perlu asuhan gizi' ? 'Checked' : '' }}></td>
                            <td style="width: 49%;">Belum perluh asuhan gizi</td>
                            <td style="width: 1%;"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding-bottom: 60px; padding-top: 20px; padding-left: 5px;">6. Kesimpulan :
                    {{ $data->kesimpulan }}</td>
            </tr>
            <tr>
                <td style="text-align: right; padding-right: 2%;">Tgl
                    :{{ \Carbon\Carbon::parse($data->tanggal_asesmen)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
            </tr>
            <tr>
                <th style="text-align: right; padding-right: 10%; padding-bottom: 30px;">Ahli Gizi,</th>
            </tr>
            <tr>
                <td style="text-align: right; padding-right: 2%;">
                    <img src="{{ $data->ttd_dietitian }}" alt="Base64 Image" width="200px">

                </td>
            </tr>
            <tr>
                <td style="text-align: right; padding-right: 14%; padding-bottom: 50px;"><i>
                        {{ $data->nama_dietitian }}</i></td>
            </tr>
        </table>
    </div>
</body>

</html>
