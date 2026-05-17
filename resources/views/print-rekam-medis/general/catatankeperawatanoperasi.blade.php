<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>CATATAN KEPERAWATAN INTRA DAN PASCA OPERASI</title>
    <style>
        @page { margin: 14px; }
        body { margin: 14px; font-family: Arial, sans-serif; font-size: 8pt; }
        .wrap { width: 100%; }
        table { border-collapse: collapse; width: 100%; }
        td, th { font-size: 8pt; }
        input[type=checkbox] { margin: 0 2px; }
        .underline { border-bottom: 1px solid #000; display: inline-block; min-width: 80px; }
        .underline-sm { border-bottom: 1px solid #000; display: inline-block; min-width: 40px; }
        .section-label { font-weight: bold; font-size: 8pt; }
        .row-item { margin-bottom: 3px; line-height: 17px; }
    </style>
</head>
<body>
<?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
<div class="wrap">

{{-- ── Nomor Surat ── --}}
<div style="width:100%; text-align:right; margin-bottom:4px; font-size:8pt;">
    {{ $data->no_surat ?? 'RM 4.6/CKIDPO/' . config('app.tahun_akreditasi', '22') }}
</div>

{{-- ── HEADER ── --}}
<table style="border:1px solid black; margin-bottom:4px;">
    <tr>
        <td style="width:22%; border-right:1px solid black; padding:4px 6px; vertical-align:middle;">
            <img src="data:image/png;base64,<?php echo base64_encode(file_get_contents($fullpath)); ?>"
                 style="width:100%; max-height:60px;" />
        </td>
        <td style="width:52%; border-right:1px solid black; padding:4px 8px; text-align:center; vertical-align:middle; font-size:10pt; font-weight:bold; line-height:18px;">
            CATATAN KEPERAWATAN INTRA DAN PASCA OPERASI
        </td>
        <td style="width:26%; padding:4px 8px; font-size:8pt; vertical-align:top; line-height:17px;">
            Nama &nbsp;&nbsp;&nbsp;: {{ $data->nama ?: '…………………………………' }}<br>
            No. RM &nbsp;: {{ $data->no_rm ?: '…………………………………' }}<br>
            L / P &nbsp;&nbsp;&nbsp;&nbsp;: {{ $data->jenis_kelamin ?: '…………' }}<br>
            Tgl Lahir : {{ $data->tanggal_lahir ? \Carbon\Carbon::parse($data->tanggal_lahir)->format('d/m/Y') : '…………………' }}
        </td>
    </tr>
</table>

{{-- ── WAKTU OPERASI ── --}}
<table style="border:1px solid black; margin-bottom:4px;">
    <tr>
        <td style="padding:3px 8px; border-right:1px solid black; width:33%;">
            <strong>Jam Mulai</strong> : {{ $data->jam_mulai ?: '............' }}
            &nbsp;&nbsp; <strong>Jam Selesai</strong> : {{ $data->jam_selesai ?: '............' }}
        </td>
        <td style="padding:3px 8px; border-right:1px solid black; width:34%;">
            <strong>Anestesi Mulai</strong> : {{ $data->jam_anestesi_mulai ?: '............' }}
            &nbsp;&nbsp; <strong>Selesai</strong> : {{ $data->jam_anestesi_selesai ?: '............' }}
        </td>
        <td style="padding:3px 8px; width:33%;">
            <strong>Pembedahan Mulai</strong> : {{ $data->jam_pembedahan_mulai ?: '............' }}
            &nbsp;&nbsp; <strong>Selesai</strong> : {{ $data->jam_pembedahan_selesai ?: '............' }}
        </td>
    </tr>
</table>

{{-- ── SECTION A ── --}}
<table style="border:1px solid black; margin-bottom:4px;">
    <tr>
        <td colspan="2" style="background:#ddd; padding:2px 8px; font-weight:bold; font-size:9pt; border-bottom:1px solid black;">
            A. CATATAN INTRA OPERASI
        </td>
    </tr>
    <tr>
    {{-- LEFT COLUMN --}}
    <td style="width:50%; border-right:1px solid black; padding:5px 8px; vertical-align:top; line-height:17px;">

        {{-- 1. Tipe Operasi --}}
        <div class="row-item">
            <span class="section-label">1. Tipe Operasi :</span><br>
            &nbsp;&nbsp;
            <input type="checkbox" {{ $data->tipe_elektif ? 'checked' : '' }}> Elektif &nbsp;
            <input type="checkbox" {{ $data->tipe_darurat ? 'checked' : '' }}> Darurat &nbsp;
            <input type="checkbox" {{ $data->tipe_rawat_jalan ? 'checked' : '' }}> Rawat Jalan
        </div>

        {{-- 2. Jenis Pembiusan --}}
        <div class="row-item">
            <span class="section-label">2. Jenis Pembiusan :</span><br>
            &nbsp;&nbsp;
            <input type="checkbox" {{ $data->biusan_umum ? 'checked' : '' }}> Umum &nbsp;
            <input type="checkbox" {{ $data->biusan_lokal ? 'checked' : '' }}> Lokal &nbsp;
            <input type="checkbox" {{ $data->biusan_regional ? 'checked' : '' }}> Regional
        </div>

        {{-- 3. Kesadaran --}}
        <div class="row-item">
            <span class="section-label">3. Kesadaran :</span><br>
            &nbsp;&nbsp;
            <input type="checkbox" {{ $data->kesadaran_terjaga ? 'checked' : '' }}> Terjaga &nbsp;
            <input type="checkbox" {{ $data->kesadaran_mudah_dibangunkan ? 'checked' : '' }}> Mudah Dibangunkan<br>
            &nbsp;&nbsp;
            <input type="checkbox"> Lainnya: <span class="underline">{{ $data->kesadaran_lainnya }}</span>
        </div>

        {{-- 4. Status Emosi --}}
        <div class="row-item">
            <span class="section-label">4. Status Emosi :</span><br>
            &nbsp;&nbsp;
            <input type="checkbox" {{ $data->emosi_rileks ? 'checked' : '' }}> Rileks &nbsp;
            <input type="checkbox" {{ $data->emosi_gelisah ? 'checked' : '' }}> Gelisah &nbsp;
            <input type="checkbox" {{ $data->emosi_tidak_ada_respon ? 'checked' : '' }}> Tidak Ada Respon
        </div>

        {{-- 5. Posisi Canul Intravena --}}
        <div class="row-item">
            <span class="section-label">5. Posisi Canul Intravena :</span><br>
            &nbsp;&nbsp;
            <input type="checkbox" {{ $data->canul_tangan ? 'checked' : '' }}> Tangan &nbsp;
            <input type="checkbox" {{ $data->canul_kaki ? 'checked' : '' }}> Kaki &nbsp;
            <input type="checkbox" {{ $data->canul_cvp ? 'checked' : '' }}> CVP<br>
            &nbsp;&nbsp;
            <input type="checkbox"> Lainnya: <span class="underline">{{ $data->canul_lainnya }}</span>
        </div>

        {{-- 6. Jenis Operasi --}}
        <div class="row-item">
            <span class="section-label">6. Jenis Operasi :</span><br>
            &nbsp;&nbsp;
            <input type="checkbox" {{ $data->jenis_op_bersih ? 'checked' : '' }}> Bersih &nbsp;
            <input type="checkbox" {{ $data->jenis_op_terkontaminasi ? 'checked' : '' }}> Terkontaminasi<br>
            &nbsp;&nbsp;
            <input type="checkbox" {{ $data->jenis_op_bersih_terkontaminasi ? 'checked' : '' }}> Bersih Terkontaminasi &nbsp;
            <input type="checkbox" {{ $data->jenis_op_kotor_infeksi ? 'checked' : '' }}> Kotor/Infeksi
        </div>

        {{-- 7. Posisi Operasi --}}
        <div class="row-item">
            <span class="section-label">7. Posisi Operasi :</span><br>
            &nbsp;&nbsp;
            <input type="checkbox" {{ $data->posisi_supine ? 'checked' : '' }}> Supine &nbsp;
            <input type="checkbox" {{ $data->posisi_prone ? 'checked' : '' }}> Prone &nbsp;
            <input type="checkbox" {{ $data->posisi_lithotomi ? 'checked' : '' }}> Lithotomi<br>
            &nbsp;&nbsp;
            <input type="checkbox" {{ $data->posisi_kidney ? 'checked' : '' }}> Kidney &nbsp;
            <input type="checkbox" {{ $data->posisi_lateral ? 'checked' : '' }}> Lateral<br>
            &nbsp;&nbsp;
            <input type="checkbox"> Lainnya: <span class="underline">{{ $data->posisi_lainnya }}</span><br>
            &nbsp;&nbsp; Diawasi oleh: <span class="underline" style="min-width:120px;">{{ $data->posisi_diawasi_oleh }}</span>
        </div>

        {{-- 8. Posisi Selengantangan --}}
        <div class="row-item">
            <span class="section-label">8. Posisi Selengantangan :</span><br>
            &nbsp;&nbsp;
            <input type="checkbox" {{ $data->selengantangan_adduksi ? 'checked' : '' }}> Adduksi &nbsp;
            <input type="checkbox" {{ $data->selengantangan_abduksi ? 'checked' : '' }}> Abduksi<br>
            &nbsp;&nbsp;
            <input type="checkbox"> Lainnya: <span class="underline">{{ $data->selengantangan_lainnya }}</span>
        </div>

        {{-- 9. Urine Catheter --}}
        <div class="row-item">
            <span class="section-label">9. Urine Catheter :</span>
            <input type="checkbox" {{ $data->urine_ya ? 'checked' : '' }}> Ya &nbsp;
            <input type="checkbox" {{ $data->urine_tidak ? 'checked' : '' }}> Tidak<br>
            &nbsp;&nbsp;
            <input type="checkbox" {{ $data->urine_ok ? 'checked' : '' }}> OK &nbsp;
            <input type="checkbox" {{ $data->urine_ruangan ? 'checked' : '' }}> Ruangan<br>
            &nbsp;&nbsp; Dipasang oleh: <span class="underline" style="min-width:100px;">{{ $data->urine_dipasang_oleh }}</span><br>
            &nbsp;&nbsp; Jenis: <span class="underline" style="min-width:100px;">{{ $data->urine_jenis }}</span>
        </div>

        {{-- 10. Desinfeksi Kulit --}}
        <div class="row-item">
            <span class="section-label">10. Desinfeksi Kulit :</span><br>
            &nbsp;&nbsp;
            <input type="checkbox" {{ $data->desinfeksi_iodium ? 'checked' : '' }}> Iodium &nbsp;
            <input type="checkbox" {{ $data->desinfeksi_alkohol ? 'checked' : '' }}> Alkohol<br>
            &nbsp;&nbsp;
            <input type="checkbox" {{ $data->desinfeksi_povidone ? 'checked' : '' }}> Povidone Iodine &nbsp;
            <input type="checkbox" {{ $data->desinfeksi_chlorhexidine ? 'checked' : '' }}> Chlorhexidine
        </div>

        {{-- 11. Insisi Kulit --}}
        <div class="row-item">
            <span class="section-label">11. Insisi Kulit :</span><br>
            &nbsp;&nbsp;
            <input type="checkbox" {{ $data->insisi_pfannenstiel ? 'checked' : '' }}> Pfannenstiel &nbsp;
            <input type="checkbox"> Lainnya: <span class="underline">{{ $data->insisi_lainnya }}</span>
        </div>

        {{-- 12. Alat Bantu --}}
        <div class="row-item">
            <span class="section-label">12. Alat Bantu :</span><br>
            &nbsp;&nbsp;
            <input type="checkbox" {{ $data->alat_hand_rest ? 'checked' : '' }}> Hand Rest &nbsp;
            <input type="checkbox" {{ $data->alat_lithotomi_support ? 'checked' : '' }}> Lithotomi Support<br>
            &nbsp;&nbsp;
            <input type="checkbox" {{ $data->alat_lateral_support ? 'checked' : '' }}> Lateral Support &nbsp;
            <input type="checkbox" {{ $data->alat_chest_support ? 'checked' : '' }}> Chest Support &nbsp;
            <input type="checkbox" {{ $data->alat_heat_frame ? 'checked' : '' }}> Heat Frame<br>
            &nbsp;&nbsp;
            <input type="checkbox"> Lainnya: <span class="underline">{{ $data->alat_lainnya }}</span>
        </div>

    </td>

    {{-- RIGHT COLUMN --}}
    <td style="width:50%; padding:5px 8px; vertical-align:top; line-height:17px;">

        {{-- 13. Diatermi --}}
        <div class="row-item">
            <span class="section-label">13. Diatermi :</span>
            <input type="checkbox" {{ $data->diatermi_ya ? 'checked' : '' }}> Ya &nbsp;
            <input type="checkbox" {{ $data->diatermi_tidak ? 'checked' : '' }}> Tidak<br>
            &nbsp;&nbsp;
            <input type="checkbox" {{ $data->diatermi_monopolar ? 'checked' : '' }}> Monopolar &nbsp;
            <input type="checkbox" {{ $data->diatermi_bipolar ? 'checked' : '' }}> Bipolar<br>
            &nbsp;&nbsp; Pad Netral :<br>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="checkbox" {{ $data->diatermi_netral_bokong ? 'checked' : '' }}> Bokong &nbsp;
            <input type="checkbox" {{ $data->diatermi_netral_tungkai_atas ? 'checked' : '' }}> Tungkai Atas<br>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="checkbox" {{ $data->diatermi_netral_tungkai_bawah ? 'checked' : '' }}> Tungkai Bawah &nbsp;
            <input type="checkbox" {{ $data->diatermi_netral_punggung ? 'checked' : '' }}> Punggung &nbsp;
            <input type="checkbox" {{ $data->diatermi_netral_bahu ? 'checked' : '' }}> Bahu<br>
            &nbsp;&nbsp; Dipasang oleh: <span class="underline" style="min-width:100px;">{{ $data->diatermi_dipasang_oleh }}</span><br>
            &nbsp;&nbsp; Kondisi Kulit Sebelum:<br>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="checkbox" {{ $data->diatermi_kulit_sbl_utuh ? 'checked' : '' }}> Utuh &nbsp;
            <input type="checkbox" {{ $data->diatermi_kulit_sbl_bulosa ? 'checked' : '' }}> Bulosa &nbsp;
            <input type="checkbox" {{ $data->diatermi_kulit_sbl_eritema ? 'checked' : '' }}> Eritema &nbsp;
            <input type="checkbox" {{ $data->diatermi_kulit_sbl_luka_bakar ? 'checked' : '' }}> Luka Bakar<br>
            &nbsp;&nbsp; Kondisi Kulit Sesudah:<br>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="checkbox" {{ $data->diatermi_kulit_ssd_utuh ? 'checked' : '' }}> Utuh &nbsp;
            <input type="checkbox" {{ $data->diatermi_kulit_ssd_bulosa ? 'checked' : '' }}> Bulosa &nbsp;
            <input type="checkbox" {{ $data->diatermi_kulit_ssd_eritema ? 'checked' : '' }}> Eritema &nbsp;
            <input type="checkbox" {{ $data->diatermi_kulit_ssd_luka_bakar ? 'checked' : '' }}> Luka Bakar
        </div>

        {{-- 14. Warm Blanket --}}
        <div class="row-item">
            <span class="section-label">14. Warm Blanket :</span>
            <input type="checkbox" {{ $data->warm_blanket_ya ? 'checked' : '' }}> Ya &nbsp;
            <input type="checkbox" {{ $data->warm_blanket_tidak ? 'checked' : '' }}> Tidak<br>
            &nbsp;&nbsp; Jenis: <span class="underline">{{ $data->warm_blanket_jenis }}</span>
            &nbsp; Jam: {{ $data->warm_blanket_jam_mulai ?: '.....' }} – {{ $data->warm_blanket_jam_selesai ?: '.....' }}
        </div>

        {{-- 15. Tourniquet --}}
        <div class="row-item">
            <span class="section-label">15. Tourniquet :</span>
            <input type="checkbox" {{ $data->tourniquet_ya ? 'checked' : '' }}> Ya &nbsp;
            <input type="checkbox" {{ $data->tourniquet_tidak ? 'checked' : '' }}> Tidak<br>
            &nbsp;&nbsp; Lokasi: <span class="underline">{{ $data->tourniquet_lokasi }}</span><br>
            &nbsp;&nbsp;
            <input type="checkbox" {{ $data->tourniquet_lengan ? 'checked' : '' }}> Lengan:
            Jam {{ $data->tourniquet_lengan_jam_mulai ?: '.....' }}–{{ $data->tourniquet_lengan_jam_selesai ?: '.....' }}
            TD: <span class="underline-sm">{{ $data->tourniquet_lengan_td }}</span><br>
            &nbsp;&nbsp;
            <input type="checkbox" {{ $data->tourniquet_kaki ? 'checked' : '' }}> Kaki:
            Jam {{ $data->tourniquet_kaki_jam_mulai ?: '.....' }}–{{ $data->tourniquet_kaki_jam_selesai ?: '.....' }}
            TD: <span class="underline-sm">{{ $data->tourniquet_kaki_td }}</span><br>
            &nbsp;&nbsp; Dipasang oleh: <span class="underline" style="min-width:100px;">{{ $data->tourniquet_dipasang_oleh }}</span>
        </div>

        {{-- 16. Implant --}}
        <div class="row-item">
            <span class="section-label">16. Implant :</span>
            <input type="checkbox" {{ $data->implant_ya ? 'checked' : '' }}> Ya &nbsp;
            <input type="checkbox" {{ $data->implant_tidak ? 'checked' : '' }}> Tidak<br>
            &nbsp;&nbsp; Jenis: <span class="underline">{{ $data->implant_jenis }}</span>
            &nbsp; Lokasi: <span class="underline">{{ $data->implant_lokasi }}</span>
        </div>

        {{-- 17. Drain --}}
        <div class="row-item">
            <span class="section-label">17. Drain :</span>
            <input type="checkbox" {{ $data->drain_ya ? 'checked' : '' }}> Ya &nbsp;
            <input type="checkbox" {{ $data->drain_tidak ? 'checked' : '' }}> Tidak<br>
            &nbsp;&nbsp; Jenis: <span class="underline">{{ $data->drain_jenis }}</span>
            &nbsp; Lokasi: <span class="underline">{{ $data->drain_lokasi }}</span>
        </div>

        {{-- 18. Irigasi Luka --}}
        <div class="row-item">
            <span class="section-label">18. Irigasi Luka :</span>
            <input type="checkbox" {{ $data->irigasi_ya ? 'checked' : '' }}> Ya &nbsp;
            <input type="checkbox" {{ $data->irigasi_tidak ? 'checked' : '' }}> Tidak<br>
            &nbsp;&nbsp;
            <input type="checkbox" {{ $data->irigasi_nacl ? 'checked' : '' }}> NaCl &nbsp;
            <input type="checkbox" {{ $data->irigasi_h2o2 ? 'checked' : '' }}> H2O2 &nbsp;
            <input type="checkbox" {{ $data->irigasi_antibiotik ? 'checked' : '' }}> Antibiotik<br>
            &nbsp;&nbsp;
            <input type="checkbox"> Lainnya: <span class="underline-sm">{{ $data->irigasi_lainnya }}</span>
        </div>

        {{-- 19. Tampon --}}
        <div class="row-item">
            <span class="section-label">19. Tampon :</span>
            <input type="checkbox" {{ $data->tampon_ya ? 'checked' : '' }}> Ya &nbsp;
            <input type="checkbox" {{ $data->tampon_tidak ? 'checked' : '' }}> Tidak<br>
            &nbsp;&nbsp; Lokasi: <span class="underline">{{ $data->tampon_lokasi }}</span>
            &nbsp; Jumlah: <span class="underline-sm">{{ $data->tampon_jumlah }}</span>
        </div>

        {{-- 20. Spesimen --}}
        <div class="row-item">
            <span class="section-label">20. Spesimen :</span><br>
            &nbsp;&nbsp;
            <input type="checkbox" {{ $data->spesimen_histology ? 'checked' : '' }}> Histology: <span class="underline">{{ $data->spesimen_histology_jenis }}</span><br>
            &nbsp;&nbsp;
            <input type="checkbox" {{ $data->spesimen_kultur ? 'checked' : '' }}> Kultur: <span class="underline">{{ $data->spesimen_kultur_jenis }}</span><br>
            &nbsp;&nbsp;
            <input type="checkbox" {{ $data->spesimen_cytologi ? 'checked' : '' }}> Cytologi: <span class="underline">{{ $data->spesimen_cytologi_jenis }}</span><br>
            &nbsp;&nbsp;
            <input type="checkbox" {{ $data->spesimen_frozen ? 'checked' : '' }}> Frozen Section: <span class="underline">{{ $data->spesimen_frozen_jenis }}</span>
        </div>

        {{-- 21. Cairan Infus --}}
        <div class="row-item">
            <span class="section-label">21. Cairan Infus :</span>
            <table style="border:1px solid black; margin-top:2px; font-size:7.5pt;">
                <tr style="background:#eee;">
                    <th style="border:1px solid black; padding:2px 4px;">Cairan</th>
                    <th style="border:1px solid black; padding:2px 4px;">Input (ml)</th>
                    <th style="border:1px solid black; padding:2px 4px;">Output (ml)</th>
                    <th style="border:1px solid black; padding:2px 4px;">Total (ml)</th>
                </tr>
                @php $cairanList = $data->cairan_infus ?? []; @endphp
                @if(count($cairanList) > 0)
                    @foreach($cairanList as $row)
                    <tr>
                        <td style="border:1px solid black; padding:2px 4px;">{{ $row['cairan'] ?? '' }}</td>
                        <td style="border:1px solid black; padding:2px 4px; text-align:center;">{{ $row['input'] ?? '' }}</td>
                        <td style="border:1px solid black; padding:2px 4px; text-align:center;">{{ $row['output'] ?? '' }}</td>
                        <td style="border:1px solid black; padding:2px 4px; text-align:center;">{{ $row['total'] ?? '' }}</td>
                    </tr>
                    @endforeach
                @else
                    @for($i = 0; $i < 3; $i++)
                    <tr>
                        <td style="border:1px solid black; padding:2px 4px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td style="border:1px solid black; padding:2px 4px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td style="border:1px solid black; padding:2px 4px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td style="border:1px solid black; padding:2px 4px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    </tr>
                    @endfor
                @endif
            </table>
        </div>

        {{-- 22-24. Kassa, Jarum, Bisturi --}}
        <div class="row-item">
            <table style="font-size:8pt; margin-top:2px;">
                <tr>
                    <td style="padding-right:6px; font-weight:bold;">22. Kassa</td>
                    <td>Sebelum: <span class="underline-sm">{{ $data->kassa_sebelum }}</span></td>
                    <td>&nbsp;+ <span class="underline-sm">{{ $data->kassa_penambahan }}</span></td>
                    <td>&nbsp;= Sesudah: <span class="underline-sm">{{ $data->kassa_setelah }}</span></td>
                </tr>
                <tr>
                    <td style="padding-right:6px; font-weight:bold;">23. Jarum</td>
                    <td>Sebelum: <span class="underline-sm">{{ $data->jarum_sebelum }}</span></td>
                    <td>&nbsp;+ <span class="underline-sm">{{ $data->jarum_penambahan }}</span></td>
                    <td>&nbsp;= Sesudah: <span class="underline-sm">{{ $data->jarum_setelah }}</span></td>
                </tr>
                <tr>
                    <td style="padding-right:6px; font-weight:bold;">24. Bisturi</td>
                    <td>Sebelum: <span class="underline-sm">{{ $data->bisturi_sebelum }}</span></td>
                    <td>&nbsp;+ <span class="underline-sm">{{ $data->bisturi_penambahan }}</span></td>
                    <td>&nbsp;= Sesudah: <span class="underline-sm">{{ $data->bisturi_setelah }}</span></td>
                </tr>
            </table>
        </div>

    </td>
    </tr>
</table>

{{-- ── SECTION B ── --}}
<table style="border:1px solid black; margin-bottom:4px;">
    <tr>
        <td colspan="5" style="background:#ddd; padding:2px 8px; font-weight:bold; font-size:9pt; border-bottom:1px solid black;">
            B. TABEL KASA DAN ALAT INSTRUMEN
        </td>
    </tr>
    <tr style="background:#eee; text-align:center; font-weight:bold;">
        <td style="border:1px solid black; padding:3px 6px; width:28%;">Nama Alat / Kasa</td>
        <td style="border:1px solid black; padding:3px 6px; width:18%;">Persediaan</td>
        <td style="border:1px solid black; padding:3px 6px; width:18%;">Terpakai</td>
        <td style="border:1px solid black; padding:3px 6px; width:18%;">Sisa</td>
        <td style="border:1px solid black; padding:3px 6px; width:18%;">Keterangan</td>
    </tr>
    @php
    $rows = [
        ['label' => 'Kasa Besar',        'key' => 'kasa_besar'],
        ['label' => 'Kasa',              'key' => 'kasa'],
        ['label' => 'Kasa Kacang',       'key' => 'kasa_kacang'],
        ['label' => 'Kasa Tampon',       'key' => 'kasa_tampon'],
        ['label' => 'Instrumen',         'key' => 'instrumen'],
        ['label' => 'Jarum Atraumatik',  'key' => 'jarum_atraumatik'],
        ['label' => 'Jarum Lepas',       'key' => 'jarum_lepas'],
        ['label' => 'Selang',            'key' => 'selang'],
    ];
    @endphp
    @foreach($rows as $row)
    <tr>
        <td style="border:1px solid black; padding:3px 8px; font-weight:bold;">{{ $row['label'] }}</td>
        <td style="border:1px solid black; padding:3px 8px; text-align:center;">{{ $data->{$row['key'].'_persediaan'} }}</td>
        <td style="border:1px solid black; padding:3px 8px; text-align:center;">{{ $data->{$row['key'].'_terpakai'} }}</td>
        <td style="border:1px solid black; padding:3px 8px; text-align:center;">{{ $data->{$row['key'].'_sisa'} }}</td>
        <td style="border:1px solid black; padding:3px 8px;">{{ $data->{$row['key'].'_keterangan'} }}</td>
    </tr>
    @endforeach
</table>

{{-- ── TANDA TANGAN ── --}}
<table style="border:1px solid black; margin-bottom:4px;">
    <tr>
        <td style="width:33%; border-right:1px solid black; padding:6px 10px; text-align:center; vertical-align:top;">
            <div style="font-weight:bold; margin-bottom:4px;">Dokter Operator</div>
            <div style="height:60px; border:1px solid #999; margin-bottom:4px; text-align:center;">
                @if($data->ttd_dokter_operator)
                    <img src="{{ $data->ttd_dokter_operator }}" style="max-height:55px; max-width:100%;" />
                @endif
            </div>
            <div style="border-top:1px solid #000; padding-top:2px;">
                {{ $data->nama_dokter_operator ?: '................................................' }}
            </div>
        </td>
        <td style="width:33%; border-right:1px solid black; padding:6px 10px; text-align:center; vertical-align:top;">
            <div style="font-weight:bold; margin-bottom:4px;">Perawat Instrumen</div>
            <div style="height:60px; border:1px solid #999; margin-bottom:4px; text-align:center;">
                @if($data->ttd_perawat_instrumen)
                    <img src="{{ $data->ttd_perawat_instrumen }}" style="max-height:55px; max-width:100%;" />
                @endif
            </div>
            <div style="border-top:1px solid #000; padding-top:2px;">
                {{ $data->nama_perawat_instrumen ?: '................................................' }}
            </div>
        </td>
        <td style="width:34%; padding:6px 10px; text-align:center; vertical-align:top;">
            <div style="font-weight:bold; margin-bottom:4px;">Perawat Sirkuler</div>
            <div style="height:60px; border:1px solid #999; margin-bottom:4px; text-align:center;">
                @if($data->ttd_perawat_sirkuler)
                    <img src="{{ $data->ttd_perawat_sirkuler }}" style="max-height:55px; max-width:100%;" />
                @endif
            </div>
            <div style="border-top:1px solid #000; padding-top:2px;">
                {{ $data->nama_perawat_sirkuler ?: '................................................' }}
            </div>
        </td>
    </tr>
</table>


{{-- ══════════════════════════════════════════════════════════════════ --}}
{{-- C. DIAGNOSA INTRA OPERASI                                        --}}
{{-- ══════════════════════════════════════════════════════════════════ --}}
<table style="border:1px solid black; margin-bottom:4px; page-break-before:always;">
    <tr>
        <td colspan="3" style="background:#ddd; padding:2px 8px; font-weight:bold; font-size:9pt; border-bottom:1px solid black;">
            C. DIAGNOSA, INTERVENSI, IMPLEMENTASI ASUHAN KEPERAWATAN INTRA OPERASI
        </td>
    </tr>
    <tr style="background:#eee; font-weight:bold; text-align:center;">
        <td style="border:1px solid black; padding:3px 6px; width:28%;">Diagnosa</td>
        <td style="border:1px solid black; padding:3px 6px; width:44%;">Intervensi/Implementasi (Jam dilakukan)</td>
        <td style="border:1px solid black; padding:3px 6px; width:28%;">Evaluasi (Nama &amp; Paraf)</td>
    </tr>

    {{-- C1 Gangguan pola nafas --}}
    <tr style="vertical-align:top;">
        <td style="border:1px solid black; padding:4px 8px; font-size:8pt; line-height:16px;">
            <strong>Gangguan pola nafas b.d</strong><br>
            <input type="checkbox" {{ $data->c_gn_neuro_muskular ? 'checked' : '' }}> Neuro muskular<br>
            <input type="checkbox" {{ $data->c_gn_penumpukan_sekret ? 'checked' : '' }}> Penumpukan sekret
        </td>
        <td style="border:1px solid black; padding:4px 8px; font-size:8pt; line-height:16px;">
            <input type="checkbox" {{ $data->c_gn_int_jalan_nafas ? 'checked' : '' }}> Pertahankan jalan nafas pasien dengan memiringkan kepala<br>
            <input type="checkbox" {{ $data->c_gn_int_hiperekstensi ? 'checked' : '' }}> Hiperekstensi rahang<br>
            <input type="checkbox" {{ $data->c_gn_int_observasi_rr ? 'checked' : '' }}> Observasi RR dan kedalaman pernapasan, cuping hidung.<br>
            <input type="checkbox" {{ $data->c_gn_int_pantau_ttv ? 'checked' : '' }}> Pantau TTV secara kontinu<br>
            <input type="checkbox" {{ $data->c_gn_int_suction ? 'checked' : '' }}> Lakukan suction jika diperlukan<br>
            <input type="checkbox" {{ $data->c_gn_int_o2 ? 'checked' : '' }}> Pemberian O<sub>2</sub> sesuai kebutuhan<br>
            <input type="checkbox" {{ $data->c_gn_int_obat ? 'checked' : '' }}> Pemberian obat
        </td>
        <td style="border:1px solid black; padding:4px 8px; font-size:8pt; line-height:16px;">
            <input type="checkbox" {{ $data->c_gn_eval_ttv_normal ? 'checked' : '' }}> TTV dalam batas normal<br>
            <input type="checkbox" {{ $data->c_gn_eval_nafas_spontan ? 'checked' : '' }}> Nafas spontan<br>
            <input type="checkbox" {{ $data->c_gn_eval_sianosis ? 'checked' : '' }}> Sianosis<br>
            <input type="checkbox"> O<sub>2</sub> : {{ $data->c_gn_eval_o2_value ?: '.......' }} l/mnt<br>
            <input type="checkbox" {{ $data->c_gn_eval_observasi_ruangan ? 'checked' : '' }}> Selanjutnya di observasi diruangan<br><br>
            Perawat Kamar Bedah<br><br>
            @if($data->c_gn_paraf)
                <img src="{{ $data->c_gn_paraf }}" style="max-height:40px; max-width:90px;" /><br>
            @endif
            ( {{ $data->c_gn_nama ?: '………………………' }} )
        </td>
    </tr>

    {{-- C2 Resiko kekurangan cairan --}}
    <tr style="vertical-align:top;">
        <td style="border:1px solid black; padding:4px 8px; font-size:8pt; line-height:16px;">
            <strong>Resiko tinggi kekurangan cairan b.d</strong><br>
            <input type="checkbox" {{ $data->c_rc_pembatasan_intake ? 'checked' : '' }}> Pembatasan intake<br>
            <input type="checkbox" {{ $data->c_rc_hilang_cairan ? 'checked' : '' }}> Hilangnya cairan tubuh secara abnormal<br>
            <input type="checkbox" {{ $data->c_rc_pengeluaran_integritas ? 'checked' : '' }}> Pengeluaran integritas pembuluh darah
        </td>
        <td style="border:1px solid black; padding:4px 8px; font-size:8pt; line-height:16px;">
            <input type="checkbox" {{ $data->c_rc_int_ukur_io ? 'checked' : '' }}> Ukur input dan output cairan<br>
            <input type="checkbox" {{ $data->c_rc_int_pantau_ttv ? 'checked' : '' }}> Pantau TTV secara kontinu<br>
            <input type="checkbox" {{ $data->c_rc_int_mual_muntah ? 'checked' : '' }}> Catat munculnya mual muntah<br>
            <input type="checkbox" {{ $data->c_rc_int_periksa_pembalut ? 'checked' : '' }}> Periksa pembalut, drain<br>
            <input type="checkbox" {{ $data->c_rc_int_pantau_suhu ? 'checked' : '' }}> Pantau suhu tubuh, palpasi denyut perifer
        </td>
        <td style="border:1px solid black; padding:4px 8px; font-size:8pt; line-height:16px;">
            <input type="checkbox" {{ $data->c_rc_eval_ttv_normal ? 'checked' : '' }}> TTV dalam batas normal<br>
            <input type="checkbox"> Input : {{ $data->c_rc_eval_input ?: '.........' }}<br>
            <input type="checkbox"> Output : {{ $data->c_rc_eval_output ?: '.........' }}<br>
            <input type="checkbox" {{ $data->c_rc_eval_mukosa_lembab ? 'checked' : '' }}> Mukosa bibir lembab<br>
            <input type="checkbox" {{ $data->c_rc_eval_turgor_elastis ? 'checked' : '' }}> Turgor elastis<br><br>
            Perawat Kamar Bedah<br><br>
            @if($data->c_rc_paraf)
                <img src="{{ $data->c_rc_paraf }}" style="max-height:40px; max-width:90px;" /><br>
            @endif
            ( {{ $data->c_rc_nama ?: '………………………' }} )
        </td>
    </tr>

    {{-- C3 Resiko cedera --}}
    <tr style="vertical-align:top;">
        <td style="border:1px solid black; padding:4px 8px; font-size:8pt; line-height:16px;">
            <strong>Resiko tinggi cedera b.d</strong><br>
            <input type="checkbox" {{ $data->c_rd_pemajanan_peralatan ? 'checked' : '' }}> Pemajanan peralatan operasi<br>
            <input type="checkbox" {{ $data->c_rd_hipoksia_jaringan ? 'checked' : '' }}> Hipoksia jaringan, perubahan posisi, faktor pembekuan, kerusakan kulit
        </td>
        <td style="border:1px solid black; padding:4px 8px; font-size:8pt; line-height:16px;">
            <input type="checkbox" {{ $data->c_rd_int_lepas_gigi ? 'checked' : '' }}> Lepaskan gigi palsu/kawat gigi, kontak lensa, perhiasan sesuai protokol preoperasi<br>
            <input type="checkbox" {{ $data->c_rd_int_periksa_identitas ? 'checked' : '' }}> Periksa identitas pasien dan jadwal prosedur operasi, sesuaikan gelang nama dengan jadwal<br>
            <input type="checkbox" {{ $data->c_rd_int_brankar ? 'checked' : '' }}> Pastikan brankar ataupun meja operasi terkunci pada waktu memindahkan pasien<br>
            <input type="checkbox" {{ $data->c_rd_int_sabuk ? 'checked' : '' }}> Pastikan penggunaan sabuk pengaman pada paha sesuai kebutuhan<br>
            <input type="checkbox" {{ $data->c_rd_int_peralatan_posisi ? 'checked' : '' }}> Siapkan peralatan dan bantalan untuk posisi<br>
            <input type="checkbox" {{ $data->c_rd_int_keamanan_elektrikal ? 'checked' : '' }}> Pastikan keamanan elektrikal selama prosedur operasi<br>
            <input type="checkbox" {{ $data->c_rd_int_plate_diatermi ? 'checked' : '' }}> Letakkan plate diatermi sesuai prosedur<br>
            <input type="checkbox" {{ $data->c_rd_int_pantau_io ? 'checked' : '' }}> Pantau input dan output cairan<br>
            <input type="checkbox" {{ $data->c_rd_int_catat_kassa ? 'checked' : '' }}> Pastikan dan catat jumlah pemakaian kassa, alat, jarum, mata pisau.
        </td>
        <td style="border:1px solid black; padding:4px 8px; font-size:8pt; line-height:16px;">
            <input type="checkbox" {{ $data->c_rd_eval_posisi ? 'checked' : '' }}> Posisi pasien sesuai kebutuhan, sirkulasi, darah tidak terganggu, tidak ada penekanan pada sistem persarafan<br>
            <input type="checkbox" {{ $data->c_rd_eval_alat_elektro ? 'checked' : '' }}> Penggunaan alat elektro surgical sesuai prosedur.<br>
            <input type="checkbox" {{ $data->c_rd_eval_kassa ? 'checked' : '' }}> Jumlah kassa, jarum, instrument, pisau operasi sebelum dan sesudah tindakan<br><br>
            Perawat Kamar Bedah<br><br>
            @if($data->c_rd_paraf)
                <img src="{{ $data->c_rd_paraf }}" style="max-height:40px; max-width:90px;" /><br>
            @endif
            ( {{ $data->c_rd_nama ?: '………………………' }} )
        </td>
    </tr>

    {{-- C4 Resiko infeksi intra --}}
    <tr style="vertical-align:top;">
        <td style="border:1px solid black; padding:4px 8px; font-size:8pt; line-height:16px;">
            <strong>Resiko infeksi b.d</strong><br>
            <input type="checkbox" {{ $data->c_ri_trauma_post ? 'checked' : '' }}> Trauma post operasi<br>
            <input type="checkbox" {{ $data->c_ri_pemajanan_lingkungan ? 'checked' : '' }}> Pemajanan lingkungan<br>
            <input type="checkbox" {{ $data->c_ri_pemajanan_peralatan ? 'checked' : '' }}> Pemajanan peralatan operasi
        </td>
        <td style="border:1px solid black; padding:4px 8px; font-size:8pt; line-height:16px;">
            <input type="checkbox" {{ $data->c_ri_int_cuci_tangan ? 'checked' : '' }}> Pastikan bahwa semua tim bedah telah melakukan cucitangan secara benar<br>
            <input type="checkbox" {{ $data->c_ri_int_desinfeksi ? 'checked' : '' }}> Lakukan desinfeksi area pembedahan, dan pasang duk steril pada area pembedahan<br>
            <input type="checkbox" {{ $data->c_ri_int_kadaluarsa ? 'checked' : '' }}> Cek kadaluarsa alkes yang digunakan<br>
            <input type="checkbox" {{ $data->c_ri_int_sterilitas ? 'checked' : '' }}> Pertahankan sterilitas selama pembedahan<br>
            <input type="checkbox" {{ $data->c_ri_int_tutup_luka ? 'checked' : '' }}> Tutup luka dengan pembalut steril
        </td>
        <td style="border:1px solid black; padding:4px 8px; font-size:8pt; line-height:16px;">
            <input type="checkbox" {{ $data->c_ri_eval_lingkungan_steril ? 'checked' : '' }}> Selama operasi lingkungan yang steril dapat dipertahankan<br><br>
            Perawat Kamar Bedah<br><br>
            @if($data->c_ri_paraf)
                <img src="{{ $data->c_ri_paraf }}" style="max-height:40px; max-width:90px;" /><br>
            @endif
            ( {{ $data->c_ri_nama ?: '………………………' }} )
        </td>
    </tr>
</table>

{{-- ══════════════════════════════════════════════════════════════════ --}}
{{-- D. PENGKAJIAN PASCA OPERASI                                      --}}
{{-- ══════════════════════════════════════════════════════════════════ --}}
<table style="border:1px solid black; margin-bottom:4px;">
    <tr>
        <td colspan="2" style="background:#ddd; padding:2px 8px; font-weight:bold; font-size:9pt; border-bottom:1px solid black;">
            D. PENGKAJIAN ASUHAN KEPERAWATAN PASCA OPERASI <em>(diisi oleh perawat ruang pemulihan)</em>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding:4px 8px; font-size:8pt; line-height:17px; border-bottom:1px solid black;">
            Ruang pemulihan &nbsp;
            <input type="checkbox" {{ $data->d_ruang_pemulihan_ya ? 'checked' : '' }}> Ya &nbsp;&nbsp;
            Masuk jam: {{ $data->d_masuk_jam ?: '....... Wib' }} &nbsp;
            Keluar jam: {{ $data->d_keluar_jam ?: '....... wib' }}<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="checkbox" {{ $data->d_ruang_pemulihan_tidak ? 'checked' : '' }}> Tidak &nbsp;&nbsp;
            Kembali ke:
            <input type="checkbox" {{ $data->d_kembali_ruangan ? 'checked' : '' }}> Ruangan &nbsp;
            <input type="checkbox" {{ $data->d_kembali_icu ? 'checked' : '' }}> ICU &nbsp;
            <input type="checkbox"> {{ $data->d_kembali_lainnya ?: '............' }}
        </td>
    </tr>
    <tr>
        <td style="width:50%; border-right:1px solid black; padding:4px 8px; font-size:8pt; line-height:17px; vertical-align:top;">
            1. Keadaan umum &nbsp;
            <input type="checkbox" {{ $data->d_keadaan_baik ? 'checked' : '' }}> Baik &nbsp;
            <input type="checkbox" {{ $data->d_keadaan_sedang ? 'checked' : '' }}> Sedang &nbsp;
            <input type="checkbox" {{ $data->d_keadaan_buruk ? 'checked' : '' }}> Buruk<br>

            2. Kesadaran &nbsp;
            <input type="checkbox" {{ $data->d_kesadaran_cm ? 'checked' : '' }}> CM &nbsp;
            <input type="checkbox" {{ $data->d_kesadaran_apatis ? 'checked' : '' }}> Apatis &nbsp;
            <input type="checkbox" {{ $data->d_kesadaran_somnolen ? 'checked' : '' }}> Somnolen &nbsp;
            <input type="checkbox" {{ $data->d_kesadaran_sopor ? 'checked' : '' }}> Sopor &nbsp;
            <input type="checkbox" {{ $data->d_kesadaran_koma ? 'checked' : '' }}> Koma<br>

            3. Keadaan kulit waktu datang &nbsp;
            <input type="checkbox" {{ $data->d_kulit_datang_kering ? 'checked' : '' }}> Kering/lembab &nbsp;
            <input type="checkbox" {{ $data->d_kulit_datang_merah_muda ? 'checked' : '' }}> Merah muda/kebiruan &nbsp;
            <input type="checkbox" {{ $data->d_kulit_datang_hangat ? 'checked' : '' }}> Hangat/lain<br>

            4. Keadaan kulit waktu keluar &nbsp;
            <input type="checkbox" {{ $data->d_kulit_keluar_kering ? 'checked' : '' }}> Kering/lembab &nbsp;
            <input type="checkbox" {{ $data->d_kulit_keluar_merah_muda ? 'checked' : '' }}> Merah muda/kebiruan &nbsp;
            <input type="checkbox" {{ $data->d_kulit_keluar_hangat ? 'checked' : '' }}> Hangat/lain<br>

            5. Sirkulasi anggota badan &nbsp;
            <input type="checkbox" {{ $data->d_sirkulasi_merah_muda ? 'checked' : '' }}> Merah muda &nbsp;
            <input type="checkbox" {{ $data->d_sirkulasi_kebiruan ? 'checked' : '' }}> Kebiruan<br>

            6. Posisi pasien &nbsp;
            <input type="checkbox" {{ $data->d_posisi_lateral ? 'checked' : '' }}> Lateral ka/ki &nbsp;
            <input type="checkbox" {{ $data->d_posisi_datar ? 'checked' : '' }}> Datar &nbsp;
            <input type="checkbox" {{ $data->d_posisi_head_up ? 'checked' : '' }}> Head up 30° &nbsp;
            <input type="checkbox" {{ $data->d_posisi_semi_fowler ? 'checked' : '' }}> Semi fowler<br>

            7. Perdarahan &nbsp;
            <input type="checkbox" {{ $data->d_perdarahan_ya ? 'checked' : '' }}> Ya, {{ $data->d_perdarahan_cc ?: '.......' }} cc &nbsp;
            <input type="checkbox" {{ $data->d_perdarahan_tidak ? 'checked' : '' }}> Tidak &nbsp;
            Lokasi: {{ $data->d_perdarahan_lokasi ?: '.......' }}<br>

            8. Muntah &nbsp;
            <input type="checkbox" {{ $data->d_muntah_ya ? 'checked' : '' }}> Ya &nbsp;
            <input type="checkbox" {{ $data->d_muntah_tidak ? 'checked' : '' }}> Tidak<br>

            9. Mukosa mulut &nbsp;
            <input type="checkbox" {{ $data->d_mukosa_lembab ? 'checked' : '' }}> Lembab &nbsp;
            <input type="checkbox" {{ $data->d_mukosa_kering ? 'checked' : '' }}> Kering<br>

            10. Jaringan PA dan formulir &nbsp;
            <input type="checkbox" {{ $data->d_jaringan_pa_ya ? 'checked' : '' }}> Ya &nbsp;
            <input type="checkbox" {{ $data->d_jaringan_pa_tidak ? 'checked' : '' }}> Tidak &nbsp;
            Dikirim dari:
            <input type="checkbox" {{ $data->d_jaringan_pa_k_bedah ? 'checked' : '' }}> K. Bedah &nbsp;
            <input type="checkbox" {{ $data->d_jaringan_pa_ruangan ? 'checked' : '' }}> Ruangan &nbsp;
            Jumlah: {{ $data->d_jaringan_pa_jumlah ?: '.......' }}<br>

            11. Skrining nyeri &nbsp;
            <input type="checkbox" {{ $data->d_nyeri_ya ? 'checked' : '' }}> Ya (bilaya, dilanjutkan dengan pengkajian nyeri) &nbsp;
            <input type="checkbox" {{ $data->d_nyeri_tidak ? 'checked' : '' }}> Tidak<br>

            12. Resiko jatuh &nbsp;
            <input type="checkbox" {{ $data->d_jatuh_ringan ? 'checked' : '' }}> Ringan &nbsp;
            <input type="checkbox" {{ $data->d_jatuh_sedang ? 'checked' : '' }}> Sedang &nbsp;
            <input type="checkbox" {{ $data->d_jatuh_tinggi ? 'checked' : '' }}> Tinggi
        </td>
        <td style="width:50%; padding:4px 8px; font-size:8pt; vertical-align:top;">
            <table style="width:100%; border-collapse:collapse; font-size:7.5pt;">
                <tr style="background:#eee; font-weight:bold; text-align:center;">
                    <td style="border:1px solid black; padding:2px 4px;">Nadi</td>
                    <td style="border:1px solid black; padding:2px 4px;">Waktu Masuk</td>
                    <td style="border:1px solid black; padding:2px 4px;">Waktu Keluar</td>
                    <td style="border:1px solid black; padding:2px 4px;">Pernafasan</td>
                    <td style="border:1px solid black; padding:2px 4px;">Waktu Masuk</td>
                    <td style="border:1px solid black; padding:2px 4px;">Waktu Keluar</td>
                </tr>
                @php
                $nadiRows = [
                    ['label'=>'Teratur', 'key'=>'teratur'],
                    ['label'=>'Tidak teratur', 'key'=>'tidak_teratur'],
                    ['label'=>'Lemah', 'key'=>'lemah'],
                    ['label'=>'Takikardia', 'key'=>'takikardia'],
                    ['label'=>'Normal', 'key'=>'normal'],
                ];
                $nafasRows = [
                    ['label'=>'Teratur', 'key'=>'teratur'],
                    ['label'=>'Tidak teratur', 'key'=>'tidak_teratur'],
                    ['label'=>'Dangkal', 'key'=>'dangkal'],
                    ['label'=>'Dalam', 'key'=>'dalam'],
                    ['label'=>'Sukar/dibantu', 'key'=>'sukar'],
                ];
                @endphp
                @foreach($nadiRows as $i => $row)
                <tr>
                    <td style="border:1px solid black; padding:2px 4px;">{{ $row['label'] }}</td>
                    <td style="border:1px solid black; padding:2px 4px; text-align:center;">
                        @if($data->{'d_nadi_'.$row['key'].'_masuk'}) ✓ @endif
                    </td>
                    <td style="border:1px solid black; padding:2px 4px; text-align:center;">
                        @if($data->{'d_nadi_'.$row['key'].'_keluar'}) ✓ @endif
                    </td>
                    <td style="border:1px solid black; padding:2px 4px;">{{ $nafasRows[$i]['label'] }}</td>
                    <td style="border:1px solid black; padding:2px 4px; text-align:center;">
                        @if($data->{'d_nafas_'.$nafasRows[$i]['key'].'_masuk'}) ✓ @endif
                    </td>
                    <td style="border:1px solid black; padding:2px 4px; text-align:center;">
                        @if($data->{'d_nafas_'.$nafasRows[$i]['key'].'_keluar'}) ✓ @endif
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="6" style="border:1px solid black; padding:2px 4px; font-size:7pt;">Isi kolom dengan tanda ( ✓ )</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

{{-- ══════════════════════════════════════════════════════════════════ --}}
{{-- E. DIAGNOSA PASCA OPERASI                                        --}}
{{-- ══════════════════════════════════════════════════════════════════ --}}
<table style="border:1px solid black; margin-bottom:4px;">
    <tr>
        <td colspan="3" style="background:#ddd; padding:2px 8px; font-weight:bold; font-size:9pt; border-bottom:1px solid black;">
            E. DIAGNOSA, INTERVENSI, IMPLEMENTASI ASUHAN KEPERAWATAN PASCA OPERASI
        </td>
    </tr>
    <tr style="background:#eee; font-weight:bold; text-align:center;">
        <td style="border:1px solid black; padding:3px 6px; width:28%;">Diagnosa</td>
        <td style="border:1px solid black; padding:3px 6px; width:44%;">Intervensi/Implementasi (Jam dilakukan)</td>
        <td style="border:1px solid black; padding:3px 6px; width:28%;">Evaluasi (Nama &amp; Paraf)</td>
    </tr>

    {{-- E1 Nyeri akut --}}
    <tr style="vertical-align:top;">
        <td style="border:1px solid black; padding:4px 8px; font-size:8pt; line-height:16px;">
            <strong>Nyeri akut berhubungan dengan tindakan operasi</strong><br>
            <input type="checkbox" {{ $data->e_na_gangguan_kulit ? 'checked' : '' }}> Gangguan pada kulit, jaringan otot dan integritas kulit<br>
            <input type="checkbox" {{ $data->e_na_selang_drain ? 'checked' : '' }}> Terdapatnya selang/drain
        </td>
        <td style="border:1px solid black; padding:4px 8px; font-size:8pt; line-height:16px;">
            <input type="checkbox" {{ $data->e_na_int_kaji_lokasi ? 'checked' : '' }}> Kaji lokasi, intensitas nyeri<br>
            <input type="checkbox" {{ $data->e_na_int_kaji_ttv ? 'checked' : '' }}> Kaji TTV, perhatikan tak ikardi, peningkatan pernapasan.<br>
            <input type="checkbox" {{ $data->e_na_int_atur_posisi ? 'checked' : '' }}> Atur posisi yang aman dan nyaman<br>
            <input type="checkbox" {{ $data->e_na_int_relaksasi ? 'checked' : '' }}> Anjurkan penggunaan tehnik relaksasi
        </td>
        <td style="border:1px solid black; padding:4px 8px; font-size:8pt; line-height:16px;">
            <input type="checkbox" {{ $data->e_na_eval_ttv_normal ? 'checked' : '' }}> TTV dalam batas normal<br>
            <input type="checkbox" {{ $data->e_na_eval_nyeri_terkontrol ? 'checked' : '' }}> Nyeri terkontrol<br>
            <input type="checkbox" {{ $data->e_na_eval_nyeri_berkurang ? 'checked' : '' }}> Pasien mengatakan nyeri berkurang<br>
            <input type="checkbox" {{ $data->e_na_eval_observasi_ruangan ? 'checked' : '' }}> Selanjutnya diobservasi diruangan
        </td>
    </tr>

    {{-- E2 Resiko infeksi pasca --}}
    <tr style="vertical-align:top;">
        <td style="border:1px solid black; padding:4px 8px; font-size:8pt; line-height:16px;">
            <strong>Resiko infeksi b.d</strong><br>
            <input type="checkbox" {{ $data->e_ri_trauma_post ? 'checked' : '' }}> Trauma post operasi<br>
            <input type="checkbox" {{ $data->e_ri_pemajanan_lingkungan ? 'checked' : '' }}> Pemajanan lingkungan<br>
            <input type="checkbox" {{ $data->e_ri_pemajanan_peralatan ? 'checked' : '' }}> Pemajanan peralatan operasi
        </td>
        <td style="border:1px solid black; padding:4px 8px; font-size:8pt; line-height:16px;">
            <input type="checkbox" {{ $data->e_ri_int_cuci_tangan ? 'checked' : '' }}> Pastikan bahwa semua tim bedah telah melakukan cuci tangan secara benar<br>
            <input type="checkbox" {{ $data->e_ri_int_desinfeksi ? 'checked' : '' }}> Lakukan desinfeksi area pembedahan, dan pasang duk steril pada area pembedahan<br>
            <input type="checkbox" {{ $data->e_ri_int_kadaluarsa ? 'checked' : '' }}> Cek kadaluarsa alkes yang digunakan<br>
            <input type="checkbox" {{ $data->e_ri_int_sterilitas ? 'checked' : '' }}> Pertahankan sterilitas selama pembedahan<br>
            <input type="checkbox" {{ $data->e_ri_int_tutup_luka ? 'checked' : '' }}> Tutup luka dengan pembalut steril
        </td>
        <td style="border:1px solid black; padding:4px 8px; font-size:8pt; line-height:16px;">
            <input type="checkbox" {{ $data->e_ri_eval_lingkungan_steril ? 'checked' : '' }}> Selama operasi lingkungan yang steril dapat dipertahankan<br><br>
            Perawat Kamar Bedah<br><br>
            @if($data->e_ri_paraf)
                <img src="{{ $data->e_ri_paraf }}" style="max-height:40px; max-width:90px;" /><br>
            @endif
            ( {{ $data->e_ri_nama ?: '………………………' }} )
        </td>
    </tr>

    {{-- E3 Resiko suhu --}}
    <tr style="vertical-align:top;">
        <td style="border:1px solid black; padding:4px 8px; font-size:8pt; line-height:16px;">
            <strong>Resiko tinggi perubahan suhu tubuh b.d</strong><br>
            <input type="checkbox" {{ $data->e_rs_suhu_rendah ? 'checked' : '' }}> Pemajanan suhu rendah dalam jangka lama<br>
            <input type="checkbox" {{ $data->e_rs_penggunaan_obat ? 'checked' : '' }}> Penggunaan obat, zat anestesi<br>
            <input type="checkbox" {{ $data->e_rs_dehidrasi ? 'checked' : '' }}> Dehidrasi
        </td>
        <td style="border:1px solid black; padding:4px 8px; font-size:8pt; line-height:16px;">
            <input type="checkbox" {{ $data->e_rs_int_catat_suhu ? 'checked' : '' }}> Catat suhu post operasi<br>
            <input type="checkbox" {{ $data->e_rs_int_kaji_suhu ? 'checked' : '' }}> Kaji suhu lingkungan dan modifikasi sesuai kebutuhan (selimut penghangat, meningkatkan suhu ruangan)<br>
            <input type="checkbox" {{ $data->e_rs_int_kolaborasi_obat ? 'checked' : '' }}> Kolaborasi penggunaan obat
        </td>
        <td style="border:1px solid black; padding:4px 8px; font-size:8pt; line-height:16px;">
            <input type="checkbox" {{ $data->e_rs_eval_dingin_berkurang ? 'checked' : '' }}> Pasien mengatakan dingin berkurang<br>
            <input type="checkbox" {{ $data->e_rs_eval_tidak_menggigil ? 'checked' : '' }}> Pasien tidak menggigil<br>
            <input type="checkbox"> Suhu : {{ $data->e_rs_eval_suhu ?: '.......' }} °C
        </td>
    </tr>
</table>

{{-- ══════════════════════════════════════════════════════════════════ --}}
{{-- F. TTD PASCA OPERASI                                             --}}
{{-- ══════════════════════════════════════════════════════════════════ --}}
<table style="border:1px solid black; margin-bottom:4px;">
    <tr>
        <td style="width:33%; border-right:1px solid black; padding:6px 10px; text-align:center; vertical-align:top;">
            <div style="font-weight:bold; margin-bottom:4px;">Perawat Asisten/Instrumen</div>
            <div style="height:60px; border:1px solid #999; margin-bottom:4px; text-align:center;">
                @if($data->f_ttd_perawat_instrumen)
                    <img src="{{ $data->f_ttd_perawat_instrumen }}" style="max-height:55px; max-width:100%;" />
                @endif
            </div>
            <div style="border-top:1px solid #000; padding-top:2px;">
                ( {{ $data->f_nama_perawat_instrumen ?: '…………………………………' }} )
            </div>
        </td>
        <td style="width:33%; border-right:1px solid black; padding:6px 10px; text-align:center; vertical-align:top;">
            <div style="font-weight:bold; margin-bottom:4px;">Perawat Sirkuler</div>
            <div style="height:60px; border:1px solid #999; margin-bottom:4px; text-align:center;">
                @if($data->f_ttd_perawat_sirkuler)
                    <img src="{{ $data->f_ttd_perawat_sirkuler }}" style="max-height:55px; max-width:100%;" />
                @endif
            </div>
            <div style="border-top:1px solid #000; padding-top:2px;">
                ( {{ $data->f_nama_perawat_sirkuler ?: '…………………………………' }} )
            </div>
        </td>
        <td style="width:34%; padding:6px 10px; text-align:center; vertical-align:top;">
            <div style="font-weight:bold; margin-bottom:4px;">Perawat Anestesi</div>
            <div style="height:60px; border:1px solid #999; margin-bottom:4px; text-align:center;">
                @if($data->f_ttd_perawat_anestesi)
                    <img src="{{ $data->f_ttd_perawat_anestesi }}" style="max-height:55px; max-width:100%;" />
                @endif
            </div>
            <div style="border-top:1px solid #000; padding-top:2px;">
                ( {{ $data->f_nama_perawat_anestesi ?: '…………………………………' }} )
            </div>
        </td>
    </tr>
</table>

</div>
</body>
</html>
