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

        .tablee1dot8 {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .td11dot8 {
            border: 1px solid black;
            border-collapse: collapse;
            width: 5%;
        }

        .td21dot8 {
            border: 1px solid black;
            border-collapse: collapse;
            width: 25%;
        }

        .td31dot8 {
            border: 1px solid black;
            border-collapse: collapse;
            width: 40%;
            text-align: center;
        }

        .td41dot8 {
            border: 1px solid black;
            border-collapse: collapse;
            width: 30%;
            text-align: center;
        }

        .smallfont1dot8 {
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
    <div class="smallfont1dot8">
        <table class="tablee1dot8" style="width: 100%;">
            <tr>
                <td class="tablee1dot8" style="text-align: center" colspan="4"><b>PEMBERIAN INFORMASI</b></td>
            </tr>
            <tr>
                <td colspan="3">Dokter Pelaksana Tindakan</td>
                <td>: {{ $data->petugas }}</td>

            </tr>
            <tr class="tablee1dot8">
                <td colspan="3">Pemberi Informasi</td>
                <td>: {{ $data->pemberi_info }}</td>
            </tr>
            <tr class="tablee1dot8">
                <td colspan="3">Penerima informasi/pemberi penolakan*</td>
                <td>: {{ $data->penerima_info }}</td>
            </tr>
            <tr style="text-align: center">
                <th class="td11dot8">No.</th>
                <th class="td21dot8">Jenis Informasi</th>
                <th class="td31dot8">Isi Informasi</th>
                <th class="td41dot8">Tandai</th>

            </tr>
            <tr>
                <td class="td11dot8" align="center">1</td>
                <td class="td21dot8">Diagnosis (WD&DD)</td>
                <td class="td31dot8"> {{ $data->diagnosis }}</td>
                <td class="td41dot8"><input type="checkbox" {{ $data->diagnosis_ttd == 'true' ? 'Checked' : '' }}></td>
            </tr>
            <tr>
                <td class="td11dot8" align="center">2</td>
                <td class="td21dot8">Dasar Diagnosis</td>
                <td class="td31dot8"> {{ $data->dasar_diagnosis }}</td>
                <td class="td41dot8"><input type="checkbox" {{ $data->dasar_diagnosis_ttd == 'true' ? 'Checked' : '' }}>
                </td>
            </tr>
            <tr>
                <td class="td11dot8" align="center">3</td>
                <td class="td21dot8">Tindakan Kedokteran</td>
                <td class="td31dot8">{{ $data->tindakan_kedokteran }}</td>
                <td class="td41dot8"><input type="checkbox"
                        {{ $data->tindakan_kedokteran_ttd == 'true' ? 'Checked' : '' }}></td>
            </tr>
            <tr>
                <td class="td11dot8" align="center">4</td>
                <td class="td21dot8">Indikasi Tindakan</td>
                <td class="td31dot8">{{ $data->indikasi_tindakan }}</td>
                <td class="td41dot8"><input type="checkbox"
                        {{ $data->indikasi_tindakan_ttd == 'true' ? 'Checked' : '' }}></td>
            </tr>
            <tr>
                <td class="td11dot8" align="center">5</td>
                <td class="td21dot8">Tata Cara</td>
                <td class="td31dot8">{{ $data->tata_cara }}</td>
                <td class="td41dot8"><input type="checkbox" {{ $data->tata_cara_ttd == 'true' ? 'Checked' : '' }}></td>
            </tr>
            <tr>
                <td class="td11dot8" align="center">6</td>
                <td class="td21dot8">Tujuan</td>
                <td class="td31dot8">{{ $data->tujuan }}</td>
                <td class="td41dot8"><input type="checkbox" {{ $data->tujuan_ttd == 'true' ? 'Checked' : '' }}></td>
            </tr>
            <tr>
                <td class="td11dot8" align="center">7</td>
                <td class="td21dot8">Resiko</td>
                <td class="td31dot8">{{ $data->risiko }}</td>
                <td class="td41dot8"><input type="checkbox" {{ $data->risiko_ttd == 'true' ? 'Checked' : '' }}></td>
            </tr>
            <tr>
                <td class="td11dot8" align="center">8</td>
                <td class="td21dot8">Komplikasi</td>
                <td class="td31dot8">{{ $data->komplikasi }}</td>
                <td class="td41dot8"><input type="checkbox" {{ $data->komplikasi_ttd == 'true' ? 'Checked' : '' }}>
                </td>
            </tr>
            <tr>
                <td class="td11dot8" align="center">9</td>
                <td class="td21dot8">Prognosis</td>
                <td class="td31dot8">{{ $data->prognosis }}</td>
                <td class="td41dot8"><input type="checkbox" {{ $data->prognosis_ttd == 'true' ? 'Checked' : '' }}></td>
            </tr>
            <tr>
                <td class="td11dot8" align="center" rowspan="2">10</td>
                <td class="td21dot8">Alternatif & Resiko</td>
                <td class="td31dot8">{{ $data->alternatif_dan_risiko }}</td>
                <td class="td41dot8"><input type="checkbox" {{ $data->alternatif_dan_risiko_ttd == 'true' ? 'Checked' : '' }}></td>
            </tr>
            <tr>
                <td class="td21dot8">Lain-lain</td>
                <td class="td31dot8">{{ $data->lainlain }}</td>
                <td class="td41dot8"><input type="checkbox" {{ $data->lainlain_ttd == 'true' ? 'Checked' : '' }}></td>
            </tr>
            <tr class="tablee1dot8">
                <td colspan="3" style="text-align: justify; padding:5px">Dengan ini menyatakan bahwa saya Dokter
                    <b>{{ $data->pemberi_info }}</b> telah
                    menerangkan hal-hal diatas
                    secara benar dan jelas dan memberikan kesempatan untuk bertanya dan/atau berdiskusi
                </td>
                <td class="td41dot8" align="center">Dokter, {{ $data->petugas }}<br>
                    <img src="{{ $data->menyatakan_menerangkan_ttd }}" alt="Base64 Image" width="50px">
                </td>
            </tr>
            <tr class="tablee1dot8">
                <td colspan="3" style="text-align: justify; padding:5px">Dengan ini menyatakan bahwa saya/ keluarga
                    pasien
                    <b>{{ $data->menyatakan }}</b> telah menerima informasi
                    sebagaimana diatas serta telah diberi kesempatan untuk berdiskusi/bertanya dan telah memahaminya
                </td>
                <td class="td41dot8" align="center">Penerima informasi,{{ $data->penerima_info }}<br>
                    <img src="{{ $data->menyatakan_memahami_ttd }}" alt="Base64 Image" width="50px">
                </td>
            </tr>
            <tr>
                <td class="tablee1dot8" style="text-align: justify; padding:5px" colspan="4"><i>*Bila pasien tidak
                        kompeten atau tidak mau
                        nerima infromasi, maka penerima
                        informasi, maka penerima informasi adalah wali atau keluarga terdekat</i></td>
            </tr>
            <tr>
                <td class="tablee1dot8" style="text-align: center; padding:5px" colspan="4"><b>PERSETUJUAN
                        TINDAKAN
                        KEDOKTERAN</b></td>
            </tr>
            <tr>
                <td colspan="4" align="justify; padding:5px">Yang bertanda tangan di bawah ini, saya nama
                    <b>{{ $data->yang_bertanda_tangan }}</b>, tanggal
                    lahir
                    <b></b>, jenis kelamin <b>{{ $data->jenis_kelamin }}</b>, alamat <b> {{ $data->alamat }}</b>,
                    hubungan dengan pasien
                    <b> </b>, Dengan ini menyatakan <b>PERSETUJUAN</b> untuk dilakukannya tindakan
                    <b></b> terhadap saya/<b> </b>, bernama <b> </b>, tanggal lahir
                    <b> </b>, jenis kelamin <b> </b>, alamat <b> </b>, Saya memahami
                    perlunya manfaat dan manfaat tindakan tersebut sebagaimana telah dijelaskan seperti diatas kepada
                    saya,
                    termasuk resiko dan komplikasi yang mungkin timbul. <br> Saya juga menyadari bahwa oleh karena itu
                    ilmu
                    kedokteran bukanlah ilmu pasti, maka keberhasilan tindakan kedokteran bukanlah keniscayaan,
                    melainkan
                    sangat bergantung kepada izin Tuhan Yang Maha Esa. <br><br><br>Medan,
                    Tanggal {{ \Carbon\Carbon::parse($data->date)->locale('id')->isoFormat('D MMMM YYYY') }} ,Pukul,
                    {{ $data->time }}
                    <br>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <table style="width: 100%;" border="0">
                        <tr>
                            <td align="center" style="width:200px">
                                Yang menyatakan (Pasien)
                                <br>
                                <img src="{{ $data->yang_menyatakan_ttd }}" alt="Base64 Image" width="100px">
                                <br>
                                ({{ $data->yang_menyatakan }})
                                <br>
                                <i>Tanda Tangan dan Nama Jelas</i>
                            </td>
                            <td align="center" style="width:200px">
                                Saksi (Keluarga Pasien)
                                <br>
                                <img src="{{ $data->saksi_1_ttd }}" alt="Base64 Image" width="100px">
                                <br>
                                ({{ $data->saksi_1 }})
                                <br>
                                <i>Tanda Tangan dan Nama Jelas</i>
                            </td>
                            <td align="center" style="width:200px">
                                Saksi (Perawat)
                                <br>
                                <img src="{{ $data->saksi_2_ttd }}" alt="Base64 Image" width="100px">
                                <br>
                                ({{ $data->saksi_2 }})
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
