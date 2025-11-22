<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>REKAM MEDIS GENERAL - FORMULIR KONSUL DAN JAWABAN KONSUL</title>
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
    </style>

</head>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;">
    </div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <?php $eyero = storage_path('app/public/images/EYE-RO.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 10.2/FKDJK/22
        </div>
        @include('print-rekam-medis.partials.header')     
        <table class="tablee" style="width:100%; position:relative">
        <tr>
            <td style="border-bottom: 1px solid black; font-weight: bold; text-align: center;"> FORMULIR KONSUL</td>
        </tr>
        <tr>
            <td style="padding-left:5px;">
                TS. Dr ___________________________ Yth.
            </td>
        </tr>
        <tr>
            <td >
                <table style="width:100%;">
                    <tr>
                        <td style="padding-left:3px;">Mohon</td>
                        <td><input type="checkbox"></td>
                        <td>1) Konsul Saja</td>
                        <td><input type="checkbox"></td>
                        <td>2) Pengobatan bersama selanjutnya</td>
                        <td><input type="checkbox"></td>
                        <td>3)Ambil Alih</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table style="width:100%;">
                    <tr>
                        <td style="width:10%; padding-left:5px;">Pasien</td>
                        <td style="width:10%;">Nama</td>
                        <td style="width:80%;">: ..........................................................................................................................................</td>
                    </tr>
                    <tr>
                        <td style="width:10%;"><br></td>
                        <td style="width:10%;">Tgl.Lahir</td>
                        <td style="width:80%;">: ..................................................................................................................................<b>L/P*</b></td>
                    </tr>
                    <tr>
                        <td style="width:10%;"><br></td>
                        <td style="width:10%;">Diagnosa</td>
                        <td style="width:80%;">: ..........................................................................................................................................</td>
                    </tr>
                </table>
            </td>
        </tr>
         <tr>
            <td>
                <table style="width:100%;">
                <div style="padding-left:5px;"> Dengan Persangkaan kami menderita : ..................................................................................................................</div>
                <div style="padding-left:5px;">: ..............................................................................................................................................................................</div>
                <div style="padding-left:5px;"> Pada pasien kami dapati hal-hal sebagai berikut : .................................................................................................</div>
                <div style="padding-left:5px;">: ..............................................................................................................................................................................</div>
                <div style="padding-left:5px;"> Pengobatan/Tindakan Pembedahan yang telah kami berikan adalah : .................................................................</div>
                <div style="padding-left:5px;">: ..............................................................................................................................................................................</div>
                <div style="padding-left:5px;">Atas bantuan TS kami ucapkan terima kasih</div>
                </table>
            </td>
        </tr>
        <tr>
            <td style="text-align:right; padding-right:5px;">Medan, ………Tgl ………../ Jam : </td>
        </tr>
        <tr>
            <td style="text-align:right; padding-right:8%;">Salam Sejawat </td>
        </tr>
        <tr>
            <td style="text-align:right; padding-right:3px; padding-top:3%;">.......................................................</td>
        </tr>
        <tr>
            <td style="text-align:right; padding-right:5px;">Nama dan Tanda Tangan Dokter </td>
        </tr>
        <tr>
            <td style="font-weight: bold; text-align: center; border-bottom: 1px solid black; border-top: 1px solid black;">FORMULIR JAWABAN KONSUL</td>
        </tr>
        <tr>
            <td style="padding-left:5px;">
                TS. Dr ___________________________ Yth.
            </td>
        </tr>
        <tr>
            <td style="padding-left:5px;">Sehubungan dengan permintaan konsul TS, tanggal ....................</td>
        </tr>
        <tr>
            <td>
                <table style="width:100%;">
                    <tr>
                        <td style="width:10%; padding-left:2px;">Pasien</td>
                        <td style="width:10%;">Nama</td>
                        <td style="width:80%;">: ...........................................................................................................................................</td>
                    </tr>
                    <tr>
                        <td style="width:10%;"><br></td>
                        <td style="width:10%;">Tgl.Lahir</td>
                        <td style="width:80%;">: ...........................................................................................................................................</td>
                    </tr>
                </table>
            </td>
        </tr>
         <tr>
            <td>
                <table style="width:100%;">
                <div style="padding-left:3px;"> Kami sampaikan sebagai berikut : ..........................................................................................................................</div>
                <div style="padding-left:3px;">: ...............................................................................................................................................................................</div>
                <div style="padding-left:3px;"> Berdasarkan hal-hal tersebut diatas, kami anjurkan dilakukan pemeriksaan / tindakan pembedahan</div>
                <div style="padding-left:3px;">: ...............................................................................................................................................................................</div>
                <div style="padding-left:3px;">: ...............................................................................................................................................................................</div>
                <div style="padding-left:3px;"> Juga kami anjurkan konsultasi TS : ............................................Bagian................................................................</div>
                <div style="padding-left:3px;">: ...............................................................................................................................................................................</div>
                <div style="padding-left:3px;"> Therapy / tindakan yang kami anjurkan </div>
                <div style="padding-left:3px;">: ...............................................................................................................................................................................</div>
                <div style="padding-left:3px;">: ...............................................................................................................................................................................</div>
                <div style="padding-left:3px;">Atas bantuan TS kami ucapkan terima kasih</div>
                </table>
            </td>
        </tr>
        <tr>
            <td style="text-align:right; padding-right:5px;">Medan, ………Tgl ………../ Jam : </td>
        </tr>
        <tr>
            <td style="text-align:right; padding-right:8%;">Salam Sejawat </td>
        </tr>
        <tr>
            <td style="text-align:right; padding-right:3px; padding-top:2%;">.......................................................</td>
        </tr>
        <tr>
            <td style="text-align:right; padding-right:5px;">Nama dan Tanda Tangan Dokter </td>
        </tr>
        </table>    
        </div>
</body>