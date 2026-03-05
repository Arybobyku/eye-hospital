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
            {{ $data->no_surat ?? 'RM 3.2/KADPPB/' . config('app.tahun_akreditasi', '22') }}
        </div>
        @include('print-rekam-medis.partials.header')
        <table style="width: 100%;  border: 1px solid black;" cellpadding="0" cellspacing="0">
            <tr>
                <td style="font-weight: bold; text-align: center; padding: 7px; border-bottom: 1px solid black;">
                    FORM KRONOLOGIS PASIEN
                </td>
            </tr>
            <tr>
                <td style="padding-bottom: 10px; padding-left: 8px;">saya yang bertanda tangan dibawah ini:</td>
            </tr>
            <tr>
                <td>
                    <table style="width: 80%; padding-left: 8px">
                        <tr>
                            <td style="width: 20%;">Nama</td>
                            <td style="width: 39%;">: {{ $data->nama_pembuat }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table style="width: 80%; padding-left: 8px">
                        <tr>
                            <td style="width: 20%;">Alamat</td>
                            <td style="width: 39%;">: {{ $data->alamat_pembuat }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table style="width: 80%; padding-left: 8px">
                        <tr>
                            <td style="width: 20%;">NIK</td>
                            <td style="width: 39%;">: {{ $data->nik_pembuat }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table style="width: 80%; padding-left: 8px">
                        <tr>
                            <td style="width: 20%;">Hubungan dengan pasien</td>
                            <td style="width: 1%;">:</td>
                            <td style="width: 39%;">
                                {{ $data->hubungan_pasien != 'Lainnya' ? $data->hubungan_pasien : $data->hubungan_pasien_lainnya }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding-bottom: 10px; padding-left: 8px; padding-top:10px">
                    <br>
                    Dengan ini menerangkan kronologis kejadian yang terjadi pada : <br><br>
                    Tanggal :
                    <b>{{ \Carbon\Carbon::parse($data->tanggal_kejadian)->locale('id')->isoFormat('D MMMM YYYY') }} </b>
                    pukul <b>{{ \Carbon\Carbon::parse($data->jam_kejadian)->locale('id')->isoFormat('HH:MM') }}</b> di
                    <b>{{ $data->tempat_kejadian }}</b>. Kejadian ini terjadi pada saat :
                    <br>
                    <br>
                    Sedang Bekerja/Pergi Bekerja/Pulang Bekerja *)
                </td>
            </tr>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td style="padding-left: 15px;"><input type="checkbox"
                                    {{ $data->lokasi_kecelakaan_lalu_lintas ? 'checked' : '' }}>
                            </td>
                            <td> Kecelakaan Lalu Lintas di Jalan Raya </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td style="padding-left: 15px;"><input type="checkbox"
                                    {{ $data->lokasi_rumah ? 'checked' : '' }}>
                            </td>
                            <td> Rumah </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td style="padding-left: 15px;"><input type="checkbox"
                                    {{ $data->lokasi_lainnya_check ? 'checked' : '' }}>
                            </td>
                            <td> Lainya {{ $data->lokasi_lainnya }} </td>
                        </tr>
                    </table>
                    <br>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 8px; ">
                    {{ $data->detail_kronologis }}
                </td>
            </tr>
            <tr>
                <td style="padding-left: 15px; font-size:14px; padding-top:10px">
                    - Formulir kronologis ini diisi dan dilengkapi dengan sebenar-benarnya, sesuai fakta, waktu dan
                    tempat
                    kejadian;
                    <br>
                    - Apabila saya memberikan kronologis yang tidak benar maka saya bersedia bertanggung jawab untuk
                    membayar seluruh
                    biaya perawatan kesehatan pasien selama dirawat di RSK. Mata Prima Vision.
                    <br>
                    - Apabila dikemudian hari, adanya tuntutan perihal formulir kronologis ini maka RSK. Mata Prima
                    Vision
                    akan
                    dibebaskan dari segala tuntutan hukum pidana maupun perdata.
                </td>
            </tr>
            <tr>
                <td style="padding-top: 10px; padding-left:8px">
                    Demikian kronologis ini saya buat dengan penuh kesadaran dan rasa tanggung jawab untuk dipergunakan
                    sebagaimana mestinya.
                </td>
            </tr>

            <tr>
                <td style=" padding-left: 2%; padding-top:20px">Medan, 
                    :{{ \Carbon\Carbon::parse($data->tanggal_ttd)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
            </tr>
            <tr>
                <td style=" padding-left: 2%; padding-bottom: 30px;">Hormat saya,</td>
            </tr>
            <tr>
                <td style="padding-left: 2%;">
                    <img src="{{ $data->ttd_pembuat }}" alt="Base64 Image" width="200px">

                </td>
            </tr>
            <tr>
                <td style="padding-left: 8%; padding-bottom: 50px;"><i>
                        {{ $data->nama_pembuat }}</i></td>
            </tr>
        </table>
    </div>
</body>

</html>
