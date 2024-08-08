<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM Tindakan Bedah</title>
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
        .steps8dot7 {
            margin-left: -50px;
        }

        .step28dot7 {
            margin-left: -5px;
        }
        .step38dot7 {
            margin-left: 10px;
        }
        .section-10-11-8dot7 {
            margin-top: 8px;
        }
        .logo8dot7 {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 100px; /* Ubah ukuran sesuai kebutuhan Anda */
        }
        .tablee8dot10 {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .td18dot10 {
            border: 1px solid black;
            border-collapse: collapse;
            width: 25%;
            padding-left: 5px;
            padding-right: 5px;
        }

        .td28dot10 {
            width: 7%;
            padding-left: 5px;
            padding-right: 5px;
        }

        .td38dot10 {
            width: 3%;
            padding-left: -10px;
            padding-right: -10px;
        }

        .steps8dot10 {
            margin-left: -30px;
        }
        .fonttt {
            font-size: 10;
        }
        .page_break{
            page-break-before: always;
        }
    </style>
@foreach ($jenistindakan as $tindakan)
    

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;"></div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            @if ($tindakan->namatindakan == 'Tindakan Laser PRP')
            RM 8.7/FTLP/22
            @elseif ($tindakan->namatindakan == 'Injeksi Antivega')
            RM 8.8/LIAV/22
            @elseif ($tindakan->namatindakan == 'Tindakan Laser PRP Capsulotomy')
            RM 8.9/FTL/22
            @elseif ($tindakan->namatindakan == 'Laporan Operasi Trabekulektomi')
            RM 8.10/LOT/22
            @elseif ($tindakan->namatindakan == 'Laporan Operasi Pterygium')
            RM 9.0/LOP/22
            @elseif ($tindakan->namatindakan == 'Laporan Insisi Chalazion')
            RM 9.1/LIC/22
           @endif 
        </div>
        @include('print-rekam-medis.partials.header')
    </div>
    <div>
        <H4 style="text-align: center;">FORM {{ $tindakan->namatindakan }}</H4>
       
            
        <table class="tablee8dot10" style="width: 100%;">
            <p style="text-align: right; padding-bottom: 4%; margin-right:30px;" > Tgl. Operasi
                :{{ $tindakan->tanggal }}</p>
            <table class="tablee8dot10" style="width: 100%; padding-left: 10px; padding-right: 10px;">
                <tr>
                    <td class="td28dot10">
                        Mata :
                    </td>
                    <td class="td38dot10">OD</td>
                    <td class="td38dot10"><input type="checkbox" {{ $tindakan->od == 'Ya' ? 'Checked' : ''}}></td>
                    <td class="td38dot10">OS</td>
                    <td class="td38dot10"><input type="checkbox" {{ $tindakan->os == 'Ya' ? 'Checked' : ''}}></td>
                    <td class="td18dot10">
                        Operator : {{ $tindakan->nama_operator }}
                    </td>
                    <td class="td18dot10">
                        Jam operasi : {{ $tindakan->jam_operasi }}
                    </td>
                    <td class="td18dot10">
                        Lama Operasi : {{ $tindakan->lama_operasi }}
                    </td>
                </tr>
                <tr>
                    <td class="td18dot10" colspan="6">
                        Diagnosis : {{ $tindakan->diagnosis}}
                    </td>
                    <td class="td18dot10" colspan="2">
                        Asisten: {{ $tindakan->asisten }}
                    </td>
                </tr>
                <tr>
                    <td class="td18dot10" colspan="5">
                        Jenis Operasi : {{ $tindakan->jenis_operasi }}
                    </td>
                    <td class="td18dot10" colspan="2">
                        Anesteshia : {{ $tindakan->anesthesia }}
                    </td>
                    <td class="td18dot10">
                        Anesthesiologist : {{ $tindakan->anesthesiologist }}
                    </td>
                </tr>
            </table>
            <p >Langkah-langkah tindakan :</p>
        @if ($tindakan->namatindakan == 'Tindakan Laser PRP')
       
        
            <ol>
                <li>Pasien diberi obat tetes pelebar pupil mata (Mydriatyl 1%).</li>
                <li>Perawat mempersiapkan berkas kelengkapan tindakan laser.</li>
                <li>Perawat mengecek pupil mata pasien, jika pupil mata sudah lebar pasien masuk ke ruangan laser.</li>
                <li>Pasien diberi obat tetes Anestesi (Pantocain 0,5%).</li>
                <li>Pasien duduk menghadap ke alat laser.</li>
                <li>Pasien menempelkan dagu dan dahi ke peyangga pada alat laser.</li>
                <li>Dokter menyalakan alat Laser Photocoagulation.</li>
                <li>Pasien dipasang Lensa Super Quad/Trans Equator pada mata yang akan dilaser.</li>
                <li>Dilakukan tindakan laser dengan parameter (power) laser: 200 ms x 200 ms x 240 mW = 352</li>
                <li>Setelah selesai tindakan laser, pasien diberi obat tetes antibiotik.</li>
                 <li>Pasien diberikan resep obat dan surat kontrol.</li>
            </ol>

        @elseif ($tindakan->namatindakan == 'Laporan Insisi Chalazion')
        <ol >
            <li >Pasien dibaringkan di meja operasi.</li>
            <li >Disinfektan lapangan operasi dengan betadine.</li>
            <li >Tutup dengan doek steril.</li>
            <li >Pasang forceps chalizon.</li>
            <li >Anestesi dengan inj. Lidocain subconjungtiva margin palpebra.</li>
            <li >Incesi daerah chalizon, tampak keluar nanah.</li>
            <li >Bersihkan chalizon dengan cuvet.</li>
            <li >Kontrol perdaharahn.</li>
            <li >Beri salep antibiotik kemudian ditutup dengan kassa steril.</li>
            <li >Operasi selesai.</li>
        </ol>
         @elseif ($tindakan->namatindakan == 'Injeksi Antivega')
        <ol  style="padding-top: 3%;">
            <li >Pasien berbaring dalam anestesi topical/ local/ umum.</li>
            <li >Dilakukan tindakan a & antiseptis menggunakan providone iodin.</li>
            <li >Dipasangkan eye drape.</li>
            <li >Dipasangkan blefarostat.</li>
            <li >Dilakukan pengukuran menggunakan caliper/trocar dengan jarak 3,5/4mm dari limbus di kuadran superior/temporal.</li>
            <li >Dilakukan injeksi avasin / intravitreal sebanyak ........... ml.</li>
            <li >Diteteskan antibiotik.</li>
            <li >Mata ditutup kasa & dop.</li>
            <li >tindakan selesai</li>
        </ol>
        @elseif ($tindakan->namatindakan == 'Tindakan Laser PRP Capsulotomy')
        <ol>
            <ol >
                <li>Pasien diberi obat tetes pelebar pupil mata (Mydriatyl 1%).</li>
                <li>Perawat mempersiapkan berkas kelengkapan tindakan laser.</li>
                <li>Perawat mengecek pupil mata pasien, jika pupil mata sudah lebar pasien masuk ke ruangan laser.</li>
                <li>Pasien diberi obat tetes Anestesi (Pantocain 0,5%).</li>
                <li>Pasien duduk menghadap ke alat laser.</li>
                <li>Pasien menempelkan dagu dan dahi ke peyangga pada alat laser.</li>
                <li>Dokter menyalakan alat YAG Laser.</li>
                <li>Dilakukan tindakan laser dengan parameter (power) laser:</li>
                <li>Setelah selesai tindakan laser, pasien diberi obat tetes antibiotik.</li>
                 <li>Pasien diberikan resep obat dan surat kontrol.</li>
            </ol>
            @elseif ($tindakan->namatindakan == 'Laporan Operasi Trabekulektomi')
            <ol  style="padding-top: 1%;">
                <li >Pasien dalam posisi SUPINE di tempat tidur.</li>
                <li >Teknik A & Antiseptic.</li>
                <li >Pasang drape dan spekulum.</li>
                <li >Dilakukan Anasteshi Subkonjungtiva.</li>
                <li >Pemasangan kendali dengan benang slik 7-0 jahitan half thickness.</li>
                <li >Peritomi Konjungtiva superior dan cauter pendarahan.</li>
                <li >Buat insisi sk;era ukuran 4x3mm dan dibuat Flap Sklera.</li>
                <li >Dilakukan parasintesi dengan stab knife 15&deg; dan trabekulektomi ukuran 2x2mm.</li>
                <li >Lalu dilakukan iridektomi kemudian flab ditutup dan sklera dijahit tiap sudut dengan ethylon 10-0.</li>
                <li >Konjungtiva dijahit dengan benang ethylon 10-0</li>
                <li >Injeksi Antibiotik Gentamycin, Dexametason dan salep mata</li>
                <li >Operasi selesai</li>
            </ol>
            @elseif ($tindakan->namatindakan == 'Laporan Operasi Pterygium')
            <ol class="step8dot7" style="padding-top: 3%;">
                <li >Pasien dalam posisi SUPINE di tempat tidur dan Anastesi Parabulper.</li>
                <li >Teknik A & Antiseptic.</li>
                <li >Tutup duklubang steril.</li>
                <li >Pasang Blefarostat.</li>
                <li >Injeksi Lidocain pada caput dan corpus pterygium.</li>
                <li >Pisahkan dari epitrkornea hingga bersih.</li>
                <li >Atasi pendarahan.</li>
                <li >Gunting corpus pterygium.</li>
                <li >Buat graft dari Konjungtiva bagian sup or</li>
                <li >Geser ke medial, jahit tepinya</li>
                <li >Salp</li>
                <li >Operasi selesai</li>
            </ol> 
        @endif
    </div>
    <br>
    <br>

        <p style="text-align: right; margin-right:30px">Tanda Tangan DPJP/Dokter</p>
        <br><br><br><br>
        <p style="text-align: right; margin-right:30px">(_____________________)</p>
    
</body>
@if ($loop->index < count($jenistindakan) - 1)
<div class="page_break"></div>
@endif
@endforeach
</html>