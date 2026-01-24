<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Operasi Vitreo Retina</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            line-height: 1.3;
            color: #000;
        }
        
        .wrap {
            width: 100%;
            padding: 0 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }
        
        table td {
            border: 1px solid #000;
            padding: 3px 5px;
            vertical-align: top;
        }
        
        table.no-border td {
            border: none;
            padding: 2px 5px;
        }
        
        .header-title {
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            padding: 5px 0;
            border-bottom: 2px solid #000;
            margin-bottom: 3px;
        }
        
        .row-title {
            background: #f0f0f0;
            font-weight: bold;
            text-align: center;
            padding: 4px;
        }
        
        .checkbox {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 1px solid #000;
            text-align: center;
            line-height: 10px;
            margin-right: 3px;
            vertical-align: middle;
        }
        
        .checkbox.checked::before {
            content: '✓';
            font-weight: bold;
        }
        
        .label-inline {
            display: inline-block;
            margin-right: 10px;
        }
        
        .field-value {
            display: inline-block;
            border-bottom: 1px solid #000;
            min-width: 100px;
            padding: 0 5px;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .fw-bold {
            font-weight: bold;
        }
        
        .mt-10 {
            margin-top: 10px;
        }
        
        .signature-box {
            border: 1px solid #000;
            width: 200px;
            height: 80px;
            display: inline-block;
            text-align: center;
            background: #fff;
        }
        
        .signature-box img {
            max-width: 100%;
            max-height: 100%;
        }
        
        .sketch-box {
            border: 1px solid #000;
            width: 100%;
            height: 300px;
            text-align: center;
            background: #fff;
        }
        
        .sketch-box img {
            max-width: 100%;
            max-height: 100%;
        }
        
        .implant-stiker {
            border: 1px solid #000;
            width: 150px;
            height: 100px;
            display: inline-block;
        }
        
        .implant-stiker img {
            max-width: 100%;
            max-height: 100%;
        }
        
        .small-text {
            font-size: 9px;
        }
    </style>
</head>
<body>
    <div style="position:fixed; right: 13px; bottom: 10px;">
    </div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png');  ?>  
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 10.1/LOVR/22
        </div>
        @include('print-rekam-medis.partials.header')
        
        <!-- HEADER TITLE -->
        <div class="header-title">LAPORAN OPERASI VITREO RETINA</div>
        
        <!-- MAIN TABLE -->
        <table>
            <!-- Tanggal Operasi -->
            <tr>
                <td colspan="4" style="text-align: center; font-weight: bold;">
                    Tanggal Operasi : {{ $dokumen->tanggal_operasi ? \Carbon\Carbon::parse($dokumen->tanggal_operasi)->format('d-m-Y') : '........................' }}
                </td>
            </tr>
            
            <!-- Area Operasi & DPJP -->
            <tr>
                <td style="width: 25%;">
                    Area Operasi : 
                    <span class="checkbox {{ $dokumen->area_operasi_od ? 'checked' : '' }}"></span> OD
                    <span class="checkbox {{ $dokumen->area_operasi_os ? 'checked' : '' }}"></span> OS
                </td>
                <td style="width: 25%;">
                    DPJP Bedah : {{ $dokumen->dpjp_bedah ?? '........................' }}
                </td>
                <td style="width: 25%;">
                    Asisten : {{ $dokumen->asisten ?? '........................' }}
                </td>
                <td style="width: 25%;" rowspan="2">
                </td>
            </tr>
            
            <!-- Jam Operasi & Perawat -->
            <tr>
                <td>
                    Jam Mulai Operasi : {{ $dokumen->jam_mulai_operasi ?? '...........' }}
                </td>
                <td>
                    Jam Selesai Operasi : {{ $dokumen->jam_selesai_operasi ?? '...........' }}
                </td>
                <td>
                    Perawat Instrumen : {{ $dokumen->perawat_instrumen ?? '........................' }}
                </td>
            </tr>
            
            <!-- Diagnosis & Anestesi -->
            <tr>
                <td>
                    Diagnosis Pre Operasi : {{ $dokumen->diagnosis_pre_operasi ?? '' }}
                </td>
                <td colspan="2">
                    Jenis Anestesi : 
                    <span class="checkbox {{ $dokumen->anestesi_lokal ? 'checked' : '' }}"></span> Lokal
                    <span class="checkbox {{ $dokumen->anestesi_umum ? 'checked' : '' }}"></span> Anestesi Umum
                </td>
                <td rowspan="2">
                    Nama : {{ $dokumen->nama ?? '' }}<br>
                    Tgl Lahir : {{ $dokumen->tanggal_lahir ? \Carbon\Carbon::parse($dokumen->tanggal_lahir)->format('d-m-Y') : '' }}<br>
                    No. RM : {{ $dokumen->no_rm ?? '' }}<br>
                    NIK : {{ $dokumen->nik ?? '' }}
                </td>
            </tr>
            
            <tr>
                <td>
                    Diagnosis Post Operasi : {{ $dokumen->diagnosis_post_operasi ?? '' }}
                </td>
                <td colspan="2">
                    <span class="checkbox {{ $dokumen->anestesi_sedasi ? 'checked' : '' }}"></span> Sedasi
                    <span class="checkbox {{ $dokumen->anestesi_blok ? 'checked' : '' }}"></span> Anestesi Blok
                </td>
            </tr>
            
            <!-- Jenis Tindakan & DPJP Anestesi -->
            <tr>
                <td>
                    Jenis Tindakan Pembedahan : {{ $dokumen->jenis_tindakan_pembedahan ?? '' }}
                </td>
                <td colspan="3">
                    DPJP Anestesi : {{ $dokumen->dpjp_anestesi ?? '........................' }}
                </td>
            </tr>
            
            <!-- PERITOMI, KENDALA OTOT, BAKEL SKLERA -->
            <tr>
                <td style="vertical-align: top;">
                    <strong>Peritomi</strong><br>
                    <span class="checkbox {{ $dokumen->peritomi_360 ? 'checked' : '' }}"></span> 360º<br>
                    <span class="checkbox {{ $dokumen->peritomi_sebagian ? 'checked' : '' }}"></span> Sebagian<br>
                    <br>
                    <strong>Kendala Otot</strong><br>
                    <span class="checkbox {{ $dokumen->kendala_4_rektus ? 'checked' : '' }}"></span> 4 rektus<br>
                    <span class="checkbox {{ $dokumen->kendala_rektus_superior ? 'checked' : '' }}"></span> Rektus superior saja<br>
                    <span class="checkbox {{ $dokumen->kendala_tak_dilakukan ? 'checked' : '' }}"></span> Tak dilakukan<br>
                    <br>
                    <strong>Bakel Sklera</strong><br>
                    <span class="checkbox {{ $dokumen->bakel_sirkuler_5mm ? 'checked' : '' }}"></span> Sirkuler 5 mm<br>
                    <span class="checkbox {{ $dokumen->bakel_sirkuler_4mm ? 'checked' : '' }}"></span> Sirkuler 4 mm<br>
                    <span class="checkbox {{ $dokumen->bakel_sirkuler_2_5mm ? 'checked' : '' }}"></span> Sirkuler 2,5 mm<br>
                    <span class="checkbox {{ $dokumen->bakel_tak_dilakukan ? 'checked' : '' }}"></span> Tak dilakukan
                </td>
                <td style="vertical-align: top;">
                    <span class="checkbox {{ $dokumen->bakel_sirkuler_2mm ? 'checked' : '' }}"></span> Sirkuler 2 mm<br>
                    <span class="checkbox {{ $dokumen->bakel_sponge ? 'checked' : '' }}"></span> Sponge<br>
                    <span class="checkbox {{ $dokumen->bakel_tyre ? 'checked' : '' }}"></span> Tyre, type {{ $dokumen->bakel_tyre_type ?? '............' }}<br>
                    <br>
                    Ikatan sleeve di :<br>
                    <span class="checkbox {{ $dokumen->ikatan_sleeve_ni ? 'checked' : '' }}"></span> NI
                    <span class="checkbox {{ $dokumen->ikatan_sleeve_ns ? 'checked' : '' }}"></span> NS
                    <span class="checkbox {{ $dokumen->ikatan_sleeve_ts ? 'checked' : '' }}"></span> TS
                    <span class="checkbox {{ $dokumen->ikatan_sleeve_ti ? 'checked' : '' }}"></span> TI
                </td>
                <td colspan="2" style="vertical-align: top;">
                    Ikatan dengan benang di :<br>
                    <span class="checkbox {{ $dokumen->ikatan_benang_ni ? 'checked' : '' }}"></span> NI
                    <span class="checkbox {{ $dokumen->ikatan_benang_ns ? 'checked' : '' }}"></span> NS
                    <span class="checkbox {{ $dokumen->ikatan_benang_ts ? 'checked' : '' }}"></span> TS
                    <span class="checkbox {{ $dokumen->ikatan_benang_ti ? 'checked' : '' }}"></span> TI
                </td>
            </tr>
            
            <!-- JAHITAN BAKEL -->
            <tr>
                <td colspan="2">
                    <strong>Jahitan bakel</strong><br>
                    <span class="checkbox {{ $dokumen->jahitan_bakel_5_0 ? 'checked' : '' }}"></span> 5,0
                    <span class="checkbox {{ $dokumen->jahitan_bakel_4_0 ? 'checked' : '' }}"></span> 4,0<br>
                    <span class="checkbox {{ $dokumen->jahitan_bakel_6_0 ? 'checked' : '' }}"></span> 6,0
                    <span class="checkbox {{ $dokumen->jahitan_bakel_5_0_material ? 'checked' : '' }}"></span> 5,0
                </td>
                <td colspan="2">
                    <span class="checkbox {{ $dokumen->jahitan_bakel_nylon ? 'checked' : '' }}"></span> Nylon
                    <span class="checkbox {{ $dokumen->jahitan_bakel_prolene ? 'checked' : '' }}"></span> Prolene<br>
                    <span class="checkbox {{ $dokumen->jahitan_bakel_vycril ? 'checked' : '' }}"></span> Vycril {{ $dokumen->jahitan_bakel_vycril_detail ?? '............' }}
                </td>
            </tr>
            
            <!-- JAHITAN SKLERETOMI & KANULA -->
            <tr>
                <td>
                    <strong>Jahitan Skleretomi</strong><br>
                    <span class="checkbox {{ $dokumen->skleretomi_3_lubang ? 'checked' : '' }}"></span> 3 lubang<br>
                    <span class="checkbox {{ $dokumen->skleretomi_4_lubang ? 'checked' : '' }}"></span> 4 lubang/pindah
                </td>
                <td colspan="3">
                    <strong>Kanula</strong><br>
                    <span class="checkbox {{ $dokumen->kanula_3mm ? 'checked' : '' }}"></span> 3 mm
                    <span class="checkbox {{ $dokumen->kanula_tak_tembus ? 'checked' : '' }}"></span> Tak tembus, pindah {{ $dokumen->kanula_3_5mm ?? '3,5 mm' }}<br>
                    <span class="checkbox {{ $dokumen->kanula_4mm ? 'checked' : '' }}"></span> 4 mm
                    <span class="checkbox {{ $dokumen->kanula_ujung_tak_terlihat ? 'checked' : '' }}"></span> Ujung kanula tak terlihat (blind)
                </td>
            </tr>
            
            <!-- TEKNIK OPERASI -->
            <tr>
                <td style="vertical-align: top;">
                    <strong>Teknik Operasi</strong><br>
                    <span class="checkbox {{ $dokumen->teknik_pneumatic_retinopexy ? 'checked' : '' }}"></span> Pneumatic retinopexy<br>
                    <span class="checkbox {{ $dokumen->teknik_fge ? 'checked' : '' }}"></span> FGE<br>
                    <span class="checkbox {{ $dokumen->teknik_sice ? 'checked' : '' }}"></span> SICE<br>
                    <span class="checkbox {{ $dokumen->teknik_core_vitrectomy ? 'checked' : '' }}"></span> Core Vitrectomy<br>
                    <span class="checkbox {{ $dokumen->teknik_endblock ? 'checked' : '' }}"></span> Endblock/delaminasi<br>
                    <span class="checkbox {{ $dokumen->teknik_ekstirpasi_iol ? 'checked' : '' }}"></span> Ekstirpasi IOL<br>
                    <span class="checkbox {{ $dokumen->teknik_reposisi_iol ? 'checked' : '' }}"></span> Reposisi IOL<br>
                    <span class="checkbox {{ $dokumen->teknik_iridektomi_perifer ? 'checked' : '' }}"></span> Iridektomi perifer
                </td>
                <td colspan="2" style="vertical-align: top;">
                    <span class="checkbox {{ $dokumen->teknik_pneumatic_dysplacement ? 'checked' : '' }}"></span> Pneumatic dysplacement
                    <span class="checkbox {{ $dokumen->teknik_tpa ? 'checked' : '' }}"></span> TPA<br>
                    <span class="checkbox {{ $dokumen->teknik_kriopeksi ? 'checked' : '' }}"></span> Kriopeksi 360º/PCR/cyclocryo
                    <span class="checkbox {{ $dokumen->teknik_ilm_peeling ? 'checked' : '' }}"></span> ILM peeling<br>
                    <span class="checkbox {{ $dokumen->teknik_injeksi_intravitreal ? 'checked' : '' }}"></span> Injeksi Intravitreal, Lokasi : {{ $dokumen->teknik_injeksi_lokasi ?? '........................' }}<br>
                    <span class="checkbox {{ $dokumen->teknik_pewarna_membran ? 'checked' : '' }}"></span> Pewarna membran/vitreus
                    <span class="checkbox {{ $dokumen->teknik_membrane_peeling ? 'checked' : '' }}"></span> Membrane Peeling<br>
                    <span class="checkbox {{ $dokumen->teknik_bersihkan_vitreous ? 'checked' : '' }}"></span> Bersihkan vitreous base
                    <span class="checkbox {{ $dokumen->teknik_lensectomy ? 'checked' : '' }}"></span> Lensectomy<br>
                    <span class="checkbox {{ $dokumen->teknik_ekstirpasi_benda_asing ? 'checked' : '' }}"></span> Ekstirpasi benda asing
                    <span class="checkbox {{ $dokumen->teknik_ac_fiksasi ? 'checked' : '' }}"></span> AC/Fiksasi skelera<br>
                    <span class="checkbox {{ $dokumen->teknik_ekstirpasi_lensa ? 'checked' : '' }}"></span> Ekstirpasi lensa
                    <span class="checkbox {{ $dokumen->teknik_tidak_dipasang_iol ? 'checked' : '' }}"></span> Tidak dipasang IOL<br>
                    <span class="checkbox {{ $dokumen->teknik_evakuasi_silicone ? 'checked' : '' }}"></span> Evakuasi silicone oil
                    <span class="checkbox {{ $dokumen->teknik_fako ? 'checked' : '' }}"></span> FAKO
                </td>
                <td style="vertical-align: top;"></td>
            </tr>
            
            <!-- DRAINASE & LASER -->
            <tr>
                <td>
                    <strong>Drainase cairan subretina</strong><br>
                    <span class="checkbox {{ $dokumen->drainase_lubang_retina_baru ? 'checked' : '' }}"></span> Dari lubang retina baru<br>
                    <span class="checkbox {{ $dokumen->drainase_robekan_ada ? 'checked' : '' }}"></span> Dari robekan yang ada<br>
                    <span class="checkbox {{ $dokumen->drainase_external ? 'checked' : '' }}"></span> Drainase external
                </td>
                <td colspan="3">
                    <strong>Laser</strong><br>
                    <span class="checkbox {{ $dokumen->laser_dilakukan ? 'checked' : '' }}"></span> Dilakukan
                    Jumlah : {{ $dokumen->laser_jumlah ?? '........' }}
                    Power : {{ $dokumen->laser_power ?? '........' }}<br>
                    <span class="checkbox {{ $dokumen->laser_el ? 'checked' : '' }}"></span> EL
                    Time Exposure : {{ $dokumen->laser_time_exposure ?? '........' }}<br>
                    <span class="checkbox {{ $dokumen->laser_lio ? 'checked' : '' }}"></span> LIO<br>
                    <span class="checkbox {{ $dokumen->laser_tidak_dilakukan ? 'checked' : '' }}"></span> Tidak dilakukan
                </td>
            </tr>
            
            <!-- TAMPONADE -->
            <tr>
                <td style="vertical-align: top;">
                    <strong>Tamponade/Intravitreal Injection</strong><br>
                    <span class="checkbox {{ $dokumen->tamponade_cairan ? 'checked' : '' }}"></span> Cairan<br>
                    <span class="checkbox {{ $dokumen->tamponade_c3f8 ? 'checked' : '' }}"></span> C3F8 {{ $dokumen->tamponade_c3f8_persen ?? '14%/........' }}<br>
                    <span class="checkbox {{ $dokumen->tamponade_f6h8 ? 'checked' : '' }}"></span> F6H8<br>
                    <span class="checkbox {{ $dokumen->tamponade_silicon_oil ? 'checked' : '' }}"></span> Silicon oil {{ $dokumen->tamponade_silicon_oil_type ?? '1000/1300/5000' }}<br>
                    <span class="checkbox {{ $dokumen->tamponade_corneal_debridemant ? 'checked' : '' }}"></span> Corneal debridemant<br>
                    <span class="checkbox {{ $dokumen->tamponade_retina_melekat_sempurna ? 'checked' : '' }}"></span> Retina melekat sempurna<br>
                    <span class="checkbox {{ $dokumen->tamponade_sisa_cairan ? 'checked' : '' }}"></span> Sisa cairan sub retina<br>
                    <span class="checkbox {{ $dokumen->tamponade_ya ? 'checked' : '' }}"></span> Ya
                    <span class="checkbox {{ $dokumen->tamponade_tidak ? 'checked' : '' }}"></span> Tidak
                </td>
                <td colspan="3" style="vertical-align: top;">
                    <span class="checkbox {{ $dokumen->tamponade_udara_steril ? 'checked' : '' }}"></span> Udara steril
                    <span class="checkbox {{ $dokumen->tamponade_lensa_kontak ? 'checked' : '' }}"></span> Lensa Kontak<br>
                    <span class="checkbox {{ $dokumen->tamponade_sf6 ? 'checked' : '' }}"></span> SF6 {{ $dokumen->tamponade_sf6_persen ?? '20%/........' }}
                    <span class="checkbox {{ $dokumen->tamponade_retina_melekat_tidak_sempurna ? 'checked' : '' }}"></span> Retina melekat tidak sempurna<br>
                    <span class="checkbox {{ $dokumen->tamponade_perfluorocarbon ? 'checked' : '' }}"></span> Perfluorocarbon
                    <span class="checkbox {{ $dokumen->tamponade_retina_tak_melekat ? 'checked' : '' }}"></span> Retina tak melekat<br>
                    <br>
                    Antibiotik : {{ $dokumen->tamponade_antibiotik ?? '............' }}<br>
                    Anti VEGF : {{ $dokumen->tamponade_anti_vegf ?? '............' }}<br>
                    Lain - lain : {{ $dokumen->tamponade_lainnya ?? '............' }}
                </td>
            </tr>
            
            <!-- JENIS SPECIMEN -->
            <tr>
                <td colspan="4">
                    Jenis specimen pemeriksaan : {{ $dokumen->jenis_specimen ?? '........................................................................................' }}
                </td>
            </tr>
        </table>
        
        <!-- PAGE BREAK -->
        <div style="page-break-after: always;"></div>
        
        <!-- PAGE 2 HEADER -->
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 10.1/LOVR/22
        </div>
        <div class="header-title">LAPORAN OPERASI VITREO RETINA</div>
        
        <!-- KOMPLIKASI & PERDARAHAN -->
        <table>
            <tr>
                <td colspan="2">
                    <strong>Komplikasi dan penanganannya :</strong>
                    <span class="checkbox {{ $dokumen->komplikasi_ya ? 'checked' : '' }}"></span> Ya
                    <span class="checkbox {{ $dokumen->komplikasi_tidak ? 'checked' : '' }}"></span> Tidak<br>
                    @if($dokumen->komplikasi_ya)
                    Jika Ya : {{ $dokumen->komplikasi_detail ?? '' }}
                    @endif
                </td>
                <td colspan="2">
                    <strong>Perdarahan</strong>
                    <span class="checkbox {{ $dokumen->perdarahan_ya ? 'checked' : '' }}"></span> Ya
                    <span class="checkbox {{ $dokumen->perdarahan_tidak ? 'checked' : '' }}"></span> Tidak<br>
                    Jumlah Perdarahan : {{ $dokumen->jumlah_perdarahan ?? '........' }} cc<br>
                    <br>
                    <span class="checkbox {{ $dokumen->transfusi_ya ? 'checked' : '' }}"></span> Ya
                    <span class="checkbox {{ $dokumen->transfusi_tidak ? 'checked' : '' }}"></span> Tidak<br>
                    Jumlah : {{ $dokumen->jumlah_transfusi ?? '........' }} cc
                </td>
            </tr>
            
            <!-- GAMBAR SKEMA OPERASI -->
            <tr>
                <td colspan="4">
                    <strong>Gambar skema operasi :</strong><br>
                    @if($dokumen->gambar_skema)
                    <div class="sketch-box">
                        <img src="{{ $dokumen->gambar_skema }}" alt="Gambar Skema Operasi">
                    </div>
                    @else
                    <div class="sketch-box"></div>
                    @endif
                </td>
            </tr>
            
            <!-- TATALAKSANA PASCA BEDAH -->
            <tr>
                <td colspan="4">
                    <strong>Tatalaksana Pasca Bedah</strong><br>
                    <span class="checkbox {{ $dokumen->tidur_telungkup_3hr ? 'checked' : '' }}"></span> Tidur telungkup 3 hr
                    <span class="checkbox {{ $dokumen->tidur_telungkup_10hr ? 'checked' : '' }}"></span> 10 hr
                    <span class="checkbox {{ $dokumen->tidur_telungkup_1bl ? 'checked' : '' }}"></span> 1 bl
                    <span class="checkbox {{ $dokumen->tidur_biasa ? 'checked' : '' }}"></span> Tidur biasa
                    <span class="checkbox {{ $dokumen->lepas_lensa_kontak ? 'checked' : '' }}"></span> Lepas lensa kontak stlh 2 hr
                </td>
            </tr>
            
            <tr>
                <td style="width: 50%;">
                    1. Kontrol nadi/tensi/pernafasan/suhu/{{ $dokumen->tatalaksana_1 ?? '.......................' }}
                </td>
                <td style="width: 50%;">
                    5. Obat-obatan : {{ $dokumen->tatalaksana_5 ?? '........................' }}
                </td>
            </tr>
            
            <tr>
                <td>
                    2. Puasa : {{ $dokumen->tatalaksana_2 ?? '........................................................................................' }}
                </td>
                <td rowspan="2" style="vertical-align: top;">
                    {{ $dokumen->tatalaksana_5 ?? '' }}
                </td>
            </tr>
            
            <tr>
                <td>
                    {{ $dokumen->tatalaksana_2 ?? '' }}
                </td>
            </tr>
            
            <tr>
                <td>
                    3. Drain : {{ $dokumen->tatalaksana_3 ?? '......................................................................................' }}
                </td>
                <td rowspan="2" style="vertical-align: top;">
                    {{ $dokumen->tatalaksana_5 ?? '' }}
                </td>
            </tr>
            
            <tr>
                <td>
                    {{ $dokumen->tatalaksana_3 ?? '' }}
                </td>
            </tr>
            
            <tr>
                <td>
                    4. Infus : {{ $dokumen->tatalaksana_4 ?? '.......................................................................................' }}
                </td>
                <td>
                    6. Ganti Balut : {{ $dokumen->tatalaksana_6 ?? '........................' }}
                </td>
            </tr>
            
            <tr>
                <td>
                    {{ $dokumen->tatalaksana_4 ?? '' }}
                </td>
                <td>
                    7. Lain - lain : {{ $dokumen->tatalaksana_7 ?? '........................' }}
                </td>
            </tr>
            
            <tr>
                <td>
                    {{ $dokumen->tatalaksana_4 ?? '' }}
                </td>
                <td>
                    {{ $dokumen->tatalaksana_7 ?? '' }}
                </td>
            </tr>
            
            <tr>
                <td colspan="2">
                </td>
                <td colspan="2">
                    {{ $dokumen->tatalaksana_7 ?? '' }}
                </td>
            </tr>
            
            <!-- TANDA TANGAN -->
            <tr>
                <td colspan="2" style="text-align: center;">
                    <strong>DPJP Bedah,</strong><br><br>
                    @if($dokumen->ttd_dpjp_bedah)
                    <div class="signature-box" style="margin: 0 auto;">
                        <img src="{{ $dokumen->ttd_dpjp_bedah }}" alt="TTD DPJP Bedah">
                    </div>
                    @else
                    <div class="signature-box" style="margin: 0 auto;"></div>
                    @endif
                    <br>
                    (dr.{{ $dokumen->nama_dpjp_bedah_ttd ?? '.......................' }})
                </td>
                <td colspan="2">
                    <strong>Laporan operasi selesai ditulis</strong><br>
                    Tanggal : {{ $dokumen->tanggal_selesai_laporan ? \Carbon\Carbon::parse($dokumen->tanggal_selesai_laporan)->format('d-m-Y') : '.......................' }}<br>
                    Jam : {{ $dokumen->jam_selesai_laporan ?? '.......................' }}
                </td>
            </tr>
            
            <!-- STIKER IMPLANT -->
            <tr>
                <td colspan="4" style="text-align: center;">
                    <strong>Stiker Implant</strong><br>
                    @if($dokumen->stiker_implant)
                    <div class="implant-stiker" style="margin: 10px auto;">
                        <img src="{{ $dokumen->stiker_implant }}" alt="Stiker Implant">
                    </div>
                    @else
                    <div class="implant-stiker" style="margin: 10px auto;"></div>
                    @endif
                </td>
            </tr>
        </table>
    </div>
</body>
</html>