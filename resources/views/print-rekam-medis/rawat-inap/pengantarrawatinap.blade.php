<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>REKAM MEDIS GENERAL - SURAT PENGANTAR UNTUK DIRAWAT INAP</title>
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
    display: flex;
    align-items: baseline;
    margin-bottom: 8px;
  }
  .info-label {
    width: 160px;
    flex-shrink: 0;
  }
  .info-colon {
    margin: 0 8px;
    flex-shrink: 0;
  }
  .info-value {
    flex: 1;
    border-bottom: 1px dotted #000;
    min-height: 18px;
    padding-left: 5px;
  }
    </style>
    
</head>
<body>
<div style="position:fixed; right: 13px; bottom: 10px;">
</div>
<?php $fullpath = storage_path('app/public/images/header_rme.png');  ?>  
<div class="wrap">
  <div style="width:100%; text-align:right; margin-bottom:5px">
    {{ $data->no_surat ?? 'RM 2.5/SPUDI/' . config('app.tahun_akreditasi', '22') }}
  </div>
  @include('print-rekam-medis.partials.header')

  <!-- Judul -->
  <table style="width: 100%; border: 1px solid black; border-collapse: collapse;">
    <tr>
      <td style="font-weight: bold; text-align: center; padding: 7px;">
        SURAT PENGANTAR UNTUK DIRAWAT INAP
      </td>
    </tr>
  </table>

  <!-- Body Form -->
  <table style="width: 100%; border: 1px solid black; border-collapse: collapse; margin-top: 0px;">
    <tr>
      <td class="tablee" style="padding: 15px;">

        <!-- Asal Ruangan -->
        <div class="info-row" style="margin-bottom: 12px;">
          <span class="info-label">Asal Ruangan</span>
          <span class="info-colon">:</span>
          <span>
            @php
              $asalRuangan = $data->asal_ruangan ?? '[]';
              if (is_string($asalRuangan)) {
                $asalRuangan = json_decode($asalRuangan, true) ?? [];
              }
            @endphp
            <span style="margin-right: 15px;">
              <input type="checkbox" {{ in_array('IGD', $asalRuangan) ? 'checked' : '' }} disabled>
              IGD
            </span>
            <span>
              <input type="checkbox" {{ in_array('Poliklinik', $asalRuangan) ? 'checked' : '' }} disabled>
              Poliklinik{{ $data->nama_poliklinik ? ', ' . $data->nama_poliklinik : '' }}
            </span>
          </span>
        </div>

        <!-- Rencana Perawatan -->
        <div class="info-row" style="margin-bottom: 12px;">
          <span class="info-label">Rencana perawatan di</span>
          <span class="info-colon">:</span>
          <span class="info-value">{{ $data->rencana_perawatan ?? '' }}</span>
        </div>

        <!-- Teks Pengantar -->
        <div style="margin: 15px 0;">
          Bersama ini kami kirimkan pasien tersebut diatas untuk dirawat inap :
        </div>

        <!-- Karena Menderita -->
        <div class="info-row" style="margin-bottom: 12px;">
          <span class="info-label">Karena menderita</span>
          <span class="info-colon">:</span>
          <span class="info-value">{{ $data->karena_menderita ?? '' }}</span>
        </div>

        <!-- Saran Terapi -->
        <div class="info-row" style="margin-bottom: 4px;">
          <span class="info-label">Saran Terapi</span>
          <span class="info-colon">:</span>
          <span class="info-value">
            {!! nl2br(e($data->saran_terapi ?? '')) !!}
          </span>
        </div>

        <!-- Rencana Tindakan -->
        <div class="info-row" style="margin-bottom: 4px;">
          <span class="info-label">Rencana Tindakan</span>
          <span class="info-colon">:</span>
          <span class="info-value">
            {!! nl2br(e($data->rencana_tindakan ?? '')) !!}
          </span>
        </div>

        <!-- Teks Penutup -->
        <div style="margin: 20px 0 10px 0;">
          Mohon ditindaklanjuti untuk rencana tindakan terapi.
        </div>

        <!-- Tanggal -->
        <div style="margin-top: 20px; text-align: right; padding-right: 80px;">
          Medan, {{ $data->tanggal ? \Carbon\Carbon::parse($data->tanggal)->format('d F Y') : 'Tgl...................................' }}
        </div>

        <!-- Tanda Tangan Dokter -->
        <table style="width: 100%; margin-top: 20px;">
          <tr>
            <td style="width: 40%;">&nbsp;</td>
            <td style="text-align: center; vertical-align: top;">
              <div class="text-above" style="font-weight: bold;">Dokter yang memeriksa</div>

              @if (!empty($data->ttd_dokter))
                <div class="img-wrapper" style="margin: 10px 0;">
                  <img src="{{ $data->ttd_dokter }}" style="height:80px;">
                </div>
              @else
                <div style="height: 80px;"></div>
              @endif

              <div style="margin-top: 5px;">
                ( {{ $data->nama_dokter_ttd ?? '........................................' }} )
              </div>
              <div style="font-size: 12px; margin-top: 3px;">Nama Jelas dan Tanda Tangan</div>
            </td>
          </tr>
        </table>

      </td>
    </tr>
  </table>

</div>
</body>
</html>