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
            border:1px solid black;
            border-collapse: collapse;
        }
        .page_break{
    page-break-before: always;
}
    </style>

</head>

<body>
    <div style="position:fixed; right: 13px; bottom: 10px;">
    </div>
    <?php $fullpath = storage_path('app/public/images/header_rme.png'); ?>
    <?php $eyero = storage_path('app/public/images/EYE-RO.png'); ?>
    <div class="wrap">
        <div style="width:100%; text-align:right; margin-bottom:5px">
            RM 1.4/PKMRJ/22
        </div>
        <table style="border-collapse: collapse;">
            {{-- HEADER --}}
            <tr style="border: 1px solid black;">
                <div style="width: 100%;">
                    <table style="width: 100%;">
                        <tr style="border: 1px solid black;">
                            <td style="border-right: 1px solid black; width:100%">
                                <img style="width: 100%;"
                                    src="data:image/png;base64,
                            <?php echo base64_encode(file_get_contents($fullpath)); ?>" />
                            </td>
                            <td style="width: 50%">
                                <table style="width: 100%" border="0">
                                    <tr>
                                        <td width="20%">Nama</td>
                                        <td width="1%">:</td>
                                        <td width=50%>..........</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">Tgl. Lahir</td>
                                        <td width="1%">:</td>
                                        <td width=50%>..........</td>
                                    </tr>
                                    <tr>
                                        <td width="20%">No.RM</td>
                                        <td width="1%">:</td>
                                        <td width=50%>..........</td>
                                    </tr>
                                    <tr>
                                        <td width="10%">NIK</td>
                                        <td width="1%">:</td>
                                        <td width=50%>..........</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </tr>
        </table>
        <table>
    <tr>
        <td><h4 style="text-decoration: underline"> STATUS OFTALMOLOGIS RAWAT JALAN </h4></td>
        
       <table style="border: 1px solid black; margin-top:18px; margin-left:19px;"> <td style="text-align:center; "> Tanggal Kunjungan : ............................jam.........WIB</td></table>
    </tr>
    {{-- OC DAN OD --}}
        <tr>
            <td>
        <table style="border: 1px solid black; width:105%; heigh:600px; padding-top:10px">
            <tr> 
                <td><h4 style="text-decoration: underline; margin-left:10px; margin-top:1px"> OCULAR DEXTRA </h4>
                </td>
                <table style="border: 1px solid black;margin-left:-100px"><td style="text-align:center;"> PD:........</td>
                </table>
             </tr>
             <tr>
                <div style="margin-left: 10px;">Autoref: ...........................................</div>
                <div style="margin-left: 10px;">Keratometri:  K1 : ........@................ </div>
                <div style="margin-left: 96px;">K2 : ........@................ </div>
                <br>
                <div style="margin-left: 10px;">Tonommetri: ...............MmHg</div> 
                <div style="margin-left: 10px; font-weight:bold">VISUS: ...............</div>
                <div style="margin-left: 10px; font-weight:bold">BCVA: ..........................->........</div>
                <div style="margin-left: 10px; font-weight:bold">Add: ...............</div>
                <br>
                <div style="margin-left: 10px;">Kacamata Lama :  Sph : ........Cyl: ...........x.......... </div>
                <div style="margin-left: 125px;">Addisi: ........................ </div>
                <br>
             </tr>
        </table>
            </td>
            <td>
                <table style="border: 1px solid black; width:95%; margin-left:35px; padding-top:10px">
                    <tr> 
                        <td><h4 style="text-decoration: underline; margin-left:10px; margin-top:1px"> OCULAR SINISTRA</h4></td>
                        <table style="border: 1px solid black;margin-left:-100px "><td style="text-align:center;"> PD:........</td>
        
                        </table>
                </tr>
                <tr>
                    <div style="margin-left: 10px;">Autoref: ...........................................</div>
                    <div style="margin-left: 10px;">Keratometri:  K1 : ........@................ </div>
                    <div style="margin-left: 96px;">K2 : ........@................ </div>
                    <br>
                    <div style="margin-left: 10px;">Tonommetri: ...............MmHg</div> 
                    <div style="margin-left: 10px; font-weight:bold">VISUS: ...............</div>
                    <div style="margin-left: 10px; font-weight:bold">BCVA: ..........................->........</div>
                    <div style="margin-left: 10px; font-weight:bold">Add: ...............</div>
                    <br>
                    <div style="margin-left: 10px;">Kacamata Lama :  Sph : ........Cyl: ...........x.......... </div>
                    <div style="margin-left: 125px;">Addisi: ........................ </div>
                    <br>
                 </tr>
                </table>
                    </td>
        </tr>
        {{-- POSISI DAN PERGERAKAN --}}
        <br>
        <tr>
            <table style="border:1px solid black; width:95%; position:fixed; margin-top:560px; margin-left:20px; height:170px;">
                <tr>
                    <td>
                    <table style="width: 200%; height:100px" >
                        <br>
                        <br>
                        <tr><div>POSISI DAN PERGERAKAN</div></tr>
                        <tr>
                            <td>BOLA MATA : </td>
                            <td><input type="checkbox" checked style="margin-left: -220px"></td>
                            <td><div style="margin-left:-200px">Normal</div> </td>
                    </table>
                </td>
                    <td> <img style="width: 60%;margin-left:180px; margin-top:30px;"
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
                <th class="tablee"  style="font-weight:bold;">STATUS</th>
                <th class="tablee" style="font-weight:bold;">OCULAR DEXTRA</th>
                <th class="tablee" style="font-weight:bold;">OCULAR SINISTRA</th>
            </tr>
            <tr class="tablee" style="text-align: center">
                <td class="tablee">PALPEBRA</td>
                <td class="tablee">
                    <table>
                        <tr>
                            <td><input type="checkbox" checked></td>
                            <td>Normal</td>
                        </tr>
                    </table>
                </td>
                <td class="tablee">
                    <table>
                        <tr>
                            <td><input type="checkbox" checked></td>
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
                            <td><input type="checkbox" checked></td>
                            <td>Normal</td>
                        </tr>
                    </table>
                </td>
                <td class="tablee">
                    <table>
                        <tr>
                            <td><input type="checkbox" checked></td>
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
                            <td><input type="checkbox" checked></td>
                            <td>Normal</td>
                        </tr>
                    </table>
                </td>
                <td class="tablee">
                    <table>
                        <tr>
                            <td><input type="checkbox" checked></td>
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
                            <td><input type="checkbox" checked></td>
                            <td>Normal</td>
                        </tr>
                    </table>
                </td>
                <td class="tablee">
                    <table>
                        <tr>
                            <td><input type="checkbox" checked></td>
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
                            <td><input type="checkbox" checked></td>
                            <td>Normal</td>
                        </tr>
                    </table>
                </td>
                <td class="tablee">
                    <table>
                        <tr>
                            <td><input type="checkbox" checked></td>
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
                            <td><input type="checkbox" checked></td>
                            <td>Normal</td>
                        </tr>
                    </table>
                </td>
                <td class="tablee">
                    <table>
                        <tr>
                            <td><input type="checkbox" checked></td>
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
                            <td><input type="checkbox" checked></td>
                            <td>Normal</td>
                        </tr>
                    </table>
                </td>
                <td class="tablee">
                    <table>
                        <tr>
                            <td><input type="checkbox" checked></td>
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
                            <td><input type="checkbox" checked></td>
                            <td>Normal</td>
                        </tr>
                    </table>
                </td>
                <td class="tablee">
                    <table>
                        <tr>
                            <td><input type="checkbox" checked></td>
                            <td>Normal</td>
                        </tr>
                    </table>
                </td>
            </tr>

        </table>
        <div class="page_break"></div>
        {{-- pemeriksaan penunjang --}}
        <table  style="border:1px solid black; padding:5px; width:95%; position:fixed; margin-top:50px; margin-left:20px">
            <tr>
                <td>PEMERIKSAAN PENUNJANG :</td>
            </tr>
            <tr>
                <td>.................................</td>
            </tr>
            <br>
            <br>
            <tr>
                <td>DIAGNOSA KERJA :</td>
                <td>KODE ICD 10 :</td>
            </tr>
            <tr>
                <td>.................................</td>
                <td>.................................</td>
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
                <td>...................................</td>
            </tr>
            <br><br>
            <tr>
                <td>PERENCANAAN :</td>
            </tr>
            <tr>
                <td>...................................</td>
            </tr>
            <br><br>
            <tr>
                <td>PROGNOSA :</td>
            </tr>
            <tr>
                <td>...................................</td>
            </tr>
            <br>

        </table>
        {{-- signature --}}
        <table style="border:1px solid black; padding:5px; width:55%; position:fixed; margin-top:580px; margin-left:20px">
            <tr>
                <td>TANDA TANGAN DAN NAMA DOKTER</td>
            </tr>
            <tr>
                <td>VERIFIKASI (stempel, nama/paraf)</td>
            </tr>
            <br><br><br><br><br>
            <tr>
                <td>................................</td>
            </tr>
            <br>
        </table>
        
        
    </div>
</body>
<?php

function bulans($bln)
{
    if ($bln == '01') {
        $bln = 'Januari';
    } elseif ($bln == '02') {
        $bln = 'Februari';
    } elseif ($bln == '03') {
        $bln = 'Maret';
    } elseif ($bln == '04') {
        $bln = 'April';
    } elseif ($bln == '05') {
        $bln = 'Mei';
    } elseif ($bln == '06') {
        $bln = 'Juni';
    } elseif ($bln == '07') {
        $bln = 'Juli';
    } elseif ($bln == '08') {
        $bln = 'Agustus';
    } elseif ($bln == '09') {
        $bln = 'September';
    } elseif ($bln == '10') {
        $bln = 'Oktober';
    } elseif ($bln == '11') {
        $bln = 'November';
    } elseif ($bln == '12') {
        $bln = 'Desember';
    }
    return $bln;
}

?>

</html>
