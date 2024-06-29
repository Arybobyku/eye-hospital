<?php

function keratometriFormat($input)
{
    // Memisahkan angka pertama dan kedua dari input
    preg_match('/^([\d.]+) \((\d+)\)$/', $input, $matches);

    if (count($matches) == 3) {
        $number1 = $matches[1];
        $number2 = $matches[2];

        // Menghasilkan output sesuai format yang diinginkan
        $output = $number1 . ' @ ' . $number2;
        return $output;
    } else {
        return $input;
    }
}

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
?>