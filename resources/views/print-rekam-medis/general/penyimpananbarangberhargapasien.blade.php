<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>REKAM MEDIS GENERAL - FORMULIR PENYIMPANAN BARANG BERHARGA MILIK PASIEN</title>
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
    text-align: center;
    padding: 5px;
  }
   .text-above {
    text-align: center;   
    margin-bottom: 5px;  
  }
  .info-row {
    padding: 5px;
    border-bottom: 1px solid #ddd;
  }
  .signature-section {
    margin-top: 20px;
    padding: 10px;
  }
    </style>
    
</head>
<body>
<div style="position:fixed; right: 13px; bottom: 10px;">
</div>
<?php $fullpath = storage_path('app/public/images/header_rme.png');  ?>  
<div class="wrap">
  <div style="width:100%; text-align:right; margin-bottom:5px">
    {{ $data->no_surat ?? 'RM 7.2/FPBBMP/' . config('app.tahun_akreditasi', '22') }}
  </div>
  @include('print-rekam-medis.partials.header')

<table style="width: 100%; border: 1px solid black; border-collapse: collapse;">
    <tr>
        <td style="font-weight: bold; text-align: center; padding: 7px;">
            FORMULIR PENYIMPANAN BARANG BERHARGA MILIK PASIEN
        </td>
    </tr>
</table>

<!-- Nama Petugas Penerima -->
<table style="width: 100%; border: 1px solid black; border-collapse: collapse; margin-top: 10px;">
  <tr>
    <td style="padding: 8px;">
      <strong>Nama petugas penerima barang:</strong> {{ $data->nama_petugas ?? '' }}
    </td>
  </tr>
</table>

<!-- Tabel Barang Berharga -->
@php
  $rows = $data->barang_rows ?? [];
  if (is_string($rows)) {
    $rows = json_decode($rows, true) ?? [];
  }
@endphp

<table style="width: 100%; border: 1px solid black; border-collapse: collapse; margin-top: 10px;">
  <thead>
    <tr>
      <td class="tablee" rowspan="2" style="width: 5%; font-weight: bold;">NO</td>
      <td class="tablee" rowspan="2" style="width: 25%; font-weight: bold;">Jenis harta benda</td>
      <td class="tablee" rowspan="2" style="width: 10%; font-weight: bold;">Jumlah</td>
      <td class="tablee" colspan="2" style="width: 20%; font-weight: bold;">Kondisi barang</td>
      <td class="tablee" rowspan="2" style="width: 20%; font-weight: bold;">Saat dititipkan<br>tanggal</td>
      <td class="tablee" rowspan="2" style="width: 20%; font-weight: bold;">Saat diserahkan<br>tanggal</td>
    </tr>
    <tr>
      <td class="tablee" style="width: 10%; font-weight: bold;">Baik</td>
      <td class="tablee" style="width: 10%; font-weight: bold;">Buruk</td>
    </tr>
  </thead>
  <tbody>
    @forelse ($rows as $index => $row)
      <tr>
        <td class="tablee">{{ $index + 1 }}</td>
        <td class="tablee" style="text-align: left; padding-left: 5px;">
          {{ $row['jenis_barang'] ?? '' }}
        </td>
        <td class="tablee">{{ $row['jumlah'] ?? '' }}</td>
        <td class="tablee">
          @if (($row['kondisi'] ?? '') === 'baik')
            ✓
          @endif
        </td>
        <td class="tablee">
          @if (($row['kondisi'] ?? '') === 'buruk')
            ✓
          @endif
        </td>
        <td class="tablee">{{ $row['tanggal_dititipkan'] ?? '' }}</td>
        <td class="tablee">{{ $row['tanggal_diserahkan'] ?? '' }}</td>
      </tr>
    @empty
      <tr>
        <td class="tablee" colspan="7">Tidak ada data barang</td>
      </tr>
    @endforelse
    
    @if (count($rows) < 10)
      @for ($i = count($rows); $i < 10; $i++)
        <tr>
          <td class="tablee">{{ $i + 1 }}</td>
          <td class="tablee">&nbsp;</td>
          <td class="tablee">&nbsp;</td>
          <td class="tablee">&nbsp;</td>
          <td class="tablee">&nbsp;</td>
          <td class="tablee">&nbsp;</td>
          <td class="tablee">&nbsp;</td>
        </tr>
      @endfor
    @endif
  </tbody>
</table>

<!-- Tanggal dan Tanda Tangan -->
<div style="margin-top: 20px; text-align: right; padding-right: 50px;">
  <p>Medan, {{ $data->tanggal ? \Carbon\Carbon::parse($data->tanggal)->format('d F Y') : '.....................' }}</p>
</div>

<table style="width: 100%; margin-top: 20px;">
  <tr>
    <td style="width: 33%; text-align: center; vertical-align: top;">
      <div class="text-above" style="font-weight: bold;">Yang Memeriksa</div>
      <div class="text-above" style="font-size: 12px;">Petugas Rumah Sakit</div>
      @if (!empty($data->ttd_petugas))
        <div class="img-wrapper" style="margin: 10px 0;">
          <img src="{{ $data->ttd_petugas }}" style="height:80px;">
        </div>
      @else
        <div style="height: 80px;"></div>
      @endif
      <div style="margin-top: 5px;">
        ( {{ $data->nama_petugas_ttd ?? '........................................' }} )
      </div>
    </td>
    
    <td style="width: 33%; text-align: center; vertical-align: top;">
      <div class="text-above" style="font-weight: bold;">Saksi 1</div>
      <div class="text-above" style="font-size: 12px;">&nbsp;</div>
      @if (!empty($data->ttd_saksi1))
        <div class="img-wrapper" style="margin: 10px 0;">
          <img src="{{ $data->ttd_saksi1 }}" style="height:80px;">
        </div>
      @else
        <div style="height: 80px;"></div>
      @endif
      <div style="margin-top: 5px;">
        ( {{ $data->nama_saksi1_ttd ?? '........................................' }} )
      </div>
    </td>
    
    <td style="width: 33%; text-align: center; vertical-align: top;">
      <div class="text-above" style="font-weight: bold;">Saksi</div>
      <div class="text-above" style="font-size: 12px;">Pasien/keluarga</div>
      @if (!empty($data->ttd_keluarga))
        <div class="img-wrapper" style="margin: 10px 0;">
          <img src="{{ $data->ttd_keluarga }}" style="height:80px;">
        </div>
      @else
        <div style="height: 80px;"></div>
      @endif
      <div style="margin-top: 5px;">
        ( {{ $data->nama_keluarga_ttd ?? '........................................' }} )
      </div>
    </td>
  </tr>
</table>

<!-- Keadaan Khusus Pasien Tidak Sadar -->
@if ($data->pasien_tidak_sadar)
  <div style="margin-top: 30px; padding: 10px; border: 1px solid black;">
    <div style="font-weight: bold; margin-bottom: 10px;">Keadaan khusus pasien tidak sadar:</div>
    <div style="text-align: justify; margin-bottom: 15px;">
      Dengan ini menyatakan bahwa telah mendata serta menyimpan harta/benda milik pasien yang 
      masuk ke Ruang Rawat dalam keadaan tidak sadar tanpa didampingi oleh keluarga/wali.
    </div>
    
    <table style="width: 100%; margin-top: 20px;">
      <tr>
        <td style="width: 50%;">&nbsp;</td>
        <td style="width: 50%; text-align: center; vertical-align: top;">
          <div class="text-above" style="font-weight: bold;">Mengetahui</div>
          <div class="text-above" style="font-size: 12px;">Kepala ruangan</div>
          @if (!empty($data->ttd_kepala_ruangan))
            <div class="img-wrapper" style="margin: 10px 0;">
              <img src="{{ $data->ttd_kepala_ruangan }}" style="height:80px;">
            </div>
          @else
            <div style="height: 80px;"></div>
          @endif
          <div style="margin-top: 5px;">
            ( {{ $data->nama_kepala_ruangan_ttd ?? '........................................' }} )
          </div>
        </td>
      </tr>
    </table>
  </div>
@endif

</div>
</body>
</html>