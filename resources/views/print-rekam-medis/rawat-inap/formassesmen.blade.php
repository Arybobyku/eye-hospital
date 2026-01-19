<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asesmen Awal Keperawatan Rawat Inap</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            padding: 20px;
            background: white;
        }
        
        .page {
            max-width: 21cm;
            margin: 0 auto;
            background: white;
            padding: 1.5cm;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        .header {
            margin-bottom: 10px;
        }
        
        .kop-surat {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 5px;
        }
        
        .kop-left {
            font-size: 9pt;
        }
        
        .kop-right {
            display: flex;
            gap: 30px;
            font-size: 9pt;
        }
        
        .kop-right-item {
            display: flex;
            flex-direction: column;
        }
        
        .kop-right-item span:first-child {
            font-weight: normal;
        }
        
        .kop-right-item span:last-child {
            border-bottom: 1px solid #000;
            min-width: 150px;
            height: 20px;
        }
        
        h1 {
            text-align: center;
            font-size: 12pt;
            font-weight: bold;
            margin: 15px 0 5px 0;
        }
        
        .subtitle {
            text-align: center;
            font-size: 9pt;
            margin-bottom: 15px;
        }
        
        .section {
            margin-bottom: 15px;
        }
        
        .section-title {
            font-weight: bold;
            font-size: 10pt;
            margin-bottom: 8px;
            text-decoration: underline;
        }
        
        .checkbox-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
            margin-left: 5px;
        }
        
        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .checkbox {
            width: 14px;
            height: 14px;
            border: 1px solid #000;
            display: inline-block;
            vertical-align: middle;
        }
        
        .underline {
            display: inline-block;
            border-bottom: 1px dotted #000;
            min-width: 100px;
            height: 18px;
        }
        
        .two-column {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .keadaan-umum {
            display: grid;
            grid-template-columns: auto 1fr auto 1fr;
            gap: 5px 10px;
            align-items: center;
            font-size: 10pt;
        }
        
        .keadaan-umum label {
            text-align: right;
        }
        
        .keadaan-umum .value {
            border-bottom: 1px solid #000;
            min-width: 60px;
            height: 20px;
        }
        
        .pemeriksaan-fisik {
            display: grid;
            grid-template-columns: auto auto auto 1fr;
            gap: 5px 10px;
            align-items: center;
            font-size: 10pt;
        }
        
        .table-bordered {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        
        .table-bordered th,
        .table-bordered td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            font-size: 9pt;
        }
        
        .table-bordered th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        
        .table-bordered td {
            text-align: left;
        }
        
        .inline-fields {
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .risk-box {
            border: 1px solid #000;
            padding: 8px;
            margin: 10px 0;
        }
        
        .pain-scale {
            display: flex;
            justify-content: center;
            margin: 15px 0;
        }
        
        .pain-scale img {
            max-width: 100%;
            height: auto;
        }
        
        .signature-box {
            margin-top: 30px;
            text-align: right;
        }
        
        .signature-line {
            display: inline-block;
            border-bottom: 1px solid #000;
            min-width: 200px;
            margin-top: 60px;
        }
    </style>
</head>
<body>
    <!-- HALAMAN 1 -->
    <div class="page">
        <div class="header">
            <div class="kop-surat">
                <div class="kop-left">RM 7.8/AAKRI/2022</div>
                <div class="kop-right">
                    <div class="kop-right-item">
                        <span>Nama :</span>
                        <span></span>
                    </div>
                    <div class="kop-right-item">
                        <span>Tgl Lahir :</span>
                        <span></span>
                    </div>
                    <div class="kop-right-item">
                        <span>L/P</span>
                        <span></span>
                    </div>
                </div>
            </div>
            <div class="kop-surat">
                <div class="kop-left"></div>
                <div class="kop-right">
                    <div class="kop-right-item">
                        <span>No. RM :</span>
                        <span></span>
                    </div>
                    <div class="kop-right-item">
                        <span>NIK :</span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>

        <h1>ASSESMEN AWAL KEPERAWATAN RAWAT INAP</h1>
        <div class="subtitle">(Formulir ini digunakan untuk pasien dewasa/usia lanjut dan<br>harus dilengkapi dalam waktu 24 jam pertama pasien masuk ruang rawat inap)</div>

        <!-- ALERGI/REAKSI -->
        <div class="section">
            <div class="section-title">ALERGI/REAKSI</div>
            <div class="checkbox-group">
                <div class="checkbox-item">
                    <span class="checkbox"></span>
                    <span>Tidak ada alergi</span>
                </div>
                <div class="checkbox-item">
                    <span class="checkbox"></span>
                    <span>Alergi Obat, sebutkan <span class="underline" style="width: 200px;"></span> Reaksi <span class="underline" style="width: 200px;"></span></span>
                </div>
                <div class="checkbox-item">
                    <span class="checkbox"></span>
                    <span>Alergi makanan, sebutkan <span class="underline" style="width: 180px;"></span> Reaksi <span class="underline" style="width: 180px;"></span></span>
                </div>
                <div class="checkbox-item">
                    <span class="checkbox"></span>
                    <span>Alergi lainnya, sebutkan <span class="underline" style="width: 180px;"></span> Reaksi <span class="underline" style="width: 180px;"></span></span>
                </div>
                <div class="checkbox-item" style="margin-left: 20px;">
                    <span class="checkbox"></span>
                    <span>Diberitahukan ke Dokter/Apoteker/ahli gizi (lingkari yang sesuai) Ya, pukul<span class="underline" style="width: 60px;"></span> Tidak</span>
                </div>
                <div class="checkbox-item" style="margin-left: 20px;">
                    <span class="checkbox"></span>
                    <span>Gelang tanda alergi dipasang (warna merah) Ya Tidak</span>
                </div>
                <div class="checkbox-item">
                    <span class="checkbox"></span>
                    <span>Tidak Diketahui</span>
                </div>
            </div>
        </div>

        <!-- KEADAAN UMUM & PEMERIKSAAN FISIK -->
        <div class="two-column">
            <!-- Keadaan Umum -->
            <div>
                <div class="section-title">Keadaan Umum</div>
                <div class="keadaan-umum">
                    <label>Kesadaran</label>
                    <div class="value"></div>
                    <label></label>
                    <div></div>
                    
                    <label>GCS</label>
                    <div class="value">E...V...M...</div>
                    <label></label>
                    <div></div>
                    
                    <label>Tekanan Darah</label>
                    <div class="value"></div>
                    <label>mmHg</label>
                    <div></div>
                    
                    <label>Pols</label>
                    <div class="value"></div>
                    <label>x/mnt</label>
                    <div></div>
                    
                    <label>RR</label>
                    <div class="value"></div>
                    <label>x/mnt</label>
                    <div></div>
                    
                    <label>SPO₂</label>
                    <div class="value"></div>
                    <label>%</label>
                    <div></div>
                    
                    <label>Suhu Tubuh</label>
                    <div class="value"></div>
                    <label>°C</label>
                    <div></div>
                    
                    <label>Berat Badan</label>
                    <div class="value"></div>
                    <label>Kg</label>
                    <div></div>
                    
                    <label>Tinggi Badan</label>
                    <div class="value"></div>
                    <label>Cm</label>
                    <div></div>
                    
                    <label>Lingkar Kepala</label>
                    <div class="value"></div>
                    <label>Cm</label>
                    <div></div>
                    
                    <label>LiLA</label>
                    <div class="value"></div>
                    <label>Cm</label>
                    <div></div>
                </div>
            </div>

            <!-- Pemeriksaan Fisik -->
            <div>
                <div class="section-title">Pemeriksaan Fisik</div>
                <div class="pemeriksaan-fisik" style="font-size: 9.5pt;">
                    <label>Pernafasan</label>
                    <div><span class="checkbox"></span> Normal</div>
                    <div><span class="checkbox"></span> Batuk</div>
                    <div><span class="checkbox"></span> Sesak <span class="underline" style="width: 80px;"></span></div>
                    
                    <label>Pengelihatan</label>
                    <div><span class="checkbox"></span> Baik</div>
                    <div><span class="checkbox"></span> Rusak</div>
                    <div><span class="checkbox"></span> Alat Bantu <span class="underline" style="width: 60px;"></span></div>
                    
                    <label>Pendengaran</label>
                    <div><span class="checkbox"></span> Baik</div>
                    <div><span class="checkbox"></span> Rusak</div>
                    <div><span class="checkbox"></span> Alat Bantu <span class="underline" style="width: 60px;"></span></div>
                    
                    <label>Bicara</label>
                    <div><span class="checkbox"></span> Normal</div>
                    <div colspan="2"><span class="checkbox"></span> Gangguan <span class="underline" style="width: 100px;"></span></div>
                    
                    <label>Mulut</label>
                    <div><span class="checkbox"></span> Bersih</div>
                    <div><span class="checkbox"></span> Kotor</div>
                    <div><span class="checkbox"></span> Gigi Palsu <span class="underline" style="width: 60px;"></span></div>
                    
                    <label>Refleks Menelan</label>
                    <div><span class="checkbox"></span> Normal</div>
                    <div><span class="checkbox"></span> Sulit</div>
                    <div><span class="checkbox"></span> Rusak <span class="underline" style="width: 80px;"></span></div>
                    
                    <label>Gastrosintestinal</label>
                    <div><span class="checkbox"></span> Normal</div>
                    <div><span class="checkbox"></span> Refluks</div>
                    <div><span class="checkbox"></span> Nausea <span class="checkbox"></span> Muntah</div>
                    
                    <label>Defekasi</label>
                    <div><span class="checkbox"></span> Normal</div>
                    <div colspan="2"><span class="checkbox"></span> Retensio <span class="underline" style="width: 100px;"></span></div>
                    
                    <label>Miksi</label>
                    <div><span class="checkbox"></span> Normal</div>
                    <div colspan="2"><span class="checkbox"></span> Retensio <span class="underline" style="width: 100px;"></span></div>
                    
                    <label>Pola Tidur</label>
                    <div><span class="checkbox"></span> Normal</div>
                    <div colspan="2"><span class="checkbox"></span> Insomnia <span class="underline" style="width: 100px;"></span></div>
                    
                    <label>Kulit</label>
                    <div><span class="checkbox"></span> Normal</div>
                    <div colspan="2"><span class="checkbox"></span> Luka: Lokasi: <span class="underline" style="width: 100px;"></span></div>
                </div>
            </div>
        </div>

        <!-- KHUSUS UNTUK WANITA -->
        <div class="section" style="margin-top: 15px;">
            <div class="section-title">Khusus Untuk Wanita</div>
            <div style="margin-left: 5px;">
                <div class="inline-fields">
                    <span>Hamil :</span>
                    <span><span class="checkbox"></span> Ya, HPHT <span class="underline" style="width: 150px;"></span></span>
                    <span><span class="checkbox"></span> Tidak</span>
                </div>
                <div style="margin-top: 5px;">
                    <span>Keluhan Menstruasi : <span class="underline" style="width: 500px;"></span></span>
                </div>
            </div>
        </div>

        <!-- SKRINING RISIKO CEDERA/JATUH -->
        <div class="section">
            <div class="section-title">SKRINING RISIKO CEDERA/JATUH</div>
            <div class="risk-box">
                <div class="inline-fields">
                    <span>Risiko Cedera/Jatuh :</span>
                    <span><span class="checkbox"></span> Ya, maka lakukan pemasangan :</span>
                    <span><span class="checkbox"></span> Tidak</span>
                </div>
                <div style="margin-left: 20px; margin-top: 5px;">
                    <div><span class="checkbox"></span> Gelang risiko jatuh</div>
                    <div><span class="checkbox"></span> Segitiga risiko jatuh</div>
                </div>
                <div style="margin-top: 5px;">
                    <span>Diberitahukan ke dokter : <span class="checkbox"></span> Ya, pukul : <span class="underline" style="width: 80px;"></span> <span class="checkbox"></span> Tidak</span>
                </div>
            </div>
        </div>

        <!-- RIWAYAT PSIKOSOSIAL KULTURAL SPIRITUAL -->
        <div class="section">
            <div class="section-title">RIWAYAT PSIKOSOSIAL KULTURAL SPIRITUAL</div>
            
            <div style="margin-bottom: 10px;">
                <strong>Status Psikologis</strong>
                <div class="inline-fields" style="margin-left: 5px;">
                    <span><span class="checkbox"></span> Cemas</span>
                    <span><span class="checkbox"></span> Takut</span>
                    <span><span class="checkbox"></span> Marah</span>
                    <span><span class="checkbox"></span> Sedih</span>
                    <span><span class="checkbox"></span> Kecenderungan bunuh diri</span>
                </div>
                <div style="margin-left: 5px; margin-top: 5px;">
                    <span>Lain-lain, sebutkan <span class="underline" style="width: 450px;"></span></span>
                </div>
            </div>

            <div style="margin-bottom: 10px;">
                <strong>Status Sosial</strong>
                <div style="margin-left: 5px;">
                    <div class="inline-fields">
                        <span>Hubungan pasien dengan anggota keluarga :</span>
                        <span><span class="checkbox"></span> Baik</span>
                        <span><span class="checkbox"></span> Tidak Baik</span>
                    </div>
                    <div style="margin-top: 5px;">
                        <span>Tempat tinggal : <span class="checkbox"></span> Rumah/<span class="checkbox"></span>Apartemen/<span class="checkbox"></span>Panti/<span class="checkbox"></span>Lainnya : <span class="underline" style="width: 150px;"></span></span>
                    </div>
                    <div style="margin-top: 5px;">
                        <span>Kerabat yang dapat dihubungi : Nama :<span class="underline" style="width: 120px;"></span> Hubungan :<span class="underline" style="width: 100px;"></span> Telepon:<span class="underline" style="width: 100px;"></span></span>
                    </div>
                </div>
            </div>

            <div style="margin-bottom: 10px;">
                <strong>Status Kultural</strong>
                <div style="margin-left: 5px;">
                    <div class="inline-fields">
                        <span>Bahasa Sehari-hari :</span>
                        <span><span class="checkbox"></span> Indonesia</span>
                        <span><span class="checkbox"></span> Daerah, sebutkan: <span class="underline" style="width: 100px;"></span></span>
                        <span><span class="checkbox"></span> Inggris: aktif/pasif</span>
                    </div>
                    <div style="margin-top: 5px;">
                        <span>Lain-lain, sebutkan <span class="underline" style="width: 300px;"></span></span>
                    </div>
                    <div style="margin-top: 5px;">
                        <span>Perlu penterjemah : <span class="checkbox"></span> Ya, Bahasa<span class="underline" style="width: 150px;"></span> <span class="checkbox"></span> Tidak</span>
                    </div>
                </div>
            </div>

            <div>
                <strong>Status Spiritual</strong>
                <div style="margin-left: 5px;">
                    <div>Nilai-nilai atau kepercayaan yang dianut <span class="underline" style="width: 400px;"></span></div>
                    <div><span class="underline" style="width: 650px;"></span></div>
                </div>
            </div>
        </div>
    </div>

    <!-- HALAMAN 2 -->
    <div class="page" style="margin-top: 30px;">
        <div class="header">
            <div class="kop-surat">
                <div class="kop-left">RM 7.8/AAKRI/2022</div>
                <div class="kop-right">
                    <div class="kop-right-item">
                        <span>Nama :</span>
                        <span></span>
                    </div>
                    <div class="kop-right-item">
                        <span>Tgl Lahir :</span>
                        <span></span>
                    </div>
                    <div class="kop-right-item">
                        <span>L/P</span>
                        <span></span>
                    </div>
                </div>
            </div>
            <div class="kop-surat">
                <div class="kop-left"></div>
                <div class="kop-right">
                    <div class="kop-right-item">
                        <span>No. RM :</span>
                        <span></span>
                    </div>
                    <div class="kop-right-item">
                        <span>NIK :</span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- PENILAIAN RISIKO DEKUBITUS -->
        <div class="section">
            <div class="section-title">PENILAIAN RISIKO DEKUBITUS (SKALA NORTON)</div>
            <table class="table-bordered">
                <thead>
                    <tr>
                        <th>Yang Dinilai</th>
                        <th>4</th>
                        <th>3</th>
                        <th>2</th>
                        <th>1</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Keluhan Fisik</td>
                        <td>Baik</td>
                        <td>Sedang</td>
                        <td>Buruk</td>
                        <td>Sangat buruk</td>
                    </tr>
                    <tr>
                        <td>Status Mental</td>
                        <td>Sadar</td>
                        <td>Apatis</td>
                        <td>Bingung</td>
                        <td>Stupor</td>
                    </tr>
                    <tr>
                        <td>Aktifitas</td>
                        <td>Jalan sendiri</td>
                        <td>Dengan bantuan</td>
                        <td>Kursi roda</td>
                        <td>Di tempat tidur</td>
                    </tr>
                    <tr>
                        <td>Mobilitas</td>
                        <td>Bebas bergerak</td>
                        <td>Gerak terbatas</td>
                        <td>Sangat terbatas</td>
                        <td>Tidak bergerak</td>
                    </tr>
                    <tr>
                        <td>Inkontinensia</td>
                        <td>Kontinen</td>
                        <td>Kadang inkontinen</td>
                        <td>Selalu inkontinen</td>
                        <td>Inkontinen urin &alfi</td>
                    </tr>
                </tbody>
            </table>
            <div style="margin-top: 10px;">
                <strong>Jumlah Skor : <span class="underline" style="width: 60px;"></span></strong>
            </div>
            <div style="margin-left: 5px; margin-top: 5px; font-size: 9.5pt;">
                <div>16-20 : Tidak ada risiko</div>
                <div>12-15 : Risiko Sedang</div>
                <div>&lt;12 : Risiko Tinggi</div>
            </div>
        </div>

        <!-- PENILAIAN SKALA NYERI -->
        <div class="section">
            <div class="section-title">PENILAIAN SKALA NYERI</div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                <div>
                    <div class="inline-fields" style="margin-bottom: 8px;">
                        <span>Keluhan Nyeri</span>
                        <span><span class="checkbox"></span> Ada, Skala nyeri <span class="underline" style="width: 80px;"></span></span>
                        <span><span class="checkbox"></span> Tidak ada</span>
                    </div>
                    <div style="margin-bottom: 8px;">
                        <span>Lokasi : <span class="underline" style="width: 200px;"></span></span>
                    </div>
                    <div class="inline-fields" style="margin-bottom: 8px;">
                        <span>Nyeri berpindah/menjalar:</span>
                        <span><span class="checkbox"></span> Ada, ke <span class="underline" style="width: 100px;"></span></span>
                        <span><span class="checkbox"></span> Tidak ada</span>
                    </div>
                    <div class="inline-fields" style="margin-bottom: 8px;">
                        <span>Onset nyeri</span>
                        <span><span class="checkbox"></span> &lt; 3 bulan = akut</span>
                        <span><span class="checkbox"></span> &gt;3 bulan = kronik</span>
                    </div>
                </div>
                <div>
                    <div style="margin-bottom: 8px;">
                        <strong>Rasa Nyeri</strong>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 5px; font-size: 9.5pt;">
                        <div><span class="checkbox"></span> Seperti ditusuk</div>
                        <div><span class="checkbox"></span> Seperti ditikam</div>
                        <div><span class="checkbox"></span> Seperti berdenyut</div>
                        <div><span class="checkbox"></span> Seperti dipukul</div>
                        <div><span class="checkbox"></span> Seperti kram</div>
                        <div><span class="checkbox"></span> Seperti dibakar</div>
                        <div><span class="checkbox"></span> Nyeri tajam</div>
                        <div><span class="checkbox"></span> Nyeri tumpul</div>
                        <div><span class="checkbox"></span> Seperti ditarik</div>
                    </div>
                </div>
            </div>
            <div class="inline-fields" style="margin-top: 8px;">
                <span>Frekuensi nyeri :</span>
                <span><span class="checkbox"></span> 1-2 jam</span>
                <span><span class="checkbox"></span> 3-4 jam</span>
                <span style="margin-left: 30px;">Lama nyeri :</span>
                <span><span class="checkbox"></span> &lt;30 menit</span>
                <span><span class="checkbox"></span> &gt;30menit</span>
            </div>
            <div style="margin-top: 8px;">
                <span>Nyeri memburuk bila : <span class="underline" style="width: 200px;"></span> Nyeri berkurang bila : <span class="underline" style="width: 200px;"></span></span>
            </div>
        </div>

        <!-- SKRINING GIZI -->
        <div class="section">
            <div class="section-title">SKRINING GIZI</div>
            <table class="table-bordered">
                <thead>
                    <tr>
                        <th style="width: 70%;">Parameter (berdasarkan MST)</th>
                        <th style="width: 30%;">Skor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong>1. Apakah pasien mengalami penurunan BB yang tidak<br>diinginkan dalam 3 bulan terakhir?</strong>
                            <div style="margin-top: 5px; font-size: 9pt;">
                                <div>0 = tidak ada penurunan BB</div>
                                <div>1 = penurunan 1-5 kg</div>
                                <div>2 = penurunan 6-10 kg</div>
                                <div>3 = penurunan 11-15 kg</div>
                                <div>4 = penurunan &gt;15 kg</div>
                            </div>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <strong>2. Apakah asupan makanan berkurang karena tidak<br>nafsu makan?</strong>
                            <div style="margin-top: 5px