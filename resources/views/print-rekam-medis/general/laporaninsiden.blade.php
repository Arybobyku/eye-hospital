<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>LAPORAN INSIDEN</title>
    <style>
        @page { margin: 18px; }
        body { margin: 18px; font-family: Arial, sans-serif; font-size: 9pt; }
        .wrap { width: 100%; height: auto; display: inline-block; }
        table { border-collapse: collapse; }
        input[type=checkbox] { margin: 0 2px; }
    </style>
</head>
<body>
<?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
<div class="wrap">

    {{-- ── Nomor Surat ── --}}
    <div style="width:100%; text-align:right; margin-bottom:4px; font-size:9pt;">
        {{ $data->no_surat ?? 'RM 7.9/LI/' . config('app.tahun_akreditasi', '22') }}
    </div>

    {{-- ── HEADER: Logo | Judul | Identitas Pasien ── --}}
    <table style="width:100%; border:1px solid black; margin-bottom:4px;">
        <tr>
            <td style="width:30%; border-right:1px solid black; padding:6px 8px; vertical-align:middle;">
                <img src="data:image/png;base64,<?php echo base64_encode(file_get_contents($fullpath)); ?>"
                     style="width:100%; max-height:70px;" />
            </td>
            <td style="width:38%; border-right:1px solid black; padding:6px 8px; text-align:center; vertical-align:middle; font-size:10pt; font-weight:bold;">
                Formulir Laporan Insiden ke Tim KP di RS
            </td>
            <td style="width:32%; padding:6px 10px; font-size:9pt; vertical-align:top; line-height:20px;">
                Nama &nbsp;&nbsp;&nbsp;&nbsp;: {{ $data->nama ?: '…………………………………' }} <strong>L / P*</strong><br>
                Ruangan : {{ $data->ruangan ?: '…………………………………' }}<br>
                No. RM &nbsp;: {{ $data->no_rm ?: '…………………………………' }}
            </td>
        </tr>
    </table>

    {{-- ── RAHASIA ── --}}
    <div style="border:1px solid black; padding:3px 10px; text-align:center; font-size:8pt; margin-bottom:4px;">
        RAHASIA, TIDAK BOLEH DIFOTOCOPY, DILAPORKAN MAXIMAL 2 x 24
    </div>

    <div style="text-align:center; font-weight:bold; font-size:11pt;">LAPORAN INSIDEN</div>
    <div style="text-align:center; font-size:9pt; margin-bottom:6px;">(INTERNAL)</div>

    {{-- ── MAIN CONTENT: 2 COLUMN ── --}}
    <table style="width:100%; border:1px solid black; font-size:9pt;">
    <tr>

    {{-- LEFT COLUMN --}}
    <td style="width:50%; border-right:1px solid black; padding:8px 10px; vertical-align:top; line-height:20px;">

        <strong>I. DATA PASIEN</strong><br><br>

        Umur * :
        <input type="checkbox" {{ $data->umur_0_1_bulan ? 'checked' : '' }}> 0 – 1 bulan &nbsp;
        <input type="checkbox" {{ $data->umur_1_bulan_1_tahun ? 'checked' : '' }}> > 1 bulan – 1 tahun<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="checkbox" {{ $data->umur_1_5_tahun ? 'checked' : '' }}> > 1 tahun – 5 tahun &nbsp;
        <input type="checkbox" {{ $data->umur_5_15_tahun ? 'checked' : '' }}> > 5 tahun – 15 tahun<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="checkbox" {{ $data->umur_15_30_tahun ? 'checked' : '' }}> > 15 tahun – 30 tahun &nbsp;
        <input type="checkbox" {{ $data->umur_30_65_tahun ? 'checked' : '' }}> > 30 tahun – 65 tahun<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="checkbox" {{ $data->umur_65_plus ? 'checked' : '' }}> > 65 tahun<br><br>

        Jenis kelamin :
        <input type="checkbox" {{ ($data->jenis_kelamin === 'L') ? 'checked' : '' }}> Laki-laki &nbsp;&nbsp;&nbsp;
        <input type="checkbox" {{ ($data->jenis_kelamin === 'P') ? 'checked' : '' }}> Perempuan<br><br>

        Penanggung biaya pasien :<br>
        &nbsp;&nbsp;
        <input type="checkbox" {{ $data->biaya_pribadi ? 'checked' : '' }}> Pribadi &nbsp;&nbsp;&nbsp;
        <input type="checkbox" {{ $data->biaya_asuransi_swasta ? 'checked' : '' }}> Asuransi Swasta<br>
        &nbsp;&nbsp;
        <input type="checkbox" {{ $data->biaya_perusahaan ? 'checked' : '' }}> Perusahaan &nbsp;
        <input type="checkbox" {{ $data->biaya_bpjs ? 'checked' : '' }}> BPJS*<br><br>

        Tanggal Masuk RS :
        @if($data->tanggal_masuk_rs)
            {{ \Carbon\Carbon::parse($data->tanggal_masuk_rs)->format('d/m/Y') }}
        @else
            ……………………………
        @endif
        &nbsp; Jam {{ $data->jam_masuk_rs ?: '…………' }}<br><br>

        <strong>II. RINCIAN KEJADIAN</strong><br><br>

        <strong>1. Tanggal dan Waktu Insiden</strong><br>
        &nbsp;&nbsp; Tanggal :
        @if($data->insiden_tanggal)
            {{ \Carbon\Carbon::parse($data->insiden_tanggal)->format('d/m/Y') }}
        @else
            ………………………………
        @endif
        &nbsp; Jam {{ $data->insiden_jam ?: '………………' }}<br><br>

        <strong>2. Insiden</strong> : {{ $data->insiden_deskripsi ?: '………………………………………………………………………' }}<br><br>

        <strong>3. Kronologis Insiden</strong><br>
        @if($data->kronologis_insiden)
            {!! nl2br(e($data->kronologis_insiden)) !!}
        @else
            ………………………………………………………………………………………………………………<br>
            ………………………………………………………………………………………………………………<br>
            ………………………………………………………………………………………………………………
        @endif
        <br><br>

        <strong>4. Jenis Insiden* :</strong><br>
        &nbsp;&nbsp; <input type="checkbox" {{ $data->jenis_knc ? 'checked' : '' }}> Kejadian Nyaris Cedera / KNC <em>(Near miss)</em><br>
        &nbsp;&nbsp; <input type="checkbox" {{ $data->jenis_ktc ? 'checked' : '' }}> Kejadian Tidak Cedera / KTC <em>(No Harm)</em><br>
        &nbsp;&nbsp; <input type="checkbox" {{ $data->jenis_ktd ? 'checked' : '' }}> Kejadian Tidak Diharapkan / KTD <em>(Adverse Event)</em> / Kejadian Sentinel <em>(Sentinel Event)</em>

    </td>

    {{-- RIGHT COLUMN --}}
    <td style="width:50%; padding:8px 10px; vertical-align:top; line-height:20px;">

        &nbsp;<br><br>{{-- spacer --}}

        <strong>5. Orang Pertama Yang Melaporkan Insiden*</strong><br>
        &nbsp;&nbsp; <input type="checkbox" {{ $data->pelapor_karyawan ? 'checked' : '' }}> Karyawan : Dokter / Perawat / Petugas lainnya<br>
        &nbsp;&nbsp; <input type="checkbox" {{ $data->pelapor_pasien ? 'checked' : '' }}> Pasien<br>
        &nbsp;&nbsp; <input type="checkbox" {{ $data->pelapor_keluarga ? 'checked' : '' }}> Keluarga / Pendamping pasien<br>
        &nbsp;&nbsp; <input type="checkbox" {{ $data->pelapor_pengunjung ? 'checked' : '' }}> Pengunjung<br>
        &nbsp;&nbsp; <input type="checkbox" {{ $data->pelapor_lainnya ? 'checked' : '' }}> Lain-lain
        {{ $data->pelapor_lainnya_sebutkan ? '…' . $data->pelapor_lainnya_sebutkan . '…' : '………………………………………………………' }}
        <strong>(sebutkan)</strong><br><br>

        <strong>6. Insiden terjadi pada* :</strong><br>
        &nbsp;&nbsp; <input type="checkbox" {{ $data->terjadi_pada_pasien ? 'checked' : '' }}> Pasien<br>
        &nbsp;&nbsp; <input type="checkbox" {{ $data->terjadi_pada_lainnya ? 'checked' : '' }}> Lain-lain
        {{ $data->terjadi_pada_lainnya_sebutkan ?: '……………………………………………………………' }}
        <strong>(sebutkan)</strong><br>
        <small>Mis : karyawan / Pengunjung / Pendamping / Keluarga pasien, lapor ke K3 RS.</small><br><br>

        <strong>7. Insiden menyangkut pasien :</strong><br>
        &nbsp;&nbsp; <input type="checkbox" {{ $data->pasien_rawat_inap ? 'checked' : '' }}> Pasien rawat inap<br>
        &nbsp;&nbsp; <input type="checkbox" {{ $data->pasien_rawat_jalan ? 'checked' : '' }}> Pasien rawat jalan<br>
        &nbsp;&nbsp; <input type="checkbox" {{ $data->pasien_igd ? 'checked' : '' }}> Pasien IGD<br>
        &nbsp;&nbsp; <input type="checkbox" {{ $data->pasien_lainnya ? 'checked' : '' }}> Lain-lain
        {{ $data->pasien_lainnya_sebutkan ?: '………………………………………………………' }}
        <strong>(sebutkan)</strong><br><br>

        <strong>8. Tempat Insiden</strong><br>
        &nbsp;&nbsp; Lokasi kejadian {{ $data->lokasi_kejadian ?: '……………………………………………………' }}
        <strong>(sebutkan)</strong>

    </td>
    </tr>
    </table>

    <br>

    {{-- ── PAGE 2 CONTENT ── --}}
    <table style="width:100%; border:1px solid black; font-size:9pt;">
    <tr>

    {{-- LEFT COLUMN P2 --}}
    <td style="width:50%; border-right:1px solid black; padding:8px 10px; vertical-align:top; line-height:20px;">

        (Tempat pasien berada)<br><br>

        <strong>9. Insiden terjadi pada pasien : (sesuai kasus penyakit/ spesialisasi)</strong><br>
        &nbsp;&nbsp; <input type="checkbox" {{ $data->spesialisasi_penyakit_mata ? 'checked' : '' }}> Penyakit Mata<br>
        &nbsp;&nbsp; <input type="checkbox" {{ $data->spesialisasi_lainnya ? 'checked' : '' }}> Lain-lain
        {{ $data->spesialisasi_lainnya_sebutkan ?: '…………………………………………………………' }}
        <strong>(sebutkan)</strong><br><br>

        <strong>10. Unit / Departemen terkait yang menyebabkan insiden</strong><br>
        &nbsp;&nbsp; Unit kerja penyebab {{ $data->unit_kerja_penyebab ?: '………………………………………………' }}
        <strong>(sebutkan)</strong><br><br>

        <strong>11. Akibat Insiden Terhadap Pasien* :</strong><br>
        &nbsp;&nbsp; <input type="checkbox" {{ $data->akibat_kematian ? 'checked' : '' }}> Kematian<br>
        &nbsp;&nbsp; <input type="checkbox" {{ $data->akibat_cedera_berat ? 'checked' : '' }}> Cedera Irreversibel / Cedera Berat<br>
        &nbsp;&nbsp; <input type="checkbox" {{ $data->akibat_cedera_sedang ? 'checked' : '' }}> Cedera Reversibel / Cedera Sedang<br>
        &nbsp;&nbsp; <input type="checkbox" {{ $data->akibat_cedera_ringan ? 'checked' : '' }}> Cedera Ringan<br>
        &nbsp;&nbsp; <input type="checkbox" {{ $data->akibat_tidak_cedera ? 'checked' : '' }}> Tidak ada cedera<br><br>

        <strong>12. Tindakan yang dilakukan segera setelah kejadian, dan hasilnya :</strong><br>
        @if($data->tindakan_hasil)
            {!! nl2br(e($data->tindakan_hasil)) !!}
        @else
            ……………………………………………………………………………………………………………………<br>
            ……………………………………………………………………………………………………………………<br>
            ………………………………………………………………………………………………………………….
        @endif
        <br><br>

        <strong>13. Tindakan dilakukan oleh* :</strong><br>
        &nbsp;&nbsp; <input type="checkbox" {{ $data->tindakan_tim ? 'checked' : '' }}> Tim : terdiri dari :<br>
        &nbsp;&nbsp;&nbsp;&nbsp; {{ $data->tindakan_tim_terdiri ?: '……………………………………………………………………' }}<br>
        &nbsp;&nbsp; <input type="checkbox" {{ $data->tindakan_dokter ? 'checked' : '' }}> Dokter<br>
        &nbsp;&nbsp; <input type="checkbox" {{ $data->tindakan_perawat ? 'checked' : '' }}> Perawat<br>
        &nbsp;&nbsp; <input type="checkbox" {{ $data->tindakan_petugas_lainnya ? 'checked' : '' }}> Petugas lainnya
        {{ $data->tindakan_petugas_lainnya_sebutkan ?: '……………………………………………' }}<br><br>

        <strong>14. Apakah kejadian yang sama pernah terjadi di Unit Kerja lain?*</strong><br>
        &nbsp;&nbsp; <input type="checkbox" {{ $data->kejadian_sama_ya ? 'checked' : '' }}> Ya &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="checkbox" {{ $data->kejadian_sama_tidak ? 'checked' : '' }}> Tidak<br>
        Apabila ya, isi bagian dibawah ini.<br>
        <strong>Kapan ? dan Langkah / tindakan apa yang telah diambil pada Unit kerja tersebut untuk mencegah terulangnya kejadian yang sama?</strong><br>
        @if($data->kejadian_sama_keterangan)
            {!! nl2br(e($data->kejadian_sama_keterangan)) !!}
        @else
            ……………………………………………………………………………………………………………………
        @endif

    </td>

    {{-- RIGHT COLUMN P2 --}}
    <td style="width:50%; padding:8px 10px; vertical-align:top;">

        {{-- Pembuat / Penerima Laporan --}}
        <table style="width:100%; border:1px solid black; font-size:9pt; border-collapse:collapse; margin-bottom:10px;">
            <tr>
                <td style="border:1px solid black; padding:4px 8px; width:30%;">Pembuat Laporan</td>
                <td style="border:1px solid black; padding:4px 8px; width:20%;">: {{ $data->pembuat_laporan ?: '…………' }}</td>
                <td style="border:1px solid black; padding:4px 8px; width:30%;">Penerima Laporan</td>
                <td style="border:1px solid black; padding:4px 8px; width:20%;">: {{ $data->penerima_laporan ?: '…………' }}</td>
            </tr>
            <tr>
                <td style="border:1px solid black; padding:4px 8px;">Paraf</td>
                <td style="border:1px solid black; padding:4px 8px; text-align:center;">
                    @if($data->pembuat_laporan_paraf)
                        <img src="{{ $data->pembuat_laporan_paraf }}" alt="Paraf Pembuat"
                             style="max-width:90px; max-height:45px; object-fit:contain;">
                    @else
                        : …………
                    @endif
                </td>
                <td style="border:1px solid black; padding:4px 8px;">Paraf</td>
                <td style="border:1px solid black; padding:4px 8px; text-align:center;">
                    @if($data->penerima_laporan_paraf)
                        <img src="{{ $data->penerima_laporan_paraf }}" alt="Paraf Penerima"
                             style="max-width:90px; max-height:45px; object-fit:contain;">
                    @else
                        : …………
                    @endif
                </td>
            </tr>
            <tr>
                <td style="border:1px solid black; padding:4px 8px;">Tgl Terima</td>
                <td style="border:1px solid black; padding:4px 8px;">:
                    @if($data->tgl_terima)
                        {{ \Carbon\Carbon::parse($data->tgl_terima)->format('d/m/Y') }}
                    @else
                        …………
                    @endif
                </td>
                <td style="border:1px solid black; padding:4px 8px;">Tgl Lapor</td>
                <td style="border:1px solid black; padding:4px 8px;">:
                    @if($data->tgl_lapor)
                        {{ \Carbon\Carbon::parse($data->tgl_lapor)->format('d/m/Y') }}
                    @else
                        …………
                    @endif
                </td>
            </tr>
        </table>

        <div style="font-size:9pt; line-height:22px;">
            <strong>Grading Risiko Kejadian*</strong> (Diisi oleh atasan pelapor) :<br>
            <input type="checkbox" {{ $data->grading_biru ? 'checked' : '' }}> <strong>BIRU</strong> &nbsp;&nbsp;
            <input type="checkbox" {{ $data->grading_hijau ? 'checked' : '' }}> <strong>HIJAU</strong> &nbsp;&nbsp;
            <input type="checkbox" {{ $data->grading_kuning ? 'checked' : '' }}> <strong>KUNING</strong> &nbsp;&nbsp;
            <input type="checkbox" {{ $data->grading_merah ? 'checked' : '' }}> <strong>MERAH</strong><br>
            NB. * = pilih satu jawaban.
        </div>

    </td>
    </tr>
    </table>

</div>
</body>
</html>
