<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>REKAM MEDIS GENERAL - FORMULIR PERMINTAAN PELAYANAN KEGIATAN KEROHANIAN</title>
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
    text-align: left;
    padding: 5px;
  }
   .text-above {
    text-align: center;   
    margin-bottom: 5px;  
  }
  .info-row {
    padding: 5px;
    display: flex;
    align-items: baseline;
  }
  .info-label {
    width: 180px;
    display: inline-block;
  }
  .info-value {
    flex: 1;
    border-bottom: 1px dotted #000;
    display: inline-block;
    min-height: 18px;
  }
    </style>
    
</head>
<body>
<div style="position:fixed; right: 13px; bottom: 10px;">
</div>
<?php $fullpath = storage_path('app/public/images/header_rme.png');  ?>  
<div class="wrap">
  <div style="width:100%; text-align:right; margin-bottom:5px">
    {{ $data->no_surat ?? 'RM 7.1/FPPKK/' . config('app.tahun_akreditasi', '22') }}
  </div>
  @include('print-rekam-medis.partials.header')

<table style="width: 100%; border: 1px solid black; border-collapse: collapse;">
    <tr>
        <td style="font-weight: bold; text-align: center; padding: 7px;">
            FORMULIR PERMINTAAN PELAYANAN KEGIATAN KEROHANIAN
        </td>
    </tr>
</table>

<!-- Identitas Pasien dan Wali -->
<table style="width: 100%; border: 1px solid black; border-collapse: collapse; margin-top: 10px;">
  <tr>
    <td class="tablee" style="width: 50%; vertical-align: top; padding: 10px;">
      <div style="font-weight: bold; margin-bottom: 10px;">Identitas Pasien</div>
      
      <div class="info-row">
        <span class="info-label">1. Nama</span>
        <span style="margin: 0 5px;">:</span>
        <span class="info-value">{{ $data->nama_pasien ?? '' }}</span>
      </div>
      
      <div class="info-row">
        <span class="info-label">2. Tanggal lahir</span>
        <span style="margin: 0 5px;">:</span>
        <span class="info-value">
          {{ $data->tanggal_lahir_pasien ? \Carbon\Carbon::parse($data->tanggal_lahir_pasien)->format('d-m-Y') : '' }}
        </span>
      </div>
      
      <div class="info-row">
        <span class="info-label">3. Jenis kelamin</span>
        <span style="margin: 0 5px;">:</span>
        <span class="info-value">
          {{ $data->jenis_kelamin_pasien === 'L' ? 'Laki-laki' : ($data->jenis_kelamin_pasien === 'P' ? 'Perempuan' : '') }}
        </span>
      </div>
      
      <div class="info-row">
        <span class="info-label">4. Alamat</span>
        <span style="margin: 0 5px;">:</span>
        <span class="info-value">{{ $data->alamat_pasien ?? '' }}</span>
      </div>
      
      <div class="info-row">
        <span class="info-label">5. Nomor rekam medis</span>
        <span style="margin: 0 5px;">:</span>
        <span class="info-value">{{ $data->no_rm ?? '' }}</span>
      </div>
    </td>
    
    <td class="tablee" style="width: 50%; vertical-align: top; padding: 10px;">
      <div style="font-weight: bold; margin-bottom: 10px;">Identitas Wali (Anak/Istri/Suami/Orangtua)</div>
      
      <div class="info-row">
        <span class="info-label">6. Nama</span>
        <span style="margin: 0 5px;">:</span>
        <span class="info-value">{{ $data->nama_wali ?? '' }}</span>
      </div>
      
      <div class="info-row">
        <span class="info-label">7. Tanggal Lahir</span>
        <span style="margin: 0 5px;">:</span>
        <span class="info-value">
          {{ $data->tanggal_lahir_wali ? \Carbon\Carbon::parse($data->tanggal_lahir_wali)->format('d-m-Y') : '' }}
        </span>
      </div>
      
      <div class="info-row">
        <span class="info-label">8. Jenis Kelamin</span>
        <span style="margin: 0 5px;">:</span>
        <span class="info-value">
          {{ $data->jenis_kelamin_wali === 'L' ? 'Laki-laki' : ($data->jenis_kelamin_wali === 'P' ? 'Perempuan' : '') }}
        </span>
      </div>
      
      <div class="info-row">
        <span class="info-label">9. Alamat</span>
        <span style="margin: 0 5px;">:</span>
        <span class="info-value">{{ $data->alamat_wali ?? '' }}</span>
      </div>
    </td>
  </tr>
</table>

<!-- Permintaan Agama -->
<table style="width: 100%; border: 1px solid black; border-collapse: collapse; margin-top: 10px;">
  <tr>
    <td class="tablee" style="padding: 10px;">
      <div style="font-weight: bold; margin-bottom: 10px;">Permintaan Agama:</div>
      
      <div class="info-row">
        <span class="info-label">1. Agama Kepercayaan Pasien Yang Minta</span>
        <span style="margin: 0 5px;">:</span>
        <span class="info-value">{{ $data->agama_kepercayaan ?? '' }}</span>
      </div>
      
      <div class="info-row">
        <span class="info-label">2. Bentuk Pelayanan Kerohanian Yang Diminta</span>
        <span style="margin: 0 5px;">:</span>
        <span class="info-value">{{ $data->bentuk_pelayanan ?? '' }}</span>
      </div>
      
      <div class="info-row">
        <span class="info-label">3. Hari/Tanggal/Jam Pelayanan Kegiatan Kerohanian</span>
        <span style="margin: 0 5px;">:</span>
        <span class="info-value">
          @if($data->tanggal_pelayanan || $data->jam_pelayanan)
            {{ $data->tanggal_pelayanan ? \Carbon\Carbon::parse($data->tanggal_pelayanan)->format('d-m-Y') : '' }}
            {{ $data->jam_pelayanan ? ', Jam ' . $data->jam_pelayanan : '' }}
          @endif
        </span>
      </div>
      
      <div class="info-row">
        <span class="info-label">4. Koordinasi Dengan Team Terkait</span>
        <span style="margin: 0 5px;">:</span>
        <span class="info-value">{{ $data->koordinasi_team ?? '' }}</span>
      </div>
    </td>
  </tr>
</table>

<!-- Pelayanan Yang Diberikan -->
<table style="width: 100%; border: 1px solid black; border-collapse: collapse; margin-top: 5;">
  <tr>
    <td class="tablee" style="padding: 10px;">
      <div style="font-weight: bold; margin-bottom: 10px;">PELAYANAN YANG DIBERIKAN</div>
      
      <div style="margin-bottom: 10px;">
        <input type="checkbox" {{ $data->pelayanan_doa_bersama ? 'checked' : '' }} disabled>
        <span style="margin-left: 5px;">Doa Bersama Diruangan Dengan Didampingi/Tanpa Pemuka Agama RS/Pribadi</span>
      </div>
      
      @if($data->keterangan_pelayanan)
        <div style="border-top: 1px dotted #000; padding-top: 5px; margin-top: 5px;">
          {!! nl2br(e($data->keterangan_pelayanan)) !!}
        </div>
      @else
        <div style="border-top: 1px dotted #000; padding-top: 5px; margin-top: 5px; min-height: 40px;">
          &nbsp;
        </div>
      @endif
    </td>
  </tr>
</table>

<!-- Tanggal dan Tanda Tangan -->
<div style="margin-top: 5px; text-align: right; padding-right: 50px;">
  <p>Medan, {{ $data->tanggal ? \Carbon\Carbon::parse($data->tanggal)->format('d F Y') : '.....................' }}</p>
</div>

<table style="width: 100%; margin-top: 5px;">
  <tr>
    <td style="width: 33%; text-align: center; vertical-align: top;">
      <div class="text-above" style="font-weight: bold;">Rohaniawan</div>
      <div class="text-above" style="font-size: 12px;">Tanda tangan</div>
      @if (!empty($data->ttd_rohaniawan))
        <div class="img-wrapper" style="margin: 10px 0;">
          <img src="{{ $data->ttd_rohaniawan }}" style="height:80px;">
        </div>
      @else
        <div style="height: 80px;"></div>
      @endif
      <div style="margin-top: 5px;">
        ( {{ $data->nama_rohaniawan_ttd ?? '........................................' }} )
      </div>
    </td>
    
    <td style="width: 33%; text-align: center; vertical-align: top;">
      <div class="text-above" style="font-weight: bold;">Kepala Ruangan</div>
      <div class="text-above" style="font-size: 12px;">Tanda Tangan</div>
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
    
    <td style="width: 33%; text-align: center; vertical-align: top;">
      <div class="text-above" style="font-weight: bold;">Pasien/Keluarga</div>
      <div class="text-above" style="font-size: 12px;">Tanda tangan</div>
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

</div>
</body>
</html>