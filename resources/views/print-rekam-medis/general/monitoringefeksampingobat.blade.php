<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>REKAM MEDIS GENERAL - MONITORING EFEK SAMPING OBAT</title>
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

    </style>
    
</head>
<body>
<div style="position:fixed; right: 13px; bottom: 10px;">
</div>
<?php $fullpath = storage_path('app/public/images/header_rme.png');  ?>  
<div class="wrap">
	<div style="width:100%; text-align:right; margin-bottom:5px">
        {{ $data->no_surat ?? 'RM 3.8/MESO/' . config('app.tahun_akreditasi', '22') }}
	</div>
	@include('print-rekam-medis.partials.header')
    <table style="width: 100%;  border: 1px solid black;" cellpadding="0" cellspacing="0" >
        <tr>
            <td style="font-weight: bold; text-align: center; padding: 5px; border-bottom: 1px solid black;">
            MONITORING EFEK SAMPING OBAT
            </td>
        </tr>
    </table>
    <table style="width: 100%;  border-right: 1px solid black; border-left: 1px solid black; border-bottom: 1px solid black;" cellpadding="0" cellspacing="0" >

        <tr>
            <td colspan="6" style="padding-left: 8px;">A. Identitas</td>
        </tr>
        <tr>
            <td colspan="2" style="padding-left: 27px;">1. Nama</td>
            <td colspan="4">: {{ $data->nama ?? '........................' }}</td>
        </tr>
        <tr>
            <td colspan="2" style="padding-left: 27px;">2. Tanggal Lahir</td>
            <td colspan="4">: {{ $data->tanggal_lahir ? \Carbon\Carbon::parse($data->tanggal_lahir)->format('d/m/Y') : '........................' }}</td>
        </tr>
        <tr>
            <td colspan="2" style="padding-left: 27px;">3. No.RM</td>
            <td colspan="4">: {{ $data->no_rm ?? '........................' }}</td>
        </tr>
        <tr style="border-bottom: 1px solid black; ">
            <td style="padding-left: 27px;">4. Kelamin</td>
            <td>{{ $data->jenis_kelamin ?? 'L/P' }}</td>
            <td>Berat Badan</td>
            <td>: {{ $data->berat_badan ?? '......................' }}Kg</td>
            <td>Tinggi Badan</td>
            <td>: {{ $data->tinggi_badan ?? '......................' }}Cm</td>
        </tr>
        <tr>
            <td colspan="6" style="padding-left: 8px;">B. Keluhan Utama</td>
        </tr>
        <tr>
            <td colspan="6" style="padding-left: 27px;">: {{ $data->keluhan_utama ?? '....................' }}</td>
        </tr>
        <tr>
            <td colspan="6" style="padding-left: 27px;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="6" style="padding-left: 8px;">C. Sejarah Penyakit yang diderita saat ini</td>
        </tr>
        <tr>
            <td colspan="6" style="padding-left: 27px;">: {{ $data->sejarah_penyakit_sekarang ?? '....................' }}</td>
        </tr>
        <tr>
            <td colspan="6" style="border-bottom: 1px solid black; padding-left: 27px;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="6" style="padding-left: 8px;">D. Sejarah Medis Terdahulu</td>
        </tr>
        <tr>
            <td colspan="6">
                <table style="width: 100%; border-collapse: collapse; border: 1px solid black; padding:10px; text-align: center;" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="border: 1px solid black;">Penyakit</td>
                        <td style="border: 1px solid black;">Onset</td>
                        <td style="border: 1px solid black;">Membaik/Sembuh</td>
                        <td style="border: 1px solid black;">Resep</td>
                    </tr>
                    @if(isset($data->sejarah_medis_rows))
                        @foreach($data->sejarah_medis_rows as $row)
                        <tr>
                            <td style="border: 1px solid black;">{{ $row['penyakit'] ?? '' }}</td>
                            <td style="border: 1px solid black;">{{ $row['onset'] ?? '' }}</td>
                            <td style="border: 1px solid black;">{{ $row['membaik_sembuh'] ?? '' }}</td>
                            <td style="border: 1px solid black;">{{ $row['resep'] ?? '' }}</td>
                        </tr>
                        @endforeach
                    @else
                    <tr>
                        <td style="border: 1px solid black;"><br></td>
                        <td style="border: 1px solid black;"><br></td>
                        <td style="border: 1px solid black;"><br></td>
                        <td style="border: 1px solid black;"><br></td>
                    </tr>
                    @endif
                </table>
            </td>
        </tr>
        <tr>
            <tr>
                <td colspan="6" style="border-top:1px solid black; padding-left: 8px;">E. Sejarah Alergi</td>
            </tr>
            <tr>
                <td colspan="6">
                    <table style="width: 76%;" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="width:15%;"><br></td>
                            <td style="width:21%; text-align:right;">Ya :</td>
                            <td style="width:1%;">{{ ($data->alergi_status ?? '') == 'Ya' ? '[X]' : '[]' }}</td>
                            <td style="width:21%; text-align:right;">Tidak :</td>
                            <td style="width:1%; ">{{ ($data->alergi_status ?? '') == 'Tidak' ? '[X]' : '[]' }}</td>
                            <td style="width:32%; text-align:right;">Tidak Diketahui :</td>
                            <td style="width:21%; text-align:left;">{{ ($data->alergi_status ?? '') == 'Tidak diketahui' ? '[X]' : '[]' }}</td>  
                        </tr>
                        <tr>
                            <td style="width:15%; padding-left: 27px;">Tipe :</td>
                            <td style="width:21%; text-align:right;">Ringan :</td>
                            <td style="width:1%; ">{{ ($data->alergi_tipe ?? '') == 'Ringan' ? '[X]' : '[]' }}</td>
                            <td style="width:21%; text-align:right;">Sedang :</td>
                            <td style="width:1%;">{{ ($data->alergi_tipe ?? '') == 'Sedang' ? '[X]' : '[]' }}</td>
                            <td style="width:32%; text-align:right;" >Berat :</td>
                            <td style="width:21%; text-align:left;">{{ ($data->alergi_tipe ?? '') == 'Berat' ? '[X]' : '[]' }}</td> 
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="6" style="border-top:1px solid black; padding-left: 8px;">F. Sejarah Sosial</td>
            </tr>
            <tr>
                <td colspan="6">
                    <table style="width: 60%;" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="width:30%; padding-left: 27px;">Merokok :</td>
                            <td style="width:14%; text-align:right;">Ya :</td>
                            <td style="width:1%;">{{ ($data->merokok ?? '') == 'Ya' ? '[X]' : '[]' }}</td>
                            <td style="width:20%; text-align:right;">Tidak :</td>
                            <td style="width:55%;  text-align:left;">{{ ($data->merokok ?? '') == 'Tidak' ? '[X]' : '[]' }}</td>
            
                        </tr>
                        <tr>
                            <td style="width:30%; padding-left: 27px;">Alcohol :</td>
                            <td style="width:14%; text-align:right;">Ya :</td>
                            <td style="width:1%; ">{{ ($data->alkohol ?? '') == 'Ya' ? '[X]' : '[]' }}</td>
                            <td style="width:20%; text-align:right;">Tidak :</td>
                            <td style="width:55%;  text-align:left;">{{ ($data->alkohol ?? '') == 'Tidak' ? '[X]' : '[]' }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="6" style="border-top:1px solid black; padding-left: 8px;">G. Sejarah Obat</td>
            </tr>
            <tr>
                <td colspan="6" style="padding-left: 27px;">1.	Apakah pasien saat ini atau dalam waktu 3 bulan terakhir mengkonsumsi obat resep ?</td>
            </tr>
            <tr>
                <td colspan="6" style="padding-left: 27px;">{{ $data->obat_resep ?? '....................................................................................................................................................................' }}</td>
            </tr>
            <tr>
                <td colspan="6" style="padding-left: 27px;">2. Apakah pasien saat ini mengkonsumsi obat bebas ?</td>
            </tr>
            <tr>
                <td colspan="6" style="padding-left: 27px;"> (Nama obat, Dosis, Cara, Lama pemakaian dan kegunaan)</td>
            </tr>
            <tr>
                <td colspan="6" style="padding-left: 27px;">{{ $data->obat_bebas ?? '................................................................................................................................................................................' }}</td>
            </tr>
            <tr>
                <td colspan="6" style="padding-left: 27px;">3. Penilaian Sejarah Obat :</td>
            </tr>
            <tr>
                <td colspan="6">
                    <table style="width: 100%;" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="padding-left: 43px; width: 2%;">{{ ($data->penilaian_ketidakpatuhan ?? false) ? '[X]' : '[]' }}</td>
                            <td style="width: 99%;">Ketidakpatuhan pasien</td>
                        </tr>
                        <tr>
                            <td style="padding-left: 43px;">{{ ($data->penilaian_pengetahuan_kurang ?? false) ? '[X]' : '[]' }}</td>
                            <td style="width: 98%;">Pengetahuan tentang obat kurang</td>
                        </tr>
                        <tr>
                            <td style="padding-left: 43px;">{{ ($data->penilaian_cara_salah ?? false) ? '[X]' : '[]' }}</td>
                            <td style="width: 98%;">Cara menggunakan obat tidak benar</td>
                        </tr>
                        <tr>
                            <td style="padding-left: 43px;">{{ ($data->penilaian_komunikasi_kurang ?? false) ? '[X]' : '[]' }}</td>
                            <td style="width: 98%;">Komunikasi kurang cukup dengan profesi kesehatan lainnya</td>
                        </tr>
                        <tr>
                            <td style="padding-left: 43px;">{{ ($data->penilaian_efek_samping ?? false) ? '[X]' : '[]' }}</td>
                            <td style="width: 98%;">Reaksi efek samping obat</td>
                        </tr>
                        <tr>
                            <td style="padding-left: 43px;">{{ ($data->penilaian_masalah_lain ?? false) ? '[X]' : '[]' }}</td>
                            <td style="width: 98%;">Masalah berhubungan dengan obat lainnya.</td>
                        </tr>
                    </table>
                </td>
            </tr>
        <tr>
            <td colspan="6" style="text-align:center; border-top:1px solid black;">
                Medan, {{ $data->created_at ? \Carbon\Carbon::parse($data->created_at)->format('d/m/Y') : '.....................' }}
            </td>
        </tr>
        <tr>
            <td colspan="6" style="text-align:center;">{{ $data->profesi_ttd ?? 'Dokter/Perawat' }}</td>
        </tr>
        @if(!empty($data->ttd_petugas))
        <tr>
            <td colspan="6" style="text-align:center; padding-top: 10px;">
                <img src="{{ $data->ttd_petugas }}" style="max-width: 200px; max-height: 80px;" />
            </td>
        </tr>
        @endif
        <tr>
            <td colspan="6" style="text-align:center; padding-top: 2%;">{{ $data->nama_petugas ?? '..........................' }}</td>
        </tr>
    </table>
</div>
</body>
</html>