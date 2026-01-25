<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>VOUCHER RAWAT INAP - CATATAN KUNJUNGAN DOKTER</title>
    <style>
    @page { margin: 18px; }
    body { margin: 18px; font-family: Arial, sans-serif; }
    
    .wrap {
        width: 100%;
        height: auto;
        display: inline-block;
    }

    .left { display: inline-block; float: left; }
    .right { display: inline-block; float: right; margin-right: 65px;}

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
        padding: 5px;
    }

    .text-above {
        text-align: center;   
        margin-bottom: 5px;  
    }
    
    .signature-box {
        width: 100%;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .signature-box img {
        max-width: 100%;
        max-height: 100%;
    }
    </style>
</head>
<body>
    {{-- HALAMAN 1: CATATAN KUNJUNGAN DOKTER --}}
    <div style="position:fixed; right: 13px; bottom: 10px;"></div>
    <?php $fullpath = storage_path('app/public/images/header_rme4.png');  ?>  
    
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">RM 9.10/SPPU/22</div>
    </div>
        @include('print-rekam-medis.partials.header5')
    
    {{-- INFO DOKTER --}}
    <table style="width:100%; border-collapse: collapse; border: 1px solid black;">
        <tr>
            <td style="width:35%; padding-left: 5px;">Nama Dokter : {{ $voucher->nama_dokter ?? '...................................' }}</td>
            <td style="width:35%;">Admission Date : {{ $voucher->admission_date ? \Carbon\Carbon::parse($voucher->admission_date)->format('d-m-Y') : '.................................' }}</td>
            <td style="width:30%;"> Discharge Date : {{ $voucher->discharge_date ? \Carbon\Carbon::parse($voucher->discharge_date)->format('d-m-Y') : '..........................' }}</td>
        </tr>
    </table>
    <br>
    
{{-- TABEL KUNJUNGAN --}}
<table style="width:100%; border-collapse: collapse; border: 1px solid black; margin-top: 5px; text-align: center;">
    <tr>
        <td class="tablee" style="width:15%;"><strong>HARI</strong></td>
        <td class="tablee" style="width:25%;"><strong>TANGGAL-JAM</strong></td>
        <td class="tablee" style="width:30%;"><strong>PARAF DOKTER</strong></td>
        <td class="tablee" style="width:30%;"><strong>PARAF PERAWAT</strong></td>
    </tr>
    
    {{-- ROW 1 --}}
    <tr>
        <td class="tablee">{{ $voucher->row1_hari ?? '' }}</td>
        <td class="tablee">{{ $voucher->row1_tanggal_jam ? \Carbon\Carbon::parse($voucher->row1_tanggal_jam)->format('d-m-Y H:i') : '' }}</td>
        <td class="tablee">
            @if($voucher->row1_paraf_dokter)
                <img src="{{ $voucher->row1_paraf_dokter }}" style="max-width: 100px; max-height: 50px;">
                <br><small>{{ $voucher->row1_nama_dokter ?? '' }}</small>
            @endif
        </td>
        <td class="tablee">
            @if($voucher->row1_paraf_perawat)
                <img src="{{ $voucher->row1_paraf_perawat }}" style="max-width: 100px; max-height: 50px;">
                <br><small>{{ $voucher->row1_nama_perawat ?? '' }}</small>
            @endif
        </td>
    </tr>
    
    {{-- ROW 2 --}}
    <tr>
        <td class="tablee">{{ $voucher->row2_hari ?? '' }}</td>
        <td class="tablee">{{ $voucher->row2_tanggal_jam ? \Carbon\Carbon::parse($voucher->row2_tanggal_jam)->format('d-m-Y H:i') : '' }}</td>
        <td class="tablee">
            @if($voucher->row2_paraf_dokter)
                <img src="{{ $voucher->row2_paraf_dokter }}" style="max-width: 100px; max-height: 50px;">
                <br><small>{{ $voucher->row2_nama_dokter ?? '' }}</small>
            @endif
        </td>
        <td class="tablee">
            @if($voucher->row2_paraf_perawat)
                <img src="{{ $voucher->row2_paraf_perawat }}" style="max-width: 100px; max-height: 50px;">
                <br><small>{{ $voucher->row2_nama_perawat ?? '' }}</small>
            @endif
        </td>
    </tr>
    
    {{-- ROW 3 --}}
    <tr>
        <td class="tablee">{{ $voucher->row3_hari ?? '' }}</td>
        <td class="tablee">{{ $voucher->row3_tanggal_jam ? \Carbon\Carbon::parse($voucher->row3_tanggal_jam)->format('d-m-Y H:i') : '' }}</td>
        <td class="tablee">
            @if($voucher->row3_paraf_dokter)
                <img src="{{ $voucher->row3_paraf_dokter }}" style="max-width: 100px; max-height: 50px;">
                <br><small>{{ $voucher->row3_nama_dokter ?? '' }}</small>
            @endif
        </td>
        <td class="tablee">
            @if($voucher->row3_paraf_perawat)
                <img src="{{ $voucher->row3_paraf_perawat }}" style="max-width: 100px; max-height: 50px;">
                <br><small>{{ $voucher->row3_nama_perawat ?? '' }}</small>
            @endif
        </td>
    </tr>
    
    {{-- ROW 4 --}}
    <tr>
        <td class="tablee">{{ $voucher->row4_hari ?? '' }}</td>
        <td class="tablee">{{ $voucher->row4_tanggal_jam ? \Carbon\Carbon::parse($voucher->row4_tanggal_jam)->format('d-m-Y H:i') : '' }}</td>
        <td class="tablee">
            @if($voucher->row4_paraf_dokter)
                <img src="{{ $voucher->row4_paraf_dokter }}" style="max-width: 100px; max-height: 50px;">
                <br><small>{{ $voucher->row4_nama_dokter ?? '' }}</small>
            @endif
        </td>
        <td class="tablee">
            @if($voucher->row4_paraf_perawat)
                <img src="{{ $voucher->row4_paraf_perawat }}" style="max-width: 100px; max-height: 50px;">
                <br><small>{{ $voucher->row4_nama_perawat ?? '' }}</small>
            @endif
        </td>
    </tr>
    
    {{-- ROW 5 --}}
    <tr>
        <td class="tablee">{{ $voucher->row5_hari ?? '' }}</td>
        <td class="tablee">{{ $voucher->row5_tanggal_jam ? \Carbon\Carbon::parse($voucher->row5_tanggal_jam)->format('d-m-Y H:i') : '' }}</td>
        <td class="tablee">
            @if($voucher->row5_paraf_dokter)
                <img src="{{ $voucher->row5_paraf_dokter }}" style="max-width: 100px; max-height: 50px;">
                <br><small>{{ $voucher->row5_nama_dokter ?? '' }}</small>
            @endif
        </td>
        <td class="tablee">
            @if($voucher->row5_paraf_perawat)
                <img src="{{ $voucher->row5_paraf_perawat }}" style="max-width: 100px; max-height: 50px;">
                <br><small>{{ $voucher->row5_nama_perawat ?? '' }}</small>
            @endif
        </td>
    </tr>
    
    {{-- ROW 6 --}}
    <tr>
        <td class="tablee">{{ $voucher->row6_hari ?? '' }}</td>
        <td class="tablee">{{ $voucher->row6_tanggal_jam ? \Carbon\Carbon::parse($voucher->row6_tanggal_jam)->format('d-m-Y H:i') : '' }}</td>
        <td class="tablee">
            @if($voucher->row6_paraf_dokter)
                <img src="{{ $voucher->row6_paraf_dokter }}" style="max-width: 100px; max-height: 50px;">
                <br><small>{{ $voucher->row6_nama_dokter ?? '' }}</small>
            @endif
        </td>
        <td class="tablee">
            @if($voucher->row6_paraf_perawat)
                <img src="{{ $voucher->row6_paraf_perawat }}" style="max-width: 100px; max-height: 50px;">
                <br><small>{{ $voucher->row6_nama_perawat ?? '' }}</small>
            @endif
        </td>
    </tr>
    
    <tr>
        <td colspan="4" style="font-style: italic; font-weight: bold; font-size: 12px; text-align: center; padding: 4px;">
            FORMULIR INI HANYA UNTUK SATU DOKTER. HARAP GUNAKAN FORMULIR LAIN UNTUK DOKTER YANG BERBEDA
        </td>        
    </tr>
</table>
    
    {{-- PAGE BREAK --}}
    <div style="page-break-after: always;"></div>
    
    {{-- HALAMAN 2: VOUCHER HONOR PROFESI --}}
    <div style="position:fixed; right: 13px; bottom: 10px;"></div>
    <?php $fullpath = storage_path('app/public/images/header_rme4.png');  ?>  
    
    <div class="wrap">
        @include('print-rekam-medis.partials.header6')
    </div>
    
    <table style="width:100%; border-collapse: collapse; border: 1px solid black; text-align: left;">
        {{-- PERAWATAN VISITE --}}
        <tr>
            <td colspan="2" style="padding: 5px;">Perawatan-Visite (Kunjungan)</td>
            <td colspan="2" style="padding: 5px;">: Rp. {{ $voucher->perawatan_visite ?? '...................' }}/Hari</td>
        </tr>
        
        {{-- JENIS TARIF OPERASI --}}
        <tr>
            <td colspan="2" style="padding: 5px;">Jenis Tarif Operasi</td>
            <td colspan="2" style="padding: 5px;">
                <table>
                    <tr>
                        <td>: Pribadi</td>
                        <td><input type="checkbox" {{ $voucher->tarif_pribadi == '1' ? 'checked' : '' }}></td>
                        <td>Rumah Sakit</td>
                        <td><input type="checkbox" {{ $voucher->tarif_rumah_sakit == '1' ? 'checked' : '' }}></td>
                        <td>Perusahaan</td>
                        <td><input type="checkbox" {{ $voucher->tarif_perusahaan == '1' ? 'checked' : '' }}></td>
                        <td>Staff RSKMPV</td>
                        <td><input type="checkbox" {{ $voucher->tarif_staff == '1' ? 'checked' : '' }}></td>
                    </tr>
                </table>
            </td>
        </tr>
        
        {{-- OPERASI --}}
        <tr>
            <td colspan="4" style="padding: 5px;">
                <table style="width:100%;">
                    <tr>
                        <td style="width:10%;">Operasi</td>
                        <td style="width:30%;">- Besar</td>
                        <td style="width:60%;">: Rp. {{ $voucher->operasi_besar ?? '...................' }}</td>
                    </tr>
                    <tr>
                        <td><br></td>
                        <td>- Sedang</td>
                        <td>: Rp. {{ $voucher->operasi_sedang ?? '...................' }}</td>
                    </tr>
                    <tr>
                        <td><br></td>
                        <td>- Kecil</td>
                        <td>: Rp. {{ $voucher->operasi_kecil ?? '...................' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        
        {{-- ANASTHESI --}}
        <tr>
            <td colspan="2" style="padding: 5px;">Anasthesi</td>
            <td colspan="2" style="padding: 5px;">: {{ $voucher->anasthesi ?? '..............................' }}</td>
        </tr>
        
        {{-- DOKTER KONSULTAN --}}
        <tr style="border-bottom: 1px solid black;">
            <td colspan="2" style="padding: 5px;">Dokter Konsultan</td>
            <td colspan="2" style="padding: 5px;">: {{ $voucher->dokter_konsultan ?? '..............................' }}</td>
        </tr>
        
        {{-- PARTUS --}}
        <tr>
            <td colspan="4" style="padding: 5px;">
                <table style="width:100%;">
                    <tr>
                        <td style="width:10%;">Partus</td>
                        <td style="width:30%;">- Biasa/Normal</td>
                        <td style="width:60%;">: Rp. {{ $voucher->partus_normal ?? '...................' }}</td>
                    </tr>
                    <tr>
                        <td style="width:10%;"><br></td>
                        <td style="width:30%;">- Vacuum, Biopsy</td>
                        <td style="width:60%;">: Rp. {{ $voucher->partus_vacuum ?? '...................' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        
        {{-- DATE & TIME --}}
        <tr>
            <td class="tablee" style="padding: 5px;">Date : {{ $voucher->date_voucher ? \Carbon\Carbon::parse($voucher->date_voucher)->format('d-m-Y') : '' }}</td>
            <td class="tablee" style="padding: 5px;">Time : {{ $voucher->time_voucher ?? '' }}</td>
            <td class="tablee" style="padding: 5px;">Dibuat Oleh :</td>
            <td class="tablee" style="padding: 5px;">(Tanda Tangan & Nama Jelas)</td>
        </tr>
        
        {{-- SIGNATURE ROW --}}
        <tr>
            <td class="tablee" style="padding: 5px; height: 120px; vertical-align: top;"></td>
            <td class="tablee" style="padding: 5px; height: 120px; vertical-align: top;"></td>
            <td class="tablee" style="padding: 5px; height: 120px; vertical-align: top;">
                <div style="text-align: center;">
                    <div>Kepala Keperawatan</div>
                    @if($voucher->ttd_dibuat_oleh)
                        <div class="signature-box">
                            <img src="{{ $voucher->ttd_dibuat_oleh }}" alt="TTD Dibuat Oleh">
                        </div>
                    @endif
                    <div style="margin-top: 5px;"><strong>{{ $voucher->dibuat_oleh ?? '' }}</strong></div>
                </div>
            </td>
            <td class="tablee" style="padding: 5px; height: 120px; vertical-align: top;">
                <div style="text-align: center;">
                    <div>Dr. {{ $voucher->nama_dokter_voucher ?? '................' }}</div>
                    @if($voucher->ttd_dokter)
                        <div class="signature-box">
                            <img src="{{ $voucher->ttd_dokter }}" alt="TTD Dokter">
                        </div>
                    @endif
                </div>
            </td>
        </tr>
        
        {{-- FOOTER NOTE --}}
        <tr>
            <td colspan="4" style="text-align: center; font-size: 12px; padding: 5px;">
                JIKA DOKTER MEMBERITAHUKAN HONORNYA MELALUI TELEPON ATAUPUN SECARA LISAN, MOHON KEPADA STAFF 
                YANG MENERIMANYA MENJELASKAN NAMA DAN TANDA TANGAN DI FORM INI UNTUK MEWAKILI DOKTER.
            </td>
        </tr>
    </table>
</body>
</html>