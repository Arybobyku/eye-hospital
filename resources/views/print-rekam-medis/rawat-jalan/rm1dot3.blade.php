<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM1.3</title>
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

        .fontsmall {
            font-size: 10;
        }
    </style>

</head>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;">
    </div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <?php $patimg = storage_path('app/public/images/PAT.png'); ?>
    @foreach ($ro as $dataRo)
        <div class="wrap">
            <div style="width:100%; text-align:right; margin-bottom:5px">
                RM 1.3/PKMRJ/22
            </div>
            @include('print-rekam-medis.partials.header')
            <table style="width: 100%; text-align: left;" cellpadding="0" cellspacing="0">
                {{-- PENGKAJIAN KEPERAWATAN MATA RAWAT JALAN --}}
                <tr style="border: 1px solid black;">
                    <div style="width: 100%; text-align: center; margin-top: 0px; margin-top:5px; font-weight: bold">
                        PENGKAJIAN KEPERAWATAN MATA RAWAT JALAN
                    </div>
                    <div
                        style="width: 100%; text-align: center; margin-top: 0px; line-height: 21px; margin-bottom: 3px; ">
                        <i>(dilengkapi dalam waktu 2 jam pertama pasien masuk ruang rawat jalan)</i>
                    </div>
                </tr>
                {{-- Tanggal --}}
                <tr style="border: 1px solid black; width:100%">
                    <table style="border-collapse: collapse; width:100%">
                        <tr>
                            <td style="border-right: 1px solid black; width:100%">
                                Tanggal: <b>{{ $dataRo->tanggal }}</b>
                            </td>
                            <td style="border-right: 1px solid black; width:100%">
                                Waktu: <b>{{ $dataRo->waktu }}</b>
                            </td>
                            <td style="width:100%">
                                Perawat Pengkaji: <b>{{ $dataRo->nama_pemeriksa }}</b>
                            </td>
                        </tr>
                    </table>
                </tr>
                {{-- Status Fungsional --}}
                <tr style="border: 1px solid black; width:100%">
                    <table style="border-collapse: collapse; width:100%">
                        <tr>
                            <td style="">
                                Status Fungsional:
                            </td>
                            <td>
                                <table>
                                    <tr>
                                        <td><input type="checkbox"
                                                {{ $dataRo->status_fungsional == 'Jalan tanpa bantuan' ? 'Checked' : '' }}>
                                        </td>
                                        <td>Jalan tanpa bantuan</td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table>
                                    <tr>
                                        <td><input type="checkbox"
                                                {{ $dataRo->status_fungsional == 'Kursi Roda' ? 'Checked' : '' }}></td>
                                        <td>Kursi Roda</td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table>
                                    <tr>
                                        <td><input type="checkbox"
                                                {{ $dataRo->status_fungsional == 'Tempat tidur dorong' ? 'Checked' : '' }}>
                                        </td>
                                        <td>Tempat Tidur Dorong</td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table>
                                    <tr>
                                        <td><input type="checkbox"
                                                {{ $dataRo->status_fungsional == 'Jalan dengan bantuan' ? 'Checked' : '' }}>
                                        </td>
                                        <td>Jalan dengan bantuan</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </tr>
                {{-- Keluhan Utama --}}
                <tr style="border: 1px solid black; width:100%">
                    <table style="border-collapse: collapse; width:100%">
                        <tr>
                            <td style="border-right: 1px solid black; width:100%">
                                <div style="width: 100%;height:50px">Keluhan Utama : <br>
                                    <b>{{ $dataRo->keluhan_utama }}</b>
                                </div>
                                <div style="border-top: 1px solid black; width:100%; height:1px;"></div>
                                <div style="width: 100%;height:100px">Riwayat Penyakit : <br>
                                    <b>{{ $dataRo->riwayat_penyakit }} </b>
                                </div>
                            </td>
                            <td style="width:100%;">
                                <b>KASUS URGENT:</b>
                                <table>
                                    <tr>
                                        <td><input type="checkbox"
                                                {{ $dataRo->kasus_urgent == 'Mata Merah' ? 'Checked' : '' }}></td>
                                        <td>MATA MERAH</td>
                                    </tr>
                                </table>
                                <table>
                                    <tr>
                                        <td><input type="checkbox"
                                                {{ $dataRo->kasus_urgent == 'Trauma/Kesakitan' ? 'Checked' : '' }}>
                                        </td>
                                        <td>TRAUMA/KESAKITAN/</td>
                                    </tr>
                                </table>
                                <table>
                                    <tr>
                                        <td><input type="checkbox"
                                                {{ $dataRo->kasus_urgent == 'Mata Kabur Mendadak' ? 'Checked' : '' }}>
                                        </td>
                                        <td>MATA KABUR MENDADAK</td>
                                    </tr>
                                </table>
                                <table>
                                    <tr>
                                        <td><input type="checkbox"
                                                {{ $dataRo->kasus_urgent == 'Balita/Manula' ? 'Checked' : '' }}></td>
                                        <td>BALITA / MANULA</td>
                                    </tr>
                                </table>
                                <table>
                                    <tr>
                                        <td><input type="checkbox"
                                                {{ $dataRo->kasus_urgent == 'Lainnya' ? 'Checked' : '' }}></td>
                                        <td>LAINYA</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </tr>
                {{-- PEMERIKSAAN FISIK --}}
                <tr>
                    <table
                        style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black; width:100%; padding:5px">
                        <tr>
                            <b>PEMERIKSAAN FISIK</b>
                        </tr>
                        <tr>
                            <td>TD</td>
                            <td><b>{{ $dataRo->tekanan_darah }} mmHg</b></td>
                            <td>Nadi</td>
                            <td><b>{{ $dataRo->nadi }} /menit</b></td>
                            <td>RR</td>
                            <td><b>{{ $dataRo->respiratory_rate }} /menit</b></td>
                        </tr>
                        <tr>
                            <td>BB</td>
                            <td><b>{{ $dataRo->berat_badan }} kg</b></td>
                            <td>TB</td>
                            <td><b>{{ $dataRo->tinggi_badan }} cm</b></td>
                            <td>Suhu</td>
                            <td><b>{{ $dataRo->suhu }} C</b></td>
                        </tr>
                    </table>
                </tr>
                <tr>
                    <table
                        style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black; width:100%; padding:5px">
                        <tr>
                            <b>RIWAYAT KESEHATAN</b>
                        </tr>

                        <tr>
                            <td>1. Penyakit yang pernah diderita :</td>
                            <td><input type="checkbox"
                                    {{ $dataRo->penyakit_pernah_diderita == 'Diabetes' ? 'Checked' : '' }}></td>
                            <td>Diabetes</td>
                            <td><input type="checkbox"
                                    {{ $dataRo->penyakit_pernah_diderita == 'Hipertensi' ? 'Checked' : '' }}></td>
                            <td>Hipertensi</td>
                            <td><input type="checkbox"
                                    {{ $dataRo->penyakit_pernah_diderita == 'Jantung' ? 'Checked' : '' }}></td>
                            <td>Jantung</td>
                            <td><input type="checkbox"
                                    {{ $dataRo->penyakit_pernah_diderita == 'Hepatitis' ? 'Checked' : '' }}></td>
                            <td>Hepatitis</td>
                            <td><input type="checkbox"
                                    {{ $dataRo->penyakit_pernah_diderita == 'Asma' ? 'Checked' : '' }}></td>
                            <td>Asma</td>
                        </tr>
                        <tr>
                            <table>
                                <tr>
                                    <td>Lainnya :</td>
                                    <td>{{ $dataRo->penyakit_pernah_diderita_lainnya }}</td>
                                </tr>
                            </table>
                        </tr>
                        <tr>
                            <td>2. Pernah Dioperasi :</td>
                            <td><input type="checkbox" {{ $dataRo->pernah_dioperasi == 'Tidak' ? 'Checked' : '' }}>
                            </td>
                            <td>Tidak</td>
                            <td><input type="checkbox" {{ $dataRo->pernah_dioperasi == 'Ya' ? 'Checked' : '' }}></td>
                            <td>Ya</td>
                        </tr>
                        <tr>
                            <table>
                                <tr>
                                    <td>Jenis Operasi :</td>
                                    <td>{{ $dataRo->pernah_dioperasi_lainnya }}</td>
                                </tr>
                            </table>
                        </tr>
                        <tr>
                            <td>3. Riwayat Alergi :</td>
                            <td><input type="checkbox"
                                    {{ $dataRo->riwayat_alergi_makanan == 'Tidak' ? 'Checked' : '' }} ||
                                    {{ $dataRo->riwayat_alergi_obatan == 'Tidak' ? 'Checked' : '' }}></td>
                            <td>Tidak</td>
                            <td><input type="checkbox" {{ $dataRo->riwayat_alergi_makanan == 'Ya' ? 'Checked' : '' }}
                                    || {{ $dataRo->riwayat_alergi_obatan == 'Ya' ? 'Checked' : '' }}></td>
                            <td>Ya</td>
                        </tr>
                        <tr>
                            <td>Alergi Terhadap :</td>
                            <td><input type="checkbox" {{ $dataRo->riwayat_alergi_makanan == 'Ya' ? 'Checked' : '' }}>
                            </td>
                            <td colspan="2">Makanan : <b>{{ $dataRo->riwayat_alergi_makanan_lainnya }}</b></td>
                            <td colspan="2" style="text-align: right"><input type="checkbox"
                                    {{ $dataRo->riwayat_alergi_obatan == 'Ya' ? 'Checked' : '' }}></td>
                            <td colspan="1" style="text-align: left">Obat :
                                <b>{{ $dataRo->riwayat_alergi_obatan_lainnya }}</b>
                            </td>
                        </tr>
                        <tr style="font-size: 10">
                            <td>4. Obat yang digunakan saat ini :</td>
                            <td><input type="checkbox"
                                    {{ $dataRo->obat_digunakan_saat_ini == 'Obat Pencacar Darah' ? 'Checked' : '' }}>
                            </td>
                            <td>Obat Pencair Darah</td>
                            <td><input type="checkbox"
                                    {{ $dataRo->obat_digunakan_saat_ini == 'Obat Prostat' ? 'Checked' : '' }}></td>
                            <td>Obat Prostat</td>
                            <td><input type="checkbox"
                                    {{ $dataRo->obat_digunakan_saat_ini == 'Obat Asma' ? 'Checked' : '' }}></td>
                            <td>Obat Asma</td>
                            <td><input type="checkbox"
                                    {{ $dataRo->obat_digunakan_saat_ini == 'Obat Alergi/Stroid' ? 'Checked' : '' }}>
                            </td>
                            <td>Obat Alergi</td>

                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: right"><input type="checkbox"
                                    {{ $dataRo->obat_digunakan_saat_ini == 'Lainnya' ? 'Checked' : '' }}></td>
                            <td colspan="5" style="text-align: left">Lainnya :
                                <b>{{ $dataRo->obat_digunakan_saat_ini_lainnya }}</b>
                            </td>
                        </tr>
                    </table>
                </tr>
                <tr>
                    <table
                        style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black; width:100%; padding:5px">
                        <tr>
                            <b>PENILAIAN RESIKO JATUH</b>
                        </tr>
                        <tr>
                            <td>Resiko Jatuh</td>
                            <td><input type="checkbox" {{ $dataRo->penilaian_resiko_jatuh == 'Ya' ? 'Checked' : '' }}>
                            </td>
                            <td>YA</td>
                            <td><input type="checkbox"
                                    {{ $dataRo->penilaian_resiko_jatuh == 'Tidak' ? 'Checked' : '' }}></td>
                            <td>TIDAK</td>
                        </tr>
                    </table>
                </tr>
                <tr>
                    <table
                        style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black; width:100%; padding:5px">
                        <tr>
                            <td>
                                <table>
                                    <tr><b>SKRINING NYERI</b></tr>
                                    <tr>
                                        <td>
                                            <img style="width: 100%;"
                                                src="data:image/png;base64,
                            <?php echo base64_encode(file_get_contents($patimg)); ?>" />
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table>
                                    <tr>
                                        <td>Nyeri :</td>

                                        <td>
                                            <table>
                                                <tr>
                                                    <td><input type="checkbox"
                                                            {{ $dataRo->nyeri == 'Tidak ada nyeri' ? 'Checked' : '' }}>
                                                    </td>
                                                    <td>Tidak Ada Nyeri</td>
                                                </tr>
                                            </table>
                                        </td>

                                        <td>
                                            <table>
                                                <tr>
                                                    <td><input type="checkbox"
                                                            {{ $dataRo->nyeri == 'Nyeri akut' ? 'Checked' : '' }}>
                                                    </td>
                                                    <td>Nyeri Akut</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td><input type="checkbox"
                                                            {{ $dataRo->nyeri == 'Nyeri kronis' ? 'Checked' : '' }}>
                                                    </td>
                                                    <td>Nyeri Kronis </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>

                                        <td colspan="2">Skala Nyeri : <b>{{ $dataRo->skala_nyeri }}</b>
                                        </td>
                                        <td colspan="2">Lokasi : <b>{{ $dataRo->lokasi_nyeri }}</b></td>
                                    </tr>
                                    <tr>

                                        <td colspan="2">Karakteristik :
                                            <b>{{ $dataRo->karakteristik_nyeri }}</b></td>
                                        <td colspan="2">Durasi : <b>{{ $dataRo->durasi_nyeri }}</b></td>

                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <table>
                                                <tr>
                                                    <td>Nyeri hilang bila :</td>
                                                    <td>
                                                        <table>
                                                            <tr>
                                                                <td><input type="checkbox"
                                                                        {{ $dataRo->nyeri_hilang_bila == 'Minum obat' ? 'Checked' : '' }}>
                                                                </td>
                                                                <td>Minum Obat</td>
                                                            </tr>
                                                        </table>
                                                    </td>

                                                    <td>
                                                        <table>
                                                            <tr>
                                                                <td><input type="checkbox"
                                                                        {{ $dataRo->nyeri_hilang_bila == 'Istirahat' ? 'Checked' : '' }}>
                                                                </td>
                                                                <td>Istirahat</td>
                                                            </tr>
                                                        </table>
                                                    </td>

                                                    <td>
                                                        <table>
                                                            <tr>
                                                                <td><input type="checkbox"
                                                                        {{ $dataRo->nyeri_hilang_bila == 'Berubah Posisi' ? 'Checked' : '' }}>
                                                                </td>
                                                                <td>Berubah Posisi</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <table>
                                                <tr>
                                                    <td colspan="2" style="text-align: right"><input type="checkbox"
                                                            {{ $dataRo->nyeri_hilang_bila == 'Lainnya' ? 'Checked' : '' }}>
                                                    </td>
                                                    <td colspan="2" style="text-align: left">Lainnya :
                                                        <b>{{ $dataRo->nyeri_hilang_bila_lainnya }}</b>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                    </table>
                </tr>
            </table>
        </div>
        @if ($loop->index < count($ro) - 1)
            <div class="page_break"></div>
        @endif
    @endforeach
</body>

</html>
