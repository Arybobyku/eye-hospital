<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM2.0</title>
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

        .tablee2dot0 {
            border: 1px solid black;
            border-collapse: collapse;
            border-top:0.5px solid;
            border-bottom:0.5px solid;
        }

        .td12dot0 {
            border: 1px solid black;
            border-collapse: collapse;
            width: 50%;
        }
        .td12dot0x {
            border-top: 1px solid black;
            border-collapse: collapse;
            width: 50%;
        }

        .td22dot0 {
            border: 1px solid black;
            border-collapse: collapse;
            width: 50%;
        }
        .td12dot0y {
            border-left: 1px solid black;
            border-top: 1px solid black;
            border-collapse: collapse;
            width: 50%;
        }

        .signature-section {
            width: 10%;
            margin-top: 30px;
        }
        .signature-section table {
            width: 10%;
            border-collapse: collapse;
        }
        .signature-box {
            text-align: center;
            vertical-align: top;
            width: 10%;
            padding: 10px;
        }
        .signature-image {
            max-width: 100px;
            max-height: 80px;
            margin: 10px auto;
            display: block;
        }
        .signature-name {
            margin-top: 10px;
            font-size: 11pt;
        }
        .signature-label {
            font-size: 10pt;
            margin-top: 5px;
            color: #666;
        }

    </style>
   
        
<body>
    <div style="position:fixed; right: 13px; bottom: 10px;"></div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 2.0/CKB/22
        </div>
        @include('print-rekam-medis.partials.header')
    </div>
    <table class="tablee2dot0" style="width: 100%;">
        <tr>
            <td style="text-align: center" colspan="4"><b>CHECKLIST KESIAPAN BEDAH</b></td>
        </tr>
        <tr>
            <td class="td12dot0x">Ruang</td>
            <td class="td12dot0x">: {{$ckb->nama_ruang ?? ''}}</td>
            <td class="td12dot0y">Kamar</td>
            <td class="td12dot0x">: {{  $ckb->nama_kamar ?? ''  }}</td>

        </tr>
        <tr class="tablee2dot0">
            <td class="td12dot0x">Diagnosis</td>
            <td class="td12dot0x">: {{  $ckb->diagnosa ?? ''}}</td>
            <td class="td12dot0y">Tindakan</td>
            <td class="td12dot0x">: {{  $ckb->tindakan ?? '' }}</td>
        </tr>
        <tr class="tablee2dot0">
            <td class="td12dot0x">Tehknik anastesi</td>
            <td class="td12dot0x">: {{ $ckb->teknik_anastesi ?? ''  }}</td>
            <td class="td12dot0y">Tgl. Tindakan</td>
            <td class="td12dot0x">: {{ $ckb->tanggal_tindakan ?? '' }}</td>
        </tr>
    </table>
        <table  style="width: 100%; border:1px solid; border-top:0.5px">
        <tr>
            <td style="padding-top: 3px; padding-left: 15px;" colspan="2"><b>listrik</b></td>
        </tr>        
        <tr>            
            <td style="padding-left: 15px;"><input type="checkbox" {{ $ckb->check_phaco?'checked': '' }}></td>
            <td>Mesin Phaco terhubung dengan sumber listrik, indikator (+)</td>   
        </tr>
        <tr>            
            <td style="padding-left: 15px;" style="padding-left: 15px;"> <input type="checkbox" {{ $ckb->check_anestesi?'checked': ''  }}></td>
            <td>Mesin anestesi terhubung dengan sumber listrik, indikator (+)</td>   
        </tr>
        <tr>            
            <td style="padding-left: 15px;" style="padding-left: 15px;"><input type="checkbox" {{ $ckb->check_light_source?'checked': ''  }}></td>
            <td>Light source, monitor Mata terhubung dengan sumber listrik, indicator (+)</td>   
        </tr>
        <tr>            
            <td style="padding-left: 15px;" style="padding-left: 15px;"><input type="checkbox" {{ $ckb->check_ext_kabel?'checked': ''  }}></td>
            <td>Extension kabel,terhubung dengan sumber listrik, indicator (+)</td>   
        </tr>
        <tr>            
            <td style="padding-left: 15px;" style="padding-left: 15px;"><input type="checkbox" {{ $ckb->check_meja_operasi?'checked': ''  }}></td>
            <td>Meja operasi terhubung dengan sumber listrik, indicator (+)</td>   
        </tr>
        <tr>            
            <td style="padding-left: 15px;" style="padding-left: 15px;"><input type="checkbox" {{ $ckb->check_mikroskop?'checked': ''  }}></td>
            <td>Microskop terhubung dengan sumber listrik, indicator (+)</td>   
        </tr>
        <tr>            
            <td style="padding-left: 15px;" style="padding-left: 15px;"><input type="checkbox" {{ $ckb->check_lampu_ok?'checked': ''  }}></td>
            <td>Lampu kamar operasi menyala</td>   
        </tr>
        <tr>            
            <td style="padding-left: 15px;" style="padding-left: 15px;"><input type="checkbox" {{ $ckb->check_ac_ok?'checked': ''  }}></td>
            <td>AC berfungsi dengan baik</td>   
        </tr>
        <tr>            
            <td style="padding-left: 15px;" style="padding-left: 15px;"><input type="checkbox" {{ $ckb->check_gas_medis?'checked': ''  }}></td>
            <td>Gas medis terhubung dengan mesin, indicator (+)</td>   
        </tr>
        <tr>
            <td style="padding-top: 10px; padding-left: 15px;" colspan="2"><b>Alat</b></td>
        </tr>        
        <tr>            
            <td style="padding-left: 15px;"><input type="checkbox" {{ $ckb->check_cassette?'checked': ''  }}></td>
            <td>Casette, selang, Diatermi dan konektor Mesin Phaco sudah tersedia</td>   
        </tr>
        <tr>            
            <td style="padding-left: 15px;"><input type="checkbox" {{ $ckb->check_patient_plate?'checked': ''  }}></td>
            <td>Patient plate sudah tersedia</td>   
        </tr>
        <tr>            
            <td style="padding-left: 15px;"><input type="checkbox"  {{ $ckb->check_instrumen?'checked': ''  }}></td>
            <td>Insument steril sesuai kebutuhan sudah tersedia </td>   
        </tr>
        <tr>            
            <td style="padding-left: 15px;"><input type="checkbox" {{ $ckb->check_handle_mikro?'checked': ''  }}></td>
            <td>Handle Microskop steril</td>   
        </tr>
        <tr>            
            <td style="padding-left: 15px;"><input type="checkbox" {{ $ckb->check_kom_kidney?'checked': ''  }}></td>
            <td>Kom kidney steril sudah tersedia</td>   
        </tr>
        <tr>
            <td style="padding-top: 10px; padding-left: 15px;" colspan="2"><b>Linen Steril</b></td>
        </tr>        
        <tr>            
            <td style="padding-left: 15px;"><input type="checkbox" {{ $ckb->check_jas_steril?'checked': ''  }}></td>
            <td>Jas steril</td>   
        </tr>
        <tr>            
            <td style="padding-left: 15px;"><input type="checkbox" {{ $ckb->check_duk?'checked': ''  }}></td>
            <td>Duk Steril</td>   
        </tr>
        <tr>            
            <td style="padding-left: 15px;"><input type="checkbox" {{ $ckb->check_linen?'checked': ''  }}></td>
            <td>Linen meja instrumen</td>   
        </tr>
        <tr>            
            <td style="padding-left: 15px;"><input type="checkbox" {{ $ckb->check_kasa?'checked': ''  }}></td>
            <td>Kasa</td>   
        </tr>   
        <tr>
            <td style="padding-top: 10px; padding-left: 15px;"colspan="2"><b>AKHP</b></td>
        </tr>        
        <tr>            
            <td style="padding-left: 15px;"><input type="checkbox" {{ $ckb->check_akhp?'checked': ''  }}></td>
            <td >Tersedia AKHP sesuai kebutuhan </td>   
        </tr>
        <tr>
            <td colspan="2 ">
                <table style="width: 100%;" border="0">
                    <tr>
                        <td class="signature-box">
                            <div style="font-weight: bold; margin-bottom: 10px;">Perawat Kamar Bedah</div>
                            @if(!empty($ckb->ttd_perawat))
                                <img src="{{ $ckb->ttd_perawat }}" class="signature-image" alt="TTD Perawat">
                            @else
                                <div style="height: 100px;"></div>
                            @endif
                            <div class="signature-name">
                                ( <u>{{ $ckb->nama_lengkap_perawat?? '..................................' }}</u> )
                            </div>
                        </td>
                        <td class="signature-box">
                            <div style="font-weight: bold; margin-bottom: 10px;">Kepala Ruangan</div>
                            @if(!empty($ckb->ttd_kepala))
                                <img src="{{$ckb->ttd_kepala }}" class="signature-image" alt="TTD Kepala Ruangan">
                            @else
                                <div style="height: 100px;"></div>
                            @endif
                            <div class="signature-name">
                                ( <u>{{ $ckb->nama_lengkap_kepala_ruangan ?? '..................................' }}</u> )
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    </table>
</body>

</head>