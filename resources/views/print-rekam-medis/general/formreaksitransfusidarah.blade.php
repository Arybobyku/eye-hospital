<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>REKAM MEDIS GENERAL - FORMULIR REAKSI TRANSFUSI DARAH</title>
    <style>
    @page { margin: 18px; }

    body { margin: 18px; font-family: Arial, sans-serif; font-size: 12px; }
    .wrap {
        width: 100%;
        height: auto;
        display: inline-block;
    }

    .left { display: inline-block; float: left; }
    .right { display: inline-block; float: right;}
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
<?php $fullpath = storage_path('app/public/images/header_rme.png');  ?>  
<div class="wrap">
    <div style="width:100%; text-align:right; margin-bottom:5px">
        {{$formData->no_surat ?? 'RM 6.2/FRTD/' . config('app.tahun_akreditasi', '22') }}
    </div>
    @include('print-rekam-medis.partials.header')
    <table style="width: 100%; border: 1px solid black;" cellpadding="0" cellspacing="0">
        <tr>
            <td style="font-weight: bold; text-align: center; padding: 5px; border-bottom: 1px solid black;">
                FORMULIR REAKSI TRANSFUSI DARAH
            </td>
        </tr>
    </table>
    <table style="width: 100%; border-right: 1px solid black; border-left: 1px solid black; border-bottom: 1px solid black;" cellpadding="0" cellspacing="0">
        <tr>
            <td colspan="4" style="padding-left:8px;">
                Dokter Pengirim / Referring Doctor: <strong>{{ $formData->dokter_pengirim ?? '-' }}</strong>
            </td>
            <td style="border-left:1px solid black; padding-left:5px; width:3%; text-align:center;">
                <input type="checkbox" {{ $formData->jenis_rawat == 'inap' ? 'checked' : '' }}>
            </td>
            <td style="width:20%;">
                Rawat Inap / Inpatient
            </td>
            <td style="padding-left:10px; width:3%; text-align:center;">
                <input type="checkbox" {{ $formData->jenis_rawat == 'jalan' ? 'checked' : '' }}>
            </td>
            <td style="width:20%;">
                Rawat Jalan / Outpatient
            </td>
        </tr>
        <tr>
            <td colspan="4" style="padding-top: 10px; padding-left:8px;">
                Tgl/Date: <strong>{{ $formData->tanggal ? \Carbon\Carbon::parse($formData->tanggal)->format('d/m/Y') : '-' }}</strong>
            </td>
            <td colspan="4" style="border-left:1px solid black;"><br></td>
        </tr>
        <tr>
            <td colspan="8" style="border-top:1px solid black; font-size:11px; padding:5px 8px;">
                Untuk advis diagnosa dan terapi, manajemen dan sangkaan akan reaksi transfusi, hubungi dokter jaga ruangan
            </td>
        </tr>
        <tr>
            <td colspan="8" style="border-top:1px solid black;">
                <table style="width: 100%;">        
                    <tr>
                        <td style="width: 50%; padding-left:8px;">
                            Instalansi: <strong>{{ $formData->instalansi ?? '-' }}</strong>
                        </td>
                        <td style="width: 50%;">
                            Tanggal: <strong>{{ $formData->tanggal_transfusi ? \Carbon\Carbon::parse($formData->tanggal_transfusi)->format('d/m/Y') : '-' }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-left:8px;">
                            Diagnosa Klinis: <strong>{{ $formData->diagnosa_klinis ?? '-' }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 50%; padding-left:8px;">
                            Produk Darah: <strong>{{ $formData->produk_darah ?? '-' }}</strong>
                        </td>
                        <td style="width: 50%;">
                            Waktu Permintaan: <strong>{{ $formData->waktu_permintaan ?? '-' }}</strong>
                        </td>
                    </tr>
                    <tr> 
                        <td style="width: 50%; padding-left:8px;">
                            No. Kantong: <strong>{{ $formData->no_kantong ?? '-' }}</strong>
                        </td>
                        <td style="width: 50%;">
                            Vol. Transfusi: <strong>{{ $formData->vol_transfusi ?? '-' }}</strong> ml
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="8" style="border-top:1px solid black;">
                <table style="width: 100%;">
                    <tr>
                        <td colspan="2" style="padding-left:8px;"><b>Clerical Check:</b></td>
                        <td colspan="5"><b>Temperatur dalam 24 jam selama transfusi:</b></td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td style="width:3%; text-align:right;">
                            <input type="checkbox" disabled {{ $formData->temperatur_24jam === 'febris' ? 'checked' : '' }}>
                        </td>
                        <td style="width:20%;">
                            FEBRIS (=< 38 °C)
                        </td>
                        <td style="width:3%; text-align:right;">
                            <input type="checkbox" disabled {{ $formData->temperatur_24jam === 'afebris' ? 'checked' : '' }}>
                        </td>
                        <td colspan="2">
                            AFEBRIS (=< 38 °C)
                        </td>
                    </tr>

                    <tr>
                        <td style="padding-left:8px; width: 200px;">Pasien ID</td>
                        <td style="width:3%; text-align:right;">
                            <input type="checkbox" {{ $formData->clerical_pasien_id == 'ya' ? 'checked' : '' }}>
                        </td>
                        <td style="width:5%;">
                            Ya
                        </td>
                        <td style="width:3%; text-align:right;">
                            <input type="checkbox" {{ $formData->clerical_pasien_id == 'tidak' ? 'checked' : '' }}>
                        </td>
                        <td>
                            Tidak
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-left:8px;">Bag Darah</td>
                        <td style="width:3%; text-align:right;">
                            <input type="checkbox" {{ $formData->clerical_bag_darah == 'ya' ? 'checked' : '' }}>
                        </td>
                        <td style="width:5%;">
                            Ya
                        </td>
                        <td style="width:3%; text-align:right;">
                            <input type="checkbox" {{ $formData->clerical_bag_darah == 'tidak' ? 'checked' : '' }}>
                        </td>
                        <td>
                            Tidak
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-left:8px;">Rekord Transfusi Darah</td>
                        <td style="width:3%; text-align:right;">
                            <input type="checkbox" {{ $formData->clerical_rekord_transfusi == 'ya' ? 'checked' : '' }}>
                        </td>
                        <td style="width:5%;">
                            Ya
                        </td>
                        <td style="width:3%; text-align:right;">
                            <input type="checkbox" {{ $formData->clerical_rekord_transfusi == 'tidak' ? 'checked' : '' }}>
                        </td>
                        <td>
                            Tidak
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr style="border-top:1px solid black;">
            <td colspan="3" style="padding-left:8px;"><b>Vital Sign</b></td>
            <td style="border:1px solid black; text-align:center;"><b>Waktu</b></td>
            <td style="border:1px solid black; text-align:center;"><b>Temperatur</b></td>
            <td style="border:1px solid black; text-align:center;"><b>H.R</b></td>
            <td style="border:1px solid black; text-align:center;"><b>B.P</b></td>
            <td style="border:1px solid black; text-align:center;"><b>Pulse</b></td>
        </tr>
        <tr>
            <td colspan="3" style="padding-left: 20px;">Pre reaksi alergi</td>
            <td style="border:1px solid black; text-align:center;">{{ $formData->pre_waktu ?? '-' }}</td>
            <td style="border:1px solid black; text-align:center;">{{ $formData->pre_temperatur ?? '-' }}</td>
            <td style="border:1px solid black; text-align:center;">{{ $formData->pre_hr ?? '-' }}</td>
            <td style="border:1px solid black; text-align:center;">{{ $formData->pre_bp ?? '-' }}</td>
            <td style="border:1px solid black; text-align:center;">{{ $formData->pre_pulse ?? '-' }}</td>
        </tr>
        <tr>                        
            <td colspan="3" style="padding-left: 20px;">Waktu terjadi reaksi</td>
            <td style="border:1px solid black; text-align:center;">{{ $formData->reaksi_waktu ?? '-' }}</td>
            <td style="border:1px solid black; text-align:center;">{{ $formData->reaksi_temperatur ?? '-' }}</td>
            <td style="border:1px solid black; text-align:center;">{{ $formData->reaksi_hr ?? '-' }}</td>
            <td style="border:1px solid black; text-align:center;">{{ $formData->reaksi_bp ?? '-' }}</td>
            <td style="border:1px solid black; text-align:center;">{{ $formData->reaksi_pulse ?? '-' }}</td>
        </tr>
        <tr>
            <td colspan="8" style="border-top:1px solid black; padding-left:8px;"><b>Obat premedikasi</b></td>
        </tr>
        <tr>
            <td style="border-top:1px solid black; width:3%; text-align:center;">
                <input type="checkbox" {{ $formData->obat_antipiretik == 1 ? 'checked' : '' }}>
            </td>
            <td style="border-top:1px solid black;">
                A. Antipiretik
            </td>
            <td style="border-left:1px solid black; border-top:1px solid black; width:3%; text-align:center;">
                <input type="checkbox" {{ $formData->obat_antihistamin == 1 ? 'checked' : '' }}>
            </td>
            <td style="border-top:1px solid black; width:22%;">
                B. Antihistamin
            </td>
            <td style="border-left:1px solid black; border-top:1px solid black; width:3%; text-align:center;">
                <input type="checkbox" {{ $formData->obat_steroid == 1 ? 'checked' : '' }}>
            </td>
            <td style="border-top:1px solid black;">
                C. Steroid
            </td>
            <td style="border-left:1px solid black; border-top:1px solid black; width:3%; text-align:center;">
                <input type="checkbox" {{ $formData->obat_diuretik == 1 ? 'checked' : '' }}>
            </td>
            <td style="border-top:1px solid black;">
                D. Diuretik
            </td>
        </tr>
        <tr>
            <td colspan="8" style="border-top:1px solid black; padding-left:8px;"><b>Tanda dan Gejala</b></td>
        </tr>
        <tr>
            <td colspan="8">
                <table style="width: 100%;">
                    <tr>
                        <td style="width:3%; text-align:center;">
                            <input type="checkbox" {{ $formData->gejala_demam == 1 ? 'checked' : '' }}>
                        </td>
                        <td style="padding-left: 8px; width:30%;">
                            Demam
                        </td>
                        <td style="width:3%; text-align:center;">
                            <input type="checkbox" {{ $formData->gejala_pusing == 1 ? 'checked' : '' }}>
                        </td>
                        <td style="width:30%;">
                            Pusing
                        </td>
                        <td style="width:3%; text-align:center;">
                            <input type="checkbox" {{ $formData->gejala_kejang == 1 ? 'checked' : '' }}>
                        </td>
                        <td style="width:31%;">
                            Kejang
                        </td>
                    </tr>
                
                    <tr>
                        <td style="text-align:center;">
                            <input type="checkbox" {{ $formData->gejala_sesak_nafas == 1 ? 'checked' : '' }}>
                        </td>
                        <td style="padding-left: 8px;">
                            Sesak Nafas
                        </td>
                        <td style="text-align:center;">
                            <input type="checkbox" {{ $formData->gejala_menggigil == 1 ? 'checked' : '' }}>
                        </td>
                        <td>
                            Menggigil
                        </td>
                        <td style="text-align:center;">
                            <input type="checkbox" {{ $formData->gejala_sakit_kepala == 1 ? 'checked' : '' }}>
                        </td>
                        <td>
                            Sakit Kepala
                        </td>
                    </tr>
                
                    <tr>
                        <td style="text-align:center;">
                            <input type="checkbox" {{ $formData->gejala_nyeri_dada == 1 ? 'checked' : '' }}>
                        </td>
                        <td style="padding-left: 8px;">
                            Nyeri Dada
                        </td>
                        <td style="text-align:center;">
                            <input type="checkbox" {{ $formData->gejala_gatal == 1 ? 'checked' : '' }}>
                        </td>
                        <td>
                            Gatal – gatal
                        </td>
                        <td style="text-align:center;">
                            <input type="checkbox" {{ $formData->gejala_mual == 1 ? 'checked' : '' }}>
                        </td>
                        <td>
                            Mual – mual
                        </td>
                    </tr>
                
                    <tr>
                        <td style="text-align:center;">
                            <input type="checkbox" {{ $formData->gejala_lower_back_pain == 1 ? 'checked' : '' }}>
                        </td>
                        <td style="padding-left: 8px;">
                            Lower back pain
                        </td>
                        <td style="text-align:center;">
                            <input type="checkbox" {{ $formData->gejala_bentol == 1 ? 'checked' : '' }}>
                        </td>
                        <td>
                            Bentol – bentol
                        </td>
                        <td style="text-align:center;">
                            <input type="checkbox" {{ $formData->gejala_muntah == 1 ? 'checked' : '' }}>
                        </td>
                        <td>
                            Muntah
                        </td>
                    </tr>
                
                    <tr>
                        <td style="text-align:center;">
                            <input type="checkbox" {{ $formData->gejala_lain_lain == 1 ? 'checked' : '' }}>
                        </td>
                        <td style="padding-left: 8px;">
                            Lain - lain
                        </td>
                        <td style="text-align:center;">
                            <input type="checkbox" {{ $formData->gejala_urine_gelap == 1 ? 'checked' : '' }}>
                        </td>
                        <td>
                            Urine Gelap
                        </td>
                        <td style="text-align:center;">
                            <input type="checkbox" {{ $formData->gejala_pendarahan == 1 ? 'checked' : '' }}>
                        </td>
                        <td>
                            Pendarahan dari luka atau IV
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="8" style="border-top:1px solid black; padding-left: 8px;"><b>Pemberian darah yang diberikan dibawah 12 jam</b></td>
        </tr>
        <tr>
            <td style="border:1px solid black; text-align:center;" rowspan="2" colspan="2">Donor Unit</td>
            <td style="border:1px solid black; text-align:center;" rowspan="2">Tipe Darah</td>
            <td style="border:1px solid black; text-align:center;" rowspan="2">Tanggal</td>
            <td style="border:1px solid black; text-align:center;" colspan="2">Waktu</td>
            <td style="border:1px solid black; text-align:center;" rowspan="2">Vol. darah yang masuk</td>
            <td style="border:1px solid black; text-align:center;" rowspan="2">Reaksi <br>Ya/Tidak</td>
        </tr>
        <tr>
            <td style="border:1px solid black; text-align:center;">Mulai</td>
            <td style="border:1px solid black; text-align:center;">Stop</td>
        </tr>
        @if(count($pemberianDarah) > 0)
            @foreach($pemberianDarah as $darah)
            <tr>
                <td colspan="2" style="border:1px solid black; text-align:center; padding: 5px;">{{ $darah['donor_unit'] ?? '-' }}</td>
                <td style="border:1px solid black; text-align:center; padding: 5px;">{{ $darah['tipe_darah'] ?? '-' }}</td>
                <td style="border:1px solid black; text-align:center; padding: 5px;">
                    {{ isset($darah['tanggal']) ? \Carbon\Carbon::parse($darah['tanggal'])->format('d/m/Y') : '-' }}
                </td>
                <td style="border:1px solid black; text-align:center; padding: 5px;">{{ $darah['waktu_mulai'] ?? '-' }}</td>
                <td style="border:1px solid black; text-align:center; padding: 5px;">{{ $darah['waktu_stop'] ?? '-' }}</td>
                <td style="border:1px solid black; text-align:center; padding: 5px;">{{ $darah['volume'] ?? '-' }}</td>
                <td style="border:1px solid black; text-align:center; padding: 5px;">{{ $darah['reaksi'] ?? '-' }}</td>
            </tr>
            @endforeach
        @else
            <tr>
                <td colspan="2" style="border:1px solid black; text-align:center; padding: 10px;"><br></td>
                <td style="border:1px solid black; text-align:center;"><br></td>
                <td style="border:1px solid black; text-align:center;"><br></td>
                <td style="border:1px solid black; text-align:center;"><br></td>
                <td style="border:1px solid black; text-align:center;"><br></td>
                <td style="border:1px solid black; text-align:center;"><br></td>
                <td style="border:1px solid black; text-align:center;"><br></td>
            </tr>
        @endif
        
        <tr>
            <td colspan="8" style="padding-left: 8px; padding-top: 10px;"><b>Dokter Pengirim</b></td>
        </tr>
        <tr>
            <td style="padding-left: 8px;">Nama</td>
            <td colspan="2">: <strong>{{ $formData->dokter_nama ?? '-' }}</strong></td>
            <td style="width:1%;"></td>
            <td>Telp. HP</td>
            <td colspan="3">: <strong>{{ $formData->dokter_telp ?? '-' }}</strong></td>
        </tr>
        <tr>
            <td style="padding-left: 8px;">Sign :</td>
            <td colspan="2" style="padding-top: 12px"> 
                @if($formData->ttd_dokter)
                    <img src="{{ $formData->ttd_dokter }}" style="height: 40px;" />
                @else
                    -
                @endif
            </td>
            <td></td>
            <td>Tanggal</td>
            <td colspan="3">: <strong>{{ $formData->dokter_tanggal ? \Carbon\Carbon::parse($formData->dokter_tanggal)->format('d/m/Y') : '-' }}</strong></td>
        </tr>
        <tr>
            <td colspan="8" style="padding-top:2%; padding-left: 8px;"><b>Pertimbangkan:</b></td>
        </tr>
        <tr>
            <td colspan="8" style="padding-left: 8px;">Indikasi transfusi darah jika Hb < 7 gr/dl</td>
        </tr>
        <tr>
            <td colspan="8" style="padding-left: 8px;">Akhir transfusi cukup sampai Hb ± 10 gr/dl</td>
        </tr>
    </table>
</div>
</body>
</html>