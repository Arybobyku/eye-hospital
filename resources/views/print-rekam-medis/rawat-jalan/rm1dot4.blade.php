<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>RM1.4</title>
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

        .tablee {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .page_break {
            page-break-before: always;
        }
    </style>

</head>

<body>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <?php $eyero = storage_path('app/public/images/EYE-RO.png'); ?>
   
        <div class="wrap">
            <div style="width:100%; text-align:right; margin-bottom:5px">
                RM 1.4/PKMRJ/22
            </div>
            @include('print-rekam-medis.partials.header')
            <table>
                <tr>
                    <td>
                        <h4 style="text-decoration: underline"> STATUS OFTALMOLOGIS RAWAT JALAN </h4>
                    </td>

                    <table style="border: 1px solid black; margin-top:18px; margin-left:19px;">
                        <td style="text-align:center; "> Tanggal Kunjungan : {{ $dataRo->tanggal }} jam
                            {{ $dataRo->waktu }} WIB
                        </td>
                    </table>
                </tr>
                {{-- OC DAN OD --}}
                <tr>
                    <td>
                        <table style="border: 1px solid black; width:105%; heigh:600px; padding-top:10px">
                            <tr>
                                <td>
                                    <h4 style="text-decoration: underline; margin-left:10px; margin-top:1px"> OCULAR
                                        DEXTRA
                                    </h4>
                                </td>
                                <table style="border: 1px solid black;margin-left:-100px">
                                    <td style="text-align:center;"> PD:{{ $dataRo->ocular_dextra_pd ?? '....' }}</td>
                                </table>
                            </tr>
                            <tr>
                                <div style="margin-left: 10px;">
                                    <table>
                                        <tr>
                                            <td>Autoref</td>
                                            <td>:</td>
                                            <td colspan="2">{{ $dataRo->ocular_dextra_autoref ?? '....' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Keratometri</td>
                                            <td>:</td>
                                            <td>K1:
                                                {{ keratometriFormat($dataRo->ocular_dextra_keratometri_k1 ?? '....') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td>K2:
                                                {{ keratometriFormat($dataRo->ocular_dextra_keratometri_k2 ?? '....') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tonommetri</td>
                                            <td>:</td>
                                            <td>{{ $dataRo->ocular_dextra_tonometri ?? '....' }} MmHg</td>
                                        </tr>
                                        <tr>
                                            <td style="margin-left: 10px; font-weight:bold">VISUS</td>
                                            <td>:</td>
                                            <td>{{ $dataRo->ocular_dextra_visus ?? '....' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="margin-left: 10px; font-weight:bold">BCVA</td>
                                            <td>:</td>
                                            <td>{{ $dataRo->ocular_dextra_bcva1 ?? '....' }} =>
                                                {{ $dataRo->ocular_dextra_bcva2 ?? '....' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="margin-left: 10px; font-weight:bold">Add</td>
                                            <td>:</td>
                                            <td>{{ $dataRo->ocular_dextra_add }}</td>
                                        </tr>
                                        <tr>
                                            <td>Kacamata Lama</td>
                                            <td>:</td>
                                            <td>
                                                Sph :
                                                {{ $dataRo->ocular_dextra_kacamata_lama_sph ?? '....' }}
                                                Cyl:
                                                {{ $dataRo->ocular_dextra_kacamata_lama_cyl ?? '....' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>Addisi: {{ $dataRo->ocular_dextra_kacamata_lama_addisi ?? '....' }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <br>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <table style="border: 1px solid black; width:95%; margin-left:35px; padding-top:10px">
                            <tr>
                                <td>
                                    <h4 style="text-decoration: underline; margin-left:10px; margin-top:1px"> OCULAR
                                        SINISTRA</h4>
                                </td>
                                <table style="border: 1px solid black;margin-left:-100px ">
                                    <td style="text-align:center;"> PD:{{ $dataRo->ocular_sinistra_pd ?? '....' }}</td>

                                </table>
                            </tr>
                            <tr>
                                <div style="margin-left: 10px;">
                                    <table>
                                        <tr>
                                            <td>Autoref</td>
                                            <td>:</td>
                                            <td colspan="2">
                                                {{ $dataRo->ocular_sinistra_autoref ?? '....' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Keratometri</td>
                                            <td>:</td>
                                            <td>K1:
                                                {{ keratometriFormat($dataRo->ocular_sinistra_keratometri_k1 ?? '....') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>K2:
                                                {{ keratometriFormat($dataRo->ocular_sinistra_keratometri_k2 ?? '....') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tonommetri</td>
                                            <td>:</td>
                                            <td>
                                                {{ $dataRo->ocular_sinistra_tonometri ?? '....' }} MmHg
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="margin-left: 10px; font-weight:bold">VISUS</td>
                                            <td>:</td>
                                            <td>
                                                {{ $dataRo->ocular_sinistra_visus ?? '....' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="margin-left: 10px; font-weight:bold">BCVA</td>
                                            <td>:</td>
                                            <td>
                                                {{ $dataRo->ocular_dextra_bcva1 ?? '....' }}
                                                =>
                                                {{ $dataRo->ocular_sinistra_bcva2 ?? '....' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="margin-left: 10px; font-weight:bold">Add</td>
                                            <td>:</td>
                                            <td>
                                                {{ $dataRo->ocular_sinistra_add }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Kacamata Lama</td>
                                            <td>:</td>
                                            <td>
                                                Sph :
                                                {{ $dataRo->ocular_sinistra_kacamata_lama_sph ?? '....' }} Cyl:
                                                {{ $dataRo->ocular_sinistra_kacamata_lama_cyl ?? '....' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                Addisi:
                                                {{ $dataRo->ocular_sinistra_kacamata_lama_addisi ?? '....' }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <br>
                            </tr>
                        </table>
                    </td>
                </tr>
                {{-- POSISI DAN PERGERAKAN --}}
                <br>
                <tr>
                    <table
                        style="border:1px solid black; width:95%; position:fixed; margin-top:560px; margin-left:20px; height:170px;">
                        <tr>
                            <td>
                                <table style="width: 200%; height:100px">
                                    <br>
                                    <br>
                                    <tr>
                                        <td>POSISI BOLA MATA : </td>
                                        <td><input type="checkbox"
                                                {{ $dataDokter->posisi_bola_mata == 'Normal' ? 'Checked' : '' }}
                                                style="margin-left: -150px"></td>
                                        <td>
                                            <div style="margin-left:-130px">Normal</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>PERGERAKAN</br>BOLA MATA : </td>
                                        <td><input type="checkbox"
                                                {{ $dataDokter->pergerakan_bola_mata == 'Normal' ? 'Checked' : '' }}
                                                style="margin-left: -150px"></td>
                                        <td>
                                            <div style="margin-left:-130px">Normal</div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <img style="width: 60%;margin-left:180px; margin-top:30px;"
                                    src="data:image/png;base64,
                                        <?php echo base64_encode(file_get_contents($eyero)); ?>" />
                            </td>
                        </tr>
                    </table>
                </tr>
            </table>
            {{-- status oc od --}}
            <table class="tablee" style="width:95%; position:fixed; margin-top:750px; margin-left:20px">
                <tr class="tablee">
                    <th class="tablee" style="font-weight:bold;">STATUS</th>
                    <th class="tablee" style="font-weight:bold;">OCULAR DEXTRA</th>
                    <th class="tablee" style="font-weight:bold;">OCULAR SINISTRA</th>
                </tr>
                <tr class="tablee" style="text-align: center">
                    <td class="tablee">PALPEBRA</td>
                    <td class="tablee">
                        <table>
                            <tr>
                                <td><input type="checkbox"
                                        {{ $dataDokter->ocular_dextra_palpebra == 'Normal' ? 'Checked' : '' }}></td>
                                <td>Normal</td>
                            </tr>
                        </table>
                    </td>
                    <td class="tablee">
                        <table>
                            <tr>
                                <td><input type="checkbox"
                                        {{ $dataDokter->ocular_sinistra_palpebra == 'Normal' ? 'Checked' : '' }}></td>
                                <td>Normal</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="tablee" style="text-align: center">
                    <td class="tablee">CONJUNCTIVA</td>
                    <td class="tablee">
                        <table>
                            <tr>
                                <td><input type="checkbox"
                                        {{ $dataDokter->ocular_dextra_conjunctiva == 'Normal' ? 'Checked' : '' }}></td>
                                <td>Normal</td>
                            </tr>
                        </table>
                    </td>
                    <td class="tablee">
                        <table>
                            <tr>
                                <td><input type="checkbox"
                                        {{ $dataDokter->ocular_sinistra_conjunctiva == 'Normal' ? 'Checked' : '' }}></td>
                                <td>Normal</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="tablee" style="text-align: center">
                    <td class="tablee">CORNEA</td>
                    <td class="tablee">
                        <table>
                            <tr>
                                <td><input type="checkbox"
                                        {{ $dataDokter->ocular_dextra_cornea == 'Normal' ? 'Checked' : '' }}></td>
                                <td>Normal</td>
                            </tr>
                        </table>
                    </td>
                    <td class="tablee">
                        <table>
                            <tr>
                                <td><input type="checkbox"
                                        {{ $dataDokter->ocular_sinistra_cornea == 'Normal' ? 'Checked' : '' }}></td>
                                <td>Normal</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="tablee" style="text-align: center">
                    <td class="tablee">BILIK MATA DEPAN</td>
                    <td class="tablee">
                        <table>
                            <tr>
                                <td><input type="checkbox"
                                        {{ $dataDokter->ocular_dextra_bilik_mata_depan == 'Normal' ? 'Checked' : '' }}>
                                </td>
                                <td>Normal</td>
                            </tr>
                        </table>
                    </td>
                    <td class="tablee">
                        <table>
                            <tr>
                                <td><input type="checkbox"
                                        {{ $dataDokter->ocular_sinistra_bilik_mata_depan == 'Normal' ? 'Checked' : '' }}>
                                </td>
                                <td>Normal</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="tablee" style="text-align: center">
                    <td class="tablee">PUPIL DAN IRIS</td>
                    <td class="tablee">
                        <table>
                            <tr>
                                <td><input type="checkbox"
                                        {{ $dataDokter->ocular_dextra_pupil_dan_iris == 'Normal' ? 'Checked' : '' }}></td>
                                <td>Normal</td>
                            </tr>
                        </table>
                    </td>
                    <td class="tablee">
                        <table>
                            <tr>
                                <td><input type="checkbox"
                                        {{ $dataDokter->ocular_sinistra_pupil_dan_iris == 'Normal' ? 'Checked' : '' }}>
                                </td>
                                <td>Normal</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="tablee" style="text-align: center">
                    <td class="tablee">LENSA</td>
                    <td class="tablee">
                        <table>
                            <tr>
                                <td><input type="checkbox"
                                        {{ $dataDokter->ocular_dextra_lensa == 'Normal' ? 'Checked' : '' }}></td>
                                <td>Normal</td>
                            </tr>
                        </table>
                    </td>
                    <td class="tablee">
                        <table>
                            <tr>
                                <td><input type="checkbox"
                                        {{ $dataDokter->ocular_sinistra_lensa == 'Normal' ? 'Checked' : '' }}></td>
                                <td>Normal</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="tablee" style="text-align: center">
                    <td class="tablee">VITREOUS</td>
                    <td class="tablee">
                        <table>
                            <tr>
                                <td><input type="checkbox"
                                        {{ $dataDokter->ocular_dextra_vitreous == 'Normal' ? 'Checked' : '' }}></td>
                                <td>Normal</td>
                            </tr>
                        </table>
                    </td>
                    <td class="tablee">
                        <table>
                            <tr>
                                <td><input type="checkbox"
                                        {{ $dataDokter->ocular_sinistra_vitreous == 'Normal' ? 'Checked' : '' }}></td>
                                <td>Normal</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="tablee" style="text-align: center">
                    <td class="tablee">FUNDUSCOPY</td>
                    <td class="tablee">
                        <table>
                            <tr>
                                <td><input type="checkbox"
                                        {{ $dataDokter->ocular_dextra_funduscopy == 'Normal' ? 'Checked' : '' }}></td>
                                <td>Normal</td>
                            </tr>
                        </table>
                    </td>
                    <td class="tablee">
                        <table>
                            <tr>
                                <td><input type="checkbox"
                                        {{ $dataDokter->ocular_sinistra_funduscopy == 'Normal' ? 'Checked' : '' }}></td>
                                <td>Normal</td>
                            </tr>
                        </table>
                    </td>
                </tr>

            </table>
            <div class="page_break"></div>
            {{-- pemeriksaan penunjang --}}
            <table
                style="border:1px solid black; padding:5px; width:95%; position:fixed; margin-top:50px; margin-left:20px">
                <tr>
                    <td>PEMERIKSAAN PENUNJANG :</td>
                </tr>
                <tr>
                    <td>{{ $dataDokter->pemeriksaan_penunjang }}</td>
                </tr>
                <br>
                <br>
                <tr>
                    <td>DIAGNOSA KERJA :</td>
                    <td>KODE ICD 10 : </td>
                </tr>
                <tr>
                  <td></td>
                    <td> 
                     
                    </td>
                </tr>
                <br>
                <br>
                <tr>
                    <td>DIAGNOSA BANDING :</td>
                    <td>KODE ICD 10 :</td>
                </tr>
                <tr>
                    <td>.................................</td>
                    <td>.................................</td>
                </tr>
                <br>
                <tr>
                    <td>TATA LAKSANA :</td>
                </tr>
                <tr>
                    <td>{{ $dataDokter->pemeriksaan_tata_laksana }}</td>
                </tr>
                <br><br>
                <tr>
                    <td>PERENCANAAN :</td>
                </tr>
                <tr>
                    <td>{{ $dataDokter->pilihan_plan }}</td>
                </tr>
                <br><br>
                <tr>
                    <td>PROGNOSA :</td>
                </tr>
                <tr>
                    <td>{{ $dataDokter->pemeriksaan_prognosa }}</td>
                </tr>
                <br>

            </table>
            {{-- signature --}}
            <table
                style="border:1px solid black; padding:5px; width:55%; position:fixed; margin-top:580px; margin-left:20px">
                <tr>
                    <td>TANDA TANGAN DAN NAMA DOKTER</td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <br><br><br><br><br>
                <tr>
                    <td>{{ $dataDokter->nama_dokter }}</td>
                </tr>
                <br>
            </table>
        </div>
      
</body>

</html>
