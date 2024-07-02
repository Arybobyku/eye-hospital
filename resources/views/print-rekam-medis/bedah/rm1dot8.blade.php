<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM1.8</title>
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

        .td1 {
            border: 1px solid black;
            border-collapse: collapse;
            width: 5%;
        }

        .td2 {
            border: 1px solid black;
            border-collapse: collapse;
            width: 25%;
        }

        .td3 {
            border: 1px solid black;
            border-collapse: collapse;
            width: 40%;
            text-align: center;
        }

        .td4 {
            border: 1px solid black;
            border-collapse: collapse;
            width: 30%;
            text-align: center;
        }
        .smallfont {
            font-size: 10;
        }
    </style>

</head>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;"></div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 1.8/PTK/22
        </div>
        @include('print-rekam-medis.partials.header')
    </div>
    <div style="text-align: center; padding:5px;"><b>PERSETUJUAN TINDAKAN KEDOKTERAN</b></div>
    <div class="smallfont">
    <table class="tablee" style="width: 100%;">
        <tr>
            <td class="tablee" style="text-align: center" colspan="4"><b>PEMBERIAN INFORMASI</b></td>
        </tr>
        <tr>
            <td colspan="3">Dokter Pelaksana Tindakan</td>
            <td>: {{ $ptk->dokter_pelaksana_tindakan }}</td>

        </tr>
        <tr class="tablee">
            <td colspan="3">Pemberi Informasi</td>
            <td>: {{ $ptk->pemberi_informasi }}</td>
        </tr>
        <tr class="tablee">
            <td colspan="3">Penerima informasi/pemberi penolakan*</td>
            <td>: {{ $ptk->penerima_penolak_informasi}}</td>
        </tr>
        <tr style="text-align: center">
            <th class="td1">No.</th>
            <th class="td2">Jenis Informasi</th>
            <th class="td3">Isi Informasi</th>
            <th class="td4">Tandai</th>

        </tr>
        <tr>
            <td class="td1" align="center">1</td>
            <td class="td2">Diagnosis (WD&DD)</td>
            <td class="td3"> {{ $ptk->ji_diagnosis_wd_dd }}</td>
            <td class="td4"><input type="checkbox" {{ $ptk->ji_diagnosis_wd_dd != '' ? 'Checked' : '' }}></td>
        </tr>
        <tr>
            <td class="td1" align="center">2</td>
            <td class="td2">Dasar Diagnosis</td>
            <td class="td3"> {{ $ptk->ji_dasar_diagnosis }}</td>
            <td class="td4"><input type="checkbox" {{ $ptk->ji_dasar_diagnosis != '' ? 'Checked' : '' }}></td>
        </tr>
        <tr>
            <td class="td1" align="center">3</td>
            <td class="td2">Tindakan Kedokteran</td>
            <td class="td3">{{ $ptk->ji_tindakan_kedokteran }}</td>
            <td class="td4"><input type="checkbox" {{ $ptk->ji_tindakan_kedokteran != '' ? 'Checked' : '' }}></td>
        </tr>
        <tr>
            <td class="td1" align="center">4</td>
            <td class="td2">Indikasi Tindakan</td>
            <td class="td3">{{ $ptk->ji_indikasi_tindakan }}</td>
            <td class="td4"><input type="checkbox" {{ $ptk->ji_indikasi_tindakan != '' ? 'Checked' : '' }}></td>
        </tr>
        <tr>
            <td class="td1" align="center">5</td>
            <td class="td2">Tata Cara</td>
            <td class="td3">{{ $ptk->ji_tata_cara }}</td>
            <td class="td4"><input type="checkbox" {{ $ptk->ji_tata_cara != '' ? 'Checked' : '' }}></td>
        </tr>
        <tr>
            <td class="td1" align="center">6</td>
            <td class="td2">Tujuan</td>
            <td class="td3">{{ $ptk->ji_tujuan }}</td>
            <td class="td4"><input type="checkbox" {{ $ptk->ji_tujuan != '' ? 'Checked' : '' }}></td>
        </tr>
        <tr>
            <td class="td1" align="center">7</td>
            <td class="td2">Resiko</td>
            <td class="td3">{{ $ptk->ji_resiko }}</td>
            <td class="td4"><input type="checkbox" {{ $ptk->ji_resiko != '' ? 'Checked' : '' }}></td>
        </tr>
        <tr>
            <td class="td1" align="center">8</td>
            <td class="td2">Komplikasi</td>
            <td class="td3">{{ $ptk->ji_komplikasi }}</td>
            <td class="td4"><input type="checkbox" {{ $ptk->ji_komplikasi != '' ? 'Checked' : '' }}></td>
        </tr>
        <tr>
            <td class="td1" align="center">9</td>
            <td class="td2">Prognosis</td>
            <td class="td3">{{ $ptk->ji_prognosis }}</td>
            <td class="td4"><input type="checkbox" {{ $ptk->ji_prognosis != '' ? 'Checked' : '' }}></td>
        </tr>
        <tr>
            <td class="td1" align="center" rowspan="2">10</td>
            <td class="td2">Alternatif & Resiko</td>
            <td class="td3">{{ $ptk->ji_alternatif_dan_resiko }}</td>
            <td class="td4"><input type="checkbox" {{ $ptk->ji_alternatif_dan_resiko != '' ? 'Checked' : '' }}></td>
        </tr>
        <tr>
            <td class="td2">Lain-lain</td>
            <td class="td3">{{ $ptk->ji_lain_lain }}</td>
            <td class="td4"><input type="checkbox" {{ $ptk->ji_lain_lain  != '' ? 'Checked' : '' }}></td>
        </tr>
        <tr class="tablee">
            <td colspan="3" style="text-align: justify; padding:5px">Dengan ini menyatakan bahwa saya Dokter <b>{{ $ptk->dokter_pelaksana_tindakan }}</b> telah
                menerangkan hal-hal diatas
                secara benar dan jelas dan memberikan kesempatan untuk bertanya dan/atau berdiskusi</td>
            <td class="td4" align="center">Dokter,<br><br>(.................)</td>
        </tr>
        <tr class="tablee">
            <td colspan="3" style="text-align: justify; padding:5px">Dengan ini menyatakan bahwa saya/ keluarga pasien
               <b>{{ $ptk->penerima_penolak_informasi }}</b> telah menerima informasi
                sebagimana diatas serta telah diberi kesempatan untuk berdiskusi/bertanya dan telah memahaminya</td>
            <td class="td4" align="center">Penerima informasi,<br><br>(.................)</td>
        </tr>
        <tr>
            <td class="tablee" style="text-align: justify; padding:5px" colspan="4"><i>*Bila pasien tidak kompeten atau tidak mau
                    nerima infromasi, maka penerima
                    informasi, maka penerima informasi adalah wali atau keluarga terdekat</i></td>
        </tr>
        <tr>
            <td class="tablee" style="text-align: center; padding:5px" colspan="4"><b>PERSETUJUAN TINDAKAN KEDOKTERAN</b></td>
        </tr>
        <tr>
            <td colspan="4" align="justify; padding:5px">Yang bertanda tangan di bawah ini, saya nama <b>{{ $ptk->ptk_nama_penerima }}</b>, tanggal
                lahir
                <b>{{ $ptk->ptk_tanggal_lahir_penerima }}</b>, jenis kelamin <b>{{ $ptk->ptk_jenis_kelamin_penerima }}</b>, alamat <b> {{ $ptk->ptk_alamat_penerima }}</b>, hubungan dengan pasien
                <b> {{ $ptk->ptk_hubungan_penerima }}</b>, Dengan ini menyatakan <b>PERSETUJUAN</b> untuk dilakukannya tindakan
                <b> {{ $ptk->ptk_tindakan}}</b> terhadap<b> {{ $ptk->ptk_terhadap }} saya</b>, bernama <b> {{ $ptk->ptk_nama_target }}</b>, tanggal lahir
                <b> {{ $ptk->ptk_tanggal_lahir_target}}</b>, jenis kelamin  <b>{{ $ptk->ptk_jenis_kelamin_target }}</b>, alamat <b> {{ $ptk->ptk_alamat_target }}</b>, Saya memahami
                perlunya manfaat dan manfaat tindakan tersebut sebagaimana telah dijelaskan seperti diatas kepada saya,
                termasuk resiko dan komplikasi yang mungkin timbul. <br> Saya juga menyadari bahwa oleh karena itu ilmu
                kedokteran bukanlah ilmu pasti, maka keberhasilan tindakan kedokteran bukanlah keniscayaan, melainkan
                sangat bergantung kepada izin Tuhan Yang Maha Esa. <br><br><br>Medan,
                Tanggal {{ $ptk->tanggal }},Pukul, {{  $ptk->pukul }}
                <br>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <table style="width: 100%;" border="0">
                    <tr>
                        <td align="center" style="width:200px">
                            Yang menyatakan (pasien),
                            <br>
                            <br>
                            <br>
                            ({{ $pasien->nama }})
                            <br>
                            <i>Tanda Tangan dan Nama Jelas</i>
                        </td>
                        <td align="center" style="width:200px">
                            Saksi (Keluarga Pasien)
                            <br>
                            <br>
                            <br>
                            ({{ $ptk->ptk_nama_penerima }})
                            <br>
                            <i>Tanda Tandan dan Nama Jelas</i>
                        </td>
                        <td align="center" style="width:200px">
                            Saksi (Perawat)
                            <br>
                            <br><br>
                            ({{ $ptk->perawat }})
                            <br>
                            <i>Tanda Tangan dan Nama Jelas</i>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    </div>
</body>

</html>