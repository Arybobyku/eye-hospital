<table border="1">
  <tr>
    <td colspan="11">Kontrol Pasien / Operasi RS Prima Vision</td>
  </tr>
  <tr>
    <td colspan="11">Periode {{ tglse($dari) }} sampai {{ tglse($ke) }}</td>
  </tr>
  <tr>
    <td colspan="11">
      Filter:
      Cara Bayar: {{ $carabayar_nama }} |
      Asuransi: {{ $nama_asuransi }} |
      Dokter: {{ $nama_dokter }}
    </td>
  </tr>

  <tr>
    <td>Nama Pasien</td>
    <td>Rekam Medis</td>
    <td>Tanggal Lahir</td>
    <td>No HP</td>
    <td>Dokter</td>
    <td>Metode Pembayaran</td>
    <td>Diagnosa / Anamnese</td>
    <td>Pemeriksaan / Prognosa</td>
    <td>Jadwal Operasi</td>
    <td>Paket Bedah</td>
    <td>Jadwal Kontrol</td>
  </tr>

  @foreach ($data as $row)
    <tr>
      <td>{{ $row->nama_pasien }}</td>
      <td>{{ $row->rekam_medis }}</td>
      <td>{{ $row->tanggal_lahir ? tglse($row->tanggal_lahir) : '-' }}</td>
      <td>{{ $row->no_handphone ?? '-' }}</td>
      <td>{{ $row->nama_dokter ?? '-' }}</td>
      <td>{{ $row->metode_pembayaran ?? '-' }}</td>
      <td>{{ $row->anamnese ?? '-' }}</td>
      <td>{{ $row->pemeriksaan_prognosa ?? '-' }}</td>
      <td>{{ $row->jadwal_operasi ? tglse($row->jadwal_operasi) : '-' }}</td>
      <td>{{ $row->paket_bedah ?? '-' }}</td>
      <td>{{ $row->tanggal_kontrol_selanjutnya ? tglse($row->tanggal_kontrol_selanjutnya) : '-' }}</td>
    </tr>
  @endforeach
</table>

<?php
function tglse($created) {
  if (!$created) return '-';

  // kalau format datetime (YYYY-MM-DD HH:MM:SS), ambil tanggalnya aja
  $created = substr($created, 0, 10);

  $tgl_ = explode('-', $created);
  if (count($tgl_) < 3) return $created;

  $thn = $tgl_[0]; $bln = $tgl_[1]; $tgl = $tgl_[2];

  if ($bln == '01') { $bln = 'Januari'; }
  else if ($bln == '02') { $bln = 'Februari'; }
  else if ($bln == '03') { $bln = 'Maret'; }
  else if ($bln == '04') { $bln = 'April'; }
  else if ($bln == '05') { $bln = 'Mei'; }
  else if ($bln == '06') { $bln = 'Juni'; }
  else if ($bln == '07') { $bln = 'Juli'; }
  else if ($bln == '08') { $bln = 'Agustus'; }
  else if ($bln == '09') { $bln = 'September'; }
  else if ($bln == '10') { $bln = 'Oktober'; }
  else if ($bln == '11') { $bln = 'November'; }
  else { $bln = 'Desember'; }

  return $tgl . ' ' . $bln . ' ' . $thn;
}
?>
