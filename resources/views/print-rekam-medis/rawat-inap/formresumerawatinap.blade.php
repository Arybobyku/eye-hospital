<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>REKAM MEDIS GENERAL - Resume Medis</title>
    <style>
    @page { margin: 18px; }
    body { margin: 18px; }
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
    padding: 5px;
  }

  .page_break {
      page-break-before: always;
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
    {{ $data->no_surat ?? 'RM 3.5/RM/' . config('app.tahun_akreditasi', '22') }}
	</div>
	@include('print-rekam-medis.partials.header')
<table style="width: 100%; border: 1px solid black; border-collapse: collapse;">
    <tr>
        <td style="font-weight: bold; text-align: center; padding: 7px;">
            RESUME MEDIS
        </td>
    </tr>
</table>
      <table style="width: 100%;  border-collapse:collapse; table-layout:fixed; border: 1px solid black; cellpadding="0" cellspacing="0"  >
        <colgroup>
          <col style="width:30%;">
          <col style="width:50%;">
          <col style="width:20%;">
        </colgroup>
      <tr>
        <td class="tablee" colspan="2">Tanggal Masuk : {{ $data->tanggal_masuk ? \Carbon\Carbon::parse($data->tanggal_masuk)->format('d/m/Y') : '' }}</td>
        <td class="tablee">Tanggal Keluar / Tanggal Meninggal : {{ $data->tanggal_keluar ? \Carbon\Carbon::parse($data->tanggal_keluar)->format('d/m/Y') : '' }}</td>
      </tr>
      <tr>
        <td class="tablee" colspan="2">Ruang Rawat terakhir : {{ $data->ruang_rawat ?? '' }}</td>
        <td class="tablee">Penanggung Pembayaran : {{ $data->penanggung_pembayaran ?? '' }}</td>

      </tr>
      <tr>
        <td colspan="3" class="tablee"> Dokter Penanggung Jawab (DPJP)  : dr {{ $data->dpjp ?? '………………………………………………………' }} </td>
      </tr>
      <tr>
        <td colspan="3" class="tablee">
            <table>
                <tr>
                    <td>Rawat Tim Dokter :</td>
                    <td><input type="checkbox" {{ $data->rawat_tim == 'tidak' ? 'checked' : '' }}></td>
                    <td>Tidak</td>                    
                    <td><input type="checkbox" {{ $data->rawat_tim == 'ya' ? 'checked' : '' }}></td>
                    <td>Ya, Oleh</td>
                    <td>1. dr{{ $data->tim_dokter_1 ?? '..................................' }}</td>
                    <td>3. dr{{ $data->tim_dokter_3 ?? '..................................' }}</td>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td>2. dr{{ $data->tim_dokter_2 ?? '..................................' }}</td>
                    <td>4. dr{{ $data->tim_dokter_4 ?? '..................................' }}</td>
                </tr>
            </table>
        </td>
      </tr>
      <tr >
        <td colspan="3" class="tablee">Alasan Dirawat : {{ $data->alasan_dirawat ?? '' }}</td>
      </tr>
      <tr>
        <td colspan="3" class="tablee">Didiagnosa Masuk : {{ $data->diagnosa_masuk ?? '' }}</td>
      </tr>
      <tr>
        <td class="tablee">Didiagnosa Keluar (Diagnosa Utama) </td>
        <td class="tablee">{{ $data->diagnosa_keluar ?? '' }}</td>
        <td class="tablee">ICD: {{ $data->icd_utama ?? '' }}</td>
      </tr>
      <tr>
        <td class="tablee">Diagnosis Sekunder</td>
        <td class="tablee">1. {{ $data->diagnosa_sekunder_1 ?? '................................................' }}</td>
        <td class="tablee"></td>
      </tr>
      <tr>
        <td class="tablee"></td>
        <td class="tablee">2. {{ $data->diagnosa_sekunder_2 ?? '................................................' }}</td>
        <td class="tablee"></td>
      </tr>
      <tr>
        <td class="tablee"></td>
        <td class="tablee">3. {{ $data->diagnosa_sekunder_3 ?? '................................................' }}</td>
        <td class="tablee"></td>
      </tr>
      <tr>
        <td class="tablee"></td>
        <td class="tablee">4. {{ $data->diagnosa_sekunder_4 ?? '................................................' }}</td>
        <td class="tablee"></td>
      </tr>
      <tr>
        <td class="tablee">Penyebab Kematian (Secara Klinis) </td>
        <td class="tablee" colspan="2">{{ $data->penyebab_kematian ?? '' }}</td>
      </tr>
      <tr >
        <td class="tablee">Pemeriksaan Fisik Yang penting </td>
        <td class="tablee" colspan="2">{{ $data->pemeriksaan_fisik ?? '' }}</td>
      </tr>
      <tr >
        <td class="tablee">Laboratorium Yang Penting </td>
        <td class="tablee" colspan="2">{{ $data->laboratorium ?? '' }}</td>
      </tr>
      </table>             
      <div class="page_break"></div>
        <div style="width:100%; text-align:right; margin-bottom:5px">
		       RM 3.5/RM/22
	      </div>
      <table style="width: 100%;  border-collapse:collapse; table-layout:fixed; border: 1px solid black; cellpadding="0" cellspacing="0"  >
        <colgroup>
          <col style="width:30%;">
          <col style="width:40%;">
          <col style="width:30%;">
        </colgroup>
      <tr >
        <td class="tablee" colspan="2">Radiologi </td>
        <td class="tablee">{{ $data->radiologi ?? '' }}</td>
      </tr>
      <tr>
        <td class="tablee" colspan="2">Penunjang Lain</td>
        <td class="tablee">{{ $data->penunjang_lain ?? '' }}</td>
      </tr>
      <tr>
        <td class="tablee">Tindakan / Operasi</td>
        <td class="tablee">{{ $data->tindakan_operasi ?? '' }}</td>
        <td class="tablee">ICD: {{ $data->icd_tindakan ?? '' }}</td>
      </tr>
      <tr>
        <td class="tablee" colspan="2">Pengobatan Selama Dirawat</td>
        <td class="tablee">{{ $data->pengobatan ?? '' }}</td>
      </tr>
      <tr>
        <td class="tablee" colspan="2">
            <table>
                <tr>
                    <td colspan="2">Kondisi Pulang </td>
                </tr>
                <tr>
                    <td><input type="checkbox" {{ $data->kondisi_sembuh ? 'checked' : '' }}></td>
                    <td>Sembuh</td>
                </tr>
                <tr>
                    <td><input type="checkbox" {{ $data->kondisi_pindah_rs ? 'checked' : '' }}></td>
                    <td>Pindah RS </td>
                </tr>
                <tr>
                    <td><input type="checkbox" {{ $data->kondisi_pulang_sendiri ? 'checked' : '' }}></td>
                    <td>Pulang atas Permintaan Sendiri</td>
                </tr>
                <tr>
                    <td><input type="checkbox" {{ $data->kondisi_meninggal ? 'checked' : '' }}></td>
                    <td>Meninggal</td>
                </tr>
                <tr>
                    <td><input type="checkbox" {{ $data->kondisi_lainnya ? 'checked' : '' }}></td>
                    <td>Lain-Lain </td>
                </tr>
            </table>
        </td>
        <td >
            <table style="width: 100%;" cellpadding="0" cellspacing="0">
                <tr >
                    <td style="border-bottom: 1px solid #000;">Instruksi dan Edukasi Lanjutan (follow up)</td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid #000;">Kontrol Tanggal  : {{ $data->kontrol_tanggal ? \Carbon\Carbon::parse($data->kontrol_tanggal)->format('d/m/Y') : '' }}</td>
                </tr>
                <tr>    
                    <td style="border-bottom: 1px solid #000;">Diet   : {{ $data->diet ?? '' }}</td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid #000;">Latihan   : {{ $data->latihan ?? '' }}</td>
                </tr>
                <tr>
                    <td>Segera kembali ke rumah Sakit, langsung ke Gawat Darurat, bila terjadi : {{ $data->kondisi_darurat ?? '' }}</td>
                </tr>
            </table>
        </td>
      </tr>
      <tr>
    <td colspan="3" class="tablee" style="font-weight:bold">Terapi Pulang</td>
      </tr>
      <tr>
        <td colspan="3">
            <Table style="width: 100%;"   cellpadding="0" cellspacing="0">
                <tr style="border-bottom: ">
                    <td style="border-right: 1px solid #000; border-bottom: 1px solid #000;  text-align: center;">Nama Obat </td>
                    <td style="border-right: 1px solid #000; border-bottom: 1px solid #000; text-align: center;">Jumlah</td>
                    <td style="border-right: 1px solid #000; border-bottom: 1px solid #000; text-align: center;">Dosis</td>
                    <td style="border-right: 1px solid #000; border-bottom: 1px solid #000; text-align: center;">Frekuensi</td>
                    <td style="border-right: 1px solid #000; border-bottom: 1px solid #000; text-align: center;">Cara Pemberian</td>
                    <td style="border-right: 1px solid #000; border-bottom: 1px solid #000; text-align: center;">Nama Obat</td>
                    <td style="border-right: 1px solid #000; border-bottom: 1px solid #000; text-align: center;">Jumlah</td>
                    <td style="border-right: 1px solid #000; border-bottom: 1px solid #000; text-align: center;">Dosis</td>
                    <td style="border-right: 1px solid #000; border-bottom: 1px solid #000; text-align: center;">Frekuensi</td>
                    <td style=" text-align: center; border-bottom: 1px solid #000;">Cara Pemberian</td>
                </tr>
                @php
                    $terapi = is_array($data->terapi_pulang) ? $data->terapi_pulang : [];
                    $rows = max(1, ceil(count($terapi) / 2)); // Minimal 1 baris, dibagi 2 kolom
                @endphp
                
                @for($i = 0; $i < $rows; $i++)
                    @php
                        $obat1 = $terapi[$i * 2] ?? null;
                        $obat2 = $terapi[$i * 2 + 1] ?? null;
                    @endphp
                    <tr style="border-bottom: 1px solid #000;">
                        <td style="border-right: 1px solid #000; padding: 5px;">{{ $obat1['nama_obat'] ?? '' }}</td>
                        <td style="border-right: 1px solid #000; padding: 5px;">{{ $obat1['jumlah'] ?? '' }}</td>
                        <td style="border-right: 1px solid #000; padding: 5px;">{{ $obat1['dosis'] ?? '' }}</td>
                        <td style="border-right: 1px solid #000; padding: 5px;">{{ $obat1['frekuensi'] ?? '' }}</td>
                        <td style="border-right: 1px solid #000; padding: 5px;">{{ $obat1['cara_pemberian'] ?? '' }}</td>
                        <td style="border-right: 1px solid #000; padding: 5px;">{{ $obat2['nama_obat'] ?? '' }}</td>
                        <td style="border-right: 1px solid #000; padding: 5px;">{{ $obat2['jumlah'] ?? '' }}</td>
                        <td style="border-right: 1px solid #000; padding: 5px;">{{ $obat2['dosis'] ?? '' }}</td>
                        <td style="border-right: 1px solid #000; padding: 5px;">{{ $obat2['frekuensi'] ?? '' }}</td>
                        <td style="padding: 5px;">{{ $obat2['cara_pemberian'] ?? '' }}</td>
                    </tr>
                @endfor
            </Table>
        </td>
      </tr>
      <tr>
        <td colspan="3">Tanggal {{ now()->format('d/m/Y') }}</td>
      </tr>
      <tr>
        <td colspan="3" style="text-align: center;">Yang membuat <br>
            @if($data->dokter_ttd)
                <img src="{{ $data->dokter_ttd }}" style="max-width: 150px; max-height: 80px; margin: 10px 0;" alt="TTD">
            @else
                <br><br><br>
            @endif
        </td> 
      </tr>    
      <tr>
        <td colspan="3" style="text-align: center;">{{ $data->nama_dokter ?? '………………………………………………….' }}</td>
      </tr>
      <tr>
        <td colspan="3" style="text-align: center; ">Nama Jelas dan Tandatangan </td>
      </tr>
    </table>
    <div  style="text-align: right;">Page 2 to 2</div>
    <div><i>1. Lembar Asli Untuk arsip rekam Medis</i> </div>
    <div><i>2. Lembar Kedua Untuk Pasien</i> </div>
    <div><i>3. Lembar Ketiga Untuk Penjamin </i></div>
</div>
</body>
</html>