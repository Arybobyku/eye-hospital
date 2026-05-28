<style>
    .header-table { width: 100%; border-collapse: collapse; border: 1px solid black; margin-bottom: 4px; }
    .header-table > tbody > tr > td { border: 1px solid black; padding: 3px 5px; vertical-align: middle; }
    .info-table td { border: none; padding: 1px 3px; }
    .header-logo { width: 35%; text-align: center; }
    .header-logo img { max-width: 100%; height: auto; }
    .header-title { width: 27%; text-align: center; vertical-align: middle; }
    .header-title b { font-size: 9.5pt; }
    .header-title i { font-size: 7.5pt; }
    .header-info { width: 38%; }
</style>

<table class="header-table">
    <tr>
        <td class="header-logo">
            <img src="data:image/png;base64,<?php echo base64_encode(file_get_contents($fullpath)); ?>" />
        </td>
        <td class="header-title">
            <b>PEMBERIAN EDUKASI PASIEN TERINTEGRASI</b><br>
            <i>
                Tanggal Kunjungan:
                {{ !empty($data->tanggal_kunjungan)
                    ? \Carbon\Carbon::parse($data->tanggal_kunjungan)->format('d/m/Y')
                    : '__________' }}
                &nbsp;&nbsp; Jam:
                {{ $data->jam_kunjungan ?? '__________' }} WIB
            </i>
        </td>
        <td class="header-info">
            <table class="info-table" style="width:100%; font-size:8pt;" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="30%">Nama</td>
                    <td width="4%">:</td>
                    <td>{{ $pasien->nama ?? $data->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Tgl. Lahir</td>
                    <td>:</td>
                    <td>
                        {{ !empty($pasien->tanggal_lahir)
                            ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d/m/Y')
                            : '-' }}
                        &nbsp; {{ $data->jenis_kelamin ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td>No. RM</td>
                    <td>:</td>
                    <td>{{ $pasien->rekam_medis ?? $data->no_rm ?? '-' }}</td>
                </tr>
                <tr>
                    <td>NIK</td>
                    <td>:</td>
                    <td>{{ $pasien->no_identitas ?? $data->nik ?? '-' }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
