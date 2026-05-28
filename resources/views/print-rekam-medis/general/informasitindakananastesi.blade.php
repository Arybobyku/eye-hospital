<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>INFORMASI TINDAKAN ANASTESI DAN SEDASI</title>
    <style>
        @page { margin: 20px 25px 80px 25px; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            font-size: 9.5pt;
            color: #000;
        }

        .wrap { width: 100%; }

        .no-surat {
            text-align: right;
            font-size: 9.5pt;
            margin-bottom: 4px;
        }

        .judul {
            text-align: center;
            font-weight: bold;
            font-size: 12pt;
            margin: 10px 0 12px 0;
            text-decoration: underline;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        .data-table td {
            padding: 2px 5px;
            vertical-align: top;
            font-size: 9.5pt;
            border: none;
        }

        .label-col { width: 110px; }
        .colon-col { width: 10px; }

        .section-title {
            font-weight: bold;
            font-size: 9.5pt;
            margin: 8px 0 3px 0;
        }

        .sub-title {
            font-weight: bold;
            font-size: 9.5pt;
            margin: 6px 0 2px 0;
        }

        .content-text {
            font-size: 9.5pt;
            margin: 2px 0;
            text-align: justify;
        }

        .bullet-item {
            margin: 2px 0 2px 14px;
            font-size: 9.5pt;
            text-align: justify;
        }

        .page-break { page-break-before: always; }

        .sign-section {
            margin-top: 20px;
            padding: 10px;
        }

        .sign-intro {
            font-size: 9.5pt;
            margin-bottom: 8px;
            text-align: justify;
        }

        .sign-table {
            width: 100%;
            border-collapse: collapse;
        }

        .sign-table td {
            padding: 3px 5px;
            vertical-align: top;
            font-size: 9.5pt;
            border: none;
        }

        .sign-label { width: 150px; }
        .sign-colon { width: 10px; }

        .ttd-row {
            width: 100%;
        }

        .ttd-cell {
            width: 50%;
            text-align: center;
            padding: 0 10px;
            vertical-align: top;
        }

        .ttd-img {
            max-width: 130px;
            max-height: 65px;
            display: block;
            margin: 0 auto 2px auto;
        }

        .ttd-nama {
            display: inline-block;
            border-top: 1px solid #000;
            min-width: 160px;
            text-align: center;
            padding-top: 3px;
            font-size: 9.5pt;
        }
    </style>
</head>
<body>
<?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>

<div class="wrap">
    <div class="no-surat">RM 8.2/ITADS/{{ config('app.tahun_akreditasi', '22') }}</div>

    @include('print-rekam-medis.partials.header')

    <div style="border: 1px solid #000; padding: 8px 12px; margin-top: 6px;">

    <div class="judul">INFORMASI TINDAKAN ANASTESI DAN SEDASI</div>

    <hr style="border:none; border-top:1px solid #ccc; margin:6px 0 10px 0;">

    <!-- ANASTESIA UMUM -->
    <div class="section-title"><input type="checkbox" {{ $data->baca_au ? 'checked' : '' }}> ANASTESIA UMUM (AU)</div>
    <p class="content-text">AU adalah teknik pembiusan dengan bius total dimana pasien tidak sadar, tidak dapat diransang dan tidak merasakan sakit. Obat bius untuk AU berupa obat yang disuntikkan kedalam pembuluh darah atau zat anastesi yang dapat dihirup/dihisap, terutama pada bayi/anak, lama kerja obat disesuaikan dengan lama operasi. Sesuai dengan kebutuhan operasi dan kondisi pasien, teknik ini akan mempengaruhi kemampuan untuk mempertahankan patensi jalan nafas, terjadi depresi fungsi pernafasan spontan atau depresi fungsi otot sehingga pasien sering memerlukan pemasangan alat pernafasan untuk mempertahankan patensi jalan nafas dan pemberian nafas bantu.</p>

    <div class="sub-title">KELEBIHAN TEKNIK AU :</div>
    <div class="bullet-item">• Dari awal pembiusan pasien sudah tidak sadar, tidak merasakan nyeri, teknik dan lama pembiusan bisa disesuaikan dengan lama operasi.</div>

    <div class="sub-title">KEKURANGAN TEKNIK AU :</div>
    <div class="bullet-item">• Pasca bedah pasien harus sadar penuh sebelum bisa diberi minum.</div>
    <div class="bullet-item">• Obat bius yang diberikan dapat memiliki efek keseluruh tubuh termasuk ke aliran pembuluh janin dalam kandungan.</div>

    <div class="sub-title">KOMPLIKASI / EFEK SAMPING :</div>
    <div class="bullet-item">• Efek samping pasca bedah berupa mual muntah, menggigil, pusing, mengantuk, sakit tenggorokan yang bisa diatasi dengan obat-obatan.</div>
    <div class="bullet-item">• Beresiko pada pasien yang tidak puasa, bisa terjadi aspirasi yaitu masuknya isi lambung ke jalan nafas/paru.</div>
    <div class="bullet-item">• Kesulitan pemasangan alat/pipa pernafasan yang tidak terduga sebelumnya.</div>
    <div class="bullet-item">• Alergi/hipersensitif terhadap obat (sangat jarang), mulai derajat ringan hingga berat/fatal.</div>

    <!-- ANESTESIA SPINAL/EPIDURAL -->
    <div class="section-title" style="margin-top:8px;"><input type="checkbox" {{ $data->baca_spinal ? 'checked' : '' }}>ANESTESIA SPINAL / EPIDURAL</div>
    <div class="bullet-item">• Anestesia spinal/epidural adalah pembiusan yang hanya meliputi daerah perut ke bawah (perut sampai ujung kaki) dengan pasien tetap sadar tanpa merasakan nyeri. Bila pasien menginginkan untuk tidur maka dokter dapat memberi obat tidur/penenang melalui suntikan.</div>
    <div class="bullet-item">• Untuk anestesia epidural di daerah punggung penyuntikan didahului dengan pemberian obat bius lokal dan melalui jarum epidural yang disuntikan di celah tulang belakang akan dimasukkan selang kecil ke arah pinggiran tulang belakang.</div>
    <div class="bullet-item">• Pada kedua teknik diatas, penyuntikan dilakukan pada pasien dalam keadaan posisi duduk membungkuk atau miring ke salah satu sisi. Hilang rasa ini bisa berlangsung kira-kira 2 sampai 3 jam sesuai jenis obat anestesi lokal yang digunakan.</div>

    <div class="sub-title">KELEBIHAN TEKNIK ANESTESI SPINAL / EPIDURAL :</div>
    <div class="bullet-item">• Jumlah obat yang diberikan sedikit sekali.</div>
    <div class="bullet-item">• Obat bius tidak masuk ke dalam sirkulasi ari-ari/rahim sehingga baik untuk operasi besar.</div>
    <div class="bullet-item">• Bisa ditambahkan obat penghilang rasa sakit yang bisa bertahan hingga 24 jam pasca bedah.</div>
    <div class="bullet-item">• Bila tidak mual/muntah pasca bedah bisa langsung minum tanpa harus menunggu flatus.</div>
    <div class="bullet-item">• Lebih aman untuk pasien yang tidak puasa/operasi darurat.</div>

    </div>{{-- end border page 1 --}}

    <!-- Page 2 -->
    <div class="page-break"></div>
    <div class="no-surat">RM 8.2/ITADS/{{ config('app.tahun_akreditasi', '22') }}</div>
    @include('print-rekam-medis.partials.header')

    <div style="border: 1px solid #000; padding: 8px 12px; margin-top: 6px;">

    <div class="sub-title" style="margin-top:8px;">KELEMAHAN SPINAL / EPIDURAL :</div>
    <div class="bullet-item">• Pasca bedah harus berbaring, tidak boleh duduk/bangun selama 6 jam.</div>

    <div class="sub-title">KOMPLIKASI / EFEK SAMPING :</div>
    <div class="bullet-item">• Efek samping pasca bedah yang sering adalah mual/muntah, gatal-gatal terutama di daerah wajah, semua bisa diatasi dengan obat-obatan.</div>
    <div class="bullet-item">• Efek samping yang jarang adalah sakit kepala di bagian depan atau belakang kepala pada hari ke-2/ke-3 terutama pada waktu mengangkat kepala dan menghilang 5 sampai 7 hari.</div>
    <div class="bullet-item">• Efek samping lain berupa kesulitan buang air kecil.</div>
    <div class="bullet-item">• Alergi hipersensitif terhadap obat (sangat jarang), mulai derajat ringan hingga berat/fatal.</div>
    <div class="bullet-item">• Gangguan pernafasan mulai dari ringan sampai berat (henti nafas).</div>
    <div class="bullet-item">• Kelumpuhan atau kesemutan/rasa baal di tungkai yang memanjang, bersifat sementara dan bisa sembuh kembali.</div>
    <div class="bullet-item">• Untuk epidural bisa terjadi kejang bila obat masuk ke dalam pembuluh darah (jarang terjadi).</div>

    <!-- BLOK PERIFER -->
    <div class="section-title" style="margin-top:8px;"><input type="checkbox" {{ $data->baca_blok ? 'checked' : '' }}> BLOK PERIFER</div>
    <p class="content-text">Blok Perifer adalah teknik pembiusan yang hanya melibatkan sebagian tubuh saja (misalnya lengan atas atau bawah, tangan, kaki dan sebagainya). Teknik ini dilakukan dengan penyuntikkan obat bius lokal di daerah sekitar saraf yang mensyarafi sebagian tubuh yang akan dioperasi. Efek bius berlangsung antara 2-4 jam tergantung jenis obat yang dipakai.</p>

    <div class="sub-title">KOMPLIKASI / EFEK SAMPING :</div>
    <div class="bullet-item">• Rasa kesemutan dan atau gangguan bergerak (motorik) yang berkepanjangan tetapi bersifat sementara.</div>
    <div class="bullet-item">• Pendarahan dibawah kulit (hematom).</div>
    <div class="bullet-item">• Tertusuknya lapisan paru.</div>
    <div class="bullet-item">• Pembiusan yang tidak komplit (sebagian tubuh terbius).</div>
    <div class="bullet-item">• Reaksi alergi atau hipersensitif yang ringan hingga berat (fatal).</div>
    <div class="bullet-item">• Kejang bila obat masuk ke dalam pembuluh darah yang dapat ditangani sesuai prosedur tanpa gejala sisa.</div>

    <!-- SEDASI -->
    <div class="section-title" style="margin-top:8px;"><input type="checkbox" {{ $data->baca_sedasi ? 'checked' : '' }}>SEDASI</div>
    <div class="sub-title">• Sedasi Ringan</div>
    <p class="content-text">Teknik pembiusan dengan penyuntikkan obat yang dapat menyebabkan pasien mengantuk, tetapi masih memiliki respon normal terhadap rangsangan verbal dan tetap dapat mempertahankan patensi dari jalan nafasnya, sedang fungsi pernafasan dan kerja jantung serta pembuluh darah tidak dipengaruhi.</p>

    <div class="sub-title">• Sedasi Sedang</div>
    <p class="content-text">Teknik pembiusan dengan penyuntikkan obat yang dapat menyebabkan pasien mengantuk, tetapi masih memiliki respon terhadap rangsangan verbal. Pada sedasi moderat terjadi perubahan ringan dari respon pernafasan namun fungsi kerja jantung serta pembuluh darah masih tetap dipertahankan.</p>

    <div class="sub-title">• Sedasi Dalam</div>
    <p class="content-text">Teknik pembiusan dengan penyuntikkan obat yang dapat menyebabkan pasien mengantuk, tidur, serta tidak mudah dibangunkan tetapi masih memberikan respon terhadap rangsangan berulang atau rangsangan nyeri. Respon pernafasan sudah mulai terganggu dan pasien tidak dapat mempertahankan patensi dari jalan nafasnya.</p>

    <div class="sub-title">KELEBIHAN TEKNIK SEDASI :</div>
    <div class="bullet-item">• Obat diberikan secara bertahap.</div>
    <div class="bullet-item">• Selama tindakan pasien dalam keadaan mengantuk dan tidur.</div>
    <div class="bullet-item">• Obat yang diberikan dapat memiliki efek amnesia.</div>

    </div>{{-- end border page 2 --}}

    <!-- Page 3 -->
    <div class="page-break"></div>
    <div class="no-surat">RM 8.2/ITADS/{{ config('app.tahun_akreditasi', '22') }}</div>
    @include('print-rekam-medis.partials.header')

    <div style="border: 1px solid #000; padding: 8px 12px; margin-top: 6px;">

    <div class="sub-title" style="margin-top:8px;">KELEMAHAN TEKNIK SEDASI :</div>
    <div class="bullet-item">• Pasca sedasi pasien harus sadar penuh sebelum bisa diberi minum.</div>
    <div class="bullet-item">• Sampai 24 jam pasca sedasi pasien tidak diperbolehkan mengendarai mobil, mengoperasikan mesin dan menandatangani dokumen penting yang bersifat legal.</div>

    <div class="sub-title">KOMPLIKASI SEDASI :</div>
    <div class="bullet-item">• Oleh karena tindakan sedasi merupakan rangkaian proses dinamik dan dapat berubah, maka sedasi ringan ataupun moderat bisa bergeser menjadi sedasi dalam.</div>
    <div class="bullet-item">• Efek samping pasca sedasi dapat berupa: mual muntah, menggigil, pusing, mengantuk, yang bisa diatasi dengan obat-obatan.</div>
    <div class="bullet-item">• Alergi/hipersensitif terhadap obat (sangat jarang), mulai derajat ringan hingga berat/fatal.</div>
    <div class="bullet-item">• Beresiko pada pasien yang tidak puasa, bisa terjadi aspirasi yaitu masuknya isi lambung ke jalan nafas/paru.</div>
    <div class="bullet-item">• Pada sedasi dalam terdapat kemungkinan pemasangan alat atau pipa pernafasan.</div>

    <!-- ANESTESIA TOPIKAL -->
    <div class="section-title" style="margin-top:8px;"><input type="checkbox" {{ $data->baca_topikal ? 'checked' : '' }}>ANESTESIA TOPIKAL</div>
    <p class="content-text">Anestesia topikal adalah teknik pembiusan yang hanya melibatkan bagian tubuh tertentu saja (misalnya mata, gusi, dll). Teknik pembiusan dilakukan dengan memberikan obat bius tetes, spray/jelly pada bagian tubuh yang akan dibius. Efek bius berlangsung kira-kira 15-30 menit tergantung jenis obat yang dipakai.</p>

    <div class="sub-title">KOMPLIKASI :</div>
    <p class="content-text">Hampir tidak pernah ditemukan.</p>

    <!-- SIGNATURE SECTION -->
    <div class="sign-section" style="margin-top:14px;">
        @php
            $hubunganOptions = ['diri saya sendiri', 'istri', 'suami', 'anak', 'ayah', 'ibu'];
            $hubunganDipilih = $data->hubungan ?? '';
        @endphp
        <p class="sign-intro">
            Saya yang bertanda tangan di bawah ini telah membaca atau dibacakan keterangan diatas dan telah dijelaskan terkait dengan prosedur anestesia dan sedasi yang akan dilakukan terhadap:
            @foreach($hubunganOptions as $opt)
                @if(strtolower($hubunganDipilih) === strtolower($opt))
                    <u><strong>{{ $opt }}</strong></u>@if(!$loop->last)/ @endif
                @else
                    <span style="text-decoration: line-through; color:#999;">{{ $opt }}</span>@if(!$loop->last)/ @endif
                @endif
            @endforeach
            *)
        </p>

        <table class="sign-table">
            <tr>
                <td class="sign-label">Nama</td>
                <td class="sign-colon">:</td>
                <td>{{ $data->nama_pasien_atau_wali ?? '' }}</td>
            </tr>
            <tr>
                <td class="sign-label">Umur / Jenis Kelamin</td>
                <td class="sign-colon">:</td>
                <td>{{ $data->umur_jenis_kelamin ?? '' }}</td>
            </tr>
            <tr>
                <td class="sign-label">No. Telp</td>
                <td class="sign-colon">:</td>
                <td>{{ $data->no_telp ?? '' }}</td>
            </tr>
            <tr>
                <td class="sign-label">No. Rekam Medis</td>
                <td class="sign-colon">:</td>
                <td>{{ $data->no_rm ?? '' }}</td>
            </tr>
            <tr>
                <td class="sign-label">Diagnosa</td>
                <td class="sign-colon">:</td>
                <td>{{ $data->diagnosa ?? '' }}</td>
            </tr>
            <tr>
                <td class="sign-label">Rencana Tindakan</td>
                <td class="sign-colon">:</td>
                <td>{{ $data->rencana_tindakan ?? '' }}</td>
            </tr>
            <tr>
                <td class="sign-label">Jenis Anestesia</td>
                <td class="sign-colon">:</td>
                <td>{{ $data->jenis_anestesia ?? '' }}</td>
            </tr>
        </table>

        <p style="font-size:9pt; margin:4px 0 2px 0;">*) Coret yang tidak perlu</p>

        <table style="width:100%; margin-top:6px;">
            <tr>
                <td style="font-size:9.5pt;">
                    Medan,
                    {{ $data->tanggal_surat ? \Carbon\Carbon::parse($data->tanggal_surat)->locale('id')->isoFormat('D MMMM YYYY') : '___________________' }}
                    &nbsp;&nbsp; Jam {{ $data->jam_surat ?? '______' }} WIB
                </td>
            </tr>
        </table>

        <table class="ttd-row" style="margin-top:10px;">
            <tr>
                <td class="ttd-cell">
                    <div>Dokter yang menjelaskan</div>
                    @if($data->ttd_dokter)
                        <img src="{{ $data->ttd_dokter }}" class="ttd-img" alt="TTD Dokter">
                    @else
                        <div style="height:50px;"></div>
                    @endif
                    <div><span class="ttd-nama">( {{ $data->nama_dokter ?? '' }} )</span></div>
                </td>
                <td class="ttd-cell">
                    <div>Pihak yang dijelaskan</div>
                    @if($data->ttd_pihak)
                        <img src="{{ $data->ttd_pihak }}" class="ttd-img" alt="TTD Pihak">
                    @else
                        <div style="height:50px;"></div>
                    @endif
                    <div><span class="ttd-nama">( {{ $data->nama_pihak ?? '' }} )</span></div>
                </td>
            </tr>
        </table>
    </div>

    </div>{{-- end border page 3 --}}
</div>
</body>
</html>
